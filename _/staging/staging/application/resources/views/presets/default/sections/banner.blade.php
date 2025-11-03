@php
    $banner = getContent('banner.content', true);
    $neighborhoods = App\Models\Neighborhood::with(['buildings','county'])
        ->where('status', 1)
        ->orderByRaw('RAND()')
        ->latest()
        ->take(10)
        ->get();
@endphp
<!--========================== Banner Section Start ==========================-->
@if ($general->theme == 1)
    <section class="banner-section">
        <div class=" container">
            <div class="banner-thumb">
                <div class="row">
                    <div class="col-lg-6 col-12 my-auto">
                        <div class="content mb-4">
                            <h3>{{ __($banner->data_values->heading) }}</h3>
                            <p>{{ __($banner->data_values->subheading) }}</p>
                        </div>
                        <div class="d-flex">
                            <a href="{{ $banner->data_values->button_one_link }}"
                                class="btn button me-3">{{ __($banner->data_values->button_one) }}</a>
                            <a href="{{ $banner->data_values->button_two_link }}"
                                class="btn btn2 button">{{ __($banner->data_values->button_two) }}</a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12 my-auto pt-lg-0 pt-md-4 pt-4 thumb">
                        <div>
                            <img class="shape"
                                src="{{ getImage(getFilePath('bannerOne') . '/' . $banner->data_values->theme_one_shape) }}"
                                alt="shape" width="86">
                        </div>
                        <img src="{{ getImage(getFilePath('bannerOne') . '/' . $banner->data_values->theme_one_banner) }}"
                            class="img-fluid d-flex ms-auto" alt="image">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--========================== Banner Section End ==========================-->
@endif

@if ($general->theme == 2)
    <!--========================== Banner Section Start ==========================-->
    <section class="banner-section-two">
        <div class="banner-thumb bg-img bg-overlay py-120"
            data-background="{{ getImage(getFilePath('bannerOne') . '/' . $banner->data_values->theme_two_banner) }}">
            <div class="content mb-4 wow animate__animated animate__fadeInUp" data-wow-delay="0.6s">
                <h3>{{ __($banner->data_values->heading) }}</h3>
                <p>{{ __($banner->data_values->subheading) }}</p>
            </div>

            <div class="main">
                <form id="myForm" class="form-area d-flex" action="{{ route('search.building') }}" method="GET">
                    <div class="my-auto">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-image"></i>
                            <p class="mx-2 text-nowrap">@lang('Building')</p>
                        </div>
                    </div>
                    <div class="w-100">
                        <div class="search">
                            <input id="searchInput" type="text" name="search" class="form--control"
                                value="{{ old('search') }}" placeholder="Search for building">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </section>
    <!--========================== Banner Section End ==========================-->

    <!-- ==================== top categories Start ==================== -->
    <section class="top-categories pb-100">
        <div class="container">
            <div class="category-slider">
                @foreach ($neighborhoods as $item)
                    <div>
                        <a href="{{ route('neighborhood.details', ['county' => slug($item->county->name),'slug' => slug($item->name), 'id' => $item->id]) }}"
                            class="card">
                            <div class="thumb">
                                <img src="{{ getImage(getFilePath('neighborhood') . '/' . $item->image) }}"
                                    alt="image">
                            </div>
                            <h5>{{ __($item->name) }}</h5>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- ==================== top categories end ==================== -->
@endif

@push('script')
    @push('script')
        <script>
            $(document).ready(function() {
                'use strict';
                $('#searchInput').keypress(function(e) {
                    if (e.which === 13) {
                        e.preventDefault();
                        $('#myForm').submit();
                    }
                });
            });
        </script>
    @endpush
@endpush
