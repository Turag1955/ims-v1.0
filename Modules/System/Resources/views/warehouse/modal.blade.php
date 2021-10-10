<div class="modal fade show" id="store_or_update_modal" tabindex="-1" role="dialog" aria-labelledby="model-1"
    aria-modal="true">
    <div class="modal-dialog" role="document">

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
                        <input type="hidden" id="update_id" value="" name="update_id">
                        <x-form.textbox type="text" col="col-md-12" label="Name" name="name" placeholder="Enter Name" />
                        <x-form.textbox type="text" col="col-md-12" label="Phone" name="phone"   placeholder="Enter Phone" />
                        <x-form.textbox type="email" col="col-md-12" label="Email" name="email" placeholder="Enter Email" />
                        <x-form.textarea type="textarea" col="col-md-12" label="Address" name="address" placeholder="Enter Address" />
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
