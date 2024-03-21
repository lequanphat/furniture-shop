jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        $('#js-create-supplier-btn').click(() => {
            $('#createEmployeeModal').modal('show');
            $('#create-supplier-form')[0].reset();
            // $('#create_category_response').html('');
            // $('#create_category_response').removeClass('alert-success alert-danger');
        });
        
        $('#create-supplier-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/admin/suppliers/create',
                type: 'POST',
                data: formData,
                success: function (response) {
                    console.log(response);
                    $('#create_supplier_response').removeClass('alert-danger');
                    $('#create_supplier_response').addClass('alert-success');
                    $('#create_supplier_response').html(response.message);
                },
                error: function (error) {
                    console.log(error);
                    $('#create_supplier_response').removeClass('alert-success');
                    $('#create_supplier_response').addClass('alert-danger');
                    $('#create_supplier_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });
        $('#create-supplier-form').on('reset', function () {
            $('#create_brand_response').html('');
            $('#create_brand_response').removeClass('alert-success alert-danger');
            $('#create_brand_response').addClass('d-none');
        });
        $('#UpdateSupplierModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('#updateSupplierTitle').html('Update Supplier - ' + button.data('supplier-id'));
            modal.find('#supplier_id').val(button.data('supplier-id'));
            modal.find('#name').val(button.data('name'));
            modal.find('#description').val(button.data('description'));
            modal.find('#address').val(button.data('address'));
            modal.find('#phone_number').val(button.data('phone-number'));
        });

        $('#update-supplier-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            console.log({ formData });
            // console.log()
            $.ajax({
                url: `/admin/suppliers/update`,
                type: 'PUT',
                data: formData,
                success: function (response) {
                    console.log({ response });
                    // Handle the success response
                    $('#update_supplier_response').removeClass('alert-danger');
                    $('#update_supplier_response').addClass('alert-success');
                    $('#update_supplier_response').html(response.message);
                },
                error: function (error) {
                    console.log({ error });
                    // Handle the error response
                    $('#update_supplier_response').removeClass('alert-success');
                    $('#update_supplier_response').addClass('alert-danger');
                    // $('#update_brand_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });
    });
})(jQuery); 