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
                        <h1 class="breadcrumb__title display-4 fw-semibold text-center"> সেমিনার রেজিস্ট্রেশন</h1>
                        <ul class="breadcrumb__list d-flex align-items-center justify-content-center gap-4">
                            <li class="breadcrumb__item">
                                <a href="{{ route('frontend.home') }}"
                                    class="breadcrumb__link text-neutral-500 hover-text-main-600 fw-medium">
                                    <i class="text-lg d-inline-flex ph-bold ph-house"></i> হোম</a>
                            </li>
                            <li class="breadcrumb__item">
                                <i class="text-neutral-500 d-flex ph-bold ph-caret-right"></i>
                            </li>
                            <li class="breadcrumb__item">
                                <a href="{{ route('frontend.seminors') }}"
                                    class="breadcrumb__link text-neutral-500 hover-text-main-600 fw-medium">
                                    সেমিনার</a>
                            </li>
                            <li class="breadcrumb__item">
                                <i class="text-neutral-500 d-flex ph-bold ph-caret-right"></i>
                            </li>
                            {{-- <li class="breadcrumb__item">
                                <a href="course.html"
                                    class="breadcrumb__link text-neutral-500 hover-text-main-600 fw-medium"> </a>
                            </li> --}}
                            <li class="breadcrumb__item d-none">
                                <i class="text-neutral-500 d-flex ph-bold ph-caret-right"></i>
                            </li>
                            <li class="breadcrumb__item">
                                <span class="text-main-two-600"> সেমিনার রেজিস্ট্রেশন </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==================== Breadcrumb End Here ==================== -->
    <!-- ================================ Apply For Admission Section Start =================================== -->

    <section class="py-120">
        <div class="container">
            <div class="border border-neutral-30 rounded-12 bg-main-25 p-24 bg-main-25">
                @include('admin.partials.flash')
                <form action="{{ route('frontend.seminors.store') }}" method="post">
                    @csrf
                    <h3 class="mb-24 text-center">রেজিস্ট্রেশনের জন্য আবেদন করুন</h3>

                    <input type="hidden" name="seminor_id" value="{{ $seminor->id }}">
                    <!-- Personal information Start -->
                    <div class="border border-neutral-30 rounded-12 bg-white p-24">
                        <h5 class="mb-0">শিক্ষার্থীর তথ্য</h5>
                        <span class="d-block border border-main-25 my-24 border-dashed"></span>
                        <div class="row gy-4">
                            <div class="col-sm-6">
                                <label for="username" class="text-neutral-700 text-lg fw-medium mb-12">শিক্ষার্থীর নাম <span
                                        class="text-danger-600">*</span> </label>
                                <input type="text"
                                    class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600"
                                    id="username" name="username" value="{{ old('username') }}"
                                    placeholder="আপনার নাম লিখুন...">
                            </div>
                            <div class="col-sm-6">
                                <label for="email" class="text-neutral-700 text-lg fw-medium mb-12">ইমেইল এড্রেস <span
                                        class="text-danger-600">*</span> </label>
                                <input type="email"
                                    class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600"
                                    id="email" name="email" value="{{ old('email') }}"
                                    placeholder="আপনার ইমেইল এড্রেস দিন...">
                            </div>
                            <div class="col-sm-12">
                                <label for="Phone" class="text-neutral-700 text-lg fw-medium mb-12">মোবাইল নাম্বর <span
                                        class="text-danger-600">*</span> </label>
                                <input type="tel"
                                    class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600"
                                    id="Phone" name="phone" value="{{ old('phone') }}"
                                    placeholder="আপনার মোবাইল নাম্বার দিন...">
                            </div>
                            <div class="col-sm-6">
                                <label for="name" class="text-neutral-700 text-lg fw-medium mb-12">শিক্ষার্থীর পেশা
                                    <span class="text-danger-600">*</span> </label>
                                <input type="text"
                                    class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600"
                                    id="profession" name="profession" value="{{ old('profession') }}"
                                    placeholder="আপনার পেশা কি...">
                            </div>
                            <div class="col-sm-12">
                                <label for="address" class="text-neutral-700 text-lg fw-medium mb-12">ঠিকানা </label>
                                <textarea class="common-input bg-main-25 rounded-24 border-transparent focus-border-main-600" id="address"
                                    name="address" placeholder="আপনার ঠিকানা...">{{ old('address') }}</textarea>
                            </div>
                            <div class="col-12 mb-2">
                                <!-- Google reCaptcha v2 -->
                                {!! htmlFormSnippet() !!}
                                @if ($errors->has('g-recaptcha-response'))
                                    <div>
                                        <small class="text-danger">{{ $errors->first('g-recaptcha-response') }}</small>
                                    </div>
                                @endif
                            </div>
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-main rounded-pill flex-center gap-8 mt-16">
                                    সাবমিট করুন
                                    <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Personal information End -->
                </form>
            </div>
        </div>
    </section>
    <!-- ================================ Apply For Admission Section End =================================== -->
@endsection
@push('scripts')
    {!! htmlScriptTagJsApi() !!}
@endpush
