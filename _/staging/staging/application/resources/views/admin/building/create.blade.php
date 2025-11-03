@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <div class="row gy">
                        <form action="{{ route('admin.building.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="image-upload">
                                            <div class="thumb">
                                                <div class="avatar-preview">
                                                    <div class="profilePicPreview"
                                                        style="background-image: url({{ getImage(getFilePath('building')) }});">
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
                                                ({{ getFileSize('building') }})</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="mb-2 form--label">@lang('Name')</label>
                                                <input type="text" name="name" class="form-control"
                                                    placeholder="@lang('name')" value="{{ old('name') }}" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="mb-2 form--label">@lang('Neighborhood')</label>
                                                <select name="neighborhood_id" id="status" class="form-control" required>
                                                    <option>@lang('Select Neighborhood')</option>
                                                    @foreach ($neighborhoods ?? [] as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ $item->id == old('neighborhood_id') ? 'selected' : '' }}>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="address">@lang('Address')</label>
                                                <textarea name="address" rows="5" cols="5" class="form-control" required>{{ old('address') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="mb-2 form--label">@lang('Claim')</label>
                                        <select name="claim" id="status" class="form-control" required>
                                            <option>@lang('Select claim')</option>
                                            <option value="1">@lang('Claim for me')</option>
                                            <option value="2">@lang('Claim for user')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="mb-2 form--label">@lang('Years')</label>
                                        <input type="month" name="year_built" value="{{ old('year_built') }}"
                                            class="form-control" required />
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label class="mb-2 form--label">@lang('Price')</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="price" name="price"
                                                aria-label="price" aria-describedby="basic-addon2"
                                                value="{{ old('price') }}" required>
                                            <span class="input-group-text" id="basic-addon2">{{ gs()->cur_sym }}</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="mb-2 form--label">@lang('Units')</label>
                                        <input type="number" name="units" value="{{ old('unit') }}"
                                            class="form-control" required />
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label class="mb-2 form--label">@lang('Stories')</label>
                                        <input type="number" name="stories" value="{{ old('stories') }}"
                                            class="form-control" required />
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="mb-2 form--label">@lang('Status')</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>
                                                @lang('Active')</option>
                                            <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>
                                                @lang('Deactivate')</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="description">@lang('Description')</label>
                                        <textarea name="description" rows="10" cols="5" class="form-control trumEdit1"
                                            placeholder="@lang('Description')">{{ old('description') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="description">@lang('Copyright Description')</label>
                                        <textarea name="copyright_description" rows="7" cols="5" class="form-control trumEdit2"
                                            placeholder="@lang('Copyright Description')">{{ old('copyright_description') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12 text-end mt-3 d-none next">
                                    <button type="submit" class="btn btn--primary">
                                        @lang('Next')
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>

                                <div class="col-lg-12 text-end mt-3 save">
                                    <button type="submit" class="btn btn--primary">
                                        @lang('Save')
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .ck.ck-editor__main>.ck-editor__editable {
            height: 150px;
        }


        ::-webkit-scrollbar {
            width: .5rem;
        }

        ::-webkit-scrollbar-track {
            background: #bdc3c7;
            border-radius: .75rem;
        }

        ::-webkit-scrollbar-thumb {
            background: #34495e;
            border-radius: .75rem;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #2c3e50;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {
                "use strict";
                if ($(".trumEdit1")[0]) {
                    ClassicEditor
                        .create(document.querySelector('.trumEdit1'))
                        .then(editor => {
                            window.editor = editor;
                        });
                }
                if ($(".trumEdit2")[0]) {
                    ClassicEditor
                        .create(document.querySelector('.trumEdit2'))
                        .then(editor => {
                            window.editor = editor;
                        });
                }
            });
        })(jQuery);
    </script>

    <script>
        $('select[name=claim]').change(function() {
            let claim = $(this).val();
            if (claim == 1) {
                $(".next").removeClass('d-none');
                $(".save").addClass('d-none');
            } else {
                $(".next").addClass('d-none');
                $(".save").removeClass('d-none');
            }
        })
    </script>
@endpush
