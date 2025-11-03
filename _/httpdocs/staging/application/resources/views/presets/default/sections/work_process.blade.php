@php
    $work_process = getContent('work_process.content', true);
    $elements = getContent('work_process.element');
@endphp

<!-- ==================== How It Works Start ==================== -->
<section class="how-it-work">
    <div class="container">
        <div class="how-it-work__header">
            <h2 class="how-it-work__title">{{ __($work_process->data_values->heading ?? "How it works") }}</h2>
            <p class="how-it-work__subtitle">{{ __($work_process->data_values->subheading ?? "Simplicity meets precision. Explore, select, and download the visuals you need — all in a seamless flow designed for professionals.") }}</p>
        </div>
        <div class="how-it-work__grid">
            @foreach ($elements as $item)
                @php
                    // Map icons based on loop iteration
                    $iconMapping = [
                        1 => 'building.svg',
                        2 => 'image.svg',
                        3 => 'image_download.svg'
                    ];
                    $iconFile = $iconMapping[$loop->iteration] ?? 'building.svg';
                @endphp
                <div class="how-it-work__card">
                    <div class="how-it-work__icon">
                        <img src="{{ asset('application/assets/images/svg/' . $iconFile) }}"
                            alt="{{ __($item->data_values->title) }}">
                    </div>
                    <h5 class="how-it-work__card-title">{{ __($item->data_values->title) }}</h5>
                    <p class="how-it-work__card-description">@php echo __($item->data_values->description) @endphp</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- ==================== How It Works End ==================== -->
