 
<?php $__env->startSection('title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>
 
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
                <div class="tile-body">
                    <table class="table table-bordered text-center" id="sampleTable">
                        <thead>
                            <tr>
                                <th> Tnx ID </th>
                                <th>Image</th>
                                <th> Student Name </th>
                                <th> Pay Amount </th>
                                <th> Remarks </th>
                                <th> Pay Date </th>
                                <th> Status </th>
                                
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $fee; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fees): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td width='7%'><?php echo e($fees->id); ?></td>
                                        <?php
                                        $students = DB::table('students')->where('id',$fees->student_id)->first();
                                        ?>
                                        <td><img src="<?php echo asset('public/storage/'.$students->image); ?>" alt="!"  height="35"></td>
                                        <td><?php echo e($students->sname); ?> </td>
                                        <td><?php echo e(number_format($fees->paidamount, 2)); ?> </td>
                                        <td>
                                            <?php if($fees->channel == 2): ?>
                                            <?php echo e($fees->trxID); ?>

                                            <?php else: ?>
                                            <?php echo e($fees->paidremark); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                        <?php
                                            $date = strtotime($fees->paiddate);
                                            $createDate = date('d-M-y', $date);
                                        ?>
                                            <?php echo e($createDate); ?>

                                        </td>
                                        <td>
                                        <?php if($fees->status == 0): ?>
                                            <form action="<?php echo e(route('FessStatus', $fees->id)); ?>" method="post">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="paidamount" value="<?php echo e($fees->paidamount); ?>">
                                                <input type="hidden" name="paymentType" value="<?php echo e($fees->paymentType); ?>">
                                                <input type="hidden" name="student_id" value="<?php echo e($fees->student_id); ?>">
                                                <button type="submit" class='btn btn-success' name="status" value="1">Approve</button>
                                            </form>
                                            <?php else: ?>
                                            <form action="<?php echo e(route('FessStatus', $fees->id)); ?>" method="post">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="paidamount" value="<?php echo e($fees->paidamount); ?>">
                                                <input type="hidden" name="paymentType" value="<?php echo e($fees->paymentType); ?>">
                                                <input type="hidden" name="student_id" value="<?php echo e($fees->student_id); ?>">
                                                <button type="submit" class='btn btn-danger' name="status" value="0">Pending</button>
                                            </form>
                                            <?php endif; ?>
                                        </td>
                                        
                                        
                                       
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                <a href="<?php echo e(route('admin.fees.payslip', $fees->id)); ?>" class="btn btn-sm btn-info" title="View Payslip"><i class="fas fa-file-invoice"></i></a>
                                                <a href="<?php echo e(route('admin.fees.payslip.download', $fees->id)); ?>" class="btn btn-sm btn-success" title="Download Payslip"><i class="fas fa-download"></i></a>
                                                <a href="<?php echo e(route('admin.fees.edit', $fees->id)); ?>" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
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
<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/payments/fees.blade.php ENDPATH**/ ?>