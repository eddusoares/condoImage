@php
    $tags = App\Models\Tag::where('status', 1)->get();
@endphp
@extends('admin.layouts.app')
@section('panel')
    <div class="row gy-4">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header border-bottom pb-2 d-flex justify-content-between bg--primary">
                    <h5 class="text-light">@lang('User Name'): {{ $file->user->firstname }} {{ $file->user->lastname }}
                    </h5>
                    <form id="changeHandleStatusForm">
                        @csrf
                        <div class="form-group col-md-2 col-sm-6 w-100 mb-0">
                            <input type="hidden" name="file_id" value="{{ $file->id }}">
                            <label class="fw-bold handle-label">@lang('Do you want to review it')?</label>
                            <label class="switch m-0">
                                <input type="checkbox" class="toggle-switch myCheckbox" name="progress"
                                    {{ $file->status == 3 ? 'checked' : '' }}
                                    {{ $file->status == 1 || $file->status == 2 ? 'disabled' : '' }}>
                                <span class="boll-bg slider round"></span>
                            </label>
                        </div>
                    </form>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <h6>
                                @if (isset($file->is_premium))
                                    @lang('Premium')<i class="text--primary fas fa-crown mx-2"></i>
                                @else
                                    @lang('Free')<i class="text--primary fas fa-check-circle mx-2"></i>
                                @endif
                            </h6>
                            <div class="submitted-image-mt">
                                <label class="form-label">@lang('Submitted Image')</label>
                                <div class="">
                                    @if ($file->width > $file->height)
                                        <img class="custom-rounded"
                                            src="{{ fileStorePath($file) }}" alt=""
                                            width="800">
                                    @else
                                        <img class="custom-rounded"
                                            src="{{ fileStorePath($file) }}" alt=""
                                            width="500">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <form id="filePromptUpdateForm">
                                @csrf
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="row">

                                            <div class="col-md-8">

                                            </div>
                                            <div class="col-md-4">
                                                <button type="submit" id="updateBtn"
                                                    class="btn btn--primary float-end {{ $file->status == 0 || $file->status == 1 || $file->status == 2 ? 'disabled' : '' }}">@lang('Update')</button>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <input type="hidden" name="file_id" value="{{ $file->id }}">
                                        <div id="reviewerDetail"
                                            class="mb-3 {{ isset($file->reviewer_id) ? '' : 'd-none' }}">
                                            <label class="form-label">@lang('Reviewer Name')</label>
                                            <h4>@lang('Admin')</h4>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputState" class="form-label">@lang('Status')</label>
                                            <select id="inputState" class="form-control" name="status"
                                                {{ $file->status == 0 || $file->status == 1 || $file->status == 2 ? 'disabled' : '' }}>
                                                <option value="0" {{ $file->status == 0 ? 'selected' : '' }}>
                                                    @lang('Pending')</option>
                                                <option value="1" {{ $file->status == 1 ? 'selected' : '' }}>
                                                    @lang('Publish')</option>
                                                <option value="2" {{ $file->status == 2 ? 'selected' : '' }}>
                                                    @lang('Reject')</option>
                                                <option value="3" {{ $file->status == 3 ? 'selected' : '' }}>
                                                    @lang('On Reviewing')</option>
                                            </select>
                                        </div>

                                        <div id="rejectionReason"
                                            class="form-group {{ $file->status == 2 ? '' : 'd-none' }}">
                                            <label class="text-danger">@lang('Rejection Reason')</label>
                                            <textarea id="reason" name="reason" rows="13" class="form-control"
                                                {{ $file->status == 0 || $file->status == 1 || $file->status == 2 ? 'disabled' : '' }}>{{ $file->reason }}</textarea>
                                        </div>
                                        <div id="fileTitle" class="form-group">
                                            <label>@lang('Title')</label>
                                            <input id="title" class="form-control" type="text" name="title"
                                                {{ $file->status == 0 || $file->status == 1 || $file->status == 2 ? 'disabled' : '' }}
                                                value="{{ $file->title }}">
                                        </div>
                                        <div id="fileCategory_id" class="form-group">
                                            <label class="form--label">@lang('Category')</label>
                                            <select id="category_id" class="form-control" name="category_id"
                                                {{ $file->status == 0 || $file->status == 1 || $file->status == 2 ? 'disabled' : '' }}>
                                                @foreach ($categories as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $file->category_id == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div id="fileTags" class="form-group ">
                                            <label>@lang('Tags')</label>
                                            <select id="tags" name="tags[]" class="form-control select2-auto-tokenize"
                                                {{ $file->status == 0 || $file->status == 1 || $file->status == 2 ? 'disabled' : '' }}
                                                multiple="multiple">
                                                @foreach ($tags as $tag)
                                                    <option value="{{ $tag->id }}"
                                                        {{ in_array($tag->id, $file->tags) ? 'selected' : '' }}>
                                                        {{ __($tag->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div id="fileDescription" class="form-group">
                                            <label>@lang('Description')</label>
                                            <textarea id="description" rows="13" class="form-control" name="description"
                                                {{ $file->status == 0 || $file->status == 1 || $file->status == 2 ? 'disabled' : '' }}>{{ $file->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.select2-auto-tokenize').select2({
                dropdownParent: $('.card-body'),
                tags: true,
                tokenSeparators: [',']
            });
        })(jQuery);
    </script>

    <script>
        $(document).ready(function() {
            "use strict";
            $("#inputState").change(function() {
                var selectedValue = $(this).val();

                if (selectedValue === '2') {
                    $("#rejectionReason").removeClass("d-none");
                } else {
                    $("#rejectionReason").addClass("d-none");
                }
            });
        });


        // update button prevent submission on enter key press
        $(document).ready(function() {
            "use strict";
            $('#myForm').on('keydown', function(event) {
                if (event.key === 'Enter' && event.target.tagName !== 'TEXTAREA') {
                    event.preventDefault();
                }
            });
        });

        // CheckBox status changing  Ajax
        $(document).ready(function() {
            "use strict";
            $(".myCheckbox").change(function() {
                if ($(this).is(":checked")) {
                    var csrfToken = $("input[name='_token']").val();
                    $.ajax({
                        url: "{{ route('admin.review.changeHandleStatus') }}",
                        data: $('#changeHandleStatusForm').serialize(),
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(data) {
                            $("#inputState").val(data.status);
                            $("#inputState").removeAttr("disabled");
                            $("#title").removeAttr("disabled");
                            $("#tags").removeAttr("disabled");
                            $("#category_id").removeAttr("disabled");
                            $("#description").removeAttr("disabled");
                            $("#reason").removeAttr("disabled");
                            $("#updateBtn").removeClass('disabled');
                            $("#reviewerDetail").removeClass('d-none');

                            Toast.fire({
                                icon: 'success',
                                title: 'You are now reviewing this image.'
                            })
                            return false;
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                } else {
                    var csrfToken = $("input[name='_token']").val();
                    $.ajax({
                        url: "{{ route('admin.review.changeHandleStatus') }}",
                        data: $('#changeHandleStatusForm').serialize(),
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(data) {
                            $("#inputState").val(data.status);
                            $("#inputState").prop("disabled", true);
                            $("#title").prop("disabled", true);
                            $("#tags").prop("disabled", true);
                            $("#category_id").prop("disabled", true);
                            $("#description").prop("disabled", true);
                            $("#reason").prop("disabled", true);
                            $("#updateBtn").addClass('disabled');
                            $("#reviewerDetail").addClass('d-none');

                            Toast.fire({
                                icon: 'success',
                                title: 'You are not reviewing this image.'
                            })
                            return false;
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                }
            });
        });

        // file Updation Ajax
        $('#filePromptUpdateForm').submit(function(e) {
            e.preventDefault();
            var csrfToken = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('admin.review.update', $file->id) }}",
                data: $('#filePromptUpdateForm').serialize(),
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(data) {
                    if (data.status == 1 || data.status == 2) {
                        $("#inputState").val(data.status);
                        $("#inputState").prop("disabled", true);
                        $("#title").prop("disabled", true);
                        $("#tags").prop("disabled", true);
                        $("#category_id").prop("disabled", true);
                        $("#reason").prop("disabled", true);
                        $("#description").prop("disabled", true);
                        $('input[name="progress"]').prop("disabled", true);
                        $("#updateBtn").addClass("disabled");
                    }
                    Toast.fire({
                        icon: 'success',
                        title: 'Image has been updated successfully published.'
                    })
                },
                error: function(data) {
                    Toast.fire({
                        icon: 'error',
                        title: data.responseJSON.message
                    })
                }
            });
        });

        // Reload Button
        document.querySelector('.reloadForm').addEventListener('click', function() {
            location.reload();
        });
    </script>
@endpush
