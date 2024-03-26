jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        // create employee api
        $('#create-employee-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/admin/employee/create',
                type: 'POST',
                data: formData,
                success: function (response) {
                    // Handle the success response

                    $('#create_employee_response').removeClass('alert-danger d-none');
                    $('#create_employee_response').addClass('alert-success');
                    $('#create_employee_response').html(response.message);
                    const data_asset = $('#asset').attr('data-asset');
                    $('#employee-table-body').append(`<tr>
                        <td>${response.user.user_id}</td>
                        <td>
                            <div class="d-flex py-1 align-items-center">
                                <span class="avatar me-2"
                                    style="background-image: url(${response.user.avatar})"></span>
                                <div class="flex-fill">
                                    <div class="font-weight-medium">
                                    ${response.user.first_name} ${response.user.last_name}
                                    <span
                                    class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                                    </div>
                                    <div class="text-muted"><a href="#"
                                            class="text-reset">${response.user.email}</a></div>
                                </div>
                            </div>
                        </td>
                        <td>${response.user.gender ? 'Male' : 'Female'}</td>
                        <td>${response.user.birth_date}</td>
                        <td>
                            <div>
                            ${response.address.phone_number}
                            </div>
                            <div>
                            ${response.address.address}
                            </div>
                        </td>
                        <td><span class="badge bg-success me-1"></span> Active</td>
                        <td>
                            <a href="employee/${response.user.user_id}/details" class="btn p-2">
                                <img src="${data_asset}svg/view.svg" style="width: 18px;" />
                            </a>
                            <a href="#" class="btn p-2" data-bs-toggle="modal"
                                data-bs-target="#update-employee-modal"
                                data-user-id="${response.user.user_id}" data-email="${response.user.email}"
                                data-first-name="${response.user.first_name}"
                                data-last-name="${response.user.last_name}"
                                data-phone-number="${response.address.phone_number}"
                                data-address="${response.address.address}"
                                data-gender="${response.user.gender}"
                                data-birth-date="${response.user.birth_date}">
                                <img src="${data_asset}svg/edit.svg" style="width: 18px;" />
                            </a>
                            <a href="#" class="btn p-2" data-bs-toggle="modal"
                                data-bs-target="#delete-user-modal"
                                data-user-id="${response.user.user_id}">
                                <img src="${data_asset}svg/trash.svg" style="width: 18px;" />
                            </a>
                        </td>
                    </tr>`);
                },
                error: function (error) {
                    // Handle the error response
                    $('#create_employee_response').removeClass('alert-successs d-none');
                    $('#create_employee_response').addClass('alert-danger');
                    $('#create_employee_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });
        // reset create employee form
        $('#create-employee-form').on('reset', function () {
            $('#create_employee_response').html('');
            $('#create_employee_response').removeClass('alert-success alert-danger');
            $('#create_employee_response').addClass('d-none');
        });

        // click show update employee
        $('#update-employee-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('#update-employee-title').html('Update Employee - ' + button.data('user-id'));
            modal.find('#first_name').val(button.data('first-name'));
            modal.find('#last_name').val(button.data('last-name'));
            modal.find('#email ').val(button.data('email'));
            modal.find('#email ').attr('readonly', true);
            modal.find('#address ').val(button.data('address'));
            modal.find('#phone_number ').val(button.data('phone-number'));
            modal.find('#birth_date ').val(button.data('birth-date'));
            if (button.data('gender')) modal.find('#male ').prop('checked', true);
            else modal.find('#female ').prop('checked', true);
        });

        // update employee
        $('#update-employee-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            console.log({ formData });
            $.ajax({
                url: `/admin/employee/update`,
                type: 'POST',
                data: formData,
                success: function (response) {
                    console.log({ response });
                    // Handle the success response
                    $('#update_employee_response').removeClass('alert-successs d-none');
                    $('#update_employee_response').addClass('alert-success');
                    $('#update_employee_response').html(Object.values(response.message));
                    var row = $('#employee-table-body tr').filter(function () {
                        return $(this).find('td:first').text() == response.user.user_id;
                    });
                    if (row) {
                        const data_asset = $('#asset').attr('data-asset');
                        row.html(`
                        <td>${response.user.user_id}</td>
                        <td>
                            <div class="d-flex py-1 align-items-center">
                                <span class="avatar me-2"
                                    style="background-image: url(${response.user.avatar})"></span>
                                <div class="flex-fill">
                                    <div class="font-weight-medium">
                                    ${response.user.first_name} ${response.user.last_name}
                                    <span
                                    class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                                    </div>
                                    <div class="text-muted"><a href="#"
                                            class="text-reset">${response.user.email}</a></div>
                                </div>
                            </div>
                        </td>
                        <td>${response.user.gender ? 'Male' : 'Female'}</td>
                        <td>${response.user.birth_date}</td>
                        <td>
                            <div>
                            ${response.address.phone_number}
                            </div>
                            <div>
                            ${response.address.address}
                            </div>
                        </td>
                        <td><span class="badge bg-success me-1"></span> Active</td>
                        <td>
                            <a href="employee/${response.user.user_id}/details" class="btn p-2">
                                <img src="${data_asset}svg/view.svg" style="width: 18px;" />
                            </a>
                            <a href="#" class="btn p-2" data-bs-toggle="modal"
                                data-bs-target="#update-employee-modal"
                                data-user-id="${response.user.user_id}" data-email="${response.user.email}"
                                data-first-name="${response.user.first_name}"
                                data-last-name="${response.user.last_name}"
                                data-phone-number="${response.address.phone_number}"
                                data-address="${response.address.address}"
                                data-gender="${response.user.gender}"
                                data-birth-date="${response.user.birth_date}">
                                <img src="${data_asset}svg/edit.svg" style="width: 18px;" />
                            </a>
                            <a href="#" class="btn p-2" data-bs-toggle="modal"
                                data-bs-target="#delete-user-modal"
                                data-user-id="${response.user.user_id}">
                                <img src="${data_asset}svg/trash.svg" style="width: 18px;" />
                            </a>
                        </td>
                    `);
                    }
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

        // click delete employee
        $('#delete-user-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var userId = button.data('user-id');
            var modal = $(this);
            modal.find('.modal-footer button.btn-danger').data('user-id', userId);
        });
        // click restore employee
        $('#restore-user-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var userId = button.data('user-id');
            var modal = $(this);
            modal.find('.modal-footer button.btn').data('user-id', userId);
        });
        // delete user
        $('#delete-user-modal').on('click', '.modal-footer button.btn-danger', function (e) {
            var userId = $(this).data('user-id');
            console.log(userId);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: `/admin/employee/${userId}/ban`,
                type: 'GET',
                success: function (response) {
                    var link = $('.js-user-table a[data-user-id="' + userId + '"]');
                    // update status
                    var statusCell = link.closest('tr').find('td').eq(5);
                    statusCell.html('<span class="badge bg-danger me-1"></span> Blocked');
                    // update action
                    var actionCell = link.closest('tr').find('td').eq(6);
                    const data_asset = $('#asset').attr('data-asset');
                    actionCell.find('a:last').remove();
                    actionCell.append(`<a href="#" class="btn p-2" data-bs-toggle="modal"
                        data-bs-target="#restore-user-modal"
                        data-user-id="${userId}">
                        <img src="${data_asset}svg/key.svg" style="width: 18px;" />
                        </a>`);

                    // show success modal
                    $('#success-notify-modal').addClass('show');
                    $('#success-notify-modal').attr('style', 'display: block;');
                    $('#success-notify-modal').removeAttr('aria-hidden');
                    $('body').append('<div class="modal-backdrop fade show"></div>');
                    $('#success-title').html('Deleted User Successfully');
                    $('#success-desc').html('This user can not be able to access the system.');
                },
                error: function (error) {
                    console.log({ error });
                },
            });
        });
        // restore user
        $('#restore-user-modal').on('click', '.modal-footer button.btn-primary', function (e) {
            var userId = $(this).data('user-id');
            console.log(userId);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: `/admin/employee/${userId}/unban`,
                type: 'GET',
                success: function (response) {
                    var link = $('.js-user-table a[data-user-id="' + userId + '"]');
                    // update status
                    var statusCell = link.closest('tr').find('td').eq(5);
                    statusCell.html('<span class="badge bg-success me-1"></span> Active');
                    // update action
                    var actionCell = link.closest('tr').find('td').eq(6);
                    actionCell.find('a:last').remove();
                    const data_asset = $('#asset').attr('data-asset');
                    actionCell.append(`<a href="#" class="btn p-2" data-bs-toggle="modal"
                        data-bs-target="#delete-user-modal"
                        data-user-id="${userId}">
                        <img src="${data_asset}svg/trash.svg" style="width: 18px;" />
                        </a>`);
                    // show success modal
                    $('#success-notify-modal').addClass('show');
                    $('#success-notify-modal').attr('style', 'display: block;');
                    $('#success-notify-modal').removeAttr('aria-hidden');
                    $('body').append('<div class="modal-backdrop fade show"></div>');
                    $('#success-title').html('Restored User Successfully');
                    $('#success-desc').html('This user can be able to access the system again.');
                },
                error: function (error) {
                    console.log({ error });
                },
            });
        });
        $('.js-close-success-modal').click(function () {
            $('#success-notify-modal').removeClass('show');
            $('#success-notify-modal').attr('style', 'display: none;');
            $('#success-notify-modal').attr('aria-hidden', 'true');
            $('.modal-backdrop.fade.show').remove();
        });

        // profile user
        const idemployees = ['first_name', 'last_name', 'gender', 'birth_date', 'phone_number', 'address'];
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
    });
})(jQuery);
