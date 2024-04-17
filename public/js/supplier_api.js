jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        const data_asset = $('#asset').attr('data-asset');
        $('#js-create-supplier-btn').click(() => {
            $('#createEmployeeModal').modal('show');
            $('#create-supplier-form')[0].reset();
            // $('#create_category_response').html('');
            // $('#create_category_response').removeClass('alert-success alert-danger');
        });
        
        $('#create-supplier-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/admin/suppliers/create',
                type: 'POST',
                data: formData,
                success: function (response) {
                    console.log(response);
                    $('#create_supplier_response').removeClass('alert-danger');
                    $('#create_supplier_response').addClass('alert-success');
                    $('#create_supplier_response').html(response.message);
                    $('#supplier-table').append(
                        `<tr>
                        <td>${response.supplier.supplier_id}</td>

                        <td>${response.supplier.name }</td>
                        <td>
                        ${response.supplier.description }
                        </td>
                        <td> ${response.supplier.address }</td>
                        <td>${response.supplier.phone_number }</td>
                        {{-- temporary value --}}
                        <td>
                            <button type="button" class="js-update-category-btn btn  mr-2 px-2 py-1"
                                data-bs-toggle="modal" data-bs-target="#UpdateSupplierModal"
                                data-supplier-id="${response.supplier.supplier_id}<"
                                data-name="${response.supplier.name }}"
                                data-description=" ${response.supplier.description }"
                                data-address="${response.supplier.address }"
                                data-phone-number="${response.supplier.phone_number }">
                                <img src="${data_asset}svg/edit.svg" style="width: 18px;" />
                            </button>

                        </td>`
                    )
                },
                error: function (error) {
                    console.log(error);
                    $('#create_supplier_response').removeClass('alert-success');
                    $('#create_supplier_response').addClass('alert-danger');
                    $('#create_supplier_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });
        $('#create-supplier-form').on('reset', function () {
            $('#create_brand_response').html('');
            $('#create_brand_response').removeClass('alert-success alert-danger');
            $('#create_brand_response').addClass('d-none');
        });
        $('#UpdateSupplierModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('#updateSupplierTitle').html('Update Supplier - ' + button.data('supplier-id'));
            modal.find('#supplier_id').val(button.data('supplier-id'));
            modal.find('#name').val(button.data('name'));
            modal.find('#description').val(button.data('description'));
            modal.find('#address').val(button.data('address'));
            modal.find('#phone_number').val(button.data('phone-number'));
        });

        $('#update-supplier-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            console.log({ formData });
            // console.log()
            $.ajax({
                url: `/admin/suppliers/update`,
                type: 'PUT',
                data: formData,
                success: function (response) {
                    console.log({ response });
                    // Handle the success response
                    $('#update_supplier_response').removeClass('alert-danger');
                    $('#update_supplier_response').addClass('alert-success');
                    $('#update_supplier_response').html(response.message);
                    var row = $('#supplier-table tr').filter(function () {
                        return $(this).find('td:first').text() == response.supplier.supplier_id;
                    });
                    if (row)
                    {
                        row.html(`
                        <td>${response.supplier.supplier_id}</td>

                        <td>${response.supplier.name }</td>
                        <td>
                        ${response.supplier.description }
                        </td>
                        <td> ${response.supplier.address }</td>
                        <td>${response.supplier.phone_number }</td>
                        {{-- temporary value --}}
                        <td>
                            <button type="button" class="js-update-category-btn btn  mr-2 px-2 py-1"
                                data-bs-toggle="modal" data-bs-target="#UpdateSupplierModal"
                                data-supplier-id="${response.supplier.supplier_id}"
                                data-name="${response.supplier.name }"
                                data-description=" ${response.supplier.description }"
                                data-address="${response.supplier.address }"
                                data-phone-number="${response.supplier.phone_number }">
                                <img src="${data_asset}svg/edit.svg" style="width: 18px;" />
                            </button>

                        </td>`)
                    }
                },
                error: function (error) {
                    console.log({ error });
                    // Handle the error response
                    $('#update_supplier_response').removeClass('alert-success');
                    $('#update_supplier_response').addClass('alert-danger');
                    // $('#update_brand_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });
        function createSupplierElement(supplier)
        {
            return `<tr>
            <td>${supplier.supplier_id}</td>

            <td>${supplier.name }</td>
            <td>
            ${supplier.description }
            </td>
            <td> ${supplier.address }</td>
            <td>${supplier.phone_number }</td>
            {{-- temporary value --}}
            <td>
                <button type="button" class="js-update-category-btn btn  mr-2 px-2 py-1"
                    data-bs-toggle="modal" data-bs-target="#UpdateSupplierModal"
                    data-supplier-id="${supplier.supplier_id}<"
                    data-name="${supplier.name }}"
                    data-description=" ${supplier.description }"
                    data-address="${supplier.address }"
                    data-phone-number="${supplier.phone_number }">
                    <img src="${data_asset}svg/edit.svg" style="width: 18px;" />
                </button>

            </td>`;
        }
    function SupplierPagination({ page }) {
        const search = $('#search-supplier-input').val();
        history.pushState(null, null, `/admin/suppliers?page=${page}&search=${search}`);
        // call ajax
        $.ajax({
            url: `/admin/suppliers/pagination?page=${page}&search=${search}`,
            type: 'GET',
            success: function (response) {
                console.log(response);
                let html = '';
                response.suppliers.data.forEach((supplier) => {
                    html += createSupplierElement(supplier);
                });
                $('#supplier-table').html(html);
                renderPagination({
                    current_page: response.suppliers.current_page,
                    last_page: response.suppliers.last_page,
                });
            },
            error: function (error) {
                console.log(error);
            },
        });
    };
        $(document).on('click', '.pagination .page-link', function (event) {
            var button = $(event.target);
            const page = button.data('page');
            SupplierPagination({ page });
        });
        $('#search-supplier-input').on(
            'input',
            debounce(function () {
                SupplierPagination({ page: 1 });
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
        }});
    })(jQuery); 