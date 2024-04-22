jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        function createUserElement({ user, can_update = false, can_delete = false }) {
            const type = user.is_staff ? 'employee' : 'customers';
            const newTag = user.new ? '<span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>' : '';
            const status = user.is_active
                ? '<span class="badge bg-success me-1"></span> Active'
                : '<span class="badge bg-danger me-1"></span> Blocked';
            const update_action =
                can_update && user.is_staff
                    ? `<a href="#" class="btn p-2" data-bs-toggle="modal"
                        data-bs-target="#update-employee-modal"
                        data-user-id="${user.user_id}">
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
                ? user.is_active
                    ? `<a href="#" class="btn p-2" data-bs-toggle="modal"
                        data-bs-target="#delete-confirm-modal"
                        data-user-id="${user.user_id}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-trash">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 7l16 0" />
                            <path d="M10 11l0 6" />
                            <path d="M14 11l0 6" />
                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                        </svg>
                    </a>`
                    : `<a href="#" class="btn p-2" data-bs-toggle="modal"
                        data-bs-target="#restore-user-modal"
                        data-user-id="${user.user_id}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-key">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z" />
                            <path d="M15 9h.01" />
                        </svg></a>`
                : '';
            const view_action = `<a href="${type}/${user.user_id}/details" class="btn p-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round"
                class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-eye">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                <path
                    d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
            </svg>
            </a>`;
            const action = `
                ${view_action}
                ${update_action}
                ${delete_action}`;
            const phone_number = user.default_address?.phone_number ?? 'Unset';
            const address = user.default_address?.address ?? 'Unset';
            const birth_date = user.birth_date ?? 'Unset';
            const gender = user.gender ? 'Male' : 'Female';
            return `<tr>
            <td>${user.user_id}</td>
            <td>
                <div class="d-flex py-1 align-items-center">
                    <span class="avatar me-2" style="background-image: url(${user.avatar})"></span>
                    <div class="flex-fill">
                        <div class="font-weight-medium">
                        ${user.first_name} ${user.last_name} ${newTag}</div>
                        <div class="text-muted"><a href="#"
                                class="text-reset">${user.email}</a></div></div>
                </div>
            </td>
            <td><div>${gender}</div></td>
            <td>${birth_date}</td>
            <td class="text-muted">
                <div>${phone_number}</div>
                <div>${address}</div>
            </td>
            <td>${status}</td>
            <td>${action}</td>
        </tr>`;
        }

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
                    response.user.new = true;
                    response.user.is_active = true;

                    $('#employee-table-body').append(
                        createUserElement({
                            user: response.user,
                            can_update: response.can_update,
                            can_delete: response.can_delete,
                        }),
                    );
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
            const user_id = button.data('user-id');
            modal.find('#update-employee-title').html('Update Employee - ' + user_id);
            $.ajax({
                url: `/admin/employee/${user_id}`,
                type: 'GET',
                success: function (response) {
                    modal.find('#first_name').val(response.user.first_name);
                    modal.find('#last_name').val(response.user.last_name);
                    modal.find('#email ').val(response.user.email);
                    modal.find('#email ').attr('readonly', true);
                    modal.find('#address ').val(response.user.default_address.address);
                    modal.find('#phone_number ').val(response.user.default_address.phone_number);
                    modal.find('#birth_date ').val(response.user.birth_date);
                    if (response.user.gender) modal.find('#male ').prop('checked', true);
                    else modal.find('#female ').prop('checked', true);
                },
                error: function (error) {
                    console.log(error);
                },
            });
        });

        // update employee
        $('#update-employee-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: `/admin/employee/update`,
                type: 'POST',
                data: formData,
                success: function (response) {
                    // Handle the success response
                    $('#update_employee_response').removeClass('alert-successs d-none');
                    $('#update_employee_response').addClass('alert-success');
                    $('#update_employee_response').html(Object.values(response.message));
                    var row = $('#employee-table-body tr').filter(function () {
                        return $(this).find('td:first').text() == response.user.user_id;
                    });
                    if (row) {
                        let html = createUserElement({
                            user: response.user,
                            can_update: response.can_update,
                            can_delete: response.can_delete,
                        });
                        html = html.replace('<tr>', '');
                        html = html.replace('</tr>', '');
                        row.html(html);
                    }
                },
                error: function (error) {
                    // Handle the error response
                    $('#update_employee_response').removeClass('alert-success d-none');
                    $('#update_employee_response').addClass('alert-danger');
                    $('#update_employee_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });

        // click delete employee
        $('#delete-confirm-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var userId = button.data('user-id');
            $(this)
                .find('.modal-description')
                .html(`If deleted, users will not be able to access the system, but data will still be stored.`);
            $(this).find('#confirm-btn').data('user-id', userId);
            $(this).find('#confirm-btn').text('Yes, delete this user');
        });
        // click restore employee
        $('#restore-user-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var userId = button.data('user-id');
            var modal = $(this);
            modal.find('.modal-footer button.btn').data('user-id', userId);
        });
        // delete user
        $('#delete-confirm-modal').on('click', '#confirm-btn', function (e) {
            var userId = $(this).data('user-id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: `/admin/users/${userId}/ban`,
                type: 'GET',
                success: function (response) {
                    var link = $('.js-user-table a[data-user-id="' + userId + '"]');
                    // update status
                    var statusCell = link.closest('tr').find('td').eq(5);
                    statusCell.html('<span class="badge bg-danger me-1"></span> Blocked');
                    // update action
                    var actionCell = link.closest('tr').find('td').eq(6);
                    actionCell.find('a:last').remove();
                    actionCell.append(`<a href="#" class="btn p-2" data-bs-toggle="modal"
                        data-bs-target="#restore-user-modal"
                        data-user-id="${userId}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-key">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z" />
                            <path d="M15 9h.01" />
                        </svg>
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
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: `/admin/users/${userId}/unban`,
                type: 'GET',
                success: function (response) {
                    var link = $('.js-user-table a[data-user-id="' + userId + '"]');
                    // update status
                    var statusCell = link.closest('tr').find('td').eq(5);
                    statusCell.html('<span class="badge bg-success me-1"></span> Active');
                    // update action
                    var actionCell = link.closest('tr').find('td').eq(6);
                    actionCell.find('a:last').remove();
                    actionCell.append(`<a href="#" class="btn p-2" data-bs-toggle="modal"
                        data-bs-target="#delete-user-modal"
                        data-user-id="${userId}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-trash">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 7l16 0" />
                            <path d="M10 11l0 6" />
                            <path d="M14 11l0 6" />
                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                        </svg>
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

        // user pagination
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

        // employee pagination
        function employeePagination({ page }) {
            const search = $('#search-employee-input').val();
            const type = $('#select-employee-type').val();
            history.pushState(null, null, `/admin/employee?page=${page}&type=${type}&search=${search}`);
            // call ajax
            $.ajax({
                url: `/admin/employee/pagination?page=${page}&type=${type}&search=${search}`,
                type: 'GET',
                success: function (response) {
                    if (response.employee.data.length === 0) {
                        $('#employee-table-body').html(
                            '<tr><td colspan="7" class="text-center text-muted">No data available</td></tr>',
                        );
                        return;
                    }
                    let html = '';
                    response.employee.data.forEach((employee) => {
                        html += createUserElement({
                            user: employee,
                            can_update: response.can_update,
                            can_delete: response.can_delete,
                        });
                    });
                    $('#employee-table-body').html(html);
                    renderPagination({
                        current_page: response.employee.current_page,
                        last_page: response.employee.last_page,
                    });
                },
                error: function (error) {
                    console.log(error);
                },
            });
        }

        $(document).on('click', '.js-employee-pagination .pagination .page-link', function (event) {
            var button = $(event.target);
            const page = button.data('page');
            employeePagination({ page });
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
        $('#search-employee-input').on(
            'input',
            debounce(function () {
                employeePagination({ page: 1 });
            }, 500),
        );
        // select type
        $('#select-employee-type').change(function () {
            employeePagination({ page: 1 });
        });

        // customers pagination

        function customersPagination({ page }) {
            const search = $('#search-customers-input').val();
            const type = $('#select-customers-type').val();
            history.pushState(null, null, `/admin/customers?page=${page}&type=${type}&search=${search}`);
            // call ajax
            $.ajax({
                url: `/admin/customers/pagination?page=${page}&type=${type}&search=${search}`,
                type: 'GET',
                success: function (response) {
                    if (response.customers.data.length === 0) {
                        $('#customers-table-body').html(
                            '<tr><td colspan="7" class="text-center text-muted">No data available</td></tr>',
                        );
                        return;
                    }
                    let html = '';
                    response.customers.data.forEach((customer) => {
                        html += createUserElement({ user: customer, can_delete: response.can_delete });
                    });
                    $('#customers-table-body').html(html);
                    renderPagination({
                        current_page: response.customers.current_page,
                        last_page: response.customers.last_page,
                    });
                },
                error: function (error) {
                    console.log(error);
                },
            });
        }

        $(document).on('click', '.js-customers-pagination .pagination .page-link', function (event) {
            var button = $(event.target);
            const page = button.data('page');
            customersPagination({ page });
        });

        // search with ajax
        $('#search-customers-input').on(
            'input',
            debounce(function () {
                customersPagination({ page: 1 });
            }, 500),
        );

        // select type
        $('#select-customers-type').change(function () {
            customersPagination({ page: 1 });
        });
    });
})(jQuery);
