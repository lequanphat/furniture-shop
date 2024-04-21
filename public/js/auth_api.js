jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        $('#login-form input').on('input', function () {
            $('#js-login-error').addClass('d-none');
        });
        // login form
        $('#login-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/login',
                method: 'POST',
                data: formData,
                success: function (response) {
                    window.location.href = '/';
                },
                error: function (error) {
                    console.log('====================================');
                    console.log(error);
                    console.log('====================================');
                    $('#js-login-error').removeClass('d-none');
                    $('#js-login-error').html('*' + Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });

        $('#register-form input').on('input', function () {
            $('#js-register-error').addClass('d-none');
        });
        // register form
        $('#register-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/register',
                method: 'POST',
                data: formData,
                success: function (response) {
                    window.location.href = '/account-verification/' + response.user_id;
                },
                error: function (error) {
                    $('#js-register-error').removeClass('d-none');
                    $('#js-register-error').html('*' + Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });

        const inputs = $('.input-field');
        inputs.each(function (index) {
            $(this).on('input', function (event) {
                if ($(this).val() && index < inputs.length - 1) {
                    $(inputs[index + 1]).focus(); // Focus on the next input
                }
            });

            $(this).on('keydown', function (event) {
                if (event.key === 'Backspace' && !$(this).val() && index > 0) {
                    $(inputs[index - 1]).focus(); // Focus on the previous input
                }
            });
        });
        // account verify form
        $('#account-verify-form').submit(function (e) {
            e.preventDefault();
            var codeInputs = $(this).find('[data-code-input]');
            var code = '';
            codeInputs.each(function () {
                code += $(this).val();
            });

            console.log({ code });
            $.ajax({
                url: `/account-verification/${$(this).data('user-id')}`,
                method: 'POST',
                data: {
                    otp: code,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    window.location.href = '/';
                },
                error: function (error) {
                    $('#js-account-verify-response').html(error.responseJSON.message);
                },
            });
        });
    });
})(jQuery);
