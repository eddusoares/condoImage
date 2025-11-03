@if (isset($breadcrumbs) && !Route::is('home'))
    <div class="container my-4">
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb">
                @foreach ($breadcrumbs as $crumb)
                    @if ($loop->last)
                        <li class="breadcrumb-item active">{{ $crumb['title'] }}</li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ $crumb['url'] }}">{{ $crumb['title'] }}</a>
                        </li>
                    @endif
                @endforeach
            </ol>
        </nav>
    </div>
@endif
