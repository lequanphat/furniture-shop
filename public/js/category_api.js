jQuery.noConflict();

(function ($) {
    $(document).ready(function () {
        $('#js-create-category-btn').click(() => {
            $('#createEmployeeModal').modal('show');
            $('#create-employee-form')[0].reset();
            $('#create_employee_response').html('');
            $('#create_employee_response').removeClass('alert-success alert-danger');
        });
    });
})(jQuery);
