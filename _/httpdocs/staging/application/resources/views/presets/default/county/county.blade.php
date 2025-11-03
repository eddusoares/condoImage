@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="contact-bottom pb-100">
        <div class="container">
            <div class="image--breadcrumb position-relative">
                <div class="image--wrap mb-5">
                    <img src="{{ getImage(getFilePath('county') . '/' . $county->image) }}" alt="...">
                </div>
                <div class="content--wrap position-absolute d-flex align-items-center gap-1">
                    <h6 class="mb-0">{{ __($county->name) }}</h6> <span>/</span>
                    <p>@lang('Neighborhoods Listing')</p>
                </div>
            </div>

            <div class="sub-content mb-4">
                @lang('Download over') {{ $totalImages }} @lang('images from more than') {{ $totalBuildings }} @lang('condo buildings in over')
                {{ $neighborhoods->count() }} @lang('neighborhoods') / {{ __($county->name) }}
            </div>
            <div class="row mb-5 gy-5">
                @foreach ($neighborhoods as $item)
                    <div class="col-lg-4">
                        <a href="{{ route('neighborhood.details', ['county' => slug($item->county->name),'slug' => slug($item->name), 'id' => $item->id]) }}">
                            <div class="bg-white rounded-lg overflow-hidden">
                                <img src="{{ getImage(getFilePath('neighborhood') . '/' . $item->image) }}" alt="City Image"
                                    class="w-full h-48 object-cover" height="200">
                                <div class="py-3 text-center border">
                                    <h5 class="text-start px-2 mb-1 font-semibold uppercase tracking-wider">
                                        {{ __($item->name) }}
                                    </h5>
                                    <hr class="m-0">
                                    <div class="d-flex justify-content-between text-sm text-gray-600 mt-2 px-2">
                                        <span>{{ $item->buildings->count() }} @lang('Buildings')</span>
                                        <span>{{ $item->total_building_images_count + $item->total_listing_images_count }}
                                            @lang('Images')</span>

                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                @if ($neighborhoods->hasPages())
                    <div class="row justify-content-center mt-5">
                        <div class="col-lg-6">
                            <div class="card-footer py-4">
                                {{ paginateLinks($neighborhoods) }}
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
