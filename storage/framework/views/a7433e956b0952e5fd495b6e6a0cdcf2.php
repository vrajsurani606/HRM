<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['column', 'title']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['column', 'title']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $currentSort = request('sort');
    $currentDirection = request('direction', 'desc');
    $newDirection = ($currentSort == $column && $currentDirection == 'asc') ? 'desc' : 'asc';
    
    $queryParams = request()->query();
    $queryParams['sort'] = $column;
    $queryParams['direction'] = $newDirection;
    
    $url = request()->url() . '?' . http_build_query($queryParams);
?>

<a href="<?php echo e($url); ?>" 
   style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 4px;">
    <?php echo e($title); ?>

    <?php if($currentSort == $column): ?>
        <span style="font-size: 12px;"><?php echo e($currentDirection == 'asc' ? '↑' : '↓'); ?></span>
    <?php endif; ?>
</a><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/components/sortable-header.blade.php ENDPATH**/ ?>