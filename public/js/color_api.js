jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        $('#create-color-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/admin/colors',
                type: 'POST',
                data: formData,
                success: function (response) {
                    // Handle the success response
                    $('#create_response').removeClass('alert-danger d-none');
                    $('#create_response').addClass('alert-success');
                    $('#create_response').html(response.message);

                    $('#color-table-body').append(`
                        <tr>
                            <td>${response.color.coder_id}</td>
                            <td>${response.color.name}</td>
                            <td>
                                <div class="col-auto rounded"
                                    style="background: ${response.color.code}; width: 20px; height: 20px;">
                                </div>
                            </td>
                        </tr>`);
                },
                error: function (error) {
                    // Handle the error response
                    $('#create_response').removeClass('alert-successs d-none');
                    $('#create_response').addClass('alert-danger');
                    $('#create_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });
    });
})(jQuery);
