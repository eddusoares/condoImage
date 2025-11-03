<!doctype html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ $general->siteName(__($pageTitle)) }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('includes.seo')

    <link href="{{ asset('assets/common/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/common/css/all.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/common/css/line-awesome.min.css') }}">

    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/magnific-popup.css') }}">
    <!-- Slick -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/slick.css') }}">
    <!-- Odometer -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/odometer.css') }}">

    <!-- animate -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/animate.min.css') }}">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/fileUpload.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/admin/css/select2.min.css') }}">

    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}">
    @stack('style-lib')

    @stack('style')


    <style>
        .cookies-card {
            position: fixed;
            bottom: 16px;
            width: 40%;
            padding: 20px;
            background: #fff;
            border: 2px solid #108ce6;
            box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
            right: 16px;
            z-index: 99;
            border: 2px solid #108ce6;
        }

        .dark-mode .cookies-card {
            background: #2d3748;
            border: 1px solid #404040;
        }

        @media (max-width:576px) {
            .cookies-card {
                width: 90%;
            }
        }
    </style>

    <link rel="stylesheet"
        href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ $general->base_color }}&secondColor={{ $general->secondary_color }}">
</head>

<body>
    <!--==================== Preloader Start ====================-->
    <div class="preloader">
        <div class="loader"></div>
    </div>
    <!--==================== Preloader End ====================-->

    <!--==================== Overlay Start ====================-->
    <div class="body-overlay"></div>
    <!--==================== Overlay End ====================-->

    <!--==================== Sidebar Overlay End ====================-->
    <div class="sidebar-overlay"></div>
    <!--==================== Sidebar Overlay End ====================-->

    <div class="page-wrapper">
        @include('presets.default.partials.sidebar')
        <div class="main-wrapper">
            <div class="main-body-wrapper">
                <!-- navbar-wrapper-start -->
                @include('presets.default.partials.topbar')
                <div class="page-wrapper">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    {{-- @include('presets.default.partials.upload-modal') --}}


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('assets/common/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/common/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset($activeTemplateTrue . 'js/jquery.validate.js') }}"></script>

    <!-- Slick js -->
    <script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
    <!-- Magnific Popup js -->
    <script src="{{ asset($activeTemplateTrue . 'js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Odometer js -->
    <script src="{{ asset($activeTemplateTrue . 'js/odometer.min.js') }}"></script>
    <!-- Viewport js -->
    <script src="{{ asset($activeTemplateTrue . 'js/viewport.jquery.js') }}"></script>

    <!-- smooth scroll js -->
    <script src="{{ asset($activeTemplateTrue . 'js/smoothscroll.min.js') }}"></script>

    <script src="{{ asset($activeTemplateTrue . 'js/fileUpload.js') }}"></script>

    <script src="{{ asset('assets/admin/js/select2.min.js') }}"></script>

        <!-- main js -->
        <script src="{{ asset($activeTemplateTrue . 'js/main.js') }}"></script>

    @stack('script-lib')

    @include('includes.notify')

    @include('includes.plugins')


    @stack('script')


    <script>
        (function($) {
            "use strict";
            $(".langSel").on("change", function() {
                window.location.href = "{{ route('home') }}/change/" + $(this).val();
            });

        })(jQuery);
    </script>


    <script>
        (function($) {
            "use strict";

            $('form').on('submit', function() {
                if ($(this).valid()) {
                    $(':submit', this).attr('disabled', 'disabled');
                }
            });

            var inputElements = $('[type=text],[type=password],select,textarea');
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


            $('.showFilterBtn').on('click', function() {
                $('.responsive-filter-card').slideToggle();
            });


            let headings = $('.table th');
            let rows = $('.table tbody tr');
            let columns
            let dataLabel;

            $.each(rows, function(index, element) {
                columns = element.children;
                if (columns.length == headings.length) {
                    $.each(columns, function(i, td) {
                        dataLabel = headings[i].innerText;
                        $(td).attr('data-label', dataLabel)
                    });
                }
            });

        })(jQuery);
    </script>

</body>

</html>
