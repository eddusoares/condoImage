@php
    $visual = getContent('visual_compilation.content', true);
    // Usar a imagem específica do Figma - caminho completo
    $heroSrc = asset('application/assets/images/listing_asset_image/visual_compilation.jpg');
@endphp

<!-- ==================== Visual Compilation (CTA) ==================== -->
<section class="vc-section">
    <div class="container">
        <div class="vc-hero"
            style="background-image: linear-gradient(0deg, rgba(77, 77, 81, 0.7) 0%, rgba(77, 77, 81, 0.7) 100%), url('{{ $heroSrc }}');">
            <div class="vc-hero__content">
                <h2 class="vc-hero__title">{{ __($visual->data_values->heading) }}</h2>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Visual Compilation End ==================== -->