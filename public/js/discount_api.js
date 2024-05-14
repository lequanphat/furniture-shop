jQuery.noConflict();

(function ($) {
    $(document).ready(function () {
        let formatter = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 0,
        });

        $('#create-discount-form').submit(function (e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: '/admin/discounts',
                type: 'POST',
                data: formData,
                success: function (response) {
                    $('#create_discount_response').removeClass('alert-danger d-none');
                    $('#create_discount_response').addClass('alert-success');
                    $('#create_discount_response').html(response.message);
                    window.location.reload();
                },
                error: function (error) {
                    $('#create_discount_response').removeClass('alert-success d-none');
                    $('#create_discount_response').addClass('alert-danger');
                    $('#create_discount_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });

        $('#delete-confirm-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var discount_Id = button.data('discount-id');
            $(this)
                .find('.modal-description')
                .html(`Are you sure to delete discount with id <strong>${discount_Id} </strong> ?`);
            $(this).find('#confirm-btn').data('discount-id', discount_Id);
            $(this).find('#confirm-btn').text('Yes, delete this discount');
        });

        $('#delete-confirm-modal').on('click', '#confirm-btn', function (e) {
            var discount_id = $(this).data('discount-id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: `/admin/discounts/${discount_id}`,
                type: 'DELETE',
                success: function (response) {
                    window.location.reload();
                },
                error: function (error) {
                    $('#error-delete-modal').addClass('show');
                    $('#error-delete-modal').attr('style', 'display: block;');
                    $('#error-delete-modal').removeAttr('aria-hidden');
                },
            });
        });

        // restore

        $('#restore-confirm-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var discount_Id = button.data('discount-id');
            $(this)
                .find('.modal-description')
                .html(`Are you sure to restore discount with id <strong>${discount_Id} </strong> ?`);
            $(this).find('#confirm-btn').data('discount-id', discount_Id);
            $(this).find('#confirm-btn').text('Yes, restore this discount');
        });

        $('#restore-confirm-modal').on('click', '#confirm-btn', function (e) {
            var discount_id = $(this).data('discount-id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: `/admin/discounts/${discount_id}`,
                type: 'PATCH',
                success: function (response) {
                    window.location.reload();
                },
                error: function (error) {
                    $('#error-delete-modal').addClass('show');
                    $('#error-delete-modal').attr('style', 'display: block;');
                    $('#error-delete-modal').removeAttr('aria-hidden');
                },
            });
        });

        $('#modal-discount-update').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            // modal.find('#updateSupplierTitle').html('Update Supplier - ' + button.data('supplier-id'));
            modal.find('#discount_id').val(button.data('discount-id'));
            modal.find('#title').val(button.data('title'));
            modal.find('#update_editor').val(button.data('description'));
            modal.find('#percentage').val(button.data('percentage'));
            modal.find('#startdate').val(button.data('start-date'));
            modal.find('#enddate').val(button.data('end-date'));
            modal.find('#active').val(button.data('is-active'));
        });

        $('#Update-discount-form').submit(function (e) {
            e.preventDefault();
            let formData = $(this).serialize();
            const discount_id = $('#discount_id').val();
            $.ajax({
                url: `/admin/discounts/${discount_id}`,
                type: 'PUT',
                data: formData,
                success: function (response) {
                    $('#update_discount_response').removeClass('alert-danger d-none');
                    $('#update_discount_response').addClass('alert-success');
                    $('#update_discount_response').html(response.message);

                    window.location.reload();
                },
                error: function (error) {
                    $('#update_discount_response').removeClass('alert-success d-none');
                    $('#update_discount_response').addClass('alert-danger');
                    $('#update_discount_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });

        function filterDiscount({ page }) {
            const search = $('#search').val();
            const type = $('#status_type').val();
            const status = $('#status').val();
            // const sort = $('#select-discount-sort').val();
            history.pushState(
                null,
                null,
                `/admin/discounts?search=${search}&page=${page}&type=${type}&status=${status}`,
            );
            window.location.reload();
        }

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

        // search with ajax
        $('#search').on(
            'input',
            debounce(function () {
                filterDiscount({ page: 1 });
            }, 500),
        );

        $('#status_type').change(function () {
            filterDiscount({ page: 1 });
        });
        $('#status').change(function () {
            filterDiscount({ page: 1 });
        });
        // select sort
        $('#select-roles-sort').change(function () {
            rolesPagination({ page: 1 });
        });

        // add product to discount

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

        $(document).on('click', '.js-add-product', function (event) {
            event.preventDefault();
            const sku = $(this).data('sku');
            const discount_id = $('#discount_id').val();
            console.log({ discount_id, sku });
            $.ajax({
                url: `/admin/discount/${discount_id}/${sku}`,
                type: 'POST',
                data: {},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    console.log(response);
                    window.location.reload();
                },
                error: function (error) {
                    console.log(error);
                },
            });
        });
        const filterDetailedProducts = ({ page }) => {
            const discount_id = $('#discount_id').val();
            const search = $('#search-detailed-products').val();
            if (!page) {
                page = 1;
            }
            const url = `/admin/discount/${discount_id}/get_products_not_in_discount?search=${search}&page=${page}`;
            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    let html = '';
                    for (let i = 0; i < response.products.data.length; i++) {
                        const detailed_product = response.products.data[i];
                        const image = detailed_product.images.length > 0 ? detailed_product.images[0].url : '';
                        html += `<tr data-sku="${detailed_product.sku}">
                        <td>
                            <div class="d-flex py-1 align-items-center">
                                <span class="avatar me-2 custom-product-image"
                                    style="background-image: url(${image});">
                                </span>
                                <div class="flex-1">
                                    <div class="font-weight-medium">
                                        <h4 class="m-0">${detailed_product.name}</h4>
                                    </div>
                                    <div class="text-muted">
                                        <a href="#"class="text-reset">#${detailed_product.sku}</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div><p class="text-reset m-0">${detailed_product.color.name}</p></div>
                            <div class="text-muted "><p class="text-reset m-0">${detailed_product.size}</p></div>
                        </td>
                        <td class="js-detailed-product-quantities">${detailed_product.quantities}</td>
                        <td class="text-danger">
                        ${formatter.format(detailed_product.original_price)}đ
                        </td>
                        <td>
                        <div class="custom-table-action">
                        <button class="js-add-product btn p-2" data-sku="${detailed_product.sku}">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24"
                                viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                <path stroke="none" d="M0 0h24v24H0z"
                                    fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                        </button>
                    </div>
                        </td>
                    </tr>`;
                    }
                    $('#detailed-products-table').html(html);
                    $('.js-detailed-products-pagination .pagination').html(
                        renderPagination({
                            current_page: response.products.current_page,
                            last_page: response.products.last_page,
                        }),
                    );
                },
                error: function (error) {
                    console.log(error);
                },
            });
        };
        $('#search-detailed-products').on(
            'input',
            debounce(function () {
                filterDetailedProducts({ page: 1 });
            }, 500),
        );

        $(document).on('click', '.js-detailed-products-pagination .pagination .page-link', function (event) {
            var button = $(event.target);
            const page = button.data('page');
            filterDetailedProducts({ page });
        });

        $('#delete-product-confirm-modal').on('show.bs.modal', function (e) {
            var button = $(e.relatedTarget);
            var sku = button.data('sku');
            var discount_id = button.data('discount-id');
            var name = button.data('name');
            $(this)
                .find('.modal-description')
                .html(`Do you want to remove product <strong>${sku} - ${name}</strong> from this discount ?`);
            $(this).find('#confirm-btn').text('Yes, remove this product');
            $(this).find('#confirm-btn').data('sku', sku);
            $(this).find('#confirm-btn').data('discount-id', discount_id);
        });

        $(document).on('click', '#delete-product-confirm-modal #confirm-btn', function (e) {
            const sku = $(this).data('sku');
            const discount_id = $(this).data('discount-id');
            $.ajax({
                url: `/admin/discount/${discount_id}/${sku}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (data) {
                    $('#detail_discount_table tr td a.js-sku')
                        .filter(function () {
                            return $(this).text() == `#${sku}`;
                        })
                        .closest('tr')
                        .remove();
                },
                error: function (error) {
                    console.log(error);
                },
            });
        });
    });
})(jQuery);
