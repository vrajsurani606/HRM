<?php
namespace App\Http\Controllers\Quotation;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuotationController extends Controller
{
    public function index(): View
    {
        return view('quotations.index');
    }

    public function create(): View
    {
        return view('quotations.create');
    }

    public function store(Request $request): RedirectResponse
    {
        return back()->with('success', 'Quotation saved');
    }

    public function show(int $id): View
    {
        return view('quotations.show', compact('id'));
    }

    public function edit(int $id): View
    {
        return view('quotations.edit', compact('id'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        return back()->with('success', 'Quotation updated');
    }

    public function destroy(int $id): RedirectResponse
    {
        return back()->with('success', 'Quotation deleted');
    }
}
