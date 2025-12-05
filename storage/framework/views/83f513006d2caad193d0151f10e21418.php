  <?php
  $isDashboard = \Route::currentRouteName() === 'dashboard';
  $pageTitle = trim(View::yieldContent('page_title', ''));
?>

<div class="hrp-breadcrumb">
  <div class="crumb">
    <?php if (! empty(trim($__env->yieldContent('breadcrumb')))): ?>
      <?php echo $__env->yieldContent('breadcrumb'); ?>
    <?php else: ?>
      <span class="hrp-bc-ico">
        <img src="<?php echo e(asset('side_icon/Vector.svg')); ?>" alt="Dashboard" onerror="this.onerror=null;this.src='<?php echo e(asset('side_icon/dashboard.svg')); ?>';"/>
      </span>
      <a class="hrp-bc-home" href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
      <?php if(!$isDashboard && $pageTitle): ?>
        <span class="hrp-bc-sep">›</span>
        <span class="hrp-bc-current"><?php echo e($pageTitle); ?></span>
      <?php endif; ?>
    <?php endif; ?>
  </div>
  <?php if (! empty(trim($__env->yieldContent('footer_pagination')))): ?>
    <div class="hrp-pagination"><?php echo $__env->yieldContent('footer_pagination'); ?></div>
  <?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/partials/footer.blade.php ENDPATH**/ ?>