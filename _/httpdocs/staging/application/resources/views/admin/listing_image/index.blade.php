@extends('admin.layouts.app')
@section('panel')
    @include('admin.components.tabs.listing_image')
    <div class="row gy-4">
        <div class="col-xxl-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('SI')</th>
                                    <th>@lang('Author')</th>
                                    <th>@lang('Image')</th>
                                    <th>@lang('Building Name')</th>
                                    <th>@lang('Unit Number')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($listingUnits as $item)
                                    <tr>
                                        <td>
                                            #{{ $loop->iteration }}
                                        </td>
                                        <td>
                                            @php
                                                echo $item->author();
                                            @endphp
                                        </td>
                                        <td>
                                            <img class="custom-rounded"
                                                src="{{ getImage(getFilePath('listing_asset_image') . '/' . $item->image) }}"
                                                alt="Listing Unit Image" width="70">
                                        </td>

                                        <td>
                                            <span class="fw-bold">
                                                {{ $item->building->name }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="fw-bold">
                                                {{ $item->unit_number }}
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
                                                data-action="{{ route('admin.listing.asset.status.change', $item->id) }}"
                                                data-question="@lang('Are you sure to change ?') {{ $item->getStatusText() }}">
                                                <i class="las la-sync"></i>
                                            </button>

                                            <a href="{{ route('admin.listing.asset.view', $item->id) }}"
                                                class="btn btn--primary ms-1" data-name="{{ $item->name }}"><i
                                                    class="las la-eye"></i>
                                            </a>

                                            @if ($item->isAdminAuthor())
                                                <a class="btn btn--primary ms-1"
                                                    href="{{ route('admin.listing.asset.edit', $item->id) }}">
                                                    <i class="las la-edit"></i>
                                                </a>
                                                <button class="btn btn--danger confirmationBtn"
                                                    data-action="{{ route('admin.listing.asset.delete', $item->id) }}"
                                                    data-question="@lang('Are you sure to delete this listing image?')">
                                                    <i class="las la-trash"></i>
                                                </button>
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
                @if ($listingUnits->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($listingUnits) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-confirmation-modal></x-confirmation-modal>
@endsection


@push('breadcrumb-plugins')
    <div class="text-end mb-2">
        <a href="{{ route('admin.listing.asset.create') }}" class="btn btn-sm btn--primary">
            <i class="las la-plus"></i>@lang('Add New')</a>
    </div>
@endpush
