jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        $('#create-product-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            formData += `&description=${CKEDITOR.instances.editor.getData()}`;
            console.log({ formData });
            $.ajax({
                url: `/admin/products/create`,
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    window.location.href = '/admin/products';
                },
                error: function (error) {
                    console.log({ error });
                },
            });
        });

        var selectedFiles = [];
        $('#image-picker').change(function (event) {
            var files = event.target.files;
            // Handle the file preview
            for (var i = 0; i < files.length; i++) {
                if (i >= 4) break;
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
                            
                            <button data-filename="${file.name}" type="button" class="js-remove-image bg-white btn-close position-absolute" style="top: 3%; right: 5%;"></button>
                        </div>`);
                    };
                })(files[i]);
                reader.readAsDataURL(files[i]);
            }
            if (selectedFiles.length >= 4) {
                $('#image-picker').attr('disabled', true);
            }
        });

        $('#preview-list').on('click', '.js-remove-image', function (e) {
            var filename = $(this).data('filename');
            selectedFiles = selectedFiles.filter((file) => file.name !== filename);
            console.log({ selectedFiles });
            $(this).parent().remove();
            if (selectedFiles.length < 4) {
                $('#image-picker').attr('disabled', false);
            }
        });

        $('#create-detailed-product-form').submit(function (e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
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
                    window.location.href = '/admin/products';
                },
                error: function (error) {
                    $('#js-error').removeClass('d-none');
                    $('#js-error').text('* ' + error.responseJSON.message);
                },
            });
        });
    });
})(jQuery);
