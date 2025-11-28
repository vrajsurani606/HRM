// Project Overview JavaScript
const projectId = window.location.pathname.split('/')[2];
let projectData = null;
let tasksData = [];
let membersData = [];

// Load all project data
async function loadProjectData() {
    try {
        const response = await fetch(`/projects/${projectId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        const data = await response.json();
        
        if (data.success && data.project) {
            projectData = data.project;
            updateProjectInfo();
            loadCharts();
            await loadTasks();
            await loadTeamMembers();
        }
    } catch (error) {
        console.error('Error loading project:', error);
        if (typeof toastr !== 'undefined') {
            toastr.error('Error loading project data');
        }
    }
}

// Load tasks
async function loadTasks() {
    try {
        const response = await fetch(`/projects/${projectId}/tasks`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        const data = await response.json();
        
        if (data.success) {
            tasksData = data.tasks || [];
            renderTasks();
        }
    } catch (error) {
        console.error('Error loading tasks:', error);
        document.getElementById('tasksContent').innerHTML = '<p style="text-align: center; color: #ef4444; padding: 40px;">Failed to load tasks</p>';
    }
}

// Load team members
async function loadTeamMembers() {
    try {
        const response = await fetch(`/projects/${projectId}/members`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        const data = await response.json();
        
        if (data.success) {
            membersData = data.members || [];
            renderTeamMembers();
            document.getElementById('projectMembers').textContent = membersData.length;
        }
    } catch (error) {
        console.error('Error loading team members:', error);
        document.getElementById('teamContent').innerHTML = '<p style="text-align: center; color: #ef4444; padding: 40px;">Failed to load team members</p>';
    }
}

// Render tasks
function renderTasks() {
    const container = document.getElementById('tasksContent');
    
    if (tasksData.length === 0) {
        container.innerHTML = '<p style="text-align: center; color: #6b7280; padding: 40px;">No tasks yet. Create your first task!</p>';
        return;
    }
    
    let html = '<div style="display: flex; flex-direction: column; gap: 12px;">';
    
    tasksData.forEach(task => {
        const isCompleted = task.is_completed;
        const hasSubtasks = task.subtasks && task.subtasks.length > 0;
        
        html += `
            <div class="file-item" style="background: ${isCompleted ? '#f0fdf4' : '#f9fafb'};">
                <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
                    <input type="checkbox" ${isCompleted ? 'checked' : ''} 
                           onchange="toggleTask(${task.id}, this.checked)"
                           style="width: 20px; height: 20px; cursor: pointer;">
                    <div style="flex: 1;">
                        <h4 style="margin: 0 0 4px 0; font-size: 14px; font-weight: 600; color: #1f2937; ${isCompleted ? 'text-decoration: line-through; opacity: 0.6;' : ''}">
                            ${escapeHtml(task.title)}
                        </h4>
                        ${task.due_date ? `<div style="font-size: 12px; color: #6b7280;">Due: ${task.due_date}</div>` : ''}
                        ${hasSubtasks ? `<div style="font-size: 12px; color: #6b7280; margin-top: 4px;">${task.subtasks.filter(st => st.is_completed).length}/${task.subtasks.length} subtasks completed</div>` : ''}
                    </div>
                </div>
                <div style="display: flex; gap: 8px;">
                    <button class="file-btn" onclick="editTask(${task.id})">Edit</button>
                    <button class="file-btn" onclick="deleteTask(${task.id})" style="color: #ef4444; border-color: #fecaca;">Delete</button>
                </div>
            </div>
        `;
        
        // Render subtasks
        if (hasSubtasks) {
            task.subtasks.forEach(subtask => {
                html += `
                    <div class="file-item" style="margin-left: 40px; background: ${subtask.is_completed ? '#f0fdf4' : 'white'};">
                        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
                            <input type="checkbox" ${subtask.is_completed ? 'checked' : ''} 
                                   onchange="toggleTask(${subtask.id}, this.checked)"
                                   style="width: 18px; height: 18px; cursor: pointer;">
                            <div style="flex: 1;">
                                <h4 style="margin: 0; font-size: 13px; font-weight: 500; color: #4b5563; ${subtask.is_completed ? 'text-decoration: line-through; opacity: 0.6;' : ''}">
                                    ${escapeHtml(subtask.title)}
                                </h4>
                            </div>
                        </div>
                    </div>
                `;
            });
        }
    });
    
    html += '</div>';
    container.innerHTML = html;
}

// Render team members
function renderTeamMembers() {
    const container = document.getElementById('teamContent');
    
    if (membersData.length === 0) {
        container.innerHTML = '<p style="text-align: center; color: #6b7280; padding: 40px; grid-column: 1/-1;">No team members yet</p>';
        return;
    }
    
    let html = '';
    membersData.forEach(member => {
        const initials = member.name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
        const colors = ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444', '#06b6d4'];
        const color = colors[member.id % colors.length];
        
        html += `
            <div class="team-card">
                <div class="team-avatar" style="background: ${color};">
                    ${initials}
                </div>
                <h4 class="team-name">${escapeHtml(member.name)}</h4>
                <p class="team-role">${member.pivot?.role || 'Member'}</p>
                ${member.email ? `<p style="font-size: 11px; color: #9ca3af; margin: 4px 0 0 0;">${escapeHtml(member.email)}</p>` : ''}
            </div>
        `;
    });
    
    container.innerHTML = html;
}

// Toggle task completion
async function toggleTask(taskId, isCompleted) {
    try {
        const response = await fetch(`/projects/${projectId}/tasks/${taskId}`, {
            method: 'PUT',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ is_completed: isCompleted })
        });
        
        const data = await response.json();
        
        if (data.success) {
            if (typeof toastr !== 'undefined') {
                toastr.success('Task updated successfully');
            }
            await loadTasks();
            await loadProjectData(); // Refresh stats
        } else {
            if (typeof toastr !== 'undefined') {
                toastr.error('Failed to update task');
            }
        }
    } catch (error) {
        console.error('Error updating task:', error);
        if (typeof toastr !== 'undefined') {
            toastr.error('Error updating task');
        }
    }
}

// Edit task
function editTask(taskId) {
    const task = tasksData.find(t => t.id === taskId);
    if (!task) return;
    
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Edit Task',
            html: `
                <input id="taskTitle" class="swal2-input" placeholder="Task title" value="${escapeHtml(task.title)}">
                <input id="taskDueDate" class="swal2-input" type="date" value="${task.due_date || ''}">
            `,
            showCancelButton: true,
            confirmButtonText: 'Update',
            preConfirm: () => {
                return {
                    title: document.getElementById('taskTitle').value,
                    due_date: document.getElementById('taskDueDate').value
                };
            }
        }).then(async (result) => {
            if (result.isConfirmed) {
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
                    
                    if (data.success) {
                        toastr.success('Task updated successfully');
                        await loadTasks();
                    } else {
                        toastr.error('Failed to update task');
                    }
                } catch (error) {
                    console.error('Error updating task:', error);
                    toastr.error('Error updating task');
                }
            }
        });
    }
}

// Delete task
async function deleteTask(taskId) {
    if (typeof Swal !== 'undefined') {
        const result = await Swal.fire({
            title: 'Delete Task?',
            text: 'This action cannot be undone',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Delete'
        });
        
        if (result.isConfirmed) {
            try {
                const response = await fetch(`/projects/${projectId}/tasks/${taskId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    toastr.success('Task deleted successfully');
                    await loadTasks();
                    await loadProjectData(); // Refresh stats
                } else {
                    toastr.error('Failed to delete task');
                }
            } catch (error) {
                console.error('Error deleting task:', error);
                toastr.error('Error deleting task');
            }
        }
    }
}

