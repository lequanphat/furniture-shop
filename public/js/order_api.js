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

        function debounce(func, wait) { //hàm đợi 1 thời gian rồi mới thực hiện
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


        /////////////////////////////////hàm filter cho trang order chính để phân trang và earch ajax
        const filterOrders = ({ page }) => {
            const search = $('#search-orders').val();           //lấy value từ ô tìm kiếm bên index của orders
            const search_day_first = $('#day_first').val();     //lấy ngày đầu kiếm order trong 1 khoảng thời gian
            const search_day_last = $('#day_last').val();       //lấy ngày cuối kiếm order trong 1 khoảng thời gian
            const isChecked = $('#sort_by_last');               //2 dòng này lấy check để sort
            const sort_choose = isChecked.prop('checked');
            //alert(sort_choose);

            //alert(search_day_last);
            if (!page) {
                page = 1;
            }
            //url để tìm kiếm, lấy từ route /admin/orders/search , truyền qua hàm search_orders_ajax để nó lấy dữ liệu từ url và lọc
            const url = `/admin/orders/search?search=${search}&dayfirst=${search_day_first}&daylast=${search_day_last}&sortchoose=${sort_choose}&page=${page}`;


            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    //console.log(response);
                    console.log(response.order_for_ajax.data);

                    let html = '';//khi lấy dữ liệu thành công, bắt đầu đặt lại các dòng trong bảng theo kết quả từ orders
                    for(let item of response.order_for_ajax.data){ //từ bên controller search_warranties_ajax qua

                        //tính số ngày kể từ lúc tạo để coi nó có phải new không
                        const today = new Date();
                        const create_day = new Date(item.created_at);
                        const millisecondsDiff = today - create_day;
                        const daysDiff = Math.floor(millisecondsDiff / (1000 * 60 * 60 * 24));
                        let isnew ='';
                        if(daysDiff < 7){
                            isnew = '<span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>'
                        }

                        //kiểm tra trả tiền chưa
                        let ispaid ='';
                        switch(item.is_paid){
                            case 0: ispaid = '<span class="badge bg-yellow-lt">Pending Payment</span>'; break;
                            case 1: ispaid = '<span class="badge bg-green-lt">Payment Received</span>'; break;
                            default: ispaid = '<span class="badge bg-red-lt">Cant find data</span>'; break;
                        }

                        let status = '';
                        switch(item.status){
                            case 0: status = '<span class="badge bg-yellow-lt">Unconfirmed</span>'; break;
                            case 1: status = '<span class="badge bg-azure-lt">Confirmed</span>'; break;
                            case 2: status = '<span class="badge bg-purple-lt">In transit</span>'; break;
                            case 3: status = '<span class="badge bg-green-lt">Delivered</span>'; break;
                            case 4: status = '<span class="badge bg-red-lt">Canceled</span>'; break;
                            default: status = '<span class="badge bg-red-lt">Cant find data</span>'; break;
                        }

                        //phần này copy từ tbody ở index qua
                        html+=`
                        <tr>
                            <td>${item.order_id}</td>
                            <td>
                                <div class="d-flex py-1 align-items-center">
                                    <div class="flex-fill">
                                        <div class="font-weight-medium">
                                            ${item.receiver_name} - ${item.phone_number}
                                            ${isnew}
                                        </div>
                                        <div class="text-muted"><a href="#" class="text-reset">${item.address}</a></div>
                                    </div>
                                </div>
                            </td>
                            <td><span>${item.howmanydaysago}</span></td>
                            <td>${item.money}đ</td>
                            <td>${ispaid}</td>
                            <td>${status}</td>
                            <td>
                                <a href="/admin/orders/${item.order_id}" class="btn p-2" title="Details">
                                    <img src="${data_asset}svg/view.svg" style="width: 18px;" />
                                </a>

                                <button type="button" class="js-update-order-btn btn  mr-2 px-2 py-2"
                                    title="Update" data-bs-toggle="modal"
                                    data-bs-target="#update-order-modal"
                                    data-order-id="${item.order_id}"
                                    data-total-price="${item.total_price }"
                                    data-is-paid="${item.is_paid }"
                                    data-status="${item.status }"
                                    data-receiver-name="${ item.receiver_name }"
                                    data-address="${ item.address }"
                                    data-phone-number="${ item.phone_number }"
                                    data-customer-id="${ item.customer_id }"
                                    data-created-by="${ item.created_by }">
                                    <img src="${data_asset}svg/edit.svg" style="width: 18px;" />
                                </button>
                            </td>
                        </tr>`
                    }
                    $('#order-table').html(html); //rồi đặt lại bảng bằng dữ liệu đã được filter ra

                    //thanh phân trang dưới cùng, copy đổi tên biến đã trả từ controller search_orders_ajax là đc
                    let pagination = `<li class="page-item ${
                        response.order_for_ajax.current_page === 1 ? 'disabled' : ''
                    }">
                        <a class="page-link" href="#" data-page="${response.order_for_ajax.current_page - 1}">
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

                    for (let i = 0; i < response.order_for_ajax.last_page; i++) {
                        pagination += `
                            <li class="page-item ${
                                response.order_for_ajax.current_page === i + 1 ? 'active mx-1' : ''
                            }">
                                <a class="page-link " href="#" rel="first" data-page="${i + 1}">${i + 1}</a>
                            </li>`;
                    }

                    pagination += `<li class="page-item ${
                        response.order_for_ajax.current_page === response.order_for_ajax.last_page
                            ? 'disabled'
                            : ''
                    }">
                        <a class="page-link" href="#" data-page="${response.order_for_ajax.current_page + 1}">
                            next
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M9 6l6 6l-6 6" />
                            </svg>
                        </a>
                    </li>`;
                    $('.pagination').html(pagination);//sửa lại thanh pagination ở index
                },
                error: function (error) {
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
        //phần phân trang để chung ở dưới





        ///////////////////////////////// filter cho bảng dữ liệu, liên quan tới tìm kiếm và phân trang của order detail
        const filterDetailedProducts = ({ page }) => {
            const search = $('#search-detailed-products').val();    //lấy value từ ô tìm kiếm bên create_detailed_order
            if (!page) {
                page = 1;
            }
            const url = `/admin/products/detailed_products?search=${search}&page=${page}`;
            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    console.log('====================================');
                    console.log(response.detailed_products.data);
                    console.log('====================================');
                    const now = new Date();
                    now.setHours(0, 0, 0, 0); // Set the time to 00:00:00.000
                    let formatter = new Intl.NumberFormat('en-US', {
                        minimumFractionDigits: 0,
                    });
                    let html = '';            //khởi tạo biến html để hiển thị cho bảng thêm sản phẩm order
                    for (let i = 0; i < response.detailed_products.data.length; i++) {  //đối với mỗi dòng dữ liệu, tính giá tiền từ phần trăm discount
                        const detailed_product = response.detailed_products.data[i];
                        let discount_percentage = 0;
                        for (let j = 0; j < detailed_product.product_discounts.length; j++) {
                            const startDate = new Date(detailed_product.product_discounts[j].discount.start_date);
                            const endDate = new Date(detailed_product.product_discounts[j].discount.end_date);
                            if (startDate.getTime() <= now.getTime() && now.getTime() <= endDate.getTime()) {
                                discount_percentage += detailed_product.product_discounts[j].discount.percentage;
                            }
                        }
                        let unit_price =
                            detailed_product.original_price -
                            (detailed_product.original_price * discount_percentage) / 100;
                        let image = '';
                        if (detailed_product.images.length > 0) {
                            image = detailed_product.images[0].url;
                        }                                                           //sau khi tính xong bắt đầu tạo dòng html để hiển thị lên bảng
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
                            discount_percentage > 0
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
                                    <img src="${data_asset}svg/plus.svg"
                                        style="width: 18px;" />
                                </button>
                            </div>
                        </td>
                    </tr>`;
                    }
                    $('#detailed-products-table').html(html);   //mớ trên đó là tạo dữ liệu, giờ thì set dòng html đó vào bảng

                    // pagination, tạo dòng phân trang sau khi đã tạo các dòng dữ liệu
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
        // search filter của detail order
        $('#search-detailed-products').on(
            'input',
            debounce(function () {
                filterDetailedProducts({ page: 1 });
            }, 500),
        );

        // pagination cho trang order và detail order luôn
        $(document).on('click', '.pagination .page-link', function (event) {
            var button = $(event.target);
            const page = button.data('page');
            filterDetailedProducts({ page });
            filterOrders({page});
        });

        $(document).on('input', '.quantities-input', function () {
            var max = parseInt($(this).attr('max'));
            if (parseInt($(this).val()) > max) {
                $(this).val(max);
            } else if (parseInt($(this).val()) < 0) {
                $(this).val(parseInt($(this).val()));
            }
        });
        $(document).on('click', '.js-add-product', function (event) {
            const _this = this;
            let quantities = $(this).closest('tr').find('.quantities-input').val();
            if (quantities === '' || quantities <= 0) {
                alert('Please input quantities');
                return;
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
                    console.log(response);
                    const quantities_instance = $(_this).closest('tr').find('.js-detailed-product-quantities');
                    quantities_instance.text(parseInt(quantities_instance.text()) - quantities);
                    $(_this).closest('tr').find('.quantities-input').val(0);
                },
                error: function (error) {
                    console.log(error);
                },
            });
        });

        // on modal show


    });
})(jQuery);
