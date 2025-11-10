<?php
    $pages = App\Models\Page::get();
    $firstFivePages = $pages->take(5);
    $morePages = $pages->slice(5);
    $allNeighborhoods = App\Models\Neighborhood::with([
        'buildings' => function ($query) {
            $query->select('id', 'name', 'neighborhood_id');
        },
        'county' => function ($query) {
            $query->select('id', 'name');
        },
        'buildings.neighborhood.county',
    ])
        ->where('status', 1)
        ->get();

    $splitNeighborhoods = $allNeighborhoods->values()->chunk(ceil($allNeighborhoods->count() / 2));
    $allBuildings = App\Models\Building::with('neighborhood.county')->where('status', 1)->inRandomOrder()->take(30)->get();
    $splitBuildings = $allBuildings->values()->chunk(ceil($allBuildings->count() / 2));

    // Combined search items for suggestions
    $searchItems = collect();
    $searchItems = $searchItems->merge($allBuildings->map(fn($b) => [
        'type' => 'building',
        'name' => $b->name,
        'url' => baseRoute('condo.building.details', building_route_params($b)),
    ]));
    $searchItems = $searchItems->merge($allNeighborhoods->map(fn($n) => [
        'type' => 'neighborhood',
        'name' => $n->name,
        'url' => baseRoute('neighborhood.details', ['county' => slug($n->county->name), 'slug' => slug($n->name), 'id' => $n->id]),
    ]));
    $searchItems = $searchItems->shuffle(); // Randomize the combined list

    $wishlist = App\Models\Wishlist::where('user_id', auth()->id())->get();
?>

<!-- ==================== Header End Here ==================== -->

