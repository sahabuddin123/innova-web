<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title'); ?> - <?php echo e(config('settings.site_name')); ?></title>
    <!-- Google Fonts -->
       <link href="https://fonts.googleapis.com/css?family=Hind+Siliguri:300,400,500,600,700|Source+Sans+Pro:300,400,500,600,700|Roboto:300,400,500,700,900&amp;display=swap" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@100;200;300;400;500;600;700;800;900&family=Noto+Sans:ital,wght@1,600&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo e(asset('public/storage/'.config('settings.site_favicon'))); ?>" type="image/x-icon">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/v2/assets/css/bootstrap.min.css')); ?>">
    <!-- select2 -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/v2/assets/css/select2.min.css')); ?>">
    <!-- Slick -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/v2/assets/css/slick.css')); ?>">
    <!-- Slick -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/v2/assets/css/magnific-popup.css')); ?>">
    <!-- jquery-ui -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/v2/assets/css/jquery-ui.css')); ?>">
    <!-- plyr Css -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/v2/assets/css/plyr.css')); ?>">
    <!-- animate -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/v2/assets/css/animate.css')); ?>">
    
    

    <link rel="stylesheet" href="<?php echo e(asset('frontend/v2/assets/css/aos.css')); ?>">
    <!-- Main css -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/v2/assets/css/main.css')); ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <!-- Include script -->
   <?php echo htmlScriptTagJsApi(); ?>

    <style>
        *, body{
            --heading-font:  "Hind Siliguri", serif;
            --body-font: "Noto Sans Bengali", sans-serif;
        }
        a{
            font-family: "Hind Siliguri";
        }
        p{
            font-family: "Noto Sans Bengali", sans-serif;
        }
    </style>
</head>

<body>

    <!--==================== Preloader Start ====================-->
    <div class="preloader" id="modern-preloader">
        <div class="preloader-center">
            <svg width="60" height="80" viewBox="0 0 60 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <polygon class="diamond diamond1" points="30,15 36,18.5 30,22 24,18.5" fill="#1976d2"/>
                    <polygon class="diamond diamond2" points="30,25 36,28.5 30,32 24,28.5" fill="#42a5f5"/>
                    <polygon class="diamond diamond3" points="30,35 36,38.5 30,42 24,38.5" fill="#90caf9"/>
                </g>
            </svg>
        </div>
    </div>
    <!--==================== Preloader End ====================-->

    <!--==================== Overlay Start ====================-->
    <div class="overlay"></div>
    <!--==================== Overlay End ====================-->

    <!--==================== Sidebar Overlay End ====================-->
    <div class="side-overlay"></div>
    <!--==================== Sidebar Overlay End ====================-->

    <!-- ==================== Scroll to Top End Here ==================== -->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <!-- ==================== Scroll to Top End Here ==================== -->
<!-- header -->
<?php echo $__env->make('frontend.v2.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!-- /header -->

<?php echo $__env->yieldContent('content'); ?>

<!-- Footer -->
<?php echo $__env->make('frontend.v2.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- /Footer -->



    <!-- Jquery js -->
    <script src="<?php echo e(asset('frontend/v2/assets/js/jquery-3.7.1.min.js')); ?>"></script>
    <!-- Bootstrap Bundle Js -->
    <script src="<?php echo e(asset('frontend/v2/assets/js/boostrap.bundle.min.js')); ?>"></script>
    <!-- select2 Js -->
    <script src="<?php echo e(asset('frontend/v2/assets/js/select2.min.js')); ?>"></script>
    <!-- Phosphor Icon Js -->
    <script src="<?php echo e(asset('frontend/v2/assets/js/phosphor-icon.js')); ?>"></script>
    <!-- Slick js -->
    <script src="<?php echo e(asset('frontend/v2/assets/js/slick.min.js')); ?>"></script>
    <!-- Slick js -->
    <script src="<?php echo e(asset('frontend/v2/assets/js/counter.min.js')); ?>"></script>
    <!-- magnific popup -->
    <script src="<?php echo e(asset('frontend/v2/assets/js/magnific-popup.min.js')); ?>"></script>
    <!-- Jquery Ui js -->
    <script src="<?php echo e(asset('frontend/v2/assets/js/jquery-ui.js')); ?>"></script>
    <!-- plyr Js -->
    <script src="<?php echo e(asset('frontend/v2/assets/js/plyr.js')); ?>"></script>
    <!-- vanilla Tilt -->
    <script src="<?php echo e(asset('frontend/v2/assets/js/vanilla-tilt.min.js')); ?>"></script>
    <!-- wow -->
    <script src="<?php echo e(asset('frontend/v2/assets/js/wow.min.js')); ?>"></script>

    <script src="<?php echo e(asset('frontend/v2/assets/js/aos.js')); ?>"></script>

    <!-- main js -->
    <script src="<?php echo e(asset('frontend/v2/assets/js/main.js')); ?>"></script>

    <style>
        .preloader {
            position: fixed;
            left: 0; top: 0; width: 100vw; height: 100vh;
            background: #fff;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.5s;
        }
        .preloader-center {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .preloader.hide {
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.5s;
        }
        .diamond {
            opacity: 0.7;
            transform-origin: 50% 50%;
            animation: diamond-bounce 1.2s infinite;
        }
        .diamond1 {
            animation-delay: 0s;
        }
        .diamond2 {
            animation-delay: 0.2s;
        }
        .diamond3 {
            animation-delay: 0.4s;
        }
        @keyframes  diamond-bounce {
            0% { transform: translateY(0) scale(1); opacity: 0.7; }
            20% { transform: translateY(-10px) scale(1.1); opacity: 1; }
            40% { transform: translateY(0) scale(1); opacity: 0.7; }
            60% { transform: translateY(10px) scale(0.95); opacity: 0.5; }
            80% { transform: translateY(0) scale(1); opacity: 0.7; }
            100% { transform: translateY(0) scale(1); opacity: 0.7; }
        }
    </style>
    <script>
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.getElementById('modern-preloader').classList.add('hide');
            }, 400);
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if(session('success')): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: <?php echo json_encode(session('success')); ?>,
                    confirmButtonText: 'OK'
                });
            <?php elseif(session('error')): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: <?php echo json_encode(session('error')); ?>,
                    confirmButtonText: 'OK'
                });
            <?php elseif($errors->any()): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Submission failed',
                    text: <?php echo json_encode($errors->first()); ?>,
                    confirmButtonText: 'OK'
                });
            <?php endif; ?>
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>

</body>

</html>
<?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/frontend/v2/app.blade.php ENDPATH**/ ?>