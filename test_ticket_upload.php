<?php
// Test file to check if ticket uploads are working
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Ticket Upload Test ===\n\n";

// Check latest tickets
$tickets = DB::table('tickets')
    ->orderBy('id', 'desc')
    ->limit(5)
    ->get(['id', 'title', 'attachment', 'attachments', 'created_at']);

echo "Latest 5 Tickets:\n";
foreach ($tickets as $ticket) {
    echo "ID: {$ticket->id}\n";
    echo "Title: {$ticket->title}\n";
    echo "Attachment: " . ($ticket->attachment ?? 'NULL') . "\n";
    echo "Attachments: " . ($ticket->attachments ?? 'NULL') . "\n";
    echo "Created: {$ticket->created_at}\n";
    echo "---\n";
}

// Check storage directory
echo "\n=== Storage Check ===\n";
$storagePath = storage_path('app/public/ticket_attachments');
echo "Storage path: $storagePath\n";
echo "Exists: " . (file_exists($storagePath) ? 'YES' : 'NO') . "\n";

if (file_exists($storagePath)) {
    $files = scandir($storagePath);
    $files = array_diff($files, ['.', '..']);
    echo "Files count: " . count($files) . "\n";
    echo "Files:\n";
    foreach (array_slice($files, 0, 10) as $file) {
        echo "  - $file\n";
    }
}

// Check public storage link
echo "\n=== Public Storage Link ===\n";
$publicStorage = public_path('storage');
echo "Public storage path: $publicStorage\n";
echo "Exists: " . (file_exists($publicStorage) ? 'YES' : 'NO') . "\n";
echo "Is link: " . (is_link($publicStorage) ? 'YES' : 'NO') . "\n";

if (is_link($publicStorage)) {
    echo "Target: " . readlink($publicStorage) . "\n";
}
