<?php
    $config = $listingConfig ?? [];
    $type = $config['type'] ?? 'buildings';
    $heading = $config['heading'] ?? ($type === 'buildings' ? 'All buildings' : 'All neighborhoods / cities');
    $subheading = $config['subheading'] ?? null;
    $buttonText = $config['button_text'] ?? ($type === 'buildings' ? 'Explore all buildings' : 'Explore all neighborhoods');
    $buttonLink = $config['button_link'] ?? ($type === 'buildings' ? route('condo.building') : url('/neighborhood'));
    $showMeta = (bool)($config['show_meta'] ?? false);
    $searchAction = $config['search_action'] ?? ($type === 'buildings' ? route('search.building') : url('/neighborhood'));
    $limit = isset($config['limit']) ? max(1, (int)$config['limit']) : ($type === 'buildings' ? 6 : 6);

    // Generate unique IDs to avoid conflicts when multiple listing components exist on same page
    $sectionId = $config['section_id'] ?? uniqid('listing_');
    $componentId = $type === 'buildings' ? 'buildings' : 'neighborhoods';
    $uniqueId = $sectionId . '-' . $componentId;

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
?>
 
<section class="neigh-section" data-listing-component="<?php echo e($uniqueId); ?>">
    <div class="container">
        <div class="section-head d-flex align-items-center justify-content-between">
            <div>
                <h2><?php echo e(__($heading)); ?></h2>
                <?php if(!empty($subheading)): ?>
                    <p class="section-subtitle"><?php echo e(__($subheading)); ?></p>
                <?php endif; ?>
            </div>
            <div class="list-search d-flex align-items-center listing-search-form" data-search-form="<?php echo e($uniqueId); ?>" data-search-endpoint="<?php echo e($searchAction); ?>">
                <!-- <span class="list-search__icon"><i class="fas fa-search"></i></span> -->
                <input type="text" name="q" class="list-search__input" placeholder="Search" autocomplete="off" data-search-input="<?php echo e($uniqueId); ?>">
                <button type="button" class="list-search__clear-btn" aria-label="Clear search" style="display: none;" data-clear-btn="<?php echo e($uniqueId); ?>">
                    <i class="fas fa-times"></i>
                </button>
                <button type="button" class="list-search__submit-btn" aria-label="Search" data-search-btn="<?php echo e($uniqueId); ?>">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <div class="row g-4 mb-5" id="listing-cards-container-<?php echo e($uniqueId); ?>" data-container="<?php echo e($uniqueId); ?>">
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-12 col-sm-6 col-lg-4">
                    <?php
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
                    ?>
                    <a href="<?php echo e($cardHref); ?>" class="neigh-card d-block <?php echo e($showMeta ? 'with-meta' : ''); ?>">
                        <img class="neigh-card__img" src="<?php echo e($imageSrc); ?>" alt="<?php echo e(__($label)); ?>">
                        <div class="neigh-card__label"><?php echo e(__($label)); ?></div>
                        <?php if($showMeta): ?>
                            <div class="neigh-card__meta">
                                <?php if($type === 'buildings'): ?>
                                    <span class="meta-left"><?php echo e($imagesCount); ?>

                                        <?php echo e(\Illuminate\Support\Str::plural('Image', $imagesCount)); ?></span>
                                    <span class="sep" aria-hidden="true"></span>
                                    <span class="meta-right"><?php echo e($metaRight); ?>

                                        <?php echo e(\Illuminate\Support\Str::plural('Listing', $metaRight)); ?></span>
                                <?php else: ?>
                                    <span class="meta-left"><?php echo e($buildingsCount); ?>

                                        <?php echo e(\Illuminate\Support\Str::plural('Building', $buildingsCount)); ?></span>
                                    <span class="sep" aria-hidden="true"></span>
                                    <span class="meta-right"><?php echo e($imagesCount); ?>

                                        <?php echo e(\Illuminate\Support\Str::plural('image', $imagesCount)); ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if($showMoreButton && !empty($loadMoreEndpoint)): ?>
            <div class="text-center mb-3">
                <button
                    id="load-more-<?php echo e($uniqueId); ?>"
                    class="btn button"
                    data-current-limit="<?php echo e($limit); ?>"
                    data-type="<?php echo e($type); ?>"
                    data-endpoint="<?php echo e($loadMoreEndpoint); ?>"
                    data-increment="<?php echo e($loadMoreIncrement); ?>"
                    data-params='<?php echo json_encode($loadMoreParams, 15, 512) ?>'
                    data-load-more-btn="<?php echo e($uniqueId); ?>"
                    <?php if(!is_null($loadMoreMaxLimit)): ?> data-max-limit="<?php echo e($loadMoreMaxLimit); ?>" <?php endif; ?>
                >More</button>
            </div>
        <?php endif; ?>

        <?php if(! $showMoreButton): ?>
            <div class="text-center">
                <a href="<?php echo e($buttonLink); ?>" class="btn button"><?php echo e(__($buttonText)); ?></a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php if($showMoreButton && !empty($loadMoreEndpoint)): ?>
