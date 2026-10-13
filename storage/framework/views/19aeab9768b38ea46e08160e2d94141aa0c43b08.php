<h2 class="section-title">
    ব্যাকগ্রাউন্ড
</h2>

<p>
    Accelerating and Strengthening Skills for Economic Transformation (ASSET)
    প্রকল্পের মূল উদ্দেশ্য হলো অদক্ষ ও আধা দক্ষ জনগোষ্ঠীকে দক্ষ মানবসম্পদে রূপান্তর করা।
    পাশাপাশি সরকারি প্রতিষ্ঠান, বেসরকারি কোম্পানি, এনজিও, ইন্ডাস্ট্রি স্কিল কাউন্সিল
    এবং বিভিন্ন শিল্প সংগঠনকে সহায়তা প্রদান করা।
</p>

<br>

<h2 class="section-title">
    ASSET প্রকল্প সম্পর্কে
</h2>

<p>
    Accelerating and Strengthening Skills for Economic Transformation (ASSET)
    ১৬ মে ২০১৭ সালে অর্থ মন্ত্রণালয়ের অর্থ বিভাগের অধীনে Companies Act, 1994 অনুযায়ী প্রতিষ্ঠিত হয়।
    ASSET একটি “not-for-profit entity” হিসেবে নিবন্ধিত, যার লক্ষ্য দেশে দক্ষতা উন্নয়নে
    অর্থায়ন করা।
    এই প্রকল্পের মাধ্যমে সরকারি ও বেসরকারি প্রশিক্ষণ প্রতিষ্ঠানগুলোকে আর্থিক সহায়তা প্রদান করা হয়,
    যাতে তারা বাজার উপযোগী দক্ষতা উন্নয়ন প্রশিক্ষণ প্রদান করতে পারে।
</p>

<br>

<h2 class="section-title">
    INNOVA Computers Institute with ASSET Project
</h2>

<p>
    INNOVA Computers Institute হলো National Skills Development Authority (NSDA)
    এর অধীন একটি Skills Training Provider (STP) এবং Bangladesh Technical Education Board (BTEB)
    অনুমোদিত Registered Training Organization (RTO)।
    আমাদের লক্ষ্য বাংলাদেশের আইটি খাতে আন্তর্জাতিক মানের প্রশিক্ষণ প্রদান করে দক্ষ মানবসম্পদ তৈরি করা।
    সম্প্রতি INNOVA Computers Institute, ASSET Project এর সাথে একটি সমঝোতা স্মারক (MoU)
    স্বাক্ষর করেছে।
</p>

<?php
    $assetCourses = $assetCourses ?? \App\Models\AssetCourse::where('status', true)->get();
?>

<ul>
    <?php $__empty_1 = true; $__currentLoopData = $assetCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <li><?php echo e($course->name); ?></li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <li>No courses available at the moment.</li>
    <?php endif; ?>
</ul>

<p>
    এই প্রশিক্ষণের মাধ্যমে তরুণদের ফ্রিল্যান্সিং ও কর্মসংস্থানের জন্য দক্ষ করে গড়ে তোলা হবে।
</p>

<br>

<h2 class="section-title">
    আমাদের কোর্সসমূহ
</h2>

<div class="table-responsive">

    <table class="table table-bordered course-table">

        <thead>

            <tr>
                <th>কোর্সের নাম</th>
                <th width="180">কোর্স আউটলাইন</th>
            </tr>

        </thead>

        <tbody>
    <?php $__empty_1 = true; $__currentLoopData = $assetCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><?php echo e($course->name); ?></td>
            <td>
                <?php if($course->course_outline): ?>
                    <a href="<?php echo e(asset('storage/' . $course->course_outline)); ?>" target="_blank" class="btn btn-primary btn-sm">View</a>
                <?php else: ?>
                    <button class="btn btn-secondary btn-sm" disabled>No outline</button>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="2" class="text-center">No courses available at the moment.</td>
        </tr>
    <?php endif; ?>
</tbody>

    </table>

</div>

<br>

<h2 class="section-title">
    বিশেষ সুবিধাসমূহ
</h2>

<ul>

    <li>
        সকল প্রশিক্ষণ সম্পূর্ণ ফ্রি।
    </li>

    <li>
        ন্যূনতম যোগ্যতা SSC / সমমান পাস।
    </li>

    <li>
        একজন প্রশিক্ষণার্থী শুধুমাত্র একটি কোর্স করতে পারবে।
    </li>

    <li>
        ASSET এর নিয়ম অনুযায়ী ভাতা প্রদান করা হবে।
    </li>

    <li>
        প্রশিক্ষণ শেষে উপস্থিতির ভিত্তিতে মোবাইল ব্যাংকিং এর মাধ্যমে ভাতা প্রদান করা হবে।
    </li>

    <li>
        ভাতা পেতে কমপক্ষে ৮০% উপস্থিতি এবং মূল্যায়নে অংশগ্রহণ বাধ্যতামূলক।
    </li>

    <li>
        নারী ও বিশেষ চাহিদাসম্পন্নদের আবেদন করতে উৎসাহিত করা হচ্ছে।
    </li>

    <li>
        ১৮-৪৫ বছর বয়সী যুবক-যুবতীরা আবেদন করতে পারবে।
    </li>

    <li>
        প্রশিক্ষণগুলো INNOVA Computers Institute এ পরিচালিত হবে।
    </li>

    <li>
        প্রশিক্ষণে অংশগ্রহণের জন্য নির্বাচনী প্রক্রিয়া থাকবে।
    </li>

</ul>

<br>

<h2 class="section-title">
    অভিযোগ ব্যবস্থাপনা
</h2>

<p>
    ASSET সম্পর্কিত যেকোনো সমস্যার জন্য অভিযোগ করতে পারবেন। যেমন:
</p>

<ul>

    <li>রেজিস্ট্রেশন সংক্রান্ত সমস্যা</li>

    <li>ভর্তি সংক্রান্ত সমস্যা</li>

    <li>ম্যানেজমেন্ট সংক্রান্ত সমস্যা</li>

    <li>ক্লাস চলাকালীন ট্রেইনার সংক্রান্ত সমস্যা</li>

    <li>কোর্স কারিকুলাম সংক্রান্ত সমস্যা</li>

    <li>অন্যান্য যেকোনো সমস্যা</li>

</ul>

<p>
    নিচের লিংকের মাধ্যমে অভিযোগ জমা দিতে পারবেন।
    আমাদের ম্যানেজমেন্ট সরাসরি আপনার সাথে যোগাযোগ করবে।
    আপনার পরিচয় গোপন রাখা হবে।
</p>

<button class="custom-btn" style="margin-top: 20px !important;">
    অভিযোগ জমা দিন
</button><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/frontend/v2/asset/partials/overview.blade.php ENDPATH**/ ?>