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
    use App\Http\Controllers\AttendanceReportController;
    use App\Http\Controllers\LeaveApprovalController;
use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\Setting\SettingController; 
use App\Http\Controllers\MaintenanceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index']);

// Maintenance routes removed to avoid closures; use Artisan locally or a dedicated controller if needed

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Attendance Routes
Route::prefix('attendance')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/check', [App\Http\Controllers\AttendanceController::class, 'checkPage'])->name('attendance.check');
    Route::get('/status', [App\Http\Controllers\AttendanceController::class, 'checkStatus'])->name('attendance.status');
    Route::post('/check-in', [App\Http\Controllers\AttendanceController::class, 'checkIn'])->name('attendance.check-in');
    Route::post('/check-out', [App\Http\Controllers\AttendanceController::class, 'checkOut'])->name('attendance.check-out');
    Route::get('/history', [App\Http\Controllers\AttendanceController::class, 'history'])->name('attendance.history');
    
    // Attendance Reports
    Route::get('/reports', [App\Http\Controllers\AttendanceReportController::class, 'index'])->name('attendance.reports');
    Route::get('/reports/generate', [App\Http\Controllers\AttendanceReportController::class, 'generate'])->name('attendance.reports.generate');
    Route::get('/reports/export', [App\Http\Controllers\AttendanceReportController::class, 'export'])->name('attendance.reports.export');
});

// Leave Management Routes
Route::prefix('leaves')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\Leave\LeaveController::class, 'index'])->name('leaves.index');
    Route::get('/create', [App\Http\Controllers\Leave\LeaveController::class, 'create'])->name('leaves.create');
    Route::post('/', [App\Http\Controllers\Leave\LeaveController::class, 'store'])->name('leaves.store');
    Route::get('/{leave}', [App\Http\Controllers\Leave\LeaveController::class, 'show'])->name('leaves.show');
    Route::put('/{leave}', [App\Http\Controllers\Leave\LeaveController::class, 'update'])->name('leaves.update');
    Route::delete('/{leave}', [App\Http\Controllers\Leave\LeaveController::class, 'destroy'])->name('leaves.destroy');
    
    // HR/Admin only routes
    Route::post('/{leave}/approve', [App\Http\Controllers\Leave\LeaveController::class, 'approve'])->name('leaves.approve');
    Route::post('/{leave}/reject', [App\Http\Controllers\Leave\LeaveController::class, 'reject'])->name('leaves.reject');
});

// API route for paid leave balance
Route::get('/api/employee/{employeeId}/paid-leave-balance', [App\Http\Controllers\Leave\LeaveController::class, 'getPaidLeaveBalance'])->middleware('auth');

// API route for employee leave balance (HR/Admin)
Route::get('/api/employee/{employeeId}/leave-balance', [App\Http\Controllers\Leave\LeaveController::class, 'getEmployeeBalance'])->middleware('auth');

// Company Holidays Routes
Route::prefix('holidays')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\CompanyHolidayController::class, 'index'])->name('holidays.index');
    Route::get('/create', [App\Http\Controllers\CompanyHolidayController::class, 'create'])->name('holidays.create')->middleware('role:admin|hr');
    Route::post('/', [App\Http\Controllers\CompanyHolidayController::class, 'store'])->name('holidays.store')->middleware('role:admin|hr');
    Route::get('/{holiday}/edit', [App\Http\Controllers\CompanyHolidayController::class, 'edit'])->name('holidays.edit')->middleware('role:admin|hr');
    Route::put('/{holiday}', [App\Http\Controllers\CompanyHolidayController::class, 'update'])->name('holidays.update')->middleware('role:admin|hr');
    Route::delete('/{holiday}', [App\Http\Controllers\CompanyHolidayController::class, 'destroy'])->name('holidays.destroy')->middleware('role:admin|hr');
});

