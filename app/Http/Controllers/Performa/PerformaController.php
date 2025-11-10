<?php
namespace App\Http\Controllers\Performa;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PerformaController extends Controller
{
    public function index(): View
    {
        return view('performas.index');
    }

    public function create(): View
    {
        return view('performas.create');
    }

    public function store(Request $request): RedirectResponse
    {
        return back()->with('success', 'Performa saved');
    }

    public function show(int $id): View
    {
        return view('performas.show', compact('id'));
    }

    public function edit(int $id): View
    {
        return view('performas.edit', compact('id'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        return back()->with('success', 'Performa updated');
    }

    public function destroy(int $id): RedirectResponse
    {
        return back()->with('success', 'Performa deleted');
    }
}
