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
                    @if (permission('product-access'))
                        <div class="dt-entry__heading">
                            <button class="btn btn-primary btn-sm" type="button"
                                onclick="product_modal('Add New Product','Save')"><i class="fas fa-plus-square"></i> Add New
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
                                <div class="form-group col-md-3 ">
                                    <label for="name">Product Name</label>
                                    <input class="form-control form-control-sm" type="text" name="name" id="name"
                                        placeholder="Name">
                                </div>
                                <div class="form-group col-md-3 ">
                                    <label for="code">Barcode</label>
                                    <input class="form-control form-control-sm" type="text" name="code" id="code"
                                        placeholder="Code">
                                </div>
                                <x-form.selectbox label="Category" name="category_id" class="selectpicker" col="col-md-3">
                                    @if (!$categories->isEmpty())
                                        @foreach ($categories as $categorie)
                                            <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                                        @endforeach
                                    @endif
                                </x-form.selectbox>

                                <x-form.selectbox label="Brand" name="brand_id" class="selectpicker" col="col-md-3">
                                    @if (!$brands->isEmpty())
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                                        @endforeach
                                    @endif
                                </x-form.selectbox>
                                <div class="col-md-12  pt-24 text-right">
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
                                    @if (permission('product-bulk-delete'))
                                        <th>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="select_all"
                                                    id="select_all" onchange="check_select_all()">
                                                <label class="form-check-label" for="select_checkbox"></label>
                                            </div>
                                        </th>
                                    @endif
                                    <th>Sl</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Brand</th>
                                    <th>Category</th>
                                    <th>Unit</th>
                                    <th>Cost</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Alert Qty</th>
                                    <th>Tax</th>
                                    <th>Tax Method</th>
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
    @include('product::modal');
    @include('product::product-view');
