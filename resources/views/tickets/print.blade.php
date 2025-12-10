<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket #{{ $ticket->ticket_no }} - Print</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .ticket-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        .info-group {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
        .value {
            margin-top: 5px;
        }
        .description {
            margin: 20px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border-left: 4px solid #007bff;
        }
        .comments {
            margin-top: 30px;
        }
        .comment {
            border: 1px solid #ddd;
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 5px;
        }
        .comment-header {
            font-weight: bold;
            margin-bottom: 10px;
            color: #555;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-open { background-color: #ffc107; color: #000; }
        .status-assigned { background-color: #17a2b8; color: #fff; }
        .status-in_progress { background-color: #007bff; color: #fff; }
        .status-completed { background-color: #28a745; color: #fff; }
        .status-resolved { background-color: #6f42c1; color: #fff; }
        .status-closed { background-color: #6c757d; color: #fff; }
        
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Support Ticket</h1>
        <h2>Ticket #{{ $ticket->ticket_no }}</h2>
    </div>

    <div class="ticket-info">
        <div>
            <div class="info-group">
                <div class="label">Title:</div>
                <div class="value">{{ $ticket->title }}</div>
            </div>
            
            <div class="info-group">
                <div class="label">Customer:</div>
                <div class="value">{{ $ticket->customer }}</div>
            </div>
            
            <div class="info-group">
                <div class="label">Company:</div>
                <div class="value">{{ $ticket->company ?? 'N/A' }}</div>
            </div>
            
            <div class="info-group">
                <div class="label">Category:</div>
                <div class="value">{{ $ticket->category ?? 'N/A' }}</div>
            </div>
        </div>
        
        <div>
            <div class="info-group">
                <div class="label">Status:</div>
                <div class="value">
                    <span class="status-badge status-{{ $ticket->status }}">{{ ucfirst(str_replace('_', ' ', $ticket->status)) }}</span>
                </div>
            </div>
            
            <div class="info-group">
                <div class="label">Priority:</div>
                <div class="value">{{ ucfirst($ticket->priority) }}</div>
            </div>
            
            <div class="info-group">
                <div class="label">Assigned To:</div>
                <div class="value">{{ $ticket->assignedEmployee->name ?? 'Unassigned' }}</div>
            </div>
            
            <div class="info-group">
                <div class="label">Created:</div>
                <div class="value">{{ $ticket->created_at->format('M d, Y H:i') }}</div>
            </div>
        </div>
    </div>

    <div class="description">
        <div class="label">Description:</div>
        <div class="value">{{ $ticket->description }}</div>
    </div>

    @if($ticket->resolution_notes)
    <div class="description">
        <div class="label">Resolution Notes:</div>
        <div class="value">{{ $ticket->resolution_notes }}</div>
    </div>
    @endif

    @if($ticket->comments->count() > 0)
    <div class="comments">
        <h3>Comments</h3>
        @foreach($ticket->comments as $comment)
            @if(!$comment->is_internal || auth()->user()->can('Tickets Management.view internal comments'))
            <div class="comment">
                <div class="comment-header">
                    {{ $comment->user->name }} - {{ $comment->created_at->format('M d, Y H:i') }}
                    @if($comment->is_internal)
                        <span style="color: #dc3545; font-size: 11px;">(Internal)</span>
                    @endif
                </div>
                <div>{{ $comment->comment }}</div>
            </div>
            @endif
        @endforeach
    </div>
    @endif

    <div class="no-print" style="margin-top: 30px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">Print Ticket</button>
        <button onclick="window.close()" style="padding: 10px 20px; background-color: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">Close</button>
    </div>
</body>
</html>