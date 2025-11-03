@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="dashboard-card-wrap mt-0" id="dropzone">
                    <form action="{{ route('admin.storage.update', $storageProvider->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <div class="image-upload">
                                            <div class="thumb">
                                                <div class="avatar-preview">
                                                    <div class="profilePicPreview"
                                                        style="background-image: url({{ getImage(getFilePath('storage') . '/' . @$storageProvider->logo) }});">
                                                        <button type="button" class="remove-image"><i
                                                                class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="avatar-edit">
                                                    <input type="file" class="profilePicUpload" name="image"
                                                        id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                                    <label for="profilePicUpload1"
                                                        class="btn btn--primary">@lang('Upload')</label>
                                                </div>
                                            </div>
                                            <small class="pt-4 mb-4">@lang('Recommend image size')
                                                ({{ getFileSize('storage') }})</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-8">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="name" class="required">@lang('Name')</label>
                                                <div class="input-group">
                                                    <input type="text" id="name" name="name" class="form-control" readonly
                                                        placeholder="Storage Name" value="{{ @$storageProvider->name }}" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-612 col-12">
                                            <div class="form-group">
                                                <label class="form--label">@lang('Status')</label>
                                                <select class="form-select select" required name="status"
                                                    onchange="status(this);">
                                                    <option selected value="">@lang('Select Status')</option>
                                                    <option
                                                        value="1"{{ $storageProvider->status == 1 ? 'selected' : '' }}>
                                                        @lang('Enable')</option>
                                                    <option
                                                        value="0"{{ $storageProvider->status == 0 ? 'selected' : '' }}>
                                                        @lang('Disable')</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($storageProvider->id != 1)
                                  <div class="col-lg-12 col-xl-12">
                                    <i class="fa fa-key me-2 mb-3"></i> {{ keyToTitle($storageProvider->name)  }}
                                    @foreach ($storageProvider->credentials ?? [] as $key => $value)
                                        <div class="col-lg-12">
                                            <label class="form-label capitalize">
                                                {{ keyToTitle( $key) }} :
                                            </label>
                                            <input type="text" name="credentials[{{ $key }}]"
                                                value="{{ $value }}" class="form-control remove-spaces">
                                        </div>
                                    @endforeach
                                </div>   
                                @endif
                               
                            </div>

                            <div class="col-sm-12 text-end">
                                <div class="card-footer">
                                    <a href="{{ route('admin.storage.index') }}"
                                        class="btn btn--primary back--button align-items-center">
                                        @lang('Back')
                                    </a>
                                    <button type="submit"
                                        class="btn btn--primary btn--sm">@lang('Save')</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
