<?php $__env->startSection('page_title', 'User Management'); ?>

<?php $__env->startSection('content'); ?>
  <div class="employee-container">
    <div class="hrp-actions" style="justify-content: flex-end; padding: 0 4px 8px;">
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Users Management.create user')): ?>
        <a class="hrp-btn hrp-btn-primary" href="<?php echo e(route('users.create')); ?>">Create User</a>
      <?php endif; ?>
    </div>
    <div class="employee-grid">
      <?php
        $staticImages = [
          'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face',
          'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop&crop=face',
          'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop&crop=face',
          'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop&crop=face',
          'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&h=100&fit=crop&crop=face',
          'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop&crop=face'
        ];
      ?>

      <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="emp-card">
          <div class="card-header">
            <?php ($badgeText = optional($user->roles->first())->name ?? 'User'); ?>
            <span class="emp-badge"><?php echo e(ucfirst($badgeText)); ?></span>
            <div class="dropdown">
              <button class="dropdown-toggle" onclick="toggleDropdown(<?php echo e($loop->index); ?>)" title="More options">⋮</button>
              <div id="dropdown-<?php echo e($loop->index); ?>" class="dropdown-menu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Users Management.edit user')): ?>
                  <a href="<?php echo e(route('users.edit', $user)); ?>">
                    <img src="<?php echo e(asset('action_icon/edit.svg')); ?>" width="16" height="16"> Edit
                  </a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Users Management.delete user')): ?>
                  <form method="POST" action="<?php echo e(route('users.destroy', $user)); ?>" class="delete-form">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="button" class="delete-btn" onclick="confirmDelete(this)">
                      <img src="<?php echo e(asset('action_icon/delete.svg')); ?>" width="16" height="16"> Delete
                    </button>
                  </form>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Users Management.view user')): ?>
                  <a href="<?php echo e(route('users.show', $user)); ?>">
                    <img src="<?php echo e(asset('action_icon/view.svg')); ?>" width="16" height="16"> View
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <div class="section-separator"></div>

          <div class="profile-section">
            <div class="profile-image">
              <?php ($imageIndex = $loop->index % count($staticImages)); ?>
              <img src="<?php echo e($staticImages[$imageIndex]); ?>" alt="<?php echo e($user->name); ?>">
            </div>
            <div class="profile-info">
              <h3 class="profile-name"><?php echo e($user->name); ?></h3>
              <p class="profile-email"><?php echo e($user->email); ?></p>
            </div>
          </div>

          <div class="role-section">
            <div class="role-badge">
              <div class="role-dot"></div>
              <span class="role-title"><?php echo e(optional($user->roles->first())->name ? ucfirst(optional($user->roles->first())->name) : 'User'); ?></span>
            </div>
            <?php if($user->roles && $user->roles->count() > 1): ?>
              <span class="role-description">+<?php echo e($user->roles->count() - 1); ?> more</span>
            <?php else: ?>
              <span class="role-description">Application User</span>
            <?php endif; ?>
          </div>

          <div class="bottom-info">
            <div class="info-labels">
              <div>Mobile</div>
              <div>Joined</div>
            </div>
            <div class="info-values">
              <div><?php echo e($user->mobile_no ?? 'N/A'); ?></div>
              <div><?php echo e(optional($user->created_at)->format('d M, Y')); ?></div>
            </div>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="empty-state">No users found</div>
      <?php endif; ?>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_pagination'); ?>
  <?php if($users->hasPages()): ?>
    <?php echo e($users->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.jv')); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/employee-grid.css')); ?>">
<style>
  .large-swal-popup {
    font-size: 15px !important;
  }
  
  .large-swal-popup .swal2-title {
    font-size: 20px !important;
    font-weight: 600 !important;
    margin-bottom: 1rem !important;
  }
  
  .large-swal-popup .swal2-content {
    font-size: 15px !important;
    margin-bottom: 1.5rem !important;
    line-height: 1.4 !important;
  }
  
  .large-swal-popup .swal2-actions {
    gap: 0.75rem !important;
    margin-top: 1rem !important;
  }
  
  .large-swal-popup .swal2-actions .swal2-styled {
    font-size: 14px !important;
    padding: 8px 16px !important;
    border-radius: 6px !important;
  }
  
  .large-swal-popup .swal2-icon {
    margin: 0.5rem auto 1rem !important;
  }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function toggleDropdown(index) {
  document.querySelectorAll('.dropdown-menu').forEach(menu => {
    if (menu.id !== `dropdown-${index}`) menu.style.display = 'none';
  });
  const dropdown = document.getElementById(`dropdown-${index}`);
  if(dropdown){ dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none'; }
}
document.addEventListener('click', function(event) {
  if (!event.target.closest('.dropdown')) {
    document.querySelectorAll('.dropdown-menu').forEach(menu => { menu.style.display = 'none'; });
  }
});
function confirmDelete(button) {
  Swal.fire({
    title: 'Delete this user?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#ef4444',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'Cancel',
    width: '400px',
    padding: '1.5rem',
    customClass: { popup: 'large-swal-popup' }
  }).then((result) => {
    if (result.isConfirmed) {
      button.closest('form').submit();
    }
  });
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/users/index.blade.php ENDPATH**/ ?>