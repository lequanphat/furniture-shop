jQuery.noConflict();

(function ($) {
    $(document).ready(function () {
        const data_asset = $('#asset').attr('data-asset');

        $('#create-category-modal').on('show.bs.modal', function (event) {
            $('#create-category-form')[0].reset();
            $('#create_category_response').addClass('d-none');
        });

        $('#create-category-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/admin/categories',
                type: 'POST',
                data: formData,
                success: function (response) {
                    let parent = 'Không';
                    if (response.category?.parent?.category_id) {
                        parent = `${response.category.parent.category_id} - ${response.category.parent.name}`;
                    }
                    $('#category-table-body').append(`
                    <tr>
                        <td>${response.category.category_id}</td>

                        <td>${response.category.name}</td>
                        <td>
                        ${response.category.description}
                        </td>
                        <td> ${response.category.index}</td>
                        <td>${parent}</td>
                        <td>
                            <button type="button" class="js-update-category-btn btn  mr-2 px-2 py-1"
                                data-bs-toggle="modal" data-bs-target="#update-category-modal"
                                data-category-id="${response.category.category_id}"
                                data-name="${response.category.name}"
                                data-description="${response.category.description}"
                                data-index="${response.category.index}"
                                data-parent-id="${response.category.parent_id}">
                                <img src="${data_asset}svg/edit.svg" style="width: 18px;" />
                            </button>
                            <a href='/admin/categories/delete/${response.category.category_id}'>
                                <img src="${data_asset}svg/trash.svg" style="width: 18px;" />
                            </a>
                        </td>
                    </tr>`);
                    $('#create_category_response').removeClass('d-none');
                    $('#create_category_response').removeClass('alert-danger');
                    $('#create_category_response').addClass('alert-success');
                    $('#create_category_response').html(response.message);
                },
                error: function (error) {
                    $('#create_category_response').removeClass('d-none');
                    $('#create_category_response').removeClass('alert-success');
                    $('#create_category_response').addClass('alert-danger');
                    $('#create_category_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });

        $('.js-update-category-btn').on('click', function () {
            $('#update-category-form').data('id', $(this).data('category-id'));
            $('#update-category-modal #updateCateTitle').html(`Update Category - ${$(this).data('category-id')}`);
            $('#update-category-modal #category_id').val($(this).data('category-id'));
            $('#update-category-modal #name').val($(this).data('name'));
            $('#update-category-modal #description').val($(this).data('description'));
            $('#update-category-modal #index').val($(this).data('index'));
            $('#update-category-modal #parent_id').val($(this).data('parent-id'));
            $('#update_category_response').html('');
            $('#update_category_response').removeClass('alert-success alert-danger');
            $('#update_category_response').addClass('d-none');
        });

        // update category
        $('#update-category-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            console.log($('#update-category-form').data('id'));
            $.ajax({
                url: `/admin/categories/${$('#update-category-form').data('id')}`,
                type: 'PATCH',
                data: formData,
                success: function (response) {
                    console.log({ response });
                    // Handle the success response
                    $('#update_category_response').removeClass('d-none');
                    $('#update_category_response').addClass('alert-success');
                    $('#update_category_response').removeClass('alert-error');
                    $('#update_category_response').html(response.message);
                    var row = $('#category-table-body tr').filter(function () {
                        return $(this).find('td:first').text() == response.category.category_id;
                    });

                    if (row) {
                        let parent = 'Không';
                        if (response.category?.parent?.category_id) {
                            parent = `${response.category.parent.category_id} - ${response.category.parent.name}`;
                        }
                        row.html(`
                            <td>${response.category.category_id}</td>
                            <td>${response.category.name}</td>
                            <td>
                            ${response.category.description}
                            </td>
                            <td> ${response.category.index}</td>
                            <td>${parent}</td>
                            <td>
                                <button type="button" class="js-update-category-btn btn  mr-2 px-2 py-1"
                                    data-bs-toggle="modal" data-bs-target="#update-category-modal"
                                    data-category-id="${response.category.category_id}"
                                    data-name="${response.category.name}"
                                    data-description="${response.category.description}"
                                    data-index="${response.category.index}"
                                    data-parent-id="${response.category.parent_id}">
                                    <img src="${data_asset}svg/edit.svg" style="width: 18px;" />
                                </button>
                                <a href='/admin/categories/delete/${response.category.category_id}'>
                                    <img src="${data_asset}svg/trash.svg" style="width: 18px;" />
                                </a>
                            </td>`);
                    }
                },
                error: function (error) {
                    console.log({ error });
                    // Handle the error response
                    $('#update_category_response').removeClass('d-none');
                    $('#create_category_response').removeClass('alert-success');
                    $('#create_category_response').addClass('alert-danger');
                    $('#update_category_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });

        // delete category
        $(document).on('click', '.js-delete-category', function (e) {
            e.preventDefault();
            var category_id = $(this).data('category-id');
            console.log(category_id);
            var row = $(this).closest('tr');
            $.ajax({
                url: `/admin/categories/${category_id}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    row.remove();
                },
                error: function (error) {
                    // show error modal
                    console.log('====================================');
                    console.log(error);
                    console.log('====================================');
                    $('#error-delete-modal').addClass('show');
                    $('#error-delete-modal').attr('style', 'display: block;');
                    $('#error-delete-modal').removeAttr('aria-hidden');
                    $('body').append('<div class="modal-backdrop fade show"></div>');
                    $('#error-message').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });
        //  close error modal
        $('.js-close-error-modal').click(function () {
            $('#error-delete-modal').removeClass('show');
            $('#error-delete-modal').attr('style', 'display: none;');
            $('#error-delete-modal').attr('aria-hidden', 'true');
            $('.modal-backdrop.fade.show').remove();
        });
    });
})(jQuery);
