jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        //file phải được khai báo ở views/admin/components/link-script.blade.php

        //hàm tạo order
        $('#js-create-order-btn').click(() => {
            $('#createEmployeeModal').modal('show');
            $('#create-order-form')[0].reset();
            // $('#create_category_response').html('');
            // $('#create_category_response').removeClass('alert-success alert-danger');
        });

        $('#create-order-form').submit(function (e) {
            //khi nhấn submit trên form thì vào hàm này
            e.preventDefault(); //chặn lại form gửi theo mặc định để vào hàm này xử lý
            var formData = $(this).serialize(); //dùng phương thức serialize để chuyển dữ liệu form thành định dạng 1 chuỗi query (để xuống gửi chung với ajax)
            $.ajax({
                //hàm ajax thường để gửi request HTTP không đồng bộ tới server
                url: '/admin/orders/create', //đoạn url tới chỗ xử lý request tạo(thường trỏ tới controller hoặc API biết tạo order dựa trên dữ liệu gửi)
                type: 'POST', //method POST tạo dữ liệu trên server
                data: formData, //dữ liệu đi chung để tạo order
                success: function (response) {
                    //hàm nếu cái ajax request thành công
                    console.log(response);
                    $('#create_order_response').removeClass('alert-danger'); //bỏ class css alert-danger để hiển thị cái mới
                    $('#create_order_response').addClass('alert-success'); //thêm class css để thông báo cái mới
                    $('#create_order_response').html(response.message); //chỉnh lại trên file html ở cái id đó với cái message gửi từ respone của server
                },
                error: function (error) {
                    //hàm nếu lỗi, tương tự như trên
                    console.log(error);
                    $('#create_order_response').removeClass('alert-success');
                    $('#create_order_response').addClass('alert-danger');
                    $('#create_order_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
            //note: ở url nó gọi tới /admin/orders/create, cái này không phải là hàm controller nhưng ở route, đoạn url này đã được
            //xác định cho hàm ở controller nên nó cũng vào đó
        });
        $('#create-order-form').on('reset', function () {
            $('#create_order_response').html('');
            $('#create_order_response').removeClass('alert-success alert-danger');
            $('#create_order_response').addClass('d-none');
        });

        //hàm show dữ liệu của hàng được chọn lên form sửa
        //id UpdateOrderModal đc gắn với event listener show.bs.modal (cái event này được khởi động bởi bootstrap trước modal đc hiển thị ra)
        $('#UpdateOrderModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); //biến lưu đối tượng jQuery đại diện cho cái nút triggerd mở modal
            var modal = $(this); //biến lưu đối tượng jQuery của toàn bộ cái modal
            modal.find('#updateOrderTitle').html('Update Order number ' + button.data('order-id')); //tìm id updateOrderTitle rồi sửa cái nội dung html của đối tượng có id đó
            modal.find('#order_id').val(button.data('order-id')); //tìm đối tượng có id đó trong form rồi sửa value nó thành dữ liệu có id là brand-id được lưu trong button
            modal.find('#totalPrice').val(button.data('total-price'));
            modal.find('#paid').val(button.data('is-paid'));
            modal.find('#status').val(button.data('status'));
            modal.find('#receiver_name').val(button.data('receiver-name'));
            modal.find('#address').val(button.data('address'));
            modal.find('#phone_number').val(button.data('phone-number'));
            modal.find('#customer_id').val(button.data('customer-id'));
            //modal.find('#employee_id').val(button.data('created-by'));
        });
        //hàm sửa dữ liệu order
        $('#update-order-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            console.log({ formData });
            $.ajax({
                url: `/admin/orders/update`,
                type: 'PUT',
                data: formData,
                success: function (response) {
                    //console.log({ response });
                    // Handle the success response
                    $('#update_order_response').removeClass('alert-danger');
                    $('#update_order_response').addClass('alert-success');
                    $('#update_order_response').html(response.message);
                },
                error: function (error) {
                    //console.log({ error });
                    // Handle the error response
                    $('#update_order_response').removeClass('alert-success');
                    $('#update_order_response').addClass('alert-danger');
                },
            });
        });


        //hàm lấy giá trị đc chọn từ select rồi gửi yêu cầu ajax đến controller
        $('#select_status_for_table').on('change', function() {
            var statusnum = $(this).val();

            // Gửi yêu cầu Ajax đến controller
            $.ajax({
                url: "/admin/orders",
                method: "GET",
                data: {
                    status: statusnum,
                },
                success: function(response) {
                    // Hiển thị dữ liệu được trả về từ controller vào table
                    var data = response.data;
                    // ...
                }
            });
        });
    });
})(jQuery);
