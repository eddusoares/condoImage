
<?php if(false): ?>
    <div class="container my-4">
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb">
                <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($loop->last): ?>
                        <li class="breadcrumb-item active"><?php echo e($crumb['title']); ?></li>
                    <?php else: ?>
                        <li class="breadcrumb-item"><a href="<?php echo e($crumb['url']); ?>"><?php echo e($crumb['title']); ?></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ol>
        </nav>
    </div>
<?php endif; ?>
<?php /**PATH C:\Users\victo\Desktop\pedro\condoImage\_\httpdocs\staging\application\resources\views/presets/default/partials/breadcrumb.blade.php ENDPATH**/ ?>