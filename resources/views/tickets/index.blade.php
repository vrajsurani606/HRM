@extends('layouts.macos')
@section('page_title', 'Ticket Support')

@php
  // Define employee ID for JavaScript use
  $isEmployeeUser = auth()->user()->hasRole('employee') || auth()->user()->hasRole('Employee');
  $currentEmployeeId = null;
  if ($isEmployeeUser) {
    $emp = \App\Models\Employee::where('user_id', auth()->id())->first();
    $currentEmployeeId = $emp ? $emp->id : null;
  }
@endphp

@section('content')
<div class="hrp-content">
  <!-- Filters -->
  <form method="GET" action="{{ route('tickets.index') }}" class="jv-filter" id="ticketFilters" data-no-loader="true">
    <select class="filter-pill" name="status">
      <option value="">All Status</option>
      <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
      <option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>Assigned</option>
      <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
      <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
      <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
      <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
    </select>

    <select class="filter-pill" name="priority">
      <option value="">All Priority</option>
      <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
      <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
      <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
      <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
    </select>

    <select class="filter-pill" name="company">
      <option value="">All Companies</option>
      @foreach($companies as $company)
        <option value="{{ $company }}" {{ request('company') == $company ? 'selected' : '' }}>{{ $company }}</option>
      @endforeach
    </select>

    <button type="submit" class="filter-search" aria-label="Search">
      <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
      </svg>
    </button>

    <a href="{{ route('tickets.index') }}" class="filter-search" aria-label="Reset" title="Reset Filters">
      <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
        <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
      </svg>
    </a>

    <div class="filter-right">
      <input 
        type="text" 
        name="q" 
        id="liveSearch" 
        class="filter-pill live-search" 
        placeholder="Search tickets, customer, status..." 
        value="{{ request('q') }}"
      >

      @if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.create ticket'))
        <button type="button" class="pill-btn pill-success" onclick="openAddTicketModal()" style="display: flex; align-items: center; gap: 8px;">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
              <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
            </svg>
            Add Ticket
          </button>
        @endif
    </div>
  </form>

  <!-- Data Table -->
  <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
    <table>
      <thead>
        <tr>
          <th style="width: 100px; text-align: center;">Action</th>
          <th style="width: 80px;">Sr. No.</th>
          <th style="width: 140px;">Ticket ID</th>
          <th style="width: 120px;">Status</th>
          @if(!auth()->user()->hasRole('customer'))
            <th style="width: 180px;">Assigned To</th>
          @endif
          <th style="width: 150px;">Category</th>
          @if(!auth()->user()->hasRole('customer'))
            <th style="width: 300px;">Customer</th>
          @endif
          <th style="width: 250px;">Title</th>
          <th style="width: 300px;">Description</th>
        </tr>
      </thead>
      <tbody>
        @forelse($tickets as $i => $ticket)
          <tr>
            <td style="text-align: center; padding: 14px; vertical-align: middle;">
              @php
                $isAdmin = auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('admin') || auth()->user()->hasRole('hr');
                $isEmployee = auth()->user()->hasRole('employee') || auth()->user()->hasRole('Employee');
                $isCustomer = auth()->user()->hasRole('customer');
                $employeeRecord = \App\Models\Employee::where('user_id', auth()->id())->first();
                $isAssignedEmployee = $employeeRecord && $ticket->assigned_to == $employeeRecord->id;
              @endphp
              
              <div style="display: flex; gap: 6px; align-items: center; justify-content: center; height: 100%;">
                <!-- View/Edit/Delete Actions -->
                @if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.view ticket'))
                  <img src="{{ asset('action_icon/view.svg') }}" alt="View" class="action-icon" onclick="viewTicket({{ $ticket->id }})" title="View" style="vertical-align: middle;">
                @endif
                @if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.edit ticket'))
                  @if($isCustomer && $ticket->status !== 'open')
                    <img src="{{ asset('action_icon/edit.svg') }}" alt="Edit" class="action-icon" style="opacity: 0.4; cursor: not-allowed; vertical-align: middle;" title="You can only edit tickets when they are in 'Open' status">
                  @else
                    <img src="{{ asset('action_icon/edit.svg') }}" alt="Edit" class="action-icon" onclick="editTicket({{ $ticket->id }})" title="Edit" style="vertical-align: middle;">
                  @endif
                @endif
                @if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.delete ticket'))
                  <img src="{{ asset('action_icon/delete.svg') }}" alt="Delete" class="action-icon" onclick="deleteTicket({{ $ticket->id }})" title="Delete" style="vertical-align: middle;">
                @endif
                
                <!-- Workflow Actions -->
                @if($isAdmin && $ticket->status === 'completed')
                  <!-- Admin: Confirm Completion -->
                  <img src="{{ asset('action_icon/approve.svg') }}" alt="Confirm" class="action-icon" onclick="confirmTicket({{ $ticket->id }})" title="Confirm Resolution" style="vertical-align: middle;">
                @elseif($isEmployee && $isAssignedEmployee && in_array($ticket->status, ['assigned', 'in_progress']))
                  <!-- Employee: Mark as Complete -->
                  <img src="{{ asset('action_icon/approve.svg') }}" alt="Complete" class="action-icon" onclick="completeTicket({{ $ticket->id }})" title="Mark as Complete" style="vertical-align: middle;">
                @elseif($isCustomer && !in_array($ticket->status, ['completed', 'closed', 'resolved']))
                  <!-- Customer: Close Ticket -->
                  <img src="{{ asset('action_icon/reject.svg') }}" alt="Close" class="action-icon" onclick="closeTicketFromIndex({{ $ticket->id }})" title="Close Ticket" style="vertical-align: middle;">
                @endif
              </div>
            </td>
            <td style="padding: 14px 16px; text-align: center; font-weight: 600; color: #64748b; vertical-align: middle;">{{ ($tickets->currentPage()-1) * $tickets->perPage() + $i + 1 }}</td>
            <td style="padding: 14px 16px; vertical-align: middle;">
              @php
                $ticketStatusColors = [
                  'open' => '#3b82f6',
                  'assigned' => '#8b5cf6',
                  'in_progress' => '#f59e0b',
                  'completed' => '#22c55e',
                  'resolved' => '#10b981',
                  'closed' => '#6b7280',
                ];
              @endphp
              <div style="display: flex; align-items: center; gap: 8px;">
                <div style="width: 8px; height: 8px; border-radius: 50%; background: {{ $ticketStatusColors[$ticket->status] ?? '#6b7280' }};"></div>
                <span style="font-weight: 700; color: #0f172a; font-size: 14px;">{{ $ticket->ticket_no ?? 'TKT-'.$ticket->id }}</span>
              </div>
            </td>
            <td style="padding: 14px 16px; vertical-align: middle;">
              @php
                $statusColors = [
                  'open' => '#3b82f6',
                  'assigned' => '#8b5cf6',
                  'in_progress' => '#f59e0b',
                  'completed' => '#f97316',
                  'resolved' => '#10b981',
                  'closed' => '#6b7280',
                ];
                $statusBg = [
                  'open' => '#dbeafe',
                  'assigned' => '#ede9fe',
                  'in_progress' => '#fef3c7',
                  'completed' => '#ffedd5',
                  'resolved' => '#d1fae5',
                  'closed' => '#f3f4f6',
                ];
                // For customers, show "completed" as "in_progress" (they see resolved only when admin confirms)
                $displayStatus = $ticket->status;
                if (auth()->user()->hasRole('customer') && $displayStatus === 'completed') {
                    $displayStatus = 'in_progress';
                }
                
                $statusColor = $statusColors[$displayStatus] ?? '#6b7280';
                $statusBackground = $statusBg[$displayStatus] ?? '#f3f4f6';
                $statusText = match($displayStatus) {
                  'assigned' => 'Assigned',
                  'in_progress' => 'In Progress',
                  'completed' => 'Completed',
                  'resolved' => 'Resolved',
                  'closed' => 'Closed',
                  default => 'Open'
                };
              @endphp
              <span style="display: inline-block; padding: 6px 14px; background: {{ $statusBackground }}; border-radius: 20px; border: 2px solid {{ $statusColor }}; color: {{ $statusColor }}; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">{{ $statusText }}</span>
            </td>
            @if(!auth()->user()->hasRole('customer'))
            <td style="padding: 14px 16px; vertical-align: middle;">
              @if($ticket->assignedEmployee)
                <div style="display: flex; align-items: center; gap: 10px; white-space: nowrap;">
                  @if($ticket->assignedEmployee->photo_path)
                    <img src="{{ storage_asset($ticket->assignedEmployee->photo_path) }}" alt="{{ $ticket->assignedEmployee->name }}" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; flex-shrink: 0; border: 2px solid #e5e7eb;">
                  @else
                    <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #8b5cf6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 13px; flex-shrink: 0;">
                      {{ strtoupper(substr($ticket->assignedEmployee->name, 0, 1)) }}
                    </div>
                  @endif
                  <div style="display: inline-flex; align-items: center; gap: 8px; min-width: 0;">
                    <span style="color: #0f172a; font-size: 14px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $ticket->assignedEmployee->name }}</span>
                    @if(!auth()->user()->hasRole('customer') && (auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.reassign ticket')))
                      <button onclick="assignTicket({{ $ticket->id }})" style="background: #f8fafc; border: 1px solid #e2e8f0; cursor: pointer; padding: 4px 8px; border-radius: 6px; font-size: 11px; color: #64748b; font-weight: 600; transition: all 0.2s; display: inline-flex; align-items: center; gap: 4px; white-space: nowrap; flex-shrink: 0;" onmouseover="this.style.background='#f1f5f9'; this.style.borderColor='#cbd5e1'" onmouseout="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'" title="Reassign to another employee">
                        <svg width="11" height="11" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                        </svg>
                        <span>Reassign</span>
                      </button>
                    @endif
                  </div>
                </div>
              @else
                @if(!auth()->user()->hasRole('customer') && (auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.assign ticket')))
                  <button onclick="assignTicket({{ $ticket->id }})" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; cursor: pointer; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; transition: all 0.3s; box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3); white-space: nowrap;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(59, 130, 246, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(59, 130, 246, 0.3)'" title="Assign this ticket to an employee">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    <span>Assign Employee</span>
                  </button>
                @else
                  <span style="color: #9ca3af; font-size: 13px; font-style: italic;">Not assigned yet</span>
                @endif
              @endif
            </td>
            @endif
            <td style="padding: 14px 16px; vertical-align: middle;">{{ $ticket->category ?? 'General Inquiry' }}</td>
            @if(!auth()->user()->hasRole('customer'))
            <td style="padding: 14px 16px; vertical-align: middle;">{{ $ticket->customer ?? '-' }}</td>
            @endif
            <td style="padding: 14px 16px; vertical-align: middle;">{{ $ticket->title ?? $ticket->subject ?? '-' }}</td>
            <td style="padding: 14px 16px; vertical-align: middle;">{{ Str::limit($ticket->description ?? 'Ok', 50) }}</td>
          </tr>
        @empty
            <x-empty-state 
                colspan="9" 
                title="No tickets found" 
                message="Try adjusting your filters or create a new ticket"
            />
        @endforelse
      </tbody>
    </table>
  </div>

</div>

<!-- Add/Edit Ticket Modal -->
<div id="ticketModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; padding-bottom: 80px;">
  <div style="background: white; border-radius: 15px; padding: 30px; max-width: 600px; width: 90%; max-height: calc(100vh - 120px); overflow-y: auto; box-shadow: 0 10px 40px rgba(0,0,0,0.3); margin: auto;">
    <h3 id="modalTitle" style="margin: 0 0 20px 0; font-size: 22px; font-weight: 700;">Add Ticket</h3>
    
    <form id="ticketForm" onsubmit="submitTicket(event)" enctype="multipart/form-data">
      <input type="hidden" name="ticket_id" id="ticket_id">
      
      @php
        $isCustomer = auth()->user()->hasRole('customer');
        $isAdmin = auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('admin') || auth()->user()->hasRole('hr');
      @endphp
      
      @if(!$isCustomer)
        <!-- Admin/Employee Fields -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
          @if($isAdmin)
            <div>
              <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Ticket Status</label>
              <select name="status" id="ticket_status" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                <option value="open">Open</option>
                <option value="assigned">Assigned</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
                <option value="resolved">Resolved</option>
                <option value="closed">Closed</option>
              </select>
            </div>
          @endif
        </div>

        @if($isAdmin)
          <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Assign To Employee</label>
            <select name="assigned_to" id="ticket_assigned_to" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
              <option value="">Not Assigned</option>
              @foreach(\App\Models\Employee::orderBy('name')->get() as $emp)
                <option value="{{ $emp->id }}">{{ $emp->name }} - {{ $emp->position ?? 'N/A' }}</option>
              @endforeach
            </select>
          </div>
        @endif

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
          <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Category</label>
            <input type="text" name="category" id="ticket_category" placeholder="e.g. Technical, Billing" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
          </div>
          
          <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Company</label>
            <input type="text" name="company" id="ticket_company" placeholder="Company Name" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
          </div>
        </div>

        <div style="margin-bottom: 15px;">
          <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Customer Name</label>
          <input type="text" name="customer" id="ticket_customer" required placeholder="Customer Name" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
        </div>
      @else
        <!-- Customer Fields Only - Simple Form -->
        @if(auth()->user()->company_id)
          @php
            $userProjects = \App\Models\Project::where('company_id', auth()->user()->company_id)
              ->whereIn('status', ['active', 'in_progress'])
              ->orderBy('name')
              ->get();
          @endphp
          
          @if($userProjects->count() > 0)
          <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Related Project (Optional)</label>
            <select name="project_id" id="ticket_project_id" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
              <option value="">Select a project (if applicable)</option>
              @foreach($userProjects as $project)
                <option value="{{ $project->id }}">{{ $project->name }}</option>
              @endforeach
            </select>
          </div>
          @endif
        @endif
        
        <div style="margin-bottom: 15px;">
          <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Category</label>
          <select name="ticket_type" id="ticket_type" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
            <option value="">Select a category</option>
            <option value="Technical Support">Technical Support</option>
            <option value="Billing">Billing</option>
            <option value="Feature Request">Feature Request</option>
            <option value="Bug Report">Bug Report</option>
            <option value="General Inquiry">General Inquiry</option>
            <option value="AMC Renewal">AMC Renewal</option>
            <option value="Other">Other</option>
          </select>
        </div>
        
        <div style="margin-bottom: 15px;">
          <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Priority Level</label>
          <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;">
            <label style="display: flex; align-items: center; padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; transition: all 0.2s;" onclick="this.querySelector('input').checked = true; updatePriorityStyle()">
              <input type="radio" name="priority" value="low" style="margin-right: 6px;" checked>
              <span style="font-size: 13px; font-weight: 600;">Low</span>
            </label>
            <label style="display: flex; align-items: center; padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; transition: all 0.2s;" onclick="this.querySelector('input').checked = true; updatePriorityStyle()">
              <input type="radio" name="priority" value="medium" style="margin-right: 6px;">
              <span style="font-size: 13px; font-weight: 600;">Medium</span>
            </label>
            <label style="display: flex; align-items: center; padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; transition: all 0.2s;" onclick="this.querySelector('input').checked = true; updatePriorityStyle()">
              <input type="radio" name="priority" value="high" style="margin-right: 6px;">
              <span style="font-size: 13px; font-weight: 600;">High</span>
            </label>
            <label style="display: flex; align-items: center; padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; transition: all 0.2s;" onclick="this.querySelector('input').checked = true; updatePriorityStyle()">
              <input type="radio" name="priority" value="urgent" style="margin-right: 6px;">
              <span style="font-size: 13px; font-weight: 600;">Urgent</span>
            </label>
          </div>
        </div>
      @endif

      <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Title/Subject <span style="color: #ef4444;">*</span></label>
        <input type="text" name="title" id="ticket_title" required placeholder="Brief description of your issue" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
      </div>

      <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Description <span style="color: #ef4444;">*</span></label>
        <textarea name="description" id="ticket_description" rows="4" required placeholder="Please provide detailed information about your issue..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; resize: vertical;"></textarea>
      </div>

      <div style="margin-bottom: 20px;">
        <label style="display: flex; align-items: center; margin-bottom: 8px; font-weight: 600; font-size: 14px;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 6px; flex-shrink: 0;">
            <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/>
          </svg>
          <span>Attach Files (Optional) - Multiple images supported</span>
        </label>
        <label for="ticket_attachments" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 16px; background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 500; color: #64748b; transition: all 0.2s; width: 100%; justify-content: center;" onmouseover="this.style.background='#f1f5f9'; this.style.borderColor='#94a3b8'" onmouseout="this.style.background='#f8fafc'; this.style.borderColor='#cbd5e1'">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink: 0;">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
          </svg>
          <span id="ticket_attachments_label">Click to upload images or PDFs (Max 10MB each)</span>
        </label>
        <input type="file" id="ticket_attachments" name="attachments[]" accept="image/*,.pdf" multiple style="display: none;" onchange="showTicketFileNames(this)">
        <div id="ticket_files_preview" style="margin-top: 10px;"></div>
      </div>

      <div style="display: flex; gap: 10px; justify-content: flex-end;">
        <button type="button" onclick="closeTicketModal()" style="padding: 10px 20px; border: 1px solid #ddd; background: white; border-radius: 8px; cursor: pointer; font-weight: 600;">Cancel</button>
        <button type="submit" style="padding: 10px 20px; border: none; background: #10b981; color: white; border-radius: 8px; cursor: pointer; font-weight: 600;">{{ $isCustomer ? 'Submit Ticket' : 'Save Ticket' }}</button>
      </div>
    </form>
  </div>
</div>

<script>
function updatePriorityStyle() {
  const radios = document.querySelectorAll('input[name="priority"]');
  if (!radios || radios.length === 0) return;
  
  radios.forEach(radio => {
    const label = radio.closest('label');
    if (!label) return;
    
    if (radio.checked) {
      label.style.borderColor = '#3b82f6';
      label.style.background = '#eff6ff';
    } else {
      label.style.borderColor = '#e5e7eb';
      label.style.background = 'white';
    }
  });
}

function showTicketFileNames(input) {
  const preview = document.getElementById('ticket_files_preview');
  const label = document.getElementById('ticket_attachments_label');
  
  if (input.files && input.files.length > 0) {
    const files = Array.from(input.files);
    const totalSize = files.reduce((sum, file) => sum + file.size, 0);
    const totalSizeMB = (totalSize / 1024 / 1024).toFixed(2);
    
    // Update label
    label.textContent = `✓ ${files.length} file(s) selected (${totalSizeMB} MB total)`;
    label.parentElement.style.borderColor = '#10b981';
    label.parentElement.style.background = '#f0fdf4';
    
    // Show preview
    let previewHTML = '<div style="display: grid; gap: 8px;">';
    
    files.forEach((file, index) => {
      const fileSize = (file.size / 1024 / 1024).toFixed(2);
      const isImage = file.type.startsWith('image/');
      const isPdf = file.type === 'application/pdf';
      
      previewHTML += `
        <div style="display: flex; align-items: center; gap: 12px; padding: 12px; background: white; border: 1px solid #e5e7eb; border-radius: 8px;">
          <div style="flex-shrink: 0;">
            ${isImage ? `
              <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
              </svg>
            ` : isPdf ? `
              <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
              </svg>
            ` : `
              <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/>
              </svg>
            `}
          </div>
          <div style="flex: 1; min-width: 0;">
            <div style="font-weight: 600; font-size: 14px; color: #0f172a; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${file.name}</div>
            <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
              ${isImage ? '🖼️ Image' : isPdf ? '📄 PDF' : '📎 File'} • ${fileSize} MB
            </div>
          </div>
          <button type="button" onclick="removeTicketFile(${index})" style="flex-shrink: 0; padding: 6px 12px; background: #fee2e2; color: #dc2626; border: none; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fee2e2'">
            Remove
          </button>
        </div>
      `;
    });
    
    previewHTML += '</div>';
    preview.innerHTML = previewHTML;
  }
}

function removeTicketFile(index) {
  const input = document.getElementById('ticket_attachments');
  const dt = new DataTransfer();
  
  // Add all files except the one to remove
  Array.from(input.files).forEach((file, i) => {
    if (i !== index) {
      dt.items.add(file);
    }
  });
  
  input.files = dt.files;
  showTicketFileNames(input);
}

function clearTicketFiles(clearPreview = true) {
  const input = document.getElementById('ticket_attachments');
  const preview = document.getElementById('ticket_files_preview');
  const label = document.getElementById('ticket_attachments_label');
  
  input.value = '';
  // Only clear preview if explicitly requested (not when editing with existing attachments)
  if (clearPreview && !document.getElementById('existing_attachments_grid')) {
    preview.innerHTML = '';
  }
  label.textContent = 'Click to upload images or PDFs (Max 10MB each)';
  label.parentElement.style.borderColor = '#cbd5e1';
  label.parentElement.style.background = '#f8fafc';
}
</script>

<!-- Assign Ticket Modal -->
<div id="assignModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
  <div style="background: white; border-radius: 15px; padding: 30px; max-width: 400px; width: 90%; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
    <h3 style="margin: 0 0 20px 0; font-size: 22px; font-weight: 700;">Assign Ticket</h3>
    
    <form id="assignForm" onsubmit="submitAssignment(event)">
      <input type="hidden" name="assign_ticket_id" id="assign_ticket_id">
      
      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Select Employee</label>
        <select name="assigned_to" id="assign_employee_id" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
          <option value="">Select Employee</option>
          @foreach(\App\Models\Employee::orderBy('name')->get() as $emp)
            <option value="{{ $emp->id }}">{{ $emp->name }} - {{ $emp->position ?? 'N/A' }}</option>
          @endforeach
        </select>
      </div>

      <div style="display: flex; gap: 10px; justify-content: flex-end;">
        <button type="button" onclick="closeAssignModal()" style="padding: 10px 20px; border: 1px solid #ddd; background: white; border-radius: 8px; cursor: pointer; font-weight: 600;">Cancel</button>
        <button type="submit" style="padding: 10px 20px; border: none; background: #3b82f6; color: white; border-radius: 8px; cursor: pointer; font-weight: 600;">Assign</button>
      </div>
    </form>
  </div>
</div>

<!-- View Ticket Modal -->
<div id="viewTicketModal" class="ticket-view-modal-overlay" style="display: none;">
  <div class="ticket-view-modal-container">
    <!-- Modal Header -->
    <div class="ticket-view-modal-header">
      <div style="display: flex; align-items: center; gap: 12px;">
        <div id="viewTicketStatusBadge" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: uppercase;"></div>
        <div id="viewTicketPriorityBadge" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: uppercase;"></div>
      </div>
      <button onclick="closeViewTicketModal()" style="background: none; border: none; cursor: pointer; color: #64748b; font-size: 28px; line-height: 1; padding: 4px; border-radius: 8px; transition: all 0.2s;" onmouseover="this.style.background='#f1f5f9'; this.style.color='#0f172a'" onmouseout="this.style.background='none'; this.style.color='#64748b'">&times;</button>
    </div>
    
    <!-- Modal Body - Two Column Layout -->
    <div class="ticket-view-modal-body">
      <!-- LEFT COLUMN - Ticket Details -->
      <div class="ticket-view-left-column">
        <!-- Ticket Title & ID -->
        <div style="margin-bottom: 24px;">
          <div style="font-size: 12px; color: #64748b; font-weight: 600; margin-bottom: 6px;">
            <span id="viewTicketNo">Ticket #TKT-00001</span>
            <span style="margin: 0 8px;">•</span>
            <span id="viewTicketCreatedAt">Created Dec 15, 2025</span>
          </div>
          <h2 id="viewTicketTitle" style="font-size: 24px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.3;"></h2>
        </div>
        
        <!-- Info Cards Grid -->
        @php
          $isCustomerUser = auth()->user()->hasRole('customer');
        @endphp
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 24px;">
          @if(!$isCustomerUser)
          <div style="padding: 16px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
            <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
              Customer
            </div>
            <div id="viewTicketCustomer" style="font-size: 15px; font-weight: 600; color: #0f172a;">-</div>
          </div>
          @endif
          <div style="padding: 16px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
            <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
              Company
            </div>
            <div id="viewTicketCompany" style="font-size: 15px; font-weight: 600; color: #0f172a;">-</div>
          </div>
          <div style="padding: 16px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
            <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
              Category
            </div>
            <div id="viewTicketCategory" style="font-size: 15px; font-weight: 600; color: #0f172a;">-</div>
          </div>
          @if($isCustomerUser)
          <div style="padding: 16px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
            <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              Priority
            </div>
            <div id="viewTicketPriorityCard" style="font-size: 15px; font-weight: 600; color: #0f172a;">-</div>
          </div>
          @else
          <div style="padding: 16px; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-radius: 12px; border: 1px solid #bfdbfe;">
            <div style="font-size: 11px; font-weight: 700; color: #1e40af; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
              Assigned To
            </div>
            <div id="viewTicketAssignedTo" style="font-size: 15px; font-weight: 600; color: #1e40af;">Not assigned</div>
          </div>
          @endif
        </div>
        
        <!-- Description Section -->
        <div style="margin-bottom: 24px;">
          <div style="font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; gap: 8px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            Description
          </div>
          <div id="viewTicketDescription" style="padding: 16px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0; font-size: 14px; color: #374151; line-height: 1.7; white-space: pre-wrap; min-height: 80px;"></div>
        </div>
        
        <!-- Resolution Notes Section (if exists) -->
        <div id="viewTicketResolutionSection" style="display: none; margin-bottom: 24px;">
          <div style="font-size: 13px; font-weight: 700; color: #065f46; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; gap: 8px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            Resolution Notes
          </div>
          <div id="viewTicketResolutionNotes" style="padding: 16px; background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); border-radius: 12px; border-left: 4px solid #10b981; font-size: 14px; color: #064e3b; line-height: 1.7;"></div>
        </div>
        
        <!-- Attachments Section -->
        <div id="viewTicketAttachmentsSection" style="display: none; margin-bottom: 24px;">
          <div style="font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; gap: 8px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
            Attachments
            <span id="viewTicketAttachmentCount" style="background: #e5e7eb; padding: 2px 8px; border-radius: 10px; font-size: 11px;">0</span>
          </div>
          <div id="viewTicketAttachments" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 12px;"></div>
        </div>
        
        <!-- Action Buttons -->
        <div id="viewTicketActionButtons" style="display: flex; gap: 12px; padding-top: 16px; border-top: 1px solid #e5e7eb;">
          @php
            $canEditTicket = auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.edit ticket') || $isEmployeeUser;
          @endphp
          <!-- Edit button - shown for admins always, for employees only if assigned (controlled via JS) -->
          <button id="viewTicketEditBtn" onclick="editTicketFromView()" style="display: {{ $canEditTicket ? 'flex' : 'none' }}; padding: 10px 20px; background: #3b82f6; color: white; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; align-items: center; gap: 8px; transition: all 0.2s;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Edit Ticket
          </button>
          <button onclick="closeViewTicketModal()" style="padding: 10px 20px; background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
            Close
          </button>
        </div>
      </div>
      
      <!-- RIGHT COLUMN - Chat Section -->
      <div class="ticket-view-right-column">
        <!-- Chat Header with Tabs for Admin -->
        <div style="border-bottom: 1px solid #e5e7eb; background: white; flex-shrink: 0;">
          @if(auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('admin') || auth()->user()->hasRole('hr') || auth()->user()->hasRole('employee') || auth()->user()->hasRole('Employee'))
          <!-- Tab Navigation for Admin/Employee -->
          <div style="display: flex; border-bottom: 1px solid #e5e7eb;">
            <button id="chatTabExternal" onclick="switchChatTab('external')" style="flex: 1; padding: 12px 16px; background: white; border: none; border-bottom: 3px solid #3b82f6; cursor: pointer; font-size: 13px; font-weight: 600; color: #3b82f6; display: flex; align-items: center; justify-content: center; gap: 6px; transition: all 0.2s;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
              </svg>
              Customer Chat
            </button>
            <button id="chatTabInternal" onclick="switchChatTab('internal')" style="flex: 1; padding: 12px 16px; background: #f8fafc; border: none; border-bottom: 3px solid transparent; cursor: pointer; font-size: 13px; font-weight: 600; color: #64748b; display: flex; align-items: center; justify-content: center; gap: 6px; transition: all 0.2s;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
              </svg>
              Internal Notes
              <span id="internalNotesCount" style="background: #fef3c7; color: #92400e; padding: 2px 6px; border-radius: 10px; font-size: 10px; font-weight: 700; display: none;">0</span>
            </button>
          </div>
          @endif
          <div style="padding: 12px 16px; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 8px;">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
              </svg>
              <h3 id="chatSectionTitle" style="margin: 0; font-size: 15px; font-weight: 600; color: #1f2937;">Discussion</h3>
            </div>
            <button onclick="refreshTicketComments()" style="padding: 5px 10px; background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 6px; cursor: pointer; font-size: 11px; font-weight: 600; color: #64748b; display: flex; align-items: center; gap: 4px;" title="Refresh">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/>
              </svg>
              Refresh
            </button>
          </div>
        </div>
        
        <!-- Chat Messages Container -->
        <div id="ticketChatMessages" style="flex: 1; padding: 16px; overflow-y: auto; display: flex; flex-direction: column; gap: 12px; min-height: 0;">
          <!-- Empty State -->
          <div id="ticketChatEmptyState" style="text-align: center; padding: 40px 20px;">
            <div style="width: 60px; height: 60px; margin: 0 auto 12px; background: linear-gradient(135deg, #f5f3ff, #ede9fe); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="2">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
              </svg>
            </div>
            <h4 style="margin: 0 0 4px 0; font-size: 14px; font-weight: 600; color: #1f2937;">No Messages Yet</h4>
            <p style="margin: 0; font-size: 12px; color: #6b7280;">Start the conversation!</p>
          </div>
        </div>
        
        <!-- Attachment Preview Area -->
        <div id="ticketChatAttachmentPreview" style="display: none; padding: 8px 16px; background: #f0fdf4; border-top: 1px solid #bbf7d0; flex-shrink: 0;">
          <div style="display: flex; align-items: center; gap: 10px;">
            <div id="ticketChatAttachmentThumb" style="width: 50px; height: 50px; border-radius: 8px; overflow: hidden; border: 2px solid #22c55e; flex-shrink: 0;"></div>
            <div style="flex: 1; min-width: 0;">
              <div id="ticketChatAttachmentName" style="font-size: 13px; font-weight: 600; color: #166534; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"></div>
              <div id="ticketChatAttachmentSize" style="font-size: 11px; color: #16a34a;"></div>
            </div>
            <button onclick="clearChatAttachment()" style="padding: 6px; background: #fee2e2; border: none; border-radius: 6px; cursor: pointer; color: #dc2626;" title="Remove">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
              </svg>
            </button>
          </div>
        </div>
        
        <!-- Chat Input Area -->
        <div style="padding: 12px 16px; background: white; border-top: 1px solid #e5e7eb; flex-shrink: 0;">
          <!-- File Input (hidden) -->
          <input type="file" id="ticketChatFileInput" accept="image/*,.pdf" style="display: none;" onchange="handleChatFileSelect(this)">
          
          <div style="display: flex; align-items: flex-end; gap: 8px;">
            <!-- Attachment Button -->
            <button onclick="document.getElementById('ticketChatFileInput').click()" style="width: 40px; height: 40px; border-radius: 50%; background: #f1f5f9; border: 1px solid #e2e8f0; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s; flex-shrink: 0;" title="Attach file" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
                <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/>
              </svg>
            </button>
            
            <textarea id="ticketChatInput" placeholder="Type your message..." rows="1" style="flex: 1; padding: 10px 14px; border: 1px solid #e5e7eb; border-radius: 20px; background: #f9fafb; color: #1f2937; font-size: 14px; outline: none; resize: none; min-height: 40px; max-height: 80px; font-family: inherit; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e5e7eb'" onkeypress="if(event.key === 'Enter' && !event.shiftKey) { event.preventDefault(); sendTicketComment(); }"></textarea>
            
            <button onclick="sendTicketComment()" style="width: 40px; height: 40px; border-radius: 50%; background: #3b82f6; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s; flex-shrink: 0;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <line x1="22" y1="2" x2="11" y2="13"></line>
                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
              </svg>
            </button>
          </div>
          
          @if(auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('admin') || auth()->user()->hasRole('hr') || auth()->user()->hasRole('employee') || auth()->user()->hasRole('Employee'))
          <div style="display: flex; align-items: center; gap: 8px; padding-top: 8px;">
            <label id="internalNoteLabel" style="display: flex; align-items: center; gap: 6px; font-size: 11px; color: #64748b; cursor: pointer;">
              <input type="checkbox" id="ticketInternalComment" style="width: 13px; height: 13px; cursor: pointer;">
              <span>🔒 Internal note (hidden from customer)</span>
            </label>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function openAddTicketModal() {
  document.getElementById('modalTitle').textContent = 'Add Ticket';
  document.getElementById('ticketForm').reset();
  document.getElementById('ticket_id').value = '';
  // Clear the preview area for new tickets
  document.getElementById('ticket_files_preview').innerHTML = '';
  clearTicketFiles(true);
  document.getElementById('ticketModal').style.display = 'flex';
}

function closeTicketModal() {
  document.getElementById('ticketModal').style.display = 'none';
}

function submitTicket(event) {
  event.preventDefault();
  const formData = new FormData(event.target);
  
  // Handle multiple attachments
  const attachmentsInput = document.getElementById('ticket_attachments');
  if (attachmentsInput && attachmentsInput.files.length > 0) {
    // Remove any existing attachment entries
    formData.delete('attachment');
    formData.delete('attachments[]');
    
    // Add all files as attachments[]
    Array.from(attachmentsInput.files).forEach((file, index) => {
      formData.append('attachments[]', file);
    });
  }
  
  // Debug: Check if file is in FormData
  console.log('FormData entries:');
  for (let pair of formData.entries()) {
    console.log(pair[0], pair[1]);
  }
  
  const data = Object.fromEntries(formData);
  const ticketId = data.ticket_id;
  const url = ticketId ? `{{ url('tickets') }}/${ticketId}` : '{{ route("tickets.store") }}';
  const method = 'POST';
  
  @if(auth()->user()->hasRole('customer'))
    // For customers, add default values that will be auto-filled by backend
    if (!formData.has('status') || !formData.get('status')) {
      formData.append('status', 'open');
    }
    if (!formData.has('customer') || !formData.get('customer')) {
      formData.append('customer', '{{ auth()->user()->name }}');
    }
    if (!formData.has('company') || !formData.get('company')) {
      @if(auth()->user()->company)
        formData.append('company', '{{ auth()->user()->company->company_name }}');
      @endif
    }
  @endif
  
  if (ticketId) {
    formData.append('_method', 'PUT');
  }
  
  fetch(url, {
    method: method,
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      closeTicketModal();
      
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          icon: 'success',
          title: 'Success!',
          html: `
            <p style="margin-bottom: 16px;">${data.message || 'Ticket saved successfully!'}</p>
            ${data.ticket && data.ticket.id ? `
              <a href="{{ url('tickets') }}/${data.ticket.id}" 
                 style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #3b82f6; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: all 0.2s;"
                 onmouseover="this.style.background='#2563eb'" 
                 onmouseout="this.style.background='#3b82f6'">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                  <circle cx="12" cy="12" r="3"/>
                </svg>
                View Ticket
              </a>
            ` : ''}
          `,
          showConfirmButton: true,
          confirmButtonText: 'Close',
          confirmButtonColor: '#10b981',
          timer: 5000,
          timerProgressBar: true
        }).then(() => {
          location.reload();
        });
      } else {
        alert(data.message || 'Ticket saved successfully!');
        setTimeout(() => location.reload(), 1000);
      }
    } else {
      if (typeof Swal !== 'undefined') {
        Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Unknown error' });
      } else {
        alert('Error: ' + (data.message || 'Unknown error'));
      }
    }
  })
  .catch(error => {
    console.error('Error:', error);
    if (typeof Swal !== 'undefined') {
      Swal.fire({ icon: 'error', title: 'Error', text: 'Error saving ticket' });
    } else {
      alert('Error saving ticket');
    }
  });
}

