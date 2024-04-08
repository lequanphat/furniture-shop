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
            const role_name = button.text().trim();

            button.closest('.dropdown').find('button').text(role_name);
            var user_id = button.closest('tr').find('td:first').text().trim();

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
                    console.log(data);
                },
                error: function (error) {
                    console.log(error);
                },
            });
        });
    });
})(jQuery);
