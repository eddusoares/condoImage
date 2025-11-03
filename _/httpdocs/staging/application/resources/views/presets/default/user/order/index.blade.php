@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="body-wrapper">
        <div class="table-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="dashboard-card-wrap mt-0">
                        <div class="table-area">
                            <div class="row justify-content-center">
                                <div class="col-xl-12">
                                    <div class="table-area">
                                        <table class="custom-table">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">@lang('#')</th>
                                                    <th>@lang('Order Type')</th>
                                                    <th>@lang('Price')</th>
                                                    <th>@lang('Status')</th>
                                                    <th>@lang('Order Date')</th>
                                                    <th class="text-center">@lang('Action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($orders as $item)
                                                    <tr>
                                                        <td data-label="preview" class="info text-center">
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td data-label="published">
                                                            @if ($item->building_type == 1)
                                                                <a title="View Image" class="text--base"
                                                                    href="{{ route('condo.building.details', building_route_params($item->building)) }}">{{__($item->building->name)}} @lang('building images')</a>
                                                            @else
                                                                <a title="View Image" class="text--base"
                                                                    href="{{ route('condo.building.listing.images',listing_unit_route_params($item->buildingListingUnit)) }}">
                                                                    {{__($item?->buildingListingUnit?->building?->name)}}  
                                                                    {{__($item?->buildingListingUnit?->unit_number)}} 
                                                                    @lang('Listing Images')
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td data-label="download">
                                                            {{ $general->cur_sym }} {{ $item->amount }}
                                                        </td>
                                                        <td data-label="total">
                                                            @php
                                                                echo $item->statusBadge;
                                                            @endphp
                                                        </td>
                                                        <td data-label="total-earnings">
                                                            {{ showDateTime($item->created_at, 'h:i A, M Y') }}
                                                        </td>
                                                        <td data-label="Action" class="text-center">
                                                            <a href="{{ route('user.images.download', $item->id) }}"
                                                                class="btn button">
                                                                <i class="fas fa-download"></i>
                                                                @lang('Download Zip file')
                                                                
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
                                        </table>
                                        @if ($orders->hasPages())
                                            <div class="text-end">
                                                {{ $orders->links() }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
