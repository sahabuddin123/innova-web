
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between mb-3">
    <h1 class="h3 page-title">EMI Payment Statement</h1>
    <button class="btn btn-secondary" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
</div>

<div class="card" id="printArea">
    <!-- Header -->
    <div class="card-body border-bottom">
        <div class="row">
            <div class="col-md-3 text-center">
                <h5><strong><?php echo e(config('settings.site_name')); ?></strong></h5>
                
                <p class="small">Head Office: Masterpara, Charbata, Subarnachar, Noakhali, Bangladesh</p>
            </div>
            <div class="col-md-6 text-center">
                <h4><strong>EMI PAYMENT STATEMENT</strong></h4>
                <p class="small">As on <?php echo e(Carbon\Carbon::now()->format('d-M-Y')); ?></p>
            </div>
            <div class="col-md-3 text-right">
                <p><strong>Statement ID:</strong> EMI-<?php echo e($loan->id); ?></p>
                <p><strong>Loan ID:</strong> <?php echo e($loan->id); ?></p>
            </div>
        </div>
    </div>

    <!-- Shareholder Details -->
    <div class="card-body border-bottom">
        <h5>Shareholder Information</h5>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Name:</strong> <?php echo e($loan->shareholder->name ?? 'N/A'); ?></p>
                <p><strong>Code:</strong> <?php echo e($loan->shareholder->shareholder_code ?? 'N/A'); ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Contact:</strong> <?php echo e($loan->shareholder->contact ?? 'N/A'); ?></p>
                <p><strong>Email:</strong> <?php echo e($loan->shareholder->email ?? 'N/A'); ?></p>
            </div>
        </div>
    </div>

    <!-- Loan Details -->
    <div class="card-body border-bottom">
        <h5>Loan Details</h5>
        <div class="row">
            <div class="col-md-6">
                <table class="table table-sm">
                    <tr>
                        <td><strong>Bank Name:</strong></td>
                        <td><?php echo e($loan->bank_name); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Loan Amount:</strong></td>
                        <td><?php echo e(number_format($loan->loan_amount, 2)); ?> BDT</td>
                    </tr>
                    <tr>
                        <td><strong>Interest Rate:</strong></td>
                        <td><?php echo e($loan->interest_rate); ?>% p.a.</td>
                    </tr>
                    <tr>
                        <td><strong>Loan Date:</strong></td>
                        <td><?php echo e($loan->loan_date ? $loan->loan_date->format('d-M-Y') : '-'); ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-sm">
                    <tr>
                        <td><strong>Maturity Date:</strong></td>
                        <td><?php echo e($loan->maturity_date ? $loan->maturity_date->format('d-M-Y') : '-'); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Loan Term:</strong></td>
                        <td><?php echo e($loan->loan_term_months); ?> months</td>
                    </tr>
                    <tr>
                        <td><strong>Installment Count:</strong></td>
                        <td><?php echo e($loan->installment_count); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
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
    </div>

    <!-- EMI Payment History -->
    <div class="card-body border-bottom">
        <h5>EMI Payment Details</h5>
        <table class="table table-bordered table-sm">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Payment Date</th>
                    <th>EMI Amount</th>
                    <th>Status</th>
                    <th>Paid At</th>
                    <th>Paid By</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $loan->emiInstallments()->orderBy('payment_date')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $emi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($index + 1); ?></td>
                        <td><?php echo e($emi->payment_date ? $emi->payment_date->format('d-M-Y') : '-'); ?></td>
                        <td class="text-right"><strong><?php echo e(number_format($emi->emi_amount, 2)); ?></strong></td>
                        <td>
                            <?php if($emi->status == 'paid'): ?>
                                <span class="badge badge-success">Paid</span>
                            <?php elseif($emi->status == 'pending'): ?>
                                <span class="badge badge-warning">Pending</span>
                            <?php else: ?>
                                <span class="badge badge-secondary"><?php echo e(ucfirst($emi->status)); ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($emi->paid_at ? $emi->paid_at->format('d-M-Y H:i') : '-'); ?></td>
                        <td><?php echo e($emi->receivedByUser->name ?? '-'); ?></td>
                        <td><?php echo e($emi->remarks ?? '-'); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">No EMI records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tfoot class="table-light">
                <tr>
                    <th colspan="2" class="text-right">TOTAL EMI PAID:</th>
                    <th class="text-right"><strong><?php echo e(number_format($totalPaid, 2)); ?> BDT</strong></th>
                    <th colspan="4"></th>
                </tr>
                <tr>
                    <th colspan="2" class="text-right">TOTAL INTEREST:</th>
                    <th class="text-right"><strong><?php echo e(number_format($totalInterest, 2)); ?> BDT</strong></th>
                    <th colspan="4"></th>
                </tr>
                <tr>
                    <th colspan="2" class="text-right">REMAINING EMI:</th>
                    <th class="text-right"><strong><?php echo e(number_format($remainingEmi, 2)); ?> BDT</strong></th>
                    <th colspan="4"></th>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Summary Section -->
    <div class="card-body">
        <h5>Summary</h5>
        <div class="row">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>Total Installments</h6>
                        <h4><?php echo e($loan->installment_count); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>EMI Paid</h6>
                        <h4 class="text-success"><?php echo e(number_format($totalPaid, 2)); ?> BDT</h4>
                        <small><?php echo e($paidInstallments); ?> installments</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>Pending EMI</h6>
                        <h4 class="text-warning"><?php echo e(number_format($remainingEmi, 2)); ?> BDT</h4>
                        <small><?php echo e($pendingInstallments); ?> installments</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>Total Interest</h6>
                        <h4 class="text-danger"><?php echo e(number_format($totalInterest, 2)); ?> BDT</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3 no-print">
    <a href="<?php echo e(route('admin.bank.loan.index')); ?>" class="btn btn-secondary">Back</a>
</div>

<style>
    @media  print {
        .sidebar, .page-title { display: none !important; }
        .navbar { display: none !important; }
        .btn { display: none !important; }
        .no-print { display: none !important; }
        body { margin: 0; padding: 0; background: white; }
        .card { border: none; box-shadow: none; }
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/bank_loan/emi_statement.blade.php ENDPATH**/ ?>