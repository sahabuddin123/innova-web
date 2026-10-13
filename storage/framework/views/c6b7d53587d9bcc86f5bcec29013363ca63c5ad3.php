
<?php $__env->startSection('title'); ?> Student List <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Students</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>
    <!-- Content Row -->
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- 404 Error Text -->
<div class="text-center">
    <div class="error mx-auto" data-text="404">404</div>
    <p class="lead text-gray-800 mb-5">Students Not Found</p>
    <p class="text-gray-500 mb-0">It looks like you found a glitch in the matrix...</p>
    <a href="<?php echo e(route('admin.dashboard')); ?>">&larr; Back to Dashboard</a>
</div>

</div>
<!-- /.container-fluid -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/students/404.blade.php ENDPATH**/ ?>