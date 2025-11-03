@php
    $creatives = getContent('creative_resource.content', true);
    $elements = getContent('creative_resource.element');
@endphp
<!--========================== Creative Resource Start ==========================-->
<section class="cr-section">
    <div class="container">
        <div class="cr-main">
            <!-- Coluna esquerda - ConteÃºdo -->
            <div class="cr-left-column">
                <div class="cr-header">
                    <h2 class="cr-title">{{ __($creatives->data_values->heading) }}</h2>
                    <p class="cr-subtitle">{{ __($creatives->data_values->subheading) }}</p>
                </div>

                <div class="cr-features">
                    @foreach ($elements as $item)
                        <div class="cr-feature">
                            <h4 class="cr-feature__title">
                                @php $icon = $item->data_values->icon ?? null; @endphp
                                @if(!empty($icon))
                                    <span class="cr-feature__icon"><i class="{{ $icon }}" aria-hidden="true"></i></span>
                                @endif
                                {{ __($item->data_values->title ?? '') }}
                            </h4>
                            <p class="cr-feature__description">@php echo __($item->data_values->description ?? ''); @endphp</p>
                            @if (!$loop->last)
                                <div class="cr-feature__divider"></div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Coluna direita - Imagem estÃ¡tica -->
            <div class="cr-right-column">
                <div class="cr-panel">
                    <img class="cr-static-visual" src="{{ getImage(getFilePath('creative') . '/' . ($creatives->data_values->image ?? '')) }}" alt="{{ __($creatives->data_values->heading ?? 'Creative Resource') }}">
                </div>
            </div>
        </div>
    </div>
</section>
<!--========================== Creative Resource End ==========================-->


