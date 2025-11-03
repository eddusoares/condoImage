@extends($activeTemplate . 'layouts.frontend')
@section('content')

    @php
        $featured = $neighborhoods->first();
        $featuredUrl = $featured ? route('neighborhood.details', ['county' => slug($featured->county->name), 'slug' => slug($featured->name), 'id' => $featured->id]) : '#';
    @endphp

    <!-- Hero Neighborhood -->
    @if ($featured)
        <section class="neigh-hero">
            <div class="neigh-hero__bg"
                style="background-image:url('{{ getImage(getFilePath('neighborhood') . '/' . $featured->image) }}')"></div>
            <div class="neigh-hero__content">
                <div class="neigh-hero__breadcrumb">
                    <span class="breadcrumb-home">Home</span>
                    <span class="breadcrumb-pipe"></span>
                    <span class="breadcrumb-current">Neighborhood listing</span>
                </div>
                <div class="neigh-hero__featured">Featured</div>
                <h1 class="neigh-hero__title">{{ __($featured->name) }}</h1>
                <a href="{{ $featuredUrl }}" class="neigh-hero__btn">
                    <span class="btn-text">See "{{ __($featured->name) }}"</span>
                    <div class="btn-arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14" fill="none" class="arrow-svg">
                            <path d="M12.5 2L1.5 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M6.5 1H12.5C12.9714 1 13.2071 1 13.3536 1.14645C13.5 1.29289 13.5 1.5286 13.5 2V8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </a>
            </div>
        </section>
    @endif

    <div class="neigh-page">
        <!-- Stand out with better visuals -->
        @include('presets.default.sections.top_categories', ['neighborhoods' => $neighborhoods])

        <!-- All Neighborhoods -->
        @include('presets.default.sections.neighborhood_gallery', [
            'showMeta' => true,
            'customTitle' => 'All Neighborhoods'
        ])
    </div>

    <!-- How it works -->
    @include('presets.default.sections.work_process')

    <!-- Visual compilation CTA -->
    @include('presets.default.sections.visual_compilation')

@endsection
