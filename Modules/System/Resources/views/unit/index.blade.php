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
                    @if (permission('unit-access'))
                        <div class="dt-entry__heading">
                            <button class="btn btn-primary btn-sm" type="button"
                                onclick="add_data_modal('Add New','Save')"><i class="fas fa-plus-square"></i> Add New
                            </button>
                        </div>
                    @endif

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
                                <div class="form-group col-md-6 ">
                                    <label for="menu_name">Unit Name</label>
                                    <input class="form-control form-control-sm" type="text" name="unit_name" id="unit_name"
                                        placeholder="Unit Name">
                                </div>
                                <div class="col-md-6 pt-24 pt-5 text-right">
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
                                    @if (permission('unit-bulk-delete'))
                                        <th>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="select_all"
                                                    id="select_all" onchange="check_select_all()">
                                                <label class="form-check-label" for="select_checkbox"></label>
                                            </div>
                                        </th>
                                    @endif
                                    <th>Sl</th>
                                    <th>Unit Code</th>
                                    <th>Unit Name</th>
                                    <th>Base Unit</th>
                                    <th>Operator</th>
                                    <th>Operation Value</th>
                                    <th>Status</th>
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
    @include('system::unit.modal');
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
                    "url": "{{ url('unit/data-table') }}",
                    "type": "POST",
                    "data": function(data) {
                        data.unit_name = $('#form-fillter #unit_name').val();
                        data._token = _token;
                    }
                },
                //columnDefs use for which columns not sorting 
                "columnDefs": [{
                    @if (permission('unit-bulk-delete'))
                        "targets": [0, 8],
                        "orderable": false
                    @else
                        "targets": [7],
                        "orderable": false
                    @endif

                }],
                "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'<'float-right'B>>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'<'float-right'p>>>",

                "buttons": [
                    @if (permission('unit-report'))
                    
                    
                    
                        {
                        "extend": 'colvis',
                        "className": 'btn btn-primary btn-sm text-white',
                        "text": 'Column',
                        },
                        {
                        "extend": 'csv',
                        "className": 'btn btn-primary btn-sm text-white',
                        "title": "Group List",
                        "filename": 'Group-list',
                        "exportOptions": {
                        columns: function(index, data, node) {
                        return table.column(index).visible();
                        }
                        }
                        },
                        {
                        "extend": 'print',
                        "title": "unit-List",
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
                        "title": " List",
                        "className": 'btn btn-primary btn-sm text-white',
                        "filename": 'unit-list',
                        "orientaion": 'landscape',
                        "pageSize": 'A4', //a3,a4,a5,a6,legal,letter
                        "exportOptions": {
                        columns: [1, 2, 3]
                        }
                        },
                        {
                        "extend": 'excel',
                        "title": "Customer List",
                        "className": 'btn btn-primary btn-sm text-white',
                        "filename": 'unit-list',
                        "exportOptions": {
                        columns: function(index, data, node) {
                        return table.column(index).visible();
                        }
                        }
                        }
                    @endif
                    // {
                    //     "className": 'btn btn-danger btn-sm text-white delete_btn d-none',
                    //     "text": 'Delete',
                    //     action: function(e, dt, node, config) {
                    //         multi_delete();
                    //     }
                    // }
                ]
            });
            @if (permission('unit-bulk-delete'))
                $('.dt-buttons').append(
                '<button type="button" class="btn btn-danger btn-sm" id="bulk_action_delete">Delete</button>');
            @endif


            $('#btn_fillter').click(function() {
                var name = $('#form-fillter #unit_name').val();
                if (name == '') {
                    Swal.fire('error', 'please write something..', 'error');
                } else {
                    table.ajax.reload();
                }

            });
            $('#btn_reset').click(function() {
                $('#form-fillter')[0].reset();
                table.ajax.reload();
            });



            $(document).on('click', '.save_btn', function() {
                let storeData = document.getElementById('store_or_update_form');
                let formData = new FormData(storeData);
                let url = "{{ route('unit.store.update') }}";
                let id = $('#update_id').val();
                let method;

                if (id != '') {
                    method = 'update';
                } else {
                    method = 'add';
                }

                $.ajax({
                    url: url,
                    type: 'post',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    cahce: false,
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
                        $('#store_or_update_form').find('.error').remove();


                        if (data.status == false) {
                            $.each(data.errors, function(key, value) {
                                $('#store_or_update_form #' + key).addClass(
                                    'is-invalid');
                                $('#store_or_update_form #' + key).parent().append(
                                    '<small class="error text-danger">' + value +
                                    '</small>');

                            });
                        } else {
                            if (method == 'update') {
                                $('#store_or_update_form #update_id').val('');
                                table.ajax.reload(null, false);
                            } else {
                                table.ajax.reload();
                            }
                            base_unit();
                            notification(data.status, data.message);
                            $('#store_or_update_modal').modal('hide');
                        }
                    }
                });
            });

            $(document).on('click', '.user_edit', function() {
                let id = $(this).data('id');
                $.ajax({
                    url: "{{ route('unit.edit') }}",
                    type: "POST",
                    data: {
                        id: id,
                        _token: _token
                    },
                    success: function(data) {
                        // console.log(data);
                        $('#store_or_update_form #update_id').val(data.id);
                        $('#store_or_update_form #unit_code').val(data.unit_code);
                        $('#store_or_update_form #unit_name').val(data.unit_name);
                        $('#store_or_update_form #base_unit').val(data.base_unit);
                        $('#store_or_update_form #operator').val(data.operator);
                        $('#store_or_update_form #operation_value').val(data.operation_value);
                        $('#store_or_update_form .selectpicker').selectpicker('refresh');


                        $('#store_or_update_modal').modal({
                            keyboard: true,
                            backdrop: 'static'
                        });
                        $('#store_or_update_modal .modal-title').html(
                            '<i class="fas fa-edit"></i> <span> Edit ' + data
                            .name + '</span>');
                        $('#store_or_update_modal .save_btn').text('Update');
                        $('#store_or_update_modal .modal-header').addClass('bg-primary');
                    }
                });

            });

            $(document).on('click', '.user_delete', function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let url = "{{ route('unit.delete') }}";
                let row = table.row($(this).parent('tr'));
                Swal.fire({
                    title: 'Are you sure to delete ' + name + ' data?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: url,
                            type: "POST",
                            data: {
                                id: id,
                                _token: _token
                            },
                            dataType: "JSON",
                        }).done(function(response) {
                            if (response.status == "success") {
                                Swal.fire("Deleted", response.message, "success").then(function() {
                                        table.row(row).remove().draw(false);
                                        base_unit();
                                    });
                                   
                            }
                            if (response.status == "error") {
                                Swal.fire('Oops...', response.message, "error");
                            }
                        }).fail(function() {
                            Swal.fire('Oops...', "Somthing went wrong with ajax!", "error");
                        });
                    }
                });
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
                    let url = "{{ route('unit.bulk.delete') }}"
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
                            }).done(function(res) {
                                if (res.status == 'success') {
                                    Swal.fire("Delete", res.message, "success").then(
                                        function() {
                                            table.row(rows).remove().draw(false);
                                            $('#select_all').prop('checked', false);
                                            base_unit()
                                        });
                                   
                                }
                            }).fail(function() {
                                Swal.fire("Oops..!", "something went wrong", "error");
                            });
                        }
                    })
                }

            });

            $(document).on('click', '.change_status', function() {
                let id = $(this).data('id');
                let status = $(this).data('status');

                Swal.fire({
                    title: 'Are you sure Status Change ? ',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('unit.status') }}",
                            type: 'POST',
                            data: {
                                id: id,
                                status: status,
                                _token: _token
                            },
                            dataType: "JSON",
                        }).done(function(res) {
                            if (res.status == 'success') {
                                Swal.fire("Status", res.message, "success");
                                base_unit();
                                table.ajax.reload();
                            }
                        }).fail(function() {
                            Swal.fire("Oops..!", "something went wrong", "error");
                        });
                    }
                })
            })
            base_unit();

            function base_unit() {
                $.ajax({
                    url: "{{ route('unit.base.unit') }}",
                    type: "POST",
                    data: {
                        _token: _token
                    },
                    success: function(data) {
                        if (data) {

                            $('#store_or_update_form #base_unit').html('');
                            $('#store_or_update_form #base_unit').html(data);
                        } else {
                            $('#store_or_update_form #base_unit').html('');
                        }
                        $('#store_or_update_form .selectpicker').selectpicker('refresh');

                    }
                });
            }

        });

    </script>
@endpush
