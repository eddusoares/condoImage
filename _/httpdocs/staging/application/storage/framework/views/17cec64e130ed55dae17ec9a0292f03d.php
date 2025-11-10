<?php
    $config = $listingConfig ?? [];
    $type = $config['type'] ?? 'buildings';
    $heading = $config['heading'] ?? ($type === 'buildings' ? 'All buildings' : 'All neighborhoods / cities');
    $subheading = $config['subheading'] ?? null;
    $buttonText = $config['button_text'] ?? ($type === 'buildings' ? 'Explore all buildings' : 'Explore all neighborhoods');
    // CORREÇÃO: Remover fallback hardcoded e usar diretamente o valor da configuração
    $buttonLink = $config['button_link'] ?? '#';
    $rawSearchAction = $config['search_action'] ?? '#';
    if ($rawSearchAction instanceof \Illuminate\Support\Collection) {
      $rawSearchAction = $rawSearchAction->first();
    }
    $searchAction = $rawSearchAction ? (string) $rawSearchAction : '#';

    $rawSearchParam = $config['search_param'] ?? null;
    $searchParam = is_string($rawSearchParam) && $rawSearchParam !== ''
      ? $rawSearchParam
      : ($type === 'buildings' ? 'search' : 'q');

    $searchDefaults = $config['search_defaults'] ?? [];
    if ($searchDefaults instanceof \Illuminate\Support\Collection) {
      $searchDefaults = $searchDefaults->toArray();
    }
    if (!is_array($searchDefaults)) {
      $searchDefaults = [];
    }

    $rawListEndpoint = $config['list_endpoint'] ?? null;
    if ($rawListEndpoint instanceof \Illuminate\Support\Collection) {
      $rawListEndpoint = $rawListEndpoint->first();
    }
    $listEndpoint = $rawListEndpoint ? (string) $rawListEndpoint : '';
    if ($listEndpoint === '') {
      $listEndpoint = $type === 'buildings' ? baseRoute('condo.building') : baseRoute('neighborhood');
    }

    $limit = isset($config['limit']) ? max(1, (int)$config['limit']) : ($type === 'buildings' ? 6 : 6);
    $initialLimitValue = $limit ?: 6;

    // Generate unique IDs to avoid conflicts when multiple listing components exist on same page
    $sectionId = $config['section_id'] ?? uniqid('listing_');
    $componentId = $type === 'buildings' ? 'buildings' : 'neighborhoods';
    $uniqueId = $sectionId . '-' . $componentId;

  $showMeta = (bool) ($config['show_meta'] ?? false);

  $items = $config['items'] ?? null;

  if ($items instanceof \Illuminate\Support\Collection) {
    $items = $items->all();
  }

  if (empty($items)) {
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
  $initialMobileState = $showMoreButton ? 'collapsed' : 'expanded';

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

  $loadMoreEndpoint = $loadMoreConfig['endpoint'] ?? ($type === 'buildings' ? baseRoute('condo.building') : baseRoute('neighborhood'));
        $loadMoreParams = $loadMoreConfig['params'] ?? [];
        $loadMoreIncrement = isset($loadMoreConfig['increment']) ? max(1, (int) $loadMoreConfig['increment']) : 3;
        $loadMoreMaxLimit = isset($loadMoreConfig['max_limit']) ? (int) $loadMoreConfig['max_limit'] : null;
    }
?>
 
