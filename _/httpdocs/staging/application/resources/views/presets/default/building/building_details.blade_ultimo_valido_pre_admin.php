@extends($activeTemplate . 'layouts.frontend')
@section('content')

@php
    // Prefer building images; fallback to the building cover image duplicated
    $heroImages = $building->buildingImages?->pluck('image')->take(10) ?? collect();
    
    // Default images used in carousels throughout the page
    $defaultImages = optional($building->buildingImages)->pluck('image');
    if(!$defaultImages || $defaultImages->isEmpty()){
        $defaultImages = collect([$building->image]);
    }
@endphp

<!-- Hero Building Section (carousel like others) -->
<section id="buildingDetailsHeroCarousel" class="banner-section-two carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
    <div class="carousel-indicators" id="buildingDetailsHeroIndicators">
        @for ($i = 0; $i < 4; $i++)
            <button type="button" class="{{ $i === 0 ? 'active' : '' }}" data-virtual-index="{{ $i }}"
                aria-current="{{ $i === 0 ? 'true' : 'false' }}" aria-label="Indicator {{ $i + 1 }}"></button>
        @endfor
    </div>

    <div class="carousel-inner">
        @if ($heroImages->count())
            @foreach ($heroImages as $img)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="banner-thumb bg-img bg-overlay py-120" data-background="{{ getImage(getFilePath('building') . '/' . $img) }}"></div>
                </div>
            @endforeach
        @else
            @for ($i = 0; $i < 2; $i++)
                <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                    <div class="banner-thumb bg-img bg-overlay py-120" data-background="{{ getImage(getFilePath('building') . '/' . $building->image) }}"></div>
                </div>
            @endfor
        @endif
    </div>

    <!-- Overlay content -->
    <div class="hero-static-content">
        <div class="neigh-hero__content">
            <div class="neigh-hero__breadcrumb">
                <a href="{{ route('home') }}" class="breadcrumb-home">Home</a>
                <span class="breadcrumb-pipe"></span>
                <a href="{{ route('county', ['slug' => slug($building->neighborhood->county->name), 'id' => $building->neighborhood->county->id]) }}" class="breadcrumb-county">{{ $building->neighborhood->county->name }}</a>
                <span class="breadcrumb-pipe"></span>
                <a href="{{ route('neighborhood.details', ['county' => slug($building->neighborhood->county->name), 'slug' => slug($building->neighborhood->name), 'id' => $building->neighborhood->id]) }}" class="breadcrumb-section">{{ $building->neighborhood->name }}</a>
                <span class="breadcrumb-pipe"></span>
                <span class="breadcrumb-current">{{ $building->name }}</span>
            </div>
            
            <!-- Building Information -->
            <div class="building-hero__neighborhood">{{ $building->neighborhood->name }}</div>
            <h1 class="building-hero__title">{{ __($building->name) }}</h1>
            <div class="building-hero__address">{{ $building->address ?? $building->neighborhood->name . ', ' . $building->neighborhood->county->name }}</div>
        </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#buildingDetailsHeroCarousel" data-bs-slide="prev" aria-label="Previous">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#buildingDetailsHeroCarousel" data-bs-slide="next" aria-label="Next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</section>

<!-- Professional Real Estate Photography -->
@include('presets.default.sections.building_visuals_buy', ['building' => $building])

<!-- Container para reordenação mobile das 3 seções -->
<div class="mobile-reorder-container">

<!-- How it works -->
@include('presets.default.sections.work_process')

