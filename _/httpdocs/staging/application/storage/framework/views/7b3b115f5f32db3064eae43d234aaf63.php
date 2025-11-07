
<?php $__env->startSection('panel'); ?>
    <div class="row gy-4">
        <div class="col-xxl-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('#'); ?></th>
                                    <th><?php echo app('translator')->get('Name'); ?></th>
                                    <th><?php echo app('translator')->get('Created At'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $imageCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <?php echo e($loop->iteration); ?>

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
                                                <?php echo e(showDateTime($item->created_at)); ?>

                                            </span>
                                        </td>

                                        <td>
                                            <button class="btn btn--primary ms-1 editCatBtn"
                                                data-action="<?php echo e(route('admin.image.category.update', $item->id)); ?>"
                                                data-name="<?php echo e($item->name); ?>"><i class="las la-edit"></i>
                                            </button>
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
                <?php if($imageCategories->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo e(paginateLinks($imageCategories)); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div id="createCat" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Add New Image Category'); ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.image.category.create')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group ">
                            <label><?php echo app('translator')->get('Image Category Name'); ?></label>
                            <input class="form-control" type="text" name="name" required>
                        </div>
                 
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-global"><?php echo app('translator')->get('Create'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div id="editCat" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Edit Image Category'); ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form id="editForm" action="" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><?php echo app('translator')->get('Image Category Name'); ?></label>
                            <input class="form-control" type="text" name="name" required>
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

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";

            $('.createCatBtn').on('click', function() {
                var modal = $('#createCat');
                modal.modal('show');
            });

            $('.editCatBtn').on('click', function() {
                var modal = $('#editCat');
                let url = $(this).data('action');
                let base = "<?php echo e(url('/')); ?>";

                $('#editForm').attr('action', url);
                modal.find('input[name="name"]').val($(this).data('name'));

                modal.modal('show');
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <div class="text-end mb-2">
        <button class="btn btn-sm btn--primary createCatBtn"><i class="las la-plus"></i><?php echo app('translator')->get('Add New'); ?></button>
    </div>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\victo\Desktop\pedro\condoImage\_\httpdocs\staging\application\resources\views/admin/image_category/index.blade.php ENDPATH**/ ?>