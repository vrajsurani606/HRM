# HR Portal macOS-Style Design Guide

This document explains the current macOS-style UI used in HR Portal and how to replicate it in a second project. It covers structure, required assets, key components, and step-by-step integration instructions.

---

## Overview
- **Core layout**: A single rounded “window” with sidebar + header + content.
- **Aesthetic**: Light glass, soft shadows, rounded corners, macOS traffic-light dots, and a fixed glass-like bottom dock.
- **Primary files**:
  - Layout: `resources/views/layouts/macos.blade.php`
  - Styles: `public/new_theme/css/hrportal.css`

---

## Required Assets
Include these styles/scripts (as in `macos.blade.php`). Adjust paths for your project.

- **CSS**
  - Bootstrap: `new_theme/bower_components/bootstrap/dist/css/bootstrap.min.css`
  - Font Awesome: `new_theme/bower_components/font-awesome/css/font-awesome.min.css`
  - Ionicons: `new_theme/bower_components/Ionicons/css/ionicons.min.css`
  - AdminLTE: `new_theme/dist/css/AdminLTE.min.css`, `new_theme/dist/css/skins/_all-skins.min.css`
  - Datepicker & Daterangepicker: `new_theme/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css`, `new_theme/bower_components/bootstrap-daterangepicker/daterangepicker.css`
  - WYSIHTML5: `new_theme/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css`
  - Project fonts and tables: `new_theme/css/visby-fonts.css`, `new_theme/css/jquery.dataTables.min.css`, `new_theme/css/buttons.dataTables.min.css`, `new_theme/dist/css/select2.min.css`
  - HR Portal theme: `new_theme/css/macos.css` (if present), `new_theme/css/hrportal.css`

- **JS**
  - jQuery, jQuery UI
  - Bootstrap
  - Datepicker, Daterangepicker, Moment.js
  - WYSIHTML5
  - Select2
  - CKEditor (if you need rich text)

Note: If the second project doesn’t need AdminLTE/Select2/etc., you can include only what’s necessary, but `hrportal.css` expects the basic reset/utility styles from Bootstrap.

---

## Layout Structure
Use the same high-level structure to achieve the macOS look.

```html
<body class="skin-red sidebar-collapse macos-theme">
  <div class="wrapper mac-glass-bg">
    <div class="hrp-window">
      <div class="hrp-shell">
        <!-- Sidebar -->
        <aside class="hrp-sidebar">
          <div class="hrp-sidebar-inner">
            <div class="hrp-side-top">
              <div class="hrp-window-dots">
                <span class="hrp-dot hrp-dot-r"></span>
                <span class="hrp-dot hrp-dot-y"></span>
                <span class="hrp-dot hrp-dot-g"></span>
              </div>
            </div>
            <ul class="hrp-menu">
              <!-- .hrp-menu-item, .hrp-sub, .active -->
            </ul>
          </div>
        </aside>

        <!-- Main -->
        <main class="hrp-main">
          <header class="hrp-header">
            <div class="hrp-header-left">
              <div class="hrp-window-dots">
                <span class="hrp-dot hrp-dot-r"></span>
                <span class="hrp-dot hrp-dot-y"></span>
                <span class="hrp-dot hrp-dot-g"></span>
              </div>
              <h1 class="hrp-page-title">Page Title</h1>
            </div>
            <div class="hrp-header-right">
              <!-- thumb, user button, fingerprint, etc. -->
            </div>
          </header>

          <div class="hrp-content">
            <!-- Your page content and cards/forms -->
          </div>
        </main>
      </div>
    </div>

    <!-- Bottom Dock -->
    <div class="mac-dock mac-dock-bottom">
      <a class="dock-item" href="#" title="Example">
        <img src="new_theme/images/nav_icon/master_setup.svg" alt="Master" />
      </a>
      <span class="mac-dock-divider" aria-hidden="true"></span>
      <!-- More items -->
    </div>
  </div>
</body>
```

Key wrappers/classes are defined in `hrportal.css`:
- `.hrp-window`, `.hrp-shell`, `.hrp-sidebar`, `.hrp-main`, `.hrp-content`
- `.hrp-header`, `.hrp-window-dots`, `.hrp-dot{,-r,-y,-g}`
- `.mac-dock-bottom`, `.dock-item`, `.mac-dock-divider`

---

## Sidebar
- Structure: `.hrp-sidebar > .hrp-sidebar-inner`
- Sections: `.hrp-menu-section`
- Items: `.hrp-menu-item > a` with optional icon `<i>`
- Sub-items: `.hrp-menu-item.hrp-sub`
- States:
  - `.active` to highlight current page
  - `.active-parent` to highlight parent while sub is active

Example:
```html
<li class="hrp-menu-item active-parent">
  <a href="#"><i class="fa fa-home"></i> <span>Dashboard</span></a>
</li>
<li class="hrp-menu-item hrp-sub active">
  <a href="#"><span>Overview</span></a>
</li>
```

---

