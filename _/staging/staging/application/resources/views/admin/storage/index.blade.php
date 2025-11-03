@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                                <tr>
                                    <th>@lang('Image')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('status')</th>
                                    <th>@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($storageProviders as $item)
                                    <tr>
                                        <td class="product_image td-img">
                                            <img src="{{ getImage(getFilePath('storage') . '/' . @$item->logo) }}"
                                                class='img-thumbnail ' title="@lang('Image')">
                                        </td>
                                        <td>{{ __($item->name) }}</td>

                                        <td data-label="Status">
                                            <label class="switch m-0">
                                                <form action="{{ route('admin.storage.status') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                                </form>
                                                <input type="checkbox" class="toggle-switch status" name="status"
                                                    {{ $item->status ? 'checked' : null }} id="status" value="1">
                                                <span class="slider round"></span>
                                            </label>
                                        </td>

                                        <td>
                                            <div class="button--group">
                                                <a href="{{ route('admin.storage.edit', $item->id) }}"
                                                    title="@lang('Edit')" class="btn btn-sm btn--success editModal">
                                                    <i class="la la-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __(@$emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table><!-- table end -->
                        {{ $storageProviders->links() }}
                    </div>
                </div>
            </div><!-- card end -->
        </div>
    </div>
@endsection
@push('style')
    <style>
        .td-img img{
           width: 100px; 
        }
    </style>
@endpush


@push('script')
    <script>
        $(document).ready(function() {
            "use strict";
            $(".status").on('click', function() {
                var form = $(this).siblings('form');
                form.submit();

            });
        });
    </script>
@endpush
