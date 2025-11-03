@extends($activeTemplate . 'layouts.master')

@section('content')
    <!-- body-wrapper-start -->
    <div class="body-wrapper">
        <div class="table-content">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="dashboard-card-wrap mt-0">
                        <div class="row gy-4">
                            <div class="col-12">
                                <div class="border-box user-profile">
                                    <form action="" method="post">
                                        @csrf
                                        <div class="col-sm-12 mb-3">
                                            <label class="form-label">@lang('Current Password')</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control form--control"
                                                    name="current_password" required autocomplete="current-password">
                                                <div class="password-show-hide toggle-password-change fas fa-eye-slash"
                                                    data-target="current_password"> </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 mb-3">
                                            <label class="form-label">@lang('New Password')</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control form--control" name="password"
                                                    required autocomplete="current-password">
                                                <div class="password-show-hide toggle-password-change fas fa-eye-slash"
                                                    data-target="password"> </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <label class="form-label">@lang('Confirm Password')</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control form--control"
                                                    name="password_confirmation" required autocomplete="current-password">
                                                <div class="password-show-hide toggle-password-change fas fa-eye-slash"
                                                    data-target="password_confirmation"> </div>
                                            </div>
                                        </div>
                                        <div class="form-group text-end">
                                            <button type="submit" class="btn button">@lang('Update')</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
