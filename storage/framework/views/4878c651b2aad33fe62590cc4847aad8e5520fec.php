

<?php $__env->startSection('title'); ?>
    <?php echo e($pageTitle); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-users"></i> <?php echo e($pageTitle); ?></h1>
        </div>
        <div>
            
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
                                <th> Image </th>
                                <th> Students name </th>
                                <th> Batch No </th>
                                <th> Technical Board Session </th>
                                <th> Registration No </th>
                                <th> Certificate Image </th>
                                <th> Delivery Image </th>
                                <th> Status </th>
                                <th> Last Update </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i
                                        class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $certificate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->index + 1); ?></td>
                                    <td><img src="<?php echo asset('public/storage/' . $course->StudentsInfo->image); ?>" alt="!" height="90"></td>
                                    <td><?php echo e($course->StudentsInfo->sname); ?> </td>
                                    <td>
                                        <?php
                                            $batchno = DB::table('batchs')
                                                ->where('id', $course->StudentsInfo->batch_id)
                                                ->pluck('batchnum')
                                                ->first();
                                        ?>
                                        <?php echo e($batchno); ?>

                                    </td>
                                    <td>
                                        <?php echo e($course->StudentsSessions->sessionName); ?>

                                    </td>
                                    <td>
                                        <?php echo e($course->regNo); ?>

                                    </td>
                                    <td>
                                        <img src="<?php echo asset('public/storage/' . $course->cimage); ?>" alt="!" height="90">
                                    </td>
                                    <td>
                                        <img src="<?php echo asset('public/storage/' . $course->dimage); ?>" alt="!" height="90">
                                    </td>
                                    <td>
                                        <?php
                                            if ($course->IsActive == 1) {
                                                $status = "<span class='text-success'>Deliverd</span>";
                                            } elseif ($course->IsActive == 2) {
                                                $status = "<span class='text-info'>Waiting For Delivery</span>";
                                            } elseif ($course->IsActive == 3) {
                                                $status = "<span class='text-warning'>Printing Queie</span>";
                                            } elseif ($course->IsActive == 4) {
                                                $status = "<span class='text-danger'>Cancle</span>";
                                            }
                                        ?>
                                        <b><?php echo $status; ?></b>
                                    </td>
                                    <td>
                                        <?php
                                            $date = strtotime($course->updated_at);
                                            $updateDate = date('d-M-y h:s a', $date);
                                        ?>
                                        <?php echo e($updateDate); ?>

                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Second group">
                                            <a href="<?php echo e(route('admin.certificate.view', $course->id)); ?>"
                                                class="btn btn-sm btn-info" title="View Student"><i
                                                    class="fa fa-eye"></i></a>
                                            <a href="<?php echo e(route('admin.certificate.edit', $course->id)); ?>"
                                                class="btn btn-sm btn-primary" title="Edit Student Information"><i
                                                    class="fa fa-edit"></i></a>
                                            <?php
                                                $deleteData = [
                                                    'id' => $course->id,
                                                    'student_id' => $course->student_id,
                                                ];
                                            ?>
                                            <a href="<?php echo e(route('admin.certificate.delete', $deleteData)); ?>"
                                                class="btn btn-sm btn-danger" title="Delete Student Information"><i
                                                    class="fa fa-trash"></i></a>
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
            order: [
                [1, 'desc']
            ],
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/certificate/index.blade.php ENDPATH**/ ?>