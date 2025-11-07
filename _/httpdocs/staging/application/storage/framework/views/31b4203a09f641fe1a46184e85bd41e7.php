
<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <div class="row gy">
                        <form action="<?php echo e(route('admin.building.update', $building->id)); ?>" method="post"
                            enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="image-upload">
                                            <div class="thumb">
                                                <div class="avatar-preview">
                                                    <div class="profilePicPreview"
                                                        style="background-image: url(<?php echo e(getImage(getFilePath('building') . '/' . $building->image)); ?>);">
                                                        <button type="button" class="remove-image"><i
                                                                class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="avatar-edit">
                                                    <input type="file" class="profilePicUpload" name="image"
                                                        id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                                    <label for="profilePicUpload1"
                                                        class="btn btn--primary"><?php echo app('translator')->get('Upload'); ?></label>
                                                </div>
                                            </div>
                                            <small class="pt-4 mb-4"><?php echo app('translator')->get('Recommend image size'); ?>
                                                (<?php echo e(getFileSize('building')); ?>)</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="mb-2 form--label"><?php echo app('translator')->get('Name'); ?></label>
                                                <input type="text" name="name" class="form-control"
                                                    placeholder="<?php echo app('translator')->get('name'); ?>" value="<?php echo e($building->name); ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="mb-2 form--label"><?php echo app('translator')->get('Neighborhood'); ?></label>
                                                <select name="neighborhood_id" id="status" class="form-control" required>
                                                    <option><?php echo app('translator')->get('Select Neighborhood'); ?></option>
                                                    <?php $__currentLoopData = $neighborhoods ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($item->id); ?>"
                                                            <?php echo e($item->id == $building->neighborhood_id ? 'selected' : ''); ?>>
                                                            <?php echo e($item->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="address"><?php echo app('translator')->get('Address'); ?></label>
                                                <textarea name="address" rows="5" cols="5" class="form-control" required><?php echo e($building->address); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="mb-2 form--label"><?php echo app('translator')->get('Years'); ?></label>
                                        <input type="month" name="year_built" value="<?php echo e($building->year_built); ?>"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-6">
                                    <div class="form-group">
                                        <label class="mb-2 form--label"><?php echo app('translator')->get('Price'); ?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="price" name="price"
                                                aria-label="price" aria-describedby="basic-addon2"
                                                value="<?php echo e($building->price); ?>" required>
                                            <span class="input-group-text" id="basic-addon2"><?php echo e(gs()->cur_sym); ?></span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="mb-2 form--label"><?php echo app('translator')->get('Units'); ?></label>
                                        <input type="number" name="units" value="<?php echo e($building->units); ?>"
                                            class="form-control" required />
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label class="mb-2 form--label"><?php echo app('translator')->get('Stories'); ?></label>
                                        <input type="number" name="stories" value="<?php echo e($building->stories); ?>"
                                            class="form-control" required />
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="mb-2 form--label"><?php echo app('translator')->get('Status'); ?></label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1" <?php echo e($building->status == 1 ? 'selected' : ''); ?>>
                                                <?php echo app('translator')->get('Active'); ?></option>
                                            <option value="2" <?php echo e($building->status == 2 ? 'selected' : ''); ?>>
                                                <?php echo app('translator')->get('Deactivate'); ?></option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="description"><?php echo app('translator')->get('Description'); ?></label>
                                        <textarea name="description" rows="10" cols="5" class="form-control trumEdit1"
                                            placeholder="<?php echo app('translator')->get('Description'); ?>"><?php echo e($building->description); ?></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="copyright_description"><?php echo app('translator')->get('Copyright Description'); ?></label>
                                        <textarea name="copyright_description" rows="10" cols="5" class="form-control trumEdit2"
                                            placeholder="<?php echo app('translator')->get('Copyright Description'); ?>"><?php echo e($building->copyright_description); ?></textarea>
                                    </div>
                                </div>
                            </div>



                            <div class="row mt-5">
                                <?php $__currentLoopData = $building->buildingListingUnits ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-lg-3">
                                        <?php if($loop->first): ?>
                                            <h4 class="mb-3"><?php echo app('translator')->get('Listings Images'); ?></h4>
                                        <?php endif; ?>
                                        <div class="form-group <?php echo e(!$loop->first ? 'mt-5' : ''); ?>">
                                            <div class="image-upload">
                                                <div class="thumb">
                                                    <div class="avatar-preview">
                                                        <div class="profilePicPreview"
                                                            style="background-image: url(<?php echo e(getImage(getFilePath('listing_asset_image') . '/' . $item->image)); ?>);">
                                                            <button type="button" class="remove-image"><i
                                                                    class="fa fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h3 class="text-center mt-2"><?php echo e($item->unit_number); ?></h3>
                                                    <a class="btn btn--success w-100 mt-2"
                                                        href="<?php echo e(route('condo.building.listing.images', listing_unit_route_params($item))); ?>"><?php echo app('translator')->get('View all images'); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <div class="col-lg-12 text-end mt-3">
                                <button type="submit" class="btn btn--primary">
                                    <?php echo app('translator')->get($building->claim == 1 ? 'Next' : 'Save'); ?>
                                    <?php if($building->claim == 1): ?>
                                        <i class="fas fa-chevron-right"></i>
                                    <?php endif; ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
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

<?php $__env->startPush('style'); ?>
    <style>
        .ck.ck-editor__main>.ck-editor__editable {
            height: 150px;
        }


        ::-webkit-scrollbar {
            width: .5rem;
        }

        ::-webkit-scrollbar-track {
            background: #bdc3c7;
            border-radius: .75rem;
        }

        ::-webkit-scrollbar-thumb {
            background: #34495e;
            border-radius: .75rem;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #2c3e50;
        }


        .file-form {

            position: relative;
            padding: 2.5rem;
            border: 2px dashed blue;
        }

        .file-form:hover {
            border-color: green;
        }

        .file-form.highlight {
            border-color: green;
        }

        .drop-content {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            cursor: pointer;
            text-align: center;
            padding-top: 12px;
            font-weight: bold;
            color: #34495e;
            font-size: 18px;
        }

        .previewCard {
            margin-top: 20px;
        }

        .file-form input {
            display: none;
        }

        .previewCard .uploadedImage {
            max-height: 750px;
            overflow-y: auto;
            display: flex;
            flex-wrap: wrap;
            padding: 10px;
        }

        .d-none {
            display: none !important;
        }

        .box-shadow--none {
            box-shadow: none !important
        }

        #executeBtn {
            background-color: #34495e;
        }

        #executeBtn:hover {
            background-color: #2c3e50;
        }

        #executeBtn:active {
            background-color: #2c3e50;
            transform: scale(1.1);
        }


        #clearAllBtn {
            color: #ecf0f1;
            background-color: #e74c3c;
        }

        #clearAllBtn:active {
            background-color: #c0392b;
            transform: scale(1.1);
        }

        #clearAllBtn:hover {
            background-color: #c0392b;
        }

        .image-content {
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            border: 1px dashed #bdc3c7;
            border-radius: .25rem;
            margin-left: 0px;
            margin-right: 16px;
            padding: .25rem;
            margin-top: 15px;

        }

        .image-wrapper {
            position: relative;
            width: 148px;
            height: 148px;

            img {
                object-fit: cover;
                height: 100%;
                width: 100%;
                transition: 1s;
            }
        }


        .image-wrapper:hover img {
            filter: hsl;
        }

        .image-wrapper span {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-weight: bold;
            font-size: 15px;
            background: red;
            padding: 10px;
            border-radius: 20%;
            line-height: 10px;
        }

        .image-wrapper:hover span {
            display: block;
        }


        .title {
            text-align: center;
            margin-top: 4rem;
            color: #34495e;
        }

        @media only screen and (max-width: 620px) {

            .previewCard .uploadedImage {
                justify-content: center;
            }

            .drop-content {
                padding-top: 8px;
                font-size: 15px;

            }

        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {
                "use strict";
                if ($(".trumEdit1")[0]) {
                    ClassicEditor
                        .create(document.querySelector('.trumEdit1'))
                        .then(editor => {
                            window.editor = editor;
                        });
                }
                if ($(".trumEdit2")[0]) {
                    ClassicEditor
                        .create(document.querySelector('.trumEdit2'))
                        .then(editor => {
                            window.editor = editor;
                        });
                }
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\victo\Desktop\pedro\condoImage\_\httpdocs\staging\application\resources\views/admin/building/edit.blade.php ENDPATH**/ ?>