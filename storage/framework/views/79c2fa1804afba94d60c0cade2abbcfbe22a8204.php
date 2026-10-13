

<?php $__env->startSection('title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-user"></i> <?php echo e($pageTitle); ?></h1>
    </div>
    
</div>
<?php echo $__env->make('admin.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img src="<?php echo e(asset('public/storage/'.$targetRegistration->StudentsInfo->image)); ?>"
                            alt="avatar" class="rounded-circle img-fluid img-thumbnail" style="width: 150px;">
                        <h5 class="my-3"><?php echo e($targetRegistration->StudentsInfo->sname); ?></h5>
                        
                        <p class="p-0 text-info"><b><mark> Student ID : <?php echo e($targetRegistration->StudentsInfo->id); ?> </mark></b></p>
                        
                    </div>
                </div>
                <div class="card mb-4 mb-lg-0">
                <div class="card-header bg-success"><h5 class="text-white"><i class="fas fa-university"></i> Registration Information</h5></div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush rounded-3">
                        
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Batch Name</p>
                                <p class="mb-0"><?php echo e($targetRegistration->StudentsInfo->StudentsBatchs->batchnum); ?></p>
                            </li>
                            
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Course Name</p>
                                <p class="mb-0"><?php echo e($targetRegistration->StudentsInfo->StudentsCourses->name); ?></p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Course Durations</p>
                                <p class="mb-0"><?php echo e($targetRegistration->StudentsInfo->StudentsCourses->courseduration); ?> Months</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Course Moduls</p>
                                <p class="mb-0"><?php echo e($targetRegistration->StudentsInfo->StudentsCourses->totalmoduls); ?></p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Registration Session</p>
                                <p class="mb-0">
                                      <?php echo e($targetRegistration->StudentsSessions->sessionName); ?>

                                </p>
                            </li>
                             <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Registration Date</p>
                                <p class="mb-0">
                                     <?php
                                        $REGdate = strtotime($targetRegistration->regDate);
                                        $regDate = date('d-M-Y', $REGdate);
                                    ?>
                                      <?php echo e($regDate); ?>

                                    
                                </p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0 text-info">Registration Fee</p>
                                <p class="mb-0 text-info"><b><?php echo e(number_format($targetRegistration->balance, 2)); ?> BDT </b></p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0 text-success">Total Registration Pay Amount</p>
                                <?php
                                $payamount = DB::table('fees_transections')->select('paidamount')->where('student_id', $targetRegistration->StudentsInfo->id)->where('paymentType',2)->sum('paidamount');
                                $totalDue = $targetRegistration->balance - $payamount;
                                ?>
                                <p class="mb-0 text-success"><b><?php echo e(number_format($payamount, 2)); ?> BDT </b></p>
                            </li> 
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0 text-danger">Total Registration Due Amount</p>
                                <p class="mb-0 text-danger"><b><?php echo e(number_format($totalDue, 2)); ?> BDT </b></p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0 text-primary">Registration Status</p>
                                <p class="mb-0">
                                    <?php if($targetRegistration->IsActive == 1): ?>
                                        <b class="text-success"><?php echo e("Complete"); ?></b>
                                    <?php elseif($targetRegistration->IsActive == 2): ?>
                                        <b class="text-warning"><?php echo e("Waiting For Payment"); ?></b>
                                    <?php elseif($targetRegistration->IsActive == 3): ?>
                                        <b class="text-info"><?php echo e("Postponded"); ?></b>
                                    <?php elseif($targetRegistration->IsActive == 4): ?>
                                        <b class="text-danger"><?php echo e("Restricted"); ?></b>
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
                         <div class="card-header bg-primary"> <h5 class="text-white"><i class="fa fa-user"></i> Students Informations</h5></div>
                        <div class="card-body">
                           
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Full Name : </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo e($targetRegistration->StudentsInfo->sname); ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Phone Number : </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo e($targetRegistration->StudentsInfo->phone); ?></p>
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
                                            $date = strtotime($targetRegistration->StudentsInfo->dob);
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
                                            if($targetRegistration->StudentsInfo->gender == 1){
                                            $gender = "Male";}
                                            else if($targetRegistration->StudentsInfo->gender == 2){
                                            $gender = "Female";}
                                            else{
                                            $gender = "Others";}
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
                                            if ($targetRegistration->bloodgroup == 1) {
                                                $blood = 'A(+ve)';
                                            } elseif ($targetRegistration->bloodgroup == 2) {
                                                $blood = 'O(+ve)';
                                            } elseif ($targetRegistration->bloodgroup == 3) {
                                                $blood = 'B(+ve)';
                                            } elseif ($targetRegistration->bloodgroup == 4) {
                                                $blood = 'AB(+ve)';
                                            } elseif ($targetRegistration->bloodgroup == 5) {
                                                $blood = 'A(-ve)';
                                            } elseif ($targetRegistration->bloodgroup == 6) {
                                                $blood = 'O(-ve)';
                                            } elseif ($targetRegistration->bloodgroup == 7) {
                                                $blood = 'B(-ve)';
                                            } else {
                                                $blood = 'AB(-ve)';
                                            }
                                        ?>
                                        <?php echo e($blood); ?>

                                        </p>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        
                                    </div>
                                </div>
                        </div>
                    </div>
                    <!-- Education Qualification -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary"> <h5 class="text-white"><i class="fa fa-graduation-cap"></i>  Education Qualification</h5></div>
                       <div class="card-body">
                               <div class="row">
                                   <div class="col-sm-6 col-md-3">
                                       <p class="mb-0">Board Exam Name </p>
                                   </div>
                                   <div class="col-sm-6 col-md-3">
                                       <p class="mb-0">
                                       <?php if($targetRegistration->ExamName == 1): ?>
                                       <b class="text-success"><?php echo e("JSC"); ?></b>
                                       <?php elseif($targetRegistration->ExamName == 2): ?>
                                       <b class="text-success"><?php echo e("JDC"); ?></b>
                                       <?php elseif($targetRegistration->ExamName == 3): ?>
                                       <b class="text-primary"><?php echo e("SSC"); ?></b>
                                       <?php elseif($targetRegistration->ExamName == 4): ?>
                                       <b class="text-primary"><?php echo e("Dakhil"); ?></b>
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
                        <div class="card-header bg-primary"> <h5 class="text-white"><i class="fa fa-users"></i> Guardians Informations</h5></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Father's Name : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0"><?php echo e($targetRegistration->StudentsInfo->f_name); ?></p>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Father's Phone Number : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0"><?php echo e($targetRegistration->StudentsInfo->f_phone); ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Mother's Name : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0"><?php echo e($targetRegistration->StudentsInfo->m_name); ?></p>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Mother's Phone Number : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0"><?php echo e($targetRegistration->StudentsInfo->m_phone); ?></p>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/registration/show.blade.php ENDPATH**/ ?>