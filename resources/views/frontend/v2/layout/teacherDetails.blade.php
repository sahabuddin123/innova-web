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
                        <h1 class="breadcrumb__title display-4 fw-semibold text-center"> প্রবন্ধ</h1>
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
                                <span class="text-main-two-600"> ব্লগ </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== Breadcrumb End Here ==================== -->
       <!-- ================================ Instructor Details Section Start ==================================== -->
       <section class="instructor-details py-120 position-relative z-1">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <div class="instructor-details__thumb">
                        <img src="{{ asset('public/storage/' . $teacher->image) }}" alt="" class="max-h-416 max-w-416 cover-img rounded-circle">
                        <ul class="social-list flex-center gap-16 mt-40">
                            <li class="social-list__item">
                                <a href="{{ $teacher->link1 }}" class="text-main-600 text-xl hover-text-white w-40 h-40 rounded-circle border border-main-600 hover-bg-main-600 flex-center"><i class="ph-bold ph-facebook-logo"></i></a>
                            </li>
                            <li class="social-list__item">
                                <a href="{{ $teacher->link2 }}" class="text-main-600 text-xl hover-text-white w-40 h-40 rounded-circle border border-main-600 hover-bg-main-600 flex-center"> <i class="ph-bold ph-instagram-logo"></i></a>
                            </li>
                            <li class="social-list__item">
                                <a href="{{ $teacher->link3 }}" class="text-main-600 text-xl hover-text-white w-40 h-40 rounded-circle border border-main-600 hover-bg-main-600 flex-center"><i class="ph-bold ph-behance-logo"></i></a>
                            </li>
                            <li class="social-list__item">
                                <a href="{{ $teacher->link4 }}" class="text-main-600 text-xl hover-text-white w-40 h-40 rounded-circle border border-main-600 hover-bg-main-600 flex-center"><i class="ph-bold ph-twitter-logo"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8 ps-xl-5">
                    <div class="ps-lg-5">
                        <h5 class="text-main-600 mb-0">ইনস্ট্রাকটর</h5>
                        <h2 class="my-16">{{ $teacher->name }}</h2>
                        <span class="text-neutral-700">{{ $teacher->designation }}</span>
                        <div class="d-flex flex-column gap-16 flex-wrap max-w-340 mt-40">
                            <div class="flex-between gap-8">
                                <div class="flex-align gap-8">
                                    <span class="text-neutral-700 text-2xl d-flex"><i class="ph-bold ph-lightbulb"></i></span>
                                    <span class="text-neutral-700 text-lg fw-medium">{{ $teacher->subject }}</span>
                                </div>
                                <div class="flex-align gap-8">
                                    <span class="text-neutral-700 text-2xl d-flex"><i class="ph-bold ph-watch"></i></span>
                                    <span class="text-neutral-700 text-lg fw-medium">{{ $teacher->ComCourse }}</span>
                                </div>
                            </div>
                            <div class="flex-between gap-8 flex-wrap">
                                <div class="flex-align gap-8">
                                    <span class="text-neutral-700 text-2xl d-flex"><i class="ph-bold ph-users"></i></span>
                                    <span class="text-neutral-700 text-lg fw-medium">{{ $teacher->nStd }} শিক্ষার্থী</span>
                                </div>
                                <div class="flex-align gap-4">
                                    <span class="text-2xl fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                    <span class="text-lg text-neutral-700 fw-semibold">
                                        {{ $teacher->rating }}
                                        <span class="text-neutral-100 fw-normal">({{ $teacher->review }})</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <span class="d-block border border-neutral-30 my-40 border-dashed"></span>
                        <h4 class="mb-24">জীবন বৃত্তান্ত</h4>
                        <p class="text-neutral-500">{{ $teacher->bio }}</p>
                        <span class="d-block border border-neutral-30 my-40 border-dashed"></span>
                        <h4 class="mb-24">যোগাযোগ</h4>
                        <div class="d-flex flex-column gap-24">
                            <div class="flex-align gap-12">
                                <span class="text-2xl w-44 h-44 border border border-neutral-30 rounded-4 flex-center text-main-600 bg-main-25">
                                    <i class="ph-bold ph-phone-call"></i>
                                </span>
                                <a href="tel:{{ $teacher->phone }}" class="text-neutral-500 hover-text-main-600"> {{ $teacher->phone }}</a>
                            </div>
                            <div class="flex-align gap-12">
                                <span class="text-2xl w-44 h-44 border border border-neutral-30 rounded-4 flex-center text-success-600 bg-main-25">
                                    <i class="ph-bold ph-envelope-simple"></i>
                                </span>
                                <a href="mailto:{{ $teacher->email }}" class="text-neutral-500 hover-text-main-600"> {{ $teacher->email }}</a>
                            </div>
                            <div class="flex-align gap-12">
                                <span class="text-2xl w-44 h-44 border border border-neutral-30 rounded-4 flex-center text-warning-600 bg-main-25">
                                    <i class="ph-bold ph-map-pin-line"></i>
                                </span>
                                <span class="text-neutral-500">{{ $teacher->address }}</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================================ Instructor Details Section End ==================================== -->
@endsection
