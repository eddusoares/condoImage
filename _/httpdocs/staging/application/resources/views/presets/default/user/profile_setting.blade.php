@extends($activeTemplate . 'layouts.master')
@section('content')
    <!-- body-wrapper-start -->
    <div class="body-wrapper">
        <div class="table-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="dashboard-card-wrap mt-0">
                        <div class="row">
                            <div class="col-sm-12 mb-5 mt-3">
                                <div class="drop-file-wrap--">
                                    <div class="dashboard_profile_wrap">
                                        <form action="{{ route('user.change.image', $user->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="profile_photo">
                                                <img src="{{ getImage(getFilePath('userProfile') . '/' . $user->image) }}"
                                                    alt="@lang('agent')">
                                                <div class="photo_upload">
                                                    <label for="file_upload"><i class="fas fa-image"></i></label>
                                                    <input id="file_upload" name="image" type="file"
                                                        class="upload_file" onchange="this.form.submit()">
                                                </div>
                                            </div>
                                        </form>
                                        <div class="user-info text-center">
                                            <p><span>@lang('User Name'):</span> {{ @$user->fullname }}</p>
                                            <p><span>@lang('Email'):</span> {{ @$user->email }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form class="register" action="" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-6 mb-4">
                                    <label class="form--label">@lang('First Name')</label>
                                    <input type="text" class="form--control" name="firstname"
                                        value="{{ @$user->firstname }}" placeholder="First Name" required>
                                </div>
                                <div class="form-group col-sm-6 mb-4">
                                    <label class="form--label">@lang('Last Name')</label>
                                    <input type="text" class="form--control" name="lastname"
                                        value="{{ @$user->lastname }}" placeholder="Last Name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6 mb-4">
                                    <label class="form--label">@lang('E-mail Address')</label>
                                    <input class="form--control" value="{{ $user->email }}" placeholder="E-mail Address"
                                        readonly>
                                </div>
                                <div class="form-group col-sm-6 mb-4">
                                    <label class="form--label">@lang('Mobile Number')</label>
                                    <input class="form--control" value="{{ $user->mobile }}" placeholder="Mobile Number"
                                        readonly>
                                </div>
                            </div>


                            <div class="row">
                                <div class="form-group col-sm-6 mb-4">
                                    <label class="form--label">@lang('State')</label>
                                    <input type="text" class="form--control" name="state"
                                        value="{{ @$user->address->state }}" placeholder="State">
                                </div>
                                <div class="form-group col-sm-6 mb-4">
                                    <label class="form--label">@lang('Zip Code')</label>
                                    <input type="text" class="form--control" name="zip"
                                        value="{{ @$user->address->zip }}" placeholder="Zip Code">
                                </div>

                                <div class="form-group col-sm-6 mb-4">
                                    <label class="form--label">@lang('City')</label>
                                    <input type="text" class="form--control" name="city"
                                        value="{{ @$user->address->city }}" placeholder="City">
                                </div>

                                <div class="form-group col-sm-6 mb-4">
                                    <label class="form--label">@lang('Country')</label>
                                    <input class="form--control" value="{{ @$user->address->country }}"
                                        placeholder="Country" disabled>
                                </div>
                                <div class="col-sm-12 mb-4">
                                    <div class="form-group">
                                        <label for="address" class="form--label">@lang('Address')</label>
                                        <div class="input--group textarea">
                                            <textarea id="address" class="form--control" placeholder="Address" name="address">{{ @$user->address->address }}</textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group text-end">
                                <button type="submit" class="btn button">@lang('Save')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
