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
                        <a href="{{ route('menu.builder', ['id' => $data['menu']->id]) }}"
                            class="btn btn-danger btn-sm"><i class="fas fa-arrow-circle-left"></i> Back
                        </a>
                    </div>
                    <!-- /entry heading -->

                </div>
                <!-- /entry header -->

                <!-- Card -->
                <div class="dt-card">

                    <!-- Card Body -->
                    <div class="dt-card__body ">

                        <form action="{{ route('menu.module.store.or.update') }}" method="post">
                            @csrf
                            <input type="hidden" name="update_id"
                                value="{{ isset($data['module']->id) ? $data['module']->id : '' }}">
                            <input type="hidden" name="menu_id" id="menu_id" value="{{ $data['menu']->id }}">
                            <div class="form-group">
                                <label for="type">Type</label>
                                <select onchange="selectItem(this.value)"
                                    class="form-control selectpicker @error('type') is-invalid @enderror" name="type"
                                    id="type">
                                    <option value="">Select Please</option>
                                    <option @isset($data['module']) {{ $data['module']->type == 1 ? 'selected' : '' }}
                                        @endisset {{ old('type') == 1 ? 'selected' : '' }} value="1">Devider</option>
                                    <option @isset($data['module']) {{ $data['module']->type == 2 ? 'selected' : '' }}
                                        @endisset {{ old('type') == 2 ? 'selected' : '' }} value="2">Module/Item</option>
                                </select>
                                @error('type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="devider_fileds d-none">
                                <div class="form-group">
                                    <label for="devider_name">Devider Name</label>
                                    <input class="form-control @error('devider_name') is-invalid @enderror" type="text"
                                        name="devider_name" id="devider_name"
                                        value="{{ isset($data['module']) ? $data['module']->devider_name : old('devider_name') }}"
                                        placeholder="Devider Name">
                                    @error('devider_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="module_fields d-none">
                                <div class="form-group">
                                    <label for="module_name">Module Name</label>
                                    <input class="form-control @error('module_name') is-invalid @enderror" type="text"
                                        name="module_name" id="module_name"
                                        value="{{ isset($data['module']) ? $data['module']->module_name : old('module_name') }}"
                                        placeholder="Module Name">
                                    @error('module_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="icon_class">Fornt Icon Class For The Module <a
                                            href="https://forntawesome.com">Use Fornt Icon Class</a></label>
                                    <input class="form-control @error('icon_class') is-invalid @enderror" type="text"
                                        name="icon_class" id="icon_class"
                                        value="{{ isset($data['module']) ? $data['module']->icon_class : old('icon_class') }}"
                                        placeholder="Front Icon Class">
                                    @error('icon_class')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="url">URL</label>
                                    <input class="form-control @error('url') is-invalid @enderror" type="text" name="url"
                                        id="url" value="{{ isset($data['module']) ? $data['module']->url : old('url') }}"
                                        placeholder="Front Icon Class">
                                    @error('url')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="target">Open In</label>
                                    <select class="form-control selectpicker @error('target') is-invalid @enderror"
                                        name="target" id="target">
                                        <option value="">Select Please</option>
                                        <option @isset($data['module'])
                                            {{ $data['module']->target == '_self' ? 'selected' : '' }} @endisset
                                            {{ old('target') == '_self' ? 'selected' : '' }} value="_self">Same Tab</option>
                                        <option @isset($data['module'])
                                            {{ $data['module']->target == '_blank' ? 'selected' : '' }} @endisset
                                            {{ old('target') == '_blank' ? 'selected' : '' }} value="_blank">New Tab</option>
                                    </select>
                                    @error('target')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-danger btn-sm" type="reset"><i class="fas fa-redo"></i>
                                    Reset</button>
                                <button class="btn btn-primary btn-sm" type="submit">
                                    @isset($data['module'])
                                        <i class="fas fa-arrow-circle-up"></i> Update
                                    @else
                                        <i class="fas fa-plus-square"></i> Save
                                    @endisset
                                </button>
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
    <script>
        var type = $('#type option:selected').val();
        if (type) {
            selectItem(type);
        }

        function selectItem(type) {
            if (type == 1) {
                $('.devider_fileds').removeClass('d-none');
                $('.module_fields').addClass('d-none');
            } else if (type == 2) {
                $('.module_fields').removeClass('d-none');
                $('.devider_fileds').addClass('d-none');
            }
        }

    </script>
@endpush
