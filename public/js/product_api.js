jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        const data_asset = $('#asset').attr('data-asset');
        let formatter = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 0,
        });

        $('#create-product-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            formData += '&description=' + encodeURIComponent(CKEDITOR.instances.editor.getData());
            formData += '&tags=' + encodeURIComponent(JSON.stringify($('#select-tags').val()));
            $.ajax({
                url: `/admin/products/create`,
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    window.location.href = `/admin/products/${response.product.product_id}`;
                },
                error: function (error) {
                    $('#js-error').removeClass('d-none');
                    $('#js-error').text(error.responseJSON.message);
                },
            });
        });

        // update product
        $('#update-product-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            formData += '&description=' + encodeURIComponent(CKEDITOR.instances.editor.getData());
            formData += '&tags=' + encodeURIComponent(JSON.stringify($('#select-tags').val()));
            const product_id = $('#update-product-form').data('id');
            $.ajax({
                url: `/admin/products/${product_id}/update`,
                type: 'PATCH',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    $('#js-response').removeClass('d-none');
                    $('#js-response').addClass('alert-success');
                    $('#js-response').removeClass('alert-danger');
                    $('#js-response').html(response.message);
                },
                error: function (error) {
                    console.log(error);
                    $('#js-response').removeClass('d-none');
                    $('#js-response').removeClass('alert-success');
                    $('#js-response').addClass('alert-danger');
                    $('#js-response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });

        // for create detailed product
        var selectedFiles = [];
        $('#image-picker').change(function (event) {
            var files = event.target.files;
            // Handle the file preview
            for (var i = 0; i < files.length; i++) {
                if (selectedFiles.length >= 4) break;
                selectedFiles.push(files[i]);
                var reader = new FileReader();
                reader.onload = (function (file) {
                    return function (e) {
                        $('#preview-list').append(`<div class="col-md-3 col-sm-4 position-relative">
                            <a data-fslightbox="gallery" href="#">
                                <div 
                                    class="img-responsive img-responsive-1x1 rounded-3 border"
                                    style="background-image: url(${e.target.result})" >
                                </div>
                            </a>
                            
                            <button data-file-id="${file.lastModified}" type="button" 
                            class="js-remove-image bg-white btn-close position-absolute" 
                            style="top: 3%; right: 5%;"></button>
                        </div>`);
                    };
                })(files[i]);
                reader.readAsDataURL(files[i]);
            }
            console.log({ selectedFiles });
            if (selectedFiles.length >= 4) {
                $('#image-picker').attr('disabled', true);
            }
        });

        $('#preview-list').on('click', '.js-remove-image', function (e) {
            var lastModified = $(this).data('file-id');
            selectedFiles = selectedFiles.filter((file) => {
                $(`button[data-file-id="${lastModified}"]`).parent().remove();
                return file.lastModified !== lastModified;
            });
            $(this).parent().remove();
            if (selectedFiles.length < 4) {
                $('#image-picker').attr('disabled', false);
            }
        });

        $('#create-detailed-product-form').submit(function (e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            // add description to form data
            formData.append('description', CKEDITOR.instances.editor.getData());
            // add images to form data
            selectedFiles.forEach(function (file, index) {
                formData.append('image' + index, file);
            });
            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    window.location.href = `/admin/products/${response.detailed_product.product_id}`;
                },
                error: function (error) {
                    $('#js-error').removeClass('d-none');
                    $('#js-error').text(error.responseJSON.message);
                },
            });
        });

        // for update detailed product
        var updateSelectedFiles = [];
        var oldSelectedFile = [];

        var count = $('#update-preview-list').children().length;
        for (var i = 0; i < count; i++) {
            oldSelectedFile.push($('#update-preview-list').children().eq(i).data('file-id'));
        }

        $('#update-image-picker').change(function (event) {
            var files = event.target.files;
            // Handle the file preview
            for (var i = 0; i < files.length; i++) {
                if (updateSelectedFiles.length + oldSelectedFile.length >= 4) break;
                updateSelectedFiles.push(files[i]);
                var reader = new FileReader();
                reader.onload = (function (file) {
                    return function (e) {
                        $('#update-preview-list').append(`<div class="col-md-3 col-sm-4 position-relative">
                            <a data-fslightbox="gallery" href="#">
                                <div 
                                    class="img-responsive img-responsive-1x1 rounded-3 border"
                                    style="background-image: url(${e.target.result})" >
                                </div>
                            </a>
                            
                            <button data-file-id="${file.lastModified}" type="button" 
                            class="js-remove-image bg-white btn-close position-absolute" 
                            style="top: 3%; right: 5%;"></button>
                        </div>`);
                    };
                })(files[i]);
                reader.readAsDataURL(files[i]);
            }
            console.log({ updateSelectedFiles, oldSelectedFile });
            if (updateSelectedFiles.length + oldSelectedFile.length >= 4) {
                $('#update-image-picker').attr('disabled', true);
            }
        });

        $('#update-preview-list').on('click', '.js-remove-image', function (e) {
            // handle for new files
            var lastModified = $(this).data('file-id');
            updateSelectedFiles = updateSelectedFiles.filter((file) => {
                $(`button[data-file-id="${lastModified}"]`).parent().remove();
                return file.lastModified !== lastModified;
            });
            $(this).parent().remove();

            // handle for old files
            var file_id = $(this).parent().data('file-id');
            oldSelectedFile = oldSelectedFile.filter((item) => {
                return item !== file_id;
            });

            if (updateSelectedFiles.length + oldSelectedFile.length < 4) {
                $('#update-image-picker').attr('disabled', false);
            }
            console.log({ updateSelectedFiles, oldSelectedFile });
        });

        $('#update-detailed-product-form').submit(function (e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            // add description to form data
            formData.append('description', CKEDITOR.instances.editor.getData());
            // add images to form data
            updateSelectedFiles.forEach(function (file, index) {
                formData.append('image' + index, file);
            });
            formData.append('old_images', oldSelectedFile);

            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    console.log('====================================');
                    console.log(response);
                    console.log('====================================');
                    $('#js-response-message').removeClass('d-none');
                    $('#js-response-message').addClass('alert-success');
                    $('#js-response-message').text(response.message);
                },
                error: function (error) {
                    $('#js-response-message').removeClass('d-none');
                    $('#js-response-message').addClass('alert-danger');
                    $('#js-response-message').text(error.responseJSON.message);
                },
            });
        });

        // start delete product
        $('#delete-product-modal').on('show.bs.modal', function (event) {
            const tr = $(event.relatedTarget).closest('tr');
            const product_id = tr.find('td').eq(0).text().trim();
            const product_name = tr.find('h3').text().trim();
            $('#delete-product-modal').find('.js-message').data('product-id', product_id);
            $('#delete-product-modal')
                .find('.js-message')
                .html(`Are you sure you want to delete product <strong>${product_id} - ${product_name}</strong>?`);
        });

        $('#delete-product-modal').on('click', '.js-delete', function (e) {
            const product_id = $('#delete-product-modal').find('.js-message').data('product-id');
            console.log('delete product', product_id);

            $.ajax({
                url: `/admin/products/${product_id}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    $('#product-table-body tr').each(function () {
                        const tdText = $(this).find('td').first().text().trim();
                        if (tdText == product_id) {
                            $(this).remove();
                        }
                    });
                },
                error: function (error) {
                    console.log(error);
                },
            });
        });

        $('#delete-detailed-product-modal').on('show.bs.modal', function (event) {
            const tr = $(event.relatedTarget).closest('tr');
            const sku = tr.find('td').eq(0).find('a.text-reset').text().trim().slice(1);
            const name = tr.find('td').eq(0).find('h3').text().trim();
            $('#delete-detailed-product-modal').find('.js-message').data('sku', sku);
            $('#delete-detailed-product-modal')
                .find('.js-message')
                .html(`Are you sure you want to delete detailed product <strong>${sku} - ${name}</strong> ?`);
        });
        $('#delete-detailed-product-modal').on('click', '.js-delete', function (e) {
            const sku = $('#delete-detailed-product-modal').find('.js-message').data('sku');
            $.ajax({
                url: `/admin/products/delete/${sku}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    $('tbody tr').each(function () {
                        const tdText = $(this).find('td').eq(0).find('a.text-reset').text().trim().slice(1);
                        console.log(tdText, sku);
                        if (tdText === sku) {
                            $(this).remove();
                        }
                    });
                },
                error: function (error) {
                    console.log(error);
                },
            });
        });
        // end delete product

        // product pagination
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
        function createProductElement({ product, can_update = false, can_delete = false }) {
            const newTag = product.new
                ? '<span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>'
                : '';
            const view_btn = `<a href="/admin/products/${product.product_id}"
                class="btn p-2">
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
            const update_btn = can_update
                ? `<a href="/admin/products/${product.product_id}/update"
                class="btn p-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-pencil">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                    <path d="M13.5 6.5l4 4" />
                </svg>
            </a>`
                : '';

            const delete_btn = can_delete
                ? `<a class="btn p-2" data-bs-toggle="modal"
            data-bs-target="#delete-product-modal">
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
        </a>`
                : '';
            return `<tr>
            <td>${product.product_id}</td>
            <td>
                <div class="d-flex py-1 align-items-center">
                    <span class="avatar me-2"
                        style="background-image: url(${
                            product.detailed_product?.images[0]?.url
                        }); width: 80px; height: 80px; flex-shrink: 0;"></span>
                    <div class="flex-fill">
                        <div class="font-weight-medium">
                            <h3 class="m-0">${product.name}
                                ${newTag}</h3>
                        </div>
                        <div class="text-muted">
                            <a href="/admin/products/${product.product_id}"
                                class="text-reset">${product.number_of_detailed_products} detailed products</a>
                        </div>
                    </div>
                </div>
            </td>
            <td>${formatter.format(product.average_price)}đ</td>
            <td>${product.sum_quantities}</td>
            <td>${product.brand.name}</td>
            <td>${product.category.name}</td>
            <td>${view_btn} ${update_btn} ${delete_btn}</td>
        </tr>`;
        }

        function productPagination({ page }) {
            const search = $('#search-product-input').val();
            const brand = $('#brands_select').val();
            const category = $('#categories_select').val();
            history.pushState(
                null,
                null,
                `/admin/products?page=${page}&category=${category}&brand=${brand}&search=${search}`,
            );
            // call ajax
            $.ajax({
                url: `/admin/products/pagination?page=${page}&category=${category}&brand=${brand}&search=${search}`,
                type: 'GET',
                success: function (response) {
                    // pagination item
                    renderPagination({
                        current_page: response.products.current_page,
                        last_page: response.products.last_page,
                    });
                    // render product item
                    if (response.products.data.length === 0) {
                        $('#product-table-body').html(` <tr>
                        <td colspan="7" class="text-center text-muted">No data available</td>
                    </tr>`);
                        return;
                    }
                    let html = '';
                    response.products.data.forEach((product) => {
                        html += createProductElement({
                            product,
                            can_update: response.can_update,
                            can_delete: response.can_delete,
                        });
                    });
                    $('#product-table-body').html(html);
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
            productPagination({ page });
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
        $('#search-product-input').on(
            'input',
            debounce(function () {
                productPagination({ page: 1 });
            }, 500),
        );
        $('#categories_select').on('change', function () {
            productPagination({ page: 1 });
        });
        $('#brands_select').on('change', function () {
            productPagination({ page: 1 });
        });
    });
})(jQuery);
