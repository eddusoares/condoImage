@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 mb-30">
            <div class="card">
                <form action="{{ route('admin.building.image.description.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="building_id" value="{{ $building->id }}">
                    <div class="card-body">

                        @foreach ($imageCategories ?? [] as $key => $item)
                            @php
                                $inputId = 'fileInput_' . $key;
                                $dropId = 'dropSection_' . $key;
                                $previewId = 'uploadedImage_' . $key;
                                $inputName = strtolower(preg_replace('/[^A-Za-z0-9]/', '_', $item->name));
                            @endphp

                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="hidden" name="{{ $inputName }}[image_category_id]"
                                        value="{{ $item->id }}">
                                    <div class="form-group">
                                        <label for="description">{{ __($item->name) }}</label>
                                        <div class="file-form" id="{{ $dropId }}">
                                            <div class="dropzone" id="{{ $dropId }}"
                                                data-preview-id="{{ $previewId }}" data-category-id="{{ $item->id }}"
                                                data-building-id="{{ $building->id }}"
                                                data-input-name="{{ $inputName }}">
                                             
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <input type="hidden" name="{{ $inputName }}[image_category_id]"
                                        value="{{ $item->id }}">
                                    <div class="form-group">
                                        <label for="description">{{ __($item->name) }}
                                            @lang('Description')</label>
                                        <textarea id="{{ $inputId }}" class="trumEdit" name="{{ $inputName }}[description]" rows="10"
                                            cols="5" required>{{ $item->findImageCategoryDescription($building->id, $item->id) ?? '' }} </textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12 mt-0">
                                    <div class= "previewCard">
                                        <div id="{{ $previewId }}" class="px-0 uploadedImage">
                                            @foreach ($building->buildingImages ?? [] as $data)
                                                @if ($data->image_category_id == $item->id)
                                               
                                                    <div class="image-content">
                                                        <div class="image-wrapper">
                                                            <img alt="@lang('building-image')"
                                                                src="{{ findWatermarkImagePath(getFilePath('building_watermark'),$data, $data->image) }}">
                                                            <span class="remove-btn confirmationBtn"
                                                                data-action="{{ route('admin.building.image.delete', $data->id) }}"
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
                        @endforeach
                        <div class="d-flex justify-content-end">

                            <div>
                                <button type="submit" class="btn btn--primary">
                                    @lang('Save')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Dropzone preview template --}}
    <div style="display: none;">
        <div id="preview-template">
            <div class="dz-preview dz-file-preview" style="display: inline-block; margin: 10px; max-width: 150px;">
                <div class="dz-image" style="height: 120px; overflow: hidden; border: 1px solid #ddd; border-radius: 5px;">
                    <img data-dz-thumbnail style="max-width: 100%; height: auto; object-fit: contain;" />
                </div>
                <div class="dz-details" style="font-size: 12px; margin-top: 5px;">
                    <div class="dz-size"><span data-dz-size></span></div>
                    <div class="dz-filename"><span data-dz-name></span></div>
                </div>
                <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                <div class="dz-error-message" style="color: red;"><span data-dz-errormessage></span></div>
                <a class="dz-remove" href="javascript:undefined;" data-dz-remove
                    style="font-size: 12px; color: #c00;">Remove</a>
            </div>
        </div>
    </div>

    <x-confirmation-modal></x-confirmation-modal>
@endsection




@push('style-lib')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />
@endpush


@push('script-lib')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
@endpush

@push('script')
    <script>
        Dropzone.autoDiscover = false;

        document.addEventListener("DOMContentLoaded", function() {
            const dropzones = document.querySelectorAll(".dropzone");

            dropzones.forEach((dropzoneEl) => {
                const uuid = crypto.randomUUID();
                const buildingId = dropzoneEl.dataset.buildingId;
                const categoryId = dropzoneEl.dataset.categoryId;

                const dz = new Dropzone(dropzoneEl, {
                    url: "{{ route('admin.building.upload.chunk') }}",
                    method: "post",
                    chunking: true,
                    forceChunking: true,
                    chunkSize: 500 * 1024,
                    parallelChunkUploads: false,
                    retryChunks: true,
                    retryChunksLimit: 3,
                    acceptedFiles: "image/*",
                    addRemoveLinks: true,
                    maxFilesize: 30,
                    paramName: "file",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    previewTemplate: document.querySelector("#preview-template").innerHTML,
                    createImageThumbnails: true,
                    maxThumbnailFilesize: 50, // MB — Dropzone default is 10MB
                    thumbnailWidth: 200,
                    thumbnailHeight: 200,

                    init: function() {
                        this.on("sending", function(file, xhr, formData) {
                            // Extra data per file
                            formData.append("uuid", uuid);
                            formData.append("building_id", buildingId);
                            formData.append("category_id", categoryId);
                        });

                        this.on("success", function(file, response) {
                            console.log("Chunk uploaded:", response);

                            if (response.done && response.finalize_url) {
                                fetch(response.finalize_url, {
                                        method: "POST",
                                        headers: {
                                            "Content-Type": "application/json",
                                            "X-CSRF-TOKEN": document.querySelector(
                                                    'meta[name="csrf-token"]')
                                                .content,
                                        },
                                        body: JSON.stringify({
                                            uuid: response.uuid,
                                            name: response.name,
                                            buildingId: buildingId,
                                            imageCategoryId: categoryId

                                        })
                                    })
                                    .then((res) => res.json())
                                    .then((data) => {
                                        console.log("Finalized:", data);
                                        file.serverPath = data?.url || null;
                                        file.buildingImageId = data.buildingImageId;

                                    });
                            }
                        });

                        this.on("removedfile", function(file) {
                            if (file.previewElement) {
                                file.previewElement.remove();
                            }
                            console.log(file.buildingImageId);

                            if (file.upload && file.upload.uuid) {
                                fetch("{{ route('admin.building.upload.chunk.delete') }}", {
                                        method: "POST",
                                        headers: {
                                            "Content-Type": "application/json",
                                            "X-CSRF-TOKEN": document.querySelector(
                                                    'meta[name="csrf-token"]')
                                                .content
                                        },
                                        body: JSON.stringify({
                                            uuid: file.upload.uuid,
                                            file_path: file.serverFilePath,
                                            buildingId: buildingId,
                                            imageCategoryId: categoryId,
                                            buildingImageId: file
                                                .buildingImageId,

                                        })
                                    })
                                    .then((res) => res.json())
                                    .then((data) => console.log("Deleted:", data));
                            }
                        });
                    }
                });
            });
        });
    </script>


@endpush




@push('style-lib')
    <style>
        .dz-preview img {
            width: 100%;
            height: auto;
            max-height: 120px;
            object-fit: contain;
        }

        .dropzone {
            border: 1px dashed #0087F7 !important;
            border-radius: 6px;
            background: #f9f9f9;
            padding: 30px;
        }

        .dz-success-mark,
        .dz-error-mark {
            display: none;
        }

        .ck.ck-editor__main>.ck-editor__editable {
            height: 135px;
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

        .dropzone {
            .icon--wrap {
                display: flex;
                justify-content: center;
                align-items: center;
                width: 100%;
                margin-bottom: -20px;

                i {
                    font-size: 48px;
                    color: #0909097d;
                }
            }
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
