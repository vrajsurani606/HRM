<?php $__env->startSection('page_title', $page_title); ?>

<?php $__env->startSection('content'); ?>
<div class="hrp-card">
  <div class="hrp-card-body">
    <form id="filterForm" method="GET" action="<?php echo e(route('hiring.index')); ?>" class="jv-filter">
      <input type="text" name="from_date" class="filter-pill date-picker" placeholder="From : dd/mm/yyyy" value="<?php echo e(request('from_date')); ?>" autocomplete="off">
      <input type="text" name="to_date" class="filter-pill date-picker" placeholder="To : dd/mm/yyyy" value="<?php echo e(request('to_date')); ?>" autocomplete="off">
      <select name="gender" class="filter-pill">
        <option value="" <?php echo e(!request('gender') ? 'selected' : ''); ?>>All Genders</option>
        <option value="male" <?php echo e(request('gender') == 'male' ? 'selected' : ''); ?>>Male</option>
        <option value="female" <?php echo e(request('gender') == 'female' ? 'selected' : ''); ?>>Female</option>
        <option value="other" <?php echo e(request('gender') == 'other' ? 'selected' : ''); ?>>Other</option>
      </select>
      <select name="experience" class="filter-pill">
        <option value="" <?php echo e(!request('experience') ? 'selected' : ''); ?>>All Experience</option>
        <option value="fresher" <?php echo e(request('experience') == 'fresher' ? 'selected' : ''); ?>>Fresher</option>
        <option value=">0" <?php echo e(request('experience') == '>0' ? 'selected' : ''); ?>>0+</option>
        <option value=">1" <?php echo e(request('experience') == '>1' ? 'selected' : ''); ?>>1+</option>
        <option value=">2" <?php echo e(request('experience') == '>2' ? 'selected' : ''); ?>>2+</option>
        <option value=">3" <?php echo e(request('experience') == '>3' ? 'selected' : ''); ?>>3+</option>
      </select>
      <button type="submit" class="filter-search" aria-label="Search">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
        </svg>
      </button>
      <div class="filter-right">
        <div class="view-toggle-group" style="margin-right:8px;">
          <button class="view-toggle-btn" data-view="grid" title="Grid View" aria-label="Grid View">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="3" width="7" height="7" rx="1"></rect>
              <rect x="14" y="3" width="7" height="7" rx="1"></rect>
              <rect x="3" y="14" width="7" height="7" rx="1"></rect>
              <rect x="14" y="14" width="7" height="7" rx="1"></rect>
            </svg>
          </button>
          <button class="view-toggle-btn active" data-view="list" title="List View" aria-label="List View">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="8" y1="6" x2="21" y2="6"></line>
              <line x1="8" y1="12" x2="21" y2="12"></line>
              <line x1="8" y1="18" x2="21" y2="18"></line>
              <line x1="3" y1="6" x2="3.01" y2="6"></line>
              <line x1="3" y1="12" x2="3.01" y2="12"></line>
              <line x1="3" y1="18" x2="3.01" y2="18"></line>
            </svg>
          </button>
        </div>
        <input type="text" name="search" class="filter-pill" placeholder="Search by name, mobile, code..." value="<?php echo e(request('search')); ?>">
        <a href="<?php echo e(route('hiring.index')); ?>" class="pill-btn pill-secondary">Reset</a>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Leads Management.create lead')): ?>
          <a href="<?php echo e(route('hiring.create')); ?>" class="pill-btn pill-success">+ Add</a>
        <?php endif; ?>
      </div>
    </form>
  </div>
  <!-- Grid View -->
  <div class="hiring-grid-view">
    <?php $__empty_1 = true; $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <?php ($initial = strtoupper(mb_substr((string)($lead->person_name ?? 'U'), 0, 1))); ?>
      <div class="hiring-grid-card" onclick="window.location.href='<?php echo e(route('hiring.edit', $lead)); ?>'" title="Edit lead">
        <div class="hiring-grid-header">
          <div class="hiring-grid-id">
            <div class="hiring-avatar"><?php echo e($initial); ?></div>
            <div class="hiring-name-role">
              <h3 class="hiring-grid-title"><?php echo e($lead->person_name); ?></h3>
              <div class="hiring-role"><?php echo e($lead->position ?? '-'); ?></div>
            </div>
          </div>
          <div class="hiring-chips">
            <span class="chip chip-<?php echo e($lead->is_experience ? 'exp' : 'fresh'); ?>"><?php echo e($lead->is_experience ? (($lead->experience_count ?? 0).' yrs') : 'Fresher'); ?></span>
            <span class="chip chip-gender"><?php echo e(ucfirst($lead->gender ?? '-')); ?></span>
          </div>
        </div>
        <p class="hiring-grid-sub">Code: <?php echo e($lead->unique_code); ?> • Mobile: <?php echo e($lead->mobile_no ?? '-'); ?></p>
        <div class="hiring-grid-meta">
          <div class="hiring-grid-left">
            <div class="meta-row"><span class="meta-label">Address</span><span class="meta-value"><?php echo e($lead->address ?? '-'); ?></span></div>
            <div class="meta-row"><span class="meta-label">Prev.</span><span class="meta-value"><?php echo e($lead->experience_previous_company ?? '-'); ?> <?php echo e($lead->previous_salary ? '• ₹'.$lead->previous_salary : ''); ?></span></div>
          </div>
          <div class="hiring-grid-actions" onclick="event.stopPropagation()">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Leads Management.edit lead')): ?>
              <a href="<?php echo e(route('hiring.edit', $lead)); ?>" class="hiring-grid-action-btn btn-edit" title="Edit" aria-label="Edit">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
              </a>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Leads Management.print lead')): ?>
              <a href="<?php echo e(route('hiring.print', ['id' => $lead->id, 'type' => 'offerletter'])); ?>" target="_blank" class="hiring-grid-action-btn btn-print" title="Print Offer Letter" aria-label="Print Offer Letter">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
              </a>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Leads Management.delete lead')): ?>
              <form method="POST" action="<?php echo e(route('hiring.destroy', $lead)); ?>" class="delete-form" style="display:inline">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button type="button" class="hiring-grid-action-btn btn-delete" onclick="confirmDeleteLead(this); event.stopPropagation();" title="Delete" aria-label="Delete">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                </button>
              </form>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Leads Management.convert lead')): ?>
              <a href="<?php echo e(route('hiring.convert', $lead->id)); ?>" class="hiring-grid-action-btn btn-convert" title="Convert to Employee" aria-label="Convert to Employee">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,11 12,14 15,11"></polyline><line x1="12" y1="2" x2="12" y2="14"></line></svg>
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div class="text-center py-3">No records found</div>
    <?php endif; ?>
  </div>

  <!-- List View -->
  <div class="hiring-list-view active">
    <div class="JV-datatble JV-datatble--zoom striped-surface striped-surface--full table-wrap pad-none">
      <table>
        <thead>
          <tr>
            <th>Action</th>
            <th>Serial No.</th>
            <th>Hiring Lead Code</th>
            <th>Person Name</th>
            <th>Mo. No.</th>
            <th>Address</th>
            <th>Position</th>
            <th>Is Exp.?</th>
            <th>Exp.</th>
            <th>Pre. Company</th>
            <th>Pre. Salary</th>
            <th>Gender</th>
            <th>Resume</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td>
              <div class="action-icons">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Leads Management.edit lead')): ?>
                  <a href="<?php echo e(route('hiring.edit', $lead)); ?>" title="Edit" aria-label="Edit">
                    <img src="<?php echo e(asset('action_icon/edit.svg')); ?>" alt="Edit" class="action-icon">
                  </a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Leads Management.print lead')): ?>
                  <a href="<?php echo e(route('hiring.print', ['id' => $lead->id, 'type' => 'offerletter'])); ?>" title="Print Offer Letter" target="_blank" aria-label="Print Offer Letter">
                    <img src="<?php echo e(asset('action_icon/print.svg')); ?>" alt="Print Offer Letter" class="action-icon">
                  </a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Leads Management.delete lead')): ?>
                  <form method="POST" action="<?php echo e(route('hiring.destroy', $lead)); ?>" class="delete-form" style="display:inline">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="button" onclick="confirmDeleteLead(this)" title="Delete" aria-label="Delete" style="background:transparent;border:0;padding:0;line-height:0;cursor:pointer">
                      <img src="<?php echo e(asset('action_icon/delete.svg')); ?>" alt="Delete" class="action-icon">
                    </button>
                  </form>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Leads Management.convert lead')): ?>
                  <a href="<?php echo e(route('hiring.convert', $lead->id)); ?>"
                        class="convert-btn"
                        data-id="<?php echo e($lead->id); ?>"
                        data-url="<?php echo e(route('hiring.convert', $lead->id)); ?>"
                        data-name="<?php echo e($lead->person_name); ?>"
                        title="Convert to Employee">
                          <img src="<?php echo e(asset('action_icon/convert.svg')); ?>" class="action-icon">
                    </a>
                <?php endif; ?>
              </div>
            </td>
            <td>
              <?php ($sno = ($leads->currentPage()-1) * $leads->perPage() + $i + 1); ?>
              <?php echo e($sno); ?>

            </td>
            <td><?php echo e($lead->unique_code); ?></td>
            <td><?php echo e($lead->person_name); ?></td>
            <td><?php echo e($lead->mobile_no); ?></td>
            <td><?php echo e($lead->address); ?></td>
            <td><?php echo e($lead->position); ?></td>
            <td>
              <?php if($lead->is_experience): ?>
              <span style="display:inline-flex;align-items:center;gap:6px;background:#e8f7ef;color:#0ea05d;font-weight:800;font-size:12px;padding:6px 10px;border-radius:9999px;">
                <span style="width:8px;height:8px;border-radius:9999px;background:#0ea05d;display:inline-block"></span> Yes
              </span>
              <?php else: ?>
              <span style="display:inline-flex;align-items:center;gap:6px;background:#f3f4f6;color:#6b7280;font-weight:800;font-size:12px;padding:6px 10px;border-radius:9999px;">
                <span style="width:8px;height:8px;border-radius:9999px;background:#9ca3af;display:inline-block"></span> No
              </span>
              <?php endif; ?>
            </td>
            <td><?php echo e($lead->experience_count); ?></td>
            <td><?php echo e($lead->experience_previous_company); ?></td>
            <td><?php echo e($lead->previous_salary); ?></td>
            <td class="capitalize"><?php echo e($lead->gender); ?></td>
            <td>
              <?php if($lead->resume_path): ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Leads Management.view resume')): ?>
                  <a class="hrp-link" href="<?php echo e(route('hiring.resume', $lead->id)); ?>" target="_blank">View</a>
                <?php else: ?>
                  <span style="color:#9ca3af;">—</span>
                <?php endif; ?>
              <?php else: ?>
                —
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="13" class="text-center py-8">No records found</td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // SweetAlert delete confirmation for hiring leads
  function confirmDeleteLead(button) {
    Swal.fire({
      title: 'Delete this lead?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#ef4444',
      cancelButtonColor: '#6b7280',
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'Cancel',
      width: '400px', 
      padding: '1.5rem',
      customClass: {
        popup: 'perfect-swal-popup'
      }
    }).then((result) => {
      if (result.isConfirmed) {
        button.closest('form').submit();
      }
    });
  }

