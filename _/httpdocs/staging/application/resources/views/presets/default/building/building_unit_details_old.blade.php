@php
    $faq = getContent('faq.content', true);
    $elements = getContent('faq.element');
@endphp

@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class=" item-details pt-60 pb-3">
        <div class="container">
            <div class="row gy-4 mb-4">
                <div class="col-xl-8 d-flex flex-wrap gap-3">
                    <div class="row">
                        <div class="col-md-3 col-sm-4">
                            <div class="border-end pe-2 flex-sm-shrink-0">
                                <h4 class="text-center text-sm-start">{{ __($listingUnit->building->name) }}
                                    @lang('unit') {{ $listingUnit->unit_number }}
                                </h4>
                                <h6 class="text-center text-sm-start">{{ $listingUnit->building->address }}</h6>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-4">
                            <div class="d-flex flex-column justify-content-center align-items-center border-end pe-3">
                                <i class="fas fa-door-closed"></i>
                                <p class="text-nowrap">@lang('Number of UNITS')</p>
                                <h6 class="text-nowrap unit-count">{{ $listingUnit->building->units }}</h6>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-4">

                            <div class="d-flex flex-column justify-content-center align-items-center border-end pe-3">
                                <i class="far fa-window-restore"></i>
                                <p class="text-nowrap">@lang('Number of Stories')</p>
                                <h6 class="text-nowrap unit-count">{{ $listingUnit->building->stories }}</h6>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-4">
                            <div class="d-flex flex-column justify-content-center align-items-center pe-3">
                                <i class="fas fa-building"></i>
                                <p class="text-nowrap">@lang('Year BUILT')</p>

                                <h6 class="text-nowrap unit-count">{{ $listingUnit->building->year_built }}</h6>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-xl-4">
                    <div class="border bg-white p-3">
                        <p>@lang('Enhance your MLS listings and Social Media with REAL Stunning images')</p>
                        <h5 class="mb-0">@lang('Instant Download') {{ __($listingUnit->building->name) }}
                            {{ $listingUnit->unit_number }} @lang('Images')</h5>
                    </div>
                </div>
            </div>
            <div class="row g-4 mb-4">
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="main-thumb--slider">
                        @foreach ($listingUnit->listingImages ?? [] as $item)
                            <div class="thumb-main">
                                <img src="{{ findWatermarkOrMainImagePath($item,'listing_asset_image') }}"
                                    alt="image">
                                <div class="info">
                                    @php
                                        if (Auth::check()) {
                                            $wish = App\Models\Wishlist::where('user_id', auth()->user()->id)
                                                ->where('data_id', $listingUnit->id)
                                                ->where('type', 'listing')
                                                ->first();
                                        }
                                    @endphp

                                    @guest
                                        <button class="btn-img markWishlist"><i class="fas fa-heart"></i></button>
                                    @endguest
                                    @auth
                                        @if (isset($wish))
                                            <button data-id="{{ $listingUnit->id }}" data-type="listing"
                                                class="btn-img markWishlist"><i class="fas fa-heart text--base"></i></button>
                                        @else
                                            <button data-id="{{ $listingUnit->id }}" data-type="listing"
                                                class="btn-img markWishlist"><i class="fas fa-heart"></i></button>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

                <div class="col-lg-4 col-md-5 col-12">
                    <div class="right-side">
                        <h6>@lang('Purchase option')</h6>
                        <form action="{{ route('user.condo.listing.payment') }}" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="condo_listing_id" value="{{ $listingUnit->id }}">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment" value="2"
                                    id="flexRadioDefault2" checked="">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    {{ $listingUnit->listingImages->count() }} @lang('images')
                                    @lang('for') {{ $general->cur_sym . $listingUnit->price }}
                                </label>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn button w-100 myGuestDownloadButton"><i
                                        class="fas fa-download mx-2"></i>@lang('Download zip')</button>
                            </div>
                        </form>

                        <div class="type">
                            <div class="details">
                                <i class="fas fa-certificate"></i>
                                <h6 title="{{ strip_tags($listingUnit->building->copyright_description) }}">
                                    @lang('Copy Information')</h6>
                            </div>
                            <div class="details">
                                <i class="fas fa-sign-in-alt"></i>
                                <h6>@lang('Sign In first to buy image')</h6>
                            </div>
                            <div class="details">
                                <i class="fas fa-file"></i>
                                <h6>@lang('Collection by:') {{ $listingUnit->userable->username }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <div class="short--preview d-flex flex-wrap gap-5">
                    <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-3">
                        @foreach ($listingUnit->listingImages ?? [] as $image)
                            <div class="thumb">
                                <img src="{{ findWatermarkOrMainImagePath($image,'listing_asset_image') }}"
                                    alt="image">
                            </div>
                        @endforeach
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
                                    @lang('Details')
                                </button>
                            </h2>
                            <div id="collapse-details" class="accordion-collapse collapse"
                                aria-labelledby="headingListingImageList" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    @php
                                        echo $listingUnit->description;
                                    @endphp
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingMoreListingImageList">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-List" aria-expanded="true"
                                    aria-controls="headingMoreListingImageList">
                                    @lang('More Listing from') {{ $listingUnit->building->name }}
                                </button>
                            </h2>
                            <div id="collapse-List" class="accordion-collapse collapse show"
                                aria-labelledby="headingMoreListingImageList" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    @php
                                        echo $listingUnit->building->description;
                                    @endphp
                                    <div class="accordion-thumb--slider my-4">
                                        @foreach ($buildingListingImages ?? [] as $data)
                                            <div class="thumb-main">
                                                <img
                                                    src=" {{ getImage(getFilePath('listing_asset_image') . '/' . $data['first_image']) }}"alt="image">
                                                <div
                                                    class="d-flex flex-column justify-content-center align-items-center mt-3">

                                                    <h5 class="">{{ $data['unit_number'] }}</h5>
                                                    <a href="{{ route('condo.building.listing.images', [slug($data['county']), slug($data['neighborhood']), slug($data['building']), slug($data['unit_number']), $data['id']]) }}"
                                                        class="btn button">
                                                        @lang('View all images')
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="mb-4">
                                @php
                                    echo $listingUnit->building->description;
                                @endphp
                            </div>
                            <a href="{{ route('condo.building.details', building_listing_unit_route_params($listingUnit)) }}"
                                class="d-flex flex-wrap gap-3">
                                @foreach ($groupedImagesByCategory ?? [] as $group)
                                    <div class="thumb">
                                        <img
                                            src="{{ getImage(getFilePath('building_watermark') . '/watermark_' . $group['first_image']) }}"alt="image">
                                        <div
                                            class="content d-flex flex-column justify-content-center align-items-center my-2 border-end">
                                            <h6 class="m-0">{{ __($group['category_name']) }}</h6>
                                            <h6 class="m-0">{{ $group['image_count'] }}</h6>
                                            <h6 class="m-0">@lang('IMAGES')</h6>
                                        </div>
                                    </div>
                                @endforeach
                            </a>

                            <div class="d-flex justify-content-center mt-3">
                                <a href="{{ route('condo.building.details', building_listing_unit_route_params($listingUnit)) }}"
                                    class="btn button">
                                    @lang('View all images')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (isset($sections))
        @if ($sections->secs != null)
            @foreach (json_decode($sections->secs) as $sec)
                @include($activeTemplate . 'sections.' . $sec)
            @endforeach
        @endif
    @endif
@endsection

@push('style')
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
@endpush

@push('script')
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
                url: "{{ route('user.mark.wishlist') }}",
                data: {
                    id: id,
                    type: type,
                },
                method: "GET",
                success: function(data) {
                    if (data.status == true) {
                        var innerData = `<i class="fas fa-heart text--base"></i>@lang('Added')`;
                        button.html(innerData);
                        Toast.fire({
                            icon: 'success',
                            title: 'Successfully set this image to your wishlist.'
                        })
                        return false;
                    }

                    if (data.status == false) {
                        var innerData = `<i class="fas fa-heart"></i>@lang('Add')`;
                        button.html(innerData);
                        Toast.fire({
                            icon: 'success',
                            title: 'Successfully removed this image from your wishlist.'
                        })
                        return false;
                    }

                    if (data.auth == false) {
                        window.location.href = "{{ route('user.login') }}";
                    }
                },
                error: function(xhr, status, error) {},
            });

        });
    </script>
@endpush
