
<?php $__env->startSection('content'); ?>

<?php
    // Prefer building images; fallback to the building cover image duplicated
    $heroImages = $building->buildingImages?->pluck('image')->take(10) ?? collect();
    
    // Default images used in carousels throughout the page
    $defaultImages = optional($building->buildingImages)->pluck('image');
    if(!$defaultImages || $defaultImages->isEmpty()){
        $defaultImages = collect([$building->image]);
    }
?>

<!-- Hero Building Section (carousel like others) -->
<section id="buildingDetailsHeroCarousel" class="banner-section-two carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
    <div class="carousel-indicators" id="buildingDetailsHeroIndicators">
        <?php for($i = 0; $i < 4; $i++): ?>
            <button type="button" class="<?php echo e($i === 0 ? 'active' : ''); ?>" data-virtual-index="<?php echo e($i); ?>"
                aria-current="<?php echo e($i === 0 ? 'true' : 'false'); ?>" aria-label="Indicator <?php echo e($i + 1); ?>"></button>
        <?php endfor; ?>
    </div>

    <div class="carousel-inner">
        <?php if($heroImages->count()): ?>
            <?php $__currentLoopData = $heroImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="carousel-item <?php echo e($loop->first ? 'active' : ''); ?>">
                    <div class="banner-thumb bg-img bg-overlay py-120" data-background="<?php echo e(getImage(getFilePath('building') . '/' . $img)); ?>"></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <?php for($i = 0; $i < 2; $i++): ?>
                <div class="carousel-item <?php echo e($i === 0 ? 'active' : ''); ?>">
                    <div class="banner-thumb bg-img bg-overlay py-120" data-background="<?php echo e(getImage(getFilePath('building') . '/' . $building->image)); ?>"></div>
                </div>
            <?php endfor; ?>
        <?php endif; ?>
    </div>

    <!-- Overlay content -->
    <div class="hero-static-content">
        <div class="neigh-hero__content">
            <div class="neigh-hero__breadcrumb">
                <a href="<?php echo e(route('home')); ?>" class="breadcrumb-home">Home</a>
                <span class="breadcrumb-pipe"></span>
                <!-- <a href="<?php echo e(route('county', ['slug' => slug($building->neighborhood->county->name), 'id' => $building->neighborhood->county->id])); ?>" class="breadcrumb-county"><?php echo e($building->neighborhood->county->name); ?></a>
                <span class="breadcrumb-pipe"></span> -->
                <a href="<?php echo e(route('neighborhood.details', ['county' => slug($building->neighborhood->county->name), 'slug' => slug($building->neighborhood->name), 'id' => $building->neighborhood->id])); ?>" class="breadcrumb-section"><?php echo e($building->neighborhood->name); ?></a>
                <span class="breadcrumb-pipe"></span>
                <span class="breadcrumb-current"><?php echo e($building->name); ?></span>
            </div>
            
            <!-- Building Information -->
            <div class="building-hero__neighborhood"><?php echo e($building->neighborhood->name); ?></div>
            <h1 class="building-hero__title"><?php echo e(__($building->name)); ?></h1>
            <div class="building-hero__address"><?php echo e($building->address ?? $building->neighborhood->name . ', ' . $building->neighborhood->county->name); ?></div>
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
<?php echo $__env->make('presets.default.sections.building_visuals_buy', ['building' => $building], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!-- Container para reordenação mobile das 3 seções -->
<div class="mobile-reorder-container">

<!-- How it works -->


<!-- All Images for [Building Name] -->
<section class="building-info-sections" id="building-images">
    <div class="container">
        <div class="info-section building-gallery-section">
            <div class="info-section__header">
                <h3>All images for <?php echo e($building->name); ?></h3>
                <button type="button" class="info-section__toggle active">-</button>
            </div>
            <div class="info-section__content" style="display: block;">
                <?php
                    $galleryImages = optional($building->buildingImages)->pluck('image');
                    if(!$galleryImages || $galleryImages->isEmpty()){
                        $galleryImages = collect([$building->image]);
                    }
                ?>
                
                <!-- Row 1: Galeria de 3 imagens com navegação -->
                <div class="main-gallery-container" data-gallery="main" data-images='<?php echo json_encode($galleryImages->toArray(), 15, 512) ?>'>
                    <div class="accordion-gallery-row" id="main-gallery-row">
                        <?php if($galleryImages->isNotEmpty()): ?>
                            <?php $__currentLoopData = $galleryImages->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $imageUrl = getImage(getFilePath('building') . '/' . $img);
                                ?>
                                <div class="accordion-gallery-item"
                                     style="background-image: url('<?php echo e($imageUrl); ?>');"
                                     data-full-image="<?php echo e($imageUrl); ?>"
                                     data-label="<?php echo e($building->name); ?> - image <?php echo e($loop->iteration); ?>">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <!-- Fallback com imagem padrão -->
                            <?php for($i = 0; $i < 3; $i++): ?>
                                <?php
                                    $fallbackImage = getImage(getFilePath('building') . '/' . $building->image);
                                ?>
                                <div class="accordion-gallery-item"
                                     style="background-image: url('<?php echo e($fallbackImage); ?>');"
                                     data-full-image="<?php echo e($fallbackImage); ?>"
                                     data-label="<?php echo e($building->name); ?>">
                                </div>
                            <?php endfor; ?>
                        <?php endif; ?>
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
                        <p class="accordion-buy-subtitle">Perfect for listings, brochures, and social media.</p>
                    </div>

                    <!-- Segunda row: Grid com preço, contagem e descrição -->
                    <div class="accordion-buy-right">
                        <div class="accordion-buy-pricing">
                            <div class="accordion-buy-price">$<?php echo e($building->price ?? '49'); ?></div>
                            <div class="accordion-buy-details">
                                <div class="accordion-buy-count"><?php echo e($building->buildingImages->count() ?? '29'); ?> images</div>
                                <div class="accordion-buy-description">high-res images of <?php echo e($building->name); ?>, ready to impress.</div>
                            </div>
                            
                            <!-- Terceira row: Texto antes do botão -->
                        </div>
                        
                        <form action="<?php echo e(route('user.condo.building.payment')); ?>" method="POST" class="accordion-buy-form">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="condo_building_id" value="<?php echo e($building->id); ?>">
                            <input type="hidden" name="payment" value="2">
                            <button type="submit" class="accordion-buy-btn">Buy</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footage -->
        <div class="info-section">
            <div class="info-section__header">
                <h3>Footage</h3>
                <button type="button" class="info-section__toggle">+</button>
            </div>
            <div class="info-section__content" style="display: none;">
                <?php
                    $footageImages = $defaultImages;
                ?>
                
                <!-- Row 1: Galeria de 3 imagens com navegação -->
                <div class="gallery-container" data-gallery="footage" data-images='<?php echo json_encode($defaultImages->toArray(), 15, 512) ?>'>
                    <div class="accordion-gallery-row" id="footage-gallery-row">
                        <?php if($footageImages->isNotEmpty()): ?>
                            <?php $__currentLoopData = $footageImages->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $imageName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $imageUrl = getImage(getFilePath('building') . '/' . $imageName);
                                ?>
                                <div class="accordion-gallery-item"
                                     style="background-image: url('<?php echo e($imageUrl); ?>');"
                                     data-full-image="<?php echo e($imageUrl); ?>"
                                     data-label="<?php echo e($building->name); ?> footage - image <?php echo e($loop->iteration); ?>">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <!-- Fallback com imagem padrão -->
                            <?php for($i = 0; $i < 3; $i++): ?>
                                <?php
                                    $fallbackImage = getImage(getFilePath('building') . '/' . $building->image);
                                ?>
                                <div class="accordion-gallery-item"
                                     style="background-image: url('<?php echo e($fallbackImage); ?>');"
                                     data-full-image="<?php echo e($fallbackImage); ?>"
                                     data-label="<?php echo e($building->name); ?>">
                                </div>
                            <?php endfor; ?>
                        <?php endif; ?>
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
                            <div class="accordion-buy-price">$<?php echo e($building->price ?? '49'); ?></div>
                            <div class="accordion-buy-details">
                                <div class="accordion-buy-count"><?php echo e($building->buildingImages->count() ?? '29'); ?> images</div>
                                <div class="accordion-buy-description">High-res images of <?php echo e($building->name); ?>, ready to impress.</div>
                            </div>
                        </div>
                        
                        <form action="<?php echo e(route('user.condo.building.payment')); ?>" method="POST" class="accordion-buy-form">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="condo_building_id" value="<?php echo e($building->id); ?>">
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
                <button type="button" class="info-section__toggle disabled">+</button>
            </div>
        </div>

        <!-- Social media -->
        <div class="info-section">
            <div class="info-section__header">
                <h3>Social media</h3>
                <button type="button" class="info-section__toggle disabled">+</button>
            </div>
        </div>

        <!-- Lobby -->
        <div class="info-section">
            <div class="info-section__header">
                <h3>Lobby</h3>
                <button type="button" class="info-section__toggle disabled">+</button>
            </div>
        </div>

        <!-- Amenities -->
        <div class="info-section">
            <div class="info-section__header">
                <h3>Amenities</h3>
                <button type="button" class="info-section__toggle disabled">+</button>
            </div>
        </div>

        <!-- Drone Aerial -->
        <div class="info-section">
            <div class="info-section__header">
                <h3>Drone Aerial</h3>
                <button type="button" class="info-section__toggle disabled">+</button>
            </div>
        </div>

        <!-- Listing Images -->
        <div class="info-section">
            <div class="info-section__header">
                <h3>Listing Images</h3>
                <button type="button" class="info-section__toggle">+</button>
            </div>
            <div class="info-section__content" style="display: none;">
                <?php
                    $listingImages = $defaultImages;
                ?>
                
                <!-- Row 1: Galeria de 3 imagens com navegação -->
                <div class="gallery-container" data-gallery="listing" data-images='<?php echo json_encode($defaultImages->toArray(), 15, 512) ?>'>
                    <div class="accordion-gallery-row" id="listing-gallery-row">
                        <?php if($listingImages->isNotEmpty()): ?>
                            <?php $__currentLoopData = $listingImages->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $imageName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $imageUrl = getImage(getFilePath('building') . '/' . $imageName);
                                ?>
                                <div class="accordion-gallery-item"
                                     style="background-image: url('<?php echo e($imageUrl); ?>');"
                                     data-full-image="<?php echo e($imageUrl); ?>"
                                     data-label="<?php echo e($building->name); ?> listing - image <?php echo e($loop->iteration); ?>">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <!-- Fallback com imagem padrão -->
                            <?php for($i = 0; $i < 3; $i++): ?>
                                <?php
                                    $fallbackImage = getImage(getFilePath('building') . '/' . $building->image);
                                ?>
                                <div class="accordion-gallery-item"
                                     style="background-image: url('<?php echo e($fallbackImage); ?>');"
                                     data-full-image="<?php echo e($fallbackImage); ?>"
                                     data-label="<?php echo e($building->name); ?>">
                                </div>
                            <?php endfor; ?>
                        <?php endif; ?>
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
                            <div class="accordion-buy-price">$<?php echo e($building->price ?? '49'); ?></div>
                            <div class="accordion-buy-details">
                                <div class="accordion-buy-count"><?php echo e($building->buildingImages->count() ?? '29'); ?> images</div>
                                <div class="accordion-buy-description">High-res images of <?php echo e($building->name); ?>, ready to impress.</div>
                            </div>
                        </div>
                        
                        <form action="<?php echo e(route('user.condo.building.payment')); ?>" method="POST" class="accordion-buy-form">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="condo_building_id" value="<?php echo e($building->id); ?>">
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
                <button type="button" class="info-section__toggle">+</button>
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

<!-- Image preview modal -->
<div class="image-preview-modal" id="imagePreviewModal" aria-hidden="true">
    <div class="image-preview-modal__backdrop" role="presentation"></div>
    <div class="image-preview-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="imagePreviewModalTitle">
        <button type="button" class="image-preview-modal__close" aria-label="Close image preview">
            <span aria-hidden="true">&times;</span>
        </button>
        <img id="imagePreviewModalImage" class="image-preview-modal__image" src="" alt="Image preview" draggable="false">
    </div>
</div>

<!-- Visual compilation CTA -->
<?php echo $__env->make('presets.default.sections.visual_compilation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</section>



<!-- JavaScript for collapsible sections -->
<?php $__env->startPush('script'); ?>
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
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('imagePreviewModal');
            if (!modal) {
                return;
            }

            const modalImage = document.getElementById('imagePreviewModalImage');
            const closeButton = modal.querySelector('.image-preview-modal__close');
            const backdrop = modal.querySelector('.image-preview-modal__backdrop');
            const OPEN_CLASS = 'is-open';

            const preventDefault = function (event) {
                event.preventDefault();
            };

            modalImage.addEventListener('contextmenu', preventDefault);
            modalImage.addEventListener('dragstart', preventDefault);

            document.addEventListener('contextmenu', function (event) {
                if (event.target.closest('.accordion-gallery-item') || event.target.closest('.tc-card')) {
                    preventDefault(event);
                }
            }, true);

            document.querySelectorAll('.tc-card__img').forEach(function (img) {
                img.setAttribute('draggable', 'false');
                img.addEventListener('contextmenu', preventDefault);
            });

            function setBodyScroll(lock) {
                document.body.classList.toggle('image-preview-modal-open', lock);
            }

            function closeModal() {
                modal.classList.remove(OPEN_CLASS);
                modal.setAttribute('aria-hidden', 'true');
                modalImage.src = '';
                modalImage.alt = '';
                setBodyScroll(false);
            }

            function openModal(src, altText) {
                if (!src) {
                    return;
                }

                modalImage.src = src;
                modalImage.alt = altText || 'Preview image';
                modal.classList.add(OPEN_CLASS);
                modal.setAttribute('aria-hidden', 'false');
                setBodyScroll(true);
            }

            [closeButton, backdrop].forEach(function (element) {
                if (!element) return;
                element.addEventListener('click', closeModal);
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && modal.classList.contains(OPEN_CLASS)) {
                    closeModal();
                }
            });

            function extractBackgroundImage(element) {
                if (!element) return null;
                const bgImage = element.style.backgroundImage || window.getComputedStyle(element).backgroundImage;
                if (!bgImage || bgImage === 'none') {
                    return null;
                }
                const match = bgImage.match(/url\(["']?(.*?)["']?\)/i);
                return match ? match[1] : null;
            }

            document.querySelectorAll('.tc-card__img').forEach(function (img) {
                img.setAttribute('draggable', 'false');
            });

            document.addEventListener('click', function (event) {
                if (event.target.closest('.tc-nav-btn')) {
                    return;
                }

                const card = event.target.closest('.tc-card');
                if (card) {
                    const img = card.querySelector('.tc-card__img');
                    const src = card.dataset.previewImage || img?.getAttribute('src');
                    const label = card.dataset.previewLabel || card.querySelector('.tc-card__label')?.textContent || img?.getAttribute('alt');

                    if (src) {
                        event.preventDefault();
                        event.stopPropagation();
                        openModal(src, label);
                    }
                    return;
                }

                const galleryItem = event.target.closest('.accordion-gallery-item');
                if (galleryItem) {
                    event.preventDefault();
                    event.stopPropagation();
                    const src = galleryItem.dataset.fullImage || extractBackgroundImage(galleryItem);
                    const label = galleryItem.getAttribute('aria-label') || galleryItem.dataset.label || 'Gallery image preview';
                    openModal(src, label);
                }
            });
        });
    </script>

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
        document.querySelectorAll('.info-section').forEach(section => {
            const header = section.querySelector('.info-section__header');
            const toggle = section.querySelector('.info-section__toggle');
            const content = section.querySelector('.info-section__content');

            if (!header || !toggle) {
                return;
            }

            // Se a se��o n��o possui conte��do, desativa o toggle
            if (!content) {
                toggle.classList.add('disabled');
                toggle.setAttribute('aria-disabled', 'true');
                return;
            }

            const setExpandedState = function (expanded) {
                content.style.display = expanded ? 'block' : 'none';
                toggle.textContent = expanded ? '-' : '+';
                toggle.classList.toggle('active', expanded);
            };

            setExpandedState(content.style.display !== 'none');

            const handleToggle = function () {
                const isOpen = content.style.display !== 'none';
                setExpandedState(!isOpen);
                toggle.dataset.userInteraction = 'true';
            };

            header.addEventListener('click', function () {
                handleToggle();
            });

            toggle.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();
                handleToggle();
            });
        });

        // Gallery Navigation - Simplified Universal Function
        let accordionBaseImagePath = '';
        function initAccordionGalleries() {
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
                baseImagePath = '<?php echo e(getImage(getFilePath("building") . "/")); ?>';
            }
            accordionBaseImagePath = baseImagePath;
            
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

                galleryRow.style.touchAction = 'pan-y';
                galleryRow.style.msTouchAction = 'pan-y';
                
                const totalImages = imagesArray.length;
                let currentStartIndex = 0;

                function resolveImagesPerPage() {
                    if (window.innerWidth <= 768) {
                        return 1;
                    }
                    return Math.min(3, totalImages);
                }

                let imagesPerPage = resolveImagesPerPage();
                const SWIPE_THRESHOLD = 40;
                const supportsPointerEvents = 'PointerEvent' in window;

                function updateGallery() {
                    galleryRow.innerHTML = '';

                    const maxStartIndex = Math.max(0, totalImages - imagesPerPage);
                    currentStartIndex = Math.min(currentStartIndex, maxStartIndex);

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

                    if (totalImages <= imagesPerPage) {
                        prevBtn.style.opacity = '0.3';
                        nextBtn.style.opacity = '0.3';
                        prevBtn.style.pointerEvents = 'none';
                        nextBtn.style.pointerEvents = 'none';
                    } else {
                        prevBtn.style.opacity = currentStartIndex === 0 ? '0.5' : '1';
                        prevBtn.style.pointerEvents = currentStartIndex === 0 ? 'none' : 'auto';

                        const atEnd = currentStartIndex >= maxStartIndex;
                        nextBtn.style.opacity = atEnd ? '0.5' : '1';
                        nextBtn.style.pointerEvents = atEnd ? 'none' : 'auto';
                    }
                }

                function goPrev() {
                    if (totalImages > imagesPerPage && currentStartIndex > 0) {
                        currentStartIndex = Math.max(0, currentStartIndex - 1);
                        updateGallery();
                    }
                }

                function goNext() {
                    if (totalImages > imagesPerPage) {
                        const maxStartIndex = Math.max(0, totalImages - imagesPerPage);
                        if (currentStartIndex < maxStartIndex) {
                            currentStartIndex = Math.min(maxStartIndex, currentStartIndex + 1);
                            updateGallery();
                        }
                    }
                }

                function handleSwipe(deltaX) {
                    if (totalImages <= imagesPerPage) {
                        return;
                    }

                    if (deltaX <= -SWIPE_THRESHOLD) {
                        goNext();
                    } else if (deltaX >= SWIPE_THRESHOLD) {
                        goPrev();
                    }
                }

                function handleResize() {
                    const nextValue = resolveImagesPerPage();
                    if (nextValue !== imagesPerPage) {
                        imagesPerPage = nextValue;
                        updateGallery();
                    }
                }

                window.addEventListener('resize', handleResize);

                prevBtn.addEventListener('click', goPrev);
                nextBtn.addEventListener('click', goNext);

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

                    galleryRow.addEventListener('pointerdown', function (event) {
                        if (event.pointerType !== 'touch' && event.pointerType !== 'pen') {
                            return;
                        }
                        pointerActive = true;
                        pointerId = event.pointerId;
                        pointerStartX = event.clientX;
                        pointerLastX = event.clientX;
                        try {
                            galleryRow.setPointerCapture(pointerId);
                        } catch (err) {
                            /* ignore */
                        }
                    });

                    galleryRow.addEventListener('pointermove', function (event) {
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
                            galleryRow.releasePointerCapture(event.pointerId);
                        } catch (err) {
                            /* ignore */
                        }
                        const deltaX = pointerLastX - pointerStartX;
                        resetPointerState();
                        handleSwipe(deltaX);
                    }

                    galleryRow.addEventListener('pointerup', handlePointerEnd);
                    galleryRow.addEventListener('pointercancel', function (event) {
                        if (!pointerActive || event.pointerId !== pointerId) {
                            return;
                        }
                        try {
                            galleryRow.releasePointerCapture(event.pointerId);
                        } catch (err) {
                            /* ignore */
                        }
                        resetPointerState();
                    });
                } else {
                    let touchStartX = null;
                    galleryRow.addEventListener('touchstart', function (event) {
                        if (event.touches.length !== 1) {
                            return;
                        }
                        touchStartX = event.touches[0].clientX;
                    }, { passive: true });

                    galleryRow.addEventListener('touchend', function (event) {
                        if (touchStartX === null) {
                            return;
                        }
                        const touch = event.changedTouches[0];
                        const deltaX = touch.clientX - touchStartX;
                        touchStartX = null;
                        handleSwipe(deltaX);
                    }, { passive: true });

                    galleryRow.addEventListener('touchcancel', function () {
                        touchStartX = null;
                    }, { passive: true });
                }

                updateGallery();
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initAccordionGalleries);
        } else {
            initAccordionGalleries();
        }

        // Garantir que a seção principal "All images for..." esteja sempre expandida inicialmente
        function ensureMainGalleryExpanded() {
            const buildingGallerySection = document.querySelector('.building-gallery-section');
            if (buildingGallerySection) {
                const content = buildingGallerySection.querySelector('.info-section__content');
                const toggle = buildingGallerySection.querySelector('.info-section__toggle');
                
                if (content && toggle && toggle.dataset.userInteraction !== 'true') {
                    content.style.display = content.style.display || 'block';
                    if (content.style.display !== 'none') {
                        toggle.textContent = '-';
                        toggle.classList.add('active');
                    } else {
                        toggle.textContent = '+';
                        toggle.classList.remove('active');
                    }
                }
            }
            
            // Debug: verificar se as imagens estão carregando
            setTimeout(function() {
                console.log('Base image path usado:', accordionBaseImagePath);
                
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
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', ensureMainGalleryExpanded);
        } else {
            ensureMainGalleryExpanded();
        }

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

        function initVisibleSlick() {
            initSlickSlider($('.accordion-thumb--slider:visible'));
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initVisibleSlick);
        } else {
            initVisibleSlick();
        }

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
        function initSectionCarousels() {
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
                const SWIPE_THRESHOLD = 40;
                const supportsPointerEvents = 'PointerEvent' in window;

                function updateCarousel() {
                    const translateX = -(currentIndex * moveDistance);
                    track.style.transform = `translateX(${translateX}px)`;

                    // Atualizar indicadores
                    indicators.forEach((indicator, index) => {
                        indicator.classList.toggle('active', index === currentIndex);
                        indicator.setAttribute('aria-current', index === currentIndex ? 'true' : 'false');
                    });
                }

                function goNext() {
                    if (totalCards <= 1) return;
                    currentIndex = (currentIndex < maxIndex) ? currentIndex + 1 : 0;
                    updateCarousel();
                }

                function goPrev() {
                    if (totalCards <= 1) return;
                    currentIndex = (currentIndex > 0) ? currentIndex - 1 : maxIndex;
                    updateCarousel();
                }

                function handleSwipe(deltaX) {
                    if (totalCards <= 1) return;
                    if (deltaX <= -SWIPE_THRESHOLD) {
                        goNext();
                    } else if (deltaX >= SWIPE_THRESHOLD) {
                        goPrev();
                    }
                }

                // Botão next
                if (nextBtn) {
                    nextBtn.addEventListener('click', goNext);
                }

                // Botão prev
                if (prevBtn) {
                    prevBtn.addEventListener('click', goPrev);
                }

                // Indicadores
                indicators.forEach((indicator, index) => {
                    indicator.addEventListener('click', function () {
                        currentIndex = index;
                        updateCarousel();
                    });
                });

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

                // Inicializar
                updateCarousel();
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initSectionCarousels);
        } else {
            initSectionCarousels();
        }
    </script>

    <script>
        $(document).on('click', '.markWishlist', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var type = $(this).data('type');
            var button = $(this);
            $.ajax({
                url: "<?php echo e(route('user.mark.wishlist')); ?>",
                data: {
                    id: id,
                    type: type,
                },
                method: "GET",
                success: function (data) {
                    if (data.status == true) {
                        var innerData = `<i class="fas fa-heart text--base"></i><?php echo app('translator')->get('Added'); ?>`;
                        button.html(innerData);
                        Toast.fire({
                            icon: 'success',
                            title: 'Successfully set this image to your wishlist.'
                        })
                        return false;
                    }

                    if (data.status == false) {
                        var innerData = `<i class="fas fa-heart"></i><?php echo app('translator')->get('Add'); ?>`;
                        button.html(innerData);
                        Toast.fire({
                            icon: 'success',
                            title: 'Successfully removed this image from your wishlist.'
                        })
                        return false;
                    }

                    if (data.auth == false) {
                        window.location.href = "<?php echo e(route('user.login')); ?>";
                    }
                },
                error: function (xhr, status, error) { },
            });

        });
    </script>


<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\victo\Desktop\pedro\condoImage\_\httpdocs\staging\application\resources\views/presets/default/building/building_details.blade.php ENDPATH**/ ?>