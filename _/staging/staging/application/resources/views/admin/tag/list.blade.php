@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                                <tr>
                                    <th>@lang('#')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tags as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ __($item->name) }}</td>
                                        <td>
                                            @php echo $item->statusBadge @endphp
                                        </td>
                                        <td>
                                            <div class="button--group">
                                                <button type="button"
                                                    class="btn btn-sm btn--primary updateCity"data-id="{{ $item->id }}"
                                                    data-name="{{ $item->name }}" data-status="{{ $item->status }}"><i
                                                        class="las la-edit"></i></button>
                                            </div>
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
                @if ($tags->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($tags) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>


    {{-- Add METHOD MODAL --}}
    <div id="cityModel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Add PropertyType')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.tag.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name"> @lang('Property Type'):</label>
                            <input type="text" class="form-control" name="name" placeholder="@lang('Property Type')"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-global">@lang('Create')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Update METHOD MODAL --}}
    <div id="updateCityModel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Update PropertyType')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.tag.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name"> @lang('Property Type'):</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>

                        <div class="form-group">
                            <label>@lang('Status')</label>
                            <select class="form-control" name="status">
                                <option value="1">@lang('Activate')</option>
                                <option value="0">@lang('Deactivate')</option>
                            </select>
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
@push('breadcrumb-plugins')
    <button type="button" class="btn btn-sm btn--primary addCity"><i class="las la-plus"></i>@lang('Add
            New')</button>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";

            $('.addCity').on('click', function() {
                $('#cityModel').modal('show');
            });


            $('.updateCity').on('click', function() {
                var modal = $('#updateCityModel');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('input[name=name]').val($(this).data('name'));
                if ($(this).data('status') == 0) {
                    $("option[value='0']").attr("selected", "selected");
                } else {
                    $("option[value='1']").attr("selected", "selected");
                }
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
