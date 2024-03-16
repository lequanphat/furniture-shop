jQuery.noConflict();

(function ($) {
    $(document).ready(function () {
        $('#js-create-category-btn').click(() => {
            $('#createEmployeeModal').modal('show');
            $('#create-category-form')[0].reset();
            // $('#create_category_response').html('');
            // $('#create_category_response').removeClass('alert-success alert-danger');
        });

        $('#create-category-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/admin/categories/create',
                type: 'POST',
                data: formData,
                success: function (response) {
                    console.log(response);
                    $('#create_category_response').removeClass('alert-danger');
                    $('#create_category_response').addClass('alert-success');
                    $('#create_category_response').html(response.message);
                },
                error: function (error) {
                    console.log(error);
                    $('#create_employee_response').removeClass('alert-success');
                    $('#create_employee_response').addClass('alert-danger');
                    $('#create_employee_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });

        // click show update employee
        $('#UpdateCategoryModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('#updateCateTitle').html('Update Category - ' + button.data('category-id'));
            modal.find('#category_id').val(button.data('category-id'));
            modal.find('#name').val(button.data('name'));
            modal.find('#description').val(button.data('description'));
            modal.find('#index').val(button.data('index'));
            modal.find('#phone_number ').val(button.data('phone-number'));
            modal.find('#parent_id').val(button.data('parent-id'));
        });

        // click cancel employee
        $('#js-cancel-update-employee-btn').click(() => {
            $('#updateEmployeeModal').modal('hide');
        });

        // update employee
        $('#update-category-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            console.log({ formData });
            // console.log()
            $.ajax({
                url: `/admin/categories/update`,
                type: 'POST',
                data: formData,
                success: function (response) {
                    console.log({ response });
                    // Handle the success response
                    $('#update_category_response').removeClass('alert-danger');
                    $('#update_category_response').addClass('alert-success');
                    $('#update_category_response').html(response.message);
                },
                error: function (error) {
                    console.log({ error });
                    // Handle the error response
                    $('#update_category_response').removeClass('alert-success');
                    $('#update_category_response').addClass('alert-danger');
                    // $('#update_category_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });

        $('#reset_create_employee_form').click(() => {
            $('#create_category_response').html('');
            $('#create_category_response').removeClass('alert-success alert-danger');
        });
    });
})(jQuery);
