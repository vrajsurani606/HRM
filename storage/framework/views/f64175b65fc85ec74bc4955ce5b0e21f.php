<?php $__env->startSection('page_title', 'Roles Management'); ?>

<?php $__env->startSection('content'); ?>
  <div class="hrp-card">
    <div class="hrp-card-body">
      <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
        <div class="jv-filter">
          <div class="filter-right">
            <form method="GET" action="<?php echo e(route('roles.index')); ?>" class="filter-row">
              <input type="text" name="q" value="<?php echo e($q ?? ''); ?>" placeholder="Search roles..." class="filter-pill">
              <button type="submit" class="filter-search" aria-label="Search">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                  <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2" />
                  <path d="m21 21-4.35-4.35" stroke="currentColor" stroke-width="2" />
                </svg>
              </button>
              <a href="<?php echo e(route('roles.index')); ?>" class="pill-btn pill-secondary">Reset</a>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Roles Management.create role')): ?>
                <a href="<?php echo e(route('roles.create')); ?>" class="pill-btn pill-success">+ Add</a>
              <?php endif; ?>
            </form>
          </div>
        </div>
        <table>
          <thead>
            <tr>
              <th>Actions</th>
              <th>ID</th>
              <th>Role Name</th>
              <th>Description</th>
              <th>Permissions</th>
              <th>Users</th>
            </tr>
          </thead>
          <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td>
                <div class="action-icons">
                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Roles Management.view role')): ?>
                    <a href="<?php echo e(route('roles.show', $role)); ?>" class="action-icon" title="View"><img src="<?php echo e(asset('action_icon/view.svg')); ?>" alt="view" width="16" height="16"></a>
                  <?php endif; ?>
                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Roles Management.edit role')): ?>
                    <a href="<?php echo e(route('roles.edit', $role)); ?>" class="action-icon" title="Edit"><img src="<?php echo e(asset('action_icon/edit.svg')); ?>" alt="edit" width="16" height="16"></a>
                  <?php endif; ?>
                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Roles Management.delete role')): ?>
                    <?php if($role->users->count() == 0): ?>
                      <form action="<?php echo e(route('roles.destroy', $role)); ?>" method="POST" onsubmit="return confirm('Are you sure?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="action-icon" title="Delete"><img src="<?php echo e(asset('action_icon/delete.svg')); ?>" alt="delete" width="16" height="16"></button>
                      </form>
                    <?php endif; ?>
                  <?php endif; ?>
                </div>
              </td>
              <td><?php echo e($role->id); ?></td>
              <td><?php echo e(ucfirst($role->name)); ?></td>
              <td><?php echo e($role->description ?? 'No description'); ?></td>
              <td><?php echo e($role->permissions->count()); ?></td>
              <td><?php echo e($role->users->count()); ?></td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="6">No roles found</td>
            </tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>

      <div class="pagination-wrapper">
        <?php echo e($roles->links()); ?>

      </div>
  </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/roles/index.blade.php ENDPATH**/ ?>