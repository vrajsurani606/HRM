<?php
namespace App\Http\Controllers\Receipt;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class ReceiptController extends Controller
{
    public function index(){ return view('receipts.index'); }
    public function create(){ return view('receipts.create'); }
    public function store(Request $r){ return back()->with('success','Receipt saved'); }
    public function show($id){ return view('section',['name'=>'receipt-show']); }
    public function edit($id){ return view('section',['name'=>'receipt-edit']); }
    public function update(Request $r,$id){ return back()->with('success','Receipt updated'); }
    public function destroy($id){ return back()->with('success','Receipt deleted'); }
}
