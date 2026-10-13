<div class="tile">
    <form action="<?php echo e(route('admin.settings.update')); ?>" method="POST" role="form" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <h3 class="tile-title">Site Logo</h3>
        <hr>
        <div class="tile-body">
            <div class="row">
                <div class="col-3">
                    <?php if(config('settings.site_logo') != null): ?>
                        <img src="<?php echo e(asset('public/storage/'.config('settings.site_logo'))); ?>" id="logoImg" style="width: 80px; height: auto;">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/80x80?text=Placeholder+Image" id="logoImg" style="width: 80px; height: auto;">
                    <?php endif; ?>
                </div>
                <div class="col-9">
                    <div class="form-group">
                        <label class="control-label">Site Logo</label>
                        <input class="form-control" type="file" name="site_logo" onchange="loadFile(event,'logoImg')"/>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-3">
                    <?php if(config('settings.site_favicon') != null): ?>
                        <img src="<?php echo e(asset('public/storage/'.config('settings.site_favicon'))); ?>" id="faviconImg" style="width: 80px; height: auto;">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/80x80?text=Placeholder+Image" id="faviconImg" style="width: 80px; height: auto;">
                    <?php endif; ?>
                </div>
                <div class="col-9">
                    <div class="form-group">
                        <label class="control-label">Site Favicon</label>
                        <input class="form-control" type="file" name="site_favicon" onchange="loadFile(event,'faviconImg')"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="tile-footer">
            <div class="row d-print-none mt-2">
                <div class="col-12 text-right">
                    <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Settings</button>
                </div>
            </div>
        </div>
    </form>
</div>
<?php $__env->startPush('scripts'); ?>
    <script>
        loadFile = function(event, id) {
            var output = document.getElementById(id);
            output.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/settings/includes/logo.blade.php ENDPATH**/ ?>