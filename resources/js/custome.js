$('.dropify').dropify();




function store_form_data(table, url, method, formData) {
    //alert('hi');

    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        dataType: "JSON",
        contentType: false,
        processData: false,
        cache: false,
        success: function (data) {
            $('#storeData').find('.is-invalid').removeClass('is-invalid');
            $('#storeData').find('.error').remove();
            if (data.status == false) {
                $.each(data.errors, function (key, value) {
                    $('#storeData #' + key).addClass('is-invalid');
                    $('#storeData #' + key).parent().append(
                        "<div class='error invalid-tooltip'>" + value + "</div>");
                });
            } else {
                //FlashMessage(data.status, data.msg);
                if (data.status == 'success') {
                    if (method == 'update') {
                        table.ajax.reload(null, false);
                        $('#storeData #update_id').val('');
                        $('#storeData #old_image').val('');

                    } else {
                        table.ajax.reload();
                    }
                    console.log(method);
                    //resetForm('storeData');
                    $('#saveData').modal('hide');
                }

            }
        },

        error: function (xhr, ajaxoption, thrownError) {
            console.log('error');
            console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
        }
    });
}

function bulk_action_delete(url, id, rows, table){
    Swal.fire({
        title: 'Are you sure  Data Delete',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    id: id,
                    _token: _token
                },
                dataType: "JSON",
            }).done(function (res) {
                if (res.status == 'success') {
                    Swal.fire("Delete", res.message, "success").then(function () {
                        table.row(rows).remove().draw(false);
                        $('#select_all').prop('checked', false);
                    });
                }
            }).fail(function () {
                Swal.fire("Oops..!", "something went wrong", "error");
            });
        }
    })
}

function delete_user(table, url, row, id, name) {
    Swal.fire({
        title: 'Are you sure ' + name + ' Data Delete',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    id: id,
                    _token: _token
                },
                dataType: "JSON",
            }).done(function (res) {
                if (res.status == 'success') {
                    Swal.fire("Delete", res.message, "success").then(function () {
                        table.row(row).remove().draw(false);
                    });
                }
            }).fail(function () {
                Swal.fire("Oops..!", "something went wrong", "error");
            });
        }
    })
}


function add_data_modal(title, btnText) {

    $('#store_or_update_form')[0].reset();
    $('#store_or_update_form').find('.is-invalid').removeClass('is-invalid');
    $('#store_or_update_form').find('.error').remove();
    //$('#storData .dropify-render img').attr('src', '');

    $('.selectpicker').trigger('change').val('');
    $('#store_or_update_modal').modal({
        keyboard: true,
        backdrop: 'static'
    });
    $('#store_or_update_form .modal-title').text(title);
    $('#store_or_update_form #save_btn').text(btnText);
}

function check_select_all() {
    if ($('#select_all:checked').length == 1) {
        $('.select_data').prop('checked', true);
    } else {
        $('.select_data').prop('checked', false);
    }
    $('.select_data').is(':checked') ? $('.select_data').closest('tr').addClass('bg-warning') : $('.select_data').closest('tr').removeClass('bg-warning')
}

function select_single_item(id) {
    let total = $('.select_data').length;
    let total_checked = $('.select_data:checked').length;
    // console.log(total + '==' + total_checked);

    $('#checkbox' + id).is(':checked') ? $('#checkbox' + id).closest('tr').addClass('bg-warning') : $('#checkbox' + id).closest('tr').removeClass('bg-warning')
    total == total_checked ? $('#select_all').prop('checked', true) : $('#select_all').prop('checked', false)

}

function  bulk_action_delete(url, id, rows, table) {
    Swal.fire({
        title: 'Are you sure  Data Delete',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    id: id,
                    _token: _token
                },
                dataType: "JSON",
            }).done(function (res) {
                if (res.status == 'success') {
                    Swal.fire("Delete", res.message, "success").then(function () {
                       table.row(rows).remove().draw(false);
                       $('#select_all').prop('checked', false);
                    });
                }
            }).fail(function () {
                Swal.fire("Oops..!", "something went wrong", "error");
            });
        }
    })
}
