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
                        <a href="{{ route('menu') }}"
                            class="btn btn-danger btn-sm"><i class="fas fa-arrow-circle-left"></i> Back
                        </a>
                        <a href="{{ route('menu.module.create', ['menu' => $data['menu']->id]) }}"
                            class="btn btn-primary btn-sm"><i class="fas fa-plus-square"></i> Add New
                        </a>
                    </div>
                    <!-- /entry heading -->

                </div>
                <!-- /entry header -->

                <!-- Card -->
                <div class="dt-card">

                    <!-- Card Body -->
                    <div class="dt-card__body menu-builder">
                        <h5>Drag and Drop The Menu item Below to re-arrenge them</h5>
                        <div class="dd">
                            <x-menu-builder :menuItem="$data['menu']->menuItem" />
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
    {{-- @include('menu.modal') --}}
@endsection
@push('script')
    <script>
        $(function() {
            $('.dd').nestable({
                maxDepth: 2
            });
            $('.dd').on('change', function(e) {
                $.post('{{ route("menu.order", ["menu" => $data["menu"]->id]) }}', {
                    order: JSON.stringify($('.dd').nestable('serialize')),
                    _token: _token
                }, function(data) {
                    notification('success', 'menu order successfully');
                });
            })
        });

        function deletModule(id) {
            Swal.fire({
                title: 'Are you sure to delete ?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete_form_' + id).submit();
                }
            });
        }

        $(document).ready(function() {
            @if (session('success')){
                notification('success',"{{ session('success') }}");
                }
            @endif
            @if (session('error')){
                notification('error',"{{ session('error') }}");
                }
            @endif
        });

    </script>
@endpush
