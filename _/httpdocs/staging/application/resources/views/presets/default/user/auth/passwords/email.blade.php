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
                            <form method="POST" action="{{ route('user.password.email') }}">
                                @csrf
                                <div class="row gy-3">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="email" class="form--label">@lang('Email or Username')</label>
                                            <input type="text" class="form--control" name="value"
                                                value="{{ old('value') }}" required autofocus="off">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
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
