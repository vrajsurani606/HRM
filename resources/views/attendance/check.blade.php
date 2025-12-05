@extends('layouts.macos')
@section('page_title','Check IN / OUT')

@section('content')
<div style="padding: 24px;">
  <div style="max-width: 500px; margin: 0 auto; background: white; border-radius: 25px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); overflow: hidden;">

    @php
      $empPhoto = ($employee && !empty($employee->photo_path)) ? storage_asset(''.$employee->photo_path) : null;
      $userPhoto = auth()->user()->profile_photo_url ?? null;
      $photo = $empPhoto ?: $userPhoto;
      $initial = strtoupper(mb_substr((string)($employee->name ?? auth()->user()->name ?? 'U'), 0, 1));
      $hasCheckIn = (bool)($attendance && $attendance->check_in);
      $hasCheckOut = (bool)($attendance && $attendance->check_out);
      $showTimingImmediately = $hasCheckIn ? true : false;
    @endphp

    <!-- Blue Header -->
    <div style="background: linear-gradient(135deg, #89CFF0 0%, #67B7D1 100%); padding: 30px 20px 70px; text-align: center; position: relative;">
      <!-- User Avatar -->
      <div style="position: absolute; left: 50%; bottom: -50px; transform: translateX(-50%); width: 100px; height: 100px; border-radius: 22px; overflow: hidden; border: 5px solid white; box-shadow: 0 8px 25px rgba(0,0,0,0.15); z-index: 10; background: white;">
        @if($photo)
          <img src="{{ $photo }}" alt="avatar" style="width: 100%; height: 100%; object-fit: cover;"/>
        @else
          <span style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; font-weight: 800; font-size: 40px; color: white; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">{{ $initial }}</span>
        @endif
      </div>
    </div>

    <!-- Content Area -->
    <div style="padding: 70px 30px 30px; text-align: center; background: #f8f9fa;">
      <h2 style="font-size: 26px; font-weight: 700; color: #2c3e50; margin: 0 0 5px 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $employee->name ?? (auth()->user()->name ?? 'User') }}</h2>
      <p style="color: #95a5a6; font-size: 15px; margin: 0 0 35px 0; font-weight: 500;">Welcome !</p>

      <!-- Form - visibility controlled by JavaScript -->
      <form id="punchForm" method="POST" action="{{ route('attendance.check-in') }}" style="display: inline-block;">
        @csrf
        <button id="punchButton" type="submit" style="padding: 0; border: 0; background: transparent; cursor: pointer; outline: none;">
          <!-- Check IN Button (default) -->
          <div id="checkInBtn" class="punch-btn" style="width: 180px; height: 160px; background: #a8f5b5; border-radius: 26px; display: flex; align-items: center; justify-content: center; box-shadow: inset 0 -8px 0 rgba(0,0,0,0.05), 0 10px 24px rgba(0,0,0,0.10); transition: all 0.2s ease; margin: 0 auto; position: relative; display: none;">
            <svg width="65" height="65" viewBox="0 0 24 24" fill="none" stroke="#3C3C3C" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
              <polyline points="10 17 15 12 10 7"></polyline>
              <line x1="15" y1="12" x2="3" y2="12"></line>
            </svg>
          </div>
          <!-- Check OUT Button -->
          <div id="checkOutBtn" class="punch-btn" style="width: 180px; height: 160px; background: #ffc4c4; border-radius: 26px; display: flex; align-items: center; justify-content: center; box-shadow: inset 0 -8px 0 rgba(0,0,0,0.05), 0 10px 24px rgba(0,0,0,0.10); transition: all 0.2s ease; margin: 0 auto; position: relative; display: none;">
            <svg width="65" height="65" viewBox="0 0 24 24" fill="none" stroke="#3C3C3C" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
              <polyline points="16 17 21 12 16 7"></polyline>
              <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
          </div>
          <p id="buttonLabel" style="margin-top: 12px; color: #6b6b6b; font-size: 13px; font-weight: 600;">Tap green to Check IN...</p>
        </button>
      </form>
      
      <!-- Timing Display -->
      <div id="checkTiming" style="{{ $showTimingImmediately ? '' : 'display:none;' }} margin-top: 20px;">
        <div style="display: inline-block; padding: 18px 28px; border-radius: 15px; background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); color: #1976d2; font-weight: 700; font-size: 16px; box-shadow: 0 5px 15px rgba(25, 118, 210, 0.2);">
          @if($attendance && $attendance->check_in)
            ✓ Checked in at {{ \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') }}
          @endif
        </div>
        
        @if(!$hasCheckOut && $attendance && $attendance->check_in)
          <div id="elapsedTime" style="margin-top: 15px; padding: 15px 25px; border-radius: 12px; background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); color: #e65100; font-weight: 700; font-size: 18px; box-shadow: 0 4px 12px rgba(230, 81, 0, 0.15);">
            <div style="font-size: 13px; margin-bottom: 5px; opacity: 0.8;">Time Elapsed</div>
            <div id="timerDisplay" style="font-size: 28px; font-family: 'Courier New', monospace; letter-spacing: 2px;">00:00:00</div>
          </div>
        @endif
        
        @if($hasCheckOut)
          <div style="margin-top: 12px; color: #e74c3c; font-weight: 700; font-size: 15px;">✓ Checked out at {{ \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') }}</div>
          @if($attendance->total_working_hours)
            <div style="margin-top: 10px; padding: 12px 20px; border-radius: 10px; background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); color: #2e7d32; font-weight: 700; font-size: 15px;">
              Total Working Time: {{ $attendance->total_working_hours }}
            </div>
          @endif
          
          <!-- Cooldown Message -->
          <div id="cooldownMessage" style="margin-top: 15px; padding: 12px 20px; border-radius: 10px; background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); color: #e65100; font-weight: 600; font-size: 14px;">
            <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z"/>
              </svg>
              <span id="cooldownText">You can re-check in after 5 minutes</span>
            </div>
            <div id="cooldownTimer" style="margin-top: 8px; font-size: 20px; font-weight: 700; font-family: 'Courier New', monospace;"></div>
          </div>
        @endif
        
        <div style="margin-top: 25px;">
          <button id="okBtn" type="button" data-dashboard-url="{{ url('/dashboard') }}" style="cursor: pointer; padding: 14px 38px; border-radius: 50px; border: 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-weight: 700; font-size: 15px; box-shadow: 0 6px 18px rgba(102, 126, 234, 0.4); transition: all 0.3s ease;">OK</button>
        </div>
      </div>

      <!-- Date Info Inside Card -->
      <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e0e0e0; color: #7f8c8d; font-size: 13px;">
        <small>
          {{ \Carbon\Carbon::parse($today)->format('l, d M Y') }}
        </small>
      </div>
    </div>
  </div>
</div>

<style>
.punch-btn {
  position: relative;
}

#punchButton:hover .punch-btn {
  transform: translateY(-2px);
  box-shadow: inset 0 -8px 0 rgba(0,0,0,0.05), 0 14px 28px rgba(0,0,0,0.15);
}

#punchButton:active .punch-btn {
  transform: translateY(2px);
  box-shadow: inset 0 -4px 0 rgba(0,0,0,0.05), 0 6px 18px rgba(0,0,0,0.08);
}

#okBtn {
  position: relative;
}

#okBtn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 22px rgba(102, 126, 234, 0.5);
}

