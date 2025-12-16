<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
        $isEmployee = $user->hasRole('employee') || $user->hasRole('Employee');
        $isCustomer = $user->hasRole('customer');
        
        // Allow admins, employees, and customers to view tickets
        if (!$isAdmin && !$isEmployee && !$isCustomer) {
            abort(403, 'Unauthorized to view tickets.');
        }
        
        $query = Ticket::with(['assignedEmployee', 'opener', 'company', 'project']);

        // Super-admin and HR can see all tickets
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
        
        // Check if user is a customer first
        $isCustomer = $user->hasRole('customer') && $user->company_id;
        
        // Check if user is an employee - MUST match user_id first, then fallback to email
        $employeeRecord = \App\Models\Employee::where('user_id', $user->id)->first();
        if (!$employeeRecord) {
            // Fallback: try to find by email only if user_id not found
            $employeeRecord = \App\Models\Employee::where('email', $user->email)->first();
        }
        
        $isEmployee = $user->hasRole('employee') || $user->hasRole('Employee');
        
        if (!$isAdmin) {
            // Filter by role: customers see only their company's tickets
            if ($isCustomer) {
                $company = $user->company;
                if ($company) {
                    $query->where(function($q) use ($company) {
                        $q->where('company', $company->company_name)
                          ->orWhere('customer', $company->name ?? auth()->user()->name);
                    });
                }
            }
            // Filter by role: employees see only their assigned tickets
            elseif ($isEmployee && $employeeRecord) {
                // Employee can ONLY see tickets assigned to them
                $query->where('assigned_to', $employeeRecord->id);
            }
            // Any other role that's not admin - show no tickets by default
            else {
                $query->whereRaw('1 = 0'); // Show nothing
            }
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->string('priority'));
        }
        if ($request->filled('company')) {
            $query->where('company', $request->string('company'));
        }
        if ($request->filled('ticket_type')) {
            $query->where('ticket_type', $request->string('ticket_type'));
        }
        if ($request->filled('q')) {
            $q = $request->string('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('ticket_no', 'like', "%{$q}%")
                    ->orWhere('subject', 'like', "%{$q}%")
                    ->orWhere('customer', 'like', "%{$q}%")
                    ->orWhere('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('company', 'like', "%{$q}%")
                    ->orWhere('category', 'like', "%{$q}%")
                    ->orWhere('ticket_type', 'like', "%{$q}%")
                    ->orWhere('status', 'like', "%{$q}%")
                    ->orWhere('priority', 'like', "%{$q}%")
                    ->orWhereHas('assignedEmployee', function($empQuery) use ($q) {
                        $empQuery->where('name', 'like', "%{$q}%");
                    });
            });
        }

        $perPage = (int) $request->get('per_page', 25);
        $tickets = $query->orderByDesc('id')->paginate($perPage)->appends($request->query());

        // Filter companies list based on role
        $companiesQuery = Ticket::query()->whereNotNull('company')->distinct();
        if (!$isAdmin) {
            if ($isCustomer) {
                $company = $user->company;
                if ($company) {
                    $companiesQuery->where(function($q) use ($company) {
                        $q->where('company', $company->company_name)
                          ->orWhere('customer', $company->name ?? auth()->user()->name);
                    });
                }
            } elseif ($isEmployee && $employeeRecord) {
                $companiesQuery->where('assigned_to', $employeeRecord->id);
            } else {
                $companiesQuery->whereRaw('1 = 0'); // Show nothing
            }
        }
        $companies = $companiesQuery->pluck('company');
        
        $types = Ticket::query()->whereNotNull('ticket_type')->distinct()->pluck('ticket_type');

        return view('tickets.index', [
            'tickets' => $tickets,
            'companies' => $companies,
            'types' => $types,
        ]);
    }

    public function show(Ticket $ticket)
    {
        // Redirect to index page with view parameter (popup will open automatically)
        return redirect()->route('tickets.index', ['view' => $ticket->id]);
    }
    
    /**
     * Show ticket details page (legacy - kept for backward compatibility)
     */
    public function showPage(Ticket $ticket)
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
        $isEmployee = $user->hasRole('employee') || $user->hasRole('Employee');
        $isCustomer = $user->hasRole('customer');
        
        // Check basic permission - allow customers to view their own tickets
        if (!$isAdmin && !$isEmployee && !$isCustomer) {
            abort(403, 'Unauthorized to view tickets.');
        }
        
        if (!$isAdmin) {
            // Check access: customers can only view their company's tickets
            if ($user->hasRole('customer') && $user->company_id) {
                $company = $user->company;
                // Customer can view if:
                // 1. Ticket company matches their company name, OR
                // 2. Ticket customer matches their name, OR  
                // 3. Ticket was opened by them
                $canView = false;
                
                if ($company && $ticket->company == $company->company_name) {
                    $canView = true;
                }
                
                if ($ticket->customer == $user->name) {
                    $canView = true;
                }
                
                if ($ticket->opened_by == $user->id) {
                    $canView = true;
                }
                
                if (!$canView) {
                    abort(403, 'Unauthorized access to this ticket.');
                }
            } elseif ($isEmployee) {
                // Employees can only view assigned tickets
                $employee = \App\Models\Employee::where('user_id', $user->id)->first();
                if (!$employee) {
                    $employee = \App\Models\Employee::where('email', $user->email)->first();
                }
                if (!$employee || $ticket->assigned_to != $employee->id) {
                    abort(403, 'Unauthorized access to this ticket.');
                }
            } else {
                abort(403, 'Unauthorized access to this ticket.');
            }
        }
        
        // Eager load relationships for better performance
        $ticket->load([
            'comments.user',
            'assignedEmployee',
            'opener',
            'completedBy',
            'confirmedBy',
            'closedBy',
            'company',
            'project'
        ]);
        
        return view('tickets.show', compact('ticket', 'isAdmin', 'isEmployee'));
    }

    /**
     * Get ticket data as JSON for AJAX requests
     */
    public function getJson(Ticket $ticket)
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
        $isEmployee = $user->hasRole('employee') || $user->hasRole('Employee');
        $isCustomer = $user->hasRole('customer');
        
        // Check basic permission
        if (!$isAdmin && !$isEmployee && !$isCustomer) {
            return response()->json(['success' => false, 'message' => 'Unauthorized to view tickets.'], 403);
        }
        
        if (!$isAdmin) {
            // Check access: customers can only view their company's tickets
            if ($user->hasRole('customer') && $user->company_id) {
                $company = $user->company;
                $canView = false;
                
                if ($company && $ticket->company == $company->company_name) {
                    $canView = true;
                }
                
                if ($ticket->customer == $user->name) {
                    $canView = true;
                }
                
                if ($ticket->opened_by == $user->id) {
                    $canView = true;
                }
                
                if (!$canView) {
                    return response()->json(['success' => false, 'message' => 'Unauthorized access to this ticket.'], 403);
                }
            } elseif ($isEmployee) {
                $employee = \App\Models\Employee::where('user_id', $user->id)->first();
                if (!$employee) {
                    $employee = \App\Models\Employee::where('email', $user->email)->first();
                }
                if (!$employee || $ticket->assigned_to != $employee->id) {
                    return response()->json(['success' => false, 'message' => 'Unauthorized access to this ticket.'], 403);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Unauthorized access to this ticket.'], 403);
            }
        }
        
        // Load the assigned employee relationship
        $ticket->load('assignedEmployee');
        
        return response()->json([
            'success' => true,
            'ticket' => [
                'id' => $ticket->id,
                'ticket_no' => $ticket->ticket_no,
                'title' => $ticket->title,
                'subject' => $ticket->subject,
                'description' => $ticket->description,
                'status' => $ticket->status,
                'priority' => $ticket->priority,
                'category' => $ticket->category,
                'ticket_type' => $ticket->ticket_type,
                'customer' => $ticket->customer,
                'company' => $ticket->company,
                'assigned_to' => $ticket->assigned_to,
                'assigned_employee' => $ticket->assignedEmployee ? [
                    'id' => $ticket->assignedEmployee->id,
                    'name' => $ticket->assignedEmployee->name,
                    'photo_path' => $ticket->assignedEmployee->photo_path,
                ] : null,
                'resolution_notes' => $ticket->resolution_notes,
                'attachments' => $ticket->attachments,
                'created_at' => $ticket->created_at,
                'updated_at' => $ticket->updated_at,
                'opened_by' => $ticket->opened_by,
                'project_id' => $ticket->project_id,
            ]
        ]);
    }

    public function create()
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
        $isCustomer = $user->hasRole('customer');
        
        // Allow admins and customers to create tickets
        if (!$isAdmin && !$isCustomer) {
            abort(403, 'Unauthorized to create tickets.');
        }
        
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        \Log::info('=== TICKET STORE CALLED ===', [
            'has_files' => $request->hasFile('attachments'),
            'all_files' => array_keys($request->allFiles()),
            'content_type' => $request->header('Content-Type'),
        ]);
        
        $user = auth()->user();
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
        $isCustomer = $user->hasRole('customer');
        
        // Allow admins and customers to create tickets
        if (!$isAdmin && !$isCustomer) {
            abort(403, 'Unauthorized to create tickets.');
        }
        if (!auth()->user()->can('Tickets Management.create ticket')) {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Unauthorized to create tickets'], 403)
                : back()->with('error', 'Unauthorized to create tickets');
        }
        
        $user = auth()->user();
        $isCustomer = $user->hasRole('customer');
        
        // Different validation rules for customers vs admins
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'status' => 'nullable|in:open,assigned,pending,needs_approval,in_progress,completed,resolved,closed',
            'ticket_type' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:255',
            'company' => $isCustomer ? 'nullable' : 'nullable|string|max:255',
            'customer' => $isCustomer ? 'nullable' : 'required|string|max:255',
            'project_id' => 'nullable|exists:projects,id',
            'assigned_to' => 'nullable|exists:employees,id',
        ];
        
        $validated = $request->validate($rules);
        
        // Auto-set company_id and company name for customers
        if ($isCustomer && $user->company_id) {
            $validated['company_id'] = $user->company_id;
            $company = $user->company;
            if ($company) {
                $validated['company'] = $company->company_name;
                $validated['customer'] = $user->name;
            }
        }
        
        // Set default status if not provided
        if (!isset($validated['status'])) {
            $validated['status'] = 'open';
        }
        
        // Set default priority if not provided
        if (!isset($validated['priority'])) {
            $validated['priority'] = 'medium';
        }
        
        // Set subject from title if not provided (subject is required in DB)
        if (!isset($validated['subject'])) {
            $validated['subject'] = $validated['title'];
        }
        
        // Set opened_by and opened_at
        $validated['opened_by'] = $user->id;
        $validated['opened_at'] = now();
        
        // Generate ticket number if not exists
        if (!isset($validated['ticket_no'])) {
            $validated['ticket_no'] = 'TKT-' . strtoupper(uniqid());
        }

        $ticket = Ticket::create($validated);

        // Handle multiple attachments if provided
        \Log::info('Ticket Store - Checking for attachments', [
            'has_attachments' => $request->hasFile('attachments'),
            'has_single_attachment' => $request->hasFile('attachment'),
            'all_files' => $request->allFiles(),
        ]);
        
        $attachmentPaths = [];
        
        // Handle multiple attachments (new format)
        if ($request->hasFile('attachments')) {
            $files = $request->file('attachments');
            
            // Validate files
            $request->validate([
                'attachments.*' => 'file|mimes:jpeg,jpg,png,gif,webp,pdf,doc,docx,zip|max:10240', // 10MB max per file
            ]);
            
            foreach ($files as $file) {
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $attachmentPath = $file->storeAs('ticket_attachments', $filename, 'public');
                $attachmentPaths[] = $attachmentPath;
                
                \Log::info('Ticket Store - Multiple file stored', [
                    'path' => $attachmentPath,
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }
        }
        // Handle single attachment (backward compatibility)
        elseif ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            
            // Validate file
            $request->validate([
                'attachment' => 'file|mimes:jpeg,jpg,png,gif,webp,pdf,doc,docx,zip|max:10240', // 10MB max
            ]);
            
            $filename = time() . '_' . $file->getClientOriginalName();
            $attachmentPath = $file->storeAs('ticket_attachments', $filename, 'public');
            $attachmentPaths[] = $attachmentPath;
            
            \Log::info('Ticket Store - Single file stored', [
                'path' => $attachmentPath,
            ]);
        }
        
        // Save attachments to ticket
        if (!empty($attachmentPaths)) {
            // For backward compatibility, save first attachment in 'attachment' field
            $ticket->attachment = $attachmentPaths[0];
            
            // Save all attachments in new 'attachments' field
            $ticket->attachments = $attachmentPaths;
            $ticket->save();
            
            \Log::info('Ticket Store - Attachments saved to ticket', [
                'count' => count($attachmentPaths),
                'paths' => $attachmentPaths
            ]);
        } else {
            \Log::info('Ticket Store - No attachment files found');
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true, 
                'ticket' => $ticket,
                'message' => 'Support ticket created successfully! We will get back to you soon.'
            ]);
        }

        return redirect()->route('tickets.index')->with('success', 'Support ticket created successfully! We will get back to you soon.');
    }

    public function edit(Ticket $ticket)
    {
        // Check permission
        if (!auth()->user()->can('Tickets Management.edit ticket')) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized to edit tickets.'], 403);
            }
            abort(403, 'Unauthorized to edit tickets.');
        }
        
        $user = auth()->user();
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
        
        if (!$isAdmin) {
            // Check access: customers can only edit their company's tickets
            if ($user->hasRole('customer') && $user->company_id) {
                $company = $user->company;
                // Customer can edit if:
                // 1. Ticket company matches their company name, OR
                // 2. Ticket customer matches their name, OR  
                // 3. Ticket was opened by them
                $canEdit = false;
                
                if ($company && $ticket->company == $company->company_name) {
                    $canEdit = true;
                }
                
                if ($ticket->customer == $user->name) {
                    $canEdit = true;
                }
                
                if ($ticket->opened_by == $user->id) {
                    $canEdit = true;
                }
                
                if (!$canEdit) {
                    abort(403, 'Unauthorized access to this ticket.');
                }
            } elseif ($user->hasRole('employee') || $user->hasRole('Employee')) {
                $employee = \App\Models\Employee::where('user_id', $user->id)->first();
                if (!$employee) {
                    $employee = \App\Models\Employee::where('email', $user->email)->first();
                }
                if (!$employee || $ticket->assigned_to != $employee->id) {
                    abort(403, 'Unauthorized access to this ticket.');
                }
            } else {
                abort(403, 'Unauthorized access to this ticket.');
            }
        }
        
        // Return JSON for AJAX requests
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'ticket' => $ticket
            ]);
        }
        
        // Redirect to index page with edit parameter (popup will open automatically)
        return redirect()->route('tickets.index', ['edit' => $ticket->id]);
    }

    public function update(Request $request, Ticket $ticket)
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
        $isEmployee = $user->hasRole('employee') || $user->hasRole('Employee');
        $isCustomer = $user->hasRole('customer');
        
        // Check if employee is assigned to this ticket
        $isAssignedEmployee = false;
        if ($isEmployee) {
            $employee = \App\Models\Employee::where('user_id', $user->id)->first();
            if (!$employee) {
                $employee = \App\Models\Employee::where('email', $user->email)->first();
            }
            $isAssignedEmployee = $employee && $ticket->assigned_to == $employee->id;
        }
        
        // Check permission - admins, assigned employees, or users with edit permission
        $hasEditPermission = $isAdmin || $isAssignedEmployee || $user->can('Tickets Management.edit ticket');
        
        if (!$hasEditPermission) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized to edit tickets.'], 403);
            }
            return back()->with('error', 'Unauthorized to edit tickets.');
        }
        
        if (!$isAdmin && !$isAssignedEmployee) {
            // Check access: customers can only update their company's tickets
            if ($isCustomer && $user->company_id) {
                $company = $user->company;
                // Customer can update if:
                // 1. Ticket company matches their company name, OR
                // 2. Ticket customer matches their name, OR  
                // 3. Ticket was opened by them
                $canUpdate = false;
                
                if ($company && $ticket->company == $company->company_name) {
                    $canUpdate = true;
                }
                
                if ($ticket->customer == $user->name) {
                    $canUpdate = true;
                }
                
                if ($ticket->opened_by == $user->id) {
                    $canUpdate = true;
                }
                
                if (!$canUpdate) {
                    if ($request->ajax()) {
                        return response()->json(['success' => false, 'message' => 'Unauthorized access to this ticket.'], 403);
                    }
                    abort(403, 'Unauthorized access to this ticket.');
                }
            } else {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Unauthorized access to this ticket.'], 403);
                }
                abort(403, 'Unauthorized access to this ticket.');
            }
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'status' => 'nullable|in:open,assigned,pending,needs_approval,in_progress,completed,resolved,closed',
            'category' => 'nullable|string|max:255',
            'ticket_type' => 'nullable|string|max:100',
            'company' => 'nullable|string|max:255',
            'customer' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|exists:employees,id',
            'resolution_notes' => 'nullable|string',
        ]);

        // Debug: Log what we're receiving
        \Log::info('Ticket Update Request', [
            'ticket_id' => $ticket->id,
            'priority_before' => $ticket->priority,
            'priority_new' => $validated['priority'] ?? 'not set',
            'resolution_notes_before' => $ticket->resolution_notes,
            'resolution_notes_new' => $validated['resolution_notes'] ?? 'not set',
            'all_validated' => $validated
        ]);

        // Auto-update status when assigning employee
        if (isset($validated['assigned_to']) && $validated['assigned_to'] && in_array($ticket->status, ['open', 'assigned'])) {
            $validated['status'] = 'in_progress';
        }

        $ticket->update($validated);
        
        // Debug: Log after update
        \Log::info('Ticket After Update', [
            'ticket_id' => $ticket->id,
            'priority_after' => $ticket->priority,
            'resolution_notes_after' => $ticket->resolution_notes,
        ]);
        
        // Refresh the model to get updated values
        $ticket->refresh();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true, 
                'ticket' => $ticket,
                'message' => 'Ticket updated successfully'
            ]);
        }

        return redirect()->route('tickets.index', ['view' => $ticket->id])->with('success', 'Ticket updated successfully');
    }

    public function destroy(Ticket $ticket): RedirectResponse|JsonResponse
    {
        // Check permission
        if (!auth()->user()->can('Tickets Management.delete ticket')) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized to delete tickets.'], 403);
            }
            return back()->with('error', 'Unauthorized to delete tickets.');
        }
        
        $user = auth()->user();
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
        
        if (!$isAdmin) {
            // Check access
            if ($user->hasRole('customer') && $user->company_id) {
                if ($ticket->company_id != $user->company_id) {
                    abort(403, 'Unauthorized access to this ticket.');
                }
            } elseif ($user->hasRole('employee') || $user->hasRole('Employee')) {
                $employee = \App\Models\Employee::where('user_id', $user->id)->first();
                if (!$employee) {
                    $employee = \App\Models\Employee::where('email', $user->email)->first();
                }
                if (!$employee || $ticket->assigned_to != $employee->id) {
                    abort(403, 'Unauthorized access to this ticket.');
                }
            } else {
                abort(403, 'Unauthorized access to this ticket.');
            }
        }
        
        $ticket->delete();
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Ticket deleted successfully');
    }
    
    /**
     * Assign ticket to employee (Admin only)
     */
    public function assign(Request $request, Ticket $ticket)
    {
        // Check permission
        if (!auth()->user()->can('Tickets Management.assign ticket')) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized to assign tickets.'], 403);
            }
            abort(403, 'Unauthorized to assign tickets.');
        }
        
        $validated = $request->validate([
            'assigned_to' => 'required|exists:employees,id',
        ]);
        
        $ticket->update([
            'assigned_to' => $validated['assigned_to'],
            'status' => Ticket::STATUS_ASSIGNED,
        ]);
        
        return back()->with('success', 'Ticket assigned successfully');
    }
    
    /**
     * Mark ticket as completed (Employee only)
     */
    public function complete(Request $request, Ticket $ticket)
    {
        // Check permission
        if (!auth()->user()->can('Tickets Management.complete ticket')) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized to complete tickets.'], 403);
            }
            abort(403, 'Unauthorized to complete tickets.');
        }
        
        $user = auth()->user();
        $employee = \App\Models\Employee::where('user_id', $user->id)->first();
        
        if (!$employee || $ticket->assigned_to != $employee->id) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You can only complete tickets assigned to you.'
                ], 403);
            }
            abort(403, 'You can only complete tickets assigned to you.');
        }
        
        if (!$ticket->canBeCompleted()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This ticket cannot be completed at this stage. Status must be "assigned" or "in_progress".'
                ], 400);
            }
            return back()->with('error', 'This ticket cannot be completed at this stage.');
        }
        
        $validated = $request->validate([
            'resolution_notes' => 'nullable|string',
            'completion_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max per image
        ]);
        
        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('completion_images')) {
            foreach ($request->file('completion_images') as $image) {
                $path = $image->store('tickets/completion', 'public');
                $imagePaths[] = $path;
            }
        }
        
        $ticket->update([
            'status' => Ticket::STATUS_COMPLETED,
            'completed_at' => now(),
            'completed_by' => $employee->id,
            'resolution_notes' => $validated['resolution_notes'] ?? 'Completed',
            'completion_images' => !empty($imagePaths) ? $imagePaths : null,
        ]);
        
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Ticket marked as completed. Admin will be notified for confirmation.',
                'ticket' => $ticket
            ]);
        }
        
        return back()->with('success', 'Ticket marked as completed. Waiting for admin confirmation.');
    }
    
    /**
     * Confirm ticket resolution (Admin only)
     */
    public function confirm(Request $request, Ticket $ticket)
    {
        // Check permission
        if (!auth()->user()->can('Tickets Management.confirm resolution')) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized to confirm ticket resolution.'], 403);
            }
            abort(403, 'Unauthorized to confirm ticket resolution.');
        }
        
        if (!$ticket->canBeConfirmed()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This ticket cannot be confirmed at this stage. Employee must mark it as completed first.'
                ], 400);
            }
            return back()->with('error', 'This ticket cannot be confirmed at this stage.');
        }
        
        $ticket->update([
            'status' => Ticket::STATUS_RESOLVED,
            'confirmed_at' => now(),
            'confirmed_by' => auth()->id(),
        ]);
        
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Ticket confirmed as resolved. Customer has been notified.',
                'ticket' => $ticket
            ]);
        }
        
        return back()->with('success', 'Ticket confirmed as resolved. Customer will be notified.');
    }
    
    /**
     * Update completion data (Admin only)
     */
    public function updateCompletion(Request $request, Ticket $ticket)
    {
        // Check permission
        if (!auth()->user()->can('Tickets Management.edit ticket') && 
            !auth()->user()->can('Tickets Management.manage ticket')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update completion data.'
            ], 403);
        }
        
        $validated = $request->validate([
            'resolution_notes' => 'nullable|string',
            'completion_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'string',
        ]);
        
        $currentImages = $ticket->completion_images ?? [];
        
        // Remove specified images
        if (!empty($validated['remove_images'])) {
            foreach ($validated['remove_images'] as $imageToRemove) {
                if (($key = array_search($imageToRemove, $currentImages)) !== false) {
                    // Delete file from storage
                    \Storage::disk('public')->delete($imageToRemove);
                    unset($currentImages[$key]);
                }
            }
            $currentImages = array_values($currentImages); // Re-index array
        }
        
        // Add new images
        if ($request->hasFile('completion_images')) {
            foreach ($request->file('completion_images') as $image) {
                $path = $image->store('tickets/completion', 'public');
                $currentImages[] = $path;
            }
        }
        
        $ticket->update([
            'resolution_notes' => $validated['resolution_notes'] ?? $ticket->resolution_notes,
            'completion_images' => !empty($currentImages) ? $currentImages : null,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Completion data updated successfully',
            'ticket' => $ticket
        ]);
    }
    
    /**
     * Delete completion image (Admin only)
     */
    public function deleteCompletionImage(Request $request, Ticket $ticket)
    {
        // Check permission
        if (!auth()->user()->can('Tickets Management.delete attachment')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to delete completion images.'
            ], 403);
        }
        
        $validated = $request->validate([
            'image_path' => 'required|string',
        ]);
        
        $currentImages = $ticket->completion_images ?? [];
        $imagePath = $validated['image_path'];
        
        if (($key = array_search($imagePath, $currentImages)) !== false) {
            // Delete file from storage
            \Storage::disk('public')->delete($imagePath);
            unset($currentImages[$key]);
            $currentImages = array_values($currentImages); // Re-index array
            
            $ticket->update([
                'completion_images' => !empty($currentImages) ? $currentImages : null,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Image not found'
        ], 404);
    }
    
    /**
     * Close ticket (Customer only - for resolved tickets)
     */
    public function close(Request $request, Ticket $ticket)
    {
        // Check permission
        if (!auth()->user()->can('Tickets Management.close ticket')) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized to close tickets.'], 403);
            }
            abort(403, 'Unauthorized to close tickets.');
        }
        
        $user = auth()->user();
        $isCustomer = $user->hasRole('customer');
        
        // Only customers can close their own tickets
        if (!$isCustomer) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only customers can close tickets.'
                ], 403);
            }
            abort(403, 'Only customers can close tickets.');
        }
        
        // Check if customer owns this ticket (by company_id or customer name)
        $ownsTicket = false;
        if ($user->company_id && $ticket->company_id == $user->company_id) {
            $ownsTicket = true;
        } elseif ($ticket->customer == $user->name || $ticket->opened_by == $user->id) {
            $ownsTicket = true;
        }
        
        if (!$ownsTicket) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You can only close your own tickets.'
                ], 403);
            }
            abort(403, 'You can only close your own tickets.');
        }
        
        // Only open or resolved tickets can be closed by customers
        if (!in_array($ticket->status, [Ticket::STATUS_OPEN, Ticket::STATUS_RESOLVED])) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only open or resolved tickets can be closed.'
                ], 400);
            }
            return back()->with('error', 'Only open or resolved tickets can be closed.');
        }
        
        $validated = $request->validate([
            'feedback' => 'nullable|string|max:1000',
        ]);
        
        $ticket->update([
            'status' => Ticket::STATUS_CLOSED,
            'closed_at' => now(),
            'closed_by' => $user->id,
            'customer_feedback' => $validated['feedback'] ?? null,
        ]);
        
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Ticket closed successfully. Thank you for your feedback!',
                'ticket' => $ticket
            ]);
        }
        
        return back()->with('success', 'Ticket closed successfully. Thank you for your feedback!');
    }
    
    /**
     * Get comments for a ticket (AJAX)
     */
    public function getComments(Ticket $ticket)
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
        $isEmployee = $user->hasRole('employee') || $user->hasRole('Employee');
        $isCustomer = $user->hasRole('customer');
        
        // Check basic permission
        if (!$isAdmin && !$isEmployee && !$isCustomer) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        // Check access based on role
        if (!$isAdmin) {
            if ($isCustomer && $user->company_id) {
                $company = $user->company;
                $canView = false;
                
                if ($company && $ticket->company == $company->company_name) {
                    $canView = true;
                }
                if ($ticket->customer == $user->name) {
                    $canView = true;
                }
                if ($ticket->opened_by == $user->id) {
                    $canView = true;
                }
                
                if (!$canView) {
                    return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
                }
            } elseif ($isEmployee) {
                $employee = \App\Models\Employee::where('user_id', $user->id)->first();
                if (!$employee) {
                    $employee = \App\Models\Employee::where('email', $user->email)->first();
                }
                if (!$employee || $ticket->assigned_to != $employee->id) {
                    return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
                }
            }
        }
        
        // Load comments with user relationship
        $comments = $ticket->comments()->with('user')->orderBy('created_at', 'asc')->get();
        
        return response()->json([
            'success' => true,
            'comments' => $comments
        ]);
    }
    
    /**
     * Add comment to ticket
     */
    public function addComment(Request $request, Ticket $ticket)
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
        $isEmployee = $user->hasRole('employee') || $user->hasRole('Employee');
        $isCustomer = $user->hasRole('customer');
        
        // Allow admins, employees, and customers to add comments
        if (!$isAdmin && !$isEmployee && !$isCustomer) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized to add comments.'], 403);
            }
            abort(403, 'Unauthorized to add comments.');
        }
        
        \Log::info('=== ADD COMMENT METHOD CALLED ===', [
            'ticket_id' => $ticket->id,
            'has_file' => $request->hasFile('attachment'),
            'all_files' => $request->allFiles(),
            'content_type' => $request->header('Content-Type'),
        ]);
        
        $user = auth()->user();
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
        $isEmployee = $user->hasRole('employee') || $user->hasRole('Employee');
        
        // Check access
        if (!$isAdmin) {
            if ($user->hasRole('customer') && $user->company_id) {
                $company = $user->company;
                // Customer can comment if:
                // 1. Ticket company_id matches their company_id, OR
                // 2. Ticket company name matches their company name, OR
                // 3. Ticket customer matches their name, OR
                // 4. Ticket was opened by them
                $canComment = false;
                
                if ($ticket->company_id && $ticket->company_id == $user->company_id) {
                    $canComment = true;
                }
                
                if ($company && $ticket->company == $company->company_name) {
                    $canComment = true;
                }
                
                if ($ticket->customer == $user->name) {
                    $canComment = true;
                }
                
                if ($ticket->opened_by == $user->id) {
                    $canComment = true;
                }
                
                if (!$canComment) {
                    if ($request->ajax()) {
                        return response()->json(['success' => false, 'message' => 'Unauthorized access to this ticket.'], 403);
                    }
                    abort(403, 'Unauthorized access to this ticket.');
                }
            } elseif ($isEmployee) {
                $employee = \App\Models\Employee::where('user_id', $user->id)->first();
                if (!$employee) {
                    $employee = \App\Models\Employee::where('email', $user->email)->first();
                }
                if (!$employee || $ticket->assigned_to != $employee->id) {
                    if ($request->ajax()) {
                        return response()->json(['success' => false, 'message' => 'Unauthorized access to this ticket.'], 403);
                    }
                    abort(403, 'Unauthorized access to this ticket.');
                }
            } else {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Unauthorized access to this ticket.'], 403);
                }
                abort(403, 'Unauthorized access to this ticket.');
            }
        }
        
        $validated = $request->validate([
            'comment' => 'required|string',
            'is_internal' => 'nullable|boolean',
            'attachment' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,pdf|max:10240', // 10MB max
        ]);
        
        // Check permission for internal comments
        if ($validated['is_internal'] && !auth()->user()->can('Tickets Management.create internal comment')) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized to create internal comments.'], 403);
            }
            abort(403, 'Unauthorized to create internal comments.');
        }
        
        // Customers can never post internal comments
        if ($user->hasRole('customer')) {
            $validated['is_internal'] = false;
        }
        
        // Handle file upload
        $attachmentPath = null;
        $attachmentType = null;
        $attachmentName = null;
        
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $attachmentPath = $file->store('tickets/attachments', 'public');
            $attachmentType = $file->getMimeType();
            $attachmentName = $file->getClientOriginalName();
        }
        
        $comment = $ticket->comments()->create([
            'user_id' => $user->id,
            'comment' => $validated['comment'],
            'is_internal' => $validated['is_internal'] ?? false,
            'attachment_path' => $attachmentPath,
            'attachment_type' => $attachmentType,
            'attachment_name' => $attachmentName,
        ]);
        
        if ($request->wantsJson() || $request->ajax()) {
            $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
            
            // Load the comment with user relationship
            $comment->load('user');
            
            $html = view('tickets.partials.comment', compact('comment', 'isAdmin'))->render();
            
            return response()->json([
                'success' => true,
                'message' => 'Comment added successfully',
                'html' => $html,
                'comment' => $comment
            ]);
        }
        
        return back()->with('success', 'Comment added successfully');
    }
    
    /**
     * Print ticket details
     */
    public function print(Ticket $ticket)
    {
        // Check permission
        if (!auth()->user()->can('Tickets Management.print ticket') && 
            !auth()->user()->can('Tickets Management.view ticket')) {
            abort(403, 'Unauthorized to print tickets.');
        }
        
        $user = auth()->user();
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
        
        // Check access for non-admin users
        if (!$isAdmin) {
            if ($user->hasRole('customer') && $user->company_id) {
                $company = $user->company;
                $canView = false;
                
                if ($company && $ticket->company == $company->company_name) {
                    $canView = true;
                }
                
                if ($ticket->customer == $user->name || $ticket->opened_by == $user->id) {
                    $canView = true;
                }
                
                if (!$canView) {
                    abort(403, 'Unauthorized access to this ticket.');
                }
            } elseif ($user->hasRole('employee') || $user->hasRole('Employee')) {
                $employee = \App\Models\Employee::where('user_id', $user->id)->first();
                if (!$employee || $ticket->assigned_to != $employee->id) {
                    abort(403, 'Unauthorized access to this ticket.');
                }
            } else {
                abort(403, 'Unauthorized access to this ticket.');
            }
        }
        
        // Load relationships
        $ticket->load([
            'comments.user',
            'assignedEmployee',
            'opener',
            'completedBy',
            'confirmedBy',
            'closedBy',
            'company',
            'project'
        ]);
        
        return view('tickets.print', compact('ticket'));
    }
}
