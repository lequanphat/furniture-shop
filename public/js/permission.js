jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        const data_asset = $('#asset').attr('data-asset');

        // create role

        $('#create-role-form').on('submit', function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: `/admin/roles`,
                type: 'POST',
                data: formData,
                success: function (data) {
                    $('#create_role_response').html(data.message);
                    $('#create_role_response').removeClass('alert-danger d-none');
                    $('#create_role_response').addClass('alert-success');
                    console.log(data);
                },
                error: function (error) {
                    $('#create_role_response').html(Object.values(error.responseJSON.errors)[0][0]);
                    $('#create_role_response').removeClass('alert-success d-none');
                    $('#create_role_response').addClass('alert-danger');
                    console.log(error);
                },
            });
        });

        // update role

        $('#update-role-form').on('submit', function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            const role_id = $(this).data('role-id');
            $.ajax({
                url: `/admin/roles/${role_id}`,
                type: 'PATCH',
                data: formData,
                success: function (data) {
                    $('#update_role_response').html(data.message);
                    $('#update_role_response').removeClass('alert-danger d-none');
                    $('#update_role_response').addClass('alert-success');
                    console.log(data);
                },
                error: function (error) {
                    $('#update_role_response').html(Object.values(error.responseJSON.errors)[0][0]);
                    $('#update_role_response').removeClass('alert-success d-none');
                    $('#update_role_response').addClass('alert-danger');
                    console.log(error);
                },
            });
        });

        $('#update-role-modal').on('show.bs.modal', function (e) {
            console.log('modal opened');
            var button = $(e.relatedTarget);
            var role_id = button.data('role-id');
            const modal = $(this);
            modal.find('form')[0].reset();
            modal.find('form').data('role-id', role_id);
            // call ajax to get role details
            $.ajax({
                url: `/admin/roles/${role_id}`,
                type: 'GET',
                success: function (response) {
                    modal.find('#role_name').val(response.role.name);

                    var permissions = response.permissions;
                    permissions.forEach((permission) => {
                        modal.find(`input[value="${permission.name}"]`).prop('checked', true);
                    });
                    console.log(response);
                },
                error: function (error) {
                    console.log(error);
                },
            });
        });

        $(document).on('click', '.js-change-role', function (e) {
            const button = $(this);
            // get data
            const role_name = button.text().trim();
            var user_id = button.closest('tr').find('td:first').text().trim();
            var user_name = button.closest('tr').find('.js-fullname').text().trim();

            // assign data
            $('#js-arc-message').html(
                `You want to change role of user <strong>${user_name}</strong> to <strong>${role_name}</strong>`,
            );
            $('#assign-role-confirm-modal').data('user-id', user_id);
            $('#assign-role-confirm-modal').data('role-name', role_name);
        });

        $(document).on('click', '#js-assign-role-btn', function (e) {
            const role_name = $('#assign-role-confirm-modal').data('role-name');
            const user_id = $('#assign-role-confirm-modal').data('user-id');
            $.ajax({
                url: `/admin/authorization`,
                type: 'POST',
                data: {
                    role_name: role_name,
                    user_id: user_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (data) {
                    const tr = $('tr')
                        .find('td:first')
                        .filter(function () {
                            return $(this).text().trim() === user_id;
                        })
                        .closest('tr');
                    // get old role
                    const old_role = tr.find('.js-dropdown-role button').text().trim();
                    // assign new role
                    tr.find('.js-dropdown-role button').text(role_name);
                    // remove old role from dropdown
                    tr.find('.dropdown-menu')
                        .find('a')
                        .filter(function () {
                            return $(this).text().trim() === role_name;
                        })
                        .remove();
                    // add old role to dropdown
                    tr.find('.dropdown-menu').append(
                        ` <a class="js-change-role dropdown-item"
                        data-bs-toggle="modal"
                        data-bs-target="#assign-role-confirm-modal">${old_role}</a>`,
                    );
                },
                error: function (error) {
                    console.log(error);
                },
            });
        });
    });
})(jQuery);
