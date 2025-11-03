<div class="row">
    <div class="col">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.review.pending') ? 'active' : '' }}"
                    href="{{ route('admin.review.pending') }}">@lang('Pending')
                    @if ($filePendingCount)
                        <span class="badge rounded-pill bg--white text-muted">{{ $filePendingCount }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.review.on.reviewing') ? 'active' : '' }}"
                    href="{{ route('admin.review.on.reviewing') }}">@lang('On Reviewing')
                    @if ($fileOnReviewingCount)
                        <span class="badge rounded-pill bg--white text-muted">{{ $fileOnReviewingCount }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.review.published') ? 'active' : '' }}"
                    href="{{ route('admin.review.published') }}">@lang('Published')
                    @if ($filePublishedCount)
                        <span class="badge rounded-pill bg--white text-muted">{{ $filePublishedCount }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.review.rejected') ? 'active' : '' }}"
                    href="{{ route('admin.review.rejected') }}">@lang('Rejected')
                    @if ($fileRejectedCount)
                        <span class="badge rounded-pill bg--white text-muted">{{ $fileRejectedCount }}</span>
                    @endif
                </a>
            </li>
        </ul>
    </div>
</div>
