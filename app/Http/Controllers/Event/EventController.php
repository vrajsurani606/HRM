<?php
namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        return view('events.index');
    }

    public function create(): View
    {
        return view('events.create');
    }

    public function store(Request $request): RedirectResponse
    {
        return back()->with('success', 'Event saved');
    }

    public function show(int $id): View
    {
        return view('events.show', compact('id'));
    }

    public function edit(int $id): View
    {
        return view('events.edit', compact('id'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        return back()->with('success', 'Event updated');
    }

    public function destroy(int $id): RedirectResponse
    {
        return back()->with('success', 'Event deleted');
    }
}
