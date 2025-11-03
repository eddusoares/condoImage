@php
    $pages = App\Models\Page::orderBy('id', 'desc')->get();
@endphp
@extends($activeTemplate . 'layouts.frontend')


@section('content')

    @if (isset($sections) && $sections && $sections->secs)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
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
            var button = $(this);
            $.ajax({
                url: "{{ route('user.mark.wishlist') }}",
                data: {
                    file_id: file_id,
                },
                method: "GET",
                success: function (data) {
                    if (data.status == true) {
                        var innerData = `<i class="fas fa-heart text--base"></i>@lang('Added')`;
                        button.html(innerData);
                        Toast.fire({
                            icon: 'success',
                            title: 'Successfully set this image to your wishlist.'
                        })
                        return false;
                    }

                    if (data.status == false) {
                        var innerData = `<i class="fas fa-heart"></i>@lang('Add')`;
                        button.html(innerData);
                        Toast.fire({
                            icon: 'success',
                            title: 'Successfully removed this image from your wishlist.'
                        })
                        return false;
                    }

                    if (data.auth == false) {
                        window.location.href = "{{ route('user.login') }}";
                    }
                },
                error: function (xhr, status, error) { },
            });

        });
    </script>

    <script>
        $(document).ready(function () {
            'use strict';
            $('#searchInput').keypress(function (e) {
                if (e.which === 13) {
                    e.preventDefault();
                    $('#myForm').submit();
                }
            });
        });
    </script>

    <!-- Top Categories Carousel Script -->
    <script src="{{ asset($activeTemplateTrue . 'js/simplified_carousel_script.js') }}"></script>
@endpush


