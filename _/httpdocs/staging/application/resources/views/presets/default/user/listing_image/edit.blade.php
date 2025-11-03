@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="body-wrapper">
        <div class="table-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="dashboard-card-wrap mt-0">
                        <div class="row gy">
                            <form action="{{ route('user.listing.asset.update', $listingUnit->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="image-upload">
                                                <div class="thumb">
                                                    <div class="avatar-preview">
                                                        <div class="profilePicPreview"
                                                            style="background-image: url({{ getImage(getFilePath('listing_asset_image') . '/' . $listingUnit->image) }});">
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
                                                    ({{ getFileSize('listing_asset_image') }})</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="form-group mt-3">
                                                <label class="form--label">@lang('Unit Number')</label>
                                                <input class="form-control form--control" type="text" name="unit_number"
                                                    value="{{ $listingUnit->unit_number }}" required>
                                            </div>

                                            <div class="form-group mt-3">
                                                <label class="form--label">@lang('Building Name')</label>
                                                <select class="form-control form--control form-select" name="building_id"
                                                    id="building_id" required>
                                                    <option>@lang('Select Your Building')</option>
                                                    @foreach ($buildings as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ $listingUnit->building_id == $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group mt-3">
                                                <label class="form--label">@lang('Price')</label>
                                                <input class="form-control form--control" type="text" name="price"
                                                    value="{{ $listingUnit->price }}" required>
                                            </div>
                                            <div class="form-group mt-3">
                                                <label class="fw-bold form--label">@lang('Is Premium')</label>
                                                <label class="switch m-0">
                                                    <input type="checkbox" class="toggle-switch"
                                                        {{ $listingUnit->is_premium ? 'checked' : '' }} name="is_premium">
                                                    <span class="slider round"></span>
                                                </label>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="description" class="form--label">@lang('Description')</label>
                                            <textarea name="description" rows="10" cols="5" class="form-control form--control trumEdit1"
                                                placeholder="@lang('Description')">{{ $listingUnit->description }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="row mt-3">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="description">@lang('Listing Image')</label>
                                            <div class="file-form" id="dropSection">
                                                <input id="fileInput" type="file" name="images[]" multiple
                                                    accept="image/*">
                                                <label class="drop-content form--label" for="fileInput">
                                                    <div class="upload-icon">📁</div>
                                                    @lang('Drop listing images to attach, or click to select')
                                                </label>
                                            </div>
                                            <div class="card p-0 box-shadow--none previewCard">
                                                <div id="uploadedImage" class="px-0">
                                                    @foreach ($listingUnit->listingImages ?? [] as $img)
                                                        <div class="image-content">
                                                            <div class="image-wrapper">
                                                                <img alt="@lang('listing-image')"
                                                                    src="{{ getImage(getFilePath('listing_asset_image') . '/' . $img->image) }}">
                                                                <span class="remove-btn confirmationBtn"
                                                                    data-action="{{ route('user.listing.asset.image.delete', $img->id) }}"
                                                                    data-question="@lang('Are you sure to delete this listing image?')">
                                                                    <i class="las la-times-circle"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="col-lg-12 text-end mt-3">
                                    <button type="submit" class="btn button">
                                                @lang('Next')
                                      <i class="fas fa-chevron-right"></i>
                                    </button>
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

@push('script-lib')
    <script src="{{ asset('assets/common/js/ckeditor.js') }}"></script>
@endpush

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

        #fileInput {
            display: none;
        }

        #uploadedImage {
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


            #uploadedImage {
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
            const dropArea = document.getElementById("dropSection");
            const fileInput = document.getElementById("fileInput");
            const uploadedImages = document.getElementById("uploadedImage");

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
                        </div>
                    `;
                    uploadedImages.appendChild(elem);
                    uploadedImages.classList.remove('d-none');


                    elem.querySelector(".remove-btn").addEventListener("click", function() {
                        removeFile(file.name, elem);
                    });
                }
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
                dropArea.addEventListener(eventName, () => dropArea.classList.add('highlight'), false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, () => dropArea.classList.remove('highlight'), false);
            });

            dropArea.addEventListener('drop', handleDrop, false);

            fileInput.addEventListener('change', function() {
                handleFiles(this.files);
            });
        });
    </script>
@endpush
