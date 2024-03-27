jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        const data_asset = $('#asset').attr('data-asset');
        // create tag

        $('#create-tag-modal').on('show.bs.modal', function (event) {
            $('#create-tag-form')[0].reset();
            $('#create_response').addClass('d-none');
        });

        $('#create-tag-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/admin/tags',
                type: 'POST',
                data: formData,
                success: function (response) {
                    // Handle the success response
                    $('#create_response').removeClass('alert-danger d-none');
                    $('#create_response').addClass('alert-success');
                    $('#create_response').html(response.message);

                    const row = `
                        <tr>
                        <td>${response.tag.tag_id}</td>
                        <td><span class="badge bg-cyan-lt">${response.tag.name}</span>
                        <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New
                        </span>
                        </td>
                        <td>
                            <a class="btn p-2">
                                <img src="${data_asset}svg/edit.svg" style="width: 18px;"
                                    data-bs-toggle="modal" data-bs-target="#update-tag-modal"
                                    data-id="${response.tag.tag_id}" data-name="${response.tag.name}" />
                            </a>
                            <a href="#" class="js-delete-tag btn p-2"
                                data-id="${response.tag.tag_id}">
                                <img src="${data_asset}svg/trash.svg" style="width: 18px;" />
                            </a>
                        </td>
                        </tr>`;

                    if ($('#tag-table1-body').find('tr').length < 8) {
                        $('#tag-table1-body').append(row);
                    } else {
                        $('#tag-table2-body').append(row);
                    }
                },
                error: function (error) {
                    // Handle the error response
                    $('#create_response').removeClass('alert-successs d-none');
                    $('#create_response').addClass('alert-danger');
                    $('#create_response').html(Object.values(error.responseJSON.errors)[0][0]);
                },
            });
        });

        // update tag

        $('#update-tag-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            $('#update-tag-form').data('id', button.data('id'));
            modal.find('.modal-title').html('Update Tag - ' + button.data('id'));
            modal.find('#name').val(button.data('name'));
            $('#update_response').html('');
            $('#update_response').addClass('d-none');
        });

        $('#update-tag-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: `/admin/tags/${$('#update-tag-form').data('id')}`,
                type: 'PATCH',
                data: formData,
                success: function (response) {
                    // Handle the success response
                    $('#update_response').removeClass('alert-danger d-none');
                    $('#update_response').addClass('alert-success');
                    $('#update_response').html(response.message);

                    var row = $('#tag-table1-body tr').filter(function () {
                        return $(this).find('td:first').text() == response.tag.tag_id;
                    });
                    if (row.length === 0) {
                        row = $('#tag-table2-body tr').filter(function () {
                            return $(this).find('td:first').text() == response.tag.tag_id;
                        });
                    }
                    if (row) {
                        row.html(`
                        <td>${response.tag.tag_id}</td>
                        <td><span class="badge bg-cyan-lt">${response.tag.name}</span>
                        <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New
                        </span>
                        </td>
                        <td>
                            <a class="btn p-2">
                                <img src="${data_asset}svg/edit.svg" style="width: 18px;"
                                    data-bs-toggle="modal" data-bs-target="#update-tag-modal"
                                    data-id="${response.tag.tag_id}" data-name="${response.tag.name}" />
                            </a>
                            <a href="#" class="js-delete-tag btn p-2"
                                data-id="${response.tag.tag_id}">
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

        // delete tag
        $(document).on('click', '.js-delete-tag', function (e) {
            e.preventDefault();
            var tag_id = $(this).data('id');
            console.log(tag_id);
            var row = $(this).closest('tr');
            $.ajax({
                url: `/admin/tags/${tag_id}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    row.remove();
                },
                error: function (error) {
                    // show error modal
                    console.log(error);
                    // $('#error-delete-modal').addClass('show');
                    // $('#error-delete-modal').attr('style', 'display: block;');
                    // $('#error-delete-modal').removeAttr('aria-hidden');
                    // $('body').append('<div class="modal-backdrop fade show"></div>');
                    // $('#error-message').html(Object.values(error.responseJSON.message));
                },
            });
        });
    });
})(jQuery);
