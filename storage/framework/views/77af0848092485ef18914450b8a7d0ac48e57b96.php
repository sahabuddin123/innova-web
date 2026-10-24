<?php
    $errors = Session::get('error');
    $messages = Session::get('success');
    $info = Session::get('info');
    $warnings = Session::get('warning');

    $errorList = is_array($errors) ? $errors : ($errors ? [$errors] : []);
    $messageList = is_array($messages) ? $messages : ($messages ? [$messages] : []);
    $infoList = is_array($info) ? $info : ($info ? [$info] : []);
    $warningList = is_array($warnings) ? $warnings : ($warnings ? [$warnings] : []);
?>

<?php if($errorList): ?>
    <?php $__currentLoopData = $errorList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button class="close" type="button" data-dismiss="alert">×</button>
            <strong>Error!</strong> <?php echo e($value); ?>

        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php if($messageList): ?>
    <?php $__currentLoopData = $messageList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button class="close" type="button" data-dismiss="alert">×</button>
            <strong>Success!</strong> <?php echo e($value); ?>

        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php if($infoList): ?>
    <?php $__currentLoopData = $infoList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="alert alert-info alert-dismissible" role="alert">
            <button class="close" type="button" data-dismiss="alert">×</button>
            <strong>Info!</strong> <?php echo e($value); ?>

        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php if($warningList): ?>
    <?php $__currentLoopData = $warningList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button class="close" type="button" data-dismiss="alert">×</button>
            <strong>Warning!</strong> <?php echo e($value); ?>

        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH C:\wamp64\www\innova-web\resources\views/admin/partials/flash.blade.php ENDPATH**/ ?>