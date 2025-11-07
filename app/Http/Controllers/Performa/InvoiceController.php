<?php
namespace App\Http\Controllers\Performa;
use App\Http\Controllers\Controller;
class InvoiceController extends Controller
{
    public function index(){ return view('section',['name'=>'invoices']); }
    public function show($id){ return view('section',['name'=>'invoice']); }
}