<div class="header is-over-hero" id="header">
    <div class="container">
        <nav class="navbar">
            <div class="header-menu-wrapper">
                <a href="<?php echo e(route('home')); ?>" class="brand-text" id="normal-logo">
                    <span class="brand-primary">CONDO</span><span class="brand-secondary">IMAGE</span>
                </a>
            </div>
            <div class="row ms-auto d-none d-xl-flex nav-center-block">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-center">
                        <!-- Fixed desktop nav links -->
                        <div class="item nav-links-centered">
                            <a href="<?php echo e(route('home')); ?>"
                                class="<?php echo e(request()->routeIs('home') ? 'is-active' : ''); ?>">Home</a>

                            <div class="item nav-links-centered">
                                <button class="nav-link-button" id="navbarNeighborhoodToggle" type="button"
                                    aria-haspopup="true" aria-expanded="false" aria-label="Open neighborhood">
                                    Neighborhood
                                </button>

                                <div class="navbar-search__panel" id="navbarNeighborhoodPanel" aria-hidden="true">
                                    <div class="navbar-search__card">
                                        <button class="navbar-search__close mobile-panel-close" type="button"
                                            aria-label="Close neighborhoods panel">
                                            <i class="las la-times"></i>
                                        </button>
                                        <div class="navbar-flyout__columns">
                                            <div class="navbar-flyout__column">
                                                <p class="navbar-flyout__subtitle">Explore Miami's top areas</p>
                                                <ul class="navbar-flyout__list">
                                                    <?php $__currentLoopData = $allNeighborhoods->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $neighborhood): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li><a
                                                                href="<?php echo e(route('neighborhood.details', ['county' => slug($neighborhood->county->name), 'slug' => slug($neighborhood->name), 'id' => $neighborhood->id])); ?>"><?php echo e($neighborhood->name); ?></a>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
                                            <div class="navbar-flyout__column navbar-flyout__column--actions">
                                                <p class="navbar-flyout__subtitle">Quick actions</p>
                                                <ul class="navbar-flyout__list navbar-flyout__list--actions">
                                                    <li><a class="navbar-flyout__action"
                                                            href="<?php echo e(route('neighborhood')); ?>">View
                                                            all neighborhoods</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="item nav-links-centered">
                                <button class="nav-link-button" id="navbarCondoToggle" type="button"
                                    aria-haspopup="true" aria-expanded="false" aria-label="Open condo building">
                                    Condo Building
                                </button>

                                <div class="navbar-search__panel" id="navbarCondoPanel" aria-hidden="true">
                                    <div class="navbar-search__card">
                                        <button class="navbar-search__close mobile-panel-close" type="button"
                                            aria-label="Close condo buildings panel">
                                            <i class="las la-times"></i>
                                        </button>
                                        <div class="navbar-flyout__columns">
                                            <div class="navbar-flyout__column">
                                                <p class="navbar-flyout__subtitle">Discover premium residences</p>
                                                <ul class="navbar-flyout__list">
                                                    <?php $__currentLoopData = $allBuildings->take(7); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $building): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li><a
                                                                href="<?php echo e(route('condo.building.details', building_route_params($building))); ?>"><?php echo e($building->name); ?></a>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
                                            <div class="navbar-flyout__column navbar-flyout__column--actions">
                                                <p class="navbar-flyout__subtitle">Quick actions</p>
                                                <ul class="navbar-flyout__list navbar-flyout__list--actions">
                                                    <li><a class="navbar-flyout__action"
                                                            href="<?php echo e(route('condo.building')); ?>">View
                                                            all condos</a></li>
                                                    <li><a class="navbar-flyout__action"
                                                            href="<?php echo e(route('neighborhood')); ?>">Browse by
                                                            neighborhood</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav-actions ms-auto d-flex align-items-center gap-2 gap-md-3">
                <div class="navbar-search">
                    <button class="navbar-search__toggle" id="navbarSearchToggle" type="button" aria-haspopup="true"
                        aria-expanded="false" aria-label="Open search">
                        <i class="fas fa-search"></i>
                    </button>

                    <div class="navbar-search__panel" id="navbarSearchPanel" aria-hidden="true">
                        <div class="navbar-search__card">
                            <form action="<?php echo e(baseRoute('search.building')); ?>" method="GET" class="navbar-search__field">
                                <i class="fas fa-search"></i>
                                <input id="navbarSearchInput" name="search" type="text" data-building-search
                                    placeholder="Search buildings and neighborhoods" autocomplete="off">
                                <button class="navbar-search__close" id="navbarSearchClose" type="button"
                                    aria-label="Close search">
                                    <i class="las la-times"></i>
                                </button>
                            </form>

                            <div class="navbar-search__suggestions">
                                <p class="navbar-search__headline">Suggested Searches</p>
                                <ul id="building-suggestions">
                                    <?php $__currentLoopData = $allBuildings->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $building): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><a href="<?php echo e(route('condo.building.details', building_route_params($building))); ?>"><i class="las la-arrow-right"></i> Explore <?php echo e($building->name); ?></a></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                            <script id="buildings-data" type="application/json">
<?php echo json_encode($searchItems->values(), JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES); ?>

</script>
                        </div>
                    </div>
                </div>
                <a href="<?php echo e(route('user.login')); ?>" class="nav-icon nav-actions__account" aria-label="Account"><i
                        class="far fa-user"></i></a>
                <button class="navbar-toggler header-button nav-actions__toggler" type="button"
                    id="mobileMenuToggle" aria-label="Toggle navigation">
                    <span id="hiddenNav"><i class="las la-bars"></i></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>"
                            href="<?php echo e(route('home')); ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link nav-link-button mobile-panel-trigger" 
                                data-panel="navbarNeighborhoodPanel" type="button">
                            Neighborhoods
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link nav-link-button mobile-panel-trigger" 
                                data-panel="navbarCondoPanel" type="button">
                            Condo Buildings
                        </button>
                    </li>
                    <?php if(auth()->guard()->check()): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarUserDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Account
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarUserDropdown">
                                <li><a class="dropdown-item" href="<?php echo e(route('user.home')); ?>">Dashboard</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('user.profile.setting')); ?>">Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="<?php echo e(route('user.logout')); ?>">Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('user.login')); ?>">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('user.register')); ?>">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>

    </div>
</div>

