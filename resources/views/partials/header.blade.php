<header class="hrp-header">
  <div class="hrp-header-left">
    <button class="hrp-menu-toggle btn btn-default" type="button" aria-controls="hrpSidebar" aria-expanded="false" style="margin-right:8px;border-radius:8px;padding:6px 10px;">
      <span class="sr-only">Toggle menu</span>
      <i class="fa fa-bars" aria-hidden="true"></i>
    </button>
    <h1 class="hrp-page-title">@yield('page_title','Dashboard')</h1>
  </div>
  <div class="hrp-header-right">
    <div class="hrp-thumb" title="IN/OUT">
      <div class="ico" aria-hidden="true">
        <img src="{{ asset('new_theme/images/fingure.svg') }}" alt="IN/OUT" width="22" height="22" />
      </div>
      <div class="lbl">IN/OUT</div>
    </div>
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
