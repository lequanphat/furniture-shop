jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
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
