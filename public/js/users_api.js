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
                    $('#create_employee_response').removeClass('alert-danger d-none');
                    $('#create_employee_response').addClass('alert-success');
                    $('#create_employee_response').html(response.message);
                },
                error: function (error) {
                    // Handle the error response
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
        $('#delete-employee-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var userId = button.data('user-id');
            var modal = $(this);
            modal.find('.modal-footer button.btn-danger').data('user-id', userId);
        });
        // click restore employee
        $('#restore-employee-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var userId = button.data('user-id');
            var modal = $(this);
            modal.find('.modal-footer button.btn').data('user-id', userId);
        });
        // delete user
        $('#delete-employee-modal').on('click', '.modal-footer button.btn-danger', function (e) {
            var userId = $(this).data('user-id');
            console.log(userId);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: `/admin/employee/${userId}/ban`,
                type: 'GET',
                success: function (response) {
                    var link = $('#js-employee-table a[data-user-id="' + userId + '"]');
                    // update status
                    var statusCell = link.closest('tr').find('td').eq(5);
                    // update action
                    statusCell.html('<span class="badge bg-danger me-1"></span> Blocked');
                    var actionCell = link.closest('tr').find('td').eq(6);
                    actionCell.find('a:last').html(`temp`);
                },
                error: function (error) {
                    console.log({ error });
                },
            });
        });
        // restore user
        $('#restore-employee-modal').on('click', '.modal-footer button.btn-primary', function (e) {
            var userId = $(this).data('user-id');
            console.log(userId);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: `/admin/employee/${userId}/unban`,
                type: 'GET',
                success: function (response) {
                    var link = $('#js-employee-table a[data-user-id="' + userId + '"]');
                    var statusCell = link.closest('tr').find('td').eq(5);
                    statusCell.html('<span class="badge bg-success me-1"></span> Active');
                },
                error: function (error) {
                    console.log({ error });
                },
            });
        });
    });
})(jQuery);
