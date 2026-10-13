
<?php $__env->startSection('title'); ?>
    ওয়ার্কফ্লো - <?php echo e(config('settings.site_name')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- page title -->
<section class="page-title bg-primary">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white text-uppercase text-sm">আমাদের কাজের প্রক্রিয়া</span>
                    <h1 class="text-capitalize text-lg text-white mt-2">ওয়ার্কফ্লো</h1>
                    <a href="<?php echo e(route('frontend.home')); ?>" class="btn btn-main btn-white-btn">হোমে ফিরুন</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- section -->
<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <?php if($workflows->count() > 0): ?>
                <?php $__currentLoopData = $workflows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workflow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="workflow-item text-center p-4">
                        <div class="step-number mb-3"><?php echo e($workflow->step); ?></div>
                        <i class="<?php echo e($workflow->icon ?? 'fa fa-tasks'); ?> fa-3x mb-3"></i>
                        <h3><?php echo e($workflow->title); ?></h3>
                        <p><?php echo e($workflow->description); ?></p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p>কোনো ওয়ার্কফ্লো পাওয়া যায়নি।</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.v2.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/frontend/modules/workflow.blade.php ENDPATH**/ ?>