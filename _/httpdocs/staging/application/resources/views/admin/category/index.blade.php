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
                                    <th>@lang('Image')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Created At')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
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
                                            <button class="btn btn--primary ms-1 editCatBtn"
                                                data-action="{{ route('admin.category.update', $category->id) }}"
                                                data-name="{{ $category->name }}" data-status="{{ $category->status }}"
                                                data-image="{{ $category->image }}"><i class="las la-edit"></i>
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
                @if ($categories->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($categories) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

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
                <form action="{{ route('admin.category.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group ">
                            <label>@lang('Category Name')</label>
                            <input class="form-control" type="text" name="name" required>
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
                                        <input type="file" class="profilePicUpload" name="image" id="profilePicUpload0"
                                            accept=".png, .jpg, .jpeg">
                                        <label for="profilePicUpload0" class="bg--primary">@lang('Category Image')</label>
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
                        <button type="submit" class="btn btn--primary btn-global">@lang('Create')</button>
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
                            <input class="form-control" type="text" name="name" required>
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
                                        <input type="file" class="profilePicUpload" name="image"
                                            id="profilePicUpload2" accept=".png, .jpg, .jpeg">
                                        <label for="profilePicUpload2" class="bg--primary">@lang('Category Image')</label>
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
                        <button type="submit" class="btn btn--primary btn-global">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

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

                if($(this).data('status') == 1){
                    modal.find('input[name="catstatus"]').prop('checked', true);
                }

                if($(this).data('status') == 0){
                    modal.find('input[name="catstatus"]').prop('checked', false);
                }
                modal.modal('show');
            });
        })(jQuery);
    </script>

    <script>
        $('.iconPicker').iconpicker().on('iconpickerSelected', function(e) {
            $(this).closest('.form-group').find('.iconpicker-input').val(`<i class="${e.iconpickerValue}"></i>`);
        });
    </script>
@endpush

