@extends('admin.layouts.app')
@section('panel')
    @include('admin.components.tabs.building')
    <div class="row gy-4">
        <div class="col-xxl-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('SI')</th>
                                    <th>@lang('Image')</th>
                                    <th>@lang('Claim By')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Neighborhood')</th>
                                    <th>@lang('Built Year')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($buildings as $item)
                                    <tr>
                                        <td>
                                            #{{ $loop->iteration }}
                                        </td>

                                        <td>
                                            <img class="custom-rounded"
                                                src="{{ getImage(getFilePath('building') . '/' . $item->image) }}"
                                                alt="Building Image" width="70">
                                        </td>

                                        <td>
                                          {{$item->imageUploadAuthor($item)}}
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
                                                {{ $item->neighborhood->name }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="fw-bold">
                                                {{ $item->year_built }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="fw-bold">
                                                {{ $general->cur_sym }}{{ showAmount($item->price) }}
                                            </span>
                                        </td>

                                        <td>
                                            @php echo $item->statusBadge @endphp
                                        </td>

                                        <td>
                                            <button class="btn btn--warning confirmationBtn"
                                                data-action="{{ route('admin.building.status.change', $item->id) }}"
                                                data-question="@lang('Are you sure to change ?') {{ $item->getStatusText() }}">
                                                <i class="las la-sync"></i>
                                            </button>

                                            <a href="{{ route('admin.building.view', $item->id) }}"
                                                class="btn btn--primary ms-1" data-name="{{ $item->name }}"><i
                                                    class="las la-eye"></i>
                                            </a>
                                            @if ($item->claim != 1)
                                                <button data-action="{{ route('admin.building.claim', $item->id) }}"
                                                    class="btn btn--primary ms-1 claimBtn"><i
                                                        class="fas fa-exclamation-triangle"></i>
                                                </button>
                                            @endif
                                             @if ($item->claim == 1)
                                            <a href="{{ route('admin.building.edit', $item->id) }}"
                                                class="btn btn--primary ms-1" data-name="{{ $item->name }}"><i
                                                    class="las la-edit"></i>
                                            </a>
                                            @endif


                                            {{-- <button class="btn btn--danger confirmationBtn"
                                                data-action="{{ route('admin.building.delete', $item->id) }}"
                                                data-question="@lang('Are you sure to delete this building?')">
                                                <i class="las la-trash"></i>
                                            </button> --}}

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
                @if ($buildings->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($buildings) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-confirmation-modal></x-confirmation-modal>
    {{-- claim Create Modal --}}
    <div id="claim" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Edit claim author')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form id="editForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label>@lang('State Name')</label>
                            <select class="form-control" name="claim" id="claim">
                                <option value="1">@lang('Claim for me')</option>
                                <option value="2">@lang('Open for contributor')</option>
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
    <div class="text-end mb-2">
        <a href="{{ route('admin.building.create') }}" class="btn btn-sm btn--primary createCatBtn">
            <i class="las la-plus"></i>@lang('Add New')</a>
    </div>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.claimBtn').on('click', function() {
                var modal = $('#claim');
                let url = $(this).data('action');
                let base = "{{ url('/') }}";

                $('#editForm').attr('action', url);

                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
