@extends('frontend.v2.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <!-- ==================== Breadcrumb Start Here ==================== -->
    <section class="breadcrumb py-120 bg-main-25 position-relative z-1 overflow-hidden mb-0">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape1.png') }}" alt=""
            class="shape one animation-rotation d-md-block d-none">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape2.png') }}" alt=""
            class="shape two animation-scalation d-md-block d-none">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape3.png') }}" alt=""
            class="shape eight animation-walking d-md-block d-none">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape5.png') }}" alt=""
            class="shape six animation-walking d-md-block d-none">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape4.png') }}" alt=""
            class="shape four animation-scalation">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape4.png') }}" alt=""
            class="shape nine animation-scalation">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb__wrapper">
                        <h1 class="breadcrumb__title display-4 fw-semibold text-center"> আপনার প্রশ্নসমূহ</h1>
                        <ul class="breadcrumb__list d-flex align-items-center justify-content-center gap-4">
                            <li class="breadcrumb__item">
                                <a href="{{ route('frontend.home') }}"
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
                                <span class="text-main-two-600"> আপনার প্রশ্নসমূহ </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== Breadcrumb End Here ==================== -->
    <!-- =============================== FAQ Page Section Start ================================== -->
    <section class="faq-page py-120">
        <div class="container">
            <div class="section-heading text-center">
                <div class="flex-align d-inline-flex gap-8 mb-16">
                    <span class="text-main-600 text-2xl d-flex"><i class="ph-bold ph-book"></i></span>
                    <h5 class="text-main-600 mb-0">আপনার প্রশ্নসমূহ</h5>
                </div>
                {{-- <h2 class="mb-24">Find Answers to Your Questions</h2> --}}
                <p class="">যে প্রতিষ্ঠানে হাতেখড়ি হতে যাচ্ছে আপনার ক্যারিয়ারের, সেই ইনোভা কম্পিউটার্স সম্পর্কে আপনার
                    মনে নিশ্চয়ই অনেক প্রশ্ন রয়েছে। আপনার সব প্রশ্নের উত্তর দিতে আমরা সদা প্রস্তুত। দক্ষ কোয়ালিটি টিম আর
                    এডমিশন ডিপার্টমেন্টের সদস্যদের কাছে আপনি পাবেন আপডেটেড তথ্য। তাছাড়া কোর্স মডিউল, সেমিনার, কোর্স ফি বা
                    ইনোভা কম্পিউটার্স সম্পর্কে বিভিন্ন তথ্য পাবেন আমাদের ওয়েবসাইটেও।</p>
            </div>

            {{-- <div class="text-center mb-40">
                <ul class="nav nav-pills common-tab d-inline-flex gap-16 bg-white p-12 border border-neutral-30 rounded-pill" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill bg-main-25 text-md fw-medium text-neutral-500 flex-center w-100 gap-8 active" id="pills-onlineEdu-tab" data-bs-toggle="pill" data-bs-target="#pills-onlineEdu" type="button" role="tab" aria-controls="pills-onlineEdu" aria-selected="true">
                            <i class="text-xl text-main-600 d-flex ph-bold ph-user"></i>
                            Online Education
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill bg-main-25 text-md fw-medium text-neutral-500 flex-center w-100 gap-8" id="pills-paymentMethod-tab" data-bs-toggle="pill" data-bs-target="#pills-paymentMethod" type="button" role="tab" aria-controls="pills-paymentMethod" aria-selected="false">
                            <i class="text-xl text-main-600 d-flex ph-bold ph-graduation-cap"></i>
                            Payment Method
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill bg-main-25 text-md fw-medium text-neutral-500 flex-center w-100 gap-8" id="pills-Pricing-tab" data-bs-toggle="pill" data-bs-target="#pills-Pricing" type="button" role="tab" aria-controls="pills-Pricing" aria-selected="false">
                            <i class="text-xl text-main-600 d-flex ph-bold ph-star"></i>
                            Pricing Plan
                        </button>
                    </li>
                </ul>
            </div> --}}


            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-onlineEdu" role="tabpanel"
                    aria-labelledby="pills-onlineEdu-tab" tabindex="0">
                    <div class="row gy-4">
                        <div class="col-lg-6">
                            <div class="accordion common-accordion" id="accordionExampleOne">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            আপনারা কি আয় করিয়ে দিবেন?
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        data-bs-parent="#accordionExampleOne">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">আয় করার ব্যাপারটি নির্ভর করে আপনার নিজের কোন
                                                একটি বিষয় ভিত্তিক দক্ষতা ও যোগ্যতার উপর। আমরা আপনাকে নির্দিষ্ট কোর্স, তার
                                                সাথে সম্পর্কিত মার্কেটপ্লেস এবং মার্কেটপ্লেসে কি উপায়ে কাজ পাওয়া যায় সেই
                                                বিষয়ে প্রশিক্ষণ ও সঠিক গাইডলাইন দিয়ে সাহায্য করবো। কিন্তু এই বিষয়গুলোকে কাজে
                                                লাগিয়ে সময়, পরিশ্রম এবং ধৈর্যের মাধ্যমে আয় আপনার নিজেকেই করতে হবে। আর আয়ের
                                                বিষয়টি আপনি একটি কাজের প্রতি কতটা পরিশ্রম এবং সময় দিচ্ছেন তার উপর নির্ভরশীল।
                                                শুধু ফ্রিল্যান্সিং করেই যে আয় করতে হবে ব্যাপারটি এমন নয়। আপনি লোকাল
                                                ক্লায়েন্ট হান্ট করে, রিমোট জব করে অথবা নিজে ব্যবসা করেও আয় করতে পারেন।</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            অনলাইন কোর্স কিভাবে করান? শুধু কি ভিডিও দিবেন?
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleOne">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">আমাদের অনলাইন কোর্সগুলো লাইভ ক্লাসের মাধ্যমে হয়ে
                                                থাকে। ট্রেইনাররা জুম সফটওয়্যারের মাধ্যমে ক্লাসগুলো অনলাইনে পরিচালনা করে
                                                থাকেন। এছাড়া ক্লাস রেকর্ড দিয়ে দেয়া হয় যেন আপনি পরবর্তীতে সেগুলো প্র্যাকটিস
                                                করতে পারেন। ক্লাস রেকর্ড ছাড়াও পরবর্তীতে কোন সমস্যা হলে আপনি ব্যাকআপ
                                                সাপোর্টও নিতে পারবেন।</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            আপনাদের এইখানে কোর্স করে কি শুধু অনলাইন মার্কেটে কাজ পাওয়া যায়?
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleOne">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">শুধু অনলাইন মার্কেটে ফ্রিল্যান্সিং করেই যে আয়
                                                করতে হবে ব্যাপারটি এমন নয়। একটি কোর্স সম্পন্ন করে আপনি অনলাইন মার্কেটে
                                                ফ্রিল্যান্সার হিসেবে কাজ করার পাশাপাশি আপনি আমাদের কাছে আপনার CV দিয়ে রাখতে
                                                পারেন। কোর্স শেষে আমাদের নিজস্ব ক্যারিয়ার প্লেসমেন্ট সেল এর মাধ্যমে আমরা
                                                বিভিন্ন কোম্পানিতে আমাদের শিক্ষার্থীদের রেফার করে থাকি। আপনি যদি নিয়মিত
                                                ক্লাস করেন, সব প্রজেক্ট ও পরীক্ষা দেয়ার মাধ্যমে একটি কোর্সটি ভালোভাবে
                                                সম্পন্ন করেন, সেক্ষেত্রে আমাদের ক্যারিয়ার প্লেসমেন্ট ডিপার্ট্মেন্টের মাধ্যমে
                                                আপনার চাকরি পাওয়ার একটি দূর্দান্ত সুযোগ থাকবে।</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseFour" aria-expanded="false"
                                            aria-controls="collapseFour">
                                            আপনারা কি সার্টিফিকেট দিবেন?
                                        </button>
                                    </h2>
                                    <div id="collapseFour" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleOne">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">আপনি যদি কোর্স শেষে সফলতার সাথে চূড়ান্ত
                                                মূল্যায়নে উত্তীর্ণ হয়ে থাকেন তাহলে আপনি সার্টিফিকেট পাবেন। এবং কোর্স শেষে
                                                আপনি একটি অ্যাসেসমেন্ট দিয়ে সরকারি কারিগরি শিক্ষা বোর্ডের অধীনে সার্টিফিকেট
                                                পেতে পারেন।</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFive1"
                                            aria-expanded="false" aria-controls="collapseFive">
                                            কোর্স ফি কি একবারে দিতে হয়?/ কিস্তিতে কিভাবে কোর্স ফি পরিশোধ করব?
                                        </button>
                                    </h2>
                                    <div id="collapseFive1" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleOne">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">আপনি চাইলে পুরো কোর্স ফি একবারে দিতে পারবেন
                                                কিংবা আপনি কোর্স ফি ৪টি কিস্তিতে পরিশোধ করতে পারবেন ২৫-৩০ দিন অন্তর অন্তর।
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFive2"
                                            aria-expanded="false" aria-controls="collapseFive">
                                            আমি মাসে কত টাকা আয় করতে পারব?
                                        </button>
                                    </h2>
                                    <div id="collapseFive2" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleOne">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">ইনকাম সম্পূর্ণভাবে নির্ভর করবে আপনি কতটা দক্ষ
                                                আর একটি কাজের পেছনে কতটা সময় ব্যয় করছেন, তার উপর। অন্যের সাথে নিজেকে তুলনা
                                                করে প্রথমে নির্দিষ্ট ইনকামের এমাউন্ট নির্ধারণ করে কাজ শেখা উচিৎ নয়। আপনাকে
                                                সবচেয়ে প্রথমে আপনার কাজের দক্ষতা নিশ্চিত করতে হবে। তাই আয় এর ভাবনার আগে আপনি
                                                নিজেকে দক্ষ করে তোলা বেশি জরুরী। আপনি যদি ধৈর্যের সাথে আগ্রহ নিয়ে আমাদের
                                                মেন্টরের গাইডলাইন ফলো করে চলতে থাকেন তাহলে অবশ্যই অল্প সময়েই আশানুরুপ আয়
                                                করতে সক্ষম হবেন।
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFive3"
                                            aria-expanded="false" aria-controls="collapseFive">
                                            ইনোভা কম্পিউটার্স বিডি এর বিশেষ সুবিধা গুলো কি কি?
                                        </button>
                                    </h2>
                                    <div id="collapseFive3" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleOne">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">আমাদের দায়িত্ব কিন্তু কেবল প্রশিক্ষণ দেওয়ার
                                                মাঝেই সীমাবদ্ধ নয়। আমাদের বেশ কিছু বিশেষ সুবিধা রয়েছে, তার মধ্যে উল্লেখযোগ্য
                                                কিছু সুবিধা হলঃ ফ্রিল্যান্সিং বা বিভিন্ন মার্কেটপ্লেসে বায়ার রিকুয়েস্ট
                                                পাঠানো থেকে শুরু করে ক্লায়েন্ট ম্যানেজমেন্টের সকল দিকনির্দেশনা, ক্যারিয়ার
                                                প্লেসমেন্ট সাপোর্ট, কোর্স চলাকালীন সময়ে ২৪/৭ অনলাইন সাপোর্ট, লাইফটাইম
                                                সাপোর্ট, CIT.Tools, Prestige Card, Virtual internship, রিভিউ ক্লাস ও শর্ট
                                                সাপোর্ট সহ নানাকিছু।
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFive4"
                                            aria-expanded="false" aria-controls="collapseFive">
                                            সেমিনারে জয়েন করলে কি লাভ?
                                        </button>
                                    </h2>
                                    <div id="collapseFive4" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleOne">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">আমাদের ফ্রি সেমিনারে জয়েন করলে কোর্স বিবরন,
                                                ফ্রিল্যান্সিং, অনলাইন এবং লোকাল মার্কেটপ্লেসের আয় সম্পর্কে বিস্তারিত ধারনা
                                                পাবেন, সেমিনারের অংশগ্রহণকারীদের জন্য পরবর্তীতে ফ্রি ওয়ার্কশপের আয়োজন করা
                                                হয়ে থাকে। যেখানে আপনি ফ্রি একটি টপিক শিখতে পারবেন। আমাদের সেমিনার শিডিউল এই
                                                লিংক থেকে চেক করে নিতে পারেনঃ https://www.innovacomputersbd.com/seminor
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFive5"
                                            aria-expanded="false" aria-controls="collapseFive">
                                            আমি কিভাবে সেমিনারে অংশগ্রহণ করবো?
                                        </button>
                                    </h2>
                                    <div id="collapseFive5" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleOne">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">আপনি সেমিনারে অংশগ্রহণের জন্য এই লিংকে
                                                রেজিস্ট্রেশন করতে পারেনঃ https://www.innovacomputersbd.com/seminor/ আপনি
                                                রেজিস্ট্রেশন সম্পন্ন করার পর, আমাদের প্রতিনিধি সেমিনারের পূর্বে ফোন করে
                                                আপনাকে সেমিনারের সময়সূচী জানিয়ে দিবে।
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFive6"
                                            aria-expanded="false" aria-controls="collapseFive">
                                            ভর্তি হতে কি কি লাগবে?
                                        </button>
                                    </h2>
                                    <div id="collapseFive6" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleOne">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">এক কপি পাসপোর্ট সাইজের ছবি (সদ্য তোলা হতে হবে)
                                                - NID / জন্মনিবন্ধন এর ফটোকপি - যেকোনো একটি একাডেমিক সার্টিফিকেটের ফটোকপি
                                                (S.S.C / H.S.C)
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFive7"
                                            aria-expanded="false" aria-controls="collapseFive">
                                            আপনাদের এখানে কোর্স করলে কি কি সুবিধা দেয়া হয়?/ অফলাইন কোর্সে কি কি সুবিধা
                                            রয়েছে?
                                        </button>
                                    </h2>
                                    <div id="collapseFive7" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleOne">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">সরাসরি কোর্স করলে আপনি হাতে কলমে শিখতে পারবেন,
                                                পাশাপাশি আমাদের যেসব সুবিধা রয়েছে তা হল - আমাদের বেশ নিজস্ব কম্পিউটার ল্যাব
                                                রয়েছে, - আমরা আমাদের শিক্ষার্থীদের জন্য ২৪/৭ অনলাইন সাপোর্ট চালু করেছি, -
                                                এছাড়া রয়েছে ব্যাচভিত্তিক আলোচনার জন্য অনলাইন গ্রুপ সাপোর্ট, - প্রয়োজনীয়
                                                ক্লাসের ভিডিও দেয়া হয়, - ক্লাস মিস করলে রয়েছে ব্যাকআপ সাপোর্ট, - ক্লাসের
                                                বাইরে রয়েছে প্র্যাকটিস রুম, - এছাড়া কোর্স শেষে শর্তসাপেক্ষে ইন্টার্নশিপ
                                                সুবিধা, - আমাদের নিজস্ব ক্যারিয়ার প্লেসমেন্ট সেল এর মাধ্যমে আমরা বিভিন্ন
                                                কোম্পানিতে রেফার করে থাকি। আমাদের রয়েছে লাইফটাইম সাপোর্ট।
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFive8"
                                            aria-expanded="false" aria-controls="collapseFive">
                                            আমি ইংরেজিতে দুর্বল আমি কি করতে পারি?
                                        </button>
                                    </h2>
                                    <div id="collapseFive8" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleOne">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">ইংরেজি যেহেতু আমাদের মায়ের ভাষা নয় তাই অনেকেরই
                                                এই বিষয়ে দুর্বলতা থাকে। তাই আমাদের Communicative English এর আলাদা কোর্স
                                                রয়েছে। যেটা আপনি আমাদের যে কোন কোর্সের পাশাপাশি করতে পারবেন।
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFive9"
                                            aria-expanded="false" aria-controls="collapseFive">
                                            ওয়েব ডিজাইন ও ডেভেলপমেন্ট কি আলাদা কোর্স ?
                                        </button>
                                    </h2>
                                    <div id="collapseFive9" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleOne">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">ওয়েব ডিজাইন ও ডেভেলপমেন্ট সম্পূর্ন আলাদা কোর্স।
                                                ওয়েব ডেভেলপমেন্ট জানতে হলে আপনাকে প্রথমে ওয়েব ডিজাইন জানতে হবে। এছাড়াও আপনি
                                                আমাদের ওয়েব ডিজাইন ও ডেভেলপমেন্ট ফ্রি সেমিনারে আসলে আপনার প্রাথমিক ধারনা
                                                পেয়ে যাবেন।
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFive10"
                                            aria-expanded="false" aria-controls="collapseFive">
                                            কোর্স শেষে চাকরীর নিশ্চয়তা দিবেন কি?
                                        </button>
                                    </h2>
                                    <div id="collapseFive10" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleOne">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">আয় করার ব্যাপারটি নির্ভর করে আপনার নিজের কোন
                                                একটি বিষয়ভিত্তিক দক্ষতা ও যোগ্যতার উপর। কোর্স শেষে আমাদের নিজস্ব ক্যারিয়ার
                                                প্লেসমেন্ট সেল এর মাধ্যমে আমরা বিভিন্ন কোম্পানিতে আমাদের শিক্ষার্থীদের রেফার
                                                করে থাকি। আপনি যদি নিয়মিত ক্লাস করেন, সব প্রজেক্ট এবং পরীক্ষা দেয়ার মাধ্যমে
                                                কোর্সটি ভালোভাবে সম্পন্ন করেন সেক্ষেত্রে আমাদের ক্যারিয়ার প্লেসমেন্ট
                                                ডিপার্টমেন্ট এর মাধ্যমে কোর্স শেষে আপনার চাকরি পাওয়ার একটি দুর্দান্ত সুযোগ
                                                রয়েছে।
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFive12"
                                            aria-expanded="false" aria-controls="collapseFive12">
                                            ফ্রি কোর্স টিউটোরিয়াল আছে কি? / ইউটিউবে কি কোন কোর্স ভিডিও দেখা যাবে আপনাদের?
                                        </button>
                                    </h2>
                                    <div id="collapseFive12" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleTwooo">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">আমরা সম্পূর্ণ কোর্স ভিডিও দিয়ে থাকি না। তবে
                                                আমাদের ইউটিউব চ্যানেল থেকে আপনি ভিডিও টিউটোরিয়াল দেখতে পারবেন। এই চ্যানেল
                                                সাবস্ক্রাইব করে আমাদের টিউটোরিয়াল,শিক্ষার্থীদের সফলতা ও আপডেট নিউজ পেতে
                                                পারেনঃ https://www.youtube.com/@innovacomputers6765
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="accordion common-accordion" id="accordionExampleTwooo">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTwoEducation"
                                            aria-expanded="false" aria-controls="collapseTwoEducation">
                                            অনলাইনে ক্লাস করে সফল হতে পারব কি ?
                                        </button>
                                    </h2>
                                    <div id="collapseTwoEducation" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleTwooo">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">আমাদের অনলাইন এবং অফলাইন ক্লাসের মান যেহেতু একই
                                                তাই অফলাইনে শিক্ষার্থীরা সফল হতে পারলে অনলাইনে কেন নয়! আমদের গাইডলাইন
                                                যথাযথভাবে অনুসরণ করে এবং সঠিক নিয়মে প্র্যাকটিস করলে অবশ্যই সফল হতে পারবেন।
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFiveEducation1"
                                            aria-expanded="false" aria-controls="collapseFiveEducation1">
                                            আমি কি কোর্সের মধ্যেই ইনকাম করতে পারব?
                                        </button>
                                    </h2>
                                    <div id="collapseFiveEducation1" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleTwooo">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">ইনকাম নির্ভর করবে আপনি কতটা দক্ষতা ও প্রচেস্টার
                                                উপর। আমাদের অনেক শিক্ষার্থী কোর্স চলাকালিন সময় থেকেই আয় শুরু করেন, আবার
                                                অনেকে এক বছর বা তার বেশি সময় ধরে চেষ্টা করে সফল হন, দিন শেষে বড় বিষয় হল,
                                                আপনি যদি ধৈর্যের সাথে আগ্রহ নিয়ে আমাদের মেন্টরের গাইডলাইন ফলো করে চলতে থাকেন
                                                তাহলে অবশ্যই অল্প সময়েই আশানুরুপ আয় করতে সক্ষম হবেন। আপনি চাইলে প্রথমে
                                                আমাদের একটি অনলাইন ফ্রি সেমিনারে অংশ নিতে পারেন এবং আমাদের মেন্টরের সাথে
                                                সরাসরি এই বিষয়ে আলোচনা করতে পারেন। আশা করি একটি ভালো গাইডলাইন পাবেন।
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseThreeEducation"
                                            aria-expanded="false" aria-controls="collapseThreeEducation">
                                            অনলাইনে ক্লাস করে সফল হতে পারব কি ?
                                        </button>
                                    </h2>
                                    <div id="collapseThreeEducation" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleTwooo">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">আমাদের অনলাইন এবং অফলাইনের মান যেহেতু একই তাই
                                                অফলাইনে শিক্ষার্থীরা সফল হতে পারলে অনলাইনে কেন নয়! আমাদের গাইডলাইন যথাযথভাবে
                                                অনুসরণ করে এবং সঠিক নিয়মিত প্র্যাকটিস করলে অবশ্যই সফল হতে পারবেন।</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOneEducation" aria-expanded="true"
                                            aria-controls="collapseOneEducation">
                                            অনলাইনে কোন কোন মার্কেটপ্লেসে কাজ রয়েছে?
                                        </button>
                                    </h2>
                                    <div id="collapseOneEducation" class="accordion-collapse collapse show"
                                        data-bs-parent="#accordionExampleTwooo">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">অনলাইনে Upwork, Fiverr, Freelancer.com সহ
                                                প্রত্যেক মার্কেটপ্লেসেই ফ্রিল্যান্সিং করে আয় করার সুযোগ রয়েছে। কিন্তু এর
                                                জন্য প্রয়োজন কিছু নির্দিষ্ট বিষয়ভিত্তিক পারদর্শিতা ও সঠিক গাইডলাইন। আপনার কি
                                                কোন নির্দিষ্ট বিষয়ের উপর পারদর্শিতা আছে?</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFourEducation"
                                            aria-expanded="false" aria-controls="collapseFourEducation">
                                            ভর্তি হতে কি কি যোগ্যতা লাগে?
                                        </button>
                                    </h2>
                                    <div id="collapseFourEducation" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleTwooo">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">আমাদের কোর্সগুলোতে ভর্তির ক্ষেত্রে তেমন কোন
                                                বিষয় ভিত্তিক যোগ্যতার প্রয়োজন নেই। আপনার যদি একটি কম্পিউটার পরিচালনার বেসিক
                                                ধারণা থাকে তবে আপনি আমাদের আইটি বিষয়ক যেকোনো কোর্স করতে পারবেন। এছাড়াও
                                                আমাদের ট্রেইনাররা একদম বেসিক থেকে সকল কোর্স শুরু করে থাকেন যেন আপনার কোন
                                                বিষয় বুঝতে সমস্যা না হয়।</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFiveEducation3"
                                            aria-expanded="false" aria-controls="collapseFiveEducation3">
                                            আপনাদের কোর্স মেন্টর/ ট্রেইনাররা কতটা দক্ষ?
                                        </button>
                                    </h2>
                                    <div id="collapseFiveEducation3" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleTwooo">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">আমাদের কোর্স গুলো মার্কেটপ্লেস এক্সপার্ট
                                                ট্রেইনার দ্বারা পরিচালিত হয়ে থাকে। আপনি যদি আমাদের পেইজে নিয়মিত চোখ রাখেন
                                                তাহলে দেখতে পাবেন আমাদের শিক্ষার্থীদের সফলতা এবং তাদের সফলতার পেছনে আমাদের
                                                ট্রেইনারদের অবদান। এছাড়াও যদি আপনি তাদের দক্ষতা সম্পর্কে আরও জানতে চান তাহলে
                                                আমাদের অফিসিয়াল ওয়েবসাইটে বা এই লিঙ্ক থেকে দেখে নিতে পারেন
                                                https://innovacomputersbd.com/faculties. এখানে আপনি দেখতে পারবেন আমাদের
                                                ট্রেইনারদের specialized areas & work experience. আমাদের ফ্রি সেমিনারে
                                                অংশগ্রহণ করে আপনি তাদের সাথে সরাসরি কথা বলতে পারবেন।</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFiveEducation4"
                                            aria-expanded="false" aria-controls="collapseFiveEducation4">
                                            ইন্টার্নশিপের সুযোগ রয়েছে কি?
                                        </button>
                                    </h2>
                                    <div id="collapseFiveEducation4" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleTwooo">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">জ্বি আছে। শর্তসাপেক্ষে কোর্স শেষে ইন্টার্নশিপের
                                                বিশেষ সুবিধা রয়েছে।</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFiveEducation5"
                                            aria-expanded="false" aria-controls="collapseFiveEducation5">
                                            আমি আঁকা আঁকি পারি না আমি কি গ্রাফিক শিখতে পারব?
                                        </button>
                                    </h2>
                                    <div id="collapseFiveEducation5" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleTwooo">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">জি পারবেন। আমাদের এমন অনেক শিক্ষার্থী সফল
                                                হয়েছেন যারা সম্পূর্ন ভিন্ন ব্যাকগ্রাউন্ডের। তাই আর্ট জানতে হবে এমন কোন
                                                বাধ্যবাধকতা নেই। তবে যদি জেনে থাকেন তাহলে সেটা আপনার জন্য বিশেষ দক্ষতা যা
                                                আপনার পোর্টফলিওকে ভারি করবে তবে জানতেই হবে এমন কোন বিষয় নেই। তাছাড়া আমাদের
                                                কোর্সের মডিউলের মধ্যে ড্রয়িং ক্লাস রয়েছে।</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFiveEducation6"
                                            aria-expanded="false" aria-controls="collapseFiveEducation6">
                                            অফলাইন আর অনলাইন কোর্স ফি আলাদা কেন?/ অফলাইন কোর্স ফি বেশি কেন?
                                        </button>
                                    </h2>
                                    <div id="collapseFiveEducation6" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleTwooo">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">অফিসে এসে কোর্স করলে ফি বেশি হবে কারণ আমাদের
                                                অফিসে ইন্টেরিয়র, সরঞ্জামাদি, ল্যাব সবকিছু ব্যবহৃত হওয়ায় কোর্স ফি বেশি।
                                                কিন্তু অনলাইনে কোর্স করলে কম্পিউটার, ইন্টারনেট কানেকশন সকল খরচই শিক্ষার্থী
                                                বহন করে থাকে এবং আমাদের ক্লাস রুমও ব্যবহৃত হয় না। তাই দুটি জায়গায় কোর্স ফি
                                                এর তারতম্য রয়েছে। তবে ক্লাসের মানের কোন পার্থক্য নেই। কেননা অনলাইন ও অফলাইনে
                                                একই প্রশিক্ষকগণ একই কোর্স মডিউলে ক্লাস নিয়ে থাকেন।</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFiveEducation7"
                                            aria-expanded="false" aria-controls="collapseFiveEducation7">
                                            কোর্স শেষে চাকরীর নিশ্চয়তা দিবেন কি?
                                        </button>
                                    </h2>
                                    <div id="collapseFiveEducation7" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleTwooo">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">আয় করার ব্যাপারটি নির্ভর করে আপনার নিজের কোন
                                                একটি বিষয়ভিত্তিক দক্ষতা ও যোগ্যতার উপর। কোর্স শেষে আমাদের নিজস্ব ক্যারিয়ার
                                                প্লেসমেন্ট সেল এর মাধ্যমে আমরা বিভিন্ন কোম্পানিতে আমাদের শিক্ষার্থীদের রেফার
                                                করে থাকি। আপনি যদি নিয়মিত ক্লাসে উপস্থিত হয়ে, সব প্রজেক্ট এবং পরীক্ষা দিয়ে
                                                কোর্সটি ভালোভাবে সম্পন্ন করেন সেক্ষেত্রে আমাদের ক্যারিয়ার প্লেসমেন্ট
                                                ডিপার্টমেন্টের মাধ্যমে কোর্স শেষে আপনার চাকরি পাওয়ার একটি দুর্দান্ত সুযোগ
                                                রয়েছে।
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFiveEducation8"
                                            aria-expanded="false" aria-controls="collapseFiveEducation8">
                                            কোর্স ফি বেশি কেন?
                                        </button>
                                    </h2>
                                    <div id="collapseFiveEducation8" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleTwooo">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">আমাদের কোর্স ফি বেশি কিন্তু তার পিছনে যথার্থ
                                                কারন ও যুক্তি রয়েছে। শুধুমাত্র কোর্স শেষ করে দেয়ার মধ্যেই আমরা সীমাবদ্ধ নই।
                                                আমাদের শুধু ক্লাসে কাজ শিখানো হয়না ক্লাসের পর কোন সমস্যা হলে ক্লাসের বাইরেও
                                                আমরা সাপোর্ট দিয়ে থাকি। সেজন্য আমরা আমাদের শিক্ষার্থীদের জন্য ২৪/৭ অনলাইন
                                                সাপোর্ট চালু করেছি। এই ২৪/৭ সাপোর্ট কোর্স চলাকালীন এবং কোর্স শেষেও দিয়ে
                                                থাকি। এছাড়া কোর্স শেষে ইন্টার্নশিপ সুবিধা, মার্কেটপ্লেসে কাজের সাপোর্ট দিয়ে
                                                থাকি। আমাদের নিজস্ব ক্যারিয়ার প্লেসমেন্ট সেল এর মাধ্যমে আমরা বিভিন্ন
                                                কোম্পানিতে রেফার করে থাকি। কোর্স ফি নেয়া হয় একবার তবে সেবা প্রদান করা হয়
                                                সবসময়। আমাদের এখানে অভিজ্ঞ ট্রেইনার দ্বারা খুব যত্ন সহকারে শিক্ষার্থীদের
                                                কোর্স করানো হয়।
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFiveEducation9"
                                            aria-expanded="false" aria-controls="collapseFiveEducation9">
                                            অফিস সময়/ শুক্রবারে কি আপনাদের অফিস খোলা থাকে?
                                        </button>
                                    </h2>
                                    <div id="collapseFiveEducation9" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleTwooo">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">সপ্তাহে ৭ দিন সকাল ৯টা - সন্ধ্যা ৭টা আমাদের
                                                প্রতিষ্ঠান খোলা থাকে। আপনি আপনার সুবিধামত যে কোন সময়ে চলে আসতে পারেন।
                                                প্রয়োজনে কল করতে পারেন 01844463954 নাম্বারে।
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFiveEducation10"
                                            aria-expanded="false" aria-controls="collapseFiveEducation10">
                                            ২৪/৭ সার্ভিস সম্পর্কে জানতে চাচ্ছি।
                                        </button>
                                    </h2>
                                    <div id="collapseFiveEducation10" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleTwooo">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">ইনোভা কম্পিউটার্স বিডি এর বিশেষ সেবা ২৪/৭
                                                সাপোর্ট। ক্লাস শেষে বাসায় প্র্যাকটিস করতে গিয়ে আপনি যদি কোন সমস্যায় পড়েন
                                                সেক্ষেত্রে কিছু নিয়ম মেনে আপনি এই সেবা নিতে পারেন। সপ্তাহে ৭দিন ২৪ ঘন্টা
                                                আইটি এক্সপার্ট আছেন আপনার জন্য।
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFiveEducation11"
                                            aria-expanded="false11" aria-controls="collapseFiveEducation11">
                                            সেমিনার করতে কত টাকা লাগবে?
                                        </button>
                                    </h2>
                                    <div id="collapseFiveEducation11" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleTwooo">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">ইনোভা কম্পিউটার্স বিডি কর্তৃক আয়োজিত সেমিনার ও
                                                ওয়ার্কশপগুলো সম্পূর্ণ ফ্রি ও সকলের জন্য উন্মুক্ত।
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFiveEducation12"
                                            aria-expanded="false" aria-controls="collapseFiveEducation12">
                                            অনলাইন ও অফলাইনের কোর্স মডিউল কি একই ?
                                        </button>
                                    </h2>
                                    <div id="collapseFiveEducation12" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleTwooo">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">অনলাইন ও অফলাইন ক্লাসের মানে কোন পার্থক্য নেই।
                                                কেননা আমাদের অনলাইন ও অফলাইনের কোর্স মডিউল এবং ট্রেইনার একই। ট্রেইনিং এর
                                                মানও একই। আপনি আগ্রহী থাকলে একটি অনলাইন সেমিনার করতে পারেন। আশা করছি এই
                                                দ্বিধাটি দূর হয়ে যাবে।
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFiveEducation13"
                                            aria-expanded="false" aria-controls="collapseFiveEducation13">
                                            আপনারা কি মার্কেটপ্লেসে কাজ পাইয়ে দিবেন?
                                        </button>
                                    </h2>
                                    <div id="collapseFiveEducation13" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleTwooo">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">স্যার/ম্যাম, আমাদের প্রতিটি কোর্স চলাকালিন
                                                সময়েই ফ্রিল্যান্সিং মার্কেটপ্লেসে কিভাবে কাজ করবেন এবং কিভাবে কাজ পাবেন ,
                                                কিভাবে কাজ ডেলিভারি করবেন এগুলো step by step দেখানো হবে। তাছাড়া আমাদের
                                                কোর্সের মডিউল আন্তর্জাতিক মান ও স্ট্যান্ডার্ড অনুযায়ী সেট করে থাকি। বিষয়টি
                                                এমন যে আমরা আপনাকে প্রতিটি কোর্সেই ফ্রিল্যান্সিং এর যাবতীয় গাইডলাইন,সাপোর্ট
                                                দিব। কিন্তু আপনার দক্ষতা, শ্রম দিয়ে আপনাকেই কাজ করতে হবে এবং সেই পথে হাঁটতে
                                                হবে।
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFiveEducation14"
                                            aria-expanded="false" aria-controls="collapseFiveEducation14">
                                            আমি কতদিনে দক্ষ/এক্সপার্ট হতে পারব?
                                        </button>
                                    </h2>
                                    <div id="collapseFiveEducation14" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExampleTwooo">
                                        <div class="accordion-body">
                                            <p class="accordion-body__desc">দক্ষতা নির্ভর করবে আপনার পরিশ্রম এর উপর, কি
                                                ভাবে নিচ্ছেন আপনার এই পেশাকে তার উপর। আপনাকে যদি একটু সহজ ভাষায় বলি, একজন
                                                ব্যাক্তি যদি তার ফোন দিয়ে একটি লগো ডিজাইন করে এটিও একটি দক্ষতার মধ্য
                                                পড়ে,আবার আরেকজন ব্যাক্তি ২-৫ঘন্টা ব্যায় করে একটি লগো ডিজাইন করে সেটিও একটি
                                                দক্ষতার মধ্যেই পড়ে, আবার অনেকে ১ মাস সময় লাগিয়ে দেয় একটি লোগো বা ডিজাইন
                                                কনসেপ্ট নিয়ে কাজ করতে। তাই এটি নির্ভর করবে আপনি কেমন দক্ষ হতে চান।আপনাকে
                                                দক্ষ হতে হলে দীর্ঘ মেয়াদী পরিকল্পনা করতে হবে, নতুন নতুন ডিজাইন এর সাথে পরিচয়
                                                হতে হবে, মানসিকতা তৈরি করুন। আসল কথা হচ্ছে আপনি অল্প সময়ে একজন ভালো
                                                ডিজাইনার/এক্সপার্ট হওয়ার আশা করা বোকামি। নিজের সবটুকু বিলিয়ে দিন। সময় দিন
                                                নিজেই নিজের দক্ষতা বুঝতে পারবেন। একবছর আগে যে কাজ করেছেন সেটি ঠিক ১ বছর পর
                                                সে কাজটির সাথে তুলনা করলেই বুঝতে পারবেন আপনি কেমন উন্নতি করেছেন, কেমন দক্ষতা
                                                অর্জন করেছেন। সাফল্য অর্জনের পথে যত কষ্টই হোক, লেগে থাকার মানসিকতা তৈরী
                                                করেন।
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- =============================== FAQ Page Section End ================================== -->

    <!-- ===================================== Testimonials Section Three Start ================================= -->
    <section class="testimonials-three py-120 bg-main-25 position-relative z-1 overflow-hidden">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape2.png') }}" alt=""
            class="shape two animation-scalation">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape6.png') }}" alt=""
            class="shape four animation-scalation">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape4.png') }}" alt=""
            class="shape one animation-scalation">

        <div class="container">
            <div class="row gy-4 align-items-center flex-wrap-reverse">
                <div class="col-xl-7">
                    <div class="testimonials-three-slider">
                        @foreach ($review as $item)
                            <div class="testimonials-three-item bg-white p-24 rounded-12 box-shadow-md">
                                <div class="w-90 h-90 rounded-circle position-relative mb-4">
                                    <img src="{{ asset('storage/app/public/' . $item->image) }}"
                                        alt="{{ $item->stdName }}" class="cover-img rounded-circle">
                                    <span
                                        class="w-40 h-40 bg-main-two-600 flex-center border border-white border-2 rounded-circle position-absolute inset-block-end-0 inset-inline-end-0 mt--5 me--5">
                                        <img src="{{ asset('frontend/v2/assets/images/icons/quote-two-icon.png') }}"
                                            alt="">
                                    </span>
                                </div>
                                <p class="text-neutral-500 my-24">{{ $item->msg }}</p>
                                <ul class="flex-align gap-8 mb-16">
                                    @if ($item->rating >= 1 && $item->rating < 2)
                                        <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                        <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star-half"></i>
                                        </li>
                                    @elseif ($item->rating >= 2 && $item->rating < 3)
                                        <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                        <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                        <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star-half"></i>
                                        </li>
                                    @elseif ($item->rating >= 3 && $item->rating < 4)
                                        <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                        <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                        <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                        <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star-half"></i>
                                        </li>
                                    @elseif ($item->rating >= 4 && $item->rating < 5)
                                        <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                        <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                        <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                        <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                        <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star-half"></i>
                                        </li>
                                    @elseif ($item->rating >= 5)
                                        <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                        <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                        <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                        <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                        <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    @endif
                                </ul>
                                <h4 class="mb-16 text-lg">{{ $item->stdName }}</h4>
                                <span class="text-neutral-500">{{ $item->course }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-xl-5 ps-xl-5">
                    <div class="flex-align d-inline-flex gap-8 mb-16 wow bounceInDown">
                        <span class="text-main-600 text-2xl d-flex"><i class="ph-bold ph-book-open"></i></span>
                        <h5 class="text-main-600 mb-0">আমাদের শিক্ষার্থীদের রিভিউ</h5>
                    </div>
                    <h2 class="mb-24 wow bounceInRight">ইনোভা প্ল্যাটফর্মের স্যাটিসফাইড শিক্ষার্থীদের সাক্ষাৎকার</h2>
                    <p class="text-neutral-500 text-line-4 wow bounceInUp">আমরা বিশ্বাস করি আমাদের প্রতিটি শিক্ষার্থী ইনোভা
                        কম্পিউটার্সের পরিবারের সদস্য। ছাত্রছাত্রীদের যেকোনো পরামর্শ আমরা গুরুত্বের সাথে বিবেচনা করি সবসময়।
                        এভাবেই প্রায় ৫ বছর ধরে ইনোভা কম্পিউটার্স বিডি বজায় রেখেছে আইটি ট্রেনিং-এর মান আর পরিবেশ। তাই
                        শিক্ষার্থীদের যেকোনো গঠনমূলক মন্তব্য আমাদের ভুল-ত্রুটি শুধরে সামনে এগিয়ে চলার পথে প্রেরণা যোগায়।</p>
                    <div class="flex-align gap-16 mt-40">
                        <button type="button" id="testimonials-three-prev"
                            class="slick-prev slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1 w-48 h-48"
                            style="">
                            <i class="ph ph-caret-left"></i>
                        </button>
                        <button type="button" id="testimonials-three-next"
                            class="slick-next slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1 w-48 h-48"
                            style="">
                            <i class="ph ph-caret-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ===================================== Testimonials Section Three End ================================= -->
@endsection