function editTicket(id) {
  // Fetch ticket data and open modal
  fetch(`{{ url('tickets') }}/${id}/json`, {
    method: 'GET',
    headers: {
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success && data.ticket) {
      const ticket = data.ticket;
      const isCustomer = {{ auth()->user()->hasRole('customer') ? 'true' : 'false' }};
      
      // Check if customer can edit (only when status is 'open')
      if (isCustomer && ticket.status !== 'open') {
        if (typeof Swal !== 'undefined') {
          Swal.fire({
            icon: 'warning',
            title: 'Cannot Edit',
            text: 'You can only edit tickets when they are in "Open" status. This ticket is currently "' + ticket.status.replace('_', ' ').toUpperCase() + '".',
            confirmButtonColor: '#3b82f6'
          });
        } else {
          alert('You can only edit tickets when they are in "Open" status.');
        }
        return;
      }
      
      // Set modal title
      document.getElementById('modalTitle').textContent = 'Edit Ticket #' + (ticket.ticket_no || ticket.id);
      
      // Fill form fields
      document.getElementById('ticket_id').value = ticket.id;
      document.getElementById('ticket_title').value = ticket.title || ticket.subject || '';
      document.getElementById('ticket_description').value = ticket.description || '';
      
      // Admin fields
      const statusField = document.getElementById('ticket_status');
      if (statusField) statusField.value = ticket.status || 'open';
      
      const assignedToField = document.getElementById('ticket_assigned_to');
      if (assignedToField) assignedToField.value = ticket.assigned_to || '';
      
      const categoryField = document.getElementById('ticket_category');
      if (categoryField) categoryField.value = ticket.category || '';
      
      const companyField = document.getElementById('ticket_company');
      if (companyField) companyField.value = ticket.company || '';
      
      const customerField = document.getElementById('ticket_customer');
      if (customerField) customerField.value = ticket.customer || '';
      
      // Customer fields
      const ticketTypeField = document.getElementById('ticket_type');
      if (ticketTypeField) ticketTypeField.value = ticket.ticket_type || ticket.category || '';
      
      const projectIdField = document.getElementById('ticket_project_id');
      if (projectIdField) projectIdField.value = ticket.project_id || '';
      
      // Set priority radio buttons
      const priorityValue = ticket.priority || 'low';
      document.querySelectorAll('input[name="priority"]').forEach(radio => {
        radio.checked = (radio.value === priorityValue);
      });
      updatePriorityStyle();
      
      // Show existing attachments
      showExistingAttachments(ticket.attachments || []);
      
      // Clear new file input but don't clear preview (existing attachments are shown there)
      clearTicketFiles(false);
      
      // Open modal
      document.getElementById('ticketModal').style.display = 'flex';
    } else {
      if (typeof Swal !== 'undefined') {
        Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Could not load ticket data' });
      } else {
        alert('Error loading ticket data');
      }
    }
  })
  .catch(error => {
    console.error('Error:', error);
    if (typeof Swal !== 'undefined') {
      Swal.fire({ icon: 'error', title: 'Error', text: 'Error loading ticket data' });
    } else {
      alert('Error loading ticket data');
    }
  });
}

