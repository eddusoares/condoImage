@php
    // Para a página de building details, mostramos buildings relacionados do mesmo neighborhood
    try {
        if (!isset($relatedBuildings) || $relatedBuildings->isEmpty()) {
            // Se não vier $relatedBuildings, busca outros buildings do mesmo neighborhood
            $relatedBuildings = App\Models\Building::with('neighborhood.county')
                ->where('neighborhood_id', $building->neighborhood_id)
                ->where('id', '!=', $building->id)
                ->where('status', 1)
                ->take(6)
                ->get();
        }

        // Verificar se temos buildings para mostrar
        if ($relatedBuildings->isEmpty()) {
            $relatedBuildings = collect(); // Collection vazia para evitar erros
        }
    } catch (Exception $e) {
        // Em caso de erro, usar collection vazia
        $relatedBuildings = collect();
    }
@endphp

<section class="top-categories-container pb-100">
    <div class="container-fluid">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="download-image-collection-card">
                    <!-- Título -->
                    <h4 class="download-card-title">Download Image Collection</h4>

                    <!-- Row com Preço à esquerda e Info à direita -->
                    <div class="download-card-main-row">
                        <div class="download-card-price-section">
                            <span class="download-card-price">${{ $building->price ?? '49' }}</span>
                        </div>
                        <div class="download-card-info-section">
                            <div class="download-card-count">{{ $building->buildingImages->count() ?? '29' }} images
                            </div>
                            <div class="download-card-description">High-res images of {{ $building->name }}, ready to
                                impress.</div>
                        </div>
                    </div>

                    <!-- Subtitle -->
                    <p class="download-card-subtitle">Perfect for listings, brochures, and social media.</p>

                    <!-- Botão -->
                    <form action="{{ route('user.condo.building.payment') }}" method="POST" class="download-form">
                        @csrf
                        <input type="hidden" name="condo_building_id" value="{{ $building->id }}">
                        <input type="hidden" name="payment" value="2">
                        <button type="submit" class="download-card-button">Buy</button>
                    </form>
                </div>

                @if($relatedBuildings->count() > 0)
                    <div class="tc-inline-controls mt-4">
                        <button class="tc-nav-btn tc-prev" type="button" aria-label="Previous">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="tc-nav-btn tc-next" type="button" aria-label="Next">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        <div class="tc-indicators">
                            @foreach ($relatedBuildings as $item)
                                <button type="button" class="tc-indicator {{ $loop->first ? 'active' : '' }}"
                                    data-slide="{{ $loop->index }}" aria-current="{{ $loop->first ? 'true' : 'false' }}"
                                    aria-label="Slide {{ $loop->iteration }}"></button>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-6">
                @if($relatedBuildings->count() > 0)
                    <div id="buildingCarousel" class="tc-carousel">
                        <div class="tc-carousel-track">
                            @foreach ($relatedBuildings as $item)
                                <a href="{{ route('condo.building.details', building_route_params($item)) }}" class="tc-card">
                                    <img class="tc-card__img" src="{{ getImage(getFilePath('building') . '/' . $item->image) }}"
                                        alt="{{ $item->name }}">
                                    <div class="tc-card__label">{{ __($item->name) }}</div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <!-- Fallback: Mostrar imagem do próprio building se não há relacionados -->
                    <div class="tc-carousel">
                        <div class="tc-card">
                            <img class="tc-card__img" src="{{ getImage(getFilePath('building') . '/' . $building->image) }}"
                                alt="{{ $building->name }}">
                            <div class="tc-card__label">{{ __($building->name) }}</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<script>
    // Função para rolar até a seção de download
    function scrollToDownload() {
        const downloadSection = document.querySelector('.download-collection-section, .download-section');
        if (downloadSection) {
            downloadSection.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const track = document.querySelector('#buildingCarousel .tc-carousel-track');
        const prevBtn = document.querySelector('.tc-prev');
        const nextBtn = document.querySelector('.tc-next');
        const indicators = document.querySelectorAll('.tc-indicator');

        // Só executar se houver carousel
        if (!track || indicators.length === 0) return;

        let currentIndex = 0;
        const cardWidth = 492; // largura da imagem
        const gap = 40; // espaçamento entre imagens
        const moveDistance = cardWidth + gap; // distância para mover (532px)
        const totalCards = indicators.length;
        const maxIndex = Math.max(0, totalCards - 2); // máximo para mostrar 2 imagens completas

        function updateCarousel() {
            const translateX = -(currentIndex * moveDistance);
            track.style.transform = `translateX(${translateX}px)`;

            // Atualizar indicadores
            indicators.forEach((indicator, index) => {
                indicator.classList.toggle('active', index === currentIndex);
                indicator.setAttribute('aria-current', index === currentIndex ? 'true' : 'false');
            });
        }

        // Botão next
        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                if (totalCards <= 2) return; // Não navegar se só tem 1-2 items

                if (currentIndex < maxIndex) {
                    currentIndex++;
                } else {
                    currentIndex = 0; // volta para o início
                }
                updateCarousel();
            });
        }

        // Botão prev
        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                if (totalCards <= 2) return; // Não navegar se só tem 1-2 items

                if (currentIndex > 0) {
                    currentIndex--;
                } else {
                    currentIndex = maxIndex; // vai para o final
                }
                updateCarousel();
            });
        }

        // Indicadores
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', function () {
                if (totalCards <= 2) return; // Não navegar se só tem 1-2 items

                currentIndex = Math.min(index, maxIndex);
                updateCarousel();
            });
        });

        // Inicializar
        updateCarousel();
    });
</script>
