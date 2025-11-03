@php
    $banner = getContent('banner.content', true);
    $neighborhoods = App\Models\Neighborhood::with(['buildings', 'county'])
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
    @php
        // Carrega todas as imagens da pasta de banners (bannerOne)
        $dirRel = getFilePath('bannerOne');
        $docRoot = rtrim(dirname(base_path()), DIRECTORY_SEPARATOR);
        $dirAbs = $docRoot . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $dirRel);
        $files = [];
        if (is_dir($dirAbs)) {
            foreach (['*.jpg', '*.jpeg', '*.png', '*.webp'] as $pat) {
                $files = array_merge($files, glob($dirAbs . DIRECTORY_SEPARATOR . $pat));
            }
        }
        $heroImages = collect($files)->map(fn($p) => basename($p))->filter()->unique()->values();
        if ($heroImages->isEmpty() && !empty($banner->data_values->theme_two_banner)) {
            $heroImages = collect([$banner->data_values->theme_two_banner]);
        }
        if ($heroImages->count() === 1) {
            $heroImages = $heroImages->concat([$heroImages->first()]);
        }
    @endphp

    <section id="heroCarousel" class="banner-section-two carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <!-- Indicadores (4 pontos fixos com ativo rotativo) -->
        <div class="carousel-indicators" id="heroIndicators">
            @for ($i = 0; $i < 4; $i++)
                <button type="button" class="{{ $i === 0 ? 'active' : '' }}" data-virtual-index="{{ $i }}"
                    aria-current="{{ $i === 0 ? 'true' : 'false' }}" aria-label="Indicator {{ $i + 1 }}"></button>
            @endfor
        </div>

        <!-- Slides (apenas backgrounds) -->
        <div class="carousel-inner">
            @foreach ($heroImages as $img)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="banner-thumb bg-img bg-overlay py-120" data-background="{{ getImage($dirRel . '/' . $img) }}">
                        <!-- Conteúdo movido para fora para ficar estático -->
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Conteúdo estático posicionado sobre o carousel -->
        <div class="hero-static-content">
            <div class="content mb-4 wow animate__animated animate__fadeInUp" data-wow-delay="0.6s">
                <h3>{{ __($banner->data_values->heading) }}</h3>
                <p>{{ __($banner->data_values->subheading) }}</p>
            </div>

            <div class="hero-search">
                <form id="myForm" class="hero-search__form" action="{{ route('search.building') }}" method="GET">
                    <span class="hero-search__icon"><i class="fas fa-search"></i></span>
                    <input id="searchInput" type="text" name="search" class="form--control hero-search__input"
                        value="{{ old('search') }}" placeholder="Search for building">
                </form>
            </div>
        </div>

        <!-- Controles -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </section>
    <!--========================== Banner Section End ==========================-->
@endif

<!-- <section class="top-categories-container pb-100">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-5">
                <div class="tc-copy">
                    @php($tc = getContent('top_categories.content', true))
                    <h3>{{ __($tc->data_values->heading ?? 'Stand out with better visuals') }}</h3>
                    <p>{{ __($tc->data_values->subheading_primary ?? 'Discover premium images crafted for real estate professionals. From drone shots to interiors and floor plans  all organized by building and neighborhood.') }}</p>
                    <p class="mb-4">{{ __($tc->data_values->subheading_secondary ?? 'Stand out from the competition with stunning, ready-to-use visuals.') }}</p>
                    <a href="{{ $tc->data_values->button_link ?? route('condo.building') }}" class="btn button">{{ __($tc->data_values->button_text ?? 'Explore all buildings') }}</a>
                    <a href="{{ route('condo.building') }}" class="btn button">Explore all buildings</a>
                    <div class="tc-inline-controls mt-3">
                        <button class="tc-nav-btn" type="button" data-bs-target="#categoriesCarousel"
                            data-bs-slide="prev" aria-label="Previous">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div class="tc-indicators">
                            @foreach ($neighborhoods as $item)
                                <button type="button" data-bs-target="#categoriesCarousel"
                                    data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"
                                    aria-current="{{ $loop->first ? 'true' : 'false' }}"
                                    aria-label="Slide {{ $loop->iteration }}"></button>
                            @endforeach
                        </div>
                        <button class="tc-nav-btn" type="button" data-bs-target="#categoriesCarousel"
                            data-bs-slide="next" aria-label="Next">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div id="categoriesCarousel" class="carousel slide tc-carousel" data-bs-ride="carousel"
                    data-bs-interval="6000">
                    <div class="carousel-inner">
                        @foreach ($neighborhoods as $item)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <a href="{{ route('neighborhood.details', ['county' => slug($item->county->name), 'slug' => slug($item->name), 'id' => $item->id]) }}"
                                    class="tc-card d-block">
                                    <img class="tc-card__img"
                                        src="{{ getImage(getFilePath('neighborhood') . '/' . $item->image) }}"
                                        alt="{{ $item->name }}">
                                    <div class="tc-card__label">{{ __($item->name) }}</div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->

@push('script')
    @push('script')
        <script>
            $(document).ready(function () {
                'use strict';
                $('#searchInput').keypress(function (e) {
                    if (e.which === 13) {
                        e.preventDefault();
                        $('#myForm').submit();
                    }
                });
            });

            // Indicators: 4 dots fixed, active cycles modulo 4
            document.addEventListener('DOMContentLoaded', function () {
                const carouselEl = document.querySelector('#heroCarousel');
                if (!carouselEl) return;
                const bsCarousel = bootstrap.Carousel.getOrCreateInstance(carouselEl);
                const indicators = Array.from(document.querySelectorAll('#heroIndicators button'));
                const slides = carouselEl.querySelectorAll('.carousel-item');
                const lastIndex = Math.max(0, slides.length - 1);

                function setActiveByIndex(index) {
                    const activeDot = index % 4;
                    indicators.forEach((btn, i) => {
                        const isActive = i === activeDot;
                        btn.classList.toggle('active', isActive);
                        btn.setAttribute('aria-current', isActive ? 'true' : 'false');
                    });
                }

                carouselEl.addEventListener('slid.bs.carousel', function (evt) {
                    const index = evt.to ?? Array.from(slides).indexOf(carouselEl.querySelector('.carousel-item.active'));
                    setActiveByIndex(index);
                });

                indicators.forEach((btn, i) => {
                    btn.addEventListener('click', function () {
                        const active = carouselEl.querySelector('.carousel-item.active');
                        const currentIndex = Array.from(slides).indexOf(active);
                        const groupStart = currentIndex - (currentIndex % 4);
                        const target = Math.min(groupStart + i, lastIndex);
                        bsCarousel.to(target);
                    });
                });
            });
        </script>
    @endpush
@endpush

