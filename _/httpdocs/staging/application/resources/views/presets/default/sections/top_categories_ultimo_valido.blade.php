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

                    <div class="tc-inline-controls mt-3">
                        <button class="tc-nav-btn tc-prev" type="button" aria-label="Previous">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="tc-nav-btn tc-next" type="button" aria-label="Next">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        <div class="tc-indicators">
                            @foreach ($neighborhoods as $item)
                                <button type="button" class="tc-indicator {{ $loop->first ? 'active' : '' }}"
                                    data-slide="{{ $loop->index }}" aria-current="{{ $loop->first ? 'true' : 'false' }}"
                                    aria-label="Slide {{ $loop->iteration }}"></button>
                            @endforeach
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
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const track = document.querySelector('.tc-carousel-track');
        const prevBtn = document.querySelector('.tc-prev');
        const nextBtn = document.querySelector('.tc-next');
        const indicators = document.querySelectorAll('.tc-indicator');

        let currentIndex = 0;
        const cardWidth = 492; // largura da imagem
        const gap = 40; // espaçamento entre imagens
        const moveDistance = cardWidth + gap; // distância para mover (532px)
        const totalCards = indicators.length;
        const maxIndex = totalCards - 2; // máximo para mostrar 2 imagens completas

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
        nextBtn.addEventListener('click', function () {
            if (currentIndex < maxIndex) {
                currentIndex++;
            } else {
                currentIndex = 0; // volta para o início
            }
            updateCarousel();
        });

        // Botão prev
        prevBtn.addEventListener('click', function () {
            if (currentIndex > 0) {
                currentIndex--;
            } else {
                currentIndex = maxIndex; // vai para o final
            }
            updateCarousel();
        });

        // Indicadores
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', function () {
                currentIndex = Math.min(index, maxIndex);
                updateCarousel();
            });
        });

        // Inicializar
        updateCarousel();
    });
</script>