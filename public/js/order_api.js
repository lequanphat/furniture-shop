jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        const data_asset = $('#asset').attr('data-asset');
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

        // filter
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
                    console.log(response);

                    const now = new Date();
                    now.setHours(0, 0, 0, 0); // Set the time to 00:00:00.000
                    let formatter = new Intl.NumberFormat('en-US', {
                        minimumFractionDigits: 0,
                    });
                    let html = '';
                    for (let i = 0; i < response.detailed_products.data.length; i++) {
                        const detailed_product = response.detailed_products.data[i];
                        let discount_percentage = 0;
                        for (let j = 0; j < detailed_product.product_discounts.length; j++) {
                            const startDate = new Date(detailed_product.product_discounts[j].discount.start_date);
                            const endDate = new Date(detailed_product.product_discounts[j].discount.end_date);
                            if (startDate.getTime() <= now.getTime() && now.getTime() <= endDate.getTime()) {
                                discount_percentage += detailed_product.product_discounts[j].discount.percentage;
                            }
                        }

                        let image = '';
                        if (detailed_product.images.length > 0) {
                            image = detailed_product.images[0].url;
                        }
                        html += `<tr>
                        <td>
                            <div class="d-flex py-1 align-items-center">
                                <span class="avatar me-2"
                                    style="background-image: url(${image}); width: 40px; height: 40px;">
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
                        <td>${detailed_product.quantities}</td>
                        <td>
                        ${
                            discount_percentage > 0
                                ? `<del>${formatter.format(detailed_product.original_price)}đ</del>`
                                : ''
                        }
                            <p class="text-danger m-0">
                                ${formatter.format(
                                    detailed_product.original_price -
                                        (detailed_product.original_price * discount_percentage) / 100,
                                )}đ
                            </p>
                        </td>
                        </td>
                        <td>
                            <div class="custom-table-action">
                            ${detailed_product.quantities > 0 ? '<input class="quantities-input" type="number">' : ''}
                                <button class="btn p-2"
                                ${detailed_product.quantities == 0 ? 'disabled' : ''} >
                                    <img src="${data_asset}svg/plus.svg"
                                        style="width: 18px;" />
                                </button>
                            </div>
                        </td>
                    </tr>`;
                    }
                    $('#detailed-products-table').html(html);

                    // pagination
                    let pagination = `<li class="page-item ${
                        response.detailed_products.current_page === 1 ? 'disabled' : ''
                    }">
                    <a class="page-link" href="#" data-page="${response.detailed_products.current_page - 1}">
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

                    for (let i = 0; i < response.detailed_products.last_page; i++) {
                        pagination += `
                            <li class="page-item ${
                                response.detailed_products.current_page === i + 1 ? 'active mx-1' : ''
                            }">
                                <a class="page-link " href="#" rel="first" data-page="${i + 1}">${i + 1}</a>
                            </li>`;
                    }
                    pagination += `<li class="page-item ${
                        response.detailed_products.current_page === response.detailed_products.last_page
                            ? 'disabled'
                            : ''
                    }">
                    <a class="page-link" href="#" data-page="${response.detailed_products.current_page + 1}">
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
                },
                error: function (error) {
                    console.log(error);
                },
            });
        };
        // search filter
        $('#search-detailed-products').on(
            'input',
            debounce(function () {
                filterDetailedProducts({ page: 1 });
            }, 500),
        );

        // pagination
        $(document).on('click', '.pagination .page-link', function (event) {
            var button = $(event.target);
            const page = button.data('page');
            console.log({ page });
            filterDetailedProducts({ page });
        });
    });
})(jQuery);
