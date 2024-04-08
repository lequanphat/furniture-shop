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
        function createProductElement(product) {
            return `<tr>
            <td>
                <div class="d-flex py-1 align-items-center">
                    <span class="avatar me-2"
                        style="background-image: url(${
                            product.detailed_product?.images[0]?.url
                        }); width: 80px; height: 80px; flex-shrink: 0;"></span>
                    <div class="flex-fill">
                        <div class="font-weight-medium">
                            <h3 class="m-0">${product.name}
                                ${
                                    product.new
                                        ? `<span
                                class="badge badge-sm bg-green-lt text-uppercase ms-auto">New
                            </span>`
                                        : ''
                                }</h3>
                        </div>
                        <div class="text-muted">
                            <a href="/admin/products/${product.product_id}"
                                class="text-reset">${product.number_of_detailed_products}detailed products</a>
                        </div>
                    </div>
                </div>
            </td>
            <td>${formatter.format(product.average_price)}đ</td>
            <td>${product.sum_quantities}</td>
            <td>${product.brand.name}</td>
            <td>${product.category.name}</td>
            <td>
                <a href="/admin/products/${product.product_id}"
                    class="btn p-2"><img src="${data_asset}svg/view.svg" style="width: 18px;" /></a>
                <a href="/admin/products/${product.product_id}/update"
                    class="btn p-2"><img src="${data_asset}svg/edit.svg" style="width: 18px;" /></a>
            </td>
        </tr>`;
        }

        function productPagination({ page }) {
            const search = $('#search-product-input').val();
            history.pushState(null, null, `/admin/products?page=${page}&search=${search}`);
            // call ajax
            $.ajax({
                url: `/admin/products/pagination?page=${page}&search=${search}`,
                type: 'GET',
                success: function (response) {
                    let html = '';
                    response.products.data.forEach((product) => {
                        html += createProductElement(product);
                    });
                    $('#product-table-body').html(html);
                    renderPagination({
                        current_page: response.products.current_page,
                        last_page: response.products.last_page,
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
            const search = '';
            productPagination({ page });
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
        // search with ajax
        $('#search-product-input').on(
            'input',
            debounce(function () {
                productPagination({ page: 1 });
            }, 500),
        );
    });
})(jQuery);
