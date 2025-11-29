<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\ProjectStage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ProjectStageController extends Controller
{
    public function index(): View
    {
        $stages = ProjectStage::withCount('projects')->orderBy('order')->get();
        return view('projects.stages.index', compact('stages'));
    }

    public function show(ProjectStage $stage): JsonResponse
    {
        return response()->json([
            'success' => true,
            'stage' => $stage
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:project_stages,name',
            'color' => 'required|string|size:7',
            'description' => 'nullable|string|max:500'
        ]);

        $stage = ProjectStage::create([
            'name' => $validated['name'],
            'color' => $validated['color'],
            'description' => $validated['description'] ?? null,
            'order' => ProjectStage::max('order') + 1
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Stage created successfully',
            'stage' => $stage
        ]);
    }

    public function update(Request $request, ProjectStage $stage): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:project_stages,name,' . $stage->id,
            'color' => 'required|string|size:7',
            'description' => 'nullable|string|max:500'
        ]);

        $stage->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Stage updated successfully',
            'stage' => $stage
        ]);
    }

    public function destroy(ProjectStage $stage): JsonResponse
    {
        // Check if stage has projects
        if ($stage->projects()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete stage with existing projects. Please move or delete projects first.'
            ], 422);
        }

        $stage->delete();

        return response()->json([
            'success' => true,
            'message' => 'Stage deleted successfully'
        ]);
    }

    public function updateOrder(Request $request): JsonResponse
    {
        try {
            \Log::info('Update order request received', ['data' => $request->all()]);
            
            $validated = $request->validate([
                'stages' => 'required|array',
                'stages.*.id' => 'required|exists:project_stages,id',
                'stages.*.order' => 'required|integer|min:0'
            ]);

            \Log::info('Validation passed', ['validated' => $validated]);

            foreach ($validated['stages'] as $stageData) {
                $updated = ProjectStage::where('id', $stageData['id'])
                    ->update(['order' => $stageData['order']]);
                \Log::info('Updated stage', ['id' => $stageData['id'], 'order' => $stageData['order'], 'updated' => $updated]);
            }

            \Log::info('Stage order updated successfully');

            return response()->json([
                'success' => true,
                'message' => 'Stage order updated successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to update stage order', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update stage order: ' . $e->getMessage()
            ], 500);
        }
    }
}
