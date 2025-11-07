<div class="row">
    <div class="col">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::routeIs('admin.listing.asset.index') ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.listing.asset.index')); ?>"><?php echo app('translator')->get('All'); ?>
                    <?php if($allListing): ?>
                    <span class="badge rounded-pill bg--white text-muted"><?php echo e($allListing); ?></span>
                    <?php endif; ?>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::routeIs('admin.listing.asset.pending') ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.listing.asset.pending')); ?>"><?php echo app('translator')->get('Pending'); ?>
                    <?php if($pendingListingImages): ?>
                    <span class="badge rounded-pill bg--white text-muted"><?php echo e($pendingListingImages); ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::routeIs('admin.listing.asset.active') ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.listing.asset.active')); ?>"><?php echo app('translator')->get('Active'); ?>
                    <?php if($activeListingImages): ?>
                    <span class="badge rounded-pill bg--white text-muted"><?php echo e($activeListingImages); ?></span>
                    <?php endif; ?>
                </a>
            </li>
        </ul>
    </div>
</div><?php /**PATH C:\Users\victo\Desktop\pedro\condoImage\_\httpdocs\staging\application\resources\views/admin/components/tabs/listing_image.blade.php ENDPATH**/ ?>