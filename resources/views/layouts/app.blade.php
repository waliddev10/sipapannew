<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ config('app.description') }}">
    <meta name="author" content="{{ config('app.author') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@hasSection('title') @yield('title') - {{ config('app.name') }} @else {{ config('app.name') }} @endif</title>
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="{{ asset('assets/css/sb-admin-2.css') }}" rel="stylesheet">
    {{--
    <link href="{{ asset('assets/css/sb-admin-2.css').'?v='.Str::random(5) }}" rel="stylesheet"> --}}

    @stack('styles')

</head>

<body id="page-top">

    {{-- <div class="preloader">
        <div class="loading">
            <div class="loader"> </div>
            <div style="padding-top: 20px"><strong>F M I S</strong></div>
        </div>
    </div> --}}

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('partials.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('partials.navbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid p-0">
                    {{-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">@yield('title', 'Halaman')</h1>
                        @yield('title-widget')
                    </div> --}}

                    <!-- Content Row -->
                    @yield('content')
                    <!-- Content Row -->

                </div>
                <!-- /.container-fluid -->

            </div>

            @include('partials.footer')

        </div>
    </div>

    @include('components.scroll-to-top')

    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/sb-admin-2.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/sb-admin-2.js').'?v='.Str::random(5) }}"></script> --}}

    @stack('scripts')
</body>

</html>