@extends($activeTemplate . 'layouts.frontend')
@section('content')

    @php
        $slides = $neighborhood->buildings->take(10);
        $neighborhoodUrl = route('neighborhood.details', ['county' => slug($neighborhood->county->name), 'slug' => slug($neighborhood->name), 'id' => $neighborhood->id]);
    @endphp

    <!-- Hero Neighborhood (carousel like other pages) -->
    <section id="neighDetailsHeroCarousel" class="banner-section-two carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
        <!-- Indicators -->
        <div class="carousel-indicators" id="neighDetailsHeroIndicators">
            @for ($i = 0; $i < 4; $i++)
                <button type="button" class="{{ $i === 0 ? 'active' : '' }}" data-virtual-index="{{ $i }}"
                    aria-current="{{ $i === 0 ? 'true' : 'false' }}" aria-label="Indicator {{ $i + 1 }}"></button>
            @endfor
        </div>

        <div class="carousel-inner">
            @if($slides->count())
                @foreach ($slides as $item)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="banner-thumb bg-img bg-overlay py-120" data-background="{{ getImage(getFilePath('building') . '/' . $item->image) }}"></div>
                    </div>
                @endforeach
            @else
                <!-- Fallback: duplicate neighborhood image to enable carousel -->
                @for($i=0;$i<2;$i++)
                    <div class="carousel-item {{ $i===0 ? 'active' : '' }}">
                        <div class="banner-thumb bg-img bg-overlay py-120" data-background="{{ getImage(getFilePath('neighborhood') . '/' . $neighborhood->image) }}"></div>
                    </div>
                @endfor
            @endif
        </div>

        <!-- Static overlay content -->
        <div class="hero-static-content">
            <div class="neigh-hero__content">
                <div class="neigh-hero__breadcrumb">
                    <a href="{{ route('home') }}" class="breadcrumb-home">Home</a>
                    <span class="breadcrumb-pipe"></span>
                    <a href="{{ route('county', ['slug' => slug($neighborhood->county->name), 'id' => $neighborhood->county->id]) }}" class="breadcrumb-county">{{ $neighborhood->county->name }}</a>
                    <span class="breadcrumb-pipe"></span>
                    <a href="{{ route('neighborhood') }}" class="breadcrumb-section">Neighborhood</a>
                    <span class="breadcrumb-pipe"></span>
                    <span class="breadcrumb-current">{{ $neighborhood->name }}</span>
                </div>
                <div class="neigh-hero__featured">Featured</div>
                <h1 class="neigh-hero__title">{{ __($neighborhood->name) }}</h1>
                <a href="{{ $neighborhoodUrl }}" class="neigh-hero__btn">
                    <span class="btn-text">See "{{ __($neighborhood->name) }}"</span>
                    <div class="btn-arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 15 14" fill="none" class="arrow-svg">
                            <path d="M12.5 2L1.5 13" stroke="#414145" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M6.5 1H12.5C12.9714 1 13.2071 1 13.3536 1.14645C13.5 1.29289 13.5 1.5286 13.5 2V8" stroke="#414145" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </a>
            </div>
        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#neighDetailsHeroCarousel" data-bs-slide="prev" aria-label="Previous">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#neighDetailsHeroCarousel" data-bs-slide="next" aria-label="Next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </section>

    @if (isset($sections) && $sections && $sections->secs)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @else
        <div class="neigh-page">
            <!-- All Buildings in [Neighborhood Name] -->
            @include($activeTemplate . 'sections.category', [
                'type' => 'buildings',
                'showMeta' => true,
                'buildingsData' => $neighborhood->buildings,
                'defaultTitle' => 'All buildings in :neighborhood',
                'defaultButtonText' => 'Explore all buildings',
                'defaultButtonLink' => route('condo.building'),
                'replacements' => [
                    ':neighborhood' => $neighborhood->name,
                    ':county' => $neighborhood->county->name,
                ],
            ])
        </div>

        <!-- Visual compilation CTA -->
        @include('presets.default.sections.visual_compilation')
    @endif

@endsection
