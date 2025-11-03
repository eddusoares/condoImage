<!-- Modal -->
@php
    $categories = App\Models\Category::where('status', 1)->get();
    $tags = App\Models\Tag::where('status', 1)->get();
@endphp
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header mb-4">
        <h6 class="offcanvas-title" id="offcanvasRightLabel">@lang('Upload File')</h6>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="upload">
        <form id="uploadForm">
            @csrf
            <div id="fileUpload"></div>
            <div class="progress mt-3">
                <div class="progress-bar bg--base" role="progressbar" style="width: 0%;" aria-valuenow="0"
                    aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="row">
                <div class="col-12 my-3">
                    <div class="form-group">
                        <label class="form--label">@lang('Product Title')</label>
                        <input id="title" type="text" class="form--control" name="title" placeholder="Enter"
                            required>
                    </div>
                </div>
                <div class="col-lg-12 col-12 mb-3">
                    <div class="form-group">
                        <label class="form--label">@lang('Category')</label>
                        <select id="category_id" class="form-select select" name="category_id" required>
                            <option value="">@lang('Select Category')</option>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-12 col-12 mb-3">
                    <div class="form-group multiSelectParentDiv">
                        <label class="form--label">@lang('Tags')</label>
                        <select name="tags[]" class="form--control form-select select2-auto-tagging"
                            multiple="multiple" required>
                            @foreach ($tags as $item)
                                <option value="{{ $item->id }}">{{ __($item->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <label class="form--label">@lang('Description')</label>
                    <textarea id="description" class="form--control" name="description" placeholder="Write a description about your file."
                        required></textarea>
                </div>

                <div class="col-12 mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input bg--base" name="isPremium" value="1" type="checkbox"
                            role="switch" id="flexSwitchCheckChecked" checked>
                        <label class="form-check-label" for="flexSwitchCheckChecked">@lang('Is Premium?')</label>
                    </div>
                </div>

                <div class="col-12 d-flex justify-content-end mb-5 mt-3">
                    <button id="uploadButton" class="btn button">@lang('Submit')</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal -->

@push('script')
    <script>
        $(document).ready(function() {
            'use strict';
            $("#fileUpload").fileUpload();
        });
        $('.progress').hide();
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

    <script>
        $('#uploadButton').on('click', function(event) {
            event.preventDefault();
            let formData = new FormData($('#uploadForm')[0]);

            $.ajax({
                url: '{{ route('user.file.store') }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                xhr: function() {
                    let xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(e) {
                        if (e.lengthComputable) {
                            let percent = (e.loaded / e.total) * 100;
                            $('.progress-bar').css('width', percent.toFixed(2) + '%');
                            $('.progress-bar').attr('aria-valuenow', percent.toFixed(2));
                            let currentProgress = 0;
                            let interval = setInterval(function() {
                                    $('.progress-bar .progress-text').text(currentProgress +
                                        '%');
                                    if (currentProgress >= percent) {
                                        clearInterval(interval);
                                        if (currentProgress === 100) {
                                            $('.progress-bar .progress-text').text(
                                                'Please wait...'
                                            );
                                        }
                                    } else {
                                        currentProgress++;
                                    }
                                },
                                20
                            );
                        }
                    });
                    return xhr;
                },
                beforeSend: function() {
                    $('.progress').show();
                    $('.progress-bar').css('width', '0%');
                    $('.progress-bar').html(
                        '<div class="progress-text">0%</div>');
                },
                success: function(response) {
                    $('#title').val('');
                    $('#category_id').val('');
                    $('#description').val('');
                    Toast.fire({
                        icon: 'success',
                        title: 'Your Image is under review.'
                    })
                },
                error: function(error) {
                    Toast.fire({
                        icon: 'error',
                        title: error.responseJSON.message
                    })
                },
                complete: function() {
                    $('.progress-bar .progress-text').text('Done');
                    $('.progress').delay(1000)
                        .fadeOut();
                }
            });
        });
    </script>
@endpush
