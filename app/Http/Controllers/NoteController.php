<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\NoteReply;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NoteController extends Controller
{
    /**
     * Get all notes for admin dashboard
     */
    public function adminIndex(Request $request)
    {
        $query = Note::with(['creator', 'employees', 'replies.user'])
            ->where('created_by', auth()->id())
            ->orWhere('type', 'admin');

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority) {
            $query->where('priority', $request->priority);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('content', 'like', "%$search%");
            });
        }

        $notes = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'notes' => $notes->items(),
            'pagination' => [
                'total' => $notes->total(),
                'per_page' => $notes->perPage(),
                'current_page' => $notes->currentPage(),
                'last_page' => $notes->lastPage(),
            ]
        ]);
    }

    /**
     * Get notes for employee dashboard
     */
    public function employeeIndex(Request $request)
    {
        $employee = Employee::where('user_id', auth()->id())->first();

        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Employee record not found'
            ], 404);
        }

        $query = Note::with(['creator', 'employees', 'replies.user'])
            ->whereHas('employees', function ($q) use ($employee) {
                $q->where('employee_id', $employee->id);
            });

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority) {
            $query->where('priority', $request->priority);
        }

        // Filter unread
        if ($request->has('unread') && $request->unread) {
            $query->whereHas('employees', function ($q) use ($employee) {
                $q->where('employee_id', $employee->id)
                  ->whereNull('read_at');
            });
        }

        $notes = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        // Mark as read
        foreach ($notes as $note) {
            $note->markAsRead($employee->id);
        }

        return response()->json([
            'success' => true,
            'notes' => $notes->items(),
            'pagination' => [
                'total' => $notes->total(),
                'per_page' => $notes->perPage(),
                'current_page' => $notes->currentPage(),
                'last_page' => $notes->lastPage(),
            ]
        ]);
    }

    /**
     * Create a new note
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:pending,in_progress,completed,urgent',
            'type' => 'required|in:admin,employee,system',
            'due_date' => 'nullable|date|after:today',
            'employee_ids' => 'required|array|min:1',
            'employee_ids.*' => 'exists:employees,id',
        ]);

        try {
            $note = Note::create([
                'title' => $validated['title'],
                'content' => $validated['content'],
                'priority' => $validated['priority'],
                'status' => $validated['status'],
                'type' => $validated['type'],
                'due_date' => $validated['due_date'] ?? null,
                'created_by' => auth()->id(),
                'user_id' => null,
            ]);

            // Attach employees
            $note->employees()->attach($validated['employee_ids']);

            return response()->json([
                'success' => true,
                'message' => 'Note created successfully',
                'note' => $note->load(['creator', 'employees', 'replies.user'])
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create note: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single note with replies
     */
    public function show($id)
    {
        $note = Note::with(['creator', 'employees', 'replies.user'])->find($id);

        if (!$note) {
            return response()->json([
                'success' => false,
                'message' => 'Note not found'
            ], 404);
        }

        // Check authorization
        $employee = Employee::where('user_id', auth()->id())->first();
        $isCreator = $note->created_by === auth()->id();
        $isAssigned = $employee && $note->employees->contains($employee->id);

        if (!$isCreator && !$isAssigned && !auth()->user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'note' => $note
        ]);
    }

    /**
     * Update note
     */
    public function update(Request $request, $id)
    {
        $note = Note::find($id);

        if (!$note) {
            return response()->json([
                'success' => false,
                'message' => 'Note not found'
            ], 404);
        }

        // Only creator can update
        if ($note->created_by !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string|max:5000',
            'priority' => 'sometimes|in:low,medium,high,urgent',
            'status' => 'sometimes|in:pending,in_progress,completed,urgent',
            'due_date' => 'nullable|date|after:today',
            'employee_ids' => 'sometimes|array|min:1',
            'employee_ids.*' => 'exists:employees,id',
        ]);

        try {
            $note->update($validated);

            // Update employees if provided
            if (isset($validated['employee_ids'])) {
                $note->employees()->sync($validated['employee_ids']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Note updated successfully',
                'note' => $note->load(['creator', 'employees', 'replies.user'])
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update note: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete note
     */
    public function destroy($id)
    {
        $note = Note::find($id);

        if (!$note) {
            return response()->json([
                'success' => false,
                'message' => 'Note not found'
            ], 404);
        }

        // Only creator can delete
        if ($note->created_by !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        try {
            $note->delete();

            return response()->json([
                'success' => true,
                'message' => 'Note deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete note: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add reply to note
     */
    public function addReply(Request $request, $id)
    {
        $note = Note::find($id);

        if (!$note) {
            return response()->json([
                'success' => false,
                'message' => 'Note not found'
            ], 404);
        }

        $validated = $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        try {
            $employee = Employee::where('user_id', auth()->id())->first();
            $isAdmin = auth()->user()->hasRole('admin') || $note->created_by === auth()->id();

            $reply = NoteReply::create([
                'note_id' => $id,
                'user_id' => auth()->id(),
                'content' => $validated['content'],
                'is_admin_reply' => $isAdmin,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Reply added successfully',
                'reply' => $reply->load('user')
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add reply: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark note as acknowledged
     */
    public function acknowledge($id)
    {
        $note = Note::find($id);

        if (!$note) {
            return response()->json([
                'success' => false,
                'message' => 'Note not found'
            ], 404);
        }

        $employee = Employee::where('user_id', auth()->id())->first();

        if (!$employee || !$note->employees->contains($employee->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        try {
            $note->markAsAcknowledged($employee->id);

            return response()->json([
                'success' => true,
                'message' => 'Note acknowledged successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to acknowledge note: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get note statistics for admin
     */
    public function adminStats()
    {
        $stats = [
            'total' => Note::where('created_by', auth()->id())->count(),
            'pending' => Note::where('created_by', auth()->id())->where('status', 'pending')->count(),
            'in_progress' => Note::where('created_by', auth()->id())->where('status', 'in_progress')->count(),
            'completed' => Note::where('created_by', auth()->id())->where('status', 'completed')->count(),
            'urgent' => Note::where('created_by', auth()->id())->where('priority', 'urgent')->count(),
            'overdue' => Note::where('created_by', auth()->id())
                ->where('status', '!=', 'completed')
                ->where('due_date', '<', now())
                ->count(),
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * Get note statistics for employee
     */
    public function employeeStats()
    {
        $employee = Employee::where('user_id', auth()->id())->first();

        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Employee record not found'
            ], 404);
        }

        $stats = [
            'total' => $employee->notes()->count(),
            'unread' => $employee->notes()
                ->whereHas('employees', function ($q) use ($employee) {
                    $q->where('employee_id', $employee->id)
                      ->whereNull('read_at');
                })->count(),
            'pending' => $employee->notes()->where('status', 'pending')->count(),
            'in_progress' => $employee->notes()->where('status', 'in_progress')->count(),
            'completed' => $employee->notes()->where('status', 'completed')->count(),
            'urgent' => $employee->notes()->where('priority', 'urgent')->count(),
            'overdue' => $employee->notes()
                ->where('status', '!=', 'completed')
                ->where('due_date', '<', now())
                ->count(),
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }
}
