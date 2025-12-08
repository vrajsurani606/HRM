@extends('layouts.macos')
@section('page_title', 'Ticket Support')

@section('content')
<div class="hrp-content">
  <!-- Filters -->
  <form method="GET" action="{{ route('tickets.index') }}" class="jv-filter" id="ticketFilters">
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

    <div class="filter-right">
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

      <input 
        type="text" 
        name="q" 
        id="liveSearch" 
        class="filter-pill live-search" 
        placeholder="Search tickets, customer, status..." 
        value="{{ request('q') }}"
      >

      @if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.create ticket'))
        <button type="button" class="pill-btn pill-success" onclick="openAddTicketModal()" style="display: flex; align-items: center; gap: 8px; margin-left: 8px;">
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
            <td style="text-align: center; padding: 14px;">
              @php
                $isAdmin = auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('admin') || auth()->user()->hasRole('hr');
                $isEmployee = auth()->user()->hasRole('employee') || auth()->user()->hasRole('Employee');
                $isCustomer = auth()->user()->hasRole('customer');
                $employeeRecord = \App\Models\Employee::where('user_id', auth()->id())->first();
                $isAssignedEmployee = $employeeRecord && $ticket->assigned_to == $employeeRecord->id;
              @endphp
              
              <div style="display: inline-flex; gap: 8px; align-items: center; justify-content: center;">
                <!-- View/Edit/Delete Actions -->
                @if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.view ticket'))
                  <img src="{{ asset('action_icon/view.svg') }}" alt="View" class="action-icon" onclick="viewTicket({{ $ticket->id }})" title="View">
                @endif
                @if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.edit ticket'))
                  <img src="{{ asset('action_icon/edit.svg') }}" alt="Edit" class="action-icon" onclick="editTicket({{ $ticket->id }})" title="Edit">
                @endif
                @if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.delete ticket'))
                  <img src="{{ asset('action_icon/delete.svg') }}" alt="Delete" class="action-icon" onclick="deleteTicket({{ $ticket->id }})" title="Delete">
                @endif
                
                <!-- Workflow Actions -->
                @if($isAdmin && $ticket->status === 'completed')
                  <!-- Admin: Confirm Completion -->
                  <img src="{{ asset('action_icon/approve.svg') }}" alt="Confirm" class="action-icon" onclick="confirmTicket({{ $ticket->id }})" title="Confirm Resolution">
                @elseif($isEmployee && $isAssignedEmployee && in_array($ticket->status, ['assigned', 'in_progress']))
                  <!-- Employee: Mark as Complete -->
                  <img src="{{ asset('action_icon/completed.svg') }}" alt="Complete" class="action-icon" onclick="completeTicket({{ $ticket->id }})" title="Mark as Complete">
                @elseif($isCustomer && $ticket->status === 'resolved')
                  <!-- Customer: Close Ticket -->
                  <img src="{{ asset('action_icon/reject.svg') }}" alt="Close" class="action-icon" onclick="closeTicketFromIndex({{ $ticket->id }})" title="Close Ticket">
                @endif
              </div>
            </td>
            <td style="padding: 14px 16px; text-align: center; font-weight: 600; color: #64748b;">{{ ($tickets->currentPage()-1) * $tickets->perPage() + $i + 1 }}</td>
            <td style="padding: 14px 16px;">
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
            <td style="padding: 14px 16px;">
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
                $statusColor = $statusColors[$ticket->status] ?? '#6b7280';
                $statusBackground = $statusBg[$ticket->status] ?? '#f3f4f6';
                $statusText = match($ticket->status) {
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
            <td style="padding: 14px 16px;">
              @if($ticket->assignedEmployee)
                <div style="display: flex; align-items: center; gap: 10px;">
                  @if($ticket->assignedEmployee->photo_path)
                    <img src="{{ storage_asset($ticket->assignedEmployee->photo_path) }}" alt="{{ $ticket->assignedEmployee->name }}" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; flex-shrink: 0; border: 2px solid #e5e7eb;">
                  @else
                    <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #8b5cf6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 13px; flex-shrink: 0;">
                      {{ strtoupper(substr($ticket->assignedEmployee->name, 0, 1)) }}
                    </div>
                  @endif
                  <div style="display: flex; align-items: center; gap: 8px; flex: 1;">
                    <span style="color: #0f172a; font-size: 14px; font-weight: 600; white-space: nowrap;">{{ $ticket->assignedEmployee->name }}</span>
                    @if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.reassign ticket'))
                      <button onclick="assignTicket({{ $ticket->id }})" style="background: #f8fafc; border: 1px solid #e2e8f0; cursor: pointer; padding: 4px 10px; border-radius: 6px; font-size: 11px; color: #64748b; font-weight: 600; transition: all 0.2s; display: inline-flex; align-items: center; gap: 4px; white-space: nowrap;" onmouseover="this.style.background='#f1f5f9'; this.style.borderColor='#cbd5e1'" onmouseout="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'" title="Reassign to another employee">
                        <svg width="11" height="11" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                        </svg>
                        <span>Reassign</span>
                      </button>
                    @endif
                  </div>
                </div>
              @else
                @if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.assign ticket'))
                  <button onclick="assignTicket({{ $ticket->id }})" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; cursor: pointer; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; transition: all 0.3s; box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(59, 130, 246, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(59, 130, 246, 0.3)'" title="Assign this ticket to an employee">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    <span style="white-space: nowrap;">Assign Employee</span>
                  </button>
                @else
                  <span style="color: #9ca3af; font-size: 13px; font-style: italic;">Not assigned</span>
                @endif
              @endif
            </td>
            @if(!auth()->user()->hasRole('customer'))
            <td style="padding: 14px 16px;">{{ $ticket->category ?? 'General Inquiry' }}</td>
            <td style="padding: 14px 16px;">{{ $ticket->customer ?? '-' }}</td>
            @else
            <td style="padding: 14px 16px;">{{ $ticket->category ?? 'General Inquiry' }}</td>
            @endif
            <td style="padding: 14px 16px;">{{ $ticket->title ?? $ticket->subject ?? '-' }}</td>
            <td style="padding: 14px 16px;">{{ Str::limit($ticket->description ?? 'Ok', 50) }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="{{ auth()->user()->hasRole('customer') ? '6' : '9' }}" style="text-align: center; padding: 40px; color: #9ca3af;">
              <p style="font-weight: 600; margin: 0;">No tickets found</p>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</div>

<!-- Add/Edit Ticket Modal -->
<div id="ticketModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
  <div style="background: white; border-radius: 15px; padding: 30px; max-width: 600px; width: 90%; max-height: 90vh; overflow-y: auto; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
    <h3 id="modalTitle" style="margin: 0 0 20px 0; font-size: 22px; font-weight: 700;">Add Ticket</h3>
    
    <form id="ticketForm" onsubmit="submitTicket(event)">
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
          
          @if($isAdmin)
            <div>
              <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Work Status</label>
              <select name="work_status" id="ticket_work_status" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                <option value="not_assigned">Not Assigned</option>
                <option value="in_progress">In Progress</option>
                <option value="on_hold">On Hold</option>
                <option value="completed">Completed</option>
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
              <input type="radio" name="priority" value="normal" style="margin-right: 6px;">
              <span style="font-size: 13px; font-weight: 600;">Normal</span>
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

      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Description <span style="color: #ef4444;">*</span></label>
        <textarea name="description" id="ticket_description" rows="4" required placeholder="Please provide detailed information about your issue..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; resize: vertical;"></textarea>
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
  document.querySelectorAll('input[name="priority"]').forEach(radio => {
    const label = radio.closest('label');
    if (radio.checked) {
      label.style.borderColor = '#3b82f6';
      label.style.background = '#eff6ff';
    } else {
      label.style.borderColor = '#e5e7eb';
      label.style.background = 'white';
    }
  });
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

<script>
function openAddTicketModal() {
  document.getElementById('modalTitle').textContent = 'Add Ticket';
  document.getElementById('ticketForm').reset();
  document.getElementById('ticket_id').value = '';
  document.getElementById('ticketModal').style.display = 'flex';
}

function closeTicketModal() {
  document.getElementById('ticketModal').style.display = 'none';
}

function submitTicket(event) {
  event.preventDefault();
  const formData = new FormData(event.target);
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
  // Redirect to ticket show/edit page
  window.location.href = `{{ url('tickets') }}/${id}`;
}

function viewTicket(id) {
  window.location.href = `{{ url('tickets') }}/${id}`;
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
  const baseUrl = '{{ url('/') }}';
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
  updateData.append('work_status', 'in_progress'); // Set work status
  
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

// Live search functionality
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('liveSearch');
  const filterForm = document.getElementById('ticketFilters');
  
  if (searchInput && filterForm) {
    let searchTimeout;
    
    searchInput.addEventListener('input', function() {
      clearTimeout(searchTimeout);
      
      // Show loading indicator
      searchInput.style.background = '#f8fafc url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'20\' height=\'20\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%236b7280\' stroke-width=\'2\'%3E%3Cpath d=\'M21 12a9 9 0 1 1-6.219-8.56\'/%3E%3C/svg%3E") no-repeat right 12px center';
      searchInput.style.backgroundSize = '16px';
      searchInput.style.animation = 'spin 1s linear infinite';
      
      searchTimeout = setTimeout(() => {
        filterForm.submit();
      }, 800); // 800ms delay for better UX
    });
    
    // Add CSS animation for loading spinner
    const style = document.createElement('style');
    style.textContent = `
      @keyframes spin {
        from { background-position: right 12px center; transform: rotate(0deg); }
        to { background-position: right 12px center; transform: rotate(360deg); }
      }
    `;
    document.head.appendChild(style);
  }
  
  // Auto-submit on filter changes
  const filterSelects = document.querySelectorAll('#ticketFilters select');
  filterSelects.forEach(select => {
    select.addEventListener('change', function() {
      filterForm.submit();
    });
  });
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
  /* Search Input Fix */
  .filter-pill.live-search {
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
</style>
@endpush
