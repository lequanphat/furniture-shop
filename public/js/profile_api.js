const idemployees = ['first_name', 'last_name', 'gender', 'birth_date', 'phone_number', 'address'];
const idcustomer = ['first_name', 'last_name', 'gender', 'birth_date', 'phone_number'];
jQuery(document).ready(function () {
    $('#enable-edit-profile-employee').click(() => {
        var label;
        idemployees.forEach(function (id) {
            label = $('label[for="' + id + '"]');
            label.addClass('required');
            $('#' + id).prop('readonly', false);
            $('#' + id).prop('required', true);
        });
        $('#avatar').prop('disabled', false);
        $('#btn-list-edit').removeClass('d-none');
        $('#page-title').html('Edit Profile');
    });
    $('#enable-edit-profile-customer').click(() => {
        var label;
        idcustomer.forEach(function (id) {
            label = $('label[for="' + id + '"]');
            label.addClass('required');
            $('#' + id).prop('readonly', false);
            $('#' + id).prop('required', true);
        });
        $('#btn-list-edit').removeClass('d-none');
    });
    // for avatar change
    var imageData = null;
    $('#avatar').on('change', function () {
        const file = this.files[0];
        console.log(file);
        const reader = new FileReader();
        reader.onload = function (e) {
            $('#imagePreview').attr('src', e.target.result);
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

    $('#update-address-form').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        console.log(formData);
        $.ajax({
            url: `/account/profile/addresscard/update`,
            type: 'POST',
            data: formData,
            success: function (response) {
                console.log({ response });
                // Handle the success response
                $('#update_address_response').removeClass('alert-successs d-none');
                $('#update_address_response').addClass('alert-success');
                $('#update_address_response').html(Object.values(response.message));
            },
            error: function (error) {
                console.log({ error });
                // Handle the error response
                $('#update_address_response').removeClass('alert-success d-none');
                $('#update_address_response').addClass('alert-danger');
                $('#update_address_response').html(Object.values(error.responseJSON.errors)[0][0]);
            },
        });
    });
    $('#update-profile-customer-form').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        console.log(formData);
        $.ajax({
            url: `/account/profile/update`,
            type: 'POST',
            data: formData,
            success: function (response) {
                console.log({ response });
                // Handle the success response
                $('#update_customer_response').removeClass('alert-successs d-none');
                $('#update_customer_response').addClass('alert-success');
                $('#update_customer_response').html(Object.values(response.message));
            },
            error: function (error) {
                console.log({ error });
                // Handle the error response
                $('#update_customer_response').removeClass('alert-success d-none');
                $('#update_customer_response').addClass('alert-danger');
                $('#update_customer_response').html(Object.values(error.responseJSON.errors)[0][0]);
            },
        });
    });
    $('#UpdateAddressModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        modal.find('#updateAddressTitle').html('Update Address Card');
        modal.find('#address_id').val(button.data('address-id'));
        modal.find('#receiver_name').val(button.data('receiver-name'));
        modal.find('#address').val(button.data('address'));
        modal.find('#phone_number').val(button.data('phone-number'));
        modal.find('#is_default').attr('checked', button.data('is-default'));
    });
    $('#CreateAddressModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        console.log(button.data());
        modal.find('#user_id').val(button.data('user-id'));
    });
    $('#create-address-form').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        console.log(formData);
        $.ajax({
            url: `/account/profile/addresscard/create`,
            type: 'POST',
            data: formData,
            success: function (response) {
                console.log({ response });
                // Handle the success response
                $('#create_customer_response').removeClass('alert-successs d-none');
                $('#create_customer_response').addClass('alert-success');
                $('#create_customer_response').html(Object.values(response.message));
            },
            error: function (error) {
                console.log({ error });
                // Handle the error response
                $('#create_customer_response').removeClass('alert-success d-none');
                $('#create_customer_response').addClass('alert-danger');
                $('#create_customer_response').html(Object.values(error.responseJSON.errors)[0][0]);
            },
        });
    });
});