<!-- All Images for [Building Name] -->
<section class="building-images-showcase" id="building-images">
    <div class="container">
        <!-- Accordion Header -->
        <div class="info-section building-gallery-section">
            <div class="info-section__header">
                <h3>All images for {{ $building->name }}</h3>
                <button class="info-section__toggle active">-</button>
            </div>
            <div class="info-section__content" style="display: block;">
                @php
                    $galleryImages = optional($building->buildingImages)->pluck('image');
                    if(!$galleryImages || $galleryImages->isEmpty()){
                        $galleryImages = collect([$building->image]);
                    }
                @endphp
                
                <!-- Row 1: Galeria de 3 imagens com navegação -->
                <div class="main-gallery-container" data-gallery="main" data-images='@json($galleryImages->toArray())'>
                    <div class="accordion-gallery-row" id="main-gallery-row">
                        @if($galleryImages->isNotEmpty())
                            @foreach($galleryImages->take(3) as $index => $img)
                                <div class="accordion-gallery-item"
                                     style="background-image: url('{{ getImage(getFilePath('building') . '/' . $img) }}');">
                                </div>
                            @endforeach
                        @else
                            <!-- Fallback com imagem padrão -->
                            @for($i = 0; $i < 3; $i++)
                                <div class="accordion-gallery-item"
                                     style="background-image: url('{{ getImage(getFilePath('building') . '/' . $building->image) }}');">
                                </div>
                            @endfor
                        @endif
                    </div>
                    
                    <!-- Botões de navegação lateral -->
                    <button class="main-gallery-prev" type="button" aria-label="Previous images">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="main-gallery-next" type="button" aria-label="Next images">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>

                <!-- Row 2: Área de compra em 2 colunas -->
                <div class="accordion-buy-row">
                    <!-- Primeira row: Apenas o título -->
                    <div class="accordion-buy-left">
                        <h3 class="accordion-buy-title">Download Image Collection</h3>
                    </div>

                    <!-- Segunda row: Grid com preço, contagem e descrição -->
                    <div class="accordion-buy-right">
                        <div class="accordion-buy-pricing">
                            <div class="accordion-buy-price">${{ $building->price ?? '49' }}</div>
                        </div>
                        <div class="accordion-buy-count">{{ $building->buildingImages->count() ?? '29' }} images</div>
                        <div class="accordion-buy-details">
                            <div class="accordion-buy-description">high-res images of {{ $building->name }}, ready to impress.</div>
                        </div>
                        
                        <!-- Terceira row: Texto antes do botão -->
                        <p class="accordion-buy-subtitle">Perfect for listings, brochures, and social media.</p>
                        
                        <form action="{{ route('user.condo.building.payment') }}" method="POST" class="accordion-buy-form">
                            @csrf
                            <input type="hidden" name="condo_building_id" value="{{ $building->id }}">
                            <input type="hidden" name="payment" value="2">
                            <button type="submit" class="accordion-buy-btn">Buy</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Building Information Sections -->
