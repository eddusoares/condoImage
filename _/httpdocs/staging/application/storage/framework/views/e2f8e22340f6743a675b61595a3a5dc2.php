<?php
    $banner = getContent('banner.content', true);
    $neighborhoods = App\Models\Neighborhood::with(['buildings', 'county'])
        ->where('status', 1)
        ->orderByRaw('RAND()')
        ->latest()
        ->take(10)
        ->get();

    // Prepare banner search dataset early to avoid scope issues
    try {
        $bannerBuildings = App\Models\Building::with('neighborhood.county')
            ->where('status', 1)
            ->inRandomOrder()
            ->take(40)
            ->get();
        $bannerNeighborhoods = App\Models\Neighborhood::with('county')
            ->where('status', 1)
            ->inRandomOrder()
            ->take(40)
            ->get();
        $bannerSearchItems = collect()
            ->merge($bannerBuildings->map(fn($b) => [
                'type' => 'building',
                'name' => $b->name,
                'url' => baseRoute('condo.building.details', building_route_params($b)),
            ]))
            ->merge($bannerNeighborhoods->map(fn($n) => [
                'type' => 'neighborhood',
                'name' => $n->name,
                'url' => baseRoute('neighborhood.details', [
                    'county' => slug(optional($n->county)->name ?? ''),
                    'slug' => slug($n->name),
                    'id' => $n->id,
                ]),
            ]))
            ->shuffle()
            ->values();
    } catch (\Throwable $e) {
        // Fallback to empty array on failure (avoid breaking the view)
        $bannerSearchItems = collect();
        if (config('app.debug')) {
            // Log can be added here if needed: \Log::warning('Banner search dataset error: '.$e->getMessage());
        }
    }
?>
<!--========================== Banner Section Start ==========================-->
<?php if($general->theme == 1): ?>
    <section class="banner-section">
        <div class=" container">
            <div class="banner-thumb">
                <div class="row">
                    <div class="col-lg-6 col-12 my-auto">
                        <div class="content mb-4">
                            <h3><?php echo e(__($banner->data_values->heading)); ?></h3>
                            <p><?php echo e(__($banner->data_values->subheading)); ?></p>
                        </div>
                        <div class="d-flex">
                            <a href="<?php echo e($banner->data_values->button_one_link); ?>"
                                class="btn button me-3"><?php echo e(__($banner->data_values->button_one)); ?></a>
                            <a href="<?php echo e($banner->data_values->button_two_link); ?>"
                                class="btn btn2 button"><?php echo e(__($banner->data_values->button_two)); ?></a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12 my-auto pt-lg-0 pt-md-4 pt-4 thumb">
                        <div>
                            <img class="shape"
                                src="<?php echo e(getImage(getFilePath('bannerOne') . '/' . $banner->data_values->theme_one_shape)); ?>"
                                alt="shape" width="86">
                        </div>
                        <img src="<?php echo e(getImage(getFilePath('bannerOne') . '/' . $banner->data_values->theme_one_banner)); ?>"
                            class="img-fluid d-flex ms-auto" alt="image">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--========================== Banner Section End ==========================-->
<?php endif; ?>