<!-- Mobile Menu System - Completely Separate from Desktop -->
<div class="mobile-menu-system" id="mobileMenuSystem">
    <!-- Mobile Search Menu -->
    <div class="mobile-menu-panel" id="mobileSearchPanel">
        <div class="mobile-menu-header">
            <div></div>
            <button class="mobile-menu-close" data-action="close">
                <i class="las la-times"></i>
            </button>
        </div>
        <div class="mobile-menu-content">
            <form action="<?php echo e(baseRoute('search.building')); ?>" method="GET" class="mobile-search-form">
                <div class="mobile-search-field">
                    <i class="fas fa-search"></i>
                    <input name="search" type="text" data-building-search placeholder="Search buildings and neighborhoods" autocomplete="off">
                </div>
            </form>
            <div class="mobile-search-suggestions">
                <p class="mobile-search-headline">Suggested Searches</p>
                <ul class="mobile-suggestions-list" id="mobile-building-suggestions">
                    <?php $__currentLoopData = $allBuildings->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $building): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href="<?php echo e(route('condo.building.details', building_route_params($building))); ?>">
                                <i class="las la-arrow-right"></i> Explore <?php echo e($building->name); ?>

                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Mobile Main Menu (Sandwich) -->
    <div class="mobile-menu-panel" id="mobileMainPanel">
        <div class="mobile-menu-header">
            <div></div>
            <button class="mobile-menu-close" data-action="close">
                <i class="las la-times"></i>
            </button>
        </div>
        <div class="mobile-menu-content">
            <ul class="mobile-main-nav">
                <li>
                    <a href="<?php echo e(route('home')); ?>" class="mobile-nav-item">Home</a>
                </li>
                <li>
                    <button class="mobile-nav-item mobile-nav-button" data-action="navigate" data-target="mobileNeighborhoodPanel">
                        Neighborhood
                    </button>
                </li>
                <li>
                    <button class="mobile-nav-item mobile-nav-button" data-action="navigate" data-target="mobileCondoPanel">
                        Condo buildings
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Mobile Neighborhood Menu -->
    <div class="mobile-menu-panel" id="mobileNeighborhoodPanel">
        <div class="mobile-menu-header">
            <button class="mobile-menu-back" data-action="back" data-target="mobileMainPanel">
                <i class="las la-angle-left"></i>
            </button>
            <button class="mobile-menu-close" data-action="close">
                <i class="las la-times"></i>
            </button>
        </div>
        <div class="mobile-menu-content">
            <!-- Explore Miami's top areas -->
            <div class="mobile-menu-section">
                <p class="mobile-menu-section-title">Explore Miami's top areas</p>
                <ul class="mobile-menu-list">
                    <?php $__currentLoopData = $splitNeighborhoods->flatten()->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $neighborhood): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href="<?php echo e(route('neighborhood.details', ['county' => slug($neighborhood->county->name), 'slug' => slug($neighborhood->name), 'id' => $neighborhood->id])); ?>" class="mobile-menu-link">
                                <?php echo e($neighborhood->name); ?>

                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>

            <!-- Quick actions -->
            <div class="mobile-menu-section">
                <p class="mobile-menu-section-title">Quick actions</p>
                <ul class="mobile-menu-list mobile-menu-list--actions">
                    <li>
                        <a href="<?php echo e(route('condo.building')); ?>" class="mobile-menu-action">
                            View all condos
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('neighborhood')); ?>" class="mobile-menu-action">
                            Browse by neighborhood
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Mobile Condo Buildings Menu -->
    <div class="mobile-menu-panel" id="mobileCondoPanel">
        <div class="mobile-menu-header">
            <button class="mobile-menu-back" data-action="back" data-target="mobileMainPanel">
                <i class="las la-angle-left"></i>
            </button>
            <button class="mobile-menu-close" data-action="close">
                <i class="las la-times"></i>
            </button>
        </div>
        <div class="mobile-menu-content">
            <!-- Discover premium residences -->
            <div class="mobile-menu-section">
                <p class="mobile-menu-section-title">Discover premium residences</p>
                <ul class="mobile-menu-list">
                    <?php $__currentLoopData = $splitBuildings->flatten()->take(7); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $building): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href="<?php echo e(route('condo.building.details', building_route_params($building))); ?>" class="mobile-menu-link">
                                <?php echo e($building->name); ?>

                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>

            <!-- Quick actions -->
            <div class="mobile-menu-section">
                <p class="mobile-menu-section-title">Quick actions</p>
                <ul class="mobile-menu-list mobile-menu-list--actions">
                    <li>
                        <a href="<?php echo e(route('condo.building')); ?>" class="mobile-menu-action">
                            View all condos
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('neighborhood')); ?>" class="mobile-menu-action">
                            Browse by neighborhood
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('script'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Função reutilizável para configurar painéis
            function setupPanel(toggleId, panelId, inputId = null, closeBtnId = null) {
                const toggle = document.getElementById(toggleId);
                const panel = document.getElementById(panelId);
                const input = inputId ? document.getElementById(inputId) : null;
                const closeBtn = closeBtnId ? document.getElementById(closeBtnId) : null;

                if (!toggle || !panel) {
                    return;
                }

                const syncPanelWidth = () => {
                    const navbar = document.querySelector('.header .navbar');
                    if (!navbar) return;
                    const w = navbar.getBoundingClientRect().width;
                    panel.style.width = w + 'px';
                    const card = panel.querySelector('.navbar-search__card');
                    if (card) card.style.width = '100%';
                };

                const openPanel = () => {
                    // Em desktop, iguala a largura do flyout à do navbar
                    syncPanelWidth();
                    // Fecha todos os outros painéis primeiro
                    document.querySelectorAll('.navbar-search__panel.is-open').forEach(p => {
                        if (p !== panel) {
                            p.classList.remove('is-open');
                            p.setAttribute('aria-hidden', 'true');
                        }
                    });
                    document.querySelectorAll('.navbar-search__toggle[aria-expanded="true"]').forEach(t => {
                        if (t !== toggle) {
                            t.setAttribute('aria-expanded', 'false');
                        }
                    });

                    panel.classList.add('is-open');
                    panel.setAttribute('aria-hidden', 'false');
                    toggle.setAttribute('aria-expanded', 'true');

                    // Adicionar classe ao body para browsers sem suporte ao :has()
                    if (panelId === 'navbarSearchPanel') {
                        document.body.classList.add('navbar-search-open');
                    }

                    if (input) {
                        window.setTimeout(() => {
                            input.focus();
                        }, 20);
                    }
                };

                const closePanel = () => {
                    panel.classList.remove('is-open');
                    panel.setAttribute('aria-hidden', 'true');
                    toggle.setAttribute('aria-expanded', 'false');
                    
                    // Remover classe do body
                    if (panelId === 'navbarSearchPanel') {
                        document.body.classList.remove('navbar-search-open');
                    }
                    
                    if (input) {
                        input.value = '';
                    }
                };

                const clearSearch = () => {
                    if (input) {
                        input.value = '';
                        input.focus();
                    }
                };

                toggle.addEventListener('click', function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    event.stopImmediatePropagation();
                    if (panel.classList.contains('is-open')) {
                        closePanel();
                    } else {
                        openPanel();
                    }
                });

                if (closeBtn) {
                    // Para o botão de search, fechar o painel
                    if (closeBtnId === 'navbarSearchClose') {
                        closeBtn.addEventListener('click', function (event) {
                            event.preventDefault();
                            event.stopPropagation();
                            closePanel();
                        });
                        
                        // Também adicionar mousedown para garantir captura
                        closeBtn.addEventListener('mousedown', function (event) {
                            event.preventDefault();
                            event.stopPropagation();
                            closePanel();
                        });
                    } else {
                        closeBtn.addEventListener('click', function (event) {
                            event.preventDefault();
                            event.stopPropagation();
                            closePanel();
                        });
                    }
                }

                panel.addEventListener('click', function (event) {
                    event.stopPropagation();
                });

                // Sincroniza em resize quando aberto
                window.addEventListener('resize', () => {
                    if (panel.classList.contains('is-open')) {
                        syncPanelWidth();
                    }
                });

                return { openPanel, closePanel };
            }

            // Configura todos os painéis
            const searchPanel = setupPanel('navbarSearchToggle', 'navbarSearchPanel', 'navbarSearchInput', 'navbarSearchClose');
            const neighborhoodPanel = setupPanel('navbarNeighborhoodToggle', 'navbarNeighborhoodPanel');
            const condoPanel = setupPanel('navbarCondoToggle', 'navbarCondoPanel');

            // Mobile: open Neighborhood/Condo panels fullscreen instead of dropdown
            (function attachMobileMenuHandlers() {
                const isMobile = () => window.matchMedia('(max-width: 991.98px)').matches;
                const collapse = document.getElementById('navbarSupportedContent');

                // Lock/unlock body scroll when the Bootstrap collapse menu opens/closes
                if (collapse) {
                    collapse.addEventListener('show.bs.collapse', function () {
                        document.body.classList.add('mobile-menu-open');
                    });
                    collapse.addEventListener('hidden.bs.collapse', function () {
                        document.body.classList.remove('mobile-menu-open');
                    });
                }

                const openFullPanel = (panelId) => {
                    console.log('openFullPanel called with:', panelId); // Debug
                    if (!isMobile()) {
                        console.log('Not mobile, returning'); // Debug
                        return;
                    }
                    
                    // Close collapse if open
                    if (collapse && collapse.classList.contains('show')) {
                        collapse.classList.remove('show');
                        document.body.classList.remove('mobile-menu-open');
                        console.log('Collapse closed'); // Debug
                    }
                    
                    // Close other panels and open target
                    ['navbarNeighborhoodPanel','navbarCondoPanel','navbarSearchPanel'].forEach(id => {
                        const p = document.getElementById(id);
                        if (p) {
                            const shouldOpen = id === panelId;
                            p.classList.toggle('is-open', shouldOpen);
                            p.setAttribute('aria-hidden', shouldOpen ? 'false' : 'true');
                            console.log(`Panel ${id}: ${shouldOpen ? 'opened' : 'closed'}`); // Debug
                        }
                    });
                    document.body.classList.add('navbar-search-open');
                    console.log('Body class added'); // Debug
                };

                // On mobile, strip Bootstrap dropdown behavior from items (become plain nav items)
                const stripMobileDropdowns = () => {
                    if (!collapse) return;
                    if (!isMobile()) return;
                    collapse.querySelectorAll('.dropdown-toggle').forEach(el => {
                        el.classList.remove('dropdown-toggle');
                        el.removeAttribute('data-bs-toggle');
                        el.removeAttribute('aria-expanded');
                        el.removeAttribute('role');
                    });
                    // Hide any dropdown menus inside collapse
                    collapse.querySelectorAll('.dropdown-menu').forEach(menu => {
                        menu.style.display = 'none';
                    });
                };
                stripMobileDropdowns();
                window.addEventListener('resize', stripMobileDropdowns);

                // Delegated handler to be robust to markup changes
                if (collapse) {
                    collapse.addEventListener('click', function (e) {
                        if (!isMobile()) return;
                        
                        const trigger = e.target.closest('.mobile-panel-trigger');
                        if (!trigger) return;
                        
                        e.preventDefault(); 
                        e.stopPropagation();
                        e.stopImmediatePropagation();
                        
                        const panelId = trigger.getAttribute('data-panel');
                        console.log('Mobile panel trigger clicked:', panelId); // Debug
                        
                        if (panelId) {
                            // Fechar o menu mobile primeiro de forma mais direta
                            if (collapse.classList.contains('show')) {
                                collapse.classList.remove('show');
                            }
                            
                            // Abrir o painel imediatamente
                            openFullPanel(panelId);
                        }
                });
            };
                

                // Event listeners para botões de fechar dos painéis móveis
                document.querySelectorAll('.mobile-panel-close').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        const panel = this.closest('.navbar-search__panel');
                        if (panel) {
                            panel.classList.remove('is-open');
                            panel.setAttribute('aria-hidden', 'true');
                            document.body.classList.remove('navbar-search-open');
                        }
                    });
                });
            })();

            // Event listeners globais
            document.addEventListener('click', function (event) {
                const openPanels = document.querySelectorAll('.navbar-search__panel.is-open');
                if (openPanels.length === 0) return;

                const clickedInsidePanel = event.target.closest('.navbar-search__panel');
                const clickedToggle = event.target.closest('.navbar-search__toggle');

                if (!clickedInsidePanel && !clickedToggle) {
                    openPanels.forEach(panel => {
                        panel.classList.remove('is-open');
                        panel.setAttribute('aria-hidden', 'true');
                    });
                    document.querySelectorAll('.navbar-search__toggle[aria-expanded="true"]').forEach(toggle => {
                        toggle.setAttribute('aria-expanded', 'false');
                    });
                    // Remover classe do body
                    document.body.classList.remove('navbar-search-open');
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    document.querySelectorAll('.navbar-search__panel.is-open').forEach(panel => {
                        panel.classList.remove('is-open');
                        panel.setAttribute('aria-hidden', 'true');
                    });
                    document.querySelectorAll('.navbar-search__toggle[aria-expanded="true"]').forEach(toggle => {
                        toggle.setAttribute('aria-expanded', 'false');
                    });
                    // Remover classe do body
                    document.body.classList.remove('navbar-search-open');
                }
            });
        });
    </script>
    <script>
