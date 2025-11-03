@php
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

    $wishlist = App\Models\Wishlist::where('user_id', auth()->id())->get();
@endphp

<!-- ==================== Header End Here ==================== -->

<div class="header is-over-hero" id="header">
    <div class="container my-2">
        <nav class="navbar navbar-expand-lg gap-3">
            <div class="header-menu-wrapper align-items-center d-flex">
                <div class="logo-wrapper">
                    <a href="{{ route('home') }}" class="navbar-brand logo brand-text" id="normal-logo">
                        <span class="brand-primary">CONDO</span><span class="brand-secondary">IMAGE</span>
                    </a>
                </div>
            </div>


            <button class="navbar-toggler header-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span id="hiddenNav"><i class="las la-bars"></i></span>
            </button>

            <div class="row ms-auto d-none d-xl-flex nav-center-block">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-center">
                        <!-- Fixed desktop nav links -->
                        <div class="item nav-links-centered">
                            <a href="{{ route('home') }}"
                                class="{{ request()->routeIs('home') ? 'is-active' : '' }}">Home</a>

                            <div class="item nav-links-centered">
                                <button class="nav-link-button" id="navbarNeighborhoodToggle" type="button"
                                    aria-haspopup="true" aria-expanded="false" aria-label="Open neighborhood">
                                    Neighborhood
                                </button>

                                <div class="navbar-search__panel" id="navbarNeighborhoodPanel" aria-hidden="true">
                                    <div class="navbar-search__card">
                                        <div class="navbar-flyout__columns">
                                            <div class="navbar-flyout__column">
                                                <p class="navbar-flyout__subtitle">Explore Miami's top areas</p>
                                                <ul class="navbar-flyout__list">
                                                    @foreach($allNeighborhoods->take(5) as $neighborhood)
                                                        <li><a
                                                                href="{{ route('neighborhood.details', ['county' => slug($neighborhood->county->name), 'slug' => slug($neighborhood->name), 'id' => $neighborhood->id]) }}">{{ $neighborhood->name }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="navbar-flyout__column navbar-flyout__column--actions">
                                                <p class="navbar-flyout__subtitle">Quick actions</p>
                                                <ul class="navbar-flyout__list navbar-flyout__list--actions">
                                                    <li><a class="navbar-flyout__action"
                                                            href="{{ route('neighborhood') }}">View
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
                                        <div class="navbar-flyout__columns">
                                            <div class="navbar-flyout__column">
                                                <p class="navbar-flyout__subtitle">Discover premium residences</p>
                                                <ul class="navbar-flyout__list">
                                                    @foreach($allBuildings->take(7) as $building)
                                                        <li><a
                                                                href="{{ route('condo.building.details', building_route_params($building)) }}">{{ $building->name }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="navbar-flyout__column navbar-flyout__column--actions">
                                                <p class="navbar-flyout__subtitle">Quick actions</p>
                                                <ul class="navbar-flyout__list navbar-flyout__list--actions">
                                                    <li><a class="navbar-flyout__action"
                                                            href="{{ route('condo.building') }}">View
                                                            all condos</a></li>
                                                    <li><a class="navbar-flyout__action"
                                                            href="{{ route('neighborhood') }}">Browse by
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

            <!-- Right side actions (desktop) -->
            <div class="d-none d-xl-flex nav-icons-right ms-3 align-items-center gap-3">
                <div class="navbar-search">
                    <button class="navbar-search__toggle" id="navbarSearchToggle" type="button" aria-haspopup="true"
                        aria-expanded="false" aria-label="Open search">
                        <i class="fas fa-search"></i>
                    </button>

                    <div class="navbar-search__panel" id="navbarSearchPanel" aria-hidden="true">
                        <div class="navbar-search__card">
                            <form action="{{ route('search.building') }}" method="GET" class="navbar-search__field">
                                <i class="fas fa-search"></i>
                                <input id="navbarSearchInput" name="search" type="text"
                                    placeholder="Search buildings and neighborhoods" autocomplete="off">
                                <button type="submit" class="navbar-search__submit" aria-label="Submit search">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="navbar-search__close" id="navbarSearchClose" type="button"
                                    aria-label="Close search">
                                    <i class="las la-times"></i>
                                </button>
                            </form>

                            <div class="navbar-search__suggestions">
                                <p class="navbar-search__headline">Suggested Searches</p>
                                <ul>
                                    @foreach($allBuildings->take(4) as $building)
                                        <li><a
                                                href="{{ route('condo.building.details', building_route_params($building)) }}"><i
                                                    class="las la-arrow-right"></i> Explore {{ $building->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('user.login') }}" class="nav-icon" aria-label="Account"><i
                        class="far fa-user"></i></a>
            </div>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                            href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarNeighborhoodDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Neighborhoods
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarNeighborhoodDropdown">
                            @foreach($allNeighborhoods->take(8) as $neighborhood)
                                <li><a class="dropdown-item"
                                        href="{{ route('neighborhood.details', ['county' => slug($neighborhood->county->name), 'slug' => slug($neighborhood->name), 'id' => $neighborhood->id]) }}">{{ $neighborhood->name }}</a>
                                </li>
                            @endforeach
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('neighborhood') }}">View all neighborhoods</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarCondoDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Condo Buildings
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarCondoDropdown">
                            @foreach($allBuildings->take(8) as $building)
                                <li><a class="dropdown-item"
                                        href="{{ route('condo.building.details', building_route_params($building)) }}">{{ $building->name }}</a>
                                </li>
                            @endforeach
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('condo.building') }}">View all buildings</a>
                            </li>
                        </ul>
                    </li>
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarUserDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Account
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarUserDropdown">
                                <li><a class="dropdown-item" href="{{ route('user.home') }}">Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.profile.setting') }}">Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="{{ route('user.logout') }}">Logout</a></li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </nav>

    </div>
</div>

@push('script')
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

                const openPanel = () => {
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
                    if (input) {
                        input.value = '';
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
                    closeBtn.addEventListener('click', function (event) {
                        event.preventDefault();
                        event.stopPropagation();
                        closePanel();
                    });
                }

                panel.addEventListener('click', function (event) {
                    event.stopPropagation();
                });

                return { openPanel, closePanel };
            }

            // Configura todos os painéis
            const searchPanel = setupPanel('navbarSearchToggle', 'navbarSearchPanel', 'navbarSearchInput', 'navbarSearchClose');
            const neighborhoodPanel = setupPanel('navbarNeighborhoodToggle', 'navbarNeighborhoodPanel');
            const condoPanel = setupPanel('navbarCondoToggle', 'navbarCondoPanel');

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
                }
            });
        });
    </script>
@endpush

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
</style>
<!-- ==================== Header End Here ==================== -->