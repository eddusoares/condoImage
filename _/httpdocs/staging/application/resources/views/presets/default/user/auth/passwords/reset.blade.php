@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="account bg-img py-120 bg-overlay-two"
        data-background="{{ getImage(getFilePath('others') . '/' . 'signinbg.png') }}">
        <div class="account-inner">
            <div class="container">
                <div class="row justify-content-lg-end justify-content-center">
                    <div class="col-12">
                        <div class="account-form">
                            <div class="content">
                                <a class="navbar-brand logo d-flex mx-auto" href="{{ route('home') }}"><img
                                        src="{{ getImage('assets/images/general/logo2.png') }}" alt="logo"></a>
                                <h3 class="title">{{ $pageTitle }}</h3>
                            </div>
                            <form method="POST" action="{{ route('user.password.update') }}">
                                @csrf
                                <input type="hidden" name="email" value="{{ $email }}">
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="input-group mb-3">
                                    <label class="form--label">@lang('Password')</label>
                                    <input type="password" class="form--control" name="password" required>
                                    <div class="password-show-hide fas fa-eye toggle-password fa-eye-slash icon-eye-pos"
                                        id="#password"></div>
                                    @if ($general->secure_password)
                                        <div class="input-popup">
                                            <p class="error lower">@lang('1 small letter minimum')</p>
                                            <p class="error capital">@lang('1 capital letter minimum')</p>
                                            <p class="error number">@lang('1 number minimum')</p>
                                            <p class="error special">@lang('1 special character minimum')</p>
                                            <p class="error minimum">@lang('6 character password')</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="input-group mb-3">
                                    <label class="form--label">@lang('Confirm Password')</label>
                                    <input type="password" class="form--control" name="password_confirmation" required>
                                    <div class="password-show-hide fas fa-eye toggle-password fa-eye-slash icon-eye-pos"
                                        id="#password_confirmation"></div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn button w-100"> @lang('Submit')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script-lib')
    <script src="{{ asset('assets/common/js/secure_password.js') }}"></script>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            @if ($general->secure_password)
                $('input[name=password]').on('input', function() {
                    secure_password($(this));
                });

                $('[name=password]').focus(function() {
                    $(this).closest('.form-group').addClass('hover-input-popup');
                });

                $('[name=password]').focusout(function() {
                    $(this).closest('.form-group').removeClass('hover-input-popup');
                });
            @endif
        })(jQuery);
    </script>
@endpush
