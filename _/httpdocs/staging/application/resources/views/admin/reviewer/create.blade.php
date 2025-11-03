@extends('admin.layouts.app')
@section('panel')
    <div class="row gy-4">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-50 border-bottom pb-2">@lang('Create New Reviewer')</h5>
                    <form action="{{ route('admin.reviewer.insert') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview staff-check"
                                                    style="background-image: url({{ getImage(getFilePath('reviewerProfile')) }})">
                                                    <button type="button" class="remove-image"><i
                                                            class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" class="profilePicUpload" name="image"
                                                    id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                                <small class="mt-2">{{ getFileSize('reviewerProfile') }} @lang('is recommended')</small>
                                                <label for="profilePicUpload1"
                                                    class="btn bg--primary text-white">@lang('Upload Image')</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="inputState" class="form-label">@lang('Name')</label>
                                            <input class="form-control" type="text" name="name">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="inputState" class="form-label">@lang('Email')</label>
                                            <input class="form-control" type="email" name="email">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="inputState" class="form-label">@lang('Username')</label>
                                            <input class="form-control" type="text" name="username">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="inputState" class="form-label">@lang('Mobile')</label>
                                            <input class="form-control" type="number" name="mobile">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="inputState" class="form-label">@lang('Password')</label>
                                            <input class="form-control" type="text" name="password">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="inputState" class="form-label">@lang('Confirm Password')</label>
                                            <input class="form-control" type="text" name="password_confirmation">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn--primary btn-global float-end">@lang('Create')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
