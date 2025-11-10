<!doctype html>
<html lang="<?php echo e(config('app.locale')); ?>" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title> <?php echo e($general->siteName(__($pageTitle))); ?></title>
    <?php echo $__env->make('includes.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Bootstrap CSS -->
    <link href="<?php echo e(baseAsset('assets/common/css/bootstrap.min.css')); ?>" rel="stylesheet">

    <link href="<?php echo e(baseAsset('assets/common/css/all.min.css')); ?>" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo e(baseAsset('assets/common/css/line-awesome.min.css')); ?>">


    <!-- Magnific Popup -->
    <link rel="stylesheet" href="<?php echo e(baseAsset($activeTemplateTrue . 'css/magnific-popup.css')); ?>">
    <!-- Slick -->
    <link rel="stylesheet" href="<?php echo e(baseAsset($activeTemplateTrue . 'css/slick.css')); ?>">
    <!-- Odometer -->
    <link rel="stylesheet" href="<?php echo e(baseAsset($activeTemplateTrue . 'css/odometer.css')); ?>">
    <!-- Public site stylesheet (altered) -->
    <link rel="stylesheet" href="<?php echo e(baseAsset($activeTemplateTrue . 'css/override.css')); ?>">
    <!-- animate -->
    <link rel="stylesheet" href="<?php echo e(baseAsset($activeTemplateTrue . 'css/animate.min.css')); ?>">

    <?php echo $__env->yieldPushContent('style-lib'); ?>
    <link rel="stylesheet"
        href="<?php echo e(baseAsset($activeTemplateTrue . 'css/color.php')); ?>?color=<?php echo e($general->base_color); ?>&secondColor=<?php echo e($general->secondary_color); ?>">

    <?php echo $__env->yieldPushContent('style'); ?>
    
    <script>
        // Global configuration for BASE_URL support
        window.BASE_URL = '<?php echo e(env("BASE_URL", "")); ?>';
        window.APP_URL = '<?php echo e(config("app.url")); ?>';
    </script>
</head>

<body>
    <?php echo $__env->make('includes.browse', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldPushContent('fbComment'); ?>

    <!--==================== Preloader Start ====================-->
    
    <!--==================== Preloader End ====================-->


    <!--==================== Overlay Start ====================-->
    <div class="body-overlay"></div>
    <!--==================== Overlay End ====================-->

    <!--==================== Sidebar Overlay End ====================-->
    <div class="sidebar-overlay"></div>
    <!--==================== Sidebar Overlay End ====================-->

    <!-- ==================== Scroll to Top End Here ==================== -->
    <!-- ==================== Scroll to Top End Here ==================== -->

    <?php echo $__env->make($activeTemplate . 'partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if(!Route::is('neighborhood') && !Route::is('neighborhood.*')): ?>
        <?php echo $__env->make($activeTemplate . 'partials.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <?php echo $__env->yieldContent('content'); ?>
    <?php echo $__env->make($activeTemplate . 'partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make($activeTemplate . 'partials.cookie', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?php echo e(baseAsset('assets/common/js/jquery-3.7.1.min.js')); ?>"></script>
    <script src="<?php echo e(baseAsset('assets/common/js/bootstrap.bundle.min.js')); ?>"></script>
    <!-- Slick js -->
    <script src="<?php echo e(baseAsset($activeTemplateTrue . 'js/slick.min.js')); ?>"></script>
    <!-- Magnific Popup js -->
    <script src="<?php echo e(baseAsset($activeTemplateTrue . 'js/jquery.magnific-popup.min.js')); ?>"></script>
    <!-- Odometer js -->
    <script src="<?php echo e(baseAsset($activeTemplateTrue . 'js/odometer.min.js')); ?>"></script>
    <!-- Viewport js -->
    <script src="<?php echo e(baseAsset($activeTemplateTrue . 'js/viewport.jquery.js')); ?>"></script>
    <!-- main js -->
    <script src="<?php echo e(baseAsset($activeTemplateTrue . 'js/main.js')); ?>"></script>
    <!-- smooth scroll js -->
    <script src="<?php echo e(baseAsset($activeTemplateTrue . 'js/smoothscroll.min.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('script-lib'); ?>

    <?php echo $__env->yieldPushContent('script'); ?>

    <?php echo $__env->make('includes.plugins', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('includes.notify', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <script>
        (function($) {
            "use strict";
            $(".langSel").on("change", function() {
                window.location.href = "<?php echo e(baseRoute('home')); ?>/change/" + $(this).val();
            });

            $('.policy').on('click', function() {
                $.get('<?php echo e(baseRoute('cookie.accept')); ?>', function(response) {
                    $('.cookies-card').addClass('d-none');
                });
            });

            setTimeout(function() {
                $('.cookies-card').removeClass('hide')
            }, 2000);

            var inputElements = $('[type=text],select,textarea');
            $.each(inputElements, function(index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });

            $.each($('input, select, textarea'), function(i, element) {

                if (element.hasAttribute('required')) {
                    $(element).closest('.form-group').find('label').addClass('required');
                }

            });

        })(jQuery);
    </script>

</body>

</html>
<?php /**PATH C:\Users\victo\Desktop\pedro\condoImage\_\httpdocs\staging\application\resources\views/presets/default/layouts/frontend.blade.php ENDPATH**/ ?>