jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        const data_asset = $('#asset').attr('data-asset');
        $('#js-create-brand-btn').click(() => {
            $('#createEmployeeModal').modal('show');
            $('#create-brand-form')[0].reset();
            // $('#create_category_response').html('');
            // $('#create_category_response').removeClass('alert-success alert-danger');
        });
        
        $('#create-brand-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/admin/brands/create',
                type: 'POST',
                data: formData,
                success: function (response) {
                    console.log(response);
                    $('#create_brand_response').removeClass('alert-danger');
                    $('#create_brand_response').addClass('alert-success');
                    $('#create_brand_response').html(response.message);
                    $('#brand-table').append(`
                    <tr>
                    <td>${response.brand.brand_id }</td>
                    <td>${response.brand.name }</td>
                    <td>
                    ${response.brand.description }
                    </td>
                    <td>${response.brand.index }</td>
                    <td>
                        <button type="button" class="js-update-brand-btn btn  mr-2 px-2 py-1"
                            data-bs-toggle="modal" data-bs-target="#UpdateBrandModal"
                            data-brand-id="${response.brand.brand_id }" data-name="${response.brand.brand_id }"
                            data-description="   ${response.brand.description }"
                            data-index="${response.brand.index }"
                            data-parent-id="${response.brand.parent_id }">
                            <img src="${data_asset}svg/edit.svg" style="width: 18px;" />
                        </button>
                    </td>`
            )},
                error: function (error) {
                    console.log(error);
                    $('#create_brand_response').removeClass('alert-success');
                    $('#create_brand_response').addClass('alert-danger');
                    $('#create_brand_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });
        $('#create-brand-form').on('reset', function () {
            $('#create_brand_response').html('');
            $('#create_brand_response').removeClass('alert-success alert-danger');
            $('#create_brand_response').addClass('d-none');
        });
        $('#UpdateBrandModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('#updateBrandTitle').html('Update Brand - ' + button.data('brand-id'));
            modal.find('#brand_id').val(button.data('brand-id'));
            modal.find('#name').val(button.data('name'));
            modal.find('#description').val(button.data('description'));
            modal.find('#index').val(button.data('index'));
        });

        $('#update-brand-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            console.log({ formData });
            // console.log()
            $.ajax({
                url: `/admin/brands/update`,
                type: 'PUT',
                data: formData,
                success: function (response) {
                    console.log({ response });
                    // Handle the success response
                    $('#update_brand_response').removeClass('alert-danger');
                    $('#update_brand_response').addClass('alert-success');
                    $('#update_brand_response').html(response.message);
                    var row = $('#brand-table tr').filter(function () {
                        return $(this).find('td:first').text() == response.brand.brand_id;
                    });
                    if (row)
                    {
                        row.html(`
                        <tr>
                        <td>${response.brand.brand_id }</td>
    
                        <td>${response.brand.name }</td>
                        <td>
                        ${response.brand.description }
                        </td>
                        <td>${response.brand.index }</td>
                        <td>
                            <button type="button" class="js-update-brand-btn btn  mr-2 px-2 py-1"
                                data-bs-toggle="modal" data-bs-target="#UpdateBrandModal"
                                data-brand-id="${response.brand.brand_id }" data-name="${response.brand.brand_id }"
                                data-description="   ${response.brand.description }"
                                data-index="${response.brand.index }"
                                data-parent-id="${response.brand.parent_id }">
                                <img src="${data_asset}svg/edit.svg" style="width: 18px;" />
                            </button>
                        </td>`)
                    }
                },
                error: function (error) {
                    console.log({ error });
                    // Handle the error response
                    $('#update_brand_response').removeClass('alert-success');
                    $('#update_brand_response').addClass('alert-danger');
                    // $('#update_brand_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });

        function createBrandElement(brand) {
            return `   <tr>
            <td>${brand.brand_id }</td>

            <td>${brand.name }</td>
            <td>
            ${brand.description }
            </td>
            <td>${brand.index }</td>
            <td>
                <button type="button" class="js-update-brand-btn btn  mr-2 px-2 py-1"
                    data-bs-toggle="modal" data-bs-target="#UpdateBrandModal"
                    data-brand-id="${brand.brand_id }" data-name="${brand.brand_id }"
                    data-description="   ${brand.description }"
                    data-index="${brand.index }"
                    data-parent-id="${brand.parent_id }">
                    <img src="${data_asset}svg/edit.svg" style="width: 18px;" />
                </button>
            </td>`;
        }
        
        function BrandPagination({ page }) {
            const search = $('#search-brand-input').val();
            history.pushState(null, null, `/admin/brands?page=${page}&search=${search}`);
            // call ajax
            $.ajax({
                url: `/admin/brands/pagination?page=${page}&search=${search}`,
                type: 'GET',
                success: function (response) {
                    let html = '';
                    response.brands.data.forEach((brand) => {
                        html += createBrandElement(brand);
                    });
                    $('#brand-table').html(html);
                    renderPagination({
                        current_page: response.brands.current_page,
                        last_page: response.brands.last_page,
                    });
                },
                error: function (error) {
                    console.log(error);
                },
            });
        }

        // pagination
        $(document).on('click', '.pagination .page-link', function (event) {
            var button = $(event.target);
            const page = button.data('page');
            BrandPagination({ page });
        });
        $('#search-brand-input').on(
            'input',
            debounce(function () {
                BrandPagination({ page: 1 });
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
        }
    });
})(jQuery); 