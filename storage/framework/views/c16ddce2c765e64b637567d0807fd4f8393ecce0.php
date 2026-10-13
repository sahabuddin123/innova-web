

<?php $__env->startSection('title'); ?>
    <?php echo e($pageTitle); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo e($pageTitle); ?></h1>
        <a href="<?php echo e(route('admin.asset-training.students.index')); ?>" class="btn btn-secondary">Back to List</a>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title mb-3"><?php echo e($student->full_name); ?></h5>
                    <p class="text-muted mb-1"><?php echo e($student->course); ?></p>
                    <p class="text-muted"><?php echo e($student->registration_status); ?></p>
                    <p class="text-muted">WhatsApp: <?php echo e($student->whatsapp ?? 'N/A'); ?></p>
                    <p class="text-muted">Call Type: <?php echo e($student->call_type ?? 'N/A'); ?></p>
                    <?php if($student->photo): ?>
                        <img src="<?php echo e(asset('uploads/asset/' . $student->photo)); ?>" alt="Student Photo" class="img-fluid rounded mt-3" />
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Registration Information</h5>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Email</div>
                        <div class="col-md-8"><?php echo e($student->email); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Mobile</div>
                        <div class="col-md-8"><?php echo e($student->mobile); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Father's Name</div>
                        <div class="col-md-8"><?php echo e($student->father_name); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Mother's Name</div>
                        <div class="col-md-8"><?php echo e($student->mother_name); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Address</div>
                        <div class="col-md-8"><?php echo e($student->address); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Date of Birth</div>
                        <div class="col-md-8"><?php echo e(\Carbon\Carbon::parse($student->dob)->format('d M Y')); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Education</div>
                        <div class="col-md-8"><?php echo e($student->education); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Board</div>
                        <div class="col-md-8"><?php echo e($student->board); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Subject</div>
                        <div class="col-md-8"><?php echo e($student->subject); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Passing Year</div>
                        <div class="col-md-8"><?php echo e($student->passing_year); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Employment Status</div>
                        <div class="col-md-8"><?php echo e($student->employment_status); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Religion</div>
                        <div class="col-md-8"><?php echo e($student->religion); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Gender</div>
                        <div class="col-md-8"><?php echo e($student->gender); ?></div>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Update Registration Status</h5>
                    <form action="<?php echo e(route('admin.asset-training.students.status', $student->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row g-3 align-items-end">
                            <div class="col-md-12">
                                <label class="form-label">Registration Status</label>
                                <select name="registration_status" class="form-select">
                                    <?php $__currentLoopData = ['Pending','Contacted','Converted','Follow Up','Follow Up Later','Lost','Not Qualified','Qualified','Service','Wrong Number','Not Interested','Canceled','Don\'t Call Again']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($option); ?>" <?php echo e($student->registration_status == $option ? 'selected' : ''); ?>><?php echo e($option); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-success">Update Status</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Feedback History</h5>
                    <div class="mb-4">
                        <?php if($student->feedbacks->isEmpty()): ?>
                            <p class="text-muted">No feedback has been recorded yet.</p>
                        <?php else: ?>
                            <ul class="list-group">
                                <?php $__currentLoopData = $student->feedbacks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feedback): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="list-group-item">
                                        <strong><?php echo e($feedback->feedback_step); ?><?php echo e($feedback->feedback_step == 1 ? 'st' : ($feedback->feedback_step == 2 ? 'nd' : ($feedback->feedback_step == 3 ? 'rd' : 'th'))); ?> feedback:</strong>
                                        <div><?php echo e($feedback->feedback); ?></div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <form action="<?php echo e(route('admin.asset-training.students.feedback.store', $student->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Feedback Step</label>
                                <select name="feedback_step" class="form-select">
                                    <option value="1">1st feedback</option>
                                    <option value="2">2nd feedback</option>
                                    <option value="3">3rd feedback</option>
                                    <option value="4">4th feedback</option>
                                    <option value="5">5th feedback</option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-label">Feedback</label>
                                    <textarea name="feedback" class="form-control" rows="3" placeholder="Enter feedback"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 text-end">
                                <button class="btn btn-primary">Save Feedback</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/asset-training/students/show.blade.php ENDPATH**/ ?>