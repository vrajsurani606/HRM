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
        
        $query = Ticket::with('assignedEmployee');

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

        $companies = Ticket::whereNotNull('company')->distinct()->pluck('company');

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
        
        $ticket = Ticket::with('assignedEmployee')->findOrFail($id);
        return view('tickets.show', compact('ticket'));
    }

    public function edit($id)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.edit ticket'))) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
            }
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $ticket = Ticket::findOrFail($id);

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
        
        $ticket = Ticket::findOrFail($id);

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
