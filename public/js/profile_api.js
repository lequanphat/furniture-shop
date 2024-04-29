const idcustomer = ['first_name', 'last_name', 'gender', 'birth_date', 'phone_number', 'address'];
jQuery(document).ready(function () {
    $('#enable-edit-profile-customer').click(() => {
        var label;
        idcustomer.forEach(function (id) {
            label = $('label[for="' + id + '"]');
            label.addClass('required');
            $('#' + id).prop('readonly', false);
            $('#' + id).prop('required', true);
        });
        $('#btn-list-edit').removeClass('d-none');
        $('#enable-edit-profile-customer').addClass('d-none');
    });
    $('#cancel-edit-profile-customer').click(() => {
        const profileform = document.getElementById('update-profile-customer-form');
        profileform.reset();
        var label;
        idcustomer.forEach(function (id) {
            label = $('label[for="' + id + '"]');
            label.removeClass('required');
            $('#' + id).prop('readonly', true);
            $('#' + id).prop('required', false);
        });
        $('#btn-list-edit').addClass('d-none');
        $('#enable-edit-profile-customer').removeClass('d-none');
    });
    function createAddressElement(address) {
        return `<div class="address-info">
            <div class="header">
                <p class="receiver-name">${address.receiver_name}</p>
                <p>${address.phone_number}</p>
            </div>
            <p>${address.address}</p>
            ${address.is_default ? '<div class="default-tag">Default</div>' : ''}
        </div>
        <div class="address-action">
            <button class="update-btn" data-bs-toggle="modal"
                data-bs-target="#UpdateAddressModal"
                data-address-id="${address.address_id}"
                data-receiver-name="${address.receiver_name}"
                data-address="${address.address}"
                data-phone-number="${address.phone_number}"
                data-is-default="${address.is_default}"><i
                    class="fa fa-edit"></i> Update</button>
            <button class="remove-btn" data-bs-toggle="modal"
                data-bs-target="#RemoveAddressModal"
                data-address-id="${address.address_id}"><i
                    class="fa fa-remove"></i>
                Remove</button>
        </div>`;
    }
    $('#update-address-form').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: `/account/profile/addresscard/update`,
            type: 'POST',
            data: formData,
            success: function (response) {
                // Handle the success response
                $('#update_address_response').removeClass('alert-successs d-none');
                $('#update_address_response').addClass('alert-success');
                $('#update_address_response').html(Object.values(response.message));
                var row = $(`#address_table .address-item.${response.address.address_id}`);
                if (row) {
                    if (response.address.is_default == true) {
                        $('#address_table .address-item .default-tag').remove();
                    }
                    row.html(createAddressElement(response.address));
                }
            },
            error: function (error) {
                // Handle the error response
                $('#update_address_response').removeClass('alert-success d-none');
                $('#update_address_response').addClass('alert-danger');
                $('#update_address_response').html(Object.values(error.responseJSON.errors)[0][0]);
            },
        });
    });
    $('#remove-address-form').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: `/account/profile/addresscard/remove`,
            type: 'POST',
            data: formData,
            success: function (response) {
                // Handle the success response
                $('#RemoveAddressModal').modal('hide');
                var row = $(`#address_table .address-item.${response.address_id}`);
                if (row) row.remove();
            },
            error: function (error) {
                // Handle the error response
                $('#remove_address_response').removeClass('alert-success d-none');
                $('#remove_address_response').addClass('alert-danger');
                $('#remove_address_response').html(Object.values(error.responseJSON.errors)[0][0]);
            },
        });
    });
    $('#update-profile-customer-form').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: `/account/profile/update`,
            type: 'POST',
            data: formData,
            success: function (response) {
                // Handle the success response
                $('#update_customer_response').removeClass('alert-successs d-none');
                $('#update_customer_response').addClass('alert-success');
                $('#update_customer_response').html('Updated profile successfully');
            },
            error: function (error) {
                // Handle the error response
                $('#update_customer_response').removeClass('alert-success d-none');
                $('#update_customer_response').addClass('alert-danger');
                $('#update_customer_response').html(Object.values(error.responseJSON.errors)[0][0]);
            },
        });
    });
    $('#RemoveAddressModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        modal.find('#address_id').val(button.data('address-id'));
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
        modal.find('#user_id').val(button.data('user-id'));
    });
    $('#create-address-form').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: `/account/profile/addresscard/create`,
            type: 'POST',
            data: formData,
            success: function (response) {
                // Handle the success response
                $('#create_address_response').removeClass('alert-successs d-none');
                $('#create_address_response').addClass('alert-success');
                $('#create_address_response').html(Object.values(response.message));
                if (response.address.is_default == true) {
                    $('#address_table .address-item .default-tag').remove();
                }
                $('#address_table').append(`<div class="address-item ${response.address.address_id}">
                    ${createAddressElement(response.address)}</div>`);
            },
            error: function (error) {
                // Handle the error response
                $('#create_customer_response').removeClass('alert-success d-none');
                $('#create_customer_response').addClass('alert-danger');
                $('#create_customer_response').html(Object.values(error.responseJSON.errors)[0][0]);
            },
        });
    });
});
