
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
                        <h1 class="breadcrumb__title display-4 fw-semibold text-center"> আমাদের গ্যালারী</h1>
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
                                <span class="text-main-two-600"> গ্যালারী </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== Breadcrumb End Here ==================== -->
    <!-- =============================== Gallery Page Section Start ================================== -->
    <section class="faq-page py-120">
        <div class="container">
            <div class="section-heading text-center">
                <p class="">বছরের প্রতিদিনই শিক্ষার্থী আর উৎসাহীদের পদচারণায় মুখর থাকে ইনোভা কম্পিউটার্স বিডি এর
                    প্রাঙ্গণ। এরই মাঝে উৎসব আর বিশেষ দিনগুলো আমাদের কাজে প্রেরণা যোগায়। বছরজুড়ে কাটিয়ে আসা অতীতে ফিরে তাকিয়ে
                    দেখলে, আমরা দেখতে পাই স্মৃতিময় অসংখ্য দিন। বিশেষ দিনগুলোতে শিক্ষার্থী-শিক্ষক আর কর্মচারীদের কিছু সুন্দর
                    মুহূর্ত দেখতে পাবেন আমাদের গ্যালারিতে।</p>
            </div>

            <div class="text-center mb-40">
                <ul class="nav nav-pills common-tab d-inline-flex gap-16 bg-white p-12 border border-neutral-30 rounded-pill"
                    id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link rounded-pill bg-main-25 text-md fw-medium text-neutral-500 flex-center w-100 gap-8 active"
                            id="pills-onlineEdu-tab" data-bs-toggle="pill" data-bs-target="#pills-onlineEdu" type="button"
                            role="tab" aria-controls="pills-onlineEdu" aria-selected="true">
                            <i class="text-xl text-main-600 d-flex ph-bold ph-user"></i>
                            আমাদের প্রিমিসেস
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link rounded-pill bg-main-25 text-md fw-medium text-neutral-500 flex-center w-100 gap-8"
                            id="pills-paymentMethod-tab" data-bs-toggle="pill" data-bs-target="#pills-paymentMethod"
                            type="button" role="tab" aria-controls="pills-paymentMethod" aria-selected="false">
                            <i class="text-xl text-main-600 d-flex ph-bold ph-graduation-cap"></i>
                            ফেয়ারওয়েল
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link rounded-pill bg-main-25 text-md fw-medium text-neutral-500 flex-center w-100 gap-8"
                            id="pills-Pricing-tab" data-bs-toggle="pill" data-bs-target="#pills-Pricing" type="button"
                            role="tab" aria-controls="pills-Pricing" aria-selected="false">
                            <i class="text-xl text-main-600 d-flex ph-bold ph-star"></i>
                            ইভেন্ট
                        </button>
                    </li>
                </ul>
            </div>


            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-onlineEdu" role="tabpanel"
                    aria-labelledby="pills-onlineEdu-tab" tabindex="0">
                    <div class="row gy-4 popup-gallery1">
                        <?php $__currentLoopData = $gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($item->type == 0): ?>
                                <div class="col-md-4">
                                    <a href="<?php echo e(asset('public/storage/' . $item->image)); ?>" title="<?php echo e($item->title); ?>">
                                        <img src="<?php echo e(asset('public/storage/' . $item->image)); ?>" alt="!"
                                            class="img-fluid rounded-50">
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-paymentMethod" role="tabpanel"
                    aria-labelledby="pills-paymentMethod-tab" tabindex="0">
                    <div class="row gy-4 popup-gallery2">
                        <?php $__currentLoopData = $gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($item->type == 1): ?>
                                <div class="col-md-4">
                                    <a href="<?php echo e(asset('public/storage/' . $item->image)); ?>" title="<?php echo e($item->title); ?>">
                                        <img src="<?php echo e(asset('public/storage/' . $item->image)); ?>" alt="!"
                                            class="img-fluid rounded-50">
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-Pricing" role="tabpanel" aria-labelledby="pills-Pricing-tab"
                    tabindex="0">
                    <div class="row gy-4 popup-gallery3">
                        <?php $__currentLoopData = $gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($item->type == 2): ?>
                                <div class="col-md-4">
                                    <a href="<?php echo e(asset('public/storage/' . $item->image)); ?>" title="<?php echo e($item->title); ?>">
                                        <img src="<?php echo e(asset('public/storage/' . $item->image)); ?>" alt="!"
                                            class="img-fluid rounded-50">
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =============================== Gallery Page Section End ================================== -->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function() {
            $('.popup-gallery3').magnificPopup({
                delegate: 'a',
                type: 'image',
                tLoading: 'Loading image #%curr%...',
                mainClass: 'mfp-img-mobile',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1]
                },
                image: {
                    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                    titleSrc: function(item) {
                        return item.el.attr('title');
                    }
                }
            });
            $('.popup-gallery2').magnificPopup({
                delegate: 'a',
                type: 'image',
                tLoading: 'Loading image #%curr%...',
                mainClass: 'mfp-img-mobile',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1] 
                },
                image: {
                    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                    titleSrc: function(item) {
                        return item.el.attr('title');
                    }
                }
            });
            $('.popup-gallery1').magnificPopup({
                delegate: 'a',
                type: 'image',
                tLoading: 'Loading image #%curr%...',
                mainClass: 'mfp-img-mobile',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1]
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

<?php echo $__env->make('frontend.v2.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/frontend/v2/layout/gallery.blade.php ENDPATH**/ ?>