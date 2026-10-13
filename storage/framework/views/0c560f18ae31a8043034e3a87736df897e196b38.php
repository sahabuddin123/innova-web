

<?php $__env->startSection('title'); ?>
    <?php echo e($pageTitle); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-certificate"></i> <?php echo e($pageTitle); ?></h1>
        <a href="<?php echo e(route('admin.certificate_icbd.index')); ?>" class="btn btn-primary">
            <i class="fa fa-list"></i> All Certificates
        </a>
      
    </div>

    <?php echo $__env->make('admin.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row">
        <div class="col-lg-4">
            <!-- Student Info -->
            <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="<?php echo e(asset('public/storage/' . $certificate->student->image)); ?>" alt="avatar"
                         class="rounded-circle img-fluid img-thumbnail" style="width: 150px;">
                    <h5 class="my-3"><?php echo e($certificate->student->sname); ?></h5>
                    <p class="p-0 text-info">
                        <b><mark> Student ID : <?php echo e($certificate->student->id); ?> </mark></b>
                    </p>
                </div>
            </div>

            <!-- Registration Info -->
            <div class="card mb-4 mb-lg-0">
                <div class="card-header bg-success">
                    <h5 class="text-white"><i class="fas fa-university"></i> Registration Info</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush rounded-3">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Batch</span>
                            
                              <?php
                                            $batchno = DB::table('batchs')
                                                ->where('id', $certificate->batch_id)
                                                ->pluck('batchnum')
                                                ->first();
                                        ?>
                                        <?php echo e($batchno); ?>

                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Course</span>
                            <span><?php echo e($certificate->course->name); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Duration</span>
                            <span><?php echo e($certificate->course->courseduration); ?> Months</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Modules</span>
                            <span><?php echo e($certificate->course->totalmoduls); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Certificate No</span>
                            <span><b><?php echo e($certificate->certificate_no); ?></b></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Status</span>
                            <span>
                                <?php if($certificate->is_active == 1): ?>
                                    <b class="text-success">Delivered</b>
                                <?php elseif($certificate->is_active == 2): ?>
                                    <b class="text-warning">Pending</b>
                                <?php elseif($certificate->is_active == 3): ?>
                                    <b class="text-info">Printing</b>
                                <?php elseif($certificate->is_active == 4): ?>
                                    <b class="text-danger">Cancelled</b>
                                <?php endif; ?>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
              <a href="<?php echo e(route('admin.certificate_icbd.print', $certificate->id)); ?>" class="btn btn-success" target="_blank">
            print Certificates
        </a>
            <!-- Certificate Details -->
            <div class="card mb-4">
                <div class="card-header bg-primary">
                    <h5 class="text-white"><i class="fa fa-file"></i> Certificate Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">Theory Hours:</div>
                        <div class="col-sm-8"><b><?php echo e($certificate->theory_hours); ?></b></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4">Practical Hours:</div>
                        <div class="col-sm-8"><b><?php echo e($certificate->practical_hours); ?></b></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4">Internship Hours:</div>
                        <div class="col-sm-8"><b><?php echo e($certificate->intern_hours); ?></b></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4">Result:</div>
                        <div class="col-sm-8"><b><?php echo e($certificate->result); ?></b></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4">Issue Date:</div>
                        <div class="col-sm-8"><?php echo e($certificate->issue_date); ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4">Receiver:</div>
                        <div class="col-sm-8"><?php echo e($certificate->certificate_receiver); ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4">Delivery Date:</div>
                        <div class="col-sm-8"><?php echo e($certificate->delivery_date); ?></div>
                    </div>
                </div>
            </div>

            <!-- Certificate & Delivery Images -->
            <div class="card mb-4">
                <div class="card-header bg-primary">
                    <h5 class="text-white"><i class="fa fa-image"></i> Certificate Images</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-6">
                            <p><b>Certificate Image</b></p>
                            <a href="<?php echo e(asset('public/storage/' . $certificate->cimage)); ?>" target="_blank">
                                <img src="<?php echo e(asset('public/storage/' . $certificate->cimage)); ?>" alt="Not added" height="120">
                            </a>
                        </div>
                        <div class="col-md-6">
                            <p><b>Delivery Image</b></p>
                            <a href="<?php echo e(asset('public/storage/' . $certificate->dimage)); ?>" target="_blank">
                                <img src="<?php echo e(asset('public/storage/' . $certificate->dimage)); ?>" alt="Not added" height="120">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/certificate_icbd/show.blade.php ENDPATH**/ ?>