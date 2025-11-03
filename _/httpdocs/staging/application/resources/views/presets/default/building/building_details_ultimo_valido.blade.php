@extends($activeTemplate . 'layouts.frontend')
@section('content')

<!-- Hero Building Section -->
<section class="neigh-hero">
    <div class="neigh-hero__bg"
        style="background-image:url('{{ getImage(getFilePath('building') . '/' . $building->image) }}')"></div>
    <div class="neigh-hero__content">
        <div class="neigh-hero__breadcrumb">
            <span class="breadcrumb-home">Home</span>
            <span class="breadcrumb-pipe"></span>
            <span class="breadcrumb-county">{{ $building->neighborhood->county->name }}</span>
            <span class="breadcrumb-pipe"></span>
            <span class="breadcrumb-section">{{ $building->neighborhood->name }}</span>
            <span class="breadcrumb-pipe"></span>
            <span class="breadcrumb-current">{{ $building->name }}</span>
        </div>
        <div class="neigh-hero__featured">Featured Building</div>
        <h1 class="neigh-hero__title">{{ __($building->name) }}</h1>
        <a href="#building-images" class="neigh-hero__btn">
            <span class="btn-text">See "{{ __($building->name) }}"</span>
            <div class="btn-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14" fill="none"
                    class="arrow-svg">
                    <path d="M12.5 2L1.5 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M6.5 1H12.5C12.9714 1 13.2071 1 13.3536 1.14645C13.5 1.29289 13.5 1.5286 13.5 2V8"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
        </a>
    </div>
</section>

<!-- Professional Real Estate Photography -->
@include('presets.default.sections.building_visuals', ['building' => $building])

<!-- How it works -->
@include('presets.default.sections.work_process')

<!-- All Images for [Building Name] -->
<section class="building-images-showcase" id="building-images">
    <div class="container">
        <!-- Title -->
        <div class="showcase-header mb-5">
            <h2 class="showcase-title">All images for {{ $building->name }}</h2>
        </div>

        <!-- Images Grid -->
        <div class="images-grid mb-5">
            @php
                // Usar imagens padrão do diretório building_images_default
                $defaultImages = [
                    'image1.png',
                    'image2.png',
                    'image5.png'
                ];
            @endphp

            @foreach($defaultImages as $index => $imageName)
                <div class="grid-item">
                    <div class="showcase-image-card">
                        <div class="showcase-image"
                            style="background-image: url('{{ asset('assets/images/building_images_default/' . $imageName) }}');"
                            role="img" aria-label="{{ $building->name }} Image {{ $index + 1 }}">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Download Card Centered - Layout Figma -->
        <div class="showcase-download-section">
            <div class="showcase-download-card">
                <!-- Primeira parte (esquerda) - Textos centralizados -->
                <div class="download-info">
                    <h3 class="download-title">Download Image Collection</h3>
                    <p class="download-subtitle">Perfect for listings, brochures, and social media.</p>
                </div>

                <!-- Segunda parte (central) - VAZIA -->
                <div class="download-spacer"></div>

                <!-- Terceira parte (direita) - Dividida em 2 rows -->
                <div class="download-right-section">
                    <!-- Primeira row da terceira parte -->
                    <div class="download-pricing">
                        <div class="download-price">${{ $building->price ?? '49' }}</div>
                        <div class="download-details">
                            <div class="download-count">{{ $building->buildingImages->count() ?? '29' }} images</div>
                            <div class="download-description">High-res images of {{ $building->name }}, ready to
                                impress.
                            </div>
                        </div>
                    </div>

                    <!-- Segunda row da terceira parte -->
                    <form action="{{ route('user.condo.building.payment') }}" method="POST" class="download-form">
                        @csrf
                        <input type="hidden" name="condo_building_id" value="{{ $building->id }}">
                        <input type="hidden" name="payment" value="2">
                        <button type="submit" class="download-btn">Buy</button>
                    </form>
                </div>
            </div>
        </div>
</section>

