@php
    $categories = App\Models\Category::where('status', 1)
        ->inRandomOrder()
        ->take(3)
        ->get();
    $collection = getContent('photo_collection.content', true);
@endphp

<!-- ==================== Collections Start ==================== -->
<section class="collections py-100">
    <div class="container">
        <div class="d-flex justify-content-between mb-4">
            <div class="title">
                <h3>{{ __($collection->data_values->heading) }}</h3>
                <p>{{ __($collection->data_values->subheading) }}</p>
            </div>
            <div>
                <a href="{{ route('explore') }}"
                    class="btn btn2 button d-lg-block d-md-block d-none">@lang('Explore collections')</a>
            </div>
        </div>
        <div class="row g-5">
            @foreach ($categories as $item)
                @php
                    $query = App\Models\File::where('status', 1)->where('category_id', $item->id);

                    $totalCount = $query->count();

                    $files = $query
                        ->latest()
                        ->take(3)
                        ->get();
                    $filesCount = $files->count();
                @endphp
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card">
                        <div class="row g-4">
                            @if ($filesCount == 0)
                                <div class="col-12">
                                    <img src="{{ getImage(getFilePath('others') . '/' . 'coming_soon.jpg') }}"
                                        class="thumb-main" alt="image">
                                </div>
                            @endif

                            @if ($filesCount == 1)
                                @foreach ($files as $file)
                                    <div class="col-12">
                                        <img src="{{ fileStorePath($file,'preview') }}"
                                            class="thumb-main" alt="image">
                                    </div>
                                    @php
                                        break;
                                    @endphp
                                @endforeach
                            @endif

                            @if ($filesCount == 2)
                                @foreach ($files as $file)
                                    <div class="col-12">
                                        <img src="{{ fileStorePath($file,'preview') }}"
                                            class="thumb-main" alt="image">
                                    </div>
                                    @php
                                        break;
                                    @endphp
                                @endforeach
                            @endif

                            @if ($filesCount > 2)
                                @foreach ($files as $file)
                                    @if ($loop->iteration == 1)
                                        <div class="col-8">
                                            <img src="{{ fileStorePath($file,'preview') }}"
                                                class="thumb-main" alt="image">
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            <div class="col-4">
                            @if ($filesCount > 2)
                                @foreach ($files as $file)
                                    @if ($loop->iteration == 2)
                                            <img src="{{ fileStorePath($file,'preview') }}"
                                                class="thumb mb-3" alt="image">
                                    @endif
                                @endforeach
                            @endif

                            @if ($filesCount > 2)
                                @foreach ($files as $file)
                                    @if ($loop->iteration == 3)
                                            <img src="{{ fileStorePath($file,'preview') }}"
                                                class="thumb mb-3" alt="image">
                                    @endif
                                @endforeach
                            @endif
                        </div>

                        </div>
                        <div class="title">
                            <a href="{{ route('files.category', $item->id) }}">{{ $item->name }}</a>
                            @if ($totalCount == 1)
                                <p>{{ $totalCount }} @lang('photo')</p>
                            @else
                                <p>{{ $totalCount }} @lang('photos')</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- ==================== Collections End ==================== -->
