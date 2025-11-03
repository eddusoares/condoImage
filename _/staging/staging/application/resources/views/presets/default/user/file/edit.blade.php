@php
    $categories = App\Models\Category::where('status', 1)->get();
    $tags = App\Models\Tag::where('status', 1)->get();
@endphp
@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="body-wrapper">
        <div class="table-content">
            <div class="dashboard-card-wrap mt-0">
                <h6 class="">{{ $pageTitle }}</h6>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="">
                            @if ($file->width > $file->height)
                                <img class="custom-rounded" src="{{ fileStorePath($file,'file') }}"
                                    alt="" width="800">
                            @else
                                <img class="custom-rounded" src="{{ fileStorePath($file,'file') }}"
                                    alt="" width="300">
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-8">

                        <form action="{{ route('user.file.update', $file->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Product Title')</label>
                                        <input type="text" class="form--control" name="title" placeholder="Enter"
                                            value="{{ $file->title }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Category')</label>
                                        <select id="category_id" class="form-select select" name="category_id" required>
                                            @foreach ($categories as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $file->category_id == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-12 mb-3">
                                    <div class="select-tag">
                                        <div class="form-group multiSelectParentEditDiv">
                                            <label class="form--label">@lang('Tags')</label>
                                            <select name="tags[]"
                                                class="form--control form-select select2-auto-edit-tagging"
                                                multiple="multiple" required>
                                                @foreach ($tags as $tag)
                                                    <option value="{{ $tag->id }}"
                                                        {{ in_array($tag->id, $file->tags) ? 'selected' : '' }}>
                                                        {{ __($tag->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form--label">@lang('Description')</label>
                                    <textarea class="form--control" id="description" name="description" placeholder="Write a description about your file."
                                        required>{{ $file->description }}</textarea>
                                </div>

                                <div class="col-12 mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input bg--base" name="isPremium" value="1"
                                            type="checkbox" role="switch" id="flexSwitchCheckChecked" {{ $file->is_premium == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="flexSwitchCheckChecked">@lang('Is Premium?')</label>
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-end mb-3 mt-3">
                                    <button class="btn button">@lang('Submit')</button>
                                </div>
                            </div>
                        </form>

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
            $('.select2-auto-edit-tagging').select2({
                dropdownParent: $('.multiSelectParentEditDiv'),
                tags: true,
                tokenSeparators: [',']
            });
        })(jQuery);
    </script>
@endpush