<?php $__env->startPush('style'); ?>
<style>
/* Estilos para o botão de busca */
.list-search {
    position: relative;
}

.list-search__submit-btn,
.list-search__clear-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #6c757d;
    padding: 8px;
    cursor: pointer;
    border-radius: 4px;
    transition: all 0.2s ease;
    z-index: 2;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.list-search__submit-btn {
    right: 8px;
}

.list-search__clear-btn {
    right: 48px;
}

.list-search__submit-btn:hover,
.list-search__clear-btn:hover {
    color: #0E80BD;
    background: rgba(14, 128, 189, 0.1);
}

.list-search__clear-btn:hover {
    color: #dc3545;
    background: rgba(220, 53, 69, 0.1);
}

.list-search__submit-btn:active,
.list-search__clear-btn:active {
    transform: translateY(-50%) scale(0.95);
}

.list-search__input {
    padding-right: 88px !important; /* Espaço para ambos os botões */
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('[data-listing-component]').forEach(function (component) {
    const uniqueId  = component.getAttribute('data-listing-component');
    const container = document.getElementById('listing-cards-container-' + uniqueId);

    // Pega elementos do SEARCH (sempre inicializa, com ou sem More)
    const searchForm   = component.querySelector('[data-search-form="' + uniqueId + '"]');
    const searchInput  = component.querySelector('[data-search-input="' + uniqueId + '"]');
    const searchBtn    = component.querySelector('[data-search-btn="' + uniqueId + '"]');
    const clearBtn     = component.querySelector('[data-clear-btn="' + uniqueId + '"]');
    const searchAction = searchForm ? (searchForm.getAttribute('data-search-endpoint') || '') : '';

    // Elementos do MORE (podem não existir)
    const loadMoreBtn  = document.getElementById('load-more-' + uniqueId);
    const type         = (loadMoreBtn?.dataset.type) || component.getAttribute('data-type') || 'buildings';
    const listEndpoint = (loadMoreBtn?.getAttribute('data-endpoint')) || (type === 'buildings' ? '/condo-building' : '/neighborhood');
    let currentLimit   = parseInt(loadMoreBtn?.dataset.currentLimit || '6', 10);
    const increment    = parseInt(loadMoreBtn?.getAttribute('data-increment') || '3', 10);
    const maxLimit     = parseInt(loadMoreBtn?.getAttribute('data-max-limit') || '0', 10);
    let isSearchActive = false;

    // ---------- SEARCH ----------
    if (searchForm && searchInput && searchBtn && clearBtn && container) {
      const toggleClear = () => {
        clearBtn.style.display = searchInput.value.trim() ? 'flex' : 'none';
      };
      searchInput.addEventListener('input', toggleClear);
      toggleClear();

      const performSearch = async () => {
        const q = searchInput.value.trim();
        if (!q) return;

        // Durante busca, esconde More (se existir)
        if (loadMoreBtn) loadMoreBtn.style.display = 'none';
        isSearchActive = true;

        try {
          // Usa SEMPRE o search_action definido no Blade
          const url = new URL(searchAction || (type === 'buildings' ? '/search-building' : '/neighborhood'), window.location.origin);

          // Parâmetro correto por tipo/rota
          // - buildings → search.building → 'search'
          // - neighborhoods → neighborhood → 'q'
          if ((searchAction && searchAction.indexOf('/search') !== -1) || type === 'buildings') {
            url.searchParams.set('search', q);
          } else {
            url.searchParams.set('q', q);
          }

          const res  = await fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
          const data = await res.json();

          container.innerHTML = '';

          // /search-building (AJAX) retorna { status, buildings: [] }
          if (data && Array.isArray(data)) {
            data.forEach(item => container.insertAdjacentHTML('beforeend', generateCardHtml(item, type)));
          } else if (data && Array.isArray(data.buildings)) {
            data.buildings.forEach(item => container.insertAdjacentHTML('beforeend', generateCardHtml(item, type)));
          } else {
            container.innerHTML = `<div class="col-12"><p class="text-center text-muted">No results found for "${q}"</p></div>`;
          }
        } catch (e) {
          console.error('Search error', e);
          container.innerHTML = '<div class="col-12"><p class="text-center text-danger">Error loading search results</p></div>';
        }
      };

      const reloadInitialList = async () => {
        // Volta para a listagem normal (limit + endpoint de lista)
        try {
          const url = new URL(listEndpoint, window.location.origin);
          url.searchParams.set('limit', String(currentLimit));
          const res  = await fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
          const data = await res.json();

          container.innerHTML = '';
          if (Array.isArray(data) && data.length) {
            data.forEach(item => container.insertAdjacentHTML('beforeend', generateCardHtml(item, type)));
            if (loadMoreBtn) {
              // Decide se volta a mostrar o botão
              if ((maxLimit === 0 || currentLimit < maxLimit) && data.length >= currentLimit) {
                loadMoreBtn.style.display = 'block';
                loadMoreBtn.disabled = false;
                loadMoreBtn.textContent = 'More';
              } else {
                loadMoreBtn.style.display = 'none';
              }
            }
          } else {
            container.innerHTML = '<div class="col-12"><p class="text-center text-muted">No items found</p></div>';
            if (loadMoreBtn) loadMoreBtn.style.display = 'none';
          }
        } catch (e) {
          console.error('Reload list error', e);
        }
      };

      const clearSearch = async () => {
        searchInput.value = '';
        toggleClear();
        isSearchActive = false;
        currentLimit = parseInt(loadMoreBtn?.dataset.currentLimit || '6', 10);
        await reloadInitialList();
      };

      searchBtn.addEventListener('click', performSearch);
      clearBtn.addEventListener('click', clearSearch);
    }

    // ---------- MORE ----------
    if (!loadMoreBtn || !container) return;

    loadMoreBtn.addEventListener('click', function () {
      if (isSearchActive) return; // não pagina durante a busca

      const nextLimit = maxLimit > 0 ? Math.min(currentLimit + increment, maxLimit) : currentLimit + increment;
      if (nextLimit === currentLimit) {
        loadMoreBtn.disabled = true;
        loadMoreBtn.textContent = 'No more items';
        return;
      }

      loadMoreBtn.disabled = true;
      loadMoreBtn.textContent = 'Loading...';

      const url = new URL(listEndpoint, window.location.origin);
      url.searchParams.set('limit', String(nextLimit));

      fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.json())
        .then(data => {
          container.innerHTML = '';
          data.forEach(item => container.insertAdjacentHTML('beforeend', generateCardHtml(item, type)));
          currentLimit = nextLimit;
          loadMoreBtn.dataset.currentLimit = String(currentLimit);
          const noMoreData = data.length < currentLimit;

          if ((maxLimit > 0 && currentLimit >= maxLimit) || noMoreData) {
            loadMoreBtn.disabled = true;
            loadMoreBtn.textContent = 'No more items';
          } else {
            loadMoreBtn.disabled = false;
            loadMoreBtn.textContent = 'More';
          }
          document.dispatchEvent(new CustomEvent('contentLoaded'));
        })
        .catch(err => {
          console.error('Load more error', err);
          loadMoreBtn.disabled = false;
          loadMoreBtn.textContent = 'More';
        });
    });
  });

  // ------- mesma função de cards -------
  function generateCardHtml(item, type) {
    const slug = (str) => String(str || '').toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');

    if (type === 'buildings') {
      const countySlug   = item?.neighborhood?.county ? slug(item.neighborhood.county.name) : '';
      const neighSlug    = item?.neighborhood ? slug(item.neighborhood.name) : '';
      const buildingSlug = slug(item.name);
      const cardHref     = `/${countySlug}/${neighSlug}/${buildingSlug}/${item.id}`;
      const label        = item.name || '';
      const imageSrc     = item.image ? `/assets/images/building/${item.image}` : '/placeholder-image/350x300';

      const buildingImagesCount = item.building_images?.length ?? item.buildingImages?.length ?? 0;
      const listingUnitsCount   = item.building_listing_units?.length ?? item.buildingListingUnits?.length ?? 0;

      const imagesText   = buildingImagesCount === 1 ? 'Image' : 'Images';
      const listingsText = listingUnitsCount   === 1 ? 'Listing' : 'Listings';

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
        </div>`;
    } else {
      const countySlug   = item.county ? slug(item.county.name) : '';
      const neighSlug    = slug(item.name);
      const cardHref     = `/${countySlug}/${neighSlug}/${item.id}`;
      const label        = item.name || '';
      const imageSrc     = item.image ? `/assets/images/neighborhood/${item.image}` : '/placeholder-image/350x300';
      const buildingsCnt = item.buildings ? item.buildings.length : 0;

      let imagesCnt = 0;
      if (item.buildings) {
        item.buildings.forEach(b => {
          imagesCnt += (b.building_images?.length ?? b.buildingImages?.length ?? 0);
          if (b.building_listing_units) {
            b.building_listing_units.forEach(u => {
              imagesCnt += (u.listing_images?.length ?? 0);
            });
          }
        });
      }

      const imagesText    = imagesCnt === 1 ? 'image' : 'images';
      const buildingsText = buildingsCnt === 1 ? 'Building' : 'Buildings';

      return `
        <div class="col-12 col-sm-6 col-lg-4">
          <a href="${cardHref}" class="neigh-card d-block with-meta">
            <img class="neigh-card__img" src="${imageSrc}" alt="${label}">
            <div class="neigh-card__label">${label}</div>
            <div class="neigh-card__meta">
              <span class="meta-left">${buildingsCnt} ${buildingsText}</span>
              <span class="sep" aria-hidden="true"></span>
              <span class="meta-right">${imagesCnt} ${imagesText}</span>
            </div>
          </a>
        </div>`;
    }
  }
});
</script>

<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH C:\Users\victo\Desktop\pedro\condoImage\_\httpdocs\staging\application\resources\views/presets/default/sections/partials/listing_cards.blade.php ENDPATH**/ ?>