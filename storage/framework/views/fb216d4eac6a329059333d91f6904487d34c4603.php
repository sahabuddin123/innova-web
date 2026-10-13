

<?php $__env->startSection('title'); ?>
    <?php echo e($pageTitle); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-certificate"></i> <?php echo e($pageTitle); ?></h1>
        </div>
    </div>
    <?php echo $__env->make('admin.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body overflow-auto">
                    <table class="table table-bordered table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Image</th>
                                <th>Student Name</th>
                                <th>Batch No</th>
                                <th>Certificate No</th>
                                <th>Issue Date</th>
                                <th>Receiver</th>
                                <th>Delivery Date</th>
                                <th>Status</th>
                                <th>Last Update</th>
                                <th style="width:100px;" class="text-center text-danger"><i class="fa fa-bolt"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $certificates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td>
                                        <img src="<?php echo e(asset('public/storage/' . $course->student->image)); ?>" 
                                             alt="Student" height="60">
                                    </td>
                                    <td><?php echo e($course->student->sname); ?></td>
                                    <td>
                                        <?php
                                            $batchno = DB::table('batchs')
                                                ->where('id', $course->batch_id)
                                                ->pluck('batchnum')
                                                ->first();
                                        ?>
                                        <?php echo e($batchno); ?>

                                    </td>
                                    <td><?php echo e($course->certificate_no); ?></td>
                                    <td><?php echo e($course->issue_date ? date('d-M-Y', strtotime($course->issue_date)) : '-'); ?></td>
                                    <td><?php echo e($course->certificate_receiver ?? '-'); ?></td>
                                    <td><?php echo e($course->delivery_date ? date('d-M-Y', strtotime($course->delivery_date)) : '-'); ?></td>
                                    <td>
                                        <?php
                                            $status = '';
                                            if ($course->is_active == 1) {
                                                $status = "<span class='badge badge-success'>Delivered</span>";
                                            } elseif ($course->is_active == 2) {
                                                $status = "<span class='badge badge-info'>Waiting</span>";
                                            } elseif ($course->is_active == 3) {
                                                $status = "<span class='badge badge-warning'>Printing Queue</span>";
                                            } elseif ($course->is_active == 4) {
                                                $status = "<span class='badge badge-danger'>Cancelled</span>";
                                            }
                                        ?>
                                        <?php echo $status; ?>

                                    </td>
                                    <td><?php echo e(date('d-M-y h:i a', strtotime($course->updated_at))); ?></td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('admin.certificate_icbd.view', $course->id)); ?>"
                                               class="btn btn-sm btn-info" title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.certificate_icbd.edit', $course->id)); ?>"
                                               class="btn btn-sm btn-primary" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <?php
                                                $deleteData = [
                                                    'id' => $course->id,
                                                    'student_id' => $course->student_id,
                                                ];
                                            ?>
                                            <a href="<?php echo e(route('admin.certificate_icbd.delete', $deleteData)); ?>"
                                               class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </a>
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
    <script type="text/javascript">
        $('#sampleTable').DataTable({
            order: [[0, 'asc']],
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/certificate_icbd/index.blade.php ENDPATH**/ ?>