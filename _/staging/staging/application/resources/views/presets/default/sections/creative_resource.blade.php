@php
    $creatives = getContent('creative_resource.content', true);
    $elements = getContent('creative_resource.element');
@endphp
<!--========================== Creative Resource Start ==========================-->
<section class="about py-100">
    
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12 pt-lg-0 pt-md-4 pt-4 my-auto wow animate__animated animate__fadeInLeft"
                data-wow-delay="0.6s">
                <div class="content">
                    <div class="top">
                        <h3>{{ __($creatives->data_values->heading) }}</h3>
                        <p>{{ __($creatives->data_values->subheading) }}</p>
                    </div>
                    @foreach ($elements as $item)
                        <div class="check d-flex">
                            @php echo $item->data_values->icon; @endphp
                            <div>
                                <h6>{{ __($item->data_values->title) }}</h6>
                                @php echo __($item->data_values->description); @endphp
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6 col-12 pt-lg-0 pt-md-4 pt-4 wow animate__animated animate__fadeInRight"
                data-wow-delay="0.6s">
                <img src="{{ getImage(getFilePath('creative') . '/' . $creatives->data_values->image) }}" class="img-fluid d-flex ms-auto" alt="image">
            </div>
        </div>

    </div>
</section>
<!--========================== Creative Resource End ==========================-->
