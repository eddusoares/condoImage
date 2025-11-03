@php
    $user = auth()->user();
@endphp
<nav class="navbar-wrapper">
    <div class="navbar-wrapper-area">
        <div class="dashboard-title-part">
            <h5 class="title">{{ __($pageTitle) }}</h5>
        </div>
        <div class="navbar__right d-flex">
          
            <ul class="navbar__action-list">
                <li class="dropdown">
                    <button type="button" data-bs-toggle="dropdown" data-display="static" aria-haspopup="true"
                        aria-expanded="false">
                        <span class="navbar-user">
                            <span class="navbar-user__thumb"><img
                                    src="{{ getImage(getFilePath('userProfile') . '/' . $user->image) }}" alt="user"></span>
                            <span class="navbar-user__info">
                                <span class="navbar-user__name">{{ $user->fullname }}</span>
                            </span>
                            <span class="icon"><i class="las la-chevron-circle-down"></i></span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu--sm p-0 border-0  dropdown-menu-right">
                        <a href="{{ route('user.profile.setting') }}"
                            class="dropdown-menu__item d-flex align-items-center ps-3 pe-3 pt-2 pb-2">
                            <i class="dropdown-menu__icon las la-user-circle"></i>
                            <span class="dropdown-menu__caption">@lang('Profile')</span>
                        </a>
                        <a href="{{ route('user.change.password') }}"
                            class="dropdown-menu__item d-flex align-items-center ps-3 pe-3 pt-2 pb-2">
                            <i class="dropdown-menu__icon las la-key"></i>
                            <span class="dropdown-menu__caption">@lang('Password')</span>
                        </a>
                        <a href="{{ route('user.twofactor') }}"
                            class="dropdown-menu__item d-flex align-items-center ps-3 pe-3 pt-2 pb-2">
                            <i class="dropdown-menu__icon las la-user-check"></i>
                            <span class="dropdown-menu__caption">@lang('2Fa Security')</span>
                        </a>
                        <a href="{{ route('user.logout') }}" class="dropdown-menu__item d-flex align-items-center ps-3 pe-3 pt-2 pb-2">
                            <i class="dropdown-menu__icon las la-sign-out-alt"></i>
                            <span class="dropdown-menu__caption">@lang('Sign Out')</span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
