<?php $__env->startSection('page_title', 'Ticket Support'); ?>

<?php $__env->startSection('content'); ?>
<div class="hrp-content">
  <!-- Filters -->
  <form method="GET" action="<?php echo e(route('tickets.index')); ?>" class="jv-filter" id="ticketFilters">
    <select class="filter-pill" name="status">
      <option value="">All Status</option>
      <option value="open" <?php echo e(request('status') == 'open' ? 'selected' : ''); ?>>Open</option>
      <option value="in_progress" <?php echo e(request('status') == 'in_progress' ? 'selected' : ''); ?>>In Progress</option>
      <option value="resolved" <?php echo e(request('status') == 'resolved' ? 'selected' : ''); ?>>Resolved</option>
      <option value="closed" <?php echo e(request('status') == 'closed' ? 'selected' : ''); ?>>Closed</option>
    </select>

    <select class="filter-pill" name="priority">
      <option value="">All Priority</option>
      <option value="low" <?php echo e(request('priority') == 'low' ? 'selected' : ''); ?>>Low</option>
      <option value="medium" <?php echo e(request('priority') == 'medium' ? 'selected' : ''); ?>>Medium</option>
      <option value="high" <?php echo e(request('priority') == 'high' ? 'selected' : ''); ?>>High</option>
      <option value="urgent" <?php echo e(request('priority') == 'urgent' ? 'selected' : ''); ?>>Urgent</option>
    </select>

    <select class="filter-pill" name="company">
      <option value="">All Companies</option>
      <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($company); ?>" <?php echo e(request('company') == $company ? 'selected' : ''); ?>><?php echo e($company); ?></option>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <button type="submit" class="filter-search" aria-label="Search">
      <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
      </svg>
    </button>

    <a href="<?php echo e(route('tickets.index')); ?>" class="filter-search" aria-label="Refresh">
      <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
        <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
      </svg>
    </a>

    <div class="filter-right">
      <input name="q" class="filter-pill" placeholder="Search tickets..." value="<?php echo e(request('q')); ?>">
      <?php if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.create ticket')): ?>
        <button type="button" class="pill-btn pill-success" onclick="openAddTicketModal()" style="display: flex; align-items: center; gap: 8px;">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
          </svg>
          Add Ticket
        </button>
      <?php endif; ?>
    </div>
  </form>

  <!-- Data Table -->
  <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
    <table>
      <thead>
        <tr>
          <th style="width: 100px; text-align: center;">Action</th>
          <th style="width: 100px;">Serial No.</th>
          <th style="width: 120px;">Ticket</th>
          <th style="width: 180px;">Work by Emp.</th>
          <th style="width: 150px;">Category</th>
          <th style="width: 300px;">Customer</th>
          <th style="width: 250px;">Title</th>
          <th style="width: 300px;">Description</th>
        </tr>
      </thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td style="text-align: center; padding: 14px;">
              <div style="display: inline-flex; gap: 8px; align-items: center;">
                <?php if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.view ticket')): ?>
                  <img src="<?php echo e(asset('action_icon/view.svg')); ?>" alt="View" style="cursor: pointer; width: 18px; height: 18px;" onclick="viewTicket(<?php echo e($ticket->id); ?>)" title="View">
                <?php endif; ?>
                <?php if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.edit ticket')): ?>
                  <img src="<?php echo e(asset('action_icon/edit.svg')); ?>" alt="Edit" style="cursor: pointer; width: 18px; height: 18px;" onclick="editTicket(<?php echo e($ticket->id); ?>)" title="Edit">
                <?php endif; ?>
                <?php if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.delete ticket')): ?>
                  <img src="<?php echo e(asset('action_icon/delete.svg')); ?>" alt="Delete" style="cursor: pointer; width: 18px; height: 18px;" onclick="deleteTicket(<?php echo e($ticket->id); ?>)" title="Delete">
                <?php endif; ?>
              </div>
            </td>
            <td style="padding: 14px 16px; text-align: center;"><?php echo e(($tickets->currentPage()-1) * $tickets->perPage() + $i + 1); ?></td>
            <td style="padding: 14px 16px;">
              <?php
                $statusColors = [
                  'open' => '#3b82f6',
                  'needs_approval' => '#9333ea',
                  'in_progress' => '#f59e0b',
                  'resolved' => '#10b981',
                  'closed' => '#10b981',
                ];
                $statusColor = $statusColors[$ticket->status] ?? '#6b7280';
                $statusText = match($ticket->status) {
                  'needs_approval' => 'Needs Approval',
                  'in_progress' => 'In Progress',
                  'closed' => 'Closed',
                  default => ucfirst($ticket->status ?? 'Open')
                };
              ?>
              <span style="color: <?php echo e($statusColor); ?>; font-weight: 600; font-size: 14px;"><?php echo e($statusText); ?></span>
            </td>
            <td style="padding: 14px 16px;">
              <?php if($ticket->assignedEmployee): ?>
                <?php
                  $workStatusColor = match($ticket->work_status) {
                    'completed' => '#10b981',
                    'in_progress' => '#3b82f6',
                    'on_hold' => '#f59e0b',
                    'not_assigned' => '#6b7280',
                    default => '#3b82f6'
                  };
                  $workStatusText = $ticket->work_status ? ucfirst(str_replace('_', ' ', $ticket->work_status)) : 'Assigned';
                  $workStatusBg = match($ticket->work_status) {
                    'completed' => '#d1fae5',
                    'in_progress' => '#dbeafe',
                    'on_hold' => '#fef3c7',
                    'not_assigned' => '#f3f4f6',
                    default => '#dbeafe'
                  };
                ?>
                <div style="display: flex; flex-direction: column; gap: 6px;">
                  <div style="display: flex; align-items: center; gap: 6px; background: <?php echo e($workStatusBg); ?>; padding: 4px 10px; border-radius: 12px; width: fit-content;">
                    <svg width="12" height="12" fill="<?php echo e($workStatusColor); ?>" viewBox="0 0 24 24">
                      <?php if($ticket->work_status === 'completed'): ?>
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                      <?php else: ?>
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                      <?php endif; ?>
                    </svg>
                    <span style="color: <?php echo e($workStatusColor); ?>; font-weight: 600; font-size: 13px;"><?php echo e($workStatusText); ?></span>
                  </div>
                  <div style="display: flex; align-items: center; gap: 8px;">
                    <svg width="14" height="14" fill="#6b7280" viewBox="0 0 24 24">
                      <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    <span style="color: #374151; font-size: 13px; font-weight: 500;"><?php echo e($ticket->assignedEmployee->name); ?></span>
                    <?php if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.reassign ticket')): ?>
                      <button onclick="assignTicket(<?php echo e($ticket->id); ?>)" style="background: #f3f4f6; border: 1px solid #e5e7eb; cursor: pointer; padding: 3px 8px; border-radius: 6px; font-size: 11px; color: #6b7280; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'" title="Reassign">
                        <svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24" style="vertical-align: middle;">
                          <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                        </svg>
                      </button>
                    <?php endif; ?>
                  </div>
                </div>
              <?php else: ?>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                  <?php if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.assign ticket')): ?>
                    <button onclick="assignTicket(<?php echo e($ticket->id); ?>)" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border: none; padding: 6px 14px; border-radius: 8px; font-size: 13px; cursor: pointer; font-weight: 600; display: flex; align-items: center; gap: 6px; transition: all 0.3s; box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(59, 130, 246, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(59, 130, 246, 0.3)'">
                      <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                      </svg>
                      Assign Employee
                    </button>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
            </td>
            <td style="padding: 14px 16px;"><?php echo e($ticket->category ?? 'General Inquiry'); ?></td>
            <td style="padding: 14px 16px;"><?php echo e($ticket->customer ?? '-'); ?></td>
            <td style="padding: 14px 16px;"><?php echo e($ticket->title ?? $ticket->subject ?? '-'); ?></td>
            <td style="padding: 14px 16px;"><?php echo e(Str::limit($ticket->description ?? 'Ok', 50)); ?></td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="8" style="text-align: center; padding: 40px; color: #9ca3af;">
              <p style="font-weight: 600; margin: 0;">No tickets found</p>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <?php if($tickets->hasPages()): ?>
  <div style="margin-top: 20px; display: flex; justify-content: center;">
    <?php echo e($tickets->links()); ?>

  </div>
  <?php endif; ?>
</div>

<!-- Add/Edit Ticket Modal -->
<div id="ticketModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
  <div style="background: white; border-radius: 15px; padding: 30px; max-width: 600px; width: 90%; max-height: 90vh; overflow-y: auto; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
    <h3 id="modalTitle" style="margin: 0 0 20px 0; font-size: 22px; font-weight: 700;">Add Ticket</h3>
    
    <form id="ticketForm" onsubmit="submitTicket(event)">
      <input type="hidden" name="ticket_id" id="ticket_id">
      
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
        <?php if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.change status') || auth()->user()->can('Tickets Management.create ticket')): ?>
          <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Ticket Status</label>
            <select name="status" id="ticket_status" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
              <option value="open">Open</option>
              <option value="needs_approval">Needs Approval</option>
              <option value="in_progress">In Progress</option>
              <option value="resolved">Resolved</option>
              <option value="closed">Closed</option>
            </select>
          </div>
        <?php endif; ?>
        
        <?php if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.change work status') || auth()->user()->can('Tickets Management.create ticket')): ?>
          <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Work Status</label>
            <select name="work_status" id="ticket_work_status" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
              <option value="not_assigned">Not Assigned</option>
              <option value="in_progress">In Progress</option>
              <option value="on_hold">On Hold</option>
              <option value="completed">Completed</option>
            </select>
          </div>
        <?php endif; ?>
      </div>

      <?php if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.assign ticket') || auth()->user()->can('Tickets Management.reassign ticket') || auth()->user()->can('Tickets Management.create ticket')): ?>
        <div style="margin-bottom: 15px;">
          <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Assign To Employee</label>
          <select name="assigned_to" id="ticket_assigned_to" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
            <option value="">Not Assigned</option>
            <?php $__currentLoopData = \App\Models\Employee::orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($emp->id); ?>"><?php echo e($emp->name); ?> - <?php echo e($emp->position ?? 'N/A'); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>
      <?php endif; ?>

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

      <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Title/Subject</label>
        <input type="text" name="title" id="ticket_title" required placeholder="Ticket Title" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
      </div>

      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Description</label>
        <textarea name="description" id="ticket_description" rows="4" required placeholder="Describe the issue..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; resize: vertical;"></textarea>
      </div>

      <div style="display: flex; gap: 10px; justify-content: flex-end;">
        <button type="button" onclick="closeTicketModal()" style="padding: 10px 20px; border: 1px solid #ddd; background: white; border-radius: 8px; cursor: pointer; font-weight: 600;">Cancel</button>
        <button type="submit" style="padding: 10px 20px; border: none; background: #10b981; color: white; border-radius: 8px; cursor: pointer; font-weight: 600;">Save Ticket</button>
      </div>
    </form>
  </div>
</div>

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
          <?php $__currentLoopData = \App\Models\Employee::orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($emp->id); ?>"><?php echo e($emp->name); ?> - <?php echo e($emp->position ?? 'N/A'); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
  const url = ticketId ? `<?php echo e(url('tickets')); ?>/${ticketId}` : '<?php echo e(route("tickets.store")); ?>';
  const method = 'POST';
  
  if (ticketId) {
    formData.append('_method', 'PUT');
  }
  
  fetch(url, {
    method: method,
    headers: {
      'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      toastr.success(data.message);
      closeTicketModal();
      setTimeout(() => location.reload(), 1000);
    } else {
      toastr.error('Error: ' + (data.message || 'Unknown error'));
    }
  })
  .catch(error => {
    console.error('Error:', error);
    toastr.error('Error saving ticket');
  });
}

