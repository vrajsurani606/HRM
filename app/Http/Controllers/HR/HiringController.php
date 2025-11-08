<?php
namespace App\Http\Controllers\HR;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HiringLead;
use Illuminate\Support\Facades\Storage;

class HiringController extends Controller
{
    public function index()
    {
        $leads = HiringLead::latest()->paginate(25);
        return view('hr.hiring.index', [
            'page_title' => 'Hiring Lead List',
            'leads' => $leads,
        ]);
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
}
