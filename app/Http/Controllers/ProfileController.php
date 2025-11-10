<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        // Try to find associated employee by email
        $employee = \App\Models\Employee::where('email', $user->email)->first();
        
        return view('profile.edit', [
            'user' => $user,
            'employee' => $employee,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Update employee record if exists
        $employee = \App\Models\Employee::where('email', $user->email)->first();
        if ($employee) {
            $employee->update([
                'name' => $request->name,
                'email' => $request->email,
                'mobile_no' => $request->mobile_no ?? $employee->mobile_no,
                'address' => $request->address ?? $employee->address,
                'aadhaar_no' => $request->aadhaar_no ?? $employee->aadhaar_no,
                'pan_no' => $request->pan_no ? strtoupper($request->pan_no) : $employee->pan_no,
                'gender' => $request->gender ?? $employee->gender,
                'date_of_birth' => $request->date_of_birth ?? $employee->date_of_birth,
                'marital_status' => $request->marital_status ?? $employee->marital_status,
                'highest_qualification' => $request->highest_qualification ?? $employee->highest_qualification,
                'year_of_passing' => $request->year_of_passing ?? $employee->year_of_passing,
                'previous_company_name' => $request->previous_company_name ?? $employee->previous_company_name,
                'previous_designation' => $request->previous_designation ?? $employee->previous_designation,
                'duration' => $request->duration ?? $employee->duration,
                'reason_for_leaving' => $request->reason_for_leaving ?? $employee->reason_for_leaving,
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated')->with('active_tab', 'personal');
    }

    /**
     * Update bank details.
     */
    public function updateBank(Request $request): RedirectResponse
    {
        $request->validate([
            'bank_name' => ['required', 'string', 'max:255'],
            'bank_account_no' => ['required', 'string', 'max:30'],
            'bank_ifsc' => ['required', 'string', 'max:11', 'regex:/^[A-Z]{4}0[A-Z0-9]{6}$/'],
        ]);

        $user = $request->user();
        $employee = \App\Models\Employee::where('email', $user->email)->first();

        if ($employee) {
            $employee->update([
                'bank_name' => $request->bank_name,
                'bank_account_no' => $request->bank_account_no,
                'bank_ifsc' => strtoupper($request->bank_ifsc),
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'bank-updated')->with('active_tab', 'bank');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
