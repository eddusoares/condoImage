@php
    $visual = getContent('visual_compilation.content', true);
@endphp

<!-- ==================== Action Start ==================== -->
<section class="action py-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12 mx-auto text-center">
                <div>
                    <h3>{{ __($visual->data_values->heading) }}</h3>
                    <p>{{ __($visual->data_values->subheading) }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Action End ==================== -->
