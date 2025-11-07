<?php
    $faq = getContent('faq.content', true);
    $elements = getContent('faq.element');
?>


<?php $__env->startSection('content'); ?>
    <section class=" item-details pt-60 pb-3">
        <div class="container">
            <div class="row gy-4 mb-4">
                <div class="col-xl-8 d-flex flex-wrap gap-3">
                    <div class="row">
                        <div class="col-md-3 col-sm-4">
                            <div class="border-end pe-2 flex-sm-shrink-0">
                                <h4 class="text-center text-sm-start"><?php echo e(__($listingUnit->building->name)); ?>

                                    <?php echo app('translator')->get('unit'); ?> <?php echo e($listingUnit->unit_number); ?>

                                </h4>
                                <h6 class="text-center text-sm-start"><?php echo e($listingUnit->building->address); ?></h6>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-4">
                            <div class="d-flex flex-column justify-content-center align-items-center border-end pe-3">
                                <i class="fas fa-door-closed"></i>
                                <p class="text-nowrap"><?php echo app('translator')->get('Number of UNITS'); ?></p>
                                <h6 class="text-nowrap unit-count"><?php echo e($listingUnit->building->units); ?></h6>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-4">

                            <div class="d-flex flex-column justify-content-center align-items-center border-end pe-3">
                                <i class="far fa-window-restore"></i>
                                <p class="text-nowrap"><?php echo app('translator')->get('Number of Stories'); ?></p>
                                <h6 class="text-nowrap unit-count"><?php echo e($listingUnit->building->stories); ?></h6>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-4">
                            <div class="d-flex flex-column justify-content-center align-items-center pe-3">
                                <i class="fas fa-building"></i>
                                <p class="text-nowrap"><?php echo app('translator')->get('Year BUILT'); ?></p>

                                <h6 class="text-nowrap unit-count"><?php echo e($listingUnit->building->year_built); ?></h6>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-xl-4">
                    <div class="border bg-white p-3">
                        <p><?php echo app('translator')->get('Enhance your MLS listings and Social Media with REAL Stunning images'); ?></p>
                        <h5 class="mb-0"><?php echo app('translator')->get('Instant Download'); ?> <?php echo e(__($listingUnit->building->name)); ?>

                            <?php echo e($listingUnit->unit_number); ?> <?php echo app('translator')->get('Images'); ?></h5>
                    </div>
                </div>
            </div>
            <div class="row g-4 mb-4">
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="main-thumb--slider">
                        <?php $__currentLoopData = $listingUnit->listingImages ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="thumb-main">
                                <img src="<?php echo e(findWatermarkImagePath(getFilePath('listing_asset_image_watermark'), $item, $item->image)); ?>"
                                    alt="image">
                                <div class="info">
                                    <?php
                                        if (Auth::check()) {
                                            $wish = App\Models\Wishlist::where('user_id', auth()->user()->id)
                                                ->where('data_id', $listingUnit->id)
                                                ->where('type', 'listing')
                                                ->first();
                                        }
                                    ?>

                                    <?php if(auth()->guard()->guest()): ?>
                                        <button class="btn-img markWishlist"><i class="fas fa-heart"></i></button>
                                    <?php endif; ?>
                                    <?php if(auth()->guard()->check()): ?>
                                        <?php if(isset($wish)): ?>
                                            <button data-id="<?php echo e($listingUnit->id); ?>" data-type="listing"
                                                class="btn-img markWishlist"><i class="fas fa-heart text--base"></i></button>
                                        <?php else: ?>
                                            <button data-id="<?php echo e($listingUnit->id); ?>" data-type="listing"
                                                class="btn-img markWishlist"><i class="fas fa-heart"></i></button>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>
                </div>

                <div class="col-lg-4 col-md-5 col-12">
                    <div class="right-side">
                        <h6><?php echo app('translator')->get('Purchase option'); ?></h6>
                        <form action="<?php echo e(route('user.condo.listing.payment')); ?>" method="POST" class="mt-4">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="condo_listing_id" value="<?php echo e($listingUnit->id); ?>">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment" value="2"
                                    id="flexRadioDefault2" checked="">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    <?php echo e($listingUnit->listingImages->count()); ?> <?php echo app('translator')->get('images'); ?>
                                    <?php echo app('translator')->get('for'); ?> <?php echo e($general->cur_sym . $listingUnit->price); ?>

                                </label>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn button w-100 myGuestDownloadButton"><i
                                        class="fas fa-download mx-2"></i><?php echo app('translator')->get('Download zip'); ?></button>
                            </div>
                        </form>

                        <div class="type">
                            <div class="details">
                                <i class="fas fa-certificate"></i>
                                <h6 title="<?php echo e(strip_tags($listingUnit->building->copyright_description)); ?>">
                                    <?php echo app('translator')->get('Copy Information'); ?></h6>
                            </div>
                            <div class="details">
                                <i class="fas fa-sign-in-alt"></i>
                                <h6><?php echo app('translator')->get('Sign In first to buy image'); ?></h6>
                            </div>
                            <div class="details">
                                <i class="fas fa-file"></i>
                                <h6><?php echo app('translator')->get('Collection by:'); ?> <?php echo e($listingUnit->userable->username); ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <div class="short--preview d-flex flex-wrap gap-5">
                    <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-3">
                        <?php $__currentLoopData = $listingUnit->listingImages ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="thumb">
                                <img src="<?php echo e(findWatermarkImagePath(getFilePath('listing_asset_image_watermark'), $image, $image->image)); ?>"
                                    alt="image">
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="faq pb-60">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="accordion custom--accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingListingImageList">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-details" aria-expanded="false"
                                    aria-controls="headingListingImageList">
                                    <?php echo app('translator')->get('Details'); ?>
                                </button>
                            </h2>
                            <div id="collapse-details" class="accordion-collapse collapse"
                                aria-labelledby="headingListingImageList" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <?php
                                        echo $listingUnit->description;
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingMoreListingImageList">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-List" aria-expanded="true"
                                    aria-controls="headingMoreListingImageList">
                                    <?php echo app('translator')->get('More Listing from'); ?> <?php echo e($listingUnit->building->name); ?>

                                </button>
                            </h2>
                            <div id="collapse-List" class="accordion-collapse collapse show"
                                aria-labelledby="headingMoreListingImageList" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <?php
                                        echo $listingUnit->building->description;
                                    ?>
                                    <div class="accordion-thumb--slider my-4">
                                        <?php $__currentLoopData = $buildingListingImages ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="thumb-main">
                                                <img
                                                    src=" <?php echo e(getImage(getFilePath('listing_asset_image') . '/' . $data['first_image'])); ?>"alt="image">
                                                <div
                                                    class="d-flex flex-column justify-content-center align-items-center mt-3">

                                                    <h5 class=""><?php echo e($data['unit_number']); ?></h5>
                                                    <a href="<?php echo e(route('condo.building.listing.images', [slug($data['county']), slug($data['neighborhood']), slug($data['building']), slug($data['unit_number']), $data['id']])); ?>"
                                                        class="btn button">
                                                        <?php echo app('translator')->get('View all images'); ?>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="mb-4">
                                <?php
                                    echo $listingUnit->building->description;
                                ?>
                            </div>
                            <a href="<?php echo e(route('condo.building.details', building_listing_unit_route_params($listingUnit))); ?>"
                                class="d-flex flex-wrap gap-3">
                                <?php $__currentLoopData = $groupedImagesByCategory ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="thumb">
                                        <img
                                            src="<?php echo e(getImage(getFilePath('building_watermark') . '/watermark_' . $group['first_image'])); ?>"alt="image">
                                        <div
                                            class="content d-flex flex-column justify-content-center align-items-center my-2 border-end">
                                            <h6 class="m-0"><?php echo e(__($group['category_name'])); ?></h6>
                                            <h6 class="m-0"><?php echo e($group['image_count']); ?></h6>
                                            <h6 class="m-0"><?php echo app('translator')->get('IMAGES'); ?></h6>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </a>

                            <div class="d-flex justify-content-center mt-3">
                                <a href="<?php echo e(route('condo.building.details', building_listing_unit_route_params($listingUnit))); ?>"
                                    class="btn button">
                                    <?php echo app('translator')->get('View all images'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if(isset($sections)): ?>
        <?php if($sections->secs != null): ?>
            <?php $__currentLoopData = json_decode($sections->secs); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make($activeTemplate . 'sections.' . $sec, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .main-thumb--slider {
            .slick-arrow {
                top: 50% !important;
                width: 44px;
                height: 44px;
            }

            .slick-prev {
                left: 40px;
                background-color: hsl(var(--base));
            }

            .slick-next {
                right: 40px;
                background-color: hsl(var(--base));
            }

        }

        .accordion-thumb--slider {
            .slick-arrow {
                top: 50% !important;
                width: 44px;
                height: 44px;
            }

            .slick-prev {
                left: 40px;
                background-color: hsl(var(--base));
            }

            .slick-next {
                right: 40px;
                background-color: hsl(var(--base));
            }
        }

        @media only screen and (max-width: 767px) {
            .short--preview {
                .thumb {
                    width: 110px;
                }
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        $(".main-thumb--slider").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 1000,
            pauseOnHover: true,
            speed: 2000,
            dots: false,
            arrows: true,
            prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-long-arrow-alt-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next"><i class="fas fa-long-arrow-alt-right"></i></button>',
            responsive: [{
                    breakpoint: 1199,
                    settings: {
                        slidesToShow: 1,
                    },
                },
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 1,
                    },
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 1,
                    },
                },
                {
                    breakpoint: 586,
                    settings: {
                        slidesToShow: 1,
                    },
                },
                {
                    breakpoint: 400,
                    settings: {
                        slidesToShow: 1,
                    },
                },
            ],
        });



        function initSlickSlider(slider) {
            if (!slider.hasClass('slick-initialized')) {
                slider.slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    autoplay: false,
                    autoplaySpeed: 1000,
                    pauseOnHover: true,
                    speed: 1000,
                    dots: false,
                    arrows: true,
                    prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-long-arrow-alt-left"></i></button>',
                    nextArrow: '<button type="button" class="slick-next"><i class="fas fa-long-arrow-alt-right"></i></button>',
                    responsive: [{
                            breakpoint: 1199,
                            settings: {
                                slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 991,
                            settings: {
                                slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 767,
                            settings: {
                                slidesToShow: 2
                            }
                        },
                        {
                            breakpoint: 586,
                            settings: {
                                slidesToShow: 1
                            }
                        },
                        {
                            breakpoint: 400,
                            settings: {
                                slidesToShow: 1
                            }
                        },
                    ],
                });
            }
        }

        initSlickSlider($('.accordion-thumb--slider:visible'));


        $('.accordion-button').on('click', function() {
            const targetCollapse = $(this).data('bs-target');
            setTimeout(() => {
                const slider = $(targetCollapse).find('.accordion-thumb--slider');
                initSlickSlider(slider);
            }, 100);
        });
    </script>
    <script>
        $(document).on('click', '.markWishlist', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var type = $(this).data('type');
            var button = $(this);
            $.ajax({
                url: "<?php echo e(route('user.mark.wishlist')); ?>",
                data: {
                    id: id,
                    type: type,
                },
                method: "GET",
                success: function(data) {
                    if (data.status == true) {
                        var innerData = `<i class="fas fa-heart text--base"></i><?php echo app('translator')->get('Added'); ?>`;
                        button.html(innerData);
                        Toast.fire({
                            icon: 'success',
                            title: 'Successfully set this image to your wishlist.'
                        })
                        return false;
                    }

                    if (data.status == false) {
                        var innerData = `<i class="fas fa-heart"></i><?php echo app('translator')->get('Add'); ?>`;
                        button.html(innerData);
                        Toast.fire({
                            icon: 'success',
                            title: 'Successfully removed this image from your wishlist.'
                        })
                        return false;
                    }

                    if (data.auth == false) {
                        window.location.href = "<?php echo e(route('user.login')); ?>";
                    }
                },
                error: function(xhr, status, error) {},
            });

        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\victo\Desktop\pedro\condoImage\_\httpdocs\staging\application\resources\views/presets/default/building/building_unit_details.blade.php ENDPATH**/ ?>