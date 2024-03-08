// create employee api
$(document).ready(function () {
    // Clear form data when the modal is shown
    $('#exampleModal').on('show.fade.modal', function (e) {
        // Reset form fields
        $('#create-employee-form')[0].reset();
        // Clear any previous response message
        $('#create_employee_response').empty();
    });
    console.log('reset');
});

jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        $('#create-employee-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/admin/employee/create',
                type: 'POST',
                data: formData,
                success: function (response) {
                    // Handle the success response
                    $('#create_employee_response').removeClass('alert-danger');
                    $('#create_employee_response').addClass('alert-success');
                    $('#create_employee_response').html(response.message);
                },
                error: function (error) {
                    // Handle the error response
                    $('#create_employee_response').removeClass('alert-success');
                    $('#create_employee_response').addClass('alert-danger');
                    $('#create_employee_response').html(error.responseJSON.message);
                },
            });
        });
    });
})(jQuery);
