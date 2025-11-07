@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <div class="row gy">
                        <form action="{{ route('admin.building.update', $building->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="image-upload">
                                            <div class="thumb">
                                                <div class="avatar-preview">
                                                    <div class="profilePicPreview"
                                                        style="background-image: url({{ getImage(getFilePath('building') . '/' . $building->image) }});">
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
                                                    placeholder="@lang('name')" value="{{ $building->name }}" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="mb-2 form--label">@lang('Neighborhood')</label>
                                                <select name="neighborhood_id" id="status" class="form-control" required>
                                                    <option>@lang('Select Neighborhood')</option>
                                                    @foreach ($neighborhoods ?? [] as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ $item->id == $building->neighborhood_id ? 'selected' : '' }}>
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
                                                <textarea name="address" rows="5" cols="5" class="form-control" required>{{ $building->address }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="mb-2 form--label">@lang('Years')</label>
                                        <input type="month" name="year_built" value="{{ $building->year_built }}"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-6">
                                    <div class="form-group">
                                        <label class="mb-2 form--label">@lang('Price')</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="price" name="price"
                                                aria-label="price" aria-describedby="basic-addon2"
                                                value="{{ $building->price }}" required>
                                            <span class="input-group-text" id="basic-addon2">{{ gs()->cur_sym }}</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="mb-2 form--label">@lang('Units')</label>
                                        <input type="number" name="units" value="{{ $building->units }}"
                                            class="form-control" required />
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label class="mb-2 form--label">@lang('Stories')</label>
                                        <input type="number" name="stories" value="{{ $building->stories }}"
                                            class="form-control" required />
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="mb-2 form--label">@lang('Status')</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1" {{ $building->status == 1 ? 'selected' : '' }}>
                                                @lang('Active')</option>
                                            <option value="2" {{ $building->status == 2 ? 'selected' : '' }}>
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
                                            placeholder="@lang('Description')">{{ $building->description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="copyright_description">@lang('Copyright Description')</label>
                                        <textarea name="copyright_description" rows="10" cols="5" class="form-control trumEdit2"
                                            placeholder="@lang('Copyright Description')">{{ $building->copyright_description }}</textarea>
                                    </div>
                                </div>
                            </div>



                            <div class="row mt-5">
                                @foreach ($building->buildingListingUnits ?? [] as $item)
                                    <div class="col-lg-3">
                                        @if ($loop->first)
                                            <h4 class="mb-3">@lang('Listings Images')</h4>
                                        @endif
                                        <div class="form-group {{ !$loop->first ? 'mt-5' : '' }}">
                                            <div class="image-upload">
                                                <div class="thumb">
                                                    <div class="avatar-preview">
                                                        <div class="profilePicPreview"
                                                            style="background-image: url({{ getImage(getFilePath('listing_asset_image') . '/' . $item->image) }});">
                                                            <button type="button" class="remove-image"><i
                                                                    class="fa fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h3 class="text-center mt-2">{{ $item->unit_number }}</h3>
                                                    <a class="btn btn--success w-100 mt-2"
                                                        href="{{ route('condo.building.listing.images', listing_unit_route_params($item)) }}">@lang('View all images')</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="col-lg-12 text-end mt-3">
                                <button type="submit" class="btn btn--primary">
                                    @lang($building->claim == 1 ? 'Next' : 'Save')
                                    @if ($building->claim == 1)
                                        <i class="fas fa-chevron-right"></i>
                                    @endif
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-confirmation-modal></x-confirmation-modal>
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


        .file-form {

            position: relative;
            padding: 2.5rem;
            border: 2px dashed blue;
        }

        .file-form:hover {
            border-color: green;
        }

        .file-form.highlight {
            border-color: green;
        }

        .drop-content {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            cursor: pointer;
            text-align: center;
            padding-top: 12px;
            font-weight: bold;
            color: #34495e;
            font-size: 18px;
        }

        .previewCard {
            margin-top: 20px;
        }

        .file-form input {
            display: none;
        }

        .previewCard .uploadedImage {
            max-height: 750px;
            overflow-y: auto;
            display: flex;
            flex-wrap: wrap;
            padding: 10px;
        }

        .d-none {
            display: none !important;
        }

        .box-shadow--none {
            box-shadow: none !important
        }

        #executeBtn {
            background-color: #34495e;
        }

        #executeBtn:hover {
            background-color: #2c3e50;
        }

        #executeBtn:active {
            background-color: #2c3e50;
            transform: scale(1.1);
        }


        #clearAllBtn {
            color: #ecf0f1;
            background-color: #e74c3c;
        }

        #clearAllBtn:active {
            background-color: #c0392b;
            transform: scale(1.1);
        }

        #clearAllBtn:hover {
            background-color: #c0392b;
        }

        .image-content {
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            border: 1px dashed #bdc3c7;
            border-radius: .25rem;
            margin-left: 0px;
            margin-right: 16px;
            padding: .25rem;
            margin-top: 15px;

        }

        .image-wrapper {
            position: relative;
            width: 148px;
            height: 148px;

            img {
                object-fit: cover;
                height: 100%;
                width: 100%;
                transition: 1s;
            }
        }


        .image-wrapper:hover img {
            filter: hsl;
        }

        .image-wrapper span {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-weight: bold;
            font-size: 15px;
            background: red;
            padding: 10px;
            border-radius: 20%;
            line-height: 10px;
        }

        .image-wrapper:hover span {
            display: block;
        }


        .title {
            text-align: center;
            margin-top: 4rem;
            color: #34495e;
        }

        @media only screen and (max-width: 620px) {

            .previewCard .uploadedImage {
                justify-content: center;
            }

            .drop-content {
                padding-top: 8px;
                font-size: 15px;

            }

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
@endpush
