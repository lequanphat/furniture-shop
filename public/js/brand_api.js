jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        $('#js-create-brand-btn').click(() => {
            $('#createEmployeeModal').modal('show');
            $('#create-brand-form')[0].reset();
            // $('#create_category_response').html('');
            // $('#create_category_response').removeClass('alert-success alert-danger');
        });
        
        $('#create-brand-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/admin/brands/create',
                type: 'POST',
                data: formData,
                success: function (response) {
                    console.log(response);
                    $('#create_brand_response').removeClass('alert-danger');
                    $('#create_brand_response').addClass('alert-success');
                    $('#create_brand_response').html(response.message);
                    $('#brand-table').append(`
                    <tr>
                    <td>${response.brand.brand_id }</td>
                    <td>${response.brand.name }</td>
                    <td>
                    ${response.brand.description }
                    </td>
                    <td>${response.brand.index }</td>
                    <td>
                        <button type="button" class="js-update-brand-btn btn  mr-2 px-2 py-1"
                            data-bs-toggle="modal" data-bs-target="#UpdateBrandModal"
                            data-brand-id="${response.brand.brand_id }" data-name="${response.brand.brand_id }"
                            data-description="   ${response.brand.description }"
                            data-index="${response.brand.index }"
                            data-parent-id="${response.brand.parent_id }">
                            <img src="{{ asset('svg/edit.svg') }}" style="width: 18px;" />
                        </button>
                    </td>`
            )},
                error: function (error) {
                    console.log(error);
                    $('#create_brand_response').removeClass('alert-success');
                    $('#create_brand_response').addClass('alert-danger');
                    $('#create_brand_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });
        $('#create-brand-form').on('reset', function () {
            $('#create_brand_response').html('');
            $('#create_brand_response').removeClass('alert-success alert-danger');
            $('#create_brand_response').addClass('d-none');
        });
        $('#UpdateBrandModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('#updateBrandTitle').html('Update Brand - ' + button.data('brand-id'));
            modal.find('#brand_id').val(button.data('brand-id'));
            modal.find('#name').val(button.data('name'));
            modal.find('#description').val(button.data('description'));
            modal.find('#index').val(button.data('index'));
        });

        $('#update-brand-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            console.log({ formData });
            // console.log()
            $.ajax({
                url: `/admin/brands/update`,
                type: 'PUT',
                data: formData,
                success: function (response) {
                    console.log({ response });
                    // Handle the success response
                    $('#update_brand_response').removeClass('alert-danger');
                    $('#update_brand_response').addClass('alert-success');
                    $('#update_brand_response').html(response.message);
                    var row = $('#brand-table tr').filter(function () {
                        return $(this).find('td:first').text() == response.brand.brand_id;
                    });
                    if (row)
                    {
                        row.html(`
                        <tr>
                        <td>${response.brand.brand_id }</td>
    
                        <td>${response.brand.name }</td>
                        <td>
                        ${response.brand.description }
                        </td>
                        <td>${response.brand.index }</td>
                        <td>
                            <button type="button" class="js-update-brand-btn btn  mr-2 px-2 py-1"
                                data-bs-toggle="modal" data-bs-target="#UpdateBrandModal"
                                data-brand-id="${response.brand.brand_id }" data-name="${response.brand.brand_id }"
                                data-description="   ${response.brand.description }"
                                data-index="${response.brand.index }"
                                data-parent-id="${response.brand.parent_id }">
                                <img src="{{ asset('svg/edit.svg') }}" style="width: 18px;" />
                            </button>
                        </td>`)
                    }
                },
                error: function (error) {
                    console.log({ error });
                    // Handle the error response
                    $('#update_brand_response').removeClass('alert-success');
                    $('#update_brand_response').addClass('alert-danger');
                    // $('#update_brand_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });
    });
})(jQuery); 