// Update project info
function updateProjectInfo() {
    document.getElementById('projectName').textContent = projectData.name;
    document.getElementById('projectDueDate').textContent = projectData.due_date || 'Not set';
    document.getElementById('projectStatus').textContent = (projectData.status || 'Active').replace('_', ' ').toUpperCase();
    
    // Calculate progress based on tasks
    const totalTasks = tasksData.length;
    const completedTasks = tasksData.filter(t => t.is_completed).length;
    const progress = totalTasks > 0 ? Math.round((completedTasks / totalTasks) * 100) : 0;
    
    document.getElementById('statProgress').textContent = progress + '%';
    document.getElementById('statTasks').textContent = `${completedTasks}/${totalTasks}`;
    document.getElementById('statBudget').textContent = projectData.budget ? `$${parseFloat(projectData.budget).toLocaleString()}` : '$0';
    
    // Calculate days left
    if (projectData.due_date) {
        const dueDate = new Date(projectData.due_date);
        const today = new Date();
        const daysLeft = Math.ceil((dueDate - today) / (1000 * 60 * 60 * 24));
        document.getElementById('statDaysLeft').textContent = daysLeft > 0 ? daysLeft : '0';
    } else {
        document.getElementById('statDaysLeft').textContent = '-';
    }
}

// Switch tabs
function switchTab(tabName) {
    // Update buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
    
    // Update content
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });
    document.getElementById(`tab-${tabName}`).classList.add('active');
}

