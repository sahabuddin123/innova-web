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
    <!-- DataTables CSS (CDN) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <!-- Magnific Popup CSS (CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
    <!-- Custom styles for this template-->
    <link href="https://fonts.googleapis.com/css?family=Hind+Siliguri:300,400,500,600,700|Source+Sans+Pro:300,400,500,600,700|Roboto:300,400,500,700,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@100;200;300;400;500;600;700;800;900&family=Noto+Sans:ital,wght@1,600&display=swap" rel="stylesheet">
    <link href="{{ asset('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Dynamic Font Family -->
    @php
        $fontFamily = config('settings.admin_font_family', 'default');
        $fontFamilies = [
            'default' => 'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
            'poppins' => "'Poppins', sans-serif",
            'roboto' => "'Roboto', sans-serif",
            'open-sans' => "'Open Sans', sans-serif",
            'noto-sans' => "'Noto Sans Bengali', 'Noto Sans', sans-serif"
        ];
        $selectedFont = $fontFamilies[$fontFamily] ?? $fontFamilies['default'];
    @endphp
    
    <!-- Custom Admin Panel UI Enhancements -->
    <style>
        :root {
            --admin-accent: {{ config('settings.admin_accent_color', '#667eea') }};
            --admin-radius: {{ config('settings.admin_border_radius', '8') }}px;
            --sidebar-bg: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --admin-font: {{ $selectedFont }};
        }
        
        body, body * {
            font-family: var(--admin-font);
        }
        
        /* Dynamic Theme Colors */
        @php $themeColor = config('settings.admin_theme_color', 'gradient-purple'); @endphp
        
        @if($themeColor == 'gradient-blue')
        :root { --sidebar-bg: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
        @elseif($themeColor == 'gradient-green')
        :root { --sidebar-bg: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
        @elseif($themeColor == 'gradient-dark')
        :root { --sidebar-bg: linear-gradient(135deg, #232526 0%, #414345 100%); }
        @elseif($themeColor == 'glass')
        :root { --sidebar-bg: rgba(255, 255, 255, 0.1); --glass-effect: 1; }
        @elseif($themeColor == 'light')
        :var { --sidebar-bg: #f8f9fa; }
        @endif
        
        /* Glass Effect */
        @if(config('settings.admin_glass_effect') == '1')
        .sidebar, .topbar, .card, .tile, .dropdown-menu {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.85) !important;
        }
        .sidebar {
            background: rgba(102, 126, 234, 0.15) !important;
            border-right: 1px solid rgba(255, 255, 255, 0.2);
        }
        .sidebar .nav-item .nav-link {
            background: transparent;
        }
        .sidebar .nav-item .nav-link.active {
            background: rgba(255, 255, 255, 0.2) !important;
        }
        @endif
        
        /* ===== Sidebar Enhancements ===== */
        .sidebar {
            background: var(--sidebar-bg);
            transition: all 0.3s ease;
            border-radius: 0 {{ config('settings.admin_border_radius', '8') }}px {{ config('settings.admin_border_radius', '8') }}px 0;
        }
        
        .sidebar .nav-item .nav-link {
            padding: 12px 20px;
            border-radius: var(--admin-radius);
            margin: 4px 12px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .sidebar .nav-item .nav-link:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
        }
        
        .sidebar .nav-item .nav-link.active {
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        /* Active nav item highlight */
        .sidebar .nav-item.active > .nav-link {
            background: rgba(255, 255, 255, 0.25) !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }
        
        /* Active collapse item */
        .sidebar .collapse-item.active {
            background: #fff !important;
            color: var(--admin-accent) !important;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
        }
        
        .sidebar .nav-item .nav-link i {
            width: 24px;
            text-align: center;
            margin-right: 8px;
        }
        
        .sidebar .sidebar-divider {
            border-color: rgba(255, 255, 255, 0.2);
            margin: 15px 20px;
        }
        
        .sidebar .sidebar-heading {
            color: rgba(255, 255, 255, 0.7);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0 24px;
            margin-top: 10px;
        }
        
        /* Sidebar collapse menu */
        .sidebar .collapse-inner {
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            margin: 5px 10px;
        }
        
        .sidebar .collapse-item {
            padding: 10px 15px;
            border-radius: 6px;
            margin: 2px 0;
            transition: all 0.2s ease;
        }
        
        .sidebar .collapse-item:hover {
            background: #f8f9fa;
            transform: translateX(5px);
        }
        
        .sidebar .collapse-item.active {
            background: #fff !important;
            color: #667eea !important;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
        }
        
        /* ===== Header Enhancements ===== */
        .topbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border-bottom: 1px solid #e3e6f0;
        }
        
        .navbar-search {
            background: #f8f9fc !important;
            border-radius: 25px;
            padding: 0 15px;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }
        
        .navbar-search:focus-within {
            border-color: #667eea;
            background: white !important;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }
        
        .navbar-search input {
            background: transparent;
            border: none;
            padding: 10px 15px;
        }
        
        .navbar-search input:focus {
            outline: none;
            box-shadow: none;
        }
        
        .navbar-search .btn {
            border-radius: 50%;
            width: 36px;
            height: 36px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* ===== Card & Container Enhancements ===== */
        @php $cardStyle = config('settings.admin_card_style', 'default'); @endphp
        
        .card {
            border: none;
            border-radius: var(--admin-radius);
            transition: all 0.3s ease;
        }
        
        @if($cardStyle == 'default')
        .card {
            box-shadow: {{ config('settings.admin_shadow_effect', '1') == '1' ? '0 2px 15px rgba(0, 0, 0, 0.05)' : 'none' }};
            background: #fff;
        }
        @elseif($cardStyle == 'flat')
        .card {
            box-shadow: none;
            background: #f8f9fc;
            border: 1px solid #e3e6f0;
        }
        @elseif($cardStyle == 'modern')
        .card {
            box-shadow: {{ config('settings.admin_shadow_effect', '1') == '1' ? '0 10px 40px rgba(0, 0, 0, 0.08)' : 'none' }};
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fc 100%);
            border: 1px solid rgba(255, 255, 255, 0.8);
        }
        @elseif($cardStyle == 'glass')
        .card {
            box-shadow: {{ config('settings.admin_shadow_effect', '1') == '1' ? '0 8px 32px rgba(0, 0, 0, 0.1)' : 'none' }};
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        @endif
        
        .card:hover {
            box-shadow: {{ config('settings.admin_shadow_effect', '1') == '1' ? '0 5px 25px rgba(0, 0, 0, 0.1)' : 'none' }};
            transform: {{ config('settings.admin_animation', '1') == '1' ? 'translateY(-2px)' : 'none' }};
        }
        
        .tile {
            border-radius: var(--admin-radius);
            box-shadow: {{ config('settings.admin_shadow_effect', '1') == '1' ? '0 2px 15px rgba(0, 0, 0, 0.05)' : 'none' }};
            border: none;
        }
        
        .tile-body {
            padding: 20px;
        }
        
        /* ===== Button Enhancements ===== */
        .btn {
            border-radius: var(--admin-radius);
            font-weight: 500;
            padding: 8px 20px;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            transform: {{ config('settings.admin_animation', '1') == '1' ? 'translateY(-2px)' : 'none' }};
            box-shadow: {{ config('settings.admin_shadow_effect', '1') == '1' ? '0 5px 15px rgba(0, 0, 0, 0.1)' : 'none' }};
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--admin-accent) 0%, var(--admin-accent) 100%);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--admin-accent) 0%, #5a6fd6 100%);
        }
        
        /* ===== Table Enhancements ===== */
        .table {
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .table thead th {
            background: #f8f9fc;
            border-bottom: 2px solid #e3e6f0;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            color: #5a5a5a;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background: #f8f9fc;
        }
        
        /* ===== Dropdown Enhancements ===== */
        .dropdown-menu {
            border: none;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 10px;
        }
        
        .dropdown-item {
            border-radius: 6px;
            padding: 10px 15px;
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background: #f8f9fc;
            transform: translateX(5px);
        }
        
        /* ===== Badge Enhancements ===== */
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 11px;
        }
        
        /* ===== Modal Enhancements ===== */
        .modal-content {
            border: none;
            border-radius: var(--admin-radius);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }
        
        .modal-header {
            border-bottom: 1px solid #e3e6f0;
            padding: 20px 25px;
        }
        
        .modal-footer {
            border-top: 1px solid #e3e6f0;
            padding: 15px 25px;
        }
        
        /* ===== Page Heading Enhancements ===== */
        .d-sm-flex.align-items-center.justify-content-between {
            margin-bottom: 25px;
        }
        
        .d-sm-flex.align-items-center.justify-content-between h1 {
            font-weight: 600;
            color: #333;
        }
        
        /* ===== Alert Enhancements ===== */
        .alert {
            border: none;
            border-radius: var(--admin-radius);
            padding: 15px 20px;
        }
        
        /* ===== Form Enhancements ===== */
        .form-control {
            border-radius: var(--admin-radius);
            border: 2px solid #e3e6f0;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }
        
        /* ===== Animation Keyframes ===== */
        @if(config('settings.admin_animation', '1') == '1')
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .tile-body {
            animation: fadeInUp 0.5s ease;
        }
        @endif
        
        /* ===== Custom CSS from Settings ===== */
        {!! config('settings.admin_custom_css', '') !!}
    </style>
   
   </head>
   <body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
    @include('admin.partials.sidebar')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
    @include('admin.partials.header')
    <!-- Begin Page Content -->
    <main class="container-fluid">
        @yield('content')
    </main>
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
    @include('admin.partials.footer')
    </div>
    <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    @include('admin.partials.model')
    <!-- jQuery (CDN) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('backend/js/sb-admin-2.min.js') }}"></script>
    <!-- DataTables & Buttons JS (CDN) -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <!-- Magnific Popup JS (CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    <!-- Page level plugins -->
    <script src="{{ asset('backend/vendor/chart.js/Chart.min.js') }}"></script>
    <!-- Page level custom scripts -->
    <!--  -->
    <!-- <script src="{{ asset('backend/js/demo/chart-pie-demo.js') }}"></script> -->
       <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    
       <!-- Delete Confirmation Script -->
    <script>
        $(document).ready(function() {
            // Handle all delete links and buttons
            $(document).on('click', 'a[href*="/delete"], button[data-delete-url]', function(e) {
                e.preventDefault();
                
                var deleteUrl = $(this).attr('href') || $(this).data('delete-url');
                var itemName = $(this).data('name') || 'this item';
                
                // Show SweetAlert confirmation
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to delete ' + itemName + '?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, Delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit POST request
                        $.ajax({
                            url: deleteUrl,
                            type: 'POST',
                            data: {
                                '_token': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    'Record has been deleted successfully.',
                                    'success'
                                ).then(function() {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Error deleting record: ' + xhr.statusText,
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>