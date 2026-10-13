

<?php $__env->startSection('title'); ?>
    <?php echo e($pageTitle); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('backend/css/lightbox-popup.css')); ?>">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-user"></i> <?php echo e($pageTitle); ?></h1>
        </div>
        <div>
            <a href="<?php echo e(route('admin.students.index')); ?>" class="btn btn-success pull-right">All Students</a>
            <a href="<?php echo e(route('admin.students.create')); ?>" class="btn btn-primary pull-right">Add Students</a>
            <a href="<?php echo e(route('admin.idcard.view', $targetStudents->id)); ?>" class="btn btn-warning pull-right">ID Cards</a>
            <a href="<?php echo e(route('admin.idcard.iddownload', $targetStudents->id)); ?>" class="btn btn-info pull-right">Download
                ID Card</a>

            <?php if($targetStudents->IsRegister == 1): ?>
                <a href="<?php echo e(route('admin.registration.create', $targetStudents->id)); ?>"
                    class="btn btn-danger pull-right">Make Registration</a>
            <?php endif; ?>
            <?php if($targetStudents->IsRegister != 1): ?>
                <a href="<?php echo e(route('admin.certificate.create', $targetStudents->id)); ?>" class="btn btn-info pull-right">BTEB
                    Certificate</a>
            <?php endif; ?>
            <a href="<?php echo e(route('admin.certificate_icbd.create', $targetStudents->id)); ?>" class="btn btn-info pull-right">ICBD
                    Certificate</a>
        </div>
    </div>
    <?php echo $__env->make('admin.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <div class="popup-gallery">
                                <a href="<?php echo asset('public/storage/' . $targetStudents->image); ?>" title="<?php echo e($targetStudents->sname); ?>">
                                    <img src="<?php echo asset('public/storage/' . $targetStudents->image); ?>" alt="!"
                                        class="rounded-circle img-fluid img-thumbnail" style="width: 150px;">
                                </a>
                            </div>
                            <h5 class="my-3"><?php echo e($targetStudents->sname); ?></h5>
                            <p class="p-0 text-info"><b><mark> Student ID : <?php echo e($targetStudents->id); ?> </mark></b></p>
                        </div>
                    </div>
                    <div class="card mb-4 mb-lg-0">
                        <div class="card-header bg-success">
                            <h5 class="text-white"><i class="fas fa-university"></i> Academic Information</h5>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush rounded-3">

                                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                    <p class="mb-0">Batch Name</p>
                                    <p class="mb-0"><?php echo e($targetStudents->StudentsBatchs->batchnum); ?></p>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                    <p class="mb-0">Course Name</p>
                                    <p class="mb-0"><?php echo e($targetStudents->StudentsCourses->name); ?></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                    <p class="mb-0">Course Durations</p>
                                    <p class="mb-0"><?php echo e($targetStudents->StudentsCourses->courseduration); ?> Months</p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                    <p class="mb-0">Course Moduls</p>
                                    <p class="mb-0"><?php echo e($targetStudents->StudentsCourses->totalmoduls); ?></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                    <p class="mb-0">Total Projects</p>
                                    <p class="mb-0"><?php echo e($targetStudents->StudentsCourses->totalproject); ?></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                    <p class="mb-0 text-info">Course Fee</p>
                                    <p class="mb-0 text-info">
                                        <b><?php echo e(number_format($targetStudents->StudentsCourses->coursefee, 2)); ?> BDT </b></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                    <p class="mb-0">Discount</p>
                                    <p class="mb-0"><?php echo e($targetStudents->discount); ?> % </p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                    <p class="mb-0 text-primary">Total Course Fee</p>
                                    <p class="mb-0 text-primary"><b><?php echo e(number_format($targetStudents->balance, 2)); ?> BDT
                                        </b></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                    <p class="mb-0 text-success">Total Pay Amount</p>
                                    <?php
                                        $payamount = DB::table('fees_transections')
                                            ->select('paidamount')
                                            ->where('student_id', $targetStudents->id)
                                            ->where('paymentType', 1)
                                            ->sum('paidamount');
                                        $totalDue = $targetStudents->balance - $payamount;
                                    ?>
                                    <p class="mb-0 text-success"><b><?php echo e(number_format($payamount, 2)); ?> BDT </b></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                    <p class="mb-0 text-danger">Total Due Amount</p>
                                    <p class="mb-0 text-danger"><b><?php echo e(number_format($totalDue, 2)); ?> BDT </b></p>
                                </li>
                                <?php
                                    function time_elapsed_string($datetime, $full = false)
                                    {
                                        $now = new DateTime();
                                        $ago = new DateTime($datetime);
                                        $diff = $now->diff($ago);

                                        $diff->w = floor($diff->d / 7);
                                        $diff->d -= $diff->w * 7;

                                        $string = [
                                            'y' => 'year',
                                            'm' => 'month',
                                            'w' => 'week',
                                            'd' => 'day',
                                            'h' => 'hour',
                                            'i' => 'minute',
                                            's' => 'second',
                                        ];
                                        foreach ($string as $k => &$v) {
                                            if ($diff->$k) {
                                                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                                            } else {
                                                unset($string[$k]);
                                            }
                                        }

                                        if (!$full) {
                                            $string = array_slice($string, 0, 1);
                                        }
                                        return $string ? implode(', ', $string) . ' ago' : 'just now';
                                    }
                                ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                    <p class="mb-0">Last Payment Date</p>
                                    <p class="mb-0">
                                        <?php
                                            $lastdate = DB::table('fees_transections')
                                                ->where('student_id', $targetStudents->id)
                                                ->where('paymentType', 1)
                                                ->pluck('paiddate')
                                                ->take(1)
                                                ->last();

                                            if (isset($lastdate)) {
                                                $data = time_elapsed_string($lastdate);
                                            } else {
                                                $data = 'No payments';
                                            }

                                        ?>
                                        <?php echo e($data); ?>


                                    </p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                    <p class="mb-0">Batch Start Date</p>
                                    <p class="mb-0">
                                        <?php
                                            $date = strtotime($targetStudents->StudentsBatchs->startdate);
                                            $startdate = date('d-M-Y', $date);
                                        ?>
                                        <?php echo e($startdate); ?>

                                    </p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                    <p class="mb-0">Class Schedule</p>
                                    <p class="mb-0"><?php echo e($targetStudents->StudentsBatchs->schedule); ?></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <!-- Student Information -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary">
                            <h5 class="text-white"><i class="fa fa-user"></i> Students Informations</h5>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Full Name : </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo e($targetStudents->sname); ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Phone Number : </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo e($targetStudents->phone); ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">NID / BCN : </p>
                                </div>
                                <div class="col-sm-9 col-md-9">
                                    <p class="text-muted mb-0">
                                        <?php echo e($targetStudents->nid); ?>

                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">School / Collage : </p>
                                </div>
                                <div class="col-sm-9 col-md-9">
                                    <p class="text-muted mb-0">
                                        <?php echo e($targetStudents->last_school); ?>

                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <p class="mb-0">Date of Birth : </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p class="text-muted mb-0">
                                        <?php
                                            $date = strtotime($targetStudents->dob);
                                            $dob = date('d-M-Y', $date);
                                        ?>
                                        <?php echo e($dob); ?>

                                    </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p class="mb-0">Gender : </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p class="text-muted mb-0">
                                        <?php
                                            if ($targetStudents->gender == 1) {
                                                $gender = 'Male';
                                            } elseif ($targetStudents->gender == 2) {
                                                $gender = 'Female';
                                            } else {
                                                $gender = 'Others';
                                            }
                                        ?>
                                        <?php echo e($gender); ?>

                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <p class="mb-0">Blood Group : </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p class="text-muted mb-0">
                                        <?php
                                            if ($targetStudents->bloodgroup == 1) {
                                                $blood = 'A(+ve)';
                                            } elseif ($targetStudents->bloodgroup == 2) {
                                                $blood = 'O(+ve)';
                                            } elseif ($targetStudents->bloodgroup == 3) {
                                                $blood = 'B(+ve)';
                                            } elseif ($targetStudents->bloodgroup == 4) {
                                                $blood = 'AB(+ve)';
                                            } elseif ($targetStudents->bloodgroup == 5) {
                                                $blood = 'A(-ve)';
                                            } elseif ($targetStudents->bloodgroup == 6) {
                                                $blood = 'O(-ve)';
                                            } elseif ($targetStudents->bloodgroup == 7) {
                                                $blood = 'B(-ve)';
                                            } else {
                                                $blood = 'AB(-ve)';
                                            }
                                        ?>
                                        <?php echo e($blood); ?>

                                    </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p class="mb-0">Religion : </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p class="text-muted mb-0">
                                        <?php
                                            if ($targetStudents->religion == 1) {
                                                $religion = 'Islam';
                                            } elseif ($targetStudents->religion == 2) {
                                                $religion = 'Hindhu';
                                            } elseif ($targetStudents->religion == 3) {
                                                $religion = 'Bhudist';
                                            } elseif ($targetStudents->religion == 4) {
                                                $religion = 'Christian';
                                            }
                                        ?>
                                        <?php echo e($religion); ?>

                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <p class="mb-0">Height : </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p class="text-muted mb-0">
                                        <?php echo e($targetStudents->height); ?> Inches
                                    </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p class="mb-0">Weight : </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p class="text-muted mb-0">
                                        <?php echo e($targetStudents->weight); ?> KGs
                                    </p>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <p class="mb-0">Student Status : </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p class="text-muted mb-0">
                                        <?php
                                            if ($targetStudents->IsActive == 1) {
                                                $status = 'Regular';
                                            } elseif ($targetStudents->IsActive == 2) {
                                                $status = 'Iregular';
                                            } elseif ($targetStudents->IsActive == 3) {
                                                $status = 'Complete';
                                            } elseif ($targetStudents->IsActive == 4) {
                                                $status = 'Restricted';
                                            } elseif ($targetStudents->IsActive == 5) {
                                                $status = 'Postponded';
                                            }
                                        ?>
                                        <?php echo e($status); ?>

                                    </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p class="mb-0">Admission Date : </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p class="text-muted mb-0">
                                        <?php
                                            $date = strtotime($targetStudents->admission_date);
                                            $admission_date = date('d-M-Y', $date);
                                        ?>
                                        <?php echo e($admission_date); ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Guardian Informations -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary">
                            <h5 class="text-white"><i class="fa fa-users"></i> Guardians Informations</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Father's Name : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0"><?php echo e($targetStudents->f_name); ?></p>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Father's Phone Number : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0"><?php echo e($targetStudents->f_phone); ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Mother's Name : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0"><?php echo e($targetStudents->m_name); ?></p>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Mother's Phone Number : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0"><?php echo e($targetStudents->m_phone); ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Guardian's Name : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0"><?php echo e($targetStudents->g_name); ?></p>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Guardian's Phone Number : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0"><?php echo e($targetStudents->g_phone); ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Relation Guardian : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0"><?php echo e($targetStudents->rel_g); ?></p>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Referance : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0"><?php echo e($targetStudents->ref); ?></p>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript" src="<?php echo e(asset('backend/js/lightbox-popup.min.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            $('.popup-gallery').magnificPopup({
                delegate: 'a',
                type: 'image',
                tLoading: 'Loading image #%curr%...',
                mainClass: 'mfp-img-mobile',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
                },
                image: {
                    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                    titleSrc: function(item) {
                        return item.el.attr('title');
                    }
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/students/show.blade.php ENDPATH**/ ?>