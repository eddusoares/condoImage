@extends($activeTemplate . 'layouts.master')
@section('content')
    <!-- body-wrapper-start -->
    <div class="body-wrapper">
        <div class="table-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="dashboard-card-wrap mt-0">
                        <div class="table-area">
                            <div class="col-xl-12">
                                <div class="table-area">
                                    <table class="custom-table">
                                        <thead>
                                            <tr>
                                                <th>@lang('SI')</th>
                                                <th>@lang('Image')</th>
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
                                                      
                                                        @if (auth()->user()->user_type == 2 && $item->claim == 2 && $item->claim_by == 0)
                                                            <a href="{{ route('user.building.claim', $item->id) }}"
                                                                class="btn btn-secondary btn--sm">
                                                                @lang('Claim')
                                                            </a>
                                                        @endif
                                                        @if ($item->userHasClaimed($item))
                                                            <a href="{{ route('user.building.create', $item->id) }}"
                                                                class="btn btn-secondary btn--sm">
                                                                <i class="fas fa-cloud-upload-alt me-1"></i>
                                                                @lang('Upload Image')
                                                            </a>
                                                        @endif
                                                        <a href="{{ route('condo.building.details', building_route_params($item)) }}"
                                                            class="btn btn-secondary btn--sm">
                                                            @lang('View')
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
                            @if ($buildings->hasPages())
                                <div class="card-footer py-4">
                                    {{ paginateLinks($buildings) }}
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
