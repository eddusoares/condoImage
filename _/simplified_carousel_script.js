// JavaScript simplificado para o carrossel da seção top-categories
document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.querySelector('#categoriesCarousel');
    console.log('Carousel found:', carousel);
    
    if (!carousel) {
        console.log('Carousel #categoriesCarousel not found!');
        return;
    }

    const track = carousel.querySelector('.tc-carousel-track');
    console.log('Track found:', track);
    
    const slides = track ? track.querySelectorAll('.tc-card') : [];
    console.log('Slides found:', slides.length);
    
    const controlsDesktop = document.querySelector('.top-categories-container .tc-inline-controls-desktop');
    const controlsMobile = document.querySelector('.top-categories-container .tc-inline-controls-mobile');
    
    console.log('Controls Desktop:', controlsDesktop);
    console.log('Controls Mobile:', controlsMobile);
    
    if (slides.length === 0) {
        console.log('No slides found!');
        return;
    }

    let currentIndex = 0;
    const totalSlides = slides.length;
    
    // Função para detectar se é mobile e calcular valores corretos
    function getSlideValues() {
        const isMobile = window.innerWidth <= 991.98;
        if (isMobile) {
            return {
                slideWidth: 260, // Largura mobile
                slideGap: 16,    // Gap mobile
                slideStep: 276   // 260 + 16
            };
        } else {
            return {
                slideWidth: 400, // Largura desktop
                slideGap: 40,    // Gap desktop
                slideStep: 440   // 400 + 40
            };
        }
    }

    // Função para atualizar a posição do carrossel
    function updateCarousel() {
        const { slideStep } = getSlideValues();
        const translateX = -(currentIndex * slideStep);
        
        console.log('updateCarousel:', {
            currentIndex,
            slideStep,
            translateX,
            isMobile: window.innerWidth <= 991.98
        });
        
        if (track) {
            track.style.transform = `translateX(${translateX}px)`;
            console.log('Track transform applied:', track.style.transform);
        } else {
            console.log('Track not found!');
        }
    }

    // Função para atualizar indicadores
    function updateIndicators() {
        // Determinar qual indicador deve estar ativo (0-3)
        const activeIndicatorIndex = currentIndex % 4;
        
        // Atualizar indicadores desktop
        const indicatorsDesktop = controlsDesktop ? controlsDesktop.querySelectorAll('.tc-indicator') : [];
        indicatorsDesktop.forEach((indicator, index) => {
            const isActive = index === activeIndicatorIndex;
            indicator.classList.toggle('active', isActive);
            indicator.setAttribute('aria-current', isActive ? 'true' : 'false');
        });

        // Atualizar indicadores mobile
        const indicatorsMobile = controlsMobile ? controlsMobile.querySelectorAll('.tc-indicator') : [];
        indicatorsMobile.forEach((indicator, index) => {
            const isActive = index === activeIndicatorIndex;
            indicator.classList.toggle('active', isActive);
            indicator.setAttribute('aria-current', isActive ? 'true' : 'false');
        });
    }

    // Função para ir para próximo slide
    function nextSlide() {
        currentIndex = (currentIndex + 1) % totalSlides; // Carrossel infinito
        updateCarousel();
        updateIndicators();
    }

    // Função para ir para slide anterior
    function prevSlide() {
        currentIndex = currentIndex === 0 ? totalSlides - 1 : currentIndex - 1; // Carrossel infinito
        updateCarousel();
        updateIndicators();
    }

    // Event listeners para botões desktop
    if (controlsDesktop) {
        const prevBtnDesktop = controlsDesktop.querySelector('.tc-prev');
        const nextBtnDesktop = controlsDesktop.querySelector('.tc-next');
        
        if (prevBtnDesktop) {
            prevBtnDesktop.addEventListener('click', prevSlide);
            prevBtnDesktop.addEventListener('touchstart', function(e) {
                e.preventDefault();
                prevSlide();
            });
        }
        
        if (nextBtnDesktop) {
            nextBtnDesktop.addEventListener('click', nextSlide);
            nextBtnDesktop.addEventListener('touchstart', function(e) {
                e.preventDefault();
                nextSlide();
            });
        }

        // Event listeners para indicadores desktop
        const indicatorsDesktop = controlsDesktop.querySelectorAll('.tc-indicator');
        indicatorsDesktop.forEach((indicator, index) => {
            const handleDesktopIndicatorClick = function() {
                // Calcular o índice correto baseado no grupo atual
                const currentGroup = Math.floor(currentIndex / 4);
                currentIndex = (currentGroup * 4) + index;
                
                // Se exceder o total, voltar para o índice correto
                if (currentIndex >= totalSlides) {
                    currentIndex = index;
                }
                
                updateCarousel();
                updateIndicators();
            };
            
            indicator.addEventListener('click', handleDesktopIndicatorClick);
            indicator.addEventListener('touchstart', function(e) {
                e.preventDefault();
                handleDesktopIndicatorClick();
            });
        });
    }

    // Event listeners para botões mobile
    if (controlsMobile) {
        const prevBtnMobile = controlsMobile.querySelector('.tc-prev');
        const nextBtnMobile = controlsMobile.querySelector('.tc-next');
        
        console.log('Mobile buttons found:', { prevBtnMobile, nextBtnMobile });
        
        if (prevBtnMobile) {
            prevBtnMobile.addEventListener('click', function() {
                console.log('Mobile prev button clicked');
                prevSlide();
            });
            prevBtnMobile.addEventListener('touchstart', function(e) {
                console.log('Mobile prev button touched');
                e.preventDefault();
                prevSlide();
            });
        }
        
        if (nextBtnMobile) {
            nextBtnMobile.addEventListener('click', function() {
                console.log('Mobile next button clicked');
                nextSlide();
            });
            nextBtnMobile.addEventListener('touchstart', function(e) {
                console.log('Mobile next button touched');
                e.preventDefault();
                nextSlide();
            });
        }

        // Event listeners para indicadores mobile
        const indicatorsMobile = controlsMobile.querySelectorAll('.tc-indicator');
        indicatorsMobile.forEach((indicator, index) => {
            const handleIndicatorClick = function() {
                // Calcular o índice correto baseado no grupo atual
                const currentGroup = Math.floor(currentIndex / 4);
                currentIndex = (currentGroup * 4) + index;
                
                // Se exceder o total, voltar para o índice correto
                if (currentIndex >= totalSlides) {
                    currentIndex = index;
                }
                
                updateCarousel();
                updateIndicators();
            };
            
            indicator.addEventListener('click', handleIndicatorClick);
            indicator.addEventListener('touchstart', function(e) {
                e.preventDefault();
                handleIndicatorClick();
            });
        });
    }

    // Inicializar carrossel
    updateCarousel();
    updateIndicators();
    
    // Recalcular em resize para mudanças desktop/mobile
    window.addEventListener('resize', function() {
        updateCarousel();
    });
});