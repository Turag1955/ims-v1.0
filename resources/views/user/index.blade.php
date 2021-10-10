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
                    @if (permission('user-add'))
                        <div class="dt-entry__heading">
                            <button onclick="userShowModal('User Add','Save')" class="btn btn-primary btn-sm"
                                type="button"><i class="fas fa-plus-square"></i> Add User
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
                                <div class="form-group col-3 ">
                                    <label for="role_id">Role</label>
                                    <select name="role_id" id="role_id" class="selectpicker">
                                        <option value="">Slect Please</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-3 ">
                                    <label for="name">Name</label>
                                    <input class="form-control form-control-sm" type="text" name="name" id="name"
                                        placeholder="Name">
                                </div>
                                <div class="form-group col-3 ">
                                    <label for="email">Email</label>
                                    <input class="form-control form-control-sm" type="text" name="email" id="email"
                                        placeholder="Email">
                                </div>
                                <div class="form-group col-3 ">
                                    <label for="mobile_no">Mobile No</label>
                                    <input class="form-control form-control-sm" type="text" name="mobile_no" id="mobile_no"
                                        placeholder="Mobile No">
                                </div>
                                <div class="form-group col-3 ">
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="gender" class="selectpicker">
                                        <option value="">Slect Please</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                    </select>
                                </div>
                                <div class="form-group col-3 ">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="selectpicker">
                                        <option value="">Slect Please</option>
                                        <option value="1">Active</option>
                                        <option value="0">Deactive</option>
                                    </select>
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
                                    @if (permission('user-bulk-delete'))
                                        <th>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="select_all"
                                                    id="select_all" onchange="check_select_all()">
                                                <label class="form-check-label" for="select_checkbox"></label>
                                            </div>
                                        </th>
                                    @endif

                                    <th width="10%">Sl</th>
                                    <th width="15%">Avatar</th>
                                    <th width="15%">Role</th>
                                    <th width="10%">name</th>
                                    <th width="10%">email</th>
                                    <th width="10%">Mobile No</th>
                                    <th width="10%">Gender</th>
                                    <th width="10%">Status</th>
                                    <th width="5%">Action</th>
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
    @include('user.modal')
    @include('user.userViewModal')

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
                    "url": "{{ url('user/data-table') }}",
                    "type": "POST",
                    "data": function(data) {
                        data.role_id = $('#form-fillter #role_id').val();
                        data.name = $('#form-fillter #name').val();
                        data.mobile_no = $('#form-fillter #mobile_no').val();
                        data.gender = $('#form-fillter #gender').val();
                        data.status = $('#form-fillter #status').val();
                        data.email = $('#form-fillter #email').val();
                        data._token = _token;
                    }
                },
                //columnDefs use for which columns not sorting 
                "columnDefs": [{
                    @if (permission('user-bulk-delete'))
                        "targets": [0, 2, 9],
                    @else
                        "targets": [1, 8],
                    @endif "orderable": false
                }],
                "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'<'float-right'B>>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'<'float-right'p>>>",
                "buttons": [
                    @if (permission('user-report'))
                    
                    
                    
                        {
                        "extend": 'colvis',
                        "className": 'btn btn-primary btn-sm text-white',
                        "text": 'Column',
                        },
                        {
                        "extend": 'csv',
                        "className": 'btn btn-primary btn-sm text-white',
                        "title": "User List",
                        "filename": 'user-list',
                        "exportOptions": {
                        columns: function(index, data, node) {
                        return table.column(index).visible();
                        }
                        }
                        },
                        {
                        "extend": 'print',
                        "title": "User List",
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
                        "title": "User List",
                        "className": 'btn btn-primary btn-sm text-white',
                        "filename": 'user-list',
                        "orientaion": 'landscape',
                        "pageSize": 'A4', //a3,a4,a5,a6,legal,letter
                        "exportOptions": {
                        columns: [1, 2, 3]
                        }
                        },
                        {
                        "extend": 'excel',
                        "title": "User List",
                        "className": 'btn btn-primary btn-sm text-white',
                        "filename": 'User-list',
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

            $('#btn_fillter').click(function() {
                table.ajax.reload();
                $('#form-fillter')[0].reset();
            });
            $('#btn_reset').click(function() {
                $('#form-fillter')[0].reset();
                table.ajax.reload();
            });
            @if (permission('user-bulk-delete'))
                $('.dt-buttons').append(
                '<button type="button" class="btn btn-danger btn-sm" id="bulk_action_delete">Delete</button>');
            @endif


            $(document).on('click', '.save_btn', function() {
                let storeData = document.getElementById('store_or_update_form');
                let formData = new FormData(storeData);
                let url = "{{ route('user.store.or.update') }}";
                let id = $('#update_id').val();
                let method;
                if (id != '') {
                    method = 'update';
                } else {
                    method = 'add';
                }
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    dataType: "JSON",
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(data) {
                        $('#store_or_update_form').find('.is-invalid').removeClass(
                            'is-invalid');
                        $('#store_or_update_form').find('.error').remove();

                        if (data.status == false) {
                            $.each(data.errors, function(key, value) {
                                $('#store_or_update_form input #' + key).addClass('is-invalid');
                                $('#store_or_update_form select #' + key).parent() .addClass('is-invalid');
                                if (key == 'password' || key == 'confirm_password') {
                                    $('#store_or_update_form #' + key).parents('form-group').append('<span class="error text-danger">' + value + '</span>');
                                } else {
                                    $('#store_or_update_form #' + key).parent().append( '<span class="error text-danger">' + value + '</span>');
                                }


                            });
                        } else {

                            if (data.status == 'success') {

                                if (method == 'update') {
                                    table.ajax.reload(null, false);
                                    $('#store_or_update_form #update_id').val('');
                                } else {
                                    table.ajax.reload();
                                }
                                notification('success', data.message)
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
            })
            $(document).on('click', '.user_edit', function() {
                $('#store_or_update_form').find('.is-invalid').removeClass('is-invalid');
                $('#store_or_update_form').find('.error').remove()
                let id = $(this).data('id');
                $.ajax({
                    url: "{{ route('user.edit') }}",
                    type: "post",
                    data: {
                        id: id,
                        _token: _token
                    },
                    success: function(data) {
                        $('#store_or_update_form #update_id').val(data.data.id);
                        $('#store_or_update_form #name').val(data.data.name);
                        $('#store_or_update_form #role_id').val(data.data.role_id).trigger(
                            'change');
                        $('#store_or_update_form #email').val(data.data.email);
                        $('#store_or_update_form #mobile_no').val(data.data.mobile_no);
                        $('#store_or_update_form #password').val(data.data.password);
                        $('#store_or_update_form #confirm_password').val(data.data.password);
                        $('#store_or_update_form #gender').val(data.data.gender).trigger(
                            'change');

                        $('#store_or_update_modal').modal({
                            keyboard: true,
                            backdrop: 'static'
                        });
                        $('#store_or_update_modal .modal-title').html(
                            '<i class="fas fa-edit"></i> <span> Edit ' + data.data
                            .name + '</span>');
                        $('#store_or_update_modal .save_btn').text('Update');
                        $('#store_or_update_modal .modal-header').addClass('bg-primary');
                    }
                });
            });
            $(document).on('click', '.user_show', function() {

                let id = $(this).data('id');
                $.ajax({
                    url: "{{ route('user.show') }}",
                    type: "post",
                    data: {
                        id: id,
                        _token: _token
                    },
                    success: function(data) {
                        $('.user_details').html();
                        $('.user_details').html(data);

                        $('#showModal').modal({
                            keyboard: true,
                            backdrop: 'static'
                        });
                        $('#showModal .modal-title').html(
                            '<i class="fas fa-eye"></i> <span>User Details</span>');
                        $('#showModal .modal-header').addClass('bg-primary');
                    }
                });
            })

            $(document).on('click', '.user_delete', function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let url = "{{ route('user.delete') }}";
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
                    let url = "{{ route('user.bulk.delete') }}"
                    bulk_action_delete(url, id, rows, table);
                }

            });

            $(document).on('click', '.change_status', function() {
                let status = $(this).data('status');
                let id = $(this).data('id');

                $.ajax({
                    url: "{{ route('user.status') }}",
                    type: "post",
                    data: {
                        id: id,
                        status: status,
                        _token: _token
                    },
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status == 'success') {
                            table.ajax.reload();
                            notification('success', data.message);
                        } else {
                            notification('error', data.message);
                        }
                    }
                });
            });

            $('.toggle_password').click(function() {
                $(this).toggleClass('fa-eye fa-eye-slash');
                var input = $($(this).attr('toggle'));
                if (input.attr('type') == 'password') {
                    input.attr('type', 'text');
                } else {
                    input.attr('type', 'password');
                }
            });
        });

        function userShowModal(title, btnText) {
            $('#store_or_update_form')[0].reset();
            $('#store_or_update_form').find('.is-invalid').removeClass('is-invalid');
            $('#store_or_update_form').find('.error').remove();

            $('#store_or_update_form table tbody').find('tr:gt(0)').remove();
            $('#store_or_update_form .selectpicker').val('').trigger('change');
            $('#store_or_update_modal').modal({
                keyboard: true,
                backdrop: 'static'
            });
            $('#store_or_update_modal .modal-title').text(title);
            $('#store_or_update_modal .save_btn').text(btnText);
        }

    </script>
@endpush
