<?php
namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function index(): View
    {
        return view('companies.index');
    }

    public function create(): View
    {
        return view('companies.create');
    }

    public function store(Request $request): RedirectResponse
    {
        return back()->with('success', 'Company saved');
    }

    public function show(int $id): View
    {
        return view('companies.show', compact('id'));
    }

    public function edit(int $id): View
    {
        return view('companies.edit', compact('id'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        return back()->with('success', 'Company updated');
    }

    public function destroy(int $id): RedirectResponse
    {
        return back()->with('success', 'Company deleted');
    }
}
