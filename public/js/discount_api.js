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
                success :function(response)
                {
                    $('#create_discount_response').removeClass('alert-danger d-none');
                    $('#create_discount_response').addClass('alert-success');
                    $('#create_discount_response').html(response.message);
                },
                error:function(error)
                {
                    $('#create_discount_response').removeClass('alert-success d-none');
                    $('#create_discount_response').addClass('alert-danger');
                    $('#create_discount_response').html(Object.values(error.responseJSON.errors)[0][0]);
                }

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
                success :function(response)
                {
                    $('#update_discount_response').removeClass('alert-danger d-none');
                    $('#update_discount_response').addClass('alert-success');
                    $('#update_discount_response').html(response.message);
                },
                error:function(error)
                {
                    $('#update_discount_response').removeClass('alert-success d-none');
                    $('#update_discount_response').addClass('alert-danger');
                    $('#update_discount_response').html(Object.values(error.responseJSON.errors)[0][0]);
                }

            });
        })

    });
})(jQuery);
