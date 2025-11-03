@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $policyPages = getContent('policy_pages.element', false, null, true);
    @endphp
    <section class="account bg-img py-120 bg-overlay-two"
        data-background="{{ getImage(getFilePath('others') . '/' . 'signinbg.png') }}">
        <div class="account-inner">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-10 col-12">
                        <div class="account-form">
                            <div class="content">
                                <a class="navbar-brand logo" href="{{ route('home') }}"><img
                                        src="{{ getImage('assets/images/general/logo2.png') }}" alt="logo"></a>
                                <h3 class="title">@lang('Sign up')</h3>
                            </div>

                            <form action="{{ route('user.register') }}" method="POST" class="verify-gcaptcha">
                                @csrf
                                <div class="row gy-3">
                                    @if (session()->get('reference') != null)
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="referenceBy" class="form--label">@lang('Reference by')</label>
                                                <input type="text" name="referBy" id="referenceBy"
                                                    class="form-control form--control"
                                                    value="{{ session()->get('reference') }}" readonly>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="d-flex justify-content-center gap-3">
                                        <button type="button" class="btn btn-primary user">@lang('User')</button>
                                        <button type="button"
                                            class="btn btn-primary contributor">@lang('Contributor')</button>
                                        <input type="text" hidden name="user_type">
                                    </div>



                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Username')</label>
                                            <input type="text" class="form-control form--control checkUser"
                                                name="username" value="{{ old('username') }}" placeholder="Username"
                                                required>
                                            <small class="text-danger usernameExist"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('E-Mail Address')</label>
                                            <input type="email" class="form-control form--control checkUser"
                                                name="email" value="{{ old('email') }}" placeholder="Email" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Country')</label>
                                            <select name="country" class="form--control select-login">
                                                @foreach ($countries as $key => $country)
                                                    <option data-mobile_code="{{ $country->dial_code }}"
                                                        value="{{ $country->country }}" data-code="{{ $key }}">
                                                        {{ __($country->country) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Mobile')</label>
                                            <div class="input-group">
                                                <span class="input-group-text mobile-code bg--base border-0 text-light">

                                                </span>
                                                <input type="hidden" name="mobile_code">
                                                <input type="hidden" name="country_code">
                                                <input type="number" name="mobile" value="{{ old('mobile') }}"
                                                    class="form-control form--control checkUser" required>
                                            </div>
                                            <small class="text-danger mobileExist"></small>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">@lang('Password')</label>
                                        <div class="input-group">
                                            <input id="password" type="password" class="form-control form--control"
                                                name="password" placeholder="Password" required>
                                            @if ($general->secure_password)
                                                <div class="input-popup">
                                                    <p class="error lower">@lang('1 small letter minimum')</p>
                                                    <p class="error capital">@lang('1 capital letter minimum')</p>
                                                    <p class="error number">@lang('1 number minimum')</p>
                                                    <p class="error special">@lang('1 special character minimum')</p>
                                                    <p class="error minimum">@lang('6 character password')</p>
                                                </div>
                                            @endif
                                            <div class="password-show-hide fas fa-eye toggle-password fa-eye-slash"
                                                id="#password"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="confirm-password" class="form--label">@lang('Confirm Password')</label>
                                        <div class="input-group">
                                            <input id="password_confirmation" type="password"
                                                class="form-control form--control" name="password_confirmation"
                                                placeholder="Confirm Password" required>
                                            <div class="password-show-hide fas fa-eye toggle-password fa-eye-slash"
                                                id="#password_confirmation"></div>
                                        </div>
                                    </div>

                                    <x-captcha></x-captcha>
                                    <div class="form-group">
                                        <div class="form--check">
                                            <input class="form-check-input me-2" type="checkbox" id="agree"
                                                @checked(old('agree')) name="agree" required>
                                            <label for="agree"> @lang('I agree with') @foreach ($policyPages as $policy)
                                                    <a class="text--base"
                                                        href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}">{{ __($policy->data_values->title) }}</a>
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn button w-100">@lang('Sign Up')</button>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="text-center">
                                            <p class="text">@lang('Already Have An Account')? <a href="{{ route('user.login') }}"
                                                    class="text--base">@lang('Sign In')</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <h6 class="text-center mb-0  py-3">@lang('You already have an account please Login ')</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--sm button" data-bs-dismiss="modal">@lang('Close')</button>
                    <a href="{{ route('user.login') }}" class="btn btn--sm button">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .country-code .input-group-text {
            background: #fff !important;
        }

        .country-code select {
            border: none;
        }

        .country-code select:focus {
            border: none;
            outline: none;
        }
    </style>
@endpush
@push('script-lib')
    <script src="{{ asset('assets/common/js/secure_password.js') }}"></script>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
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

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false && response.type == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });
        })(jQuery);
    </script>

    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {
                $('.user, .contributor').on('click', function() {
                    const userType = $(this).hasClass('user') ? 1 : 2;
                    $('input[name="user_type"]').val(userType);
                });
            });

        })(jQuery);
    </script>
@endpush
