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
                        <h1 class="breadcrumb__title display-4 fw-semibold text-center"> আমাদের সম্পর্কে </h1>
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
                                <span class="text-main-two-600"> আমাদের সম্পর্কে </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== Breadcrumb End Here ==================== -->
    <!-- ================================ About Section Start ==================================== -->
    <section class="about py-120 position-relative z-1 mash-bg-main mash-bg-main-two">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape2.png') }}" alt=""
            class="shape one animation-scalation">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape6.png') }}" alt=""
            class="shape four animation-scalation">

        <div class="position-relative">
            <div class="container">
                <div class="row gy-xl-0 gy-5 flex-wrap-reverse align-items-center">
                    <div class="col-xl-6">
                        <div class="about-thumbs position-relative pe-lg-5">
                            <img src="{{ asset('frontend/v2/assets/images/shapes/shape7.png') }}" alt=""
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
                                    <img src="{{ asset('frontend/v2/assets/images/thumbs/about-img1.jpg') }}"
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
                                    <img src="{{ asset('frontend/v2/assets/images/thumbs/about-img2.jpg') }}"
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
                                    কোনো সীমা নেই। আপনি যদি একজন শিক্ষার্থী, পেশাজীবী বা আজীবন শেখার আগ্রহী হন, ইনোভা সবসময়
                                    আপনাকে এগিয়ে যেতে সাহায্য করবে।</p>
                            </div>

                            <div class="flex-align align-items-start gap-28 mb-32" data-aos="fade-left"
                                data-aos-duration="200">
                                <span
                                    class="w-80 h-80 bg-main-25 border border-neutral-30 flex-center rounded-circle flex-shrink-0">
                                    <img src="{{ asset('frontend/v2/assets/images/icons/about-img1.png') }}"
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
                                    <img src="{{ asset('frontend/v2/assets/images/icons/about-img2.png') }}"
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
                                    আরও পড়ুন
                                    <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                                </a>
                                <div class="flex-align gap-20">
                                    <img src="{{ asset('frontend/v2/assets/images/thumbs/ceo-img.png') }}"
                                        alt="" class="w-52 h-52 rounded-circle object-fit-cover flex-shrink-0">
                                    <div class="flex-grow-1">
                                        <span class="mb-4">
                                            <img src="{{ asset('frontend/v2/assets/images/thumbs/signature.png') }}"
                                                alt="">
                                        </span>
                                        <span class="text-sm d-block">নির্বাহি পরিচালক, ইনোভা কম্পিটার্স বিডি।</span>
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
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape2.png') }}" alt=""
            class="shape one animation-scalation">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape6.png') }}" alt=""
            class="shape six animation-scalation">

        <div class="container">
            <div class="section-heading text-center">
                <h2 class="mb-24 wow bounceIn">কোর্স ইনস্ট্রাকটররা</h2>
                <p class=" wow bounceInUp">আমাদের সাথে এই আবিষ্কার, বৃদ্ধি এবং রূপান্তরের যাত্রায় যোগ দিন। একসাথে, চলুন
                    একটি উজ্জ্বল ভবিষ্যৎ গড়ে তুলি।</p>
            </div>
            <div class="instructor-slider">
                {{-- instructor Start --}}
                @foreach ($teacher as $item)
                    <div class="instructor-item scale-hover-item bg-white rounded-16 p-12 h-100 border border-neutral-30"
                        data-aos="fade-up" data-aos-duration="200">
                        <div class="rounded-12 overflow-hidden position-relative bg-dark-yellow">
                            <a href="#" class="w-100 h-100 d-flex align-items-end">
                                <img src="{{ asset('public/storage/' . $item->image) }}" alt="Course Image"
                                    class="scale-hover-item__img rounded-12 cover-img transition-2">
                            </a>
                        </div>
                        <div class="p-24 position-relative">
                            <div class="social-infos">
                                <ul class="social-list flex-align flex-column gap-12 mb-12">
                                    <li class="social-list__item">
                                        <a href="{{ $item->link1 }}"
                                            class=" flex-center border border-white text-white w-44 h-44 rounded-circle text-xl hover-text-main hover-bg-white"><i
                                                class="ph-bold ph-facebook-logo"></i></a>
                                    </li>
                                    <li class="social-list__item">
                                        <a href="{{ $item->link2 }}"
                                            class=" flex-center border border-white text-white w-44 h-44 rounded-circle text-xl hover-text-main hover-bg-white">
                                            <i class="ph-bold ph-twitter-logo"></i></a>
                                    </li>
                                    <li class="social-list__item">
                                        <a href="{{ $item->link3 }}"
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
                                    <a href="instructor-details.html" class="link text-line-2">{{ $item->name }}</a>
                                </h4>
                                <div class="flex-between gap-8 flex-wrap mb-16">
                                    <div class="flex-align gap-8">
                                        <span class="text-neutral-700 text-2xl d-flex"><i
                                                class="ph-bold ph-lightbulb"></i></span>
                                        <span class="text-neutral-700 text-lg fw-medium">{{ $item->subject }}</span>
                                    </div>
                                    <div class="flex-align gap-8">
                                        <span class="text-neutral-700 text-2xl d-flex"><i
                                                class="ph-bold ph-watch"></i></span>
                                        <span class="text-neutral-700 text-lg fw-medium">{{ $item->ComCourse }}</span>
                                    </div>
                                </div>
                                <div class="flex-between gap-8 flex-wrap">
                                    <div class="flex-align gap-8">
                                        <span class="text-neutral-700 text-2xl d-flex"><i
                                                class="ph-bold ph-users"></i></span>
                                        <span class="text-neutral-700 text-lg fw-medium">{{ $item->nStd }}
                                            শিক্ষার্থী</span>
                                    </div>
                                    <div class="flex-align gap-4">
                                        <span class="text-2xl fw-medium text-warning-600 d-flex"><i
                                                class="ph-fill ph-star"></i></span>
                                        <span class="text-lg text-neutral-700">
                                            {{ $item->rating }}
                                            <span class="text-neutral-100">({{ $item->review }})</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-24 border-top border-neutral-50 mt-28 border-dashed border-0">
                                <a href="#"
                                    class="flex-align gap-8 text-main-600 hover-text-decoration-underline transition-1 fw-semibold"
                                    tabindex="0">
                                    প্রোফাইল দেখুন
                                    <i class="ph ph-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{-- instructor Start --}}
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


    <!-- =========================== CHoose Us Section Start ================================ -->
    @foreach ($cmsAbout as $item)
    <!-- =========================== CHoose Us Section Start ================================ -->
    <section class="choose-us pt-120 position-relative z-1 mash-bg-main mash-bg-main-two">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape2.png') }}" alt=""
            class="shape one animation-scalation">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape2.png') }}" alt=""
            class="shape six animation-scalation">

        <div class="container">
            <div class="row gy-4">
                <div class="col-xl-6">
                    <div class="choose-us__content">
                        <div class="mb-40">
                            <div class="flex-align gap-8 mb-16 wow bounceInDown">
                                <span class="w-8 h-8 bg-main-600 rounded-circle"></span>
                                <h5 class="text-main-600 mb-0">{{$item->shortTitle}}</h5>
                            </div>
                            <h2 class="mb-24  wow bounceIn">{{$item->LongTitle}}</h2>
                            <p class="text-neutral-500 text-line-2  wow bounceInUp">{{$item->shortdetail}}</p>
                        </div>

                        <ul>
                            <li class="flex-align gap-12 mb-16" data-aos="fade-up-left" data-aos-duration="200">
                                <span class="flex-shrink-0 text-xl text-main-600 d-flex"><i
                                        class="ph-bold ph-checks"></i></span>
                                <span class="flex-grow-1 text-neutral-500">{{$item->info1}}</span>
                            </li>
                            <li class="flex-align gap-12 mb-16" data-aos="fade-up-left" data-aos-duration="400">
                                <span class="flex-shrink-0 text-xl text-main-600 d-flex"><i
                                        class="ph-bold ph-checks"></i></span>
                                <span class="flex-grow-1 text-neutral-500">{{$item->info2}}</span>
                            </li>
                            <li class="flex-align gap-12 mb-16" data-aos="fade-up-left" data-aos-duration="500">
                                <span class="flex-shrink-0 text-xl text-main-600 d-flex"><i
                                        class="ph-bold ph-checks"></i></span>
                                <span class="flex-grow-1 text-neutral-500">{{$item->info3}}</span>
                            </li>
                        </ul>

                        <div class="pt-24 border-top border-neutral-50 mt-28 border-dashed border-0">
                            <a href="{{$item->btnLink}}" class="btn btn-main rounded-pill flex-align d-inline-flex gap-8">
                                {{$item->btnTxt}}
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
                                <img src="{{ asset('frontend/v2/assets/images/icons/stars.png') }}" alt="">
                            </span>
                            <div>
                                <span class="text-lg text-neutral-700 d-block">
                                    {{$item->Rating}}
                                    <span class="text-neutral-100">({{$item->Reviews}})</span>
                                </span>
                                <span class="text-neutral-500">AVG Reviews</span>
                            </div>
                        </div>

                        <div class="banner-box one style-two px-24 py-12 rounded-12 bg-white fw-medium box-shadow-lg d-inline-block"
                            data-aos="fade-left">
                            <span class="text-main-600">5k+</span> Enrolled Students
                            <div class="enrolled-students mt-12">
                               
                                    @php
                                        $stdList = explode(',', $item->stdId);
                                    @endphp
                                    @foreach ($stdList as $val)
                                        @php
                                            $student = DB::table('students')->where('id', $val)->first();
                                        @endphp
                                        <img src="{{ asset('storage/app/public/' . $student->image) }}" alt=""
                                            class="w-48 h-48 rounded-circle object-fit-cover">
                                    @endforeach
                               
                            </div>
                        </div>

                        <div class="text-end" data-aos="zoom-out">
                            <div class="d-sm-inline-block d-block position-relative">
                                <img src="{{ asset('storage/app/public/' . $item->bgimg1) }}" alt=""
                                    class="choose-us__img rounded-12" data-tilt data-tilt-max="16" data-tilt-speed="500"
                                    data-tilt-perspective="5000" data-tilt-full-page-listening>
                                <span
                                    class="shadow-main-two w-80 h-80 flex-center bg-main-two-600 rounded-circle position-absolute inset-block-start-0 inset-inline-start-0 mt-40 ms--40 animation-upDown">
                                    <img src="{{ asset('frontend/v2/assets/images/icons/book.png') }}" alt="">
                                </span>
                            </div>
                        </div>
                        <div class="animation-video" data-aos="zoom-in">
                            <img src="{{ asset('storage/app/public/' . $item->bgimg2) }}" alt=""
                                class="border border-white rounded-circle border-3" data-tilt>
                            <a href="{{$item->video}}"
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
                        <h2 class="display-four mb-16 text-neutral-700 counter">{{$item->successTraing}}</h2>
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
                        <h2 class="display-four mb-16 text-neutral-700 counter"> {{$item->completeCourse}}</h2>
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
                        <h2 class="display-four mb-16 text-neutral-700 counter">{{$item->satisfaction}}</h2>
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
                        <h2 class="display-four mb-16 text-neutral-700 counter">{{$item->stdComunity}}</h2>
                        <span class="text-neutral-500 text-lg">স্টুডেন্ট কমিউনিটি</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endforeach
    {{-- @dd($cmsAbout); --}}
    <!-- ========================== Counter Section End ============================== -->
    <!-- =========================== CHoose Us Section End ================================ -->

    <!-- ================================= testimonials Section Start ========================================= -->
    <section class="testimonials py-120 position-relative z-1 bg-main-25">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape2.png' )}}" alt="" class="shape six animation-scalation">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape3.png' )}}" alt="" class="shape four animation-rotation">

        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-6">
                    <div class="testimonials__thumbs-slider pe-lg-5 me-xxl-5">
                        <div class="testimonials__thumbs wow bounceIn" data-tilt data-tilt-max="15" data-tilt-speed="500"
                            data-tilt-perspective="5000" data-tilt-full-page-listening>
                            <img src="{{ asset('frontend/v2/assets/images/thumbs/review-1.jpg')}}" alt="">
                        </div>
                        <div class="testimonials__thumbs wow bounceIn" data-tilt data-tilt-max="15" data-tilt-speed="500"
                            data-tilt-perspective="5000" data-tilt-full-page-listening>
                            <img src="{{ asset('frontend/v2/assets/images/thumbs/review-1.jpg')}}" alt="">
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
                            <p class="text-neutral-500 text-line-2 wow bounceInUp">ইতোমধ্যে ১০,০০০+ শিক্ষার্থী ইনোভা প্ল্যাটফর্মে প্রশিক্ষণ নিয়েছে</p>
                        </div>

                        <div class="testimonials__slider">
                            {{-- eview start --}}
                            @foreach ($Review as $item)
                            <div class="testimonials-item">
                                <ul class="flex-align gap-8 mb-16" data-aos="fade-left" data-aos-duration="800">
                                    @if ($item->rating >= 1 && $item->rating < 2)
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star-half"></i></li>
                                    @elseif ($item->rating >= 2 && $item->rating < 3)
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star-half"></i></li>
                                    @elseif ($item->rating >= 3 && $item->rating < 4)
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star-half"></i></li>
                                    @elseif ($item->rating >= 4 && $item->rating < 5)
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star-half"></i></li>
                                    @elseif ($item->rating >= 5)
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    @endif
                                    
                                </ul>
                                <p class="text-neutral-700" data-aos="fade-left" data-aos-duration="1200">"{{ $item->msg}}”</p>
                                <h4 class="mt-48 mb-8" data-aos="fade-left"> <img src="{{ asset('storage/app/public/' . $item->image) }}" alt="{{ $item->stdName}}" class="w-48 h-48 rounded-circle object-fit-cover d-inline-block"> &nbsp;{{ $item->stdName}}</h4>
                                <span class="text-neutral-700" data-aos="fade-left">{{ $item->course}}</span>
                            </div>
                            @endforeach
                            {{-- eview end --}}
                           
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
@endsection
