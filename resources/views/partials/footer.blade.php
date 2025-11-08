  @php
  $isDashboard = \Route::currentRouteName() === 'dashboard';
  $pageTitle = trim(View::yieldContent('page_title', ''));
@endphp

<div class="hrp-breadcrumb">
  <div class="crumb">
    @hasSection('breadcrumb')
      @yield('breadcrumb')
    @else
      <span class="hrp-bc-ico">
        <img src="{{ asset('side_icon/Vector.svg') }}" alt="Dashboard" onerror="this.onerror=null;this.src='{{ asset('side_icon/dashboard.svg') }}';"/>
      </span>
      <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
      @if(!$isDashboard && $pageTitle)
        <span class="hrp-bc-sep">›</span>
        <span class="hrp-bc-current">{{ $pageTitle }}</span>
      @endif
    @endif
  </div>
  @hasSection('footer_pagination')
  <div class="hrp-pagination">@yield('footer_pagination')</div>
  @endif
</div>
