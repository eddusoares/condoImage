@php
    $pages = App\Models\Page::get();
    $banner = getContent('banner.content', true);
    $socials = getContent('social_icon.element');
    $contact = getContent('contact_us.content', true);
    $policyPages = getContent('policy_pages.element', false, null, true);
    $categories = App\Models\Category::where('status', 1)->inRandomOrder()->take(4)->get();
    $footerLinks = getContent('footer_company_links.element');

    $neighborhood = App\Models\Neighborhood::with(['buildings', 'county', 'buildings.neighborhood.county']);

    $allNeighborhoods = (clone $neighborhood)->where('status', 1)->get();
    $latestNeighborhoods = (clone $neighborhood)->inRandomOrder()->where('status', 1)->take(4)->get();

@endphp

<!-- ==================== Footer Start Here ==================== -->
@if (
        Route::currentRouteName() === 'user.login' ||
        Route::currentRouteName() === 'user.register' ||
        Route::currentRouteName() === 'user.password.request' ||
        Route::currentRouteName() === 'user.password.code.verify' ||
        Route::currentRouteName() === 'user.password.reset' ||
        Route::currentRouteName() === 'user.authorization'
    )
@else
    <footer class="footer-area">
        <div class="footer-divider"></div>
        <div class="footer-main">
            <div class="footer-container">
                <div class="footer-columns">
                    <div class="footer-column footer-column-brand">
                        <div class="footer-item">
                            <div class="footer-brand">
                                <a href="{{ route('home') }}" class="navbar-brand footer-logo" aria-label="CondoImage">
                                    <span class="brand-primary">CONDO</span><span class="brand-secondary">IMAGE</span>
                                </a>
                            </div>
                            <p class="footer-item__desc">{{ __($contact->data_values->website_footer ?? ($contact->data_values->footer_short_description ?? '""')) }}</p>

                            <ul class="footer-social-list">
                                <li class="footer-social-item">
                                    <a href="#" class="footer-social-link" aria-label="Facebook">
                                        <img src="{{ asset('application/assets/images/svg/facebook.svg') }}" alt="Facebook"
                                            class="footer-social-icon">
                                    </a>
                                </li>
                                <li class="footer-social-item">
                                    <a href="#" class="footer-social-link" aria-label="Instagram">
                                        <img src="{{ asset('application/assets/images/svg/instagram.svg') }}"
                                            alt="Instagram" class="footer-social-icon">
                                    </a>
                                </li>
                                <li class="footer-social-item">
                                    <a href="#" class="footer-social-link" aria-label="LinkedIn">
                                        <img src="{{ asset('application/assets/images/svg/linkedin.svg') }}" alt="LinkedIn"
                                            class="footer-social-icon">
                                    </a>
                                </li>
                                <li class="footer-social-item">
                                    <a href="#" class="footer-social-link" aria-label="X">
                                        <img src="{{ asset('application/assets/images/svg/x.svg') }}" alt="X"
                                            class="footer-social-icon">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="footer-column">
                        <div class="footer-item">
                            <h4 class="footer-item__title">@lang('Information')</h4>
                            <ul class="footer-menu">
                                @foreach ($policyPages as $item)
                                    <li class="footer-menu__item">
                                        <a href="{{ route('policy.pages', [slug($item->data_values->title), $item->id]) }}"
                                            class="footer-menu__link">{{ __($item->data_values->title) }}
                                        </a>
                                    </li>
                                @endforeach
                                <li class="footer-menu__item">
                                    <a href="{{ route('cookie.policy') }}" target="_blank"
                                        class="footer-menu__link">@lang('Cookie Policy')
                                    </a>
                                </li>
                                @foreach ($pages as $page)
                                    @if ($page->slug == 'contact')
                                        <li class="footer-menu__item"><a href="{{ route('pages', $page->slug) }}"
                                                class="footer-menu__link">{{ __($page->name) }}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="footer-column">
                        <div class="footer-item">
                            <h4 class="footer-item__title">@lang('Company')</h4>
                            <ul class="footer-menu">
                                @foreach ($footerLinks as $item)
                                    <li class="footer-menu__item"><a href="{{ $item->data_values->url }}"
                                            class="footer-menu__link">{{ __($item->data_values->title) }}</a></li>
                                @endforeach
                                @foreach ($pages as $page)
                                    @if ($page->slug != '/' && $page->slug != 'contact' && $page->slug != 'explore')
                                        <li class="footer-menu__item"><a href="{{ route('pages', $page->slug) }}"
                                                class="footer-menu__link">{{ __($page->name) }}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="footer-column">
                        <div class="footer-item">
                            <h4 class="footer-item__title">@lang('Neighborhoods')</h4>
                            <ul class="footer-menu">
                                @foreach ($latestNeighborhoods as $item)
                                    <li class="footer-menu__item">
                                        <a href="{{ route('neighborhood.details', ['county' => slug($item->county->name), 'slug' => slug($item->name), 'id' => $item->id]) }}"
                                            class="footer-menu__link">{{ $item->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Footer Top End-->
    </footer>
@endif

@push('script')
    <script>
        function showMoreBuildings(wrapperId) {
            const wrapper = document.getElementById(wrapperId);
            const hiddenItems = wrapper.querySelector('.extra-buildings');
            if (hiddenItems) {
                hiddenItems.classList.remove('d-none');

                // Hide the "View All" button after click
                const viewAllBtn = wrapper.querySelector('a.fw-bold');
                console.log(viewAllBtn);

                if (viewAllBtn) {
                    viewAllBtn.classList.add('d-none');
                }
            }
        }
    </script>
@endpush