// Show existing attachments in edit mode
function showExistingAttachments(attachments) {
  const preview = document.getElementById('ticket_files_preview');
  
  if (!attachments || attachments.length === 0) {
    preview.innerHTML = '';
    return;
  }
  
  let previewHTML = '<div style="margin-bottom: 12px; font-size: 13px; font-weight: 600; color: #64748b;">📎 Existing Attachments:</div>';
  previewHTML += '<div id="existing_attachments_grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px; margin-bottom: 16px;">';
  
  attachments.forEach((attachment, index) => {
    const fileName = attachment.split('/').pop();
    const extension = fileName.split('.').pop().toLowerCase();
    const isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(extension);
    const isPdf = extension === 'pdf';
    const imageUrl = getStorageUrl(attachment);
    
    if (isImage) {
      previewHTML += `
        <div style="border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; background: white; position: relative;">
          <a href="${imageUrl}" target="_blank" style="display: block;">
            <img src="${imageUrl}" alt="Attachment ${index + 1}" style="width: 100%; height: 100px; object-fit: cover;">
          </a>
          <div style="padding: 6px; font-size: 10px; color: #64748b; text-align: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
            🖼️ ${fileName}
          </div>
        </div>
      `;
    } else if (isPdf) {
      previewHTML += `
        <div style="border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; background: white; padding: 12px; text-align: center;">
          <a href="${imageUrl}" target="_blank" style="display: inline-flex; flex-direction: column; align-items: center; gap: 4px; color: #dc2626; text-decoration: none;">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
            </svg>
            <div style="font-size: 10px; font-weight: 600; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 100%;">
              📄 ${fileName}
            </div>
          </a>
        </div>
      `;
    } else {
      previewHTML += `
        <div style="border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; background: white; padding: 12px; text-align: center;">
          <a href="${imageUrl}" target="_blank" style="display: inline-flex; flex-direction: column; align-items: center; gap: 4px; color: #3b82f6; text-decoration: none;">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/>
            </svg>
            <div style="font-size: 10px; font-weight: 600; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 100%;">
              📎 ${fileName}
            </div>
          </a>
        </div>
      `;
    }
  });
  
  previewHTML += '</div>';
  previewHTML += '<div style="font-size: 12px; color: #64748b; margin-bottom: 8px;">➕ Add more files (optional):</div>';
  
  preview.innerHTML = previewHTML;
}

