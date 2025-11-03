@php
    $creatives = getContent('creative_resource.content', true);
    $elements = getContent('creative_resource.element');
@endphp
<!--========================== Creative Resource Start ==========================-->
<section class="cr-section">
    <div class="container">
        <div class="cr-main">
            <!-- Coluna esquerda - Conteúdo -->
            <div class="cr-left-column">
                <div class="cr-header">
                    <h2 class="cr-title">{{ __($creatives->data_values->heading) }}</h2>
                    <p class="cr-subtitle">{{ __($creatives->data_values->subheading) }}</p>
                </div>

                <div class="cr-features">
                    @foreach ($elements as $item)
                        <div class="cr-feature">
                            <h4 class="cr-feature__title">{{ __($item->data_values->title) }}</h4>
                            <p class="cr-feature__description">@php echo __($item->data_values->description); @endphp</p>
                            @if (!$loop->last)
                                <div class="cr-feature__divider"></div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Coluna direita - Imagem estática -->
            <div class="cr-right-column">
                <div class="cr-panel">
                    <img class="cr-static-visual" src="{{ asset('application/assets/images/listing_asset_image/visual_that_sell.png') }}" alt="Visual that sell">
                </div>
            </div>
        </div>
    </div>
</section>
<!--========================== Creative Resource End ==========================-->

