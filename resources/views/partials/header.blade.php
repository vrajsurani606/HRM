<header class="hrp-header">
  <div class="hrp-header-left">
    <button class="hrp-menu-toggle btn btn-default" type="button" aria-controls="hrpSidebar" aria-expanded="false" style="margin-right:8px;border-radius:8px;padding:6px 10px;">
      <span class="sr-only">Toggle menu</span>
      <i class="fa fa-bars" aria-hidden="true"></i>
    </button>
    <h1 class="hrp-page-title">@yield('page_title','Dashboard')</h1>
  </div>
  <div class="hrp-header-right" style="display: flex; align-items: center;">
    <!-- Time Tracker Component -->
    <div class="hrp-thumb" title="IN/OUT" id="attendanceBtn" style="cursor: pointer; position: relative; display: flex; align-items: center; padding: 5px 10px; border-radius: 20px; background: rgba(255, 255, 255, 0.1); margin-right: 10px;">
      <div class="ico" aria-hidden="true" style="margin-right: 5px;">
        <img src="{{ asset('new_theme/images/fingure.svg') }}" alt="IN/OUT" width="22" height="22" />
      </div>
      <div class="lbl" style="font-weight: 500;">IN/OUT</div>
    </div>
    
    <!-- Time Tracker Container (will be populated by JavaScript) -->
    <div id="timeTrackerContainer"></div>
    <div class="dropdown">
      <button class="hrp-user-btn" data-toggle="dropdown" aria-expanded="false">
        <img class="hrp-avatar" src="https://i.pravatar.cc/64?img=12" alt="user"/>
        <div class="hrp-user-meta">
          <div class="hrp-user-email">{{ auth()->user()->email ?? 'user@example.com' }}</div>
          <div class="hrp-user-name">{{ auth()->user()->name ?? 'User' }}</div>
        </div>
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu dropdown-menu-right">
        <li><a href="{{ route('profile.edit') }}">Profile</a></li>
        <li>
          <form method="POST" action="{{ route('logout') }}" style="margin:0;padding:0;">
            @csrf
            <button type="submit" class="dropdown-item" style="width:100%;text-align:left;padding:6px 20px;background:none;border:0;">Logout</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</header>

@push('scripts')
<script src="{{ asset('js/time-tracker.js') }}" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Time tracking variables
    let startTime;
    let timerInterval;
    let isTracking = false;
    const timeDisplay = document.getElementById('timeDisplay');
    const timeTooltip = document.getElementById('timeTooltip');
    const attendanceBtn = document.getElementById('attendanceBtn');
    const startBtn = document.getElementById('startBtn');
    const stopBtn = document.getElementById('stopBtn');
    let tooltipTimeout;

    // Format time as HH:MM:SS
    function formatTime(seconds) {
        const hrs = Math.floor(seconds / 3600);
        const mins = Math.floor((seconds % 3600) / 60);
        const secs = seconds % 60;
        return [
            hrs.toString().padStart(2, '0'),
            mins.toString().padStart(2, '0'),
            secs.toString().padStart(2, '0')
        ].join(':');
    }

    // Update the timer display
    function updateTimer() {
        const now = new Date();
        const elapsed = Math.floor((now - startTime) / 1000);
        timeDisplay.textContent = formatTime(elapsed);
    }

    // Show time tooltip
    function showTooltip() {
        clearTimeout(tooltipTimeout);
        if (timeTooltip) {
            timeTooltip.style.display = 'block';
        }
    }

    // Hide time tooltip
    function hideTooltip() {
        tooltipTimeout = setTimeout(() => {
            if (timeTooltip) {
                timeTooltip.style.display = 'none';
            }
        }, 500);
    }

    // Start tracking time
    function startTracking() {
        if (isTracking) return;
        
        startTime = new Date();
        isTracking = true;
        startBtn.disabled = true;
        stopBtn.disabled = false;
        
        // Update immediately and then every second
        updateTimer();
        timerInterval = setInterval(updateTimer, 1000);
        
        // Save to localStorage
        localStorage.setItem('timeTrackerStart', startTime.getTime());
        
        // Show tooltip for 3 seconds
        showTooltip();
        setTimeout(hideTooltip, 3000);
        
        // Show success message
        toastr.success('Time tracking started');
    }

    // Stop tracking time
    function stopTracking() {
        if (!isTracking) return;
        
        clearInterval(timerInterval);
        isTracking = false;
        startBtn.disabled = false;
        stopBtn.disabled = true;
        
        // Calculate total time
        const endTime = new Date();
        const totalSeconds = Math.floor((endTime - startTime) / 1000);
        
        // Clear from localStorage
        localStorage.removeItem('timeTrackerStart');
        
        // Show tooltip with final time for 3 seconds
        timeDisplay.textContent = formatTime(totalSeconds);
        showTooltip();
        setTimeout(hideTooltip, 3000);
        
        // Show success message
        toastr.success(`Time tracked: ${formatTime(totalSeconds)}`);
        
        // Reset display
        timeDisplay.textContent = '00:00:00';
    }

    // Toggle tracking (start/stop)
    function toggleTracking() {
        if (isTracking) {
            stopTracking();
        } else {
            startTracking();
        }
    }

    // Check for existing tracking session on page load
    function checkExistingSession() {
        const savedTime = localStorage.getItem('timeTrackerStart');
        if (savedTime) {
            startTime = new Date(parseInt(savedTime));
            isTracking = true;
            startBtn.disabled = true;
            stopBtn.disabled = false;
            updateTimer();
            timerInterval = setInterval(updateTimer, 1000);
            // Show current time in tooltip on hover
            showTooltip();
        }
    }

    // Event listeners
    if (attendanceBtn) {
        attendanceBtn.addEventListener('click', function(e) {
            e.preventDefault();
            toggleTracking();
        });
        
        // Show/hide tooltip on hover
        attendanceBtn.addEventListener('mouseenter', showTooltip);
        attendanceBtn.addEventListener('mouseleave', hideTooltip);
        
        // Keep tooltip visible when hovering over it
        if (timeTooltip) {
            timeTooltip.addEventListener('mouseenter', showTooltip);
            timeTooltip.addEventListener('mouseleave', hideTooltip);
        }
    }
    
    // Hidden buttons for programmatic control
    if (startBtn) startBtn.addEventListener('click', startTracking);
    if (stopBtn) stopBtn.addEventListener('click', stopTracking);
    
    // Initialize
    checkExistingSession();
    
    // Initialize tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
});
</script>
@endpush
