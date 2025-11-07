<aside id="hrpSidebar" class="hrp-sidebar">
  <div class="hrp-sidebar-inner">
    <div class="hrp-side-top" aria-hidden="true">
      <div class="hrp-window-dots">
        <span class="hrp-dot hrp-dot-r"></span>
        <span class="hrp-dot hrp-dot-y"></span>
        <span class="hrp-dot hrp-dot-g"></span>
      </div>
      <span class="hrp-side-badge"></span>
    </div>
    <ul class="hrp-menu">
      <li class="hrp-menu-item"><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
      @php
        $hrmActiveParent = request()->routeIs('hiring.*') || request()->routeIs('employees.*');
      @endphp
      <li class="hrp-menu-item {{ $hrmActiveParent ? 'active-parent' : '' }}"><a href="{{ route('section',['name'=>'hr']) }}"><i class="fa fa-users"></i> <span>HRM</span></a></li>

      <li class="hrp-menu-item hrp-sub {{ request()->routeIs('hiring.create') ? 'active' : '' }}"><a href="{{ route('hiring.create') }}"><span>Add New Hiring Lead</span></a></li>
     
      <li class="hrp-menu-item hrp-sub {{ request()->routeIs('hiring.index') ? 'active' : '' }}"><a href="{{ route('hiring.index') }}"><span>List of Hiring Lead</span></a></li>
    
      <li class="hrp-menu-item hrp-sub {{ request()->routeIs('employees.*') ? 'active' : '' }}"><a href="{{ route('employees.index') }}"><span>Employee List</span></a></li>
   
      <li class="hrp-menu-item"><a href="{{ route('attendance.report') }}"><i class="fa fa-calendar-check-o"></i> <span>Attendance Mgmt.</span></a></li>
    
      <li class="hrp-menu-item"><a href="{{ route('projects.index') }}"><i class="fa fa-tasks"></i> <span>Project & Task Mgmt.</span></a></li>
   
      <li class="hrp-menu-section">Inquiry Mgmt.</li>
  
      <li class="hrp-menu-item hrp-sub {{ request()->routeIs('inquiries.create') ? 'active' : '' }}"><a href="{{ route('inquiries.create') }}"><i class="fa fa-plus-circle"></i> <span>Add Inquiry</span></a></li>
 
      <li class="hrp-menu-item hrp-sub {{ request()->routeIs('inquiries.index') ? 'active' : '' }}"><a href="{{ route('inquiries.index') }}"><i class="fa fa-list"></i> <span>List Inquiries</span></a></li>

      <li class="hrp-menu-item {{ request()->routeIs('quotations.*') ? 'active-parent' : '' }}"><a href="{{ route('quotations.index') }}"><i class="fa fa-file-text-o"></i> <span>Quotation Mgmt.</span></a></li>
 
      <li class="hrp-menu-item {{ request()->routeIs('companies.*') ? 'active-parent' : '' }}"><a href="{{ route('companies.index') }}"><i class="fa fa-building-o"></i> <span>Company Info.</span></a></li>

        <li class="hrp-menu-item"><a href="{{ route('section',['name'=>'billing']) }}"><i class="fa fa-credit-card"></i> <span>Billing Mgmt.</span></a></li>
        <li class="hrp-menu-item"><a href="{{ route('section',['name'=>'payroll']) }}"><i class="fa fa-money"></i> <span>Payroll Mgmt.</span></a></li>

        <li class="hrp-menu-item"><a href="{{ route('tickets.index') }}"><i class="fa fa-life-ring"></i> <span>Ticket Support System</span></a></li>

      <li class="hrp-menu-item"><a href="{{ route('events.index') }}"><i class="fa fa-calendar"></i> <span>Event Mgmt.</span></a></li>

      <li class="hrp-menu-item"><a href="{{ route('section',['name'=>'rules']) }}"><i class="fa fa-book"></i> <span>Rules & Regulations</span></a></li>
    </ul>
  </div>
</aside>
