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
                        <h1 class="breadcrumb__title display-4 fw-semibold text-center"> কোর্স সমূহ</h1>
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
                                <span class="text-main-two-600"> কোর্স </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== Breadcrumb End Here ==================== -->
    <!-- =============================== Courses Section Start ================================== -->
    <div class="blog-page-section py-120">
        <div class="container">
            <div class="flex-between gap-16 flex-wrap mb-40">
                <span class="text-neutral-500">
                    Showing {{ $courses->count() }} of {{ $courses->total() }} Results
                </span>
                <div class="flex-align gap-16">
                    <div class="flex-align gap-8">
                        <span class="text-neutral-500 flex-shrink-0">Sort By :</span>
                        <form method="GET" action="{{ route('frontend.courses') }}">
                            <select name="sort_by" onchange="this.form.submit()"
                                class="form-select ps-20 pe-28 py-8 fw-medium rounded-pill bg-main-25 border border-neutral-30 text-neutral-700">
                                <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Newest
                                </option>
                                <option value="trending" {{ request('sort_by') == 'trending' ? 'selected' : '' }}>Trending
                                </option>
                                <option value="popular" {{ request('sort_by') == 'popular' ? 'selected' : '' }}>Popular
                                </option>
                            </select>
                        </form>
                    </div>
                    <button type="button"
                        class="list-bar-btn text-xl w-40 h-40 bg-main-600 text-white rounded-8 flex-center d-lg-none">
                        <i class="ph-bold ph-funnel"></i>
                    </button>
                </div>
            </div>
            @php
                use Carbon\Carbon;
            @endphp
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
                                            <span class="text-neutral-700 text-lg fw-medium">{{ $item->totalmoduls }}
                                                মডিউল</span>
                                        </div>
                                        <div class="flex-align gap-8">
                                            <span class="text-neutral-700 text-2xl d-flex"><i
                                                    class="ph-bold ph-chart-bar"></i></span>
                                            <span class="text-neutral-700 text-lg fw-medium">{{ $item->courseFor }}</span>
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
                                                        alt="User Image" class="w-32 h-32 object-fit-cover rounded-circle">
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
                                    <a href="{{ route('frontend.course.details', $item->id) }}"
                                        class="flex-align gap-8 text-main-600 hover-text-decoration-underline transition-1 fw-semibold"
                                        tabindex="0">
                                        কোর্স বিস্তারিত
                                        <i class="ph ph-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Course Card End -->
                @endforeach
            </div>

            <ul class="pagination mt-40 flex-align gap-12 flex-wrap justify-content-center">
                {{ $courses->appends(request()->input())->links() }}
            </ul>
        </div>
    </div>
    <!-- =============================== Courses Section End ================================== -->
@endsection
