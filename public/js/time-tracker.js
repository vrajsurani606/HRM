class TimeTracker {
    constructor() {
        this.timerInterval = null;
        this.startTime = null;
        this.elapsedTime = 0;
        this.isTracking = false;
        
        // Initialize the time tracker
        this.initElements();
        this.initEventListeners();
        this.checkStatus();
    }

    initElements() {
        // Create elements if they don't exist
        if (!document.getElementById('timeTrackerContainer')) {
            const container = document.createElement('div');
            container.id = 'timeTrackerContainer';
            container.style.display = 'flex';
            container.style.alignItems = 'center';
            container.style.marginLeft = '15px';
            container.style.position = 'relative';
            
            // Time display
            const timeDisplay = document.createElement('div');
            timeDisplay.id = 'timeDisplay';
            timeDisplay.textContent = '00:00:00';
            timeDisplay.style.marginRight = '10px';
            timeDisplay.style.fontWeight = 'bold';
            timeDisplay.style.fontSize = '14px';
            timeDisplay.style.color = '#fff';
            
            // Stop button
            const stopButton = document.createElement('button');
            stopButton.id = 'stopTracking';
            stopButton.innerHTML = '⏹';
            stopButton.style.background = '#ff4444';
            stopButton.style.border = 'none';
            stopButton.style.borderRadius = '50%';
            stopButton.style.width = '28px';
            stopButton.style.height = '28px';
            stopButton.style.display = 'flex';
            stopButton.style.alignItems = 'center';
            stopButton.style.justifyContent = 'center';
            stopButton.style.cursor = 'pointer';
            stopButton.style.color = 'white';
            stopButton.style.fontSize = '14px';
            stopButton.title = 'Stop Tracking';
            stopButton.style.display = 'none';
            
            container.appendChild(timeDisplay);
            container.appendChild(stopButton);
            
            // Insert after the attendance button
            const attendanceBtn = document.getElementById('attendanceBtn');
            if (attendanceBtn) {
                attendanceBtn.parentNode.insertBefore(container, attendanceBtn.nextSibling);
            }
        }
        
        // Store references to elements
        this.elements = {
            container: document.getElementById('timeTrackerContainer'),
            timeDisplay: document.getElementById('timeDisplay'),
            stopButton: document.getElementById('stopTracking'),
            attendanceBtn: document.getElementById('attendanceBtn')
        };
    }

    initEventListeners() {
        // Toggle tracking when clicking the attendance button
        if (this.elements.attendanceBtn) {
            this.elements.attendanceBtn.addEventListener('click', (e) => this.toggleTracking(e));
        }
        
        // Stop tracking when clicking the stop button
        if (this.elements.stopButton) {
            this.elements.stopButton.addEventListener('click', () => this.stopTracking());
        }
    }

    async checkStatus() {
        try {
            const response = await fetch('/api/attendance/status', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            const data = await response.json();
            
            if (data.success && data.data.has_checked_in && !data.data.has_checked_out) {
                // User is currently checked in
                this.startTime = new Date(data.data.attendance.check_in);
                this.elapsedTime = Math.floor((new Date() - this.startTime) / 1000);
                this.isTracking = true;
                this.startTimer();
                this.showStopButton();
            }
        } catch (error) {
            console.error('Error checking attendance status:', error);
        }
    }

    async toggleTracking(e) {
        e.preventDefault();
        
        if (this.isTracking) {
            await this.stopTracking();
        } else {
            await this.startTracking();
        }
    }

    async startTracking() {
        try {
            const response = await fetch('/api/attendance/check-in', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                this.startTime = new Date();
                this.elapsedTime = 0;
                this.isTracking = true;
                this.startTimer();
                this.showStopButton();
                this.showNotification('Time tracking started', 'success');
            } else {
                this.showNotification(data.message || 'Failed to start tracking', 'error');
            }
        } catch (error) {
            console.error('Error starting time tracking:', error);
            this.showNotification('Error starting time tracking', 'error');
        }
    }

    async stopTracking() {
        try {
            const response = await fetch('/api/attendance/check-out', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                this.isTracking = false;
                this.stopTimer();
                this.hideStopButton();
                this.showNotification(`Time tracking stopped. Total time: ${data.data.total_hours}`, 'success');
            } else {
                this.showNotification(data.message || 'Failed to stop tracking', 'error');
            }
        } catch (error) {
            console.error('Error stopping time tracking:', error);
            this.showNotification('Error stopping time tracking', 'error');
        }
    }

    startTimer() {
        this.stopTimer(); // Clear any existing timer
        
        // Update immediately
        this.updateTimeDisplay();
        
        // Then update every second
        this.timerInterval = setInterval(() => {
            this.elapsedTime++;
            this.updateTimeDisplay();
        }, 1000);
    }

    stopTimer() {
        if (this.timerInterval) {
            clearInterval(this.timerInterval);
            this.timerInterval = null;
        }
    }

    updateTimeDisplay() {
        if (!this.elements.timeDisplay) return;
        
        const hours = Math.floor(this.elapsedTime / 3600);
        const minutes = Math.floor((this.elapsedTime % 3600) / 60);
        const seconds = this.elapsedTime % 60;
        
        this.elements.timeDisplay.textContent = 
            `${this.pad(hours)}:${this.pad(minutes)}:${this.pad(seconds)}`;
    }

    showStopButton() {
        if (this.elements.stopButton) {
            this.elements.stopButton.style.display = 'flex';
        }
    }

    hideStopButton() {
        if (this.elements.stopButton) {
            this.elements.stopButton.style.display = 'none';
        }
    }

    showNotification(message, type = 'info') {
        // Use toastr if available, otherwise use alert
        if (typeof toastr !== 'undefined') {
            toastr[type === 'error' ? 'error' : 'success'](message);
        } else {
            alert(message);
        }
    }

    pad(num) {
        return num.toString().padStart(2, '0');
    }
}

// Initialize the time tracker when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', () => {
    window.timeTracker = new TimeTracker();
});
