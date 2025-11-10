<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\HR\EmployeeController;
use App\Http\Controllers\HR\HiringController;
use App\Http\Controllers\Inquiry\InquiryController;
use App\Http\Controllers\Quotation\QuotationController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\Performa\PerformaController;
use App\Http\Controllers\Performa\InvoiceController;
use App\Http\Controllers\Receipt\ReceiptController;
use App\Http\Controllers\Ticket\TicketController;
use App\Http\Controllers\Attendance\AttendanceReportController;
use App\Http\Controllers\Attendance\LeaveApprovalController;
use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\Setting\SettingController;
use App\Http\Controllers\MaintenanceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index']);

// Maintenance routes removed to avoid closures; use Artisan locally or a dedicated controller if needed

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/bank', [ProfileController::class, 'updateBank'])->name('profile.bank.update');
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
    Route::resource('performas', PerformaController::class); // performas.index, performas.create
    Route::resource('invoices', InvoiceController::class)->only(['index','show']); // invoices.index

    // Receipts & (Vouchers disabled)
    Route::resource('receipts', ReceiptController::class); // receipts.index, receipts.create
    // Route::resource('vouchers', VoucherController::class);

    // Tickets
    Route::resource('tickets', TicketController::class);

    // Attendance
    Route::get('attendance/report', [AttendanceReportController::class,'index'])->name('attendance.report');
    Route::resource('leave-approval', LeaveApprovalController::class)->only(['index','update']); // leave-approval.index

    // Events
    Route::resource('events', EventController::class);

    // Roles & Permissions (disabled from routes)
    // Route::resource('roles', RoleController::class);

    // Settings
    Route::resource('settings', SettingController::class)->only(['index','update']);

    // Placeholder named routes to replace generic 'section' links
    Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');
    Route::get('/payroll/create', [PayrollController::class, 'create'])->name('payroll.create');
    Route::get('/rules', [RuleController::class, 'index'])->name('rules.index');
    // Inquiry create/store handled by resource routes above

    // Utilities
    Route::get('/clear-cache', [MaintenanceController::class, 'clearCache'])->name('maintenance.clear-cache');
});

require __DIR__.'/auth.php';
