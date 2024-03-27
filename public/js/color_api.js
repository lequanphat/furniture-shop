jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        //  create color
        $('#create-color-modal').on('show.bs.modal', function (event) {
            $('#create-color-form')[0].reset();
            $('#create_response').addClass('d-none');
        });
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
                    const data_asset = $('#asset').attr('data-asset');
                    const row = `
                        <tr>
                            <td>${response.color.color_id}</td>
                            <td>${response.color.name}
                                <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New
                                </span>
                            </td>
                            <td>
                                <div class="col-auto rounded"
                                    style="background: ${response.color.code}; width: 20px; height: 20px;">
                                </div>
                            </td>
                            <td>
                                <a href="#" class="btn p-2">
                                    <img src="${data_asset}svg/edit.svg" style="width: 18px;" 
                                    data-bs-toggle="modal"
                                    data-bs-target="#update-color-modal"
                                    data-id="${response.color.color_id}"
                                    data-name="${response.color.name}" 
                                    data-code="${response.color.code}" />
                                </a>
                                <a href="#" class="js-delete-color btn p-2"
                                    data-id="${response.color.color_id}">
                                    <img src="${data_asset}svg/trash.svg" style="width: 18px;" />
                                </a>
                                
                            </td>
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
                        row.html(`
                            <td>${response.color.color_id}</td>
                        <td>${response.color.name}
                            <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New
                            </span>
                        </td>
                        <td>
                            <div class="col-auto rounded"
                                style="background: ${response.color.code}; width: 20px; height: 20px;">
                            </div>
                        </td>
                        <td>
                            <a href="#" class="btn p-2">
                                <img src="${data_asset}svg/edit.svg" style="width: 18px;" 
                                data-bs-toggle="modal"
                                data-bs-target="#update-color-modal"
                                data-id="${response.color.color_id}"
                                data-name="${response.color.name}" 
                                data-code="${response.color.code}" />
                            </a>
                            <a href="#" class="js-delete-color btn p-2"
                                data-id="${response.color.color_id}">
                                <img src="${data_asset}svg/trash.svg" style="width: 18px;" />
                            </a>
                        </td>
                   `);
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
