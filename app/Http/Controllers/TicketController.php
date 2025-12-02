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

        // Filter by role: customers see only their company's tickets
        if ($user->hasRole('customer') && $user->company_id) {
            $query->where('company_id', $user->company_id);
        }
        
        // Filter by role: employees see only their assigned tickets
        if ($user->hasRole('employee')) {
            $query->where('assigned_to', $user->id);
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
        if ($user->hasRole('customer') && $user->company_id) {
            $companiesQuery->where('company_id', $user->company_id);
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
        
        // Check access: customers can only view their company's tickets, employees can only view assigned tickets
        if ($user->hasRole('customer') && $user->company_id) {
            if ($ticket->company_id != $user->company_id) {
                abort(403, 'Unauthorized access to this ticket.');
            }
        } elseif ($user->hasRole('employee')) {
            if ($ticket->assigned_to != $user->id) {
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
        
        // Check access
        if ($user->hasRole('customer') && $user->company_id) {
            if ($ticket->company_id != $user->company_id) {
                abort(403, 'Unauthorized access to this ticket.');
            }
        } elseif ($user->hasRole('employee')) {
            if ($ticket->assigned_to != $user->id) {
                abort(403, 'Unauthorized access to this ticket.');
            }
        }
        
        return view('tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $user = auth()->user();
        
        // Check access
        if ($user->hasRole('customer') && $user->company_id) {
            if ($ticket->company_id != $user->company_id) {
                abort(403, 'Unauthorized access to this ticket.');
            }
        } elseif ($user->hasRole('employee')) {
            if ($ticket->assigned_to != $user->id) {
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
        
        // Check access
        if ($user->hasRole('customer') && $user->company_id) {
            if ($ticket->company_id != $user->company_id) {
                abort(403, 'Unauthorized access to this ticket.');
            }
        } elseif ($user->hasRole('employee')) {
            if ($ticket->assigned_to != $user->id) {
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
