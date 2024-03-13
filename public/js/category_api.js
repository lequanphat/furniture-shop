jQuery.noConflict();


(function($)
{
    $(document).ready(function()
    {
        $('#js-create-category-btn').click(()=>
        {
            $('#createEmployeeModal').modal('show');
            $('#create-category-form')[0].reset();
            // $('#create_category_response').html('');
            // $('#create_category_response').removeClass('alert-success alert-danger');
        });

        $('#create-category-form').submit (function(e)
        {
            e.preventDefault();
            var formData  = $(this).serialize();
            $.ajax(
                {
                    url:'/admin/categories/create',
                    type : 'POST',
                    data:formData,
                    success :function(response)
                    {
                        $('#create_category_response').removeClass('alert-danger');
                        $('#create_category_response').addClass('alert-success');
                        $('#create_category_response').html(response.message);
                    },
                    error :function(error)
                    {
                        $('#create_employee_response').removeClass('alert-success');
                        $('#create_employee_response').addClass('alert-danger');
                        $('#create_employee_response').html(Object.values(error.responseJSON.errors)[0][0]);
                    },
                }
            );
        });

        $('#reset_create_employee_form').click(() => {
            $('#create_category_response').html('');
            $('#create_category_response').removeClass('alert-success alert-danger');
        });
    });
})(jQuery);
