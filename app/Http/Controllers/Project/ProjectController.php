<?php
namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        return view('projects.index');
    }

    public function create(): View
    {
        return view('projects.create');
    }

    public function store(Request $request): RedirectResponse
    {
        return back()->with('success', 'Project saved');
    }

    public function show(int $id): View
    {
        return view('projects.show', compact('id'));
    }

    public function edit(int $id): View
    {
        return view('projects.edit', compact('id'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        return back()->with('success', 'Project updated');
    }

    public function destroy(int $id): RedirectResponse
    {
        return back()->with('success', 'Project deleted');
    }
}
