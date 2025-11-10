@php
    $pages = App\Models\Page::orderBy('id', 'desc')->get();
@endphp
@extends($activeTemplate . 'layouts.frontend')


@section('content')

    @if (isset($sections) && $sections && $sections->secs)
        @foreach (json_decode($sections->secs) as $sectionIndex => $sec)
            <div id="{{ $sec }}" data-section="{{ $sec }}" data-index="{{ $sectionIndex + 1 }}">
                @include($activeTemplate . 'sections.' . $sec)
            </div>
        @endforeach
    @endif


@endsection

@push('script')
    <script>
        $(document).on('click', '.myGuestWishlistButton', function () {
            window.location.href = "{{ baseRoute('user.login') }}";
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
                        window.location.href = "{{ baseRoute('user.login') }}";
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
    <script src="{{ baseAsset($activeTemplateTrue . 'js/simplified_carousel_script.js') }}"></script>

    <!-- Section Anchor Navigation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Section anchor navigation system
            function findSectionByHash(hash) {
                if (!hash) return null;
                
                // Remove # and normalize
                const target = hash.substring(1).trim().toLowerCase();
                if (!target) return null;
                
                // Priority 1: Try exact section name match
                let element = document.getElementById(target);
                if (element) return element;
                
                // Priority 2: Try data-section attribute match
                element = document.querySelector(`[data-section="${target}"]`);
                if (element) return element;
                
                // Priority 3: If it's a number, try section-{number} format
                if (/^\d+$/.test(target)) {
                    element = document.getElementById(`section-${target}`);
                    if (element) return element;
                    
                    // Try by data-index
                    element = document.querySelector(`[data-index="${target}"]`);
                    if (element) return element;
                }
                
                return null;
            }
            
            function scrollToSection(element) {
                if (!element) return;
                
                // Calculate header offset (adjust as needed)
                const headerHeight = 80;
                const elementTop = element.getBoundingClientRect().top + window.pageYOffset;
                const offsetTop = elementTop - headerHeight;
                
                // Smooth scroll to section
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
            
            function navigateToHash(hash) {
                if (!hash) return;
                // Wait for potential dynamic content
                let attempts = 0;
                const maxAttempts = 20; // 2 seconds max

                function tryScroll() {
                    const element = findSectionByHash(hash);
                    if (element) {
                        scrollToSection(element);
                        return;
                    }

                    attempts++;
                    if (attempts < maxAttempts) {
                        setTimeout(tryScroll, 100);
                    }
                }

                tryScroll();
            }

            function handleAnchorNavigation() {
                const hash = window.location.hash;
                if (hash) navigateToHash(hash);
            }
            
            // Handle initial load
            handleAnchorNavigation();
            
            // Handle hash changes
            window.addEventListener('hashchange', handleAnchorNavigation);
            
            // Handle dynamic content loading
            document.addEventListener('contentLoaded', handleAnchorNavigation);

            // Reprocess clicks on same-hash links (smooth re-scroll)
            document.addEventListener('click', function (e) {
                const link = e.target.closest('a[href*="#"]');
                if (!link) return;
                const url = new URL(link.getAttribute('href'), window.location.origin);
                if (url.pathname !== window.location.pathname) return; // only same-page hashes
                if (!url.hash) return;
                if (url.hash === window.location.hash) {
                    e.preventDefault();
                    navigateToHash(url.hash);
                }
            });
        });
    </script>
@endpush


