@extends($activeTemplate . 'layouts.master')
@section('content')
    <!-- body-wrapper-start -->
    <div class="body-wrapper">
        <div class="table-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="dashboard-card-wrap mt-0">
                        <div class="table-area">
                            <div class="row justify-content-center">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('user.category.index') }}" class="btn btn-primary btn--sm">
                                            <i class="fas fa-list me-1"></i> @lang('All Category')
                                        </a>
                                        <a href="{{ route('user.category.my.list') }}" class="btn btn-secondary btn--sm">
                                            <i class="fas fa-list me-1"></i> @lang('My Categories')
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
                                                    <th>@lang('Image')</th>
                                                    <th>@lang('Status')</th>
                                                    <th>@lang('Created At')</th>
                                                    <th>@lang('Action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($myCategories as $category)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>

                                                        <td>
                                                            @if (strlen($category->name) < 21)
                                                                <span class="fw-bold">
                                                                    {{ $category->name }}
                                                                </span>
                                                            @else
                                                                <span class="fw-bold">
                                                                    {{ substr($category->name, 0, 20) }}...
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <img class="custom-rounded"
                                                                src="{{ getImage(getFilePath('category') . '/' . $category->image) }}"
                                                                alt="Category Image" width="70">
                                                        </td>

                                                        <td>
                                                            @php echo $category->statusBadge @endphp
                                                        </td>


                                                        <td>
                                                            <span class="fw-bold">
                                                                {{ showDateTime($category->created_at) }}
                                                            </span>
                                                        </td>

                                                        <td>
                                                            <button class="btn button ms-1 editCatBtn"
                                                                data-action="{{ route('user.category.update', $category->id) }}"
                                                                data-name="{{ $category->name }}"
                                                                data-status="{{ $category->status }}"
                                                                data-image="{{ $category->image }}"><i
                                                                    class="las la-edit"></i>
                                                            </button>
                                                        </td>

                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td class="text-muted text-center" colspan="100%">
                                                            {{ __($emptyMessage) }}
                                                        </td>
                                                    </tr>
                                                @endforelse

                                            </tbody>
                                        </table><!-- table end -->
                                    </div>
                                </div>
                                @if ($myCategories->hasPages())
                                    <div class="card-footer py-4">
                                        {{ paginateLinks($myCategories) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <x-confirmation-modal></x-confirmation-modal>


    {{-- Category Create Modal --}}
    <div id="createCat" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Add New Category')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('user.category.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group ">
                            <label>@lang('Category Name')</label>
                            <input class="form-control form--control" type="text" name="name" required>
                        </div>
                        <div class="form-group mt-3">
                            <label>@lang('Category Image')</label>
                            <div class="image-upload">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview"
                                            style="background: url({{ getImage('') }})no-repeat center center/cover;">
                                            <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="avatar-edit">
                                        <input type="file" class="profilePicUpload form-control form--control"
                                            name="image" id="profilePicUpload0" accept=".png, .jpg, .jpeg">
                                        <label for="profilePicUpload0" class="btn button">@lang('Category Image')</label>
                                        <small class="mt-2">@lang('Recomended size')::<b>{{ getFileSize('category') }}</b>
                                            @lang('px').
                                        </small>
                                    </div>
                                </div>
                            </div>
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
                        <button type="submit" class="btn button mt-4">@lang('Create')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Category Edit Modal --}}
    <div id="editCat" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Edit Category')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form id="editForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Category Name')</label>
                            <input class="form-control form--control" type="text" name="name" required>
                        </div>
                        <div class="form-group mt-3">
                            <label>@lang('Category Image')</label>
                            <div class="image-upload">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview editCatPreview"
                                            style="background: url({{ getImage('') }})no-repeat center center/cover;">
                                            <button type="button" class="remove-image"><i
                                                    class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="avatar-edit">
                                        <input type="file" class="profilePicUpload form-control form--control"
                                            name="image" id="profilePicUpload2" accept=".png, .jpg, .jpeg">
                                        <label for="profilePicUpload2" class="btn button">@lang('Category Image')</label>
                                        <small class="mt-2">@lang('Recomended size')::<b>{{ getFileSize('category') }}</b>
                                            @lang('px').
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label class="fw-bold">@lang('Status')</label>
                            <label class="switch m-0">
                                <input type="checkbox" class="toggle-switch" name="catstatus">
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
@push('breadcrumb-plugins')
    <div class="text-end mb-2">
        <button class="btn btn-sm btn--primary createCatBtn"><i class="las la-plus"></i>@lang('Add New')</button>
    </div>
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
