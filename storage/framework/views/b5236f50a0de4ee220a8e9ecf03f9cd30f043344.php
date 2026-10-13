
 
<?php $__env->startSection('title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>
 
<?php $__env->startSection('content'); ?>
     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-calendar"></i> <?php echo e($pageTitle); ?></h1>
        </div>
        <div>
        <a href="<?php echo e(route('admin.session.create')); ?>" class="btn btn-primary pull-right">Add Session</a>
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
                                <th> Session Name </th>
                                <th> Start Date </th>
                                <th> End Date </th>
                                <th> Status </th>
                                <th> Create At </th>
                                <th> Last Update </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($course->id); ?></td>
                                        <td><?php echo e($course->sessionName); ?></td>
                                        <td>
                                            <?php
                                            $date = strtotime($course->startdate);
                                            $date = date("d-M-Y", $date);
                                            ?>
                                            <?php echo e($date); ?>

                                        </td>
                                        <td>
                                        <?php
                                        $date = strtotime($course->enddate);
                                            $enddate = date("d-M-Y", $date);
                                         ?>
                                         <?php echo e($enddate); ?>

                                        </td>
                                        <td>
                                            <?php
                                            if($course->IsActive == 0){
                                                $status = "<span class='text-warning'>Postponed</span>";
                                            }
                                            elseif($course->IsActive == 1){
                                                $status = "<span class='text-success'>Running</span>";
                                            }
                                            elseif($course->IsActive == 2){
                                                $status = "<span class='text-primary'>Upcomming</span>";
                                            }
                                            elseif($course->IsActive == 3){
                                                $status = "<span class='text-danger'>Complete</span>";
                                            }
                                            ?>
                                            <b><?php echo $status; ?></b>
                                        </td>
                                        <td>
                                        <?php
                                            $date = strtotime($course->created_at);
                                            $createDate = date('d-M-Y h:i A', $date);
                                        ?>
                                            <?php echo e($createDate); ?>

                                    </td>
                                        <td>
                                        <?php
                                            $date = strtotime($course->updated_at);
                                            $updateDate = date('d-M-Y h:i A', $date);
                                        ?>    
                                        <?php echo e($updateDate); ?>

                                    </td>
                                       
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                <a href="<?php echo e(route('admin.session.edit', $course->id)); ?>" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                <a href="<?php echo e(route('admin.session.delete', $course->id)); ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/session/index.blade.php ENDPATH**/ ?>