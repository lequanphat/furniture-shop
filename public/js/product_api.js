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
            if (event.target.files && event.target.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#preview-list')
                        .append(`<div class="col-md-3 col-sm-4 position-relative" data-index="${event.target.files[0].name}">
                    <a data-fslightbox="gallery" href="#">
                        <div 
                            class="img-responsive img-responsive-1x1 rounded-3 border"
                            style="background-image: url(${e.target.result})">
                        </div>
                    </a>
                    <button type="button" class="js-remove-image bg-white btn-close position-absolute" style="top: 3%; right: 5%;"></button>
                </div>`);
                };
                selectedFiles.push(event.target.files[0]);
                reader.readAsDataURL(event.target.files[0]);
                console.log(selectedFiles);
            }
        });

        $('#preview-list').on('click', '.js-remove-image', function (e) {
            var parent = $(this).parent();
            var name = parent.data('index');
            selectedFiles = selectedFiles.filter((file) => file.name !== name);
            console.log(selectedFiles);
            parent.remove();
        });

        $('#create-detailed-product-form').submit(function (e) {
            e.preventDefault();
            var form = this;
            var formDataImages = new FormData(form);
            formDataImages.append('images', selectedFiles);
            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                data: formDataImages,
                processData: false, // Uncomment this line
                contentType: false, // Uncomment this line
                success: function (response) {
                    console.log('====================================');
                    console.log({ response });
                    console.log('====================================');
                },
                error: function (error) {
                    console.log('====================================');
                    console.log(error);
                    console.log('====================================');
                    $('#js-error').removeClass('d-none');
                    $('#js-error').text('* ' + error.responseJSON.message);
                },
            });
        });
    });
})(jQuery);
