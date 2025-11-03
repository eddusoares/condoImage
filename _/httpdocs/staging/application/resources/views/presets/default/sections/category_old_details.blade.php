@php
    $buildingsData = App\Models\Building::with(['neighborhood', 'buildingImages'])
        ->where('status', 1)
        ->latest()
        ->take(6)
        ->get();
    $showMeta = $showMeta ?? false;
    $customTitle = $customTitle ?? 'All buildings';
@endphp
<!-- ==================== categories item Start ==================== -->
<section class="neigh-section">
    <div class="container">
        <div class="section-head d-flex align-items-center justify-content-between">
            <h3>{{ $customTitle }}</h3>
            <form class="list-search d-flex align-items-center" action="{{ route('search.building') }}" method="GET">
                <span class="list-search__icon"><i class="fas fa-search"></i></span>
                <input type="text" name="search" class="list-search__input" placeholder="Search"
                    value="{{ request('search') }}">
            </form>
        </div>

        <div class="row g-4 mb-5">
            @foreach ($buildingsData as $item)
                <div class="col-12 col-sm-6 col-lg-4">
                    @php
                        $imagesCount = 0;
                        $listingsCount = 0;
                        if ($showMeta) {
                            $imagesCount = $item->buildingImages ? $item->buildingImages->count() : rand(15, 50);
                            $listingsCount = rand(5, 25); // Placeholder para listings
                        }
                    @endphp
                    <a href="{{ route('condo.building.details', building_route_params($item)) }}"
                        class="neigh-card d-block {{ $showMeta ? 'with-meta' : '' }}">
                        <img class="neigh-card__img" src="{{ getImage(getFilePath('building') . '/' . $item->image) }}"
                            alt="{{ $item->name }}">
                        <div class="neigh-card__label">{{ __($item->name) }}</div>
                        @if ($showMeta)
                            <div class="neigh-card__meta">
                                <span class="meta-left">{{ $imagesCount }}
                                    {{ \Illuminate\Support\Str::plural('Image', $imagesCount) }}</span>
                                <span class="sep" aria-hidden="true"></span>
                                <span class="meta-right">{{ $listingsCount }}
                                    {{ \Illuminate\Support\Str::plural('Listing', $listingsCount) }}</span>
                            </div>
                        @endif
                    </a>
                </div>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ route('condo.building') }}" class="btn button">Explore all buildings</a>
        </div>
    </div>
</section>
<!-- ==================== categories End ==================== -->