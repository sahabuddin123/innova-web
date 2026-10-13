

<?php $__env->startSection('title'); ?>
    <?php echo e($pageTitle); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo e($pageTitle); ?></h1>
        <a href="<?php echo e(route('admin.asset-training.courses.create')); ?>" class="btn btn-primary">Create Course</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="coursesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Level</th>
                            <th>Status</th>
                            <th>Registrations</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($loop->iteration); ?></td>
                                <td><?php echo e($course->name); ?></td>
                                <td><?php echo e($course->level ?? 'N/A'); ?></td>
                                <td><?php echo $course->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>'; ?></td>
                                <td><?php echo e($course->registrations()->count()); ?></td>
                                <td>
                                    <a href="<?php echo e(route('admin.asset-training.courses.edit', $course->id)); ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="<?php echo e(route('admin.asset-training.courses.delete', $course->id)); ?>" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this course?');">
                                        <?php echo csrf_field(); ?>
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <?php echo e($courses->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        $('#coursesTable').DataTable({
            responsive: true,
            paging: false,
            searching: true,
            info: false,
            order: [[0, 'desc']],
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/asset-training/courses/index.blade.php ENDPATH**/ ?>