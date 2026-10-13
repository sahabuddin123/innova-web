@extends('frontend.v2.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <style>
        .animation-video {
            position: static !important;
        }

        .pgcf_whom_item {
            padding-top: 58px;
            padding-bottom: 34px;
            margin-bottom: 19px;
            text-align: center;
            background: #fff;
            border-radius: 30px;
        }

        .pgcf_whom_item .pgcf_whom_item_icon {
            width: auto;
            margin: 0 auto;
        }

        .pgcf_whom_item .pgcf_whom_item_text p {
            color: #1f1e1e;
            font-size: 22px;
            line-height: 33px;
            padding-top: 22px;
        }

        .pgc_for_whom h3,
        .pgcf_btn a,
        .pgcf_whom_item .pgcf_whom_item_text p {
            font-family: Hind Siliguri;
            font-weight: 600;
        }
    </style>
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
                        <h1 class="breadcrumb__title display-4 fw-semibold text-center"> ফ্রিল্যান্সিং</h1>
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
                                <span class="text-main-two-600"> ফ্রিল্যান্সিং </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== Breadcrumb End Here ==================== -->

    <!-- ================================ Blog Details Section Start =================================== -->
    <div class="blog-page-section py-120 ">
        <div class="container">
            <div class="row gy-4 bg-main-25 rounded-16 p-12">
                <div class="col-lg-6">
                    <div class="p-40">
                        <div class="section-heading">
                            <h3 class="mb-24 text-left">ফ্রিল্যান্সিং</h3>
                            <p class="text-justify">বাংলাদেশে আইসিটি ডিভিশনের এক জরিপ থেকে দেখা গেছে, বাংলাদেশে প্রায় ৫
                                লাখেরও বেশি ফ্রিল্যান্সার বিভিন্ন সেক্টরে কাজ করছেন। স্বাধীনভাবে কাজ করে স্বাবলম্বী হতে
                                ট্রেন্ডি পেশা হিসেবে সবাই ফ্রিল্যান্সিং-কে বেছে নিচ্ছে। এভাবেই বিশ্বজুড়ে প্রায় ১ বিলিয়নেরও
                                বেশি মানুষ ফ্রিল্যান্সিং করছেন। বেশিরভাগ ফ্রিল্যান্সারের গড় মাসিক আয় প্রায় ৪০ হাজারেরও বেশি।
                                ফ্রিল্যান্সিং-এ ক্যারিয়ার গড়তে চাচ্ছেন? ফ্রিল্যান্সার হিসেবে গড়ে তুলতে ইনোভা কম্পিউটার্স
                                বিডি ১২ টিরও বেশি সেক্টরে মানুষকে দক্ষ করে তুলছে।</p>
                        </div>
                        {{-- Video --}}
                        {{-- <div class="instructor-item scale-hover-item bg-white rounded-16 p-12 h-100 border"> --}}
                        <div class="animation-video" data-aos="zoom-in">
                            <img src="{{ asset('frontend/v2/assets/images/thumbs/frelanching.jpg') }}" alt="!"
                                class="border border-white border-3 rounded-16">
                            <a href="https://www.youtube.com/watch?v=HLmg1JwKk28"
                                class="play-button w-48 h-48 flex-center bg-main-600 text-white rounded-circle text-xl position-absolute top-50 start-50 translate-middle">
                                <i class="ph-fill ph-play"></i>
                            </a>
                        </div>
                        {{-- </div> --}}
                        {{-- Video End --}}
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bg-white rounded-16 p-12 border border-neutral-30">
                        <div class="p-40">
                            <div class="section-heading">
                                <h3 class="mb-24 text-center">ফ্রিল্যান্স মার্কেটপ্লেস</h3>
                                <p class="text-center">ফ্রিল্যান্স কাজের জন্য রয়েছে বিভিন্ন মার্কেটপ্লেস। আন্তর্জাতিক এসব
                                    মার্কেটপ্লেসের প্রত্যেকটি ভিন্ন ভিন্ন নিয়ম মেনে চললেও কাজের সুবিধা রয়েছে সবখানেই।</p>
                            </div>
                            <div class="row">
                                {{-- single marketplace --}}
                                <div class="col-md-4">
                                    <div class="brand-slider__item px-24 card"
                                        style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                        <div class="card-img text-center">
                                            <img src="{{ asset('frontend/v2/assets/images/marketplace/99design.png') }}"
                                                alt="Marketplace Image" style="">
                                        </div>
                                    </div>
                                </div>
                                {{-- single marketplace --}}
                                {{-- single marketplace --}}
                                <div class="col-md-4">
                                    <div class="brand-slider__item px-24 card"
                                        style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                        <div class="card-img text-center">
                                            <img src="{{ asset('frontend/v2/assets/images/marketplace/cgtrader.png') }}"
                                                alt="Marketplace Image" style="">
                                        </div>
                                    </div>
                                </div>
                                {{-- single marketplace --}}
                                {{-- single marketplace --}}
                                <div class="col-md-4">
                                    <div class="brand-slider__item px-24 card"
                                        style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                        <div class="card-img text-center">
                                            <img src="{{ asset('frontend/v2/assets/images/marketplace/codecyan.png') }}"
                                                alt="Marketplace Image" style="">
                                        </div>
                                    </div>
                                </div>
                                {{-- single marketplace --}}

                                {{-- single marketplace --}}
                                <div class="col-md-4">
                                    <div class="brand-slider__item px-24 card"
                                        style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                        <div class="card-img text-center">
                                            <img src="{{ asset('frontend/v2/assets/images/marketplace/codestore.png') }}"
                                                alt="Marketplace Image" style="">
                                        </div>
                                    </div>
                                </div>
                                {{-- single marketplace --}}
                                {{-- single marketplace --}}
                                <div class="col-md-4">
                                    <div class="brand-slider__item px-24 card"
                                        style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                        <div class="card-img text-center">
                                            <img src="{{ asset('frontend/v2/assets/images/marketplace/cf.png') }}"
                                                alt="Marketplace Image" style="">
                                        </div>
                                    </div>
                                </div>
                                {{-- single marketplace --}}
                                {{-- single marketplace --}}
                                <div class="col-md-4">
                                    <div class="brand-slider__item px-24 card"
                                        style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                        <div class="card-img text-center">
                                            <img src="{{ asset('frontend/v2/assets/images/marketplace/evanto.png') }}"
                                                alt="Marketplace Image" style="">
                                        </div>
                                    </div>
                                </div>
                                {{-- single marketplace --}}
                                {{-- single marketplace --}}
                                <div class="col-md-4">
                                    <div class="brand-slider__item px-24 card"
                                        style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                        <div class="card-img text-center">
                                            <img src="{{ asset('frontend/v2/assets/images/marketplace/fiverr.png') }}"
                                                alt="Marketplace Image" style="">
                                        </div>
                                    </div>
                                </div>
                                {{-- single marketplace --}}
                                {{-- single marketplace --}}
                                <div class="col-md-4">
                                    <div class="brand-slider__item px-24 card"
                                        style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                        <div class="card-img text-center">
                                            <img src="{{ asset('frontend/v2/assets/images/marketplace/freelancer.png') }}"
                                                alt="Marketplace Image" style="">
                                        </div>
                                    </div>
                                </div>
                                {{-- single marketplace --}}
                                {{-- single marketplace --}}
                                <div class="col-md-4">
                                    <div class="brand-slider__item px-24 card"
                                        style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                        <div class="card-img text-center">
                                            <img src="{{ asset('frontend/v2/assets/images/marketplace/freepik.png') }}"
                                                alt="Marketplace Image" style="">
                                        </div>
                                    </div>
                                </div>
                                {{-- single marketplace --}}
                                {{-- single marketplace --}}
                                <div class="col-md-12">
                                    <div class="card-img text-center pt-12">
                                        <a href="#"> 12+ প্রতিষ্ঠানের সাথে কাজ করুন</a>
                                    </div>

                                </div>
                                {{-- single marketplace --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ================================ Blog Details Section End =================================== -->
    <!-- ================================ Odiance Section Start =================================== -->
    <div class="blog-page-section ">
        <div class="container">
            <div class="row gy-4 bg-main-25 rounded-16 p-30">
                <div class="col-lg-12">
                    {{-- <div class="p-40"> --}}
                    {{-- <div class="section-heading"> --}}
                    <h3 class="mb-24 text-left">ফ্রিল্যান্সিং যাদের জন্য</h3>
                    <div class="row">
                        {{-- single odiance Start --}}
                        <div class="col-md-4">
                            <div class="pgcf_whom_item">
                                <div class="pgcf_whom_item_icon"><img class="img-fluid"
                                        src="{{ asset('frontend/v2/assets/images/odiance/option1662371472.png') }}"
                                        alt="গৃহিণী"></div>
                                <div class="pgcf_whom_item_text">
                                    <p>গৃহিণী</p>
                                </div>
                            </div>
                        </div>
                        {{-- single odiance End --}}
                        {{-- single odiance Start --}}
                        <div class="col-md-4">
                            <div class="pgcf_whom_item">
                                <div class="pgcf_whom_item_icon"><img class="img-fluid"
                                        src="{{ asset('frontend/v2/assets/images/odiance/option1662371439.png') }}"
                                        alt="চাকুরী প্রত্যাশী"></div>
                                <div class="pgcf_whom_item_text">
                                    <p>চাকুরী প্রত্যাশী</p>
                                </div>
                            </div>
                        </div>
                        {{-- single odiance End --}}
                        {{-- single odiance Start --}}
                        <div class="col-md-4">
                            <div class="pgcf_whom_item">
                                <div class="pgcf_whom_item_icon"><img class="img-fluid"
                                        src="{{ asset('frontend/v2/assets/images/odiance/option1662967888.png') }}"
                                        alt="উদ্যোক্তা"></div>
                                <div class="pgcf_whom_item_text">
                                    <p>উদ্যোক্তা</p>
                                </div>
                            </div>
                        </div>
                        {{-- single odiance End --}}
                        {{-- single odiance Start --}}
                        <div class="col-md-4">
                            <div class="pgcf_whom_item">
                                <div class="pgcf_whom_item_icon"><img class="img-fluid"
                                        src="{{ asset('frontend/v2/assets/images/odiance/option1662371456.png') }}"
                                        alt="ছাত্র-ছাত্রী"></div>
                                <div class="pgcf_whom_item_text">
                                    <p>ছাত্র-ছাত্রী</p>
                                </div>
                            </div>
                        </div>
                        {{-- single odiance End --}}
                        {{-- single odiance Start --}}
                        <div class="col-md-4">
                            <div class="pgcf_whom_item">
                                <div class="pgcf_whom_item_icon"><img class="img-fluid"
                                        src="{{ asset('frontend/v2/assets/images/odiance/option1662371522.png') }}"
                                        alt="প্রবাসী"></div>
                                <div class="pgcf_whom_item_text">
                                    <p>প্রবাসী</p>
                                </div>
                            </div>
                        </div>
                        {{-- single odiance End --}}
                        {{-- single odiance Start --}}
                        <div class="col-md-4">
                            <div class="pgcf_whom_item">
                                <div class="pgcf_whom_item_icon"><img class="img-fluid"
                                        src="{{ asset('frontend/v2/assets/images/odiance/option1662371418.png') }}"
                                        alt="ফ্রিল্যান্সিং এ আগ্রহী"></div>
                                <div class="pgcf_whom_item_text">
                                    <p>ফ্রিল্যান্সিং এ আগ্রহী</p>
                                </div>
                            </div>
                        </div>
                        {{-- single odiance End --}}
                    </div>
                </div>
                {{-- </div> --}}
                {{-- </div> --}}
            </div>
        </div>
    </div>
    <!-- ================================ Odiance Section End =================================== -->
    <!-- ================================ Course Category Section Start =================================== -->
    <div class="blog-page-section py-120">
        <div class="container">
            <div class="row gy-4 bg-main-25 rounded-16 p-30">
                <div class="col-lg-12">
                    <h3 class="mb-24 text-left">ফ্রিল্যান্সিং নিয়ে আমাদের জনপ্রিয় কোর্সসমূহ</h3>
                    <div class="row">
                        @foreach ($courseCategory as $item)
                            @if ($item->id == 8)
                                @php
                                    continue;
                                @endphp
                            @endif
                            {{-- single odiance Start --}}
                            <div class="col-md-4 col-lg-3">
                                <div class="brand-slider__item px-24 card"
                                    style="background: #fff; text-align:center; height: 157px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 25px 12px;">
                                    <div class="card-img" style="margin-top: 10%;">
                                        <img src="{{ asset('public/storage/' . $item->icon) }}"
                                            alt="{{ $item->CourseCategoris }}" style="">
                                    </div>
                                    <div class="card-body">
                                        <a href="{{ route('frontend.courses.category', $item->id) }}">
                                            <h3 class="text-center" style="font-size: 16px">{{ $item->CourseCategoris }}
                                            </h3>
                                        </a>
                                    </div>

                                </div>
                            </div>
                            {{-- single odiance End --}}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ================================ Course Category Section End =================================== -->
    <!-- ================================ Course Category Section Start =================================== -->
    <div class="blog-page-section">
        <div class="container">
            <div class="row gy-4 bg-main-25 rounded-16 p-30">
                <div class="col-lg-12">
                    <h3 class="mb-24 text-left">আপনি যেখানে কাজ করতে পারেন</h3>
                    <p class="text-left">বিভিন্ন লোকাল বা রিমোট জবের পাশাপাশি আপনি ফ্রিল্যান্সিং মার্কেটপ্লেস বেছে নিতে
                        পারেন কাজের জন্য।</p>
                    <p class="text-left">স্মার্ট স্যালারি আর স্বচ্ছন্দে কাজের সুযোগ থাকায় যেকোনো এক বা একাধিক
                        মার্কেটপ্লেসের অংশ হতে পারেন সহজেই।</p>
                    <div class="row py-30 px-10">

                        {{-- single odiance Start --}}
                        <div class="col-md-2">
                            <div class="brand-slider__item px-24 card"
                                style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                <div class="card-img text-center">
                                    <img src="{{ asset('frontend/v2/assets/images/marketplace/freepik.png') }}"
                                        alt="Marketplace Image" style="">
                                </div>
                            </div>
                        </div>
                        {{-- single odiance End --}}
                        {{-- single odiance Start --}}
                        <div class="col-md-2">
                            <div class="brand-slider__item px-24 card"
                                style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                <div class="card-img text-center">
                                    <img src="{{ asset('frontend/v2/assets/images/marketplace/freelancer.png') }}"
                                        alt="Marketplace Image" style="">
                                </div>
                            </div>
                        </div>
                        {{-- single odiance End --}}
                        {{-- single odiance Start --}}
                        <div class="col-md-2">
                            <div class="brand-slider__item px-24 card"
                                style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                <div class="card-img text-center">
                                    <img src="{{ asset('frontend/v2/assets/images/marketplace/fiverr.png') }}"
                                        alt="Marketplace Image" style="">
                                </div>
                            </div>
                        </div>
                        {{-- single odiance End --}}
                        {{-- single odiance Start --}}
                        <div class="col-md-2">
                            <div class="brand-slider__item px-24 card"
                                style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                <div class="card-img text-center">
                                    <img src="{{ asset('frontend/v2/assets/images/marketplace/evanto.png') }}"
                                        alt="Marketplace Image" style="">
                                </div>
                            </div>
                        </div>
                        {{-- single odiance End --}}
                        {{-- single odiance Start --}}
                        <div class="col-md-2">
                            <div class="brand-slider__item px-24 card"
                                style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                <div class="card-img text-center">
                                    <img src="{{ asset('frontend/v2/assets/images/marketplace/cf.png') }}"
                                        alt="Marketplace Image" style="">
                                </div>
                            </div>
                        </div>
                        {{-- single odiance End --}}
                        {{-- single odiance Start --}}
                        <div class="col-md-2">
                            <div class="brand-slider__item px-24 card"
                                style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                <div class="card-img text-center">
                                    <img src="{{ asset('frontend/v2/assets/images/marketplace/codecyan.png') }}"
                                        alt="Marketplace Image" style="">
                                </div>
                            </div>
                        </div>
                        {{-- single odiance End --}}
                        {{-- single odiance Start --}}
                        <div class="col-md-2">
                            <div class="brand-slider__item px-24 card"
                                style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                <div class="card-img text-center">
                                    <img src="{{ asset('frontend/v2/assets/images/marketplace/codestore.png') }}"
                                        alt="Marketplace Image" style="">
                                </div>
                            </div>
                        </div>
                        {{-- single odiance End --}}
                        {{-- single odiance Start --}}
                        <div class="col-md-2">
                            <div class="brand-slider__item px-24 card"
                                style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                <div class="card-img text-center">
                                    <img src="{{ asset('frontend/v2/assets/images/marketplace/cgtrader.png') }}"
                                        alt="Marketplace Image" style="">
                                </div>
                            </div>
                        </div>
                        {{-- single odiance End --}}
                        {{-- single odiance Start --}}
                        <div class="col-md-2">
                            <div class="brand-slider__item px-24 card"
                                style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                <div class="card-img text-center">
                                    <img src="{{ asset('frontend/v2/assets/images/marketplace/99design.png') }}"
                                        alt="Marketplace Image" style="">
                                </div>
                            </div>
                        </div>
                        {{-- single odiance End --}}
                        {{-- single odiance Start --}}
                        <div class="col-md-2">
                            <div class="brand-slider__item px-24 card"
                                style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                <div class="card-img text-center">
                                    <img src="{{ asset('frontend/v2/assets/images/marketplace/playstore.png') }}"
                                        alt="Marketplace Image" style="">
                                </div>
                            </div>
                        </div>
                        {{-- single odiance End --}}
                        {{-- single odiance Start --}}
                        <div class="col-md-2">
                            <div class="brand-slider__item px-24 card"
                                style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                <div class="card-img text-center">
                                    <img src="{{ asset('frontend/v2/assets/images/marketplace/pikbest.png') }}"
                                        alt="Marketplace Image" style="">
                                </div>
                            </div>
                        </div>
                        {{-- single odiance End --}}
                        {{-- single odiance Start --}}
                        <div class="col-md-2">
                            <div class="brand-slider__item px-24 card"
                                style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                <div class="card-img text-center">
                                    <img src="{{ asset('frontend/v2/assets/images/marketplace/peopleperhour.png') }}"
                                        alt="Marketplace Image" style="">
                                </div>
                            </div>
                        </div>
                        {{-- single odiance End --}}
                        {{-- single odiance Start --}}
                        <div class="col-md-2">
                            <div class="brand-slider__item px-24 card"
                                style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                <div class="card-img text-center">
                                    <img src="{{ asset('frontend/v2/assets/images/marketplace/storyblock.png') }}"
                                        alt="Marketplace Image" style="">
                                </div>
                            </div>
                        </div>
                        {{-- single odiance End --}}
                        {{-- single odiance Start --}}
                        <div class="col-md-2">
                            <div class="brand-slider__item px-24 card"
                                style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                <div class="card-img text-center">
                                    <img src="{{ asset('frontend/v2/assets/images/marketplace/toptal.png') }}"
                                        alt="Marketplace Image" style="">
                                </div>
                            </div>
                        </div>
                        {{-- single odiance End --}}
                        {{-- single odiance Start --}}
                        <div class="col-md-2">
                            <div class="brand-slider__item px-24 card"
                                style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                <div class="card-img text-center">
                                    <img src="{{ asset('frontend/v2/assets/images/marketplace/upwork.png') }}"
                                        alt="Marketplace Image" style="">
                                </div>
                            </div>
                        </div>
                        {{-- single odiance End --}}
                        {{-- single odiance Start --}}
                        <div class="col-md-2">
                            <div class="brand-slider__item px-24 card"
                                style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                <div class="card-img text-center">
                                    <img src="{{ asset('frontend/v2/assets/images/marketplace/vectorstock.png') }}"
                                        alt="Marketplace Image" style="">
                                </div>
                            </div>
                        </div>
                        {{-- single odiance End --}}
                        {{-- single odiance Start --}}
                        <div class="col-md-2">
                            <div class="brand-slider__item px-24 card"
                                style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                <div class="card-img text-center">
                                    <img src="{{ asset('frontend/v2/assets/images/marketplace/themeforest.png') }}"
                                        alt="Marketplace Image" style="">
                                </div>
                            </div>
                        </div>
                        {{-- single odiance End --}}
                        {{-- single odiance Start --}}
                        <div class="col-md-2">
                            <div class="brand-slider__item px-24 card"
                                style="background: #fff; height:80px; line-height:50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; padding: 15px; -webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); box-shadow: 5px 5px 20px rgba(0, 0, 0, .06); margin: 10px 0px;">
                                <div class="card-img text-center">
                                    <img src="{{ asset('frontend/v2/assets/images/marketplace/graphicever.png') }}"
                                        alt="Marketplace Image" style="">
                                </div>
                            </div>
                        </div>
                        {{-- single odiance End --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ================================ Course Category Section End =================================== -->
    {{-- Success Story Start --}}
    <div class="blog-page-section py-120">
        <div class="container">
            <div class="row gy-4 bg-main-25 rounded-16 p-30">
                <div class="col-lg-12">
                    <h3 class="mb-24 text-left">ইনোভা কম্পিউটার্স বিডি এর টপ রেটেড ফ্রিল্যান্সার</h3>

                    <div class="row gy-4">
                        {{-- @dd($story); --}}
                        @foreach ($story as $item)
                            <div class="col-lg-4 col-sm-6">
                                <div
                                    class="instructor-item scale-hover-item bg-white rounded-16 p-12 h-100 border border-neutral-30">
                                    <div class="animation-video" data-aos="zoom-in">
                                        <img src="{{ asset('public/storage/' . $item->image) }}" alt=""
                                            class="border border-white border-3">
                                        <a href="{{ $item->video }}"
                                            class="play-button w-48 h-48 flex-center bg-main-600 text-white rounded-circle text-xl position-absolute top-50 start-50 translate-middle">
                                            <i class="ph-fill ph-play"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Success Story End --}}
@endsection
