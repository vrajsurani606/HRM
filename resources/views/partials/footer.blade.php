  @php
  $isDashboard = \Route::currentRouteName() === 'dashboard';
  $pageTitle = trim(View::yieldContent('page_title', ''));
@endphp

<div class="hrp-breadcrumb">
  <div class="crumb">
    @hasSection('breadcrumb')
      @yield('breadcrumb')
    @else
      @php($vectorIco = public_path('side_icon/Vector.svg'))
      @php($dashIco = public_path('side_icon/dashboard.svg'))
      <span class="hrp-bc-ico">
        @if(file_exists($vectorIco))
          <img src="{{ asset('side_icon/Vector.svg') }}" alt="Dashboard"/>
        @elseif(file_exists($dashIco))
          <img src="{{ asset('side_icon/dashboard.svg') }}" alt="Dashboard"/>
        @else
          <i class="fa fa-home" aria-hidden="true"></i>
        @endif
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
