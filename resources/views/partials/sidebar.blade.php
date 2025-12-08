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
      
      {{-- Dashboard always visible for authenticated users (landing page) --}}
      <li class="hrp-menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"><a href="{{ route('dashboard') }}"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Dashboard">@else <span class="fa fa-home"></span>@endif</i> <span>Dashboard</span></a></li>
     
      @php($ico='hr.svg')
      @php($p=public_path('side_icon/'.$ico))
      @if(auth()->user()->can('Employees Management.view employee') || auth()->user()->can('Employees Management.manage employee') || auth()->user()->can('Leads Management.view lead') || auth()->user()->can('Leads Management.manage lead'))
        <li class="hrp-menu-item {{ (request()->routeIs('hiring.*') || request()->routeIs('employees.*')) ? 'active-parent open' : '' }}" data-group="hrm"><a href="#" role="button"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="HRM">@else <span class="fa fa-users"></span>@endif</i> <span>HRM</span></a></li>
        @if(auth()->user()->can('Leads Management.create lead'))
          <li class="hrp-menu-item hrp-sub {{ request()->routeIs('hiring.create') ? 'active' : '' }}" data-group="hrm"><a href="{{ route('hiring.create') }}"><span>Add New Hiring Lead</span></a></li>
        @endif
        @if(auth()->user()->can('Leads Management.view lead') || auth()->user()->can('Leads Management.manage lead'))
          <li class="hrp-menu-item hrp-sub {{ request()->routeIs('hiring.index') ? 'active' : '' }}" data-group="hrm"><a href="{{ route('hiring.index') }}"><span>List of Hiring Lead</span></a></li>
        @endif
        @if(auth()->user()->can('Employees Management.view employee') || auth()->user()->can('Employees Management.manage employee'))
          <li class="hrp-menu-item hrp-sub {{ request()->routeIs('employees.*') ? 'active' : '' }}" data-group="hrm"><a href="{{ route('employees.index') }}"><span>Employee List</span></a></li>
        @endif
      @endif

      @php($ico='inquirymanagment.svg')
      @php($p=public_path('side_icon/'.$ico))
      @if(auth()->user()->can('Inquiries Management.view inquiry') || auth()->user()->can('Inquiries Management.manage inquiry'))
        <li class="hrp-menu-item {{ request()->routeIs('inquiries.*') ? 'active-parent open' : '' }}" data-group="inquiry"><a href="#" role="button"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Inquiry">@else <span class="fa fa-envelope-open"></span>@endif</i> <span>Inquiry Management</span></a></li>
        @if(auth()->user()->can('Inquiries Management.create inquiry'))
          <li class="hrp-menu-item hrp-sub {{ request()->routeIs('inquiries.create') ? 'active' : '' }}" data-group="inquiry"><a href="{{ route('inquiries.create') }}"><span>Add New Inquiry</span></a></li>
        @endif
        <li class="hrp-menu-item hrp-sub {{ request()->routeIs('inquiries.index') && !request('action') ? 'active' : '' }}" data-group="inquiry"><a href="{{ route('inquiries.index') }}"><span>List of Inquiry</span></a></li>
      @endif

      @php($ico='quatation.svg')
      @php($p=public_path('side_icon/'.$ico))
      @if(auth()->user()->can('Quotations Management.view quotation') || auth()->user()->can('Quotations Management.manage quotation'))
        <li class="hrp-menu-item {{ request()->routeIs('quotations.*') ? 'active-parent open' : '' }}" data-group="quotation"><a href="#" role="button"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Quotation">@else <span class="fa fa-file-text-o"></span>@endif</i> <span>Quotation Management</span></a></li>
        @if(auth()->user()->can('Quotations Management.create quotation'))
          <li class="hrp-menu-item hrp-sub {{ request()->routeIs('quotations.create') ? 'active' : '' }}" data-group="quotation"><a href="{{ route('quotations.create') }}"><span>Add Quotation</span></a></li>
        @endif
        <li class="hrp-menu-item hrp-sub {{ request()->routeIs('quotations.index') && !request('action') ? 'active' : '' }}" data-group="quotation"><a href="{{ route('quotations.index') }}"><span>List of Quotation</span></a></li>
      @endif

      @php($ico='company.svg')
      @php($p=public_path('side_icon/'.$ico))
      @if(auth()->user()->can('Companies Management.view company') || auth()->user()->can('Companies Management.manage company'))
        <li class="hrp-menu-item {{ request()->routeIs('companies.*') ? 'active-parent open' : '' }}" data-group="company"><a href="#" role="button"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Company">@else <span class="fa fa-building-o"></span>@endif</i> <span>Company</span></a></li>
        @if(auth()->user()->can('Companies Management.create company'))
          <li class="hrp-menu-item hrp-sub {{ request()->routeIs('companies.create') ? 'active' : '' }}" data-group="company"><a href="{{ route('companies.create') }}"><span>Add Company</span></a></li>
        @endif
        <li class="hrp-menu-item hrp-sub {{ request()->routeIs('companies.index') && !request('action') ? 'active' : '' }}" data-group="company"><a href="{{ route('companies.index') }}"><span>List of Company</span></a></li>
      @endif

      @php($ico='invoice.svg')
      @php($p=public_path('side_icon/'.$ico))
      @php($invoiceActive = (request()->routeIs('performas.*') || request()->routeIs('invoices.*') || request()->routeIs('receipts.*')))
      @if(auth()->user()->can('Proformas Management.view proforma') || auth()->user()->can('Proformas Management.manage proforma') || auth()->user()->can('Invoices Management.view invoice') || auth()->user()->can('Invoices Management.manage invoice') || auth()->user()->can('Receipts Management.view receipt') || auth()->user()->can('Receipts Management.manage receipt'))
        <li class="hrp-menu-item {{ $invoiceActive ? 'active-parent open' : '' }}" data-group="invoice"><a href="#" role="button"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Invoice">@else <span class="fa fa-credit-card"></span>@endif</i> <span>Invoice Management</span></a></li>
        @if(auth()->user()->can('Proformas Management.create proforma'))
          <li class="hrp-menu-item hrp-sub {{ request()->routeIs('performas.create') ? 'active' : '' }}" data-group="invoice"><a href="{{ route('performas.create') }}"><span>Add Proforma</span></a></li>
        @endif
        @if(auth()->user()->can('Proformas Management.view proforma') || auth()->user()->can('Proformas Management.manage proforma'))
          <li class="hrp-menu-item hrp-sub {{ request()->routeIs('performas.index') ? 'active' : '' }}" data-group="invoice"><a href="{{ route('performas.index') }}"><span>Proforma List</span></a></li>
        @endif
        @if(auth()->user()->can('Invoices Management.view invoice') || auth()->user()->can('Invoices Management.manage invoice'))
          <li class="hrp-menu-item hrp-sub {{ request()->routeIs('invoices.index') ? 'active' : '' }}" data-group="invoice"><a href="{{ route('invoices.index') }}"><span>Tax Invoice List</span></a></li>
        @endif
        @if(auth()->user()->can('Receipts Management.create receipt'))
          <li class="hrp-menu-item hrp-sub {{ request()->routeIs('receipts.create') ? 'active' : '' }}" data-group="invoice"><a href="{{ route('receipts.create') }}"><span>Add Receipt</span></a></li>
        @endif
        @if(auth()->user()->can('Receipts Management.view receipt') || auth()->user()->can('Receipts Management.manage receipt'))
          <li class="hrp-menu-item hrp-sub {{ request()->routeIs('receipts.index') ? 'active' : '' }}" data-group="invoice"><a href="{{ route('receipts.index') }}"><span>List Of Receipt</span></a></li>
        @endif
      @endif

      @php($ico='payroll.svg')
      @php($p=public_path('side_icon/'.$ico))
      @if(auth()->user()->can('Payroll Management.view payroll') || auth()->user()->can('Payroll Management.manage payroll'))
        <li class="hrp-menu-item {{ request()->routeIs('payroll.*') ? 'active-parent open' : '' }}" data-group="payroll"><a href="#" role="button"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Payroll">@else <span class="fa fa-money"></span>@endif</i> <span>Payroll Management</span></a></li>
        @if(auth()->user()->can('Payroll Management.create payroll'))
          <li class="hrp-menu-item hrp-sub {{ request()->routeIs('payroll.create') ? 'active' : '' }}" data-group="payroll"><a href="{{ route('payroll.create') }}"><span>Add Payroll</span></a></li>
        @endif
        <li class="hrp-menu-item hrp-sub {{ request()->routeIs('payroll.index') ? 'active' : '' }}" data-group="payroll"><a href="{{ route('payroll.index') }}"><span>List of Payroll</span></a></li>
      @endif

      @php($ico='projectManager.svg')
      @php($p=public_path('side_icon/'.$ico))
      @if(auth()->user()->can('Projects Management.view project') || auth()->user()->can('Projects Management.manage project'))
        <li class="hrp-menu-item {{ request()->routeIs('projects.index') ? 'active' : '' }}"><a href="{{ route('projects.index') }}"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Project & Task">@else <span class="fa fa-tasks"></span>@endif</i> <span>Project & Task Management</span></a></li>
      @endif

      @php($ico='ticketsupport.svg')
      @php($p=public_path('side_icon/'.$ico))
      @if(auth()->user()->can('Tickets Management.view ticket') || auth()->user()->can('Tickets Management.manage ticket'))
        <li class="hrp-menu-item {{ request()->routeIs('tickets.*') ? 'active' : '' }}"><a href="{{ route('tickets.index') }}"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Ticket">@else <span class="fa fa-life-ring"></span>@endif</i> <span>Ticket Support System</span></a></li>
      @endif

      @php($ico='attendance.svg')
      @php($p=public_path('side_icon/'.$ico))
      @php($attActive = (request()->routeIs('attendance.report') || request()->routeIs('leave-approval.*')))
      @if(auth()->user()->can('Attendance Management.view attendance'))
        <li class="hrp-menu-item {{ $attActive ? 'active-parent open' : '' }}" data-group="attendance"><a href="#" role="button"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Attendance">@else <span class="fa fa-calendar-check-o"></span>@endif</i> <span>Attendance Management</span></a></li>
        <li class="hrp-menu-item hrp-sub {{ request()->routeIs('attendance.report') ? 'active' : '' }}" data-group="attendance"><a href="{{ route('attendance.report') }}"><span>Attendance Report</span></a></li>
        @if(auth()->user()->can('Leave Management.approve leave') || auth()->user()->can('Leave Management.manage leave'))
          <li class="hrp-menu-item hrp-sub {{ request()->routeIs('leave-approval.*') ? 'active' : '' }}" data-group="attendance"><a href="{{ route('leave-approval.index') }}"><span>Leave Approval</span></a></li>
        @endif
      @endif
      
      @php($ico='event.svg')
      @php($p=public_path('side_icon/'.$ico))
      @if(auth()->user()->can('Events Management.view event') || auth()->user()->can('Events Management.manage event'))
        <li class="hrp-menu-item {{ request()->routeIs('events.*') ? 'active' : '' }}"><a href="{{ route('events.index') }}"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Event">@else <span class="fa fa-calendar"></span>@endif</i> <span>Events Management</span></a></li>
      @endif

      @php($ico='users.svg')
      @php($p=public_path('side_icon/'.$ico))
      @php($userActive = (request()->routeIs('users.*') || request()->routeIs('roles.*')))
      @if(auth()->user()->can('Users Management.view user') || auth()->user()->can('Users Management.manage user') || auth()->user()->can('Roles Management.view role') || auth()->user()->can('Roles Management.manage role'))
        <li class="hrp-menu-item {{ $userActive ? 'active-parent open' : '' }}" data-group="usermgmt"><a href="#" role="button"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="User Management">@else <span class="fa fa-users"></span>@endif</i> <span>User Management</span></a></li>
        @if(auth()->user()->can('Users Management.view user') || auth()->user()->can('Users Management.manage user'))
          <li class="hrp-menu-item hrp-sub {{ request()->routeIs('users.*') ? 'active' : '' }}" data-group="usermgmt"><a href="{{ route('users.index') }}"><span>Users</span></a></li>
        @endif
        @if(auth()->user()->can('Roles Management.view role') || auth()->user()->can('Roles Management.manage role'))
          <li class="hrp-menu-item hrp-sub {{ request()->routeIs('roles.*') ? 'active' : '' }}" data-group="usermgmt"><a href="{{ route('roles.index') }}"><span>Roles</span></a></li>
        @endif
      @endif


      @php($ico='rule.svg')
      @php($p=public_path('side_icon/'.$ico))
      @if(auth()->user()->can('Rules Management.view rules') || auth()->user()->can('Rules Management.manage rules'))
        <li class="hrp-menu-item {{ request()->routeIs('rules.index') ? 'active' : '' }}"><a href="{{ route('rules.index') }}" target="_blank" rel="noopener"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Rules">@else <span class="fa fa-book"></span>@endif</i> <span>Rules & Regulations</span></a></li>
      @endif

        <!-- @php($ico='settings.svg')
        @php($p=public_path('side_icon/'.$ico))
        <li class="hrp-menu-item {{ request()->routeIs('settings.index') ? 'active' : '' }}"><a href="{{ route('settings.index') }}"><i>@if(file_exists($p))<img src="{{ asset('side_icon/'.$ico) }}" alt="Settings">@else <span class="fa fa-cog"></span>@endif</i> <span>Setting</span></a></li> -->
    </ul>
    <script>
      (function(){
        function onClick(e){
          var a = e.target.closest('a');
          if(!a) return;
          var li = a.parentElement;
          if(!li || !li.matches('.hrp-menu-item[data-group]') || a.getAttribute('href') !== "#") return;
          e.preventDefault();
          
          // Close all other open menus
          var allMenuItems = document.querySelectorAll('.hrp-menu-item[data-group]');
          allMenuItems.forEach(function(item){
            if(item !== li && item.classList.contains('open')){
              item.classList.remove('open');
              var link = item.querySelector('a');
              if(link) link.setAttribute('aria-expanded', 'false');
            }
          });
          
          // Toggle current menu
          var isOpen = li.classList.toggle('open');
          a.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        }
        document.addEventListener('DOMContentLoaded', function(){
          var menu = document.querySelector('.hrp-menu');
          if(menu){ menu.addEventListener('click', onClick); }
        });
      })();
    </script>
  </div>
</aside>
