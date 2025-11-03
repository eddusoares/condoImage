@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="contact-bottom pb-100">
        <div class="container">
            <div class="image--breadcrumb position-relative">
                <div class="image--wrap mb-5">
                    <img src="{{ getImage(getFilePath('neighborhood') . '/' . $neighborhood->image) }}" alt="...">
                </div>

                <div class="content--wrap position-absolute d-flex align-items-center gap-1">

                    <p>@lang('All Buildings in') {{ $neighborhood->name }}</p>
                </div>
            </div>
            <div class="container">
                <div class="sub-content mb-4">
                    {{ __($pageTitle) }} @lang('Neighborhoods offers over') {{ $totalImages }} @lang('condo images to download from more than') {{ $totalBuildings }}
                    @lang('condo buildings')
                </div>

                <div class="row gy-5 flex-wrap-inverse">
                    @foreach ($neighborhood->buildings ?? [] as $item)
                        <div class="col-lg-4 pe-lg-5">
                            <a href="{{ route('condo.building.details', building_route_params($item)) }}">
                                <div class="bg-white rounded-lg overflow-hidden">
                                    <img src="{{ getImage(getFilePath('building') . '/' . $item->image) }}" alt="City Image"
                                        class="w-full h-48 object-cover" height="200">
                                    <div class="py-3 text-center border">
                                        <h5 class="text-start px-2 mb-1 font-semibold uppercase tracking-wider">
                                            {{ __($item->name) }}</h5>
                                        <p class="text-start px-2 mb-1 font-semibold uppercase tracking-wider">{{ __($item->address) }}
                                        </p>
                                        <hr class="m-0">
                                        <div class="d-flex justify-content-between text-sm text-gray-600 px-2 mt-2">
                                            <span>{{ $item->buildingImages->count() }} @lang('Images')</span>

                                            @if ($item->buildingListingUnits->count() > 1)
                                                <span>{{ $item->buildingListingUnits->count() }} @lang('LIstings')</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                    @if (isset($sections))
                        @if ($sections->secs != null)
                            @foreach (json_decode($sections->secs) as $sec)
                                @include($activeTemplate . 'sections.' . $sec)
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </section>


@endsection
