@php
    $counties = App\Models\County::with('neighborhoods')
        ->where('status', 1)
        ->orderBy('id', 'desc')
        ->paginate(getPaginate(20));
@endphp
<!-- ==================== categories item Start ==================== -->
<section class="categories-item pb-100">
    <div class="container">
        <div class="row mb-5 gy-5">
            @foreach ($counties as $item)
                <div class="col-lg-4">
                    <a href="{{ route('county', ['slug' => slug($item->name), 'id' => $item->id]) }}">
                        <div class="bg-white rounded-lg overflow-hidden">
                            <img src="{{ getImage(getFilePath('county') . '/' . $item->image) }}" alt="City Image"
                                class="w-full h-48 object-cover" height="200">
                            <div class="py-3 text-center border">
                                <h5 class="text-start px-2 mb-1 font-semibold uppercase tracking-wider">
                                    {{ __($item->name) }}
                                </h5>
                                <hr class="m-0">
                                <div class="d-flex justify-content-between text-sm text-gray-600 mt-2 px-2">
                                    <span>{{ $item->neighborhoods->count() }} @lang('Buildings')</span>

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        @if ($counties->hasPages())
            <div class="row justify-content-center mt-5">
                <div class="col-lg-6">
                    <div class="card-footer py-4">
                        {{ paginateLinks($counties) }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
<!-- ==================== categories End ==================== -->
