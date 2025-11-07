@php
    $tc = getContent('top_categories_buildings.content', true);
    
    // Use buildings from database with admin parameters
    try {
        $buildings = App\Models\Building::with(['neighborhood', 'buildingImages'])
            ->where('status', 1)
            ->inRandomOrder()
            ->take(10)
            ->get();

        // Verificar se temos buildings para mostrar
        if ($buildings->isEmpty()) {
            $buildings = collect(); // Collection vazia para evitar erros
        }
    } catch (Exception $e) {
        // Em caso de erro, usar collection vazia
        $buildings = collect();
    }
@endphp

<section class="top-categories-container pb-100" id="top-categories-buildings">
    <div class="container-fluid">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="tc-copy">
                    <h2 class="tc-title">{{ __($tc->data_values->heading ?? 'Explore premium buildings') }}</h2>
                    <p class="tc-subtitle">{{ __($tc->data_values->subheading_primary ?? 'Discover exclusive condominiums and luxury buildings. From modern high-rises to boutique residences.') }}</p>
                    <p class="tc-subtitle-secondary mb-4">{{ __($tc->data_values->subheading_secondary ?? 'Find your perfect home with stunning visuals.') }}</p>
                    <a href="{{ $tc->data_values->button_link ?? route('condo.building') }}" class="tc-button">{{ __($tc->data_values->button_text ?? 'Explore all buildings') }}</a>
                </div>
                
                <!-- Controles para desktop - dentro da primeira coluna -->
                <div class="tc-inline-controls tc-inline-controls-desktop mt-3 d-none d-lg-flex">
                    <div class="tc-nav-buttons">
                        <button class="tc-nav-btn tc-prev" type="button" aria-label="Previous">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="tc-nav-btn tc-next" type="button" aria-label="Next">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="tc-indicators" data-current="0">
                        <div class="tc-indicators-container"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div id="categoriesCarousel" class="tc-carousel">
                    <div class="tc-carousel-track">
                        @foreach ($buildings as $item)
                            @php
                                $cardImage = getImage(getFilePath('building') . '/' . $item->image);
                            @endphp
                            <a href="{{ route('condo.building.details', building_route_params($item)) }}"
                                class="tc-card"
                                data-preview-image="{{ $cardImage }}"
                                data-preview-label="{{ $item->name }}">
                                <img class="tc-card__img"
                                    src="{{ $cardImage }}"
                                    alt="{{ $item->name }}"
                                    draggable="false">
                                <div class="tc-card__label">{{ __($item->name) }}</div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Row 3: Controles (mobile only) -->
        <div class="row tc-row-controls-mobile">
            <div class="col-12">
                <div class="tc-inline-controls tc-inline-controls-mobile mt-3 d-flex d-lg-none">
                    <div class="tc-nav-buttons">
                        <button class="tc-nav-btn tc-prev" type="button" aria-label="Previous">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="tc-nav-btn tc-next" type="button" aria-label="Next">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="tc-indicators" data-current="0">
                        <div class="tc-indicators-container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    (function () {
        if (window.__tcCarouselInitializerDefined) {
            if (typeof window.initTopCategoriesCarousels === 'function') {
                window.initTopCategoriesCarousels();
            }
            return;
        }

        window.__tcCarouselInitializerDefined = true;

        const MAX_VISIBLE_INDICATORS = 5;

        function computeStartIndex(totalSlides, currentIndex, showCount) {
            if (totalSlides <= showCount) {
                return 0;
            }

            const buffer = Math.floor(showCount / 2);
            const maxStart = totalSlides - showCount;
            const raw = currentIndex - buffer;

            if (raw <= 0) {
                return 0;
            }
            if (raw >= maxStart) {
                return maxStart;
            }
            return raw;
        }

        function updateIndicatorClasses(button, distance) {
            button.classList.remove('is-active', 'is-near', 'is-far');
            if (distance === 0) {
                button.classList.add('is-active');
            } else if (distance === 1) {
                button.classList.add('is-near');
            } else {
                button.classList.add('is-far');
            }
        }

        function initSection(section) {
            if (!section || section.dataset.tcCarouselBound === 'true') {
                return;
            }

            const carousel = section.querySelector('.tc-carousel');
            const track = carousel ? carousel.querySelector('.tc-carousel-track') : null;
            const cards = track ? Array.from(track.querySelectorAll('.tc-card')) : [];
            const totalSlides = cards.length;

            if (!carousel || !track || totalSlides === 0) {
                section.dataset.tcCarouselBound = 'true';
                return;
            }

            const controlWrappers = Array.from(section.querySelectorAll('.tc-inline-controls'));
            const prevButtons = [];
            const nextButtons = [];
            const indicatorSets = [];

            controlWrappers.forEach((wrapper) => {
                if (!wrapper) {
                    return;
                }

                const prev = wrapper.querySelector('.tc-prev');
                const next = wrapper.querySelector('.tc-next');
                const container = wrapper.querySelector('.tc-indicators-container');

                if (prev) {
                    prevButtons.push(prev);
                }
                if (next) {
                    nextButtons.push(next);
                }
                if (container) {
                    const buttons = [];
                    container.innerHTML = '';

                    const slotCount = Math.min(MAX_VISIBLE_INDICATORS, totalSlides);
                    for (let i = 0; i < slotCount; i++) {
                        const button = document.createElement('button');
                        button.type = 'button';
                        button.className = 'tc-indicator';
                        button.dataset.slide = '0';
                        button.setAttribute('aria-current', 'false');
                        button.addEventListener('click', function () {
                        const target = Number(button.dataset.slide);
                        if (!Number.isNaN(target)) {
                            currentIndex = Math.max(0, Math.min(target, totalSlides - 1));
                            clickPos = currentIndex;          // espelha a navegação por cliques
                            applyTransform(true);
                        }
                        });
                        container.appendChild(button);
                        buttons.push(button);
                    }

                    indicatorSets.push({
                        container,
                        buttons,
                        lastStartIndex: null,
                        spacing: null,
                        animationTimer: null,
                    });
                }
            });

            let currentIndex = 0;      // 0..totalSlides-1
            let moveDistance = 0;      // largura 1 card + gap
            let resizeTimer;
            const SWIPE_THRESHOLD = 40;

            // Regra: com N slides, existem N-1 cliques possíveis
            let clickPos  = 0;
            const totalImages = totalSlides;
            let maxClicks = Math.max(0, totalImages - 1);

            function ensureSpacing(set) {
                if (!set) {
                    return 0;
                }

                if (set.spacing && Number.isFinite(set.spacing) && set.spacing !== 0) {
                    return set.spacing;
                }

                if (set.buttons.length > 1) {
                    const first = set.buttons[0];
                    const second = set.buttons[1];
                    set.spacing = Math.abs(second.offsetLeft - first.offsetLeft);
                }

                if (!set.spacing || !Number.isFinite(set.spacing) || set.spacing === 0) {
                    const computed = getComputedStyle(set.container);
                    set.spacing = parseFloat(computed.columnGap || computed.gap || '12') || 12;
                }

                return set.spacing;
            }

            function renderIndicators() {
                indicatorSets.forEach((set) => {
                    const buttons = set.buttons;
                    if (!buttons.length) {
                        return;
                    }

                    const showCount = buttons.length;
                    const maxSlideIndex = totalSlides - 1;

                    let startIndex = 0;
                    let allowCarouselShift = false;

                    if (totalSlides > showCount) {
                        const firstCarouselIndex = 2;
                        const lastStaticIndex = totalSlides - 3; // antepenúltimo slide (base 0)

                        if (currentIndex <= firstCarouselIndex) {
                            startIndex = 0;
                        } else if (currentIndex >= lastStaticIndex) {
                            startIndex = totalSlides - showCount;
                        } else {
                            startIndex = currentIndex - 2;
                            allowCarouselShift = true;
                        }
                    }

                    const shouldAnimate = allowCarouselShift && set.lastStartIndex !== null && set.lastStartIndex !== startIndex;

                    buttons.forEach((button, idx) => {
                        const slideIndex = Math.min(startIndex + idx, maxSlideIndex);
                        const distance = Math.abs(slideIndex - currentIndex);

                        button.dataset.slide = String(slideIndex);
                        button.setAttribute('aria-label', `Slide ${slideIndex + 1}`);
                        button.setAttribute('aria-current', distance === 0 ? 'true' : 'false');

                        updateIndicatorClasses(button, distance);
                    });

                    if (set.animationTimer) {
                        clearTimeout(set.animationTimer);
                        set.animationTimer = null;
                    }

                    if (shouldAnimate) {
                        const spacing = ensureSpacing(set);
                        const direction = startIndex > set.lastStartIndex ? -1 : 1;
                        const shift = spacing * direction;
                        const durationMs = 600;

                        set.container.style.transition = 'transform 0.6s ease-in-out';
                        set.container.style.transform = `translateX(${shift}px)`;

                        set.animationTimer = window.setTimeout(() => {
                            set.container.style.transition = 'none';
                            set.container.style.transform = 'translateX(0)';
                            set.animationTimer = null;
                        }, durationMs);
                    } else {
                        set.container.style.transition = 'none';
                        set.container.style.transform = 'translateX(0)';
                    }

                    set.lastStartIndex = startIndex;
                });
            }

            function updateNavButtons() {
                const atStart = clickPos === 0 || maxClicks === 0;
                const atEnd   = clickPos >= maxClicks || maxClicks === 0;

                prevButtons.forEach((btn) => {
                    btn.disabled = atStart;
                    btn.style.opacity = btn.disabled ? '0.5' : '1';
                });
                nextButtons.forEach((btn) => {
                    btn.disabled = atEnd;
                    btn.style.opacity = btn.disabled ? '0.5' : '1';
                });
            }

            function applyTransform(animate) {
                const offset = -(currentIndex * moveDistance);
                if (!animate) {
                    const previousTransition = track.style.transition;
                    track.style.transition = 'none';
                    track.style.transform = `translate3d(${offset}px, 0, 0)`;
                    void track.offsetWidth;
                    track.style.transition = previousTransition || 'transform 0.6s ease-in-out';
                } else {
                    track.style.transition = 'transform 0.6s ease-in-out';
                    track.style.transform = `translate3d(${offset}px, 0, 0)`;
                }

                renderIndicators();
                updateNavButtons();
            }

            function recalc() {
                const firstCard = track.querySelector('.tc-card');
                if (!firstCard) {
                    moveDistance = 0;
                    maxClicks = 0;
                    updateNavButtons();
                    return;
                }

                // reset indicadores
                indicatorSets.forEach((set) => {
                    if (set.animationTimer) {
                    clearTimeout(set.animationTimer);
                    set.animationTimer = null;
                    }
                    set.container.style.transition = 'none';
                    set.container.style.transform = 'translateX(0)';
                    set.lastStartIndex = null;
                    set.spacing = null;
                });

                const trackStyles = window.getComputedStyle(track);
                const gapValue = parseFloat(trackStyles.columnGap || trackStyles.gap || '0') || 0;
                const cardWidth = firstCard.getBoundingClientRect().width;

                moveDistance = cardWidth + gapValue;

                // Regra fixa: N -> N-1 cliques
                maxClicks = Math.max(0, totalSlides - 1);

                // coerência ao recalcular
                clickPos = Math.min(clickPos, maxClicks);
                currentIndex = clickPos;

                applyTransform(false);
            }

            function goNext() {
                if (maxClicks === 0) return;
                if (clickPos < maxClicks) {
                    clickPos++;
                    currentIndex = Math.min(currentIndex + 1, totalSlides - 1);
                    applyTransform(true);
                }
            }

            function goPrev() {
                if (maxClicks === 0) return;
                if (clickPos > 0) {
                    clickPos--;
                    currentIndex = Math.max(currentIndex - 1, 0);
                    applyTransform(true);
                }
            }

            nextButtons.forEach((btn) => {
                btn.addEventListener('click', goNext);
            });

            prevButtons.forEach((btn) => {
                btn.addEventListener('click', goPrev);
            });

            let pointerActive = false;
            let pointerId = null;
            let pointerStartX = 0;
            let pointerLastX = 0;

            function resetPointerState() {
                pointerActive = false;
                pointerId = null;
                pointerStartX = 0;
                pointerLastX = 0;
            }

            function handleSwipe(deltaX) {
                if (Math.abs(deltaX) < 40) {
                    return;
                }
                if (deltaX < 0) {
                    goNext();
                } else {
                    goPrev();
                }
            }

            function onPointerDown(event) {
                if (!track || totalSlides <= 1 || event.pointerType === 'mouse') {
                    return;
                }

                pointerActive = true;
                pointerId = event.pointerId;
                pointerStartX = event.clientX;
                pointerLastX = event.clientX;

                try {
                    track.setPointerCapture(pointerId);
                } catch (err) {
                    /* ignore */
                }
            }

            function onPointerMove(event) {
                if (!pointerActive || event.pointerId !== pointerId) {
                    return;
                }
                pointerLastX = event.clientX;
            }

            function onPointerUp(event) {
                if (!pointerActive || event.pointerId !== pointerId) {
                    return;
                }

                pointerLastX = event.clientX;
                const deltaX = pointerLastX - pointerStartX;

                try {
                    track.releasePointerCapture(event.pointerId);
                } catch (err) {
                    /* ignore */
                }

                resetPointerState();
                handleSwipe(deltaX);
            }

            function onPointerCancel(event) {
                if (!pointerActive || event.pointerId !== pointerId) {
                    return;
                }
                try {
                    track.releasePointerCapture(event.pointerId);
                } catch (err) {
                    /* ignore */
                }
                resetPointerState();
            }

            let touchStartX = null;
            let touchLastX = null;

            function onTouchStart(event) {
                if (!track || totalSlides <= 1) {
                    return;
                }
                const touch = event.touches[0];
                touchStartX = touch.clientX;
                touchLastX = touch.clientX;
            }

            function onTouchMove(event) {
                if (touchStartX === null) {
                    return;
                }
                const touch = event.touches[0];
                touchLastX = touch.clientX;
            }

            function onTouchEnd() {
                if (touchStartX === null || touchLastX === null) {
                    touchStartX = null;
                    touchLastX = null;
                    return;
                }
                const deltaX = touchLastX - touchStartX;
                touchStartX = null;
                touchLastX = null;
                handleSwipe(deltaX);
            }

            if (track) {
                track.addEventListener('pointerdown', onPointerDown, { passive: true });
                track.addEventListener('pointermove', onPointerMove, { passive: true });
                track.addEventListener('pointerup', onPointerUp, { passive: true });
                track.addEventListener('pointercancel', onPointerCancel, { passive: true });

                track.addEventListener('touchstart', onTouchStart, { passive: true });
                track.addEventListener('touchmove', onTouchMove, { passive: true });
                track.addEventListener('touchend', onTouchEnd, { passive: true });
                track.addEventListener('touchcancel', onTouchEnd, { passive: true });
            }

            recalc();

            function onResize() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(recalc, 150);
            }

            window.addEventListener('resize', onResize);
            window.addEventListener('load', recalc, { once: true });

            section.dataset.tcCarouselBound = 'true';
        }

        function initAll() {
            const sections = document.querySelectorAll('.top-categories-container');
            sections.forEach((section) => initSection(section));
        }

        window.initTopCategoriesCarousels = initAll;

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initAll);
        } else {
            initAll();
        }
    })();
</script>