function editTicket(id) {
  fetch(`<?php echo e(url('tickets')); ?>/${id}/edit`, {
    headers: {
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      const ticket = data.ticket;
      document.getElementById('modalTitle').textContent = 'Edit Ticket';
      document.getElementById('ticket_id').value = ticket.id;
      document.getElementById('ticket_status').value = ticket.status || 'open';
      document.getElementById('ticket_work_status').value = ticket.work_status || '';
      document.getElementById('ticket_assigned_to').value = ticket.assigned_to || '';
      document.getElementById('ticket_category').value = ticket.category || '';
      document.getElementById('ticket_company').value = ticket.company || '';
      document.getElementById('ticket_customer').value = ticket.customer || '';
      document.getElementById('ticket_title').value = ticket.title || ticket.subject || '';
      document.getElementById('ticket_description').value = ticket.description || '';
      document.getElementById('ticketModal').style.display = 'flex';
    } else {
      toastr.error('Error loading ticket data');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    toastr.error('Error loading ticket data');
  });
}

function viewTicket(id) {
  window.location.href = `<?php echo e(url('tickets')); ?>/${id}`;
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
  
  fetch(`<?php echo e(url('tickets')); ?>/${id}`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      toastr.success('Ticket deleted successfully!');
      setTimeout(() => location.reload(), 1000);
    } else {
      toastr.error('Error deleting ticket');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    toastr.error('Error deleting ticket');
  });
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
  
  fetch(`<?php echo e(url('tickets')); ?>/${ticketId}`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: updateData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      toastr.success('Ticket assigned successfully!');
      closeAssignModal();
      setTimeout(() => location.reload(), 1000);
    } else {
      toastr.error('Error assigning ticket');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    toastr.error('Error assigning ticket');
  });
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/tickets/index.blade.php ENDPATH**/ ?>