// Employee Self-Service Routes
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/bank', [ProfileController::class, 'updateBank'])->name('profile.bank.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Employees - toggle-status must come before resource routes
    Route::post('employees/{employeeId}/toggle-status', [EmployeeController::class, 'toggleStatus'])->name('employees.toggle-status');
    Route::resource('employees', EmployeeController::class);
    Route::prefix('employees/{employee}')->group(function () {
        Route::get('/letters', [EmployeeController::class, 'lettersIndex'])->name('employees.letters.index');
        Route::get('/letters/create', [EmployeeController::class, 'createLetter'])->name('employees.letters.create');
        Route::post('/letters', [EmployeeController::class, 'storeLetter'])->name('employees.letters.store');
        Route::get('/letters/{letter}/view', [EmployeeController::class, 'viewLetter'])->name('employees.letters.view');
        Route::get('/letters/{letter}/print', [EmployeeController::class, 'print'])->name('employees.letters.print');
        Route::get('/letters/{letter}/edit', [EmployeeController::class, 'editLetter'])->name('employees.letters.edit');
        Route::put('/letters/{letter}', [EmployeeController::class, 'updateLetter'])->name('employees.letters.update');
        Route::delete('/letters/{letter}', [EmployeeController::class, 'destroyLetter'])->name('employees.letters.destroy');
        // Digital Card routes
        Route::get('/digital-card/create', [\App\Http\Controllers\HR\DigitalCardController::class, 'create'])->name('employees.digital-card.create');
        Route::post('/digital-card', [\App\Http\Controllers\HR\DigitalCardController::class, 'store'])->name('employees.digital-card.store');
        Route::get('/digital-card', [\App\Http\Controllers\HR\DigitalCardController::class, 'show'])->name('employees.digital-card.show');
        Route::get('/digital-card/edit', [\App\Http\Controllers\HR\DigitalCardController::class, 'edit'])->name('employees.digital-card.edit');
        Route::put('/digital-card', [\App\Http\Controllers\HR\DigitalCardController::class, 'update'])->name('employees.digital-card.update');
        Route::delete('/digital-card', [\App\Http\Controllers\HR\DigitalCardController::class, 'destroy'])->name('employees.digital-card.destroy');
        Route::post('/digital-card/quick-edit', [\App\Http\Controllers\HR\DigitalCardController::class, 'quickEdit'])->name('employees.digital-card.quick-edit');
    });
    Route::get('employees/letters/generate-number', [EmployeeController::class, 'generateLetterNumber'])->name('employees.letters.generate-number');
    Route::get('employees/letters/generate-reference', [EmployeeController::class, 'generateLetterNumber'])->name('employees.letters.generate-reference');
    Route::get('employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');

    // HR Hiring Leads
    Route::resource('hiring', HiringController::class);
    Route::get('hiring/{id}/print', [HiringController::class, 'print'])->name('hiring.print');
    Route::get('hiring/{id}/resume', [HiringController::class, 'resume'])->name('hiring.resume');
    Route::match(['GET', 'POST'], 'hiring/{id}/convert', [HiringController::class, 'convert'])->name('hiring.convert');
    // Offer Letter routes
    Route::get('hiring/{id}/offer/create', [HiringController::class, 'offerCreate'])->name('hiring.offer.create');
    Route::post('hiring/{id}/offer', [HiringController::class, 'offerStore'])->name('hiring.offer.store');
    Route::get('hiring/{id}/offer/edit', [HiringController::class, 'offerEdit'])->name('hiring.offer.edit');
    Route::put('hiring/{id}/offer', [HiringController::class, 'offerUpdate'])->name('hiring.offer.update');
    
    // Inquiries
    Route::get('inquiries-export', [InquiryController::class, 'export'])->name('inquiries.export');
    Route::resource('inquiries', InquiryController::class)->only(['index','create','store','show','edit','update','destroy']);
    Route::get('inquiry/{id}/follow-up', [InquiryController::class, 'followUp'])->name('inquiry.follow-up');
    Route::post('inquiry/{id}/follow-up', [InquiryController::class, 'storeFollowUp'])->name('inquiry.follow-up.store');
    Route::post('inquiry-followups/{followUp}/confirm', [InquiryController::class, 'confirmFollowUp'])->name('inquiry.follow-up.confirm');
    // Quotations
    Route::get('quotations/export', [QuotationController::class, 'export'])->name('quotations.export');
    Route::get('quotations-export-csv', [QuotationController::class, 'exportCsv'])->name('quotations.export.csv');
    Route::resource('quotations', QuotationController::class);
    Route::get('inquiry/{id}/quotation', [QuotationController::class, 'createFromInquiry'])->name('quotation.create-from-inquiry');
    Route::get('quotations/company/{id}', [QuotationController::class, 'getCompanyDetails'])->name('quotations.company.details');
    Route::get('quotations/{id}/download', [QuotationController::class, 'download'])->name('quotations.download');
    Route::get('quotations/{id}/print', [QuotationController::class, 'download'])->name('quotations.print');
    Route::get('quotations/{id}/contract-pdf', [QuotationController::class, 'generateContractPdf'])->name('quotations.contract.pdf');
    Route::get('quotations/{id}/contract-png', [QuotationController::class, 'generateContractPng'])->name('quotations.contract.png');
    Route::get('quotations/{id}/contract-file', [QuotationController::class, 'viewContractFile'])->name('quotations.contract.file');
    Route::get('quotation/{id}/follow-up', [QuotationController::class, 'followUp'])->name('quotation.follow-up');
    Route::post('quotation/{id}/follow-up', [QuotationController::class, 'storeFollowUp'])->name('quotation.follow-up.store');
    Route::post('quotation-followups/{followUp}/confirm', [QuotationController::class, 'confirmFollowUp'])->name('quotation.follow-up.confirm');
    Route::get('quotation/{id}/template-list', [QuotationController::class, 'templateList'])->name('quotations.template-list');
    Route::get('quotation/{id}/create-proforma', [QuotationController::class, 'createProforma'])->name('quotations.create-proforma');
    Route::post('quotation/{id}/store-proforma', [QuotationController::class, 'storeProforma'])->name('quotations.store-proforma');
    Route::post('quotations/{id}/convert-to-company', [QuotationController::class, 'convertToCompany'])->name('quotations.convert-to-company');
    Route::post('quotations/cleanup-orphaned', [QuotationController::class, 'cleanupOrphanedQuotations'])->name('quotations.cleanup-orphaned');

    // Companies
    Route::resource('companies', CompanyController::class);
    // Company document viewing route
    Route::get('company-documents/{type}/{filename}', [CompanyController::class, 'viewFile'])
         ->name('company.documents.view');
    Route::get('companies-export', [CompanyController::class, 'export'])->name('companies.export');

    // Project Stages Management (must be before projects resource)
    Route::get('project-stages', [\App\Http\Controllers\Project\ProjectStageController::class, 'index'])->name('project-stages.index');
    Route::post('project-stages', [\App\Http\Controllers\Project\ProjectStageController::class, 'store'])->name('project-stages.store');
    Route::post('project-stages/update-order', [\App\Http\Controllers\Project\ProjectStageController::class, 'updateOrder'])->name('project-stages.update-order');
    Route::get('project-stages/{stage}', [\App\Http\Controllers\Project\ProjectStageController::class, 'show'])->name('project-stages.show');
    Route::patch('project-stages/{stage}', [\App\Http\Controllers\Project\ProjectStageController::class, 'update'])->name('project-stages.update');
    Route::delete('project-stages/{stage}', [\App\Http\Controllers\Project\ProjectStageController::class, 'destroy'])->name('project-stages.destroy');
    
    // Project Materials (MUST be before resource routes)
    Route::get('projects/{project}/materials', [\App\Http\Controllers\Project\ProjectMaterialController::class, 'getMaterials'])->name('projects.materials.index');
    Route::post('projects/{project}/materials', [\App\Http\Controllers\Project\ProjectMaterialController::class, 'updateMaterials'])->name('projects.materials.update');
    Route::post('projects/{project}/materials/create-tasks', [\App\Http\Controllers\Project\ProjectMaterialController::class, 'createTasksFromMaterials'])->name('projects.materials.create-tasks');
    Route::patch('projects/{project}/materials/{projectMaterial}/toggle', [\App\Http\Controllers\Project\ProjectMaterialController::class, 'toggleCompletion'])->name('projects.materials.toggle');
    
    // Add new report to material
    Route::post('api/materials/{material}/reports', [\App\Http\Controllers\Project\ProjectMaterialController::class, 'addReport'])->name('materials.reports.add');
    
    // Project Tasks (MUST be before resource routes)
    Route::get('projects/{project}/tasks', [ProjectController::class, 'getTasks'])->name('projects.tasks.index');
    Route::post('projects/{project}/tasks', [ProjectController::class, 'storeTasks'])->name('projects.tasks.store');
    Route::put('projects/{project}/tasks/{task}', [ProjectController::class, 'updateTask'])->name('projects.tasks.update');
    Route::patch('projects/{project}/tasks/{task}', [ProjectController::class, 'updateTask']);
    Route::delete('projects/{project}/tasks/{task}', [ProjectController::class, 'deleteTask'])->name('projects.tasks.delete');
    
    // Project Comments (MUST be before resource routes)
    Route::get('projects/{project}/comments', [ProjectController::class, 'getComments'])->name('projects.comments.index');
    Route::post('projects/{project}/comments', [ProjectController::class, 'storeComment'])->name('projects.comments.store');
    
    // Project Members (MUST be before resource routes)
    Route::get('projects/{project}/members', [ProjectController::class, 'getMembers'])->name('projects.members.index');
    Route::get('projects/{project}/available-users', [ProjectController::class, 'getAvailableUsers'])->name('projects.members.available');
    Route::post('projects/{project}/members', [ProjectController::class, 'addMember'])->name('projects.members.add');
    Route::delete('projects/{project}/members/{user}', [ProjectController::class, 'removeMember'])->name('projects.members.remove');
    
    // Project Overview (MUST be before resource routes)
    Route::get('projects/{project}/overview', [ProjectController::class, 'overview'])->name('projects.overview');
    Route::patch('projects/{project}/stage', [ProjectController::class, 'updateProjectStage'])->name('projects.update-stage');
    
    // Projects Resource (MUST be AFTER specific routes)
    Route::resource('projects', ProjectController::class);
    Route::post('project-stages-old', [ProjectController::class, 'storeStage'])->name('project-stages-old.store');
    
    // Test route for debugging
    Route::get('test-materials-api', function() {
        $materials = \App\Models\Material::with('reports')->get();
        return response()->json([
            'success' => true,
            'message' => 'API is working!',
            'materials_count' => $materials->count(),
            'materials' => $materials
        ]);
    });
    
    // Test route with project ID (no model binding)
    Route::get('test-project-materials/{id}', function($id) {
        $project = \App\Models\Project::findOrFail($id);
        $materials = \App\Models\Material::with('reports')->get();
        return response()->json([
            'success' => true,
            'message' => 'Project materials API working!',
            'project_id' => $project->id,
            'project_name' => $project->name,
            'materials_count' => $materials->count()
        ]);
    });

    // Performa & Invoices
    Route::get('performas/export', [PerformaController::class, 'export'])->name('performas.export');
    Route::get('performas-export-csv', [PerformaController::class, 'exportCsv'])->name('performas.export.csv');
    Route::get('performas/{id}/print', [PerformaController::class, 'print'])->name('performas.print');
    Route::resource('performas', PerformaController::class); // performas.index, performas.create
    
    Route::get('performas/{id}/convert', [\App\Http\Controllers\Invoice\InvoiceController::class, 'convertForm'])->name('performas.convert');
    Route::post('performas/{id}/convert', [\App\Http\Controllers\Invoice\InvoiceController::class, 'convert'])->name('performas.convert.store');
    Route::get('invoices/export', [\App\Http\Controllers\Invoice\InvoiceController::class, 'export'])->name('invoices.export');
    Route::get('invoices-export-csv', [\App\Http\Controllers\Invoice\InvoiceController::class, 'exportCsv'])->name('invoices.export.csv');
    Route::get('invoices/{id}/print', [\App\Http\Controllers\Invoice\InvoiceController::class, 'print'])->name('invoices.print');
    Route::resource('invoices', \App\Http\Controllers\Invoice\InvoiceController::class)->except(['create', 'store']); // invoices.index, show, edit, update, destroy

    // Receipts & (Vouchers disabled)
    Route::get('receipts/export', [\App\Http\Controllers\Receipt\ReceiptController::class, 'export'])->name('receipts.export');
    Route::get('receipts-export-csv', [\App\Http\Controllers\Receipt\ReceiptController::class, 'exportCsv'])->name('receipts.export.csv');
    Route::get('receipts/{id}/print', [\App\Http\Controllers\Receipt\ReceiptController::class, 'print'])->name('receipts.print');
    Route::resource('receipts', \App\Http\Controllers\Receipt\ReceiptController::class);
    // Route::resource('vouchers', VoucherController::class);

    // Tickets
    Route::resource('tickets', TicketController::class);

    // Attendance
    Route::get('attendance/report', [AttendanceReportController::class,'index'])->name('attendance.report');
    Route::resource('leave-approval', LeaveApprovalController::class)->only(['index','store','edit','update','destroy']); // leave-approval routes

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

    // Payroll Management (define specific routes BEFORE resource to avoid {payroll} catch-all)
    Route::get('payroll/bulk', [PayrollController::class, 'bulkForm'])->name('payroll.bulk');
    Route::post('payroll/bulk-generate', [PayrollController::class, 'bulkGenerate'])->name('payroll.bulk-generate');
    Route::get('payroll/export-csv', [PayrollController::class, 'exportCsv'])->name('payroll.export-csv');
    Route::get('payroll/export-excel', [PayrollController::class, 'exportExcel'])->name('payroll.export-excel');
    Route::resource('payroll', PayrollController::class);
    Route::post('/payroll/get-employee-salary', [PayrollController::class, 'getEmployeeSalary'])->name('payroll.get-employee-salary');
    Route::get('/rules', [RuleController::class, 'index'])->name('rules.index');
    // Inquiry create/store handled by resource routes above

    // Utilities
    Route::get('/clear-cache', [MaintenanceController::class, 'clearCache'])->name('maintenance.clear-cache');
});

// Direct storage file access route (public access for PDFs and documents)
Route::get('storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    
    if (!file_exists($filePath)) {
        abort(404, 'File not found');
    }
    
    return response()->file($filePath);
})->where('path', '.*')->name('storage.file');

require __DIR__.'/auth.php';
