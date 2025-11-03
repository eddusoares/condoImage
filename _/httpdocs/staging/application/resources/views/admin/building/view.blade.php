@extends('admin.layouts.app')
@section('panel')
    <div class="row d-flex justify-content-center">
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header text-white">
                    <h5 class="mb-0">@lang('Building Information')</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- Left: Building Image --}}
                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-2 text-center bg-light">
                                <img src="{{ getImage(getFilePath('building') . '/' . $building->image) }}"
                                    alt="Building Image" class="img-fluid rounded">
                            </div>
                        </div>

                        <div class="col-xl-8 col-md-6 mb-30">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Name'):
                                    <span class="fw-bold">{{ $building->name }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Neighborhood Name'):
                                    <span class="fw-bold">{{ $building->neighborhood->name }}</span>
                                </li>
                             
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Price'):
                                    <span class="fw-bold">{{ $general->cur_sym }}{{ $building->price }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Years Build'):
                                    <span class="fw-bold">{{ $building->year_built }}</span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Units'):
                                    <span class="fw-bold">{{ $building->units }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Stores'):
                                    <span class="fw-bold">{{ $building->stories }}</span>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6">
            @forelse ($imageCategories ?? [] as $key => $item)
                @php
                    $previewId = 'uploadedImage_' . $key;
                    $matchedImages = $building->buildingImages->where('image_category_id', $item->id);
                @endphp

                <div class="card shadow-sm mb-2">
                    <div class="card-header text-white">
                        <h6 class="mb-0">{{ __($item->name) }}</h6>
                    </div>
                    <div class="card-body">
                        <div id="{{ $previewId }}" class="d-flex flex-wrap gap-3">
                            @if ($matchedImages->isEmpty())
                                <span class="text-muted">@lang('Not image Available')</span>
                            @else
                                @foreach ($matchedImages as $data)
                                    <div class="image-content border p-1 rounded bg-light">
                                        <div class="image-wrapper" style="width: 150px;">
                                            <img alt="@lang('building-image')"
                                                src="{{ getImage(getFilePath('building') . '/' . $data->image) }}"
                                                class="img-fluid rounded">
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-warning mt-3">@lang('No Image Categories Available')</div>
            @endforelse
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
@endpush
