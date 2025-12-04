<?php if(session('success')): ?>
<script>
  document.addEventListener('DOMContentLoaded', function(){
    toastr.success(<?php echo json_encode(session('success'), 15, 512) ?>);
  });
</script>
<?php endif; ?>
<?php if(session('status')): ?>
<script>
  document.addEventListener('DOMContentLoaded', function(){
    toastr.success(<?php echo json_encode(session('status'), 15, 512) ?>);
  });
</script>
<?php endif; ?>
<?php if(session('error')): ?>
<script>
  document.addEventListener('DOMContentLoaded', function(){
    toastr.error(<?php echo json_encode(session('error'), 15, 512) ?>);
  });
</script>
<?php endif; ?>
<?php if($errors->any()): ?>
<script>
  document.addEventListener('DOMContentLoaded', function(){
    toastr.error('Please fix the highlighted errors.');
  });
</script>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/partials/flash.blade.php ENDPATH**/ ?>