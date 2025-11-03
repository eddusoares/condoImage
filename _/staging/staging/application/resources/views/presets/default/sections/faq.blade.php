@php
    $faq = getContent('faq.content', true);
    $elements = getContent('faq.element');
@endphp

<!-- ==================== FAQ End ==================== -->
<section class="faq py-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-12 my-auto">
                <div class="content">
                    <h3>{{ __($faq->data_values->heading) }}</h3>
                    <p>{{ __($faq->data_values->subheading) }}</p>
                    <a href="{{ $faq->data_values->button_link }}"
                        class="btn button mt-4">{{ __($faq->data_values->button_name) }}</a>
                </div>
            </div>
            <div class="col-lg-7 col-12 my-auto mt-4 mt-lg-0 mt-md-0">
                <div class="accordion custom--accordion" id="accordionExample">
                    @foreach ($elements as $item)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne{{ $loop->iteration }}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-{{ $loop->iteration }}" aria-expanded="{{ $loop->iteration == 1 ? 'true' : 'false' }}" aria-controls="headingOne{{ $loop->iteration }}">
                                    {{ __($item->data_values->question) }}
                                </button>
                            </h2>
                            <div id="collapse-{{ $loop->iteration }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : ''}}" aria-labelledby="headingOne{{ $loop->iteration }}"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    @php echo $item->data_values->answer; @endphp
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== FAQ End ==================== -->
