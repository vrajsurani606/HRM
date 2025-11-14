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
        <a class="dock-item" data-section="dashboard" href="{{ route('dashboard') }}" title="Dashboard"><img src="{{ asset('Doc_icon/Dashboard.png') }}" alt="Dashboard" /></a>
        <a class="dock-item" data-section="hrm" href="{{ route('hiring.index') }}" title="HRM"><img src="{{ asset('Doc_icon/HRM.png') }}" alt="HRM" /></a>
        <a class="dock-item" data-section="inquiry-mgmt" href="{{ route('inquiries.index') }}" title="Inquiry Mgmt."><img src="{{ asset('Doc_icon/Inquiry Management.png') }}" alt="Inquiry Mgmt." /></a>
        <a class="dock-item" data-section="quotation-mgmt" href="{{ route('quotations.index') }}" title="Quotation Mgmt."><img src="{{ asset('Doc_icon/Quotation Management.png') }}" alt="Quotation Mgmt." /></a>
        <a class="dock-item" data-section="company" href="{{ route('companies.index') }}" title="Company"><img src="{{ asset('Doc_icon/Company Information.png') }}" alt="Company" /></a>
        <a class="dock-item" data-section="invoice-mgmt" href="{{ route('performas.index') }}" title="Invoice Mgmt."><img src="{{ asset('Doc_icon/Performa Management.png') }}" alt="Invoice Mgmt." /></a>
        <a class="dock-item" data-section="payroll-mgmt" href="{{ route('payroll.index') }}" title="Payroll Mgmt."><img src="{{ asset('Doc_icon/Payroll Management.png') }}" alt="Payroll Mgmt." /></a>
        <a class="dock-item" data-section="project-task-mgmt" href="{{ route('projects.index') }}" title="Project & Task Mgmt."><img src="{{ asset('Doc_icon/Project & Task Management.png') }}" alt="Project & Task Mgmt." /></a>
        <a class="dock-item" data-section="ticket" href="{{ route('tickets.index') }}" title="Ticket"><img src="{{ asset('Doc_icon/Ticket Support System.png') }}" alt="Ticket" /></a>
        <a class="dock-item" data-section="attendance-mgmt" href="{{ route('attendance.report') }}" title="Attendance Mgmt."><img src="{{ asset('Doc_icon/Attendance Management.png') }}" alt="Attendance Mgmt." /></a>
        <a class="dock-item" data-section="events-mgmt" href="{{ route('events.index') }}" title="Events Mgmt."><img src="{{ asset('Doc_icon/Event Management..png') }}" alt="Events Mgmt." /></a>
        <a class="dock-item" data-section="rules-regulations" href="{{ route('rules.index') }}" title="Rules & Regulations" target="_blank" rel="noopener"><img src="{{ asset('Doc_icon/Rules & Regulations.png') }}" alt="Rules & Regulations" /></a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
@stack('scripts')
</body>
</html>