(function () {
  const MAX_ITEMS = 4;

  // ------ Helpers
  const normalize = (s) =>
    (s || '')
      .toString()
      .normalize('NFD')
      .replace(/\p{Diacritic}/gu, '')
      .toLowerCase();

  const debounce = (fn, ms) => {
    let t;
    return (...args) => {
      clearTimeout(t);
      t = setTimeout(() => fn(...args), ms);
    };
  };

  // ------ Init quando DOM estiver pronto (ordem de execução segura)
  document.addEventListener('DOMContentLoaded', function () {
    const dataTag = document.getElementById('buildings-data');
    const inputs = document.querySelectorAll('[data-building-search]');

    if (!dataTag || inputs.length === 0) return; // não quebra layout

    /** Carrega todos os itens (na ordem recebida do backend) */
    let items = [];
    try {
      items = JSON.parse(dataTag.textContent || '[]');
    } catch (e) {
      items = [];
    }

    // Preprocess: acrescenta campo normalizado para busca
    items = items.map(it => ({
      ...it,
      _n: normalize(it.name)
    }));

    const escapeHtml = (str) => {
      return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
    };

    // Para cada input, encontrar o ul mais próximo (desktop ou mobile)
    inputs.forEach(input => {
      const container = input.closest('.navbar-search__card') || input.closest('.mobile-menu-content');
      const suggestionsUl = container ? container.querySelector('ul[id*="building-suggestions"]') : null;

      if (!suggestionsUl) return;

      /** Renderiza até MAX_ITEMS mantendo o design atual */
      const render = (list) => {
        const slice = list.slice(0, MAX_ITEMS);
        // Monta exatamente a mesma estrutura/estilos usados no Blade
        suggestionsUl.innerHTML = slice.map(it => (
          `<li>
             <a href="${it.url}">
               <i class="las la-arrow-right"></i> Explore ${escapeHtml(it.name)}
             </a>
           </li>`
        )).join('');
      };

      /** Busca com filtro simples por substring (com acento-agnóstico) */
      const performFilter = () => {
        const q = normalize(input.value);
        if (!q) {
          // Sem termo: volta aos primeiros MAX_ITEMS, preservando a ordem do backend
          render(items);
          return;
        }
        const filtered = items.filter(it => it._n.includes(q));
        render(filtered);
      };

      // Estado inicial (mesmo take(4) de antes)
      render(items);

      // Live search (sem mudar design, só conteúdo)
      const onInput = debounce(performFilter, 100);
      input.addEventListener('input', onInput);
    });
  });
})();
</script>
<?php $__env->stopPush(); ?>