<section class="building-info-sections">
    <div class="container">
        <!-- Footage -->
        <div class="info-section">
            <div class="info-section__header">
                <h3>Footage</h3>
                <button class="info-section__toggle">+</button>
            </div>
            <div class="info-section__content" style="display: none;">
                @php
                    $footageImages = $defaultImages;
                @endphp
                
                <!-- Row 1: Galeria de 3 imagens com navegação -->
                <div class="gallery-container" data-gallery="footage" data-images='@json($defaultImages->toArray())'>
                    <div class="accordion-gallery-row" id="footage-gallery-row">
                        @if($footageImages->isNotEmpty())
                            @foreach($footageImages->take(3) as $index => $imageName)
                                <div class="accordion-gallery-item"
                                     style="background-image: url('{{ getImage(getFilePath('building') . '/' . $imageName) }}');">
                                </div>
                            @endforeach
                        @else
                            <!-- Fallback com imagem padrão -->
                            @for($i = 0; $i < 3; $i++)
                                <div class="accordion-gallery-item"
                                     style="background-image: url('{{ getImage(getFilePath('building') . '/' . $building->image) }}');">
                                </div>
                            @endfor
                        @endif
                    </div>
                    
                    <!-- Botões de navegação lateral -->
                    <button class="gallery-prev" type="button" aria-label="Previous images">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="gallery-next" type="button" aria-label="Next images">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>

                <!-- Row 2: Área de compra em 2 colunas -->
                <div class="accordion-buy-row">
                    <!-- Coluna esquerda: Títulos -->
                    <div class="accordion-buy-left">
                        <h3 class="accordion-buy-title">Download Image Collection</h3>
                        <p class="accordion-buy-subtitle">Perfect for listings, brochures, and social media.</p>
                    </div>

                    <!-- Coluna direita: Preço e botão -->
                    <div class="accordion-buy-right">
                        <div class="accordion-buy-pricing">
                            <div class="accordion-buy-price">${{ $building->price ?? '49' }}</div>
                            <div class="accordion-buy-details">
                                <div class="accordion-buy-count">{{ $building->buildingImages->count() ?? '29' }} images</div>
                                <div class="accordion-buy-description">High-res images of {{ $building->name }}, ready to impress.</div>
                            </div>
                        </div>
                        
                        <form action="{{ route('user.condo.building.payment') }}" method="POST" class="accordion-buy-form">
                            @csrf
                            <input type="hidden" name="condo_building_id" value="{{ $building->id }}">
                            <input type="hidden" name="payment" value="2">
                            <button type="submit" class="accordion-buy-btn">Buy</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Renderings -->
        <div class="info-section">
            <div class="info-section__header">
                <h3>Renderings</h3>
                <button class="info-section__toggle disabled">+</button>
            </div>
        </div>

        <!-- Social media -->
        <div class="info-section">
            <div class="info-section__header">
                <h3>Social media</h3>
                <button class="info-section__toggle disabled">+</button>
            </div>
        </div>

        <!-- Lobby -->
        <div class="info-section">
            <div class="info-section__header">
                <h3>Lobby</h3>
                <button class="info-section__toggle disabled">+</button>
            </div>
        </div>

        <!-- Amenities -->
        <div class="info-section">
            <div class="info-section__header">
                <h3>Amenities</h3>
                <button class="info-section__toggle disabled">+</button>
            </div>
        </div>

        <!-- Drone Aerial -->
        <div class="info-section">
            <div class="info-section__header">
                <h3>Drone Aerial</h3>
                <button class="info-section__toggle disabled">+</button>
            </div>
        </div>

        <!-- Listing Images -->
        <div class="info-section">
            <div class="info-section__header">
                <h3>Listing Images</h3>
                <button class="info-section__toggle">+</button>
            </div>
            <div class="info-section__content" style="display: none;">
                @php
                    $listingImages = $defaultImages;
                @endphp
                
                <!-- Row 1: Galeria de 3 imagens com navegação -->
                <div class="gallery-container" data-gallery="listing" data-images='@json($defaultImages->toArray())'>
                    <div class="accordion-gallery-row" id="listing-gallery-row">
                        @if($listingImages->isNotEmpty())
                            @foreach($listingImages->take(3) as $index => $imageName)
                                <div class="accordion-gallery-item"
                                     style="background-image: url('{{ getImage(getFilePath('building') . '/' . $imageName) }}');">
                                </div>
                            @endforeach
                        @else
                            <!-- Fallback com imagem padrão -->
                            @for($i = 0; $i < 3; $i++)
                                <div class="accordion-gallery-item"
                                     style="background-image: url('{{ getImage(getFilePath('building') . '/' . $building->image) }}');">
                                </div>
                            @endfor
                        @endif
                    </div>
                    
                    <!-- Botões de navegação lateral -->
                    <button class="gallery-prev" type="button" aria-label="Previous images">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="gallery-next" type="button" aria-label="Next images">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>

                <!-- Row 2: Área de compra em 2 colunas -->
                <div class="accordion-buy-row">
                    <!-- Coluna esquerda: Títulos -->
                    <div class="accordion-buy-left">
                        <h3 class="accordion-buy-title">Download Image Collection</h3>
                        <p class="accordion-buy-subtitle">Perfect for listings, brochures, and social media.</p>
                    </div>

                    <!-- Coluna direita: Preço e botão -->
                    <div class="accordion-buy-right">
                        <div class="accordion-buy-pricing">
                            <div class="accordion-buy-price">${{ $building->price ?? '49' }}</div>
                            <div class="accordion-buy-details">
                                <div class="accordion-buy-count">{{ $building->buildingImages->count() ?? '29' }} images</div>
                                <div class="accordion-buy-description">High-res images of {{ $building->name }}, ready to impress.</div>
                            </div>
                        </div>
                        
                        <form action="{{ route('user.condo.building.payment') }}" method="POST" class="accordion-buy-form">
                            @csrf
                            <input type="hidden" name="condo_building_id" value="{{ $building->id }}">
                            <input type="hidden" name="payment" value="2">
                            <button type="submit" class="accordion-buy-btn">Buy</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="info-section">
            <div class="info-section__header">
                <h3>Details</h3>
                <button class="info-section__toggle">+</button>
            </div>
            <div class="info-section__content" style="display: none;">
                <div class="details-info">
                    <div class="detail-item">
                        <span class="detail-label">Images size:</span>
                        <span class="detail-value">12321×12323</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Copyright</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</div>
