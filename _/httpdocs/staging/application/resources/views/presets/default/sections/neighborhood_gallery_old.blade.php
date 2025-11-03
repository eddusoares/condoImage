@php
    $neighs = App\Models\Neighborhood::with('county')
        ->where('status', 1)
        ->latest()
        ->take(6)
        ->get();
    $showMeta = $showMeta ?? false;
@endphp

<section class="neigh-section">
    <div class="container">
        <div class="section-head d-flex align-items-center justify-content-between">
            <h3>All neighborhoods / cities</h3>
            <form class="list-search d-flex align-items-center" action="{{ url('/neighborhood') }}" method="GET">
                <span class="list-search__icon"><i class="fas fa-search"></i></span>
                <input type="text" name="search" class="list-search__input" placeholder="Search"
                    value="{{ request('search') }}">
            </form>
        </div>

        <div class="row g-4 mb-5">
            @foreach ($neighs as $n)
                <div class="col-12 col-sm-6 col-lg-4">
                    @php
                        $buildingsCount = 0;
                        $imagesCount = 0;
                        if ($showMeta) {
                            $buildingsCount = method_exists($n, 'buildings') ? $n->buildings()->count() : 0;
                            try {
                                $imagesCount = App\Models\BuildingImage::whereHas('building', function ($q) use ($n) {
                                    $q->where('neighborhood_id', $n->id);
                                })->count();
                            } catch (\Throwable $e) {
                            }
                        }
                    @endphp
                    <a href="{{ route('neighborhood.details', ['county' => slug($n->county->name), 'slug' => slug($n->name), 'id' => $n->id]) }}"
                        class="neigh-card d-block {{ $showMeta ? 'with-meta' : '' }}">
                        <img class="neigh-card__img" src="{{ getImage(getFilePath('neighborhood') . '/' . $n->image) }}"
                            alt="{{ $n->name }}">
                        <div class="neigh-card__label">{{ __($n->name) }}</div>
                        @if ($showMeta)
                            <div class="neigh-card__meta">
                                <span>{{ $buildingsCount }}
                                    {{ \Illuminate\Support\Str::plural('Building', $buildingsCount) }}</span>
                                <span class="sep" aria-hidden="true"></span>
                                <span>{{ $imagesCount }} {{ \Illuminate\Support\Str::plural('image', $imagesCount) }}</span>
                            </div>
                        @endif
                    </a>
                </div>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ url('/neighborhood') }}" class="btn button">Explore all neighborhoods</a>
        </div>
    </div>
</section>