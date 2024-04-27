jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        const data_asset = $('#asset').attr('data-asset');

        // create category
        function createCategoryElement({ category, can_update = false, can_delete = false }) {
            let parent = 'Không';
            if (category?.parent?.category_id) {
                parent = `${category.parent.category_id} - ${category.parent.name}`;
            }
            const update_btn = can_update
                ? `<button type="button" class="btn  p-2"
                data-bs-toggle="modal" data-bs-target="#update-category-modal"
                data-category-id="${category.category_id}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-pencil">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                    <path d="M13.5 6.5l4 4" />
                </svg>
            </button>`
                : '';
            const delete_btn = can_delete
                ? `<a class="btn p-2" data-category-id="${category.category_id}"
            data-category-name="${category.name}" data-bs-toggle="modal"
            data-bs-target="#delete-confirm-modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-trash">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M4 7l16 0" />
                <path d="M10 11l0 6" />
                <path d="M14 11l0 6" />
                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
            </svg>
        </a>`
                : '';
            return `<td>${category.category_id}</td>

            <td>${category.name}</td>
            <td>
            ${category.description}
            </td>
            <td> ${category.index}</td>
            <td>${parent}</td>
            <td>
                ${update_btn}
                ${delete_btn}
            </td>`;
        }

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
                    $('#category-table-body').append(
                        `<tr>${createCategoryElement({
                            category: response.category,
                            can_update: response.can_update,
                            can_delete: response.can_delete,
                        })}</tr>`,
                    );
                    $('#create_category_response').removeClass('d-none');
                    $('#create_category_response').removeClass('alert-danger');
                    $('#create_category_response').addClass('alert-success');
                    $('#create_category_response').html(response.message);
                },
                error: function (error) {
                    console.log(error);
                    $('#create_category_response').removeClass('alert-success d-none');
                    $('#create_category_response').addClass('alert-danger');
                    $('#create_category_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });

        $('#update-category-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var category_id = button.data('category-id');
            $.ajax({
                url: `/admin/categories/${category_id}`,
                type: 'GET',
                success: function (response) {
                    console.log(response);
                    $('#update-category-form').data('id', response.category.category_id);
                    $('#update-category-form input[name="name"]').val(response.category.name);
                    $('#update-category-form input[name="description"]').val(response.category.description);
                    $('#update-category-form input[name="index"]').val(response.category.index);
                    let options = '<option value="-1">Không</option>';
                    response.categories.forEach((category) => {
                        if (category.category_id == response.category.parent_id) {
                            options += `<option value="${category.category_id}" selected>${category.category_id} - ${category.name}</option>`;
                        } else {
                            options += `<option value="${category.category_id}">${category.category_id} - ${category.name}</option>`;
                        }
                    });
                    $('#update-category-form select[name="parent_id"]').html(options);
                },
                error: function (error) {
                    console.log(error);
                },
            });
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
                        row.html(
                            `${createCategoryElement({
                                category: response.category,
                                can_update: response.can_update,
                                can_delete: response.can_delete,
                            })}`,
                        );
                    }
                },
                error: function (error) {
                    console.log({ error });
                    // Handle the error response
                    $('#update_category_response').removeClass('d-none');
                    $('#update_category_response').removeClass('alert-success');
                    $('#update_category_response').addClass('alert-danger');
                    $('#update_category_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });

        // delete role
        $('#delete-confirm-modal').on('show.bs.modal', function (e) {
            var button = $(e.relatedTarget);
            var category_id = button.data('category-id');
            var category_name = button.data('category-name');

            $(this)
                .find('.modal-description')
                .html(`Do you want to delete category <strong>${category_name}</strong> ?`);
            $(this).find('#confirm-btn').text('Yes, delete this category');
            $(this).find('#confirm-btn').data('category-id', category_id);
        });

        $(document).on('click', '#delete-confirm-modal #confirm-btn', function (e) {
            var category_id = $(this).data('category-id');
            $.ajax({
                url: `/admin/categories/${category_id}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (data) {
                    $('#category-table-body tr td')
                        .filter(function () {
                            return $(this).text() == category_id;
                        })
                        .closest('tr')
                        .remove();
                },
                error: function (error) {
                    console.log(error);
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
