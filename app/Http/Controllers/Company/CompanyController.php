<?php
namespace App\Http\Controllers\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class CompanyController extends Controller
{
    public function index(){ return view('section',['name'=>'companies']); }
    public function create(){ return view('section',['name'=>'company-create']); }
    public function store(Request $r){ return back()->with('success','Company saved'); }
    public function show($id){ return view('section',['name'=>'company-show']); }
    public function edit($id){ return view('section',['name'=>'company-edit']); }
    public function update(Request $r,$id){ return back()->with('success','Company updated'); }
    public function destroy($id){ return back()->with('success','Company deleted'); }
}
