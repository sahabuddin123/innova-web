
<?php $__env->startSection('title'); ?>
    <?php echo e($pageTitle); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('admin.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- ========================= Banner Section Start =============================== -->
    <section class="banner py-80 position-relative overflow-hidden">

        <!--<img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape1.png')); ?>" alt=""-->
        <!--    class="shape one animation-rotation">-->
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape2.png')); ?>" alt=""
            class="shape two animation-scalation">
        <!--<img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape3.png')); ?>" alt=""-->
        <!--    class="shape three animation-walking">-->
        <!--<img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape4.png')); ?>" alt=""-->
        <!--    class="shape four animation-scalation">-->
        <!--<img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape5.png')); ?>" alt=""-->
        <!--    class="shape five animation-walking">-->

        <div class="container">
            <div class="row gy-5 align-items-center">
                <?php $__currentLoopData = $slider; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-xl-6">

                        <div class="banner-content pe-md-4">
                            <div class="flex-align gap-8 mb-16" data-aos="fade-down">
                                <span class="w-8 h-8 bg-main-600 rounded-circle"></span>
                                <h5 class="text-main-600 mb-0"> <?php echo $item->subTitle; ?></h5>
                            </div>


                            <h1 class="display2 mb-24 wow bounceInLeft"><?php echo $item->title; ?></span>
                            </h1>
                            <p class="text-neutral-500 text-line-2 wow bounceInUp"><?php echo $item->details; ?></p>
                            <div class="buttons-wrapper flex-align flex-wrap gap-24 mt-40">
                                <a href="<?php echo e($item->btnLink); ?>" class="btn btn-main rounded-pill flex-align gap-8"
                                    data-aos="fade-right">
                                    <?php echo e($item->btnTxt); ?>

                                    <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                                </a>
                                <a href="<?php echo e($item->btnLinkwo); ?>" class="btn btn-outline-main rounded-pill flex-align gap-8"
                                    data-aos="fade-left">
                                    <?php echo e($item->btnTxtTwo); ?>

                                    <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                    <div class="col-xl-6">
                        <div class="banner-thumb position-relative">
                            <img src="<?php echo e(asset('storage/' . $item->image)); ?>" alt=""
                                class="banner-thumb__img rounded-12 wow bounceIn" data-wow-duration="3s"
                                data-wow-delay=".5s" data-tilt data-tilt-max="12" data-tilt-speed="500"
                                data-tilt-perspective="5000" data-tilt-full-page-listening data-tilt-scale="1.02">

                            <!--<img src="<?php echo e(asset('frontend/v2/assets/images/shapes/curve-arrow.png')); ?>" alt=""-->
                            <!--    class="curve-arrow position-absolute">-->

                            <div class="banner-box one px-24 py-12 rounded-12 bg-white fw-medium box-shadow-lg d-inline-block"
                                data-aos="fade-down">
                                <span class="text-main-600"><?php echo $item->enrolStdTxt; ?>


                                    <div class="enrolled-students mt-12">
                                        <?php
                                            $stdList = explode(',', $item->sucesStdId);
                                        ?>
                                        <?php $__currentLoopData = $stdList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $student = DB::table('students')->where('id', $val)->first();
                                            ?>
                                            <img src="<?php echo e(asset('storage/' . $student->image)); ?>" alt=""
                                                class="w-48 h-48 rounded-circle object-fit-cover">
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                            </div>
                            <div class="banner-box two px-24 py-12 rounded-12 bg-white fw-medium box-shadow-lg flex-align d-inline-flex gap-16"
                                data-aos="fade-up">
                                <span
                                    class="banner-box__icon flex-shrink-0 w-48 h-48 bg-purple-400 text-white text-2xl flex-center rounded-circle"><i
                                    class="ph ph-watch"></i></span>
                                <div>
                                    <h6 class="mb-4"><?php echo e($item->offerTxt); ?></h6>
                                    <span class=""><?php echo e($item->oferTxtContent); ?></span>
                                </div>
                            </div>
                            <div class="banner-box three px-24 py-12 rounded-12 bg-white fw-medium box-shadow-lg flex-align d-inline-flex gap-16"
                                data-aos="fade-left">
                                <span
                                    class="banner-box__icon flex-shrink-0 w-48 h-48 bg-main-50 text-main-600 text-2xl flex-center rounded-circle"><i
                                    class="ph ph-phone-call"></i></span>
                                <div>
                                    <span class=""><?php echo e($item->suprtText); ?></span>
                                    <a href="tel:<?php echo e($item->suprtTextContent); ?>"
                                        class="mt-8 fw-medium text-xl d-block text-main-600 hover-text-main-500"><?php echo e($item->suprtTextContent); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <!-- ========================= Banner SEction End =============================== -->
    <!-- ========================== Brand Section Start =========================== -->
    <style>
        .brand-slider__item{
                background: #fff; 
                height: 157px !important; 
                border-radius: 20px; 
                -webkit-border-radius: 20px; 
                -moz-border-radius: 20px; 
                -ms-border-radius: 20px; -
                o-border-radius: 20px; 
                padding: 15px; 
                -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); 
                box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); 
                margin: 25px 12px;
            }
        .brand-slider__item .card-img > img {
            padding-left: 55px; 
            padding-top: 10px;
        }
        .slick-initialized.slick-slider .slick-slide {
    cursor: grab;
    height: auto;
    margin: 0 20px 0 0px !important;
}
        @media  only screen and (max-width: 600px) {
         .brand-slider__item .card-img > img {
        	padding-left: 120px;
            padding-top: 50px;
          }
        
         .brand-slider__item {
            width: 100%;
            display: inline-block;
            text-align: center;
            height: 220px !important;
            border-radius: 36px;
         }
        }
    </style>
    <div class="brand wow fadeInUpBig mb-30" data-wow-duration="1s" data-wow-delay=".5s">
        <div class="container  container--lg">
            <div class="brand-box py-30 px-16 bg-main-25 border border-neutral-30 rounded-16">
                
                <div class="container containers">
                    <div class="brand-slider">
                        <?php $__currentLoopData = $courseCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="brand-slider__item px-24 card">
                                <div class="card-img">
                                    <img src="<?php echo e(asset('storage/' . $item->icon)); ?>"
                                        alt="<?php echo e($item->CourseCategoris); ?>">
                                </div>
                                <div class="card-body">
                                    <a href="#">
                                        <h3 class="text-center" style="font-size: 16px"><?php echo e($item->CourseCategoris); ?></h3>
                                    </a>
                                </div>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ========================== Brand Section End =========================== -->

    <section class="explore-course py-120 bg-main-25 position-relative z-1">
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape2.png' )); ?>" alt="" class="shape six animation-scalation">

        <div class="container">
            <div class="section-heading text-center style-flex gap-24">
                <div class="section-heading__inner text-start">
                    <h2 class="mb-0 wow bounceIn">জনপ্রিয় কোর্সসমূহ</h2>
                </div>
                <div class="section-heading__content">
                    <p class="section-heading__desc text-start mt-0 text-line-2 wow bounceInUp">দেশ ও দেশের বাইরে বর্তমানে
                        যে স্কিলগুলোর চাহিদা সবচেয়ে বেশি, সেসব দিয়েই সাজানো হয়েছে আমাদের কোর্স লিস্ট। এখান থেকে আপনার
                        সুবিধামত অনলাইন বা অফলাইন কোর্সে এনরোল করতে পারবেন যেকোনো সময়।</p>
                    <a href="course-list-view.html"
                        class="item-hover__text flex-align gap-8 text-main-600 mt-24 hover-text-decoration-underline transition-1"
                        tabindex="0">
                        See All Course
                        <i class="ph ph-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="nav-tab-wrapper bg-white p-16 mb-40" data-aos="zoom-out">
                <ul class="nav nav-pills common-tab gap-16" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link rounded-pill bg-main-25 text-md fw-medium text-neutral-500 flex-center w-100 gap-8 active"
                            id="pills-categories-tab" data-bs-toggle="pill" data-bs-target="#pills-categories"
                            type="button" role="tab" aria-controls="pills-categories" aria-selected="true">
                            <i class="text-xl d-flex ph-bold ph-squares-four"></i>
                            সকল কোর্স
                        </a>
                    </li>
                    <?php $__currentLoopData = $FeaturecourseCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link rounded-pill bg-main-25 text-md fw-medium text-neutral-500 flex-center w-100 gap-8"
                                id="pills-design-tab" data-bs-toggle="pill" data-bs-target="#<?php echo e($item->tabId); ?>"
                                type="button" role="tab" aria-controls="pills-design" aria-selected="false">
                                <i class="text-xl d-flex ph-bold <?php echo e($item->fontawesome); ?>"></i>
                                <?php echo e($item->CourseCategoris); ?>

                            </button>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-categories" role="tabpanel"
                    aria-labelledby="pills-categories-tab" tabindex="0">
                    <div class="row gy-4">
                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <!-- Course Card Start -->
                            <div class="col-lg-4 col-sm-6 wow fadeInUp" data-aos="fade-up" data-aos-duration="200">
                                <div class="course-item bg-white rounded-16 p-12 h-100 box-shadow-md">
                                    <div class="course-item__thumb rounded-12 overflow-hidden position-relative">
                                        <a href="<?php echo e(route('frontend.course.details', $item->id)); ?>" class="w-100 h-100">
                                            <img src="<?php echo e(asset('public/storage/' . $item->image)); ?>" alt="Course Image"
                                                class="course-item__img rounded-12 cover-img transition-2">
                                        </a>
                                        <div
                                            class="flex-align gap-8 bg-main-600 rounded-pill px-24 py-12 text-white position-absolute inset-block-start-0 inset-inline-start-0 mt-20 ms-20 z-1">
                                            <span class="text-2xl d-flex"><i class="ph ph-clock"></i></span>
                                            <span class="text-lg fw-medium"><?php echo e($item->courseduration); ?> মাস</span>
                                        </div>
                                        <button type="button"
                                            class="wishlist-btn w-48 h-48 bg-white text-main-two-600 flex-center position-absolute inset-block-start-0 inset-inline-end-0 mt-20 me-20 z-1 text-2xl rounded-circle transition-2">
                                            <i class="ph ph-heart"></i>
                                        </button>
                                    </div>
                                    <div class="course-item__content">
                                        <div class="">
                                            <h4 class="mb-28">
                                                <a href="<?php echo e(route('frontend.course.details', $item->id)); ?>"
                                                    class="link text-line-2"><?php echo e($item->name); ?></a>
                                            </h4>
                                            <div class="flex-between gap-8 flex-wrap mb-16">
                                                <div class="flex-align gap-8">
                                                    <span class="text-neutral-700 text-2xl d-flex"><i
                                                            class="ph-bold ph-video-camera"></i></span>
                                                    <span
                                                        class="text-neutral-700 text-lg fw-medium"><?php echo e($item->totalmoduls); ?>

                                                        মডিউল</span>
                                                </div>
                                                <div class="flex-align gap-8">
                                                    <span class="text-neutral-700 text-2xl d-flex"><i
                                                            class="ph-bold ph-chart-bar"></i></span>
                                                    <span
                                                        class="text-neutral-700 text-lg fw-medium"><?php echo e($item->courseFor); ?></span>
                                                </div>
                                            </div>
                                            <div class="flex-between gap-8 flex-wrap">
                                                <div class="flex-align gap-4">
                                                    <span class="text-2xl fw-medium text-warning-600 d-flex"><i
                                                            class="ph-fill ph-star"></i></span>
                                                    <span class="text-lg text-neutral-700">
                                                        <?php echo e($item->Rating); ?>

                                                        <span class="text-neutral-100">(<?php echo e($item->TotalReview); ?>)</span>
                                                    </span>
                                                </div>
                                                <div class="flex-align gap-8">
                                                    <?php if($item->Instructor != null): ?>
                                                        <?php
                                                            $teaher = DB::table('teachers')
                                                                ->where('id', $item->Instructor)
                                                                ->first();
                                                        ?>
                                                        <span class="text-neutral-700 text-2xl d-flex">
                                                            <img src="<?php echo e(asset('public/storage/' . $teaher->image)); ?>"
                                                                alt="User Image"
                                                                class="w-32 h-32 object-fit-cover rounded-circle">
                                                        </span>
                                                        <span class="text-neutral-700 text-lg fw-medium"
                                                            style="text-transform: capitalize"><?php echo e(substr($teaher->name, 0, 7)); ?>.</span>
                                                    <?php else: ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="flex-between gap-8 pt-24 border-top border-neutral-50 mt-28 border-dashed border-0">
                                            <h4 class="mb-0 text-main-two-600">
                                                <?php if($item->Discount != null): ?>
                                                    <del>৳<?php echo e($item->coursefee); ?></del>
                                                    &nbsp;৳<?php echo e($item->coursefee - $item->Discount); ?>

                                                <?php else: ?>
                                                    ৳<?php echo e($item->coursefee); ?>

                                                <?php endif; ?>

                                            </h4>
                                            <a href="<?php echo e(route('frontend.course.admission', $item->id)); ?>"
                                                class="flex-align gap-8 text-main-600 hover-text-decoration-underline transition-1 fw-semibold"
                                                tabindex="0">
                                                এনরোল করুন
                                                <i class="ph ph-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Course Card End -->
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                
                <div class="tab-pane fade" id="web-software" role="tabpanel" aria-labelledby="pills-design-tab"
                    tabindex="0">
                    <div class="row gy-4">
                        <?php $__currentLoopData = $Webcourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-lg-4 col-sm-6 wow fadeInUp" data-aos="fade-up" data-aos-duration="200">
                                <div class="course-item bg-white rounded-16 p-12 h-100 box-shadow-md">
                                    <div class="course-item__thumb rounded-12 overflow-hidden position-relative">
                                        <a href="<?php echo e(route('frontend.course.details', $item->id)); ?>" class="w-100 h-100">
                                            <img src="<?php echo e(asset('public/storage/' . $item->image)); ?>" alt="Course Image"
                                                class="course-item__img rounded-12 cover-img transition-2">
                                        </a>
                                        <div
                                            class="flex-align gap-8 bg-main-600 rounded-pill px-24 py-12 text-white position-absolute inset-block-start-0 inset-inline-start-0 mt-20 ms-20 z-1">
                                            <span class="text-2xl d-flex"><i class="ph ph-clock"></i></span>
                                            <span class="text-lg fw-medium"><?php echo e($item->courseduration); ?> মাস</span>
                                        </div>
                                        <button type="button"
                                            class="wishlist-btn w-48 h-48 bg-white text-main-two-600 flex-center position-absolute inset-block-start-0 inset-inline-end-0 mt-20 me-20 z-1 text-2xl rounded-circle transition-2">
                                            <i class="ph ph-heart"></i>
                                        </button>
                                    </div>
                                    <div class="course-item__content">
                                        <div class="">
                                            <h4 class="mb-28">
                                                <a href="<?php echo e(route('frontend.course.details', $item->id)); ?>"
                                                    class="link text-line-2"><?php echo e($item->name); ?></a>
                                            </h4>
                                            <div class="flex-between gap-8 flex-wrap mb-16">
                                                <div class="flex-align gap-8">
                                                    <span class="text-neutral-700 text-2xl d-flex"><i
                                                            class="ph-bold ph-video-camera"></i></span>
                                                    <span
                                                        class="text-neutral-700 text-lg fw-medium"><?php echo e($item->totalmoduls); ?>

                                                        মডিউল</span>
                                                </div>
                                                <div class="flex-align gap-8">
                                                    <span class="text-neutral-700 text-2xl d-flex"><i
                                                            class="ph-bold ph-chart-bar"></i></span>
                                                    <span
                                                        class="text-neutral-700 text-lg fw-medium"><?php echo e($item->courseFor); ?></span>
                                                </div>
                                            </div>
                                            <div class="flex-between gap-8 flex-wrap">
                                                <div class="flex-align gap-4">
                                                    <span class="text-2xl fw-medium text-warning-600 d-flex"><i
                                                            class="ph-fill ph-star"></i></span>
                                                    <span class="text-lg text-neutral-700">
                                                        <?php echo e($item->Rating); ?>

                                                        <span class="text-neutral-100">(<?php echo e($item->TotalReview); ?>)</span>
                                                    </span>
                                                </div>
                                                <div class="flex-align gap-8">
                                                    <?php if($item->Instructor != null): ?>
                                                        <?php
                                                            $teaher = DB::table('teachers')
                                                                ->where('id', $item->Instructor)
                                                                ->first();
                                                        ?>
                                                        <span class="text-neutral-700 text-2xl d-flex">
                                                            <img src="<?php echo e(asset('public/storage/' . $teaher->image)); ?>"
                                                                alt="User Image"
                                                                class="w-32 h-32 object-fit-cover rounded-circle">
                                                        </span>
                                                        <span class="text-neutral-700 text-lg fw-medium"
                                                            style="text-transform: capitalize"><?php echo e(substr($teaher->name, 0, 7)); ?>.</span>
                                                    <?php else: ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="flex-between gap-8 pt-24 border-top border-neutral-50 mt-28 border-dashed border-0">
                                            <h4 class="mb-0 text-main-two-600">
                                                <?php if($item->Discount != null): ?>
                                                    <del>৳<?php echo e($item->coursefee); ?></del>
                                                    &nbsp;৳<?php echo e($item->coursefee - $item->Discount); ?>

                                                <?php else: ?>
                                                    ৳<?php echo e($item->coursefee); ?>

                                                <?php endif; ?>

                                            </h4>
                                            <a href="<?php echo e(route('frontend.course.admission', $item->id)); ?>"
                                                class="flex-align gap-8 text-main-600 hover-text-decoration-underline transition-1 fw-semibold"
                                                tabindex="0">
                                                এনরোল করুন
                                                <i class="ph ph-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                
                
                <div class="tab-pane fade" id="digital-marketing" role="tabpanel" aria-labelledby="pills-design-tab"
                    tabindex="0">
                    <div class="row gy-4">
                        <?php $__currentLoopData = $digitalCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-lg-4 col-sm-6 wow fadeInUp" data-aos="fade-up" data-aos-duration="200">
                                <div class="course-item bg-white rounded-16 p-12 h-100 box-shadow-md">
                                    <div class="course-item__thumb rounded-12 overflow-hidden position-relative">
                                        <a href="<?php echo e(route('frontend.course.details', $item->id)); ?>" class="w-100 h-100">
                                            <img src="<?php echo e(asset('public/storage/' . $item->image)); ?>" alt="Course Image"
                                                class="course-item__img rounded-12 cover-img transition-2">
                                        </a>
                                        <div
                                            class="flex-align gap-8 bg-main-600 rounded-pill px-24 py-12 text-white position-absolute inset-block-start-0 inset-inline-start-0 mt-20 ms-20 z-1">
                                            <span class="text-2xl d-flex"><i class="ph ph-clock"></i></span>
                                            <span class="text-lg fw-medium"><?php echo e($item->courseduration); ?> মাস</span>
                                        </div>
                                        <button type="button"
                                            class="wishlist-btn w-48 h-48 bg-white text-main-two-600 flex-center position-absolute inset-block-start-0 inset-inline-end-0 mt-20 me-20 z-1 text-2xl rounded-circle transition-2">
                                            <i class="ph ph-heart"></i>
                                        </button>
                                    </div>
                                    <div class="course-item__content">
                                        <div class="">
                                            <h4 class="mb-28">
                                                <a href="<?php echo e(route('frontend.course.details', $item->id)); ?>"
                                                    class="link text-line-2"><?php echo e($item->name); ?></a>
                                            </h4>
                                            <div class="flex-between gap-8 flex-wrap mb-16">
                                                <div class="flex-align gap-8">
                                                    <span class="text-neutral-700 text-2xl d-flex"><i
                                                            class="ph-bold ph-video-camera"></i></span>
                                                    <span
                                                        class="text-neutral-700 text-lg fw-medium"><?php echo e($item->totalmoduls); ?>

                                                        মডিউল</span>
                                                </div>
                                                <div class="flex-align gap-8">
                                                    <span class="text-neutral-700 text-2xl d-flex"><i
                                                            class="ph-bold ph-chart-bar"></i></span>
                                                    <span
                                                        class="text-neutral-700 text-lg fw-medium"><?php echo e($item->courseFor); ?></span>
                                                </div>
                                            </div>
                                            <div class="flex-between gap-8 flex-wrap">
                                                <div class="flex-align gap-4">
                                                    <span class="text-2xl fw-medium text-warning-600 d-flex"><i
                                                            class="ph-fill ph-star"></i></span>
                                                    <span class="text-lg text-neutral-700">
                                                        <?php echo e($item->Rating); ?>

                                                        <span class="text-neutral-100">(<?php echo e($item->TotalReview); ?>)</span>
                                                    </span>
                                                </div>
                                                <div class="flex-align gap-8">
                                                    <?php if($item->Instructor != null): ?>
                                                        <?php
                                                            $teaher = DB::table('teachers')
                                                                ->where('id', $item->Instructor)
                                                                ->first();
                                                        ?>
                                                        <span class="text-neutral-700 text-2xl d-flex">
                                                            <img src="<?php echo e(asset('public/storage/' . $teaher->image)); ?>"
                                                                alt="User Image"
                                                                class="w-32 h-32 object-fit-cover rounded-circle">
                                                        </span>
                                                        <span class="text-neutral-700 text-lg fw-medium"
                                                            style="text-transform: capitalize"><?php echo e(substr($teaher->name, 0, 7)); ?>.</span>
                                                    <?php else: ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="flex-between gap-8 pt-24 border-top border-neutral-50 mt-28 border-dashed border-0">
                                            <h4 class="mb-0 text-main-two-600">
                                                <?php if($item->Discount != null): ?>
                                                    <del>৳<?php echo e($item->coursefee); ?></del>
                                                    &nbsp;৳<?php echo e($item->coursefee - $item->Discount); ?>

                                                <?php else: ?>
                                                    ৳<?php echo e($item->coursefee); ?>

                                                <?php endif; ?>

                                            </h4>
                                            <a href="<?php echo e(route('frontend.course.admission', $item->id)); ?>"
                                                class="flex-align gap-8 text-main-600 hover-text-decoration-underline transition-1 fw-semibold"
                                                tabindex="0">
                                                এনরোল করুন
                                                <i class="ph ph-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                
                
                <div class="tab-pane fade" id="english-language" role="tabpanel" aria-labelledby="pills-design-tab"
                    tabindex="0">
                    <div class="row gy-4">
                        <?php $__currentLoopData = $EnglishCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-lg-4 col-sm-6 wow fadeInUp" data-aos="fade-up" data-aos-duration="200">
                                <div class="course-item bg-white rounded-16 p-12 h-100 box-shadow-md">
                                    <div class="course-item__thumb rounded-12 overflow-hidden position-relative">
                                        <a href="<?php echo e(route('frontend.course.details', $item->id)); ?>" class="w-100 h-100">
                                            <img src="<?php echo e(asset('public/storage/' . $item->image)); ?>" alt="Course Image"
                                                class="course-item__img rounded-12 cover-img transition-2">
                                        </a>
                                        <div
                                            class="flex-align gap-8 bg-main-600 rounded-pill px-24 py-12 text-white position-absolute inset-block-start-0 inset-inline-start-0 mt-20 ms-20 z-1">
                                            <span class="text-2xl d-flex"><i class="ph ph-clock"></i></span>
                                            <span class="text-lg fw-medium"><?php echo e($item->courseduration); ?> মাস</span>
                                        </div>
                                        <button type="button"
                                            class="wishlist-btn w-48 h-48 bg-white text-main-two-600 flex-center position-absolute inset-block-start-0 inset-inline-end-0 mt-20 me-20 z-1 text-2xl rounded-circle transition-2">
                                            <i class="ph ph-heart"></i>
                                        </button>
                                    </div>
                                    <div class="course-item__content">
                                        <div class="">
                                            <h4 class="mb-28">
                                                <a href="<?php echo e(route('frontend.course.details', $item->id)); ?>"
                                                    class="link text-line-2"><?php echo e($item->name); ?></a>
                                            </h4>
                                            <div class="flex-between gap-8 flex-wrap mb-16">
                                                <div class="flex-align gap-8">
                                                    <span class="text-neutral-700 text-2xl d-flex"><i
                                                            class="ph-bold ph-video-camera"></i></span>
                                                    <span
                                                        class="text-neutral-700 text-lg fw-medium"><?php echo e($item->totalmoduls); ?>

                                                        মডিউল</span>
                                                </div>
                                                <div class="flex-align gap-8">
                                                    <span class="text-neutral-700 text-2xl d-flex"><i
                                                            class="ph-bold ph-chart-bar"></i></span>
                                                    <span
                                                        class="text-neutral-700 text-lg fw-medium"><?php echo e($item->courseFor); ?></span>
                                                </div>
                                            </div>
                                            <div class="flex-between gap-8 flex-wrap">
                                                <div class="flex-align gap-4">
                                                    <span class="text-2xl fw-medium text-warning-600 d-flex"><i
                                                            class="ph-fill ph-star"></i></span>
                                                    <span class="text-lg text-neutral-700">
                                                        <?php echo e($item->Rating); ?>

                                                        <span class="text-neutral-100">(<?php echo e($item->TotalReview); ?>)</span>
                                                    </span>
                                                </div>
                                                <div class="flex-align gap-8">
                                                    <?php if($item->Instructor != null): ?>
                                                        <?php
                                                            $teaher = DB::table('teachers')
                                                                ->where('id', $item->Instructor)
                                                                ->first();
                                                        ?>
                                                        <span class="text-neutral-700 text-2xl d-flex">
                                                            <img src="<?php echo e(asset('public/storage/' . $teaher->image)); ?>"
                                                                alt="User Image"
                                                                class="w-32 h-32 object-fit-cover rounded-circle">
                                                        </span>
                                                        <span class="text-neutral-700 text-lg fw-medium"
                                                            style="text-transform: capitalize"><?php echo e(substr($teaher->name, 0, 7)); ?>.</span>
                                                    <?php else: ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="flex-between gap-8 pt-24 border-top border-neutral-50 mt-28 border-dashed border-0">
                                            <h4 class="mb-0 text-main-two-600">
                                                <?php if($item->Discount != null): ?>
                                                    <del>৳<?php echo e($item->coursefee); ?></del>
                                                    &nbsp;৳<?php echo e($item->coursefee - $item->Discount); ?>

                                                <?php else: ?>
                                                    ৳<?php echo e($item->coursefee); ?>

                                                <?php endif; ?>

                                            </h4>
                                            <a href="<?php echo e(route('frontend.course.admission', $item->id)); ?>"
                                                class="flex-align gap-8 text-main-600 hover-text-decoration-underline transition-1 fw-semibold"
                                                tabindex="0">
                                                এনরোল করুন
                                                <i class="ph ph-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                
                
                <div class="tab-pane fade" id="basic-program" role="tabpanel" aria-labelledby="pills-design-tab"
                    tabindex="0">
                    <div class="row gy-4">
                        <?php $__currentLoopData = $BasicCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-lg-4 col-sm-6 wow fadeInUp" data-aos="fade-up" data-aos-duration="200">
                                <div class="course-item bg-white rounded-16 p-12 h-100 box-shadow-md">
                                    <div class="course-item__thumb rounded-12 overflow-hidden position-relative">
                                        <a href="<?php echo e(route('frontend.course.details', $item->id)); ?>" class="w-100 h-100">
                                            <img src="<?php echo e(asset('public/storage/' . $item->image)); ?>" alt="Course Image"
                                                class="course-item__img rounded-12 cover-img transition-2">
                                        </a>
                                        <div
                                            class="flex-align gap-8 bg-main-600 rounded-pill px-24 py-12 text-white position-absolute inset-block-start-0 inset-inline-start-0 mt-20 ms-20 z-1">
                                            <span class="text-2xl d-flex"><i class="ph ph-clock"></i></span>
                                            <span class="text-lg fw-medium"><?php echo e($item->courseduration); ?> মাস</span>
                                        </div>
                                        <button type="button"
                                            class="wishlist-btn w-48 h-48 bg-white text-main-two-600 flex-center position-absolute inset-block-start-0 inset-inline-end-0 mt-20 me-20 z-1 text-2xl rounded-circle transition-2">
                                            <i class="ph ph-heart"></i>
                                        </button>
                                    </div>
                                    <div class="course-item__content">
                                        <div class="">
                                            <h4 class="mb-28">
                                                <a href="<?php echo e(route('frontend.course.details', $item->id)); ?>"
                                                    class="link text-line-2"><?php echo e($item->name); ?></a>
                                            </h4>
                                            <div class="flex-between gap-8 flex-wrap mb-16">
                                                <div class="flex-align gap-8">
                                                    <span class="text-neutral-700 text-2xl d-flex"><i
                                                            class="ph-bold ph-video-camera"></i></span>
                                                    <span
                                                        class="text-neutral-700 text-lg fw-medium"><?php echo e($item->totalmoduls); ?>

                                                        মডিউল</span>
                                                </div>
                                                <div class="flex-align gap-8">
                                                    <span class="text-neutral-700 text-2xl d-flex"><i
                                                            class="ph-bold ph-chart-bar"></i></span>
                                                    <span
                                                        class="text-neutral-700 text-lg fw-medium"><?php echo e($item->courseFor); ?></span>
                                                </div>
                                            </div>
                                            <div class="flex-between gap-8 flex-wrap">
                                                <div class="flex-align gap-4">
                                                    <span class="text-2xl fw-medium text-warning-600 d-flex"><i
                                                            class="ph-fill ph-star"></i></span>
                                                    <span class="text-lg text-neutral-700">
                                                        <?php echo e($item->Rating); ?>

                                                        <span class="text-neutral-100">(<?php echo e($item->TotalReview); ?>)</span>
                                                    </span>
                                                </div>
                                                <div class="flex-align gap-8">
                                                    <?php if($item->Instructor != null): ?>
                                                        <?php
                                                            $teaher = DB::table('teachers')
                                                                ->where('id', $item->Instructor)
                                                                ->first();
                                                        ?>
                                                        <span class="text-neutral-700 text-2xl d-flex">
                                                            <img src="<?php echo e(asset('public/storage/' . $teaher->image)); ?>"
                                                                alt="User Image"
                                                                class="w-32 h-32 object-fit-cover rounded-circle">
                                                        </span>
                                                        <span class="text-neutral-700 text-lg fw-medium"
                                                            style="text-transform: capitalize"><?php echo e(substr($teaher->name, 0, 7)); ?>.</span>
                                                    <?php else: ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="flex-between gap-8 pt-24 border-top border-neutral-50 mt-28 border-dashed border-0">
                                            <h4 class="mb-0 text-main-two-600">
                                                <?php if($item->Discount != null): ?>
                                                    <del>৳<?php echo e($item->coursefee); ?></del>
                                                    &nbsp;৳<?php echo e($item->coursefee - $item->Discount); ?>

                                                <?php else: ?>
                                                    ৳<?php echo e($item->coursefee); ?>

                                                <?php endif; ?>

                                            </h4>
                                            <a href="<?php echo e(route('frontend.course.admission', $item->id)); ?>"
                                                class="flex-align gap-8 text-main-600 hover-text-decoration-underline transition-1 fw-semibold"
                                                tabindex="0">
                                                এনরোল করুন
                                                <i class="ph ph-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                
                
                <div class="tab-pane fade" id="design-multimedia" role="tabpanel" aria-labelledby="pills-design-tab"
                    tabindex="0">
                    <div class="row gy-4">
                        <?php $__currentLoopData = $GraphicCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-lg-4 col-sm-6 wow fadeInUp" data-aos="fade-up" data-aos-duration="200">
                                <div class="course-item bg-white rounded-16 p-12 h-100 box-shadow-md">
                                    <div class="course-item__thumb rounded-12 overflow-hidden position-relative">
                                        <a href="<?php echo e(route('frontend.course.details', $item->id)); ?>" class="w-100 h-100">
                                            <img src="<?php echo e(asset('public/storage/' . $item->image)); ?>" alt="Course Image"
                                                class="course-item__img rounded-12 cover-img transition-2">
                                        </a>
                                        <div
                                            class="flex-align gap-8 bg-main-600 rounded-pill px-24 py-12 text-white position-absolute inset-block-start-0 inset-inline-start-0 mt-20 ms-20 z-1">
                                            <span class="text-2xl d-flex"><i class="ph ph-clock"></i></span>
                                            <span class="text-lg fw-medium"><?php echo e($item->courseduration); ?> মাস</span>
                                        </div>
                                        <button type="button"
                                            class="wishlist-btn w-48 h-48 bg-white text-main-two-600 flex-center position-absolute inset-block-start-0 inset-inline-end-0 mt-20 me-20 z-1 text-2xl rounded-circle transition-2">
                                            <i class="ph ph-heart"></i>
                                        </button>
                                    </div>
                                    <div class="course-item__content">
                                        <div class="">
                                            <h4 class="mb-28">
                                                <a href="<?php echo e(route('frontend.course.details', $item->id)); ?>"
                                                    class="link text-line-2"><?php echo e($item->name); ?></a>
                                            </h4>
                                            <div class="flex-between gap-8 flex-wrap mb-16">
                                                <div class="flex-align gap-8">
                                                    <span class="text-neutral-700 text-2xl d-flex"><i
                                                            class="ph-bold ph-video-camera"></i></span>
                                                    <span
                                                        class="text-neutral-700 text-lg fw-medium"><?php echo e($item->totalmoduls); ?>

                                                        মডিউল</span>
                                                </div>
                                                <div class="flex-align gap-8">
                                                    <span class="text-neutral-700 text-2xl d-flex"><i
                                                            class="ph-bold ph-chart-bar"></i></span>
                                                    <span
                                                        class="text-neutral-700 text-lg fw-medium"><?php echo e($item->courseFor); ?></span>
                                                </div>
                                            </div>
                                            <div class="flex-between gap-8 flex-wrap">
                                                <div class="flex-align gap-4">
                                                    <span class="text-2xl fw-medium text-warning-600 d-flex"><i
                                                            class="ph-fill ph-star"></i></span>
                                                    <span class="text-lg text-neutral-700">
                                                        <?php echo e($item->Rating); ?>

                                                        <span class="text-neutral-100">(<?php echo e($item->TotalReview); ?>)</span>
                                                    </span>
                                                </div>
                                                <div class="flex-align gap-8">
                                                    <?php if($item->Instructor != null): ?>
                                                        <?php
                                                            $teaher = DB::table('teachers')
                                                                ->where('id', $item->Instructor)
                                                                ->first();
                                                        ?>
                                                        <span class="text-neutral-700 text-2xl d-flex">
                                                            <img src="<?php echo e(asset('public/storage/' . $teaher->image)); ?>"
                                                                alt="User Image"
                                                                class="w-32 h-32 object-fit-cover rounded-circle">
                                                        </span>
                                                        <span class="text-neutral-700 text-lg fw-medium"
                                                            style="text-transform: capitalize"><?php echo e(substr($teaher->name, 0, 7)); ?>.</span>
                                                    <?php else: ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="flex-between gap-8 pt-24 border-top border-neutral-50 mt-28 border-dashed border-0">
                                            <h4 class="mb-0 text-main-two-600">
                                                <?php if($item->Discount != null): ?>
                                                    <del>৳<?php echo e($item->coursefee); ?></del>
                                                    &nbsp;৳<?php echo e($item->coursefee - $item->Discount); ?>

                                                <?php else: ?>
                                                    ৳<?php echo e($item->coursefee); ?>

                                                <?php endif; ?>

                                            </h4>
                                            <a href="<?php echo e(route('frontend.course.admission', $item->id)); ?>"
                                                class="flex-align gap-8 text-main-600 hover-text-decoration-underline transition-1 fw-semibold"
                                                tabindex="0">
                                                এনরোল করুন
                                                <i class="ph ph-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    <!-- ================================== Explore Course Section End =========================== -->

      <!-- ========================== Satisfied Clients Section Start =========================== -->
    <?php if($clients->count() > 0): ?>
    <section class="client-section py-80 bg-main-25 position-relative z-1">
        <div class="container">
            <div class="section-heading text-center">
                <h2 class="mb-24 wow bounceIn">Our Satisfied Clients</h2>
                <p class="wow bounceInUp">We are proud to have worked with these organizations</p>
            </div>
            <div class="row justify-content-center align-items-center">
                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-2 col-md-3 col-4 mb-4 d-flex flex-column align-items-center">
                        <div class="client-logo mb-2">
                            <img src="<?php echo e(asset('storage/' . $client->logo)); ?>" alt="<?php echo e($client->name); ?>" style="max-height: 80px; max-width: 100px; margin: 0 auto; display: block;">
                        </div>
                        <div class="client-name text-center" style="font-size: 14px;"><?php echo e($client->name); ?></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <!-- ========================== Satisfied Clients Section End =========================== -->

    <!-- ================================ Services Section Start ==================================== -->
    <?php if($services->count() > 0): ?>
    <section class="service-section py-120 bg-main-25 position-relative z-1">
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape2.png')); ?>" alt="" class="shape one animation-scalation">
        <div class="container">
            <div class="section-heading text-center">
                <h2 class="mb-24 wow bounceIn">আমাদের সেবা সমূহ</h2>
                <p class="wow bounceInUp">আমরা আপনার জন্য বিভিন্ন ধরনের সেবা প্রদান করি</p>
            </div>
            <div class="row gy-4">
                <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-aos="fade-up" data-aos-duration="200">
                    <div class="service-item bg-white rounded-16 p-32 h-100 box-shadow-md text-center">
                        <div class="service-icon mb-24">
                            <span class="w-80 h-80 flex-center d-inline-flex bg-main-25 text-main-600 text-40 rounded-circle">
                                <i class="<?php echo e($service->icon ?? 'ph ph-gear-six'); ?>"></i>
                            </span>
                        </div>
                        <h3 class="mb-16"><?php echo e($service->title); ?></h3>
                        <p class="text-neutral-500"><?php echo e($service->description); ?></p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="text-center mt-40">
                <a href="<?php echo e(route('frontend.services')); ?>" class="btn btn-main rounded-pill">সকল সেবা দেখুন</a>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <!-- ================================ Services Section End ==================================== -->

    <!-- ================================ Products Section Start ==================================== -->
    <?php if($products->count() > 0): ?>
    <section class="product-section py-120 position-relative z-1">
        <div class="container">
            <div class="section-heading text-center">
                <h2 class="mb-24 wow bounceIn">আমাদের পণ্য সমূহ</h2>
                <p class="wow bounceInUp">উন্নত মানের পণ্য আমাদের অফার</p>
            </div>
            <div class="row gy-4">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-aos="fade-up" data-aos-duration="200">
                    <div class="product-item bg-white rounded-16 p-32 h-100 box-shadow-md text-center border border-neutral-30">
                        <div class="product-icon mb-24">
                            <span class="w-80 h-80 flex-center d-inline-flex bg-main-two-25 text-main-two-600 text-40 rounded-circle">
                                <i class="<?php echo e($product->icon ?? 'ph ph-package'); ?>"></i>
                            </span>
                        </div>
                        <h3 class="mb-16"><?php echo e($product->title); ?></h3>
                        <p class="text-neutral-500"><?php echo e($product->description); ?></p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="text-center mt-40">
                <a href="<?php echo e(route('frontend.products')); ?>" class="btn btn-main rounded-pill">সকল পণ্য দেখুন</a>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <!-- ================================ Products Section End ==================================== -->

    <!-- ================================ Workflow Section Start ==================================== -->
    <?php if($workflows->count() > 0): ?>
    <section class="workflow-section py-120 bg-main-25 position-relative z-1">
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape2.png')); ?>" alt="" class="shape one animation-scalation">
        <div class="container">
            <div class="section-heading text-center">
                <h2 class="mb-24 wow bounceIn">আমাদের ওয়ার্কফ্লো</h2>
                <p class="wow bounceInUp">আমাদের কাজের প্রক্রিয়া সম্পর্কে জানুন</p>
            </div>
            <div class="row gy-4 justify-content-center">
                <?php $__currentLoopData = $workflows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workflow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-aos="fade-up" data-aos-duration="200">
                    <div class="workflow-item bg-white rounded-16 p-32 h-100 box-shadow-md text-center position-relative">
                        <div class="step-badge position-absolute top-0 start-50 translate-middle">
                            <span class="w-40 h-40 flex-center d-inline-flex bg-main-600 text-white text-lg rounded-circle"><?php echo e($workflow->step); ?></span>
                        </div>
                        <div class="workflow-icon mb-24 mt-16">
                            <span class="w-64 h-64 flex-center d-inline-flex bg-main-25 text-main-600 text-30 rounded-circle">
                                <i class="<?php echo e($workflow->icon ?? 'ph ph-flow-arrow'); ?>"></i>
                            </span>
                        </div>
                        <h4 class="mb-12"><?php echo e($workflow->title); ?></h4>
                        <p class="text-neutral-500 text-sm"><?php echo e($workflow->description); ?></p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="text-center mt-40">
                <a href="<?php echo e(route('frontend.workflow')); ?>" class="btn btn-main rounded-pill">বিস্তারিত দেখুন</a>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <!-- ================================ Workflow Section End ==================================== -->

    <!-- ========================== Satisfied Clients Section Start =========================== -->
    <?php if($clients->count() > 0): ?>
    <section class="client-section py-80 bg-main-25 position-relative z-1">
        <div class="container">
            <div class="section-heading text-center">
                <h2 class="mb-24 wow bounceIn">Our Satisfied Clients</h2>
                <p class="wow bounceInUp">We are proud to have worked with these organizations</p>
            </div>
            <div class="row justify-content-center align-items-center">
                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-2 col-md-3 col-4 mb-4 d-flex flex-column align-items-center">
                        <div class="client-logo mb-2">
                            <img src="<?php echo e(asset('storage/' . $client->logo)); ?>" alt="<?php echo e($client->name); ?>" style="max-height: 80px; max-width: 100px; margin: 0 auto; display: block;">
                        </div>
                        <div class="client-name text-center" style="font-size: 14px;"><?php echo e($client->name); ?></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <!-- ========================== Satisfied Clients Section End =========================== -->

    <?php $__env->startSection('technologies'); ?>
    <!-- ========================== Technology We Use Section Start =========================== -->
    <?php if($technologies->count() > 0): ?>
    <section class="technology-section py-80 bg-white position-relative z-1">
        <div class="container">
            <div class="section-heading text-center">
                <h2 class="mb-24 wow bounceIn">Technology We Use</h2>
            </div>
            <div class="row justify-content-center align-items-center">
                <?php $__currentLoopData = $technologies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $technology): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-1 col-md-2 col-3 mb-4 d-flex flex-column align-items-center">
                        <div class="technology-logo mb-2">
                            <img src="<?php echo e(asset('storage/' . $technology->icon)); ?>" alt="<?php echo e($technology->name); ?>" style="max-height: 60px; max-width: 60px; margin: 0 auto; display: block;">
                        </div>
                        <div class="technology-name text-center" style="font-size: 13px;"><?php echo e($technology->name); ?></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <!-- ========================== Technology We Use Section End =========================== -->
    <?php $__env->stopSection(); ?>

    <!-- ================================ About Section Start ==================================== -->
    <section class="about py-120 position-relative z-1 mash-bg-main mash-bg-main-two">
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape2.png')); ?>" alt=""
            class="shape one animation-scalation">
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape6.png')); ?>" alt=""
            class="shape four animation-scalation">

        <div class="position-relative">
            <div class="container">
                <div class="row gy-xl-0 gy-5 flex-wrap-reverse align-items-center">
                    <div class="col-xl-6">
                        <div class="about-thumbs position-relative pe-lg-5">
                            <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape7.png')); ?>" alt=""
                                class="shape seven animation-scalation">

                            <div
                                class="offer-message px-24 py-12 rounded-12 bg-main-two-50 fw-medium flex-align d-inline-flex gap-16 border border-neutral-30 animation-upDown">
                                <span
                                    class="flex-shrink-0 w-48 h-48 bg-main-two-600 text-white text-2xl flex-center rounded-circle"><i
                                    class="ph ph-watch"></i></span>
                                <div>
                                    <h6 class="mb-4">20% OFF</h6>
                                    <span class="text-neutral-500">For All Courses</span>
                                </div>
                            </div>
                            <div class="row gy-4">
                                <div class="col-sm-6">
                                    <img src="<?php echo e(asset('frontend/v2/assets/images/thumbs/about-img1.jpg')); ?>"
                                        alt="" class="rounded-12 w-100" data-tilt data-tilt-max="15"
                                        data-tilt-speed="500" data-tilt-perspective="5000" data-tilt-full-page-listening>
                                </div>
                                <div class="col-sm-6">
                                    <div class="flex-align gap-24 mb-24">
                                        <div class="bg-main-600 rounded-12 text-center py-24 px-2 w-50-percent"
                                            data-aos="fade-right">
                                            <h1 class="mb-0 text-white counter">6+</h1>
                                            <span class="text-white">বছরের অভিজ্ঞতা</span>
                                        </div>
                                        <div class="bg-neutral-700 rounded-12 text-center py-24 px-2 w-50-percent"
                                            data-aos="fade-left">
                                            <h1 class="mb-0 text-white counter">5.2k</h1>
                                            <span class="text-white">সফল শিক্ষারথী</span>
                                        </div>
                                    </div>
                                    <img src="<?php echo e(asset('frontend/v2/assets/images/thumbs/about-img2.jpg')); ?>"
                                        alt="" class="rounded-12 w-100" data-tilt data-tilt-max="20"
                                        data-tilt-speed="500" data-tilt-perspective="5000" data-tilt-full-page-listening>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="about-content">
                            <div class="mb-40">
                                <div class="flex-align gap-8 mb-16 wow bounceInDown">
                                    <span class="w-8 h-8 bg-main-600 rounded-circle"></span>
                                    <h5 class="text-main-600 mb-0 ">ইনোভা সম্পর্কে</h5>
                                </div>
                                <h2 class="mb-24 wow bounceIn">আপনার সফলতার ঠিকানা</h2>
                                <p class="text-neutral-500 text-line-2 wow bounceInUp">স্বাগতম ইনোভা-তে, যেখানে শিক্ষার
                                    কোনো সীমা নেই। আপনি যদি একজন শিক্ষার্থী, পেশাজীবী বা আজীবন শেখার আগ্রহী হন, ইনোভা সবসময়
                                    আপনাকে এগিয়ে যেতে সাহায্য করবে।</p>
                            </div>

                            <div class="flex-align align-items-start gap-28 mb-32" data-aos="fade-left"
                                data-aos-duration="200">
                                <span
                                    class="w-80 h-80 bg-main-25 border border-neutral-30 flex-center rounded-circle flex-shrink-0">
                                    <img src="<?php echo e(asset('frontend/v2/assets/images/icons/about-img1.png')); ?>"
                                        alt="">
                                </span>
                                <div class="flex-grow-1">
                                    <h4 class="text-neutral-500 mb-12">আমাদের লক্ষ্য</h4>
                                    <p class="text-neutral-500">ইনোভা কম্পিউটার্স বিডি-এর লক্ষ্য হলো বেকারত্ব দূরীকরণ এবং
                                        দক্ষ মানবসম্পদ গড়ে তোলা। আধুনিক প্রযুক্তি ও মানসম্মত প্রশিক্ষণের মাধ্যমে
                                        শিক্ষার্থীদের ক্যারিয়ার গঠনে সহায়তা করা আমাদের মূল উদ্দেশ্য।</p>
                                </div>
                            </div>
                            <div class="flex-align align-items-start gap-28 mb-0" data-aos="fade-left"
                                data-aos-duration="400">
                                <span
                                    class="w-80 h-80 bg-main-25 border border-neutral-30 flex-center rounded-circle flex-shrink-0">
                                    <img src="<?php echo e(asset('frontend/v2/assets/images/icons/about-img2.png')); ?>"
                                        alt="">
                                </span>
                                <div class="flex-grow-1">
                                    <h4 class="text-neutral-500 mb-12">আমাদের উদ্দেশ্য</h4>
                                    <p class="text-neutral-500">ইনোভা কম্পিউটার্স বিডি-এর উদ্দেশ্য হলো শিক্ষার্থীদের
                                        প্রযুক্তিগত দক্ষতা ও সৃজনশীলতা বিকাশ করে তাদেরকে সফল পেশাজীবী হিসেবে প্রতিষ্ঠিত করা
                                        এবং কর্মসংস্থানের সুযোগ তৈরি করা। </p>
                                </div>
                            </div>

                            <div class="flex-align flex-wrap gap-32 pt-40 border-top border-neutral-50 mt-40 border-dashed border-0"
                                data-aos="fade-left" data-aos-duration="600">
                                <a href="#" class="btn btn-main rounded-pill flex-align gap-8">
                                    আরও পড়ুন
                                    <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                                </a>
                                <div class="flex-align gap-20">
                                    <img src="<?php echo e(asset('frontend/v2/assets/images/thumbs/ceo-img.png')); ?>"
                                        alt="" class="w-52 h-52 rounded-circle object-fit-cover flex-shrink-0">
                                    <div class="flex-grow-1">
                                        <span class="mb-4">
                                            <img src="<?php echo e(asset('frontend/v2/assets/images/thumbs/signature.png')); ?>"
                                                alt="">
                                        </span>
                                        <span class="text-sm d-block">নির্বাহি পরিচালক, ইনোভা কম্পিউটার্স বিডি।</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================================ About Section End ==================================== -->

    <!-- ================================ Instructor Section Start ==================================== -->
    <section class="instructor py-120 bg-main-25 position-relative z-1">
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape2.png')); ?>" alt=""
            class="shape one animation-scalation">
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape6.png')); ?>" alt=""
            class="shape six animation-scalation">

        <div class="container">
            <div class="section-heading text-center">
                <h2 class="mb-24 wow bounceIn">কোর্স ইনস্ট্রাকটররা</h2>
                <p class=" wow bounceInUp">আমাদের সাথে এই আবিষ্কার, বৃদ্ধি এবং রূপান্তরের যাত্রায় যোগ দিন। একসাথে, চলুন
                    একটি উজ্জ্বল ভবিষ্যৎ গড়ে তুলি।</p>
            </div>
            <div class="instructor-slider">
                
                <?php $__currentLoopData = $teacher; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
            </div>

            <div class="flex-align gap-16 mt-40 justify-content-center">
                <button type="button" id="instructor-prev"
                    class="slick-prev slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1 w-48 h-48">
                    <i class="ph ph-caret-left"></i>
                </button>
                <button type="button" id="instructor-next"
                    class="slick-next slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1 w-48 h-48">
                    <i class="ph ph-caret-right"></i>
                </button>
            </div>

        </div>
    </section>
    <!-- ================================ Instructor Section End ==================================== -->

    <?php $__currentLoopData = $cmsAbout; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <!-- =========================== CHoose Us Section Start ================================ -->
    <section class="choose-us pt-120 position-relative z-1 mash-bg-main mash-bg-main-two">
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape2.png')); ?>" alt=""
            class="shape one animation-scalation">
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape2.png')); ?>" alt=""
            class="shape six animation-scalation">

        <div class="container">
            <div class="row gy-4">
                <div class="col-xl-6">
                    <div class="choose-us__content">
                        <div class="mb-40">
                            <div class="flex-align gap-8 mb-16 wow bounceInDown">
                                <span class="w-8 h-8 bg-main-600 rounded-circle"></span>
                                <h5 class="text-main-600 mb-0"><?php echo e($item->shortTitle); ?></h5>
                            </div>
                            <h2 class="mb-24  wow bounceIn"><?php echo e($item->LongTitle); ?></h2>
                            <p class="text-neutral-500 text-line-2  wow bounceInUp"><?php echo e($item->shortdetail); ?></p>
                        </div>

                        <ul>
                            <li class="flex-align gap-12 mb-16" data-aos="fade-up-left" data-aos-duration="200">
                                <span class="flex-shrink-0 text-xl text-main-600 d-flex"><i
                                        class="ph-bold ph-checks"></i></span>
                                <span class="flex-grow-1 text-neutral-500"><?php echo e($item->info1); ?></span>
                            </li>
                            <li class="flex-align gap-12 mb-16" data-aos="fade-up-left" data-aos-duration="400">
                                <span class="flex-shrink-0 text-xl text-main-600 d-flex"><i
                                        class="ph-bold ph-checks"></i></span>
                                <span class="flex-grow-1 text-neutral-500"><?php echo e($item->info2); ?></span>
                            </li>
                            <li class="flex-align gap-12 mb-16" data-aos="fade-up-left" data-aos-duration="500">
                                <span class="flex-shrink-0 text-xl text-main-600 d-flex"><i
                                        class="ph-bold ph-checks"></i></span>
                                <span class="flex-grow-1 text-neutral-500"><?php echo e($item->info3); ?></span>
                            </li>
                        </ul>

                        <div class="pt-24 border-top border-neutral-50 mt-28 border-dashed border-0">
                            <a href="<?php echo e($item->btnLink); ?>" class="btn btn-main rounded-pill flex-align d-inline-flex gap-8">
                                <?php echo e($item->btnTxt); ?>

                                <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                            </a>
                        </div>

                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="choose-us__thumbs position-relative">

                        <div
                            class="offer-message style-two px-24 py-12 rounded-12 bg-white fw-medium flex-align d-inline-flex gap-16 box-shadow-lg animation-upDown">
                            <span
                                class="flex-shrink-0 w-48 h-48 bg-dark-yellow text-white text-2xl flex-center rounded-circle">
                                <img src="<?php echo e(asset('frontend/v2/assets/images/icons/stars.png')); ?>" alt="">
                            </span>
                            <div>
                                <span class="text-lg text-neutral-700 d-block">
                                    <?php echo e($item->Rating); ?>

                                    <span class="text-neutral-100">(<?php echo e($item->Reviews); ?>)</span>
                                </span>
                                <span class="text-neutral-500">AVG Reviews</span>
                            </div>
                        </div>

                        <div class="banner-box one style-two px-24 py-12 rounded-12 bg-white fw-medium box-shadow-lg d-inline-block"
                            data-aos="fade-left">
                            <span class="text-main-600">5k+</span> Enrolled Students
                            <div class="enrolled-students mt-12">
                               
                                    <?php
                                        $stdList = explode(',', $item->stdId);
                                    ?>
                                    <?php $__currentLoopData = $stdList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $student = DB::table('students')->where('id', $val)->first();
                                        ?>
                                        <img src="<?php echo e(asset('storage/' . $student->image)); ?>" alt=""
                                            class="w-48 h-48 rounded-circle object-fit-cover">
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                               
                            </div>
                        </div>

                        <div class="text-end" data-aos="zoom-out">
                            <div class="d-sm-inline-block d-block position-relative">
                                <img src="<?php echo e(asset('storage/' . $item->bgimg1)); ?>" alt=""
                                    class="choose-us__img rounded-12" data-tilt data-tilt-max="16" data-tilt-speed="500"
                                    data-tilt-perspective="5000" data-tilt-full-page-listening>
                                <span
                                    class="shadow-main-two w-80 h-80 flex-center bg-main-two-600 rounded-circle position-absolute inset-block-start-0 inset-inline-start-0 mt-40 ms--40 animation-upDown">
                                    <img src="<?php echo e(asset('frontend/v2/assets/images/icons/book.png')); ?>" alt="">
                                </span>
                            </div>
                        </div>
                        <div class="animation-video" data-aos="zoom-in">
                            <img src="<?php echo e(asset('storage/' . $item->bgimg2)); ?>" alt=""
                                class="border border-white rounded-circle border-3" data-tilt>
                            <a href="<?php echo e($item->video); ?>"
                                class="play-button w-48 h-48 flex-center bg-main-600 text-white rounded-circle text-xl position-absolute top-50 start-50 translate-middle">
                                <i class="ph-fill ph-play"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =========================== CHoose Us Section End ================================ -->


    <!-- ========================== Counter Section start ============================== -->
   
    <section class="counter py-120">
        <div class="container">
            <div class="row gy-4">
                <div class="col-xl-3 col-sm-6 col-xs-6" data-aos="fade-up" data-aos-duration="200">
                    <div
                        class="counter-item animation-item h-100 text-center px-16 py-32 rounded-12 bg-main-25 border border-neutral-30">
                        <span
                            class="w-80 h-80 flex-center d-inline-flex bg-white text-main-600 text-40 rounded-circle box-shadow-md mb-24">
                            <i class="animate__wobble ph ph-users"></i>
                        </span>
                        <h2 class="display-four mb-16 text-neutral-700 counter"><?php echo e($item->successTraing); ?></h2>
                        <span class="text-neutral-500 text-lg">সাকসেসফুল ট্রেইন্ড</span>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-xs-6" data-aos="fade-up" data-aos-duration="400">
                    <div
                        class="counter-item animation-item h-100 text-center px-16 py-32 rounded-12 bg-main-two-25 border border-neutral-30">
                        <span
                            class="w-80 h-80 flex-center d-inline-flex bg-white text-main-two-600 text-40 rounded-circle box-shadow-md mb-24">
                            <i class="animate__wobble ph ph-video-camera"></i>
                        </span>
                        <h2 class="display-four mb-16 text-neutral-700 counter"> <?php echo e($item->completeCourse); ?></h2>
                        <span class="text-neutral-500 text-lg">কোর্স কমপ্লিট</span>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-xs-6" data-aos="fade-up" data-aos-duration="600">
                    <div
                        class="counter-item animation-item h-100 text-center px-16 py-32 rounded-12 bg-main-25 border border-neutral-30">
                        <span
                            class="w-80 h-80 flex-center d-inline-flex bg-white text-main-600 text-40 rounded-circle box-shadow-md mb-24">
                            <i class="animate__wobble ph ph-thumbs-up"></i>
                        </span>
                        <h2 class="display-four mb-16 text-neutral-700 counter"><?php echo e($item->satisfaction); ?></h2>
                        <span class="text-neutral-500 text-lg">স্যাটিসফেকশন রেট</span>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-xs-6" data-aos="fade-up" data-aos-duration="800">
                    <div
                        class="counter-item animation-item h-100 text-center px-16 py-32 rounded-12 bg-main-two-25 border border-neutral-30">
                        <span
                            class="w-80 h-80 flex-center d-inline-flex bg-white text-main-two-600 text-40 rounded-circle box-shadow-md mb-24">
                            <i class="animate__wobble ph ph-users-three"></i>
                        </span>
                        <h2 class="display-four mb-16 text-neutral-700 counter"><?php echo e($item->stdComunity); ?></h2>
                        <span class="text-neutral-500 text-lg">স্টুডেন্ট কমিউনিটি</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    <!-- ========================== Counter Section End ============================== -->

    <!-- ================================= testimonials Section Start ========================================= -->
    <section class="testimonials py-120 position-relative z-1 bg-main-25">
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape2.png' )); ?>" alt="" class="shape six animation-scalation">
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape3.png' )); ?>" alt="" class="shape four animation-rotation">

        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-6">
                    <div class="testimonials__thumbs-slider pe-lg-5 me-xxl-5">
                        <div class="testimonials__thumbs wow bounceIn" data-tilt data-tilt-max="15" data-tilt-speed="500"
                            data-tilt-perspective="5000" data-tilt-full-page-listening>
                            <img src="<?php echo e(asset('frontend/v2/assets/images/thumbs/review-1.jpg')); ?>" alt="">
                        </div>
                        <div class="testimonials__thumbs wow bounceIn" data-tilt data-tilt-max="15" data-tilt-speed="500"
                            data-tilt-perspective="5000" data-tilt-full-page-listening>
                            <img src="<?php echo e(asset('frontend/v2/assets/images/thumbs/review-1.jpg')); ?>" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="testimonials__content">
                        <div class="section-heading style-left">
                            <div class="flex-align gap-8 mb-16 wow bounceInDown">
                                <span class="w-8 h-8 bg-main-600 rounded-circle"></span>
                                <h5 class="text-main-600 mb-0">আমাদের শিক্ষার্থীদের রিভিউ</h5>
                            </div>
                            <h2 class="mb-24 wow bounceIn">ইনোভা প্ল্যাটফর্মের স্যাটিসফাইড শিক্ষার্থীদের সাক্ষাৎকার</h2>
                            <p class="text-neutral-500 text-line-2 wow bounceInUp">ইতোমধ্যে ১০,০০০+ শিক্ষার্থী ইনোভা প্ল্যাটফর্মে প্রশিক্ষণ নিয়েছে</p>
                        </div>

                        <div class="testimonials__slider">
                            
                            <?php $__currentLoopData = $Review; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="testimonials-item">
                                <ul class="flex-align gap-8 mb-16" data-aos="fade-left" data-aos-duration="800">
                                    <?php if($item->rating >= 1 && $item->rating < 2): ?>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star-half"></i></li>
                                    <?php elseif($item->rating >= 2 && $item->rating < 3): ?>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star-half"></i></li>
                                    <?php elseif($item->rating >= 3 && $item->rating < 4): ?>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star-half"></i></li>
                                    <?php elseif($item->rating >= 4 && $item->rating < 5): ?>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star-half"></i></li>
                                    <?php elseif($item->rating >= 5): ?>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <?php endif; ?>
                                    
                                </ul>
                                <p class="text-neutral-700" data-aos="fade-left" data-aos-duration="1200">"<?php echo e($item->msg); ?>”</p>
                                <h4 class="mt-48 mb-8" data-aos="fade-left"> <img src="<?php echo e(asset('storage/' . $item->image)); ?>" alt="<?php echo e($item->stdName); ?>" class="w-48 h-48 rounded-circle object-fit-cover d-inline-block"> &nbsp;<?php echo e($item->stdName); ?></h4>
                                <span class="text-neutral-700" data-aos="fade-left"><?php echo e($item->course); ?></span>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                           
                        </div>
                        <div class="flex-align gap-16 mt-40">
                            <button type="button" id="testimonials-prev"
                                class="slick-prev slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1 w-48 h-48">
                                <i class="ph ph-caret-left"></i>
                            </button>
                            <button type="button" id="testimonials-next"
                                class="slick-next slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1 w-48 h-48">
                                <i class="ph ph-caret-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================================= testimonials Section End ========================================= -->

    <!-- ================================= Blog Section Start ========================================= -->
    <section class="blog py-120 mash-bg-main mash-bg-main-two position-relative">
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape2.png')); ?>" alt="" class="shape two animation-scalation">
        <img src="<?php echo e(asset('frontend/v2/assets/images/shapes/shape6.png')); ?>" alt="" class="shape four animation-scalation">

        <div class="container">
            <div class="section-heading text-center">
                <h2 class="mb-24 wow bounceIn">সাম্প্রতিক প্রবন্ধ</h2>
                <p class="wow bounceInUp">শিক্ষা, প্রযুক্তি এবং ব্যক্তিগত উন্নয়ন নিয়ে আমাদের সর্বশেষ ধারণা, নির্দেশিকা এবং বিশেষজ্ঞ মতামত সম্পর্কে জানুন। দ্রুত পরিবর্তনশীল ডিজিটাল বিশ্বে এগিয়ে থাকার জন্য মূল্যবান তথ্য খুঁজে নিন।</p>
            </div>
            <div class="row gy-4">
                <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
               
                
                <div class="col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="200">
                    <div class="blog-item scale-hover-item bg-main-25 rounded-16 p-12 h-100 border border-neutral-30">
                        <div class="rounded-12 overflow-hidden position-relative">
                            <a href="#" class="w-100 h-100">
                                <img src="<?php echo e(asset('storage/' . $item->image)); ?>" alt="Blog Image"
                                    class="scale-hover-item__img rounded-12 cover-img transition-2">
                            </a>
                        </div>
                        <div class="p-24 pt-32">
                            <div class="">
                                <span class="px-20 py-8 bg-main-two-600 rounded-8 text-white fw-medium mb-20"><?php echo e($item->BlogCategory->categoryName); ?></span>
                                <h4 class="mb-28">
                                    <a href="#" class="link text-line-2"><?php echo e($item->heading); ?></a>
                                </h4>
                                <div class="flex-align gap-14 flex-wrap my-20">
                                    <div class="flex-align gap-8">
                                        <span class="text-neutral-500 text-2xl d-flex"><i
                                                class="ph ph-user-circle"></i></span>
                                        <span class="text-neutral-500 text-lg"><?php echo e(mb_substr($item->writerName, 0, 6, 'UTF-8')); ?></span>
                                    </div>
                                    <span class="w-8 h-8 bg-neutral-100 rounded-circle"></span>
                                    <div class="flex-align gap-8">
                                        <span class="text-neutral-500 text-2xl d-flex"><i
                                                class="ph ph-calendar-dot"></i></span>
                                        <span class="text-neutral-500 text-lg">
                                            <?php echo e(\Carbon\Carbon::parse($item->postDate)->format('d M, Y')); ?>

                                            
                                        </span>
                                    </div>
                                    <span class="w-8 h-8 bg-neutral-100 rounded-circle"></span>
                                    <div class="flex-align gap-8">
                                        <span class="text-neutral-500 text-2xl d-flex"><i
                                                class="ph ph-chat-dots"></i></span>
                                        <span class="text-neutral-500 text-lg"></span>
                                    </div>
                                </div>
                                <p class="text-neutral-500 text-line-2"><?php echo e($item->summary); ?></p>
                            </div>
                            <div class="pt-24 border-top border-neutral-50 mt-28 border-dashed border-0">
                                <a href="#"
                                    class="flex-align gap-8 text-main-600 hover-text-decoration-underline transition-1 fw-semibold"
                                    tabindex="0">
                                    বিস্তারিত পড়ুন
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
    <!-- ================================= Blog Section End ========================================= -->
  
  

<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.v2.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\innova-web\resources\views/frontend/v2/layout/index.blade.php ENDPATH**/ ?>