<?php
namespace App\Http\Controllers\Performa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class PerformaController extends Controller
{
    public function index(){ return view('section',['name'=>'performas']); }
    public function create(){ return view('section',['name'=>'performa-create']); }
    public function store(Request $r){ return back()->with('success','Performa saved'); }
    public function show($id){ return view('section',['name'=>'performa-show']); }
    public function edit($id){ return view('section',['name'=>'performa-edit']); }
    public function update(Request $r,$id){ return back()->with('success','Performa updated'); }
    public function destroy($id){ return back()->with('success','Performa deleted'); }
}
