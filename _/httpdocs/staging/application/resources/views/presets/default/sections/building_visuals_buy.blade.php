@php
    try {
        $buildingImages = ($building->buildingImages ?? collect())->pluck('image');
    } catch (Exception $e) {
        $buildingImages = collect();
    }
@endphp

<section class="top-categories-container pb-100">
    <div class="container-fluid">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="download-image-collection-card">
                    <h4 class="download-card-title">Download Image Collection</h4>

                    <div class="download-card-main-row">
                        <div class="download-card-price-section">
                            <span class="download-card-price">${{ $building->price ?? '49' }}</span>
                        </div>
                        <div class="download-card-info-section">
                            <div class="download-card-count">{{ $building->buildingImages->count() ?? '29' }} images</div>
                            <div class="download-card-description">high-res images of {{ $building->name }}, ready to impress.</div>
                        </div>
                    </div>

                    <p class="download-card-subtitle">Perfect for listings, brochures, and social media.</p>

                    <form action="{{ route('user.condo.building.payment') }}" method="POST" class="download-form">
                        @csrf
                        <input type="hidden" name="condo_building_id" value="{{ $building->id }}">
                        <input type="hidden" name="payment" value="2">
                        <button type="submit" class="download-card-button">Buy</button>
                    </form>
                </div>

                @if($buildingImages->count() > 0)
                    <div class="tc-inline-controls mt-4 d-none d-lg-flex">
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
                @endif
            </div>

            <div class="col-lg-6">
                <div id="buildingCarousel" class="tc-carousel">
                    <div class="tc-carousel-track">
                        @if($buildingImages->count())
                            @foreach ($buildingImages as $img)
                                <div class="tc-card">
                                    <img class="tc-card__img" src="{{ getImage(getFilePath('building') . '/' . $img) }}" alt="{{ $building->name }}">
                                    <div class="tc-card__label">{{ __($building->name) }}</div>
                                </div>
                            @endforeach
                        @else
                            <div class="tc-card">
                                <img class="tc-card__img" src="{{ getImage(getFilePath('building') . '/' . $building->image) }}" alt="{{ $building->name }}">
                                <div class="tc-card__label">{{ __($building->name) }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mobile Controls Section -->
        @if($buildingImages->count() > 0)
        <div class="row d-lg-none">
            <div class="col-12">
                <div class="tc-inline-controls mt-4">
                    <div class="tc-nav-buttons">
                        <button class="tc-nav-btn tc-prev tc-prev-mobile" type="button" aria-label="Previous">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="tc-nav-btn tc-next tc-next-mobile" type="button" aria-label="Next">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="tc-indicators" data-current="0">
                        <div class="tc-indicators-container"></div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

@push('script')
<script>
function initBuildingVisualsCarousel() {
    const carousel = document.querySelector('#buildingCarousel');
    if (!carousel) return;

    const section = carousel.closest('.top-categories-container');
    if (!section) return;

    const track = carousel.querySelector('.tc-carousel-track');
    if (!track) return;

    const cards = Array.from(track.querySelectorAll('.tc-card'));
    const totalSlides = cards.length;
    if (totalSlides === 0) return;

    track.style.touchAction = 'pan-y';
    track.style.msTouchAction = 'pan-y';

    const controlWrappers = Array.from(section.querySelectorAll('.tc-inline-controls'));
    const prevButtons = [];
    const nextButtons = [];
    const indicatorSets = [];
    const MAX_VISIBLE_INDICATORS = 5;
    const SWIPE_THRESHOLD = 40;
    const supportsPointerEvents = 'PointerEvent' in window;

    controlWrappers.forEach((wrapper) => {
        if (!wrapper) return;

        const prev = wrapper.querySelector('.tc-prev');
        const next = wrapper.querySelector('.tc-next');
        const container = wrapper.querySelector('.tc-indicators-container');

        if (prev) prevButtons.push(prev);
        if (next) nextButtons.push(next);

        if (container) {
            container.innerHTML = '';

            const buttons = [];
            const slotCount = Math.min(MAX_VISIBLE_INDICATORS, totalSlides);

            for (let i = 0; i < slotCount; i++) {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'tc-indicator';
                button.dataset.slide = '0';
                button.setAttribute('aria-current', 'false');
                button.addEventListener('click', function () {
                    const target = Number(button.dataset.slide);
                    if (Number.isNaN(target)) return;
                    currentIndex = Math.max(0, Math.min(target, totalSlides - 1));
                    currentIndex = Math.min(currentIndex, maxIndex);
                    applyTransform(true);
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

    if (!indicatorSets.length && !prevButtons.length && !nextButtons.length) {
        return;
    }

    let currentIndex = 0;
    let moveDistance = 0;
    let maxIndex = Math.max(0, totalSlides - 1);
    let resizeTimer;

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
            const computed = window.getComputedStyle(set.container);
            set.spacing = parseFloat(computed.columnGap || computed.gap || '12') || 12;
        }

        return set.spacing;
    }

    function renderIndicators() {
        indicatorSets.forEach((set) => {
            const { buttons, container } = set;
            if (!buttons.length) {
                return;
            }

            const showCount = buttons.length;
            const maxSlideIndex = totalSlides - 1;

            let startIndex = 0;
            let allowCarouselShift = false;

            if (totalSlides > showCount) {
                const middle = Math.floor(showCount / 2);
                const lastStaticIndex = totalSlides - (showCount - middle);

                if (currentIndex <= middle) {
                    startIndex = 0;
                } else if (currentIndex >= lastStaticIndex) {
                    startIndex = totalSlides - showCount;
                } else {
                    startIndex = currentIndex - middle;
                    allowCarouselShift = true;
                }
            }

            const shouldAnimate =
                allowCarouselShift && set.lastStartIndex !== null && set.lastStartIndex !== startIndex;

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

                container.style.transition = 'transform 0.6s ease-in-out';
                container.style.transform = `translateX(${shift}px)`;

                set.animationTimer = window.setTimeout(() => {
                    container.style.transition = 'none';
                    container.style.transform = 'translateX(0)';
                    set.animationTimer = null;
                }, 600);
            } else {
                container.style.transition = 'none';
                container.style.transform = 'translateX(0)';
            }

            set.lastStartIndex = startIndex;
        });
    }

    function updateNavButtons() {
        const disabled = maxIndex === 0;
        prevButtons.forEach((btn) => {
            btn.disabled = disabled;
        });
        nextButtons.forEach((btn) => {
            btn.disabled = disabled;
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

    function goNext() {
        if (maxIndex === 0) {
            return;
        }
        currentIndex = currentIndex < maxIndex ? currentIndex + 1 : 0;
        applyTransform(true);
    }

    function goPrev() {
        if (maxIndex === 0) {
            return;
        }
        currentIndex = currentIndex > 0 ? currentIndex - 1 : maxIndex;
        applyTransform(true);
    }

    function handleSwipe(deltaX) {
        if (maxIndex === 0) {
            return;
        }

        if (deltaX <= -SWIPE_THRESHOLD) {
            goNext();
        } else if (deltaX >= SWIPE_THRESHOLD) {
            goPrev();
        }
    }

    function resetIndicators() {
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
    }

    function recalc() {
        if (!cards.length) {
            return;
        }

        resetIndicators();

        const firstCard = track.querySelector('.tc-card');
        if (!firstCard) {
            moveDistance = 0;
            maxIndex = 0;
            updateNavButtons();
            return;
        }

        const trackStyles = window.getComputedStyle(track);
        const gapValue = parseFloat(trackStyles.columnGap || trackStyles.gap || '0') || 0;
        const cardRect = firstCard.getBoundingClientRect();
        moveDistance = cardRect.width + gapValue;

        const carouselRect = carousel.getBoundingClientRect();
        const visibleCount = Math.max(1, Math.floor((carouselRect.width + gapValue) / (moveDistance || 1)));

        maxIndex = Math.max(0, totalSlides - visibleCount);
        if (currentIndex > maxIndex) {
            currentIndex = maxIndex;
        }

        applyTransform(false);
    }

    if (supportsPointerEvents) {
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

        track.addEventListener('pointerdown', function (event) {
            if (event.pointerType !== 'touch' && event.pointerType !== 'pen') {
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
        });

        track.addEventListener('pointermove', function (event) {
            if (!pointerActive || event.pointerId !== pointerId) {
                return;
            }
            pointerLastX = event.clientX;
        });

        function handlePointerEnd(event) {
            if (!pointerActive || event.pointerId !== pointerId) {
                return;
            }
            pointerLastX = event.clientX;
            try {
                track.releasePointerCapture(event.pointerId);
            } catch (err) {
                /* ignore */
            }
            const deltaX = pointerLastX - pointerStartX;
            resetPointerState();
            handleSwipe(deltaX);
        }

        track.addEventListener('pointerup', handlePointerEnd);
        track.addEventListener('pointercancel', function (event) {
            if (!pointerActive || event.pointerId !== pointerId) {
                return;
            }
            try {
                track.releasePointerCapture(event.pointerId);
            } catch (err) {
                /* ignore */
            }
            resetPointerState();
        });
    } else {
        let touchStartX = null;
        track.addEventListener('touchstart', function (event) {
            if (event.touches.length !== 1) {
                return;
            }
            touchStartX = event.touches[0].clientX;
        }, { passive: true });

        track.addEventListener('touchend', function (event) {
            if (touchStartX === null) {
                return;
            }
            const touch = event.changedTouches[0];
            const deltaX = touch.clientX - touchStartX;
            touchStartX = null;
            handleSwipe(deltaX);
        }, { passive: true });

        track.addEventListener('touchcancel', function () {
            touchStartX = null;
        }, { passive: true });
    }

    prevButtons.forEach((btn) => btn.addEventListener('click', goPrev));
    nextButtons.forEach((btn) => btn.addEventListener('click', goNext));

    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = window.setTimeout(recalc, 150);
    });

    recalc();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initBuildingVisualsCarousel);
} else {
    initBuildingVisualsCarousel();
}
</script>
@endpush