// Current ticket ID for chat
let currentViewTicketId = null;
let ticketChatPollingInterval = null;

function viewTicket(id) {
  currentViewTicketId = id;
  
  // Show modal immediately
  const modal = document.getElementById('viewTicketModal');
  modal.style.display = 'flex';
  
  // Fetch ticket data
  fetch(`{{ url('tickets') }}/${id}/json`, {
    method: 'GET',
    headers: {
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success && data.ticket) {
      populateViewTicketModal(data.ticket);
      loadTicketComments(id);
      startTicketChatPolling(id);
    } else {
      closeViewTicketModal();
      if (typeof Swal !== 'undefined') {
        Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Could not load ticket data' });
      } else {
        alert('Error loading ticket data');
      }
    }
  })
  .catch(error => {
    console.error('Error:', error);
    closeViewTicketModal();
    if (typeof Swal !== 'undefined') {
      Swal.fire({ icon: 'error', title: 'Error', text: 'Error loading ticket data' });
    } else {
      alert('Error loading ticket data');
    }
  });
}

function closeViewTicketModal() {
  document.getElementById('viewTicketModal').style.display = 'none';
  currentViewTicketId = null;
  stopTicketChatPolling();
  
  // Reset chat state
  currentChatTab = 'external';
  allTicketComments = [];
  clearChatAttachment();
  
  // Reset tab UI if tabs exist
  const externalTab = document.getElementById('chatTabExternal');
  const internalTab = document.getElementById('chatTabInternal');
  if (externalTab && internalTab) {
    switchChatTab('external');
  }
}

