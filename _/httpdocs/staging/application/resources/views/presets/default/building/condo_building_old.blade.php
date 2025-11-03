@extends($activeTemplate . 'layouts.frontend')
@section('content')

    <section class="contact-bottom pb-100">
        <div class="container">
            @if ($buildings->isNotEmpty())
                <div class="image--breadcrumb position-relative">
                    <div class="image--wrap mb-5">
                        <img src="{{ getImage(getFilePath('building') . '/' . $buildings->first()->image) }}" alt="...">
                    </div>

                    <div class="content--wrap position-absolute d-flex align-items-center gap-1">
                        @if (!Route::is('condo.building'))
                            <h6 class="mb-0">@lang('Cites')</h6> <span>/</span>
                        @endif
                        <p>@lang('Condos Buildings')</p>
                    </div>
                </div>

                <div class="sub-content mb-4">
                    @lang('Instant access to high-quality images and photos from over') {{ $buildings->count() }} @lang('buildingc across') {{ $uniqueNeighborhoodCount . '+' }}
                    @lang('neighborhoods. Includes condos, apartments,common areas, drone aerials, rederings, floor plans, and more. Ideal for real estate agents, social media posts, and markets.')
                </div>
            @endif
            <div class="row mb-5 gy-5">
                @forelse ($buildings as $item)
                    <div class="col-lg-4">
                        <a href="{{ route('condo.building.details', building_route_params($item)) }}">
                            <div class="bg-white rounded-lg overflow-hidden">
                                <img src="{{ getImage(getFilePath('building') . '/' . $item->image) }}" alt="City Image"
                                    class="w-full h-48 object-cover" height="200">
                                <div class="py-3 text-center border">
                                    <h5 class="text-start px-2 mb-1 font-semibold uppercase tracking-wider">
                                        {{ __($item->name) }}
                                    </h5>
                                    <hr class="m-0">
                                    <div class="d-flex justify-content-between text-sm text-gray-600 mt-2 px-2">
                                        <span>{{ $item->building_images_count }} @lang('Images')</span>
                                        <span>{{ $item->building_listing_units_count }}
                                            @lang('Listings')</span>

                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="text-center">@lang('No data found')</div>
                @endforelse
                @if ($buildings->hasPages())
                    <div class="row justify-content-center mt-5">
                        <div class="col-lg-6">
                            <div class="card-footer py-4">
                                {{ paginateLinks($buildings) }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </section>


    @if (isset($sections))
        @if ($sections->secs != null)
            @foreach (json_decode($sections->secs) as $sec)
                @include($activeTemplate . 'sections.' . $sec)
            @endforeach
        @endif
    @endif
@endsection
