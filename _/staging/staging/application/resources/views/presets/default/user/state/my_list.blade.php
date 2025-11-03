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
                                    <a href="{{ route('user.state.index') }}" class="btn btn-primary btn--sm">
                                        <i class="fas fa-list me-1"></i> @lang('All State')
                                    </a>
                                    <a href="{{ route('user.state.my.list') }}" class="btn btn-secondary btn--sm">
                                        <i class="fas fa-list me-1"></i> @lang('My State')
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
                                                <th>@lang('Status')</th>
                                                <th>@lang('Created At')</th>
                                                <th>@lang('Action')</th>
                                        </thead>
                                        <tbody>
                                            @forelse($myStates as $item)
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
                                                        @php echo $item->statusBadge @endphp
                                                    </td>


                                                    <td>
                                                        <span class="fw-bold">
                                                            {{ showDateTime($item->created_at) }}
                                                        </span>
                                                    </td>


                                                    <td>
                                                        <button class="btn button ms-1 editCatBtn"
                                                            data-action="{{ route('user.state.update', $item->id) }}"
                                                            data-name="{{ $item->name }}"
                                                            data-status="{{ $item->status }}"><i class="las la-edit"></i>
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
                            @if ($myStates->hasPages())
                                <div class="card-footer py-4">
                                    {{ paginateLinks($myStates) }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- State Create Modal --}}
    <div id="createCat" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Add New State')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('user.state.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group ">
                            <label>@lang('State Name')</label>
                            <input class="form-control form--control" type="text" name="name" required>
                        </div>

                        <div class="form-group mt-3">
                            <label class="fw-bold">@lang('Status')</label>
                            <label class="switch m-0">
                                <input type="checkbox" class="toggle-switch" name="status">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn button">@lang('Create')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- State Edit Modal --}}
    <div id="editCat" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Edit State')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form id="editForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('State Name')</label>
                            <input class="form-control form--control" type="text" name="name" required>
                        </div>

                        <div class="form-group mt-3">
                            <label class="fw-bold">@lang('Status')</label>
                            <label class="switch m-0">
                                <input type="checkbox" class="toggle-switch" name="stateStatus">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn button">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal></x-confirmation-modal>
@endsection

@push('style')
    <style>
        .image-upload .thumb .profilePicPreview {
            width: 100%;
            height: 210px;
            display: block;
            border-radius: 10px;
            background-size: cover !important;
            background-position: top;
            background-repeat: no-repeat;
            position: relative;
            overflow: hidden;
        }
    </style>
@endpush


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
                let img = $(this).data('image');
                let imgPath = base + `/{{ getFilePath('category') }}/${img}`;

                $('#editForm').attr('action', url);
                modal.find('input[name="name"]').val($(this).data('name'));
                $('.editCatPreview').css('background', 'url(' + imgPath + ') no-repeat center center/cover');

                if ($(this).data('status') == 1) {
                    modal.find('input[name="catstatus"]').prop('checked', true);
                }

                if ($(this).data('status') == 0) {
                    modal.find('input[name="catstatus"]').prop('checked', false);
                }
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
