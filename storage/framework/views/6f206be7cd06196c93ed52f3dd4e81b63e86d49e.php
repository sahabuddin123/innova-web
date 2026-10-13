
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
                        <h1 class="breadcrumb__title display-4 fw-semibold text-center"> যোগাযোগ</h1>
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
                                <span class="text-main-two-600"> যোগাযোগ </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- ==================== Breadcrumb End Here ==================== -->
    <!-- =============================== Contact Section Start ================================== -->
    <section class="contact py-120">
        <div class="container">
            <div class="section-heading text-center">
                <div class="flex-align d-inline-flex gap-8 mb-16">
                    <span class="text-main-600 text-2xl d-flex"><i class="ph-bold ph-book"></i></span>
                    <h5 class="text-main-600 mb-0">আমাদের সাথে যোগাযোগ করুন</h5>
                </div>
                <h2 class="mb-24">আমরা আপনাকে সাহায্য করতে পারি</h2>
                <p class="">আমাদের প্ল্যাটফর্মটি উদ্ভাবন, গুণগত মান এবং অন্তর্ভুক্তির নীতিমালায় নির্মিত, যার লক্ষ্য
                    সুদক্ষ শিক্ষাদান প্রদান করা।</p>
            </div>
            <div class="row gy-4">
                <div class="col-xl-4 col-md-6">
                    <div
                        class="contact-item bg-main-25 border border-neutral-30 rounded-12 px-32 py-40 d-flex align-items-start gap-24 hover-bg-main-600 transition-2 hover-border-main-600">
                        <span
                            class="contact-item__icon w-60 h-60 text-32 flex-center rounded-circle bg-main-600 text-white flex-shrink-0">
                            <i class="ph ph-map-pin-line"></i>
                        </span>
                        <div class="flex-grow-1">
                            <h4 class="mb-12">শাখা সমূহ</h4>
                            <p class="text-neutral-500"> <b>প্রধান অফিস </b> মাস্টারপাড়া সেন্ট্রাল পয়েন্ট, চরবাটা,
                                সুবর্ণচর - ৩৮১৩ </p>
                            <p class="text-neutral-500"> <b>ব্রাঞ্চ অফিস </b>কলেজ রোড, মাওলা স্টোরের ২য় তলা, খাসেরহাট - ৩৮১৩
                            </p>
                            <a href="javascript:void(0)"
                                class="text-main-600 fw-semibold text-decoration-underline mt-16">লোকেশন খুঁজুন</a>
                        </div>
                        
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div
                        class="contact-item bg-main-25 border border-neutral-30 rounded-12 px-32 py-40 d-flex align-items-start gap-24 hover-bg-main-600 transition-2 hover-border-main-600">
                        <span
                            class="contact-item__icon w-60 h-60 text-32 flex-center rounded-circle bg-main-600 text-white flex-shrink-0">
                            <i class="ph ph-envelope-open"></i>
                        </span>
                        <div class="flex-grow-1">
                            <h4 class="mb-12">ই-মেইল এড্রেস</h4>
                            <p class="text-neutral-500">innovacomputersbd@gmail.com</p>
                            <p class="text-neutral-500">innovacom.ae@gmail.com</p>
                            <p class="text-neutral-500">innovacom.hr@gmail.com</p>
                            <p class="text-neutral-500">info@innovacomputersbd.com</p>
                            <a href="mailto:innovacomputersbd@gmail.com"
                                class="text-main-600 fw-semibold text-decoration-underline mt-16">যোগাযোগ করুন</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div
                        class="contact-item bg-main-25 border border-neutral-30 rounded-12 px-32 py-40 d-flex align-items-start gap-24 hover-bg-main-600 transition-2 hover-border-main-600">
                        <span
                            class="contact-item__icon w-60 h-60 text-32 flex-center rounded-circle bg-main-600 text-white flex-shrink-0">
                            <i class="ph ph-phone-call"></i>
                        </span>
                        <div class="flex-grow-1">
                            <h4 class="mb-12">ফোন নম্বর</h4>
                            <p class="text-neutral-500">(+880) 1844-463954</p>
                            <p class="text-neutral-500">(+880) 1844-463962</p>
                            <p class="text-neutral-500">(+880) 1844-463964</p>
                            <p class="text-neutral-500">(+880) 1867-033550</p>
                            <a href="tel:(+880)1844-463954"
                                class="text-main-600 fw-semibold text-decoration-underline mt-16">আজই আমাদের সাথে যোগাযোগ
                                করুন!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =============================== Contact Section End ================================== -->

    <!-- ====================== Contact Form Section Start ========================= -->
    <section class="contact-form-section py-240 bg-main-25 position-relative z-1">
        <img src="<?php echo e(asset('frontend/v2/assets/images/bg/wave-bg.png')); ?>" alt=""
            class="position-absolute top-0 start-0 w-100 h-100 z-n1 d-lg-block d-none">
        <div class="container">
            <div class="row gy-5 align-items-center">
                <div class="col-xl-7 col-lg-6 pe-lg-5">
                    <div class="mb-40 md-xl-5">
                        <div class="flex-align d-inline-flex gap-8 mb-16">
                            <span class="text-main-600 text-2xl d-flex"><i class="ph-bold ph-book"></i></span>
                            <h5 class="text-main-600 mb-0">আমাদের সাথে যোগাযোগ করুন</h5>
                        </div>
                        <h2 class="mb-24">কোনো প্রশ্ন থাকলে, দ্বিধা না করে আমাদের সাথে যোগাযোগ করুন।</h2>
                        <p class="text-neutral-500 text-line-3 max-w-636">যে কোনো প্রয়োজনে যোগাযোগ করতে সরাসরি আমাদের অফিস
                            ভিজিট করতে পারেন। তাছাড়া হটলাইন নম্বরে কল করে জেনে নিতে পারেন ট্রেইনিং সংক্রান্ত যেকোনো তথ্য।
                            এছাড়াও উল্লেখিত মেইলে কিংবা ফেসবুক ম্যাসেঞ্জারেও নক দিতে পারেন।</p>
                    </div>
                    <div class="flex-align gap-40 flex-wrap">
                        <div class="enrolled-students mt-12 d-block">
                            <?php $__currentLoopData = $cmsAbout; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $stdList = explode(',', $item->stdId);
                                ?>
                                <?php $__currentLoopData = $stdList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $student = DB::table('students')->where('id', $val)->first();
                                    ?>
                                    <img src="<?php echo e(asset('storage/app/public/' . $student->image)); ?>" alt=""
                                        class="w-48 h-48 rounded-circle object-fit-cover">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="">
                            <ul class="flex-align gap-4 mb-10">
                                <li class="text-warning-600 text-2xl d-flex"><i class="ph-fill ph-star"></i></li>
                                <li class="text-warning-600 text-2xl d-flex"><i class="ph-fill ph-star"></i></li>
                                <li class="text-warning-600 text-2xl d-flex"><i class="ph-fill ph-star"></i></li>
                                <li class="text-warning-600 text-2xl d-flex"><i class="ph-fill ph-star"></i></li>
                                <li class="text-warning-600 text-2xl d-flex"><i class="ph-fill ph-star-half"></i></li>
                            </ul>
                            <span class="text-neutral-700 fw-medium"> 2.5k+ reviews (4.95 of 5)</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6">
                    <div class="p-24 bg-white rounded-12 box-shadow-md">
                        <div class="border border-neutral-30 rounded-8 bg-main-25 p-24">
                            
                            <form action="<?php echo e(route('contact.store')); ?>" class="row" id="commentForm" method="POST">
                                <h4 class="mb-0">যোগাযোগ করুন</h4>
                                <span class="d-block border border-neutral-30 my-24 border-dashed"></span>
                                <?php echo csrf_field(); ?>
                                <div class="mb-24">
                                    <label for="username" class="text-neutral-700 text-lg fw-medium mb-12">আপনার পূর্ণ নাম
                                        <span class="text-danger">*</span></label>
                                    <input type="text"
                                        class="common-input rounded-pill border-transparent focus-border-main-600  <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="username" name="username" placeholder="এখানে আপনার পুরো নাম লিখুন।"
                                        value="<?php echo e(old('username')); ?>">
                                    <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <?php echo e($message); ?>

                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="mb-24">
                                    <label for="phone" class="text-neutral-700 text-lg fw-medium mb-12">মোবাইল
                                        নম্বর<span class="text-danger">*</span></label>
                                    <input type="tel"
                                        class="common-input rounded-pill border-transparent focus-border-main-600  <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="phone" name="phone" placeholder="এখানে আপনার ফোন নম্বর লিখুন।"
                                        value="<?php echo e(old('phone')); ?>">
                                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <?php echo e($message); ?>

                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="mb-24">
                                    <label for="email" class="text-neutral-700 text-lg fw-medium mb-12">ই-মেইল এড্রেস
                                        <span class="text-secondary">(if any)</span></label>
                                    <input type="email"
                                        class="common-input rounded-pill border-transparent focus-border-main-600  <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="email" name="email" placeholder="এখানে আপনার ইমেইল লিখুন।"
                                        value="<?php echo e(old('email')); ?>">
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <?php echo e($message); ?>

                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="mb-24">
                                    <label for="courseId" class="text-neutral-700 text-lg fw-medium mb-12">আপনি কি কোনো
                                        কোর্স সম্পর্কে জানতে চান? <span class="text-danger">*</span></label>
                                    <select name="courseId" id="courseId"
                                        class="common-input rounded-pill border-transparent focus-border-main-600  <?php $__errorArgs = ['courseId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option value="">-- কোর্স নির্বাচন করুন --</option>
                                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($course->id); ?>"
                                                <?php if(old('courseId') == $course->id): ?> <?php echo e('selected'); ?> <?php endif; ?>>
                                                <?php echo e($course->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['courseId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <?php echo e($message); ?>

                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="mb-24">
                                    <label for="msg" class="text-neutral-700 text-lg fw-medium mb-12">বিস্তারিত তথ্য
                                        দিন <span class="text-danger">*</span></label>
                                    <textarea name="msg" id="msg"
                                        class="common-input rounded-24 border-transparent focus-border-main-600 h-110  <?php $__errorArgs = ['msg'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="আপনার বার্তা" value="<?php echo e(old('msg')); ?>"></textarea>
                                    <?php $__errorArgs = ['msg'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <?php echo e($message); ?>

                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-12 mb-2">
                                    <!-- Google reCaptcha v2 -->
                                    <?php echo htmlFormSnippet(); ?>

                                    <?php if($errors->has('g-recaptcha-response')): ?>
                                        <div>
                                            <small
                                                class="text-danger"><?php echo e($errors->first('g-recaptcha-response')); ?></small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-0">
                                    <button type="submit" class="btn btn-main rounded-pill flex-center gap-8 mt-40">
                                        বার্তা প্রেরণ করুন
                                        <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ====================== Contact Form Section End ========================= -->
    
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <!--<?php echo htmlScriptTagJsApi(); ?>-->
<?php $__env->stopPush(); ?>

<?php echo $__env->make('frontend.v2.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/frontend/v2/layout/contact.blade.php ENDPATH**/ ?>