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
                ->orderBy('name', 'asc') // Sempre alfabética
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
                                // Contar imagens do building (incluindo capa)
                                $imagesCount = 0;
                                if ($item->buildingImages) {
                                    $imagesCount += $item->buildingImages->count();
                                }
                                // Adicionar imagem de capa se existir
                                if ($item->image) {
                                    $imagesCount += 1;
                                }
                                
                                // Aplicar regra image vs images
                                $imageKey = countImagesWithRule($imagesCount);
                                
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
                                
                                // Contar imagens de todos os buildings do neighborhood
                                $imagesCount = 0;
                                if ($item->buildings) {
                                    foreach ($item->buildings as $building) {
                                        if ($building->buildingImages) {
                                            $imagesCount += $building->buildingImages->count();
                                        }
                                        // Adicionar imagem de capa do building se existir
                                        if ($building->image) {
                                            $imagesCount += 1;
                                        }
                                    }
                                }
                                
                                // Aplicar regra image vs images
                                $imageKey = ($imagesCount === 1) ? 'image' : 'images';
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
                                        {{ ($imagesCount === 1) ? 'image' : 'images' }}</span>
                                    <span class="sep" aria-hidden="true"></span>
                                    <span class="meta-right">{{ $metaRight }}
                                        {{ \Illuminate\Support\Str::plural('Listing', $metaRight) }}</span>
                                @else
                                    <span class="meta-left">{{ $buildingsCount }}
                                        {{ \Illuminate\Support\Str::plural('Building', $buildingsCount) }}</span>
                                    <span class="sep" aria-hidden="true"></span>
                                    <span class="meta-right">{{ $imagesCount }}
                                        {{ ($imagesCount === 1) ? 'image' : 'images' }}</span>
                                @endif
                            </div>
                        @endif
                    </a>
                </div>
            @endforeach
        </div>

        <div class="text-center mb-3">
            <button id="load-more-btn" class="btn btn-outline-primary" data-current-limit="{{ $limit }}" data-type="{{ $type }}">More</button>
        </div>

        <div class="text-center">
            <a href="{{ $buttonLink }}" class="btn button">{{ __($buttonText) }}</a>
        </div>
    </div>
</section>

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.getElementById('load-more-btn');
    const container = document.getElementById('listing-cards-container');
    if (!loadMoreBtn || !container) return;

    let currentLimit = parseInt(loadMoreBtn.dataset.currentLimit);
    const type = loadMoreBtn.dataset.type;

    loadMoreBtn.addEventListener('click', function() {
        // Buildings: +3, Neighborhoods: +3
        currentLimit += 3;
        loadMoreBtn.disabled = true;
        loadMoreBtn.textContent = 'Loading...';

        const endpoint = type === 'buildings' ? '/condo-building' : '/neighborhood';
        const orderParam = type === 'buildings' ? '&order=asc' : '';
        fetch(endpoint + '?limit=' + currentLimit + orderParam, {
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
            loadMoreBtn.dataset.currentLimit = currentLimit;
            loadMoreBtn.disabled = false;
            loadMoreBtn.textContent = 'More';
            // If no more items, disable button
            if (data.length < currentLimit) {
                loadMoreBtn.disabled = true;
                loadMoreBtn.textContent = 'No more items';
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
            
            // Count all building images including cover image
            let totalImagesCount = 0;
            
            // Add cover image if exists
            if (item.image) {
                totalImagesCount += 1;
            }
            
            // Add building images
            const buildingImagesCount = item.building_images ? item.building_images.length : 
                                      (item.buildingImages ? item.buildingImages.length : 0);
            totalImagesCount += buildingImagesCount;
            
            // Add listing unit images
            if (item.building_listing_units) {
                item.building_listing_units.forEach(unit => {
                    const listingImagesCount = unit.listing_images ? unit.listing_images.length : 0;
                    totalImagesCount += listingImagesCount;
                });
            } else if (item.buildingListingUnits) {
                item.buildingListingUnits.forEach(unit => {
                    const listingImagesCount = unit.listing_images ? unit.listing_images.length : 0;
                    totalImagesCount += listingImagesCount;
                });
            }
            
            // Count listing units
            const listingUnitsCount = item.building_listing_units ? item.building_listing_units.length : 
                                    (item.buildingListingUnits ? item.buildingListingUnits.length : 0);
            
            // Apply image/images rule
            const imagesText = totalImagesCount === 1 ? 'image' : 'images';
            const listingsText = listingUnitsCount === 1 ? 'listing' : 'listings';

            return `
                <div class="col-12 col-sm-6 col-lg-4">
                    <a href="${cardHref}" class="neigh-card d-block with-meta">
                        <img class="neigh-card__img" src="${imageSrc}" alt="${label}">
                        <div class="neigh-card__label">${label}</div>
                        <div class="neigh-card__meta">
                            <span class="meta-left">${totalImagesCount} ${imagesText}</span>
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
            
            // Calculate total images count following the same pattern as PHP backend
            let totalImagesCount = 0;
            
            // Add neighborhood cover image if exists
            if (item.image) {
                totalImagesCount += 1;
            }
            
            if (item.buildings) {
                item.buildings.forEach(building => {
                    // Add building cover image
                    if (building.image) {
                        totalImagesCount += 1;
                    }
                    
                    // Add building images
                    const buildingImagesCount = building.building_images ? building.building_images.length : 
                                              (building.buildingImages ? building.buildingImages.length : 0);
                    totalImagesCount += buildingImagesCount;
                    
                    // Add listing images
                    if (building.building_listing_units) {
                        building.building_listing_units.forEach(unit => {
                            const listingImagesCount = unit.listing_images ? unit.listing_images.length : 0;
                            totalImagesCount += listingImagesCount;
                        });
                    } else if (building.buildingListingUnits) {
                        building.buildingListingUnits.forEach(unit => {
                            const listingImagesCount = unit.listing_images ? unit.listing_images.length : 0;
                            totalImagesCount += listingImagesCount;
                        });
                    }
                });
            }
            
            // Apply image/images rule consistently
            const imagesText = totalImagesCount === 1 ? 'image' : 'images';
            const buildingsText = buildingsCount === 1 ? 'building' : 'buildings';

            return `
                <div class="col-12 col-sm-6 col-lg-4">
                    <a href="${cardHref}" class="neigh-card d-block with-meta">
                        <img class="neigh-card__img" src="${imageSrc}" alt="${label}">
                        <div class="neigh-card__label">${label}</div>
                        <div class="neigh-card__meta">
                            <span class="meta-left">${buildingsCount} ${buildingsText}</span>
                            <span class="sep" aria-hidden="true"></span>
                            <span class="meta-right">${totalImagesCount} ${imagesText}</span>
                        </div>
                    </a>
                </div>
            `;
        }
    }
});
</script>
@endpush
