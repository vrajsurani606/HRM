<?php if($paginator->hasPages()): ?>
    <ul class="pagination" role="navigation">
        
        <?php if($paginator->onFirstPage()): ?>
            <li class="page-first disabled" aria-disabled="true" aria-label="««">
                <span aria-hidden="true">««</span>
            </li>
        <?php else: ?>
            <li class="page-first">
                <a href="<?php echo e($paginator->url(1)); ?>" rel="first" aria-label="««">««</a>
            </li>
        <?php endif; ?>

        
        <?php if($paginator->onFirstPage()): ?>
            <li class="page-prev disabled" aria-disabled="true" aria-label="«">
                <span aria-hidden="true">«</span>
            </li>
        <?php else: ?>
            <li class="page-prev">
                <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" aria-label="«">«</a>
            </li>
        <?php endif; ?>

        
        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
            <?php if(is_string($element)): ?>
                <li class="disabled" aria-disabled="true"><span>…</span></li>
            <?php endif; ?>

            
            <?php if(is_array($element)): ?>
                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php ($label = str_pad($page, 2, '0', STR_PAD_LEFT)); ?>
                    <?php if($page == $paginator->currentPage()): ?>
                        <li class="active" aria-current="page"><span class="jv-gradient"><?php echo e($label); ?></span></li>
                    <?php else: ?>
                        <li><a href="<?php echo e($url); ?>"><?php echo e($label); ?></a></li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <?php if($paginator->hasMorePages()): ?>
            <li class="page-next">
                <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" aria-label="»">»</a>
            </li>
        <?php else: ?>
            <li class="page-next disabled" aria-disabled="true" aria-label="»">
                <span aria-hidden="true">»</span>
            </li>
        <?php endif; ?>

        
        <?php ($lastPage = $paginator->lastPage()); ?>
        <?php if($paginator->currentPage() == $lastPage): ?>
            <li class="page-last disabled" aria-disabled="true" aria-label="»»">
                <span aria-hidden="true">»»</span>
            </li>
        <?php else: ?>
            <li class="page-last">
                <a href="<?php echo e($paginator->url($lastPage)); ?>" rel="last" aria-label="»»">»»</a>
            </li>
        <?php endif; ?>
    </ul>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/vendor/pagination/jv.blade.php ENDPATH**/ ?>