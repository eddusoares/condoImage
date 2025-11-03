@php
    $pages = App\Models\Page::get();

@endphp
@extends($activeTemplate . 'layouts.frontend')
@section('content')
    
    <!--=======-** Terms Of Service start **-=======-->
    <section class="py-100">
        <div class="policy-shape">
            <img src="{{ getImage(getFilePath('others') . '/' . 'bg-shape.png') }}" alt="image">
        </div>
        <div class="container">
            <div class="terms">
                <div class="row">
                    <div class="privacy-wrapper">
                        <h3 class="title-two text-center">{{ __($pageTitle) }}</h3>
                        <div class="wyg">
                            @php
                                echo $cookie->data_values->description;
                            @endphp
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=======-** Terms Of Service End **-=======-->
@endsection

@push('style')
    <style>
        .wyg h1,
        h2,
        h3,
        h4 {
            color: #383838;
        }

        .wyg strong {
            color: #383838
        }

        .wyg p {
            color: #666666
        }

        .wyg ul {
            margin-left: 40px
        }

        .wyg ul li {
            list-style-type: disc;
            color: #666666
        }

        .section-title {
            font-size: 30px;
            margin-bottom: 0;
        }
    </style>
@endpush