function populateViewTicketModal(ticket) {
  const isCustomer = {{ auth()->user()->hasRole('customer') ? 'true' : 'false' }};
  
  // Status colors
  const statusColors = {
    'open': { bg: '#dbeafe', color: '#1e40af', icon: '🔵' },
    'assigned': { bg: '#ede9fe', color: '#5b21b6', icon: '👤' },
    'in_progress': { bg: '#fef3c7', color: '#92400e', icon: '⏳' },
    'completed': { bg: '#ffedd5', color: '#9a3412', icon: '✅' },
    'resolved': { bg: '#d1fae5', color: '#065f46', icon: '✓' },
    'closed': { bg: '#f3f4f6', color: '#374151', icon: '🔒' }
  };
  
  const priorityColors = {
    'low': { bg: '#d1fae5', color: '#065f46', icon: '🟢' },
    'medium': { bg: '#fef3c7', color: '#92400e', icon: '🟡' },
    'high': { bg: '#fed7aa', color: '#9a3412', icon: '🟠' },
    'urgent': { bg: '#fee2e2', color: '#991b1b', icon: '🔴' }
  };
  
  // For customers, show "completed" as "in_progress"
  let displayStatus = ticket.status || 'open';
  if (isCustomer && displayStatus === 'completed') {
    displayStatus = 'in_progress';
  }
  
  const status = statusColors[displayStatus] || statusColors['open'];
  const priority = priorityColors[ticket.priority] || priorityColors['medium'];
  
  // Update status badge
  const statusBadge = document.getElementById('viewTicketStatusBadge');
  statusBadge.innerHTML = `${status.icon} ${displayStatus.replace('_', ' ')}`;
  statusBadge.style.background = status.bg;
  statusBadge.style.color = status.color;
  
  // Update priority badge
  const priorityBadge = document.getElementById('viewTicketPriorityBadge');
  priorityBadge.innerHTML = `${priority.icon} ${ticket.priority || 'medium'}`;
  priorityBadge.style.background = priority.bg;
  priorityBadge.style.color = priority.color;
  
  // Update ticket info
  document.getElementById('viewTicketNo').textContent = `Ticket #${ticket.ticket_no || ticket.id}`;
  document.getElementById('viewTicketTitle').textContent = ticket.title || ticket.subject || 'No Title';
  document.getElementById('viewTicketCreatedAt').textContent = ticket.created_at ? 
    `Created ${new Date(ticket.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}` : '';
  
  // Update info cards (check if elements exist - some are hidden for customers)
  const customerEl = document.getElementById('viewTicketCustomer');
  if (customerEl) customerEl.textContent = ticket.customer || 'N/A';
  
  document.getElementById('viewTicketCompany').textContent = ticket.company || 'N/A';
  document.getElementById('viewTicketCategory').textContent = ticket.category || ticket.ticket_type || 'General';
  
  // Update priority card for customers
  const priorityCardEl = document.getElementById('viewTicketPriorityCard');
  if (priorityCardEl) {
    const priorityText = (ticket.priority || 'medium').charAt(0).toUpperCase() + (ticket.priority || 'medium').slice(1);
    priorityCardEl.innerHTML = `<span style="color: ${priority.color};">${priority.icon} ${priorityText}</span>`;
  }
  
  // Update assigned to (only for non-customers)
  const assignedToEl = document.getElementById('viewTicketAssignedTo');
  if (assignedToEl && ticket.assigned_employee) {
    assignedToEl.innerHTML = `
      <div style="display: flex; align-items: center; gap: 8px;">
        <div style="width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #8b5cf6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 11px;">
          ${ticket.assigned_employee.name ? ticket.assigned_employee.name.charAt(0).toUpperCase() : '?'}
        </div>
        <span>${ticket.assigned_employee.name || 'Unknown'}</span>
      </div>
    `;
  } else if (assignedToEl) {
    assignedToEl.textContent = 'Not assigned';
  }
  
  // Update description
  document.getElementById('viewTicketDescription').textContent = ticket.description || 'No description provided.';
  
  // Update resolution notes
  const resolutionSection = document.getElementById('viewTicketResolutionSection');
  if (ticket.resolution_notes) {
    document.getElementById('viewTicketResolutionNotes').textContent = ticket.resolution_notes;
    resolutionSection.style.display = 'block';
  } else {
    resolutionSection.style.display = 'none';
  }
  
  // Update attachments
  const attachmentsSection = document.getElementById('viewTicketAttachmentsSection');
  const attachmentsContainer = document.getElementById('viewTicketAttachments');
  
  if (ticket.attachments && ticket.attachments.length > 0) {
    document.getElementById('viewTicketAttachmentCount').textContent = ticket.attachments.length;
    
    let attachmentsHtml = '';
    ticket.attachments.forEach((att, i) => {
      const fileName = att.split('/').pop();
      const ext = fileName.split('.').pop().toLowerCase();
      const isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext);
      const imgUrl = getStorageUrl(att);
      
      if (isImage) {
        attachmentsHtml += `
          <a href="${imgUrl}" target="_blank" style="display: block; border: 1px solid #e5e7eb; border-radius: 10px; overflow: hidden; transition: all 0.2s; background: white;" onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)'" onmouseout="this.style.boxShadow='none'">
            <img src="${imgUrl}" alt="Attachment ${i+1}" style="width: 100%; height: 100px; object-fit: cover;">
            <div style="padding: 8px; font-size: 11px; color: #64748b; text-align: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; background: #f8fafc;">🖼️ ${fileName}</div>
          </a>
        `;
      } else {
        attachmentsHtml += `
          <a href="${imgUrl}" target="_blank" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px 12px; border: 1px solid #e5e7eb; border-radius: 10px; text-decoration: none; transition: all 0.2s; background: white;" onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)'" onmouseout="this.style.boxShadow='none'">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="${ext === 'pdf' ? '#dc2626' : '#3b82f6'}" stroke-width="2">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
            </svg>
            <div style="margin-top: 8px; font-size: 11px; color: #64748b; text-align: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 100%;">${ext === 'pdf' ? '📄' : '📎'} ${fileName}</div>
          </a>
        `;
      }
    });
    
    attachmentsContainer.innerHTML = attachmentsHtml;
    attachmentsSection.style.display = 'block';
  } else {
    attachmentsSection.style.display = 'none';
  }
  
  // Handle edit button visibility for employees
  const editBtn = document.getElementById('viewTicketEditBtn');
  const isAdmin = {{ auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('admin') || auth()->user()->hasRole('hr') ? 'true' : 'false' }};
  const isEmployee = {{ auth()->user()->hasRole('employee') || auth()->user()->hasRole('Employee') ? 'true' : 'false' }};
  const currentEmployeeId = {{ $currentEmployeeId ?? 'null' }};
  
  if (editBtn) {
    if (isAdmin) {
      // Admins can always edit
      editBtn.style.display = 'flex';
    } else if (isEmployee && currentEmployeeId && ticket.assigned_to == currentEmployeeId) {
      // Employees can edit only if assigned to them
      editBtn.style.display = 'flex';
    } else if (!isAdmin && !isEmployee) {
      // Customers - hide edit button (they use the main form)
      editBtn.style.display = 'none';
    }
  }
}

function loadTicketComments(ticketId) {
  fetch(`{{ url('tickets') }}/${ticketId}/comments`, {
    method: 'GET',
    headers: {
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      renderTicketComments(data.comments || []);
    }
  })
  .catch(error => {
    console.error('Error loading comments:', error);
  });
}

// Store all comments for tab filtering
let allTicketComments = [];
let currentChatTab = 'external';
let selectedChatFile = null;

function renderTicketComments(comments) {
  allTicketComments = comments;
  const container = document.getElementById('ticketChatMessages');
  const emptyState = document.getElementById('ticketChatEmptyState');
  const isAdmin = {{ auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('admin') || auth()->user()->hasRole('hr') ? 'true' : 'false' }};
  const isEmployee = {{ auth()->user()->hasRole('employee') || auth()->user()->hasRole('Employee') ? 'true' : 'false' }};
  const isCustomer = {{ auth()->user()->hasRole('customer') ? 'true' : 'false' }};
  const currentUserId = {{ auth()->id() }};
  
  // Filter comments based on current tab and user role
  let visibleComments = comments;
  if (isCustomer) {
    visibleComments = comments.filter(c => !c.is_internal);
  } else if (isAdmin || isEmployee) {
    // Filter based on current tab
    if (currentChatTab === 'internal') {
      visibleComments = comments.filter(c => c.is_internal);
    } else {
      visibleComments = comments.filter(c => !c.is_internal);
    }
    
    // Update internal notes count
    const internalCount = comments.filter(c => c.is_internal).length;
    const countBadge = document.getElementById('internalNotesCount');
    if (countBadge) {
      if (internalCount > 0) {
        countBadge.textContent = internalCount;
        countBadge.style.display = 'inline';
      } else {
        countBadge.style.display = 'none';
      }
    }
  }
  
  if (visibleComments.length === 0) {
    emptyState.style.display = 'block';
    emptyState.querySelector('h4').textContent = currentChatTab === 'internal' ? 'No Internal Notes' : 'No Messages Yet';
    emptyState.querySelector('p').textContent = currentChatTab === 'internal' ? 'Add internal notes for your team' : 'Start the conversation!';
    // Remove all messages except empty state
    Array.from(container.children).forEach(child => {
      if (child.id !== 'ticketChatEmptyState') {
        child.remove();
      }
    });
    return;
  }
  
  emptyState.style.display = 'none';
  
  // Clear existing messages (except empty state)
  Array.from(container.children).forEach(child => {
    if (child.id !== 'ticketChatEmptyState') {
      child.remove();
    }
  });
  
  // Render comments
  visibleComments.forEach(comment => {
    const isOwn = comment.user_id === currentUserId;
    const userName = comment.user ? comment.user.name : 'Unknown';
    const userInitial = userName.charAt(0).toUpperCase();
    const chatColor = comment.user && comment.user.chat_color ? comment.user.chat_color : '#6366f1';
    const timeAgo = comment.created_at ? getTimeAgo(new Date(comment.created_at)) : '';
    
    const messageDiv = document.createElement('div');
    messageDiv.style.cssText = `display: flex; gap: 10px; ${isOwn ? 'flex-direction: row-reverse;' : ''} animation: slideIn 0.3s ease;`;
    
    let internalBadge = '';
    if (comment.is_internal && (isAdmin || isEmployee)) {
      internalBadge = `<span style="display: inline-flex; align-items: center; gap: 4px; padding: 2px 6px; background: #fef3c7; color: #92400e; border-radius: 4px; font-size: 9px; font-weight: 600; margin-left: 6px;">🔒 Internal</span>`;
    }
    
    // Build attachment HTML if exists
    let attachmentHtml = '';
    if (comment.attachment_path) {
      const isImage = comment.attachment_type && comment.attachment_type.startsWith('image/');
      const attachmentUrl = getStorageUrl(comment.attachment_path);
      
      if (isImage) {
        attachmentHtml = `
          <div style="margin-top: 8px;">
            <a href="${attachmentUrl}" target="_blank" style="display: block; border-radius: 8px; overflow: hidden; max-width: 200px;">
              <img src="${attachmentUrl}" alt="${comment.attachment_name || 'Attachment'}" style="width: 100%; max-height: 150px; object-fit: cover; border-radius: 8px;">
            </a>
            <div style="font-size: 10px; color: ${isOwn ? 'rgba(255,255,255,0.8)' : '#64748b'}; margin-top: 4px;">📷 ${comment.attachment_name || 'Image'}</div>
          </div>
        `;
      } else {
        attachmentHtml = `
          <div style="margin-top: 8px;">
            <a href="${attachmentUrl}" target="_blank" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 12px; background: ${isOwn ? 'rgba(255,255,255,0.2)' : '#f1f5f9'}; border-radius: 8px; text-decoration: none; color: ${isOwn ? 'white' : '#3b82f6'}; font-size: 12px; font-weight: 500;">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
              </svg>
              ${comment.attachment_name || 'Download File'}
            </a>
          </div>
        `;
      }
    }
    
    messageDiv.innerHTML = `
      <div style="width: 32px; height: 32px; border-radius: 50%; background: ${chatColor}; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 12px; flex-shrink: 0;">
        ${userInitial}
      </div>
      <div style="max-width: 80%; ${isOwn ? 'text-align: right;' : ''}">
        <div style="font-size: 11px; color: #64748b; margin-bottom: 3px;">
          <span style="font-weight: 600; color: #374151;">${userName}</span>
          ${internalBadge}
          <span style="margin-left: 6px;">${timeAgo}</span>
        </div>
        <div style="padding: 10px 14px; background: ${isOwn ? '#3b82f6' : (comment.is_internal ? '#fef3c7' : 'white')}; color: ${isOwn ? 'white' : '#1f2937'}; border-radius: ${isOwn ? '14px 14px 4px 14px' : '14px 14px 14px 4px'}; font-size: 13px; line-height: 1.5; box-shadow: 0 1px 3px rgba(0,0,0,0.08); ${comment.is_internal && !isOwn ? 'border: 1px solid #fbbf24;' : ''} text-align: left;">
          ${escapeHtml(comment.comment)}
          ${attachmentHtml}
        </div>
      </div>
    `;
    
    container.appendChild(messageDiv);
  });
  
  // Scroll to bottom
  container.scrollTop = container.scrollHeight;
}

// Tab switching function
function switchChatTab(tab) {
  currentChatTab = tab;
  
  const externalTab = document.getElementById('chatTabExternal');
  const internalTab = document.getElementById('chatTabInternal');
  const chatTitle = document.getElementById('chatSectionTitle');
  const internalCheckbox = document.getElementById('ticketInternalComment');
  const internalLabel = document.getElementById('internalNoteLabel');
  
  if (tab === 'external') {
    if (externalTab) {
      externalTab.style.background = 'white';
      externalTab.style.borderBottomColor = '#3b82f6';
      externalTab.style.color = '#3b82f6';
    }
    if (internalTab) {
      internalTab.style.background = '#f8fafc';
      internalTab.style.borderBottomColor = 'transparent';
      internalTab.style.color = '#64748b';
    }
    if (chatTitle) chatTitle.textContent = 'Customer Chat';
    if (internalCheckbox) internalCheckbox.checked = false;
    if (internalLabel) internalLabel.style.display = 'flex';
  } else {
    if (internalTab) {
      internalTab.style.background = 'white';
      internalTab.style.borderBottomColor = '#f59e0b';
      internalTab.style.color = '#f59e0b';
    }
    if (externalTab) {
      externalTab.style.background = '#f8fafc';
      externalTab.style.borderBottomColor = 'transparent';
      externalTab.style.color = '#64748b';
    }
    if (chatTitle) chatTitle.textContent = 'Internal Notes';
    if (internalCheckbox) internalCheckbox.checked = true;
    if (internalLabel) internalLabel.style.display = 'none';
  }
  
  // Re-render comments with new filter
  renderTicketComments(allTicketComments);
}

