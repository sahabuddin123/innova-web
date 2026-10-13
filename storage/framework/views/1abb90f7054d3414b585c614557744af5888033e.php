
 
<?php $__env->startSection('title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>
 
<?php $__env->startSection('content'); ?>
     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-book-open"></i> <?php echo e($pageTitle); ?></h1>
        </div>
        <div>
        <a href="<?php echo e(route('admin.courses.create')); ?>" class="btn btn-primary pull-right">Add Courses</a>
        </div>
    </div>
    <?php echo $__env->make('admin.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body overflow-auto">
                    <table class="table table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Featured Image </th>
                                <th> Course Name </th>
                                <th> Course Durations </th>
                                <th> Total Moduls </th>
                                <th> Course Fee </th>
                                <th> Create At </th>
                                <th> Last Update </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->index+1); ?></td>
                                        <td><img src="<?php echo asset('public/storage/'.$course->image); ?>" alt="!"  height="50"></td>
                                        <td><?php echo e($course->name); ?></td>
                                        <td><?php echo e($course->courseduration); ?> Months</td>
                                        <td><?php echo e($course->totalmoduls); ?></td>
                                        <td><?php echo e($course->coursefee); ?> <?php echo e(config('settings.currency_code')); ?></td>
                                        <td>
                                            <?php
                                            $createDate = date_format($course->created_at, 'd-M-Y');
                                            ?>
                                            <?php echo e($createDate); ?>

                                        </td>
                                        <td>
                                        <?php
                                            $updateDate = date_format($course->updated_at, 'd-M-Y');
                                            ?>
                                            <?php echo e($updateDate); ?>

                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                <a href="<?php echo e(route('admin.courses.view', $course->id)); ?>" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                                <a href="<?php echo e(route('admin.courses.edit', $course->id)); ?>" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                <a href="<?php echo e(route('admin.courses.delete', $course->id)); ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript" src="<?php echo e(asset('backend/vendor/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')); ?>"></script>
    <script type="text/javascript">$('#sampleTable').DataTable({order: [[1, 'desc']],});</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/courses/index.blade.php ENDPATH**/ ?>