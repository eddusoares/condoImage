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
                                <h3 class="title">{{ __($pageTitle) }}</h3>
                            </div>
                            <form action="{{ route('user.password.verify.code') }}" method="POST" class="submit-form">
                                @csrf
                                <p class="verification-text text-light mb-3">@lang('A 6 digit verification code sent to your email address')
                                    : {{ showEmailAddress($email) }}</p>
                                <input type="hidden" name="email" value="{{ $email }}">

                                @include($activeTemplate . 'components.verification_code')

                                <div class="form-group mb-3">
                                    <button type="submit" class="btn button w-100">@lang('Submit')</button>
                                </div>

                                <div class="form-group text-light">
                                    @lang('Please check including your Junk/Spam Folder. if not found, you can')
                                    <a class="text--base" href="{{ route('user.password.request') }}">@lang('Try to send again')</a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