<!-- Fim do container para reordenação mobile -->

<!-- Visual compilation CTA -->
@include('presets.default.sections.visual_compilation')
</section>



<!-- JavaScript for collapsible sections -->
@push('script')
    <style>
        /* Debug styles para garantir que as imagens sejam visíveis */
        .accordion-gallery-item {
            min-height: 250px !important;
            background-size: cover !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
        }
        
        .main-gallery-container .accordion-gallery-item {
            background-color: #f0f0f0;
        }
        
        .gallery-container .accordion-gallery-item {
            background-color: #f5f5f5;
        }
        
        /* Forçar visibilidade dos botões de navegação - Estilo Figma */
        .main-gallery-prev,
        .main-gallery-next,
        .gallery-prev,
        .gallery-next {
            display: flex !important;
            width: 40px !important;
            height: 40px !important;
            justify-content: center !important;
            align-items: center !important;
            gap: 8px !important;
            flex-shrink: 0 !important;
            border-radius: 40px !important;
            background: rgba(229, 229, 232, 0.50) !important;
            backdrop-filter: blur(6px) !important;
            -webkit-backdrop-filter: blur(6px) !important; /* Safari support */
            position: absolute !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            border: none !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            z-index: 1000 !important;
            color: #333 !important;
            font-size: 16px !important;
            visibility: visible !important;
            opacity: 1 !important;
            box-shadow: none !important;
        }
        
        .main-gallery-prev,
        .gallery-prev {
            left: 15px !important;
        }
        
        .main-gallery-next,
        .gallery-next {
            right: 15px !important;
        }
        
        .main-gallery-prev:hover,
        .main-gallery-next:hover,
        .gallery-prev:hover,
        .gallery-next:hover {
            background: rgba(229, 229, 232, 0.80) !important;
            transform: translateY(-50%) scale(1.05) !important;
            backdrop-filter: blur(8px) !important;
            -webkit-backdrop-filter: blur(8px) !important;
        }
        
        /* Garantir que o container tenha posição relativa */
        .main-gallery-container,
        .gallery-container {
            position: relative !important;
            overflow: visible !important;
            padding: 20px 0 !important; /* Espaço vertical para evitar cortes */
        }
        
        /* Ajustar o container pai para não cortar */
        .info-section__content {
            overflow: visible !important;
            padding: 20px 0 !important;
        }
        
        .building-images-showcase .container,
        .building-info-sections .container {
            overflow: visible !important;
        }
        
        /* Garantir que as imagens não sejam cortadas */
        .accordion-gallery-row {
            border-radius: 24px !important;
            overflow: hidden !important; /* Só as imagens têm border-radius */
        }
        
        .accordion-gallery-item {
            border-radius: 24px !important;
            overflow: hidden !important;
        }
        
        /* CSS específico para mobile */
        @media (max-width: 768px) {
            .main-gallery-prev,
            .main-gallery-next,
            .gallery-prev,
            .gallery-next {
                display: flex !important;
                width: 40px !important;
                height: 40px !important;
                font-size: 14px !important;
            }
            
            .main-gallery-prev,
            .gallery-prev {
                left: 10px !important;
            }
            
            .main-gallery-next,
            .gallery-next {
                right: 10px !important;
            }
        }
        
        /* CSS para desktop */
        @media (min-width: 769px) {
            .main-gallery-prev,
            .main-gallery-next,
            .gallery-prev,
            .gallery-next {
                display: flex !important; /* Forçar display para desktop também */
            }
        }
        
        /* CSS para telas muito pequenas */
        @media (max-width: 480px) {
            .main-gallery-prev,
            .gallery-prev {
                left: 8px !important;
                width: 36px !important;
                height: 36px !important;
                font-size: 12px !important;
            }
            
            .main-gallery-next,
            .gallery-next {
                right: 8px !important;
                width: 36px !important;
                height: 36px !important;
                font-size: 12px !important;
            }
        }
    </style>

    <script>
        // Hero Carousel Indicators: 4 dots fixed, active cycles modulo 4 (igual ao padrão das outras páginas)
        document.addEventListener('DOMContentLoaded', function () {
            const carouselEl = document.querySelector('#buildingDetailsHeroCarousel');
            if (!carouselEl) return;
            const bsCarousel = bootstrap.Carousel.getOrCreateInstance(carouselEl);
            const indicators = Array.from(document.querySelectorAll('#buildingDetailsHeroIndicators button'));
            const slides = carouselEl.querySelectorAll('.carousel-item');
            const lastIndex = Math.max(0, slides.length - 1);

            function setActiveByIndex(index) {
                const activeDot = index % 4;
                indicators.forEach((btn, i) => {
                    const isActive = i === activeDot;
                    btn.classList.toggle('active', isActive);
                    btn.setAttribute('aria-current', isActive ? 'true' : 'false');
                });
            }

            carouselEl.addEventListener('slid.bs.carousel', function (evt) {
                const index = evt.to ?? Array.from(slides).indexOf(carouselEl.querySelector('.carousel-item.active'));
                setActiveByIndex(index);
            });

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

        // Toggle collapsible info sections
        document.querySelectorAll('.info-section__header').forEach(header => {
            header.addEventListener('click', function () {
                const content = this.nextElementSibling;
                const toggle = this.querySelector('.info-section__toggle');

                if (content.style.display === 'none' || content.style.display === '') {
                    content.style.display = 'block';
                    toggle.textContent = '-';
                    toggle.classList.add('active');
                } else {
                    content.style.display = 'none';
                    toggle.textContent = '+';
                    toggle.classList.remove('active');
                }
            });
        });

        // Gallery Navigation - Simplified Universal Function
        document.addEventListener('DOMContentLoaded', function() {
            // Capturar a base URL das imagens do hero carousel para usar na galeria
            const heroImage = document.querySelector('.carousel-item .banner-thumb');
            let baseImagePath = '';
            if (heroImage) {
                const bgImage = heroImage.getAttribute('data-background');
                if (bgImage && bgImage.includes('/')) {
                    // Extrair o path base da imagem do hero
                    const lastSlash = bgImage.lastIndexOf('/');
                    baseImagePath = bgImage.substring(0, lastSlash + 1);
                }
            }
            
            // Fallback caso não consiga extrair do hero
            if (!baseImagePath) {
                baseImagePath = '{{ getImage(getFilePath("building") . "/") }}';
            }
            
            // Galeria principal (All images)
            initializeGallery('[data-gallery="main"]', baseImagePath);
            
            // Galerias das seções
            initializeGallery('[data-gallery="footage"]', baseImagePath);
            initializeGallery('[data-gallery="listing"]', baseImagePath);
            
            function initializeGallery(containerSelector, imagePath) {
                const galleryContainer = document.querySelector(containerSelector);
                if (!galleryContainer) return;
                
                // Obter array de imagens do atributo data-images
                let imagesArray = [];
                try {
                    const dataImages = galleryContainer.getAttribute('data-images');
                    if (dataImages) {
                        imagesArray = JSON.parse(dataImages);
                    }
                } catch (e) {
                    console.warn('Erro ao carregar dados das imagens:', e);
                    return;
                }
                
                if (!imagesArray || imagesArray.length === 0) return;
                
                const galleryRow = galleryContainer.querySelector('.accordion-gallery-row');
                const prevBtn = galleryContainer.querySelector('.gallery-prev, .main-gallery-prev');
                const nextBtn = galleryContainer.querySelector('.gallery-next, .main-gallery-next');
                
                if (!galleryRow || !prevBtn || !nextBtn) return;
                
                let currentStartIndex = 0;
                const imagesPerPage = 3;
                const totalImages = imagesArray.length;
                
                function updateGallery() {
                    // Clear current images
                    galleryRow.innerHTML = '';
                    
                    // Add new set of 3 images
                    for (let i = 0; i < imagesPerPage; i++) {
                        const imageIndex = currentStartIndex + i;
                        if (imageIndex < totalImages) {
                            const img = imagesArray[imageIndex];
                            const imageUrl = imagePath + img;
                            
                            const galleryItem = document.createElement('div');
                            galleryItem.className = 'accordion-gallery-item';
                            galleryItem.style.backgroundImage = `url('${imageUrl}')`;
                            
                            galleryRow.appendChild(galleryItem);
                        }
                    }
                    
                    // Update button states
                    if (totalImages <= imagesPerPage) {
                        // If we have 3 or less images, buttons become non-functional but stay visible
                        prevBtn.style.opacity = '0.3';
                        nextBtn.style.opacity = '0.3';
                        prevBtn.style.pointerEvents = 'none';
                        nextBtn.style.pointerEvents = 'none';
                    } else {
                        // Normal navigation for more than 3 images
                        prevBtn.style.opacity = currentStartIndex === 0 ? '0.5' : '1';
                        nextBtn.style.opacity = currentStartIndex >= totalImages - imagesPerPage ? '0.5' : '1';
                        prevBtn.style.pointerEvents = currentStartIndex === 0 ? 'none' : 'auto';
                        nextBtn.style.pointerEvents = currentStartIndex >= totalImages - imagesPerPage ? 'none' : 'auto';
                    }
                }
                
                // Previous button
                prevBtn.addEventListener('click', function() {
                    if (totalImages > imagesPerPage && currentStartIndex > 0) {
                        currentStartIndex = Math.max(0, currentStartIndex - imagesPerPage);
                        updateGallery();
                    }
                });
                
                // Next button
                nextBtn.addEventListener('click', function() {
                    if (totalImages > imagesPerPage && currentStartIndex < totalImages - imagesPerPage) {
                        currentStartIndex = Math.min(totalImages - imagesPerPage, currentStartIndex + imagesPerPage);
                        updateGallery();
                    }
                });
                
                // Initialize gallery state - don't recreate if images are already there
                if (galleryRow.children.length === 0) {
                    updateGallery();
                } else {
                    // Just update button states for existing images
                    if (totalImages <= imagesPerPage) {
                        prevBtn.style.opacity = '0.3';
                        nextBtn.style.opacity = '0.3';
                        prevBtn.style.pointerEvents = 'none';
                        nextBtn.style.pointerEvents = 'none';
                    } else {
                        prevBtn.style.opacity = '1';
                        nextBtn.style.opacity = '1';
                        prevBtn.style.pointerEvents = 'auto';
                        nextBtn.style.pointerEvents = 'auto';
                    }
                }
            }
        });

        // Garantir que a seção principal "All images for..." esteja sempre expandida inicialmente
        document.addEventListener('DOMContentLoaded', function() {
            const buildingGallerySection = document.querySelector('.building-gallery-section');
            if (buildingGallerySection) {
                const content = buildingGallerySection.querySelector('.info-section__content');
                const toggle = buildingGallerySection.querySelector('.info-section__toggle');
                
                if (content && toggle) {
                    // Força a expansão
                    content.style.display = 'block';
                    toggle.textContent = '-';
                    toggle.classList.add('active');
                }
            }
            
            // Debug: verificar se as imagens estão carregando
            setTimeout(function() {
                console.log('Base image path usado:', baseImagePath);
                
                const galleryItems = document.querySelectorAll('.accordion-gallery-item');
                console.log('Total de itens de galeria encontrados:', galleryItems.length);
                
                galleryItems.forEach((item, index) => {
                    const bgImage = window.getComputedStyle(item).backgroundImage;
                    console.log(`Item ${index}:`, bgImage);
                    
                    // Se não há imagem de fundo, adicionar cor de fundo para debug
                    if (!bgImage || bgImage === 'none') {
                        item.style.backgroundColor = '#ffcccc';
                        item.innerHTML = '<div style="padding: 20px; text-align: center;">Imagem não carregada</div>';
                    }
                });
                
                // Debug: verificar se os botões estão presentes
                const mainPrevBtn = document.querySelector('.main-gallery-prev');
                const mainNextBtn = document.querySelector('.main-gallery-next');
                console.log('Botão prev encontrado:', !!mainPrevBtn);
                console.log('Botão next encontrado:', !!mainNextBtn);
                
                if (mainPrevBtn) {
                    console.log('Estilos do botão prev:', window.getComputedStyle(mainPrevBtn).display, window.getComputedStyle(mainPrevBtn).visibility);
                    // Forçar visibilidade
                    mainPrevBtn.style.display = 'flex';
                    mainPrevBtn.style.visibility = 'visible';
                    mainPrevBtn.style.opacity = '1';
                }
                
                if (mainNextBtn) {
                    console.log('Estilos do botão next:', window.getComputedStyle(mainNextBtn).display, window.getComputedStyle(mainNextBtn).visibility);
                    // Forçar visibilidade
                    mainNextBtn.style.display = 'flex';
                    mainNextBtn.style.visibility = 'visible';
                    mainNextBtn.style.opacity = '1';
                }
            }, 1000);
        });

        // Slick Slider Initialization Function
        function initSlickSlider(slider) {
            if (slider.length && !slider.hasClass('slick-initialized')) {
                slider.slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    autoplay: false,
                    autoplaySpeed: 1000,
                    pauseOnHover: true,
                    speed: 1000,
                    dots: false,
                    arrows: true,
                    prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-long-arrow-alt-left"></i></button>',
                    nextArrow: '<button type="button" class="slick-next"><i class="fas fa-long-arrow-alt-right"></i></button>',
                    responsive: [{
                        breakpoint: 1199,
                        settings: {
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 991,
                        settings: {
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 586,
                        settings: {
                            slidesToShow: 1
                        }
                    },
                    {
                        breakpoint: 400,
                        settings: {
                            slidesToShow: 1
                        }
                    }]
                });
            }
        }

        // Initialize sliders when document is ready
        $(document).ready(function () {
            initSlickSlider($('.accordion-thumb--slider:visible'));
        });

        // Initialize sliders when accordion is opened
        $('.accordion-button').on('click', function () {
            const targetCollapse = $(this).data('bs-target');
            setTimeout(() => {
                const slider = $(targetCollapse).find('.accordion-thumb--slider');
                initSlickSlider(slider);
            }, 300); // Aumentei o timeout para dar tempo da animação do accordion
        });
    </script>

    <script>
        // Section Carousels Functionality
        document.addEventListener('DOMContentLoaded', function () {
            // Configuração dos carrosseis das seções
            const sectionCarousels = ['footage', 'renderings', 'social-media', 'lobby', 'amenities', 'drone-aerial', 'listing-images'];

            sectionCarousels.forEach(function (sectionName) {
                const track = document.querySelector(`[data-section="${sectionName}"] .section-carousel-track`);
                const prevBtn = document.querySelector(`[data-section="${sectionName}"].section-carousel-prev`);
                const nextBtn = document.querySelector(`[data-section="${sectionName}"].section-carousel-next`);
                const indicators = document.querySelectorAll(`[data-section="${sectionName}"] .section-carousel-indicator`);

                // Só executar se houver carousel
                if (!track || indicators.length === 0) return;

                let currentIndex = 0;
                const cardWidth = 320; // largura da imagem
                const gap = 24; // espaçamento entre imagens
                const moveDistance = cardWidth + gap; // distância para mover
                const totalCards = indicators.length;
                const maxIndex = Math.max(0, totalCards - 1); // máximo para mostrar todas as imagens

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
                        currentIndex = index;
                        updateCarousel();
                    });
                });

                // Inicializar
                updateCarousel();
            });
        });
    </script>

    <script>
        $(document).on('click', '.markWishlist', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var type = $(this).data('type');
            var button = $(this);
            $.ajax({
                url: "{{ route('user.mark.wishlist') }}",
                data: {
                    id: id,
                    type: type,
                },
                method: "GET",
                success: function (data) {
                    if (data.status == true) {
                        var innerData = `<i class="fas fa-heart text--base"></i>@lang('Added')`;
                        button.html(innerData);
                        Toast.fire({
                            icon: 'success',
                            title: 'Successfully set this image to your wishlist.'
                        })
                        return false;
                    }

                    if (data.status == false) {
                        var innerData = `<i class="fas fa-heart"></i>@lang('Add')`;
                        button.html(innerData);
                        Toast.fire({
                            icon: 'success',
                            title: 'Successfully removed this image from your wishlist.'
                        })
                        return false;
                    }

                    if (data.auth == false) {
                        window.location.href = "{{ route('user.login') }}";
                    }
                },
                error: function (xhr, status, error) { },
            });

        });
    </script>


@endpush

