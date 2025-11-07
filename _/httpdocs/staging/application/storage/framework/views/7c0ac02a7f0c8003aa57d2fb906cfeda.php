
<?php $__env->startSection('panel'); ?>
    <?php echo $__env->make('admin.components.tabs.building', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row gy-4">
        <div class="col-xxl-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('SI'); ?></th>
                                    <th><?php echo app('translator')->get('Image'); ?></th>
                                    <th><?php echo app('translator')->get('Claim By'); ?></th>
                                    <th><?php echo app('translator')->get('Name'); ?></th>
                                    <th><?php echo app('translator')->get('Neighborhood'); ?></th>
                                    <th><?php echo app('translator')->get('Built Year'); ?></th>
                                    <th><?php echo app('translator')->get('Price'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $buildings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            #<?php echo e($loop->iteration); ?>

                                        </td>

                                        <td>
                                            <img class="custom-rounded"
                                                src="<?php echo e(getImage(getFilePath('building') . '/' . $item->image)); ?>"
                                                alt="Building Image" width="70">
                                        </td>

                                        <td>
                                          <?php echo e($item->imageUploadAuthor($item)); ?>

                                        </td>

                                        <td>
                                            <?php if(strlen($item->name) < 21): ?>
                                                <span class="fw-bold">
                                                    <?php echo e($item->name); ?>

                                                </span>
                                            <?php else: ?>
                                                <span class="fw-bold">
                                                    <?php echo e(substr($item->name, 0, 20)); ?>...
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <span class="fw-bold">
                                                <?php echo e($item->neighborhood->name); ?>

                                            </span>
                                        </td>

                                        <td>
                                            <span class="fw-bold">
                                                <?php echo e($item->year_built); ?>

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
                                                data-action="<?php echo e(route('admin.building.status.change', $item->id)); ?>"
                                                data-question="<?php echo app('translator')->get('Are you sure to change ?'); ?> <?php echo e($item->getStatusText()); ?>">
                                                <i class="las la-sync"></i>
                                            </button>

                                            <a href="<?php echo e(route('admin.building.view', $item->id)); ?>"
                                                class="btn btn--primary ms-1" data-name="<?php echo e($item->name); ?>"><i
                                                    class="las la-eye"></i>
                                            </a>
                                            <?php if($item->claim != 1): ?>
                                                <button data-action="<?php echo e(route('admin.building.claim', $item->id)); ?>"
                                                    class="btn btn--primary ms-1 claimBtn"><i
                                                        class="fas fa-exclamation-triangle"></i>
                                                </button>
                                            <?php endif; ?>
                                             <?php if($item->claim == 1): ?>
                                            <a href="<?php echo e(route('admin.building.edit', $item->id)); ?>"
                                                class="btn btn--primary ms-1" data-name="<?php echo e($item->name); ?>"><i
                                                    class="las la-edit"></i>
                                            </a>
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
                <?php if($buildings->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo e(paginateLinks($buildings)); ?>

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
    
    <div id="claim" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Edit claim author'); ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form id="editForm" action="" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">

                        <div class="form-group">
                            <label><?php echo app('translator')->get('State Name'); ?></label>
                            <select class="form-control" name="claim" id="claim">
                                <option value="1"><?php echo app('translator')->get('Claim for me'); ?></option>
                                <option value="2"><?php echo app('translator')->get('Open for contributor'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-global"><?php echo app('translator')->get('Update'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('breadcrumb-plugins'); ?>
    <div class="text-end mb-2">
        <a href="<?php echo e(route('admin.building.create')); ?>" class="btn btn-sm btn--primary createCatBtn">
            <i class="las la-plus"></i><?php echo app('translator')->get('Add New'); ?></a>
    </div>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";

            $('.claimBtn').on('click', function() {
                var modal = $('#claim');
                let url = $(this).data('action');
                let base = "<?php echo e(url('/')); ?>";

                $('#editForm').attr('action', url);

                modal.modal('show');
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\victo\Desktop\pedro\condoImage\_\httpdocs\staging\application\resources\views/admin/building/index.blade.php ENDPATH**/ ?>