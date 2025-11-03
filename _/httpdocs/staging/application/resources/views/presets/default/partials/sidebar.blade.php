<div class="sidebar">
    <div class="sidebar__inner">
        <div class="sidebar-top-inner">
            <div class="sidebar__logo">
                <a href="{{ route('home') }}" class="sidebar__main-logo">
                    <img src="{{ getImage('assets/images/general/logo1.png') }}" alt="logo">
                </a>
                <div class="navbar__left">
                    <button class="navbar__expand">
                        <i class="fas fa-bars"></i>
                    </button>
                    <button class="sidebar-mobile-menu">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
            <div class="sidebar__menu-wrapper">
                <ul class="sidebar__menu p-0">
                    <li class="sidebar-menu-item {{ Route::is('user.home') ? 'active' : '' }}">
                        <a href="{{ route('user.home') }}">
                            <i class="menu-icon fas fa-tachometer-alt"></i>
                            <span class="menu-title">@lang('Dashboard')</span>
                        </a>
                    </li>
                    @if (auth()->user()->user_type == 2)
                        {{-- <li class="sidebar-menu-item {{ Route::is('user.category.index') ? 'active' : '' }}">
                            <a href="{{ route('user.category.index') }}">

                                <i class="menu-icon fas fa-boxes"></i>
                                <span class="menu-title">@lang('Categories')</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item {{ Route::is('user.state.index') ? 'active' : '' }}">
                            <a href="{{ route('user.state.index') }}">
                                <i class="menu-icon fas fa-flag"></i>
                                <span class="menu-title">@lang('State')</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item {{ Route::is('user.county.index') ? 'active' : '' }}">
                            <a href="{{ route('user.county.index') }}">
                                <i class="menu-icon fas fa-globe-americas"></i>
                                <span class="menu-title">@lang('County')</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item {{ Route::is('user.neighborhood.index') ? 'active' : '' }}">
                            <a href="{{ route('user.neighborhood.index') }}">
                                <i class="menu-icon fas fa-network-wired"></i>
                                <span class="menu-title">@lang('Neighborhood')</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item {{ Route::is('user.image.category.index') ? 'active' : '' }}">
                            <a href="{{ route('user.image.category.index') }}">
                                <i class="menu-icon  fas fa-photo-video"></i>
                                <span class="menu-title">@lang('Image Category')</span>
                            </a>
                        </li>

                        --}}

                        @if (auth()->user()->kv != 1)
                            <li class="sidebar-menu-item {{ Route::is('user.kyc.form') ? 'active' : '' }}">
                                <a href="{{ route('user.kyc.form') }}">
                                    <i class="menu-icon fas fa-file-image"></i>
                                    <span class="menu-title">@lang('KYC Form')</span>
                                </a>
                            </li>
                        @endif

                        <li class="sidebar-menu-item {{ Route::is('user.kyc.data') ? 'active' : '' }}">
                            <a href="{{ route('user.kyc.data') }}">
                                <i class="menu-icon fas fa-file-image"></i>
                                <span class="menu-title">@lang('KYC Data')</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->user_type == 1)
                        <li class="sidebar-menu-item {{ Route::is('user.order') ? 'active' : '' }}">
                            <a href="{{ route('user.order') }}">
                                <i class="menu-icon fas fa-shopping-bag"></i>
                                <span class="menu-title">@lang('My Orders')</span>
                            </a>
                        </li>
                    @endif
                    <li class="sidebar-menu-item {{ Route::is('user.building.index') ? 'active' : '' }}">
                        <a href="{{ route('user.building.index') }}">
                            <i class="menu-icon fas fa-city"></i>
                            <span class="menu-title">@lang('Buildings')</span>
                        </a>
                    </li>
                    @if (auth()->user()->user_type == 2)
                        <li class="sidebar-menu-item {{ Route::is('user.listing.asset.my.list') ? 'active' : '' }}">
                            <a href="{{ route('user.listing.asset.my.list') }}">
                                <i class="menu-icon fas fa-th-list"></i>
                                <span class="menu-title">@lang('Listing Image')</span>
                            </a>
                        </li>
                    @endif



                    <li class="sidebar-menu-item {{ Route::is('user.wishlist') ? 'active' : '' }}">
                        <a href="{{ route('user.wishlist') }}">
                            <i class="menu-icon fas fa-heart"></i>
                            <span class="menu-title">@lang('Wishlist')</span>
                        </a>
                    </li>
                    @if (auth()->user()->user_type == 1)
                        <li class="sidebar-menu-item {{ Route::is('user.deposit.history') ? 'active' : '' }}">
                            <a href="{{ route('user.deposit.history') }}">
                                <i class="menu-icon fas fa-hand-holding-usd"></i>
                                <span class="menu-title">@lang('Payouts')</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->user_type == 2)
                        <li class="sidebar-menu-item {{ Route::is('user.withdraw.history') ? 'active' : '' }}">
                            <a href="{{ route('user.withdraw.history') }}">
                                <i class="menu-icon fas fa-wallet"></i>
                                <span class="menu-title">@lang('Withdrawals')</span>
                            </a>
                        </li>
                    @endif
                    <li class="sidebar-menu-item {{ Route::is('user.transactions') ? 'active' : '' }}">
                        <a href="{{ route('user.transactions') }}">
                            <i class="menu-icon fas fa-coins"></i>
                            <span class="menu-title">@lang('Transactions')</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item {{ Route::is('ticket') ? 'active' : '' }}">
                        <a href="{{ route('ticket') }}">
                            <i class="menu-icon fas fa-life-ring"></i>
                            <span class="menu-title">@lang('Support Tickets')</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="sidebar-support-box d-grid align-items-center bg-img"
            data-background="{{ getImage(getFilePath('others') . '/' . 'sidebar-bg.png') }}">
            <div class="sidebar-support-icon">
                <i class="fas fa-question-circle"></i>
            </div>
            <div class="sidebar-support-content">
                <h4 class="title">@lang('Need Help')?</h4>
                <p>@lang('Please contact our support.')</p>
                <div class="sidebar-support-btn">
                    <a href="{{ route('ticket.open') }}" class="btn button w-100 mt-2">@lang('New Ticket')</a>
                </div>
            </div>
        </div>
    </div>
</div>
