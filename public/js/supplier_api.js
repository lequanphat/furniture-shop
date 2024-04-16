jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        const data_asset = $('#asset').attr('data-asset');
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
                    $('#supplier-table').append(
                        `<tr>
                        <td>${response.supplier.supplier_id}</td>

                        <td>${response.supplier.name }</td>
                        <td>
                        ${response.supplier.description }
                        </td>
                        <td> ${response.supplier.address }</td>
                        <td>${response.supplier.phone_number }</td>
                        {{-- temporary value --}}
                        <td>
                            <button type="button" class="js-update-category-btn btn  mr-2 px-2 py-1"
                                data-bs-toggle="modal" data-bs-target="#UpdateSupplierModal"
                                data-supplier-id="${response.supplier.supplier_id}<"
                                data-name="${response.supplier.name }}"
                                data-description=" ${response.supplier.description }"
                                data-address="${response.supplier.address }"
                                data-phone-number="${response.supplier.phone_number }">
                                <img src="${data_asset}svg/edit.svg" style="width: 18px;" />
                            </button>

                        </td>`
                    )
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
                    var row = $('#supplier-table tr').filter(function () {
                        return $(this).find('td:first').text() == response.supplier.supplier_id;
                    });
                    if (row)
                    {
                        row.html(`
                        <td>${response.supplier.supplier_id}</td>

                        <td>${response.supplier.name }</td>
                        <td>
                        ${response.supplier.description }
                        </td>
                        <td> ${response.supplier.address }</td>
                        <td>${response.supplier.phone_number }</td>
                        {{-- temporary value --}}
                        <td>
                            <button type="button" class="js-update-category-btn btn  mr-2 px-2 py-1"
                                data-bs-toggle="modal" data-bs-target="#UpdateSupplierModal"
                                data-supplier-id="${response.supplier.supplier_id}"
                                data-name="${response.supplier.name }"
                                data-description=" ${response.supplier.description }"
                                data-address="${response.supplier.address }"
                                data-phone-number="${response.supplier.phone_number }">
                                <img src="${data_asset}svg/edit.svg" style="width: 18px;" />
                            </button>

                        </td>`)
                    }
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