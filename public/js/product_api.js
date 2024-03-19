jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        $('#create-product-form').submit(function (e) {
            e.preventDefault();
            var data = CKEDITOR.instances.editor.getData();
            console.log(data);
        });
    });
})(jQuery);
