jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        const data_asset = $('#asset').attr('data-asset'); //lấy asset hình cho hàm filterWarranties

        $('#warranty-modal').on('show.bs.modal', function (event) {
            $('#create-warranty-form')[0].reset();
            $('#create_warranty_response').addClass('d-none');
            console.log('warranty-modal');
        });

        $('#create-warranty-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/admin/warranties/create', //đoạn url tới chỗ xử lý request tạo(thường trỏ tới controller hoặc API biết tạo order dựa trên dữ liệu gửi)
                type: 'POST', //method POST tạo dữ liệu trên server
                data: formData, //dữ liệu đi chung để tạo order
                success: function (response) {
                    //hàm nếu cái ajax request thành công
                    console.log(response);
                    $('#create_warranty_response').removeClass('d-none');
                    $('#create_warranty_response').removeClass('alert-danger'); //bỏ class css alert-danger để hiển thị cái mới
                    $('#create_warranty_response').addClass('alert-success'); //thêm class css để thông báo cái mới
                    $('#create_warranty_response').html(response.message); //chỉnh lại trên file html ở cái id đó với cái message gửi từ respone của server
                },
                error: function (error) {
                    //hàm nếu lỗi, tương tự như trên
                    console.log(error);
                    $('#create_warranty_response').removeClass('d-none');
                    $('#create_warranty_response').removeClass('alert-success');
                    $('#create_warranty_response').addClass('alert-danger');
                    $('#create_warranty_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
            //note: ở url nó gọi tới /admin/orders/create, cái này không phải là hàm controller nhưng ở route, đoạn url này đã được
            //xác định cho hàm ở controller nên nó cũng vào đó
        });
        $('#create-warranty-form').on('reset', function () {
            $('#create_warranty_response').html('');
            $('#create_warranty_response').removeClass('alert-success alert-danger');
            $('#create_warranty_response').addClass('d-none');
        });



        //hàm sửa warranty
        $('#UpdateWarrantyModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('#updateWarrantyTitle').html('Update Warranty - ' + button.data('warranty-id')); //tìm id updateOrderTitle rồi sửa cái nội dung html của đối tượng có id đó
            modal.find('#updateWarrantyTitle').data('warranty-id', button.data('warranty-id'));
            modal.find('#orderID').val(button.data('order-id')); //tìm đối tượng có id đó trong form rồi sửa value nó thành dữ liệu có id là brand-id được lưu trong button
            modal.find('#product_detail_ID').val(button.data('sku'));
            modal.find('#start_date').val(button.data('start-date'));
            modal.find('#description').val(button.data('description'));
            $('#update_warranty_response').addClass('d-none');
        });

        //hàm sửa warranty
        $('#update-warranty-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            const warranty_id = $('#updateWarrantyTitle').data('warranty-id');
            $.ajax({
                url: `/admin/warranties/${warranty_id}`,
                type: 'PUT',
                data: formData,
                success: function (response) {
                    console.log({ response });
                    // Handle the success response
                    $('#update_warranty_response').removeClass('d-none');
                    $('#update_warranty_response').removeClass('alert-danger');
                    $('#update_warranty_response').addClass('alert-success');
                    $('#update_warranty_response').html(response.message);
                },
                error: function (error) {
                    console.log({ error });
                    // Handle the error response
                    $('#update_warranty_response').removeClass('d-none');
                    $('#update_warranty_response').removeClass('alert-success');
                    $('#update_warranty_response').addClass('alert-danger');
                },
            });
        });


        //////////////////////////////////////////////////////////////////////////
        // Phần search và phân trang bằng ajax bắt đầu từ đây
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

        //hàm phân trang
        function renderPagination({ current_page, last_page }) {
            //thanh phân trang dưới cùng, copy đổi tên biến đã trả từ controller search_warranties_ajax là đc
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
            $('.pagination').html(pagination); //sửa lại thanh pagination ở index
        }

        //hàm tạo đối tượng để add vào bảng
        function createWarrantyElement({ warranty }){
            let status = '';//tính giờ gian status còn bảo hành ko
            switch (warranty.is_active){
                case false:
                    status = '<span class="badge bg-red-lt">Not within</span>';
                    break;
                case true:
                    status = '<span class="badge bg-green-lt">Still on</span>';
                    break;
                default:
                    status = 'error';
                    break;
            }

            const update_button = `
            <button type="button" class="js-update-order-btn btn  mr-2 px-2 py-1"
                title="Update" data-bs-toggle="modal" data-bs-target="#UpdateWarrantyModal"
                data-warranty-id="${warranty.warranty_id}"
                data-order-id="${warranty.order_id }"
                data-sku="${warranty.sku }"
                data-start-date="${warranty.start_date }"
                data-description="${warranty.description}">
                <img src="${data_asset}svg/edit.svg" style="width: 18px;" />
            </button>
            `;
            return `
                <td>${warranty.warranty_id}</td>
                <td>${warranty.order_id }</td>
                <td>${warranty.sku }</td>
                <td>${warranty.start_date }</td>
                <td>${warranty.end_date }</td>
                <td>${warranty.description}</td>
                <td>${warranty.product_detail.warranty_month} months</td>
                <td>${status}</td>
                <td>${update_button}</td>
            `;
        }


        // filter cho bảng, phần này load lại bảng với phần dữ liệu được trả về từ controller search_warranties_ajax
        const filterWarranties = ({ page }) => {
            const search = $('#search-warranties').val();           //lấy value từ ô tìm kiếm bên index của warranties
            const search_day_first = $('#search_day_first').val();  //lấy ngày đầu kiếm order trong 1 khoảng thời gian
            const search_day_last = $('#search_day_last').val();    //lấy ngày cuối kiếm order trong 1 khoảng thời gian
            const status_type = $('#status_type').val();            //lấy trạng thái trong hạn bảo hành hay không
            const sort_by = $('#sort_by').val();                    //sắp xếp lại

            history.pushState(  //đẩy giá trị lên thanh địa chỉ
                null,
                null,
                `/admin/warranties/search?search=${search}&searchdayfirst=${search_day_first}&searchdaylast=${search_day_last}&statustype=${status_type}&sortby=${sort_by}&page=${page}`,
            );

            if (!page) {
                page = 1;
            }

            //url để tìm kiếm, lấy từ route /admin/warranties/search
            const url = `/admin/warranties/search?search=${search}&searchdayfirst=${search_day_first}&searchdaylast=${search_day_last}&statustype=${status_type}&sortby=${sort_by}&page=${page}`;


            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    console.log(response);
                    console.log(response.warranties);

                    let html = '';//khi lấy dữ liệu thành công, bắt đầu đặt lại các dòng trong bảng theo kết quả từ warranties
                    for(let item of response.warranties.data){ //từ bên controller search_warranties_ajax qua
                        // let statusSpan;
                        // if (item.is_active) {
                        //     statusSpan = '<span class="badge bg-green-lt">Still on</span>';
                        // } else {
                        //     statusSpan = '<span class="badge bg-red-lt">Not within</span>';
                        // }
                        html+=`<tr>${createWarrantyElement({ warranty : item })}</tr>`;
                    }
                    $('#warranties-list').html(html); //rồi đặt lại bảng bằng dữ liệu đã được filter ra

                    // hàm phân trang render pagination here
                    renderPagination({
                        current_page: response.warranties.current_page,
                        last_page: response.warranties.last_page,
                    });
                },
                error: function (error) {
                    alert('error')
                    console.log(error);
                },
            });
        };

        // search filter
        $('#search-warranties').on(
            'input',
            debounce(function () {
                filterWarranties({ page: 1 });
            }, 500),
        );
        $('#search_day_first').on(
            'input',
            debounce(function () {
                filterWarranties({ page: 1 });
            }, 500),
        );
        $('#search_day_last').on(
            'input',
            debounce(function () {
                filterWarranties({ page: 1 });
            }, 500),
        );
        $('#status_type').on(
            'input',
            debounce(function () {
                filterWarranties({ page: 1 });
            }, 500),
        );
        $('#sort_by').on(
            'input',
            debounce(function () {
                filterWarranties({ page: 1 });
            }, 500),
        );

        // kích hoạt pagination
        $(document).on('click', '.pagination .page-link', function (event) {
            var button = $(event.target);
            const page = button.data('page');
            filterWarranties({ page });
        });

    });
})(jQuery);
