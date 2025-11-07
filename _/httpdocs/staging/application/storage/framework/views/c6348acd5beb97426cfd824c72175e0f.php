
<?php $__env->startSection('panel'); ?>
    <?php echo $__env->make('admin.components.tabs.listing_image', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row gy-4">
        <div class="col-xxl-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('SI'); ?></th>
                                    <th><?php echo app('translator')->get('Author'); ?></th>
                                    <th><?php echo app('translator')->get('Image'); ?></th>
                                    <th><?php echo app('translator')->get('Building Name'); ?></th>
                                    <th><?php echo app('translator')->get('Unit Number'); ?></th>
                                    <th><?php echo app('translator')->get('Price'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $listingUnits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            #<?php echo e($loop->iteration); ?>

                                        </td>
                                        <td>
                                            <?php
                                                echo $item->author();
                                            ?>
                                        </td>
                                        <td>
                                            <img class="custom-rounded"
                                                src="<?php echo e(getImage(getFilePath('listing_asset_image') . '/' . $item->image)); ?>"
                                                alt="Listing Unit Image" width="70">
                                        </td>

                                        <td>
                                            <span class="fw-bold">
                                                <?php echo e($item->building->name); ?>

                                            </span>
                                        </td>

                                        <td>
                                            <span class="fw-bold">
                                                <?php echo e($item->unit_number); ?>

                                            </span>
                                        </td>

                                        <td>
                                            <span class="fw-bold">
                                                <?php echo e($general->cur_sym); ?><?php echo e(showAmount($item->price)); ?>

                                            </span>
                                        </td>

                                        <td>
                                            <?php echo $item->statusBadge ?>
                                        </td>

                                        <td>
                                            <button class="btn btn--warning confirmationBtn"
                                                data-action="<?php echo e(route('admin.listing.asset.status.change', $item->id)); ?>"
                                                data-question="<?php echo app('translator')->get('Are you sure to change ?'); ?> <?php echo e($item->getStatusText()); ?>">
                                                <i class="las la-sync"></i>
                                            </button>

                                            <a href="<?php echo e(route('admin.listing.asset.view', $item->id)); ?>"
                                                class="btn btn--primary ms-1" data-name="<?php echo e($item->name); ?>"><i
                                                    class="las la-eye"></i>
                                            </a>

                                            <?php if($item->isAdminAuthor()): ?>
                                                <a class="btn btn--primary ms-1"
                                                    href="<?php echo e(route('admin.listing.asset.edit', $item->id)); ?>">
                                                    <i class="las la-edit"></i>
                                                </a>
                                                <button class="btn btn--danger confirmationBtn"
                                                    data-action="<?php echo e(route('admin.listing.asset.delete', $item->id)); ?>"
                                                    data-question="<?php echo app('translator')->get('Are you sure to delete this listing image?'); ?>">
                                                    <i class="las la-trash"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                                    </tr>
                                <?php endif; ?>

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <?php if($listingUnits->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo e(paginateLinks($listingUnits)); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if (isset($component)) { $__componentOriginalbd5922df145d522b37bf664b524be380 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbd5922df145d522b37bf664b524be380 = $attributes; } ?>
<?php $component = App\View\Components\ConfirmationModal::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\ConfirmationModal::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbd5922df145d522b37bf664b524be380)): ?>
<?php $attributes = $__attributesOriginalbd5922df145d522b37bf664b524be380; ?>
<?php unset($__attributesOriginalbd5922df145d522b37bf664b524be380); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbd5922df145d522b37bf664b524be380)): ?>
<?php $component = $__componentOriginalbd5922df145d522b37bf664b524be380; ?>
<?php unset($__componentOriginalbd5922df145d522b37bf664b524be380); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('breadcrumb-plugins'); ?>
    <div class="text-end mb-2">
        <a href="<?php echo e(route('admin.listing.asset.create')); ?>" class="btn btn-sm btn--primary">
            <i class="las la-plus"></i><?php echo app('translator')->get('Add New'); ?></a>
    </div>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\victo\Desktop\pedro\condoImage\_\httpdocs\staging\application\resources\views/admin/listing_image/index.blade.php ENDPATH**/ ?>