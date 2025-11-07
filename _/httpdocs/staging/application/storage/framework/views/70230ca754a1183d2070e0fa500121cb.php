<?php
    try {
        $buildingImages = ($building->buildingImages ?? collect())->pluck('image');
    } catch (Exception $e) {
        $buildingImages = collect();
    }
?>

<section class="top-categories-container pb-100">
    <div class="container-fluid">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="download-image-collection-card">
                    <h4 class="download-card-title">Download Image Collection</h4>

                    <div class="download-card-main-row">
                        <div class="download-card-price-section">
                            <span class="download-card-price">$<?php echo e($building->price ?? '49'); ?></span>
                        </div>
                        <div class="download-card-info-section">
                            <div class="download-card-count"><?php echo e($building->buildingImages->count() ?? '29'); ?> images</div>
                            <div class="download-card-description">high-res images of <?php echo e($building->name); ?>, ready to impress.</div>
                        </div>
                    </div>

                    <p class="download-card-subtitle">Perfect for listings, brochures, and social media.</p>

                    <form action="<?php echo e(route('user.condo.building.payment')); ?>" method="POST" class="download-form">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="condo_building_id" value="<?php echo e($building->id); ?>">
                        <input type="hidden" name="payment" value="2">
                        <button type="submit" class="download-card-button">Buy</button>
                    </form>
                </div>

                <?php if($buildingImages->count() > 0): ?>
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
                <?php endif; ?>
            </div>

            <div class="col-lg-6">
                <div id="buildingCarousel" class="tc-carousel">
                    <div class="tc-carousel-track">
                        <?php if($buildingImages->count()): ?>
                            <?php $__currentLoopData = $buildingImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="tc-card" data-modal-trigger data-image-index="<?php echo e($index); ?>">
                                    <img class="tc-card__img" src="<?php echo e(getImage(getFilePath('building') . '/' . $img)); ?>" alt="<?php echo e($building->name); ?>">
                                    <div class="tc-card__label"><?php echo e(__($building->name)); ?></div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="tc-card" data-modal-trigger data-image-index="0">
                                <img class="tc-card__img" src="<?php echo e(getImage(getFilePath('building') . '/' . $building->image)); ?>" alt="<?php echo e($building->name); ?>">
                                <div class="tc-card__label"><?php echo e(__($building->name)); ?></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mobile Controls Section -->
        <?php if($buildingImages->count() > 0): ?>
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
        <?php endif; ?>
    </div>
</section>

<!-- Modal de Imagens -->
<div id="imageModal" class="image-modal" style="display: none;" aria-hidden="true" role="dialog" aria-labelledby="modalTitle" aria-describedby="modalDescription">
    <div class="image-modal__overlay" data-modal-close></div>
    <div class="image-modal__container">
        <div class="image-modal__header">
            <h3 id="modalTitle" class="image-modal__title"><?php echo e($building->name); ?> - Images</h3>
            <button type="button" class="image-modal__close" data-modal-close aria-label="Close modal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="image-modal__content">
            <div class="image-modal__main">
                <div class="image-modal__image-container">
                    <div class="image-modal__loading" id="imageLoading">
                        <div class="image-modal__skeleton"></div>
                    </div>
                    <img id="modalImage" class="image-modal__image" alt="" style="display: none;">
                    <div class="image-modal__error" id="imageError" style="display: none;">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>Failed to load image</p>
                    </div>
                </div>
                
                <div class="image-modal__navigation" id="modalNavigation">
                    <button type="button" class="image-modal__nav-btn image-modal__prev" id="modalPrev" aria-label="Previous image">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button type="button" class="image-modal__nav-btn image-modal__next" id="modalNext" aria-label="Next image">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
            
            <div class="image-modal__indicators" id="modalIndicators">
                <div class="image-modal__indicators-container" id="modalIndicatorsContainer">
                    <!-- Indicators will be generated by JavaScript -->
                </div>
            </div>
        </div>
        
        <div id="modalDescription" class="sr-only">Image modal for building gallery</div>
    </div>
