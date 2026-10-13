
<?php $__env->startSection('title'); ?>
    <?php echo e($pageTitle); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <!-- ==================== Breadcrumb End Here ==================== -->
    
    <link href="<?php echo e(asset('frontend/assets/css/course.css')); ?>" rel="stylesheet">
    <style>
        .animation-video {
            position: static !important;
        }
    </style>
    <!-- =============================== Courses Section Start ================================== -->
    <section class="section" id="profe_graphic_banner">
        <div class="pink_shape">
            <img class="img-fluid" src="<?php echo e(asset('public/storage/background/Pg_banner_shape2.png')); ?>" alt="pink color victor shape">
        </div>
        <div class="white_dots">
            <img class="img-fluid" src="<?php echo e(asset('public/storage/background/Pg_banner_shape4.png')); ?>"
                alt="white color dots victor">
        </div>
        <div class="yellow_shape">
            <img class="img-fluid" src="<?php echo e(asset('public/storage/background/Pg_banner_shape1.png')); ?>"
                alt="Yellow color victor shape">
        </div>
        <div class="container">
            <?php if(\Session::has('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo \Session::get('success'); ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            <?php
                function englishToBanglaNumber($number, $decimals = 2)
                {
                    $engNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '.', ','];
                    $banNumbers = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '.', ','];

                    // Format the number with the specified number of decimals
                    $formattedNumber = number_format($number, $decimals, '.', ',');

                    return str_replace($engNumbers, $banNumbers, $formattedNumber);
                }
                function englishToBanglaNumbertwo($number)
                {
                    $engNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '.', ','];
                    $banNumbers = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '.', ','];

                    return str_replace($engNumbers, $banNumbers, $number);
                }
            ?>
            <!-- course list -->
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6">
                    <div class="pg_banner_text">
                        <h4><?php echo e($courses->shortTitle); ?> </h4>
                        <h1><?php echo e($courses->name); ?></h1>
                        <ul>
                            <li>মেয়াদ<span><?php echo e(englishToBanglaNumbertwo($courses->courseduration)); ?> মাস</span></li>
                            <li>লেকচার<span><?php echo e(englishToBanglaNumbertwo($courses->lacture)); ?>+</span></li>
                            <li>মডিউল<span><?php echo e(englishToBanglaNumbertwo($courses->totalmoduls)); ?></span></li>
                            <li>প্রজেক্ট<span><?php echo e(englishToBanglaNumbertwo($courses->totalproject)); ?>+</span></li>
                        </ul>
                        <div class="course_desc_article">
                            <?php echo $courses->description; ?>

                        </div>
                        <div class="pg_banner_btn">
                            <a href="<?php echo e(route('frontend.course.admission', $courses->id)); ?>">ভর্তি</a>
                            <a href="<?php echo e(route('frontend.seminors')); ?>">ফ্রি সেমিনার</a>
                        </div>
                        <div class="stars">
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 pg_banner_img_col">
                    <div class="pg_banner_img position-relative" style="z-index: 1">
                        <?php if($courses->video == null): ?>
                            <a href="https://www.youtube.com/watch?v=v-Yi2RRNS3A&t=12s"
                                class="play-button w-48 h-48 flex-center bg-main-600 text-white rounded-circle text-xl position-absolute top-50 start-50 translate-middle">
                                <i class="ph-fill ph-play"></i>
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e($courses->video); ?>"
                                class="play-button w-48 h-48 flex-center bg-main-600 text-white rounded-circle text-xl position-absolute top-50 start-50 translate-middle">
                                <i class="ph-fill ph-play"></i>
                            </a>
                        <?php endif; ?>
                        <img class="img-fluid w-100 video_thumb" src="<?php echo e(asset('public/storage/' . $courses->image)); ?>"
                            alt="">

                        </a>
                    </div>
                    <div class="yellow_dots_right">
                        <img src="<?php echo e(asset('public/storage/background/Pg_banner_shape3.png')); ?>" alt="Yellow color dots"
                            style="z-index: -1">
                    </div>
                    <div class="yellow_dot_left">
                        <img src="<?php echo e(asset('public/storage/background/Pg_banner_shape3.png')); ?>" alt="Yellow color dots"
                            style="z-index: -1">
                    </div>
                </div>
            </div>
    </section>
    <section id="pg_course_overviwe">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="course_overviwe_text">
                        <?php echo $courses->overview; ?>

                    </div>
                    <div class="sm_device-show d-block d-sm-none">
                        <div class="pg_succsess_story">
                            <div class="heading">
                                <h4><span>সাফল্যের গল্প</span> <span><a href="<?php echo e(route('frontend.successstory')); ?>">আরো
                                            দেখুন</a></span></h4>
                            </div>
                            <div class="pg_succsess_img_slider slick-initialized slick-slider slick-dotted"><i
                                    class="fa fa-angle-left angle-left slick-arrow" style="display: block;"></i>
                                    <div class="review-slider">
                                        <?php if(!empty($story)): ?>
                                        <?php $__currentLoopData = $story; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="rounded-12 text-center transition-2 item-hover bg-main-25 hover-bg-main-600">
                                                <div
                                                    class="instructor-item scale-hover-item bg-white rounded-16 p-12 h-100 border border-neutral-30">
                                                    <div class="animation-video" data-aos="zoom-in">
                                                        <img src="<?php echo e(asset('public/storage/' . $item->image)); ?>" alt=""
                                                            class="border border-white border-3">
                                                        <a href="<?php echo e($item->video); ?>"
                                                            class="play-button w-48 h-48 flex-center bg-main-600 text-white rounded-circle text-xl position-absolute top-50 start-50 translate-middle">
                                                            <i class="ph-fill ph-play"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </div>
                            </div>
                        </div>
                        <div class="pg_wait_wrap pg_wait_sticky">
                            <div class="pg_wait">
                                <h3>ভর্তি চলছে!!</h3>
                                <p>
                                    অফলাইন (সরাসরি ইনস্টিটিউট) বা অনলাইন (লাইভ ক্লাস) - আপনি আপনার সুবিধামত এবং এখন যে কোনও
                                    ব্যাচে ভর্তি হতে পারেন।
                                </p>
                                <div class="join_offline_main">
                                    <div class="join_offline">
                                        <h4>Course Fee (Offline)</h4>
                                        <p>৳ <?php echo e($courses->coursefee); ?> BDT
                                        </p><a href="<?php echo e(route('frontend.course.admission', $courses->id)); ?>">ভর্তি</a>
                                    </div>
                                    <div class="join_offline">
                                        <h4>Course Fee (Online)</h4>
                                        <p>
                                            <?php
                                                $discount = ($courses->coursefee * 40) / 100;
                                            ?>
                                            ৳ <?php echo e($courses->coursefee - $discount); ?> BDT
                                        </p>
                                        <a href="<?php echo e(route('frontend.course.admission', $courses->id)); ?>">ভর্তি</a>
                                    </div>
                                </div>
                                <div class="wait_btn text-center"><a href="#">ফ্রি সেমিনার</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="pgc_curriculum_wrap">
                        <?php echo $courses->curriculum; ?>

                    </div>
                    <div class="pgc_software">
                        <?php echo $courses->software; ?>

                    </div>
                    <div class="pgc_for_whom">
                        <?php echo $courses->trainee; ?>

                    </div>
                    <div class="pg_marketplace">
                        <?php echo $courses->jobPlacement; ?>

                    </div>
                    <div class="pg_job">
                        <?php echo $courses->jobPosition; ?>

                    </div>
                    
                </div>
                <div id="sidebar" class="col-lg-5 d-none d-sm-block">
                    <div class="pg_succsess_story">
                        <div class="heading">
                            <h4><span>সাফল্যের গল্প</span> <span><a href="<?php echo e(route('frontend.successstory')); ?>">আরো
                                        দেখুন</a></span></h4>
                        </div>
                        <div class="pg_succsess_img_slider slick-initialized slick-slider slick-dotted"><i
                                class="fa fa-angle-left angle-left slick-arrow" style="display: block;"></i>
                           
                            <div class="review-slider">
                                <?php if(!empty($story)): ?>
                                <?php $__currentLoopData = $story; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="rounded-12 text-center transition-2 item-hover bg-main-25 hover-bg-main-600">
                                        <div
                                            class="instructor-item scale-hover-item bg-white rounded-16 p-12 h-100 border border-neutral-30">
                                            <div class="animation-video" data-aos="zoom-in">
                                                <img src="<?php echo e(asset('public/storage/' . $item->image)); ?>" alt=""
                                                    class="border border-white border-3">
                                                <a href="<?php echo e($item->video); ?>"
                                                    class="play-button w-48 h-48 flex-center bg-main-600 text-white rounded-circle text-xl position-absolute top-50 start-50 translate-middle">
                                                    <i class="ph-fill ph-play"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="pg_wait_wrap pg_wait_sticky">
                        <div class="pg_wait">
                            <h3>ভর্তি চলছে!!</h3>
                            <p>
                                অফলাইন (সরাসরি ইনস্টিটিউট) বা অনলাইন (লাইভ ক্লাস) - আপনি আপনার সুবিধামত এবং এখন যে কোনও
                                ব্যাচে ভর্তি হতে পারেন।
                            </p>


                            <div class="join_offline_main">
                                <div class="join_offline">
                                    <h4>কোর্স ফি (অফলাইন)</h4>
                                    <p>৳ <?php echo e(englishToBanglaNumber($courses->coursefee)); ?> টাকা</p>
                                    <a href="<?php echo e(route('frontend.course.admission', $courses->id)); ?>">ভর্তি</a>
                                </div>
                                <div class="join_offline">
                                    <h4>কোর্স ফি (অনলাইন)</h4>
                                    <p>
                                        <?php
                                            $discount = ($courses->coursefee * 40) / 100;
                                        ?>
                                        ৳ <?php echo e(englishToBanglaNumber($courses->coursefee - $discount)); ?> টাকা
                                    </p>
                                    <a href="<?php echo e(route('frontend.course.admission', $courses->id)); ?>">ভর্তি</a>
                                </div>
                            </div>
                            <div class="wait_btn text-center"><a href="<?php echo e(route('frontend.seminors')); ?>">ফ্রি সেমিনার</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =============================== Courses Section End ================================== -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.v2.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/frontend/v2/layout/courseDetails.blade.php ENDPATH**/ ?>