<?php
    $work_process = getContent('work_process.content', true);
    $elements = getContent('work_process.element');
?>

<!-- ==================== How It Works Start ==================== -->
<section class="how-it-work">
    <div class="container">
        <div class="how-it-work__header">
            <h2 class="how-it-work__title"><?php echo e(__($work_process->data_values->heading ?? "How it works")); ?></h2>
            <p class="how-it-work__subtitle"><?php echo e(__($work_process->data_values->subheading ?? "Simplicity meets precision. Explore, select, and download the visuals you need — all in a seamless flow designed for professionals.")); ?></p>
        </div>
        <div class="how-it-work__grid">
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    // Map icons based on loop iteration
                    $iconMapping = [
                        1 => 'building.svg',
                        2 => 'image.svg',
                        3 => 'image_download.svg'
                    ];
                    $iconFile = $iconMapping[$loop->iteration] ?? 'building.svg';
                ?>
                <div class="how-it-work__card">
                    <div class="how-it-work__icon">
                        <img src="<?php echo e(asset('application/assets/images/svg/' . $iconFile)); ?>"
                            alt="<?php echo e(__($item->data_values->title)); ?>">
                    </div>
                    <h5 class="how-it-work__card-title"><?php echo e(__($item->data_values->title)); ?></h5>
                    <p class="how-it-work__card-description"><?php echo __($item->data_values->description) ?></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<!-- ==================== How It Works End ==================== -->
<?php /**PATH C:\Users\victo\Desktop\pedro\condoImage\_\httpdocs\staging\application\resources\views/presets/default/sections/work_process.blade.php ENDPATH**/ ?>