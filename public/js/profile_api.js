jQuery.noConflict();
const idemployees = ["first_name", "last_name","gender","birth_date","phone_number","address"];
(function ($) {
    $(document).ready(function () {
        $('#enable-edit-profile-employee').click(() => {
            var label;
            idemployees.forEach(function(id)
            {
                label= $('label[for="'+id+'"]');
                label.addClass('required');
                $("#" + id).prop("readonly", false);
                $("#" + id).prop("required", true);
            }
            )
            $('#avatar').prop("disabled",false)
            $("#btn-list-edit").removeClass('d-none');
            $('#page-title').html("Edit Profile");
        });
        // for avatar change
        var imageData=null;
        $('#avatar').on('change', function() {
          const file = this.files[0];
          console.log(file);
          const reader = new FileReader();
          reader.onload = function(e) {
            $('#imagePreview').attr('src',e.target.result);
          };
      
          reader.readAsDataURL(file);
        });
        // 
      
        $('#update-profile-employee-form').submit(function (e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            formData.append('avatar', imageData);
            console.log({ formData });
            $.ajax({
                url: `/admin/profile`,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    console.log({ response });
                    // Handle the success response
                    $('#update_employee_response').removeClass('alert-successs d-none');
                    $('#update_employee_response').addClass('alert-success');
                    $('#update_employee_response').html(Object.values(response.message));
                },
                error: function (error) {
                    console.log({ error });
                    // Handle the error response
                    $('#update_employee_response').removeClass('alert-success d-none');
                    $('#update_employee_response').addClass('alert-danger');
                    $('#update_employee_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });
        $('#update-profile-customer-form').submit(function (e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            formData.append('avatar', imageData);
            console.log({ formData });
            $.ajax({
                url: `/admin/profile`,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    console.log({ response });
                    // Handle the success response
                    $('#update_employee_response').removeClass('alert-successs d-none');
                    $('#update_employee_response').addClass('alert-success');
                    $('#update_employee_response').html(Object.values(response.message));
                },
                error: function (error) {
                    console.log({ error });
                    // Handle the error response
                    $('#update_employee_response').removeClass('alert-success d-none');
                    $('#update_employee_response').addClass('alert-danger');
                    $('#update_employee_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });
    });
})(jQuery); 