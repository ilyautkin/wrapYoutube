if(window.jQuery){
    if ($(document).modal) {
        $('.WY_modal').on('show.bs.modal', function (e) {
            $(this).find('.WY_body').html('<iframe src="'+$(this).data('embed')+'" class="WY_iframe" width="600" height="450"></iframe>');
        })
        $('.WY_modal').on('hidden.bs.modal', function (e) {
            $(this).find('.WY_iframe').remove();
        })
    }
}