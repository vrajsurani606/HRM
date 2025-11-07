<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HR\EmployeeController;
use App\Http\Controllers\HR\HiringController;
use App\Http\Controllers\Inquiry\InquiryController;
use App\Http\Controllers\Quotation\QuotationController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\Performa\PerformaController;
use App\Http\Controllers\Performa\InvoiceController;
use App\Http\Controllers\Receipt\ReceiptController;
use App\Http\Controllers\Receipt\VoucherController;
use App\Http\Controllers\Ticket\TicketController;
use App\Http\Controllers\Attendance\AttendanceReportController;
use App\Http\Controllers\Attendance\LeaveApprovalController;
use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Setting\SettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Employees (example module)
    Route::resource('employees', EmployeeController::class);

    // HR Hiring Leads
    Route::resource('hiring', HiringController::class);

    // Inquiries
    Route::resource('inquiries', InquiryController::class)->only(['index','create','store','show','edit','update','destroy']);

    // Quotations
    Route::resource('quotations', QuotationController::class);

    // Companies
    Route::resource('companies', CompanyController::class);

    // Projects
    Route::resource('projects', ProjectController::class);

    // Performa & Invoices
    Route::resource('performas', PerformaController::class);
    Route::resource('invoices', InvoiceController::class)->only(['index','show']);

    // Receipts & Vouchers
    Route::resource('receipts', ReceiptController::class);
    Route::resource('vouchers', VoucherController::class);

    // Tickets
    Route::resource('tickets', TicketController::class);

    // Attendance
    Route::get('attendance/report', [AttendanceReportController::class,'index'])->name('attendance.report');
    Route::resource('leave-approval', LeaveApprovalController::class)->only(['index','update']);

    // Events
    Route::resource('events', EventController::class);

    // Roles & Permissions
    Route::resource('roles', RoleController::class);

    // Settings
    Route::resource('settings', SettingController::class)->only(['index','update']);

    // Inquiry create (UI form matching theme)
    Route::get('/inquiries/create', function () {
        return view('inquiries.create');
    })->name('inquiries.create');
    Route::post('/inquiries', function (Request $request) {
        $request->validate([
            'unique_code' => ['required','string','max:50'],
            'inquiry_date' => ['nullable','date'],
            'company_name' => ['required','string','max:190'],
            'email' => ['nullable','email'],
        ]);
        return back()->with('status','Inquiry submitted');
    })->name('inquiries.store');

    // Generic section view wiring
    Route::get('/section/{name}', function (string $name) {
        return view('section', ['name' => $name]);
    })->name('section');
});

require __DIR__.'/auth.php';
