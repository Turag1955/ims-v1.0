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
                        <x-form.textbox type="text" col="col-12" label="Name" name="name" required="required"
                            placeholder="Enter Name"/>
                        <x-form.selectbox col="col-12" label="Role" name="role_id" required="required" class="selectpicker">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                            @endforeach
                        </x-form.selectbox>
                        <x-form.textbox type="text" col="col-12" label="Email" name="email" required="required" placeholder="Enter Email" />
                        <x-form.textbox type="text" col="col-12" label="Mobile No." name="mobile_no" required="required" placeholder="Enter Mobile No." />
                        <div class="form-group col-12">
                            <label for="password">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="password" placeholder="password">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-warning" id="generate_password" data-toggle="tooltip" data-placement="top" data-original-title="Generate Password">
                                        <i class="fas fa-lock text-white"  style="cursor: pointer;"></i>
                                    </span>
                                </div>
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary">
                                        <i class="fas fa-eye toggle_password text-white" toggle="#password" style="cursor: pointer;"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-12">
                            <label for="confirm_password">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm password">
                                
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary">
                                        <i class="fas fa-eye toggle_password text-white" toggle="#confirm_password" style="cursor: pointer;"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <x-form.selectbox col="col-12" label="Gender" name="gender" required="required" class="selectpicker">
                            @foreach (GENDER as $key=>$val)
                                <option value="{{ $key }}">{{$val}}</option>
                            @endforeach
                        </x-form.selectbox>
                        <div class="form-group col-12">
                            <label for="avatar">Avatar</label>
                            <input type="file" class="dropify" name="avatar" id="avatar">
                        </div>
                    </div>
                </div>
                <!-- /modal body -->

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-sm save_btn kt-spinner"></button>
                </div>
                <!-- /modal footer -->
            </form>
        </div>
        <!-- /modal content -->

    </div>
</div>
