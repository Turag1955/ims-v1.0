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
                    @if (permission('category-access'))
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
                                <div class="form-group col-6 ">
                                    <label for="menu_name">Category Name</label>
                                    <input class="form-control form-control-sm" type="text" name="name" id="name"
                                        placeholder=" Name">
                                </div>
                                <div class="col-6  pt-24 text-right">
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
                                    @if (permission('category-bulk-delete'))
                                        <th>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="select_all"
                                                    id="select_all" onchange="check_select_all()">
                                                <label class="form-check-label" for="select_checkbox"></label>
                                            </div>
                                        </th>
                                    @endif
                                    <th>Sl</th>
                                    <th> Name</th>
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
    @include('category::modal')
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
                    "url": "{{ url('category/data-table') }}",
                    "type": "POST",
                    "data": function(data) {
                        data.name = $('#form-fillter #name').val();
                        data._token = _token;
                    }
                },
                //columnDefs use for which columns not sorting 
                "columnDefs": [{
                    @if (permission('category-bulk-delete'))
                        "targets": [0, 4],
                        "orderable": false
                    @else
                        "targets": [3],
                        "orderable": false
                    @endif

                }],
                "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'<'float-right'B>>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'<'float-right'p>>>",

                "buttons": [
                    @if (permission('category-report'))
                    
                    
                    
                        {
                        "extend": 'colvis',
                        "className": 'btn btn-primary btn-sm text-white',
                        "text": 'Column',
                        },
                        {
                        "extend": 'csv',
                        "className": 'btn btn-primary btn-sm text-white',
                        "title": "category List",
                        "filename": 'category-list',
                        "exportOptions": {
                        columns: function(index, data, node) {
                        return table.column(index).visible();
                        }
                        }
                        },
                        {
                        "extend": 'print',
                        "title": "category List",
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
                        "title": "category List",
                        "className": 'btn btn-primary btn-sm text-white',
                        "filename": 'category-list',
                        "orientaion": 'landscape',
                        "pageSize": 'A4', //a3,a4,a5,a6,legal,letter
                        "exportOptions": {
                        columns: [1, 2, 3]
                        }
                        },
                        {
                        "extend": 'excel',
                        "title": "category List",
                        "className": 'btn btn-primary btn-sm text-white',
                        "filename": 'category-list',
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
            @if (permission('category-bulk-delete'))
                $('.dt-buttons').append(
                '<button type="button" class="btn btn-danger btn-sm" id="bulk_action_delete">Delete</button>');
            @endif


            $('#btn_fillter').click(function() {
                var name = $('#form-fillter #name').val();
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
                let url = "{{ route('category.store.update') }}";
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
                            notification(data.status, data.message);
                            $('#store_or_update_modal').modal('hide');
                        }
                    }
                });
            });

            $(document).on('click', '.user_edit', function() {
                let id = $(this).data('id');
                $.ajax({
                    url: "{{ route('category.edit') }}",
                    type: "POST",
                    data: {
                        id: id,
                        _token: _token
                    },
                    success: function(data) {
                        // console.log(data);
                        $('#store_or_update_form #update_id').val(data.id);
                        $('#store_or_update_form #name').val(data.name);

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
                let url = "{{ route('category.delete') }}";
                let row = table.row($(this).parent('tr'));
                 delete_data(id, url, table, row, name);
                //alert(name);
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
                    let url = "{{ route('category.bulk_delete') }}"
                    bulk_action_delete(url, id, rows, table);
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
                            url: "{{ route('category.status') }}",
                            type: 'POST',
                            data: {
                                id: id,
                                status : status,
                                _token: _token
                            },
                            dataType: "JSON",
                        }).done(function(res) {
                            if (res.status == 'success') {
                                Swal.fire("Status", res.message, "success");
                                table.ajax.reload();
                            }
                        }).fail(function() {
                            Swal.fire("Oops..!", "something went wrong", "error");
                        });
                    }
                })
            })

        });

    </script>
@endpush
