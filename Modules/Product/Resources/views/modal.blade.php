<div class="modal fade show" id="store_or_update_modal" tabindex="-1" role="dialog" aria-labelledby="model-1"
    aria-modal="true">
    <div class="modal-dialog modal-xl" role="document">

        <!-- Modal Content -->
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h3 class="modal-title" id="model-1"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <!-- /modal header -->
            <form id="store_or_update_form" method="POST">
                @csrf
                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-9">
                         <div class="row">
                            <input type="hidden" name="update_id" id="update_id" value="">
                            <x-form.textbox type="text" col="col-md-6" label="Product Name" name="name" placeholder="Enter Name" />
                            <x-form.selectbox label="Barcode Symbology" name="barcode_symbology" class="selectpicker"    col="col-md-6">
                                @foreach(BARCODE_SYMBOLOGY as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach

                            </x-form.selectbox>
                            <div class="form-group col-md-6">
                                <label for="">Barcode</label>
                              <div class="input-group">
                                <input type="text" name="code" id="code" class="form-control" placeholder="Barcode">
                                <div class="input-group-prepend" style="cursor:pointer">
                                    <span class="input-group-text" id="generate_barcode">
                                        <i class="fas fa-retweet text-primary"></i>
                                    </span>
                                </div>
                              </div>
                              <span class="ab"></span>
                            </div>
                            <x-form.selectbox label="Category" name="category_id" class="selectpicker" col="col-md-6">
                                @if(!$categories->isEmpty())
                                    @foreach($categories as $categorie)
                                        <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                                    @endforeach
                                @endif
                            </x-form.selectbox>

                            <x-form.selectbox label="Brand" name="brand_id" class="selectpicker" col="col-md-6">
                                @if(!$brands->isEmpty())
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                                    @endforeach
                                @endif
                            </x-form.selectbox>
                            <x-form.selectbox label="Unit" name="unit_id" class="selectpicker" col="col-md-6" onchange="populate_unit(this.value)">
                                @if(!$units->isEmpty())
                                    @foreach($units as $unit)
                                    @if ($unit->base_unit == null)
                                    <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                                        
                                    @endif
                                    @endforeach
                                @endif
                            </x-form.selectbox>
                            <div class="form-group col-md-6">
                                <label for="">Purchase Unit</label>
                                <select name="purchase_unit_id" id="purchase_unit_id" class="form-control selectpicker">
                                 <option value="">Select Please</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Sale Unit</label>
                                <select name="sale_unit_id" id="sale_unit_id" class="form-control selectpicker">
                                 <option value="">Select Please</option>
                                  
                                </select>
                            </div>
                           
                               
 
                            <x-form.textbox type="text" col="col-md-6" label="Cost" name="cost" placeholder="0.00" />
                            <x-form.textbox type="text" col="col-md-6" label="Price" name="price" placeholder="0.00" />

                            <x-form.textbox type="text" col="col-md-6" label="Quantity" name="qty" placeholder="0.00" />
                            <x-form.textbox type="text" col="col-md-6" label="ALert Quantity" name="alert_qty" placeholder="0.00" />
                            
                            <div class="form-group col-md-6">
                                <label for="">Tax</label>
                                <select  name="tax_id" id="tax_id" class="form-control selectpicker" data-live-search="true" data-live-search-placeholder="search">
                                    <option value="">No Tax</option>
                                    @if(!$taxes->isEmpty())
                                        @foreach($taxes as $tax)
                                            <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            
                            <x-form.selectbox label="Tax Method" name="tax_method" class="selectpicker" col="col-md-6">
                             
                                @foreach(TAX_METHOD as $key => $value)
                                    <option value="{{ $key }}" {{ $key == 1 ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach

                            </x-form.selectbox>

                            <x-form.textarea label="Description" name="description"  col="col-md-6"/>
                         </div>
                            
                        </div>
                        <div class="col-md-3">
                            <div class="form-group col-md-12">
                                <label for="">Image</label>
                                <div class="col-md-12 px-0 text-center">
                                    <div id="image">

                                    </div>
                                </div>
                                <input type="hidden" name="old_image" id="old_image" value="">
                            </div>
                        </div>


                    </div>
                </div>
                <!-- /modal body -->

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-sm save_btn"></button>
                </div>
                <!-- /modal footer -->
            </form>
        </div>
        <!-- /modal content -->

    </div>
</div>
