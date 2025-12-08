<?php
namespace App\Http\Controllers\Ticket;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.view ticket'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $user = auth()->user();
        $query = Ticket::with('assignedEmployee');
        
        // Check user roles
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
        $isCustomer = $user->hasRole('customer') && $user->company_id;
        $isEmployee = $user->hasRole('employee') || $user->hasRole('Employee');
        
        // Get employee record for filtering
        $employeeRecord = null;
        if ($isEmployee) {
            $employeeRecord = \App\Models\Employee::where('user_id', $user->id)->first();
            if (!$employeeRecord) {
                $employeeRecord = \App\Models\Employee::where('email', $user->email)->first();
            }
        }
        
        // Apply role-based filtering
        if (!$isAdmin) {
            if ($isCustomer) {
                // Customers see only their company's tickets
                $company = $user->company;
                if ($company) {
                    $query->where(function($q) use ($company, $user) {
                        $q->where('company', $company->company_name)
                          ->orWhere('customer', $company->name ?? $user->name);
                    });
                }
            } elseif ($isEmployee && $employeeRecord) {
                // Employees see ONLY tickets assigned to them
                $query->where('assigned_to', $employeeRecord->id);
            } else {
                // Other roles - show nothing
                $query->whereRaw('1 = 0');
            }
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter by company
        if ($request->filled('company')) {
            $query->where('company', $request->company);
        }

        // Search
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('ticket_no', 'like', "%{$q}%")
                    ->orWhere('subject', 'like', "%{$q}%")
                    ->orWhere('customer', 'like', "%{$q}%")
                    ->orWhere('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $perPage = (int) $request->get('per_page', 25);
        $tickets = $query->orderByDesc('created_at')->paginate($perPage)->appends($request->query());

        // Filter companies list based on role
        $companiesQuery = Ticket::whereNotNull('company')->distinct();
        if (!$isAdmin) {
            if ($isCustomer) {
                $company = $user->company;
                if ($company) {
                    $companiesQuery->where(function($q) use ($company, $user) {
                        $q->where('company', $company->company_name)
                          ->orWhere('customer', $company->name ?? $user->name);
                    });
                }
            } elseif ($isEmployee && $employeeRecord) {
                $companiesQuery->where('assigned_to', $employeeRecord->id);
            } else {
                $companiesQuery->whereRaw('1 = 0');
            }
        }
        $companies = $companiesQuery->pluck('company');

        return view('tickets.index', [
            'tickets' => $tickets,
            'companies' => $companies,
        ]);
    }

    public function create()
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.create ticket'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.create ticket'))) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
            }
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'customer' => 'required|string|max:255',
            'status' => 'required|in:open,needs_approval,in_progress,resolved,closed',
            'work_status' => 'nullable|in:not_assigned,in_progress,completed,on_hold',
            'assigned_to' => 'nullable|exists:employees,id',
            'category' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
        ]);

        $ticket = Ticket::create([
            'ticket_no' => 'TKT-' . str_pad((Ticket::max('id') ?? 0) + 1, 5, '0', STR_PAD_LEFT),
            'title' => $request->title,
            'subject' => $request->title,
            'description' => $request->description,
            'customer' => $request->customer,
            'status' => $request->status,
            'work_status' => $request->work_status ?: 'not_assigned',
            'assigned_to' => $request->assigned_to,
            'category' => $request->category,
            'company' => $request->company,
            'opened_by' => auth()->id(),
            'opened_at' => now(),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Ticket created successfully!',
                'ticket' => $ticket
            ]);
        }

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully!');
    }

    public function show($id)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.view ticket'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $user = auth()->user();
        $ticket = Ticket::with(['assignedEmployee', 'comments.user'])->findOrFail($id);
        
        // Check access based on role
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
        $isEmployee = $user->hasRole('employee') || $user->hasRole('Employee');
        
        if (!$isAdmin) {
            if ($user->hasRole('customer') && $user->company_id) {
                $company = $user->company;
                if ($company && $ticket->company != $company->company_name && $ticket->customer != ($company->name ?? $user->name)) {
                    abort(403, 'Unauthorized access to this ticket.');
                }
            } elseif ($isEmployee) {
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

    public function addComment(Request $request, $id)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $user = auth()->user();
        $ticket = Ticket::findOrFail($id);
        
        // Check access
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
        
        if (!$isAdmin) {
            if ($user->hasRole('customer') && $user->company_id) {
                $company = $user->company;
                if ($company && $ticket->company != $company->company_name && $ticket->customer != ($company->name ?? $user->name)) {
                    return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
                }
            } elseif ($user->hasRole('employee') || $user->hasRole('Employee')) {
                $employee = \App\Models\Employee::where('user_id', $user->id)->first();
                if (!$employee) {
                    $employee = \App\Models\Employee::where('email', $user->email)->first();
                }
                if (!$employee || $ticket->assigned_to != $employee->id) {
                    return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
        }

        $request->validate([
            'comment' => 'required|string|max:5000',
            'is_internal' => 'nullable|boolean',
        ]);

        $isEmployee = $user->hasRole('employee') || $user->hasRole('Employee');
        
        // Customers can never post internal comments
        // Admins and Employees can post internal comments
        $canPostInternal = $isAdmin || $isEmployee;
        
        $comment = \App\Models\TicketComment::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'comment' => $request->comment,
            'is_internal' => $canPostInternal && $request->is_internal ? true : false,
        ]);

        $comment->load('user');

        return response()->json([
            'success' => true,
            'message' => 'Comment added successfully',
            'comment' => $comment,
            'html' => view('tickets.partials.comment', [
                'comment' => $comment, 
                'isAdmin' => $isAdmin,
                'isEmployee' => $isEmployee
            ])->render()
        ]);
    }

    public function edit($id)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.edit ticket'))) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
            }
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $user = auth()->user();
        $ticket = Ticket::findOrFail($id);
        
        // Check access based on role
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
        
        if (!$isAdmin) {
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

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'ticket' => $ticket
            ]);
        }

        return view('tickets.edit', compact('ticket'));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.edit ticket'))) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
            }
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $user = auth()->user();
        $ticket = Ticket::findOrFail($id);
        
        // Check access based on role
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
        
        if (!$isAdmin) {
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

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'customer' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|required|in:open,needs_approval,in_progress,resolved,closed',
            'work_status' => 'nullable|in:not_assigned,in_progress,completed,on_hold',
            'assigned_to' => 'nullable|exists:employees,id',
            'category' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
        ]);

        $ticket->update($request->only([
            'title', 'subject', 'description', 'customer', 'status', 
            'work_status', 'assigned_to', 'category', 'company'
        ]));

        // If title is updated, also update subject
        if ($request->has('title')) {
            $ticket->subject = $request->title;
            $ticket->save();
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Ticket updated successfully!',
                'ticket' => $ticket
            ]);
        }

        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully!');
    }

    public function destroy(Ticket $ticket, Request $request)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.delete ticket'))) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
            }
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $user = auth()->user();
        
        // Check access based on role
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
        
        if (!$isAdmin) {
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
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Ticket deleted successfully!'
            ]);
        }
        
        return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully!');
    }
}
