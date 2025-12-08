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
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Projects Management.view project'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $user = auth()->user();
        
        // Filter projects based on role
        if ($user->hasRole('employee')) {
            // Employees only see projects they're members of
            $stages = ProjectStage::with(['projects' => function($query) use ($user) {
                $query->whereHas('members', function($q) use ($user) {
                    $q->where('users.id', $user->id);
                })->with('company');
            }])->orderBy('order')->get();
        } elseif ($user->hasRole('customer') && $user->company_id) {
            // Customers only see their company's projects
            $stages = ProjectStage::with(['projects' => function($query) use ($user) {
                $query->where('company_id', $user->company_id)->with('company');
            }])->orderBy('order')->get();
        } else {
            // Admin/HR see all projects
            $stages = ProjectStage::with(['projects.company'])->orderBy('order')->get();
        }
        
        $companies = \App\Models\Company::orderBy('company_name')->get();
        return view('projects.index', compact('stages', 'companies'));
    }

    public function storeStage(Request $request): JsonResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Projects Management.create stage'))) {
            return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
        }
        
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
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Projects Management.edit stage'))) {
            return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
        }
        
        $request->validate(['stage_id' => 'required|exists:project_stages,id']);
        
        $project->update(['stage_id' => $request->stage_id]);
        
        return response()->json(['success' => true]);
    }

    public function create(): View
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Projects Management.create project'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        return view('projects.create');
    }

    public function store(Request $request)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Projects Management.create project'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
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
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Projects Management.view project'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        try {
            \Log::info('Project show method called', ['id' => $id, 'is_ajax' => request()->ajax()]);
            
            $user = auth()->user();
            $query = Project::with(['company', 'stage']);
            
            // Filter by role
            if ($user->hasRole('employee')) {
                $query->whereHas('members', function($q) use ($user) {
                    $q->where('users.id', $user->id);
                });
            } elseif ($user->hasRole('customer') && $user->company_id) {
                $query->where('company_id', $user->company_id);
            }
            
            $project = $query->findOrFail($id);
            
            \Log::info('Project found', ['project' => $project->toArray()]);
            
            if (request()->ajax() || request()->wantsJson()) {
                // Check if current user is a member of this project
                $isMember = $project->members()->where('users.id', $user->id)->exists();
                $isAdmin = $user->hasRole('super-admin') || $user->hasRole('admin') || $user->hasRole('hr');
                
                return response()->json([
                    'success' => true,
                    'project' => $project,
                    'is_member' => $isMember,
                    'is_admin' => $isAdmin,
                    'can_access_chat' => $isAdmin || $isMember
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

    public function overview($id)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Projects Management.project overview'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $user = auth()->user();
        $query = Project::with(['company', 'stage', 'tasks', 'members']);
        
        // Filter by role
        if ($user->hasRole('employee')) {
            $query->whereHas('members', function($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        } elseif ($user->hasRole('customer') && $user->company_id) {
            $query->where('company_id', $user->company_id);
        }
        
        $project = $query->findOrFail($id);
        return view('projects.overview', ['id' => $id]);
    }

    public function edit(int $id)
    {
        // Edit is handled via modal in index view
        return redirect()->route('projects.index');
    }

    public function update(Request $request, $id)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Projects Management.edit project'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
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

    public function destroy(int $id)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Projects Management.delete project'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        try {
            $project = Project::findOrFail($id);
            $project->delete();
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Project deleted successfully'
                ]);
            }
            
            return back()->with('success', 'Project deleted successfully');
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete project'
                ], 500);
            }
            
            return back()->with('error', 'Failed to delete project');
        }
    }

    // Task Management Methods
    public function storeTasks(Request $request, Project $project)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Projects Management.create task'))) {
            return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:employees,id',
            'parent_id' => 'nullable|exists:project_tasks,id',
            'due_date' => 'nullable|date',
            'due_time' => 'nullable|date_format:H:i',
        ]);

        $task = $project->allTasks()->create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'assigned_to' => $validated['assigned_to'] ?? null,
            'parent_id' => $validated['parent_id'] ?? null,
            'due_date' => $validated['due_date'] ?? null,
            'due_time' => $validated['due_time'] ?? null,
            'order' => $project->allTasks()->where('parent_id', $validated['parent_id'] ?? null)->max('order') + 1,
        ]);
        
        // Recalculate project task counts
        $this->updateProjectTaskCounts($project);

        return response()->json([
            'success' => true,
            'task' => $task->load('subtasks')
        ]);
    }

    public function updateTask(Request $request, Project $project, $taskId)
    {
        try {
            if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Projects Management.edit task'))) {
                return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
            }
            
            $task = $project->allTasks()->findOrFail($taskId);
            
            $validated = $request->validate([
                'title' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'assigned_to' => 'nullable|exists:employees,id',
                'due_date' => 'nullable|date',
                'due_time' => 'nullable|date_format:H:i',
                'is_completed' => 'sometimes|boolean',
            ]);

            $task->update($validated);
            
            // Recalculate project task counts
            $this->updateProjectTaskCounts($project);

            return response()->json([
                'success' => true,
                'task' => $task->load('assignedEmployee')
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Task update failed', [
                'error' => $e->getMessage(),
                'task_id' => $taskId,
                'project_id' => $project->id
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update task: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update project's total_tasks and completed_tasks counts
     */
    private function updateProjectTaskCounts(Project $project)
    {
        $totalTasks = $project->allTasks()->count();
        $completedTasks = $project->allTasks()->where('is_completed', true)->count();
        
        $project->update([
            'total_tasks' => $totalTasks,
            'completed_tasks' => $completedTasks
        ]);
    }

    public function deleteTask(Project $project, $taskId)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Projects Management.delete task'))) {
            return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
        }
        
        $task = $project->allTasks()->findOrFail($taskId);
        $task->delete();
        
        // Recalculate project task counts
        $this->updateProjectTaskCounts($project);

        return response()->json(['success' => true]);
    }

    public function getTasks(Project $project)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Projects Management.view tasks'))) {
            return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
        }
        
        $user = auth()->user();
        $query = $project->tasks()->with(['subtasks', 'assignedEmployee']);
        
        // If user is employee, show only tasks assigned to them
        if ($user->hasRole('employee') && $user->employee) {
            $query->where('assigned_to', $user->employee->id);
        }
        
        $tasks = $query->get();
        
        return response()->json([
            'success' => true,
            'tasks' => $tasks
        ]);
    }

    // Comment Management Methods
    public function getComments(Project $project)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 401);
        }
        
        $user = auth()->user();
        
        // Check if user is admin/super-admin OR a member of this project
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('admin') || $user->hasRole('hr');
        $isMember = $project->members()->where('users.id', $user->id)->exists();
        
        if (!$isAdmin && !$isMember) {
            return response()->json([
                'success' => false, 
                'message' => 'Access denied. Only project members can view comments.'
            ], 403);
        }
        
        $comments = $project->comments()->with('user')->orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'comments' => $comments
        ]);
    }

    public function storeComment(Request $request, Project $project)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 401);
        }
        
        $user = auth()->user();
        
        // Check if user is admin/super-admin OR a member of this project
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('admin') || $user->hasRole('hr');
        $isMember = $project->members()->where('users.id', $user->id)->exists();
        
        if (!$isAdmin && !$isMember) {
            return response()->json([
                'success' => false, 
                'message' => 'Access denied. Only project members can post comments.'
            ], 403);
        }
        
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
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Projects Management.view members'))) {
            return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
        }
        
        // Get members with their employee data
        $members = $project->members()->get()->map(function($user) {
            $employee = \App\Models\Employee::where('user_id', $user->id)->first();
            
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'pivot' => $user->pivot,
                'employee' => $employee ? [
                    'id' => $employee->id,
                    'code' => $employee->code,
                    'position' => $employee->position,
                    'photo_path' => $employee->photo_path,
                    'mobile_no' => $employee->mobile_no,
                ] : null
            ];
        });
        
        return response()->json([
            'success' => true,
            'members' => $members
        ]);
    }

    public function getAvailableUsers(Project $project)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Projects Management.view members'))) {
            return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
        }
        
        try {
            // Get all employees
            $employees = \App\Models\Employee::orderBy('name')->get();
            
            // Get existing project member user IDs
            $existingMemberUserIds = $project->members()->pluck('users.id')->toArray();
            
            // Filter and format employees
            $availableEmployees = $employees->filter(function($employee) use ($existingMemberUserIds) {
                // Only include employees with user_id and not already in project
                return $employee->user_id && !in_array($employee->user_id, $existingMemberUserIds);
            })->map(function($employee) {
                return [
                    'id' => $employee->user_id,
                    'employee_id' => $employee->id,
                    'name' => $employee->name,
                    'email' => $employee->email ?? '',
                    'position' => $employee->position ?? '',
                    'photo_path' => $employee->photo_path ?? '',
                    'code' => $employee->code ?? '',
                ];
            })->values();
            
            return response()->json([
                'success' => true,
                'users' => $availableEmployees
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in getAvailableUsers', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch employees',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function addMember(Request $request, Project $project)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Projects Management.add member'))) {
            return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
        }
        
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
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Projects Management.remove member'))) {
            return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
        }
        
        $project->members()->detach($userId);

        return response()->json([
            'success' => true,
            'message' => 'Member removed successfully'
        ]);
    }

    public function getEmployeesList()
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $employees = \App\Models\Employee::select('id', 'name', 'email')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'employees' => $employees
        ]);
    }
}
