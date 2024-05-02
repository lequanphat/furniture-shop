jQuery.noConflict();

(function($) {
    $(document).ready(function() {
        const data_asset = $('#asset').attr('data-asset'); //lấy asset hình cho hàm filterWarranties

        $('#create-discount-form').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/admin/discounts/create',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#create_discount_response').removeClass('alert-danger d-none');
                    $('#create_discount_response').addClass('alert-success');
                    $('#create_discount_response').html(response.message);
                },
                error: function(error) {
                    $('#create_discount_response').removeClass('alert-success d-none');
                    $('#create_discount_response').addClass('alert-danger');
                    $('#create_discount_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });


        $('#delete-confirm-modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var discount_Id = button.data('discount-id');
            $(this).find('.modal-description').html(`If deleted, this brand will no longer be visible to Discount.`);
            $(this).find('#confirm-btn').data('discount-id', discount_Id);
            $(this).find('#confirm-btn').text('Yes, delete this ');
        });


        $('#delete-confirm-modal').on('click', '#confirm-btn', function(e) {
            var discount_id = $(this).data('discount-id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: `/admin/discounts/delete/${discount_id}`,
                type: 'DELETE',
                success: function(response) {
                    // var row = $('#discounts-table tr').filter(function () {
                    //     return $(this).find('td:first').text() == response.discount.discount_id;
                    // });
                    // if (row) {
                    //     row.html(``);
                    // }
                    // show success modal
                    $('#success-notify-modal').addClass('show');
                    $('#success-notify-modal').attr('style', 'display: block;');
                    $('#success-notify-modal').removeAttr('aria-hidden');
                    $('body').append('<div class="modal-backdrop fade show"></div>');

                    $('#success-title').html('Deleted Supplier Successfully');
                    $('#success-desc').html('This Supplier can not be able to access.');
                },
                error: function(error) {
                    // console.log(Object.values(error.responseJSON.errors)[0][0]);
                    $('#error-delete-modal').addClass('show');
                    $('#error-delete-modal').attr('style', 'display: block;');
                    $('#error-delete-modal').removeAttr('aria-hidden');
                    // $('body').append('<div class="modal-backdrop fade show"></div>');
                    // $('#error-message').text(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });
        //
        // $('.js-update-discount-btn').on('click', function() {
        //     $('#modal-discount-update #discount_id').val($(this).data('discount-id'));
        //     $('#modal-discount-update #title').val($(this).data('title'));
        //     $('#modal-discount-update #update_editor').val($(this).data('description'));
        //     $('#modal-discount-update #amount').val($(this).data('amount'));
        //     $('#modal-discount-update #startdate').val($(this).data('start-date'));
        //     $('#modal-discount-update #enddate').val($(this).data('end-date'));
        //     $('#modal-discount-update #percentage').val($(this).data('percentage'));
        //     $('#modal-discount-update #active').val($(this).data('is-active'));
        // });

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


        $('#Update-discount-form').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/admin/discounts/update',
                type: 'PATCH',
                data: formData,
                success: function(response) {
                    $('#update_discount_response').removeClass('alert-danger d-none');
                    $('#update_discount_response').addClass('alert-success');
                    $('#update_discount_response').html(response.message);

                    var row = $('#discounts-table tr').filter(function () {
                        return $(this).find('td:first').text() == response.discount_item.discount_id;
                    });
                    if (row) {
                        row.html(
                            createDiscountElement({
                                discount_item: response.discount_item,

                            }),
                        );
                    }
                },
                error: function(error) {
                    $('#update_discount_response').removeClass('alert-success d-none');
                    $('#update_discount_response').addClass('alert-danger');
                    $('#update_discount_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });

        function filterDiscount({ page }) {
            const search = $('#search').val();
            const type = $('#status_type').val();
const status =$('#status').val();
            // const sort = $('#select-discount-sort').val();
            history.pushState(null, null, `/admin/discounts?search=${search}&page=${page}&type=${type}&status=${status}`);
            // call ajax
            $.ajax({
                url: `/admin/discount/search?search=${search}&page=${page}&type=${type}&status=${status}`,
                type: 'GET',
                success: function(response) {
                    let html = ''; //khi lấy dữ liệu thành công, bắt đầu đặt lại các dòng trong bảng theo kết quả từ warranties
                    response.discounts.data.forEach((discount_item) => {
                        html += `<tr>${createDiscountElement({
                            discount_item,

                        })}</tr>`;
                    });
                    $('#discounts-table').html(html); //rồi đặt lại bảng bằng dữ liệu đã được filter ra

                    // hàm phân trang render pagination here
                    renderPagination({
                        current_page: response.discounts.current_page,
                        last_page: response.discounts.last_page,
                    });
                },
                error: function(error) {
                    console.log(error);
                },
            });
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
        function ceateDiscountDetail({discount_datail})
        {

        }

        function createDiscountElement({ discount_item }) {
            // const newTag = discount.new ? '<span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>' : '';


            let is_active = '';//tính giờ gian status còn bảo hành ko
            switch (discount_item.is_active){
                case 0:
                    is_active = '  <span class="badge bg-danger me-1"></span> Blocked';
                    break;
                case 1:
                    is_active = ' <span class="badge bg-success me-1"></span> Active';
                    break;
                default:
                    is_active  = 'error';
                    break;
            }




            const update_action = ` <button class="btn p-2 d-none d-sm-inline-block  js-update-discount-btn" data-bs-toggle="modal" data-bs-target="#modal-discount-update" data-discount-id="${discount_item.discount_id}" data-title="${discount_item.title}" data-description="${discount_item.description}"  data-start-date="${discount_item.start_date}" data-end-date="${discount_item.end_date}" data-is-active="${discount_item.is_active}" data-percentage="${discount_item.percentage}">
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
            </button>`;

            const delete_action = `
                                                <button data-bs-toggle="modal" data-bs-target="#delete-confirm-modal"
                                                      data-discount-id="${discount_item.discount_id}"  class="btn p-2">
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
                                                </button>

          `;
            const view_action = `   <a href="/admin/discounts/viewDetail/${discount_item.discount_id}"class="btn p-2">

<svg

                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                        <path
                                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                    </svg>

          </a>`;

            return `
            <td>${discount_item.discount_id}</td>
            <td>${discount_item.title}</td>
            <td>${discount_item.percentage}</td>

            <td>${discount_item.start_date}</td>
            <td>${discount_item.end_date}</td>

            <td>${is_active}</td>




            <td>${update_action} ${delete_action} ${view_action}</td>



        `;
        }

        $(document).on('click', '.js-discount-pagination .pagination .page-link', function(event) {
            var button = $(event.target);
            const page = button.data('page');
            filterDiscount({ page });
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

        // search with ajax
        $('#search').on(
            'input',
            debounce(function() {
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
        $('#select-roles-sort').change(function() {
            rolesPagination({ page: 1 });
        });
    });
})(jQuery);
