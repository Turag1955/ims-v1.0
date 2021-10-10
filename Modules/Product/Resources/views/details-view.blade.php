@if ($products->image != '')
    <div class="col-md-12 text-center ">
        <img class="img-fluid" style="width: 50%" src="{{ asset('storage/' . PRODUCT_IMAGE_PATH . $products->image) }}" alt="{{ $products->name }}" />
        <br><br>
    </div>
@endif



<div class="col-md-12">
    <div class="table-responsive">
        <table class="table table-borderless">
            <tr>
                <td><b>Product Name</b></td>
                <td><b>:</b></td>
                <td>{{ $products->name }}</td>
            </tr>
            <tr>
                <td><b>Barcode</b></td>
                <td><b>:</b></td>
                <td>{{ $products->code }}</td>
            </tr>
            <tr>
                <td><b>Barcode Symbology</b></td>
                <td><b>:</b></td>
                <td>{{ $products->barcode_symbology }}</td>
            </tr>
            <tr>
                <td><b>Brand</b></td>
                <td><b>:</b></td>
                <td>{{ $products->brand->title }}</td>
            </tr>
            <tr>
                <td><b>Category</b></td>
                <td><b>:</b></td>
                <td>{{ $products->category->name }} </td>
            </tr>
            <tr>
                <td><b>Tax</b></td>
                <td><b>:</b></td>
                <td>{{ $products->tax->name }} </td>
            </tr>
            <tr>
                <td><b>Tax</b></td>
                <td><b>:</b></td>
                <td>{{ TAX_METHOD[$products->tax_method] }} </td>
            </tr>
            <tr>
                <td><b>Unit</b></td>
                <td><b>:</b></td>
                <td>{{ $products->unit->unit_name }}</td>
            </tr>
            <tr>
                <td><b>Purchase Unit</b></td>
                <td><b>:</b></td>
                <td>{{ $products->purchase_unit->unit_name }}</td>
            </tr>
            <tr>
                <td><b>Sale Unit</b></td>
                <td><b>:</b></td>
                <td>{{ $products->sale_unit->unit_name }}</td>
            </tr>
            <tr>
                <td><b>Cost</b></td>
                <td><b>:</b></td>
                <td>{{ number_format($products->cost,2) }}</td>
            </tr>
            <tr>
                <td><b>Price</b></td>
                <td><b>:</b></td>
                <td>{{ number_format($products->price,2 )}}</td>
            </tr>
            <tr>
                <td><b>Quantity</b></td>
                <td><b>:</b></td>
                <td>{{ number_format($products->qty,2) }}</td>
            </tr>
            <tr>
                <td><b>Alert Quantity</b></td>
                <td><b>:</b></td>
                <td>{{ number_format($products->alert_qty,2) }}</td>
            </tr>
            <tr>
                <td><b>Status</b></td>
                <td><b>:</b></td>
                <td>{{ STATUS[$products->status] }}</td>
            </tr>
            <tr>
                <td><b>Created By</b></td>
                <td><b>:</b></td>
                <td>{{ $products->created_by }}</td>
            </tr>
            <tr>
                <td><b>Updated By</b></td>
                <td><b>:</b></td>
                <td>{{ $products->updated_by }}</td>
            </tr>

            <tr>
                <td><b>Joining Date</b></td>
                <td><b>:</b></td>
                <td>{{ date('d M,Y', strtotime($products->created_at)) }}</td>
            </tr>
            <tr>
                <td><b>Update Date</b></td>
                <td><b>:</b></td>
                <td>{{ date('d M,Y', strtotime($products->updated_at)) }}</td>
            </tr>
    </div>
</div>
</div>
