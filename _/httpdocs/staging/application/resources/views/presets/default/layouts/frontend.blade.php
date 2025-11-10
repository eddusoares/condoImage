<!doctype html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title> {{ $general->siteName(__($pageTitle)) }}</title>
    @include('includes.seo')
    <!-- Bootstrap CSS -->
    <link href="{{ baseAsset('assets/common/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ baseAsset('assets/common/css/all.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ baseAsset('assets/common/css/line-awesome.min.css') }}">


    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{ baseAsset($activeTemplateTrue . 'css/magnific-popup.css') }}">
    <!-- Slick -->
    <link rel="stylesheet" href="{{ baseAsset($activeTemplateTrue . 'css/slick.css') }}">
    <!-- Odometer -->
    <link rel="stylesheet" href="{{ baseAsset($activeTemplateTrue . 'css/odometer.css') }}">
    <!-- Public site stylesheet (altered) -->
    <link rel="stylesheet" href="{{ baseAsset($activeTemplateTrue . 'css/override.css') }}">
    <!-- animate -->
    <link rel="stylesheet" href="{{ baseAsset($activeTemplateTrue . 'css/animate.min.css') }}">

    @stack('style-lib')
    <link rel="stylesheet"
        href="{{ baseAsset($activeTemplateTrue . 'css/color.php') }}?color={{ $general->base_color }}&secondColor={{ $general->secondary_color }}">

    @stack('style')
    
    <script>
        // Global configuration for BASE_URL support
        window.BASE_URL = '{{ env("BASE_URL", "") }}';
        window.APP_URL = '{{ config("app.url") }}';
    </script>
</head>

<body>
    @include('includes.browse')
    @stack('fbComment')

    <!--==================== Preloader Start ====================-->
    {{-- <div class="preloader">
        <div class="loader"></div>
    </div> --}}
    <!--==================== Preloader End ====================-->


    <!--==================== Overlay Start ====================-->
    <div class="body-overlay"></div>
    <!--==================== Overlay End ====================-->

    <!--==================== Sidebar Overlay End ====================-->
    <div class="sidebar-overlay"></div>
    <!--==================== Sidebar Overlay End ====================-->

    <!-- ==================== Scroll to Top End Here ==================== -->
    <!-- ==================== Scroll to Top End Here ==================== -->

    @include($activeTemplate . 'partials.header')
    @if (!Route::is('neighborhood') && !Route::is('neighborhood.*'))
        @include($activeTemplate . 'partials.breadcrumb')
    @endif

    @yield('content')
    @include($activeTemplate . 'partials.footer')
    @include($activeTemplate . 'partials.cookie')

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ baseAsset('assets/common/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ baseAsset('assets/common/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Slick js -->
    <script src="{{ baseAsset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
    <!-- Magnific Popup js -->
    <script src="{{ baseAsset($activeTemplateTrue . 'js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Odometer js -->
    <script src="{{ baseAsset($activeTemplateTrue . 'js/odometer.min.js') }}"></script>
    <!-- Viewport js -->
    <script src="{{ baseAsset($activeTemplateTrue . 'js/viewport.jquery.js') }}"></script>
    <!-- main js -->
    <script src="{{ baseAsset($activeTemplateTrue . 'js/main.js') }}"></script>
    <!-- smooth scroll js -->
    <script src="{{ baseAsset($activeTemplateTrue . 'js/smoothscroll.min.js') }}"></script>

    @stack('script-lib')

    @stack('script')

    @include('includes.plugins')

    @include('includes.notify')


    <script>
        (function($) {
            "use strict";
            $(".langSel").on("change", function() {
                window.location.href = "{{ baseRoute('home') }}/change/" + $(this).val();
            });

            $('.policy').on('click', function() {
                $.get('{{ baseRoute('cookie.accept') }}', function(response) {
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
