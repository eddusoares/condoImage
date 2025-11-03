@extends($activeTemplate . 'layouts.master')
@section('content')
    <!-- body-wrapper-start -->
    <div class="body-wrapper">
        <div class="table-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="dashboard-card-wrap mt-0">
                        <div class="table-area">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('user.image.category.index') }}" class="btn btn-primary btn--sm">
                                        <i class="fas fa-list me-1"></i> @lang('All Image Category')
                                    </a>
                                    <a href="{{ route('user.image.category.my.list') }}" class="btn btn-secondary btn--sm">
                                        <i class="fas fa-list me-1"></i> @lang('My mage Category')
                                    </a>
                                </div>
                                <div>
                                    <button class="btn btn-success btn--sm createCatBtn">
                                        <i class="fas fa-plus me-1"></i> @lang('Add New')
                                    </button>
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="table-area">
                                    <table class="custom-table">
                                        <thead>
                                            <tr>
                                                <th>@lang('#')</th>
                                                <th>@lang('Name')</th>
                                                <th>@lang('Created At')</th>
                                                <th>@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($myImageCategories as $item)
                                                <tr>
                                                    <td>
                                                        {{ $loop->iteration }}
                                                    </td>

                                                    <td>
                                                        @if (strlen($item->name) < 21)
                                                            <span class="fw-bold">
                                                                {{ $item->name }}
                                                            </span>
                                                        @else
                                                            <span class="fw-bold">
                                                                {{ substr($item->name, 0, 20) }}...
                                                            </span>
                                                        @endif
                                                    </td>


                                                    <td>
                                                        <span class="fw-bold">
                                                            {{ showDateTime($item->created_at) }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        <button class="btn button ms-1 editCatBtn"
                                                            data-action="{{ route('user.image.category.update', $item->id) }}"
                                                            data-name="{{ $item->name }}"><i class="las la-edit"></i>
                                                        </button>
                                                    </td>

                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="text-muted text-center" colspan="100%">
                                                        {{ __($emptyMessage) }}</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table><!-- table end -->
                                </div>
                            </div>
                            @if ($myImageCategories->hasPages())
                                <div class="card-footer py-4">
                                    {{ paginateLinks($myImageCategories) }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Image Category Create Modal --}}
    <div id="createCat" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Add New Image Category')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('user.image.category.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group ">
                            <label>@lang('Image Category Name')</label>
                            <input class="form-control form--control" type="text" name="name" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn button">@lang('Create')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Image Category Edit Modal --}}
    <div id="editCat" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Edit Image Category')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form id="editForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Image Category Name')</label>
                            <input class="form-control form--control" type="text" name="name" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn button">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

  
@endsection


@push('script')
    <script>
        (function($) {
            "use strict";
            $('.createCatBtn').on('click', function() {
                var modal = $('#createCat');
                modal.modal('show');
            });
            $('.editCatBtn').on('click', function() {
                var modal = $('#editCat');
                let url = $(this).data('action');
                let base = "{{ url('/') }}";

                $('#editForm').attr('action', url);
                modal.find('input[name="name"]').val($(this).data('name'));

                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