</div>

<style>
.image-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: rgba(0, 0, 0, 0.9);
}

.image-modal__overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.image-modal__container {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.image-modal__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    color: white;
}

.image-modal__title {
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0;
}

.image-modal__close {
    background: none;
    border: none;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 8px;
    border-radius: 4px;
    transition: background-color 0.2s;
}

.image-modal__close:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

.image-modal__content {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.image-modal__main {
    flex: 1;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}

.image-modal__image-container {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.image-modal__image {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    border-radius: 8px;
}

.image-modal__loading {
    position: absolute;
    width: 100%;
    height: 60%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.image-modal__skeleton {
    width: 80%;
    height: 80%;
    background: linear-gradient(90deg, #2a2a2a 25%, #3a3a3a 50%, #2a2a2a 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
    border-radius: 8px;
}

.image-modal__error {
    color: white;
    text-align: center;
}

.image-modal__error i {
    font-size: 2rem;
    margin-bottom: 10px;
    color: #ff6b6b;
}

.image-modal__navigation {
    position: absolute;
    top: 50%;
    width: 100%;
    transform: translateY(-50%);
    display: flex;
    justify-content: space-between;
    pointer-events: none;
    padding: 0 20px;
}

.image-modal__nav-btn {
    background: rgba(0, 0, 0, 0.7);
    border: none;
    color: white;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
    pointer-events: auto;
}

.image-modal__nav-btn:hover:not(:disabled) {
    background: rgba(0, 0, 0, 0.9);
    transform: scale(1.1);
}

.image-modal__nav-btn:disabled {
    opacity: 0.3;
    cursor: not-allowed;
}

.image-modal__indicators {
    display: flex;
    justify-content: center;
}

.image-modal__indicators-container {
    display: flex;
    gap: 8px;
    max-width: 300px;
    overflow: hidden;
}

.modal-indicator {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.4);
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.modal-indicator.active {
    background: white;
    transform: scale(1.2);
}

.modal-indicator:hover {
    background: rgba(255, 255, 255, 0.7);
}

.sr-only {
    position: absolute !important;
    width: 1px !important;
    height: 1px !important;
    padding: 0 !important;
    margin: -1px !important;
    overflow: hidden !important;
    clip: rect(0, 0, 0, 0) !important;
    white-space: nowrap !important;
    border: 0 !important;
}

@keyframes loading {
    0% {
        background-position: 200% 0;
    }
    100% {
        background-position: -200% 0;
    }
}

@media (max-width: 768px) {
    .image-modal__container {
        padding: 10px;
    }
    
    .image-modal__nav-btn {
        width: 40px;
        height: 40px;
    }
    
    .image-modal__navigation {
        padding: 0 10px;
    }
}

.tc-card {
    cursor: pointer;
    transition: transform 0.2s;
}

.tc-card:hover {
    transform: scale(1.02);
}
</style>

<?php $__env->startPush('script'); ?>
<script>
// Normalizar dados de imagens
function normalizeImageData() {
    const images = [];
    <?php if($buildingImages->count()): ?>
        <?php $__currentLoopData = $buildingImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            images.push({
                src: "<?php echo e(getImage(getFilePath('building') . '/' . $img)); ?>",
                alt: "<?php echo e(addslashes($building->name)); ?>"
            });
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        images.push({
            src: "<?php echo e(getImage(getFilePath('building') . '/' . $building->image)); ?>",
            alt: "<?php echo e(addslashes($building->name)); ?>"
        });
    <?php endif; ?>
    
    // Filtrar imagens inválidas
    return images.filter(img => img.src && img.src.trim() !== '');
}

// Modal de Imagens Robusto
function initImageModal() {
    const images = normalizeImageData();
    const totalImages = images.length;
    
    // Se não há imagens, não inicializar modal
    if (totalImages === 0) {
        console.warn('No valid images found for modal');
        return;
    }

    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const modalPrev = document.getElementById('modalPrev');
    const modalNext = document.getElementById('modalNext');
    const modalIndicators = document.getElementById('modalIndicators');
    const modalIndicatorsContainer = document.getElementById('modalIndicatorsContainer');
    const imageLoading = document.getElementById('imageLoading');
    const imageError = document.getElementById('imageError');
    
    let currentIndex = 0;
    let isImageLoading = false;
    let previousFocus = null;

    // Criar indicadores
    function createIndicators() {
        modalIndicatorsContainer.innerHTML = '';
        
        if (totalImages <= 1) {
            modalIndicators.style.display = 'none';
            return;
        }
        
        modalIndicators.style.display = 'flex';
        
        for (let i = 0; i < totalImages; i++) {
            const indicator = document.createElement('button');
            indicator.type = 'button';
            indicator.className = 'modal-indicator';
            indicator.setAttribute('aria-label', `Go to image ${i + 1}`);
            indicator.dataset.index = i;
            
            indicator.addEventListener('click', () => {
                if (i !== currentIndex) {
                    goToImage(i);
                }
            });
            
            modalIndicatorsContainer.appendChild(indicator);
        }
    }

    // Atualizar indicadores
    function updateIndicators() {
        const indicators = modalIndicatorsContainer.querySelectorAll('.modal-indicator');
        indicators.forEach((indicator, index) => {
            const isActive = index === currentIndex;
            indicator.classList.toggle('active', isActive);
            indicator.setAttribute('aria-current', isActive ? 'true' : 'false');
        });
    }

    // Atualizar controles de navegação
    function updateNavigation() {
        if (totalImages <= 1) {
            modalPrev.style.display = 'none';
            modalNext.style.display = 'none';
            return;
        }
        
        modalPrev.style.display = 'flex';
        modalNext.style.display = 'flex';
        
        // Para comportamento sem loop (mais seguro)
        modalPrev.disabled = currentIndex === 0;
        modalNext.disabled = currentIndex === totalImages - 1;
        
        modalPrev.setAttribute('aria-label', `Previous image (${currentIndex} of ${totalImages})`);
        modalNext.setAttribute('aria-label', `Next image (${currentIndex + 2} of ${totalImages})`);
    }

    // Carregar imagem
    function loadImage(index) {
        if (index < 0 || index >= totalImages || isImageLoading) {
            return;
        }
        
        isImageLoading = true;
        const imageData = images[index];
        
        // Mostrar loading
        imageLoading.style.display = 'flex';
        modalImage.style.display = 'none';
        imageError.style.display = 'none';
        
        const img = new Image();
        
        img.onload = () => {
            modalImage.src = imageData.src;
            modalImage.alt = imageData.alt;
            modalImage.style.display = 'block';
            imageLoading.style.display = 'none';
            imageError.style.display = 'none';
            isImageLoading = false;
        };
        
        img.onerror = () => {
            modalImage.style.display = 'none';
            imageLoading.style.display = 'none';
            imageError.style.display = 'flex';
            isImageLoading = false;
        };
        
        img.src = imageData.src;
    }

    // Ir para imagem específica
    function goToImage(index) {
        if (index < 0 || index >= totalImages || index === currentIndex) {
            return;
        }
        
        currentIndex = index;
        loadImage(currentIndex);
        updateIndicators();
        updateNavigation();
    }

    // Navegação anterior
    function goToPrevious() {
        if (totalImages <= 1 || currentIndex === 0) return;
        goToImage(currentIndex - 1);
    }

    // Navegação próxima
    function goToNext() {
        if (totalImages <= 1 || currentIndex === totalImages - 1) return;
        goToImage(currentIndex + 1);
    }

    // Abrir modal
    function openModal(startIndex = 0) {
        // Validar índice inicial
        const validIndex = Math.max(0, Math.min(startIndex, totalImages - 1));
        
        previousFocus = document.activeElement;
        modal.style.display = 'block';
        modal.setAttribute('aria-hidden', 'false');
        
        // Inicializar interface
        createIndicators();
        goToImage(validIndex);
        
        // Foco inicial no botão fechar
        const closeBtn = modal.querySelector('.image-modal__close');
        if (closeBtn) {
            closeBtn.focus();
        }
        
        // Prevenir scroll do body
        document.body.style.overflow = 'hidden';
    }

    // Fechar modal
    function closeModal() {
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        
        // Restaurar foco
        if (previousFocus) {
            previousFocus.focus();
            previousFocus = null;
        }
    }

    // Event listeners
    
    // Triggers do modal (cards do carrossel)
    const triggers = document.querySelectorAll('[data-modal-trigger]');
    triggers.forEach(trigger => {
        trigger.addEventListener('click', (e) => {
            e.preventDefault();
            const index = parseInt(trigger.dataset.imageIndex) || 0;
            openModal(index);
        });
        
        // Acessibilidade: Enter/Space
        trigger.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                const index = parseInt(trigger.dataset.imageIndex) || 0;
                openModal(index);
            }
        });
    });

    // Botões de fechar
    const closeButtons = modal.querySelectorAll('[data-modal-close]');
    closeButtons.forEach(btn => {
        btn.addEventListener('click', closeModal);
    });

    // Navegação
    modalPrev.addEventListener('click', goToPrevious);
    modalNext.addEventListener('click', goToNext);

    // Teclado
    modal.addEventListener('keydown', (e) => {
        if (!modal.style.display || modal.style.display === 'none') return;
        
        switch (e.key) {
            case 'Escape':
                e.preventDefault();
                closeModal();
                break;
            case 'ArrowLeft':
                e.preventDefault();
                goToPrevious();
                break;
            case 'ArrowRight':
                e.preventDefault();
                goToNext();
                break;
        }
    });

    // Gerenciar foco no modal (trap focus)
    modal.addEventListener('keydown', (e) => {
        if (e.key !== 'Tab') return;
        
        const focusableElements = modal.querySelectorAll(
            'button:not([disabled]), [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );
        
        const firstFocusable = focusableElements[0];
        const lastFocusable = focusableElements[focusableElements.length - 1];
        
        if (e.shiftKey) {
            if (document.activeElement === firstFocusable) {
                e.preventDefault();
                lastFocusable.focus();
            }
        } else {
            if (document.activeElement === lastFocusable) {
                e.preventDefault();
                firstFocusable.focus();
            }
        }
    });
}

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

    // NOVO: navegação por cliques
    let currentIndex = 0;     // imagem atual (0..totalSlides-1)
    let moveDistance = 0;     // distância para mover 1 card
    let resizeTimer;

    // “pos” controla quantos cliques efetivos foram dados (frente/volta).
    // Com N imagens, máximo de cliques adiante é N-1.
    let clickPos = 0;
    let maxClicks = Math.max(0, totalSlides - 1);

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

    function goNext() {
        if (maxClicks === 0) return;          // nada a navegar
        if (clickPos < maxClicks) {           // respeita total de imagens: N -> N-1 cliques
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
        if (!cards.length) return;

        resetIndicators();

        const firstCard = track.querySelector('.tc-card');
        if (!firstCard) {
            moveDistance = 0;
            maxClicks = 0;
            updateNavButtons();
            return;
        }

        const trackStyles = window.getComputedStyle(track);
        const gapValue = parseFloat(trackStyles.columnGap || trackStyles.gap || '0') || 0;
        const cardRect = firstCard.getBoundingClientRect();
        moveDistance = cardRect.width + gapValue;

        // Regra pedida: limite por TOTAL DE IMAGENS (N -> N-1 cliques)
        const totalImages = totalSlides;
        maxClicks = Math.max(0, totalImages - 1);

        // Garanta coerência entre clickPos, currentIndex e novos cálculos
        clickPos = Math.min(clickPos, maxClicks);
        currentIndex = clickPos;

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

// Inicialização
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        initBuildingVisualsCarousel();
        initImageModal();
    });
} else {
    initBuildingVisualsCarousel();
    initImageModal();
}
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\victo\Desktop\pedro\condoImage\_\httpdocs\staging\application\resources\views/presets/default/sections/building_visuals_buy.blade.php ENDPATH**/ ?>