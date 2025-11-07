<div class="row">
    <div class="col">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::routeIs('admin.building.index') ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.building.index')); ?>"><?php echo app('translator')->get('All'); ?>
                    <?php if($allBuildings): ?>
                    <span class="badge rounded-pill bg--white text-muted"><?php echo e($allBuildings); ?></span>
                    <?php endif; ?>
                </a>
            </li>
          
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::routeIs('admin.building.pending') ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.building.pending')); ?>"><?php echo app('translator')->get('Pending'); ?>
                    <?php if($pendingBuildings): ?>
                    <span class="badge rounded-pill bg--white text-muted"><?php echo e($pendingBuildings); ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::routeIs('admin.building.active') ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.building.active')); ?>"><?php echo app('translator')->get('Active'); ?>
                    <?php if($activeBuildings): ?>
                    <span class="badge rounded-pill bg--white text-muted"><?php echo e($activeBuildings); ?></span>
                    <?php endif; ?>
                </a>
            </li>
        </ul>
    </div>
</div><?php /**PATH C:\Users\victo\Desktop\pedro\condoImage\_\httpdocs\staging\application\resources\views/admin/components/tabs/building.blade.php ENDPATH**/ ?>