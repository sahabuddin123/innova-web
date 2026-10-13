
<?php $__env->startSection('title'); ?>
    <?php echo e($pageTitle); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <!-- ==================== Breadcrumb Start Here ==================== -->
    <section class="breadcrumb py-120 bg-main-25 position-relative z-1 overflow-hidden mb-0">
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape1.png')); ?>" alt="" class="shape one animation-rotation d-md-block d-none">
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape2.png')); ?>" alt="" class="shape two animation-scalation d-md-block d-none">
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape3.png')); ?>" alt="" class="shape eight animation-walking d-md-block d-none">
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape5.png')); ?>" alt="" class="shape six animation-walking d-md-block d-none">
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape4.png')); ?>" alt="" class="shape four animation-scalation">
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape4.png')); ?>" alt="" class="shape nine animation-scalation">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb__wrapper">
                        <h1 class="breadcrumb__title display-4 fw-semibold text-center"> সেমিনার</h1>
                        <ul class="breadcrumb__list d-flex align-items-center justify-content-center gap-4">
                            <li class="breadcrumb__item">
                                <a href="<?php echo e(route('frontend.home')); ?>"
                                    class="breadcrumb__link text-neutral-500 hover-text-main-600 fw-medium">
                                    <i class="text-lg d-inline-flex ph-bold ph-house"></i> হোম</a>
                            </li>
                            <li class="breadcrumb__item">
                                <i class="text-neutral-500 d-flex ph-bold ph-caret-right"></i>
                            </li>
                            <li class="breadcrumb__item">
                                <a href="course.html"
                                    class="breadcrumb__link text-neutral-500 hover-text-main-600 fw-medium"> </a>
                            </li>
                            <li class="breadcrumb__item d-none">
                                <i class="text-neutral-500 d-flex ph-bold ph-caret-right"></i>
                            </li>
                            <li class="breadcrumb__item">
                                <span class="text-main-two-600"> সেমিনার </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==================== Breadcrumb End Here ==================== -->

    <!-- ============================== Tutor Section Start ============================== -->
    <section class="course-list-view py-120 bg-white">
        <div class="container">
           
            <div class="row gy-4">
                <?php $__currentLoopData = $seminor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-xl-4 col-sm-6">
                    <div class="scale-hover-item bg-main-25 rounded-16 p-12 h-100 border border-neutral-30">
                        <div class="course-item__thumb rounded-12 overflow-hidden position-relative">
                            <a href="<?php echo e(route('frontend.seminors.reg', $item->id)); ?>" class="w-100 h-100" tabindex="0">
                                <img src="<?php echo e(asset('public/storage/' . $item->image)); ?>" alt="Course Image"
                                    class="scale-hover-item__img rounded-12 cover-img transition-2">
                            </a>
                            <div
                                class="position-absolute inset-inline-end-0 inset-block-end-0 me-16 mb-16 py-12 px-24 rounded-8 bg-main-two-600 text-white fw-medium">
                                <h3 class="mb-0 text-white fw-medium"> <?php echo e(\Carbon\Carbon::parse($item->date)->format('d')); ?></h3>
                                <?php echo e(\Carbon\Carbon::parse($item->date)->format('M')); ?>

                            </div>
                            <div
                                class="bg-success-600 rounded-8 px-24 py-12 text-white position-absolute inset-block-start-0 inset-inline-start-0 mt-20 ms-20 z-1">
                                <?php echo e(\Carbon\Carbon::parse($item->time)->format('h:s A')); ?>

                            </div>
                        </div>
                        <div class="pt-32 pb-24 px-16 position-relative">
                            <h4 class="mb-28">
                                <a href="<?php echo e(route('frontend.seminors.reg', $item->id)); ?>" class="link text-line-2" tabindex="0"><?php echo e($item->title); ?></a>
                            </h4>
                            <div class="flex-align gap-8">
                                <span class="text-neutral-500 text-2xl d-flex"><i
                                        class="ph-bold ph-map-pin-line"></i></span>
                                <p class="text-neutral-500 text-lg"><?php echo e($item->address); ?></p>
                            </div>
                            <div class="flex-between gap-8 pt-24 border-top border-neutral-50 mt-28 border-dashed border-0">
                                <h4 class="text-main-two-600 mb-0">
                                    
                                    ফ্রি
                                </h4>
                                <a href="<?php echo e(route('frontend.seminors.reg', $item->id)); ?>"
                                    class="flex-align gap-8 text-main-600 hover-text-decoration-underline transition-1 fw-semibold"
                                    tabindex="0">
                                    জয়েন করুন
                                    <i class="ph ph-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

          
        </div>
    </section>
    <!-- ============================== Tutor Section End ============================== -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.v2.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/frontend/v2/layout/seminor.blade.php ENDPATH**/ ?>