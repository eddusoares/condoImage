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
                                <div>
                                    <a href="{{ route('user.listing.asset.create') }}" class="btn button ">
                                        <i class="fas fa-plus me-1"></i>@lang('Add New')</a>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="table-area">
                                    <table class="custom-table">
                                        <thead>
                                            <tr>
                                                <th>@lang('SI')</th>
                                                <th>@lang('Image')</th>
                                                <th>@lang('Building Name')</th>
                                                <th>@lang('Unit Number')</th>
                                                <th>@lang('Price')</th>
                                                <th>@lang('Zip Url')</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($myListingUnits as $item)
                                                <tr>
                                                    <td>
                                                        #{{ $loop->iteration }}
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
                                                        <a class="btn button "
                                                            href="{{ route('user.listing.asset.edit', $item->id) }}">
                                                            <i class="las la-edit"></i>
                                                        </a>
                                                        <a href="javascript:void(0)" class="btn button confirmationBtn"
                                                            data-action="{{ route('user.listing.asset.delete', $item->id) }}"
                                                            data-question="@lang('Are you sure to delete this listing image?')">
                                                            <i class="las la-trash"></i>
                                                        </a>
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
                            @if ($myListingUnits->hasPages())
                                <div class="card-footer py-4">
                                    {{ paginateLinks($myListingUnits) }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-confirmation-modal></x-confirmation-modal>
@endsection


