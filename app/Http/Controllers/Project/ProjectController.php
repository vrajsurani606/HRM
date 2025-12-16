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
    public function index(): View|RedirectResponse
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
                })->with(['company', 'members']);
            }])->orderBy('order')->get();
        } elseif (($user->hasRole('customer') || $user->hasRole('client') || $user->hasRole('company')) && $user->company_id) {
            // Customers/clients only see their company's projects
            $stages = ProjectStage::with(['projects' => function($query) use ($user) {
                $query->where('company_id', $user->company_id)->with(['company', 'members']);
            }])->orderBy('order')->get();
        } else {
            // Admin/HR see all projects
            $stages = ProjectStage::with(['projects.company', 'projects.members'])->orderBy('order')->get();
        }
        
        // Get all projects for list/grid view (no pagination)
        $projectsQuery = Project::with(['company', 'stage', 'members']);
        
        if ($user->hasRole('employee')) {
            $projectsQuery->whereHas('members', function($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        } elseif (($user->hasRole('customer') || $user->hasRole('client') || $user->hasRole('company')) && $user->company_id) {
            $projectsQuery->where('company_id', $user->company_id);
        }
        
        $projects = $projectsQuery->orderBy('created_at', 'desc')->get();
        
        $companies = \App\Models\Company::orderBy('company_name')->get();
        return view('projects.index', compact('stages', 'companies', 'projects'));
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

    public function create(): View|RedirectResponse
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
        if (!auth()->check()) {
            return redirect()->back()->with('error', 'Unauthorized.');
        }
        
        try {
            \Log::info('Project show method called', ['id' => $id, 'is_ajax' => request()->ajax()]);
            
            $user = auth()->user();
            
            // First, check if user has general permission or is admin
            $hasGeneralPermission = $user->hasRole('super-admin') || $user->can('Projects Management.view project');
            
            // Check if user is a member of this specific project
            $project = Project::with(['company', 'stage'])->find($id);
            
            if (!$project) {
                throw new \Exception('Project not found');
            }
            
            $isMember = $project->members()->where('users.id', $user->id)->exists();
            $isCompanyProject = ($user->hasRole('customer') || $user->hasRole('client') || $user->hasRole('company')) 
                && $user->company_id && $project->company_id == $user->company_id;
            
            // Allow access if: has permission, is member, or is company project
            if (!$hasGeneralPermission && !$isMember && !$isCompanyProject) {
                if (request()->ajax() || request()->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
                }
                return redirect()->back()->with('error', 'Permission denied.');
            }
            
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
        } elseif (($user->hasRole('customer') || $user->hasRole('client') || $user->hasRole('company')) && $user->company_id) {
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
        
        // Convert empty strings to null for optional date fields
        $data = $request->all();
        
        // Handle due_date - convert empty/null to null, otherwise try to parse
        if (!isset($data['due_date']) || $data['due_date'] === null || $data['due_date'] === '' || $data['due_date'] === 'null') {
            $data['due_date'] = null;
        }
        
        // Handle due_time - convert empty/null to null
        if (!isset($data['due_time']) || $data['due_time'] === null || $data['due_time'] === '' || $data['due_time'] === 'null') {
            $data['due_time'] = null;
        }
        
        $validated = validator($data, [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:employees,id',
            'parent_id' => 'nullable|exists:project_tasks,id',
            'due_date' => 'nullable',
            'due_time' => 'nullable',
        ])->validate();
        
        // Parse and validate date if provided
        if (!empty($validated['due_date'])) {
            $dateValue = $validated['due_date'];
            $parsedDate = null;
            
            // Try different date formats
            // Format: dd/mm/yyyy or dd/mm/yy (jQuery datepicker format)
            if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{2,4})$/', $dateValue, $matches)) {
                $day = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
                $month = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
                $year = $matches[3];
                if (strlen($year) == 2) {
                    $year = '20' . $year;
                }
                $parsedDate = "{$year}-{$month}-{$day}";
            }
            // Format: YYYY-MM-DD (HTML5 date input format)
            elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateValue)) {
                $parsedDate = $dateValue;
            }
            // Try Carbon as fallback
            else {
                try {
                    $parsedDate = \Carbon\Carbon::parse($dateValue)->format('Y-m-d');
                } catch (\Exception $e) {
                    $parsedDate = null;
                }
            }
            
            if (!$parsedDate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid date format. Use dd/mm/yyyy or yyyy-mm-dd',
                    'errors' => ['due_date' => ['The due date field must be a valid date (dd/mm/yyyy or yyyy-mm-dd).']]
                ], 422);
            }
            
            $validated['due_date'] = $parsedDate;
        }
        
        // Validate time format if provided
        if (!empty($validated['due_time']) && !preg_match('/^\d{2}:\d{2}$/', $validated['due_time'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid time format',
                'errors' => ['due_time' => ['The due time must be in HH:MM format.']]
            ], 422);
        }

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
            $user = auth()->user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Unauthorized.'], 401);
            }
            
            // Check if user is admin/super-admin OR has edit task permission
            $hasFullEditPermission = $user->hasRole('super-admin') || $user->can('Projects Management.edit task');
            
            // Check if user is a project member (can toggle completion)
            $isProjectMember = $project->members()->where('users.id', $user->id)->exists();
            
            // If only toggling completion, project members are allowed
            $isOnlyTogglingCompletion = $request->has('is_completed') && 
                count(array_filter($request->only(['title', 'description', 'assigned_to', 'due_date', 'due_time']), function($v) { return $v !== null; })) === 0;
            
            if (!$hasFullEditPermission && !($isProjectMember && $isOnlyTogglingCompletion)) {
                return response()->json(['success' => false, 'message' => 'Permission denied. You must be a project member to complete tasks.'], 403);
            }
            
            $task = $project->allTasks()->findOrFail($taskId);
            
            // Convert empty strings to null for optional date fields
            $data = $request->all();
            if (array_key_exists('due_date', $data) && (empty($data['due_date']) || $data['due_date'] === 'null')) {
                $data['due_date'] = null;
            }
            if (array_key_exists('due_time', $data) && (empty($data['due_time']) || $data['due_time'] === 'null')) {
                $data['due_time'] = null;
            }
            
            $validated = validator($data, [
                'title' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'assigned_to' => 'nullable|exists:employees,id',
                'due_date' => 'nullable',
                'due_time' => 'nullable',
                'is_completed' => 'sometimes|boolean',
            ])->validate();

            // Parse and validate date if provided
            if (!empty($validated['due_date'])) {
                $dateValue = $validated['due_date'];
                $parsedDate = null;
                
                // Try different date formats
                // Format: dd/mm/yyyy or dd/mm/yy (jQuery datepicker format)
                if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{2,4})$/', $dateValue, $matches)) {
                    $day = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
                    $month = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
                    $year = $matches[3];
                    if (strlen($year) == 2) {
                        $year = '20' . $year;
                    }
                    $parsedDate = "{$year}-{$month}-{$day}";
                }
                // Format: YYYY-MM-DD (HTML5 date input format)
                elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateValue)) {
                    $parsedDate = $dateValue;
                }
                // Try Carbon as fallback
                else {
                    try {
                        $parsedDate = \Carbon\Carbon::parse($dateValue)->format('Y-m-d');
                    } catch (\Exception $e) {
                        $parsedDate = null;
                    }
                }
                
                if (!$parsedDate) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid date format. Use dd/mm/yyyy or yyyy-mm-dd',
                        'errors' => ['due_date' => ['The due date field must be a valid date (dd/mm/yyyy or yyyy-mm-dd).']]
                    ], 422);
                }
                
                $validated['due_date'] = $parsedDate;
            }

            // Track who completed the task and when
            if (isset($validated['is_completed'])) {
                if ($validated['is_completed']) {
                    $validated['completed_by'] = auth()->id();
                    $validated['completed_at'] = now();
                } else {
                    $validated['completed_by'] = null;
                    $validated['completed_at'] = null;
                }
                
                // Cascade to subtasks: if this is a main task (no parent_id), update all subtasks
                if (!$task->parent_id) {
                    $subtasks = $project->allTasks()->where('parent_id', $task->id)->get();
                    foreach ($subtasks as $subtask) {
                        if ($validated['is_completed']) {
                            // Mark subtask as completed
                            $subtask->update([
                                'is_completed' => true,
                                'completed_by' => auth()->id(),
                                'completed_at' => now()
                            ]);
                        } else {
                            // Mark subtask as not completed
                            $subtask->update([
                                'is_completed' => false,
                                'completed_by' => null,
                                'completed_at' => null
                            ]);
                        }
                    }
                }
            }

            $task->update($validated);
            
            // Recalculate project task counts
            $this->updateProjectTaskCounts($project);

            return response()->json([
                'success' => true,
                'task' => $task->load(['assignedEmployee', 'completedByUser'])
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
        
        // All project members can see all tasks - no filtering by assigned_to
        $tasks = $project->tasks()->with(['subtasks.completedByUser.employee', 'assignedEmployee', 'completedByUser.employee'])->get();
        
        // Transform tasks to include photo_path for completed_by_user
        $tasks = $tasks->map(function($task) {
            if ($task->completedByUser) {
                $user = $task->completedByUser;
                $photoPath = null;
                
                // Try to get photo from employee relationship
                if ($user->employee && $user->employee->photo_path) {
                    $photoPath = storage_asset($user->employee->photo_path);
                }
                // Fallback: Try to find employee by matching user_id
                if (!$photoPath) {
                    $employeeByUserId = \App\Models\Employee::where('user_id', $user->id)->first();
                    if ($employeeByUserId && $employeeByUserId->photo_path) {
                        $photoPath = storage_asset($employeeByUserId->photo_path);
                    }
                }
                
                // Unset the relationship to prevent it from being serialized
                unset($task->completedByUser);
                
                $task->completed_by_user = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'chat_color' => $user->chat_color,
                    'photo_path' => $photoPath
                ];
            }
            // Add completed_at timestamp for main task
            $task->completed_at_formatted = $task->completed_at 
                ? $task->completed_at->format('Y-m-d H:i:s') 
                : ($task->is_completed && $task->updated_at ? $task->updated_at->format('Y-m-d H:i:s') : null);
            
            // Transform subtasks
            if ($task->subtasks) {
                $task->subtasks = $task->subtasks->map(function($subtask) {
                    if ($subtask->completedByUser) {
                        $user = $subtask->completedByUser;
                        $photoPath = null;
                        
                        // Try to get photo from employee relationship
                        if ($user->employee && $user->employee->photo_path) {
                            $photoPath = storage_asset($user->employee->photo_path);
                        }
                        // Fallback: Try to find employee by matching user_id
                        if (!$photoPath) {
                            $employeeByUserId = \App\Models\Employee::where('user_id', $user->id)->first();
                            if ($employeeByUserId && $employeeByUserId->photo_path) {
                                $photoPath = storage_asset($employeeByUserId->photo_path);
                            }
                        }
                        
                        // Unset the relationship to prevent it from being serialized
                        unset($subtask->completedByUser);
                        
                        $subtask->completed_by_user = [
                            'id' => $user->id,
                            'name' => $user->name,
                            'chat_color' => $user->chat_color,
                            'photo_path' => $photoPath
                        ];
                    }
                    // Add completed_at timestamp (use actual completed_at or fallback to updated_at)
                    $subtask->completed_at = $subtask->completed_at 
                        ? $subtask->completed_at->format('Y-m-d H:i:s') 
                        : ($subtask->is_completed && $subtask->updated_at ? $subtask->updated_at->format('Y-m-d H:i:s') : null);
                    return $subtask;
                });
            }
            
            return $task;
        });
        
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
        
        $comments = $project->comments()->with('user')->orderBy('created_at', 'asc')->get();
        
        // Add photo_path to each comment's user
        $comments = $comments->map(function($comment) {
            if ($comment->user) {
                $employee = \App\Models\Employee::where('user_id', $comment->user->id)->first();
                $comment->user->photo_path = $employee && $employee->photo_path ? storage_asset($employee->photo_path) : null;
            }
            return $comment;
        });
        
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

        $comment->load('user');
        
        // Add photo_path to user
        if ($comment->user) {
            $employee = \App\Models\Employee::where('user_id', $comment->user->id)->first();
            $comment->user->photo_path = $employee && $employee->photo_path ? storage_asset($employee->photo_path) : null;
        }

        return response()->json([
            'success' => true,
            'comment' => $comment
        ]);
    }

    // Poll for new comments (real-time chat)
    public function pollComments(Request $request, Project $project)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 401);
        }
        
        $user = auth()->user();
        $lastId = $request->query('last_id', 0);
        
        // Check if user is admin/super-admin OR a member of this project
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('admin') || $user->hasRole('hr');
        $isMember = $project->members()->where('users.id', $user->id)->exists();
        
        if (!$isAdmin && !$isMember) {
            return response()->json(['success' => false, 'message' => 'Access denied.'], 403);
        }
        
        // Get only new comments after lastId
        $comments = $project->comments()
            ->with('user')
            ->where('id', '>', $lastId)
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Add photo_path to each comment's user
        $comments = $comments->map(function($comment) {
            if ($comment->user) {
                $employee = \App\Models\Employee::where('user_id', $comment->user->id)->first();
                $comment->user->photo_path = $employee && $employee->photo_path ? storage_asset($employee->photo_path) : null;
            }
            return $comment;
        });
        
        return response()->json([
            'success' => true,
            'comments' => $comments
        ]);
    }
    
    // Typing status management (stored in cache)
    public function getTypingStatus(Project $project)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false], 401);
        }
        
        $cacheKey = "project_{$project->id}_typing";
        $typingUsers = cache()->get($cacheKey, []);
        
        // Filter out expired typing statuses (older than 3 seconds)
        $now = now()->timestamp;
        $activeTyping = array_filter($typingUsers, function($data) use ($now) {
            return ($now - $data['timestamp']) < 3;
        });
        
        // Update cache with only active users
        if (count($activeTyping) !== count($typingUsers)) {
            cache()->put($cacheKey, $activeTyping, 60);
        }
        
        return response()->json([
            'success' => true,
            'typing_users' => array_values(array_map(function($data) {
                return ['id' => $data['id'], 'name' => $data['name']];
            }, $activeTyping))
        ]);
    }
    
    public function setTypingStatus(Request $request, Project $project)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false], 401);
        }
        
        $user = auth()->user();
        $isTyping = $request->input('is_typing', false);
        
        $cacheKey = "project_{$project->id}_typing";
        $typingUsers = cache()->get($cacheKey, []);
        
        if ($isTyping) {
            $typingUsers[$user->id] = [
                'id' => $user->id,
                'name' => $user->name,
                'timestamp' => now()->timestamp
            ];
        } else {
            unset($typingUsers[$user->id]);
        }
        
        cache()->put($cacheKey, $typingUsers, 60);
        
        return response()->json(['success' => true]);
    }

    // Member Management Methods
    public function getMembers(Project $project)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 401);
        }
        
        $user = auth()->user();
        
        // Allow access if user is admin/super-admin, has permission, OR is a member of this project
        $isAdmin = $user->hasRole('super-admin') || $user->hasRole('admin') || $user->hasRole('hr');
        $hasPermission = $user->can('Projects Management.view members');
        $isMember = $project->members()->where('users.id', $user->id)->exists();
        
        if (!$isAdmin && !$hasPermission && !$isMember) {
            return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
        }
        
        // Get members with their employee data and chat_color
        $members = $project->members()->get()->map(function($user) {
            $employee = \App\Models\Employee::where('user_id', $user->id)->first();
            
            // Get photo path with full URL
            $photoPath = null;
            if ($employee && $employee->photo_path) {
                $photoPath = storage_asset($employee->photo_path);
            }
            
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'chat_color' => $user->chat_color,
                'pivot' => $user->pivot,
                'photo_path' => $photoPath, // Full URL for direct use
                'employee' => $employee ? [
                    'id' => $employee->id,
                    'code' => $employee->code,
                    'position' => $employee->position,
                    'photo_path' => $photoPath, // Full URL
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
            
            // Filter and format employees with chat_color
            $availableEmployees = $employees->filter(function($employee) use ($existingMemberUserIds) {
                // Only include employees with user_id and not already in project
                return $employee->user_id && !in_array($employee->user_id, $existingMemberUserIds);
            })->map(function($employee) {
                $user = $employee->user;
                return [
                    'id' => $employee->user_id,
                    'employee_id' => $employee->id,
                    'name' => $employee->name,
                    'email' => $employee->email ?? '',
                    'position' => $employee->position ?? '',
                    'photo_path' => $employee->photo_path ?? '',
                    'code' => $employee->code ?? '',
                    'chat_color' => $user ? $user->chat_color : null,
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
