<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('settings.site_name') }}</title>
    <!-- Google Fonts -->
       <link href="https://fonts.googleapis.com/css?family=Hind+Siliguri:300,400,500,600,700|Source+Sans+Pro:300,400,500,600,700|Roboto:300,400,500,700,900&amp;display=swap" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@100;200;300;400;500;600;700;800;900&family=Noto+Sans:ital,wght@1,600&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('public/storage/'.config('settings.site_favicon')) }}" type="image/x-icon">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/plugins/bootstrap/bootstrap.min.css') }}">
    <!-- slick slider -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/plugins/slick/slick.css') }}">
    <!-- themefy-icon -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/plugins/themify-icons/themify-icons.css') }}">
    <!-- animation css -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/plugins/animate/animate.css') }}">
    <!-- aos -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/plugins/aos/aos.css') }}">
    <!-- venobox popup -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/plugins/venobox/venobox.css') }}">
    <!-- Main Stylesheet -->
    <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">
    <!-- Include script -->
   {!! htmlScriptTagJsApi() !!}
</head>

<body>
  <!-- preloader start -->
  <div class="preloader">
    <img src="{{ asset('frontend/assets/images/preloader.gif') }}" alt="preloader">
  </div>
  <!-- preloader end -->
<!-- header -->
@include('frontend.partials.header')
@include('frontend.layout.login-register')
<!-- /header -->
{{-- Content Start --}}
@yield('content')
{{-- Content End --}}
<!-- Footer -->
@include('frontend.partials.footer')
<!-- /Footer -->

<!-- jQuery -->
<script src="{{ asset('frontend/assets/plugins/jQuery/jquery.min.js') }}"></script> 
<!-- Bootstrap JS -->
<script src="{{ asset('frontend/assets/plugins/bootstrap/bootstrap.min.js') }}"></script>
<!-- slick slider -->
<script src="{{ asset('frontend/assets/plugins/slick/slick.min.js') }}"></script>
<!-- aos -->
<script src="{{ asset('frontend/assets/plugins/aos/aos.js') }}"></script>
<!-- venobox popup -->
<script src="{{ asset('frontend/assets/plugins/venobox/venobox.min.js') }}"></script>
<!-- filter -->
<script src="{{ asset('frontend/assets/plugins/filterizr/jquery.filterizr.min.js') }}"></script>
<!-- google map -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU"></script>
<script src="{{ asset('frontend/assets/plugins/google-map/gmap.js') }}"></script>

<!-- Main Script -->
<script src="{{ asset('frontend/assets/js/script.js') }}"></script>
@stack('scripts')
</body>
</html>