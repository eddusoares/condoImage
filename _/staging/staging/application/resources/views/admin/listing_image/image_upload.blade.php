@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <div class="row gy">
                        <div class="dropzone" id="my-dropzone">
                            <div class="container " style="max-width: 600px; margin: auto;">
                                <div id="preview-template" style="display: none;">
                                    <div class="dz-preview dz-file-preview">
                                        <img data-dz-thumbnail />
                                        <div class="dz-details">
                                            <div class="dz-size"><span data-dz-size></span></div>
                                            <div class="dz-filename"><span data-dz-name></span></div>
                                        </div>
                                        <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         
                        </div>
                    </div>
                    <div>
                        <div class="card p-0 box-shadow--none previewCard">
                            <div id="uploadedImage" class="px-0">
                                @foreach ($listingUnit->listingImages ?? [] as $img)
                                    <div class="image-content">
                                        <div class="image-wrapper">
                                            <img alt="@lang('listing-image')"
                                                src="{{ findWatermarkImagePath(getFilePath('listing_asset_image_watermark'),$img, $img->image) }}">
                                            <span class="remove-btn confirmationBtn"
                                                data-action="{{ route('admin.listing.asset.image.delete', $img->id) }}"
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
            </div>
            <div>
                <a href="{{ route('admin.listing.asset.index') }}" class="btn btn--primary mt-2">
                    <i class="fas fa-chevron-left"></i>
                    @lang('Back to List')</a>
            </div>
        </div>
    </div>

    <x-confirmation-modal></x-confirmation-modal>
@endsection


@push('style-lib')
    <style>

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

        #uploadedImage {
            max-height: 750px;
            overflow-y: auto;
            display: flex;
            flex-wrap: wrap;
            padding: 10px;
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
    </style>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />
@endpush


@push('script-lib')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
@endpush

@push('script')
    <script>
        Dropzone.autoDiscover = false;

        const myDropzone = new Dropzone("#my-dropzone", {
            url: "{{ route('admin.listing.asset.upload.chunk') }}",
            method: "post",
            chunking: true,
            chunkSize: 1000000, // 1MB
            parallelChunkUploads: false,
            forceChunking: true,
            retryChunks: true,
            retryChunksLimit: 3,
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            maxFilesize: 30,
            paramName: "file",
            dictDefaultMessage: "Drag & drop your images here or click to upload",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            // 👇 Preview template
            previewTemplate: document.querySelector('#preview-template').innerHTML,
            // 👇 Force thumbnail for large images
            createImageThumbnails: true,
            maxThumbnailFilesize: 50, // MB — Dropzone default is 10MB
            thumbnailWidth: 200,
            thumbnailHeight: 200,

            init: function() {

                this.on("success", function(file, response) {
                    // Finalize upload if indicated
                    if (response.done && response.finalize_url) {
                        const extension = file.name.split('.').pop();
                        const listingUnitId = "{{ $listingUnit->id }}";
                        fetch(response.finalize_url, {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content,
                                },
                                body: JSON.stringify({
                                    uuid: response.uuid,
                                    name: response.name,
                                    extension: extension,
                                    listingUnitId: listingUnitId,
                                })
                            }).then(res => res.json())
                            .then(data => {
                                if (data.error) {
                                    Toast.fire({
                                        icon: 'error',
                                        title: data.error
                                    });
                                }

                                file.serverFilePath = data.url,
                                    file.listingImageId = data.listingImageId;
                            })
                            .catch(err => console.error("Finalize error:", err));
                    }
                });

                this.on("error", function(file, errorMessage) {
                    console.log(errorMessage);

                });

                this.on("removedfile", function(file) {
                    if (file.previewElement) {
                        file.previewElement.remove();
                    }

                    if (file.upload && file.upload.uuid) {
                        fetch("{{ route('admin.listing.asset.upload.chunk.delete') }}", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": document.querySelector(
                                        'meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify({
                                    uuid: file.upload.uuid,
                                    file_path: file.serverFilePath,
                                    listingImageId: file.listingImageId
                                })
                            })
                            .then(res => res.json())
                            .then(data => console.log("Chunk delete response:", data))
                            .catch(err => console.error("Chunk delete error:", err));
                    }
                });
            }
        });
    </script>
@endpush
