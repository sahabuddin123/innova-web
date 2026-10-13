@extends('frontend.v2.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <style>
        .animation-video {
            position: static !important;
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
                        <h1 class="breadcrumb__title display-4 fw-semibold text-center"> সাফল্যের গল্প</h1>

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
                                <span class="text-main-two-600"> সাফল্যের গল্প </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==================== Breadcrumb End Here ==================== -->
    <!-- ================================ Success Story Start ==================================== -->
    <section class="instructor py-120 position-relative z-1">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape2.png') }}" alt=""
            class="shape one animation-scalation">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape6.png') }}" alt=""
            class="shape six animation-scalation">

        <div class="container">
            <div class="section-heading text-center">
                <h2 class="mb-24">সাফল্যের গল্প</h2>
                <p class="">শিক্ষার্থীদের সাফল্য আমাদের ৫ বছরের পথচলার অনুপ্রেরণা। ইনোভা কম্পিউটার্স বিডি জন্মলগ্ন
                    থেকে এখন পর্যন্ত আমরা আমাদের অগ্রযাত্রার সঙ্গী হয়েছেন কয়েক হাজার মানুষ। দক্ষ মেন্টরদের অভিজ্ঞ গাইডলাইনে
                    আমরা পেয়েছি অজস্র সফল মুখ। সফলদের অনেকেই নিজেদের প্রতিষ্ঠান গড়ে তোলার পাশাপাশি কর্মসংস্থান করেছেন আরও
                    মানুষের। দেশ-বিদেশের কাজ বা ফ্রিল্যান্সিং করে আত্মনির্ভরশীল মুখের সংখ্যাও কম নয়। এমন অসংখ্য সফলতার গল্প
                    ইনোভা কম্পিউটার্স বিডি কে নিয়ে গেছে এক অপ্রতিদ্বন্দ্বী অবস্থানে।</p>
            </div>
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
            <ul class="pagination mt-40 flex-align gap-12 flex-wrap justify-content-center">
                {{ $story->appends(request()->input())->links() }}
            </ul>
        </div>
    </section>
    <!-- ================================ Success Story End ==================================== -->
    <section class="explore-course py-120 bg-main-25 position-relative z-1">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape2.png') }}" alt=""
            class="shape six animation-scalation">

        <div class="container">
            <div class="section-heading text-center style-flex gap-24">
                <div class="section-heading__inner text-start">
                    <h2 class="mb-0 wow bounceIn">জনপ্রিয় কোর্সসমূহ</h2>
                </div>
                <div class="section-heading__content">
                    <p class="section-heading__desc text-start mt-0 text-line-2 wow bounceInUp">দেশ ও দেশের বাইরে বর্তমানে
                        যে স্কিলগুলোর চাহিদা সবচেয়ে বেশি, সেসব দিয়েই সাজানো হয়েছে আমাদের কোর্স লিস্ট। এখান থেকে আপনার
                        সুবিধামত অনলাইন বা অফলাইন কোর্সে এনরোল করতে পারবেন যেকোনো সময়।</p>
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
                    @foreach ($FeaturecourseCategory as $item)
                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link rounded-pill bg-main-25 text-md fw-medium text-neutral-500 flex-center w-100 gap-8"
                                id="pills-design-tab" data-bs-toggle="pill" data-bs-target="#{{ $item->tabId }}"
                                type="button" role="tab" aria-controls="pills-design" aria-selected="false">
                                <i class="text-xl d-flex ph-bold {{ $item->fontawesome }}"></i>
                                {{ $item->CourseCategoris }}
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-categories" role="tabpanel"
                    aria-labelledby="pills-categories-tab" tabindex="0">
                    <div class="row gy-4">
                        @foreach ($courses as $item)
                            <!-- Course Card Start -->
                            <div class="col-lg-4 col-sm-6 wow fadeInUp" data-aos="fade-up" data-aos-duration="200">
                                <div class="course-item bg-white rounded-16 p-12 h-100 box-shadow-md">
                                    <div class="course-item__thumb rounded-12 overflow-hidden position-relative">
                                        <a href="{{ route('frontend.course.details', $item->id) }}" class="w-100 h-100">
                                            <img src="{{ asset('public/storage/' . $item->image) }}" alt="Course Image"
                                                class="course-item__img rounded-12 cover-img transition-2">
                                        </a>
                                        <div
                                            class="flex-align gap-8 bg-main-600 rounded-pill px-24 py-12 text-white position-absolute inset-block-start-0 inset-inline-start-0 mt-20 ms-20 z-1">
                                            <span class="text-2xl d-flex"><i class="ph ph-clock"></i></span>
                                            <span class="text-lg fw-medium">{{ $item->courseduration }} মাস</span>
                                        </div>
                                        <button type="button"
                                            class="wishlist-btn w-48 h-48 bg-white text-main-two-600 flex-center position-absolute inset-block-start-0 inset-inline-end-0 mt-20 me-20 z-1 text-2xl rounded-circle transition-2">
                                            <i class="ph ph-heart"></i>
                                        </button>
                                    </div>
                                    <div class="course-item__content">
                                        <div class="">
                                            <h4 class="mb-28">
                                                <a href="{{ route('frontend.course.details', $item->id) }}"
                                                    class="link text-line-2">{{ $item->name }}</a>
                                            </h4>
                                            <div class="flex-between gap-8 flex-wrap mb-16">
                                                <div class="flex-align gap-8">
                                                    <span class="text-neutral-700 text-2xl d-flex"><i
                                                            class="ph-bold ph-video-camera"></i></span>
                                                    <span
                                                        class="text-neutral-700 text-lg fw-medium">{{ $item->totalmoduls }}
                                                        মডিউল</span>
                                                </div>
                                                <div class="flex-align gap-8">
                                                    <span class="text-neutral-700 text-2xl d-flex"><i
                                                            class="ph-bold ph-chart-bar"></i></span>
                                                    <span
                                                        class="text-neutral-700 text-lg fw-medium">{{ $item->courseFor }}</span>
                                                </div>
                                            </div>
                                            <div class="flex-between gap-8 flex-wrap">
                                                <div class="flex-align gap-4">
                                                    <span class="text-2xl fw-medium text-warning-600 d-flex"><i
                                                            class="ph-fill ph-star"></i></span>
                                                    <span class="text-lg text-neutral-700">
                                                        {{ $item->Rating }}
                                                        <span class="text-neutral-100">({{ $item->TotalReview }})</span>
                                                    </span>
                                                </div>
                                                <div class="flex-align gap-8">
                                                    @if ($item->Instructor != null)
                                                        @php
                                                            $teaher = DB::table('teachers')
                                                                ->where('id', $item->Instructor)
                                                                ->first();
                                                        @endphp
                                                        <span class="text-neutral-700 text-2xl d-flex">
                                                            <img src="{{ asset('public/storage/' . $teaher->image) }}"
                                                                alt="User Image"
                                                                class="w-32 h-32 object-fit-cover rounded-circle">
                                                        </span>
                                                        <span class="text-neutral-700 text-lg fw-medium"
                                                            style="text-transform: capitalize">{{ substr($teaher->name, 0, 7) }}.</span>
                                                    @else
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="flex-between gap-8 pt-24 border-top border-neutral-50 mt-28 border-dashed border-0">
                                            <h4 class="mb-0 text-main-two-600">
                                                @if ($item->Discount != null)
                                                    <del>৳{{ $item->coursefee }}</del>
                                                    &nbsp;৳{{ $item->coursefee - $item->Discount }}
                                                @else
                                                    ৳{{ $item->coursefee }}
                                                @endif

                                            </h4>
                                            <a href="{{ route('frontend.course.admission', $item->id) }}"
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
                        @endforeach
                    </div>
                </div>
                {{-- TAB CONTENT Web START --}}
                <div class="tab-pane fade" id="web-software" role="tabpanel" aria-labelledby="pills-design-tab"
                    tabindex="0">
                    <div class="row gy-4">
                        @foreach ($Webcourses as $item)
                            <div class="col-lg-4 col-sm-6 wow fadeInUp" data-aos="fade-up" data-aos-duration="200">
                                <div class="course-item bg-white rounded-16 p-12 h-100 box-shadow-md">
                                    <div class="course-item__thumb rounded-12 overflow-hidden position-relative">
                                        <a href="{{ route('frontend.course.details', $item->id) }}" class="w-100 h-100">
                                            <img src="{{ asset('public/storage/' . $item->image) }}" alt="Course Image"
                                                class="course-item__img rounded-12 cover-img transition-2">
                                        </a>
                                        <div
                                            class="flex-align gap-8 bg-main-600 rounded-pill px-24 py-12 text-white position-absolute inset-block-start-0 inset-inline-start-0 mt-20 ms-20 z-1">
                                            <span class="text-2xl d-flex"><i class="ph ph-clock"></i></span>
                                            <span class="text-lg fw-medium">{{ $item->courseduration }} মাস</span>
                                        </div>
                                        <button type="button"
                                            class="wishlist-btn w-48 h-48 bg-white text-main-two-600 flex-center position-absolute inset-block-start-0 inset-inline-end-0 mt-20 me-20 z-1 text-2xl rounded-circle transition-2">
                                            <i class="ph ph-heart"></i>
                                        </button>
                                    </div>
                                    <div class="course-item__content">
                                        <div class="">
                                            <h4 class="mb-28">
                                                <a href="{{ route('frontend.course.details', $item->id) }}"
                                                    class="link text-line-2">{{ $item->name }}</a>
                                            </h4>
                                            <div class="flex-between gap-8 flex-wrap mb-16">
                                                <div class="flex-align gap-8">
                                                    <span class="text-neutral-700 text-2xl d-flex"><i
                                                            class="ph-bold ph-video-camera"></i></span>
                                                    <span
                                                        class="text-neutral-700 text-lg fw-medium">{{ $item->totalmoduls }}
                                                        মডিউল</span>
                                                </div>
                                                <div class="flex-align gap-8">
                                                    <span class="text-neutral-700 text-2xl d-flex"><i
                                                            class="ph-bold ph-chart-bar"></i></span>
                                                    <span
                                                        class="text-neutral-700 text-lg fw-medium">{{ $item->courseFor }}</span>
                                                </div>
                                            </div>
                                            <div class="flex-between gap-8 flex-wrap">
                                                <div class="flex-align gap-4">
                                                    <span class="text-2xl fw-medium text-warning-600 d-flex"><i
                                                            class="ph-fill ph-star"></i></span>
                                                    <span class="text-lg text-neutral-700">
                                                        {{ $item->Rating }}
                                                        <span class="text-neutral-100">({{ $item->TotalReview }})</span>
                                                    </span>
                                                </div>
                                                <div class="flex-align gap-8">
                                                    @if ($item->Instructor != null)
                                                        @php
                                                            $teaher = DB::table('teachers')
                                                                ->where('id', $item->Instructor)
                                                                ->first();
                                                        @endphp
                                                        <span class="text-neutral-700 text-2xl d-flex">
                                                            <img src="{{ asset('public/storage/' . $teaher->image) }}"
                                                                alt="User Image"
                                                                class="w-32 h-32 object-fit-cover rounded-circle">
                                                        </span>
                                                        <span class="text-neutral-700 text-lg fw-medium"
                                                            style="text-transform: capitalize">{{ substr($teaher->name, 0, 7) }}.</span>
                                                    @else
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="flex-between gap-8 pt-24 border-top border-neutral-50 mt-28 border-dashed border-0">
                                            <h4 class="mb-0 text-main-two-600">
                                                @if ($item->Discount != null)
                                                    <del>৳{{ $item->coursefee }}</del>
                                                    &nbsp;৳{{ $item->coursefee - $item->Discount }}
                                                @else
                                                    ৳{{ $item->coursefee }}
                                                @endif

                                            </h4>
                                            <a href="{{ route('frontend.course.admission', $item->id) }}"
                                                class="flex-align gap-8 text-main-600 hover-text-decoration-underline transition-1 fw-semibold"
                                                tabindex="0">
                                                এনরোল করুন
                                                <i class="ph ph-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{-- TAB CONTENT web END  --}}
                {{-- TAB CONTENT marketing START --}}
                <div class="tab-pane fade" id="digital-marketing" role="tabpanel" aria-labelledby="pills-design-tab"
                    tabindex="0">
                    <div class="row gy-4">
                        @foreach ($digitalCourses as $item)
                            <div class="col-lg-4 col-sm-6 wow fadeInUp" data-aos="fade-up" data-aos-duration="200">
                                <div class="course-item bg-white rounded-16 p-12 h-100 box-shadow-md">
                                    <div class="course-item__thumb rounded-12 overflow-hidden position-relative">
                                        <a href="{{ route('frontend.course.details', $item->id) }}" class="w-100 h-100">
                                            <img src="{{ asset('public/storage/' . $item->image) }}" alt="Course Image"
                                                class="course-item__img rounded-12 cover-img transition-2">
                                        </a>
                                        <div
                                            class="flex-align gap-8 bg-main-600 rounded-pill px-24 py-12 text-white position-absolute inset-block-start-0 inset-inline-start-0 mt-20 ms-20 z-1">
                                            <span class="text-2xl d-flex"><i class="ph ph-clock"></i></span>
                                            <span class="text-lg fw-medium">{{ $item->courseduration }} মাস</span>
                                        </div>
                                        <button type="button"
                                            class="wishlist-btn w-48 h-48 bg-white text-main-two-600 flex-center position-absolute inset-block-start-0 inset-inline-end-0 mt-20 me-20 z-1 text-2xl rounded-circle transition-2">
                                            <i class="ph ph-heart"></i>
                                        </button>
                                    </div>
                                    <div class="course-item__content">
                                        <div class="">
                                            <h4 class="mb-28">
                                                <a href="{{ route('frontend.course.details', $item->id) }}"
                                                    class="link text-line-2">{{ $item->name }}</a>
                                            </h4>
                                            <div class="flex-between gap-8 flex-wrap mb-16">
                                                <div class="flex-align gap-8">
                                                    <span class="text-neutral-700 text-2xl d-flex"><i
                                                            class="ph-bold ph-video-camera"></i></span>
                                                    <span
                                                        class="text-neutral-700 text-lg fw-medium">{{ $item->totalmoduls }}
                                                        মডিউল</span>
                                                </div>
                                                <div class="flex-align gap-8">
                                                    <span class="text-neutral-700 text-2xl d-flex"><i
                                                            class="ph-bold ph-chart-bar"></i></span>
                                                    <span
                                                        class="text-neutral-700 text-lg fw-medium">{{ $item->courseFor }}</span>
                                                </div>
                                            </div>
                                            <div class="flex-between gap-8 flex-wrap">
                                                <div class="flex-align gap-4">
                                                    <span class="text-2xl fw-medium text-warning-600 d-flex"><i
                                                            class="ph-fill ph-star"></i></span>
                                                    <span class="text-lg text-neutral-700">
                                                        {{ $item->Rating }}
                                                        <span class="text-neutral-100">({{ $item->TotalReview }})</span>
                                                    </span>
                                                </div>
                                                <div class="flex-align gap-8">
                                                    @if ($item->Instructor != null)
                                                        @php
                                                            $teaher = DB::table('teachers')
                                                                ->where('id', $item->Instructor)
                                                                ->first();
                                                        @endphp
                                                        <span class="text-neutral-700 text-2xl d-flex">
                                                            <img src="{{ asset('public/storage/' . $teaher->image) }}"
                                                                alt="User Image"
                                                                class="w-32 h-32 object-fit-cover rounded-circle">
                                                        </span>
                                                        <span class="text-neutral-700 text-lg fw-medium"
                                                            style="text-transform: capitalize">{{ substr($teaher->name, 0, 7) }}.</span>
                                                    @else
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="flex-between gap-8 pt-24 border-top border-neutral-50 mt-28 border-dashed border-0">
                                            <h4 class="mb-0 text-main-two-600">
                                                @if ($item->Discount != null)
                                                    <del>৳{{ $item->coursefee }}</del>
                                                    &nbsp;৳{{ $item->coursefee - $item->Discount }}
                                                @else
                                                    ৳{{ $item->coursefee }}
                                                @endif

                                            </h4>
                                            <a href="{{ route('frontend.course.admission', $item->id) }}"
                                                class="flex-align gap-8 text-main-600 hover-text-decoration-underline transition-1 fw-semibold"
                                                tabindex="0">
                                                এনরোল করুন
                                                <i class="ph ph-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{-- TAB CONTENT marketing END --}}
                {{-- TAB CONTENT English language START --}}
                <div class="tab-pane fade" id="english-language" role="tabpanel" aria-labelledby="pills-design-tab"
                    tabindex="0">
                    <div class="row gy-4">
                        @foreach ($EnglishCourses as $item)
                            <div class="col-lg-4 col-sm-6 wow fadeInUp" data-aos="fade-up" data-aos-duration="200">
                                <div class="course-item bg-white rounded-16 p-12 h-100 box-shadow-md">
                                    <div class="course-item__thumb rounded-12 overflow-hidden position-relative">
                                        <a href="{{ route('frontend.course.details', $item->id) }}" class="w-100 h-100">
                                            <img src="{{ asset('public/storage/' . $item->image) }}" alt="Course Image"
                                                class="course-item__img rounded-12 cover-img transition-2">
                                        </a>
                                        <div
                                            class="flex-align gap-8 bg-main-600 rounded-pill px-24 py-12 text-white position-absolute inset-block-start-0 inset-inline-start-0 mt-20 ms-20 z-1">
                                            <span class="text-2xl d-flex"><i class="ph ph-clock"></i></span>
                                            <span class="text-lg fw-medium">{{ $item->courseduration }} মাস</span>
                                        </div>
                                        <button type="button"
                                            class="wishlist-btn w-48 h-48 bg-white text-main-two-600 flex-center position-absolute inset-block-start-0 inset-inline-end-0 mt-20 me-20 z-1 text-2xl rounded-circle transition-2">
                                            <i class="ph ph-heart"></i>
                                        </button>
                                    </div>
                                    <div class="course-item__content">
                                        <div class="">
                                            <h4 class="mb-28">
                                                <a href="{{ route('frontend.course.details', $item->id) }}"
                                                    class="link text-line-2">{{ $item->name }}</a>
                                            </h4>
                                            <div class="flex-between gap-8 flex-wrap mb-16">
                                                <div class="flex-align gap-8">
                                                    <span class="text-neutral-700 text-2xl d-flex"><i
                                                            class="ph-bold ph-video-camera"></i></span>
                                                    <span
                                                        class="text-neutral-700 text-lg fw-medium">{{ $item->totalmoduls }}
                                                        মডিউল</span>
                                                </div>
                                                <div class="flex-align gap-8">
                                                    <span class="text-neutral-700 text-2xl d-flex"><i
                                                            class="ph-bold ph-chart-bar"></i></span>
                                                    <span
                                                        class="text-neutral-700 text-lg fw-medium">{{ $item->courseFor }}</span>
                                                </div>
                                            </div>
                                            <div class="flex-between gap-8 flex-wrap">
                                                <div class="flex-align gap-4">
                                                    <span class="text-2xl fw-medium text-warning-600 d-flex"><i
                                                            class="ph-fill ph-star"></i></span>
                                                    <span class="text-lg text-neutral-700">
                                                        {{ $item->Rating }}
                                                        <span class="text-neutral-100">({{ $item->TotalReview }})</span>
                                                    </span>
                                                </div>
                                                <div class="flex-align gap-8">
                                                    @if ($item->Instructor != null)
                                                        @php
                                                            $teaher = DB::table('teachers')
                                                                ->where('id', $item->Instructor)
                                                                ->first();
                                                        @endphp
                                                        <span class="text-neutral-700 text-2xl d-flex">
                                                            <img src="{{ asset('public/storage/' . $teaher->image) }}"
                                                                alt="User Image"
                                                                class="w-32 h-32 object-fit-cover rounded-circle">
                                                        </span>
                                                        <span class="text-neutral-700 text-lg fw-medium"
                                                            style="text-transform: capitalize">{{ substr($teaher->name, 0, 7) }}.</span>
                                                    @else
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="flex-between gap-8 pt-24 border-top border-neutral-50 mt-28 border-dashed border-0">
                                            <h4 class="mb-0 text-main-two-600">
                                                @if ($item->Discount != null)
                                                    <del>৳{{ $item->coursefee }}</del>
                                                    &nbsp;৳{{ $item->coursefee - $item->Discount }}
                                                @else
                                                    ৳{{ $item->coursefee }}
                                                @endif

                                            </h4>
                                            <a href="{{ route('frontend.course.admission', $item->id) }}"
                                                class="flex-align gap-8 text-main-600 hover-text-decoration-underline transition-1 fw-semibold"
                                                tabindex="0">
                                                এনরোল করুন
                                                <i class="ph ph-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{-- TAB CONTENT english language END --}}
                {{-- TAB CONTENT Basic Program START --}}
                <div class="tab-pane fade" id="basic-program" role="tabpanel" aria-labelledby="pills-design-tab"
                    tabindex="0">
                    <div class="row gy-4">
                        @foreach ($BasicCourses as $item)
                            <div class="col-lg-4 col-sm-6 wow fadeInUp" data-aos="fade-up" data-aos-duration="200">
                                <div class="course-item bg-white rounded-16 p-12 h-100 box-shadow-md">
                                    <div class="course-item__thumb rounded-12 overflow-hidden position-relative">
                                        <a href="{{ route('frontend.course.details', $item->id) }}" class="w-100 h-100">
                                            <img src="{{ asset('public/storage/' . $item->image) }}" alt="Course Image"
                                                class="course-item__img rounded-12 cover-img transition-2">
                                        </a>
                                        <div
                                            class="flex-align gap-8 bg-main-600 rounded-pill px-24 py-12 text-white position-absolute inset-block-start-0 inset-inline-start-0 mt-20 ms-20 z-1">
                                            <span class="text-2xl d-flex"><i class="ph ph-clock"></i></span>
                                            <span class="text-lg fw-medium">{{ $item->courseduration }} মাস</span>
                                        </div>
                                        <button type="button"
                                            class="wishlist-btn w-48 h-48 bg-white text-main-two-600 flex-center position-absolute inset-block-start-0 inset-inline-end-0 mt-20 me-20 z-1 text-2xl rounded-circle transition-2">
                                            <i class="ph ph-heart"></i>
                                        </button>
                                    </div>
                                    <div class="course-item__content">
                                        <div class="">
                                            <h4 class="mb-28">
                                                <a href="{{ route('frontend.course.details', $item->id) }}"
                                                    class="link text-line-2">{{ $item->name }}</a>
                                            </h4>
                                            <div class="flex-between gap-8 flex-wrap mb-16">
                                                <div class="flex-align gap-8">
                                                    <span class="text-neutral-700 text-2xl d-flex"><i
                                                            class="ph-bold ph-video-camera"></i></span>
                                                    <span
                                                        class="text-neutral-700 text-lg fw-medium">{{ $item->totalmoduls }}
                                                        মডিউল</span>
                                                </div>
                                                <div class="flex-align gap-8">
                                                    <span class="text-neutral-700 text-2xl d-flex"><i
                                                            class="ph-bold ph-chart-bar"></i></span>
                                                    <span
                                                        class="text-neutral-700 text-lg fw-medium">{{ $item->courseFor }}</span>
                                                </div>
                                            </div>
                                            <div class="flex-between gap-8 flex-wrap">
                                                <div class="flex-align gap-4">
                                                    <span class="text-2xl fw-medium text-warning-600 d-flex"><i
                                                            class="ph-fill ph-star"></i></span>
                                                    <span class="text-lg text-neutral-700">
                                                        {{ $item->Rating }}
                                                        <span class="text-neutral-100">({{ $item->TotalReview }})</span>
                                                    </span>
                                                </div>
                                                <div class="flex-align gap-8">
                                                    @if ($item->Instructor != null)
                                                        @php
                                                            $teaher = DB::table('teachers')
                                                                ->where('id', $item->Instructor)
                                                                ->first();
                                                        @endphp
                                                        <span class="text-neutral-700 text-2xl d-flex">
                                                            <img src="{{ asset('public/storage/' . $teaher->image) }}"
                                                                alt="User Image"
                                                                class="w-32 h-32 object-fit-cover rounded-circle">
                                                        </span>
                                                        <span class="text-neutral-700 text-lg fw-medium"
                                                            style="text-transform: capitalize">{{ substr($teaher->name, 0, 7) }}.</span>
                                                    @else
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="flex-between gap-8 pt-24 border-top border-neutral-50 mt-28 border-dashed border-0">
                                            <h4 class="mb-0 text-main-two-600">
                                                @if ($item->Discount != null)
                                                    <del>৳{{ $item->coursefee }}</del>
                                                    &nbsp;৳{{ $item->coursefee - $item->Discount }}
                                                @else
                                                    ৳{{ $item->coursefee }}
                                                @endif

                                            </h4>
                                            <a href="{{ route('frontend.course.admission', $item->id) }}"
                                                class="flex-align gap-8 text-main-600 hover-text-decoration-underline transition-1 fw-semibold"
                                                tabindex="0">
                                                এনরোল করুন
                                                <i class="ph ph-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{-- TAB CONTENT basic Program END --}}
                {{-- TAB CONTENT Design and multimedia START --}}
                <div class="tab-pane fade" id="design-multimedia" role="tabpanel" aria-labelledby="pills-design-tab"
                    tabindex="0">
                    <div class="row gy-4">
                        @foreach ($GraphicCourses as $item)
                            <div class="col-lg-4 col-sm-6 wow fadeInUp" data-aos="fade-up" data-aos-duration="200">
                                <div class="course-item bg-white rounded-16 p-12 h-100 box-shadow-md">
                                    <div class="course-item__thumb rounded-12 overflow-hidden position-relative">
                                        <a href="{{ route('frontend.course.details', $item->id) }}" class="w-100 h-100">
                                            <img src="{{ asset('public/storage/' . $item->image) }}" alt="Course Image"
                                                class="course-item__img rounded-12 cover-img transition-2">
                                        </a>
                                        <div
                                            class="flex-align gap-8 bg-main-600 rounded-pill px-24 py-12 text-white position-absolute inset-block-start-0 inset-inline-start-0 mt-20 ms-20 z-1">
                                            <span class="text-2xl d-flex"><i class="ph ph-clock"></i></span>
                                            <span class="text-lg fw-medium">{{ $item->courseduration }} মাস</span>
                                        </div>
                                        <button type="button"
                                            class="wishlist-btn w-48 h-48 bg-white text-main-two-600 flex-center position-absolute inset-block-start-0 inset-inline-end-0 mt-20 me-20 z-1 text-2xl rounded-circle transition-2">
                                            <i class="ph ph-heart"></i>
                                        </button>
                                    </div>
                                    <div class="course-item__content">
                                        <div class="">
                                            <h4 class="mb-28">
                                                <a href="{{ route('frontend.course.details', $item->id) }}"
                                                    class="link text-line-2">{{ $item->name }}</a>
                                            </h4>
                                            <div class="flex-between gap-8 flex-wrap mb-16">
                                                <div class="flex-align gap-8">
                                                    <span class="text-neutral-700 text-2xl d-flex"><i
                                                            class="ph-bold ph-video-camera"></i></span>
                                                    <span
                                                        class="text-neutral-700 text-lg fw-medium">{{ $item->totalmoduls }}
                                                        মডিউল</span>
                                                </div>
                                                <div class="flex-align gap-8">
                                                    <span class="text-neutral-700 text-2xl d-flex"><i
                                                            class="ph-bold ph-chart-bar"></i></span>
                                                    <span
                                                        class="text-neutral-700 text-lg fw-medium">{{ $item->courseFor }}</span>
                                                </div>
                                            </div>
                                            <div class="flex-between gap-8 flex-wrap">
                                                <div class="flex-align gap-4">
                                                    <span class="text-2xl fw-medium text-warning-600 d-flex"><i
                                                            class="ph-fill ph-star"></i></span>
                                                    <span class="text-lg text-neutral-700">
                                                        {{ $item->Rating }}
                                                        <span class="text-neutral-100">({{ $item->TotalReview }})</span>
                                                    </span>
                                                </div>
                                                <div class="flex-align gap-8">
                                                    @if ($item->Instructor != null)
                                                        @php
                                                            $teaher = DB::table('teachers')
                                                                ->where('id', $item->Instructor)
                                                                ->first();
                                                        @endphp
                                                        <span class="text-neutral-700 text-2xl d-flex">
                                                            <img src="{{ asset('public/storage/' . $teaher->image) }}"
                                                                alt="User Image"
                                                                class="w-32 h-32 object-fit-cover rounded-circle">
                                                        </span>
                                                        <span class="text-neutral-700 text-lg fw-medium"
                                                            style="text-transform: capitalize">{{ substr($teaher->name, 0, 7) }}.</span>
                                                    @else
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="flex-between gap-8 pt-24 border-top border-neutral-50 mt-28 border-dashed border-0">
                                            <h4 class="mb-0 text-main-two-600">
                                                @if ($item->Discount != null)
                                                    <del>৳{{ $item->coursefee }}</del>
                                                    &nbsp;৳{{ $item->coursefee - $item->Discount }}
                                                @else
                                                    ৳{{ $item->coursefee }}
                                                @endif

                                            </h4>
                                            <a href="{{ route('frontend.course.admission', $item->id) }}"
                                                class="flex-align gap-8 text-main-600 hover-text-decoration-underline transition-1 fw-semibold"
                                                tabindex="0">
                                                এনরোল করুন
                                                <i class="ph ph-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{-- TAB CONTENT Design and multimedia END --}}
            </div>
        </div>
    </section>
    <!-- ================================== Explore Course Section End =========================== -->
@endsection
