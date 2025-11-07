<?php
namespace App\Http\Controllers\HR;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HiringController extends Controller
{
    public function index(){ return view('hr.hiring.index', ['page_title'=>'Hiring Lead List']); }
    public function create(){ return view('hr.hiring.create', ['page_title'=>'Add New Hiring Lead']); }
    public function store(Request $r){ return redirect()->route('hiring.index')->with('success','Saved'); }
    public function show($id){ return view('hr.hiring.show',['page_title'=>'Hiring Lead']); }
    public function edit($id){ return view('hr.hiring.edit',['page_title'=>'Edit Hiring Lead']); }
    public function update(Request $r,$id){ return back()->with('success','Updated'); }
    public function destroy($id){ return back()->with('success','Deleted'); }
}
