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
                console.log(response);
                $('#update_address_response').removeClass('alert-successs d-none');
                $('#update_address_response').addClass('alert-success');
                $('#update_address_response').html(Object.values(response.message));
                var row = $('#address_table address').filter(function () {
                    return $(this).find('p:first').text() == response.address.address_id;
                });
                if (row) {
                    let is_default = '';
                    let boolean = 'false';
                    if (response.address.is_default == true) {
                        const paragraphs = document.querySelectorAll('p.is_default');

                        paragraphs.forEach((paragraph) => {
                            paragraph.classList.add('d-none');
                        });
                        is_default = 'Default address';
                        boolean = 'true';
                    }
                    row.html(
                        `
                    <address>
                    <p class="d-none">${response.address.address_id}</p>
                    <p class="is_default"> ${is_default} <p>
                    <p><strong>${response.address.receiver_name}</strong></p>
                    <p>${response.address.address}</p>
                    <p>${response.address.phone_number}</p>
                    <button href="#" class="check-btn sqr-btn " data-bs-toggle="modal"
                    data-bs-target="#UpdateAddressModal"
                    data-address-id="${response.address.address_id}"
                    data-receiver-name="${response.address.receiver_name}"
                    data-address="${response.address.address}"
                    data-phone-number="${response.address.phone_number}"
                    data-is-default="${boolean}">
                    <i class="fa fa-edit"></i> Edit
                    Address</button>
                    <button href="#" class="check-btn sqr-btn " data-bs-toggle="modal"
                    data-bs-target="#RemoveAddressModal"
                    data-address-id="${response.address.address_id}">
                    <i class="fa fa-remove"></i> Remove
                    Address</button>
                    <h3></h3>
                    </address>
                    
      
                    `,
                    );
                }
            },
            error: function (error) {
                console.log({ error });
                // Handle the error response
                console.log(error);
                $('#update_address_response').removeClass('alert-success d-none');
                $('#update_address_response').addClass('alert-danger');
                $('#update_address_response').html(Object.values(error.responseJSON.errors)[0][0]);
            },
        });
    });
    $('#remove-address-form').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        console.log(formData);
        $.ajax({
            url: `/account/profile/addresscard/remove`,
            type: 'POST',
            data: formData,
            success: function (response) {
                console.log({ response });
                // Handle the success response
                $('#remove_address_response').removeClass('alert-successs d-none');
                $('#remove_address_response').addClass('alert-success');
                $('#remove_address_response').html(Object.values(response.message));
                var row = $('#address_table address').filter(function () {
                    return $(this).find('p:first').text() == response.address_id;
                });
                if (row) {
                    row.html(``);
                }
            },
            error: function (error) {
                console.log({ error });
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
                let is_default = '';
                let boolean = 'false';
                if (response.address.is_default == true) {
                    const paragraphs = document.querySelectorAll('p.is_default');

                    paragraphs.forEach((paragraph) => {
                        paragraph.classList.add('d-none');
                    });
                    is_default = 'Default address';
                    boolean = 'true';
                }
                $('#address_table').append(
                    `
                    <address>
                    <p class="d-none">${response.address.address_id}</p>
                    <p class="is_default"> ${is_default} <p>
                    <p><strong>${response.address.receiver_name}</strong></p>
                    <p>${response.address.address}</p>
                    <p>${response.address.phone_number}</p>
                    <button href="#" class="check-btn sqr-btn " data-bs-toggle="modal"
                    data-bs-target="#UpdateAddressModal"
                    data-address-id="${response.address.address_id}"
                    data-receiver-name="${response.address.receiver_name}"
                    data-address="${response.address.address}"
                    data-phone-number="${response.address.phone_number}"
                    data-is-default="${boolean}">
                    <i class="fa fa-edit"></i> Edit
                    Address</button>
                    <button href="#" class="check-btn sqr-btn " data-bs-toggle="modal"
                    data-bs-target="#RemoveAddressModal"
                    data-address-id="${response.address.address_id}">
                    <i class="fa fa-remove"></i> Remove
                    Address</button>
                    <h3></h3>
                    </address>
                    `,
                );
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
