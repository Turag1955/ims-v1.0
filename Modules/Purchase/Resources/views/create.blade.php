@extends('layouts.app')
@section('title', $page_title)



@section('content')
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
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
                        <a href="{{ route('purchase') }}" class="btn btn-danger btn-sm" type="button"><i
                                class="fas fa-arrow-left"></i> Back
                        </a>
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
                        <form id="purchase_form" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <x-form.selectbox label="Warehouse" name="warehouse_id" class="selectpicker" col="col-md-6">
                                    @if (!$warehouses->isEmpty())
                                        @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                        @endforeach
                                    @endif
                                </x-form.selectbox>
                                <x-form.selectbox label="Supplier" name="supplier_id" class="selectpicker" col="col-md-6">
                                    @if (!$suppliers->isEmpty())
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}
                                                {{ $supplier->company_name ? $supplier->company_name : '' }}
                                            </option>
                                        @endforeach
                                    @endif
                                </x-form.selectbox>
                                <x-form.selectbox label="Status" name="purchase_status" class="selectpicker" col="col-md-6">
                                    @foreach (PURCHASE_STATUS as $key => $value)
                                        <option {{ $key == 1 ? 'selected' : '' }} value="{{ $key }}">
                                            {{ $value }}</option>
                                    @endforeach
                                </x-form.selectbox>
                                <div class="form-group col-md-6 ">
                                    <label for="document">Attachment Document</label>
                                    <input class="form-control form-control-sm" type="file" name="document" id="document">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="product_code_name">Select Product</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="product_code_name"
                                            id="product_code_name" placeholder="Type barcode or name and select product">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead class="bg-primary">
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th class="text-center">Unit</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center d-none recevied_product_qty">Received</th>
                                            <th class="text-right">Net Unit Cost</th>
                                            <th class="text-right">Discount</th>
                                            <th class="text-right">Tax</th>
                                            <th class="text-right">Subtotal</th>
                                            <th></th>
                                        </thead>
                                        <tbody> </tbody>
                                        <tfoot class="bg-secondary">
                                            <th colspan="3">Total</th>
                                            <th id="total_qty" class="text-center">0</th>
                                            <th class="d-none recevied_product_qty text-center">0.00</th>
                                            <th></th>
                                            <th id="total_discount" class="text-right">0.00</th>
                                            <th id="total_tax" class="text-right">0.00</th>
                                            <th id="total" class="text-right">0.00</th>
                                            <th></th>
                                        </tfoot>
                                    </table>
                                </div>
                                <x-form.selectbox label="Order Tax" name="order_tax" class="selectpicker" col="col-md-4">
                                    @if (!$suppliers->isEmpty())
                                        @foreach ($taxes as $taxe)
                                            <option value="{{ $taxe->id }}">{{ $taxe->rate }} </option>
                                        @endforeach
                                    @endif
                                </x-form.selectbox>
                                <div class="form-group col-md-4">
                                    <label for="order_discount">Order Discount</label>
                                    <input class="form-control form-control-sm" type="number" name="order_discount"
                                        id="order_discount">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="shipping_cost">Shipping Cost</label>
                                    <input class="form-control form-control-sm" type="number" name="shipping_cost"
                                        id="shipping_cost">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="note">Note</label>
                                    <textarea class="form-control form-control-sm" name="note" id="note" cols="30"
                                        rows="3"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead class="bg-primary">
                                            <th><strong>Item</strong><span class="float-right" id="item">00.0</span></th>
                                            <th><strong>Total</strong><span class="float-right" id="subtotal">00.0</span>
                                            </th>
                                            <th><strong>Order Tax</strong><span class="float-right"
                                                    id="order_tax">00.0</span></th>
                                            <th><strong>Order Discount</strong><span class="float-right"
                                                    id="order_discount">00.0</span></th>
                                            <th><strong>Shipping Cost </strong><span class="float-right"
                                                    id="shipping_cost">00.0</span></th>
                                            <th><strong>Grand Total </strong><span class="float-right"
                                                    id="grand_total">00.0</span></th>
                                        </thead>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <input type="hidden" name="total_qty">
                                    <input type="hidden" name="total_discount">
                                    <input type="hidden" name="total_tax">
                                    <input type="hidden" name="total_cost">
                                    <input type="hidden" name="item">
                                    <input type="hidden" name="order_tax">
                                    <input type="hidden" name="group_total">
                                </div>
                                <div class="form-group col-md-12 text-center">
                                    <button type="button" class="btn btn-primary btn-sm" id="save_btn">Save</button>
                                    <button type="reset" class="btn btn-danger btn-sm" id="reset_btn">Reset</button>
                                </div>
                            </div>
                        </form>



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
    <script src="js/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            $('#product_code_name').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ url('product-autocomplete-search') }}",
                        type: "POST",
                        data: {
                            _token: _token,
                            search: request.term
                        },
                         dataType: "JSON",
                        success: function(data) {
                            response(data);
                            //console.log(data);
                        }
                    });
                },
                // minLength: 1,
                // response: function(event, ui) {
                //     if (ui.content.length == 1) {
                //         var data = ui.content[0].value;
                //         $(this).autocomplete('close');
                //     }
                // },
                select: function(event, ui) {
                     //var data = ui.item.value;
                    $('#product_code_name').val(ui.item.label);

                    $('#product_code_name_id').val(ui.item.value); 

                   return false;

                }

            })..data('ui-autocomplete')._renderItem = function(ul, item) {
                return $('<li>')
                    .data('ui-autocomplete-item', item)
                    .append(item.label)
                    .appendTo(ul);
            };
        });

    </script>
@endpush
