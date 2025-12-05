<?php
namespace App\Http\Controllers\HR;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HiringLead;
use Illuminate\Support\Facades\Storage;
use App\Models\OfferLetter;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class HiringController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Leads Management.view lead'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $query = HiringLead::query();

        // Exclude converted leads (only show active leads)
        $query->where(function($q) {
            $q->whereNull('status')
              ->orWhere('status', '!=', 'converted');
        });

        // Apply date filters if they exist
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Apply gender filter if selected
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // Apply experience filter if selected
        if ($request->filled('experience')) {
            if ($request->experience === 'fresher') {
                $query->where('is_experience', 0);
            } else {
                $years = (int) str_replace('>', '', $request->experience);
                $query->where('is_experience', 1)
                      ->where('experience_count', '>=', $years);
            }
        }

        // Apply search if provided
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('person_name', 'like', "%$search%")
                  ->orWhere('mobile_no', 'like', "%$search%")
                  ->orWhere('unique_code', 'like', "%$search%")
                  ->orWhere('position', 'like', "%$search%");
            });
        }

        // Handle sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        
        // Validate sort column
        $allowedSorts = ['person_name', 'mobile_no', 'position', 'gender', 'experience_count', 'created_at', 'updated_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }
        
        // Validate sort direction
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }
        
        $perPage = $request->get('per_page', 10);
        $leads = $query->orderBy($sortBy, $sortDirection)->paginate($perPage)->appends($request->query());
        
        return view('hr.hiring.index', [
            'page_title' => 'Hiring Lead List',
            'leads' => $leads,
            'filters' => $request->all()
        ]);
    }

 public function convert(Request $request, $id)
{
    if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Leads Management.convert lead'))) {
        if ($request->ajax()) {
            return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
        }
        return redirect()->back()->with('error', 'Permission denied.');
    }
    
    $lead = HiringLead::findOrFail($id);

    // GET REQUEST (Show Form)
    if ($request->isMethod('GET')) {
        if ($request->ajax()) {
            return response()->json([
                'suggested_email' => strtolower(str_replace(' ', '.', $lead->person_name)) . '@company.com'
            ]);
        }

        $positions = ['Developer', 'Designer', 'Manager', 'HR', 'Sales', 'Marketing', 'Accountant', 'Other'];
        $nextCode = Employee::nextCode();

        return view('hr.employees.convert', [
            'lead' => $lead,
            'positions' => $positions,
            'nextCode' => $nextCode,
            'page_title' => 'Convert Lead to Employee - ' . $lead->person_name,
        ]);
    }

    // POST Request – Convert Lead
    $data = $request->validate([
        'email' => 'required|email|unique:users,email|unique:employees,email',
        'password' => 'required|string|min:6',
    ]);

    try {
        // Check if user exists
        if (User::where('email', $data['email'])->exists()) {
            throw new \Exception('A user with this email already exists.');
        }

        // Check if employee exists
        if (Employee::where('email', $data['email'])->exists()) {
            throw new \Exception('An employee with this email already exists.');
        }

        DB::transaction(function () use ($data, $lead) {

            $user = User::create([
                'name'      => $lead->person_name,
                'email'     => $data['email'],
                'password'  => bcrypt($data['password']),
                'mobile_no' => $lead->mobile_no,
                'address'   => $lead->address,
            ]);

            // Assign role if exists
            try {
                $user->assignRole('employee');
            } catch (\Exception $e) {}

            Employee::create([
                'code'      => Employee::nextCode(),
                'name'      => $lead->person_name,
                'email'     => $data['email'],
                'mobile_no' => $lead->mobile_no,
                'address'   => $lead->address,
                'position'  => $lead->position,
                'user_id'   => $user->id,
            ]);

            // Update lead status (if exists)
            try {
                $lead->update(['status' => 'converted']);
            } catch (\Exception $e) {}

        });

        // SUCCESS – AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Lead converted to employee successfully'
            ]);
        }

        // SUCCESS – Web
        return redirect()
            ->route('hiring.index')
            ->with('success', 'Lead converted to employee successfully');

    } catch (\Exception $e) {

        \Log::error('Employee conversion failed', [
            'lead_id' => $id,
            'error' => $e->getMessage()
        ]);

        // ERROR – AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()  // simple msg only
            ], 422);
        }

        // ERROR – Web
        return back()->withErrors([
            'error' => $e->getMessage() // simple msg only
        ]);
    }
}


    public function create()
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Leads Management.create lead'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $nextCode = HiringLead::nextCode();
        $positions = [
            'Full Stack Developer',
            'Frontend Developer', 
            'Backend Developer',
            'Mobile App Developer',
            'UI/UX Designer',
            'Graphic Designer',
            'Project Manager',
            'Team Lead',
            'HR Executive',
            'HR Manager',
            'Sales Executive',
            'Sales Manager',
            'Marketing Executive',
            'Digital Marketing Specialist',
            'Content Writer',
            'SEO Specialist',
            'Business Analyst',
            'Quality Assurance Engineer',
            'DevOps Engineer',
            'System Administrator',
            'Accountant',
            'Finance Manager',
            'Customer Support Executive',
            'Operations Manager',
            'Intern',
            'Reciptionist',
            'Other'
        ];
        return view('hr.hiring.create', [
            'page_title' => 'Add New Hiring Lead',
            'nextCode' => $nextCode,
            'positions' => $positions,
        ]);
    }

    public function store(Request $r)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Leads Management.create lead'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $data = $r->validate([
            // unique_code will be generated server-side to avoid collisions
            'person_name' => ['required','string','max:190'],
            'mobile_no' => ['required','regex:/^\d{10}$/'],
            'address' => ['required','string','max:255'],
            'position' => ['required','string','max:190'],
            'other_position' => ['nullable','string','max:190'],
            'is_experience' => ['required','boolean'],
            'experience_count' => ['required_if:is_experience,1','numeric','min:0','max:99.9'],
            'experience_previous_company' => ['required_if:is_experience,1','string','max:190'],
            'previous_salary' => ['nullable','numeric','min:0'],
            'gender' => ['required','in:male,female'],
            'resume' => ['nullable','file','mimes:pdf,doc,docx','max:5120'],
        ]);

        if ($r->hasFile('resume')) {
            $path = $r->file('resume')->store('resumes', 'public');
            $data['resume_path'] = $path;
        }

        $data['is_experience'] = (bool)($data['is_experience'] ?? false);
        $data['unique_code'] = HiringLead::nextCode();

        HiringLead::create($data);

        return redirect()->route('hiring.index')->with('success','Hiring lead created');
    }

    public function edit(HiringLead $hiring)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Leads Management.edit lead'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $positions = [
            'Full Stack Developer',
            'Frontend Developer', 
            'Backend Developer',
            'Mobile App Developer',
            'UI/UX Designer',
            'Graphic Designer',
            'Project Manager',
            'Team Lead',
            'HR Executive',
            'HR Manager',
            'Sales Executive',
            'Sales Manager',
            'Marketing Executive',
            'Digital Marketing Specialist',
            'Content Writer',
            'SEO Specialist',
            'Business Analyst',
            'Quality Assurance Engineer',
            'DevOps Engineer',
            'System Administrator',
            'Accountant',
            'Finance Manager',
            'Customer Support Executive',
            'Operations Manager',
            'Intern',
            'Other'
        ];
        return view('hr.hiring.edit', [
            'page_title' => 'Edit Hiring Lead',
            'lead' => $hiring,
            'positions' => $positions,
        ]);
    }

    public function update(Request $r, HiringLead $hiring)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Leads Management.edit lead'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $data = $r->validate([
            'person_name' => ['required','string','max:190'],
            'mobile_no' => ['required','regex:/^\d{10}$/'],
            'address' => ['required','string','max:255'],
            'position' => ['required','string','max:190'],
            'other_position' => ['nullable','string','max:190'],
            'is_experience' => ['required','boolean'],
            'experience_count' => ['required_if:is_experience,1','numeric','min:0','max:99.9'],
            'experience_previous_company' => ['required_if:is_experience,1','string','max:190'],
            'previous_salary' => ['nullable','numeric','min:0'],
            'gender' => ['required','in:male,female'],
            'resume' => ['nullable','file','mimes:pdf,doc,docx','max:5120'],
        ]);

        if ($r->hasFile('resume')) {
            if ($hiring->resume_path) {
                Storage::disk('public')->delete($hiring->resume_path);
            }
            $data['resume_path'] = $r->file('resume')->store('resumes','public');
        }

        $data['is_experience'] = (bool)($data['is_experience'] ?? false);

        $hiring->update($data);

        return redirect()->route('hiring.index')->with('success','Hiring lead updated');
    }

    public function destroy(HiringLead $hiring)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Leads Management.delete lead'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        if ($hiring->resume_path) {
            Storage::disk('public')->delete($hiring->resume_path);
        }
        $hiring->delete();
        return back()->with('success','Hiring lead deleted');
    }

    public function print(Request $r, $id)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Leads Management.print lead'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $lead = HiringLead::findOrFail($id);
        $type = $r->query('type', 'offerletter');

        if ($type === 'details') {
            return view('hr.hiring.print_details', compact('lead'));
        }

        $offer = $lead->offerLetter;
        if (!$offer) {
            // First time: capture details
            return redirect()->route('hiring.offer.create', $lead->id)
                ->with('info', 'Please fill offer letter details first.');
        }

        $probation = $offer->probation_period;
        $salary_increment = $offer->salary_increment;
        $probation_lines = array_values(array_filter(preg_split('/\r\n|\r|\n/', (string)($probation ?? '')), function($v){ return trim($v) !== ''; }));
        $salary_lines = array_values(array_filter(preg_split('/\r\n|\r|\n/', (string)($salary_increment ?? '')), function($v){ return trim($v) !== ''; }));
        $break_after = (count($probation_lines) > 5 || count($salary_lines) > 5);
        $joining = [
            'date_of_joining' => optional($offer->date_of_joining)->format('d-m-Y'),
            'reporting_person' => $offer->reporting_manager,
        ];

        return view('hr.hiring.print_offerletter', compact('lead','offer','probation','salary_increment','joining','probation_lines','salary_lines','break_after'));
    }

    public function offerCreate($id)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Leads Management.offer letter'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $lead = HiringLead::findOrFail($id);
        $offer = $lead->offerLetter;
        if ($offer) {
            return redirect()->route('hiring.print', ['id' => $lead->id, 'type' => 'offerletter']);
        }
        return view('hr.hiring.offer_form', [
            'page_title' => 'Issue Offer Letter',
            'lead' => $lead,
            'offer' => null,
        ]);
    }

    public function offerStore(Request $r, $id)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Leads Management.offer letter'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $lead = HiringLead::findOrFail($id);
        if ($lead->offerLetter) {
            return redirect()->route('hiring.print', ['id' => $lead->id, 'type' => 'offerletter']);
        }

        $data = $r->validate([
            'issue_date' => ['required','date'],
            'note' => ['nullable','string'],
            'monthly_salary' => ['required','numeric','min:0'],
            'annual_ctc' => ['required','numeric','min:0'],
            'reporting_manager' => ['required','string','max:190'],
            'working_hours' => ['required','string','max:190'],
            'date_of_joining' => ['required','date'],
            'probation_period' => ['required','string'],
            'salary_increment' => ['required','string'],
        ]);

        $data['hiring_lead_id'] = $lead->id;
        OfferLetter::create($data);

        return redirect()->route('hiring.print', ['id' => $lead->id, 'type' => 'offerletter'])
            ->with('success','Offer letter saved');
    }

    public function offerEdit($id)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Leads Management.offer letter'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $lead = HiringLead::findOrFail($id);
        $offer = $lead->offerLetter;
        if (!$offer) {
            return redirect()->route('hiring.offer.create', $lead->id);
        }
        return view('hr.hiring.offer_form', [
            'page_title' => 'Edit Offer Letter',
            'lead' => $lead,
            'offer' => $offer,
        ]);
    }

    public function offerUpdate(Request $r, $id)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Leads Management.offer letter'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $lead = HiringLead::findOrFail($id);
        $offer = $lead->offerLetter;
        if (!$offer) {
            return redirect()->route('hiring.offer.create', $lead->id);
        }

        $data = $r->validate([
            'issue_date' => ['required','date'],
            'note' => ['nullable','string'],
            'monthly_salary' => ['required','numeric','min:0'],
            'annual_ctc' => ['required','numeric','min:0'],
            'reporting_manager' => ['required','string','max:190'],
            'working_hours' => ['required','string','max:190'],
            'date_of_joining' => ['required','date'],
            'probation_period' => ['required','string'],
            'salary_increment' => ['required','string'],
        ]);

        $offer->update($data);

        if ($r->has('save_and_print')) {
            return redirect()->route('hiring.print', ['id' => $lead->id, 'type' => 'offerletter'])
                ->with('success','Offer letter updated');
        }
        return back()->with('success','Offer letter updated');
    }

    public function resume($id)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Leads Management.view resume'))) {
            abort(403);
        }
        
        $lead = HiringLead::findOrFail($id);
        if (!$lead->resume_path) {
            abort(404);
        }
        $disk = Storage::disk('public');
        if (!$disk->exists($lead->resume_path)) {
            abort(404);
        }
        $absolutePath = $disk->path($lead->resume_path);
        $mime = @mime_content_type($absolutePath) ?: 'application/octet-stream';
        return response()->file($absolutePath, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="'.basename($absolutePath).'"',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
    
}