document.addEventListener('DOMContentLoaded', function() {
    const csrf = '<?php echo e(csrf_token()); ?>';

    document.querySelectorAll('.convert-btn').forEach(function(btn) {

        btn.addEventListener('click', function(e) {
            e.preventDefault();

            const leadId = this.dataset.id;
            const name = this.dataset.name || 'this lead';
            const routeUrl = this.dataset.url; // <-- Laravel route('hiring.convert', id)

            // Load form data (GET request)
            fetch(routeUrl, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {

                Swal.fire({
                    title: `Convert ${name} to Employee`,
                    html: `
                        <div style="text-align: left; margin: 20px 0;">
                            <label class="hrp-label">Email:</label>
                            <input type="email" id="convert-email" class="hrp-input Rectangle-29"
                                   value="${data.suggested_email || ''}"
                                   placeholder="Enter email" style="margin-bottom: 15px; color: #000;">

                            <label class="hrp-label">Password:</label>
                            <div class="password-wrapper">
                                <input type="password" id="convert-password" class="hrp-input Rectangle-29"
                                       placeholder="Enter password" style="color: #000;">
                            </div>
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Convert & Create Login',
                    cancelButtonText: 'Cancel',
                    width: '450px',
                    customClass: { popup: 'perfect-swal-popup' },
                    preConfirm: () => {
                        const email = document.getElementById('convert-email').value.trim();
                        const password = document.getElementById('convert-password').value.trim();

                        if (!email || !password) {
                            Swal.showValidationMessage('Please fill all fields');
                            return false;
                        }

                        if (password.length < 6) {
                            Swal.showValidationMessage('Password must be at least 6 characters');
                            return false;
                        }

                        return { email, password };
                    }
                })
                .then(result => {
                    if (!result.isConfirmed) return;

                    // Submit conversion (POST request)
                    const formData = new FormData();
                    formData.append('email', result.value.email);
                    formData.append('password', result.value.password);
                    formData.append('_token', csrf);
                    
                    fetch(routeUrl, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(res => {
                        if (!res.ok) {
                            return res.text().then(text => {
                                throw new Error(`HTTP ${res.status}: ${text}`);
                            });
                        }
                        return res.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Success!', data.message, 'success')
                                .then(() => location.reload());
                        } else {
                            Swal.fire('Error!', data.message || 'Conversion failed', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Conversion error:', error);
                        Swal.fire('Error!', error.message || 'Something went wrong', 'error');
                    });
                });

            })
            .catch(() => {
                Swal.fire('Error!', 'Failed to load conversion form', 'error');
            });
        });

    });
});

// Toggle view
document.addEventListener('DOMContentLoaded', function() {
  const viewToggleBtns = document.querySelectorAll('.view-toggle-btn');
  const hiringGridView = document.querySelector('.hiring-grid-view');
  const hiringListView = document.querySelector('.hiring-list-view');

  viewToggleBtns.forEach((btn) => {
    btn.addEventListener('click', function() {
      const view = this.dataset.view;
      localStorage.setItem('hiringLeadView', view);

      if (view === 'grid') {
        hiringGridView.classList.add('active');
        hiringListView.classList.remove('active');
        this.classList.add('active');
        document.querySelector('.view-toggle-btn[data-view="list"]').classList.remove('active');
      } else {
        hiringGridView.classList.remove('active');
        hiringListView.classList.add('active');
        this.classList.add('active');
        document.querySelector('.view-toggle-btn[data-view="grid"]').classList.remove('active');
      }
    });
  });

  const storedView = localStorage.getItem('hiringLeadView');
  if (storedView === 'grid') {
    hiringGridView.classList.add('active');
    hiringListView.classList.remove('active');
    document.querySelector('.view-toggle-btn[data-view="grid"]').classList.add('active');
  } else {
    hiringGridView.classList.remove('active');
    hiringListView.classList.add('active');
    document.querySelector('.view-toggle-btn[data-view="list"]').classList.add('active');
  }
});
</script>

<?php $__env->startPush('styles'); ?>
<style>
  /* Toggle */
  .view-toggle-group { display:flex; gap:4px; background:#f3f4f6; padding:4px; border-radius:8px; }
  .view-toggle-btn { padding:8px 12px; background:transparent; border:none; border-radius:6px; cursor:pointer; transition:all .2s; display:flex; align-items:center; justify-content:center; }
  .view-toggle-btn:hover { background:#e5e7eb; }
  .view-toggle-btn.active { background:#fff; box-shadow:0 1px 3px rgba(0,0,0,0.1); }
  .view-toggle-btn svg { color:#6b7280; }
  .view-toggle-btn.active svg { color:#3b82f6; }

  /* Grid */
  .hiring-grid-view { display:none; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap:16px; padding:12px; }
  .hiring-grid-view.active { display:grid; }
  .hiring-list-view { display:none; }
  .hiring-list-view.active { display:block; }

  .hiring-grid-card { background:#fff; border-radius:12px; padding:16px 18px; box-shadow:0 1px 6px rgba(0,0,0,0.06); transition:transform .25s, box-shadow .25s; cursor:pointer; margin-top:4px; }
  .hiring-grid-card:hover { transform: translateY(-4px); box-shadow:0 4px 16px rgba(0,0,0,0.12); }
  .hiring-grid-header { display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:10px; }
  .hiring-grid-id { display:flex; align-items:center; gap:12px; min-width:0; }
  .hiring-avatar { width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-weight:700; color:#fff; background:linear-gradient(135deg,#3b82f6,#9333ea); }
  .hiring-name-role { min-width:0; }
  .hiring-grid-title { font-size:16px; font-weight:700; color:#0f172a; margin:0; line-height:1.2; max-width:260px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
  .hiring-role { font-size:12px; color:#6b7280; }
  .hiring-chips { display:flex; gap:6px; flex-wrap:wrap; justify-content:flex-end; }
  .chip { font-size:11px; padding:4px 8px; border-radius:9999px; font-weight:600; border:1px solid #e5e7eb; background:#fff; color:#374151; }
  .chip-exp { background:#dcfce7; border-color:#bbf7d0; color:#166534; }
  .chip-fresh { background:#f3f4f6; border-color:#e5e7eb; color:#374151; }
  .chip-gender { background:#e0e7ff; border-color:#c7d2fe; color:#3730a3; }
  .hiring-grid-sub { font-size:12px; color:#6b7280; margin:0 0 12px; }
  .hiring-grid-meta { display:flex; justify-content:space-between; align-items:flex-start; gap:12px; padding-top:12px; border-top:1px solid #f3f4f6; }
  .hiring-grid-left { flex:1; display:flex; flex-direction:column; gap:6px; }
  .meta-row { display:flex; gap:8px; align-items:center; }
  .meta-label { font-size:12px; color:#6b7280; min-width:56px; }
  .meta-value { font-size:13px; color:#111827; }
  .hiring-grid-actions { display:flex; gap:8px; }
  .hiring-grid-action-btn { padding:8px; border:1px solid #e5e7eb; background:#fff; border-radius:6px; cursor:pointer; transition:all .2s; display:flex; align-items:center; justify-content:center; width:32px; height:32px; }
  .hiring-grid-action-btn.btn-edit { border-color:#f59e0b; background:#fffbeb; }
  .hiring-grid-action-btn.btn-edit svg { color:#f59e0b; }
  .hiring-grid-action-btn.btn-edit:hover { background:#f59e0b; }
  .hiring-grid-action-btn.btn-edit:hover svg { color:#fff; }
  .hiring-grid-action-btn.btn-print { border-color:#6366f1; background:#eef2ff; }
  .hiring-grid-action-btn.btn-print svg { color:#6366f1; }
  .hiring-grid-action-btn.btn-print:hover { background:#6366f1; }
  .hiring-grid-action-btn.btn-print:hover svg { color:#fff; }
  .hiring-grid-action-btn.btn-delete { border-color:#ef4444; background:#fef2f2; }
  .hiring-grid-action-btn.btn-delete svg { color:#ef4444; }
  .hiring-grid-action-btn.btn-delete:hover { background:#ef4444; }
  .hiring-grid-action-btn.btn-delete:hover svg { color:#fff; }
  .hiring-grid-action-btn.btn-convert { border-color:#10b981; background:#ecfdf5; }
  .hiring-grid-action-btn.btn-convert svg { color:#10b981; }
  .hiring-grid-action-btn.btn-convert:hover { background:#10b981; }
  .hiring-grid-action-btn.btn-convert:hover svg { color:#fff; }

  /* Fix orphaned CSS line and ensure swal styles remain intact */
  /* List table alignments */
  .JV-datatble table td { vertical-align: middle; }
  .action-icons { display: inline-flex; align-items: center; gap: 8px; }
  .action-icons form { margin: 0; padding: 0; display: inline-flex; }
  .action-icons button { display: inline-flex; align-items: center; justify-content: center; padding: 0; margin: 0; line-height: 1; background: transparent; border: 0; cursor: pointer; }
  .action-icons img.action-icon { display: block; }
  .perfect-swal-popup { font-size: 15px !important; }
  .perfect-swal-popup .swal2-title { font-size: 20px !important; font-weight: 600 !important; margin-bottom: 1rem !important; }
  .perfect-swal-popup .swal2-content { font-size: 15px !important; margin-bottom: 1.5rem !important; line-height: 1.4 !important; }
  .perfect-swal-popup .swal2-actions { gap: 0.75rem !important; margin-top: 1rem !important; }
  .perfect-swal-popup .swal2-confirm, .perfect-swal-popup .swal2-cancel { font-size: 14px !important; padding: 8px 16px !important; border-radius: 6px !important; }
  .perfect-swal-popup .swal2-icon { margin: 0.5rem auto 1rem !important; }
  .perfect-swal-popup .hrp-label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
    color: #000 !important;
  }

  .perfect-swal-popup .Rectangle-29 {
    width: 100% !important;
    padding: 12px 16px !important;
    border: 1px solid #d1d5db !important;
    border-radius: 8px !important;
    font-size: 14px !important;
    color: #000 !important;
    background: #fff !important;
    margin: 0 !important;
  }

  .perfect-swal-popup .Rectangle-29:focus {
    outline: none !important;
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
  }

  .perfect-swal-popup .Rectangle-29::placeholder {
    color: #6b7280 !important;
  }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<a class="hrp-bc-home" href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
<span class="hrp-bc-sep">›</span>
<a href="<?php echo e(route('hiring.index')); ?>" style="font-weight:800;color:#0f0f0f;text-decoration:none">HRM</a>
<span class="hrp-bc-sep">›</span>
<span class="hrp-bc-current">Hiring Lead Master</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_pagination'); ?>
<?php if(isset($leads) && method_exists($leads,'links')): ?>
<form method="GET" class="hrp-entries-form">
  <span>Entries</span>
  <?php ($currentPerPage = (int) request()->get('per_page', 10)); ?>
  <select name="per_page" onchange="this.form.submit()">
    <?php $__currentLoopData = [10,25,50,100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <option value="<?php echo e($size); ?>" <?php echo e($currentPerPage === $size ? 'selected' : ''); ?>><?php echo e($size); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </select>
  <?php $__currentLoopData = request()->except(['per_page','page']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <input type="hidden" name="<?php echo e($k); ?>" value="<?php echo e($v); ?>">
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</form>
<?php echo e($leads->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.jv')); ?>

<?php endif; ?>
<?php $__env->stopSection(); ?>@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
// Initialize jQuery datepicker
$(document).ready(function() {
    $('.date-picker').datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        yearRange: '-10:+10',
        showButtonPanel: true,
        beforeShow: function(input, inst) {
            setTimeout(function() {
                inst.dpDiv.css({ marginTop: '2px', marginLeft: '0px' });
            }, 0);
        }
    });
});

// Convert dates before form submission
document.addEventListener('DOMContentLoaded', function() {
    var form = document.querySelector('.jv-filter, #filterForm');
    if(form){
        form.addEventListener('submit', function(e){
            var dateInputs = form.querySelectorAll('.date-picker');
            dateInputs.forEach(function(input){
                if(input.value){
                    var parts = input.value.split('/');
                    if(parts.length === 3) input.value = parts[2] + '-' + parts[1] + '-' + parts[0];
                }
            });
        });
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/hr/hiring/index.blade.php ENDPATH**/ ?>