@php
    $visual = getContent('visual_compilation.content', true);
    // Usar a imagem específica do Figma - caminho completo
    $heroSrc = asset('application/assets/images/listing_asset_image/visual_compilation.jpg');
@endphp

<!-- ==================== Visual Compilation (CTA) ==================== -->
<section class="vc-section">
    <div class="container">
        <div class="vc-hero" style="background: linear-gradient(0deg, rgba(77, 77, 81, 0.70) 0%, rgba(77, 77, 81, 0.70) 100%), url('{{ $heroSrc }}') lightgray 50% / cover no-repeat; background-blend-mode: hard-light, normal;">
            <div class="vc-hero__content">
                <h2 class="vc-hero__title">{{ __($visual->data_values->heading) }}</h2>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function updateVCBackground() {
        const vcHero = document.querySelector('.vc-hero');
        if (vcHero) {
            const isMobile = window.innerWidth <= 991.98;
            const heroSrc = '{{ $heroSrc }}';
            
            if (isMobile) {
                // Mobile: opacidade 0.85
                vcHero.style.background = `linear-gradient(0deg, rgba(77, 77, 81, 0.85) 0%, rgba(77, 77, 81, 0.85) 100%), url('${heroSrc}') lightgray 50% / cover no-repeat`;
            } else {
                // Desktop: opacidade 0.70
                vcHero.style.background = `linear-gradient(0deg, rgba(77, 77, 81, 0.70) 0%, rgba(77, 77, 81, 0.70) 100%), url('${heroSrc}') lightgray 50% / cover no-repeat`;
            }
            vcHero.style.backgroundBlendMode = 'hard-light, normal';
        }
    }
    
    updateVCBackground();
    window.addEventListener('resize', updateVCBackground);
});
</script>
<!-- ==================== Visual Compilation End ==================== -->
