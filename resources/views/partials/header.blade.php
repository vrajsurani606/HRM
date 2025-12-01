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
    <a href="{{ route('attendance.check') }}" class="hrp-thumb" title="IN/OUT" id="attendanceBtn" style="text-decoration:none; cursor: pointer; position: relative; display: flex; flex-direction: column; align-items: center; justify-content:center; gap: 6px; padding: 10px 12px; border-radius: 12px; background: #E8E3DF; margin-right: 10px; transition: all 0.3s ease; min-width: 70px;">
      <div class="ico" aria-hidden="true" style="display:flex; align-items:center; justify-content:center; width:40px; height:40px;">
        <img src="{{ asset('action_icon/Vector.svg') }}" alt="IN/OUT" width="40" height="40" style="display:block; object-fit: contain;" />
      </div>
      <div class="lbl" style="font-weight: 700; font-size: 12px; line-height: 1; color:#3C3C3C; text-align:center; letter-spacing: 0.3px;">IN/OUT</div>
    </a>
    
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

<style>
.hrp-thumb:hover {
    background: #d9d4cf !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.hrp-thumb:active {
    transform: translateY(0);
}
</style>
