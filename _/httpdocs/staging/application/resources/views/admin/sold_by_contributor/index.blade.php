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
                                    <th>@lang('Image')</th>
                                    <th>@lang('Contributor Name')</th>
                                    <th>@lang('Building Name')</th>
                                    <th>@lang('Image Type')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Created At')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $item)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>

                                        <td>
                                            <img class="custom-rounded"
                                                src="{{ getImage(getFilePath('building') . '/' . $item->building->image) }}"
                                                alt="County Image" width="70">
                                        </td>

                                        <td>
                                            <span class="fw-bold">{{ $item->useName($item->building->claim_by) }}</span>
                                        </td>

                                        <td>
                                            <span class="fw-bold">
                                                {{ __($item->building->name) }}

                                            </span>
                                        </td>

                                        <td>
                                            <span class="fw-bold">
                                                @if ($item->listing_unit_id)
                                                    @lang('Listing Image')
                                                @else
                                                    @lang('Building Image')
                                                @endif
                                            </span>
                                        </td>


                                        <td>
                                            {{ $general->cur_sym . showAmount($item->building->price) }}
                                        </td>


                                        <td>
                                            <span class="fw-bold">
                                                {{ showDateTime($item->created_at) }}
                                            </span>
                                        </td>

                                        <td>
                                            <a href="{{ route('condo.building.details', building_route_params($item->building)) }}"
                                                class="btn btn--primary btn--sm">
                                                @lang('View')
                                            </a>
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
                @if ($orders->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($orders) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
