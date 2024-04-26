jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        function createBrandElement({ brand, can_update = false, can_delete = false }) {
            const newTag = brand.new
                ? '<span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>'
                : '';
            const update_action = can_update
                ? `<button type="button" class="js-update-brand-btn btn  mr-2 px-2 py-1"
                data-bs-toggle="modal" data-bs-target="#UpdateBrandModal"
                data-brand-id="${brand.brand_id}" data-name="${brand.brand_id}"
                data-description="   ${brand.description}"
                data-index="${brand.index}"
                data-parent-id="${brand.parent_id}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round"
                    class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-pencil">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                    <path d="M13.5 6.5l4 4" />
                </svg>
            </button>`
                : '';
            const delete_action = can_delete
                ? `<button class="btn p-2" data-bs-toggle="modal" data-bs-target="#delete-confirm-modal" data-brand-id="${brand.brand_id}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round"
                    class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-trash">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 7l16 0" />
                    <path d="M10 11l0 6" />
                    <path d="M14 11l0 6" />
                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                </svg>
            </button>`
                : '';
            return `<td>${brand.brand_id}</td>
                <td>${brand.name} ${newTag}</td>
                <td>
                ${brand.description}
                </td>
                <td>${brand.index}</td>
                <td>
                ${update_action}
                ${delete_action}
                </td>`;
        }
        $('#brand-modal').on('show.bs.modal', function (event) {
            $('#create-brand-form')[0].reset();
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
                    $('#create_brand_response').removeClass('d-none');
                    $('#create_brand_response').addClass('alert-success');
                    $('#create_brand_response').html(response.message);
                    response.brand.new = true;
                    $('#brand-table').append(`
                    <tr>${createBrandElement({
                        brand: response.brand,
                        can_update: response.can_update,
                        can_delete: response.can_delete,
                    })}</tr>`);
                },
                error: function (error) {
                    console.log(error);
                    $('#create_brand_response').removeClass('alert-success');
                    $('#create_brand_response').addClass('alert-danger');
                    $('#create_brand_response').removeClass('d-none');
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
        $('#delete-confirm-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var brand_Id = button.data('brand-id');
            $(this)
                .find('.modal-description')
                .html(`If deleted, this brand will no longer be visible to users.`);
            $(this).find('#confirm-btn').data('brand-id', brand_Id);
            $(this).find('#confirm-btn').text('Yes, delete this brand');
        });
        $('#delete-confirm-modal').on('click', '#confirm-btn', function (e) {
            var brand_id = $(this).data('brand-id');
            $.ajax({
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: `/admin/brands/${brand_id}/delete`,
                type: 'DELETE',
                success: function (response) {
                    var row = $('#brand-table tr').filter(function () {
                        return $(this).find('td:first').text() == response.brand.brand_id;
                    });
                    if (row) {
                        row.html(``
                        );
                    }
                    // show success modal
                    $('#success-notify-modal').addClass('show');
                    $('#success-notify-modal').attr('style', 'display: block;');
                    $('#success-notify-modal').removeAttr('aria-hidden');
                    $('body').append('<div class="modal-backdrop fade show"></div>');
                    $('#success-title').html('Deleted Brand Successfully');
                    $('#success-desc').html('This brand can not be able to access.');
                },
                error: function (error) {
                    console.log(Object.values(error.responseJSON.errors)[0][0]);
                    $('#error-delete-modal').addClass('show');
                    $('#error-delete-modal').attr('style', 'display: block;');
                    $('#error-delete-modal').removeAttr('aria-hidden');
                    $('body').append('<div class="modal-backdrop fade show"></div>');
                    $('#error-message').text(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });
      
        $('.js-close-error-modal').click(function () {
            $('#error-message').removeClass('show');
            $('#error-message').attr('style', 'display: none;');
            $('#error-message').attr('aria-hidden', 'true');
            $('.modal-backdrop.fade.show').remove();
        });
        $('.js-close-success-modal').click(function () {
            $('#success-notify-modal').removeClass('show');
            $('#success-notify-modal').attr('style', 'display: none;');
            $('#success-notify-modal').attr('aria-hidden', 'true');
            $('.modal-backdrop.fade.show').remove();
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
                    $('#update_brand_response').removeClass('d-none');
                    $('#update_brand_response').addClass('alert-success');
                    $('#update_brand_response').html(response.message);
                    var row = $('#brand-table tr').filter(function () {
                        return $(this).find('td:first').text() == response.brand.brand_id;
                    });
                    if (row) {
                        row.html(
                            createBrandElement({
                                brand: response.brand,
                                can_update: response.can_update,
                                can_delete: response.can_delete,
                            }),
                        );
                    }
                },
                error: function (error) {
                    console.log({ error });
                    // Handle the error response
                    $('#update_brand_response').removeClass('d-none');
                    $('#update_brand_response').removeClass('alert-success');
                    $('#update_brand_response').addClass('alert-danger');
                    $('#update_brand_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });

        function BrandPagination({ page }) {
            const search = $('#search-brand-input').val();
            history.pushState(null, null, `/admin/brands?page=${page}&search=${search}`);
            // call ajax
            $.ajax({
                url: `/admin/brands/pagination?page=${page}&search=${search}`,
                type: 'GET',
                success: function (response) {
                    let html = '';
                    response.brands.data.forEach((brand) => {
                        html += `<tr>${createBrandElement({
                            brand,
                            can_update: response.can_update,
                            can_delete: response.can_delete,
                        })}</tr>`;
                    });
                    $('#brand-table').html(html);
                    renderPagination({
                        current_page: response.brands.current_page,
                        last_page: response.brands.last_page,
                    });
                },
                error: function (error) {
                    console.log(error);
                },
            });
        }

        // pagination
        $(document).on('click', '.pagination .page-link', function (event) {
            var button = $(event.target);
            const page = button.data('page');
            BrandPagination({ page });
        });
        $('#search-brand-input').on(
            'input',
            debounce(function () {
                BrandPagination({ page: 1 });
            }, 500),
        );
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
        function renderPagination({ current_page, last_page }) {
            let pagination = `<li class="page-item ${current_page === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${current_page - 1}">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="icon"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    stroke-width="2"
                    stroke="currentColor"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M15 6l-6 6l6 6" />
                </svg>
                prev
            </a>
        </li>`;

            for (let i = 0; i < last_page; i++) {
                pagination += `
                    <li class="page-item ${current_page === i + 1 ? 'active mx-1' : ''}">
                        <a class="page-link " href="#" rel="first" data-page="${i + 1}">${i + 1}</a>
                    </li>`;
            }
            pagination += `<li class="page-item ${current_page === last_page ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${current_page + 1}">
                next
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M9 6l6 6l-6 6" />
                </svg>
            </a>
        </li>`;
            $('.pagination').html(pagination);
        }
    });
})(jQuery);