// File attachment handling
function handleChatFileSelect(input) {
  if (input.files && input.files[0]) {
    const file = input.files[0];
    
    // Validate file size (10MB max)
    if (file.size > 10 * 1024 * 1024) {
      alert('File size must be less than 10MB');
      input.value = '';
      return;
    }
    
    selectedChatFile = file;
    
    // Show preview
    const previewContainer = document.getElementById('ticketChatAttachmentPreview');
    const thumbContainer = document.getElementById('ticketChatAttachmentThumb');
    const nameEl = document.getElementById('ticketChatAttachmentName');
    const sizeEl = document.getElementById('ticketChatAttachmentSize');
    
    nameEl.textContent = file.name;
    sizeEl.textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
    
    if (file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = function(e) {
        thumbContainer.innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover;">`;
      };
      reader.readAsDataURL(file);
    } else {
      thumbContainer.innerHTML = `
        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #fee2e2;">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
          </svg>
        </div>
      `;
    }
    
    previewContainer.style.display = 'block';
  }
}

function clearChatAttachment() {
  selectedChatFile = null;
  document.getElementById('ticketChatFileInput').value = '';
  document.getElementById('ticketChatAttachmentPreview').style.display = 'none';
}

function sendTicketComment() {
  const input = document.getElementById('ticketChatInput');
  const comment = input.value.trim();
  
  // Allow sending if there's a comment OR a file attachment
  if ((!comment && !selectedChatFile) || !currentViewTicketId) return;
  
  const isInternalCheckbox = document.getElementById('ticketInternalComment');
  const isInternal = isInternalCheckbox ? isInternalCheckbox.checked : false;
  
  const formData = new FormData();
  formData.append('comment', comment || (selectedChatFile ? '📎 Attachment' : ''));
  formData.append('is_internal', isInternal ? '1' : '0');
  
  // Add file attachment if selected
  if (selectedChatFile) {
    formData.append('attachment', selectedChatFile);
  }
  
  // Disable send button while sending
  const sendBtn = document.querySelector('#viewTicketModal button[onclick="sendTicketComment()"]');
  if (sendBtn) {
    sendBtn.disabled = true;
    sendBtn.style.opacity = '0.6';
  }
  
  fetch(`{{ url('tickets') }}/${currentViewTicketId}/comments`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      input.value = '';
      clearChatAttachment();
      // Don't reset internal checkbox if we're on internal tab
      if (isInternalCheckbox && currentChatTab !== 'internal') {
        isInternalCheckbox.checked = false;
      }
      loadTicketComments(currentViewTicketId);
    } else {
      alert('Error sending message: ' + (data.message || 'Unknown error'));
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Error sending message');
  })
  .finally(() => {
    // Re-enable send button
    if (sendBtn) {
      sendBtn.disabled = false;
      sendBtn.style.opacity = '1';
    }
  });
}

function refreshTicketComments() {
  if (currentViewTicketId) {
    loadTicketComments(currentViewTicketId);
  }
}

function startTicketChatPolling(ticketId) {
  stopTicketChatPolling();
  ticketChatPollingInterval = setInterval(() => {
    if (currentViewTicketId === ticketId) {
      loadTicketComments(ticketId);
    }
  }, 10000); // Poll every 10 seconds
}

function stopTicketChatPolling() {
  if (ticketChatPollingInterval) {
    clearInterval(ticketChatPollingInterval);
    ticketChatPollingInterval = null;
  }
}

function editTicketFromView() {
  // Save the ID before closing modal (closeViewTicketModal resets currentViewTicketId to null)
  const ticketId = currentViewTicketId;
  if (ticketId) {
    closeViewTicketModal();
    editTicket(ticketId);
  }
}

function getTimeAgo(date) {
  const seconds = Math.floor((new Date() - date) / 1000);
  
  if (seconds < 60) return 'just now';
  if (seconds < 3600) return Math.floor(seconds / 60) + 'm ago';
  if (seconds < 86400) return Math.floor(seconds / 3600) + 'h ago';
  if (seconds < 604800) return Math.floor(seconds / 86400) + 'd ago';
  
  return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
}

function escapeHtml(text) {
  const div = document.createElement('div');
  div.textContent = text;
  return div.innerHTML;
}

function deleteTicket(id) {
  if (typeof Swal === 'undefined') {
    if (confirm('Are you sure you want to delete this ticket?')) {
      performDeleteTicket(id);
    }
    return;
  }
  
  Swal.fire({
    title: 'Delete Ticket?',
    text: 'Are you sure you want to delete this ticket? This action cannot be undone.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#ef4444',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Yes, Delete',
    cancelButtonText: 'Cancel',
    width: '400px',
    padding: '1.5rem',
    customClass: { popup: 'perfect-swal-popup' }
  }).then((result) => {
    if (result.isConfirmed) {
      performDeleteTicket(id);
    }
  });
}

function performDeleteTicket(id) {
  const formData = new FormData();
  formData.append('_method', 'DELETE');
  
  fetch(`{{ url('tickets') }}/${id}`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      if (typeof Swal !== 'undefined') {
        Swal.fire({ icon: 'success', title: 'Deleted', text: 'Ticket deleted successfully!', timer: 1500, showConfirmButton: false });
      } else {
        alert('Ticket deleted successfully!');
      }
      setTimeout(() => location.reload(), 1000);
    } else {
      if (typeof Swal !== 'undefined') {
        Swal.fire({ icon: 'error', title: 'Error', text: 'Error deleting ticket' });
      } else {
        alert('Error deleting ticket');
      }
    }
  })
  .catch(error => {
    console.error('Error:', error);
    if (typeof Swal !== 'undefined') {
      Swal.fire({ icon: 'error', title: 'Error', text: 'Error deleting ticket' });
    } else {
      alert('Error deleting ticket');
    }
  });
}

// Global helper function to generate storage URL (matches storage_asset() helper)
function getStorageUrl(path) {
  if (!path) return '';
  const baseUrl = '{{ url('/') }}';
  // Remove leading slash if present
  path = path.replace(/^\/+/, '');
  // Remove 'storage/' prefix if already present to avoid duplication
  path = path.replace(/^storage\//, '');
  return `${baseUrl}/public/storage/${path}`;
}

function assignTicket(id) {
  document.getElementById('assign_ticket_id').value = id;
  document.getElementById('assignModal').style.display = 'flex';
}

function closeAssignModal() {
  document.getElementById('assignModal').style.display = 'none';
}

function submitAssignment(event) {
  event.preventDefault();
  const formData = new FormData(event.target);
  const ticketId = formData.get('assign_ticket_id');
  const employeeId = formData.get('assigned_to');
  
  const updateData = new FormData();
  updateData.append('_method', 'PUT');
  updateData.append('assigned_to', employeeId);
  updateData.append('status', 'in_progress'); // Change status to in_progress
  
  fetch(`{{ url('tickets') }}/${ticketId}`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: updateData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      if (typeof Swal !== 'undefined') {
        Swal.fire({ icon: 'success', title: 'Success', text: 'Ticket assigned successfully!', timer: 1500, showConfirmButton: false });
      } else {
        alert('Ticket assigned successfully!');
      }
      closeAssignModal();
      setTimeout(() => location.reload(), 1000);
    } else {
      if (typeof Swal !== 'undefined') {
        Swal.fire({ icon: 'error', title: 'Error', text: 'Error assigning ticket' });
      } else {
        alert('Error assigning ticket');
      }
    }
  })
  .catch(error => {
    console.error('Error:', error);
    if (typeof Swal !== 'undefined') {
      Swal.fire({ icon: 'error', title: 'Error', text: 'Error assigning ticket' });
    } else {
      alert('Error assigning ticket');
    }
  });
}

// Employee: Mark ticket as complete
function completeTicket(id) {
  if (typeof Swal === 'undefined') {
    const notes = prompt('Resolution notes (optional):');
    performCompleteTicket(id, notes || '', []);
    return;
  }
  
  Swal.fire({
    title: '<strong style="color: #1e293b; font-size: 24px;">✓ Mark as Complete</strong>',
    html: `
      <div style="text-align: left; padding: 0 10px;">
        <p style="color: #64748b; font-size: 14px; margin-bottom: 16px;">
          Add resolution notes and images to document your work (optional).
        </p>
        
        <!-- Resolution Notes -->
        <label style="display: block; font-weight: 600; color: #475569; font-size: 13px; margin-bottom: 6px;">
          📝 Resolution Notes
        </label>
        <textarea 
          id="resolution_notes" 
          class="swal2-textarea" 
          placeholder="Example: Fixed server configuration, Updated software version, etc." 
          style="width: 100%; min-height: 100px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; font-family: inherit; resize: vertical; margin-bottom: 16px;"
        ></textarea>
        
        <!-- Image Upload -->
        <label style="display: block; font-weight: 600; color: #475569; font-size: 13px; margin-bottom: 6px;">
          📷 Completion Images <span style="font-weight: 400; color: #94a3b8; font-size: 12px;">(Optional)</span>
        </label>
        <div style="margin-bottom: 12px;">
          <input 
            type="file" 
            id="completion_images" 
            accept="image/*" 
            multiple 
            style="display: none;"
          />
          <button 
            type="button" 
            onclick="document.getElementById('completion_images').click()" 
            style="width: 100%; padding: 12px; border: 2px dashed #cbd5e1; border-radius: 10px; background: #f8fafc; color: #64748b; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px;"
            onmouseover="this.style.borderColor='#3b82f6'; this.style.background='#eff6ff'; this.style.color='#3b82f6';"
            onmouseout="this.style.borderColor='#cbd5e1'; this.style.background='#f8fafc'; this.style.color='#64748b';"
          >
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
              <circle cx="8.5" cy="8.5" r="1.5"/>
              <polyline points="21 15 16 10 5 21"/>
            </svg>
            Click to upload images
          </button>
          <div id="image_preview" style="margin-top: 12px; display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 8px;"></div>
        </div>
        
        <p style="color: #94a3b8; font-size: 12px; margin-top: 8px; font-style: italic;">
          💡 Tip: Both notes and images are optional. Add what helps document your work!
        </p>
      </div>
    `,
    icon: null,
    showCancelButton: true,
    confirmButtonColor: '#3b82f6',
    cancelButtonColor: '#94a3b8',
    confirmButtonText: '<span style="display: flex; align-items: center; gap: 6px;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg> Mark Complete</span>',
    cancelButtonText: 'Cancel',
    width: '600px',
    padding: '2rem',
    customClass: {
      popup: 'complete-ticket-popup',
      confirmButton: 'complete-confirm-btn',
      cancelButton: 'complete-cancel-btn'
    },
    didOpen: () => {
      // Add custom styles
      const style = document.createElement('style');
      style.textContent = `
        .complete-ticket-popup {
          border-radius: 16px !important;
          box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15) !important;
        }
        .complete-confirm-btn {
          padding: 12px 24px !important;
          border-radius: 10px !important;
          font-weight: 600 !important;
          font-size: 14px !important;
        }
        .complete-cancel-btn {
          padding: 12px 24px !important;
          border-radius: 10px !important;
          font-weight: 600 !important;
          font-size: 14px !important;
        }
        .swal2-textarea:focus {
          border-color: #3b82f6 !important;
          outline: none !important;
          box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
        }
        .image-preview-item {
          position: relative;
          width: 80px;
          height: 80px;
          border-radius: 8px;
          overflow: hidden;
          border: 2px solid #e2e8f0;
        }
        .image-preview-item img {
          width: 100%;
          height: 100%;
          object-fit: cover;
        }
        .image-preview-item .remove-btn {
          position: absolute;
          top: 4px;
          right: 4px;
          background: #ef4444;
          color: white;
          border: none;
          border-radius: 50%;
          width: 20px;
          height: 20px;
          display: flex;
          align-items: center;
          justify-content: center;
          cursor: pointer;
          font-size: 12px;
          line-height: 1;
          opacity: 0.9;
          transition: opacity 0.2s;
        }
        .image-preview-item .remove-btn:hover {
          opacity: 1;
        }
      `;
      document.head.appendChild(style);
      
      // Handle image selection
      const imageInput = document.getElementById('completion_images');
      const imagePreview = document.getElementById('image_preview');
      
      imageInput.addEventListener('change', function(e) {
        imagePreview.innerHTML = '';
        const files = Array.from(e.target.files);
        
        files.forEach((file, index) => {
          if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
              const div = document.createElement('div');
              div.className = 'image-preview-item';
              div.innerHTML = `
                <img src="${e.target.result}" alt="Preview ${index + 1}">
                <button type="button" class="remove-btn" onclick="removeImage(${index})" title="Remove">×</button>
              `;
              imagePreview.appendChild(div);
            };
            reader.readAsDataURL(file);
          }
        });
      });
      
      // Remove image function
      window.removeImage = function(index) {
        const dt = new DataTransfer();
        const files = Array.from(imageInput.files);
        files.splice(index, 1);
        files.forEach(file => dt.items.add(file));
        imageInput.files = dt.files;
        imageInput.dispatchEvent(new Event('change'));
      };
      
      // Auto-focus textarea
      document.getElementById('resolution_notes').focus();
    }
  }).then((result) => {
    if (result.isConfirmed) {
      const notes = document.getElementById('resolution_notes').value.trim();
      const images = document.getElementById('completion_images').files;
      performCompleteTicket(id, notes || 'Completed', images);
    }
  });
}

