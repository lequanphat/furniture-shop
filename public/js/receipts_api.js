jQuery.noConflict();

(function ($) {
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
        return pagination;
    }
    $(document).ready(function () {
        // create receipt
        $('#create-receipts-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/admin/receipts/create',
                type: 'POST',
                data: formData,
                success: function (response) {
                    window.location.href = `/admin/receipts/${response.receipt.receiving_report_id}`;
                },
                error: function (error) {
                    console.log(error);
                    $('#create_receipts_response').removeClass('d-none alert-success');
                    $('#create_receipts_response').addClass('alert-danger');
                    $('#create_receipts_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });
        $('#create-order-form').on('reset', function () {
            $('#create_order_response').html('');
            $('#create_order_response').removeClass('alert-success alert-danger');
            $('#create_order_response').addClass('d-none');
        });

        function createReceiptElement({ receipt }) {
            return `
            <td>${receipt.receiving_report_id}</td>
            </td>
            <td class="text-muted">
                <div>
                    <strong>${receipt.supplier.name}</strong> |
                    ${receipt.supplier.phone_number}
                </div>
                <div>
                ${receipt.supplier.address}
                </div>
            </td>
            <td>
            ${receipt.date_time}
            </td>
            <td class="text-danger">${receipt.total_price}đ

            <td class="text-muted">
                <div>
                    <strong>${receipt.employee.first_name} ${receipt.employee.last_name} 
                        </strong> |
                        ${receipt.employee.default_address.phone_number} 
                </div>
                <div>
                ${receipt.employee.default_address.address} 
                </div>
            </td>
            <td>
                <a href="/admin/receipts/${receipt.receiving_report_id}"
                    class="btn p-2" title="Details">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-eye">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                        <path
                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                    </svg>
                </a>
            </td>
        `;
        }
        // filter receipt
        const filterReceipt = ({ page }) => {
            const search = $('#search-receipts').val();
            const type = $('#type-receipts').val();
            const sort = $('#sort-receipts').val();
            history.pushState(null, null, `/admin/receipts?page=${page}&type=${type}&search=${search}&sort=${sort}`);

            if (!page) {
                page = 1;
            }
            const url = `/admin/receipts/pagination?page=${page}&type=${type}&search=${search}&sort=${sort}`;

            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    let html = '';
                    if (response.receipts.data.length === 0) {
                        html = '<tr> <td colspan="6" class="text-center text-muted">No data available</td></tr>';
                    } else {
                        for (let item of response.receipts.data) {
                            html += `<tr>${createReceiptElement({ receipt: item })}</tr>`;
                        }
                    }
                    $('#receipts-table').html(html);
                    $('.js-receipts-pagination .pagination').html(
                        renderPagination({
                            current_page: response.receipts.current_page,
                            last_page: response.receipts.last_page,
                        }),
                    );
                },
                error: function (error) {
                    console.log(error);
                },
            });
        };

        $(document).on('click', '.js-receipts-pagination .pagination .page-link', function (event) {
            var button = $(event.target);
            const page = button.data('page');
            filterReceipt({ page });
        });

        $('#search-receipts').on(
            'input',
            debounce(function () {
                filterReceipt({ page: 1 });
            }, 500),
        );
        $('#sort-receipts').on('change', function () {
            filterReceipt({ page: 1 });
        });
        $('#type-receipts').on('change', function () {
            filterReceipt({ page: 1 });
        });
    });

    $(document).on('input', '.js-unit-price-input', function (event) {
        $(this).removeClass('danger');
    });
    $(document).on('input', '.js-quantities-input', function (event) {
        $(this).removeClass('danger');
    });
    $(document).on('click', '.js-add-product', function (event) {
        let unit_price = $(this).closest('tr').find('.js-unit-price-input').val();
        let quantities = $(this).closest('tr').find('.js-quantities-input').val();
        if (unit_price === '' || unit_price <= 0) {
            $(this).closest('tr').find('.js-unit-price-input').addClass('danger');
            return;
        }
        if (quantities === '' || quantities <= 0) {
            $(this).closest('tr').find('.js-quantities-input').addClass('danger');
            return;
        }
        quantities = parseInt(quantities);
        unit_price = parseInt(unit_price);
        const sku = $(this).closest('tr').data('sku');
        const receipt_id = $('#js-receipt-id-info').text();
        $.ajax({
            url: `/admin/receipts/${receipt_id}`,
            type: 'POST',
            data: {
                sku,
                quantities,
                unit_price,
            },
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
    function debounce(func, wait) {
        //hàm đợi 1 thời gian rồi mới thực hiện
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

    const filterDetailedProducts = ({ page }) => {
        const search = $('#search-detailed-products').val();
        if (!page) {
            page = 1;
        }
        const url = `/admin/products/detailed_products?search=${search}&page=${page}`;
        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {
                let html = '';
                for (let i = 0; i < response.detailed_products.data.length; i++) {
                    const detailed_product = response.detailed_products.data[i];
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
                    <td>
                    <input class="js-unit-price-input unit-price-input"
                    type="number">
                    </td>
                    </td>
                    <td>
                    <div class="custom-table-action">
                    <input class="js-quantities-input quantities-input"
                        type="number">
                    <button class="js-add-product btn p-2">
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
                        current_page: response.detailed_products.current_page,
                        last_page: response.detailed_products.last_page,
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
})(jQuery);
