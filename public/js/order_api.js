jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        function createOrderElement({ order }) {
            const newTag = order.new
                ? `<span
            class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>`
                : '';
            let is_paid = '';
            switch (order.is_paid) {
                case 0:
                    is_paid = '<span class="badge bg-yellow-lt">Pending Payment</span>';
                    break;
                case 1:
                    is_paid = '<span class="badge bg-green-lt">Payment Received</span>';
                    break;
                default:
                    is_paid = '';
                    break;
            }
            let status = '';
            switch (order.status) {
                case 0:
                    status = '<span class="badge bg-yellow-lt">Unconfirmed</span>';
                    break;
                case 1:
                    status = '<span class="badge bg-azure-lt">Confirmed</span>';
                    break;
                case 2:
                    status = '<span class="badge bg-purple-lt">In transit</span>';
                    break;
                case 3:
                    status = '<span class="badge bg-green-lt">Delivered</span>';
                    break;
                case 4:
                    status = '<span class="badge bg-red-lt">Canceled</span>';
                    break;
                default:
                    status = '';
                    break;
            }
            const view_action = `<a href="/admin/orders/${order.order_id}" class="btn p-2" title="Details">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-eye">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                    <path
                        d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                </svg>
            </a>`;
            const update_action = ` <button type="button" class="js-update-order-btn btn  mr-2 px-2 py-2"
                title="Update" data-bs-toggle="modal"
                data-bs-target="#update-order-modal"
                data-order-id="${order.order_id}"
                data-total-price="${order.total_price}"
                data-is-paid="${order.is_paid}"
                data-status="${order.status}"
                data-receiver-name="${order.receiver_name}"
                data-address="${order.address}"
                data-phone-number="${order.phone_number}"
                data-customer-id="${order.customer_id}"
                data-created-by="${order.created_by}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-pencil">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                    <path d="M13.5 6.5l4 4" />
                </svg>
            </button>`;
            return `<td>${order.order_id}</td>
                <td>
                    <div class="d-flex py-1 align-items-center">
                        <div class="flex-fill">
                            <div class="font-weight-medium">
                                ${order.receiver_name} - ${order.phone_number}
                                ${newTag}
                            </div>
                            <div class="text-muted"><a href="#" class="text-reset">${order.address}</a></div>
                        </div>
                    </div>
                </td>
                <td><span>${order.howmanydaysago}</span></td>
                <td class="text-danger">${order.money}đ</td>
                <td>${is_paid}</td>
                <td>${status}</td>
                <td>
                    ${view_action}
                    ${update_action}
                
                </td>`;
        }
        $('#order-modal').on('show.bs.modal', function (event) {
            $('#create-order-form')[0].reset();
            $('#create_order_response').addClass('d-none');
            console.log('order-modal');
        });

        $('#create-order-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/admin/orders',
                type: 'POST',
                data: formData,
                success: function (response) {
                    console.log(response);
                    $('#create_order_response').removeClass('d-none');
                    $('#create_order_response').removeClass('alert-danger');
                    $('#create_order_response').addClass('alert-success');
                    $('#create_order_response').html(response.message);
                },
                error: function (error) {
                    console.log(error);
                    $('#create_order_response').removeClass('d-none');
                    $('#create_order_response').removeClass('alert-success');
                    $('#create_order_response').addClass('alert-danger');
                    $('#create_order_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });
        $('#create-order-form').on('reset', function () {
            $('#create_order_response').html('');
            $('#create_order_response').removeClass('alert-success alert-danger');
            $('#create_order_response').addClass('d-none');
        });

        $('#update-order-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('#updateOrderTitle').html('Update Order - ' + button.data('order-id'));
            modal.find('#updateOrderTitle').data('order-id', button.data('order-id'));
            modal.find('#order_id').val(button.data('order-id'));
            modal.find('#totalPrice').val(button.data('total-price'));
            if (button.data('is-paid')) {
                modal.find('#paid').attr('checked', true);
            } else modal.find('#paid').attr('checked', false);
            modal.find('#status').val(button.data('status'));
            modal.find('#receiver_name').val(button.data('receiver-name'));
            modal.find('#address').val(button.data('address'));
            modal.find('#phone_number').val(button.data('phone-number'));
            if (button.data('customer-id') === '') {
                modal.find('#customer_id').val(-1);
            } else {
                modal.find('#customer_id').val(button.data('customer-id'));
            }

            $('#update_order_response').addClass('d-none');
        });
        $('#update-order-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            const order_id = $('#updateOrderTitle').data('order-id');
            $.ajax({
                url: `/admin/orders/${order_id}`,
                type: 'PUT',
                data: formData,
                success: function (response) {
                    console.log({ response });
                    // Handle the success response
                    $('#update_order_response').removeClass('d-none');
                    $('#update_order_response').removeClass('alert-danger');
                    $('#update_order_response').addClass('alert-success');
                    $('#update_order_response').html(response.message);
                },
                error: function (error) {
                    console.log({ error });
                    // Handle the error response
                    $('#update_order_response').removeClass('d-none');
                    $('#update_order_response').removeClass('alert-success');
                    $('#update_order_response').addClass('alert-danger');
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
        /////////////////////////////////hàm filter cho trang order chính để phân trang và earch ajax
        const filterOrders = ({ page }) => {
            const search = $('#search-orders').val(); //lấy value từ ô tìm kiếm bên index của orders
            const search_day_first = $('#day_first').val(); //lấy ngày đầu kiếm order trong 1 khoảng thời gian
            const search_day_last = $('#day_last').val(); //lấy ngày cuối kiếm order trong 1 khoảng thời gian
            const sort = $('#sort_by_last').val();
            const type = $('#type').val();

            history.pushState(
                null,
                null,
                `/admin/orders?page=${page}&type=${type}&search=${search}&dayfirst=${search_day_first}&daylast=${search_day_last}&sort=${sort}`,
            );

            //alert(search_day_last);
            if (!page) {
                page = 1;
            }
            //url để tìm kiếm, lấy từ route /admin/orders/search , truyền qua hàm search_orders_ajax để nó lấy dữ liệu từ url và lọc
            const url = `/admin/orders/search?page=${page}&type=${type}&search=${search}&dayfirst=${search_day_first}&daylast=${search_day_last}&sort=${sort}`;

            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    //console.log(response);

                    let html = '';
                    if (response.order_for_ajax.data.length == 0) {
                        html = '<tr><td colspan="7" class="text-center text-muted">No data available</td></tr>';
                    } else {
                        html = '';
                        for (let item of response.order_for_ajax.data) {
                            html += `<tr>${createOrderElement({ order: item })}</tr>`;
                        }
                    }
                    $('#order-table').html(html);

                    // render pagination here
                    $('.js-orders-pagination .pagination').html(
                        renderPagination({
                            current_page: response.order_for_ajax.current_page,
                            last_page: response.order_for_ajax.last_page,
                        }),
                    );
                },
                error: function (error) {
                    alert('error');
                    console.log(error);
                },
            });
        };

        // search filter của chỉ order thôi
        $('#search-orders').on(
            'input',
            debounce(function () {
                filterOrders({ page: 1 });
            }, 500),
        );
        $('#day_first').on(
            'input',
            debounce(function () {
                filterOrders({ page: 1 });
            }, 500),
        );
        $('#day_last').on(
            'input',
            debounce(function () {
                filterOrders({ page: 1 });
            }, 500),
        );
        $('#sort_by_last').on(
            'input',
            debounce(function () {
                filterOrders({ page: 1 });
            }, 500),
        );

        $('#type').on(
            'input',
            debounce(function () {
                filterOrders({ page: 1 });
            }, 500),
        );

        $(document).on('click', '.js-orders-pagination .pagination .page-link', function (event) {
            var button = $(event.target);
            const page = button.data('page');
            filterOrders({ page });
        });

        //phần phân trang để chung ở dưới

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
                    let formatter = new Intl.NumberFormat('en-US', {
                        minimumFractionDigits: 0,
                    });
                    let html = '';
                    for (let i = 0; i < response.detailed_products.data.length; i++) {
                        const detailed_product = response.detailed_products.data[i];
                        const image = detailed_product.images.length > 0 ? detailed_product.images[0].url : '';
                        const total_discount_percentage = detailed_product.total_discount_percentage;
                        const unit_price =
                            detailed_product.original_price -
                            detailed_product.original_price * (total_discount_percentage / 100);
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
                        <td>
                        ${
                            total_discount_percentage > 0
                                ? `<del>${formatter.format(detailed_product.original_price)}đ</del>`
                                : ''
                        }
                            <p class="js-unit-price text-danger m-0" data-unit-price="${unit_price}">
                                ${formatter.format(unit_price)}đ
                            </p>
                        </td>
                        </td>
                        <td>
                            <div class="custom-table-action">
                            ${
                                detailed_product.quantities > 0
                                    ? `<input class="quantities-input" type="number" max="${detailed_product.quantities}">`
                                    : ''
                            }
                                <button class="js-add-product btn p-2"
                                ${detailed_product.quantities == 0 ? 'disabled' : ''} >
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
                    $('#detailed-products-table').html(html); //mớ trên đó là tạo dữ liệu, giờ thì set dòng html đó vào bảng

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
        // search filter của detail order
        $('#search-detailed-products').on(
            'input',
            debounce(function () {
                filterDetailedProducts({ page: 1 });
            }, 500),
        );

        $(document).on('click', ' .js-detailed-products-pagination .pagination .page-link', function (event) {
            var button = $(event.target);
            const page = button.data('page');
            filterDetailedProducts({ page });
        });

        $(document).on('input', '.quantities-input', function () {
            var max = parseInt($(this).attr('max'));
            if (parseInt($(this).val()) > max) {
                $(this).val(max);
            } else if (parseInt($(this).val()) < 0) {
                $(this).val(parseInt($(this).val()));
            }
        });

        $(document).on('input', '.quantities-input', function (event) {
            $(this).removeClass('danger');
        });

        $(document).on('click', '.js-add-product', function (event) {
            let quantities = $(this).closest('tr').find('.quantities-input').val();
            if (quantities === '' || quantities <= 0) {
                $(this).closest('tr').find('.quantities-input').addClass('danger');
            }
            quantities = parseInt(quantities);
            const sku = $(this).closest('tr').data('sku');
            const order_id = $('#js-order-id-info').text();
            const unit_price = $(this).closest('tr').find('.js-unit-price').data('unit-price');
            console.log('add product', quantities, sku, order_id, unit_price);

            $.ajax({
                url: `/admin/orders/${order_id}`,
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
                    window.location.reload();
                },
                error: function (error) {
                    console.log(error);
                },
            });
        });

        // on modal show
    });
})(jQuery);
