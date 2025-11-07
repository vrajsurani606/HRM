<?php
namespace App\Http\Controllers\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class RoleController extends Controller
{
    public function index(){ return view('section',['name'=>'roles']); }
    public function create(){ return view('section',['name'=>'role-create']); }
    public function store(Request $r){ return back()->with('success','Role saved'); }
    public function show($id){ return view('section',['name'=>'role-show']); }
    public function edit($id){ return view('section',['name'=>'role-edit']); }
    public function update(Request $r,$id){ return back()->with('success','Role updated'); }
    public function destroy($id){ return back()->with('success','Role deleted'); }
}