// Load charts
function loadCharts() {
    const totalTasks = tasksData.length;
    const completedTasks = tasksData.filter(t => t.is_completed).length;
    const inProgressTasks = Math.floor(totalTasks * 0.2);
    const pendingTasks = totalTasks - completedTasks - inProgressTasks;
    
    // Task Progress Chart
    new Chart(document.getElementById('taskProgressChart'), {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'In Progress', 'Pending'],
            datasets: [{
                data: [completedTasks, inProgressTasks, pendingTasks],
                backgroundColor: ['#10b981', '#f59e0b', '#e5e7eb']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Time Tracking Chart
    new Chart(document.getElementById('timeTrackingChart'), {
        type: 'bar',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
            datasets: [{
                label: 'Hours',
                data: [8, 6, 7, 9, 5],
                backgroundColor: '#3b82f6'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Timeline Chart
    const progress = totalTasks > 0 ? Math.round((completedTasks / totalTasks) * 100) : 0;
    new Chart(document.getElementById('timelineChart'), {
        type: 'line',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Progress',
                data: [10, 25, 45, progress],
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Task Distribution Chart
    const memberTaskCounts = {};
    tasksData.forEach(task => {
        if (task.assigned_to) {
            memberTaskCounts[task.assigned_to] = (memberTaskCounts[task.assigned_to] || 0) + 1;
        }
    });
    
    new Chart(document.getElementById('taskDistributionChart'), {
        type: 'pie',
        data: {
            labels: membersData.slice(0, 3).map(m => m.name),
            datasets: [{
                data: [12, 8, 5],
                backgroundColor: ['#3b82f6', '#10b981', '#f59e0b']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Velocity Chart
    new Chart(document.getElementById('velocityChart'), {
        type: 'bar',
        data: {
            labels: ['Sprint 1', 'Sprint 2', 'Sprint 3', 'Sprint 4'],
            datasets: [{
                label: 'Completed',
                data: [8, 12, 10, 15],
                backgroundColor: '#10b981'
            }, {
                label: 'Planned',
                data: [10, 12, 12, 15],
                backgroundColor: '#e5e7eb'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Burndown Chart
    new Chart(document.getElementById('burndownChart'), {
        type: 'line',
        data: {
            labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5'],
            datasets: [{
                label: 'Ideal',
                data: [50, 40, 30, 20, 10],
                borderColor: '#e5e7eb',
                borderDash: [5, 5]
            }, {
                label: 'Actual',
                data: [50, 42, 35, 25, 15],
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

// Utility function to escape HTML
function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, m => map[m]);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    loadProjectData();
});