<?php if($general->theme == 2): ?>
    <!--========================== Banner Section Start ==========================-->
    <?php
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
    ?>

    <section id="heroCarousel" class="banner-section-two carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <!-- Indicadores (4 pontos fixos com ativo rotativo) -->
        <div class="carousel-indicators" id="heroIndicators">
            <?php for($i = 0; $i < 4; $i++): ?>
                <button type="button" class="<?php echo e($i === 0 ? 'active' : ''); ?>" data-virtual-index="<?php echo e($i); ?>"
                    aria-current="<?php echo e($i === 0 ? 'true' : 'false'); ?>" aria-label="Indicator <?php echo e($i + 1); ?>"></button>
            <?php endfor; ?>
        </div>

        <!-- Slides (apenas backgrounds) -->
        <div class="carousel-inner">
            <?php $__currentLoopData = $heroImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="carousel-item <?php echo e($loop->first ? 'active' : ''); ?>">
                    <div class="banner-thumb bg-img bg-overlay py-120" data-background="<?php echo e(getImage($dirRel . '/' . $img)); ?>">
                        <!-- Conteúdo movido para fora para ficar estático -->
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Conteúdo estático posicionado sobre o carousel -->
        <div class="hero-static-content">
            <div class="content mb-4 wow animate__animated animate__fadeInUp" data-wow-delay="0.6s">
                <h3><?php echo e(__($banner->data_values->heading)); ?></h3>
                <p><?php echo e(__($banner->data_values->subheading)); ?></p>
            </div>

            <div class="hero-search">
                <form id="myForm" class="hero-search__form" action="<?php echo e(baseRoute('search.building')); ?>" method="GET" autocomplete="off">
                    <span class="hero-search__icon"><i class="fas fa-search"></i></span>
                    <input id="searchInput" type="text" name="search" class="form--control hero-search__input"
                        value="<?php echo e(old('search')); ?>" placeholder="Search for building" aria-autocomplete="list" aria-expanded="false" aria-owns="bannerSearchResults">
                </form>
                <!-- Result panel (new implementation) -->
                <div id="bannerSearchResults" class="navbar-search__panel is-static" aria-hidden="true">
                    <div class="navbar-search__card hero-search__card">
                        <div class="navbar-search__suggestions" data-role="suggestions">
                            <p class="navbar-search__headline" data-role="headline">Suggested Searches</p>
                            <ul class="navbar-search__list" id="bannerSuggestionsList"></ul>
                        </div>
                        <template id="bannerItemTemplate">
                            <li class="banner-search-item"><a href="#" data-role="item-link"><i class="las la-arrow-right"></i> <span class="txt" data-role="item-text"></span></a></li>
                        </template>
                        <div class="navbar-search__empty d-none" data-role="empty">No results found</div>
                        <div class="navbar-search__loading d-none" data-role="loading"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...</div>
                        <div class="navbar-search__error d-none" data-role="error">Error loading results</div>
                    </div>
                </div>
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
<?php endif; ?>

<!-- <section class="top-categories-container pb-100">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-5">
                <div class="tc-copy">
                    <?php ($tc = getContent('top_categories.content', true)); ?>
                    <h3><?php echo e(__($tc->data_values->heading ?? 'Stand out with better visuals')); ?></h3>
                    <p><?php echo e(__($tc->data_values->subheading_primary ?? 'Discover premium images crafted for real estate professionals. From drone shots to interiors and floor plans  all organized by building and neighborhood.')); ?></p>
                    <p class="mb-4"><?php echo e(__($tc->data_values->subheading_secondary ?? 'Stand out from the competition with stunning, ready-to-use visuals.')); ?></p>
                    <a href="<?php echo e($tc->data_values->button_link ?? route('condo.building')); ?>" class="btn button"><?php echo e(__($tc->data_values->button_text ?? 'Explore all buildings')); ?></a>
                    <a href="<?php echo e(route('condo.building')); ?>" class="btn button">Explore all buildings</a>
                    <div class="tc-inline-controls mt-3">
                        <button class="tc-nav-btn" type="button" data-bs-target="#categoriesCarousel"
                            data-bs-slide="prev" aria-label="Previous">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div class="tc-indicators">
                            <?php $__currentLoopData = $neighborhoods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <button type="button" data-bs-target="#categoriesCarousel"
                                    data-bs-slide-to="<?php echo e($loop->index); ?>" class="<?php echo e($loop->first ? 'active' : ''); ?>"
                                    aria-current="<?php echo e($loop->first ? 'true' : 'false'); ?>"
                                    aria-label="Slide <?php echo e($loop->iteration); ?>"></button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                        <?php $__currentLoopData = $neighborhoods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="carousel-item <?php echo e($loop->first ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('neighborhood.details', ['county' => slug($item->county->name), 'slug' => slug($item->name), 'id' => $item->id])); ?>"
                                    class="tc-card d-block">
                                    <img class="tc-card__img"
                                        src="<?php echo e(getImage(getFilePath('neighborhood') . '/' . $item->image)); ?>"
                                        alt="<?php echo e($item->name); ?>">
                                    <div class="tc-card__label"><?php echo e(__($item->name)); ?></div>
                                </a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->

