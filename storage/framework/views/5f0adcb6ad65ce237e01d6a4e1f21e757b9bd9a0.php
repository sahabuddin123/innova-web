
<?php $__env->startSection('title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<br><br>
<br><br>
<br><br>
<br><br>
<br><br>
<br><br>

<link rel="stylesheet" href="<?php echo e(asset('backend/css/lightbox-popup.css')); ?>">
    <!-- Custom fonts for this template-->
    <link href="<?php echo e(asset('backend/vendor/fontawesome-free/css/all.min.css')); ?>" rel="stylesheet" type="text/css">
<!-- Page Heading -->
<?php echo $__env->make('admin.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="container">
    <div class="text-center">
<img src="<?php echo asset('public/verified.png'); ?>" alt="!" style="height: 200px">
    </div>

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <div class="popup-gallery">
                        <a href="<?php echo asset('public/storage/'.$employees->image); ?>" title="<?php echo e($employees->name); ?>">
                            <img src="<?php echo asset('public/storage/'.$employees->image); ?>" alt="!"  class="rounded img-fluid img-thumbnail" style="width: 150px;">
                        </a>
                        </div> 
                        <h5 class="my-3"><?php echo e($employees->name); ?></h5>
                        <p class="p-0 text-info"><b><mark> Employee ID : <?php echo e($employees->stuffid); ?> </mark></b></p>
                        <p class="mb-0 text-primary">
                            <a href="<?php echo e($employees->link1); ?>" target="_blank" class="text-light bg-primary px-2 py-1 rounded"><i class="fab fa-facebook-f"></i></a>
                            <a href="<?php echo e($employees->link2); ?>" target="_blank" class="text-light bg-info px-2 py-1 rounded"><i class="fab fa-linkedin-in"></i></a>
                            <a href="<?php echo e($employees->link3); ?>" target="_blank" class="text-light bg-dark px-2 py-1 rounded"><i class="fab fa-github"></i></a>
                            <a href="<?php echo e($employees->link4); ?>" target="_blank" class="text-light bg-dark px-2 py-1 rounded"><i class="fab fa-behance"></i></a>
                        </p>
                    </div>
                </div>
                <div class="card mb-4 mb-lg-0">
                <div class="card-header bg-success"><h5 class="text-white"><i class="fas fa-university"></i> Office Information</h5></div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush rounded-3">
                        
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Designation</p>
                                <p class="mb-0"><?php echo e($employees->designation); ?></p>
                            </li>
                            
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Department</p>
                                <p class="mb-0"><?php echo e($employees->department); ?></p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Subjects</p>
                                <p class="mb-0"><?php echo e($employees->subject); ?></p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Work Experience</p>
                                <p class="mb-0"><?php echo e($employees->exprience); ?></p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Contract Type</p>
                                <?php if($employees->contactType == 1): ?>
                                <p class="mb-0">Permanent</p>
                                <?php elseif($employees->contactType == 2): ?>
                                <p class="mb-0">Intern</p>
                                <?php else: ?>
                                <p class="mb-0">Contractual</p>
                                <?php endif; ?>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0 text-info">Work Shift</p>
                                <p class="mb-0 text-info"><?php echo e($employees->shift); ?></p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Joining Date</p>
                                <p class="mb-0">
                                    <?php
                                    $date = strtotime($employees->joiningdate);
                                    $admission_date = date('d-M-Y', $date);
                                ?>
                                  <?php echo e($admission_date); ?>

                                    
                                </p>
                            </li>
                            
                            
                           
                        </ul>
                    </div>
                </div>
                </div>
                <div class="col-lg-8">
                    <!-- Student Information -->
                    <div class="card mb-4">
                         <div class="card-header bg-primary"> <h5 class="text-white"><i class="fa fa-user"></i> Employee Informations</h5></div>
                        <div class="card-body">
                           
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Full Name : </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo e($employees->name); ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Phone Number : </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo e($employees->phone); ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 col-md-3">
                                <p class="mb-0">NID / BCN : </p>
                                </div>
                                <div class="col-sm-9 col-md-9">
                                    <p class="text-muted mb-0">
                                       <?php echo e($employees->nid); ?> 
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
                                            $date = strtotime($employees->dob);
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
                                            <?php if($employees->gender == 1): ?>
                                          Male
                                            <?php elseif($employees->gender == 2): ?>
                                            Female
                                            <?php else: ?>
                                           Others
                                            <?php endif; ?>
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
                                            if($employees->bloodgroup == 1){
                                            $blood = "A(+ve)";}
                                            else if($employees->bloodgroup == 2){
                                            $blood = "O(+ve)";}
                                            else if($employees->bloodgroup == 3){
                                            $blood = "B(+ve)";}
                                            else if($employees->bloodgroup == 4){
                                            $blood = "AB(+ve)";}
                                            else if($employees->bloodgroup == 5){
                                            $blood = "A(-ve)";}
                                            else if($employees->bloodgroup == 6){
                                            $blood = "O(-ve)";}
                                            else if($employees->bloodgroup == 7){
                                            $blood = "B(-ve)";}
                                            else{
                                            $blood = "AB(-ve)";}
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
                                            if($employees->religion == 1){
                                            $religion = "Islam";}
                                            else if($employees->religion == 2){
                                            $religion = "Hindhu";}
                                            else if($employees->religion == 3){
                                            $religion = "Bhudist";}
                                            else if($employees->religion == 4){
                                            $religion = "Christian";}
                                            ?>
                                            <?php echo e($religion); ?>

                                        </p>
                                    </div>
                                </div>
                                <hr>
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                <p class="mb-0">Employees Status : </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p class="text-muted mb-0">
                                    
                                        <?php if($employees->IsActive == 1): ?>
                                        <span class="text-success"><b> Active</b></span> 
                                        <?php elseif($employees->IsActive == 2): ?>
                                        <span class="text-info"><b> Postponded</b></span>  
                                        <?php elseif($employees->IsActive == 3): ?>
                                        <span class="text-danger"><b> Restricted</b></span>   
                                        <?php endif; ?> 
                                    </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                <p class="mb-0">Joining Date : </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p class="text-muted mb-0">
                                    <?php
                                        $date = strtotime($employees->joiningdate);
                                        $joiningdate = date('d-M-Y', $date);
                                    ?>
                                      <?php echo e($joiningdate); ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Guardian Informations -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary"> <h5 class="text-white"><i class="fa fa-users"></i> Others Informations</h5></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <p class="mb-0">Father's Name : </p>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <p class="text-muted mb-0"><?php echo e($employees->fname); ?></p>
                                </div>
                                
                            </div>
                            <hr>
                            <div class="row">
                                
                                <div class="col-sm-12 col-md-6">
                                    <p class="mb-0">Mother's Name : </p>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <p class="text-muted mb-0"><?php echo e($employees->mname); ?></p>
                                </div>
                            </div>
                            <hr>
                            
                            <div class="row">
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Address : </p>
                                </div>
                                <div class="col-sm-9 col-md-9">
                                    <p class="text-muted mb-0"><?php echo e($employees->address); ?></p>
                                </div>
                               
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<br><br><br>
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
         preload: [0,1] // Will preload 0 - before current, and 1 after the current image
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
<?php echo $__env->make('frontend.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/frontend/layout/employeeinfo.blade.php ENDPATH**/ ?>