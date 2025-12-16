<?php
namespace App\Http\Controllers\Inquiry;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\InquiryFollowUp;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InquiryController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Inquiries Management.view inquiry'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $user = auth()->user();
        $query = Inquiry::query()->with(['followUps' => function ($q) {
            $q->latest();
        }]);
        
        // Filter by role: customers/clients see only their company's inquiries
        $isCustomer = $user->hasRole('customer') || $user->hasRole('client') || $user->hasRole('company');
        if ($isCustomer && $user->company_id) {
            $company = $user->company;
            if ($company) {
                $query->where('company_name', $company->company_name);
            }
        }
        
        // Handle sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        
        // Validate sort column
        $allowedSorts = ['unique_code', 'inquiry_date', 'company_name', 'contact_name', 'industry_type', 'created_at', 'updated_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }
        
        // Validate sort direction
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }
        
        $query->orderBy($sortBy, $sortDirection);

        if ($request->filled('from_date')) {
            $query->whereDate('inquiry_date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->whereDate('inquiry_date', '<=', $request->input('to_date'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhere('company_phone', 'like', "%{$search}%")
                  ->orWhere('unique_code', 'like', "%{$search}%")
                  ->orWhere('contact_name', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->input('per_page', 10);
        if ($perPage <= 0) {
            $perPage = 10;
        }

        $inquiries = $query->paginate($perPage)->appends($request->except('page'));

        // Determine which inquiries have a Scheduled Demo Date equal to today
        $today = Carbon::today()->toDateString();
        $todayScheduledInquiryIds = InquiryFollowUp::whereDate('scheduled_demo_date', $today)
            ->pluck('inquiry_id')
            ->unique()
            ->toArray();

        if ($request->ajax()) {
            return view('inquiries.partials.table_rows', compact('inquiries', 'todayScheduledInquiryIds'));
        }

        return view('inquiries.index', compact('inquiries', 'todayScheduledInquiryIds'));
    }

    public function create(): View|RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Inquiries Management.create inquiry'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $lastInquiry = Inquiry::orderByDesc('id')->first();

        $nextNumber = 1;
        if ($lastInquiry && !empty($lastInquiry->unique_code)) {
            if (preg_match('/(\d+)$/', $lastInquiry->unique_code, $matches)) {
                $nextNumber = ((int) $matches[1]) + 1;
            }
        }

        $nextCode = 'CMS/INQ/' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return view('inquiries.create', compact('nextCode'));
    }

    public function store(Request $request)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Inquiries Management.create inquiry'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        // Convert date from dd/mm/yyyy to Y-m-d format before validation
        if ($request->has('inquiry_date') && !empty($request->inquiry_date)) {
            $dateValue = $request->inquiry_date;
            // Check if date is in dd/mm/yyyy format
            if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $dateValue)) {
                try {
                    $request->merge([
                        'inquiry_date' => Carbon::createFromFormat('d/m/Y', $dateValue)->format('Y-m-d')
                    ]);
                } catch (\Exception $e) {
                    // Keep original value, validation will fail
                }
            }
        }
        
        $validated = $request->validate([
            'inquiry_date'    => ['required','date'],
            'company_name'    => ['required','string','max:255'],
            'company_address' => ['required','string','max:500'],
            'industry_type'   => ['required','string','max:255'],
            'email'           => ['required','email','max:255'],
            // 10-digit Indian mobile numbers (same idea as hiring mobile_no)
            'company_phone'   => ['required','regex:/^\d{10}$/'],
            'city'            => ['required','string','max:255'],
            'city_other'      => ['nullable','string','max:255'],
            'state'           => ['required','string','max:255'],
            'state_other'     => ['nullable','string','max:255'],
            'contact_mobile'  => ['required','regex:/^\d{10}$/'],
            'contact_name'    => ['required','string','max:255'],
            'scope_link'      => ['nullable','url','max:255'],
            'contact_position'=> ['required','string','max:255'],
            'quotation_file'  => ['nullable','file','mimes:pdf,doc,docx,png,jpg,jpeg','max:2048'],
            'quotation_sent'  => ['nullable','string','max:255'],
        ]);

        $lastInquiry = Inquiry::orderByDesc('id')->first();

        $nextNumber = 1;
        if ($lastInquiry && !empty($lastInquiry->unique_code)) {
            if (preg_match('/(\d+)$/', $lastInquiry->unique_code, $matches)) {
                $nextNumber = ((int) $matches[1]) + 1;
            }
        }

        $validated['unique_code'] = 'CMS/INQ/' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        if ($request->hasFile('quotation_file')) {
            $validated['quotation_file'] = $request->file('quotation_file')->store('quotations', 'public');
        }

        Inquiry::create($validated);

            // if ($request->ajax()) {
            //     return response()->json([
            //         'success' => true,
            //         'message' => 'Inquiry created successfully!'
            //     ]);
            // }

        return redirect()->route('inquiries.index')->with('status', 'Inquiry created successfully!');
    }

    public function show(int $id): View|RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Inquiries Management.view inquiry'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $inquiry = Inquiry::findOrFail($id);
        return view('inquiries.show', compact('inquiry'));
    }

    public function edit(int $id): View|RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Inquiries Management.edit inquiry'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $inquiry = Inquiry::findOrFail($id);
        return view('inquiries.edit', compact('inquiry'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Inquiries Management.edit inquiry'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $inquiry = Inquiry::findOrFail($id);
        
        // Convert date from dd/mm/yyyy to Y-m-d format before validation
        if ($request->has('inquiry_date') && !empty($request->inquiry_date)) {
            $dateValue = $request->inquiry_date;
            // Check if date is in dd/mm/yyyy format
            if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $dateValue)) {
                try {
                    $request->merge([
                        'inquiry_date' => Carbon::createFromFormat('d/m/Y', $dateValue)->format('Y-m-d')
                    ]);
                } catch (\Exception $e) {
                    // Keep original value, validation will fail
                }
            }
        }
        
        $validated = $request->validate([
            'unique_code' => 'required|string|unique:inquiries,unique_code,' . $id,
            'inquiry_date'    => ['required','date'],
            'company_name'    => ['required','string','max:255'],
            'company_address' => ['required','string'],
            'industry_type'   => ['required','string','max:255'],
            'email'           => ['required','email','max:255'],
            'company_phone'   => ['required','regex:/^\d{10}$/'],
            'city'            => ['required','string','max:255'],
            'city_other'      => ['nullable','string','max:255'],
            'state'           => ['required','string','max:255'],
            'state_other'     => ['nullable','string','max:255'],
            'contact_mobile'  => ['required','regex:/^\d{10}$/'],
            'contact_name'    => ['required','string','max:255'],
            'scope_link'      => ['nullable','url','max:255'],
            'contact_position'=> ['required','string','max:255'],
            'quotation_file'  => ['nullable','file','mimes:pdf,doc,docx,png,jpg,jpeg','max:2048'],
            'quotation_sent'  => ['nullable','string','max:255'],
        ]);

        if ($request->hasFile('quotation_file')) {
            $validated['quotation_file'] = $request->file('quotation_file')->store('quotations', 'public');
        }

        $inquiry->update($validated);

        return redirect()->route('inquiries.index')->with('status', 'Inquiry updated successfully!');
    }

    public function destroy(int $id): RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Inquiries Management.delete inquiry'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $inquiry = Inquiry::findOrFail($id);
        $inquiry->delete();
        
        return back()->with('status', 'Inquiry deleted successfully!');
    }

    public function export(Request $request)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Inquiries Management.export inquiry'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $user = auth()->user();
        $query = Inquiry::query()->latest();

        // Filter by role: customers/clients see only their company's inquiries
        $isCustomer = $user->hasRole('customer') || $user->hasRole('client') || $user->hasRole('company');
        if ($isCustomer && $user->company_id) {
            $company = $user->company;
            if ($company) {
                $query->where('company_name', $company->company_name);
            }
        }

        if ($request->filled('from_date')) {
            $query->whereDate('inquiry_date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->whereDate('inquiry_date', '<=', $request->input('to_date'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhere('company_phone', 'like', "%{$search}%")
                  ->orWhere('unique_code', 'like', "%{$search}%")
                  ->orWhere('contact_name', 'like', "%{$search}%")
                  ->orWhere('contact_mobile', 'like', "%{$search}%")
                  ->orWhere('contact_position', 'like', "%{$search}%")
                  ->orWhere('company_address', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('state', 'like', "%{$search}%")
                  ->orWhere('industry_type', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('quotation_sent', 'like', "%{$search}%");
            });
        }

        $inquiries = $query->get();

        $fileName = 'inquiries_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $callback = function () use ($inquiries) {
            $handle = fopen('php://output', 'w');

            // Header row with all main Inquiry fields
            fputcsv($handle, [
                'ID',
                'Unique Code',
                'Inquiry Date',
                'Company Name',
                'Company Address',
                'Industry Type',
                'Email',
                'Company Mobile',
                'City',
                'State',
                'Contact Mobile',
                'Contact Name',
                'Contact Position',
                'Scope Link',
                'Quotation Sent',
                'Quotation File',
                'Created At',
                'Updated At',
            ]);

            foreach ($inquiries as $index => $inquiry) {
                fputcsv($handle, [
                    $inquiry->id,
                    $inquiry->unique_code,
                    optional($inquiry->inquiry_date)->format('Y-m-d'),
                    $inquiry->company_name,
                    $inquiry->company_address,
                    $inquiry->industry_type,
                    $inquiry->email,
                    $inquiry->company_phone,
                    $inquiry->city,
                    $inquiry->state,
                    $inquiry->contact_mobile,
                    $inquiry->contact_name,
                    $inquiry->contact_position,
                    $inquiry->scope_link,
                    $inquiry->quotation_sent,
                    $inquiry->quotation_file,
                    optional($inquiry->created_at)->format('Y-m-d H:i:s'),
                    optional($inquiry->updated_at)->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, $fileName, $headers);
    }

    public function followUp(int $id): View|RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Inquiries Management.follow up'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $inquiry = Inquiry::findOrFail($id);
        $followUps = $inquiry->followUps()->latest()->get();

        return view('inquiries.follow_up', compact('inquiry', 'followUps'));
    }

    public function storeFollowUp(Request $request, int $id)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Inquiries Management.follow up create'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $inquiry = Inquiry::findOrFail($id);
        
        // Convert date fields from dd/mm/yyyy to Y-m-d before validation
        $dateFields = ['next_followup_date', 'scheduled_demo_date', 'demo_date'];
        foreach ($dateFields as $field) {
            if ($request->has($field) && $request->$field) {
                $dateValue = $request->$field;
                // Try to parse dd/mm/yyyy format
                if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $dateValue)) {
                    try {
                        $request->merge([
                            $field => Carbon::createFromFormat('d/m/Y', $dateValue)->format('Y-m-d')
                        ]);
                    } catch (\Exception $e) {
                        // Keep original value if parsing fails
                    }
                }
            }
        }
        
        $validated = $request->validate([
            'followup_date' => 'required|string',
            'next_followup_date' => 'nullable|date',
            'demo_status' => 'nullable|string',
            'scheduled_demo_date' => 'nullable|date|required_if:demo_status,schedule',
            'scheduled_demo_time' => 'nullable|required_if:demo_status,schedule',
            'demo_date' => 'nullable|date|required_if:demo_status,yes',
            'demo_time' => 'nullable|required_if:demo_status,yes',
            'remark' => 'nullable|string',
            'inquiry_note' => 'nullable|string',
        ]);

        // Parse followup_date from dd/mm/yy to Y-m-d
        $followupDate = null;
        if (!empty($validated['followup_date'])) {
            try {
                $followupDate = Carbon::createFromFormat('d/m/y', $validated['followup_date'])->format('Y-m-d');
            } catch (\Exception $e) {
                $followupDate = null;
            }
        }

        InquiryFollowUp::create([
            'inquiry_id' => $inquiry->id,
            'followup_date' => $followupDate,
            'next_followup_date' => $validated['next_followup_date'] ?? null,
            'demo_status' => $validated['demo_status'] ?? null,
            'scheduled_demo_date' => $validated['scheduled_demo_date'] ?? null,
            'scheduled_demo_time' => $validated['scheduled_demo_time'] ?? null,
            'demo_date' => $validated['demo_date'] ?? null,
            'demo_time' => $validated['demo_time'] ?? null,
            'remark' => $validated['remark'] ?? null,
            'inquiry_note' => $validated['inquiry_note'] ?? null,
        ]);

        return back()->with('status', 'Follow-up added successfully!');
    }

    public function confirmFollowUp(Request $request, int $followUpId)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Inquiries Management.follow up confirm'))) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
            }
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $followUp = InquiryFollowUp::findOrFail($followUpId);
        $followUp->is_confirm = true;
        $followUp->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
            ]);
        }

        return back()->with('status', 'Follow-up confirmed successfully!');
    }
}
