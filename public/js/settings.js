jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        $('#update-profile-form').submit(function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            $.ajax({
                url: '/admin/settings/profile',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    console.log({ response });
                    $('#update_response').removeClass('d-none');
                    $('#update_response').removeClass('alert-danger');
                    $('#update_response').addClass('alert-success');
                    $('#update_response').html(response.message);
                },
                error: function (error) {
                    console.log({ error });
                    $('#update_response').removeClass('d-none');
                    $('#update_response').removeClass('alert-success');
                    $('#update_response').addClass('alert-danger');
                    $('#update_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });

        $('#avatar-input').change(function (e) {
            console.log('hello');
            $('#avatar-image').css('background-image', `url(${URL.createObjectURL(e.target.files[0])})`);
        });

        $('#change-password-form').submit(function (e) {
            e.preventDefault();
            const formData = $(this).serialize();
            $.ajax({
                url: '/admin/settings/change-password',
                type: 'POST',
                data: formData,
                success: function (response) {
                    console.log({ response });
                    $('#update_response').removeClass('d-none');
                    $('#update_response').removeClass('alert-danger');
                    $('#update_response').addClass('alert-success');
                    $('#update_response').html(response.message);
                },
                error: function (error) {
                    console.log({ error });
                    $('#update_response').removeClass('d-none');
                    $('#update_response').removeClass('alert-success');
                    $('#update_response').addClass('alert-danger');
                    $('#update_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });
    });
})(jQuery);
