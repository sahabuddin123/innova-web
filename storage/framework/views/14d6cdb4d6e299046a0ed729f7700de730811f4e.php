<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot password - <?php echo e(config('app.name')); ?></title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('public/storage/'.config('settings.site_favicon'))); ?>" type="image/x-icon">
    <!-- Custom fonts for this template-->
    <link href="<?php echo e(asset('backend/vendor/fontawesome-free/css/all.min.css')); ?>" rel="stylesheet" type="text/css">
    <!-- Front CSS -->
    <link href="<?php echo e(asset('backend/css/font.css')); ?>" rel="stylesheet" type="text/css">
    <!-- DataTable CSS -->
    <link href="<?php echo e(asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="<?php echo e(asset('backend/css/sb-admin-2.min.css')); ?>" rel="stylesheet">
   </head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                        <p class="mb-4">We get it, stuff happens. Just enter your email address below
                                            and we'll send you a link to reset your password!</p>
                                    </div>
                                    <?php if(session('status')): ?>
                                        <div class="alert alert-success">
                                            <?php echo e(session('status')); ?>

                                        </div>
                                    <?php endif; ?>
                                    <form class="user" role="form" method="POST" action="<?php echo e(route('admin.password.email')); ?>"> 
                                    <?php echo csrf_field(); ?>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                name="email" placeholder="Enter Email Address..." autofocus value="<?php echo e(old('email')); ?>">
                                                <?php if($errors->has('email')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                                            </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Reset Password
</button>
                                    </form>
                                    <hr>
                                    <!-- <div class="text-center">
                                        <a class="small" href="register.html">Create an Account!</a>
                                    </div> -->
                                    <div class="text-center">
                                        <a class="small" href="<?php echo e(route('admin.login')); ?>"> Go Back Login </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

<!-- Bootstrap core JavaScript-->
<script src="<?php echo e(asset('backend/vendor/jquery/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?php echo e(asset('backend/vendor/jquery-easing/jquery.easing.min.js')); ?>"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?php echo e(asset('backend/js/sb-admin-2.min.js')); ?>"></script>
    <!-- Page level plugins -->

</body>

</html><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/auth/passwords/admin-email.blade.php ENDPATH**/ ?>