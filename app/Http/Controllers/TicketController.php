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
                    ->orWhere('description', 'like', "%{$q}%");
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
        
        if (!$isAdmin) {
            // Check access: customers can only view their company's tickets
            if ($user->hasRole('customer') && $user->company_id) {
                $company = $user->company;
                if ($company && $ticket->company != $company->company_name && $ticket->customer != ($company->name ?? $user->name)) {
                    abort(403, 'Unauthorized access to this ticket.');
                }
            } elseif ($user->hasRole('employee') || $user->hasRole('Employee')) {
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
        
        return view('tickets.show', compact('ticket'));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|in:low,normal,high,urgent',
            'status' => 'nullable|in:open,pending,in_progress,resolved,closed',
            'ticket_type' => 'nullable|string|max:100',
            'company' => 'nullable|string|max:255',
            'customer' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();
        
        // Auto-set company_id for customers
        if ($user->hasRole('customer') && $user->company_id) {
            $validated['company_id'] = $user->company_id;
        }

        $ticket = Ticket::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'ticket' => $ticket]);
        }

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully');
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
            'priority' => 'nullable|in:low,normal,high,urgent',
            'status' => 'nullable|in:open,pending,in_progress,resolved,closed',
            'ticket_type' => 'nullable|string|max:100',
            'company' => 'nullable|string|max:255',
            'customer' => 'nullable|string|max:255',
        ]);

        $ticket->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'ticket' => $ticket]);
        }

        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully');
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
}
