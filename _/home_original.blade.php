@php
    $pages = App\Models\Page::orderBy('id', 'desc')->get();
    $allNeighborhoods = App\Models\Neighborhood::with('buildings')->where('status', 1)->get();
@endphp
@extends($activeTemplate . 'layouts.frontend')
@section('content')

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
            @if ($sec === 'work_process')
                @include($activeTemplate . 'sections.neighborhood_gallery')
            @endif
        @endforeach
    @endif


@endsection

@push('script')
    <script>
        $(document).on('click', '.myGuestWishlistButton', function () {
            window.location.href = "{{ route('user.login') }}";
        });
    </script>

    <script>
        $(document).on('click', '.markWishlist', function (e) {
            e.preventDefault();
            var file_id = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('user.add.wishlist') }}",
                method: "POST",
                data: {
                    file_id: file_id
                },
                success: function (response) {
                    if (response.status == 'success') {
                        $('.markWishlist[value="' + file_id + '"]').addClass('text--danger');
                        $('.markWishlist[value="' + file_id + '"]').removeClass('text--white');
                        notify('success', response.message);
                    } else {
                        notify('error', response.message);
                    }
                }
            });
        });

        $(document).on('click', '.removeWishlist', function (e) {
            e.preventDefault();
            var file_id = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('user.remove.wishlist') }}",
                method: "POST",
                data: {
                    file_id: file_id
                },
                success: function (response) {
                    if (response.status == 'success') {
                        $('.markWishlist[value="' + file_id + '"]').removeClass('text--danger');
                        $('.markWishlist[value="' + file_id + '"]').addClass('text--white');
                        notify('success', response.message);
                    } else {
                        notify('error', response.message);
                    }
                }
            });
        });
    </script>
@endpush