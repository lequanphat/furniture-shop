jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        // create role
        function createRoleElement({ role, can_update, can_delete }) {
            const newTag = role.new ? '<span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>' : '';

            const update_action = can_update
                ? `<a class="btn p-2" data-role-id="${role.id}"
                data-bs-toggle="modal" data-bs-target="#update-role-modal">
                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round"
                    class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-pencil">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                    <path d="M13.5 6.5l4 4" />
                </svg>
            </a>`
                : '';
            const delete_action = can_delete
                ? `<a href="#" class="btn p-2"
                data-role-id="${role.id}"
                data-role-name="${role.name}" data-bs-toggle="modal"
                data-bs-target="#delete-confirm-modal">
                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round"
                    class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-trash">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 7l16 0" />
                    <path d="M10 11l0 6" />
                    <path d="M14 11l0 6" />
                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                </svg>
            </a>`
                : '';

            return `
            <td>${role.id}</td>
            <td>${role.name} ${newTag}</td>
            <td>${role.count} permissions</td>
            <td>
                ${update_action} ${delete_action}
            </td>
        `;
        }
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
                    data.role.new = true;
                    $('#roles-table-body').append(
                        `<tr>${createRoleElement({
                            role: data.role,
                            can_update: data.can_update,
                            can_delete: data.can_delete,
                        })}</tr>`,
                    );
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
                    var tr = $('#roles-table-body tr').filter(function () {
                        return $(this).find('td:first').text() == role_id;
                    });
                    tr.html(
                        createRoleElement({
                            role: data.role,
                            can_update: data.can_update,
                            can_delete: data.can_delete,
                        }),
                    );
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

        // pagination

        function renderPagination({ current_page, last_page }) {
            let pagination = `<li class="page-item ${current_page === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${current_page - 1}">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="icon"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    stroke-width="2"
                    stroke="currentColor"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M15 6l-6 6l6 6" />
                </svg>
                prev
            </a>
        </li>`;

            for (let i = 0; i < last_page; i++) {
                pagination += `
                    <li class="page-item ${current_page === i + 1 ? 'active mx-1' : ''}">
                        <a class="page-link " href="#" rel="first" data-page="${i + 1}">${i + 1}</a>
                    </li>`;
            }
            pagination += `<li class="page-item ${current_page === last_page ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${current_page + 1}">
                next
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M9 6l6 6l-6 6" />
                </svg>
            </a>
        </li>`;
            $('.pagination').html(pagination);
        }
        function rolesPagination({ page }) {
            const search = $('#search-roles-input').val();
            const sort = $('#select-roles-sort').val();
            history.pushState(null, null, `/admin/roles?page=${page}&search=${search}&sort=${sort}`);
            // call ajax
            $.ajax({
                url: `/admin/roles/pagination?page=${page}&search=${search}&sort=${sort}`,
                type: 'GET',
                success: function (response) {
                    if (response.roles.data.length === 0) {
                        $('#roles-table-body').html(
                            '<tr><td colspan="4" class="text-center text-muted">No data available</td></tr>',
                        );
                        return;
                    }
                    let html = '';
                    response.roles.data.forEach((role) => {
                        html += `<tr>${createRoleElement({
                            role: role,
                            can_update: response.can_update,
                            can_delete: response.can_delete,
                        })}</tr>`;
                    });
                    $('#roles-table-body').html(html);
                    renderPagination({
                        current_page: response.roles.current_page,
                        last_page: response.roles.last_page,
                    });
                },
                error: function (error) {
                    console.log(error);
                },
            });
        }

        $(document).on('click', '.js-roles-pagination .pagination .page-link', function (event) {
            var button = $(event.target);
            const page = button.data('page');
            rolesPagination({ page });
        });

        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
        // search with ajax
        $('#search-roles-input').on(
            'input',
            debounce(function () {
                rolesPagination({ page: 1 });
            }, 500),
        );
        // select sort
        $('#select-roles-sort').change(function () {
            rolesPagination({ page: 1 });
        });

        // authorization pagination
        function createEmployeeElement({ employee, roles, can_authorize }) {
            const phone_number = employee.default_address?.phone_number ?? 'Unset';
            const address = employee.default_address?.address ?? 'Unset';
            const is_active = employee.is_active
                ? `<span class="badge bg-success me-1"></span> Active`
                : ` <span class="badge bg-danger me-1"></span> Blocked`;
            let roles_options = '';
            roles.forEach((role) => {
                if (role.name !== employee.role)
                    roles_options += `<a class="js-change-role dropdown-item"
                data-bs-toggle="modal"
                data-bs-target="#assign-role-confirm-modal">${role.name}</a>`;
            });
            const btn_action = can_authorize
                ? `<button class="btn dropdown-toggle align-text-top"
                        data-bs-toggle="dropdown">
                        ${employee.role ?? 'Unset'}
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        ${roles_options}
                    </div>`
                : `<button class="btn dropdown-toggle align-text-top"
                        disabled
                        data-bs-toggle="dropdown">
                        ${employee.role ?? 'Unset'}
                    </button>
           `;
            return `<tr>
                        <td>${employee.user_id}</td>
                        <td data-label="Name">
                            <div class="d-flex py-1 align-items-center">
                                <span class="avatar me-2"
                                    style="background-image: url(${employee.avatar})"></span>
                                <div class="flex-fill">
                                    <div class="js-fullname font-weight-medium">
                                    ${employee.first_name} ${employee.last_name}</div>
                                    <div class="text-muted"><a href="#"
                                            class="text-reset">${employee.email}</a></div>
                                </div>
                            </div>
                        </td>
                        <td class="text-muted">
                            <div>${phone_number}</div>
                            <div>${address}</div>
                        </td>
                        <td>${is_active}</td>
                        <td>
                            <div class="btn-list flex-nowrap">
                                <div class="dropdown js-dropdown-role ">${btn_action}</div>
                            </div>
                        </td>
                    </tr>`;
        }
        function authorizationPagination({ page }) {
            const search = $('#search-authorization-input').val();
            const type = $('#select-authorization-type').val();
            history.pushState(null, null, `/admin/authorization?page=${page}&search=${search}&type=${type}`);
            // call ajax
            $.ajax({
                url: `/admin/authorization/pagination?page=${page}&search=${search}&type=${type}`,
                type: 'GET',
                success: function (response) {
                    if (response.employees.data.length === 0) {
                        $('#authorization-table-body').html(
                            '<tr><td colspan="5" class="text-center text-muted">No data available</td></tr>',
                        );
                        return;
                    }
                    let html = '';
                    response.employees.data.forEach((employee) => {
                        html += createEmployeeElement({
                            employee,
                            roles: response.roles,
                            can_authorize: response.can_authorize,
                        });
                    });
                    $('#authorization-table-body').html(html);
                    renderPagination({
                        current_page: response.employees.current_page,
                        last_page: response.employees.last_page,
                    });
                },
                error: function (error) {
                    console.log(error);
                },
            });
        }
        $(document).on('click', '.js-authorization-pagination .pagination .page-link', function (event) {
            var button = $(event.target);
            const page = button.data('page');
            authorizationPagination({ page });
        });

        // search with ajax
        $('#search-authorization-input').on(
            'input',
            debounce(function () {
                authorizationPagination({ page: 1 });
            }, 500),
        );
        // select sort
        $('#select-authorization-type').change(function () {
            authorizationPagination({ page: 1 });
        });

        // delete role
        $('#delete-confirm-modal').on('show.bs.modal', function (e) {
            var button = $(e.relatedTarget);
            var role_id = button.data('role-id');
            var role_name = button.data('role-name');
            console.log('====================================');
            console.log(role_id);
            console.log('====================================');
            $(this).find('.modal-description').html(`Do you want to delete role <strong>${role_name}</strong> ?`);
            $(this).find('#confirm-btn').text('Yes, delete this role');
            $(this).find('#confirm-btn').data('role-id', role_id);
        });

        $(document).on('click', '#delete-confirm-modal #confirm-btn', function (e) {
            var role_id = $(this).data('role-id');
            console.log('====================================');
            console.log(role_id);
            console.log('====================================');
            $.ajax({
                url: `/admin/roles/${role_id}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (data) {
                    $('#roles-table-body tr td')
                        .filter(function () {
                            return $(this).text() == role_id;
                        })
                        .closest('tr')
                        .remove();
                },
                error: function (error) {
                    console.log(error);
                    $('#error-delete-modal').addClass('show');
                    $('#error-delete-modal').attr('style', 'display: block;');
                    $('#error-delete-modal').removeAttr('aria-hidden');
                    $('body').append('<div class="modal-backdrop fade show"></div>');
                    $('#error-message').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });
        //  close error modal
        $('.js-close-error-modal').click(function () {
            $('#error-delete-modal').removeClass('show');
            $('#error-delete-modal').attr('style', 'display: none;');
            $('#error-delete-modal').attr('aria-hidden', 'true');
            $('.modal-backdrop.fade.show').remove();
        });
    });
})(jQuery);
