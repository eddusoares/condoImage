@php
    $config = $listingConfig ?? [];
    $type = $config['type'] ?? 'buildings';
    $heading = $config['heading'] ?? ($type === 'buildings' ? 'All buildings' : 'All neighborhoods / cities');
    $subheading = $config['subheading'] ?? null;
    $buttonText = $config['button_text'] ?? ($type === 'buildings' ? 'Explore all buildings' : 'Explore all neighborhoods');
    $buttonLink = $config['button_link'] ?? ($type === 'buildings' ? route('condo.building') : url('/neighborhood'));
    $showMeta = (bool)($config['show_meta'] ?? false);
    $searchAction = $config['search_action'] ?? ($type === 'buildings' ? route('search.building') : url('/neighborhood'));
    $limit = isset($config['limit']) ? max(1, (int)$config['limit']) : ($type === 'buildings' ? 9 : 6);

    $items = $config['items'] ?? null;

    if (!$items) {
        if ($type === 'buildings') {
            $items = App\Models\Building::with(['neighborhood', 'buildingImages', 'buildingListingUnits'])
                ->where('status', 1)
                ->latest()
                ->take($limit)
                ->get();
        } else {
            $items = App\Models\Neighborhood::with(['county', 'buildings', 'buildings.buildingImages'])
                ->where('status', 1)
                ->latest()
                ->take($limit)
                ->get();
        }
    }
@endphp

<section class="neigh-section">
    <div class="container">
        <div class="section-head d-flex align-items-center justify-content-between">
            <div>
                <h2>{{ __($heading) }}</h2>
                @if (!empty($subheading))
                    <p class="section-subtitle">{{ __($subheading) }}</p>
                @endif
            </div>
            <form class="list-search d-flex align-items-center" action="{{ $searchAction }}" method="GET">
                <span class="list-search__icon"><i class="fas fa-search"></i></span>
                <input type="text" name="search" class="list-search__input" placeholder="Search"
                       value="{{ request('search') }}">
            </form>
        </div>

        <div class="row g-4 mb-5">
            @foreach ($items as $item)
                <div class="col-12 col-sm-6 col-lg-4">
                    @php
                        $cardHref = '#';
                        $label = '';
                        $imageSrc = '';
                        $imagesCount = 0;
                        $metaRight = 0;
                        $buildingsCount = 0;

                        if ($type === 'buildings') {
                            $cardHref = route('condo.building.details', building_route_params($item));
                            $label = $item->name;
                            $imageSrc = $item->image
                                ? getImage(getFilePath('building') . '/' . $item->image)
                                : route('placeholder.image', '350x300');

                            if ($showMeta) {
                                $imagesCount = $item->buildingImages ? $item->buildingImages->count() : ($item->building_images_count ?? 0);
                                $metaRight = $item->buildingListingUnits ? $item->buildingListingUnits->count() : ($item->building_listing_units_count ?? 0);
                            }
                        } else {
                            $cardHref = route('neighborhood.details', [
                                'county' => slug(optional($item->county)->name ?? ''),
                                'slug' => slug($item->name),
                                'id' => $item->id,
                            ]);
                            $label = $item->name;
                            $imageSrc = $item->image
                                ? getImage(getFilePath('neighborhood') . '/' . $item->image)
                                : route('placeholder.image', '350x300');

                            if ($showMeta) {
                                $buildingsCount = $item->buildings ? $item->buildings->count() : 0;
                                $imagesCount = 0;
                                if ($item->buildings) {
                                    foreach ($item->buildings as $building) {
                                        $imagesCount += $building->buildingImages ? $building->buildingImages->count() : ($building->building_images_count ?? 0);
                                    }
                                }
                            }
                        }
                    @endphp
                    <a href="{{ $cardHref }}" class="neigh-card d-block {{ $showMeta ? 'with-meta' : '' }}">
                        <img class="neigh-card__img" src="{{ $imageSrc }}" alt="{{ __($label) }}">
                        <div class="neigh-card__label">{{ __($label) }}</div>
                        @if ($showMeta)
                            <div class="neigh-card__meta">
                                @if ($type === 'buildings')
                                    <span class="meta-left">{{ $imagesCount }}
                                        {{ \Illuminate\Support\Str::plural('Image', $imagesCount) }}</span>
                                    <span class="sep" aria-hidden="true"></span>
                                    <span class="meta-right">{{ $metaRight }}
                                        {{ \Illuminate\Support\Str::plural('Listing', $metaRight) }}</span>
                                @else
                                    <span class="meta-left">{{ $buildingsCount }}
                                        {{ \Illuminate\Support\Str::plural('Building', $buildingsCount) }}</span>
                                    <span class="sep" aria-hidden="true"></span>
                                    <span class="meta-right">{{ $imagesCount }}
                                        {{ \Illuminate\Support\Str::plural('image', $imagesCount) }}</span>
                                @endif
                            </div>
                        @endif
                    </a>
                </div>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ $buttonLink }}" class="btn button">{{ __($buttonText) }}</a>
        </div>
    </div>
</section>
