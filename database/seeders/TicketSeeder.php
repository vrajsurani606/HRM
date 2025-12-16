<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'ticket_no' => 'TCK-0001',
                'subject' => 'Closed',
                'status' => 'closed',
                'priority' => 'medium',
                'assigned_to' => null,
                'opened_by' => 'system',
                'opened_at' => now(),
                'category' => 'General Inquiry',
                'customer' => 'SHREEJI GEOTECH CONSULTANCY',
                'title' => 'Testing',
                'description' => 'Ok',
                'company' => 'Cresentmine Soft',
                'ticket_type' => 'Support',
            ],
            [
                'ticket_no' => 'TCK-0002',
                'subject' => 'Closed',
                'status' => 'closed',
                'priority' => 'low',
                'assigned_to' => null,
                'opened_by' => 'system',
                'opened_at' => now(),
                'category' => 'Billing',
                'customer' => 'SHREEJI GEOTECH CONSULTANCY',
                'title' => 'Test',
                'description' => 'Ok',
                'company' => 'Cresentmine Soft',
                'ticket_type' => 'Support',
            ],
            [
                'ticket_no' => 'TCK-0003',
                'subject' => 'Needs Approval',
                'status' => 'open',
                'priority' => 'high',
                'assigned_to' => null,
                'opened_by' => 'system',
                'opened_at' => now(),
                'category' => 'General Inquiry',
                'customer' => 'SHREEJI GEOTECH CONSULTANCY',
                'title' => 'Test',
                'description' => 'Ok',
                'company' => 'Cresentmine Soft',
                'ticket_type' => 'Support',
            ],
            [
                'ticket_no' => 'TCK-0004',
                'subject' => 'Needs Approval',
                'status' => 'open',
                'priority' => 'urgent',
                'assigned_to' => null,
                'opened_by' => 'system',
                'opened_at' => now(),
                'category' => 'General Inquiry',
                'customer' => 'SHREEJI GEOTECH CONSULTANCY',
                'title' => 'Test_123',
                'description' => 'Ok',
                'company' => 'Cresentmine Soft',
                'ticket_type' => 'Support',
            ],
        ];

        foreach ($rows as $row) {
            Ticket::updateOrCreate(['ticket_no' => $row['ticket_no']], $row);
        }
    }
}
