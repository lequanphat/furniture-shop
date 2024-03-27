jQuery.noConflict();

(function($) {
    $(document).ready(function() {


        $('#create-discount-form').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/admin/discounts/create',
                type: 'POST',
                data: formData,

            });
        });

        $('.js-update-discount-btn').on('click', function() {
            $('#modal-discount-update #discount_id').val($(this).data('discount-id'))
            $('#modal-discount-update #title').val($(this).data('title'));
            $('#modal-discount-update #editor').val($(this).data('description'));
            $('#modal-discount-update #amount').val($(this).data('amount'));
            $('#modal-discount-update #startdate').val($(this).data('start-date'));
            $('#modal-discount-update #enddate').val($(this).data('end-date'));
            $('#modal-discount-update #percentage').val($(this).data('percentage'));
            $('#modal-discount-update #active').val($(this).data('is-active'));
        });



        $('#Update-discount-form').submit(function(e)
        {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/admin/discounts/update',
                type: 'PATCH',
                data: formData,

            });
        })

    });
})(jQuery);