<?php $__env->startPush('script'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const carouselEl = document.querySelector('#heroCarousel');
    if (!carouselEl) return;

    // Garante instância do Bootstrap Carousel
    const bsCarousel = bootstrap.Carousel.getOrCreateInstance(carouselEl);

    const indicators = Array.from(document.querySelectorAll('#heroIndicators button'));
    const slides = carouselEl.querySelectorAll('.carousel-item');
    const lastIndex = Math.max(0, slides.length - 1);

    function setActiveByIndex(index) {
        const activeDot = index % 4; // 4 pontos fixos
        indicators.forEach((btn, i) => {
            const isActive = i === activeDot;
            btn.classList.toggle('active', isActive);
            btn.setAttribute('aria-current', isActive ? 'true' : 'false');
        });
    }

    // Atualiza os dots a cada slide
    carouselEl.addEventListener('slid.bs.carousel', function (evt) {
        const active = carouselEl.querySelector('.carousel-item.active');
        const index = evt.to ?? Array.from(slides).indexOf(active);
        setActiveByIndex(index);
    });

    // Clique nos 4 dots vai para o "grupo" correspondente
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
<script id="banner-search-data" type="application/json"><?php echo json_encode($bannerSearchItems ?? [], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES); ?></script>
<script>
(function () {
    'use strict';

    const input = document.getElementById('searchInput');
    const dataTag = document.getElementById('banner-search-data');
    if (!input || !dataTag) {
        return;
    }

    const heroSearch = input.closest('.hero-search');
    if (!heroSearch) {
        return;
    }

    const MAX_RESULTS = 8;
    let panel = null;
    let listNode = null;
    let emptyNode = null;
    let activeIndex = -1;
    let currentResults = [];
    let closingTimer = null;

    const form = input.form;

    const normalizeValue = (value) => (value || '')
        .toString()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .toLowerCase();

    const dataset = (() => {
        try {
            const parsed = JSON.parse(dataTag.textContent || '[]');
            if (!Array.isArray(parsed)) {
                return [];
            }
            return parsed.map((item) => ({
                name: String(item?.name ?? ''),
                url: String(item?.url ?? '#'),
                normalized: normalizeValue(item?.name ?? ''),
            }));
        } catch (error) {
            console.error('Banner search dataset error:', error);
            return [];
        }
    })();

    function createPanel() {
        if (panel) {
            clearTimeout(closingTimer);
            return panel;
        }

        const wrapper = document.createElement('div');
        wrapper.className = 'navbar-search__panel hero-search__panel';
        wrapper.setAttribute('role', 'listbox');
        wrapper.setAttribute('aria-label', 'Sugestões da busca');
        wrapper.style.opacity = '0';
        wrapper.style.transform = 'translateY(-6px)';
        wrapper.style.transition = 'opacity 160ms ease, transform 160ms ease';

        const card = document.createElement('div');
        card.className = 'navbar-search__card hero-search__card';

        const headline = document.createElement('p');
        headline.className = 'navbar-search__headline';
        headline.textContent = 'Sugestões';

        const list = document.createElement('ul');
        list.className = 'navbar-search__list';

        const emptyState = document.createElement('div');
        emptyState.className = 'navbar-search__empty';
        emptyState.textContent = 'Nenhum resultado encontrado';
        emptyState.hidden = true;

        card.appendChild(headline);
        card.appendChild(list);
        card.appendChild(emptyState);
        wrapper.appendChild(card);
        heroSearch.appendChild(wrapper);

        // Fade-in to make the panel appear smoothly.
        requestAnimationFrame(() => {
            wrapper.style.opacity = '1';
            wrapper.style.transform = 'translateY(0)';
        });

        panel = wrapper;
        listNode = list;
        emptyNode = emptyState;
        return panel;
    }

    function destroyPanel(immediate = false) {
        if (!panel) {
            return;
        }

        const target = panel;
        panel = null;
        listNode = null;
        emptyNode = null;
        activeIndex = -1;
        currentResults = [];
        clearTimeout(closingTimer);

        if (immediate) {
            target.remove();
            return;
        }

        target.style.opacity = '0';
        target.style.transform = 'translateY(-6px)';
        closingTimer = setTimeout(() => target.remove(), 160);
    }

    function setActiveIndex(index) {
        if (!listNode) {
            return;
        }

        const links = listNode.querySelectorAll('a[role="option"]');
        if (!links.length) {
            activeIndex = -1;
            return;
        }

        activeIndex = index;
        links.forEach((link, idx) => {
            const isActive = idx === activeIndex;
            link.setAttribute('aria-selected', isActive ? 'true' : 'false');
            link.style.backgroundColor = isActive ? 'rgba(0,0,0,0.04)' : '';
        });
    }

    function scrollActiveIntoView() {
        if (!listNode || activeIndex < 0) {
            return;
        }

        const activeLink = listNode.querySelector(`a[role="option"][data-index="${activeIndex}"]`);
        if (activeLink) {
            activeLink.scrollIntoView({ block: 'nearest' });
        }
    }

    function renderResults(matches) {
        if (!panel || !listNode || !emptyNode) {
            return;
        }

        listNode.innerHTML = '';
        activeIndex = -1;

        if (!matches.length) {
            emptyNode.hidden = false;
            return;
        }

        emptyNode.hidden = true;

        const fragment = document.createDocumentFragment();
        matches.forEach((item, index) => {
            const li = document.createElement('li');

            const link = document.createElement('a');
            link.href = item.url;
            link.setAttribute('role', 'option');
            link.setAttribute('tabindex', '-1');
            link.dataset.index = String(index);

            const icon = document.createElement('i');
            icon.className = 'las la-arrow-right';
            icon.setAttribute('aria-hidden', 'true');

            const text = document.createElement('span');
            text.textContent = item.name;

            link.appendChild(icon);
            link.appendChild(text);

            link.addEventListener('mousedown', (event) => event.preventDefault());
            link.addEventListener('click', (event) => {
                event.preventDefault();
                destroyPanel(true);
                window.location.assign(item.url);
            });
            link.addEventListener('mouseenter', () => setActiveIndex(index));

            li.appendChild(link);
            fragment.appendChild(li);
        });

        listNode.appendChild(fragment);
    }

    function getMatches(term) {
        const trimmed = term.trim();
        if (!trimmed) {
            return dataset.slice(0, MAX_RESULTS);
        }
        const query = normalizeValue(trimmed);
        return dataset.filter((item) => item.normalized.includes(query)).slice(0, MAX_RESULTS);
    }

    function handleInput() {
        const value = input.value;
        const trimmed = value.trim();

        if (!trimmed) {
            destroyPanel();
            return;
        }

        currentResults = getMatches(trimmed);
        createPanel();
        renderResults(currentResults);
        if (currentResults.length) {
            setActiveIndex(0);
            scrollActiveIntoView();
        } else {
            setActiveIndex(-1);
        }
    }

    function handleFocus() {
        const trimmed = input.value.trim();
        if (!trimmed) {
            return;
        }
        handleInput();
    }

    function handleKeyDown(event) {
        if (!panel) {
            return;
        }

        if (event.key === 'ArrowDown') {
            if (!currentResults.length) {
                return;
            }
            event.preventDefault();
            const next = activeIndex < currentResults.length - 1 ? activeIndex + 1 : 0;
            setActiveIndex(next);
            scrollActiveIntoView();
        } else if (event.key === 'ArrowUp') {
            if (!currentResults.length) {
                return;
            }
            event.preventDefault();
            const prev = activeIndex > 0 ? activeIndex - 1 : currentResults.length - 1;
            setActiveIndex(prev);
            scrollActiveIntoView();
        } else if (event.key === 'Enter') {
            if (activeIndex >= 0 && currentResults[activeIndex]) {
                event.preventDefault();
                destroyPanel(true);
                window.location.assign(currentResults[activeIndex].url);
            }
        } else if (event.key === 'Escape') {
            event.preventDefault();
            destroyPanel();
        }
    }

    function handleDocumentPointer(event) {
        if (!panel) {
            return;
        }

        if (event.target === input || panel.contains(event.target)) {
            return;
        }

        destroyPanel();
    }

    input.addEventListener('input', handleInput);
    input.addEventListener('focus', handleFocus);
    input.addEventListener('keydown', handleKeyDown);

    input.addEventListener('blur', () => {
        // Delay lets click handlers inside the suggestion panel run first.
        setTimeout(() => destroyPanel(), 120);
    });

    document.addEventListener('pointerdown', handleDocumentPointer);

    if (form) {
        form.addEventListener('submit', () => destroyPanel(true));
    }

    window.addEventListener('blur', () => destroyPanel());
    window.addEventListener('resize', () => destroyPanel(true));
})();
</script>
<?php $__env->stopPush(); ?>

<?php /**PATH C:\Users\victo\Desktop\pedro\condoImage\_\httpdocs\staging\application\resources\views/presets/default/sections/banner.blade.php ENDPATH**/ ?>