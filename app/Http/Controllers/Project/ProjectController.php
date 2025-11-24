<?php
namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectStage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $stages = ProjectStage::with(['projects.company'])->orderBy('order')->get();
        $companies = \App\Models\Company::orderBy('company_name')->get();
        return view('projects.index', compact('stages', 'companies'));
    }

    public function storeStage(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|size:7'
        ]);

        $stage = ProjectStage::create([
            'name' => $request->name,
            'color' => $request->color,
            'order' => ProjectStage::max('order') + 1
        ]);

        return response()->json($stage);
    }

    public function updateProjectStage(Request $request, Project $project): JsonResponse
    {
        $request->validate(['stage_id' => 'required|exists:project_stages,id']);
        
        $project->update(['stage_id' => $request->stage_id]);
        
        return response()->json(['success' => true]);
    }

    public function create(): View
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'company_id' => 'nullable|exists:companies,id',
            'stage_id' => 'required|exists:project_stages,id',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'priority' => 'nullable|in:low,medium,high',
            'status' => 'nullable|in:active,on_hold,completed,cancelled',
            'budget' => 'nullable|numeric|min:0',
        ]);

        $project = Project::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'project' => $project->load('company', 'stage')
            ]);
        }

        return back()->with('success', 'Project created successfully');
    }

    public function show($id)
    {
        try {
            \Log::info('Project show method called', ['id' => $id, 'is_ajax' => request()->ajax()]);
            
            $project = Project::with(['company', 'stage'])->findOrFail($id);
            
            \Log::info('Project found', ['project' => $project->toArray()]);
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'project' => $project
                ], 200);
            }
            
            return view('projects.show', compact('project'));
        } catch (\Exception $e) {
            \Log::error('Error loading project', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Project not found: ' . $e->getMessage()
                ], 404);
            }
            
            abort(404);
        }
    }

    public function edit(int $id): View
    {
        return view('projects.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        try {
            $project = Project::findOrFail($id);
            
            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'company_id' => 'nullable|exists:companies,id',
                'stage_id' => 'sometimes|exists:project_stages,id',
                'start_date' => 'nullable|date',
                'due_date' => 'nullable|date',
                'priority' => 'nullable|in:low,medium,high',
                'status' => 'nullable|in:active,on_hold,completed,cancelled',
                'budget' => 'nullable|numeric|min:0',
            ]);

            $project->update($validated);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'project' => $project->load('company', 'stage')
                ]);
            }

            return back()->with('success', 'Project updated successfully');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Failed to update project');
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        return back()->with('success', 'Project deleted');
    }

    // Task Management Methods
    public function storeTasks(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:project_tasks,id',
            'due_date' => 'nullable|date',
        ]);

        $task = $project->allTasks()->create([
            'title' => $validated['title'],
            'parent_id' => $validated['parent_id'] ?? null,
            'due_date' => $validated['due_date'] ?? null,
            'order' => $project->allTasks()->where('parent_id', $validated['parent_id'] ?? null)->max('order') + 1,
        ]);

        return response()->json([
            'success' => true,
            'task' => $task->load('subtasks')
        ]);
    }

    public function updateTask(Request $request, Project $project, $taskId)
    {
        $task = $project->allTasks()->findOrFail($taskId);
        
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'due_date' => 'nullable|date',
            'is_completed' => 'sometimes|boolean',
        ]);

        $task->update($validated);

        return response()->json([
            'success' => true,
            'task' => $task
        ]);
    }

    public function deleteTask(Project $project, $taskId)
    {
        $task = $project->allTasks()->findOrFail($taskId);
        $task->delete();

        return response()->json(['success' => true]);
    }

    public function getTasks(Project $project)
    {
        $tasks = $project->tasks()->with('subtasks')->get();
        
        return response()->json([
            'success' => true,
            'tasks' => $tasks
        ]);
    }

    // Comment Management Methods
    public function getComments(Project $project)
    {
        $comments = $project->comments;
        
        return response()->json([
            'success' => true,
            'comments' => $comments
        ]);
    }

    public function storeComment(Request $request, Project $project)
    {
        $validated = $request->validate([
            'message' => 'required|string'
        ]);

        $comment = $project->comments()->create([
            'user_id' => auth()->id(),
            'message' => $validated['message']
        ]);

        return response()->json([
            'success' => true,
            'comment' => $comment->load('user')
        ]);
    }

    // Member Management Methods
    public function getMembers(Project $project)
    {
        $members = $project->members()->get();
        
        return response()->json([
            'success' => true,
            'members' => $members
        ]);
    }

    public function getAvailableUsers(Project $project)
    {
        // Get all users except those already in the project
        $existingMemberIds = $project->members()->pluck('users.id');
        $availableUsers = \App\Models\User::whereNotIn('id', $existingMemberIds)
            ->orderBy('name')
            ->get(['id', 'name', 'email']);
        
        return response()->json([
            'success' => true,
            'users' => $availableUsers
        ]);
    }

    public function addMember(Request $request, Project $project)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'nullable|in:member,lead,viewer'
        ]);

        // Check if member already exists
        if ($project->members()->where('user_id', $validated['user_id'])->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'User is already a member of this project'
            ], 422);
        }

        $project->members()->attach($validated['user_id'], [
            'role' => $validated['role'] ?? 'member'
        ]);

        $member = \App\Models\User::find($validated['user_id']);

        return response()->json([
            'success' => true,
            'member' => $member,
            'message' => 'Member added successfully'
        ]);
    }

    public function removeMember(Project $project, $userId)
    {
        $project->members()->detach($userId);

        return response()->json([
            'success' => true,
            'message' => 'Member removed successfully'
        ]);
    }
}
