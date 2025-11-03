@extends($activeTemplate . 'layouts.frontend')
@section('content')

    @php
        $featured = $neighborhood->buildings->first();
        $featuredUrl = $featured ? route('condo.building.details', building_route_params($featured)) : route('neighborhood');
    @endphp

    <!-- Hero Neighborhood -->
    <section class="neigh-hero">
        <div class="neigh-hero__bg"
            style="background-image:url('{{ getImage(getFilePath('neighborhood') . '/' . $neighborhood->image) }}')"></div>
        <div class="neigh-hero__content">
            <div class="neigh-hero__breadcrumb">
                <span class="breadcrumb-home">Home</span>
                <span class="breadcrumb-pipe"></span>
                <span class="breadcrumb-county">{{ $neighborhood->county->name }}</span>
                <span class="breadcrumb-pipe"></span>
                <span class="breadcrumb-section">Neighborhood</span>
                <span class="breadcrumb-pipe"></span>
                <span class="breadcrumb-current">{{ $neighborhood->name }}</span>
            </div>
            <div class="neigh-hero__featured">Featured</div>
            <h1 class="neigh-hero__title">{{ __($neighborhood->name) }}</h1>
            <a href="{{ $featuredUrl }}" class="neigh-hero__btn">
                <span class="btn-text">See "{{ __($neighborhood->name) }}"</span>
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

    <div class="neigh-page">
        <!-- Stand out with better visuals -->
        @include('presets.default.sections.top_categories', ['neighborhoods' => collect()])

        <!-- All Buildings in [Neighborhood Name] -->
        @include($activeTemplate . 'sections.category', ['showMeta' => true, 'customTitle' => 'All buildings in ' . $neighborhood->name, 'buildingsData' => $neighborhood->buildings])
    </div>

    <!-- How it works -->
    @include('presets.default.sections.work_process')

    <!-- Visual compilation CTA -->
    @include('presets.default.sections.visual_compilation')

@endsection