// Project Tasks Management with Employee Assignment and Time

let employeesList = [];

// Load employees list on page load
async function loadEmployeesList() {
    try {
        const response = await fetch('/projects/employees/list', {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });
        const data = await response.json();
        if (data.success && data.employees) {
            employeesList = data.employees;
        }
    } catch (error) {
        console.error('Error loading employees:', error);
    }
}

// Call on page load
if (typeof projectId !== 'undefined') {
    loadEmployeesList();
}

// Enhanced Add New Task Function
window.addNewTaskEnhanced = async function() {
    if (typeof Swal === 'undefined') return;
    
    // Build employees options
    let employeesOptions = '<option value="">Select Employee (Optional)</option>';
    employeesList.forEach(emp => {
        employeesOptions += `<option value="${emp.id}">${emp.name}</option>`;
    });
    
    Swal.fire({
        title: '<div style="display: flex; align-items: center; gap: 12px; justify-content: center;"><div style="width: 48px; height: 48px; background: linear-gradient(135deg, #eff6ff, #dbeafe); border-radius: 12px; display: flex; align-items: center; justify-content: center;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg></div><strong style="color: #111827; font-size: 26px; font-weight: 700; letter-spacing: -0.5px;">Add New Task</strong></div>',
        html: `
            <div style="text-align: left; padding: 16px 8px;">
                <div style="background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%); border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; margin-bottom: 20px;">
                    <div style="margin-bottom: 20px;">
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 700; color: #1f2937; margin-bottom: 10px; letter-spacing: 0.2px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            Task Title <span style="color: #ef4444; margin-left: 2px;">*</span>
                        </label>
                        <input id="taskTitle" class="swal2-input" placeholder="e.g., Design homepage mockup" 
                               style="width: 100%; margin: 0; padding: 14px 16px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-weight: 500; transition: all 0.2s; background: white; box-shadow: 0 1px 2px rgba(0,0,0,0.05);"
                               onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)'"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='0 1px 2px rgba(0,0,0,0.05)'">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 700; color: #1f2937; margin-bottom: 10px; letter-spacing: 0.2px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            </svg>
                            Description
                        </label>
                        <textarea id="taskDescription" class="swal2-textarea" placeholder="Task details..." 
                               style="width: 100%; margin: 0; padding: 14px 16px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-weight: 500; transition: all 0.2s; background: white; box-shadow: 0 1px 2px rgba(0,0,0,0.05); min-height: 80px; resize: vertical;"
                               onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 3px rgba(139,92,246,0.1)'"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='0 1px 2px rgba(0,0,0,0.05)'"></textarea>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 700; color: #1f2937; margin-bottom: 10px; letter-spacing: 0.2px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Assign To
                        </label>
                        <select id="taskAssignedTo" class="swal2-select" 
                               style="width: 100%; margin: 0; padding: 14px 16px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-weight: 500; transition: all 0.2s; background: white; box-shadow: 0 1px 2px rgba(0,0,0,0.05);"
                               onfocus="this.style.borderColor='#f59e0b'; this.style.boxShadow='0 0 0 3px rgba(245,158,11,0.1)'"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='0 1px 2px rgba(0,0,0,0.05)'">
                            ${employeesOptions}
                        </select>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div>
                            <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 700; color: #1f2937; margin-bottom: 10px; letter-spacing: 0.2px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                Due Date
                            </label>
                            <input id="taskDueDate" type="date" class="swal2-input" 
                                   style="width: 100%; margin: 0; padding: 14px 16px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-weight: 500; transition: all 0.2s; background: white; box-shadow: 0 1px 2px rgba(0,0,0,0.05);"
                                   onfocus="this.style.borderColor='#10b981'; this.style.boxShadow='0 0 0 3px rgba(16,185,129,0.1)'"
                                   onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='0 1px 2px rgba(0,0,0,0.05)'">
                        </div>
                        <div>
                            <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 700; color: #1f2937; margin-bottom: 10px; letter-spacing: 0.2px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#06b6d4" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                Due Time
                            </label>
                            <input id="taskDueTime" type="time" class="swal2-input" 
                                   style="width: 100%; margin: 0; padding: 14px 16px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-weight: 500; transition: all 0.2s; background: white; box-shadow: 0 1px 2px rgba(0,0,0,0.05);"
                                   onfocus="this.style.borderColor='#06b6d4'; this.style.boxShadow='0 0 0 3px rgba(6,182,212,0.1)'"
                                   onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='0 1px 2px rgba(0,0,0,0.05)'">
                        </div>
                    </div>
                </div>
                <div style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-radius: 8px; padding: 12px 16px; display: flex; align-items: start; gap: 10px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" style="flex-shrink: 0; margin-top: 2px;">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <p style="margin: 0; font-size: 13px; color: #1e40af; line-height: 1.5; font-weight: 500;">
                        Assign tasks to specific employees with due dates and times for better tracking.
                    </p>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right: 6px;"><polyline points="20 6 9 17 4 12"></polyline></svg> Create Task',
        cancelButtonText: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 6px;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> Cancel',
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#6b7280',
        width: '650px',
        padding: '32px 24px 24px 24px',
        customClass: {
            popup: 'custom-swal-popup',
            confirmButton: 'custom-swal-confirm',
            cancelButton: 'custom-swal-cancel'
        },
        didOpen: () => {
            document.getElementById('taskTitle').focus();
        },
        preConfirm: () => {
            const title = document.getElementById('taskTitle').value.trim();
            if (!title) {
                Swal.showValidationMessage('⚠️ Please enter a task title');
                return false;
            }
            return {
                title: title,
                description: document.getElementById('taskDescription').value.trim(),
                assigned_to: document.getElementById('taskAssignedTo').value || null,
                due_date: document.getElementById('taskDueDate').value || null,
                due_time: document.getElementById('taskDueTime').value || null
            };
        }
    }).then(async (result) => {
        if (result.isConfirmed && typeof projectId !== 'undefined') {
            try {
                const response = await fetch(`/projects/${projectId}/tasks`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(result.value)
                });

                const data = await response.json();
                if (data.success) {
                    if (typeof toastr !== 'undefined') {
                        toastr.success('Task created successfully!');
                    }
                    // Reload tasks if function exists
                    if (typeof loadTasks === 'function') {
                        await loadTasks();
                    }
                    // Reload project data if function exists
                    if (typeof loadProjectData === 'function') {
                        await loadProjectData();
                    }
                } else {
                    if (typeof toastr !== 'undefined') {
                        toastr.error(data.message || 'Failed to create task');
                    }
                }
            } catch (error) {
                console.error('Error creating task:', error);
                if (typeof toastr !== 'undefined') {
                    toastr.error('Error creating task: ' + error.message);
                }
            }
        }
    });
};

// Override the original addNewTask function
window.addNewTask = window.addNewTaskEnhanced;


// Enhanced Edit Task Function
window.editTaskEnhanced = async function(taskId) {
    if (typeof Swal === 'undefined' || typeof tasksData === 'undefined') return;
    
    const task = tasksData.find(t => t.id === taskId);
    if (!task) return;
    
    // Build employees options
    let employeesOptions = '<option value="">Select Employee (Optional)</option>';
    employeesList.forEach(emp => {
        const selected = task.assigned_to == emp.id ? 'selected' : '';
        employeesOptions += `<option value="${emp.id}" ${selected}>${emp.name}</option>`;
    });
    
    Swal.fire({
        title: '<div style="display: flex; align-items: center; gap: 12px; justify-content: center;"><div style="width: 48px; height: 48px; background: linear-gradient(135deg, #fff7ed, #fed7aa); border-radius: 12px; display: flex; align-items: center; justify-content: center;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></div><strong style="color: #111827; font-size: 26px; font-weight: 700; letter-spacing: -0.5px;">Edit Task</strong></div>',
        html: `
            <div style="text-align: left; padding: 16px 8px;">
                <div style="background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%); border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; margin-bottom: 20px;">
                    <div style="margin-bottom: 20px;">
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 700; color: #1f2937; margin-bottom: 10px; letter-spacing: 0.2px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            Task Title <span style="color: #ef4444; margin-left: 2px;">*</span>
                        </label>
                        <input id="editTaskTitle" class="swal2-input" value="${task.title || ''}" placeholder="e.g., Design homepage mockup" 
                               style="width: 100%; margin: 0; padding: 14px 16px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-weight: 500; transition: all 0.2s; background: white; box-shadow: 0 1px 2px rgba(0,0,0,0.05);"
                               onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)'"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='0 1px 2px rgba(0,0,0,0.05)'">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 700; color: #1f2937; margin-bottom: 10px; letter-spacing: 0.2px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            </svg>
                            Description
                        </label>
                        <textarea id="editTaskDescription" class="swal2-textarea" placeholder="Task details..." 
                               style="width: 100%; margin: 0; padding: 14px 16px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-weight: 500; transition: all 0.2s; background: white; box-shadow: 0 1px 2px rgba(0,0,0,0.05); min-height: 80px; resize: vertical;"
                               onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 3px rgba(139,92,246,0.1)'"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='0 1px 2px rgba(0,0,0,0.05)'">${task.description || ''}</textarea>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 700; color: #1f2937; margin-bottom: 10px; letter-spacing: 0.2px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Assign To
                        </label>
                        <select id="editTaskAssignedTo" class="swal2-select" 
                               style="width: 100%; margin: 0; padding: 14px 16px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-weight: 500; transition: all 0.2s; background: white; box-shadow: 0 1px 2px rgba(0,0,0,0.05);"
                               onfocus="this.style.borderColor='#f59e0b'; this.style.boxShadow='0 0 0 3px rgba(245,158,11,0.1)'"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='0 1px 2px rgba(0,0,0,0.05)'">
                            ${employeesOptions}
                        </select>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div>
                            <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 700; color: #1f2937; margin-bottom: 10px; letter-spacing: 0.2px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                Due Date
                            </label>
                            <input id="editTaskDueDate" type="date" class="swal2-input" value="${task.due_date || ''}"
                                   style="width: 100%; margin: 0; padding: 14px 16px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-weight: 500; transition: all 0.2s; background: white; box-shadow: 0 1px 2px rgba(0,0,0,0.05);"
                                   onfocus="this.style.borderColor='#10b981'; this.style.boxShadow='0 0 0 3px rgba(16,185,129,0.1)'"
                                   onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='0 1px 2px rgba(0,0,0,0.05)'">
                        </div>
                        <div>
                            <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 700; color: #1f2937; margin-bottom: 10px; letter-spacing: 0.2px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#06b6d4" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                Due Time
                            </label>
                            <input id="editTaskDueTime" type="time" class="swal2-input" value="${task.due_time || ''}"
                                   style="width: 100%; margin: 0; padding: 14px 16px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-weight: 500; transition: all 0.2s; background: white; box-shadow: 0 1px 2px rgba(0,0,0,0.05);"
                                   onfocus="this.style.borderColor='#06b6d4'; this.style.boxShadow='0 0 0 3px rgba(6,182,212,0.1)'"
                                   onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='0 1px 2px rgba(0,0,0,0.05)'">
                        </div>
                    </div>
                </div>
                <div style="background: linear-gradient(135deg, #fff7ed 0%, #fed7aa 100%); border-radius: 8px; padding: 12px 16px; display: flex; align-items: start; gap: 10px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" style="flex-shrink: 0; margin-top: 2px;">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <p style="margin: 0; font-size: 13px; color: #92400e; line-height: 1.5; font-weight: 500;">
                        Update task details, reassign to different employees, or modify deadlines.
                    </p>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right: 6px;"><polyline points="20 6 9 17 4 12"></polyline></svg> Update Task',
        cancelButtonText: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 6px;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> Cancel',
        confirmButtonColor: '#f59e0b',
        cancelButtonColor: '#6b7280',
        width: '650px',
        padding: '32px 24px 24px 24px',
        customClass: {
            popup: 'custom-swal-popup',
            confirmButton: 'custom-swal-confirm',
            cancelButton: 'custom-swal-cancel'
        },
        didOpen: () => {
            document.getElementById('editTaskTitle').focus();
        },
        preConfirm: () => {
            const title = document.getElementById('editTaskTitle').value.trim();
            if (!title) {
                Swal.showValidationMessage('⚠️ Please enter a task title');
                return false;
            }
            return {
                title: title,
                description: document.getElementById('editTaskDescription').value.trim(),
                assigned_to: document.getElementById('editTaskAssignedTo').value || null,
                due_date: document.getElementById('editTaskDueDate').value || null,
                due_time: document.getElementById('editTaskDueTime').value || null
            };
        }
    }).then(async (result) => {
        if (result.isConfirmed && typeof projectId !== 'undefined') {
            try {
                const response = await fetch(`/projects/${projectId}/tasks/${taskId}`, {
                    method: 'PUT',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(result.value)
                });

                const data = await response.json();
                console.log('Update response:', data); // Debug log
                
                if (data.success) {
                    if (typeof toastr !== 'undefined') {
                        toastr.success('Task updated successfully!');
                    }
                    // Reload tasks if function exists
                    if (typeof loadTasks === 'function') {
                        await loadTasks();
                    }
                    // Reload project data if function exists
                    if (typeof loadProjectData === 'function') {
                        await loadProjectData();
                    }
                } else {
                    console.error('Update failed:', data); // Debug log
                    let errorMsg = data.message || 'Failed to update task';
                    if (data.errors) {
                        errorMsg += ': ' + JSON.stringify(data.errors);
                    }
                    if (typeof toastr !== 'undefined') {
                        toastr.error(errorMsg);
                    }
                    console.error('Full error details:', data);
                }
            } catch (error) {
                console.error('Error updating task:', error);
                if (typeof toastr !== 'undefined') {
                    toastr.error('Error updating task: ' + error.message);
                }
            }
        }
    });
};

// Override the original editTask function
window.editTask = window.editTaskEnhanced;
