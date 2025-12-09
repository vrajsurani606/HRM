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
        $query = Ticket::query();

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
        $user = auth()->user();
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
        $isEmployee = $user->hasRole('employee') || $user->hasRole('Employee');
        
        if (!$isAdmin) {
            // Check access: customers can only view their company's tickets
            if ($user->hasRole('customer') && $user->company_id) {
                $company = $user->company;
                if ($company && $ticket->company != $company->company_name && $ticket->customer != ($company->name ?? $user->name)) {
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
        
        return view('tickets.show', compact('ticket', 'isAdmin', 'isEmployee'));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $isCustomer = $user->hasRole('customer');
        
        // Different validation rules for customers vs admins
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'status' => 'nullable|in:open,assigned,pending,needs_approval,in_progress,completed,resolved,closed',
            'work_status' => 'nullable|in:not_assigned,in_progress,on_hold,completed',
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
        
        // Return JSON for AJAX requests
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'ticket' => $ticket
            ]);
        }
        
        return view('tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
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

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'status' => 'nullable|in:open,assigned,pending,needs_approval,in_progress,completed,resolved,closed',
            'work_status' => 'nullable|in:not_assigned,in_progress,on_hold,completed',
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
            if (!isset($validated['work_status'])) {
                $validated['work_status'] = 'in_progress';
            }
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

        return redirect()->route('tickets.show', $ticket)->with('success', 'Ticket updated successfully');
    }

    public function destroy(Ticket $ticket): RedirectResponse|JsonResponse
    {
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
        $user = auth()->user();
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
        
        if (!$isAdmin) {
            abort(403, 'Only administrators can assign tickets.');
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
            'work_status' => 'completed',
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
        $user = auth()->user();
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
        
        if (!$isAdmin) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only administrators can confirm ticket resolution.'
                ], 403);
            }
            abort(403, 'Only administrators can confirm ticket resolution.');
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
            'confirmed_by' => $user->id,
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
        $user = auth()->user();
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
        
        if (!$isAdmin) {
            return response()->json([
                'success' => false,
                'message' => 'Only administrators can update completion data.'
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
        $user = auth()->user();
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
        
        if (!$isAdmin) {
            return response()->json([
                'success' => false,
                'message' => 'Only administrators can delete completion images.'
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
        
        // Only resolved tickets can be closed by customers
        if ($ticket->status !== Ticket::STATUS_RESOLVED) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only resolved tickets can be closed. Please wait for admin confirmation.'
                ], 400);
            }
            return back()->with('error', 'Only resolved tickets can be closed.');
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
     * Add comment to ticket
     */
    public function addComment(Request $request, Ticket $ticket)
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
        $isEmployee = $user->hasRole('employee') || $user->hasRole('Employee');
        
        // Check access
        if (!$isAdmin) {
            if ($user->hasRole('customer') && $user->company_id) {
                if ($ticket->company_id != $user->company_id) {
                    abort(403, 'Unauthorized access to this ticket.');
                }
            } elseif ($isEmployee) {
                $employee = \App\Models\Employee::where('user_id', $user->id)->first();
                if (!$employee || $ticket->assigned_to != $employee->id) {
                    abort(403, 'Unauthorized access to this ticket.');
                }
            } else {
                abort(403, 'Unauthorized access to this ticket.');
            }
        }
        
        $validated = $request->validate([
            'comment' => 'required|string',
            'is_internal' => 'nullable|boolean',
        ]);
        
        // Customers can never post internal comments
        if ($user->hasRole('customer')) {
            $validated['is_internal'] = false;
        }
        
        $comment = $ticket->comments()->create([
            'user_id' => $user->id,
            'comment' => $validated['comment'],
            'is_internal' => $validated['is_internal'] ?? false,
        ]);
        
        if ($request->wantsJson() || $request->ajax()) {
            $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
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
}
