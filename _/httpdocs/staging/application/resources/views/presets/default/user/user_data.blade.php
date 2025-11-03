@php
    $pages = App\Models\Page::get();
    $query = App\Models\Category::where('status', 1)->latest();
@endphp
@extends($activeTemplate . 'layouts.frontend')

@section('content')
    <!-- body-wrapper-start -->
    <div class="header" id="header">
        <div class="container ">
            <nav class="navbar navbar-expand-lg">
                <div class="header-menu-wrapper align-items-center d-flex">
                    <div class="logo-wrapper">
                        <a href="{{ route('home') }}" class="normal-logo" id="normal-logo">
                            <img src="{{ getImage('assets/images/general/logo1.png') }}" alt="...">
                        </a>
                    </div>
                </div>
                <form id="myForm" class="form-area d-flex" action="" method="GET">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-image ps-2"></i>
                        <p class="mx-2">@lang('Image')</p>
                    </div>
                    <div class="search">
                        <input id="searchInput" type="text" name="search" class="form--control"
                            value="{{ old('search') }}" placeholder="Search for photo">
                        <i class="fas fa-search"></i>
                    </div>
                </form>
                <button class="navbar-toggler header-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span id="hiddenNav"><i class="las la-bars"></i></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav nav-menu me-auto ps-lg-4 ps-0">
                        @foreach ($pages as $page)
                            @if ($page->slug == 'explore')
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::url() == url('/') . '/' . $page->slug ? 'active' : '' }}"
                                        href="{{ route('pages', $page->slug) }}">{{ __($page->name) }}</a>
                                </li>
                            @endif
                        @endforeach
                        @guest
                            @php
                                $categories = $query->take(3)->get();
                            @endphp
                            @foreach ($categories as $item)
                                <li class="nav-item">
                                    <a class="nav-link  {{ Request::url() == route('files.category', $item->id) }} ? 'active' : '' }}"
                                        href="{{ route('files.category', $item->id) }}">{{ __($item->name) }}</a>
                                </li>
                            @endforeach
                        @endguest
                        @auth
                            @php
                                $categories = $query->take(2)->get();
                            @endphp
                            @foreach ($categories as $item)
                                <li class="nav-item">
                                    <a class="nav-link  {{ Request::url() == route('files.category', $item->id) }} ? 'active' : '' }}"
                                        href="{{ route('files.category', $item->id) }}">{{ __($item->name) }}</a>
                                </li>
                            @endforeach
                        @endauth
                    </ul>
                    <div class="d-flex lan">
                        <i class="fas fa-globe"></i>
                        <select class="form-select langSel">
                            @foreach ($language as $item)
                                <option value="{{ $item->code }}"
                                    @if (session('lang') == $item->code) selected @endif>
                                    {{ __($item->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="login ps-lg-3 ps-0">
                        @guest
                            <a class="my-auto" href="{{ route('user.login') }}"><i
                                    class="fa-solid fa-user-large"></i>@lang('Sign In')</a>
                        @endguest

                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.home') }}">@lang('Dashboard')</a>
                            </li>
                        @endauth
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <div class="container py-100">
        <div class="table-content">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="dashboard-card-wrap mt-0">
                        <h5 class="card-title mb-3">{{ __($pageTitle) }}</h5>
                        <form method="POST" action="{{ route('user.data.submit') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-6 mb-3">
                                    <label class="form-label">@lang('First Name')</label>
                                    <input type="text" class=" form--control" name="firstname"
                                        value="{{ old('firstname') }}" required>
                                </div>

                                <div class="form-group col-sm-6 mb-3">
                                    <label class="form-label">@lang('Last Name')</label>
                                    <input type="text" class=" form--control" name="lastname"
                                        value="{{ old('lastname') }}" required>
                                </div>
                                <div class="form-group col-sm-6 mb-3">
                                    <label class="form-label">@lang('Address')</label>
                                    <input type="text" class=" form--control" name="address"
                                        value="{{ old('address') }}">
                                </div>
                                <div class="form-group col-sm-6 mb-3">
                                    <label class="form-label">@lang('State')</label>
                                    <input type="text" class=" form--control" name="state"
                                        value="{{ old('state') }}">
                                </div>
                                <div class="form-group col-sm-6 mb-3">
                                    <label class="form-label">@lang('Zip Code')</label>
                                    <input type="text" class=" form--control" name="zip"
                                        value="{{ old('zip') }}">
                                </div>

                                <div class="form-group col-sm-6 mb-3">
                                    <label class="form-label">@lang('City')</label>
                                    <input type="text" class=" form--control" name="city"
                                        value="{{ old('city') }}">
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" class="btn button w-100">
                                    @lang('Submit')
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
