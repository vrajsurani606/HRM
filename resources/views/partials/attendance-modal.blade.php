<!-- Attendance Modal -->
<div class="modal" id="attendanceModal" tabindex="-1" role="dialog" aria-labelledby="attendanceModalLabel" style="display: none; z-index: 1050;">
    <div class="modal-backdrop fade in" style="opacity: 0.5; display: none;"></div>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="attendanceModalLabel">Time Tracking</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div id="attendanceStatus" class="mb-4">
                    <div id="timeDisplay" class="display-4 mb-3">00:00:00</div>
                    <div id="statusMessage" class="h5">Ready to start tracking</div>
                    <div id="totalHours" class="text-muted mt-2" style="display: none;">
                        <small>Total Hours Today: <strong id="totalHoursValue">00:00</strong></small>
                    </div>
                </div>
                
                <div class="d-flex justify-content-center gap-3 mb-4">
                    <button id="startBtn" class="btn btn-success btn-lg px-4">
                        <i class="fas fa-sign-in-alt me-2"></i> Check In
                    </button>
                    <button id="stopBtn" class="btn btn-danger btn-lg px-4" disabled>
                        <i class="fas fa-sign-out-alt me-2"></i> Check Out
                    </button>
                </div>

                <!-- Cycles Display -->
                <div id="cyclesContainer" style="display: none; margin-top: 20px; text-align: left;">
                    <h6 class="mb-3">Today's Check-In/Out Cycles:</h6>
                    <div id="cyclesList" class="list-group list-group-sm"></div>
                </div>
                
                <div class="form-group text-left">
                    <label for="notes">Notes (Optional)</label>
                    <textarea class="form-control" id="notes" rows="2" placeholder="Add any notes about your work..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const startBtn = document.getElementById('startBtn');
    const stopBtn = document.getElementById('stopBtn');
    const timeDisplay = document.getElementById('timeDisplay');
    const statusMessage = document.getElementById('statusMessage');
    const notesInput = document.getElementById('notes');
    
    let startTime = null;
    let timer = null;
    let isTracking = false;
    
    // Attendance Button Click Handler
    const attendanceBtn = document.getElementById('attendanceBtn');
    if (attendanceBtn) {
        attendanceBtn.addEventListener('click', function() {
            // Check status when modal is opened
            checkAttendanceStatus();
            
            // Show modal
            const modal = document.getElementById('attendanceModal');
            modal.style.display = 'flex';
            const backdrop = modal.querySelector('.modal-backdrop');
            backdrop.style.display = 'block';
            
            // Add body class
            document.body.classList.add('modal-open');
            
            // Set focus to modal
            modal.focus();
        });
    }
    
    // Start button click handler
    startBtn.addEventListener('click', function() {
        startTracking();
    });
    
    // Stop button click handler
    stopBtn.addEventListener('click', function() {
        stopTracking();
    });
    
    // Check initial status on page load
    checkAttendanceStatus();
    
    // Refresh status every 10 seconds if modal is open
    // Also refresh every 1 second if in cooldown state to catch when cooldown expires
    setInterval(function() {
        const modal = document.getElementById('attendanceModal');
        if (modal && modal.style.display === 'flex') {
            checkAttendanceStatus();
        }
    }, 10000);
    
    // Aggressive refresh every 1 second when modal is open to catch cooldown expiry
    setInterval(function() {
        const modal = document.getElementById('attendanceModal');
        const startBtn = document.getElementById('startBtn');
        if (modal && modal.style.display === 'flex' && startBtn.disabled) {
            checkAttendanceStatus();
        }
    }, 1000);
    
    // Hide modal function
    function hideAttendanceModal() {
        const modal = document.getElementById('attendanceModal');
        const backdrop = modal.querySelector('.modal-backdrop');
        
        // Hide modal and backdrop
        modal.style.display = 'none';
        backdrop.style.display = 'none';
        
        // Remove body class
        document.body.classList.remove('modal-open');
        
        // Reset modal state if not tracking
        if (!isTracking) {
            resetTimer();
            notesInput.value = '';
        }
    }
    
    // Close modal when clicking close button or outside
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('attendanceModal');
        const closeBtn = modal.querySelector('.close, [data-dismiss="modal"]');
        
        // Close when clicking close button or outside modal
        if (event.target === closeBtn || event.target === modal) {
            hideAttendanceModal();
        }
    });
    
    // Close with escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            hideAttendanceModal();
        }
    });
    
    function startTracking() {
        startTime = new Date();
        isTracking = true;
        
        // Update UI
        startBtn.disabled = true;
        stopBtn.disabled = false;
        statusMessage.textContent = 'Tracking time...';
        statusMessage.className = 'h5 text-success';
        
        // Start timer
        updateTimer();
        timer = setInterval(updateTimer, 1000);
        
        // Save check-in time to localStorage
        localStorage.setItem('attendanceStartTime', startTime.getTime());
        
        // Send check-in request to server
        saveAttendance('check-in');
    }
    
    function stopTracking() {
        if (!isTracking) return;
        
        clearInterval(timer);
        isTracking = false;
        
        // Update UI
        stopBtn.disabled = true;
        statusMessage.textContent = 'Time tracked successfully!';
        statusMessage.className = 'h5 text-success';
        
        // Get the notes before resetting
        const notes = notesInput.value;
        
        // Send check-out request to server with notes
        saveAttendance('check-out', notes);
        
        // Reset after a short delay
        setTimeout(() => {
            resetTimer();
            
            // Close the modal after a short delay
            $('#attendanceModal').modal('hide');
        }, 1500);
    }
    
    function updateTimer() {
        if (!startTime) return;
        
        const now = new Date();
        const diff = now - startTime;
        
        // Format time as HH:MM:SS
        const hours = Math.floor(diff / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);
        
        timeDisplay.textContent = 
            `${hours.toString().padStart(2, '0')}:` +
            `${minutes.toString().padStart(2, '0')}:` +
            `${seconds.toString().padStart(2, '0')}`;
    }
    
    function resetTimer() {
        clearInterval(timer);
        timer = null;
        startTime = null;
        timeDisplay.textContent = '00:00:00';
        statusMessage.textContent = 'Ready to start tracking';
        statusMessage.className = 'h5';
        startBtn.disabled = false;
        stopBtn.disabled = true;
        
        // Clear localStorage
        localStorage.removeItem('attendanceStartTime');
    }
    
    function checkAttendanceStatus() {
        // Check server status
        fetch('{{ route("attendance.current-status") }}', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Attendance Status:', data);
            
            // Update UI based on server status
            if (data.has_checked_in && !data.has_checked_out) {
                // Currently checked in
                startBtn.disabled = true;
                stopBtn.disabled = false;
                statusMessage.textContent = 'You are checked in. Click Check Out to end your session.';
                statusMessage.className = 'h5 text-info';
                isTracking = true;
            } else if (data.has_checked_out && !data.can_check_in) {
                // Checked out but within 5-minute cooldown
                startBtn.disabled = true;
                stopBtn.disabled = true;
                statusMessage.textContent = data.message;
                statusMessage.className = 'h5 text-warning';
                isTracking = false;
            } else if (data.can_check_in) {
                // Can check in
                console.log('Enabling check-in button');
                startBtn.disabled = false;
                stopBtn.disabled = true;
                statusMessage.textContent = data.message || 'Ready to start tracking';
                statusMessage.className = 'h5';
                isTracking = false;
            } else {
                // Default state
                console.log('Default state - enabling check-in');
                startBtn.disabled = false;
                stopBtn.disabled = true;
                statusMessage.textContent = 'Ready to start tracking';
                statusMessage.className = 'h5';
                isTracking = false;
            }

            // Display total hours if available
            if (data.total_hours) {
                document.getElementById('totalHoursValue').textContent = data.total_hours;
                document.getElementById('totalHours').style.display = 'block';
            }

            // Display cycles if available
            if (data.cycles && data.cycles.length > 0) {
                updateCyclesDisplay({ cycles: JSON.stringify(data.cycles) });
            }
        })
        .catch(error => {
            console.error('Error checking attendance status:', error);
            // Fallback to localStorage
            const savedTime = localStorage.getItem('attendanceStartTime');
            if (savedTime) {
                startTime = new Date(parseInt(savedTime));
                isTracking = true;
                
                // Update UI
                startBtn.disabled = true;
                stopBtn.disabled = false;
                statusMessage.textContent = 'Tracking time...';
                statusMessage.className = 'h5 text-success';
                
                // Start timer
                updateTimer();
                timer = setInterval(updateTimer, 1000);
            }
        });
    }
    
    function saveAttendance(type, notes = '') {
        const url = type === 'check-in' ? '{{ route("attendance.check-in") }}' : '{{ route("attendance.check-out") }}';
        const data = {
            _token: '{{ csrf_token() }}',
            notes: notes
        };
        
        // Show loading state
        const originalHtml = type === 'check-in' ? startBtn.innerHTML : stopBtn.innerHTML;
        const button = type === 'check-in' ? startBtn : stopBtn;
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
        
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            console.log('Attendance saved successfully:', data);
            
            // Update cycles display if available
            if (data.attendance && data.attendance.cycles) {
                updateCyclesDisplay(data.attendance);
            }
            if (data.total_hours) {
                document.getElementById('totalHoursValue').textContent = data.total_hours;
                document.getElementById('totalHours').style.display = 'block';
            }
            
            // Restore button HTML
            button.innerHTML = originalHtml;
            
            // Refresh status after successful save
            setTimeout(() => {
                checkAttendanceStatus();
            }, 500);
        })
        .catch(error => {
            console.error('Error:', error);
            // Show error message
            const errorMessage = error.message || 'An error occurred while saving attendance.';
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger mt-3';
            alertDiv.role = 'alert';
            alertDiv.textContent = errorMessage;
            document.querySelector('.modal-body').prepend(alertDiv);
            
            // Auto-remove the alert after 5 seconds
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
            
            // Reset button state
            button.disabled = false;
            button.innerHTML = originalHtml;
            
            // Refresh status
            checkAttendanceStatus();
        });
    }

    function updateCyclesDisplay(attendance) {
        const cyclesContainer = document.getElementById('cyclesContainer');
        const cyclesList = document.getElementById('cyclesList');
        
        if (!attendance.cycles || attendance.cycles.length === 0) {
            cyclesContainer.style.display = 'none';
            return;
        }

        cyclesList.innerHTML = '';
        const cycles = JSON.parse(attendance.cycles);
        
        cycles.forEach((cycle, index) => {
            const checkIn = new Date(cycle.check_in);
            const checkOut = new Date(cycle.check_out);
            const duration = cycle.duration || 0;
            const hours = Math.floor(duration / 60);
            const minutes = duration % 60;
            
            const cycleItem = document.createElement('div');
            cycleItem.className = 'list-group-item';
            cycleItem.innerHTML = `
                <div class="d-flex justify-content-between">
                    <span><strong>Cycle ${index + 1}:</strong></span>
                    <span>${hours}h ${minutes}m</span>
                </div>
                <small class="text-muted">
                    ${checkIn.toLocaleTimeString()} - ${checkOut.toLocaleTimeString()}
                </small>
            `;
            cyclesList.appendChild(cycleItem);
        });
        
        cyclesContainer.style.display = 'block';
    }
});
</script>
@endpush

@push('styles')
<style>
/* Modal styles */
#attendanceModal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 1050;
}

#attendanceModal .modal-dialog {
    position: relative;
    z-index: 1051;
    width: auto;
    max-width: 500px;
    margin: 1.75rem auto;
}

#attendanceModal .modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1040;
}

/* Fix for body scroll when modal is open */
body.modal-open {
    overflow: hidden;
    padding-right: 0 !important;
}

#attendanceStatus {
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
}

#timeDisplay {
    font-family: 'Courier New', monospace;
    font-weight: bold;
    color: #2c3e50;
}

.btn-lg {
    min-width: 150px;
}

.modal-content {
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.modal-header {
    border-bottom: 1px solid #eee;
    background-color: #f8f9fa;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
}

.modal-footer {
    border-top: 1px solid #eee;
    background-color: #f8f9fa;
    border-bottom-left-radius: 15px;
    border-bottom-right-radius: 15px;
}
</style>
@endpush