## Header
- Title: `.hrp-page-title`
- macOS dots: `.hrp-window-dots > .hrp-dot{,-r,-y,-g}`
- Right area: avatar, user button `.hrp-user-btn`, fingerprint `.hrp-fingerprint`

```html
<header class="hrp-header">
  <div class="hrp-header-left">
    <div class="hrp-window-dots">
      <span class="hrp-dot hrp-dot-r"></span>
      <span class="hrp-dot hrp-dot-y"></span>
      <span class="hrp-dot hrp-dot-g"></span>
    </div>
    <h1 class="hrp-page-title">Employees</h1>
  </div>
  <div class="hrp-header-right">
    <button class="hrp-user-btn">
      <div class="hrp-user-meta">
        <div class="hrp-user-name">John Doe</div>
        <div class="hrp-user-role">Administrator</div>
      </div>
    </button>
  </div>
</header>
```

---

## Cards, Forms, and Grid
Use these helpers for consistent spacing and look.

- Card: `.hrp-card > .hrp-card-body`
- Grid: `.hrp-grid` with `.hrp-col-6`, `.hrp-col-12`
- Labels/Inputs:
  - `.hrp-label`
  - `.hrp-input`, `.hrp-select`, `.hrp-textarea`, `.hrp-file`
- Actions/Buttons: `.hrp-actions`, `.hrp-btn`, `.hrp-btn-primary`

```html
<div class="hrp-card">
  <div class="hrp-card-body">
    <div class="hrp-grid">
      <div class="hrp-col-6">
        <label class="hrp-label">First Name</label>
        <input class="hrp-input" type="text" />
      </div>
      <div class="hrp-col-6">
        <label class="hrp-label">Last Name</label>
        <input class="hrp-input" type="text" />
      </div>
      <div class="hrp-col-12">
        <label class="hrp-label">Notes</label>
        <textarea class="hrp-textarea"></textarea>
      </div>
    </div>
    <div class="hrp-actions">
      <button class="hrp-btn hrp-btn-primary">Save</button>
    </div>
  </div>
</div>
```

---

## Breadcrumb and Pagination (Sticky Inside Content)
- Breadcrumb: `.hrp-breadcrumb`
- Pagination: `.hrp-pagination`, `.hrp-page-btn`, `.hrp-page`, `.hrp-ellipsis`

```html
<div class="hrp-breadcrumb">
  <div class="crumb">Employees</div>
  <div class="hrp-pagination">
    <button class="hrp-page-btn">«</button>
    <div class="hrp-pages">
      <a class="hrp-page active" href="#">1</a>
      <span class="hrp-ellipsis">...</span>
      <a class="hrp-page" href="#">5</a>
    </div>
    <button class="hrp-page-btn">»</button>
  </div>
</div>
```

---

## Bottom Dock (Glass, Fixed)
- Wrapper: `.mac-dock-bottom`
- Items: `.dock-item > img` 44×44
- Divider: `.mac-dock-divider`

```html
<div class="mac-dock mac-dock-bottom">
  <a class="dock-item" href="#" title="HR">
    <img src="new_theme/images/nav_icon/hr.svg" alt="HR" />
  </a>
  <span class="mac-dock-divider" aria-hidden="true"></span>
  <!-- more items ... -->
</div>
```

---

## Responsive Notes
- Below 1024px: `.hrp-sidebar` is hidden, grid becomes 6 columns.
- Ensure critical actions are available without the sidebar on smaller screens.

---

## How to Replicate in a Second Project
1. **Copy CSS and assets**
   - Copy `public/new_theme/css/hrportal.css` and any referenced assets (icons, fonts like `visby-fonts.css`, images in `new_theme/images/nav_icon/`).
   - If you rely on Bootstrap/AdminLTE/etc., copy/include those as well (or adjust `hrportal.css` to your base stack).
2. **Create a base layout**
   - Reuse the HTML skeleton from “Layout Structure”.
   - Ensure the same class names (`.hrp-*` and `.mac-dock-*`).
3. **Wire partials** (optional but recommended)
   - Sidebar: create a partial with `.hrp-sidebar` structure.
   - Header: create a partial with `.hrp-header` and window dots.
4. **Include scripts**
   - Only include the JS libraries you actually use (datepicker, select2, editors, etc.).
5. **Test and adjust paths**
   - Verify image/font paths in your new project map to the correct locations.

---

## Minimal Includes Example
If you want the smallest setup without AdminLTE or extra plugins:

```html
<link rel="stylesheet" href="/path/to/bootstrap.min.css">
<link rel="stylesheet" href="/path/to/hrportal.css">
```

And at the end of the body (optional if you need components):

```html
<script src="/path/to/jquery.min.js"></script>
<script src="/path/to/bootstrap.min.js"></script>
```

---

## Reference
- Layout file: `resources/views/layouts/macos.blade.php`
- Theme stylesheet: `public/new_theme/css/hrportal.css`

This guide reflects the current styles and class names in `hrportal.css`. Update this document if you add new components or change the structure/classes.