function performCompleteTicket(id, notes, images) {
  const formData = new FormData();
  formData.append('resolution_notes', notes);
  
  // Add images to form data
  if (images && images.length > 0) {
    Array.from(images).forEach((image, index) => {
      formData.append('completion_images[]', image);
    });
  }
  
  fetch(`{{ url('tickets') }}/${id}/complete`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      if (typeof Swal !== 'undefined') {
        Swal.fire({ icon: 'success', title: 'Success', text: 'Ticket marked as complete! Waiting for admin confirmation.', timer: 2000, showConfirmButton: false });
      } else {
        alert('Ticket marked as complete!');
      }
      setTimeout(() => location.reload(), 1500);
    } else {
      if (typeof Swal !== 'undefined') {
        Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Error completing ticket' });
      } else {
        alert('Error: ' + (data.message || 'Error completing ticket'));
      }
    }
  })
  .catch(error => {
    console.error('Error:', error);
    if (typeof Swal !== 'undefined') {
      Swal.fire({ icon: 'error', title: 'Error', text: 'Error completing ticket' });
    } else {
      alert('Error completing ticket');
    }
  });
}

// Admin: Confirm ticket resolution
function confirmTicket(id) {
  if (typeof Swal === 'undefined') {
    if (confirm('Confirm this ticket as resolved?')) {
      performConfirmTicket(id);
    }
    return;
  }
  
  // Fetch ticket details first
  fetch(`{{ url('tickets') }}/${id}/edit`, {
    method: 'GET',
    headers: {
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success && data.ticket) {
      const ticket = data.ticket;
      const hasNotes = ticket.resolution_notes && ticket.resolution_notes.trim();
      const hasImages = ticket.completion_images && ticket.completion_images.length > 0;
      
      let imagesHtml = '';
      if (hasImages) {
        imagesHtml = `
          <div style="margin-top: 16px;">
            <label style="display: block; font-weight: 600; color: #475569; font-size: 13px; margin-bottom: 8px;">
              📷 Completion Images
            </label>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 8px;">
              ${ticket.completion_images.map((img, idx) => {
                const imgUrl = getStorageUrl(img);
                return `
                  <div style="position: relative; border-radius: 8px; overflow: hidden; border: 2px solid #e2e8f0;">
                    <img src="${imgUrl}" style="width: 100%; height: 100px; object-fit: cover; cursor: pointer;" onclick="window.open('${imgUrl}', '_blank')" title="Click to view full size">
                  </div>
                `;
              }).join('')}
            </div>
          </div>
        `;
      }
      
      Swal.fire({
        title: '<strong style="color: #1e293b; font-size: 22px;">✓ Confirm Resolution</strong>',
        html: `
          <div style="text-align: left; padding: 0 10px;">
            <p style="color: #64748b; font-size: 14px; margin-bottom: 16px;">
              Review the completion details before confirming. The customer will be notified.
            </p>
            
            ${hasNotes ? `
              <div style="margin-bottom: 16px;">
                <label style="display: block; font-weight: 600; color: #475569; font-size: 13px; margin-bottom: 6px;">
                  📝 Resolution Notes
                </label>
                <div style="background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 10px; padding: 12px; font-size: 14px; color: #1e293b; white-space: pre-wrap; word-wrap: break-word;">
                  ${ticket.resolution_notes}
                </div>
              </div>
            ` : `
              <div style="background: #fef3c7; border: 2px solid #fbbf24; border-radius: 10px; padding: 12px; margin-bottom: 16px;">
                <p style="color: #92400e; font-size: 13px; margin: 0;">
                  ⚠️ No resolution notes provided by employee
                </p>
              </div>
            `}
            
            ${hasImages ? imagesHtml : `
              <div style="background: #fef3c7; border: 2px solid #fbbf24; border-radius: 10px; padding: 12px; margin-bottom: 16px;">
                <p style="color: #92400e; font-size: 13px; margin: 0;">
                  ⚠️ No completion images uploaded
                </p>
              </div>
            `}
            
            <div style="margin-top: 20px; padding-top: 16px; border-top: 2px solid #e2e8f0; display: flex; gap: 8px; justify-content: center;">
              <button 
                type="button" 
                onclick="editCompletionData(${id})" 
                style="padding: 8px 16px; background: #f59e0b; color: white; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.2s;"
                onmouseover="this.style.background='#d97706'"
                onmouseout="this.style.background='#f59e0b'"
              >
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                  <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit Details
              </button>
            </div>
          </div>
        `,
        icon: null,
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<span style="display: flex; align-items: center; gap: 6px;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg> Confirm & Notify Customer</span>',
        cancelButtonText: 'Cancel',
        width: '650px',
        padding: '2rem',
        customClass: {
          popup: 'confirm-ticket-popup',
          confirmButton: 'confirm-btn',
          cancelButton: 'cancel-btn'
        },
        didOpen: () => {
          const style = document.createElement('style');
          style.textContent = `
            .confirm-ticket-popup {
              border-radius: 16px !important;
              box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15) !important;
            }
            .confirm-btn, .cancel-btn {
              padding: 12px 24px !important;
              border-radius: 10px !important;
              font-weight: 600 !important;
              font-size: 14px !important;
            }
          `;
          document.head.appendChild(style);
        }
      }).then((result) => {
        if (result.isConfirmed) {
          performConfirmTicket(id);
        }
      });
    } else {
      // Fallback if fetch fails
      Swal.fire({
        title: 'Confirm Resolution',
        text: 'Confirm that this ticket has been properly resolved? The customer will be notified.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Confirm',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          performConfirmTicket(id);
        }
      });
    }
  })
  .catch(error => {
    console.error('Error fetching ticket:', error);
    // Fallback
    Swal.fire({
      title: 'Confirm Resolution',
      text: 'Confirm that this ticket has been properly resolved? The customer will be notified.',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#10b981',
      cancelButtonColor: '#6b7280',
      confirmButtonText: 'Yes, Confirm',
      cancelButtonText: 'Cancel'
    }).then((result) => {
      if (result.isConfirmed) {
        performConfirmTicket(id);
      }
    });
  });
}

function performConfirmTicket(id) {
  fetch(`{{ url('tickets') }}/${id}/confirm`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      if (typeof Swal !== 'undefined') {
        Swal.fire({ icon: 'success', title: 'Success', text: 'Ticket confirmed as resolved! Customer will be notified.', timer: 2000, showConfirmButton: false });
      } else {
        alert('Ticket confirmed as resolved!');
      }
      setTimeout(() => location.reload(), 1500);
    } else {
      if (typeof Swal !== 'undefined') {
        Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Error confirming ticket' });
      } else {
        alert('Error: ' + (data.message || 'Error confirming ticket'));
      }
    }
  })
  .catch(error => {
    console.error('Error:', error);
    if (typeof Swal !== 'undefined') {
      Swal.fire({ icon: 'error', title: 'Error', text: 'Error confirming ticket' });
    } else {
      alert('Error confirming ticket');
    }
  });
}

// Admin: Edit completion data
function editCompletionData(id) {
  // Close current modal
  Swal.close();
  
  // Fetch ticket details
  fetch(`{{ url('tickets') }}/${id}/edit`, {
    method: 'GET',
    headers: {
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success && data.ticket) {
      const ticket = data.ticket;
      const existingImages = ticket.completion_images || [];
      
      let existingImagesHtml = '';
      if (existingImages.length > 0) {
        existingImagesHtml = `
          <div style="margin-bottom: 16px;">
            <label style="display: block; font-weight: 600; color: #475569; font-size: 13px; margin-bottom: 8px;">
              Current Images
            </label>
            <div id="existing_images" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 8px;">
              ${existingImages.map((img, idx) => {
                const imgUrl = getStorageUrl(img);
                return `
                  <div class="existing-image-item" data-image="${img}" style="position: relative; border-radius: 8px; overflow: hidden; border: 2px solid #e2e8f0;">
                    <img src="${imgUrl}" style="width: 100%; height: 100px; object-fit: cover;">
                    <button type="button" onclick="deleteCompletionImage(${id}, '${img}', this)" style="position: absolute; top: 4px; right: 4px; background: #ef4444; color: white; border: none; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 14px; font-weight: bold;" title="Delete">×</button>
                  </div>
                `;
              }).join('')}
            </div>
          </div>
        `;
      }
      
      Swal.fire({
        title: '<strong style="color: #1e293b; font-size: 22px;">✏️ Edit Completion Data</strong>',
        html: `
          <div style="text-align: left; padding: 0 10px;">
            <!-- Resolution Notes -->
            <label style="display: block; font-weight: 600; color: #475569; font-size: 13px; margin-bottom: 6px;">
              📝 Resolution Notes
            </label>
            <textarea 
              id="edit_resolution_notes" 
              class="swal2-textarea" 
              placeholder="Add or update resolution notes..." 
              style="width: 100%; min-height: 100px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; font-family: inherit; resize: vertical; margin-bottom: 16px;"
            >${ticket.resolution_notes || ''}</textarea>
            
            ${existingImagesHtml}
            
            <!-- Add New Images -->
            <label style="display: block; font-weight: 600; color: #475569; font-size: 13px; margin-bottom: 6px;">
              📷 Add New Images
            </label>
            <div style="margin-bottom: 12px;">
              <input 
                type="file" 
                id="edit_completion_images" 
                accept="image/*" 
                multiple 
                style="display: none;"
              />
              <button 
                type="button" 
                onclick="document.getElementById('edit_completion_images').click()" 
                style="width: 100%; padding: 12px; border: 2px dashed #cbd5e1; border-radius: 10px; background: #f8fafc; color: #64748b; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px;"
                onmouseover="this.style.borderColor='#3b82f6'; this.style.background='#eff6ff'; this.style.color='#3b82f6';"
                onmouseout="this.style.borderColor='#cbd5e1'; this.style.background='#f8fafc'; this.style.color='#64748b';"
              >
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                  <circle cx="8.5" cy="8.5" r="1.5"/>
                  <polyline points="21 15 16 10 5 21"/>
                </svg>
                Click to upload new images
              </button>
              <div id="edit_image_preview" style="margin-top: 12px; display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 8px;"></div>
            </div>
          </div>
        `,
        icon: null,
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<span style="display: flex; align-items: center; gap: 6px;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg> Save Changes</span>',
        cancelButtonText: 'Cancel',
        width: '650px',
        padding: '2rem',
        didOpen: () => {
          // Handle new image selection
          const imageInput = document.getElementById('edit_completion_images');
          const imagePreview = document.getElementById('edit_image_preview');
          
          imageInput.addEventListener('change', function(e) {
            imagePreview.innerHTML = '';
            const files = Array.from(e.target.files);
            
            files.forEach((file, index) => {
              if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                  const div = document.createElement('div');
                  div.className = 'image-preview-item';
                  div.style.cssText = 'position: relative; width: 80px; height: 80px; border-radius: 8px; overflow: hidden; border: 2px solid #e2e8f0;';
                  div.innerHTML = `
                    <img src="${e.target.result}" alt="Preview ${index + 1}" style="width: 100%; height: 100%; object-fit: cover;">
                    <button type="button" onclick="removeEditImage(${index})" style="position: absolute; top: 4px; right: 4px; background: #ef4444; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 12px;" title="Remove">×</button>
                  `;
                  imagePreview.appendChild(div);
                };
                reader.readAsDataURL(file);
              }
            });
          });
          
          // Remove new image function
          window.removeEditImage = function(index) {
            const dt = new DataTransfer();
            const files = Array.from(imageInput.files);
            files.splice(index, 1);
            files.forEach(file => dt.items.add(file));
            imageInput.files = dt.files;
            imageInput.dispatchEvent(new Event('change'));
          };
        }
      }).then((result) => {
        if (result.isConfirmed) {
          const notes = document.getElementById('edit_resolution_notes').value.trim();
          const newImages = document.getElementById('edit_completion_images').files;
          performUpdateCompletion(id, notes, newImages);
        }
      });
    }
  })
  .catch(error => {
    console.error('Error:', error);
    Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load ticket data' });
  });
}

