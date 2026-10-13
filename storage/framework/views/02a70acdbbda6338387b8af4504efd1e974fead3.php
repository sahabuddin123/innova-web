
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between mb-3">
    <h1 class="h3">Bank Loans</h1>
    <a href="<?php echo e(route('admin.bank.loan.create')); ?>" class="btn btn-primary">New Loan</a>
</div>
<?php echo $__env->make('admin.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-light">
                    <tr>
                        <th>#</th>
                        <th>Shareholder</th>
                        <th>Bank Name</th>
                        <th>Loan Amount</th>
                        <th>Interest Rate</th>
                        <th>Loan Date</th>
                        <th>Maturity Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($loan->id); ?></td>
                        <td><?php echo e($loan->shareholder->name ?? 'N/A'); ?></td>
                        <td><?php echo e($loan->bank_name); ?></td>
                        <td><?php echo e(number_format($loan->loan_amount, 2)); ?></td>
                        <td><?php echo e($loan->interest_rate); ?>%</td>
                        <td><?php echo e($loan->loan_date ? $loan->loan_date->format('d-M-Y') : '-'); ?></td>
                        <td><?php echo e($loan->maturity_date ? $loan->maturity_date->format('d-M-Y') : '-'); ?></td>
                        <td>
                            <?php if($loan->status == 'active'): ?>
                                <span class="badge badge-success"><?php echo e(ucfirst($loan->status)); ?></span>
                            <?php elseif($loan->status == 'completed'): ?>
                                <span class="badge badge-info"><?php echo e(ucfirst($loan->status)); ?></span>
                            <?php else: ?>
                                <span class="badge badge-secondary"><?php echo e(ucfirst($loan->status)); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo e(route('admin.bank.loan.view', $loan->id)); ?>" class="btn btn-sm btn-info">View</a>
                            <a href="<?php echo e(route('admin.bank.loan.edit', $loan->id)); ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="<?php echo e(route('admin.bank.loan.statement', $loan->id)); ?>" class="btn btn-sm btn-success">Statement</a>
                            <a href="<?php echo e(route('admin.bank.loan.emi.statement', $loan->id)); ?>" class="btn btn-sm btn-success">EMI Statement</a>
                            <a href="<?php echo e(route('admin.bank.loan.savings.statement', $loan->id)); ?>" class="btn btn-sm btn-warning">Savings Statement</a>
                            <form style="display:inline" method="POST" action="<?php echo e(route('admin.bank.loan.delete', $loan->id)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted">No loans found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/bank_loan/index.blade.php ENDPATH**/ ?>