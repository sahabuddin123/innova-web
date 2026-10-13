@extends('frontend.v2.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <!-- ==================== Breadcrumb End Here ==================== -->
    {{-- Courses CSS --}}
    <link href="{{ asset('frontend/assets/css/course.css') }}" rel="stylesheet">
    <style>
        .animation-video {
            position: static !important;
        }
    </style>
    <!-- =============================== Courses Section Start ================================== -->
    <section class="section" id="profe_graphic_banner">
        <div class="pink_shape">
            <img class="img-fluid" src="{{ asset('public/storage/background/Pg_banner_shape2.png') }}" alt="pink color victor shape">
        </div>
        <div class="white_dots">
            <img class="img-fluid" src="{{ asset('public/storage/background/Pg_banner_shape4.png') }}"
                alt="white color dots victor">
        </div>
        <div class="yellow_shape">
            <img class="img-fluid" src="{{ asset('public/storage/background/Pg_banner_shape1.png') }}"
                alt="Yellow color victor shape">
        </div>
        <div class="container">
            @if (\Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {!! \Session::get('success') !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @php
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
            @endphp
            <!-- course list -->
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6">
                    <div class="pg_banner_text">
                        <h4>{{ $courses->shortTitle }} </h4>
                        <h1>{{ $courses->name }}</h1>
                        <ul>
                            <li>মেয়াদ<span>{{ englishToBanglaNumbertwo($courses->courseduration) }} মাস</span></li>
                            <li>লেকচার<span>{{ englishToBanglaNumbertwo($courses->lacture) }}+</span></li>
                            <li>মডিউল<span>{{ englishToBanglaNumbertwo($courses->totalmoduls) }}</span></li>
                            <li>প্রজেক্ট<span>{{englishToBanglaNumbertwo($courses->totalproject) }}+</span></li>
                        </ul>
                        <div class="course_desc_article">
                            {!! $courses->description !!}
                        </div>
                        <div class="pg_banner_btn">
                            <a href="{{ route('frontend.course.admission', $courses->id) }}">ভর্তি</a>
                            <a href="{{ route('frontend.seminors') }}">ফ্রি সেমিনার</a>
                        </div>
                        <div class="stars">
                            {{-- <p> ৬,৭০০ রিভিউস<span>৫,৩৬০ স্টুডেন্ট</span></p> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 pg_banner_img_col">
                    <div class="pg_banner_img position-relative" style="z-index: 1">
                        @if ($courses->video == null)
                            <a href="https://www.youtube.com/watch?v=v-Yi2RRNS3A&t=12s"
                                class="play-button w-48 h-48 flex-center bg-main-600 text-white rounded-circle text-xl position-absolute top-50 start-50 translate-middle">
                                <i class="ph-fill ph-play"></i>
                            </a>
                        @else
                            <a href="{{ $courses->video }}"
                                class="play-button w-48 h-48 flex-center bg-main-600 text-white rounded-circle text-xl position-absolute top-50 start-50 translate-middle">
                                <i class="ph-fill ph-play"></i>
                            </a>
                        @endif
                        <img class="img-fluid w-100 video_thumb" src="{{ asset('public/storage/' . $courses->image) }}"
                            alt="">

                        </a>
                    </div>
                    <div class="yellow_dots_right">
                        <img src="{{ asset('public/storage/background/Pg_banner_shape3.png') }}" alt="Yellow color dots"
                            style="z-index: -1">
                    </div>
                    <div class="yellow_dot_left">
                        <img src="{{ asset('public/storage/background/Pg_banner_shape3.png') }}" alt="Yellow color dots"
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
                        {!! $courses->overview !!}
                    </div>
                    <div class="sm_device-show d-block d-sm-none">
                        <div class="pg_succsess_story">
                            <div class="heading">
                                <h4><span>সাফল্যের গল্প</span> <span><a href="{{ route('frontend.successstory') }}">আরো
                                            দেখুন</a></span></h4>
                            </div>
                            <div class="pg_succsess_img_slider slick-initialized slick-slider slick-dotted"><i
                                    class="fa fa-angle-left angle-left slick-arrow" style="display: block;"></i>
                                    <div class="review-slider">
                                        @if(!empty($story))
                                        @foreach ($story as $item)
                                            <div class="rounded-12 text-center transition-2 item-hover bg-main-25 hover-bg-main-600">
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
                                        @endif
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
                                        <p>৳ {{ $courses->coursefee }} BDT
                                        </p><a href="{{ route('frontend.course.admission', $courses->id) }}">ভর্তি</a>
                                    </div>
                                    <div class="join_offline">
                                        <h4>Course Fee (Online)</h4>
                                        <p>
                                            @php
                                                $discount = ($courses->coursefee * 40) / 100;
                                            @endphp
                                            ৳ {{ $courses->coursefee - $discount }} BDT
                                        </p>
                                        <a href="{{ route('frontend.course.admission', $courses->id) }}">ভর্তি</a>
                                    </div>
                                </div>
                                <div class="wait_btn text-center"><a href="#">ফ্রি সেমিনার</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="pgc_curriculum_wrap">
                        {!! $courses->curriculum !!}
                    </div>
                    <div class="pgc_software">
                        {!! $courses->software !!}
                    </div>
                    <div class="pgc_for_whom">
                        {!! $courses->trainee !!}
                    </div>
                    <div class="pg_marketplace">
                        {!! $courses->jobPlacement !!}
                    </div>
                    <div class="pg_job">
                        {!! $courses->jobPosition !!}
                    </div>
                    {{-- <div class="pgs_facilitice">
     
                 </div>
                 <div class="pgs_project"></div> --}}
                </div>
                <div id="sidebar" class="col-lg-5 d-none d-sm-block">
                    <div class="pg_succsess_story">
                        <div class="heading">
                            <h4><span>সাফল্যের গল্প</span> <span><a href="{{ route('frontend.successstory') }}">আরো
                                        দেখুন</a></span></h4>
                        </div>
                        <div class="pg_succsess_img_slider slick-initialized slick-slider slick-dotted"><i
                                class="fa fa-angle-left angle-left slick-arrow" style="display: block;"></i>
                           
                            <div class="review-slider">
                                @if(!empty($story))
                                @foreach ($story as $item)
                                    <div class="rounded-12 text-center transition-2 item-hover bg-main-25 hover-bg-main-600">
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
                                @endif
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
                                    <p>৳ {{ englishToBanglaNumber($courses->coursefee) }} টাকা</p>
                                    <a href="{{ route('frontend.course.admission', $courses->id) }}">ভর্তি</a>
                                </div>
                                <div class="join_offline">
                                    <h4>কোর্স ফি (অনলাইন)</h4>
                                    <p>
                                        @php
                                            $discount = ($courses->coursefee * 40) / 100;
                                        @endphp
                                        ৳ {{ englishToBanglaNumber($courses->coursefee - $discount) }} টাকা
                                    </p>
                                    <a href="{{ route('frontend.course.admission', $courses->id) }}">ভর্তি</a>
                                </div>
                            </div>
                            <div class="wait_btn text-center"><a href="{{ route('frontend.seminors') }}">ফ্রি সেমিনার</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =============================== Courses Section End ================================== -->
@endsection
