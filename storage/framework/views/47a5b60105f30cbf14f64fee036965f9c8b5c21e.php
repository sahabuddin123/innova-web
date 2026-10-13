
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between mb-3">
    <h1 class="h3">Bank Loan Details</h1>
</div>
<?php echo $__env->make('admin.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-sm table-bordered">
                    <tr>
                        <th>Loan ID:</th>
                        <td><?php echo e($loan->id); ?></td>
                    </tr>
                    <tr>
                        <th>Shareholder:</th>
                        <td><?php echo e($loan->shareholder->name ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Bank Name:</th>
                        <td><strong><?php echo e($loan->bank_name); ?></strong></td>
                    </tr>
                    <tr>
                        <th>Loan Amount:</th>
                        <td><strong><?php echo e(number_format($loan->loan_amount, 2)); ?> BDT</strong></td>
                    </tr>
                    <tr>
                        <th>Interest Rate:</th>
                        <td><?php echo e($loan->interest_rate); ?>%</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-sm table-bordered">
                    <tr>
                        <th>Loan Date:</th>
                        <td><?php echo e($loan->loan_date ? $loan->loan_date->format('d-M-Y') : '-'); ?></td>
                    </tr>
                    <tr>
                        <th>Maturity Date:</th>
                        <td><?php echo e($loan->maturity_date ? $loan->maturity_date->format('d-M-Y') : '-'); ?></td>
                    </tr>
                    <tr>
                        <th>Loan Term:</th>
                        <td><?php echo e($loan->loan_term_months); ?> months</td>
                    </tr>
                    <tr>
                        <th>Installment Count:</th>
                        <td><?php echo e($loan->installment_count); ?></td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            <?php if($loan->status == 'active'): ?>
                                <span class="badge badge-success">Active</span>
                            <?php else: ?>
                                <span class="badge badge-secondary"><?php echo e(ucfirst($loan->status)); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <hr>

        <h5>EMI Summary</h5>
        <div class="row">
            <div class="col-md-3">
                <div class="card text-center bg-light">
                    <div class="card-body">
                        <h6>Total Installments</h6>
                        <h3><?php echo e($loan->emiInstallments()->count()); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center bg-light">
                    <div class="card-body">
                        <h6>Paid Installments</h6>
                        <h3 class="text-success"><?php echo e($loan->paidInstallments()->count()); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center bg-light">
                    <div class="card-body">
                        <h6>Pending Installments</h6>
                        <h3 class="text-warning"><?php echo e($loan->pendingInstallments()->count()); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center bg-light">
                    <div class="card-body">
                        <h6>Total Savings</h6>
                        <h3 class="text-info"><?php echo e(number_format($loan->totalSavings(), 2)); ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="<?php echo e(route('admin.bank.loan.edit', $loan->id)); ?>" class="btn btn-warning">Edit</a>
    <a href="<?php echo e(route('admin.bank.loan.statement', $loan->id)); ?>" class="btn btn-success">View Statement</a>
    <a href="<?php echo e(route('admin.bank.loan.index')); ?>" class="btn btn-secondary">Back</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/bank_loan/show.blade.php ENDPATH**/ ?>