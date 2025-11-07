<header class="hrp-header">
  <div class="hrp-header-left">
    <button class="hrp-menu-toggle btn btn-default visible-xs-inline-block visible-sm-inline-block" type="button" aria-controls="hrpSidebar" aria-expanded="false" style="margin-right:8px;border-radius:8px;padding:6px 10px;">
      <span class="sr-only">Toggle menu</span>
      <i class="fa fa-bars" aria-hidden="true"></i>
    </button>
    <h1 class="hrp-page-title">@yield('page_title','Dashboard')</h1>
  </div>
  <div class="hrp-header-right">
    <div class="hrp-thumb" title="IN/OUT">
      <div class="ico" aria-hidden="true">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 2.75c-4.55 0-8.25 3.7-8.25 8.25 0 2.13.8 4.07 2.11 5.54.24.27.66.29.94.05.27-.24.29-.66.05-.94A7.07 7.07 0 0 1 4.5 11c0-4.14 3.36-7.5 7.5-7.5s7.5 3.36 7.5 7.5c0 2.07-.84 3.95-2.2 5.31-.26.25-.26.68 0 .94.26.26.68.26.94 0A8.963 8.963 0 0 0 20.25 11c0-4.55-3.7-8.25-8.25-8.25Z" fill="#0F172A" opacity=".6"/>
          <path d="M12 6.5a4.5 4.5 0 0 0-4.5 4.5c0 1.66.85 3.12 2.13 3.95.31.2.72.11.92-.2.2-.31.11-.72-.2-.92A3.34 3.34 0 0 1 8.25 11 3.75 3.75 0 1 1 15 11c0 2.74-1.09 5.23-2.86 7.04-.26.26-.26.68 0 .94.26.26.68.26.94 0A10.49 10.49 0 0 0 16.5 11 4.5 4.5 0 0 0 12 6.5Z" fill="#0F172A"/>
        </svg>
      </div>
      <div class="lbl">IN/OUT</div>
    </div>
    <div class="dropdown">
      <button class="hrp-user-btn" data-toggle="dropdown" aria-expanded="false">
        <img class="hrp-avatar" src="https://i.pravatar.cc/64?img=12" alt="user"/>
        <div class="hrp-user-meta">
          <div class="hrp-user-name">{{ auth()->user()->name ?? 'User' }}</div>
          <div class="hrp-user-role">S_D_Admin</div>
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
