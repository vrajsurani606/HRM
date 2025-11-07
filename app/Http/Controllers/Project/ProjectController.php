<?php
namespace App\Http\Controllers\Project;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class ProjectController extends Controller
{
    public function index(){ return view('section',['name'=>'projects']); }
    public function create(){ return view('section',['name'=>'project-create']); }
    public function store(Request $r){ return back()->with('success','Project saved'); }
    public function show($id){ return view('section',['name'=>'project-show']); }
    public function edit($id){ return view('section',['name'=>'project-edit']); }
    public function update(Request $r,$id){ return back()->with('success','Project updated'); }
    public function destroy($id){ return back()->with('success','Project deleted'); }
}
