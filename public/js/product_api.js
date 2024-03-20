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
    });
})(jQuery);
