jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        // create employee api
        $('#create-employee-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/admin/employee/create',
                type: 'POST',
                data: formData,
                success: function (response) {
                    console.log({ response });
                    // Handle the success response
                    $('#create_employee_response').removeClass('alert-danger');
                    $('#create_employee_response').addClass('alert-success');
                    $('#create_employee_response').html(response.message);
                },
                error: function (error) {
                    console.log({ error });
                    // Handle the error response
                    $('#create_employee_response').removeClass('alert-success');
                    $('#create_employee_response').addClass('alert-danger');
                    $('#create_employee_response').html(error.responseJSON.errors[0]);
                },
            });
        });
        // reset create employee form
        $('#reset_create_employee_form').click(() => {
            $('#create_employee_response').html('');
            $('#create_employee_response').removeClass('alert-success alert-danger');
        });

        // click show update employee
        $(document).on('click', '.js-update-employee-btn', function () {
            $('#updateEmployeeModal').modal('show');
            $('#updateEmployeeModal #updateEmployeeTitle').html(`Update employee - ID ${$(this).data('user-id')}`);
            $('#updateEmployeeModal #email').val($(this).data('email'));
            $('#updateEmployeeModal #email').prop('readonly', true);
            $('#updateEmployeeModal #first_name').val($(this).data('first-name'));
            $('#updateEmployeeModal #last_name').val($(this).data('last-name'));
            $('#updateEmployeeModal #phone_number').val($(this).data('phone-number'));
            $('#updateEmployeeModal #birth_date').val($(this).data('birth-date'));
            $('#updateEmployeeModal #gender').val($(this).data('gender'));
            $('#updateEmployeeModal #address').val($(this).data('address'));
            if ($(this).data('gender')) {
                $('#updateEmployeeModal #male').prop('checked', true);
            } else {
                $('#updateEmployeeModal #female').prop('checked', true);
            }
        });

        // click cancel employee
        $('#js-cancel-update-employee-btn').click(() => {
            $('#updateEmployeeModal').modal('hide');
        });
    });
})(jQuery);
