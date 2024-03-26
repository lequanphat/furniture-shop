jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        $('#create-tag-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/admin/tags',
                type: 'POST',
                data: formData,
                success: function (response) {
                    // Handle the success response
                    $('#create_response').removeClass('alert-danger d-none');
                    $('#create_response').addClass('alert-success');
                    $('#create_response').html(response.message);

                    $('#tag-table-body').append(`
                        <tr>
                            <td>${response.tag.tag_id}</td>
                            <td>${response.tag.name}</td>
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
