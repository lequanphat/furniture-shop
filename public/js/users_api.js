jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        // show create employee modal
        $('#js-create-employee-btn').click(() => {
            $('#createCategoryModal').modal('show');
            // reset data in form
            $('#create-employee-form')[0].reset();
            $('#create_employee_response').html('');
            $('#create_employee_response').removeClass('alert-success alert-danger');
        });

        // create employee api
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
                    $('#create_employee_response').html(Object.values(error.responseJSON.errors)[0][0]);
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
            // show modal
            $('#updateEmployeeModal').modal('show');
            // assign data
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
            // reset response
            $('#update_employee_response').html('');
            $('#update_employee_response').removeClass('alert-success alert-danger');
        });

        // click cancel employee
        $('#js-cancel-update-employee-btn').click(() => {
            $('#updateEmployeeModal').modal('hide');
        });

        // update employee
        $('#update-employee-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            console.log({ formData });
            $.ajax({
                url: `/admin/employee/update`,
                type: 'POST',
                data: formData,
                success: function (response) {
                    console.log({ response });
                    // Handle the success response
                    $('#update_employee_response').removeClass('alert-danger');
                    $('#update_employee_response').addClass('alert-success');
                    $('#update_employee_response').html(response.message);
                },
                error: function (error) {
                    console.log({ error });
                    // Handle the error response
                    $('#update_employee_response').removeClass('alert-success');
                    $('#update_employee_response').addClass('alert-danger');
                    $('#update_employee_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });

        // click delete employee
        $(document).on('click', '.js-delete-employee-btn', function () {
            // show modal
            $('#deleteEmployeeModal').modal('show');
            $('#js-delete-employee-confirm-text').html(
                `Are you sure you want to delete employee ${$(this).data('user-id')} - ${$(this).data(
                    'first-name',
                )} ${$(this).data('last-name')}?`,
            );
        });

        // cancel delete employee
        $('#js-cancel-delete-employee').click(() => {
            $('#deleteEmployeeModal').modal('hide');
        });

        // delete employee
        $('#js-delete-employee').click(() => {
            $('#deleteEmployeeModal').modal('hide');
            // logic here
        });
    });
})(jQuery);
