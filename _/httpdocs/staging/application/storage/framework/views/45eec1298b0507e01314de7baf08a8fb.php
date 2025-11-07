<?php
    $creatives = getContent('creative_resource.content', true);
    $elements = getContent('creative_resource.element');
?>
<!--========================== Creative Resource Start ==========================-->
<section class="cr-section">
    <div class="container">
        <div class="cr-main">
            <!-- Coluna esquerda - ConteÃºdo -->
            <div class="cr-left-column">
                <div class="cr-header">
                    <h2 class="cr-title"><?php echo e(__($creatives->data_values->heading)); ?></h2>
                    <p class="cr-subtitle"><?php echo e(__($creatives->data_values->subheading)); ?></p>
                </div>

                <div class="cr-features">
                    <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="cr-feature">
                            <h4 class="cr-feature__title">
                                <?php $icon = $item->data_values->icon ?? null; ?>
                                <?php if(!empty($icon)): ?>
                                    <span class="cr-feature__icon"><i class="<?php echo e($icon); ?>" aria-hidden="true"></i></span>
                                <?php endif; ?>
                                <?php echo e(__($item->data_values->title ?? '')); ?>

                            </h4>
                            <p class="cr-feature__description"><?php echo __($item->data_values->description ?? ''); ?></p>
                            <?php if(!$loop->last): ?>
                                <div class="cr-feature__divider"></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Coluna direita - Imagem estÃ¡tica -->
            <div class="cr-right-column">
                <div class="cr-panel">
                    <img class="cr-static-visual" src="<?php echo e(getImage(getFilePath('creative') . '/' . ($creatives->data_values->image ?? ''))); ?>" alt="<?php echo e(__($creatives->data_values->heading ?? 'Creative Resource')); ?>">
                </div>
            </div>
        </div>
    </div>
</section>
<!--========================== Creative Resource End ==========================-->


<?php /**PATH C:\Users\victo\Desktop\pedro\condoImage\_\httpdocs\staging\application\resources\views/presets/default/sections/creative_resource.blade.php ENDPATH**/ ?>