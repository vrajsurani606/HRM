<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Project;
use App\Models\ProjectMaterial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectMaterialController extends Controller
{
    public function getMaterials(Project $project): JsonResponse
    {
        try {
            \Log::info('getMaterials called for project: ' . $project->id);
            
            $materials = Material::with(['reports' => function ($query) {
                $query->where('is_active', true)->orderBy('order');
            }])
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

            \Log::info('Materials loaded: ' . $materials->count());

            $selectedMaterials = $project->projectMaterials()
                ->with(['material', 'materialReport'])
                ->get()
                ->groupBy('material_id')
                ->map(function ($items) {
                    return $items->pluck('material_report_id')->filter()->toArray();
                });

            \Log::info('Selected materials: ' . $selectedMaterials->count());

            return response()->json([
                'success' => true,
                'materials' => $materials,
                'selected' => $selectedMaterials,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in getMaterials: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error loading materials: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateMaterials(Request $request, Project $project): JsonResponse
    {
        $validated = $request->validate([
            'materials' => 'required|array',
            'materials.*.material_id' => 'required|exists:materials,id',
            'materials.*.report_ids' => 'nullable|array',
            'materials.*.report_ids.*' => 'exists:material_reports,id',
        ]);

        // Delete existing materials for this project
        $project->projectMaterials()->delete();

        // Add new materials
        foreach ($validated['materials'] as $material) {
            if (empty($material['report_ids'])) {
                // Add material without specific report
                ProjectMaterial::create([
                    'project_id' => $project->id,
                    'material_id' => $material['material_id'],
                    'material_report_id' => null,
                ]);
            } else {
                // Add material with each selected report
                foreach ($material['report_ids'] as $reportId) {
                    ProjectMaterial::create([
                        'project_id' => $project->id,
                        'material_id' => $material['material_id'],
                        'material_report_id' => $reportId,
                    ]);
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Materials updated successfully',
        ]);
    }

    public function toggleCompletion(Request $request, Project $project, ProjectMaterial $projectMaterial): JsonResponse
    {
        $projectMaterial->update([
            'is_completed' => !$projectMaterial->is_completed,
        ]);

        return response()->json([
            'success' => true,
            'is_completed' => $projectMaterial->is_completed,
        ]);
    }
    
    public function addReport(Request $request, \App\Models\Material $material): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);
            
            $maxOrder = $material->reports()->max('order') ?? 0;
            
            $report = \App\Models\MaterialReport::create([
                'material_id' => $material->id,
                'name' => $validated['name'],
                'order' => $maxOrder + 1,
                'is_active' => true,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Report added successfully',
                'report' => $report,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error adding report: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error adding report: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    public function createTasksFromMaterials(Request $request, Project $project): JsonResponse
    {
        try {
            $validated = $request->validate([
                'tasks' => 'required|array',
                'tasks.*.material_id' => 'required|exists:materials,id',
                'tasks.*.material_name' => 'required|string',
                'tasks.*.report_ids' => 'required|array',
                'tasks.*.subtasks' => 'required|array',
            ]);
            
            $tasksCreated = 0;
            $subtasksCreated = 0;
            
            foreach ($validated['tasks'] as $taskData) {
                // Get the max order for tasks
                $maxOrder = $project->allTasks()->whereNull('parent_id')->max('order') ?? 0;
                
                // Create the main task (material)
                $task = $project->allTasks()->create([
                    'title' => $taskData['material_name'],
                    'parent_id' => null,
                    'order' => $maxOrder + 1,
                    'is_completed' => false,
                ]);
                
                $tasksCreated++;
                
                // Create subtasks (reports)
                foreach ($taskData['subtasks'] as $index => $subtaskName) {
                    $task->subtasks()->create([
                        'project_id' => $project->id,
                        'title' => $subtaskName,
                        'order' => $index + 1,
                        'is_completed' => false,
                    ]);
                    
                    $subtasksCreated++;
                }
            }
            
            // Update project task counts
            $this->updateProjectTaskCounts($project);
            
            return response()->json([
                'success' => true,
                'message' => 'Tasks created successfully',
                'tasks_created' => $tasksCreated,
                'subtasks_created' => $subtasksCreated,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error creating tasks from materials: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error creating tasks: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    private function updateProjectTaskCounts(Project $project)
    {
        $totalTasks = $project->allTasks()->count();
        $completedTasks = $project->allTasks()->where('is_completed', true)->count();
        
        $project->update([
            'total_tasks' => $totalTasks,
            'completed_tasks' => $completedTasks
        ]);
    }
}
