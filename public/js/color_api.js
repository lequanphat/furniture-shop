jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        //  create color
        $('#create-color-modal').on('show.bs.modal', function (event) {
            $('#create-color-form')[0].reset();
            $('#create_response').addClass('d-none');
        });

        function createColorElement({ color, can_update = false, can_delete = false }) {
            const newTag = color.new
                ? '<span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>'
                : '';
            const update_btn = can_update
                ? `<a class="btn p-2" data-bs-toggle="modal"
                data-bs-target="#update-color-modal" data-id="${color.color_id}"
                data-name="${color.name}" data-code="${color.code}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-pencil">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                    <path d="M13.5 6.5l4 4" />
                </svg>
            </a>`
                : '';
            const delete_btn = can_delete
                ? `<a href="#" class="js-delete-color btn p-2"
                data-id="${color.color_id}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
            return `<td>${color.color_id}</td>
                <td>${color.name}
                    ${newTag}
                </td>
                <td>
                    <div class="col-auto rounded"
                        style="background: ${color.code}; width: 20px; height: 20px;border: 1px solid #ccc;" >
                    </div>
                </td>
                <td>${update_btn} ${delete_btn}</td>`;
        }
        $('#create-color-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/admin/colors',
                type: 'POST',
                data: formData,
                success: function (response) {
                    // Handle the success response
                    $('#create_response').removeClass('alert-danger d-none');
                    $('#create_response').addClass('alert-success');
                    $('#create_response').html(response.message);
                    response.color.new = true;
                    const row = `
                        <tr>
                            ${createColorElement({
                                color: response.color,
                                can_update: response.can_update,
                                can_delete: response.can_delete,
                            })}
                        </tr>`;
                    if ($('#color-table1-body').find('tr').length < 8) {
                        $('#color-table1-body').append(row);
                    } else {
                        $('#color-table2-body').append(row);
                    }
                },
                error: function (error) {
                    console.log(error);
                    // Handle the error response
                    $('#create_response').removeClass('alert-successs d-none');
                    $('#create_response').addClass('alert-danger');
                    $('#create_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });

        //  update color
        $('#update-color-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            $('#update-color-form').data('id', button.data('id'));
            modal.find('.modal-title').html('Update Color - ' + button.data('id'));
            modal.find('#name').val(button.data('name'));
            modal.find('#code').val(button.data('code'));
            $('#update_response').html('');
            $('#update_response').addClass('d-none');
        });

        $('#update-color-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: `/admin/colors/${$('#update-color-form').data('id')}`,
                type: 'PATCH',
                data: formData,
                success: function (response) {
                    // Handle the success response
                    $('#update_response').removeClass('alert-danger d-none');
                    $('#update_response').addClass('alert-success');
                    $('#update_response').html(response.message);

                    var row = $('#color-table1-body tr').filter(function () {
                        return $(this).find('td:first').text() == response.color.color_id;
                    });
                    if (row.length === 0) {
                        row = $('#color-table2-body tr').filter(function () {
                            return $(this).find('td:first').text() == response.color.color_id;
                        });
                    }
                    if (row) {
                        const data_asset = $('#asset').attr('data-asset');
                        row.html(
                            createColorElement({
                                color: response.color,
                                can_update: response.can_update,
                                can_delete: response.can_delete,
                            }),
                        );
                    }
                },
                error: function (error) {
                    // Handle the error response
                    $('#update_response').removeClass('alert-successs d-none');
                    $('#update_response').addClass('alert-danger');
                    $('#update_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });

        // delete color
        $(document).on('click', '.js-delete-color', function (e) {
            e.preventDefault();
            var color_id = $(this).data('id');
            console.log(color_id);
            var row = $(this).closest('tr');
            $.ajax({
                url: `/admin/colors/${color_id}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    row.remove();
                },
                error: function (error) {
                    // show error modal
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
