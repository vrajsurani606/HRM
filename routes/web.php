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

    // Employees (example module with permission protection)
        Route::resource('employees', EmployeeController::class);
    // HR Hiring Leads
    Route::resource('hiring', HiringController::class);
    Route::get('hiring/{id}/print', [HiringController::class, 'print'])->name('hiring.print');
    Route::get('hiring/{id}/resume', [HiringController::class, 'resume'])->name('hiring.resume');
    Route::post('hiring/{id}/convert', [HiringController::class, 'convert'])->name('hiring.convert');
    // Offer Letter routes
    Route::get('hiring/{id}/offer/create', [HiringController::class, 'offerCreate'])->name('hiring.offer.create');
    Route::post('hiring/{id}/offer', [HiringController::class, 'offerStore'])->name('hiring.offer.store');
    Route::get('hiring/{id}/offer/edit', [HiringController::class, 'offerEdit'])->name('hiring.offer.edit');
    Route::put('hiring/{id}/offer', [HiringController::class, 'offerUpdate'])->name('hiring.offer.update');
    
    // Inquiries
    Route::resource('inquiries', InquiryController::class)->only(['index','create','store','show','edit','update','destroy']);
    Route::get('inquiry/{id}/follow-up', [InquiryController::class, 'followUp'])->name('inquiry.follow-up');
    Route::post('inquiry/{id}/follow-up', [InquiryController::class, 'storeFollowUp'])->name('inquiry.follow-up.store');
    // Quotations
    Route::resource('quotations', QuotationController::class);
    Route::get('inquiry/{id}/quotation', [QuotationController::class, 'createFromInquiry'])->name('quotation.create-from-inquiry');

    // Companies
    Route::resource('companies', CompanyController::class);

    // Projects
    Route::resource('projects', ProjectController::class);
    Route::post('project-stages', [ProjectController::class, 'storeStage'])->name('project-stages.store');
    Route::patch('projects/{project}/stage', [ProjectController::class, 'updateProjectStage'])->name('projects.update-stage');

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

    // Events (align with new permission names)
    Route::resource('events', EventController::class);
    Route::post('events/{event}/images', [EventController::class, 'uploadImages'])->name('events.upload-images');
    Route::delete('event-images/{image}', [EventController::class, 'deleteImage'])->name('events.images.destroy');
    // New media endpoints (images + videos)
    Route::post('events/{event}/media', [EventController::class, 'uploadMedia'])->name('events.upload-media');
    Route::delete('event-videos/{video}', [EventController::class, 'deleteVideo'])->name('events.videos.destroy');
    // Stream/download media to avoid web server 403
    Route::get('event-images/{image}/open', [EventController::class, 'openImage'])->name('events.images.open');
    Route::get('event-images/{image}/download', [EventController::class, 'downloadImage'])->name('events.images.download');
    Route::get('event-videos/{video}/open', [EventController::class, 'openVideo'])->name('events.videos.open');
    Route::get('event-videos/{video}/download', [EventController::class, 'downloadVideo'])->name('events.videos.download');

    // User Management
    Route::resource('users', \App\Http\Controllers\UserController::class);
    
    // Roles & Permissions
    Route::resource('roles', \App\Http\Controllers\Role\RoleController::class);

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
