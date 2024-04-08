jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        const data_asset = $('#asset').attr('data-asset');

        function createEmployeeElement(employee) {
            return `<tr>
            <td>${employee.user_id}</td>
            <td>
                <div class="d-flex py-1 align-items-center">
                    <span class="avatar me-2"
                        style="background-image: url(${employee.avatar})"></span>
                    <div class="flex-fill">
                        <div class="font-weight-medium">
                        ${employee.first_name} ${employee.last_name}
                            ${
                                employee.new
                                    ? `<span
                            class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>`
                                    : ''
                            }
                        </div>
                        <div class="text-muted"><a href="#"
                                class="text-reset">${employee.email}</a></div>
                    </div>
                </div>
            </td>
            <td>
                <div>
                ${employee.gender ? 'Male' : 'Female'}
                </div>
            </td>
            <td>
            ${employee.birth_date ? employee.birth_date : 'Unset'}
            </td>
            <td class="text-muted">
                <div>
                ${employee.default_address.phone_number ? employee.default_address.phone_number : 'Unset'}
                </div>
                <div>
                ${employee.default_address.address ? employee.default_address.address : 'Unset'}
                </div>
            </td>
            <td>
            ${
                employee.is_active
                    ? '<span class="badge bg-success me-1"></span> Active'
                    : '<span class="badge bg-danger me-1"></span> Blocked'
            }
            </td>
            <td>
                <a href="employee/${employee.user_id}/details" class="btn p-2">
                    <img src="${data_asset}svg/view.svg" style="width: 18px;" />
                </a>
                <a href="#" class="btn p-2" data-bs-toggle="modal"
                    data-bs-target="#update-employee-modal"
                    data-user-id="${employee.user_id}">
                    <img src="${data_asset}svg/edit.svg" style="width: 18px;" />
                </a>
                ${
                    employee.is_active
                        ? `<a href="#" class="btn p-2" data-bs-toggle="modal"
                data-bs-target="#delete-user-modal"
                data-user-id="${employee.user_id}">
                <img src="${data_asset}svg/trash.svg" style="width: 18px;" />
            </a>`
                        : `<a href="#" class="btn p-2" data-bs-toggle="modal"
            data-bs-target="#restore-user-modal"
            data-user-id="${employee.user_id}">
            <img src="${data_asset}svg/key.svg" style="width: 18px;" />`
                }
            </td>
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

                    $('#employee-table-body').append(createEmployeeElement(response.user));
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
                    console.log(response);
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
                        let html = createEmployeeElement(response.user);
                        html = html.replace('<tr>', '');
                        html = html.replace('</tr>', '');
                        console.log(html);
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

        function employeePagination({ page }) {
            const search = $('#search-employee-input').val();
            history.pushState(null, null, `/admin/employee?page=${page}&search=${search}`);
            // call ajax
            $.ajax({
                url: `/admin/employee/pagination?page=${page}&search=${search}`,
                type: 'GET',
                success: function (response) {
                    let html = '';
                    response.employee.data.forEach((employee) => {
                        console.log(employee);
                        html += createEmployeeElement(employee);
                    });
                    $('#employee-table-body').html(html);
                    renderPagination({
                        current_page: response.employee.current_page,
                        last_page: response.employee.last_page,
                    });
                    console.log(html);
                },
                error: function (error) {
                    console.log(error);
                },
            });
        }

        // pagination
        $(document).on('click', '.pagination .page-link', function (event) {
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
    });
})(jQuery);
