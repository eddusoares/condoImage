<div class="row">
    <div class="col">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.file.index') ? 'active' : '' }}"
                    href="{{ route('admin.file.index') }}">@lang('All files')
                    @if ($allFileCount)
                        <span class="badge rounded-pill bg--white text-muted">{{ $allFileCount }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.file.my.all') ? 'active' : '' }}"
                    href="{{ route('admin.file.my.all') }}">@lang('My files')
                    @if ($adminFileCount)
                        <span class="badge rounded-pill bg--white text-muted">{{ $adminFileCount }}</span>
                    @endif
                </a>
            </li>
        </ul>
    </div>
</div>
