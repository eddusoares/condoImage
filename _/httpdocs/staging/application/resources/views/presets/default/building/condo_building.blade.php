@extends($activeTemplate . 'layouts.frontend')
@section('content')

    @php
        $slides = $buildings->take(10);
        $allNeighborhoods = $allNeighborhoods ?? collect();
    @endphp

    @if ($slides->count())
        <section id="condoHeroCarousel" class="banner-section-two carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
            <div class="carousel-indicators" id="condoHeroIndicators">
                @for ($i = 0; $i < 4; $i++)
                    <button type="button" class="{{ $i === 0 ? 'active' : '' }}" data-virtual-index="{{ $i }}"
                        aria-current="{{ $i === 0 ? 'true' : 'false' }}" aria-label="Indicator {{ $i + 1 }}"></button>
                @endfor
            </div>

            <div class="carousel-inner">
                @foreach ($slides as $item)
                    @php
                        $itemUrl = route('condo.building.details', building_route_params($item));
                    @endphp
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}"
                        data-condo-name="{{ __($item->name) }}"
                        data-condo-url="{{ $itemUrl }}">
                        <div class="banner-thumb bg-img bg-overlay py-120" data-background="{{ getImage(getFilePath('building') . '/' . $item->image) }}"></div>
                    </div>
                @endforeach
            </div>

            <div class="hero-static-content">
                <div class="neigh-hero__content">
                    <div class="neigh-hero__breadcrumb">
                        <a href="{{ route('home') }}" class="breadcrumb-home">Home</a>
                        <span class="breadcrumb-pipe"></span>
                        <span class="breadcrumb-current">Condo building</span>
                    </div>
                    <div class="neigh-hero__featured">Featured</div>
                    <h1 class="neigh-hero__title" id="condoHeroTitle"></h1>
                    <a href="#" class="neigh-hero__btn" id="condoHeroBtn">
                        <span class="btn-text" id="condoHeroBtnText"></span>
                        <div class="btn-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 15 14" fill="none" class="arrow-svg">
                                <path d="M12.5 2L1.5 13" stroke="#414145" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M6.5 1H12.5C12.9714 1 13.2071 1 13.3536 1.14645C13.5 1.29289 13.5 1.5286 13.5 2V8" stroke="#414145" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </a>
                </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#condoHeroCarousel" data-bs-slide="prev" aria-label="Previous">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#condoHeroCarousel" data-bs-slide="next" aria-label="Next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </section>
    @endif

    @if (isset($sections) && $sections && $sections->secs)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @else
        <div class="neigh-page">
            <!-- All Buildings -->
            @include($activeTemplate . 'sections.category', [
                'type' => 'neighborhoods',
                'showMeta' => true,
                'items' => $allNeighborhoods,
                'defaultTitle' => 'All neighborhoods',
                'defaultButtonText' => 'Explore all neighborhoods',
                'defaultButtonLink' => route('neighborhood'),
            ])
        </div>

        <!-- How it works -->
        @include('presets.default.sections.work_process')

        <!-- Visual compilation CTA -->
        @include('presets.default.sections.visual_compilation')
    @endif

@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const carouselEl = document.querySelector('#condoHeroCarousel');
            if (!carouselEl) return;
            const indicators = Array.from(document.querySelectorAll('#condoHeroIndicators button'));
            const slides = carouselEl.querySelectorAll('.carousel-item');
            const titleEl = document.getElementById('condoHeroTitle');
            const btnEl = document.getElementById('condoHeroBtn');
            const btnTextEl = document.getElementById('condoHeroBtnText');

            function applyFromSlide(index) {
                const active = slides[index];
                if (!active) return;
                const name = active.getAttribute('data-condo-name') || '';
                const url = active.getAttribute('data-condo-url') || '#';
                titleEl.textContent = name;
                btnEl.setAttribute('href', url);
                btnTextEl.textContent = `See "${name}"`;
                const activeDot = index % 4;
                indicators.forEach((btn, i) => {
                    const isActive = i === activeDot;
                    btn.classList.toggle('active', isActive);
                    btn.setAttribute('aria-current', isActive ? 'true' : 'false');
                });
            }

            applyFromSlide(0);
            const bsCarousel = bootstrap.Carousel.getOrCreateInstance(carouselEl);
            carouselEl.addEventListener('slid.bs.carousel', function (evt) {
                const index = evt.to ?? Array.from(slides).indexOf(carouselEl.querySelector('.carousel-item.active'));
                applyFromSlide(index);
            });
        });
    </script>
@endpush
