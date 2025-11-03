@php
    $categories = App\Models\Category::where('status', 1)->get();
    $tags = App\Models\Tag::where('status', 1)->get();
@endphp
@extends($activeTemplate . 'layouts.master')
@section('content')
    <!-- body-wrapper-start -->
    <div class="body-wrapper">

        <div class="table-content">
            <div class="m-0">
                <div class="list-card">
                    <div class="tabs tab-custom">
                        <div class="d-flex justify-content-start">
                            <ul class="nav nav-pills my-auto" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link tab-link active" id="pills-pending-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-pending" type="button" role="tab"
                                        aria-controls="pills-pending" aria-selected="true">@lang('Pending')
                                        <span>{{ $pendingFilesCount }}</span></button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link tab-link" id="pills-onReviewing-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-onReviewing" type="button" role="tab"
                                        aria-controls="pills-onReviewing" aria-selected="true">@lang('On Reviewing')
                                        <span>{{ $onReviewingFilesCount }}</span></button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link tab-link" id="pills-published-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-published" type="button" role="tab"
                                        aria-controls="pills-published" aria-selected="true">@lang('Published')
                                        <span>{{ $publishedFilesCount }}</span></button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link tab-link" id="pills-rejection-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-rejection" type="button" role="tab"
                                        aria-controls="pills-rejection" aria-selected="false">@lang('Rejected')
                                        <span>{{ $rejectedFilesCount }}</span></button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" data-wow-delay="0.6s" id="pills-tabContent">
                            <div class="tab-pane fade show active " id="pills-pending" role="tabpanel"
                                aria-labelledby="pills-pending-tab" tabindex="0">
                                <div class="table-area">
                                    <div class="row justify-content-center">
                                        <div class="col-xl-12">
                                            <div class="table-area">
                                                <table class="custom-table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">@lang('#')</th>
                                                            <th>@lang('Preview')</th>
                                                            <th>@lang('Title')</th>
                                                            <th>@lang('Category')</th>
                                                            <th>@lang('Submitted On')</th>
                                                            <th>@lang('Status')</th>
                                                            <th>@lang('Is Premium?')</th>
                                                            <th>@lang('Action')</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($pendingFiles as $item)
                                                            <tr>
                                                                <td data-label="#" class="text-center">
                                                                    {{ $loop->iteration }}
                                                                </td>
                                                                <td data-label="preview" class="info"><img
                                                                        src="{{ fileStorePath($item,'media') }}"
                                                                        alt="image">
                                                                </td>
                                                                <td data-label="preview" class="info">
                                                                    @if (strlen($item->title) < 21)
                                                                        <span class="fw-bold">
                                                                            {{ $item->title }}
                                                                        </span>
                                                                    @else
                                                                        <span class="fw-bold">
                                                                            {{ substr($item->title, 0, 20) }}...
                                                                        </span>
                                                                    @endif
                                                                </td>
                                                                <td data-label="published">
                                                                    {{ $item->category->name }}
                                                                </td>
                                                                <td data-label="published">
                                                                    {{ showDateTime($item->created_at, 'h:i A, M Y') }}
                                                                </td>
                                                                <td data-label="download">
                                                                    @php
                                                                        echo $item->statusBadge;
                                                                    @endphp
                                                                </td>
                                                                <td data-label="download">
                                                                    @if (isset($item->is_premium))
                                                                        @lang('Premium')<i
                                                                            class="text--base fas fa-crown mx-2"></i>
                                                                    @else
                                                                        @lang('Free')<i
                                                                            class="text--base fas fa-check-circle mx-2"></i>
                                                                    @endif
                                                                </td>
                                                                <td data-label="Action" class="table-dropdown">
                                                                    <i class="fas fa-ellipsis-v"
                                                                        data-bs-toggle="dropdown"></i>

                                                                    <ul class="dropdown-menu">
                                                                        <li>
                                                                            <a href="{{ route('user.file.edit', $item->id) }}"
                                                                                class="dropdown-item">@lang('Edit')</a>
                                                                        </li>
                                                                        <li><button class="dropdown-item confirmationBtn"
                                                                                data-question="@lang('Are you sure to delete this image?')"
                                                                                data-action="{{ route('user.file.delete', $item->id) }}">@lang('Delete')</button>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td class="text-muted text-center" colspan="100%">
                                                                    {{ __($emptyMessage) }}</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                                @if ($pendingFiles->hasPages())
                                                    <div class="text-end">
                                                        {{ $pendingFiles->links() }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-onReviewing" role="tabpanel"
                                aria-labelledby="pills-onReviewing-tab" tabindex="0">
                                <div class="table-area">
                                    <div class="row justify-content-center">
                                        <div class="col-xl-12">
                                            <div class="table-area">
                                                <table class="custom-table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">@lang('#')</th>
                                                            <th>@lang('Preview')</th>
                                                            <th>@lang('Reviewer')</th>
                                                            <th>@lang('Title')</th>
                                                            <th>@lang('Category')</th>
                                                            <th>@lang('Submitted On')</th>
                                                            <th>@lang('Status')</th>
                                                            <th>@lang('Is Premium?')</th>
                                                            <th>@lang('Action')</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($onReviewingFiles as $item)
                                                            <tr>
                                                                <td data-label="#" class="text-center">
                                                                    {{ $loop->iteration }}
                                                                </td>
                                                                <td data-label="preview" class="info"><img
                                                                        src="{{ fileStorePath($item,'media') }}"
                                                                        alt="image">
                                                                </td>
                                                                <td data-label="preview" class="info">
                                                                    @if (isset($item->reviewer->name))
                                                                        {{ $item->reviewer->name }}
                                                                    @else
                                                                        @lang('Admin')
                                                                    @endif
                                                                </td>
                                                                <td data-label="preview" class="info">
                                                                    @if (strlen($item->title) < 21)
                                                                        <span class="fw-bold">
                                                                            {{ $item->title }}
                                                                        </span>
                                                                    @else
                                                                        <span class="fw-bold">
                                                                            {{ substr($item->title, 0, 20) }}...
                                                                        </span>
                                                                    @endif
                                                                </td>
                                                                <td data-label="published">
                                                                    {{ $item->category->name }}
                                                                </td>
                                                                <td data-label="published">
                                                                    {{ showDateTime($item->created_at, 'h:i A, M Y') }}
                                                                </td>
                                                                <td data-label="download">
                                                                    @php
                                                                        echo $item->statusBadge;
                                                                    @endphp
                                                                </td>
                                                                <td data-label="download">
                                                                    @if (isset($item->is_premium))
                                                                        @lang('Premium')<i
                                                                            class="text--base fas fa-crown mx-2"></i>
                                                                    @else
                                                                        @lang('Free')<i
                                                                            class="text--base fas fa-check-circle mx-2"></i>
                                                                    @endif
                                                                </td>
                                                                <td data-label="Action" class="table-dropdown">
                                                                    <i class="fas fa-ellipsis-v"
                                                                        data-bs-toggle="dropdown"></i>

                                                                    <ul class="dropdown-menu">
                                                                        <li>
                                                                            <a href="{{ route('user.file.edit', $item->id) }}"
                                                                                class="dropdown-item">@lang('Edit')</a>
                                                                        </li>
                                                                        <li><button class="dropdown-item confirmationBtn"
                                                                                data-question="@lang('Are you sure to delete this image?')"
                                                                                data-action="{{ route('user.file.delete', $item->id) }}">@lang('Delete')</button>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td class="text-muted text-center" colspan="100%">
                                                                    {{ __($emptyMessage) }}</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                                @if ($onReviewingFiles->hasPages())
                                                    <div class="text-end">
                                                        {{ $onReviewingFiles->links() }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-published" role="tabpanel"
                                aria-labelledby="pills-published-tab" tabindex="0">
                                <div class="table-area">
                                    <div class="row justify-content-center">
                                        <div class="col-xl-12">
                                            <div class="table-area">
                                                <table class="custom-table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">@lang('#')</th>
                                                            <th>@lang('Preview')</th>
                                                            <th>@lang('Reviewer')</th>
                                                            <th>@lang('Title')</th>
                                                            <th>@lang('Category')</th>
                                                            <th>@lang('Submitted On')</th>
                                                            <th>@lang('Status')</th>
                                                            <th>@lang('Is Premium?')</th>
                                                            <th>@lang('Total Download')</th>
                                                            <th>@lang('Action')</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($publishedFiles as $item)
                                                            <tr>
                                                                <td data-label="#" class="text-center">
                                                                    {{ $loop->iteration }}
                                                                </td>
                                                                <td data-label="preview" class="info"><img
                                                                        src="{{ fileStorePath($item,'media') }}"
                                                                        alt="image">
                                                                </td>
                                                                <td data-label="preview" class="info">
                                                                    @if (isset($item->reviewer->name))
                                                                        {{ $item->reviewer->name }}
                                                                    @else
                                                                        @lang('Admin')
                                                                    @endif
                                                                </td>
                                                                <td data-label="preview" class="info">
                                                                    @if (strlen($item->title) < 21)
                                                                        <span class="fw-bold">
                                                                            {{ $item->title }}
                                                                        </span>
                                                                    @else
                                                                        <span class="fw-bold">
                                                                            {{ substr($item->title, 0, 20) }}...
                                                                        </span>
                                                                    @endif
                                                                </td>
                                                                <td data-label="published">
                                                                    {{ $item->category->name }}
                                                                </td>
                                                                <td data-label="published">
                                                                    {{ showDateTime($item->created_at, 'h:i A, M Y') }}
                                                                </td>
                                                                <td data-label="download">
                                                                    @php
                                                                        echo $item->statusBadge;
                                                                    @endphp
                                                                </td>
                                                                <td data-label="download">
                                                                    @if (isset($item->is_premium))
                                                                        @lang('Premium')<i
                                                                            class="text--base fas fa-crown mx-2"></i>
                                                                    @else
                                                                        @lang('Free')<i
                                                                            class="text--base fas fa-check-circle mx-2"></i>
                                                                    @endif
                                                                </td>
                                                                <td data-label="download">
                                                                    @if (isset($item->download_count))
                                                                        {{ $item->download_count }}
                                                                    @else
                                                                        0
                                                                    @endif
                                                                </td>
                                                                <td data-label="Action" class="table-dropdown">
                                                                    <i class="fas fa-ellipsis-v"
                                                                        data-bs-toggle="dropdown"></i>

                                                                    <ul class="dropdown-menu">
                                                                        <li>
                                                                            <a href="{{ route('user.file.edit', $item->id) }}"
                                                                                class="dropdown-item">@lang('Edit')</a>
                                                                        </li>
                                                                        <li><button class="dropdown-item confirmationBtn"
                                                                                data-question="@lang('Are you sure to delete this image?')"
                                                                                data-action="{{ route('user.file.delete', $item->id) }}">@lang('Delete')</button>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td class="text-muted text-center" colspan="100%">
                                                                    {{ __($emptyMessage) }}</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                                @if ($publishedFiles->hasPages())
                                                    <div class="text-end">
                                                        {{ $publishedFiles->links() }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-rejection" role="tabpanel"
                                aria-labelledby="pills-rejection-tab" tabindex="0">
                                <div class="table-area">
                                    <div class="row justify-content-center">
                                        <div class="col-xl-12">
                                            <div class="table-area">
                                                <table class="custom-table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">@lang('#')</th>
                                                            <th>@lang('Preview')</th>
                                                            <th>@lang('Reviewer')</th>
                                                            <th>@lang('Title')</th>
                                                            <th>@lang('Category')</th>
                                                            <th>@lang('Submitted On')</th>
                                                            <th>@lang('Status')</th>
                                                            <th>@lang('Is Premium?')</th>
                                                            <th>@lang('Rejection Reason')</th>
                                                            <th>@lang('Action')</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($rejectedFiles as $item)
                                                            <tr>
                                                                <td data-label="#" class="text-center">
                                                                    {{ $loop->iteration }}
                                                                </td>
                                                                <td data-label="preview" class="info"><img
                                                                        src="{{ fileStorePath($item,'media') }}"
                                                                        alt="image">
                                                                </td>
                                                                <td data-label="preview" class="info">
                                                                    @if (isset($item->reviewer->name))
                                                                        {{ $item->reviewer->name }}
                                                                    @else
                                                                        @lang('Admin')
                                                                    @endif
                                                                </td>
                                                                <td data-label="preview" class="info">
                                                                    @if (strlen($item->title) < 21)
                                                                        <span class="fw-bold">
                                                                            {{ $item->title }}
                                                                        </span>
                                                                    @else
                                                                        <span class="fw-bold">
                                                                            {{ substr($item->title, 0, 20) }}...
                                                                        </span>
                                                                    @endif
                                                                </td>
                                                                <td data-label="published">
                                                                    {{ $item->category->name }}
                                                                </td>
                                                                <td data-label="published">
                                                                    {{ showDateTime($item->created_at, 'h:i A, M Y') }}
                                                                </td>
                                                                <td data-label="download">
                                                                    @php
                                                                        echo $item->statusBadge;
                                                                    @endphp
                                                                </td>
                                                                <td data-label="download">
                                                                    @if (isset($item->is_premium))
                                                                        @lang('Premium')<i
                                                                            class="text--base fas fa-crown mx-2"></i>
                                                                    @else
                                                                        @lang('Free')<i
                                                                            class="text--base fas fa-check-circle mx-2"></i>
                                                                    @endif
                                                                </td>
                                                                <td data-label="download">
                                                                    <button data-reason="{{ $item->reason }}"
                                                                        class="text--base rerectionBtn">@lang('Click')</button>
                                                                </td>
                                                                <td data-label="Action" class="table-dropdown">
                                                                    <button class="confirmationBtn"
                                                                        data-question="@lang('Are you sure to delete this image?')"
                                                                        data-action="{{ route('user.file.delete', $item->id) }}"><i
                                                                            class="fas fa-trash text--danger"></i></button>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td class="text-muted text-center" colspan="100%">
                                                                    {{ __($emptyMessage) }}</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                                @if ($rejectedFiles->hasPages())
                                                    <div class="text-end">
                                                        {{ $rejectedFiles->links() }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-confirmation-modal></x-confirmation-modal>
    <x-rejection-reason></x-rejection-reason>
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
