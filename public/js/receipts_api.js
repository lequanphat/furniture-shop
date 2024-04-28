jQuery.noConflict();

(function ($) {
    $(document).ready(function () {
        $('#create-receipts-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/admin/receipts/create',
                type: 'POST',
                data: formData,
                success: function (response) {
                    console.log(response);
                    $('#create_receipts_response').removeClass('d-none');
                    $('#create_receipts_response').removeClass('alert-danger');
                    $('#create_receipts_response').addClass('alert-success');
                    $('#create_receipts_response').html(response.message);
                },
                error: function (error) {
                    console.log(error);
                    $('#create_receipts_response').removeClass('d-none');
                    $('#create_receipts_response').removeClass('alert-success');
                    $('#create_receipts_response').addClass('alert-danger');
                    $('#create_receipts_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });
        $('#create-order-form').on('reset', function () {
            $('#create_order_response').html('');
            $('#create_order_response').removeClass('alert-success alert-danger');
            $('#create_order_response').addClass('d-none');
        });
    });
})(jQuery);