<!-- Building Information Sections -->
<section class="building-info-sections">
    <div class="container">
        <!-- Footage -->
        <div class="info-section">
            <div class="info-section__header">
                <h3>Footage</h3>
                <button class="info-section__toggle">+</button>
            </div>
            <div class="info-section__content" style="display: none;">
                <p>Building footage information will be displayed here.</p>
            </div>
        </div>

        <!-- Renderings -->
        <div class="info-section">
            <div class="info-section__header">
                <h3>Renderings</h3>
                <button class="info-section__toggle">+</button>
            </div>
            <div class="info-section__content" style="display: none;">
                <p>Building renderings will be displayed here.</p>
            </div>
        </div>

        <!-- Social media -->
        <div class="info-section">
            <div class="info-section__header">
                <h3>Social media</h3>
                <button class="info-section__toggle">+</button>
            </div>
            <div class="info-section__content" style="display: none;">
                <p>Social media content will be displayed here.</p>
            </div>
        </div>

        <!-- Lobby -->
        <div class="info-section">
            <div class="info-section__header">
                <h3>Lobby</h3>
                <button class="info-section__toggle">+</button>
            </div>
            <div class="info-section__content" style="display: none;">
                <p>Lobby images and information will be displayed here.</p>
            </div>
        </div>

        <!-- Amenities -->
        <div class="info-section">
            <div class="info-section__header">
                <h3>Amenities</h3>
                <button class="info-section__toggle">+</button>
            </div>
            <div class="info-section__content" style="display: none;">
                <p>Building amenities information will be displayed here.</p>
            </div>
        </div>

        <!-- Drone Aerial -->
        <div class="info-section">
            <div class="info-section__header">
                <h3>Drone Aerial</h3>
                <button class="info-section__toggle">+</button>
            </div>
            <div class="info-section__content" style="display: none;">
                <p>Drone aerial images will be displayed here.</p>
            </div>
        </div>

        <!-- Listing Images -->
        <div class="info-section">
            <div class="info-section__header">
                <h3>Listing Images</h3>
                <button class="info-section__toggle">+</button>
            </div>
            <div class="info-section__content" style="display: none;">
                <p>Listing images will be displayed here.</p>
            </div>
        </div>

        <!-- Details -->
        <div class="info-section">
            <div class="info-section__header">
                <h3>Details</h3>
                <button class="info-section__toggle">+</button>
            </div>
            <div class="info-section__content" style="display: none;">
                <p>Building details and specifications will be displayed here.</p>
            </div>
        </div>
    </div>
</section>

<!-- Visual compilation CTA -->
@include('presets.default.sections.visual_compilation')
</section>



<!-- JavaScript for collapsible sections -->
@push('script')
    <script>
        // Toggle collapsible info sections
        document.querySelectorAll('.info-section__header').forEach(header => {
            header.addEventListener('click', function () {
                const content = this.nextElementSibling;
                const toggle = this.querySelector('.info-section__toggle');

                if (content.style.display === 'none' || content.style.display === '') {
                    content.style.display = 'block';
                    toggle.textContent = '-';
                    toggle.classList.add('active');
                } else {
                    content.style.display = 'none';
                    toggle.textContent = '+';
                    toggle.classList.remove('active');
                }
            });
        });

        // Slick Slider Initialization Function
        function initSlickSlider(slider) {
            if (slider.length && !slider.hasClass('slick-initialized')) {
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
                    }]
                });
            }
        }

        // Initialize sliders when document is ready
        $(document).ready(function () {
            initSlickSlider($('.accordion-thumb--slider:visible'));
        });

        // Initialize sliders when accordion is opened
        $('.accordion-button').on('click', function () {
            const targetCollapse = $(this).data('bs-target');
            setTimeout(() => {
                const slider = $(targetCollapse).find('.accordion-thumb--slider');
                initSlickSlider(slider);
            }, 300); // Aumentei o timeout para dar tempo da animação do accordion
        });
    </script>

    <script>
        $(document).on('click', '.markWishlist', function (e) {
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
                success: function (data) {
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
                error: function (xhr, status, error) { },
            });

        });
    </script>
@endpush