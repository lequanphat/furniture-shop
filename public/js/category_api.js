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

        $(document).on('click', '.js-update-category-btn', function () {
            // show modal
            $('#UpdateCategoryModal').modal('show');
            // assign data
            $('#UpdateCategoryModal #updateCateTitle').html(`Update category - ID ${$(this).data('category-id')}`);

            $('#UpdateCategoryModal #category_id').val($(this).data('category-id'));
            $('#UpdateCategoryModal #name').val($(this).data('name'));
          $('#UpdateCategoryModal #description').val($(this).data('description'));
          $('#UpdateCategoryModal #index').val($(this).data('index'));
          $('#UpdateCategoryModal #parent_id' ).val($(this).data('parent-id'))



            $('#update_employee_response').html('');
            $('#update_employee_response').removeClass('alert-success alert-danger');
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
