<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Employee;
use App\Models\Attendance;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // Check permission - users can always view their own profile
        if (!$request->user()->can('Profile Management.view own profile') && 
            !$request->user()->can('Profile Management.view profile')) {
            abort(403, 'Unauthorized access to profile.');
        }
        
        $user = $request->user();
        // Try to find associated employee by email
        $employee = Employee::where('email', $user->email)->first();

        // Date range filters for attendance
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        
        // Parse dates if provided (format: dd/mm/yy - 2 digit year from jQuery datepicker)
        $startDateParsed = null;
        $endDateParsed = null;
        
        if ($startDate) {
            try {
                // Try dd/mm/yy format first (jQuery datepicker format)
                $startDateParsed = \Carbon\Carbon::createFromFormat('d/m/y', $startDate)->startOfDay();
            } catch (\Exception $e) {
                try {
                    // Fallback to dd/mm/yyyy format
                    $startDateParsed = \Carbon\Carbon::createFromFormat('d/m/Y', $startDate)->startOfDay();
                } catch (\Exception $e2) {
                    $startDateParsed = null;
                }
            }
        }
        
        if ($endDate) {
            try {
                // Try dd/mm/yy format first (jQuery datepicker format)
                $endDateParsed = \Carbon\Carbon::createFromFormat('d/m/y', $endDate)->endOfDay();
            } catch (\Exception $e) {
                try {
                    // Fallback to dd/mm/yyyy format
                    $endDateParsed = \Carbon\Carbon::createFromFormat('d/m/Y', $endDate)->endOfDay();
                } catch (\Exception $e2) {
                    $endDateParsed = null;
                }
            }
        }
        
        // Default to current month if no date range provided
        if (!$startDateParsed && !$endDateParsed) {
            $startDateParsed = now()->startOfMonth();
            $endDateParsed = now()->endOfMonth();
        } elseif ($startDateParsed && !$endDateParsed) {
            $endDateParsed = now()->endOfDay();
        } elseif (!$startDateParsed && $endDateParsed) {
            $startDateParsed = $endDateParsed->copy()->startOfMonth();
        }

        $attendances = collect();
        $attSummary = ['present'=>0,'absent'=>0,'late'=>0,'early_exit'=>0,'hours'=>'00:00','overtime'=>'00:00'];
        $payslips = collect();
        $employees = collect();
        
        // Check if user is super-admin or admin - they see all employees' attendance
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('admin');
        
        if ($isAdmin) {
            // Get all employees for filter dropdown
            $employees = Employee::where('status', 'active')->orderBy('name')->get();
            
            // Build attendance query for all employees or filtered employee
            $query = Attendance::with('employee');
            
            // Filter by employee if selected
            $selectedEmployeeId = $request->get('employee_id');
            if ($selectedEmployeeId) {
                $query->where('employee_id', $selectedEmployeeId);
            }
            
            if ($startDateParsed) {
                $query->where('date', '>=', $startDateParsed);
            }
            if ($endDateParsed) {
                $query->where('date', '<=', $endDateParsed);
            }
            
            $attendances = $query->orderBy('date', 'desc')->orderBy('employee_id')->get();
        } elseif ($employee) {
            // Regular employee - only their own attendance
            $query = Attendance::where('employee_id', $employee->id);
            
            if ($startDateParsed) {
                $query->where('date', '>=', $startDateParsed);
            }
            if ($endDateParsed) {
                $query->where('date', '<=', $endDateParsed);
            }
            
            $attendances = $query->orderBy('date', 'desc')->get();
        }
        
        // Calculate summary from attendances
        if ($attendances->isNotEmpty()) {

            $presentDays = $attendances->whereIn('status', ['present', 'late', 'half_day'])->count();
            $absentDays  = $attendances->where('status','absent')->count();
            $lateEntries = 0;
            $earlyExits = 0;
            $totalMinutes = 0;
            $totalOvertimeMinutes = 0;
            
            // Standard work hours (9 AM to 6 PM = 9 hours = 540 minutes)
            $standardWorkMinutes = 540;
            $standardCheckIn = '09:00';
            $standardCheckOut = '18:00';

            foreach ($attendances as $a) {
                if ($a->check_in && $a->check_out) {
                    $in  = \Carbon\Carbon::parse($a->check_in);
                    $out = \Carbon\Carbon::parse($a->check_out);
                    $workedMinutes = $in->diffInMinutes($out);
                    $totalMinutes += $workedMinutes;
                    
                    // Check for late entry (after 9:30 AM)
                    $checkInTime = $in->format('H:i');
                    if ($checkInTime > '09:30') {
                        $lateEntries++;
                    }
                    
                    // Check for early exit (before 6:00 PM)
                    $checkOutTime = $out->format('H:i');
                    if ($checkOutTime < '18:00' && $a->status !== 'half_day') {
                        $earlyExits++;
                    }
                    
                    // Calculate overtime (worked more than 9 hours)
                    if ($workedMinutes > $standardWorkMinutes) {
                        $totalOvertimeMinutes += ($workedMinutes - $standardWorkMinutes);
                    }
                } elseif (!empty($a->total_working_hours)) {
                    [$h,$m] = array_map('intval', explode(':', substr($a->total_working_hours,0,5)) + [0,0]);
                    $workedMinutes = ($h * 60) + $m;
                    $totalMinutes += $workedMinutes;
                    
                    if ($workedMinutes > $standardWorkMinutes) {
                        $totalOvertimeMinutes += ($workedMinutes - $standardWorkMinutes);
                    }
                }
            }
            
            $hours = floor($totalMinutes / 60);
            $mins  = $totalMinutes % 60;
            $overtimeHours = floor($totalOvertimeMinutes / 60);
            $overtimeMins = $totalOvertimeMinutes % 60;
            
            $attSummary = [
                'present' => $presentDays,
                'absent'  => $absentDays,
                'late'    => $lateEntries,
                'early_exit' => $earlyExits,
                'hours'   => sprintf('%02d:%02d', $hours, $mins),
                'overtime' => sprintf('%dh %dm', $overtimeHours, $overtimeMins),
            ];
        }
        
        // Get payslips for the employee (only if employee exists)
        if ($employee) {
            $payslips = $employee->payrolls()->orderBy('year', 'desc')->orderBy('month', 'desc')->get();
        }
        
        return view('profile.edit', [
            'user' => $user,
            'employee' => $employee,
            'employees' => $employees,
            'attendances' => $attendances,
            'attSummary'  => $attSummary,
            'payslips' => $payslips,
            'isAdmin' => $isAdmin,
            'selectedEmployeeId' => $request->get('employee_id'),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'active_tab' => session('active_tab'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Check permission - users can always edit their own profile
        if (!$request->user()->can('Profile Management.edit own profile') && 
            !$request->user()->can('Profile Management.edit profile')) {
            abort(403, 'Unauthorized to update profile.');
        }
        
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Update employee record if exists
        $employee = \App\Models\Employee::where('email', $user->email)->first();
        if ($employee) {
            $updateData = [
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
            ];
            
            // Handle photo upload
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('employees', 'public');
                $updateData['photo_path'] = $photoPath;
                
                // Also update user photo
                $user->update(['photo_path' => $photoPath]);
            }
            
            $employee->update($updateData);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated')->with('active_tab', 'personal');
    }

    /**
     * Update bank details.
     */
    public function updateBank(Request $request): RedirectResponse
    {
        // Check permission
        if (!$request->user()->can('Profile Management.update bank details') && 
            !$request->user()->can('Profile Management.edit own profile')) {
            abort(403, 'Unauthorized to update bank details.');
        }
        
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
        // Check permission - only admins can delete profiles
        if (!$request->user()->can('Profile Management.delete profile')) {
            abort(403, 'Unauthorized to delete profile.');
        }
        
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
