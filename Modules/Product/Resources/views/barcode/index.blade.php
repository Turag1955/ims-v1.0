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
                            <a href="{{ route('product') }}" class="btn btn-primary btn-sm" type="button">Manage
                                Product</a>
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
                        <form id="barcode-form">
                            
                            <div class="row">
                                <x-form.selectbox label="Product" col="col-md-3" name="product" class="selectpicker">
                                    @if (!empty($products))
                                        @foreach ($products as $product)
                                            <option  data-barcode="{{ $product->barcode_symbology }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}" value="{{ $product->code }}">
                                                {{ $product->name . '.' . $product->code }}</option>
                                        @endforeach
                                    @endif
                                </x-form.selectbox>
                                <div class="form-group col-md-3 ">
                                    <label for="barcode_qty">Number Of Barcode</label>
                                    <input class="form-control form-control-sm" type="text" name="barcode_qty"
                                        id="barcode_qty" placeholder="Number Of Barcode">
                                </div>
                                <div class="form-group col-md-3 ">
                                    <label for="qty_row">Quantity Each Row</label>
                                    <input class="form-control form-control-sm" type="text" name="qty_row" id="qty_row"
                                        placeholder="Quantity Each Row">
                                </div>
                                <div class="form-group col-md-3 ">
                                    <label for="">Print With</label>
                                    <div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" id="product_name" name="product_name"
                                                class="custom-control-input">
                                            <label for="product_name" class="custom-control-label">Product Name</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="price" name="price">
                                            <label for="price" class="custom-control-label">Price</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">Barcode Size</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="width" name="width" placeholder="width">
                                        <input type="text" class="form-control" id="height" name="height"
                                            placeholder="height">
                                        <select name="unit" id="unit" class="form-control">
                                            <option value="">Select Please</option>
                                            <option value="px">Px</option>
                                            <option value="in">In</option>
                                            <option value="cm">Cm</option>
                                            <option value="mm">Mm</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 mt-5">
                                    <button id="generate_barcode" type="button" class="btn btn-sm btn-warning text-light"
                                        data-toggle="tooltip" data-placement="top" data-original-title="Generate Barcode"><i
                                            class="fas fa-barcode"></i> Generate Barcode</button>


                                </div>
                            </div>
                        </form>
                        <div class="row" id="barcode-section">

                        </div>


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

@endsection
@push('script')
    <script src="js/jquery.printArea.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '#generate_barcode', function() {
                let name;
                let price;
                let barcode     = $('#product option:selected').val();
                let product     = $('#product option:selected').val();
                let barcode_qty = $('#barcode_qty').val();
                let qty_row     = $('#qty_row').val();
                let width       = $('#width').val();
                let height      = $('#height').val();
                let unit        = $('#unit option:selected').val();
                
                if( $('#product_name').prop('checked') == true){
                    name = $('#product option:selected').data('name');
                }
                if($('#price').prop('checked') == true){
                    price = $('#product option:selected').data('price');
                }
                $.ajax({
                    url: " {{ route('generate.barcode') }}",
                    type: "POST",
                    data: {
                        product:product,name:name,price:price,barcode_qty:barcode_qty,qty_row:qty_row,width:width,height:height,unit:unit,barcode:barcode,_token:_token
                    },
                    beforeSend: function() {
                        $('#generate_barcode').addClass(
                            'kt-spinner kt-spinner--md kt-spinner--light');
                    },
                    complete: function() {
                        $('#generate_barcode').removeClass(
                            'kt-spinner kt-spinner--md kt-spinner--light');
                    },
                    success: function(data) {
                        $('#barcode-form').find('.is-invalid').removeClass(
                            'is-invalid');
                        $('#barcode-form').find('.error').remove();

                        if (data.status == false) {
                            $.each(data.errors, function(key, value) {
                                $('#barcode-form input #' + key).parent().addClass('is-invalid');
                                $('#barcode-form select #' + key).parent().addClass('is-invalid');
                                $('#barcode-form #' + key).parent().append('<div class="error text-danger">'+ value +'</div>');
                            });
                        } else {
                             $('#barcode-section').html('');
                             $('#barcode-section').html(data);
                        }
                    },
                    error: function(xhr, ajaxoption, thrownError) {
                        console.log('error');
                        console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr
                            .responseText);
                    }

                });
            });
        $(document).on('click','#print-barcode',function(){
            var mode = 'iframe';//popup
            var close = mode == 'popup';
            var options = {
                mode : mode,
                popClose : close
            }
            $('#printableArea').printArea(options);
        })
             

        });

    </script>
@endpush
