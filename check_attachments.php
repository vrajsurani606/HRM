<?php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Check ticket #6 specifically
$ticket = \App\Models\Ticket::find(6);
if ($ticket) {
    echo "Ticket #6: {$ticket->title}\n";
    echo "Comments Count: " . $ticket->comments->count() . "\n\n";
}

// Get the last 10 ticket comments with their attachments
$comments = \App\Models\TicketComment::latest()
    ->take(10)
    ->get(['id', 'ticket_id', 'comment', 'attachment_path', 'attachment_type', 'attachment_name', 'created_at']);

echo "Last 10 Ticket Comments:\n";
echo str_repeat("=", 80) . "\n\n";

foreach ($comments as $comment) {
    echo "ID: {$comment->id}\n";
    echo "Ticket ID: {$comment->ticket_id}\n";
    echo "Comment: " . substr($comment->comment, 0, 50) . "...\n";
    echo "Attachment Path: " . ($comment->attachment_path ?? 'NULL') . "\n";
    echo "Attachment Type: " . ($comment->attachment_type ?? 'NULL') . "\n";
    echo "Attachment Name: " . ($comment->attachment_name ?? 'NULL') . "\n";
    echo "Created: {$comment->created_at}\n";
    echo str_repeat("-", 80) . "\n";
}

// Check if storage directory exists
$storagePath = storage_path('app/public/tickets/attachments');
echo "\nStorage Path: $storagePath\n";
echo "Directory Exists: " . (is_dir($storagePath) ? 'YES' : 'NO') . "\n";

if (is_dir($storagePath)) {
    $files = scandir($storagePath);
    $files = array_diff($files, ['.', '..']);
    echo "Files in directory: " . count($files) . "\n";
    if (count($files) > 0) {
        echo "Files:\n";
        foreach ($files as $file) {
            echo "  - $file\n";
        }
    }
}
