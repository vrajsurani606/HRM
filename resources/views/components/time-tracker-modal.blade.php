<div id="timeTrackerModal" class="time-tracker-wrapper" style="display: none; z-index: 9999;">
    <div class="time-tracker-overlay"></div>
    <div class="time-tracker-container">
        <div class="time-tracker-header">
            <h4 class="m-0"><i class="fas fa-clock me-2"></i>Time Tracker</h4>
            <button type="button" class="btn-close" aria-label="Close"></button>
        </div>
        <div class="time-tracker-body p-4">
            <div class="time-display-container mb-4">
                <div id="timeDisplay" class="display-4 text-center fw-bold text-primary">00:00:00</div>
                <div id="statusMessage" class="text-center text-muted mt-2">Ready to start tracking your work hours</div>
            </div>
            
            <div class="d-flex justify-content-center gap-3 mb-4">
                <button id="startBtn" class="btn btn-success btn-lg px-4 py-2">
                    <i class="fas fa-sign-in-alt me-2"></i> Check In
                </button>
                <button id="stopBtn" class="btn btn-danger btn-lg px-4 py-2" disabled>
                    <i class="fas fa-sign-out-alt me-2"></i> Check Out
                </button>
            </div>
            
            <div class="form-group">
                <label class="form-label">Notes (Optional)</label>
                <textarea id="notes" class="form-control" rows="3" 
                    placeholder="Add any notes about your work..."></textarea>
            </div>
        </div>
        <div class="time-tracker-footer p-3 bg-light text-end">
            <small class="text-muted">Your time is tracked automatically</small>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Modal Wrapper */
.time-tracker-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1050;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    padding: 1rem;
    box-sizing: border-box;
}

/* Overlay */
.time-tracker-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1049;
    backdrop-filter: blur(2px);
    cursor: pointer;
}

/* Main Container */
.time-tracker-container {
    background: #ffffff;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    z-index: 2;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    overflow: hidden;
    border: 1px solid rgba(0, 0, 0, 0.1);
    animation: modalFadeIn 0.3s ease-out;
}

@keyframes modalFadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Header */
.time-tracker-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}

.time-tracker-header h4 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
    color: #2c3e50;
    display: flex;
    align-items: center;
}

.time-tracker-header .btn-close {
    padding: 0.5rem;
    margin: -0.5rem -0.5rem -0.5rem auto;
    background: none;
    border: none;
    font-size: 1.5rem;
    line-height: 1;
    color: #6c757d;
    cursor: pointer;
    transition: color 0.2s;
}

.time-tracker-header .btn-close:hover {
    color: #2c3e50;
}

/* Body */
.time-tracker-body {
    padding: 1.5rem;
}

.time-display-container {
    margin-bottom: 1.5rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 8px;
    text-align: center;
}

#timeDisplay {
    font-family: 'Courier New', monospace;
    font-weight: 700;
    color: #2c3e50;
    margin: 0.5rem 0;
    line-height: 1.2;
    letter-spacing: 1px;
}

#statusMessage {
    color: #6c757d;
    font-size: 0.95rem;
    margin-top: 0.5rem;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 500;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    user-select: none;
    border: 1px solid transparent;
    padding: 0.5rem 1rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.375rem;
    transition: all 0.2s ease-in-out;
    cursor: pointer;
}

.btn:disabled {
    opacity: 0.65;
    cursor: not-allowed;
}

.btn-success {
    color: #fff;
    background-color: #28a745;
    border-color: #28a745;
}

.btn-success:hover:not(:disabled) {
    background-color: #218838;
    border-color: #1e7e34;
}

.btn-danger {
    color: #fff;
    background-color: #dc3545;
    border-color: #dc3545;
}

.btn-danger:hover:not(:disabled) {
    background-color: #c82333;
    border-color: #bd2130;
}

/* Form Elements */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: inline-block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #495057;
}

