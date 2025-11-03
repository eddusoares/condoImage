@php
    $contact = getContent('contact_us.content', true);
    $pages = App\Models\Page::get();
 
@endphp
@extends($activeTemplate . 'layouts.frontend')
@section('content')

    <!-- ==================== Contact Form & Map Start Here ==================== -->
    <section class="contact-bottom py-100">
        <div class="container">
            <div class="row gy-5 flex-wrap-reverse">
                <div class="col-lg-6 pe-lg-5">
                    <div class="contact-map">
                        <iframe
                            src="https://maps.google.com/maps?q={{ @$contact->data_values->latitude }},{{ @$contact->data_values->longitude }}&hl=es;z=14&amp;output=embed"
                            allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contactus-form">
                        <h3 class="contact__title">{{ @$contact->data_values->title }}</h3>
                        <form method="post" action="" class="verify-gcaptcha">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="form--label">@lang('Name')</label>
                                <input name="name" type="text" class="form--control"
                                    value="@if (auth()->user()) {{ auth()->user()->fullname }} @else{{ old('name') }} @endif"
                                    @if (auth()->user()) readonly @endif required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form--label">@lang('Email')</label>
                                <input name="email" type="email" class="form--control"
                                    value="@if (auth()->user()) {{ auth()->user()->email }}@else{{ old('email') }} @endif"
                                    @if (auth()->user()) readonly @endif required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form--label">@lang('Subject')</label>
                                <input name="subject" type="text" class="form--control" value="{{ old('subject') }}"
                                    required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">@lang('Message')</label>
                                <textarea name="message" wrap="off" class="form--control" required>{{ old('message') }}</textarea>
                            </div>
                            <x-captcha></x-captcha>
                            <div class="form-group">
                                <button type="submit" class="btn button w-100">@lang('Send')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==================== Contact Form & Map End Here ==================== -->
@endsection
