

<?php $__env->startSection('content'); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-users"></i> <?php echo e($pageTitle); ?></h1>
    <div class="pull-right">
        <a class="btn btn-primary" href="<?php echo e(route('admin.admins.index')); ?>"> Back</a>
    </div>
</div>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="tile">
        <div class="form-group">
            <strong>Name:</strong>
            <?php echo e($user->name); ?>

        </div>
        <div class="form-group">
            <strong>Email:</strong>
            <?php echo e($user->email); ?>

        </div>
        <div class="form-group">
            <strong>Roles:</strong>
            <?php if(!empty($user->getRoleNames())): ?>
                <?php $__currentLoopData = $user->getRoleNames(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label class="badge badge-success"><?php echo e($v); ?></label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/admins/show.blade.php ENDPATH**/ ?>