@php
    // Espera receber $neighborhoods (Collection) do include. Se não vier, carrega 10 aleatórios.
    try {
        if (!isset($neighborhoods) || $neighborhoods->isEmpty()) {
            $neighborhoods = App\Models\Neighborhood::with('county')->where('status', 1)->inRandomOrder()->take(10)->get();
        }

        // Verificar se temos neighborhoods para mostrar
        if ($neighborhoods->isEmpty()) {
            $neighborhoods = collect(); // Collection vazia para evitar erros
        }

        // Agrupar neighborhoods em chunks de 2 para o carousel
        $chunkedNeighborhoods = $neighborhoods->chunk(2);
    } catch (Exception $e) {
        // Em caso de erro, usar collection vazia
        $neighborhoods = collect();
        $chunkedNeighborhoods = collect();
    }
@endphp

<section class="top-categories-container pb-100">
    <div class="container-fluid">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="tc-copy">
                    <h2 class="tc-title">Stand out with better visuals</h2>
                    <p class="tc-subtitle">Discover premium images crafted for real estate professionals. From drone
                        shots to interiors and floor plans — all organized by building and neighborhood.</p>
                    <p class="tc-subtitle-secondary mb-4">Stand out from the competition with stunning, ready‑to‑use
                        visuals.</p>
                    <a href="{{ route('condo.building') }}" class="tc-button">Explore all buildings</a>
                </div>
                
                <!-- Controles para desktop - dentro da primeira coluna -->
                <div class="tc-inline-controls tc-inline-controls-desktop mt-3">
                    <div class="tc-nav-buttons">
                        <button class="tc-nav-btn tc-prev" type="button" aria-label="Previous">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="tc-nav-btn tc-next" type="button" aria-label="Next">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="tc-indicators" data-current="0">
                        <div class="tc-indicators-container">
                            @for ($i = 0; $i < 4; $i++)
                                <button type="button" class="tc-indicator {{ $i === 0 ? 'active' : '' }}" aria-current="{{ $i === 0 ? 'true' : 'false' }}" aria-label="Indicator {{ $i + 1 }}"></button>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div id="categoriesCarousel" class="tc-carousel">
                    <div class="tc-carousel-track">
                        @foreach ($neighborhoods as $item)
                            <a href="{{ route('neighborhood.details', ['county' => slug($item->county->name), 'slug' => slug($item->name), 'id' => $item->id]) }}"
                                class="tc-card">
                                <img class="tc-card__img"
                                    src="{{ getImage(getFilePath('neighborhood') . '/' . $item->image) }}"
                                    alt="{{ $item->name }}">
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
                <div class="tc-inline-controls tc-inline-controls-mobile mt-3">
                    <div class="tc-nav-buttons">
                        <button class="tc-nav-btn tc-prev" type="button" aria-label="Previous">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="tc-nav-btn tc-next" type="button" aria-label="Next">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="tc-indicators" data-current="0">
                        <div class="tc-indicators-container">
                            @for ($i = 0; $i < 4; $i++)
                                <button type="button" class="tc-indicator {{ $i === 0 ? 'active' : '' }}" aria-current="{{ $i === 0 ? 'true' : 'false' }}" aria-label="Indicator {{ $i + 1 }}"></button>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const carousel = document.querySelector('#categoriesCarousel');
        if (!carousel) {
            return;
        }

        const track = carousel.querySelector('.tc-carousel-track');
        const controlsDesktop = document.querySelector('.top-categories-container .tc-inline-controls-desktop');
        const controlsMobile = document.querySelector('.top-categories-container .tc-inline-controls-mobile');
        
        // Determinar qual conjunto de controles usar baseado na visibilidade
        const controls = window.getComputedStyle(controlsDesktop).display !== 'none' ? controlsDesktop : controlsMobile;
        
        const prevBtn = controls ? controls.querySelector('.tc-prev') : null;
        const nextBtn = controls ? controls.querySelector('.tc-next') : null;
        const indicators = controls ? controls.querySelectorAll('.tc-indicator') : [];
        const totalSlides = track ? track.querySelectorAll('.tc-card').length : 0;

            if (!track || indicators.length === 0) {
                return;
            }

            let currentIndex = 0;
            let moveDistance = 0;
            let maxIndex = 0;
            let resizeTimer;

        function updateIndicators() {
            // Atualizar indicadores em ambos os conjuntos de controles
            const allIndicatorsDesktop = controlsDesktop ? controlsDesktop.querySelectorAll('.tc-indicator') : [];
            const allIndicatorsMobile = controlsMobile ? controlsMobile.querySelectorAll('.tc-indicator') : [];
            
            [allIndicatorsDesktop, allIndicatorsMobile].forEach(indicatorSet => {
                indicatorSet.forEach(function (indicator, index) {
                    const isActive = index === (currentIndex % 4);
                    indicator.classList.toggle('active', isActive);
                    indicator.setAttribute('aria-current', isActive ? 'true' : 'false');
                });
            });
            
            // Atualizar carrossel de indicadores (máximo 4 visíveis)
            updateIndicatorsCarousel();
        }            function updateIndicatorsCarousel() {
                const indicatorsContainer = controls ? controls.querySelector('.tc-indicators') : null;
                if (!indicatorsContainer || indicators.length <= 4) {
                    return;
                }

                // Calcular qual indicador deve estar visível na primeira posição
                let indicatorOffset = Math.max(0, Math.min(currentIndex - 1, indicators.length - 4));
                
                // Se estamos nos últimos slides, manter os últimos 4 indicadores visíveis
                if (currentIndex >= indicators.length - 2) {
                    indicatorOffset = indicators.length - 4;
                }
                
                indicatorsContainer.setAttribute('data-current', indicatorOffset.toString());
            }        function applyTransform(animate) {
            const offset = -(currentIndex * moveDistance);
            if (!animate) {
                const previousTransition = track.style.transition;
                track.style.transition = 'none';
                track.style.transform = 'translateX(' + offset + 'px)';
                void track.offsetWidth;
                track.style.transition = previousTransition || 'transform 0.6s ease-in-out';
            } else {
                track.style.transition = 'transform 0.6s ease-in-out';
                track.style.transform = 'translateX(' + offset + 'px)';
            }

            updateIndicators();

            if (prevBtn) {
                prevBtn.disabled = maxIndex === 0;
            }

            if (nextBtn) {
                nextBtn.disabled = maxIndex === 0;
            }
        }

        function recalc() {
            const firstCard = track.querySelector('.tc-card');
            if (!firstCard) {
                return;
            }

            const trackStyles = window.getComputedStyle(track);
            const gapValue = parseFloat(trackStyles.columnGap || trackStyles.gap || '0') || 0;
            const cardWidth = firstCard.getBoundingClientRect().width;

            moveDistance = cardWidth + gapValue;

            const visibleWidth = carousel.getBoundingClientRect().width;
            const visibleCount = Math.max(1, Math.round((visibleWidth + gapValue) / (moveDistance || 1)));

            maxIndex = Math.max(0, totalSlides - visibleCount);
            if (currentIndex > maxIndex) {
                currentIndex = maxIndex;
            }

            applyTransform(false);
        }

        // Event listeners para ambos os conjuntos de controles
        [controlsDesktop, controlsMobile].forEach(controlSet => {
            if (!controlSet) return;
            
            const prevBtnSet = controlSet.querySelector('.tc-prev');
            const nextBtnSet = controlSet.querySelector('.tc-next');
            const indicatorsSet = controlSet.querySelectorAll('.tc-indicator');

            if (nextBtnSet) {
                nextBtnSet.addEventListener('click', function () {
                    if (maxIndex === 0) {
                        return;
                    }

                    currentIndex = currentIndex < maxIndex ? currentIndex + 1 : 0;
                    applyTransform(true);
                });
            }

            if (prevBtnSet) {
                prevBtnSet.addEventListener('click', function () {
                    if (maxIndex === 0) {
                        return;
                    }

                    currentIndex = currentIndex > 0 ? currentIndex - 1 : maxIndex;
                    applyTransform(true);
                });
            }

            indicatorsSet.forEach(function (indicator, index) {
                indicator.addEventListener('click', function () {
                    const groupStart = currentIndex - (currentIndex % 4);
                    currentIndex = Math.min(groupStart + index, maxIndex);
                    applyTransform(true);
                });
            });
        });

        recalc();
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(recalc, 150);
        });
    });
</script>