function performUpdateCompletion(id, notes, newImages) {
  const formData = new FormData();
  formData.append('resolution_notes', notes);
  
  // Add new images
  if (newImages && newImages.length > 0) {
    Array.from(newImages).forEach((image) => {
      formData.append('completion_images[]', image);
    });
  }
  
  Swal.fire({
    title: 'Updating...',
    text: 'Please wait',
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    }
  });
  
  fetch(`{{ url('tickets') }}/${id}/update-completion`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      Swal.fire({ 
        icon: 'success', 
        title: 'Success', 
        text: 'Completion data updated successfully!', 
        timer: 2000, 
        showConfirmButton: false 
      });
      setTimeout(() => location.reload(), 1500);
    } else {
      Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Failed to update completion data' });
    }
  })
  .catch(error => {
    console.error('Error:', error);
    Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to update completion data' });
  });
}

function deleteCompletionImage(ticketId, imagePath, button) {
  if (!confirm('Delete this image?')) return;
  
  const imageItem = button.closest('.existing-image-item');
  
  fetch(`{{ url('tickets') }}/${ticketId}/delete-completion-image`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: JSON.stringify({ image_path: imagePath })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      imageItem.remove();
      // Show success message
      const msg = document.createElement('div');
      msg.textContent = '✓ Image deleted';
      msg.style.cssText = 'position: fixed; top: 20px; right: 20px; background: #10b981; color: white; padding: 12px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; z-index: 99999;';
      document.body.appendChild(msg);
      setTimeout(() => msg.remove(), 2000);
    } else {
      alert('Failed to delete image: ' + (data.message || 'Unknown error'));
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Failed to delete image');
  });
}

// Customer: Close ticket from index
function closeTicketFromIndex(ticketId) {
  if (typeof Swal === 'undefined') {
    if (confirm('Close this ticket?')) {
      const feedback = prompt('Optional feedback:');
      performCloseTicketFromIndex(ticketId, feedback || '');
    }
    return;
  }
  
  Swal.fire({
    title: '<strong style="color: #1e293b; font-size: 22px;">✓ Close This Ticket?</strong>',
    html: `
      <div style="text-align: left; padding: 0 10px;">
        <p style="color: #64748b; font-size: 14px; margin-bottom: 16px;">
          Are you satisfied with the resolution? Closing this ticket will mark it as complete.
        </p>
        
        <label style="display: block; font-weight: 600; color: #475569; font-size: 13px; margin-bottom: 6px;">
          💬 Feedback (Optional)
        </label>
        <textarea 
          id="customer_feedback_index" 
          class="swal2-textarea" 
          placeholder="Share your experience or any additional comments..." 
          style="width: 100%; min-height: 100px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; font-family: inherit; resize: vertical;"
        ></textarea>
        
        <p style="color: #94a3b8; font-size: 12px; margin-top: 8px; font-style: italic;">
          💡 Your feedback helps us improve our service
        </p>
      </div>
    `,
    icon: null,
    showCancelButton: true,
    confirmButtonColor: '#10b981',
    cancelButtonColor: '#6b7280',
    confirmButtonText: '<span style="display: flex; align-items: center; gap: 6px;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg> Yes, Close Ticket</span>',
    cancelButtonText: 'Cancel',
    width: '550px',
    padding: '2rem',
    didOpen: () => {
      document.getElementById('customer_feedback_index').focus();
    }
  }).then((result) => {
    if (result.isConfirmed) {
      const feedback = document.getElementById('customer_feedback_index').value.trim();
      performCloseTicketFromIndex(ticketId, feedback);
    }
  });
}

function performCloseTicketFromIndex(ticketId, feedback) {
  const formData = new FormData();
  formData.append('feedback', feedback);
  
  if (typeof Swal !== 'undefined') {
    Swal.fire({
      title: 'Closing...',
      text: 'Please wait',
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      }
    });
  }
  
  fetch(`{{ url('tickets') }}/${ticketId}/close`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      if (typeof Swal !== 'undefined') {
        Swal.fire({ 
          icon: 'success', 
          title: 'Ticket Closed!', 
          text: data.message || 'Thank you for your feedback!', 
          timer: 2000, 
          showConfirmButton: false 
        });
      } else {
        alert('Ticket closed successfully!');
      }
      setTimeout(() => location.reload(), 1500);
    } else {
      if (typeof Swal !== 'undefined') {
        Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Failed to close ticket' });
      } else {
        alert('Error: ' + (data.message || 'Failed to close ticket'));
      }
    }
  })
  .catch(error => {
    console.error('Error:', error);
    if (typeof Swal !== 'undefined') {
      Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to close ticket' });
    } else {
      alert('Error closing ticket');
    }
  });
}

// Auto-submit on filter changes (dropdowns only)
document.addEventListener('DOMContentLoaded', function() {
  const filterForm = document.getElementById('ticketFilters');
  const filterSelects = document.querySelectorAll('#ticketFilters select');
  
  filterSelects.forEach(select => {
    select.addEventListener('change', function() {
      filterForm.submit();
    });
  });
  
  // Auto-open edit modal if 'edit' parameter is present in URL
  const urlParams = new URLSearchParams(window.location.search);
  const editTicketId = urlParams.get('edit');
  if (editTicketId) {
    // Remove the edit parameter from URL without reload
    const newUrl = window.location.pathname + window.location.search.replace(/[?&]edit=\d+/, '').replace(/^&/, '?');
    window.history.replaceState({}, document.title, newUrl === window.location.pathname + '?' ? window.location.pathname : newUrl);
    
    // Open edit modal
    setTimeout(() => editTicket(parseInt(editTicketId)), 300);
  }
  
  // Auto-open view/show popup if 'view' parameter is present in URL
  const viewTicketId = urlParams.get('view');
  if (viewTicketId) {
    // Remove the view parameter from URL without reload
    let cleanUrl = window.location.search.replace(/[?&]view=\d+/, '');
    cleanUrl = cleanUrl.replace(/^&/, '?');
    const newUrl = window.location.pathname + (cleanUrl === '?' ? '' : cleanUrl);
    window.history.replaceState({}, document.title, newUrl || window.location.pathname);
    
    // Open view popup
    setTimeout(() => viewTicket(parseInt(viewTicketId)), 300);
  }
  
  // Auto-open edit completion modal if 'edit_completion' parameter is present
  const editCompletionId = urlParams.get('edit_completion');
  if (editCompletionId) {
    // Remove the parameter from URL
    const newUrl = window.location.pathname + window.location.search.replace(/[?&]edit_completion=\d+/, '').replace(/^&/, '?');
    window.history.replaceState({}, document.title, newUrl === window.location.pathname + '?' ? window.location.pathname : newUrl);
    
    // Open edit completion modal
    setTimeout(() => editCompletionData(parseInt(editCompletionId)), 300);
  }
});
</script>
@endsection

@section('footer_pagination')
  @if(isset($tickets) && method_exists($tickets,'links'))
  <form method="GET" class="hrp-entries-form">
    <span>Entries</span>
    @php($currentPerPage = (int) request()->get('per_page', 10))
    <select name="per_page" onchange="this.form.submit()">
      @foreach([10,25,50,100] as $size)
      <option value="{{ $size }}" {{ $currentPerPage === $size ? 'selected' : '' }}>{{ $size }}</option>
      @endforeach
    </select>
    @foreach(request()->except(['per_page','page']) as $k => $v)
    <input type="hidden" name="{{ $k }}" value="{{ $v }}">
    @endforeach
  </form>
  {{ $tickets->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.jv') }}
  @endif
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('tickets.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Ticket Support</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Tickets List</span>
@endsection

@push('styles')
<style>
  /* Chat animations */
  @keyframes slideIn {
    from {
      opacity: 0;
      transform: translateY(10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  /* ========== VIEW TICKET MODAL STYLES ========== */
  .ticket-view-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    box-sizing: border-box;
    backdrop-filter: blur(4px);
  }
  
  .ticket-view-modal-container {
    background: white;
    border-radius: 16px;
    max-width: 1400px;
    width: 95%;
    height: calc(100vh - 100px); /* Leave space for dock */
    max-height: 850px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    display: flex;
    flex-direction: column;
  }
  
  .ticket-view-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-bottom: 1px solid #e5e7eb;
    flex-shrink: 0;
  }
  
  .ticket-view-modal-body {
    display: grid;
    grid-template-columns: 1fr 400px;
    flex: 1;
    overflow: hidden;
    min-height: 0;
  }
  
  .ticket-view-left-column {
    padding: 20px;
    overflow-y: auto;
    border-right: 1px solid #e5e7eb;
  }
  
  .ticket-view-right-column {
    display: flex;
    flex-direction: column;
    background: #f8fafc;
    overflow: hidden;
  }
  
  /* Responsive */
  @media (max-width: 1024px) {
    .ticket-view-modal-container {
      height: calc(100vh - 140px);
      max-height: none;
    }
    
    .ticket-view-modal-body {
      grid-template-columns: 1fr;
      overflow-y: auto;
    }
    
    .ticket-view-left-column {
      border-right: none;
      border-bottom: 1px solid #e5e7eb;
      max-height: none;
      overflow: visible;
    }
    
    .ticket-view-right-column {
      min-height: 350px;
    }
  }
  
  @media (max-width: 640px) {
    .ticket-view-modal-overlay {
      padding: 0;
    }
    
    .ticket-view-modal-container {
      width: 100%;
      max-width: 100%;
      height: calc(100vh - 80px);
      border-radius: 0;
    }
  }
  
  /* Chat tab hover effects */
  #chatTabExternal:hover, #chatTabInternal:hover {
    background: #f1f5f9 !important;
  }

  /* Filter Layout Fix */
  .filter-right {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-left: auto;
  }

  .filter-search {
    order: 1;
  }

  .filter-search:nth-of-type(2) {
    order: 2;
  }

  .filter-pill.live-search {
    order: 3;
    min-width: 280px;
    max-width: 350px;
    padding: 8px 14px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 14px;
    outline: none;
    transition: all 0.2s;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
  
  .filter-pill.live-search:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  }

  .pill-btn {
    order: 4;
  }
  
  /* Chat tab hover effects */
  #chatTabExternal:hover, #chatTabInternal:hover {
    background: #f1f5f9 !important;
  }
</style>
@endpush
