@php
    $work_process = getContent('work_process.content', true);
    $elements = getContent('work_process.element');
@endphp

<!-- ==================== How It Works Start ==================== -->
<section class="how-it-work py-100">
    <div class="container">
        <div class="title mb-4">
            <h3>{{ __($work_process->data_values->heading) }}</h3>
            <p>{{ __($work_process->data_values->subheading) }}</p>
        </div>
        <div class="row g-4 pt-3 wow animate__animated animate__fadeInUp" data-wow-delay="0.6s">
            @foreach ($elements as $item)
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card">
                        <div>
                            <img src="{{ getImage(getFilePath('work') . '/' . $item->data_values->image) }}" alt="image">
                        </div>
                        <div>
                            <h5>{{ __($item->data_values->title) }}</h5>
                            @php echo __($item->data_values->description) @endphp
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- ==================== How It Works End ==================== -->
