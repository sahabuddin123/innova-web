
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
    <?php
        use Carbon\Carbon;
    ?>
    <!-- ==================== Breadcrumb End Here ==================== -->
    <!-- ================================ Blog Details Section Start =================================== -->
    <div class="blog-page-section py-120">
        <div class="container">

            <div class="row gy-4">
                <div class="col-lg-8">
                    <div class="bg-main-25 rounded-16 p-12 border border-neutral-30">
                        <div class="rounded-12 overflow-hidden position-relative">
                            <img src="<?php echo e(asset('public/storage/' . $blogs->image)); ?>" alt="Course Image"
                                class="rounded-12 cover-img transition-2">
                            <div
                                class="position-absolute inset-inline-end-0 inset-block-end-0 me-16 mb-16 py-12 px-24 rounded-8 bg-main-two-600 text-white fw-medium">
                                <h3 class="mb-0 text-white fw-medium"><?php echo e(Carbon::parse($blogs->postDate)->format('d')); ?>

                                </h3>
                                <?php echo e(Carbon::parse($blogs->postDate)->format('M')); ?>

                            </div>
                        </div>
                        <div class="pt-32 pb-24 px-16 position-relative">
                            <div class="flex-align gap-14 flex-wrap mb-20">
                                <div class="flex-align gap-8">
                                    <span class="text-neutral-500 text-2xl d-flex"><i class="ph ph-user-circle"></i></span>
                                    <span class="text-neutral-500 text-lg"><?php echo e($blogs->writerName); ?></span>
                                </div>
                                <span class="w-8 h-8 bg-neutral-100 rounded-circle"></span>
                                <div class="flex-align gap-8">
                                    <span class="text-neutral-500 text-2xl d-flex"><i class="ph-bold ph-eye"></i></span>
                                    <span class="text-neutral-500 text-lg"><?php echo e($blogs->views); ?></span>
                                </div>
                            </div>
                            <h2 class="mb-24"> <?php echo e($blogs->heading); ?> </h2>
                            <p class="text-neutral-500 mb-32"><?php echo e($blogs->summary); ?> </p>
                            <?php echo $blogs->details; ?>

                        </div>
                    </div>


                </div>
                <div class="col-lg-4">
                    <div class="border border-neutral-30 rounded-12 bg-main-25 p-32 bg-main-25">
                        <h4 class="mb-16">সার্চ করুন</h4>
                        <span class="d-block border border-neutral-30 my-24 border-dashed"></span>
                        <form action="<?php echo e(route('frontend.blogs.searchblog')); ?>" class="position-relative" method="post">
                            <?php echo csrf_field(); ?>
                            <input type="text" class="common-input rounded-pill py-18 pe-64" name="id"
                                placeholder="খুজুন...">
                            <button type="submit"
                                class="flex-center w-44 h-44 rounded-circle bg-main-600 hover-bg-main-700 text-white text-2xl position-absolute inset-inline-end-0 top-50 translate-middle-y me-8"><i
                                    class="ph ph-magnifying-glass"></i></button>
                        </form>
                    </div>
                    <div class="border border-neutral-30 rounded-12 bg-main-25 p-32 bg-main-25 mt-24">
                        <h4 class="mb-16">আরও সম্পর্কিত ব্লগ</h4>
                        <span class="d-block border border-neutral-30 my-24 border-dashed"></span>
                        <?php $__currentLoopData = $blogcategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex-align gap-16">
                            <a href="<?php echo e(route('frontend.blogs.read', ['id' => $item->id])); ?>" class="flex-shrink-0">
                                <img src="<?php echo e(asset('public/storage/' . $blogs->image)); ?>" alt="!"
                                    class="w-80 h-80 rounded-8 object-fit-cover">
                            </a>
                            <div class="flex-grow-1">
                                <h6 class="text-xl mb-10">
                                    <a href="<?php echo e(route('frontend.blogs.read', ['id' => $item->id])); ?>"
                                        class="hover-text-main-600 text-line-2"> <?php echo e($blogs->heading); ?> </a>
                                </h6>
                                <span
                                    class="text-neutral-500"><?php echo e(Carbon::parse($blogs->postDate)->format('d/m/y')); ?></span>
                            </div>
                        </div>
                        <span class="d-block border border-neutral-30 my-24 border-dashed"></span>


                        <span class="d-block border border-neutral-30 my-24 border-dashed"></span>
                        <a href="<?php echo e(route('frontend.blogs')); ?>"
                            class="h6 mb-0 text-main-600 fw-semibold hover-text-decoration-underline">
                            সব দেখুন
                            <i class="ph-bold ph-arrow-right"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- ================================ Blog Details Section End =================================== -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.v2.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/frontend/v2/layout/blogread.blade.php ENDPATH**/ ?>