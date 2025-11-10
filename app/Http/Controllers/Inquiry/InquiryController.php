<?php
namespace App\Http\Controllers\Inquiry;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InquiryController extends Controller
{
    public function index(): View
    {
        return view('inquiries.index');
    }

    public function create(): View
    {
        return view('inquiries.create');
    }

    public function store(Request $request): RedirectResponse
    {
        return back()->with('status', 'Inquiry saved');
    }

    public function show(int $id): View
    {
        return view('inquiries.show', compact('id'));
    }

    public function edit(int $id): View
    {
        return view('inquiries.edit', compact('id'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        return back()->with('status', 'Inquiry updated');
    }

    public function destroy(int $id): RedirectResponse
    {
        return back()->with('status', 'Inquiry deleted');
    }
}
