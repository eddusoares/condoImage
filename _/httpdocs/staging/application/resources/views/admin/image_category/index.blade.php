@extends('admin.layouts.app')
@section('panel')
    <div class="row gy-4">
        <div class="col-xxl-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('#')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Created At')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($imageCategories as $item)
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
                                            <button class="btn btn--primary ms-1 editCatBtn"
                                                data-action="{{ route('admin.image.category.update', $item->id) }}"
                                                data-name="{{ $item->name }}"><i class="las la-edit"></i>
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
                @if ($imageCategories->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($imageCategories) }}
                    </div>
                @endif
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
                <form action="{{ route('admin.image.category.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group ">
                            <label>@lang('Image Category Name')</label>
                            <input class="form-control" type="text" name="name" required>
                        </div>
                 
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-global">@lang('Create')</button>
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
                            <input class="form-control" type="text" name="name" required>
                        </div>
                                              
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-global">@lang('Update')</button>
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

@push('breadcrumb-plugins')
    <div class="text-end mb-2">
        <button class="btn btn-sm btn--primary createCatBtn"><i class="las la-plus"></i>@lang('Add New')</button>
    </div>
@endpush
