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
@if (Route::currentRouteName() === 'user.login' ||
        Route::currentRouteName() === 'user.register' ||
        Route::currentRouteName() === 'user.password.request' ||
        Route::currentRouteName() === 'user.password.code.verify' ||
        Route::currentRouteName() === 'user.password.reset' ||
        Route::currentRouteName() === 'user.authorization')
@else
    <section class="contact-bottom pb-60">
        <div class="container">
            <div class="row gy-5 flex-wrap-reverse">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="text-center mt-5">@lang('Featured Condos')</h2>
                            <div class="condo--features">
                                @foreach ($allNeighborhoods as $neighborhood)
                                    @if ($neighborhood->buildings->count() > 0)
                                        <h5 class="mb-2 mt-4">{{ __($neighborhood->name) }}</h5>
                                        @php
                                            $neighborhoodId = 'neighborhood_' . $neighborhood->id;
                                            $buildings = $neighborhood->buildings;
                                        @endphp
                                        <ul class="d-flex flex-wrap gap-2" id="{{ $neighborhoodId }}">
                                            @foreach ($buildings->take(15) as $index => $item)
                                                <li>
                                                    <a href="{{ route('condo.building.details', building_route_params($item)) }}"
                                                        class="d-flex align-items-center"><i class="fas fa-circle"></i>
                                                        {{ __($item->name) }}</a>
                                                </li>
                                            @endforeach

                                            {{-- Hidden remaining buildings --}}
                                            <div class="d-none extra-buildings d-flex gap-2">
                                                @foreach ($buildings->slice(15) as $item)
                                                    <li>
                                                        <a href="{{ route('condo.building.details', building_route_params($item)) }}"
                                                            class="d-flex align-items-center">
                                                            <i class="fas fa-circle"></i> {{ __($item->name) }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </div>

                                            {{-- View All Button --}}
                                            @if ($buildings->count() > 15)
                                                <li>
                                                    <a href="javascript:void(0);"
                                                        onclick="showMoreBuildings('{{ $neighborhoodId }}')"
                                                        class="d-flex align-items-center fw-bold">
                                                        <i class="fas fa-circle"></i>
                                                        @lang('View All')
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer-area">
        <div class="pb-60 pt-120">
            <div class="container">
                <div class="row justify-content-center gy-5">
                    <div class="col-xl-3 col-sm-6">
                        <div class="footer-item">
                            <div>
                                <h5>@lang('About Us')</h5>
                            </div>
                            <p class="footer-item__desc">{{ __($contact->data_values->footer_short_description) }}</p>
                            <ul class="social-list">
                                @foreach ($socials as $item)
                                    <li class="social-list__item"><a href="{{ $item->data_values->url }}"
                                            class="social-list__link {{ $loop->iteration === 2 ? 'active' : '' }}">@php echo $item->data_values->social_icon; @endphp</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="footer-item">
                            <h5 class="footer-item__title">@lang('Information')</h5>
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
                    <div class="col-xl-3 col-sm-6">
                        <div class="footer-item">
                            <h5 class="footer-item__title">@lang('Company')</h5>
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
                    <div class="col-xl-3 col-sm-6">
                        <div class="footer-item">
                            <h5 class="footer-item__title">@lang('Neighborhoods')</h5>
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

        <!-- bottom Footer -->
        <div class="bottom-footer py-3">
            <div class="container">
                <div class="row gy-3">
                    <div class="col-md-12 text-center">
                        <div class="bottom-footer-text">@php echo $contact->data_values->website_footer; @endphp</div>
                    </div>
                </div>
            </div>
        </div>

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
