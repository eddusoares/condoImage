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
                                                    <th>@lang('Type')</th>
                                                    <th>@lang('Title')</th>
                                                    <th>@lang('Mark At')</th>
                                                    <th>@lang('Action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($wishlists as $item)
                                                    <tr>
                                                        <td data-label="#" class="text-center">
                                                            {{ $loop->iteration }}
                                                        </td>

                                                        <td data-label="#" class="text-center">
                                                            {{ $item->type == 'building' ? 'Building' : 'Listing Unit' }}
                                                        </td>

                                                        <td data-label="Title" class="info">
                                                            {{ $item->buildingOrListing($item->data_id, $item->type) }}

                                                        </td>

                                                        <td data-label="Submitted On">
                                                            {{ showDateTime(@$item->created_at, 'h:i A, M Y') }}
                                                        </td>
                                                        <td data-label="Action">
                                                            <a href="{{ route('user.wishlist.delete', $item->id) }}"
                                                                class="btn button btn--danger border-0 btn--sm">
                                                                <i class="fas fa-trash me-1"></i>
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
                                        @if ($wishlists->hasPages())
                                            <div class="text-end">
                                                {{ $wishlists->links() }}
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
