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
                            data-bs-target="#faq-collapse-{{ $loop->iteration }}" aria-expanded="false"
                            aria-controls="faq-collapse-{{ $loop->iteration }}">
                            <h4 class="faq-question-text">{{ __($item->data_values->question) }}</h4>
                            <div class="faq-icon"></div>
                        </div>
                        <div id="faq-collapse-{{ $loop->iteration }}" class="faq-answer collapse">
                            <div class="faq-answer-content">
                                @php echo $item->data_values->answer; @endphp
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="faq-divider" aria-hidden="true"></div>
        </div>
    </div>

</section>
<!-- ==================== FAQ End ==================== -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Melhorar funcionalidade do accordion FAQ
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            // Atualizar aria-expanded para acessibilidade
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);
        });
    });

    // Escutar eventos do Bootstrap collapse
    const collapseElements = document.querySelectorAll('.faq-answer');
    
    collapseElements.forEach(collapse => {
        collapse.addEventListener('shown.bs.collapse', function() {
            const question = document.querySelector(`[data-bs-target="#${this.id}"]`);
            if (question) {
                question.setAttribute('aria-expanded', 'true');
            }
        });
        
        collapse.addEventListener('hidden.bs.collapse', function() {
            const question = document.querySelector(`[data-bs-target="#${this.id}"]`);
            if (question) {
                question.setAttribute('aria-expanded', 'false');
            }
        });
    });
});
</script>
