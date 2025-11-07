<?php
namespace App\Http\Controllers\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class EventController extends Controller
{
    public function index(){ return view('section',['name'=>'events']); }
    public function create(){ return view('section',['name'=>'event-create']); }
    public function store(Request $r){ return back()->with('success','Event saved'); }
    public function show($id){ return view('section',['name'=>'event-show']); }
    public function edit($id){ return view('section',['name'=>'event-edit']); }
    public function update(Request $r,$id){ return back()->with('success','Event updated'); }
    public function destroy($id){ return back()->with('success','Event deleted'); }
}
