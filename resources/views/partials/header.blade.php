<header class="hrp-header">
  <div class="hrp-header-left">
    <button class="hrp-menu-toggle btn btn-default" type="button" aria-controls="hrpSidebar" aria-expanded="false" style="margin-right:8px;border-radius:8px;padding:6px 10px;">
      <span class="sr-only">Toggle menu</span>
      <i class="fa fa-bars" aria-hidden="true"></i>
    </button>
    <h1 class="hrp-page-title">@yield('page_title','Dashboard')</h1>
  </div>
  <div class="hrp-header-right" style="display: flex; align-items: center;">
    <!-- Time Tracker Component - Only show if user has check-in/out permissions -->
    @if(auth()->user()->can('Attendance Management.check in') || auth()->user()->can('Attendance Management.check out') || auth()->user()->can('Attendance Management.view own attendance'))
    <a href="{{ route('attendance.check') }}" class="hrp-thumb" title="IN/OUT" id="attendanceBtn" style="text-decoration:none; cursor: pointer; position: relative; display: flex; flex-direction: column; align-items: center; justify-content:center; gap: 6px; padding: 10px 12px; border-radius: 12px; background: #E8E3DF; margin-right: 10px; transition: all 0.3s ease; min-width: 70px;">
      <div class="ico" aria-hidden="true" style="display:flex; align-items:center; justify-content:center; width:40px; height:40px;">
        <img src="{{ asset('action_icon/Vector.svg') }}" alt="IN/OUT" width="40" height="40" style="display:block; object-fit: contain;" />
      </div>
      <div class="lbl" style="font-weight: 700; font-size: 12px; line-height: 1; color:#3C3C3C; text-align:center; letter-spacing: 0.3px;">IN/OUT</div>
    </a>
    @endif
    
    <div class="dropdown">
      <button class="hrp-user-btn" data-toggle="dropdown" aria-expanded="false">
        @php
          $user = auth()->user();
          $employee = \App\Models\Employee::where('email', $user->email)->first();
          $photoUrl = $employee && $employee->photo_path 
            ? storage_asset($employee->photo_path) 
            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=3b82f6&color=fff&size=64';
        @endphp
        <img class="hrp-avatar" src="{{ $photoUrl }}" alt="user"/>
        <div class="hrp-user-meta">
          <div class="hrp-user-email">{{ $user->email ?? 'user@example.com' }}</div>
          <div class="hrp-user-name">{{ $user->name ?? 'User' }}</div>
        </div>
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu dropdown-menu-right hrp-user-dropdown">
        <li><a href="{{ route('profile.edit') }}">Profile</a></li>
        <li>
          <form method="POST" action="{{ route('logout') }}" style="margin:0;padding:0;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</header>

<style>
.hrp-thumb:hover {
    background: #d9d4cf !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.hrp-thumb:active {
    transform: translateY(0);
}

/* Profile Dropdown Styling */
.hrp-user-dropdown {
    min-width: 200px;
    padding: 8px 0;
    margin-top: 8px;
    background: #ffffff;
    border: 1px solid rgba(0, 0, 0, 0.08);
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12), 0 2px 8px rgba(0, 0, 0, 0.08);
}

.hrp-user-dropdown li {
    list-style: none;
    margin: 0;
    padding: 0;
}

.hrp-user-dropdown li a {
    display: block;
    padding: 10px 20px;
    color: #374151;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
}

.hrp-user-dropdown li a:hover {
    background: #f3f4f6;
    color: #111827;
}

.hrp-user-dropdown .logout-btn {
    display: block;
    width: 100%;
    padding: 10px 20px;
    margin: 4px 0 0 0;
    background: #10b981;
    color: #ffffff;
    font-size: 14px;
    font-weight: 600;
    text-align: left;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.hrp-user-dropdown .logout-btn:hover {
    background: #059669;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
}

.hrp-user-dropdown .logout-btn:active {
    transform: translateY(0);
}

.hrp-user-dropdown li:has(.logout-btn) {
    padding: 0 8px 4px 8px;
}
</style>
