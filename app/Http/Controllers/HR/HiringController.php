<?php
namespace App\Http\Controllers\HR;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HiringLead;
use Illuminate\Support\Facades\Storage;
use App\Models\OfferLetter;
use App\Models\Employee;
use Illuminate\Support\Str;

class HiringController extends Controller
{
    public function index(Request $request)
    {
        $query = HiringLead::query();

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

        $leads = $query->latest()->paginate(25);
        
        return view('hr.hiring.index', [
            'page_title' => 'Hiring Lead List',
            'leads' => $leads,
            'filters' => $request->all()
        ]);
    }

    public function convert($id)
    {
        $lead = HiringLead::findOrFail($id);
        $offer = $lead->offerLetter;

        // Prepare employee payload
        $email = $lead->email;
        if (!$email || Employee::where('email', $email)->exists()) {
            do {
                $email = 'candidate'.$lead->id.'-'.Str::lower(Str::random(6)).'@hr.local';
            } while (Employee::where('email', $email)->exists());
        }
        $payload = [
            'code' => Employee::nextCode(),
            'name' => $lead->person_name,
            'gender' => $lead->gender,
            'email' => $email,
            'mobile_no' => $lead->mobile_no,
            'address' => $lead->address,
            'position' => $lead->position,
            'experience_type' => $lead->is_experience ? 'Experienced' : 'Fresher',
            'previous_company_name' => $lead->experience_previous_company,
            'previous_salary' => $lead->previous_salary,
            'current_offer_amount' => optional($offer)->monthly_salary,
            'joining_date' => optional($offer)->date_of_joining,
            'status' => 'active',
        ];

        $employee = Employee::create($payload);

        return redirect()->route('employees.index')
            ->with('success', 'Hiring lead converted to employee');
    }

    public function create()
    {
        $nextCode = HiringLead::nextCode();
        return view('hr.hiring.create', [
            'page_title' => 'Add New Hiring Lead',
            'nextCode' => $nextCode,
        ]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            // unique_code will be generated server-side to avoid collisions
            'person_name' => ['required','string','max:190'],
            'mobile_no' => ['required','regex:/^\d{10}$/'],
            'address' => ['required','string','max:255'],
            'position' => ['required','string','max:190'],
            'is_experience' => ['required','boolean'],
            'experience_count' => ['required_if:is_experience,1','numeric','min:0','max:99.9'],
            'experience_previous_company' => ['required_if:is_experience,1','string','max:190'],
            'previous_salary' => ['nullable','numeric','min:0'],
            'gender' => ['required','in:male,female,other'],
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
        return view('hr.hiring.edit', [
            'page_title' => 'Edit Hiring Lead',
            'lead' => $hiring,
        ]);
    }

    public function update(Request $r, HiringLead $hiring)
    {
        $data = $r->validate([
            'person_name' => ['required','string','max:190'],
            'mobile_no' => ['required','regex:/^\d{10}$/'],
            'address' => ['required','string','max:255'],
            'position' => ['required','string','max:190'],
            'is_experience' => ['required','boolean'],
            'experience_count' => ['required_if:is_experience,1','numeric','min:0','max:99.9'],
            'experience_previous_company' => ['required_if:is_experience,1','string','max:190'],
            'previous_salary' => ['nullable','numeric','min:0'],
            'gender' => ['required','in:male,female,other'],
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
        if ($hiring->resume_path) {
            Storage::disk('public')->delete($hiring->resume_path);
        }
        $hiring->delete();
        return back()->with('success','Hiring lead deleted');
    }

    public function print(Request $r, $id)
    {
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
