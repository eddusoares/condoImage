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
                        <div class="tc-indicators">
                            @foreach ($buildingImages as $img)
                                <button type="button" class="tc-indicator {{ $loop->first ? 'active' : '' }}"
                                    data-slide="{{ $loop->index }}" aria-current="{{ $loop->first ? 'true' : 'false' }}"
                                    aria-label="Slide {{ $loop->iteration }}"></button>
                            @endforeach
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
                    <button class="tc-nav-btn tc-prev-mobile" type="button" aria-label="Previous">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="tc-nav-btn tc-next-mobile" type="button" aria-label="Next">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    </div>
                    <div class="tc-indicators">
                        @foreach ($buildingImages as $img)
                            <button type="button" class="tc-indicator-mobile {{ $loop->first ? 'active' : '' }}"
                                data-slide="{{ $loop->index }}" aria-current="{{ $loop->first ? 'true' : 'false' }}"
                                aria-label="Slide {{ $loop->iteration }}"></button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const track = document.querySelector('#buildingCarousel .tc-carousel-track');
  
  // Desktop controls
  const prevBtn = document.querySelector('.tc-prev');
  const nextBtn = document.querySelector('.tc-next');
  const indicators = document.querySelectorAll('.tc-indicator');
  
  // Mobile controls
  const prevBtnMobile = document.querySelector('.tc-prev-mobile');
  const nextBtnMobile = document.querySelector('.tc-next-mobile');
  const indicatorsMobile = document.querySelectorAll('.tc-indicator-mobile');
  
  if (!track) return;
  
  let currentIndex = 0;
  
  // Detectar se é mobile ou desktop
  const isMobile = window.innerWidth <= 991.98;
  const cardWidth = isMobile ? 260 : 400; // largura correta por breakpoint
  const gap = isMobile ? 16 : 40; // gap correto por breakpoint
  const move = cardWidth + gap;
  const total = Math.max(indicators.length, indicatorsMobile.length);
  const maxIndex = Math.max(0, total - 1); // corrigido para total - 1
  
  function update(){
    // Calcular a posição baseada no índice atual
    const translateValue = currentIndex * move;
    track.style.transform = `translateX(-${translateValue}px)`;
    
    // Update desktop indicators
    indicators.forEach((btn,i)=>{
      const active = i === currentIndex;
      btn.classList.toggle('active', active);
      btn.setAttribute('aria-current', active ? 'true' : 'false');
    });
    
    // Update mobile indicators
    indicatorsMobile.forEach((btn,i)=>{
      const active = i === currentIndex;
      btn.classList.toggle('active', active);
      btn.setAttribute('aria-current', active ? 'true' : 'false');
    });
  }
  
  // Desktop navigation
  nextBtn && nextBtn.addEventListener('click', ()=>{ 
    if(total<=2) return; 
    currentIndex = (currentIndex < maxIndex) ? currentIndex+1 : 0; 
    update(); 
  });
  prevBtn && prevBtn.addEventListener('click', ()=>{ 
    if(total<=2) return; 
    currentIndex = (currentIndex>0) ? currentIndex-1 : maxIndex; 
    update(); 
  });
  indicators.forEach((btn,i)=> btn.addEventListener('click', ()=>{ 
    if(total<=2) return; 
    currentIndex = Math.min(i, maxIndex); 
    update(); 
  }));
  
  // Mobile navigation
  nextBtnMobile && nextBtnMobile.addEventListener('click', ()=>{ 
    if(total<=2) return; 
    currentIndex = (currentIndex < maxIndex) ? currentIndex+1 : 0; 
    update(); 
  });
  prevBtnMobile && prevBtnMobile.addEventListener('click', ()=>{ 
    if(total<=2) return; 
    currentIndex = (currentIndex>0) ? currentIndex-1 : maxIndex; 
    update(); 
  });
  indicatorsMobile.forEach((btn,i)=> btn.addEventListener('click', ()=>{ 
    if(total<=2) return; 
    currentIndex = Math.min(i, maxIndex); 
    update(); 
  }));
  
  // Recalcular dimensões se a janela for redimensionada
  let resizeTimer;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      const newIsMobile = window.innerWidth <= 991.98;
      if (newIsMobile !== isMobile) {
        location.reload(); // Recarrega se mudar o breakpoint
      }
    }, 250);
  });
  
  update();
});
</script>
@endpush

