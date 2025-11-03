@php
    $counties = App\Models\County::with('neighborhoods')
        ->where('status', 1)
        ->orderBy('id', 'desc')
        ->paginate(getPaginate(20));
@endphp
<!-- ==================== categories item Start ==================== -->
<section class="categories-item">
    <div class="container">
        <div class="section-head d-flex align-items-center justify-content-between">
            <h3>All buildings</h3>
            <form class="list-search d-flex align-items-center" action="{{ route('search.building') }}" method="GET">
                <span class="list-search__icon"><i class="fas fa-search"></i></span>
                <input type="text" name="search" class="list-search__input" placeholder="Search"
                    value="{{ request('search') }}">
            </form>
        </div>

        <div class="row mb-5 gy-5">
            @foreach ($counties as $item)
                @if ($loop->iteration > 6)
                    @break
                @endif
                <div class="col-lg-4">
                    <a href="{{ route('county', ['slug' => slug($item->name), 'id' => $item->id]) }}">
                        <div class="building-card">
                            <img src="{{ getImage(getFilePath('county') . '/' . $item->image) }}" alt="City Image"
                                class="building-card__img">
                            <div class="building-card__label">{{ __($item->name) }}</div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ route('condo.building') }}" class="btn button">Explore all buildings</a>
        </div>
        @if ($counties->hasPages())
            <div class="row justify-content-center" style="margin-top: 60px;">
                <div class="col-lg-8">
                    <div class="text-center">
                        {{ paginateLinks($counties) }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
<!-- ==================== categories End ==================== -->