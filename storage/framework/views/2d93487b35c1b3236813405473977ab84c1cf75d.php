
 
<?php $__env->startSection('title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>
 
<?php $__env->startSection('content'); ?>
     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-book-open"></i> <?php echo e($subTitle); ?></h1>
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
                                <th> Student Name </th>
                                <th> Course Name </th>
                                <th> Phone </th>
                                <th> Email </th>
                                <th> Class Type </th>
                                <th> Status </th>
                                <th> Admission At </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $admission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->index+1); ?></td>
                                        <td><?php echo e($course->username); ?></td>
                                        <td><?php echo e($course->CourseInfo->first()->name); ?></td>
                                        <td><?php echo e($course->phone); ?></td>
                                        <td><?php echo e($course->email); ?> </td>
                                        <td>
                                            <?php if($course->courseType == 0): ?>
                                               <b><span class="text-primary">Offline</span></b>
                                            <?php elseif($course->courseType == 1): ?>
                                                <b><span class="text-info">online</span></b>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($course->isActive == 0): ?>
                                                <b><span class="text-warning">Waiting for Contact</span></b>
                                            <?php elseif($course->isActive == 1): ?>
                                                <b><span class="text-info">Call Not received</span></b>
                                            <?php elseif($course->isActive == 2): ?>
                                                <b><span class="text-success">Waiting For Admission</span></b>
                                            <?php elseif($course->isActive == 3): ?>
                                                <b><span class="text-primary">Admission Complete</span></b>
                                            <?php elseif($course->isActive == 4): ?>
                                            <b><span class="text-primary">SMS Send</span></b>
                                            <?php elseif($course->isActive == 5): ?>
                                                <b><span class="text-primary">Not Interested</span></b>
                                            <?php elseif($course->isActive == 6): ?>
                                                <b><span class="text-primary">Restricted</span></b>
                                            <?php endif; ?> 
                                        </td>
                                        <td>
                                            <?php
                                            $createDate = date_format($course->created_at, 'd-M-Y');
                                            ?>
                                            <?php echo e($createDate); ?>

                                        </td>
                                        
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                
                                                <a href="<?php echo e(route('admin.admission.edit', $course->id)); ?>" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                
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
<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/admission/index.blade.php ENDPATH**/ ?>