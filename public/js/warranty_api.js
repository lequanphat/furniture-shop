jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
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

        //phân trang

    });
})(jQuery);
