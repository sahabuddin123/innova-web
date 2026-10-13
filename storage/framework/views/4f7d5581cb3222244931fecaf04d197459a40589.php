
 
<?php $__env->startSection('title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>
 
<?php $__env->startSection('content'); ?>
     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-cogs"></i> <?php echo e($pageTitle); ?></h1>
    </div>
    <?php echo $__env->make('admin.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row user">
        <div class="col-md-3">
            <div class="tile p-0">
                <ul class="nav flex-column nav-tabs user-tabs">
                    <li class="nav-item border"><a class="nav-link" href="#general" data-toggle="tab">General</a></li>
                    <li class="nav-item border"><a class="nav-link" href="#ui-theme" data-toggle="tab">UI/Theme</a></li>
                    <li class="nav-item border"><a class="nav-link" href="#site-logo" data-toggle="tab">Site Logo</a></li>
                    <li class="nav-item border"><a class="nav-link" href="#footer-seo" data-toggle="tab">Footer &amp; SEO</a></li>
                    <li class="nav-item border"><a class="nav-link" href="#social-links" data-toggle="tab">Social Links</a></li>
                    <li class="nav-item border"><a class="nav-link" href="#analytics" data-toggle="tab">Analytics</a></li>
                    <li class="nav-item border"><a class="nav-link" href="#payments" data-toggle="tab">Payments</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <div class="tab-content">
                <div class="tab-pane active" id="general">
                    <?php echo $__env->make('admin.settings.includes.general', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="tab-pane fade" id="ui-theme">
                    <?php echo $__env->make('admin.settings.includes.ui_theme', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="tab-pane fade" id="site-logo">
                    <?php echo $__env->make('admin.settings.includes.logo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="tab-pane fade" id="footer-seo">
                    <?php echo $__env->make('admin.settings.includes.footer_seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="tab-pane fade" id="social-links">
                    <?php echo $__env->make('admin.settings.includes.social_links', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="tab-pane fade" id="analytics">
                    <?php echo $__env->make('admin.settings.includes.analytics', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="tab-pane fade" id="payments">
                    <?php echo $__env->make('admin.settings.includes.payments', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/settings/index.blade.php ENDPATH**/ ?>