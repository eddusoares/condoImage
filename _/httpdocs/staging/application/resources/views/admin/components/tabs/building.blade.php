<div class="row">
    <div class="col">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.building.index') ? 'active' : '' }}"
                    href="{{route('admin.building.index')}}">@lang('All')
                    @if($allBuildings)
                    <span class="badge rounded-pill bg--white text-muted">{{$allBuildings}}</span>
                    @endif
                </a>
            </li>
          
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.building.pending') ? 'active' : '' }}"
                    href="{{route('admin.building.pending')}}">@lang('Pending')
                    @if($pendingBuildings)
                    <span class="badge rounded-pill bg--white text-muted">{{$pendingBuildings}}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.building.active') ? 'active' : '' }}"
                    href="{{route('admin.building.active')}}">@lang('Active')
                    @if($activeBuildings)
                    <span class="badge rounded-pill bg--white text-muted">{{$activeBuildings}}</span>
                    @endif
                </a>
            </li>
        </ul>
    </div>
</div>