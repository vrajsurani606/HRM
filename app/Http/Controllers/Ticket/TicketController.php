<?php
namespace App\Http\Controllers\Ticket;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class TicketController extends Controller
{
    public function index(){ return view('tickets.index'); }
    public function create(){ return view('tickets.create'); }
    public function store(Request $r){ return back()->with('success','Ticket saved'); }
    public function show($id){ return view('section',['name'=>'ticket-show']); }
    public function edit($id){ return view('section',['name'=>'ticket-edit']); }
    public function update(Request $r,$id){ return back()->with('success','Ticket updated'); }
    public function destroy($id){ return back()->with('success','Ticket deleted'); }
}
