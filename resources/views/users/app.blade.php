<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title') - {{ config('app.name') }}</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('public/storage/'.config('settings.site_favicon')) }}" type="image/x-icon">
    <!-- Custom fonts for this template-->
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Front CSS -->
    <link href="{{ asset('backend/css/font.css') }}" rel="stylesheet" type="text/css">
    <!-- DataTable CSS -->
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="{{ asset('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">
   </head>
   <body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
    @include('users.partials.sidebar')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
    @include('users.partials.header')
    <!-- Begin Page Content -->
    <main class="container-fluid">
        @yield('content')
    </main>
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
    @include('users.partials.footer')
    </div>
    <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    @include('users.partials.model')
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('backend/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
    {{-- <script src="{{ asset('backend/vendor/jquery/bKash-checkout-sandbox.js') }}"></script> --}}
    {{-- <script src="{{ asset('backend/vendor/jquery/bKash-checkout.js') }}"></script> --}}
     <script src="https://scripts.pay.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout.js"></script> 
    <script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('backend/js/sb-admin-2.min.js') }}"></script>
    <!-- Page level plugins -->
    <script src="{{ asset('backend/vendor/chart.js/Chart.min.js') }}"></script>
    <!-- Page level custom scripts -->
    <!--  -->
    <!-- <script src="{{ asset('backend/js/demo/chart-pie-demo.js') }}"></script> -->
    
    @stack('scripts')
</body>
</html>