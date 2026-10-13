
 
<?php $__env->startSection('title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>
 
<?php $__env->startSection('content'); ?>
     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-users"></i> <?php echo e($pageTitle); ?></h1>
        </div>
        <div>
            <a href="<?php echo e(route('admin.shareholder.index')); ?>" class="btn btn-primary pull-right">All Investor</a>
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
                                <th> Documents</th>
                                <th> Investor Name </th>
                                <th> Pay Amount </th>
                                <th> Pay Date </th>
                                <th> Status </th>
                                
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $invesments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fees): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td width='7%'><?php echo e($fees->id); ?></td>
                                        <td>
                                            <?php if($fees->image != null): ?>
                                            <img src="<?php echo asset('public/storage/'.$fees->image); ?>" alt="!"  height="35">
                                            <?php else: ?>
                                            Documents Not Added
                                            <?php endif; ?>
                                        </td>
                                        
                                        <td><?php echo e($fees->ShareHolderInfo->first()->name); ?> </td>
                                        <td><?php echo e(number_format($fees->amount, 2)); ?> </td>
                                        <td>
                                        <?php
                                            $date = strtotime($fees->paiddate);
                                            $createDate = date('d-M-y', $date);
                                        ?>
                                            <?php echo e($createDate); ?>

                                        </td>
                                        <td>
                                            <?php if($fees->isActive == 1): ?>
                                               <b><span class='text-success'>Approved</span></b>
                                            
                                            <?php elseif($fees->isActive == 2): ?>
                                               <b><span class='text-info'>Pending</span></b>
                                            
                                            <?php elseif($fees->isActive == 3): ?>
                                                <b><span class='text-primary'>Postponded</span></b>
                                            
                                            <?php elseif($fees->isActive == 0): ?>
                                                <b><span class='text-danger'>Waiting for approval</span></b>
                                            
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                <a href="<?php echo e(route('admin.investment.edit', $fees->id)); ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                                <a href="<?php echo e(route('admin.investment.delete', $fees->id)); ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/investment/fees.blade.php ENDPATH**/ ?>