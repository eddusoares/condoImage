@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="account bg-img py-120 bg-overlay-two"
        data-background="{{ getImage(getFilePath('others') . '/' . 'signinbg.png') }}">
        <div class="account-inner">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-md-10 col-12">
                        <div class="account-form">
                            <div class="content">
                                <a class="navbar-brand logo" href="{{ route('home') }}"><img
                                        src="{{ getImage('assets/images/general/logo2.png') }}" alt="logo"></a>
                                <h3 class="title">@lang('Sign In')</h3>
                            </div>
                            <form action="{{ route('user.verify.email') }}" method="POST" class="submit-form">
                                @csrf
                                <p class="verification-text text-light">@lang('A 6 digit verification code sent to your email address'): {{ showEmailAddress(auth()->user()->email) }}</p>
        
                                @include($activeTemplate . 'components.verification_code')
        
                                <div class="mb-3">
                                    <button type="submit" class="btn button w-100">@lang('Submit')</button>
                                </div>
        
                                <div class="mb-3">
                                    <p class="text-light">
                                        @lang('If you don\'t get any code'), <a href="{{ route('user.send.verify.code', 'email') }}">
                                            @lang('Try again')</a>
                                    </p>
        
                                    @if ($errors->has('resend'))
                                        <small class="text-danger d-block">{{ $errors->first('resend') }}</small>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