#okBtn:active {
  transform: translateY(0);
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function(){
  var ok = document.getElementById('okBtn');
  if(ok){
    ok.addEventListener('click', function(){
      var expireAt = Date.now() + 30000;
      try { localStorage.setItem('checkoutWindowExpireAt', String(expireAt)); } catch(e) {}
      var to = ok.getAttribute('data-dashboard-url') || '/';
      window.location.assign(to);
    });
  }

  var form = document.getElementById('punchForm');
  var timing = document.getElementById('checkTiming');
  var hasCheckIn = {{ $hasCheckIn ? 'true' : 'false' }};
  var hasCheckOut = {{ $hasCheckOut ? 'true' : 'false' }};
  
  // Check server status to determine if we can show the form
  function checkServerStatus() {
    fetch('{{ route("attendance.current-status") }}', {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => response.json())
    .then(data => {
      console.log('Server status:', data);
      
      const checkInBtn = document.getElementById('checkInBtn');
      const checkOutBtn = document.getElementById('checkOutBtn');
      const buttonLabel = document.getElementById('buttonLabel');
      
      if (data.has_checked_in && !data.has_checked_out) {
        // Currently checked in - show check-out button
        console.log('State: Checked in, waiting for checkout');
        if(form) form.style.display = 'inline-block';
        if(timing) timing.style.display = 'block';
        if(checkInBtn) checkInBtn.style.display = 'none';
        if(checkOutBtn) checkOutBtn.style.display = 'flex';
        if(buttonLabel) buttonLabel.textContent = 'Tap red to Check OUT...';
        form.action = '{{ route("attendance.check-out") }}';
        startTimer();
      } else if (data.has_checked_out && !data.can_check_in) {
        // Within 5-minute cooldown - hide form, show timing and cooldown message
        console.log('State: In cooldown period');
        if(form) form.style.display = 'none';
        if(timing) timing.style.display = 'block';
        
        // Show cooldown message
        var cooldownMsg = document.getElementById('cooldownMessage');
        var cooldownTimer = document.getElementById('cooldownTimer');
        var cooldownText = document.getElementById('cooldownText');
        if(cooldownMsg) cooldownMsg.style.display = 'block';
        
        // Update cooldown timer based on server message
        if(data.message && cooldownText) {
          cooldownText.textContent = data.message;
        }
        
        // Schedule next check every 1 second during cooldown
        setTimeout(checkServerStatus, 1000);
      } else if (data.can_check_in) {
        // Can check in - show check-in button
        console.log('State: Ready to check in');
        if(form) form.style.display = 'inline-block';
        if(timing) timing.style.display = 'none';
        if(checkInBtn) checkInBtn.style.display = 'flex';
        if(checkOutBtn) checkOutBtn.style.display = 'none';
        if(buttonLabel) buttonLabel.textContent = 'Tap green to Check IN...';
        form.action = '{{ route("attendance.check-in") }}';
        
        // Hide cooldown message when ready to check in
        var cooldownMsg = document.getElementById('cooldownMessage');
        if(cooldownMsg) cooldownMsg.style.display = 'none';
      } else {
        // Default state - show check-in
        console.log('State: Default');
        if(form) form.style.display = 'inline-block';
        if(timing) timing.style.display = 'none';
        if(checkInBtn) checkInBtn.style.display = 'flex';
        if(checkOutBtn) checkOutBtn.style.display = 'none';
        if(buttonLabel) buttonLabel.textContent = 'Tap green to Check IN...';
        form.action = '{{ route("attendance.check-in") }}';
      }
    })
    .catch(error => {
      console.error('Error checking status:', error);
      // Fallback to original logic
      if(hasCheckIn && !hasCheckOut){
        if(form) form.style.display = 'inline-block';
        if(timing) timing.style.display = 'block';
        startTimer();
      }
    });
  }
  
  // Check status on page load
  checkServerStatus();

  // Timer function to show elapsed time since check-in
  function startTimer() {
    var timerDisplay = document.getElementById('timerDisplay');
    if (!timerDisplay) return;

    @if($attendance && $attendance->check_in && !$hasCheckOut)
      var checkInTime = new Date('{{ \Carbon\Carbon::parse($attendance->check_in)->toIso8601String() }}');
      
      function updateTimer() {
        var now = new Date();
        var diff = Math.floor((now - checkInTime) / 1000); // difference in seconds
        
        var hours = Math.floor(diff / 3600);
        var minutes = Math.floor((diff % 3600) / 60);
        var seconds = diff % 60;
        
        timerDisplay.textContent = 
          String(hours).padStart(2, '0') + ':' + 
          String(minutes).padStart(2, '0') + ':' + 
          String(seconds).padStart(2, '0');
      }
      
      updateTimer(); // Initial update
      setInterval(updateTimer, 1000); // Update every second
    @endif
  }

  // Start timer immediately if already checked in
  if(hasCheckIn && !hasCheckOut && timing && timing.style.display !== 'none'){
    startTimer();
  }
});
</script>
@endsection