<!-- Mobile Menu Script -->
<script src="<?php echo e(baseAsset($activeTemplateTrue . 'js/mobile-menu.js')); ?>"></script>

<style>
    /* Estilos baseados no Figma */
    .navbar-flyout__columns {
        display: flex;
        gap: 88px;
        /* Margem direita de 88px entre as colunas */
    }

    .navbar-flyout__column {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .navbar-flyout__column--actions {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    /* Título das seções - "Explore Miami's top areas" / "Quick actions" */
    .navbar-flyout__subtitle {
        color: #77777C;
        /* Gray-400 */
        font-family: Inter;
        font-size: 13px;
        font-style: normal;
        font-weight: 400;
        line-height: 18.2px;
        /* 140% */
        margin: 0;
    }

    .navbar-flyout__list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .navbar-flyout__list li {
        margin: 0;
    }

    /* Links da lista - bairros e ações */
    .navbar-flyout__list a,
    .navbar-flyout__action {
        color: #37373C;
        /* Gray-800 */
        font-family: Inter;
        font-size: 18px;
        font-style: normal;
        font-weight: 700;
        line-height: 27px;
        /* 150% */
        text-decoration: none;
        padding: 0;
        transition: color 0.2s ease;
    }

    .navbar-flyout__list a:hover,
    .navbar-flyout__action:hover {
        color: #0E80BD;
        transform: translateX(4px);
    }

    /* ======================== MOBILE MENU SYSTEM STYLES ======================== */
    
    /* Mobile Menu System Container */
    .mobile-menu-system {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        height: 100dvh; /* Dynamic viewport height for mobile */
        z-index: 9999;
        pointer-events: none;
        overflow: hidden;
    }

    .mobile-menu-system.active {
        pointer-events: all;
    }

    /* Individual Menu Panels */
    .mobile-menu-panel {
        position: absolute;
        top: 0;
        right: -100%;
        width: 100%;
        height: 100vh;
        height: 100dvh; /* Dynamic viewport height for mobile */
        background: #F7F7F8;
        transition: right 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94); /* Smooth curtain animation */
        display: flex;
        flex-direction: column;
        opacity: 0;
        visibility: hidden;
        transform: translateX(20px); /* Small translate for extra smoothness */
    }

    @media (max-width: 991.98px) {
        .mobile-menu-system,
        .mobile-menu-panel {
            height: calc(100vh / var(--ui-zoom-factor, 1));
            height: calc(100dvh / var(--ui-zoom-factor, 1));
        }
    }

    .mobile-menu-panel.active {
        right: 0;
        opacity: 1;
        visibility: visible;
        transform: translateX(0);
    }

    /* Mobile Menu Header */
    .mobile-menu-header {
        padding: 16px 24px;
        border-bottom: 1px solid #E5E5E8;
        display: flex;
        justify-content: space-between;
        align-items: center;
        min-height: 60px;
        background: #F7F7F8;
        position: relative;
        z-index: 10;
    }

    .mobile-menu-back,
    .mobile-menu-close {
        background: none;
        border: none;
        font-size: 24px;
        color: #1D1D1F;
        padding: 8px;
        cursor: pointer;
        transition: color 0.2s, transform 0.2s;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .mobile-menu-back:hover,
    .mobile-menu-close:hover {
        color: #0E80BD;
        transform: scale(1.1);
        background: rgba(14, 128, 189, 0.1);
    }

    .mobile-menu-back:active,
    .mobile-menu-close:active {
        transform: scale(0.95);
    }

    /* Mobile Menu Content */
    .mobile-menu-content {
        flex: 1;
        padding: 24px;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
    }

    /* Mobile Search Form */
    .mobile-search-form {
        margin-bottom: 32px;
    }

    .mobile-search-field {
        position: relative;
        display: flex;
        align-items: center;
        border-radius: 12px;
    }

    .mobile-search-field:focus-within {
    }

    .mobile-search-field i {
        color: #77777C;
        margin-right: 16px;
        font-size: 18px;
    }

    .mobile-search-field input {
        flex: 1;
        border: none;
        outline: none;
        font-family: Inter;
        font-size: 16px;
        font-weight: 600;
        line-height: 28px;
        color: #77777C;
        background: transparent;
        line-height: 1.5;
    }

    .mobile-search-field input::placeholder {
        color: #77777C;
    }

    /* Mobile Search Suggestions */
    .mobile-search-suggestions {
        margin-top: 32px;
    }

    .mobile-search-headline {
        color: #77777C;
        font-family: Inter;
        font-size: 13px;
        font-weight: 400;
        line-height: 18.2px;
        letter-spacing: 0.5px;
    }

    .mobile-suggestions-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .mobile-suggestions-list li {
        margin-bottom: 8px;
    }

    .mobile-suggestions-list a {
        display: flex;
        align-items: center;
        color: #77777C;
        font-family: Inter;
        font-size: 13px;
        font-weight: 400;
        line-height: 18.2px;
        text-decoration: none;
        transition: color 0.2s, transform 0.2s;
        border-radius: 8px;
        ;
    }

    .mobile-suggestions-list a:hover {
        color: #37373C;
        transform: translateX(4px);
    }

    .mobile-suggestions-list i {
        margin-right: 8px;
        color: #4D4D51;
        font-size: 24px;
        transition: color 0.2s;
    }

    .mobile-suggestions-list a:hover i {
        color: #37373C;
    }

    /* Mobile Main Navigation */
    .mobile-main-nav {
        list-style: none;
        padding: 0;
        margin: 24px;
    }

    .mobile-main-nav li {
        /* Sem divider */
    }

    .mobile-nav-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 8px 0;
        color: #1D1D1F;
        font-family: Inter;
        font-size: 18px;
        font-weight: 700;
        line-height: 27px;
        text-decoration: none;
        background: none;
        border: none;
        text-align: left;
        cursor: pointer;
        transition: color 0.2s, background-color 0.2s;
        border-radius: 8px;
        margin: 0 -12px;
        padding-left: 12px;
        padding-right: 12px;
    }

    .mobile-nav-item:hover {
        color: #0E80BD;
        background: rgba(14, 128, 189, 0.05);
    }

    .mobile-nav-item i {
        color: #77777C;
        font-size: 20px;
        transition: color 0.2s, transform 0.2s;
    }

    .mobile-nav-item:hover i {
        color: #0E80BD;
        transform: translateX(2px);
    }

    /* Mobile Menu Sections */
    .mobile-menu-section {
        margin-bottom: 24px;
    }

    .mobile-menu-section:last-child {
        margin-bottom: 0;
    }

    .mobile-menu-section-title {
        color: #77777C;
        font-family: Inter;
        font-size: 13px;
        font-weight: 400;
        line-height: 18.2px;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .mobile-menu-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .mobile-menu-list li {
    }

    .mobile-menu-link,
    .mobile-menu-action {
        display: block;
        padding: 8px 12px;
        color: #1D1D1F;
        font-family: Inter;
        font-size: 18px;
        font-weight: 700;
        line-height: 27px;
        text-decoration: none;
        transition: color 0.2s, background-color 0.2s, transform 0.2s;
        border-radius: 8px;
        margin: 0 -12px;
    }

    .mobile-menu-link:hover,
    .mobile-menu-action:hover {
        color: #0E80BD;
        background: rgba(14, 128, 189, 0.05);
        transform: translateX(4px);
    }

    /* Body overflow control */
    body.mobile-menu-open {
        overflow: hidden;
        height: 100vh;
        height: 100dvh;
    }

    /* Hide on desktop */
    @media (min-width: 992px) {
        .mobile-menu-system {
            display: none !important;
        }
    }
</style>
<!-- ==================== Header End Here ==================== -->


<?php /**PATH C:\Users\victo\Desktop\pedro\condoImage\_\httpdocs\staging\application\resources\views/presets/default/partials/header.blade.php ENDPATH**/ ?>