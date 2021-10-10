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
                    <div class="dt-entry__heading">
                        <a href="{{ route('role') }}" class="btn btn-danger btn-sm" type="button"><i
                                class="fas fa-arrow-circle-left"></i> Back
                        </a>
                    </div>
                    <!-- /entry heading -->

                </div>
                <!-- /entry header -->

                <!-- Card -->
                <div class="dt-card">

                    <!-- Card Body -->
                    <div class="dt-card__body">

                        <form id="RoleForm">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="update_id" id="update_id" value="{{ $result['role']->id }}">
                                <x-form.textbox label="Role Name" col="col-12" name="role_name" placeholder="Role Name"
                                    value="{{ $result['role']->role_name }}" />
                                <div class="col-12">
                                    @if (!$data['module_list']->isEmpty())
                                        <ul id="permission">
                                            @foreach ($data['module_list'] as $module)
                                                @if ($module->submenu->isEmpty())
                                                    <li>
                                                        <input type="checkbox" name="module[]" id="module"
                                                            value="{{ $module->id }}" @if (collect($result['module_role'])->contains($module->id)) {{ 'checked' }} @endif>
                                                        {{ $module->type == 1 ? $module->devider_name : $module->module_name }}
                                                        @if (!$module->permission->isEmpty())
                                                            <ul>
                                                                @foreach ($module->permission as $permission)
                                                                    <li>
                                                                        <input type="checkbox" name="permission[]"
                                                                            id="permission" value="{{ $permission->id }}"
                                                                            @if (collect($result['permission_role'])->contains($permission->id)) {{ 'checked' }} @endif>
                                                                        {{ $permission->name }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @else
                                                    <li>
                                                        <input type="checkbox" name="module[]" id="module"
                                                            value="{{ $module->id }}" @if (collect($result['module_role'])->contains($module->id)) {{ 'checked' }} @endif>
                                                        {{ $module->type == 1 ? $module->devider_name : $module->module_name }}
                                                        <ul>
                                                            @foreach ($module->submenu as $submenu)
                                                                <li>
                                                                    <input type="checkbox" name="module[]" id="module"
                                                                        value="{{ $submenu->id }}" @if (collect($result['module_role'])->contains($module->id)) {{ 'checked' }} @endif>
                                                                    {{ $submenu->module_name }}
                                                                    @if (!$submenu->permission->isEmpty())
                                                                        <ul>
                                                                            @foreach ($submenu->permission as $permission)
                                                                                <li>
                                                                                    <input type="checkbox"
                                                                                        name="permission[]" id="permission"
                                                                                        value="{{ $permission->id }}" @if (collect($result['permission_role'])->contains($permission->id)) {{ 'checked' }} @endif>
                                                                                    {{ $permission->name }}
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </li>

                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <div class="col-12 form-group">
                                    <a href="{{ route('role') }}" type="reset" class="btn btn-danger btn-sm"> <i
                                            class="fas fa-redo"></i>
                                        Cencel</a>
                                    <button type="button" class="btn btn-primary btn-sm" id="role_save_btn"> <i
                                            class="fas fa-plus-square"></i> Update</button>

                                </div>
                            </div>
                        </form>


                    </div>


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
    <script src="js/tree.js"></script>
    <script>
        $(document).ready(function() {
            $('input[type=checkbox]').click(function() {
                $(this).next().find('input[type=checkbox]').prop('checked', this.checked);
                $(this).parents('ul').prev('input[type=checkbox]').prop('checked', function() {
                    return $(this).next().find(':checked').length;
                })
            });
            $('#permission').treed();

            $(document).on('click', '#role_save_btn', function() {
                let form = document.getElementById('RoleForm');
                let formData = new FormData(form);
                if ($('#module:checked').length >= 1) {
                    $.ajax({
                        url: "{{ route('role.store.or.update') }}",
                        type: "POST",
                        data: formData,
                        dataType: "JSON",
                        contentType: false,
                        processData: false,
                        cache: false,
                        beforeSend: function() {
                            $('#role_save_btn').addClass(
                                'kt-spinner kt-spinner--md kt-spinner--light');
                        },
                        complete: function() {
                            $('#role_save_btn').removeClass(
                                'kt-spinner kt-spinner--md kt-spinner--light');
                        },
                        success: function(data) {
                            $('#RoleForm').find('.is-invalid').removeClass(
                                'is-invalid');
                            // $('#store_or_update_form').find('.error').val('');

                            $('#RoleForm').find('.error').remove();

                            if (data.status == false) {
                                $.each(data.errors, function(key, value) {

                                    $('#RoleForm input#' + key).parent()
                                        .addClass('is-invalid');
                                    $('#RoleForm #' + key).parent().append(
                                        '<small class="error text-danger">' +
                                        value +
                                        '</small>');

                                });
                            } else {
                                notification(data.status, data.message);
                                if (data.status == 'success') {
                                    window.location.replace("{{ route('role') }} ");


                                }
                            }
                        },
                        error: function(xhr, ajaxoption, thrownError) {
                            console.log('error');
                            console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr
                                .responseText);
                        }
                    });
                }else{
                    notification('error','please select one checkbox');
                }
                


            });

           
        });

    </script>
@endpush
