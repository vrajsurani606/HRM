<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HR Portal</title>
 <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
  
    <!-- Core CSS from theme -->
    <link rel="stylesheet" href="{{ asset('new_theme/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('new_theme/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('new_theme/bower_components/Ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('new_theme/bower_components/jquery-ui/themes/base/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('new_theme/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('new_theme/dist/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('new_theme/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('new_theme/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('new_theme/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('new_theme/css/macos.css') }}">
    <link rel="stylesheet" href="{{ asset('new_theme/css/visby-fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('new_theme/css/datatable.css') }}">
    <link rel="preload" href="{{ asset('new_theme/css/visby/VisbyRegular.otf') }}" as="font" type="font/otf" crossorigin>
    <link rel="preload" href="{{ asset('new_theme/css/visby/VisbyMedium.otf') }}" as="font" type="font/otf" crossorigin>
    <link rel="preload" href="{{ asset('new_theme/css/visby/VisbySemibold.otf') }}" as="font" type="font/otf" crossorigin>
    <link rel="preload" href="{{ asset('new_theme/css/visby/VisbyBold.otf') }}" as="font" type="font/otf" crossorigin>
    <link rel="stylesheet" href="{{ asset('new_theme/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('new_theme/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('new_theme/dist/css/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('new_theme/css/hrportal.css') }}">
    <!-- Toastr (notifications) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="skin-red sidebar-collapse macos-theme">

<!-- Global Page Loader -->
<div id="globalPageLoader" class="global-loader">
  <div class="loader-content">
    <div class="loader-spinner">
      <div class="spinner-ring"></div>
      <div class="spinner-ring"></div>
      <div class="spinner-ring"></div>
    </div>
    <div class="loader-text">Loading...</div>
  </div>
</div>

<style>
/* Global Page Loader Styles */
.global-loader {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.25);
  backdrop-filter: blur(2px);
  -webkit-backdrop-filter: blur(2px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 99999;
  opacity: 1;
  visibility: visible;
  transition: opacity 0.3s ease, visibility 0.3s ease;
}

.global-loader.hidden {
  opacity: 0;
  visibility: hidden;
  pointer-events: none;
}

.loader-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 16px;
  background: rgba(255, 255, 255, 0.95);
  padding: 28px 36px;
  border-radius: 16px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2), 0 0 0 1px rgba(255, 255, 255, 0.1);
}

.loader-spinner {
  position: relative;
  width: 50px;
  height: 50px;
}

.spinner-ring {
  position: absolute;
  width: 100%;
  height: 100%;
  border-radius: 50%;
  border: 3px solid transparent;
  animation: spin 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
}

.spinner-ring:nth-child(1) {
  border-top-color: #3b82f6;
  animation-delay: -0.45s;
}

.spinner-ring:nth-child(2) {
  border-top-color: #10b981;
  animation-delay: -0.3s;
  width: 75%;
  height: 75%;
  top: 12.5%;
  left: 12.5%;
}

