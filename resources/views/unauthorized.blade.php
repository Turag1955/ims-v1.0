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
                    <button onclick="userShowModal('User Add','Save')" class="btn btn-primary btn-sm" type="button"><i
                            class="fas fa-plus-square"></i> Add User
                    </button>
                </div>
                <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">

                    <!-- Tables -->

                    <!-- Site Content -->
                    <div class="dt-content">

                        <!-- Page Container -->
                        <div class="dt-page--container">

                            <!-- 404 Page -->
                            <div class="error-page text-center">

                                <!-- Title -->
                                <h1 class="dt-error-code">500</h1>
                                <!-- /title -->

                                <h2 class="mb-10">Sorry, server goes wrong</h2>

                                <p class="text-center mb-6"><a href="index-2.html" class="btn btn-primary">Go to
                                        Home</a></p>


                            </div>
                            <!-- /404 page -->

                        </div>
                        <!-- /page container -->

                    </div>
                    <!-- /site content -->
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
