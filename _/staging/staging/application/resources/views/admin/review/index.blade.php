@extends('admin.layouts.app')
@section('panel')
    @include('admin.components.tabs.review')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                                <tr>
                                    <th>@lang('#')</th>
                                    <th>@lang('Owner')</th>
                                    <th>@lang('Preview')</th>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('Submitted On')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Is Premium?')</th>
                                    @if (Request::routeIs('admin.review.published'))
                                        <th>@lang('Download Count')</th>
                                    @endif
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($files as $file)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>

                                        <td>
                                            <div class="fw-bold">
                                                @if (isset($file->user))
                                                    <a href="{{ route('admin.users.detail', $file->user->id) }}">{{ $file->user->fullname }}
                                                        {{ '(' . $file->user->username . ')' }}</a>
                                                @else
                                                    @lang('Admin')
                                                @endif
                                            </div>
                                        </td>

                                        <td data-label="preview" class="info">
                                            <img class="custom-rounded"
                                                src="{{ fileStorePath($file,'media') }}" alt="image"
                                                width="40">
                                        </td>

                                        <td data-label="preview" class="info">
                                            @if (strlen($file->title) < 21)
                                                <span class="fw-bold">
                                                    {{ $file->title }}
                                                </span>
                                            @else
                                                <span class="fw-bold">
                                                    {{ substr($file->title, 0, 20) }}...
                                                </span>
                                            @endif
                                        </td>

                                        <td data-label="published">
                                            {{ $file->category->name }}
                                        </td>

                                        <td data-label="published">
                                            {{ showDateTime($file->created_at, 'h:i A, M Y') }}
                                        </td>

                                        <td data-label="download">
                                            @php
                                                echo $file->statusBadge;
                                            @endphp
                                        </td>
                                        <td data-label="download">
                                            @if (isset($file->is_premium))
                                                @lang('Premium')<i class="text--primary fas fa-crown mx-2"></i>
                                            @else
                                                @lang('Free')<i class="text--primary fas fa-check-circle mx-2"></i>
                                            @endif
                                        </td>
                                        @if (Request::routeIs('admin.review.published'))
                                            <td data-label="download">
                                                @if (isset($file->download_count))
                                                    {{ $file->download_count }}
                                                @else
                                                    0
                                                @endif
                                            </td>
                                        @endif
                                        <td>
                                            @if (Request::routeIs('admin.review.pending'))
                                                <a title="@lang('Review')"
                                                    href="{{ route('admin.review.detail', $file->id) }}"
                                                    class="btn btn-sm btn--primary">
                                                    <i class="las la-pen-nib"></i>
                                                </a>
                                            @else
                                                <a title="@lang('Review')"
                                                    href="{{ route('admin.review.handle.detail', $file->id) }}"
                                                    class="btn btn-sm btn--primary">
                                                    <i class="las la-pen-nib"></i>
                                                </a>
                                            @endif

                                            @if (Request::routeIs('admin.review.rejected'))
                                                <button class="confirmationBtn btn btn-sm btn--danger ms-1"
                                                    data-question="@lang('Are you sure to delete this rejected image?')"
                                                    data-action="{{ route('admin.file.delete', $file->id) }}"><i
                                                        class="las la-trash"></i></button>
                                            @endif
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($files->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($files) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <x-confirmation-modal></x-confirmation-modal>
@endsection

@push('breadcrumb-plugins')
    <div class="d-flex flex-wrap justify-content-end">
        <form>
            <div class="input-group justify-content-end">
                <input type="text" name="search_table" class="form-control bg--white text-dark"
                    placeholder="@lang('Search by Table Data')">
                <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>
@endpush

@push('script')
    <script>
        //Custom Data Table
        $('.custom-data-table').closest('.card').find('.card-body').attr('style', 'padding-top:0px');
        var tr_elements = $('.custom-data-table tbody tr');
        $(document).on('input', 'input[name=search_table]', function() {
            var search = $(this).val().toUpperCase();
            var match = tr_elements.filter(function(idx, elem) {
                return $(elem).text().trim().toUpperCase().indexOf(search) >= 0 ? elem : null;
            }).sort();
            var table_content = $('.custom-data-table tbody');
            if (match.length == 0) {
                table_content.html('<tr><td colspan="100%" class="text-center">Data Not Found</td></tr>');
            } else {
                table_content.html(match);
            }
        });
    </script>
@endpush
