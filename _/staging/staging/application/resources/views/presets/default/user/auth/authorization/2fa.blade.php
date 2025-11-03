@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="account bg-img py-120 bg-overlay-two"
        data-background="{{ getImage(getFilePath('others') . '/' . 'signinbg.png') }}">
        <div class="account-inner">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="account-form">
                            <div class="content text-center">
                                <a class="navbar-brand logo" href="{{ route('home') }}"><img
                                        src="{{ getImage('assets/images/general/logo2.png') }}" alt="logo"></a>
                                <h5 class="title">{{ $pageTitle }}</h5>
                            </div>
                            <form action="{{ route('user.go2fa.verify') }}" method="POST" class="submit-form">
                                @csrf
                                <div class="">
                                    @include($activeTemplate . 'components.verification_code')

                                    <div class="form--group text-end">
                                        <button type="submit" class="btn button w-100">@lang('Submit')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script>
        (function($) {
            "use strict";
            $('#code').on('input change', function() {
                var xx = document.getElementById('code').value;

                $(this).val(function(index, value) {
                    value = value.substr(0, 7);
                    return value.replace(/\W/gi, '').replace(/(.{3})/g, '$1 ');
                });

            });
        })(jQuery)
    </script>
@endpush
