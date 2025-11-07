<?php
namespace App\Http\Controllers\Quotation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class QuotationController extends Controller
{
    public function index(){ return view('section',['name'=>'quotations']); }
    public function create(){ return view('section',['name'=>'quotation-create']); }
    public function store(Request $r){ return back()->with('success','Quotation saved'); }
    public function show($id){ return view('section',['name'=>'quotation-show']); }
    public function edit($id){ return view('section',['name'=>'quotation-edit']); }
    public function update(Request $r,$id){ return back()->with('success','Quotation updated'); }
    public function destroy($id){ return back()->with('success','Quotation deleted'); }
}
