<?php $__env->startSection('content'); ?>
  <div class="hrp-card">
    <div class="Rectangle-30 hrp-compact">
      <div class="hrp-actions" style="justify-content: space-between; padding: 0 4px 10px;">
        <div class="hrp-label" style="margin:0">User Details</div>
        <div>
          

             <a href="<?php echo e(route('users.index')); ?>" class="pill-btn back-btn" title="Back to Users">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Back
      </a>
          
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-5">
        <div style="display:flex; align-items:center; gap:16px">
          <div class="profile-image" style="width:80px;height:80px;border-radius:50%;overflow:hidden;background:#f3f4f6;border:2px solid #e5e7eb; flex:0 0 80px; display:flex;align-items:center;justify-content:center; font-weight:800; color:#0f172a">
            <?php echo e(strtoupper(substr($user->name, 0, 2))); ?>

          </div>
          <div style="min-width:0">
            <div style="font-weight:800;font-size:18px;color:#1e293b;line-height:1.3"><?php echo e($user->name); ?></div>
            <div style="color:#64748b;font-weight:600;font-size:13px;word-break:break-all"><?php echo e($user->email); ?></div>
            <div style="margin-top:8px; display:flex; gap:6px; flex-wrap:wrap">
              <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span style="background:#f1f5f9;border:1px solid #e2e8f0;border-radius:8px;padding:6px 10px;font-size:12px;font-weight:700;color:#1e293b"><?php echo e(ucfirst($role->name)); ?></span>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
          <div>
            <label class="hrp-label">Mobile</label>
            <div class="hrp-input Rectangle-29" style="display:flex;align-items:center;min-height:44px"><?php echo e($user->mobile_no ?? 'N/A'); ?></div>
          </div>
          <div>
            <label class="hrp-label">Joined</label>
            <div class="hrp-input Rectangle-29" style="display:flex;align-items:center;min-height:44px"><?php echo e($user->created_at->format('d M Y, h:i A')); ?></div>
          </div>
          <div class="md:col-span-2">
            <label class="hrp-label">Address</label>
            <div class="hrp-textarea Rectangle-29 Rectangle-29-textarea" style="display:flex;align-items:center;min-height:58px"><?php echo e($user->address ?? 'N/A'); ?></div>
          </div>
        </div>
      </div>

      <div style="margin-top:16px">
        <div class="hrp-label" style="margin:0 0 8px 4px">Permissions</div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
          <?php $__empty_1 = true; $__currentLoopData = $user->getAllPermissions()->groupBy(function($permission) { return explode('.', $permission->name)[0]; }); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module => $permissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="hrp-card" style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:10px">
              <div style="font-weight:800;font-size:14px;margin-bottom:8px"><?php echo e(ucfirst($module)); ?></div>
              <div style="display:flex; gap:8px; flex-wrap:wrap">
                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <span style="background:#ecfdf5;color:#065f46;border:1px solid #d1fae5;border-radius:8px;padding:6px 10px;font-size:12px;font-weight:700"><?php echo e(explode('.', $permission->name)[1]); ?></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="hrp-input Rectangle-29" style="display:flex;align-items:center;min-height:44px">No permissions assigned</div>
          <?php endif; ?>
        </div>
      </div>

      
    </div>
  </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/users/show.blade.php ENDPATH**/ ?>