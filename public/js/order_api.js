jQuery.noConflict();
(function ($) {
    $(document).ready(function(){
        //hàm tạo order
        $('#js-create-order-btn').click(() => {
            $('#createEmployeeModal').modal('show');
            $('#create-order-form')[0].reset();
            // $('#create_category_response').html('');
            // $('#create_category_response').removeClass('alert-success alert-danger');
        });

        $('#create-order-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/admin/orders/create',
                type: 'POST',
                data: formData,
                success: function (response) {
                    console.log(response); alert("success");
                    $('#create_order_response').removeClass('alert-danger');
                    $('#create_order_response').addClass('alert-success');
                    $('#create_order_response').html(response.message);
                },
                error: function (error) {
                    console.log(error);     alert("fail");
                    $('#create_order_response').removeClass('alert-success');
                    $('#create_order_response').addClass('alert-danger');
                    $('#create_order_response').html(Object.values(error.responseJSON.errors)[0][0]);
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
