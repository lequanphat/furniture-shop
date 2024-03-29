jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
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
    });
})(jQuery);