.spinner-ring:nth-child(3) {
  border-top-color: #f59e0b;
  animation-delay: -0.15s;
  width: 50%;
  height: 50%;
  top: 25%;
  left: 25%;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.loader-text {
  font-size: 13px;
  font-weight: 600;
  color: #374151;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  letter-spacing: 0.3px;
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
  .loader-content {
    background: rgba(30, 41, 59, 0.98);
  }
  .loader-text {
    color: #e5e7eb;
  }
}

/* Global Modal Styles - Prevent overlapping with dock */
[style*="position: fixed"][style*="z-index: 9999"],
[style*="position: fixed"][style*="z-index:9999"],
.modal-overlay,
.ticket-view-modal-overlay,
.swal2-container {
  padding-bottom: 80px !important;
  box-sizing: border-box !important;
}

/* Ensure modal content is properly centered and doesn't overflow */
[style*="position: fixed"][style*="z-index: 9999"] > div:first-child,
[style*="position: fixed"][style*="z-index:9999"] > div:first-child {
  max-height: calc(100vh - 120px) !important;
  margin: auto !important;
}

/* SweetAlert specific fix */
.swal2-popup {
  margin-bottom: 40px !important;
}

.swal2-container.swal2-center {
  padding-bottom: 80px !important;
}
</style>

<div class="wrapper mac-glass-bg">

    <!-- Single rounded window -->
    <div class="hrp-window">
      <div class="hrp-shell">
        @include('partials.sidebar')
        <main class="hrp-main">
            @include('partials.header')
            <div class="hrp-content">
                @yield('content')
                @include('partials.footer')
            </div>
        </main>
      </div>
    </div>

    <!-- Backdrop for mobile sidebar -->
    <div class="hrp-backdrop" id="hrpBackdrop" aria-hidden="true"></div>

    <!-- Bottom Dock (fixed like macOS) -->
    <div class="mac-dock mac-dock-bottom">
        @if(auth()->user()->can('Dashboard.view dashboard') || auth()->user()->can('Dashboard.manage dashboard'))
          <a class="dock-item" data-section="dashboard" href="{{ route('dashboard') }}" title="Dashboard"><img src="{{ asset('Doc_icon/Dashboard.png') }}" alt="Dashboard" /></a>
        @endif
        @if(auth()->user()->can('Employees Management.view employee') || auth()->user()->can('Employees Management.manage employee') || auth()->user()->can('Leads Management.view lead') || auth()->user()->can('Leads Management.manage lead'))
          <a class="dock-item" data-section="hrm" href="{{ route('hiring.index') }}" title="HRM"><img src="{{ asset('Doc_icon/HRM.png') }}" alt="HRM" /></a>
        @endif
        @if(auth()->user()->can('Inquiries Management.view inquiry') || auth()->user()->can('Inquiries Management.manage inquiry'))
          <a class="dock-item" data-section="inquiry-mgmt" href="{{ route('inquiries.index') }}" title="Inquiry Mgmt."><img src="{{ asset('Doc_icon/Inquiry Management.png') }}" alt="Inquiry Mgmt." /></a>
        @endif
        @if(auth()->user()->can('Quotations Management.view quotation') || auth()->user()->can('Quotations Management.manage quotation'))
          <a class="dock-item" data-section="quotation-mgmt" href="{{ route('quotations.index') }}" title="Quotation Mgmt."><img src="{{ asset('Doc_icon/Quotation Management.png') }}" alt="Quotation Mgmt." /></a>
        @endif
        @if(auth()->user()->can('Companies Management.view company') || auth()->user()->can('Companies Management.manage company'))
          <a class="dock-item" data-section="company" href="{{ route('companies.index') }}" title="Company"><img src="{{ asset('Doc_icon/Company Information.png') }}" alt="Company" /></a>
        @endif
        @if(auth()->user()->can('Proformas Management.view proforma') || auth()->user()->can('Proformas Management.manage proforma') || auth()->user()->can('Invoices Management.view invoice') || auth()->user()->can('Invoices Management.manage invoice') || auth()->user()->can('Receipts Management.view receipt') || auth()->user()->can('Receipts Management.manage receipt'))
          <a class="dock-item" data-section="invoice-mgmt" href="{{ route('performas.index') }}" title="Invoice Mgmt."><img src="{{ asset('Doc_icon/Performa Management.png') }}" alt="Invoice Mgmt." /></a>
        @endif
        @if(auth()->user()->can('Payroll Management.view payroll') || auth()->user()->can('Payroll Management.manage payroll'))
          <a class="dock-item" data-section="payroll-mgmt" href="{{ route('payroll.index') }}" title="Payroll Mgmt."><img src="{{ asset('Doc_icon/Payroll Management.png') }}" alt="Payroll Mgmt." /></a>
        @endif
        @if(auth()->user()->can('Projects Management.view project') || auth()->user()->can('Projects Management.manage project'))
          <a class="dock-item" data-section="project-task-mgmt" href="{{ route('projects.index') }}" title="Project & Task Mgmt."><img src="{{ asset('Doc_icon/Project & Task Management.png') }}" alt="Project & Task Mgmt." /></a>
        @endif
        @if(auth()->user()->can('Tickets Management.view ticket') || auth()->user()->can('Tickets Management.manage ticket'))
          <a class="dock-item" data-section="ticket" href="{{ route('tickets.index') }}" title="Ticket"><img src="{{ asset('Doc_icon/Ticket Support System.png') }}" alt="Ticket" /></a>
        @endif
        @if(auth()->user()->can('Attendance Management.view attendance'))
          <a class="dock-item" data-section="attendance-mgmt" href="{{ route('attendance.report') }}" title="Attendance Mgmt."><img src="{{ asset('Doc_icon/Attendance Management.png') }}" alt="Attendance Mgmt." /></a>
        @endif
        @if(auth()->user()->can('Events Management.view event') || auth()->user()->can('Events Management.manage event'))
          <a class="dock-item" data-section="events-mgmt" href="{{ route('events.index') }}" title="Events Mgmt."><img src="{{ asset('Doc_icon/Event Management..png') }}" alt="Events Mgmt." /></a>
        @endif
        @if(auth()->user()->can('Rules Management.view rules') || auth()->user()->can('Rules Management.manage rules'))
          <a class="dock-item" data-section="rules-regulations" href="{{ route('rules.index') }}" title="Rules & Regulations" target="_blank" rel="noopener"><img src="{{ asset('Doc_icon/Rules & Regulations.png') }}" alt="Rules & Regulations" /></a>
        @endif
    </div>

</div>

<!-- Core JS from theme -->
<script src="{{ asset('new_theme/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('new_theme/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('new_theme/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('new_theme/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('new_theme/bower_components/moment/moment.js') }}"></script>
<script src="{{ asset('new_theme/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('new_theme/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<script src="{{ asset('new_theme/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('new_theme/bower_components/ckeditor/ckeditor.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
      // Initialize toastr with default options
      toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      };
    </script>
@include('partials.flash')
<style>
  /* Perfect SweetAlert Size - Global */
  .perfect-swal-popup {
    font-size: 15px !important;
  }
  
  .perfect-swal-popup .swal2-title {
    font-size: 20px !important;
    font-weight: 600 !important;
    margin-bottom: 1rem !important;
  }
  
  .perfect-swal-popup .swal2-content {
    font-size: 15px !important;
    margin-bottom: 1.5rem !important;
    line-height: 1.4 !important;
  }
  
  .perfect-swal-popup .swal2-actions {
    gap: 0.75rem !important;
    margin-top: 1rem !important;
  }
  
  .perfect-swal-popup .swal2-confirm,
  .perfect-swal-popup .swal2-cancel {
    font-size: 14px !important;
    padding: 8px 16px !important;
    border-radius: 6px !important;
  }
  
  .perfect-swal-popup .swal2-icon {
    margin: 0.5rem auto 1rem !important;
  }
  
  .swal2-backdrop-show { backdrop-filter: blur(1px); }
</style>
<script>
  // Global SweetAlert Delete Confirmation
  document.addEventListener('click', function(e){
    // Handle forms with onsubmit="return confirm(...)"
    const form = e.target.closest('form[onsubmit*="confirm"]');
    if(form && e.target.type === 'submit'){
      e.preventDefault();
      Swal.fire({
        title: 'Delete this item?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        width: '400px',
        padding: '1.5rem',
        customClass: { popup: 'perfect-swal-popup' }
      }).then((result) => {
        if (result.isConfirmed) {
          form.removeAttribute('onsubmit');
          form.submit();
        }
      });
      return;
    }
    
    // Handle .js-confirm-delete class
    const btn = e.target.closest('.js-confirm-delete');
    if(!btn) return;
    e.preventDefault();
    const deleteForm = btn.closest('form');
    const title = btn.getAttribute('data-title') || 'Delete this item?';
    const text = btn.getAttribute('data-text') || "You won't be able to revert this!";
    const confirmText = btn.getAttribute('data-confirm') || 'Yes, delete it!';
    const cancelText = btn.getAttribute('data-cancel') || 'Cancel';
    const icon = btn.getAttribute('data-icon') || 'warning';
    Swal.fire({
      title: title,
      text: text,
      icon: icon,
      showCancelButton: true,
      confirmButtonColor: '#ef4444',
      cancelButtonColor: '#6b7280',
      confirmButtonText: confirmText,
      cancelButtonText: cancelText,
      width: '400px',
      padding: '1.5rem',
      customClass: { popup: 'perfect-swal-popup' }
    }).then((result) => {
      if (!result.isConfirmed) return;
      const wantsAjax = btn.hasAttribute('data-ajax') || (deleteForm && deleteForm.hasAttribute('data-ajax'));
      if (!wantsAjax) { deleteForm.submit(); return; }
      // AJAX delete without page refresh
      try {
        const tokenInput = deleteForm && deleteForm.querySelector('input[name="_token"]');
        const csrf = tokenInput ? tokenInput.value : (document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '');
        btn.disabled = true;
        function removeTarget(){
          var sel = btn.getAttribute('data-remove');
          var node = sel ? btn.closest(sel) : btn.closest('tr');
          if(node) node.remove();
        }
        function tryDeleteWith(method, opts){
          return fetch(deleteForm.action, Object.assign({ method: method, credentials:'same-origin' }, opts));
        }
        tryDeleteWith('DELETE', {
          method: 'DELETE',
          headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
        }).then(function(resp){
          if(resp.status === 405){
            return tryDeleteWith('POST', {
              headers: { 'X-CSRF-TOKEN': csrf, 'Accept':'application/json', 'Content-Type':'application/x-www-form-urlencoded' },
              body: new URLSearchParams({ _method: 'DELETE' })
            });
          }
          return resp;
        }).then(function(resp){
          if(!(resp.status >= 200 && resp.status < 400)) throw new Error(String(resp.status));
          return resp.json().catch(function(){ return {}; });
        }).then(function(){
          removeTarget();
          if(window.toastr) toastr.success(btn.getAttribute('data-success') || 'Deleted successfully');
        }).catch(function(err){
          var msg = 'Failed to delete';
          if(err && err.message){ msg += ' ('+err.message+')'; }
          if(window.toastr) toastr.error(msg);
        }).finally(function(){ btn.disabled = false; });
      } catch(e){ deleteForm.submit(); }
    });
  });
  // Basic Toastr defaults
  if (window.toastr) {
    toastr.options = { closeButton: true, progressBar: true, timeOut: 2500, positionClass: 'toast-bottom-right' };
  }
  // Sidebar toggle: MOBILE ONLY. On desktop, the blue badge toggles HRM submenu (no overlay).
  (function(){
    var body = document.body;
    var toggle = document.querySelector('.hrp-menu-toggle');
    var backdrop = document.getElementById('hrpBackdrop');
    var sidebar = document.getElementById('hrpSidebar');
    function isMobile(){ return window.innerWidth <= 1024; }
    function setSidebar(open){
      if(!isMobile()) return; // guard: only mobile slides in/out
      if(open){ body.classList.add('sidebar-open'); if(toggle) toggle.setAttribute('aria-expanded','true'); }
      else { body.classList.remove('sidebar-open'); if(toggle) toggle.setAttribute('aria-expanded','false'); }
    }
    // robust delegation (hamburger and blue badge in sidebar top)
    document.addEventListener('click', function(e){
      var btn = e.target.closest('.hrp-menu-toggle, .hrp-side-badge');
      if(!btn) return;
      e.preventDefault();
      if(isMobile()){
        setSidebar(!body.classList.contains('sidebar-open'));
      } else if(sidebar){
        // Desktop: collapse/expand to icons-only
        sidebar.classList.toggle('hrp-sidebar-collapsed');
      }
    });
    // keyboard support for badge
    document.addEventListener('keydown', function(e){
      var isBadge = e.target && e.target.classList && e.target.classList.contains('hrp-side-badge');
      if(!isBadge) return;
      if(e.key === 'Enter' || e.key === ' '){
        e.preventDefault();
        if(isMobile()){
          setSidebar(!body.classList.contains('sidebar-open'));
        } else if(sidebar){
          sidebar.classList.toggle('hrp-sidebar-collapsed');
        }
      }
    }, true);
    if(backdrop){ backdrop.addEventListener('click', function(){ setSidebar(false); }); }
    if(sidebar){ sidebar.addEventListener('click', function(e){ var a = e.target.closest('a'); if(a && body.classList.contains('sidebar-open')) setSidebar(false); }); }
    document.addEventListener('keydown', function(e){ if(e.key === 'Escape') setSidebar(false); });
    window.addEventListener('resize', function(){ if(!isMobile()) { body.classList.remove('sidebar-open'); } });
  
    // HRM submenu: open on first click (like the image), then allow navigation
    (function(){
      var sidebar = document.getElementById('hrpSidebar');
      if(!sidebar) return;
      var hrmParent = sidebar.querySelector('.hrp-menu-item[data-group="hrm"] > a');
      function setHrmOpen(open){
        sidebar.classList.toggle('group-open-hrm', !!open);
        var parentLi = sidebar.querySelector('.hrp-menu-item[data-group="hrm"]');
        if(parentLi){ parentLi.classList.toggle('open', !!open); }
      }
      var hasActiveHrm = !!sidebar.querySelector('.hrp-menu-item.hrp-sub[data-group="hrm"].active');
      if(hasActiveHrm){ setHrmOpen(true); }
      if(hrmParent){
        hrmParent.addEventListener('click', function(e){
          if(!sidebar.classList.contains('group-open-hrm')){
            e.preventDefault();
            setHrmOpen(true);
          }
        });
      }
    })();

    // Dock magnification (hovered + 2 neighbors each side) and tooltip follow
    try {
      var dock = document.querySelector('.mac-dock');
      if (dock) {
        var items = Array.prototype.slice.call(dock.querySelectorAll('.dock-item'));
        // Reference-like fixed scales and lifts
        var scales = [1.1, 1.2, 1.5]; // for offsets 2,1,0 respectively
        var lifts = [0, 6, 10]; // px (will be applied as negative translateY)
        var animReq = null;
        var mouseX = 0;
        var activeIndex = -1;

        function ensureTooltip(){
          if(window.__dockTooltip) return;
          var tooltip = document.querySelector('.dock-tooltip');
          if(!tooltip){
            tooltip = document.createElement('div');
            tooltip.className = 'dock-tooltip';
            // inline critical styles to guarantee visibility
            tooltip.style.position = 'fixed';
            tooltip.style.zIndex = '20000';
            tooltip.style.padding = '6px 10px';
            tooltip.style.background = '#ffffff';
            tooltip.style.color = '#0f172a';
            tooltip.style.border = '1px solid rgba(15,23,42,0.06)';
            tooltip.style.borderRadius = '10px';
            tooltip.style.boxShadow = '0 8px 24px rgba(0,0,0,0.18), inset 0 1px 0 rgba(255,255,255,0.8)';
            tooltip.style.pointerEvents = 'none';
            tooltip.style.transform = 'translate(-50%, -12px)';
            tooltip.style.whiteSpace = 'nowrap';
            tooltip.style.display='none';
            document.body.appendChild(tooltip);
          }
          function getTitle(el){
            var t = el.getAttribute('data-title');
            if(!t){
              t = el.getAttribute('title') || '';
              if(!t){ var img = el.querySelector('img'); if(img){ t = img.getAttribute('alt') || ''; } }
              if(!t){ t = el.getAttribute('data-section') || ''; }
              el.setAttribute('data-title', t);
              el.removeAttribute('title');
            }
            return t;
          }
          function getGap(){
            var rs = getComputedStyle(document.documentElement);
            var v = parseFloat(rs.getPropertyValue('--dock-tooltip-gap'));
            return isNaN(v) ? 28 : v;
          }
          window.__dockTooltip = {
            updateForIndex: function(i){
              var list = dock.querySelectorAll('.dock-item');
              if(i<0 || i>=list.length){ this.hide(); return; }
              var a = list[i];
              var title = getTitle(a); if(!title){ this.hide(); return; }
              tooltip.textContent = title;
              var img = a.querySelector('img'); var r = (img? img.getBoundingClientRect(): a.getBoundingClientRect());
              tooltip.style.left = (r.left + r.width/2) + 'px';
              tooltip.style.top = (r.top - getGap()) + 'px';
              tooltip.style.display = 'block';
              tooltip.style.opacity = '1';
            },
            hide: function(){
              tooltip.style.opacity = '0';
              setTimeout(function(){ tooltip.style.display = 'none'; }, 160);
            }
          };
        }

        function nearestIndex(x){
          var best = -1, bestDist = Infinity;
          items.forEach(function(it, i){
            var r = it.getBoundingClientRect();
            var cx = r.left + r.width/2;
            var d = Math.abs(cx - x);
            if(d < bestDist){ bestDist = d; best = i; }
          });
          return best;
        }

        function applyMagnify(){
          animReq = null;
          items.forEach(function(it){ var img = it.querySelector('img'); if(img){ img.style.transform = 'translateY(0) scale(1)'; } });
          if(activeIndex < 0) return;
          var idxs = [activeIndex-2, activeIndex-1, activeIndex, activeIndex+1, activeIndex+2];
          var weights = [0,1,2,1,0].map(function(w){ return [2,1,0,1,2][[0,1,2,3,4].indexOf(w)]; }); // not used; we'll index directly
          // center and neighbors with fixed values
          var mapping = [
            {off:-2, s:scales[0], ly:lifts[0]},
            {off:-1, s:scales[1], ly:lifts[1]},
            {off: 0, s:scales[2], ly:lifts[2]},
            {off: 1, s:scales[1], ly:lifts[1]},
            {off: 2, s:scales[0], ly:lifts[0]},
          ];
          for(var j=0;j<mapping.length;j++){
            var idx = activeIndex + mapping[j].off;
            if(idx < 0 || idx >= items.length) continue;
            var img = items[idx].querySelector('img');
            if(img){ img.style.transform = 'translateY(' + (-mapping[j].ly) + 'px) scale(' + mapping[j].s + ')'; }
          }
          // tooltip follow active
          ensureTooltip();
          if(window.__dockTooltip){ window.__dockTooltip.updateForIndex(activeIndex); }
        }

        function onMove(e){
          mouseX = e.clientX;
          var ni = nearestIndex(mouseX);
          if(ni !== activeIndex){ activeIndex = ni; }
          if(!animReq) animReq = requestAnimationFrame(applyMagnify);
        }

        function resetDock(){
          activeIndex = -1;
          items.forEach(function(it){ var img = it.querySelector('img'); if(img){ img.style.transform = ''; } });
          if(window.__dockTooltip){ window.__dockTooltip.hide(); }
          if(dock){ dock.classList.remove('is-hovering'); }
        }

        dock.addEventListener('mousemove', onMove);
        dock.addEventListener('pointermove', onMove);
        dock.addEventListener('mouseenter', function(){ dock.classList.add('is-hovering'); });
        dock.addEventListener('pointerenter', function(){ dock.classList.add('is-hovering'); });
        dock.addEventListener('mouseleave', resetDock);
        // Also lock to item on hover for precise index (reference-like)
        items.forEach(function(it, i){
          it.addEventListener('mouseenter', function(){ activeIndex = i; ensureTooltip(); if(window.__dockTooltip){ window.__dockTooltip.updateForIndex(i); } if(!animReq) animReq = requestAnimationFrame(applyMagnify); });
          it.addEventListener('pointerenter', function(){ activeIndex = i; ensureTooltip(); if(window.__dockTooltip){ window.__dockTooltip.updateForIndex(i); } if(!animReq) animReq = requestAnimationFrame(applyMagnify); });
          it.addEventListener('mouseleave', function(){ if(window.__dockTooltip){ window.__dockTooltip.hide(); } });
          it.addEventListener('pointerleave', function(){ if(window.__dockTooltip){ window.__dockTooltip.hide(); } });
        });
      }
    } catch(err) { /* no-op */ }

    // Dock tooltip and active indicator
    (function(){
      var dock = document.querySelector('.mac-dock');
      if(!dock) return;
      if(window.__dockTooltip) return; // avoid overriding existing tooltip implementation
      var tooltip = document.createElement('div');
      tooltip.className = 'dock-tooltip';
      tooltip.style.position = 'fixed';
      tooltip.style.zIndex = '20000';
      tooltip.style.padding = '6px 10px';
      tooltip.style.background = '#ffffff';
      tooltip.style.color = '#0f172a';
      tooltip.style.border = '1px solid rgba(15,23,42,0.06)';
      tooltip.style.borderRadius = '10px';
      tooltip.style.boxShadow = '0 8px 24px rgba(0,0,0,0.18), inset 0 1px 0 rgba(255,255,255,0.8)';
      tooltip.style.pointerEvents = 'none';
      tooltip.style.transform = 'translate(-50%, -12px)';
      tooltip.style.whiteSpace = 'nowrap';
      tooltip.style.display = 'none';
      document.body.appendChild(tooltip);

      function setActiveFromLocation(){
        var loc = new URL(window.location.href);
        var segs = loc.pathname.split('/').filter(Boolean);
        var lastSeg = segs.length ? segs[segs.length-1] : '';
        var qName = loc.searchParams.get('name') || '';
        var current = qName || lastSeg;
        var links = dock.querySelectorAll('.dock-item');
        links.forEach(function(a){
          var sec = a.getAttribute('data-section') || '';
          a.classList.toggle('active', !!(sec && current && current === sec));
        });
      }
      setActiveFromLocation();

      function getTitle(el){
        var t = el.getAttribute('data-title');
        if(!t){ t = el.getAttribute('title') || ''; el.setAttribute('data-title', t); el.removeAttribute('title'); }
        return t;
      }

      function getGap(){
        var rs = getComputedStyle(document.documentElement);
        var v = parseFloat(rs.getPropertyValue('--dock-tooltip-gap'));
        return isNaN(v) ? 28 : v;
      }
      window.__dockTooltip = {
        updateForIndex: function(i){
          var items = dock.querySelectorAll('.dock-item');
          if(i<0 || i>=items.length) { this.hide(); return; }
          var a = items[i];
          var title = getTitle(a);
          if(!title){ this.hide(); return; }
          tooltip.textContent = title;
          var img = a.querySelector('img');
          var r = (img ? img.getBoundingClientRect() : a.getBoundingClientRect());
          var top = r.top - getGap();
          var left = r.left + r.width/2;
          tooltip.style.left = left + 'px';
          tooltip.style.top = top + 'px';
          tooltip.style.display = 'block';
          tooltip.style.opacity = '1';
        },
        hide: function(){
          tooltip.style.opacity = '0';
          setTimeout(function(){ tooltip.style.display = 'none'; }, 160);
        }
      };

      // Keyboard focus support
      dock.querySelectorAll('.dock-item').forEach(function(a, idx){
        a.addEventListener('focus', function(){ if(window.__dockTooltip) window.__dockTooltip.updateForIndex(idx); });
        a.addEventListener('blur', function(){ if(window.__dockTooltip) window.__dockTooltip.hide(); });
      });
      function __hideDockTip(){ if(window.__dockTooltip) window.__dockTooltip.hide(); }
      window.addEventListener('resize', __hideDockTip);
      document.addEventListener('scroll', __hideDockTip, true);
    })();
  })();
</script>

<!-- Global Datepicker Initialization (jQuery UI) -->
<script>
  $(document).ready(function() {
    // Initialize all datepickers with DD/MM/YYYY format (jQuery UI)
    if ($.fn.datepicker && $.datepicker) {
      // Initialize datepickers on common selectors
      $('.datepicker, .date-picker, input[type="date"], .date-input, [data-provide="datepicker"]').each(function() {
        var $input = $(this);
        
        // Skip if already initialized
        if ($input.hasClass('hasDatepicker')) return;
        
        // Change type from date to text for better control
        if ($input.attr('type') === 'date') {
          $input.attr('type', 'text');
        }
        
        // Initialize jQuery UI datepicker
        $input.datepicker({
          dateFormat: 'dd/mm/yy', // jQuery UI format (yy = 4-digit year)
          changeMonth: true,
          changeYear: true,
          yearRange: '-10:+10',
          showButtonPanel: true,
          beforeShow: function(input, inst) {
            setTimeout(function() {
              inst.dpDiv.css({
                marginTop: '2px',
                marginLeft: '0px'
              });
            }, 0);
          }
        });
        
        // Ensure text color is black
        $input.css({
          'color': '#000',
          '-webkit-text-fill-color': '#000'
        });
      });
    }
    
    // Fix for dynamically added datepickers
    $(document).on('focus', 'input.datepicker:not(.hasDatepicker), input.date-picker:not(.hasDatepicker), input[data-provide="datepicker"]:not(.hasDatepicker)', function() {
      var $input = $(this);
      if (!$input.hasClass('hasDatepicker')) {
        if ($input.attr('type') === 'date') {
          $input.attr('type', 'text');
        }
        $input.datepicker({
          dateFormat: 'dd/mm/yy',
          changeMonth: true,
          changeYear: true,
          yearRange: '-10:+10',
          showButtonPanel: true,
          beforeShow: function(input, inst) {
            setTimeout(function() {
              inst.dpDiv.css({
                marginTop: '2px',
                marginLeft: '0px'
              });
            }, 0);
          }
        });
        $input.css({
          'color': '#000',
          '-webkit-text-fill-color': '#000'
        });
      }
    });
    
    // Ensure all date inputs have proper text color
    $('input[type="date"], input.datepicker, input.date-picker, .date-input').on('change input', function() {
      $(this).css({
        'color': '#000',
        '-webkit-text-fill-color': '#000'
      });
    });
  });
</script>

<!-- Browser navigation for yellow and green dots -->
<script>
(function() {
  'use strict';
  
  let yellowInitialized = false;
  let greenInitialized = false;
  
  function handleYellowClick(e) {
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    console.log('Yellow dot clicked - Going back');
    window.history.back();
    return false;
  }
  
  function handleGreenClick(e) {
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    console.log('Green dot clicked - Going forward');
    window.history.forward();
    return false;
  }
  
  function initNavigationDots() {
    const yellowDot = document.querySelector('.hrp-dot-y');
    const greenDot = document.querySelector('.hrp-dot-g');
    
    if (yellowDot && !yellowInitialized) {
      // Add multiple event types to ensure it works
      yellowDot.addEventListener('click', handleYellowClick, true);
      yellowDot.addEventListener('mousedown', handleYellowClick, true);
      yellowDot.addEventListener('touchstart', handleYellowClick, true);
      
      yellowDot.style.cursor = 'pointer';
      yellowDot.title = 'Go Back';
      yellowDot.setAttribute('role', 'button');
      yellowDot.setAttribute('aria-label', 'Go Back');
      
      yellowInitialized = true;
      console.log('Yellow dot initialized');
    }
    
    if (greenDot && !greenInitialized) {
      // Add multiple event types to ensure it works
      greenDot.addEventListener('click', handleGreenClick, true);
      greenDot.addEventListener('mousedown', handleGreenClick, true);
      greenDot.addEventListener('touchstart', handleGreenClick, true);
      
      greenDot.style.cursor = 'pointer';
      greenDot.title = 'Go Forward';
      greenDot.setAttribute('role', 'button');
      greenDot.setAttribute('aria-label', 'Go Forward');
      
      greenInitialized = true;
      console.log('Green dot initialized');
    }
  }
  
  // Initialize immediately if DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initNavigationDots);
  } else {
    initNavigationDots();
  }
  
  // Also try after window load
  window.addEventListener('load', initNavigationDots);
  
  // And after delays to catch any dynamic content
  setTimeout(initNavigationDots, 100);
  setTimeout(initNavigationDots, 500);
  setTimeout(initNavigationDots, 1000);
})();
</script>

<!-- Password Toggle Script -->
<script src="{{ asset('js/password-toggle.js') }}"></script>
<script src="{{ asset('js/live-search.js') }}"></script>
<script src="{{ asset('js/mobile-number-limit.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/state-city-dropdown.js') }}"></script>

@stack('scripts')
<!-- Toastr initialization is handled in partials/flash.blade.php -->

<!-- Global Page Loader Script -->
<script>
(function() {
  var loader = document.getElementById('globalPageLoader');
  if (!loader) return;
  
  // Hide loader when page is fully loaded
  function hideLoader() {
    setTimeout(function() {
      loader.classList.add('hidden');
    }, 300);
  }
  
  // Show loader
  function showLoader() {
    loader.classList.remove('hidden');
  }
  
  // Hide on page load
  if (document.readyState === 'complete') {
    hideLoader();
  } else {
    window.addEventListener('load', hideLoader);
  }
  
  // Show loader on form submit
  document.addEventListener('submit', function(e) {
    var form = e.target;
    // Skip AJAX forms
    if (form.hasAttribute('data-ajax') || form.hasAttribute('data-no-loader')) return;
    // Skip forms with target="_blank"
    if (form.target === '_blank') return;
    showLoader();
  });
  
  // Show loader on link click (navigation)
  document.addEventListener('click', function(e) {
    var link = e.target.closest('a');
    if (!link) return;
    // Skip if has data-no-loader attribute
    if (link.hasAttribute('data-no-loader')) return;
    // Skip external links, anchors, javascript:, mailto:, tel:
    var href = link.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) return;
    // Skip target="_blank" links
    if (link.target === '_blank') return;
    // Skip download links
    if (link.hasAttribute('download')) return;
    // Skip export/excel/pdf download links
    if (href && (href.includes('export') || href.includes('excel') || href.includes('download') || href.includes('pdf'))) {
      // For downloads, show loader briefly then hide after 2 seconds
      showLoader();
      setTimeout(hideLoader, 2000);
      return;
    }
    // Skip if modifier key pressed (new tab)
    if (e.ctrlKey || e.metaKey || e.shiftKey) return;
    showLoader();
  });
  
  // Hide loader on back/forward navigation
  window.addEventListener('pageshow', function(e) {
    if (e.persisted) {
      hideLoader();
    }
  });
  
  // Hide loader when SweetAlert is shown
  if (typeof Swal !== 'undefined') {
    document.addEventListener('click', function() {
      setTimeout(function() {
        if (document.querySelector('.swal2-container')) {
          hideLoader();
        }
      }, 100);
    });
  }
  
  // Observer to detect SweetAlert popup and hide loader
  var swalObserver = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
      if (mutation.addedNodes.length) {
        mutation.addedNodes.forEach(function(node) {
          if (node.classList && (node.classList.contains('swal2-container') || node.classList.contains('swal2-popup'))) {
            hideLoader();
          }
        });
      }
    });
  });
  swalObserver.observe(document.body, { childList: true, subtree: true });
  
  // Expose globally for manual control
  window.showPageLoader = showLoader;
  window.hidePageLoader = hideLoader;
})();
</script>
</body>
</html>
