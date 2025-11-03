<div class="row">
    <div class="col">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.listing.asset.index') ? 'active' : '' }}"
                    href="{{route('admin.listing.asset.index')}}">@lang('All')
                    @if($allListing)
                    <span class="badge rounded-pill bg--white text-muted">{{$allListing}}</span>
                    @endif
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.listing.asset.pending') ? 'active' : '' }}"
                    href="{{route('admin.listing.asset.pending')}}">@lang('Pending')
                    @if($pendingListingImages)
                    <span class="badge rounded-pill bg--white text-muted">{{$pendingListingImages}}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.listing.asset.active') ? 'active' : '' }}"
                    href="{{route('admin.listing.asset.active')}}">@lang('Active')
                    @if($activeListingImages)
                    <span class="badge rounded-pill bg--white text-muted">{{$activeListingImages}}</span>
                    @endif
                </a>
            </li>
        </ul>
    </div>
</div>