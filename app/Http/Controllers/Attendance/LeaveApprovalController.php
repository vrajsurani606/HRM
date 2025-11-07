<?php
namespace App\Http\Controllers\Attendance;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class LeaveApprovalController extends Controller
{
    public function index(){ return view('section',['name'=>'leave-approval']); }
    public function update(Request $r, $id){ return back()->with('success','Leave updated'); }
}
