
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
                        <h1 class="breadcrumb__title display-4 fw-semibold text-center"> প্রবন্ধ</h1>
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
                                <span class="text-main-two-600"> ব্লগ </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== Breadcrumb End Here ==================== -->
       <!-- ================================ Instructor Details Section Start ==================================== -->
       <section class="instructor-details py-120 position-relative z-1">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <div class="instructor-details__thumb">
                        <img src="<?php echo e(asset('public/storage/' . $teacher->image)); ?>" alt="" class="max-h-416 max-w-416 cover-img rounded-circle">
                        <ul class="social-list flex-center gap-16 mt-40">
                            <li class="social-list__item">
                                <a href="<?php echo e($teacher->link1); ?>" class="text-main-600 text-xl hover-text-white w-40 h-40 rounded-circle border border-main-600 hover-bg-main-600 flex-center"><i class="ph-bold ph-facebook-logo"></i></a>
                            </li>
                            <li class="social-list__item">
                                <a href="<?php echo e($teacher->link2); ?>" class="text-main-600 text-xl hover-text-white w-40 h-40 rounded-circle border border-main-600 hover-bg-main-600 flex-center"> <i class="ph-bold ph-instagram-logo"></i></a>
                            </li>
                            <li class="social-list__item">
                                <a href="<?php echo e($teacher->link3); ?>" class="text-main-600 text-xl hover-text-white w-40 h-40 rounded-circle border border-main-600 hover-bg-main-600 flex-center"><i class="ph-bold ph-behance-logo"></i></a>
                            </li>
                            <li class="social-list__item">
                                <a href="<?php echo e($teacher->link4); ?>" class="text-main-600 text-xl hover-text-white w-40 h-40 rounded-circle border border-main-600 hover-bg-main-600 flex-center"><i class="ph-bold ph-twitter-logo"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8 ps-xl-5">
                    <div class="ps-lg-5">
                        <h5 class="text-main-600 mb-0">ইনস্ট্রাকটর</h5>
                        <h2 class="my-16"><?php echo e($teacher->name); ?></h2>
                        <span class="text-neutral-700"><?php echo e($teacher->designation); ?></span>
                        <div class="d-flex flex-column gap-16 flex-wrap max-w-340 mt-40">
                            <div class="flex-between gap-8">
                                <div class="flex-align gap-8">
                                    <span class="text-neutral-700 text-2xl d-flex"><i class="ph-bold ph-lightbulb"></i></span>
                                    <span class="text-neutral-700 text-lg fw-medium"><?php echo e($teacher->subject); ?></span>
                                </div>
                                <div class="flex-align gap-8">
                                    <span class="text-neutral-700 text-2xl d-flex"><i class="ph-bold ph-watch"></i></span>
                                    <span class="text-neutral-700 text-lg fw-medium"><?php echo e($teacher->ComCourse); ?></span>
                                </div>
                            </div>
                            <div class="flex-between gap-8 flex-wrap">
                                <div class="flex-align gap-8">
                                    <span class="text-neutral-700 text-2xl d-flex"><i class="ph-bold ph-users"></i></span>
                                    <span class="text-neutral-700 text-lg fw-medium"><?php echo e($teacher->nStd); ?> শিক্ষার্থী</span>
                                </div>
                                <div class="flex-align gap-4">
                                    <span class="text-2xl fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                    <span class="text-lg text-neutral-700 fw-semibold">
                                        <?php echo e($teacher->rating); ?>

                                        <span class="text-neutral-100 fw-normal">(<?php echo e($teacher->review); ?>)</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <span class="d-block border border-neutral-30 my-40 border-dashed"></span>
                        <h4 class="mb-24">জীবন বৃত্তান্ত</h4>
                        <p class="text-neutral-500"><?php echo e($teacher->bio); ?></p>
                        <span class="d-block border border-neutral-30 my-40 border-dashed"></span>
                        <h4 class="mb-24">যোগাযোগ</h4>
                        <div class="d-flex flex-column gap-24">
                            <div class="flex-align gap-12">
                                <span class="text-2xl w-44 h-44 border border border-neutral-30 rounded-4 flex-center text-main-600 bg-main-25">
                                    <i class="ph-bold ph-phone-call"></i>
                                </span>
                                <a href="tel:<?php echo e($teacher->phone); ?>" class="text-neutral-500 hover-text-main-600"> <?php echo e($teacher->phone); ?></a>
                            </div>
                            <div class="flex-align gap-12">
                                <span class="text-2xl w-44 h-44 border border border-neutral-30 rounded-4 flex-center text-success-600 bg-main-25">
                                    <i class="ph-bold ph-envelope-simple"></i>
                                </span>
                                <a href="mailto:<?php echo e($teacher->email); ?>" class="text-neutral-500 hover-text-main-600"> <?php echo e($teacher->email); ?></a>
                            </div>
                            <div class="flex-align gap-12">
                                <span class="text-2xl w-44 h-44 border border border-neutral-30 rounded-4 flex-center text-warning-600 bg-main-25">
                                    <i class="ph-bold ph-map-pin-line"></i>
                                </span>
                                <span class="text-neutral-500"><?php echo e($teacher->address); ?></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================================ Instructor Details Section End ==================================== -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.v2.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/frontend/v2/layout/teacherDetails.blade.php ENDPATH**/ ?>