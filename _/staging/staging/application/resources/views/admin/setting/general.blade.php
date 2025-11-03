@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <h5 class="card-header">@lang('Website Settings')</h5>
                <div class="card-body px-4 timeZoneParentDiv">
                    <form action="" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row mb-2">
                                    <div class="col-md-3 col-xs-4 d-flex align-items-center">
                                        <label class="required"> @lang('Site Title')</label>
                                    </div>
                                    <div class="col-md-9 col-xs-12">
                                        <input class="form-control" type="text" name="site_name" required
                                            value="{{ $general->site_name }}">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3 col-xs-4 d-flex align-items-center">
                                        <label>@lang('Theme')</label>
                                    </div>
                                    <div class="col-md-9 col-xs-12">
                                        <select class="form-control" name="theme">
                                            <option value="1" {{ $general->theme == 1 ? 'selected' : '' }}>
                                                @lang('Theme One')</option>
                                            <option value="2" {{ $general->theme == 2 ? 'selected' : '' }}>
                                                @lang('Theme Two')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3 col-xs-4 d-flex align-items-center">
                                        <label class="required">@lang('Currency')</label>
                                    </div>
                                    <div class="col-md-9 col-xs-12">
                                        <input class="form-control" type="text" name="cur_text" required
                                            value="{{ $general->cur_text }}">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3 col-xs-4 d-flex align-items-center">
                                        <label class="required">@lang('Currency Symbol')</label>
                                    </div>
                                    <div class="col-md-9 col-xs-12">
                                        <input class="form-control" type="text" name="cur_sym" required
                                            value="{{ $general->cur_sym }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row mb-2">
                                    <div class="col-md-3 col-xs-4 d-flex align-items-center">
                                        <label> @lang('Timezone')</label>
                                    </div>
                                    <div class="col-md-9 col-xs-12">
                                        <select class="select2-basic" name="timezone">
                                            @foreach($timezones as $key => $timezone)
                                            <option value="{{ $key }}" @selected($key == $currentTimezone)>{{ __($timezone) }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3 col-xs-4 d-flex align-items-center">
                                        <label> @lang('Site Base Color')</label>
                                    </div>
                                    <div class="col-md-9 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-text p-0 border-0">
                                                <input type='text' class="form-control colorPicker"
                                                    value="{{ $general->base_color }}" />
                                            </span>
                                            <input type="text" class="form-control colorCode" name="base_color"
                                                value="{{ $general->base_color }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-3 col-xs-4 d-flex align-items-center">
                                        <label> @lang('Site Secondary Color')</label>
                                    </div>
                                    <div class="col-md-9 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-text p-0 border-0">
                                                <input type='text' class="form-control colorPicker"
                                                    value="{{ $general->secondary_color }}" />
                                            </span>
                                            <input type="text" class="form-control colorCode" name="secondary_color"
                                                value="{{ $general->secondary_color }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="form-group col-md-2 col-sm-6 mb-4">
                                <label class="fw-bold">@lang('User Registration')</label>
                                <label class="switch m-0">
                                    <input type="checkbox" class="toggle-switch" name="registration"
                                        {{ $general->registration ? 'checked' : null }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="form-group col-md-2 col-sm-6 mb-4">
                                <label class="fw-bold">@lang('KYC Verification')</label>
                                <label class="switch m-0">
                                    <input type="checkbox" class="toggle-switch" name="kv" {{ $general->kv ?
                                    'checked' : null }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="form-group col-md-2 col-sm-6 mb-4">
                                <label class="fw-bold">@lang('Email Verification')</label>
                                <label class="switch m-0">
                                    <input type="checkbox" class="toggle-switch" name="ev"
                                        {{ $general->ev ? 'checked' : null }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="form-group col-md-2 col-sm-6 mb-4">
                                <label class="fw-bold">@lang('Email Notification')</label>
                                <label class="switch m-0">
                                    <input type="checkbox" class="toggle-switch" name="en"
                                        {{ $general->en ? 'checked' : null }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="form-group col-md-2 col-sm-6 mb-4">
                                <label class="fw-bold">@lang('Mobile Verification')</label>
                                <label class="switch m-0">
                                    <input type="checkbox" class="toggle-switch" name="sv"
                                        {{ $general->sv ? 'checked' : null }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="form-group col-md-2 col-sm-6 mb-4">
                                <label class="fw-bold">@lang('SMS Notification')</label>
                                <label class="switch m-0">
                                    <input type="checkbox" class="toggle-switch" name="sn"
                                        {{ $general->sn ? 'checked' : null }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="form-group col-md-2 col-sm-6 mb-4">
                                <label class="fw-bold">@lang('Terms & Condition')</label>
                                <label class="switch m-0">
                                    <input type="checkbox" class="toggle-switch" name="agree"
                                        {{ $general->agree ? 'checked' : null }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-end">
                                <button type="submit" class="btn btn--primary btn-global">@lang('Save')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-30">
            <form action="{{ route('admin.setting.watermark.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card overflow-hidden">
                    <h5 class="card-header">@lang('Watermark')</h5>
                    <div class="card-body">
                        <div class="row my-3 mx-1 border p-3">
                            <div class="col-md-6 d-flex flex-column justify-content-center">
                                <div class="file-upload-wrapper" data-text="@lang('Select your file!')">
                                    <input type="file" accept=".png, .jpg, .jpeg" name="watermark"
                                        class="file-upload-field" id="imageInput">
                                </div>
                            </div>
                            <div class="col-md-6 d-flex align-items-center justify-content-center bg--dark">
                                <img src=" {{ getImage(getFilePath('others') . '/watermark.png', '?' . time()) }}"
                                    alt="{{ config('app.name') }}" id="imagePreview2">
                            </div>
                        </div>
                        <div class="form-group mb-0 text-end">
                            <button type="submit" class="btn bg--primary btn-global">@lang('Save')</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>


        <div class="col-lg-12 mb-30">
            <form action="{{ route('admin.update.commission') }}" method="POST">
                @csrf
                <div class="card border">
                    <h5 class="card-header">@lang('Commission Per Sell')</h5>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="fixed_charge" class="required">@lang('Building Commission')</label>
                            <div class="input-group">
                                <input type="number" step="any" class="form-control" name="building_commission"
                                    value="{{ showAmount($general->building_commission) }}" required>
                                <span class="input-group-text bg--primary"> % </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="percent_charge" class="required">@lang('Listing Commission')</label>
                            <div class="input-group">
                                <input type="number" step="any" class="form-control" name="listing_commission"
                                    value="{{ showAmount($general->listing_commission) }}" required>
                                <span class="input-group-text bg--primary">%</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-end mt-3">
                                <button type="submit" class="btn btn--primary btn-global">@lang('Save')</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

     
    </div>
@endsection

@push('script-lib')
    <script src="{{ asset('assets/admin/js/spectrum.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/spectrum.css') }}">
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.colorPicker').spectrum({
                color: $(this).data('color'),
                change: function(color) {
                    $(this).parent().siblings('.colorCode').val(color.toHexString().replace(/^#?/, ''));
                }
            });

            $('.colorCode').on('input', function() {
                var clr = $(this).val();
                $(this).parents('.input-group').find('.colorPicker').spectrum({
                    color: clr,
                });
            });
            $('.select2-basic').select2({
                dropdownParent: $('.card-body')
            });
        })(jQuery);
    </script>

    <script>
        $(document).ready(function() {
            "use strict";
            $("#imageInput").change(function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $("#imagePreview2").attr("src", e.target.result);
                    };

                    reader.readAsDataURL(file);
                } else {
                    $("#imagePreview2").attr("src", "");
                }
            });
        });
    </script>
@endpush
