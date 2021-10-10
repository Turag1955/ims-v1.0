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
                    @if (permission('sitting-access'))
                        <div class="dt-entry__heading">
                            <button class="btn btn-primary btn-sm" type="button"
                                onclick="add_data_modal('Add New','Save')"><i class="fas fa-plus-square"></i> Add New
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


                        <div class="col-md-12 dt-masonry__item">

                            <!-- Card -->
                            <div class="dt-card">

                                <!-- Card Header -->
                                <div class="dt-card__header">

                                    <!-- Card Heading -->
                                    <div class="dt-card__heading">
                                        <h3 class="dt-card__title">Vertical Tabs</h3>
                                    </div>
                                    <!-- /card heading -->

                                </div>
                                <!-- /card header -->

                                <!-- Card Body -->
                                <div class="dt-card__body tabs-container tabs-vertical">

                                    <!-- Tab Navigation -->
                                    <ul class="nav nav-tabs flex-column" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#general_sitting" role="tab"
                                                aria-controls="general_sitting" aria-selected="true">General Sitting
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#mail_sitting" role="tab"
                                                aria-controls="mail_sitting" aria-selected="true">Mail Sitting
                                            </a>
                                        </li>

                                    </ul>
                                    <!-- /tab navigation -->

                                    <!-- Tab Content -->
                                    <div class="tab-content">

                                        <!-- Tab Pane -->
                                        <div id="general_sitting" class="tab-pane active">
                                            <div class="card-body">
                                                <form id="general" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <x-form.textbox type="text" col="col-md-8" label="Title"
                                                            name="title" required="required" placeholder="Title"
                                                            value="{{ config('sittings.title') }}" />
                                                        <x-form.textarea type="text" col="col-md-8" label="Address"
                                                            name="address" required="required" placeholder="Address"
                                                            value="{{ config('sittings.address') }}" />
                                                        <div class="col-md-8">
                                                            <div class="row">
                                                                <div class="col-md-6 form-group">
                                                                    <label for="logo">Logo</label>
                                                                    <div class="col-md-12 px-0 text-center">
                                                                        <div id="logo">

                                                                        </div>
                                                                    </div>

                                                                    <input type="hidden" name="old_logo_image"
                                                                        id="old_logo_image"
                                                                        value="{{ config('sittings.logo') }}">
                                                                </div>
                                                                <div class="col-md-6 form-group">
                                                                    <label for="logo">FavIcon</label>
                                                                    <div class="col-md-12 px-0 text-center">
                                                                        <div id="favicon">

                                                                        </div>
                                                                    </div>

                                                                    <input type="hidden" name="old_favicon_image"
                                                                        id="old_favicon_image"
                                                                        value="{{ config('sittings.favicon') }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <x-form.textbox type="text" col="col-md-8" label="Currency Code"
                                                            name="currency_code" required="required"
                                                            placeholder="Currency Code"
                                                            value="{{ config('sittings.currency_code') }}" />

                                                        <x-form.textbox type="text" col="col-md-8" label="Currency Symbol"
                                                            name="currency_symbol" required="required"
                                                            placeholder="Currency Symbol"
                                                            value="{{ config('sittings.currency_symbol') }}" />
                                                        <div class="form-group col-md-8">
                                                            <label for="">Currency Position</label>
                                                            <div class="custom-control custom-radio custome-control-inline">
                                                                <input type="radio" name="currency_position" id="prefix"
                                                                    value="prefix" class="custom-control-input"
                                                                    {{ config('sittings.currency_position') == 'prefix' ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="prefix">Prefix</label>
                                                            </div>
                                                            <div class="custom-control custom-radio ">
                                                                <input type="radio" name="currency_position" id="suffix"
                                                                    value="suffix" class="custom-control-input"
                                                                    {{ config('sittings.currency_position') == 'suffix' ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="suffix">Suffix</label>
                                                            </div>
                                                        </div>
                                                        <x-form.selectbox col="col-md-8" label="Timezone" name="timezone"
                                                            required="required" class="selectpicker">
                                                            @foreach ($zones_array as $zone)
                                                                <option
                                                                    {{ config('sittings.timezone') == $zone['zone'] ? 'selected' : '' }}
                                                                    value="{{ $zone['zone'] }}">
                                                                    {{ $zone['diff_from_GMT'] . '-' . $zone['zone'] }}
                                                                </option>
                                                            @endforeach
                                                        </x-form.selectbox>

                                                        <x-form.selectbox col="col-md-8" label="Date Formate"
                                                            name="datae_formate" required="required" class="selectpicker">

                                                            <option
                                                                {{ config('sittings.datae_formate') == 'F j,Y' ? 'selected' : '' }}
                                                                value="F j,Y">{{ date('F j,Y') }}</option>
                                                            <option
                                                                {{ config('sittings.datae_formate') == 'M j,Y' ? 'selected' : '' }}
                                                                value="M j,Y">{{ date('M j,Y') }}</option>
                                                            <option
                                                                {{ config('sittings.datae_formate') == 'j F,Y' ? 'selected' : '' }}
                                                                value="j F,Y">{{ date('j F,Y') }}</option>

                                                            <option
                                                                {{ config('sittings.datae_formate') == 'J F,Y' ? 'selected' : '' }}
                                                                value="J F,Y">{{ date('J F,Y') }}</option>
                                                            <option
                                                                {{ config('sittings.datae_formate') == 'F J,Y' ? 'selected' : '' }}
                                                                value="F J,Y">{{ date('F J,Y') }}</option>
                                                            <option
                                                                {{ config('sittings.datae_formate') == 'j M,Y' ? 'selected' : '' }}
                                                                value="j M,Y">{{ date('j M ,Y') }}</option>

                                                            <option
                                                                {{ config('sittings.datae_formate') == 'F J,Y' ? 'selected' : '' }}
                                                                value="F J,Y">{{ date('F J,Y') }}</option>

                                                            <option
                                                                {{ config('sittings.datae_formate') == 'y-m-d' ? 'selected' : '' }}
                                                                value="y-m-d">{{ date('y-m-d') }}</option>
                                                            <option
                                                                {{ config('sittings.datae_formate') == 'y/m/d' ? 'selected' : '' }}
                                                                value="y/m/d">{{ date('y/m/d') }}</option>


                                                        </x-form.selectbox>

                                                        <x-form.textbox type="text" col="col-md-8" label="Invoice Prefix"
                                                            name="invoice_prefix" required="required"
                                                            placeholder="Invoice Prefix"
                                                            value="{{ config('sittings.invoice_prefix') }}" />

                                                        <x-form.textbox type="text" col="col-md-8" label="Invoice Number"
                                                            name="invoice_number" required="required"
                                                            placeholder="Invoice Number"
                                                            value="{{ config('sittings.invoice_number') }}" />
                                                        <div class="form-group col-md-8">
                                                            <input type="reset" class="btn btn-danger btn-sm" value="Reset">
                                                            <input type="button" class="btn btn-primary btn-sm"
                                                                id="general_save_btn" onclick="save_data('general')"
                                                                value="Save">

                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- /tab pane-->

                                        <!-- Tab Pane -->
                                        <div id="mail_sitting" class="tab-pane">
                                            <div class="card-body">
                                                <form id="mail" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <x-form.selectbox col="col-md-8" label="Mail Driver (protocol)"
                                                            name="mail_mailer" required="required" class="selectpicker">
                                                            @foreach (MAIL_MAILER as $mailer)
                                                                <option
                                                                    {{ config('sittings.mail_mailer') == $mailer ? 'selected' : '' }}
                                                                    value="{{ $mailer }}">
                                                                    {{ $mailer }}
                                                                </option>
                                                            @endforeach
                                                        </x-form.selectbox>

                                                        <x-form.textbox type="text" col="col-md-8" label="Mail Host"
                                                            name="mail_host" required="required" placeholder="Mail Host"
                                                            value="{{ config('sittings.mail_host') }}" />
                                                        <x-form.textbox type="text" col="col-md-8" label="Mail Address"
                                                            name="mail_username" required="required"
                                                            placeholder="Mail Address"
                                                            value="{{ config('sittings.mail_username') }}" />
                                                        <x-form.textbox type="text" col="col-md-8" label="Mail Password"
                                                            name="mail_password" required="required"
                                                            placeholder="Mail Password"
                                                            value="{{ config('sittings.mail_password') }}" />
                                                        <x-form.textbox type="text" col="col-md-8" label="Mail From Name"
                                                            name="mail_from_name" required="required"
                                                            placeholder="Mail From name"
                                                            value="{{ config('sittings.mail_from_name') }}" />
                                                        <x-form.textbox type="text" col="col-md-8" label="Mail Port "
                                                            name="mail_port" required="required" placeholder="Mail port "
                                                            value="{{ config('sittings.mail_port') }}" />

                                                        <x-form.selectbox col="col-md-8" label="Mail Encryption"
                                                            name="mail_encryption" required="required" class="selectpicker">
                                                            @foreach (MAIL_ENCRYPTION as $key => $encryption)
                                                                <option
                                                                    {{ config('sittings.mail_encryption') == $encryption ? 'selected' : '' }}
                                                                    value="{{ $encryption }}">
                                                                    {{ $key }}
                                                                </option>
                                                            @endforeach
                                                        </x-form.selectbox>

                                                        <div class="form-group col-md-8">
                                                            <input type="reset" class="btn btn-danger btn-sm" value="Reset">
                                                            <input type="button" class="btn btn-primary btn-sm"
                                                                id="mail_save_btn" onclick="save_data('mail')" value="Save">

                                                        </div>
                                                        <div class="form-group col-md-8"></div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                        <!-- /tab pane-->


                                    </div>
                                    <!-- /tab content -->

                                </div>
                                <!-- /card body -->

                            </div>
                            <!-- /card -->

                        </div>
                        <!-- /grid item -->

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
    <script src="js/spartan-multi-image-picker-min.js"></script>
    <script>
        $(document).ready(function() {
            $('#logo').spartanMultiImagePicker({
                fieldName: 'logo',
                maxCount: 1,
                rowHeight: '200px',
                groupClassName: 'col-md-12 col-sm-12 col-xs-12',
                allowedExt: 'png|jpg|jpeg',
                dropFileLabel: "Drop Here",
                onExtensionErr: function(index, file) {
                    Swal.fire({
                        icon: 'error',
                        title: 'oops...',
                        text: 'only png, jpeg, jpg file allowed'
                    })
                }
            });

            $('#favicon').spartanMultiImagePicker({
                fieldName: 'favicon',
                maxCount: 1,
                rowHeight: '200px',
                groupClassName: 'col-md-12 col-sm-12 col-xs-12',
                alloweExt: 'png|jpg|jpeg',
                dropFileLabel: "Drop Here",
                onExtensionErr: function(index, file) {
                    Swal.fire({
                        icon: 'error',
                        title: 'oops..',
                        text: 'only png,jpeg,jpg file allowed'
                    });
                }
            });

            $('input[name="logo"],input[name="favicon"]').prop('required', true);

            $('.remove_files').on('click', function() {
                $(this).parents('.col-md-12').remove();
            })

            @if (config('sittings.logo'))
                $('#logo img.spartan_image_placeholder').css('display','none');
                $('#logo .spartan_remove_row').css('display','none');
                $('#logo .img_').css('display','block');
                $('#logo .img_').attr('src','{{ asset("storage/" . LOGO_PATH . config("sittings.logo")) }}');
            @endif

            @if (config('sittings.favicon'))
                $('#logo img.spartan_image_placeholder').css('display','none');
                $('#logo .spartan_remove_row').css('display','none');
                $('#logo .img_').css('display','block');
                $('#logo .img_').attr('src','{{ asset("storage/" . LOGO_PATH . config("sittings.favicon")) }}');
            @endif


       
        });

        function save_data(form_id) {
               
                let form = document.getElementById(form_id);
                let formData = new FormData(form);
                let url;
                if (form_id == 'general') {
                    url = "{{ route('general.sitting') }}";
                } else {
                    url = "{{ route('mail.sitting') }}";
                }
                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    cache: false,
                    beforeSend: function() {
                        $('#'+form_id + '_save_btn').addClass(
                            'kt-spinner kt-spinner--md kt-spinner--light');
                    },
                    complete: function() {
                        $('#' + form_id + '_save_btn').removeClass(
                            'kt-spinner kt-spinner--md kt-spinner--light');
                    },
                    success: function(data) {
                        $('#' + form_id).find('.is-invalid').removeClass('is-invalid');
                        $('#' + form_id).find('.error').remove();

                        if (data.status == false) {
                            $.each(data.errors, function(key, value) {
                                $('#' + form_id + ' input#' + key).addClass('is-invalid');
                                $('#' + form_id + ' textarea#' + key).addClass('is-invalid');
                                $('#' + form_id + ' select#' + key).parent().addClass(
                                    'is-invalid');
                                $('#' + form_id + ' #' + key).parent().append(
                                    '<small class="text-danger error">' + value + '</small>'
                                    );

                            });
                        } else {
                            notification(data.status, data.message);
                        }
                    },
                    error: function(xhr, ajaxoption, thrownError) {
                        console.log('error');
                        console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr
                            .responseText);
                    }

                });
            }

    </script>
@endpush
