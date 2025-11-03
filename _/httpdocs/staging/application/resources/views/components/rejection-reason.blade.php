<div id="rejectionReasonModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Rejection Reason')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <p class="reason p-3"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn button btn--sm" data-bs-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        (function($) {
            "use strict";
            $(document).on('click', '.rerectionBtn', function() {
                var modal = $('#rejectionReasonModal');
                let data = $(this).data();
                console.log(data);
                modal.find('.reason').text(`${data.reason}`);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