.form-control {
    display: block;
    width: 100%;
    padding: 0.5rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control:focus {
    color: #495057;
    background-color: #fff;
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

textarea.form-control {
    min-height: calc(1.5em + 0.75rem + 2px);
    resize: vertical;
}

/* Footer */
.time-tracker-footer {
    padding: 0.75rem 1.5rem;
    background-color: #f8f9fa;
    border-top: 1px solid #e9ecef;
    text-align: right;
}

.time-tracker-footer small {
    font-size: 0.8rem;
}

/* Responsive Adjustments */
@media (max-width: 576px) {
    .time-tracker-container {
        width: 95%;
    }
    
    .time-tracker-body {
        padding: 1.25rem;
    }
    
    #timeDisplay {
        font-size: 2rem;
    }
    
    .btn {
        padding: 0.4rem 0.8rem;
        font-size: 0.9rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const modal = document.getElementById('timeTrackerModal');
    const overlay = document.querySelector('.time-tracker-overlay');
    const closeBtn = document.querySelector('.btn-close');
    const startBtn = document.getElementById('startBtn');
    const stopBtn = document.getElementById('stopBtn');
    const timeDisplay = document.getElementById('timeDisplay');
    const statusMessage = document.getElementById('statusMessage');
    const notesInput = document.getElementById('notes');
    
    // State
    let startTime = null;
    let timer = null;
    let isTracking = false;
    
    // Show modal with animation
    function showModal() {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            modal.querySelector('.time-tracker-container').style.transform = 'translateY(0)';
            modal.querySelector('.time-tracker-overlay').style.opacity = '1';
        }, 10);
    }
    
    // Hide modal with animation
    function hideModal() {
        const container = modal.querySelector('.time-tracker-container');
        container.style.transform = 'translateY(-20px)';
        modal.querySelector('.time-tracker-overlay').style.opacity = '0';
        
        setTimeout(() => {
            modal.style.display = 'none';
            document.body.style.overflow = '';
            
            if (!isTracking) {
                resetTimer();
                notesInput.value = '';
            }
        }, 300);
    }
    
    // Initialize event listeners
    function init() {
        // Show modal when clicking IN/OUT button
        document.getElementById('attendanceBtn').addEventListener('click', function(e) {
            e.preventDefault();
            showModal();
        });
        
        // Close modal when clicking close button or overlay
        closeBtn.addEventListener('click', hideModal);
        overlay.addEventListener('click', hideModal);
        
        // Close with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hideModal();
            }
        });
        
        // Start tracking
        startBtn.addEventListener('click', startTracking);
        
        // Stop tracking
        stopBtn.addEventListener('click', stopTracking);
        
        // Check for existing session
        checkExistingSession();
    }
    
    // Start tracking time
    function startTracking() {
        startTime = new Date();
        isTracking = true;
        
        // Update UI
        startBtn.disabled = true;
        stopBtn.disabled = false;
        statusMessage.textContent = 'Tracking your work time...';
        statusMessage.style.color = '#28a745';
        
        // Start timer
        updateTimer();
        timer = setInterval(updateTimer, 1000);
        
        // Save to localStorage
        localStorage.setItem('attendanceStartTime', startTime.getTime());
        
        // Send to server
        saveAttendance('check-in');
    }
    
    // Stop tracking time
    function stopTracking() {
        if (!isTracking) return;
        
        clearInterval(timer);
        isTracking = false;
        
        // Update UI
        stopBtn.disabled = true;
        statusMessage.textContent = 'Time tracked successfully!';
        statusMessage.style.color = '#28a745';
        
        // Save notes
        const notes = notesInput.value;
        
        // Show success message before closing
        setTimeout(() => {
            resetTimer();
            saveAttendance('check-out', notes);
            hideModal();
        }, 1500);
    }
    
    // Update the timer display
    function updateTimer() {
        if (!startTime) return;
        
        const now = new Date();
        const diff = now - startTime;
        
        const hours = Math.floor(diff / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);
        
        timeDisplay.textContent = 
            `${hours.toString().padStart(2, '0')}:` +
            `${minutes.toString().padStart(2, '0')}:` +
            `${seconds.toString().padStart(2, '0')}`;
    }
    
    // Reset the timer to initial state
    function resetTimer() {
        clearInterval(timer);
        timer = null;
        startTime = null;
        timeDisplay.textContent = '00:00:00';
        statusMessage.textContent = 'Ready to start tracking your work hours';
        statusMessage.style.color = '#6c757d';
        startBtn.disabled = false;
        stopBtn.disabled = true;
        notesInput.value = '';
        
        localStorage.removeItem('attendanceStartTime');
    }
    
    // Check if there's an active tracking session
    function checkExistingSession() {
        const savedTime = localStorage.getItem('attendanceStartTime');
        if (savedTime) {
            startTime = new Date(parseInt(savedTime));
            isTracking = true;
            
            startBtn.disabled = true;
            stopBtn.disabled = false;
            statusMessage.textContent = 'Tracking your work time...';
            statusMessage.style.color = '#28a745';
            
            updateTimer();
            timer = setInterval(updateTimer, 1000);
        }
    }
    
    // Save attendance data to the server
    function saveAttendance(type, notes = '') {
        const url = type === 'check-in' ? '{{ route("attendance.check-in") }}' : '{{ route("attendance.check-out") }}';
        const data = {
            _token: '{{ csrf_token() }}',
            notes: notes,
            timestamp: new Date().toISOString()
        };
        
        // Show loading state
        const button = type === 'check-in' ? startBtn : stopBtn;
        const originalText = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
        
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
            // Show success message
            showNotification('Time tracked successfully!', 'success');
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error: ' + (error.message || 'Failed to save time'), 'error');
        })
        .finally(() => {
            // Restore button state
            if (type === 'check-out') {
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-sign-out-alt me-2"></i> Check Out';
            } else {
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i> Checked In';
            }
        });
    }
    
    // Show notification to user
    function showNotification(message, type = 'info') {
        // You can implement a toast notification system here
        // For now, we'll just log to console
        console.log(`${type.toUpperCase()}: ${message}`);
    }
    
    // Initialize the time tracker
    init();
});
</script>
@endpush
