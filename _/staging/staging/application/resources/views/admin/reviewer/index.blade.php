@extends('admin.layouts.app')
@section('panel')
    <div class="row gy-4">
        <div class="col-xxl-12">
            <div class="text-end mb-2">
                <a href="{{ route('admin.reviewer.create') }}" class="btn btn--primary"><i class="fas fa-plus me-2"></i>@lang('Add')</a>
            </div>
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                                <tr>
                                    <th>@lang('SL No')</th>
                                    <th>@lang('Image')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Username')</th>
                                    <th>@lang('Email')</th>
                                    <th>@lang('Joined At')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviewers as $reviewer)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            <img src="{{ getImage(getFilePath('reviewerProfile') . '/' . $reviewer->image) }}"
                                                alt="" width="45">
                                        </td>
                                        <td>
                                            <span class="fw-bold">
                                                {{ $reviewer->name }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold">
                                                {{ $reviewer->username }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold">
                                                {{ $reviewer->email }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold">
                                                {{ $reviewer->created_at }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.reviewer.edit', $reviewer->id) }}"
                                                class="btn btn--primary ms-1"><i class="las la-edit"></i>
                                            </a>
                                            <button class="btn btn--danger ms-1 confirmationBtn"
                                                data-action="{{ route('admin.reviewer.delete', $reviewer->id) }}"
                                                data-question="@lang('Are you sure to delete this reviewer?')"
                                                data-status=""><i class="las la-trash"></i>
                                            </button>
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
                @if ($reviewers->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($reviewers) }}
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
                <input type="text" name="search_table" class="form-control text--dark" placeholder="@lang('Search by Table Data')">
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
