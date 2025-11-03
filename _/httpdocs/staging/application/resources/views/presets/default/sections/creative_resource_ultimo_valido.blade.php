@php
    $creatives = getContent('creative_resource.content', true);
    $elements = getContent('creative_resource.element');
    // Coleta até 9 imagens de 'creative_resource.element'
    $panelImages = collect($elements)->pluck('data_values.image')->filter()->take(9);
    // Constrói caminhos completos das miniaturas
    $thumbs = [];
    foreach ($panelImages as $img) {
        $thumbs[] = getImage(getFilePath('creative') . '/' . $img);
    }
    // Fallback: preenche com imagens reais de prédios se não houver no conteúdo
    if (count($thumbs) === 0) {
        try {
            $fallback = App\Models\BuildingImage::query()->inRandomOrder()->take(9)->get();
            foreach ($fallback as $fi) {
                $thumbs[] = getImage(getFilePath('building') . '/' . $fi->image);
            }
        } catch (\Throwable $e) {
            // ignora em caso de ausência de tabela ou dados
        }
    }
@endphp
<!--========================== Creative Resource Start ==========================-->
<section class="cr-section">
    <div class="container">
        <div class="row cr-row align-items-stretch">
            <!-- Copy à esquerda -->
            <div class="col-lg-6 cr-left-col">
                <div class="cr-copy">
                    <h3 class="cr-title">{{ __($creatives->data_values->heading) }}</h3>
                    <p class="cr-subtitle">{{ __($creatives->data_values->subheading) }}</p>

                    <div class="cr-features">
                        @foreach ($elements as $item)
                            <div class="cr-feature">
                                <h6 class="cr-feature__title">{{ __($item->data_values->title) }}</h6>
                                <p class="mb-0">@php echo __($item->data_values->description); @endphp</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Painel de imagens à direita -->
            <div class="col-lg-6 cr-right-col">
                <div class="cr-panel-wrapper">
                    <div class="cr-panel">
                        <h4 class="cr-panel__heading">Visual <span>that sell.</span></h4>
                        <div class="cr-grid">
                            @foreach ($thumbs as $src)
                                <img class="cr-grid__img" src="{{ $src }}" alt="visual">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--========================== Creative Resource End ==========================-->