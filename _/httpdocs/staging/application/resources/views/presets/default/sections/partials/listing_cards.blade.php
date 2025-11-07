@php
    $config = $listingConfig ?? [];
    $type = $config['type'] ?? 'buildings';
    $heading = $config['heading'] ?? ($type === 'buildings' ? 'All buildings' : 'All neighborhoods / cities');
    $subheading = $config['subheading'] ?? null;
    $buttonText = $config['button_text'] ?? ($type === 'buildings' ? 'Explore all buildings' : 'Explore all neighborhoods');
    $buttonLink = $config['button_link'] ?? ($type === 'buildings' ? route('condo.building') : url('/neighborhood'));
    $showMeta = (bool)($config['show_meta'] ?? false);
    $searchAction = $config['search_action'] ?? ($type === 'buildings' ? route('search.building') : url('/neighborhood'));
    $limit = isset($config['limit']) ? max(1, (int)$config['limit']) : ($type === 'buildings' ? 6 : 6);

    $items = $config['items'] ?? null;

    if (!$items) {
        if ($type === 'buildings') {
            $items = App\Models\Building::with(['neighborhood', 'buildingImages', 'buildingListingUnits'])
                ->where('status', 1)
                ->orderBy('name', 'asc')
                ->take($limit)
                ->get();
        } else {
            $items = App\Models\Neighborhood::with(['county', 'buildings', 'buildings.buildingImages'])
                ->where('status', 1)
                ->orderBy('name', 'asc')
                ->take($limit)
                ->get();
        }
    }

    $showMoreButton = (bool) ($config['show_more_button'] ?? false);

    $loadMoreEndpoint = '';
    $loadMoreParams = [];
    $loadMoreIncrement = 3;
    $loadMoreMaxLimit = null;

    if ($showMoreButton) {
        $loadMoreConfig = $config['load_more'] ?? [];
        if ($loadMoreConfig instanceof \Illuminate\Support\Collection) {
            $loadMoreConfig = $loadMoreConfig->toArray();
        }
        if (!is_array($loadMoreConfig)) {
            $loadMoreConfig = [];
        }

        $loadMoreEndpoint = $loadMoreConfig['endpoint'] ?? ($type === 'buildings' ? route('condo.building') : route('neighborhood'));
        $loadMoreParams = $loadMoreConfig['params'] ?? [];
        $loadMoreIncrement = isset($loadMoreConfig['increment']) ? max(1, (int) $loadMoreConfig['increment']) : 3;
        $loadMoreMaxLimit = isset($loadMoreConfig['max_limit']) ? (int) $loadMoreConfig['max_limit'] : null;
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

        <div class="row g-4 mb-5" id="listing-cards-container">
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

        @if ($showMoreButton && !empty($loadMoreEndpoint))
            <div class="text-center mb-3">
                <button
                    id="load-more-neighborhoods"
                    class="btn button"
                    data-current-limit="{{ $limit }}"
                    data-type="{{ $type }}"
                    data-endpoint="{{ $loadMoreEndpoint }}"
                    data-increment="{{ $loadMoreIncrement }}"
                    data-params='@json($loadMoreParams)'
                    @if(!is_null($loadMoreMaxLimit)) data-max-limit="{{ $loadMoreMaxLimit }}" @endif
                >More</button>
            </div>
        @endif

        @if (! $showMoreButton)
            <div class="text-center">
                <a href="{{ $buttonLink }}" class="btn button">{{ __($buttonText) }}</a>
            </div>
        @endif
    </div>
</section>

@if ($showMoreButton && !empty($loadMoreEndpoint))
@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.getElementById('load-more-neighborhoods');
    const container = document.getElementById('listing-cards-container');
    if (!loadMoreBtn || !container) return;

    let currentLimit = parseInt(loadMoreBtn.dataset.currentLimit, 10);
    const type = loadMoreBtn.dataset.type;
    const endpointAttr = loadMoreBtn.getAttribute('data-endpoint');
    const endpoint = endpointAttr !== null && endpointAttr !== ''
        ? endpointAttr
        : (type === 'buildings' ? '/condo-building' : '/neighborhood');
    const incrementAttr = loadMoreBtn.getAttribute('data-increment');
    const increment = incrementAttr ? parseInt(incrementAttr, 10) : 3;
    const maxLimitAttr = loadMoreBtn.getAttribute('data-max-limit');
    const maxLimit = maxLimitAttr ? parseInt(maxLimitAttr, 10) : 0;
    let extraParams = {};

    if (!endpoint) {
        loadMoreBtn.disabled = true;
        return;
    }

    const paramsAttr = loadMoreBtn.getAttribute('data-params');
    if (paramsAttr) {
        try {
            extraParams = JSON.parse(paramsAttr);
        } catch (error) {
            console.warn('Invalid load more params JSON:', error);
            extraParams = {};
        }
    }

    loadMoreBtn.addEventListener('click', function() {
        const nextLimit = maxLimit > 0 ? Math.min(currentLimit + increment, maxLimit) : currentLimit + increment;

        if (nextLimit === currentLimit) {
            loadMoreBtn.disabled = true;
            loadMoreBtn.textContent = 'No more items';
            return;
        }

        loadMoreBtn.disabled = true;
        loadMoreBtn.textContent = 'Loading...';

        const requestUrl = new URL(endpoint, window.location.origin);
        requestUrl.searchParams.set('limit', nextLimit);
        Object.entries(extraParams).forEach(([key, value]) => {
            requestUrl.searchParams.set(key, value);
        });

        fetch(requestUrl.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Clear container and re-render all cards
            container.innerHTML = '';
            data.forEach(item => {
                const cardHtml = generateCardHtml(item, type);
                container.insertAdjacentHTML('beforeend', cardHtml);
            });
            currentLimit = nextLimit;
            loadMoreBtn.dataset.currentLimit = currentLimit;
            const noMoreData = data.length < currentLimit;

            if (maxLimit > 0 && currentLimit >= maxLimit) {
                loadMoreBtn.disabled = true;
                loadMoreBtn.textContent = 'No more items';
            } else if (noMoreData) {
                loadMoreBtn.disabled = true;
                loadMoreBtn.textContent = 'No more items';
            } else {
                loadMoreBtn.disabled = false;
                loadMoreBtn.textContent = 'More';
            }
            
            // Dispatch contentLoaded event for anchor navigation
            document.dispatchEvent(new CustomEvent('contentLoaded'));
        })
        .catch(error => {
            console.error('Error loading more items:', error);
            loadMoreBtn.disabled = false;
            loadMoreBtn.textContent = 'More';
        });
    });

    function generateCardHtml(item, type) {
        const slug = (str) => str.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
        
        if (type === 'buildings') {
            // Buildings logic
            const countySlug = item.neighborhood && item.neighborhood.county ? slug(item.neighborhood.county.name) : '';
            const neighSlug = item.neighborhood ? slug(item.neighborhood.name) : '';
            const buildingSlug = slug(item.name);
            const cardHref = `/${countySlug}/${neighSlug}/${buildingSlug}/${item.id}`;
            const label = item.name;
            const imageSrc = item.image ? `/assets/images/building/${item.image}` : '/placeholder-image/350x300';
            
            // Count building images
            const buildingImagesCount = item.building_images ? item.building_images.length : 
                                      (item.buildingImages ? item.buildingImages.length : 0);
            
            // Count listing units
            const listingUnitsCount = item.building_listing_units ? item.building_listing_units.length : 
                                    (item.buildingListingUnits ? item.buildingListingUnits.length : 0);
            
            // Apply pluralization
            const imagesText = buildingImagesCount === 1 ? 'Image' : 'Images';
            const listingsText = listingUnitsCount === 1 ? 'Listing' : 'Listings';

            return `
                <div class="col-12 col-sm-6 col-lg-4">
                    <a href="${cardHref}" class="neigh-card d-block with-meta">
                        <img class="neigh-card__img" src="${imageSrc}" alt="${label}">
                        <div class="neigh-card__label">${label}</div>
                        <div class="neigh-card__meta">
                            <span class="meta-left">${buildingImagesCount} ${imagesText}</span>
                            <span class="sep" aria-hidden="true"></span>
                            <span class="meta-right">${listingUnitsCount} ${listingsText}</span>
                        </div>
                    </a>
                </div>
            `;
        } else {
            // Neighborhoods logic
            const countySlug = item.county ? slug(item.county.name) : '';
            const neighSlug = slug(item.name);
            const cardHref = `/${countySlug}/${neighSlug}/${item.id}`;
            const label = item.name;
            const imageSrc = item.image ? `/assets/images/neighborhood/${item.image}` : '/placeholder-image/350x300';
            const buildingsCount = item.buildings ? item.buildings.length : 0;
            
            // Calculate images count the same way as PHP backend
            let imagesCount = 0;
            if (item.buildings) {
                item.buildings.forEach(building => {
                    // Building images
                    const buildingImagesCount = building.building_images ? building.building_images.length : 
                                              (building.buildingImages ? building.buildingImages.length : 0);
                    imagesCount += buildingImagesCount;
                    
                    // Listing images
                    if (building.building_listing_units) {
                        building.building_listing_units.forEach(unit => {
                            const listingImagesCount = unit.listing_images ? unit.listing_images.length : 0;
                            imagesCount += listingImagesCount;
                        });
                    }
                });
            }
            
            // Apply same pluralization logic as PHP Str::plural('image', $imagesCount)
            const imagesText = imagesCount === 1 ? 'image' : 'images';
            const buildingsText = buildingsCount === 1 ? 'Building' : 'Buildings';

            return `
                <div class="col-12 col-sm-6 col-lg-4">
                    <a href="${cardHref}" class="neigh-card d-block with-meta">
                        <img class="neigh-card__img" src="${imageSrc}" alt="${label}">
                        <div class="neigh-card__label">${label}</div>
                        <div class="neigh-card__meta">
                            <span class="meta-left">${buildingsCount} ${buildingsText}</span>
                            <span class="sep" aria-hidden="true"></span>
                            <span class="meta-right">${imagesCount} ${imagesText}</span>
                        </div>
                    </a>
                </div>
            `;
        }
    }
});
</script>
@endpush
@endif
