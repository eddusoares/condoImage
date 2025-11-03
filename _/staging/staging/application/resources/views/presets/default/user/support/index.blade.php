@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="body-wrapper">
        <div class="table-content">
            <div class="m-0">
                <div class="list-card">
                    <div class="table-area  mt-0">
                        <div class="row justify-content-center">
                            <div class="col-xl-12">
                                <div class="text-end">
                                    <a href="{{route('ticket.open') }}" class="btn button btn--sm mb-2"> <i class="fa fa-plus"></i> @lang('New Ticket')</a>
                                </div>
                                <table class="custom-table">
                                    <thead>
                                        <tr>
                                            <th>@lang('#')</th>
                                            <th>@lang('Subject')</th>
                                            <th>@lang('Status')</th>
                                            <th>@lang('Priority')</th>
                                            <th>@lang('Last Reply')</th>
                                            <th>@lang('Action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($supports as $support)
                                            <tr>
                                                <td> {{ $loop->iteration }} </td>
                                                <td> <a href="{{ route('ticket.view', $support->ticket) }}" class="fw-bold text--base"> [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }} </a></td>
                                                <td>
                                                    @php echo $support->statusBadge; @endphp
                                                </td>
                                                <td>
                                                    @if ($support->priority == 1)
                                                        <span class="badge bg-dark">@lang('Low')</span>
                                                    @elseif($support->priority == 2)
                                                        <span class="badge bg-success">@lang('Medium')</span>
                                                    @elseif($support->priority == 3)
                                                        <span class="badge bg-primary">@lang('High')</span>
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>
            
                                                <td>
                                                    <a href="{{ route('ticket.view', $support->ticket) }}" class="btn button btn--sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    @if ($supports->hasPages())
                        <div class="text-end">
                            {{$supports->links()}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
