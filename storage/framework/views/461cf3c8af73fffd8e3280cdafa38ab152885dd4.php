
<?php $__env->startSection('title'); ?>
    <?php echo e($pageTitle); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <!-- ==================== Breadcrumb Start Here ==================== -->
    <section class="breadcrumb py-120 bg-main-25 position-relative z-1 overflow-hidden mb-0">
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape1.png')); ?>" alt=""
            class="shape one animation-rotation d-md-block d-none">
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape2.png')); ?>" alt=""
            class="shape two animation-scalation d-md-block d-none">
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape3.png')); ?>" alt=""
            class="shape eight animation-walking d-md-block d-none">
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape5.png')); ?>" alt=""
            class="shape six animation-walking d-md-block d-none">
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape4.png')); ?>" alt=""
            class="shape four animation-scalation">
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape4.png')); ?>" alt=""
            class="shape nine animation-scalation">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb__wrapper">
                        <h1 class="breadcrumb__title display-4 fw-semibold text-center"> বাকাশিবো রেজিস্ট্রেশন</h1>
                        <ul class="breadcrumb__list d-flex align-items-center justify-content-center gap-4">
                            <li class="breadcrumb__item">
                                <a href="<?php echo e(route('frontend.home')); ?>"
                                    class="breadcrumb__link text-neutral-500 hover-text-main-600 fw-medium">
                                    <i class="text-lg d-inline-flex ph-bold ph-house"></i> হোম</a>
                            </li>
                            <li class="breadcrumb__item">
                                <i class="text-neutral-500 d-flex ph-bold ph-caret-right"></i>
                            </li>
                            <li class="breadcrumb__item d-none">
                                <i class="text-neutral-500 d-flex ph-bold ph-caret-right"></i>
                            </li>
                            <li class="breadcrumb__item">
                                <span class="text-main-two-600"> রেজিস্ট্রেশন </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== Breadcrumb End Here ==================== -->
    <style>
        .dataTables_filter {
            float: right;
        }
    </style>
    <!-- ================================ Blog Details Section Start =================================== -->
    <div class="blog-page-section py-120 ">
        <div class="container">
            <div class="row gy-4 bg-main-25 rounded-16 p-12">
                <div class="col-lg-12">
                    <div class="p-40">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="card mb-4">
                                            <div class="card-body text-center">
                                                <img src="<?php echo e(asset('public/storage/' . $targetRegistration->StudentsInfo->image)); ?>"
                                                    alt="avatar" class="rounded-circle img-fluid img-thumbnail"
                                                    style="width: 150px;">
                                                <h5 class="my-3"><?php echo e($targetRegistration->StudentsInfo->sname); ?></h5>

                                                <p class="p-0 text-info"><b><mark> Student ID :
                                                            <?php echo e($targetRegistration->StudentsInfo->id); ?> </mark></b></p>

                                            </div>
                                        </div>
                                        <div class="card mb-4 mb-lg-0">
                                            <div class="card-header bg-success">
                                                <h5 class="text-white"><i class="fas fa-university"></i> Registration
                                                    Information</h5>
                                            </div>
                                            <div class="card-body p-0">
                                                <ul class="list-group list-group-flush rounded-3">

                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center py-2">
                                                        <p class="mb-0">Batch Name</p>
                                                        <p class="mb-0">
                                                            <?php echo e($targetRegistration->StudentsInfo->StudentsBatchs->batchnum); ?>

                                                        </p>
                                                    </li>

                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center py-2">
                                                        <p class="mb-0">Course Name</p>
                                                        <p class="mb-0">
                                                            <?php echo e($targetRegistration->StudentsInfo->StudentsCourses->name); ?>

                                                        </p>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center py-2">
                                                        <p class="mb-0">Course Durations</p>
                                                        <p class="mb-0">
                                                            <?php echo e($targetRegistration->StudentsInfo->StudentsCourses->courseduration); ?>

                                                            Months</p>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center py-2">
                                                        <p class="mb-0">Course Moduls</p>
                                                        <p class="mb-0">
                                                            <?php echo e($targetRegistration->StudentsInfo->StudentsCourses->totalmoduls); ?>

                                                        </p>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center py-2">
                                                        <p class="mb-0">Registration Session</p>
                                                        <p class="mb-0">
                                                            <?php echo e($targetRegistration->StudentsSessions->sessionName); ?>

                                                        </p>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center py-2">
                                                        <p class="mb-0">Registration Date</p>
                                                        <p class="mb-0">
                                                            <?php
                                                                $REGdate = strtotime($targetRegistration->regDate);
                                                                $regDate = date('d-M-Y', $REGdate);
                                                            ?>
                                                            <?php echo e($regDate); ?>


                                                        </p>
                                                    </li>

                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center py-2">
                                                        <p class="mb-0 text-primary">Registration Status</p>
                                                        <p class="mb-0">
                                                            <?php if($targetRegistration->IsActive == 1): ?>
                                                                <b class="text-success"><?php echo e('Complete'); ?></b>
                                                            <?php elseif($targetRegistration->IsActive == 2): ?>
                                                                <b class="text-warning"><?php echo e('Waiting For Payment'); ?></b>
                                                            <?php elseif($targetRegistration->IsActive == 3): ?>
                                                                <b class="text-info"><?php echo e('Postponded'); ?></b>
                                                            <?php elseif($targetRegistration->IsActive == 4): ?>
                                                                <b class="text-danger"><?php echo e('Restricted'); ?></b>
                                                            <?php endif; ?>
                                                        </p>
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
                                                        <p class="text-muted mb-0">
                                                            <?php echo e($targetRegistration->StudentsInfo->sname); ?></p>
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
                                                                $date = strtotime(
                                                                    $targetRegistration->StudentsInfo->dob,
                                                                );
                                                                $dob = date('d-m-Y', $date);
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
                                                                if ($targetRegistration->StudentsInfo->gender == 1) {
                                                                    $gender = 'Male';
                                                                } elseif (
                                                                    $targetRegistration->StudentsInfo->gender == 2
                                                                ) {
                                                                    $gender = 'Female';
                                                                } else {
                                                                    $gender = 'Others';
                                                                }
                                                            ?>
                                                            <?php echo e($gender); ?>

                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Education Qualification -->
                                        <div class="card mb-4">
                                            <div class="card-header bg-primary">
                                                <h5 class="text-white"><i class="fa fa-graduation-cap"></i> Education
                                                    Qualification</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-3">
                                                        <p class="mb-0">Board Exam Name </p>
                                                    </div>
                                                    <div class="col-sm-6 col-md-3">
                                                        <p class="mb-0">
                                                            <?php if($targetRegistration->ExamName == 1): ?>
                                                                <b class="text-success"><?php echo e('JSC'); ?></b>
                                                            <?php elseif($targetRegistration->ExamName == 2): ?>
                                                                <b class="text-success"><?php echo e('JDC'); ?></b>
                                                            <?php elseif($targetRegistration->ExamName == 3): ?>
                                                                <b class="text-primary"><?php echo e('SSC'); ?></b>
                                                            <?php elseif($targetRegistration->ExamName == 4): ?>
                                                                <b class="text-primary"><?php echo e('Dakhil'); ?></b>
                                                            <?php endif; ?>
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-6 col-md-3">
                                                        <p class="mb-0">Board Name </p>
                                                    </div>
                                                    <div class="col-sm-6 col-md-3">
                                                        <p class="mb-0">
                                                            <?php if($targetRegistration->ExamBoard == 1): ?>
                                                                <b class="text-success">Barisal</b>
                                                            <?php elseif($targetRegistration->ExamBoard == 2): ?>
                                                                <b class="text-success">Chittagong</b>
                                                            <?php elseif($targetRegistration->ExamBoard == 3): ?>
                                                                <b class="text-primary">Comilla</b>
                                                            <?php elseif($targetRegistration->ExamBoard == 4): ?>
                                                                <b class="text-primary">Dhaka</b>
                                                            <?php elseif($targetRegistration->ExamBoard == 5): ?>
                                                                <b class="text-success">Dinajpur</b>
                                                            <?php elseif($targetRegistration->ExamBoard == 6): ?>
                                                                <b class="text-primary">Jessore</b>
                                                            <?php elseif($targetRegistration->ExamBoard == 7): ?>
                                                                <b class="text-primary">Mymensingh</b>
                                                            <?php elseif($targetRegistration->ExamBoard == 8): ?>
                                                                <b class="text-success">Rajshahi</b>
                                                            <?php elseif($targetRegistration->ExamBoard == 9): ?>
                                                                <b class="text-primary">Sylhet</b>
                                                            <?php elseif($targetRegistration->ExamBoard == 10): ?>
                                                                <b class="text-primary">Madrasah</b>
                                                            <?php elseif($targetRegistration->ExamBoard == 11): ?>
                                                                <b class="text-success">Technical</b>
                                                            <?php elseif($targetRegistration->ExamBoard == 12): ?>
                                                                <b class="text-primary">DIBS(Dhaka)</b>
                                                            <?php endif; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-3">
                                                        <p class="mb-0">Roll Number</p>
                                                    </div>
                                                    <div class="col-sm-6 col-md-3">
                                                        <p class="mb-0 text-success">
                                                            <b><?php echo e($targetRegistration->ExamRoll); ?></b>
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-6 col-md-3">
                                                        <p class="mb-0">Registration Number </p>
                                                    </div>
                                                    <div class="col-sm-6 col-md-3">
                                                        <p class="mb-0 text-success">
                                                            <b><?php echo e($targetRegistration->ExamReg); ?></b>
                                                        </p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-3">
                                                        <p class="mb-0">Board Exam Session</p>
                                                    </div>
                                                    <div class="col-sm-6 col-md-3">
                                                        <p class="mb-0 text-info">
                                                            <b><?php echo e($targetRegistration->ExamSession); ?></b>
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-6 col-md-3">
                                                        <p class="mb-0">Passing Year </p>
                                                    </div>
                                                    <div class="col-sm-6 col-md-3">
                                                        <p class="mb-0 text-info">
                                                            <b><?php echo e($targetRegistration->PassYear); ?></b>
                                                        </p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6">
                                                        <p class="mb-0">Board Exam Result (GPA)</p>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6">
                                                        <p class="mb-0 text-danger">
                                                            <b><?php echo e($targetRegistration->Result); ?></b>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Guardian Informations -->
                                        <div class="card mb-4">
                                            <div class="card-header bg-primary">
                                                <h5 class="text-white"><i class="fa fa-users"></i> Guardians Informations
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-3 col-md-3">
                                                        <p class="mb-0">Father's Name : </p>
                                                    </div>
                                                    <div class="col-sm-9 col-md-3">
                                                        <p class="text-muted mb-0">
                                                            <?php echo e($targetRegistration->StudentsInfo->f_name); ?></p>
                                                    </div>

                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-3 col-md-3">
                                                        <p class="mb-0">Mother's Name : </p>
                                                    </div>
                                                    <div class="col-sm-9 col-md-3">
                                                        <p class="text-muted mb-0">
                                                            <?php echo e($targetRegistration->StudentsInfo->m_name); ?></p>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
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
    <script type="text/javascript" src="<?php echo e(asset('backend/vendor/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')); ?>"></script>
    <script type="text/javascript">
        $('#sampleTable').DataTable();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('frontend.v2.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/frontend/v2/layout/single-reg.blade.php ENDPATH**/ ?>