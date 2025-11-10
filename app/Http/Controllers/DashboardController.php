<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            'employees' => 126,
            'delta_employees' => '+3%',
            'projects' => 18,
            'delta_projects' => '+12%',
            'open_positions' => 6,
            'delta_open_positions' => '-2%',
            'attendance_percent' => '92%',
            'attendance_today' => 116,
        ];

        $notifications = [
            ['title' => 'New inquiry assigned', 'time' => '5m'],
            ['title' => 'Ticket updated', 'time' => '1h'],
            ['title' => 'Leave approved', 'time' => '2h'],
        ];

        $recentInquiries = [
            ['title' => 'Website revamp RFP', 'company' => 'Geo Research', 'date' => 'Nov 06', 'status' => 'New'],
            ['title' => 'Annual AMC', 'company' => 'Pure Dental', 'date' => 'Nov 05', 'status' => 'Open'],
            ['title' => 'Migration support', 'company' => 'Acme Corp', 'date' => 'Nov 04', 'status' => 'Open'],
            ['title' => 'Feature request', 'company' => 'Globex', 'date' => 'Nov 03', 'status' => 'New'],
            ['title' => 'Onboarding', 'company' => 'Initech', 'date' => 'Nov 02', 'status' => 'Open'],
            ['title' => 'Quarterly review', 'company' => 'Umbrella Inc', 'date' => 'Nov 01', 'status' => 'New'],
        ];

        $recentTickets = [
            ['title' => 'Payroll export failing', 'owner' => 'Support', 'date' => 'Nov 06', 'priority' => 'orange'],
            ['title' => 'App login issue', 'owner' => 'IT Desk', 'date' => 'Nov 05', 'priority' => 'blue'],
            ['title' => 'Email bounce', 'owner' => 'Ops', 'date' => 'Nov 05', 'priority' => 'blue'],
            ['title' => 'Report mismatch', 'owner' => 'QA', 'date' => 'Nov 04', 'priority' => 'orange'],
            ['title' => 'UI tweak request', 'owner' => 'PM', 'date' => 'Nov 03', 'priority' => 'green'],
            ['title' => 'Data sync lag', 'owner' => 'DevOps', 'date' => 'Nov 02', 'priority' => 'blue'],
        ];

        $users = [
            ['id'=>1,'name'=>'Ashif Khan (Telecaller)'],
            ['id'=>2,'name'=>'Dipesh Vasoya (Designer)'],
            ['id'=>3,'name'=>'Bhaktikumar Savaliya (Developer)'],
        ];

        $notes = [
            'notes' => [
                ['text' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s", 'date' => 'Oct 26, 2025 9:47 AM'],
                ['text' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s", 'date' => 'Oct 25, 2025 2:56 PM'],
            ],
            'emp' => [
                ['text' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s", 'date' => 'Aug 28, 2025', 'assignees' => [$users[0]['name'], $users[2]['name']]],
                ['text' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s", 'date' => 'Aug 28, 2025', 'assignees' => [$users[0]['name'], $users[2]['name']]],
            ],
        ];

        return view('dashboard', compact('stats','notifications','recentInquiries','recentTickets','users','notes'));
    }
}
