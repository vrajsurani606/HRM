<?php
namespace App\Http\Controllers\Performa;
use App\Http\Controllers\Controller;
class InvoiceController extends Controller
{
    public function index(){ return view('invoices.index'); }
    public function show($id){ return view('invoices.show', compact('id')); }
}
