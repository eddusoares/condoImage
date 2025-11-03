@extends($activeTemplate . 'layouts.master')
@section('content')
    <!-- body-wrapper-start -->
    <div class="body-wrapper">
        <div class="table-content">
            <div class="row justify-content-center">
                @if (!auth()->user()->ts)
                    <div class="col-xl-5 col-lg-5">
                        <div class="two-fact-wrapper">
                            <div class="two-fact-left">
                                <h5 class="card-title">@lang('Add Your Account')</h5>
                                <div class="two-fact-left__thumb">
                                    <img class="mx-auto" src="{{ $qrCodeUrl }}">
                                </div>
                                <div class="two-fact-left__content">
                                    <p class="mb-3">
                                        @lang('Use the QR code or setup key on your Google Authenticator app to add your account. ')
                                    </p>
                                </div>
                                <div class="two-fact-left__bottom">
                                    <div class="top">
                                        <label class="form--label">@lang('Setup Key')</label>
                                        <span><i class="fas fa-info-circle"></i></span>
                                    </div>
                                    <div class="bottom">
                                        <div class="form-group form-group right">
                                            <input type="text" class="form--control referralURL" name="key"
                                                value="{{ $secret }}" readonly>
                                            <button id="copyBoard" class="input-group-text copytext"><i
                                                    class="fas fa-copy"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (auth()->user()->ts)
                    <div class="col-xl-7 col-lg-7">
                        <div class="profile-right-wrap">
                            <div class="row">
                                <h5 class="mb-4">@lang('Disable 2FA Security')</h5>
                                <form action="{{ route('user.twofactor.disable') }}" method="POST">
                                    @csrf
                                    <div class="card-body">
                                        <input type="hidden" name="key" value="{{ $secret }}">
                                        <div class="form-group mb-3">
                                            <label class="form--label">@lang('Google Authenticatior OTP')</label>
                                            <input type="text" class="form--control" name="code"
                                                required>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn button">@lang('Save')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-xl-7 col-lg-7">
                        <div class="profile-right-wrap">
                            <div class="row">
                                <h5>@lang('Enable 2FA Security')</h5>
                                <form action="{{ route('user.twofactor.enable') }}" method="POST">
                                    @csrf
                                    <div class="card-body">
                                        <input type="hidden" name="key" value="{{ $secret }}">
                                        <div class="form-group mb-3">
                                            <label class="form--label">@lang('Google Authenticatior OTP')</label>
                                            <input type="text" class="form--control" name="code" required>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn button">@lang('Save')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .copied::after {
            background-color: #{{ $general->base_color }
        }

        ;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('#copyBoard').on('click', function() {
                var copyText = document.getElementsByClassName("referralURL");
                copyText = copyText[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                /*For mobile devices*/
                document.execCommand("copy");
                copyText.blur();
                this.classList.add('copied');
                setTimeout(() => this.classList.remove('copied'), 1500);
            });
        })(jQuery);
    </script>
@endpush
