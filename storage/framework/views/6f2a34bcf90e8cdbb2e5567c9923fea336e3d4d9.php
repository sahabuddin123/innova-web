

<?php $__env->startSection('title'); ?>
    <?php echo e($pageTitle); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<style>
    .form-control{
        padding: 5px 10px;
    }
</style>
    <?php echo $__env->make('admin.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800"><?php echo e($pageTitle); ?></h1>
            <p class="text-muted mb-0">Manage registrations, update call types, add feedback, and track student status quickly.</p>
        </div>
    </div>

    <div class="card mb-4 shadow-sm asset-filter-card p-4">
        <form method="GET" class="row gx-3 gy-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Search</label>
                <input type="text" name="q" class="form-control" value="<?php echo e($search); ?>" placeholder="Search name, email, phone">
            </div>
            <div class="col-md-2">
                <label class="form-label">Course</label>
                <select name="course_id" class="form-control">
                    <option value="">All Courses</option>
                    <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($course->name); ?>" <?php echo e($courseId == $course->name ? 'selected' : ''); ?>><?php echo e($course->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="registration_status" class="form-control">
                    <option value="">All Status</option>
                    <?php $__currentLoopData = ['Pending','Contacted','Converted','Follow Up','Follow Up Later','Lost','Not Qualified','Qualified','Service','Wrong Number','Not Interested','Canceled','Don\'t Call Again']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($statusOption); ?>" <?php echo e($status == $statusOption ? 'selected' : ''); ?>><?php echo e($statusOption); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Call Type</label>
                <select name="call_type" class="form-control">
                    <option value="">All Call Types</option>
                    <?php $__currentLoopData = ['1st call','2nd call','3rd call','4th call','5th call']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $callTypeOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($callTypeOption); ?>" <?php echo e($callType == $callTypeOption ? 'selected' : ''); ?>><?php echo e($callTypeOption); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                <div class="mb-2 mb-md-0 text-muted">Showing <?php echo e($students->count()); ?> of <?php echo e($students->total()); ?> registrations</div>
                <div class="text-end text-muted small">
                    Call types: <?php echo e($students->where('call_type', '!=', null)->count()); ?> &middot; Use filters above to refine results.
                </div>
            </div>
            <div class="table-responsive">
                <?php if($students->count()): ?>
                    <table class="table table-bordered table-hover table-sm admin-asset-table" id="assetStudentsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>WhatsApp</th>
                            <th>Call Type</th>
                            <th>Status</th>
                            <th>Feedback</th>
                            <th>Registered At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                <td><?php echo e($loop->iteration); ?></td>
                                <td><?php echo e($student->full_name); ?></td>
                                <td><?php echo e($student->course); ?></td>
                                <td><?php echo e($student->email); ?></td>
                                <td><?php echo e($student->mobile); ?></td>
                                <td><?php echo e($student->whatsapp ?? 'N/A'); ?></td>
                                <td>
                                    <div><?php echo e($student->call_type ?? 'N/A'); ?></div>
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-1 w-100 js-open-calltype-modal" data-id="<?php echo e($student->id); ?>" data-name="<?php echo e($student->full_name); ?>" data-call_type="<?php echo e($student->call_type); ?>">Update</button>
                                </td>
                                <td>
                                    <div><span class="badge badge-<?php echo e(in_array($student->registration_status, ['Qualified','Converted']) ? 'success' : ($student->registration_status == 'Lost' || $student->registration_status == 'Rejected' || $student->registration_status == 'Not Qualified' ? 'danger' : 'secondary')); ?>"><?php echo e($student->registration_status); ?></span></div>
                                    <button type="button" class="btn btn-sm btn-outline-warning mt-1 w-100 js-open-status-modal" data-id="<?php echo e($student->id); ?>" data-status="<?php echo e($student->registration_status); ?>" data-name="<?php echo e($student->full_name); ?>">Change</button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-success w-100 js-open-feedback-modal" data-id="<?php echo e($student->id); ?>" data-name="<?php echo e($student->full_name); ?>">Add / Edit</button>
                                </td>
                                <td><?php echo e($student->created_at->format('d M Y')); ?></td>
                                <td>
                                    <a href="<?php echo e(route('admin.asset-training.students.show', $student->id)); ?>" class="btn btn-sm btn-info">View</a>
                                    <form action="<?php echo e(route('admin.asset-training.students.delete', $student->id)); ?>" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this registration?');">
                                        <?php echo csrf_field(); ?>
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    </table>
                <?php else: ?>
                    <div class="text-center py-5 text-muted">
                        No ASSET registrations match your current filter. Try changing the search, course, status, or call type.
                    </div>
                <?php endif; ?>
                <?php echo e($students->links()); ?>

            </div>
        </div>
    </div>

    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Update Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="statusForm" method="POST" action="">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="redirect_to" value="index">
                    <div class="modal-body">
                        <p id="statusStudentName" class="font-weight-bold"></p>
                        <div class="mb-3">
                            <label for="modal_registration_status" class="form-label">Registration Status</label>
                            <select id="modal_registration_status" name="registration_status" class="form-control" required>
                                <?php $__currentLoopData = ['Pending','Contacted','Converted','Follow Up','Follow Up Later','Lost','Not Qualified','Qualified','Service','Wrong Number','Not Interested','Canceled','Don\'t Call Again']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($statusOption); ?>"><?php echo e($statusOption); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="feedbackModalLabel">Add Feedback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="feedbackForm" method="POST" action="">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="redirect_to" value="index">
                    <div class="modal-body">
                        <p id="feedbackStudentName" class="font-weight-bold"></p>
                        <div class="mb-3">
                            <label for="modal_feedback_step" class="form-label">Feedback Step</label>
                            <select id="modal_feedback_step" name="feedback_step" class="form-control" required>
                                <option value="1">1st</option>
                                <option value="2">2nd</option>
                                <option value="3">3rd</option>
                                <option value="4">4th</option>
                                <option value="5">5th</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="modal_feedback" class="form-label">Feedback</label>
                            <textarea id="modal_feedback" name="feedback" rows="4" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="callTypeModal" tabindex="-1" role="dialog" aria-labelledby="callTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="callTypeModalLabel">Update Call Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="callTypeForm" method="POST" action="">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <p id="callTypeStudentName" class="font-weight-bold"></p>
                        <div class="mb-3">
                            <label for="modal_call_type" class="form-label">Call Type</label>
                            <select id="modal_call_type" name="call_type" class="form-control" required>
                                <?php $__currentLoopData = ['1st call','2nd call','3rd call','4th call','5th call']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $callTypeOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($callTypeOption); ?>"><?php echo e($callTypeOption); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .asset-filter-card { background: #ffffff; border: 1px solid #e3e6f0; border-radius: 18px; padding: 32px; }
    .asset-filter-card .form-label { font-weight: 600; color: #4e73df; }
    .asset-filter-card .form-control { min-height: 46px; border-radius: 0.85rem; }
    .asset-filter-card .btn { min-height: 46px; }
    .admin-asset-table th { background-color: #f8f9fc; color: #5a5c69; }
    .admin-asset-table tbody tr:hover { background-color: #f2f4fb; }
    .admin-asset-table td, .admin-asset-table th { vertical-align: middle; }
    .admin-asset-table .btn { min-width: 90px; }
    .modal .modal-content { border-radius: 1.05rem; }
    .modal .modal-header .close { outline: none; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        $('#assetStudentsTable').DataTable({
            responsive: true,
            paging: false,
            searching: true,
            info: false,
            order: [[0, 'desc']],
        });

        var baseUrl = '<?php echo e(url("admin/asset-training/students")); ?>';

        $('.js-open-status-modal').on('click', function() {
            var studentId = $(this).data('id');
            var studentName = $(this).data('name');
            var currentStatus = $(this).data('status');
            var actionUrl = baseUrl + '/' + studentId + '/status';

            $('#statusStudentName').text('Update status for: ' + studentName);
            $('#statusForm').attr('action', actionUrl);
            $('#modal_registration_status').val(currentStatus);
            $('#statusModal').modal('show');
        });

        $('.js-open-feedback-modal').on('click', function() {
            var studentId = $(this).data('id');
            var studentName = $(this).data('name');
            var actionUrl = baseUrl + '/' + studentId + '/feedback';

            $('#feedbackStudentName').text('Add feedback for: ' + studentName);
            $('#feedbackForm').attr('action', actionUrl);
            $('#modal_feedback_step').val('1');
            $('#modal_feedback').val('');
            $('#feedbackModal').modal('show');
        });

        $('.js-open-calltype-modal').on('click', function() {
            var studentId = $(this).data('id');
            var studentName = $(this).data('name');
            var currentCallType = $(this).data('call_type');
            var actionUrl = baseUrl + '/' + studentId + '/call-type';

            $('#callTypeStudentName').text('Update call type for: ' + studentName);
            $('#callTypeForm').attr('action', actionUrl);
            $('#modal_call_type').val(currentCallType || '1st call');
            $('#callTypeModal').modal('show');
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/asset-training/students/index.blade.php ENDPATH**/ ?>