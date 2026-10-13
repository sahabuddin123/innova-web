
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
    <!-- ================================ Blog Page Section Start =================================== -->
    <div class="blog-page-section py-120">
        <div class="container">
            <div class="flex-between gap-16 flex-wrap mb-40">
                <span class="text-neutral-500">
                    Showing <?php echo e($blogs->count()); ?> of <?php echo e($blogs->total()); ?> Results
                </span>
                <div class="flex-align gap-16">
                    <div class="flex-align gap-8">
                        <span class="text-neutral-500 flex-shrink-0">Sort By :</span>
                        <form method="GET" action="<?php echo e(route('frontend.blogs')); ?>">
                            <select name="sort_by" onchange="this.form.submit()" class="form-select ps-20 pe-28 py-8 fw-medium rounded-pill bg-main-25 border border-neutral-30 text-neutral-700">
                                <option value="newest" <?php echo e(request('sort_by') == 'newest' ? 'selected' : ''); ?>>Newest</option>
                                <option value="trending" <?php echo e(request('sort_by') == 'trending' ? 'selected' : ''); ?>>Trending</option>
                                <option value="popular" <?php echo e(request('sort_by') == 'popular' ? 'selected' : ''); ?>>Popular</option>
                            </select>
                        </form>
                    </div>
                    <button type="button" class="list-bar-btn text-xl w-40 h-40 bg-main-600 text-white rounded-8 flex-center d-lg-none">
                        <i class="ph-bold ph-funnel"></i>
                    </button>
                </div>
            </div>
            <?php
                use Carbon\Carbon;
            ?>
            <div class="row gy-4">
                <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4 col-sm-6">
                        <div class="scale-hover-item bg-main-25 rounded-16 p-12 h-100 border border-neutral-30">
                            <div class="course-item__thumb rounded-12 overflow-hidden position-relative">
                                <a href="<?php echo e(route('frontend.blogs.read', ['id' => $blog->id])); ?>" class="w-100 h-100">
                                    <img src="<?php echo e(asset('public/storage/' .$blog->image)); ?>" alt="<?php echo e($blog->heading); ?>" class="scale-hover-item__img rounded-12 cover-img transition-2">
                                </a>
                                <div class="position-absolute inset-inline-end-0 inset-block-end-0 me-16 mb-16 py-12 px-24 rounded-8 bg-main-three-600 text-white fw-medium">
                                    <h3 class="mb-0 text-white fw-medium"><?php echo e(Carbon::parse($blog->postDate)->format('d')); ?></h3>
                                    <?php echo e(Carbon::parse($blog->postDate)->format('M')); ?>

                                </div>
                            </div>
                            <div class="pt-32 pb-24 px-16 position-relative">
                                <h4 class="mb-28">
                                    <a href="<?php echo e(route('frontend.blogs.read', ['id' => $blog->id])); ?>" class="link text-line-2"><?php echo e($blog->heading); ?></a>
                                </h4>
                                <div class="flex-align gap-14 flex-wrap justify-content-between my-20">
                                    <div class="flex-align gap-8">
                                        <span class="text-neutral-500 text-2xl d-flex"><i class="ph ph-user-circle"></i></span>
                                        <span class="text-neutral-500 text-lg"><?php echo e($blog->writerName); ?></span>
                                    </div>
                                    
                                    <div class="flex-align gap-8">
                                        <span class="text-neutral-500 text-2xl d-flex"><i class="ph-bold ph-eye"></i></span>
                                        <span class="text-neutral-500 text-lg"><?php echo e($blog->views); ?></span>
                                    </div>
                                    
                                </div>
                                <div class="flex-between gap-8 pt-24 border-top border-neutral-50 mt-28 border-dashed border-0">
                                    <a href="<?php echo e(route('frontend.blogs.read', ['id' => $blog->id])); ?>" class="flex-align gap-8 text-main-600 hover-text-decoration-underline transition-1 fw-semibold" tabindex="0">
                                        বিস্তারিত পড়ুন
                                        <i class="ph ph-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>                            
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <ul class="pagination mt-40 flex-align gap-12 flex-wrap justify-content-center">
                <?php echo e($blogs->appends(request()->input())->links()); ?>

            </ul>
        </div>
     </div>
    <!-- ================================ Blog Page Section End =================================== -->

<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<?php echo htmlScriptTagJsApi(); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('frontend.v2.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/frontend/v2/layout/blogs.blade.php ENDPATH**/ ?>