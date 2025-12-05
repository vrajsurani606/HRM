<?php $__env->startSection('content'); ?>
  <div class="hrp-card">
    <div class="Rectangle-30 hrp-compact">
      <div class="hrp-actions" style="justify-content: space-between; padding: 0 4px 10px;">
        <div class="hrp-label" style="margin:0">Role Details: <?php echo e(ucfirst($role->name)); ?></div>
        <div>
<a href="<?php echo e(route('roles.index')); ?>" class="pill-btn back-btn" title="Back to Roles">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Back
      </a>          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('roles.create')): ?>
            <a class="hrp-btn hrp-btn-primary" href="<?php echo e(route('roles.create')); ?>" style="margin-left:6px">Create Role</a>
          <?php endif; ?>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-5">
        <div class="grid grid-cols-1 gap-3">
          <div>
            <label class="hrp-label">Role Name</label>
            <div class="hrp-input Rectangle-29" style="display:flex;align-items:center;min-height:44px">
              <span class="badge badge-primary"><?php echo e(ucfirst($role->name)); ?></span>
            </div>
          </div>
          <div>
            <label class="hrp-label">Description</label>
            <div class="hrp-textarea Rectangle-29 Rectangle-29-textarea" style="display:flex;align-items:center;min-height:58px"><?php echo e($role->description ?? 'No description'); ?></div>
          </div>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="hrp-label">Users</label>
              <div class="hrp-input Rectangle-29" style="display:flex;align-items:center;min-height:44px"><?php echo e($role->users->count()); ?></div>
            </div>
            <div>
              <label class="hrp-label">Permissions</label>
              <div class="hrp-input Rectangle-29" style="display:flex;align-items:center;min-height:44px"><?php echo e($role->permissions->count()); ?></div>
            </div>
          </div>
        </div>

        <div>
          <label class="hrp-label">Users with this role</label>
          <div class="hrp-card" style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:10px; max-height:260px; overflow:auto">
            <?php $__empty_1 = true; $__currentLoopData = $role->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px">
                <div style="width:30px;height:30px;border-radius:50%;background:#e5e7eb;display:flex;align-items:center;justify-content:center;font-weight:800;color:#0f172a;font-size:12px"><?php echo e(strtoupper(substr($user->name, 0, 2))); ?></div>
                <div style="min-width:0">
                  <div style="font-weight:800;font-size:13px;color:#1e293b;line-height:1.2"><?php echo e($user->name); ?></div>
                  <div style="color:#64748b;font-weight:600;font-size:12px;word-break:break-all"><?php echo e($user->email); ?></div>
                </div>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <div class="hrp-input Rectangle-29" style="display:flex;align-items:center;min-height:44px">No users assigned to this role</div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <div style="margin-top:16px">
        <div class="hrp-label" style="margin:0 0 8px 4px">Permissions</div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
          <?php $__empty_1 = true; $__currentLoopData = $role->permissions->groupBy(function($permission) { return explode('.', $permission->name)[0]; }); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module => $permissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="hrp-card" style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:10px">
              <div style="font-weight:800;font-size:14px;margin-bottom:8px"><?php echo e(ucfirst($module)); ?> (<?php echo e($permissions->count()); ?>)</div>
              <div style="display:flex; gap:8px; flex-wrap:wrap">
                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <span style="background:#f3f4f6;color:#111827;border:1px solid #e5e7eb;border-radius:8px;padding:6px 10px;font-size:12px;font-weight:700"><?php echo e(explode('.', $permission->name)[1]); ?></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="hrp-input Rectangle-29" style="display:flex;align-items:center;min-height:44px">No permissions assigned to this role</div>
          <?php endif; ?>
        </div>
      </div>

      <div class="hrp-actions" style="padding-top:12px">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('roles.edit')): ?>
          <a class="hrp-btn" href="<?php echo e(route('roles.edit', $role)); ?>">Edit Role</a>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('roles.delete')): ?>
          <?php if($role->users->count() == 0): ?>
            <form action="<?php echo e(route('roles.destroy', $role)); ?>" method="POST" style="display:inline-block; margin-left:8px" onsubmit="return confirm('Are you sure?')">
              <?php echo csrf_field(); ?>
              <?php echo method_field('DELETE'); ?>
              <button type="submit" class="hrp-btn" style="background:#fff;color:#ef4444;border:1px solid #f2d7d7">Delete Role</button>
            </form>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/roles/show.blade.php ENDPATH**/ ?>