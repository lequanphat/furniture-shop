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
                    // Handle the success response
                    console.log('====================================');
                    console.log({ response });
                    console.log('====================================');
                    $('#create_employee_response').removeClass('alert-danger d-none');
                    $('#create_employee_response').addClass('alert-success');
                    $('#create_employee_response').html(response.message);
                },
                error: function (error) {
                    // Handle the error response
                    console.log('====================================');
                    console.log({ error });
                    console.log('====================================');
                    $('#create_employee_response').removeClass('alert-successs d-none');
                    $('#create_employee_response').addClass('alert-danger');
                    $('#create_employee_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });
        // reset create employee form
        $('#create-employee-form').on('reset', function () {
            $('#create_employee_response').html('');
            $('#create_employee_response').removeClass('alert-success alert-danger');
            $('#create_employee_response').addClass('d-none');
        });

        // click show update employee
        $(document).ready(function () {
            $('#update-employee-modal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var modal = $(this);
                modal.find('#update-employee-title').html('Update Employee - ' + button.data('user-id'));
                modal.find('#first_name').val(button.data('first-name'));
                modal.find('#last_name').val(button.data('last-name'));
                modal.find('#email ').val(button.data('email'));
                modal.find('#email ').attr('readonly', true);
                modal.find('#address ').val(button.data('address'));
                modal.find('#phone_number ').val(button.data('phone-number'));
                modal.find('#birth_date ').val(button.data('birth-date'));
                if (button.data('gender')) modal.find('#male ').prop('checked', true);
                else modal.find('#female ').prop('checked', true);
            });
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
                    $('#update_employee_response').removeClass('alert-successs d-none');
                    $('#update_employee_response').addClass('alert-success');
                    $('#update_employee_response').html(Object.values(response.message));
                },
                error: function (error) {
                    console.log({ error });
                    // Handle the error response
                    $('#update_employee_response').removeClass('alert-success d-none');
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
