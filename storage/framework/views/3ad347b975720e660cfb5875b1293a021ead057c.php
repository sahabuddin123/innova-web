
 
<?php $__env->startSection('title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>
 
<?php $__env->startSection('content'); ?>
     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-users"></i> <?php echo e($pageTitle); ?></h1>
        </div>
        <div>
        <a href="<?php echo e(route('admin.batchs.create')); ?>" class="btn btn-primary pull-right">Add Batchs</a>
        </div>
    </div>
    <div id="flash_message"></div>
    <?php echo $__env->make('admin.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body overflow-auto">
                    <table class="table table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Batch Name </th>
                                <th> Total Seat </th>
                                <th> Start Date </th>
                                <th> End Date </th>
                                
                                <th> Status </th>
                                <th> Create At </th>
                                <th> Last Update </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $batchs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->index+1); ?></td>
                                        <td><?php echo e($course->batchnum); ?></td>
                                        <td><?php echo e($course->totalseat); ?> </td>
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
                                                $status = "<span class='text-danger'>Postponed</span>";
                                            }
                                            elseif($course->IsActive == 1){
                                                $status = "<span class='text-success'>Running</span>";
                                            }
                                            elseif($course->IsActive == 2){
                                                $status = "<span class='text-info'>Upcomming</span>";
                                            }
                                            elseif($course->IsActive == 3){
                                                $status = "<span class='text-primary'>Complete</span>";
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
                                                <?php if($course->IsActive != 2): ?>
                                                 <a href="<?php echo e(route('admin.batchs.view', $course->id)); ?>" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a> 
                                                <?php endif; ?>
                                                <a href="<?php echo e(route('admin.batchs.edit', $course->id)); ?>" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                <a href="<?php echo e(route('admin.batchs.delete', $course->id)); ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                                <div class="dropdown">
                                                    <a href="#" class="btn btn-sm btn-primary dropdown-toggle" id="sms-menu" data-toggle="dropdown"><i class="fas fa-envelope"></i> </a>
                                                    <div class="dropdown-menu" aria-labelledby="#sms-menu">
                                                        <a href="javascript:void(0)" id="groupDuesms" data-id="<?php echo e($course->id); ?>" value="<?php echo e($course->id); ?>" class="dropdown-item" title="Send Due SMS">Due Remainder</a>
                                                        <a href="javascript:void(0)" id="grouptodayremainder" data-id="<?php echo e($course->id); ?>" value="<?php echo e($course->id); ?>" class="dropdown-item" title="Class Remainder">Today Class Remainder</a>
                                                        <a href="javascript:void(0)" id="groupnewschedule" data-id="<?php echo e($course->id); ?>" value="<?php echo e($course->id); ?>" class="dropdown-item" title="New Class Schedule">New Schedule Remainder</a>
                                                        <a href="javascript:void(0)" id="groupTodayPostpond" data-id="<?php echo e($course->id); ?>" value="<?php echo e($course->id); ?>" class="dropdown-item" title="Today Class Postponded">Today Postpond Remainder</a>
                                                        <a href="javascript:void(0)" id="groupTomorrowPostpond" data-id="<?php echo e($course->id); ?>" value="<?php echo e($course->id); ?>" class="dropdown-item" title="Tomorrow Class Postponded">Tomorrow Postpond Remainder</a> 
                                                    </div>
                                                </div>
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
<script type="text/javascript" src="<?php echo e(asset('backend/js/custom.js')); ?>"></script> 
    <script type="text/javascript" src="<?php echo e(asset('backend/vendor/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')); ?>"></script>
    <script type="text/javascript">$('#sampleTable').DataTable({order: [[0, 'desc']],});</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/batchs/index.blade.php ENDPATH**/ ?>