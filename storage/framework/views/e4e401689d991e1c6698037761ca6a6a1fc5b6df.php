
<?php $__env->startSection('content'); ?>

<div class="tile">
    <div class="tile-header">
                <div class="row mb-4">
            <div class="col-md-6">
                <img src="<?php echo e(asset('public/storage/' . $shareholder->image)); ?>" alt="Company Logo" style="max-height: 80px;">
            </div>
            <div class="col-md-6 text-right">
                <h4><strong>INNOVA Computers BD</strong></h4>
                <p class="mb-1">Masterpara, Charbata, Subarnachar, Noakhali.</p>
                <p class="mb-1"><i class="fa fa-phone"></i> +880 1844 463 963, +880 1817 682 323</p>
                <p><i class="fa fa-envelope"></i> innovacomputersbd@gmail.com</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="text-center"><strong>Investment Statement</strong></h2>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <p><strong>Investor ID:</strong> <?php echo e($shareholder->id); ?></p>
                <p><strong>Investor Name:</strong> <?php echo e($shareholder->name); ?></p>
                <p><strong>Total Investment:</strong> <?php echo e(number_format($totalInvestment, 2)); ?></p>
                <p><strong>Total Withdrawn:</strong> <?php echo e(number_format($totalWithdrawn, 2)); ?></p>
                <p><strong>Current Balance:</strong> <?php echo e(number_format($currentBalance, 2)); ?></p>
            </div>
            <div class="col-md-6 text-right">
                <p><strong>Generate at :</strong> <?php echo e(\Carbon\Carbon::now()->format('d-m-Y')); ?></p>
                <p><strong>Phone :</strong> <?php echo e($shareholder->phone ?? 'N/A'); ?></p>
            </div>
        </div>
    </div>
    <div class="tile-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-light">
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th class="text-right">Deposit</th>
                        <th class="text-right">Withdrawal</th>
                        <th class="text-right">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($transactions->isEmpty()): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">No transactions found</td>
                    </tr>
                    <?php else: ?>
                        <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $txn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <?php if(is_string($txn['date'])): ?>
                                    <?php echo e(\Carbon\Carbon::parse($txn['date'])->format('d-M-Y')); ?>

                                <?php else: ?>
                                    <?php echo e($txn['date']->format('d-M-Y')); ?>

                                <?php endif; ?>
                            </td>
                            <td>
                                <?php echo e($txn['description']); ?>

                                <?php if($txn['ref_type'] == 'investment'): ?>
                                    <a href="<?php echo e(route('admin.investment.detail', $txn['id'])); ?>" class="btn btn-sm btn-info" target="_blank" title="View Investment"><i class="fa fa-eye"></i></a>
                                <?php elseif($txn['ref_type'] == 'withdraw'): ?>
                                    <a href="<?php echo e(route('admin.investment.withdraw.view', $txn['id'])); ?>" class="btn btn-sm btn-warning" target="_blank" title="View Withdrawal"><i class="fa fa-eye"></i></a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($txn['type'] == 'Deposit'): ?>
                                    <span class="badge badge-success">Deposit</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Withdrawal</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-right">
                                <?php if($txn['debit'] > 0): ?>
                                    <strong class="text-success"><?php echo e(number_format($txn['debit'], 2)); ?></strong>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td class="text-right">
                                <?php if($txn['credit'] > 0): ?>
                                    <strong class="text-danger"><?php echo e(number_format($txn['credit'], 2)); ?></strong>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td class="text-right font-weight-bold">
                                <?php echo e(number_format($txn['balance'], 2)); ?>

                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </tbody>
                <tfoot class="bg-light font-weight-bold">
                    <tr>
                        <td colspan="3" class="text-right">Total:</td>
                        <td class="text-right text-success">
                            <?php echo e(number_format($transactions->sum('debit'), 2)); ?>

                        </td>
                        <td class="text-right text-danger">
                            <?php echo e(number_format($transactions->sum('credit'), 2)); ?>

                        </td>
                        <td class="text-right">
                            <?php
                                $finalBalance = $transactions->sum('debit') - $transactions->sum('credit');
                            ?>
                            <?php echo e(number_format($finalBalance, 2)); ?>

                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="<?php echo e(route('admin.investment.view', $shareholder->id)); ?>" class="btn btn-secondary">Back to Investments</a>
    <button onclick="window.print()" class="btn btn-primary">Print Statement</button>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<style>
    @media  print {
        .btn-secondary, .btn-primary, body > nav, body > .sidebar, .btn-info, .btn-warning, .sidebar { 
            display: none; 
        }
        .table { font-size: 12px; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/investment/statement.blade.php ENDPATH**/ ?>