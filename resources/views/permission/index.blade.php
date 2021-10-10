@extends('layouts.app')
@section('title', $page_title)
@section('content')
    <div class="dt-content">

        <!-- Page Header -->
        <div class="dt-page__header">
            <h1 class="dt-page__title"><i class="{{ $page_icon }}"></i> {{ $page_title }}</h1>
        </div>
        <!-- /page header -->

        <!-- Grid -->
        <div class="row">
            <div class="col-12">
                <ol class="breadcrumb bg-white">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="active breadcrumb-item">{{ $sub_title }}</li>
                </ol>
            </div>
            <!-- Grid Item -->
            <div class="col-xl-12">

                <!-- Entry Header -->
                <div class="dt-entry__header">

                    <!-- Entry Heading -->
                    <div class="dt-entry__heading">
                        <button class="btn btn-primary btn-sm" type="button" onclick="add_data_modal('Add New','Save')"><i
                                class="fas fa-plus-square"></i> Add New
                        </button>
                    </div>
                    <!-- /entry heading -->

                </div>
                <!-- /entry header -->

                <!-- Card -->
                <div class="dt-card">

                    <!-- Card Body -->
                    <div class="dt-card__body">

                        <!-- Tables -->
                        {{-- <div class="table-responsive"> --}}
                        <form id="form-fillter">

                            <div class="row">
                                <div class="form-group col-4 ">
                                    <label for="menu_name">Name</label>
                                    <input class="form-control form-control-sm" type="text" name="name" id="name"
                                        placeholder="Name">
                                </div>
                                <div class="form-group col-4 ">
                                    <label for="module_id">Module</label>
                                    <select class="form-control selectpicker" name="module_id" id="module_id">
                                        <option value="">Select Please</option>
                                        @foreach ($data['modules'] as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4  pt-24 text-right">
                                    <button id="btn_fillter" type="button" class="btn btn-sm btn-primary "
                                        data-toggle="tooltip" data-placement="top" data-original-title="Search"><i
                                            class="fas fa-search"></i></button>
                                    <button id="btn_reset" type="button" class="btn btn-sm btn-danger" data-toggle="tooltip"
                                        data-placement="top" data-original-title="Reset"><i
                                            class="fas fa-redo-alt"></i></button>

                                </div>
                            </div>
                        </form>

                        <table id="dataTable" class="table table-striped table-bordered table-hover">
                            <thead class="bg-primary ">
                                <tr>
                                    <th>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="select_all"
                                                id="select_all" onchange="check_select_all()">
                                            <label class="form-check-label" for="select_checkbox"></label>
                                        </div>
                                    </th>
                                    <th>Sl</th>
                                    <th>Module</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                    <!-- /tables -->

                </div>
                <!-- /card body -->

            </div>
            <!-- /card -->

        </div>
        <!-- /grid item -->

    </div>
    <!-- /grid -->

    </div>
    @include('permission.modal')
    @include('permission.edit-modal')

@endsection
@push('script')
    <script>
        var table;
        $(document).ready(function() {
            table = $('#dataTable').DataTable({

                "processing": true, //feature control the processing data
                "serverSide": true, //feature control datatable server side processing data
                "order": [], //initial no order
                "responsive": true, //make table responsive mobile mode
                "bInfo": true, //to show the total data number
                "bFilter": false, //datatable default search box false
                "lengthMenu": [
                    [5, 10, 15, 25, 50, 100, 1000, 10000, -1],
                    [5, 10, 15, 25, 50, 100, 1000, 10000, "All"]
                ],
                "pageLength": 5,
                "language": {
                    processing: '<i class="fas fa-spinner fa-spin fa-3x fa-fw text-primary"></i>',
                    emptyTable: '<strong class="text-danger">No Data Found</strong>',
                    infoEmpty: '',
                    zeroRecords: '<strong class="text-danger">No Data Found</strong>',
                },
                "ajax": {
                    "url": "{{ url('menu/module/permission/data-table') }}",
                    "type": "POST",
                    "data": function(data) {
                        data.name = $('#form-fillter #name').val();
                        data.module_id = $('#form-fillter #module_id').val();
                        data._token = _token;
                    }
                },
                //columnDefs use for which columns not sorting 
                "columnDefs": [{
                    "targets": [0, 5],
                    "orderable": false
                }],
                "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'<'float-right'B>>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'<'float-right'p>>>",
                "buttons": [

                    {
                        "extend": 'colvis',
                        "className": 'btn btn-primary btn-sm text-white',
                        "text": 'Column',
                    },
                    {
                        "extend": 'csv',
                        "className": 'btn btn-primary btn-sm text-white',
                        "title": "Permission List",
                        "filename": 'Permission-list',
                        "exportOptions": {
                            columns: function(index, data, node) {
                                return table.column(index).visible();
                            }
                        }
                    },
                    {
                        "extend": 'print',
                        "title": "Permission List",
                        "className": 'btn btn-primary btn-sm text-white',
                        "orientaion": 'landscape',
                        "pageSize": 'A4', //a3,a4,a5,a6,legal,letter
                        "exportOptions": {
                            columns: function(index, data, node) {
                                return table.column(index).visible();
                            }
                        },

                        customize: function(win) {
                            $(win.document.body).addClass('bg-white');
                        }
                    },
                    {
                        "extend": 'pdf',
                        "title": "Permission List",
                        "className": 'btn btn-primary btn-sm text-white',
                        "filename": 'Permission-list',
                        "orientaion": 'landscape',
                        "pageSize": 'A4', //a3,a4,a5,a6,legal,letter
                        "exportOptions": {
                            columns: [1, 2, 3]
                        }
                    },
                    {
                        "extend": 'excel',
                        "title": "Permission List",
                        "className": 'btn btn-primary btn-sm text-white',
                        "filename": 'Permission-list',
                        "exportOptions": {
                            columns: function(index, data, node) {
                                return table.column(index).visible();
                            }
                        }
                    }
                    // {
                    //     "className": 'btn btn-danger btn-sm text-white delete_btn d-none',
                    //     "text": 'Delete',
                    //     action: function(e, dt, node, config) {
                    //         multi_delete();
                    //     }
                    // }
                ]
            });

            $('#btn_fillter').click(function() {
                if ($('#form-fillter #name').val() != '' || $('#form-fillter #module_id').val() != '') {
                    table.ajax.reload();
                    $('#form-fillter')[0].reset();
                    $('#form-fillter .selectpicker').val('').trigger('change');
                } else {
                    Swal.fire('error', 'please select any feilds', 'error');
                }

            })

            $('#btn_reset').click(function() {
                $('#form-fillter')[0].reset();
                $('#form-fillter .selectpicker').val('').trigger('change');

                table.ajax.reload();


            });

            $('.dt-buttons').append(
                '<button type="button" class="btn btn-danger btn-sm delete_btn " id="bulk_action_delete">Delete</button>'
            );
            var count = 1;

            function add_daynamic_fields(row) {
                var html = `<tr>
                                 <td>
                                    <input  onkeyup="url_generator(this.value,'permission_` +row + `_slug')" 
                                    type="text" name="permission[` + row + `][name]" id="permission_` + row + `_name"
                                     class="form-control"></td>
                                  <td>
                                     <input type="text" name="permission[` +row +`][slug]" id="permission_` + row + `_slug"class="form-control"></td>
                                  <td>
                                      <button type="button" id="remove_permission" class="btn btn-danger btn-sm "
                                         data-toggle="tooltip" data-placement="top"data-original-title="Remove">
                                           <i class="fas fa-minus-square"></i>
                                     </button>
                                  </td>
                            </tr>`;
                $('#permission_table tbody').append(html);
            }
            $(document).on('click', '#add_permission', function() {
                count++;
                add_daynamic_fields(count);
            });

            $(document).on('click', '#remove_permission', function() {
                count--;
                $(this).closest('tr').remove();
            });

            $(document).on('click', '.save_btn', function() {
                let form = document.getElementById('store_or_update_form');
                let formData = new FormData(form);
                $.ajax({
                    url: "{{ route('menu.module.permission.store') }}",
                    type: "POST",
                    data: formData,
                    dataType: "JSON",
                    contentType: false,
                    processData: false,
                    cache: false,
                    beforeSend: function() {
                        $('.save_btn').addClass('kt-spinner kt-spinner--md kt-spinner--light');
                    },
                    complete: function() {
                        $('.save_btn').removeClass(
                            'kt-spinner kt-spinner--md kt-spinner--light');
                    },
                    success: function(data) {
                        $('#store_or_update_form').find('.is-invalid').removeClass(
                            'is-invalid');
                        // $('#store_or_update_form').find('.error').val('');

                        $('#store_or_update_form').find('.error').remove();

                        if (data.status == false) {
                            $.each(data.errors, function(key, value) {
                                var key = key.split('.').join('_');
                                $('#store_or_update_form select#' + key).parent()
                                    .addClass('is-invalid');
                                $('#store_or_update_form #' + key).parent().append(
                                    '<small class="error text-danger">' + value +
                                    '</small>');
                                $('#store_or_update_form table').find('#' + key)
                                    .addClass('is-invalid');
                            });
                        } else {
                            if (data.status == 'success') {
                                table.ajax.reload();
                                notification('success', data.message);
                                $('#store_or_update_modal').modal('hide');
                            }
                        }
                    },
                    error: function(xhr, ajaxoption, thrownError) {
                        console.log('error');
                        console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr
                            .responseText);
                    }
                });
            });

            $(document).on('click', '.user_edit', function() {
                let id = $(this).data('id');
                if (id) {
                    $.ajax({
                        url: "{{ route('menu.module.permission.edit') }}",
                        type: "POST",
                        data: {
                            id: id,
                            _token: _token
                        },
                        dataType: "JSON",
                        success: function(data) {
                            $('#update_form #update_id').val(data.data.id);
                            $('#update_form #name').val(data.data.name);
                            $('#update_form #slug').val(data.data.slug);
                            $('#update_modal').modal({
                                keyboard: true,
                                backdrop: 'static',
                            });
                            $('#update_modal .modal-title').html(
                                '<i class="fas fa-edit"></i> <span> Edit ' + data.data
                                .name + '</span>');
                            $('#update_modal .update_btn').text('Update');
                            $('#update_modal .modal-header').addClass('bg-primary');
                        },
                        error: function(xhr, ajaxoption, thrownError) {
                            console.log('error');
                            console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr
                                .responseText);
                        }
                    });
                }
            })

            $(document).on('click', '.update_btn', function() {

                let store_form = document.getElementById('update_form');
                let formData = new FormData(store_form);
                $.ajax({
                    url: "{{ route('menu.module.permission.update') }}",
                    type: "POST",
                    data: formData,
                    dataType: "JSON",
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(data) {
                        $('#update_form').find('.is-invalid').removeClass('is-invalid');
                        $('#update_form').find('.error').remove();
                        if (data.status == false) {
                            $.each(data.errors, function(key, value) {
                                $('#update_form input#' + key).parent()
                                    .addClass('is-invalid');
                                $('#update_form #' + key).parent().append(
                                    '<small class="error text-danger">' + value +
                                    '</small>');


                            });
                        } else {
                            if (data.status == 'success') {
                                table.ajax.reload(null, false);
                                $('#update_form #update_id').val('');
                            }
                            notification(data.status, data.message);
                            $('#update_modal').modal('hide');
                        }

                    },
                    error: function(xhr, ajaxoption, thorwnError) {
                        console.log('error');
                        console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr
                            .responseText);
                    }
                });
            });

            $(document).on('click', '.user_delete', function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let url = "{{ route('menu.module.permission.delete') }}";
                let row = table.row($(this).parent('tr'));
                delete_data(id, url, table, row, name);

            });

            $(document).on('click', '#bulk_action_delete', function() {
                let id = [];
                let rows;
                $('.select_data:checked').each(function() {
                    id.push($(this).val());
                    rows = table.row($('.select_data:checked').parents('tr'));
                });
                if (id.length == 0) {
                    Swal.fire({
                        type: 'error',
                        title: 'error',
                        text: 'please select at least one row'
                    });
                } else {
                    let url = "{{ route('menu.module.permission.bulk_delete') }}"
                    bulk_action_delete(url, id, rows, table);
                }

            });
        });

        function url_generator(input_value, output_id) {
            var value = input_value.toLowerCase().trim();
            var str = value.replace(/ +(?= )/g, '');
            var name = str.split(' ').join('-');
            $('#' + output_id).val(name);
        }

    </script>
@endpush