<section class="neigh-section" data-listing-component="<?php echo e($uniqueId); ?>" data-type="<?php echo e($type); ?>" data-mobile-state="<?php echo e($initialMobileState); ?>" data-initial-limit="<?php echo e($initialLimitValue); ?>" data-list-endpoint="<?php echo e($listEndpoint); ?>">
    <div class="container">
        <div class="section-head d-flex align-items-center justify-content-between">
            <div>
                <h2><?php echo e(__($heading)); ?></h2>
                <?php if(!empty($subheading)): ?>
                    <p class="section-subtitle"><?php echo e(__($subheading)); ?></p>
                <?php endif; ?>
            </div>
            <div class="list-search d-flex align-items-center listing-search-form" data-search-form="<?php echo e($uniqueId); ?>" data-search-endpoint="<?php echo e($searchAction); ?>" data-search-param="<?php echo e($searchParam); ?>" data-search-defaults='<?php echo json_encode($searchDefaults, 15, 512) ?>'>
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
                <div class="col-12 col-sm-6 col-lg-4" data-item-id="<?php echo e($type); ?>-<?php echo e($item->id); ?>">
                    <?php
                        $cardHref = '#';
                        $label = '';
                        $imageSrc = '';
                        $imagesCount = 0;
                        $metaRight = 0;
                        $buildingsCount = 0;

                        if ($type === 'buildings') {
                            $cardHref = baseRoute('condo.building.details', building_route_params($item));
                            $label = $item->name;
                            $imageSrc = $item->image
                                ? getImage(getFilePath('building') . '/' . $item->image)
                                : route('placeholder.image', '350x300');

                            if ($showMeta) {
                                $imagesCount = $item->buildingImages ? $item->buildingImages->count() : ($item->building_images_count ?? 0);
                                $metaRight = $item->buildingListingUnits ? $item->buildingListingUnits->count() : ($item->building_listing_units_count ?? 0);
                            }
                        } else {
                            $cardHref = baseRoute('neighborhood.details', [
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
                    data-initial-limit="<?php echo e($initialLimitValue); ?>"
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

<?php if (! $__env->hasRenderedOnce('listing_cards_styles')): $__env->markAsRenderedOnce('listing_cards_styles'); ?>
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
<?php endif; ?>

<?php if (! $__env->hasRenderedOnce('listing_cards_script')): $__env->markAsRenderedOnce('listing_cards_script'); ?>
  <?php $__env->startPush('script'); ?>
  <script>
  const rawBaseUrl = typeof window !== 'undefined' && window.BASE_URL ? String(window.BASE_URL) : '';

  const computeBaseInfo = () => {
    const defaultOrigin = window.location.origin.replace(/\/+$/, '');

    if (rawBaseUrl) {
      try {
        const parsed = new URL(rawBaseUrl);
        const origin = `${parsed.protocol}//${parsed.host}`;
        const basePath = parsed.pathname.replace(/^\/+|\/+$/g, '');
        const prefix = basePath ? `${origin}/${basePath}` : origin;
        return { origin, path: basePath, prefix };
      } catch (err) {
        console.warn('Invalid BASE_URL value detected', err);
      }
    }

    return { origin: defaultOrigin, path: '', prefix: defaultOrigin };
  };

  const BASE_INFO = computeBaseInfo();

  const splitExtras = (value) => {
    let pathOnly = String(value || '');
    let fragment = '';
    let query = '';

    const hashIndex = pathOnly.indexOf('#');
    if (hashIndex !== -1) {
      fragment = pathOnly.substring(hashIndex);
      pathOnly = pathOnly.substring(0, hashIndex);
    }

    const queryIndex = pathOnly.indexOf('?');
    if (queryIndex !== -1) {
      query = pathOnly.substring(queryIndex);
      pathOnly = pathOnly.substring(0, queryIndex);
    }

    return { pathOnly, suffix: query + fragment };
  };

  const stripBaseFromPath = (pathValue) => {
    const trimmed = String(pathValue || '').replace(/^\/+/, '');
    const basePath = BASE_INFO.path;

    if (!basePath) {
      return trimmed;
    }

    if (trimmed === basePath) {
      return '';
    }

    const basePrefix = `${basePath}/`;
    if (trimmed.startsWith(basePrefix)) {
      return trimmed.slice(basePrefix.length);
    }

    return trimmed;
  };

  const buildInternalUrl = (value) => {
    if (!value) {
      return BASE_INFO.prefix;
    }

    if (typeof value === 'string' && /^https?:\/\//i.test(value)) {
      return value;
    }

    const { pathOnly, suffix } = splitExtras(value);
    const relative = stripBaseFromPath(pathOnly);
    const prefix = BASE_INFO.prefix.replace(/\/+$/, '');
    const cleanRelative = String(relative || '').replace(/^\/+/, '');
    const finalUrl = cleanRelative ? `${prefix}/${cleanRelative}` : prefix;

    return finalUrl + suffix;
  };

  const buildAssetUrl = (path) => {
    if (!path) {
      return '';
    }
    return buildInternalUrl(path);
  };

  document.addEventListener('DOMContentLoaded', function () {
  const parseParams = (raw) => {
    if (!raw) return {};
    try {
      return JSON.parse(raw);
    } catch (err) {
      console.warn('Unable to parse load more params', err);
      return {};
    }
  };

  const buildItemKey = (item, type) => `${type}-${item && item.id !== undefined ? item.id : ''}`;

  const getCardNodes = (container) => {
    if (!container) return [];
    return Array.from(container.children).filter(node => node.hasAttribute('data-item-id'));
  };

  const setButtonState = (btn, { hidden = false, disabled = false, label = 'More' } = {}) => {
    if (!btn) return;
    btn.style.display = hidden ? 'none' : '';
    btn.disabled = !!disabled;
    if (!hidden && label) {
      btn.textContent = label;
    }
  };

  const isMobileViewport = () => window.matchMedia('(max-width: 991.98px)').matches;

  const openMobileSearchSidebar = () => {
    const toggle = document.getElementById('navbarSearchToggle');
    if (!toggle) return false;
    toggle.click();
    return true;
  };

  document.querySelectorAll('[data-listing-component]').forEach(function (component) {
    const uniqueId  = component.getAttribute('data-listing-component');
    const container = document.getElementById('listing-cards-container-' + uniqueId);

  // Pega elementos do SEARCH (sempre inicializa, com ou sem More)
  const searchForm        = component.querySelector('[data-search-form="' + uniqueId + '"]');
  const searchInput       = component.querySelector('[data-search-input="' + uniqueId + '"]');
  const searchBtn         = component.querySelector('[data-search-btn="' + uniqueId + '"]');
  const clearBtn          = component.querySelector('[data-clear-btn="' + uniqueId + '"]');
  const searchAction      = searchForm ? (searchForm.getAttribute('data-search-endpoint') || '') : '';
    const searchParamAttr   = searchForm ? (searchForm.getAttribute('data-search-param') || '') : '';
    const searchDefaultsRaw = searchForm ? searchForm.getAttribute('data-search-defaults') : '';
    const parsedSearchDefaults = parseParams(searchDefaultsRaw);
    const searchDefaults    = parsedSearchDefaults && typeof parsedSearchDefaults === 'object' && !Array.isArray(parsedSearchDefaults)
      ? parsedSearchDefaults
      : {};

    // Elementos do MORE (podem não existir)
    const loadMoreBtn  = document.getElementById('load-more-' + uniqueId);
    const inferredType = component.getAttribute('data-type');
    const type         = inferredType || loadMoreBtn?.dataset.type || 'buildings';
    const resolvedSearchParam = searchParamAttr || (type === 'buildings' ? 'search' : 'q');
    
    // Usar as funções helper do PHP para gerar endpoints corretos
  const configuredListEndpoint = component.getAttribute('data-list-endpoint') || '';
  const listEndpoint = loadMoreBtn?.getAttribute('data-endpoint') || 
            configuredListEndpoint ||
            (type === 'buildings' ? '<?php echo e(baseUrl("condo-building")); ?>' : '<?php echo e(baseUrl("neighborhood")); ?>');
    const increment    = parseInt(loadMoreBtn?.getAttribute('data-increment') || '3', 10);
    const maxLimit     = parseInt(loadMoreBtn?.getAttribute('data-max-limit') || '0', 10);
  const rawBaseParams = loadMoreBtn ? parseParams(loadMoreBtn.getAttribute('data-params')) : {};
  const baseParams    = rawBaseParams && typeof rawBaseParams === 'object' && !Array.isArray(rawBaseParams) ? rawBaseParams : {};
    let initialLimit   = parseInt(component.getAttribute('data-initial-limit') || '0', 10);
    if (!Number.isFinite(initialLimit) || initialLimit <= 0) {
      const buttonInitial = loadMoreBtn ? parseInt(loadMoreBtn.getAttribute('data-current-limit') || '0', 10) : 0;
      if (Number.isFinite(buttonInitial) && buttonInitial > 0) {
        initialLimit = buttonInitial;
      } else {
        const initialCount = getCardNodes(container).length;
        const fallbackIncrement = Number.isFinite(increment) && increment > 0 ? increment : 6;
        initialLimit = initialCount > 0 ? initialCount : fallbackIncrement;
      }
    }
    if (initialLimit <= 0) {
      initialLimit = 6;
    }
    component.dataset.initialLimit = String(initialLimit);
    if (loadMoreBtn) {
      loadMoreBtn.dataset.initialLimit = String(initialLimit);
    }
    const initialMobileState = component.dataset.mobileState || 'expanded';
    let keepExpanded = initialMobileState === 'expanded';
    const applyMobileState = (state) => {
      component.dataset.mobileState = state;
    };

    let currentLimit   = getCardNodes(container).length;
    let isSearchActive = false;

    if (loadMoreBtn) {
      loadMoreBtn.dataset.type = type;
      loadMoreBtn.dataset.currentLimit = String(currentLimit);
      if (maxLimit > 0 && currentLimit >= maxLimit) {
        setButtonState(loadMoreBtn, { hidden: false, disabled: true, label: 'No more items' });
      } else {
        setButtonState(loadMoreBtn, { hidden: false, disabled: false, label: 'More' });
      }
    }

    const getExistingIds = () => new Set(getCardNodes(container).map(node => node.getAttribute('data-item-id')));

    const buildUrl = (limitValue, offsetValue = 0) => {
      const normalizedEndpoint = buildInternalUrl(listEndpoint);
      const url = new URL(normalizedEndpoint);
      const params = { ...baseParams };
      if (typeof limitValue === 'number' && Number.isFinite(limitValue)) {
        params.limit = limitValue;
      }
      if (offsetValue) {
        params.offset = offsetValue;
      }
      Object.entries(params).forEach(([key, value]) => {
        if (value === undefined || value === null || value === '') return;
        url.searchParams.set(key, value);
      });
      return url;
    };

    const resetButtonAfterSearch = () => {
      if (!loadMoreBtn) return;
      const totalCards = getCardNodes(container).length;
      currentLimit = totalCards;
      loadMoreBtn.dataset.currentLimit = String(currentLimit);
      if (maxLimit > 0 && totalCards >= maxLimit) {
        setButtonState(loadMoreBtn, { hidden: false, disabled: true, label: 'No more items' });
      } else {
        setButtonState(loadMoreBtn, { hidden: false, disabled: false, label: 'More' });
      }
      applyMobileState(keepExpanded ? 'expanded' : initialMobileState);
    };

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

        if (loadMoreBtn) setButtonState(loadMoreBtn, { hidden: true });
        isSearchActive = true;

        try {
          const fallbackEndpoint = type === 'buildings' ? '<?php echo e(baseUrl("search")); ?>' : '<?php echo e(baseUrl("neighborhood")); ?>';
          const endpointSource = searchAction && searchAction !== '#' ? searchAction : fallbackEndpoint;
          const url = new URL(buildInternalUrl(endpointSource));

          url.searchParams.delete('offset');
          url.searchParams.delete('limit');
          url.searchParams.delete(resolvedSearchParam);
          url.searchParams.set(resolvedSearchParam, q);

          Object.entries(searchDefaults).forEach(([key, value]) => {
            if (value === undefined || value === null || value === '') {
              return;
            }
            if (key === resolvedSearchParam) {
              return;
            }
            url.searchParams.set(key, value);
          });

          const res  = await fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
          const data = await res.json();

          container.innerHTML = '';

          if (data && Array.isArray(data)) {
            data.forEach(item => container.insertAdjacentHTML('beforeend', generateCardHtml(item, type)));
          } else if (data && Array.isArray(data.buildings)) {
            data.buildings.forEach(item => container.insertAdjacentHTML('beforeend', generateCardHtml(item, type)));
          } else {
            container.innerHTML = `<div class="col-12"><p class="text-center text-muted">No results found for "${q}"</p></div>`;
          }
          applyMobileState('expanded');
        } catch (e) {
          console.error('Search error', e);
          container.innerHTML = '<div class="col-12"><p class="text-center text-danger">Error loading search results</p></div>';
          applyMobileState('expanded');
        }
      };

      const reloadInitialList = async () => {
        try {
          const fallbackCount = getCardNodes(container).length || initialLimit || increment;
          const desiredLimit  = maxLimit > 0 ? Math.min(initialLimit, maxLimit) : initialLimit;
          const requested = desiredLimit > 0 ? desiredLimit : fallbackCount;
          if (loadMoreBtn) {
            loadMoreBtn.dataset.currentLimit = String(requested);
          }
          const url = buildUrl(requested, 0);
          const res  = await fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
          const data = await res.json();

          container.innerHTML = '';
          if (Array.isArray(data) && data.length) {
            data.forEach(item => container.insertAdjacentHTML('beforeend', generateCardHtml(item, type)));
          } else {
            container.innerHTML = '<div class="col-12"><p class="text-center text-muted">No items found</p></div>';
          }
          applyMobileState(keepExpanded ? 'expanded' : initialMobileState);
          if (loadMoreBtn) {
            resetButtonAfterSearch();
          }
        } catch (e) {
          console.error('Reload list error', e);
        }
      };

      const clearSearch = async () => {
        searchInput.value = '';
        toggleClear();
        isSearchActive = false;
        await reloadInitialList();
      };

      searchBtn.addEventListener('click', function (event) {
        if (isMobileViewport()) {
          const opened = openMobileSearchSidebar();
          if (opened) {
            event.preventDefault();
            event.stopPropagation();
            return;
          }
        }
        performSearch();
      });
      clearBtn.addEventListener('click', clearSearch);
    }

    // ---------- MORE ----------
    if (!loadMoreBtn || !container) return;

    loadMoreBtn.addEventListener('click', function () {
      if (isSearchActive) return;

      const existingCards = getCardNodes(container);
      const existingCount = existingCards.length;
      const remainingAllowed = maxLimit > 0 ? Math.max(0, maxLimit - existingCount) : Number.POSITIVE_INFINITY;
      const requestSize = maxLimit > 0 ? Math.min(increment, remainingAllowed) : increment;

      if (!Number.isFinite(requestSize) || requestSize <= 0) {
        setButtonState(loadMoreBtn, { hidden: false, disabled: true, label: 'No more items' });
        return;
      }

      setButtonState(loadMoreBtn, { hidden: false, disabled: true, label: 'Loading...' });

      const url = buildUrl(requestSize, existingCount);

      fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.json())
        .then(data => {
          if (!Array.isArray(data) || !data.length) {
            setButtonState(loadMoreBtn, { hidden: false, disabled: true, label: 'No more items' });
            return;
          }

          const existingIds = getExistingIds();
          let appended = 0;

          data.forEach(item => {
            const key = buildItemKey(item, type);
            if (!existingIds.has(key)) {
              container.insertAdjacentHTML('beforeend', generateCardHtml(item, type));
              existingIds.add(key);
              appended += 1;
            }
          });

          currentLimit = getCardNodes(container).length;
          loadMoreBtn.dataset.currentLimit = String(currentLimit);

          const reachedMax = maxLimit > 0 && currentLimit >= maxLimit;
          const noMoreFromServer = appended < requestSize || data.length < requestSize;

          if (reachedMax || noMoreFromServer) {
            setButtonState(loadMoreBtn, { hidden: false, disabled: true, label: 'No more items' });
          } else {
            setButtonState(loadMoreBtn, { hidden: false, disabled: false, label: 'More' });
          }

          if (appended > 0) {
            keepExpanded = true;
            applyMobileState('expanded');
            document.dispatchEvent(new CustomEvent('contentLoaded'));
          }
        })
        .catch(err => {
          console.error('Load more error', err);
          setButtonState(loadMoreBtn, { hidden: false, disabled: false, label: 'More' });
        });
    });
  });

  // ------- mesma função de cards -------
  function generateCardHtml(item, type) {
    const slug = (str) => String(str || '').toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
    const sanitizeSegments = (segments) => segments.filter((segment) => {
      if (segment === undefined || segment === null) {
        return false;
      }
      const value = String(segment);
      return value.length > 0;
    });

    if (type === 'buildings') {
      const countySlug   = item?.neighborhood?.county ? slug(item.neighborhood.county.name) : '';
      const neighSlug    = item?.neighborhood ? slug(item.neighborhood.name) : '';
      const buildingSlug = slug(item.name);
      const cardSegments = sanitizeSegments([countySlug, neighSlug, buildingSlug, item?.id]);
      const cardHref     = buildInternalUrl(cardSegments.join('/'));
      const label        = item.name || '';
      
      // Construir URL da imagem considerando BASE_URL
      const imageSrc = item.image 
        ? buildAssetUrl(`assets/images/building/${item.image}`)
        : buildAssetUrl('placeholder-image/350x300');

      const buildingImagesCount = item.building_images?.length ?? item.buildingImages?.length ?? 0;
      const listingUnitsCount   = item.building_listing_units?.length ?? item.buildingListingUnits?.length ?? 0;

      const imagesText   = buildingImagesCount === 1 ? 'Image' : 'Images';
      const listingsText = listingUnitsCount   === 1 ? 'Listing' : 'Listings';

      return `
        <div class="col-12 col-sm-6 col-lg-4" data-item-id="${type}-${item.id}">
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
      const cardSegments = sanitizeSegments([countySlug, neighSlug, item?.id]);
      const cardHref     = buildInternalUrl(cardSegments.join('/'));
      const label        = item.name || '';
      
      // Construir URL da imagem considerando BASE_URL
      const imageSrc = item.image 
        ? buildAssetUrl(`assets/images/neighborhood/${item.image}`)
        : buildAssetUrl('placeholder-image/350x300');
      
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
        <div class="col-12 col-sm-6 col-lg-4" data-item-id="${type}-${item.id}">
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