@endsection
@push('script')
    <script src="js/spartan-multi-image-picker-min.js"></script>
    <script>
        var table;
        $(document).ready(function() {
            table = $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "responsive": true,
                "bInfo": true,
                "bFilter": false,
                "lengthMenu": [
                    [5, 10, 15, 25, 50, 100, 1000, 10000, -1],
                    [5, 10, 15, 25, 50, 100, 1000, 10000, "All"],
                ],
                "language": {
                    processing: '<i class="fas fa-spinner fa-spin fa-spin fa-3x fa-fw text-primary"></i>',
                    emptyTable: '<strong class="text-danger"> No Data Found</strong>',
                    infoEmpty: '',
                    zeroRecords: '<strong class="text-danger"> No Data Found</strong>',
                },
                "ajax": {
                    "url": "{{ route('product.data.table') }}",
                    "type": "POST",
                    "data": function(data) {
                        data.name       = $('#form-fillter #name').val();
                        data.code        = $('#form-fillter #code').val();
                        data.brand_id    = $('#form-fillter #brand_id').val();
                        data.category_id = $('#form-fillter #category_id').val();
                        data._token      = _token;
                    }
                },
                "columnDefs": [{
                    @if (permission("product-bulk-delete"))
                    "targets": [0, 2,15],
                    "orderable": false
                    @else
                    "targets": [1,14],
                    "orderable": false
                    @endif
                }],

                "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'<'float-right'B>>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'<'float-right'p>>>",

                "buttons": [
                    @if (permission('product-report'))
                    {
                        "extend": 'colvis',
                        "className": 'btn btn-primary btn-sm text-white',
                        "text": 'Column',
                    },
                    {
                        "extend": 'csv',
                        "className": 'btn btn-primary btn-sm text-white',
                        "title": "menu List",
                        "filename": 'menu-list',
                        "exportOptions": {
                            columns: function(index, data, node) {
                                return table.column(index).visible();
                            }
                        }
                    },

                    {
                        "extend": 'print',
                        "title": "product List",
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
                        "title": "product List",
                        "className": 'btn btn-primary btn-sm text-white',
                        "filename": 'product-list',
                        "orientaion": 'landscape',
                        "pageSize": 'A4', //a3,a4,a5,a6,legal,letter
                        "exportOptions": {
                            columns: [1, 2, 3]
                        }
                    },
                    {
                        "extend": 'excel',
                        "title": "product List",
                        "className": 'btn btn-primary btn-sm text-white',
                        "filename": 'product-list',
                        "exportOptions": {
                            columns: function(index, data, node) {
                                return table.column(index).visible();
                            }
                        }
                    }
                    @endif
                ]
            });
            @if (permission('customer-group-bulk-delete'))
                $('.dt-buttons').append(
                '<button type="button" class="btn btn-danger btn-sm" id="bulk_action_delete">Delete</button>');
            @endif


            $('#btn_fillter').click(function() {
                table.ajax.reload();

            });
            $('#btn_reset').click(function() {
                $('#form-fillter')[0].reset();
                $('#form-fillter .selectpicker').selectpicker('refresh');
                table.ajax.reload();
            });
    
            $(document).on('click', '.save_btn', function() {
                let form = document.getElementById('store_or_update_form');
                let formDdata = new FormData(form);
                let update_id = $('#store_or_update_form #update_id').val();
                let method;
                if (update_id) {
                    method = 'update';
                } else {

                    method = 'add';
                }

                $.ajax({
                    url: " {{ route('product.store.update') }}",
                    type: "POST",
                    data: formDdata,
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
                        $('#store_or_update_form').find('.error').remove();

                        if (data.status == false) {
                            $.each(data.errors, function(key, value) {
                                $('#store_or_update_form input #' + key).parent().addClass('is-invalid');
                            
                                if(key == 'code'){
                                $('#store_or_update_form #' + key).parents('.form-group').append('<div class="error text-danger">'+ value +'</div>');
                                    
                                }else{
                                $('#store_or_update_form #' + key).parent().append('<div class="error text-danger">'+ value +'</div>');
                                    
                                }

                            });
                        } else {
                            if (method == 'update') {

                                $('#store_or_update_form #update_id').val('');
                                $('#store_or_update_form #old_image').val('');
                                 table.ajax.reload(null, false);
                            } else {
                                table.ajax.reload();
                            }
                            $('#store_or_update_modal').modal('hide');
                            notification(data.status, data.message);
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
                $.ajax({
                    url: "{{ route('product.edit') }}",
                    type: "POST",
                    data: {
                        id: id,
                        _token: _token
                    },

                    success: function(data) {
                       
                        $('#store_or_update_form #update_id').val(data.id);
                        $('#store_or_update_form #name').val(data.name);
                        $('#store_or_update_form #code').val(data.code);
                        $('#store_or_update_form #barcode_symbology').val(data.barcode_symbology);
                        $('#store_or_update_form #brand_id').val(data.brand_id);
                        $('#store_or_update_form #category_id').val(data.category_id);
                        $('#store_or_update_form #unit_id').val(data.unit_id);
                        
                        $('#store_or_update_form #cost').val(data.cost);
                        $('#store_or_update_form #price').val(data.price);
                        $('#store_or_update_form #qty').val(data.qty);
                        $('#store_or_update_form #alert_qty').val(data.alert_qty);
                        $('#store_or_update_form #tax_id').val(data.tax_id);
                        $('#store_or_update_form #tax_method').val(data.tax_method);
                        $('#store_or_update_form #description').val(data.description);
                        $('#store_or_update_form #old_image').val(data.image);
                        $('#store_or_update_form .selectpicker').selectpicker('refresh');
                        populate_unit(data.unit_id,data.purchase_unit_id,data.sale_unit_id)
                        
                        if (data.image) {
                            var image = "{{ asset('storage/' . PRODUCT_IMAGE_PATH) }}" + '/' + data.image;
                            $('#store_or_update_form #image img.spartan_image_placeholder').css('display', 'none');
                            $('#store_or_update_form #image .spartan_remove_row').css('display','none');
                            $('#store_or_update_form #image .img_').css('display', 'block');
                            $('#store_or_update_form #image .img_').attr('src', image);
                        } else {
                            $('#store_or_update_form #image img.spartan_image_placeholder').css('display', 'block');
                            $('#store_or_update_form #image .spartan_remove_row').css('display','none');
                            $('#store_or_update_form #image .img_').css('display', 'none');
                            $('#store_or_update_form #image .img_').attr('src', '');
                        }
                        $('#store_or_update_modal').modal({
                            keyboard: true,
                            backdrop: 'static'
                        });
                        $('#store_or_update_modal #model-1').text(data.name + ' product Updat');
                        $('#store_or_update_modal .save_btn').text('Update');

                    }

                });
            });

            $(document).on('click','.user_view',function(){
                let id = $(this).data('id');
                $.ajax({
                    url : "{{ route('product.show') }}",
                    type : "POST",
                    data : {id:id,_token:_token},
                    success : function(data){
                        $('.details').html('');
                        $('.details').html(data);

                        $('#showModal').modal({
                            keyboard: true,
                            backdrop: 'static'
                        });
                        $('#showModal #model-1').text('product View');
                    }
                });
            });

            $(document).on('click', '.user_delete', function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let row = table.row($(this).parent('tr'));
                let url = "{{ route('product.delete') }}";
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
                    let url = "{{ route('product.bulk.delete') }}"
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
                            url: "{{ route('product.status') }}",
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

            $('#image').spartanMultiImagePicker({
                fieldName: 'image',
                maxCount: 1,
                rowHieght: '150px',
                groupClassName: 'col-md-12 col-sm-12 col-xs-12',
                allowedExt: 'png|jpg|jpeg',
                dropFileLabel: "Drop Here",
                onExtentionErr: function(index, file) {
                    Swal.fire({
                        icon: 'error',
                        title: 'oops...',
                        text: 'only png jpeg jpg image formated allowed'
                    });
                }
            });

            $('input[name="image"]').prop('required', true);
            $('.remove_files').on('click', function() {
                $(this).parents('.col-md-6').remove();
            });
            
            $('#generate_barcode').click(function(){
                $.get('generate-code',function(data){
                    $('#store_or_update_form #code').val(data);
                });
            });

        });
         
          function populate_unit(unit_id,$purchase_unit_id = '',$sale_unit_id = '' ){
             $.ajax({
                 url:"{{ url('populate-unit') }}/"+unit_id,
                 type:"GET",
                 dataType:"JSON",
                 success:function(data){
                 console.log(data);
                 $('#purchase_unit_id').empty();
                 $('#sale_unit_id').empty();
                    $.each(data,function(key,value){
                        $('#purchase_unit_id').append('<option value="'+key+'">'+value+'</option>');
                        $('#sale_unit_id').append('<option value="'+key+'">'+value+'</option>');
                    });
                    $('.selectpicker').selectpicker('refresh');
                     
                     //this code for updat
                     if($purchase_unit_id){
                        $('#purchase_unit_id').val($purchase_unit_id);
                     }
                     if($sale_unit_id){
                        $('#sale_unit_id').val($sale_unit_id);
                         
                     }
                     $('.selectpicker').selectpicker('refresh');
                 }
             });
         }
        
        function product_modal(title, btnText) {
            $('#store_or_update_form')[0].reset();
            $('#store_or_update_form #update_id').val('');
            
            $('.selectpicker').selectpicker('refresh');
            $('#store_or_update_form').find('.is-invalid').removeClass('is-invalid');
            $('#store_or_update_form').find('.error').remove();

            $('#store_or_update_form #image img.spartan_image_placeholder').css('display', 'block');
            $('#store_or_update_form #image .spartan_remove_row').css('display', 'none');
            $('#store_or_update_form #image .img_').css('display', 'none');
            $('#store_or_update_form #image .img_').attr('src', '');

            $('#store_or_update_modal').modal({
                keyboard: true,
                backdrop: 'static',
            });

            $('#store_or_update_modal #model-1').text(title);
            $('#store_or_update_modal .save_btn').text(btnText);


        }

    </script>
@endpush
