
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
                        <h1 class="breadcrumb__title display-4 fw-semibold text-center"> ইনস্ট্রাকটর</h1>
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
                                <span class="text-main-two-600"> ইনস্ট্রাকটর </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== Breadcrumb End Here ==================== -->
    <!-- ================================ Instructor Section Start ==================================== -->
    <section class="instructor py-120 position-relative z-1">
        <img src="assets/images/shapes/shape2.png" alt="" class="shape one animation-scalation">
        <img src="assets/images/shapes/shape6.png" alt="" class="shape six animation-scalation">

        <div class="container">
            <div class="section-heading text-center">
                <h2 class="mb-24">কোর্স ইনস্ট্রাকটররা</h2>
                <p class="">আমাদের সাথে এই আবিষ্কার, বৃদ্ধি এবং রূপান্তরের যাত্রায় যোগ দিন। একসাথে, চলুন
                    একটি উজ্জ্বল ভবিষ্যৎ গড়ে তুলি।</p>
            </div>
            <div class="row gy-4">
                <?php $__currentLoopData = $teacher; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4 col-sm-6">
                        <div class="instructor-item scale-hover-item bg-white rounded-16 p-12 h-100 border border-neutral-30"
                            data-aos="fade-up" data-aos-duration="200">
                            <div class="rounded-12 overflow-hidden position-relative bg-dark-yellow">
                                <a href="#" class="w-100 h-100 d-flex align-items-end">
                                    <img src="<?php echo e(asset('public/storage/' . $item->image)); ?>" alt="Course Image"
                                        class="scale-hover-item__img rounded-12 cover-img transition-2">
                                </a>
                            </div>
                            <div class="p-24 position-relative">
                                <div class="social-infos">
                                    <ul class="social-list flex-align flex-column gap-12 mb-12">
                                        <li class="social-list__item">
                                            <a href="<?php echo e($item->link1); ?>"
                                                class=" flex-center border border-white text-white w-44 h-44 rounded-circle text-xl hover-text-main hover-bg-white"><i
                                                    class="ph-bold ph-facebook-logo"></i></a>
                                        </li>
                                        <li class="social-list__item">
                                            <a href="<?php echo e($item->link2); ?>"
                                                class=" flex-center border border-white text-white w-44 h-44 rounded-circle text-xl hover-text-main hover-bg-white">
                                                <i class="ph-bold ph-twitter-logo"></i></a>
                                        </li>
                                        <li class="social-list__item">
                                            <a href="<?php echo e($item->link3); ?>"
                                                class=" flex-center border border-white text-white w-44 h-44 rounded-circle text-xl hover-text-main hover-bg-white"><i
                                                    class="ph-bold ph-instagram-logo"></i></a>
                                        </li>
                                    </ul>
                                    <button
                                        class="social-infos__button flex-center w-44 h-44 bg-white text-main-600 rounded-circle text-2xl transition-2">
                                        <i class="ph-bold ph-plus"></i>
                                    </button>
                                </div>
                                <div class="">
                                    <h4 class="mb-28 pb-24 border-bottom border-neutral-50 mb-24 border-dashed border-0">
                                        <a href="instructor-details.html" class="link text-line-2"><?php echo e($item->name); ?></a>
                                    </h4>
                                    <div class="flex-between gap-8 flex-wrap mb-16">
                                        <div class="flex-align gap-8">
                                            <span class="text-neutral-700 text-2xl d-flex"><i
                                                    class="ph-bold ph-lightbulb"></i></span>
                                            <span class="text-neutral-700 text-lg fw-medium"><?php echo e($item->subject); ?></span>
                                        </div>
                                        <div class="flex-align gap-8">
                                            <span class="text-neutral-700 text-2xl d-flex"><i
                                                    class="ph-bold ph-watch"></i></span>
                                            <span class="text-neutral-700 text-lg fw-medium"><?php echo e($item->ComCourse); ?></span>
                                        </div>
                                    </div>
                                    <div class="flex-between gap-8 flex-wrap">
                                        <div class="flex-align gap-8">
                                            <span class="text-neutral-700 text-2xl d-flex"><i
                                                    class="ph-bold ph-users"></i></span>
                                            <span class="text-neutral-700 text-lg fw-medium"><?php echo e($item->nStd); ?>

                                                শিক্ষার্থী</span>
                                        </div>
                                        <div class="flex-align gap-4">
                                            <span class="text-2xl fw-medium text-warning-600 d-flex"><i
                                                    class="ph-fill ph-star"></i></span>
                                            <span class="text-lg text-neutral-700">
                                                <?php echo e($item->rating); ?>

                                                <span class="text-neutral-100">(<?php echo e($item->review); ?>)</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-24 border-top border-neutral-50 mt-28 border-dashed border-0">
                                    <a href="<?php echo e(route('frontend.instructors.details', $item->id)); ?>"
                                        class="flex-align gap-8 text-main-600 hover-text-decoration-underline transition-1 fw-semibold"
                                        tabindex="0">
                                        প্রোফাইল দেখুন
                                        <i class="ph ph-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <ul class="pagination mt-40 flex-align gap-12 flex-wrap justify-content-center">
                <?php echo e($teacher->appends(request()->input())->links()); ?>

            </ul>

        </div>
    </section>
    <!-- ================================ Instructor Section End ==================================== -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.v2.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/frontend/v2/layout/teacher.blade.php ENDPATH**/ ?>