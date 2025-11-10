<?php
namespace App\Http\Controllers\Attendance;
use App\Http\Controllers\Controller;
class AttendanceReportController extends Controller
{
    public function index(){
        return view('hr.attendance.report');
    }
}
