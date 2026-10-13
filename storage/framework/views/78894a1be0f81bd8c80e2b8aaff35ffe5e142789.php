<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between mb-3">
    <h1 class="h3">EMI Installments</h1>
    <a href="<?php echo e(route('admin.emi.installment.create')); ?>" class="btn btn-primary">+ Add New EMI</a>
</div>
<?php echo $__env->make('admin.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="card">
    <div class="card-body">
        <table class="table table-striped" id="emiTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Shareholder</th>
                    <th>Bank Name</th>
                    <th>EMI Amount</th>
                    <th>Savings Amount</th>
                    <th>Payment Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<!-- Mark as Paid Modal -->
<div class="modal fade" id="markPaidModal" tabindex="-1" role="dialog" aria-labelledby="markPaidModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="markPaidModalLabel">Mark EMI as Paid</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="markPaidForm">
                    <div class="form-group">
                        <label for="paymentDate">Payment Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="paymentDate" name="payment_date" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="submitPaymentBtn">Mark as Paid</button>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript" src="<?php echo e(asset('backend/vendor/datatables/jquery.dataTables.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')); ?>"></script>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#emiTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?php echo e(route('admin.emi.installment.data')); ?>",
            columns: [
                { data: 0, name: 'id' },
                { data: 1, name: 'shareholders.name' },
                { data: 2, name: 'bank_loans.bank_name' },
                { data: 3, name: 'emi_amount' },
                { data: 4, name: 'savings_amount' },
                { data: 5, name: 'payment_date' },
                { data: 6, name: 'status' },
                { data: 7, name: 'action', orderable: false, searchable: false }
            ],
            order: [[ 0, 'desc' ]]
        });
    } else {
        console.error('DataTable plugin not found. Ensure jQuery DataTables is loaded.');
    }
    
    // Delete button handler
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var name = $(this).data('name');
        
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to delete ' + name + '?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo e(route('admin.emi.installment.delete', '')); ?>/" + id,
                    type: 'DELETE',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            'EMI Installment has been deleted successfully.',
                            'success'
                        ).then(function() {
                            $('#emiTable').DataTable().ajax.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Error deleting record: ' + (xhr.responseJSON?.message || xhr.statusText),
                            'error'
                        );
                    }
                });
            }
        });
    });
    
    // Mark as paid button handler
    var currentEmiId = null;
    $(document).on('click', '.mark-paid-btn', function(e) {
        e.preventDefault();
        currentEmiId = $(this).data('id');
        // Set today's date as default
        var today = new Date().toISOString().split('T')[0];
        $('#paymentDate').val(today);
        $('#markPaidModal').modal('show');
    });
    
    // Submit payment button handler
    $('#submitPaymentBtn').click(function() {
        var paymentDate = $('#paymentDate').val();
        
        if (!paymentDate) {
            Swal.fire('Error!', 'Please select a payment date', 'error');
            return;
        }
        
        $.ajax({
            url: "<?php echo e(route('admin.emi.installment.mark.paid', '')); ?>/" + currentEmiId,
            type: 'POST',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'payment_date': paymentDate
            },
            success: function(response) {
                $('#markPaidModal').modal('hide');
                Swal.fire(
                    'Success!',
                    'EMI marked as paid successfully.',
                    'success'
                ).then(function() {
                    $('#emiTable').DataTable().ajax.reload();
                });
            },
            error: function(xhr) {
                var message = 'Error marking as paid';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                Swal.fire('Error!', message, 'error');
            }
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/emi_installment/index.blade.php ENDPATH**/ ?>