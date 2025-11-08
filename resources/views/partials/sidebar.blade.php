<aside id="hrpSidebar" class="hrp-sidebar">
  <div class="hrp-sidebar-inner">
    <div class="hrp-side-top" aria-hidden="true">
      <div class="hrp-window-dots">
        <span class="hrp-dot hrp-dot-y"></span>
        <span class="hrp-dot hrp-dot-g"></span>
      </div>
      <span class="hrp-side-badge" role="button" tabindex="0" aria-label="Toggle sidebar" aria-controls="hrpSidebar"></span>
    </div>
    <ul class="hrp-menu">
      @php($ico='dashboard.svg')
      @php($p=public_path('side_icon/'.$ico))
      <li class="hrp-menu-item"><a href="{{ route('dashboard') }}"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Dashboard">@else <span class="fa fa-home"></span>@endif</i> <span>Dashboard</span></a></li>
      @php($ico='hr.svg')
      @php($p=public_path('side_icon/'.$ico))
      <li class="hrp-menu-item {{ (request()->routeIs('hiring.*') || request()->routeIs('employees.*')) ? 'active-parent open' : '' }}" data-group="hrm"><a href="{{ route('section',['name'=>'hr']) }}"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="HRM">@else <span class="fa fa-users"></span>@endif</i> <span>HRM</span></a></li>

      <li class="hrp-menu-item hrp-sub {{ request()->routeIs('hiring.create') ? 'active' : '' }}" data-group="hrm"><a href="{{ route('hiring.create') }}"><span>Add New Hiring Lead</span></a></li>
     
      <li class="hrp-menu-item hrp-sub {{ request()->routeIs('hiring.index') ? 'active' : '' }}" data-group="hrm"><a href="{{ route('hiring.index') }}"><span>List of Hiring Lead</span></a></li>
    
      <li class="hrp-menu-item hrp-sub {{ request()->routeIs('employees.*') ? 'active' : '' }}" data-group="hrm"><a href="{{ route('employees.index') }}"><span>Employee List</span></a></li>
   
      @php($ico='attendance.svg')
      @php($p=public_path('side_icon/'.$ico))
      <li class="hrp-menu-item"><a href="{{ route('attendance.report') }}"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Attendance">@else <span class="fa fa-calendar-check-o"></span>@endif</i> <span>Attendance Mgmt.</span></a></li>

      @php($ico='leave.svg')
      @php($p=public_path('side_icon/'.$ico))
      <li class="hrp-menu-item"><a href="{{ route('section',['name'=>'leave']) }}"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Leave">@else <span class="fa fa-plane"></span>@endif</i> <span>Leave Mgmt.</span></a></li>

      @php($ico='payroll.svg')
      @php($p=public_path('side_icon/'.$ico))
      <li class="hrp-menu-item"><a href="{{ route('section',['name'=>'payroll']) }}"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Payroll">@else <span class="fa fa-money"></span>@endif</i> <span>Payroll Mgmt.</span></a></li>

      @php($ico='projectManager.svg')
      @php($p=public_path('side_icon/'.$ico))
      <li class="hrp-menu-item"><a href="{{ route('projects.index') }}"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Project & Task">@else <span class="fa fa-tasks"></span>@endif</i> <span>Project & Task Mgmt.</span></a></li>

      @php($ico='inquirymanagment.svg')
      @php($p=public_path('side_icon/'.$ico))
      <li class="hrp-menu-item"><a href="{{ route('inquiries.index') }}"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Inquiry">@else <span class="fa fa-envelope-open"></span>@endif</i> <span>Inquiry Mgmt.</span></a></li>

      @php($ico='quatation.svg')
      @php($p=public_path('side_icon/'.$ico))
      <li class="hrp-menu-item {{ request()->routeIs('quotations.*') ? 'active-parent' : '' }}"><a href="{{ route('quotations.index') }}"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Quotation">@else <span class="fa fa-file-text-o"></span>@endif</i> <span>Quotation Mgmt.</span></a></li>

      @php($ico='invoice.svg')
      @php($p=public_path('side_icon/'.$ico))
      <li class="hrp-menu-item"><a href="{{ route('section',['name'=>'invoice']) }}"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Invoice">@else <span class="fa fa-credit-card"></span>@endif</i> <span>Invoice Mgmt.</span></a></li>

      @php($ico='voucher.svg')
      @php($p=public_path('side_icon/'.$ico))
      <li class="hrp-menu-item"><a href="{{ route('section',['name'=>'voucher']) }}"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Voucher">@else <span class="fa fa-ticket"></span>@endif</i> <span>Voucher Mgmt.</span></a></li>

      @php($ico='ticketsupport.svg')
      @php($p=public_path('side_icon/'.$ico))
      <li class="hrp-menu-item"><a href="{{ route('tickets.index') }}"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Ticket">@else <span class="fa fa-life-ring"></span>@endif</i> <span>Ticket Support System</span></a></li>

      @php($ico='event.svg')
      @php($p=public_path('side_icon/'.$ico))
      <li class="hrp-menu-item"><a href="{{ route('events.index') }}"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Event">@else <span class="fa fa-calendar"></span>@endif</i> <span>Event Mgmt.</span></a></li>

      @php($ico='company.svg')
      @php($p=public_path('side_icon/'.$ico))
      <li class="hrp-menu-item {{ request()->routeIs('companies.*') ? 'active-parent' : '' }}"><a href="{{ route('companies.index') }}"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Company">@else <span class="fa fa-building-o"></span>@endif</i> <span>Company Info.</span></a></li>

      @php($ico='rule.svg')
      @php($p=public_path('side_icon/'.$ico))
      <li class="hrp-menu-item"><a href="{{ route('section',['name'=>'rules']) }}"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Rules">@else <span class="fa fa-book"></span>@endif</i> <span>Rules & Regulations</span></a></li>

      @php($ico='settings.svg')
      @php($p=public_path('side_icon/'.$ico))
      <li class="hrp-menu-item"><a href="{{ route('section',['name'=>'settings']) }}"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Settings">@else <span class="fa fa-cog"></span>@endif</i> <span>Setting</span></a></li>
    </ul>
  </div>
</aside>
