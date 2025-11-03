@php
    $faq = getContent('faq.content', true);
    $elements = getContent('faq.element');
@endphp

<!-- ==================== FAQ Start ==================== -->
<section class="faq-section">
    <div class="container">
        <div class="faq-header">
            <h2 class="faq-title">Questions? Answers.</h2>
        </div>

        <div class="faq-content">
            <div class="faq-accordion">
                @foreach ($elements as $item)
                    <div class="faq-item">
                        <div class="faq-question" data-bs-toggle="collapse"
                            data-bs-target="#faq-collapse-{{ $loop->iteration }}" aria-expanded="false">
                            <h4 class="faq-question-text">{{ __($item->data_values->question) }}</h4>
                            <div class="faq-icon">+</div>
                        </div>
                        <div id="faq-collapse-{{ $loop->iteration }}" class="faq-answer collapse">
                            <div class="faq-answer-content">
                                @php echo $item->data_values->answer; @endphp
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</section>
<!-- ==================== FAQ End ==================== -->