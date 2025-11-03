@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="body-wrapper">
        <div class="table-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="dashboard-card-wrap mt-0">
                        <div class="row gy">
                            <form action="{{ route('user.building.update', $building->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row mt-3">
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
                                                            class="btn button">@lang('Upload')</label>
                                                    </div>
                                                </div>
                                                <small class="pt-4 mb-4">@lang('Recommend image size')
                                                    ({{ getFileSize('building') }})</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="row mt-3">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="mb-2 form--label">@lang('Name')</label>
                                                    <input type="text" name="name" class="form-control form--control"
                                                        placeholder="@lang('name')" value="{{ $building->name }}"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="mb-2 form--label">@lang('Neighborhood')</label>
                                                    <select name="neighborhood_id" id="status"
                                                        class="form-control form--control" required>
                                                        <option>@lang('Select Neighborhood')</option>
                                                        @foreach ($neighborhoods ?? [] as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ $item->id == $building->neighborhood_id ? 'selected' : '' }}>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="mb-2 form--label">@lang('Category')</label>
                                                    <select name="category_id" id="category_id"
                                                        class="form-control form--control form-select" required>
                                                        <option>@lang('Select Category')</option>
                                                        @foreach ($categories ?? [] as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ $item->id == $building->category_id ? 'selected' : '' }}>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="address">@lang('Address')</label>
                                                    <textarea name="address" rows="5" cols="5" class="form-control form--control" required>{{ $building->address }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mt-3">
                                                <div class="form-group">
                                                    <label class="fw-bold">@lang('Is Premium')</label>
                                                    <label class="switch m-0">
                                                        <input type="checkbox" class="toggle-switch"
                                                            {{ $building->is_premium ? 'checked' : '' }} name="is_premium">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="mb-2 form--label">@lang('Years')</label>
                                            <input type="month" name="year_built" value="{{ $building->year_built }}"
                                                class="form-control form--control" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label class="mb-2 form--label">@lang('Price')</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control form--control" placeholder="price"
                                                    name="price" aria-label="price" aria-describedby="basic-addon2"
                                                    value="{{ $building->price }}" required>
                                                    <span
                                                    class="input-group-text bg--base border-0 text-light">{{ gs()->cur_sym }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-4">
                                        <div class="form-group ">
                                            <label class="mb-2">@lang('Tags')</label>
                                            <small class="ms-2 mt-2">@lang('Separate multiple tags by')
                                                <code>,</code>(@lang('comma')) @lang('or')
                                                <code>@lang('enter')</code>
                                                @lang('key')</small>

                                            <select name="tags[]" class="form-control form--control select2-auto-tagging"
                                                multiple="multiple" required>
                                                @foreach ($tags as $tag)
                                                    <option value="{{ $tag->id }}"
                                                        {{ in_array($tag->id, $building->tags) ? 'selected' : '' }}>
                                                        {{ __($tag->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="mb-2 form--label">@lang('Units')</label>
                                            <input type="number" name="units" value="{{ $building->units }}"
                                                class="form-control form--control" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="mb-2 form--label">@lang('Stories')</label>
                                            <input type="number" name="stories" value="{{ $building->stories }}"
                                                class="form-control form--control" required />
                                        </div>
                                    </div>

                                   

                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="description">@lang('Description')</label>
                                            <textarea name="description" rows="10" cols="5" class="form-control form--control trumEdit1"
                                                placeholder="@lang('Description')">{{ $building->description }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                @foreach ($imageCategories ?? [] as $key => $item)
                                    @php
                                        $inputId = 'fileInput_' . $key;
                                        $dropId = 'dropSection_' . $key;
                                        $previewId = 'uploadedImage_' . $key;
                                        $inputName = strtolower(preg_replace('/[^A-Za-z0-9]/', '_', $item->name));
                                    @endphp

                                    <div class="row mt-3">
                                        <div class="col-lg-12">
                                            <input type="hidden" name="{{ $inputName }}[image_category_id]"
                                                value="{{ $item->id }}">
                                            <div class="form-group">
                                                <label for="description">{{ __($item->name) }}</label>
                                                <div class="file-form" id="{{ $dropId }}">
                                                    <input id="{{ $inputId }}" type="file"
                                                        name="{{ $inputName }}[images][]" multiple accept="image/*"
                                                        data-preview="{{ $previewId }}">
                                                    <label class="drop-content" for="{{ $inputId }}">
                                                        <div class="upload-icon">📁</div>
                                                        @lang("Drop {$item->name} images to attach, or click to select")
                                                    </label>
                                                </div>
                                                <div class="card p-0 box-shadow--none previewCard">
                                                    <div id="{{ $previewId }}" class="px-0 uploadedImage">
                                                        @foreach ($building->buildingImages ?? [] as $data)
                                                            @if ($data->image_category_id == $item->id)
                                                                <div class="image-content">
                                                                    <div class="image-wrapper">
                                                                        <img alt="@lang('building-image')"
                                                                            src="{{ getImage(getFilePath('building') . '/' . $data->image) }}">
                                                                        <span class="remove-btn confirmationBtn"
                                                                            data-action="{{ route('user.building.image.delete', $data->id) }}"
                                                                            data-question="@lang("Are you sure to delete this building {$item->name} image?")">
                                                                            <i class="las la-times-circle"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                @foreach ($building->buildingListingUnits ?? [] as $item)
                                    <div class="row mt-3">
                                        <div class="col-lg-3">
                                            <h4 class="mb-3">@lang('Listings Images')</h4>
                                            <div class="form-group">
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
                                                            href="{{ route('user.listing.asset.index') }}">@lang('View all images')</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="col-lg-12 text-end mt-3">
                                    <button type="submit" class="btn button">@lang('Update')</button>
                                </div>
                            </form>
                        </div>
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

        .image-upload .thumb .profilePicPreview {
            width: 100%;
            height: 210px;
            display: block;
            border-radius: 10px;
            background-size: cover !important;
            background-position: top;
            background-repeat: no-repeat;
            position: relative;
            overflow: hidden;
        }

        .select2-container--default .select2-selection--multiple {
            width: 100% !important;
        }
    </style>
@endpush


@push('script-lib')
    <script src="{{ asset('assets/common/js/ckeditor.js') }}"></script>
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
            });
        })(jQuery);
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dropZones = document.querySelectorAll(".file-form");
            dropZones.forEach(dropArea => {
                const fileInput = dropArea.querySelector('input[type="file"]');
                const previewId = fileInput.dataset.preview;
                const uploadedImages = document.getElementById(previewId);

                let dataTransfer = new DataTransfer();

                function handleFiles(files) {
                    [...files].forEach(file => {
                        dataTransfer.items.add(file);
                        previewFile(file);
                    });
                    fileInput.files = dataTransfer.files;
                }

                function previewFile(file) {
                    let reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onloadend = function() {
                        let elem = document.createElement("div");
                        elem.classList.add("image-content");
                        elem.setAttribute("data-file", file.name);
                        elem.innerHTML = `
                    <div class="image-wrapper">
                        <img alt="${file.name}" src="${reader.result}">
                        <span class="remove-btn">
                            <i class="las la-times-circle"></i>
                        </span>
                    </div>`;
                        uploadedImages.appendChild(elem);
                        uploadedImages.classList.remove('d-none');

                        elem.querySelector(".remove-btn").addEventListener("click", function() {
                            removeFile(file.name, elem);
                        });
                    };
                }

                function removeFile(fileName, element) {
                    element.remove();
                    let updatedFiles = new DataTransfer();
                    [...fileInput.files].forEach(file => {
                        if (file.name !== fileName) {
                            updatedFiles.items.add(file);
                        }
                    });
                    fileInput.files = updatedFiles.files;
                    dataTransfer = updatedFiles;

                    if (uploadedImages.childElementCount === 0) {
                        uploadedImages.classList.add('d-none');
                    }
                }

                function handleDrop(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    let files = e.dataTransfer.files;
                    if (files.length > 0) {
                        handleFiles(files);
                    }
                }

                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropArea.addEventListener(eventName, preventDefaults, false);
                    document.body.addEventListener(eventName, preventDefaults, false);
                });

                ['dragenter', 'dragover'].forEach(eventName => {
                    dropArea.addEventListener(eventName, () => dropArea.classList.add('highlight'),
                        false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropArea.addEventListener(eventName, () => dropArea.classList.remove(
                        'highlight'), false);
                });

                dropArea.addEventListener('drop', handleDrop, false);

                fileInput.addEventListener('change', function() {
                    handleFiles(this.files);
                });
            });
        });
    </script>

    <script>
        (function($) {
            "use strict";
            $('.select2-auto-tagging').select2({
                dropdownParent: $('.multiSelectParentDiv'),
                tags: true,
                tokenSeparators: [',']
            });
        })(jQuery);
    </script>
@endpush
