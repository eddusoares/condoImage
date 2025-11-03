@extends($activeTemplate . 'layouts.' . $layout)
@section('content')
    @auth
        <div class="body-wrapper">
            <div class="table-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="dashboard-card-wrap mt-0">
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <h5 class="text--base mt-0">
                                    @php echo $myTicket->statusBadge; @endphp
                                    [@lang('Ticket')#{{ $myTicket->ticket }}] {{ $myTicket->subject }}
                                </h5>
                                @if ($myTicket->status != 3 && $myTicket->user)
                                    <button class="btn button bg-danger border-0 close-button btn--sm confirmationBtn"
                                        type="button" data-question="@lang('Are you sure to close this ticket?')"
                                        data-action="{{ route('ticket.close', $myTicket->id) }}"><i
                                            class="fa fa-lg fa-times-circle"></i>
                                    </button>
                                @endif
                            </div>
                            @if ($myTicket->status != 4)
                                <form class="mt-3" method="post" action="{{ route('ticket.reply', $myTicket->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row justify-content-between">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea name="message" class="form--control" rows="4">{{ old('message') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end mt-3">
                                        <a href="javascript:void(0)" class="btn button btn-sm addFile"><i
                                                class="fa fa-plus"></i> @lang('Add New')</a>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label class="form-label">@lang('Attachments')</label> <small
                                            class="text-danger">@lang('Max 5 files can be uploaded'). @lang('Maximum upload size is')
                                            {{ ini_get('upload_max_filesize') }}</small>
                                        <input type="file" name="attachments[]" class="form--control" />
                                        <div id="fileUploadsContainer"></div>
                                        <p class="my-2 ticket-attachments-message text-muted">
                                            @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'),
                                            .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                        </p>
                                    </div>
                                    <div class="text-end mt-3 mb-5">
                                        <button type="submit" class="btn button"> <i class="fa fa-reply"></i>
                                            @lang('Reply')</button>
                                    </div>
                                </form>
                            @endif

                            @foreach ($messages as $message)
                                @if ($message->admin_id == 0)
                                    <div class="row border border--base rounded-2 my-3 py-3 mx-2">
                                        <div class="col-md-3 border-end text-end">
                                            <h5 class="my-3">{{ $message->ticket->name }}</h5>
                                        </div>
                                        <div class="col-md-9">
                                            <p class="text-muted fw-bold my-3">
                                                @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                            <p>{{ $message->message }}</p>
                                            @if ($message->attachments->count() > 0)
                                                <div class="mt-2">
                                                    @foreach ($message->attachments as $k => $image)
                                                        <a href="{{ route('ticket.download', encrypt($image->id)) }}"
                                                            class="me-3"><i class="fa fa-file"></i> @lang('Attachment')
                                                            {{ ++$k }} </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="row border border-danger rounded-2 my-3 py-3 mx-2"
                                        style="background-color: #ffc3c329">
                                        <div class="col-md-3 border-end text-end">
                                            <h5 class="my-3">{{ $message->admin->name }}</h5>
                                            <p class="lead text-muted">@lang('Staff')</p>
                                        </div>
                                        <div class="col-md-9">
                                            <p class="text-muted fw-bold my-3">
                                                @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                            <p>{{ $message->message }}</p>
                                            @if ($message->attachments->count() > 0)
                                                <div class="mt-2">
                                                    @foreach ($message->attachments as $k => $image)
                                                        <a href="{{ route('ticket.download', encrypt($image->id)) }}"
                                                            class="me-3"><i class="fa fa-file"></i> @lang('Attachment')
                                                            {{ ++$k }} </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endauth
    @guest
    <div class="guest-body-wrapper">
        <div class="table-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="dashboard-card-wrap mt-0">
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <h5 class="text--base mt-0">
                                @php echo $myTicket->statusBadge; @endphp
                                [@lang('Ticket')#{{ $myTicket->ticket }}] {{ $myTicket->subject }}
                            </h5>
                            @if ($myTicket->status != 3 && $myTicket->user)
                                <button class="btn button bg-danger border-0 close-button btn--sm confirmationBtn"
                                    type="button" data-question="@lang('Are you sure to close this ticket?')"
                                    data-action="{{ route('ticket.close', $myTicket->id) }}"><i
                                        class="fa fa-lg fa-times-circle"></i>
                                </button>
                            @endif
                        </div>
                        @if ($myTicket->status != 4)
                            <form class="mt-3" method="post" action="{{ route('ticket.reply', $myTicket->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row justify-content-between">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea name="message" class="form--control" rows="4">{{ old('message') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end mt-3">
                                    <a href="javascript:void(0)" class="btn button btn-sm addFile"><i
                                            class="fa fa-plus"></i> @lang('Add New')</a>
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label">@lang('Attachments')</label> <small
                                        class="text-danger">@lang('Max 5 files can be uploaded'). @lang('Maximum upload size is')
                                        {{ ini_get('upload_max_filesize') }}</small>
                                    <input type="file" name="attachments[]" class="form--control" />
                                    <div id="fileUploadsContainer"></div>
                                    <p class="my-2 ticket-attachments-message text-muted">
                                        @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'),
                                        .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                    </p>
                                </div>
                                <div class="text-end mt-3 mb-5">
                                    <button type="submit" class="btn button"> <i class="fa fa-reply"></i>
                                        @lang('Reply')</button>
                                </div>
                            </form>
                        @endif

                        @foreach ($messages as $message)
                            @if ($message->admin_id == 0)
                                <div class="row border border--base rounded-2 my-3 py-3 mx-2">
                                    <div class="col-md-3 border-end text-end">
                                        <h5 class="my-3">{{ $message->ticket->name }}</h5>
                                    </div>
                                    <div class="col-md-9">
                                        <p class="text-muted fw-bold my-3">
                                            @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                        <p>{{ $message->message }}</p>
                                        @if ($message->attachments->count() > 0)
                                            <div class="mt-2">
                                                @foreach ($message->attachments as $k => $image)
                                                    <a href="{{ route('ticket.download', encrypt($image->id)) }}"
                                                        class="me-3"><i class="fa fa-file"></i> @lang('Attachment')
                                                        {{ ++$k }} </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="row border border-danger rounded-2 my-3 py-3 mx-2"
                                    style="background-color: #ffc3c329">
                                    <div class="col-md-3 border-end text-end">
                                        <h5 class="my-3">{{ $message->admin->name }}</h5>
                                        <p class="lead text-muted">@lang('Staff')</p>
                                    </div>
                                    <div class="col-md-9">
                                        <p class="text-muted fw-bold my-3">
                                            @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                        <p>{{ $message->message }}</p>
                                        @if ($message->attachments->count() > 0)
                                            <div class="mt-2">
                                                @foreach ($message->attachments as $k => $image)
                                                    <a href="{{ route('ticket.download', encrypt($image->id)) }}"
                                                        class="me-3"><i class="fa fa-file"></i> @lang('Attachment')
                                                        {{ ++$k }} </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endguest

    <x-confirmation-modal></x-confirmation-modal>
@endsection
@push('style')
    <style>
        .input-group-text:focus {
            box-shadow: none !important;
        }
    </style>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addFile').on('click', function() {
                if (fileAdded >= 4) {
                    notify('error', 'You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                $("#fileUploadsContainer").append(`
                    <div class="input-group my-3">
                        <input type="file" name="attachments[]" class="form-control form--control" required />
                        <button class="input-group-text btn-danger remove-btn"><i class="las la-times"></i></button>
                    </div>
                `)
            });
            $(document).on('click', '.remove-btn', function() {
                fileAdded--;
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
