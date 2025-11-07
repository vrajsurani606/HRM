<?php
namespace App\Http\Controllers\Inquiry;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(){ return view('section', ['name' => 'inquiries']); }
    public function create(){ return view('inquiries.create'); }
    public function store(Request $r){ return back()->with('status','Inquiry saved'); }
    public function show($id){ return view('section', ['name' => 'inquiry-show']); }
    public function edit($id){ return view('section', ['name' => 'inquiry-edit']); }
    public function update(Request $r,$id){ return back()->with('status','Inquiry updated'); }
    public function destroy($id){ return back()->with('status','Inquiry deleted'); }
}
