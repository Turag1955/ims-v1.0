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
                        <div class="row">
                            <div class="col-12">
                                <h2 class="text-center text-secondary">{{ $result['role']->role_name }} - Details</h2>
                            </div>
                            <div class="col-12">
                                <ul class="text-left" style="list-style: none">
                                    @if (!$data['module_list']->isEmpty())
                                        @foreach ($data['module_list'] as $module)
                                            @if ($module->submenu->isEmpty())
                                                <li>
                                                    @if (collect($result['module_role'])->contains($module->id))
                                                        <i class="fas fa-check-circle text-success"></i>
                                                    @else
                                                        <i class="fas fa-times-circle text-danger"></i>
                                                    @endif
                                                    {{ $module->type == 1 ? $module->devider_name : $module->module_name }}
                                                    <ul style="list-style: none">
                                                        @if (!$module->permission->isEmpty())
                                                            @foreach ($module->permission as $permission)
                                                                <li>
                                                                    @if (collect($result['permission_role'])->contains($module->id))
                                                                        <i class="fas fa-check-circle text-success"></i>
                                                                    @else
                                                                        <i class="fas fa-times-circle text-danger"></i>
                                                                    @endif
                                                                    {{ $permission->name }}
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                </li>
                                            @else
                                                <li>
                                                    @if (collect($result['module_role'])->contains($module->id))
                                                        <i class="fas fa-check-circle text-success"></i>
                                                    @else
                                                        <i class="fas fa-times-circle text-danger"></i>
                                                    @endif
                                                    {{ $module->type == 1 ? $module->devider_name : $module->module_name }}
                                                    <ul style="list-style: none">
                                                        @foreach ($module->submenu as $submenu)
                                                            <li>
                                                                @if (collect($result['module_role'])->contains($submenu->id))
                                                                    <i class="fas fa-check-circle text-success"></i>
                                                                @else
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                @endif
                                                                {{ $submenu->module_name }}
                                                                @if (!$submenu->permission->isEmpty())
                                                                    <ul style="list-style: none">
                                                                        @foreach ($submenu->permission as $permission)
                                                                            <li>
                                                                                @if (collect($result['permission_role'])->contains($permission->id))
                                                                                <i class="fas fa-check-circle text-success"></i>
                                                                            @else
                                                                                <i class="fas fa-times-circle text-danger"></i>
                                                                            @endif
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
                                    @endif
                                </ul>
                            </div>
                        </div>
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

            // $('input[type=checkbox']).click(function(){
            //     $(this).next().find('input[type=checkbox]').prop('checked',this.checked);
            //     $(this).parents('ul').prev('input[type=checkbox]').prop('checked',function(){
            //         return $(this).next().find(':checked').length;
            //     })
            // });
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
                } else {
                    notification('error', 'please select one checkbox');
                }
            });
        });

    </script>
@endpush
