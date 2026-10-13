@extends('frontend.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<!-- page title -->

{{-- Courses CSS --}}
<link href="{{ asset('frontend/assets/css/course.css') }}" rel="stylesheet">
<!-- courses -->
<section class="section" id="profe_graphic_banner">
   <div class="pink_shape">
      <img class="img-fluid" src="{{ asset('public/storage/background/Pg_banner_shape2.png') }}"
         alt="pink color victor shape">
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
      <!-- course list -->
      <div class="row justify-content-center align-items-center">
         <div class="col-lg-6">
            <div class="pg_banner_text">
               <h4>{{$courses->shortTitle}} </h4>
               <h1>{{$courses->name}}</h1>
               <ul>
                  <li>মেয়াদ<span>{{$courses->courseduration}} মাস</span></li>
                  <li>লেকচার<span>{{$courses->lacture}}+</span></li>
                  <li>মডিউল<span>{{$courses->totalmoduls}}</span></li>
                  <li>প্রজেক্ট<span>{{$courses->totalproject}}+</span></li>
               </ul>
               <div class="course_desc_article">
                  {!! $courses->description !!}
               </div>
               <div class="pg_banner_btn">
                  <a href="{{ route('frontend.course.admission', $courses->id) }}">ভর্তি</a>
                  <a href="#">ফ্রি সেমিনার</a>
               </div>
               <div class="stars">
                  {{-- <p> ৬,৭০০ রিভিউস<span>৫,৩৬০ স্টুডেন্ট</span></p> --}}
               </div>
            </div>
         </div>
         <div class="col-lg-6 pg_banner_img_col">
            <div class="pg_banner_img position-relative">
               @if($courses->video == null)
               <a class="venobox vbox-item" data-autoplay="true" data-vbtype="video"
                  href="https://www.youtube.com/watch?v=v-Yi2RRNS3A&t=12s" savefrom_lm_index="2" savefrom_lm="1">
               @else
               <a class="venobox vbox-item" data-autoplay="true" data-vbtype="video"
               href="{{$courses->video}}" savefrom_lm_index="2" savefrom_lm="1">
               @endif
                  <img class="img-fluid w-100 video_thumb" src="{{ asset('public/storage/'.$courses->image) }}" alt="">
                  <div class="overly_icon">
                     <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="play"
                        class="svg-inline--fa fa-play " role="img" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 384 512">
                        <path fill="currentColor"
                           d="M361 215C375.3 223.8 384 239.3 384 256C384 272.7 375.3 288.2 361 296.1L73.03 472.1C58.21 482 39.66 482.4 24.52 473.9C9.377 465.4 0 449.4 0 432V80C0 62.64 9.377 46.63 24.52 38.13C39.66 29.64 58.21 29.99 73.03 39.04L361 215z">
                        </path>
                     </svg>
                  </div>
               </a>
            </div>
            <div class="yellow_dots_right">
               <img src="{{ asset('public/storage/background/Pg_banner_shape3.png') }}"
                  alt="Yellow color dots">
            </div>
            <div class="yellow_dot_left">
               <img src="{{ asset('public/storage/background/Pg_banner_shape3.png') }}"
                  alt="Yellow color dots">
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
                  <h4><span>Success story</span> <span><a href="#">See more</a></span></h4>
               </div>
               <div class="pg_succsess_img_slider slick-initialized slick-slider slick-dotted"><i
                     class="fa fa-angle-left angle-left slick-arrow" style="display: block;"></i>
                  <div class="slick-list draggable">
                     <div class="slick-track"
                        style="opacity: 1; width: 11825px; transform: translate3d(-473px, 0px, 0px);">
                        <div class="pg_slide_item position-relative slick-slide slick-cloned" data-slick-index="-1"
                           aria-hidden="true" tabindex="-1" style="width: 473px;">
                           <a class="venobox vbox-item" data-autoplay="true" data-vbtype="video"
                              href="#" tabindex="-1" savefrom_lm_index="2" savefrom_lm="1">
                              <img class="img-fluid w-100"
                                 src="#" alt="Success Story">
                              <div class="overly_icon">
                                 <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="play"
                                    class="svg-inline--fa fa-play " role="img" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 384 512">
                                    <path fill="currentColor"
                                       d="M361 215C375.3 223.8 384 239.3 384 256C384 272.7 375.3 288.2 361 296.1L73.03 472.1C58.21 482 39.66 482.4 24.52 473.9C9.377 465.4 0 449.4 0 432V80C0 62.64 9.377 46.63 24.52 38.13C39.66 29.64 58.21 29.99 73.03 39.04L361 215z">
                                    </path>
                                 </svg>
                              </div>
                           </a>
                        </div>
                     </div>
                  </div>
                  <i class="fa fa-angle-right angle-right slick-arrow" style="display: block;"></i>
                  <ul class="slick-dots" style="display: flex;" role="tablist">
                     <li class="slick-active" role="presentation"><button type="button" role="tab"
                           id="slick-slide-control30" aria-controls="slick-slide30" aria-label="1 of 12" tabindex="0"
                           aria-selected="true">1</button></li>
                  </ul>
               </div>
            </div>
            <div class="pg_wait_wrap pg_wait_sticky">
               <div class="pg_wait">
                  <h3>ভর্তি চলছে!!</h3>
                  <p>
                   অফলাইন (সরাসরি ইনস্টিটিউট) বা অনলাইন (লাইভ ক্লাস) - আপনি আপনার সুবিধামত এবং এখন যে কোনও ব্যাচে ভর্তি হতে পারেন।
                  </p>
                  <div class="join_offline_main">
                     <div class="join_offline">
                        <h4>Course Fee (Offline)</h4>
                        <p>৳ {{$courses->coursefee}} BDT
                        </p><a href="{{ route('frontend.course.admission', $courses->id) }}">ভর্তি</a>
                     </div>
                     <div class="join_offline">
                        <h4>Course Fee (Online)</h4>
                        <p>
                            @php
                               $discount =  $courses->coursefee * 40/100;
                            @endphp
                            ৳ {{$courses->coursefee - $discount }} BDT
                        </p>
                        <a href="{{ route('frontend.course.admission', $courses->id) }}" >ভর্তি</a>
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
                  <h4><span>Success story</span> <span><a href="#">See more</a></span></h4>
               </div>
               <div class="pg_succsess_img_slider slick-initialized slick-slider slick-dotted"><i
                     class="fa fa-angle-left angle-left slick-arrow" style="display: block;"></i>
                  <div class="slick-list draggable">
                     <div class="slick-track"
                        style="opacity: 1; width: 11825px; transform: translate3d(-473px, 0px, 0px);">
                        <div class="pg_slide_item position-relative slick-slide slick-cloned" data-slick-index="-1"
                           aria-hidden="true" tabindex="-1" style="width: 473px;">
                           <a class="venobox vbox-item" data-autoplay="true" data-vbtype="video"
                              href="#" tabindex="-1" savefrom_lm_index="2" savefrom_lm="1">
                              <img class="img-fluid w-100"
                                 src="#" alt="Success Story">
                              <div class="overly_icon">
                                 <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="play"
                                    class="svg-inline--fa fa-play " role="img" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 384 512">
                                    <path fill="currentColor"
                                       d="M361 215C375.3 223.8 384 239.3 384 256C384 272.7 375.3 288.2 361 296.1L73.03 472.1C58.21 482 39.66 482.4 24.52 473.9C9.377 465.4 0 449.4 0 432V80C0 62.64 9.377 46.63 24.52 38.13C39.66 29.64 58.21 29.99 73.03 39.04L361 215z">
                                    </path>
                                 </svg>
                              </div>
                           </a>
                        </div>
                     </div>
                  </div>
                  <i class="fa fa-angle-right angle-right slick-arrow" style="display: block;"></i>
                  <ul class="slick-dots" style="display: flex;" role="tablist">
                     <li class="slick-active" role="presentation"><button type="button" role="tab"
                           id="slick-slide-control30" aria-controls="slick-slide30" aria-label="1 of 12" tabindex="0"
                           aria-selected="true">1</button></li>
                  </ul>
               </div>
            </div>
            <div class="pg_wait_wrap pg_wait_sticky">
               <div class="pg_wait">
                  <h3>Admission is going on!</h3>
                  <p>
                    অফলাইন (সরাসরি ইনস্টিটিউট) বা অনলাইন (লাইভ ক্লাস) - আপনি আপনার সুবিধামত এবং এখন যে কোনও ব্যাচে ভর্তি হতে পারেন।
                  </p>
                  <div class="join_offline_main">
                     <div class="join_offline">
                        <h4>Course Fee (Offline)</h4>
                        <p>৳ {{$courses->coursefee}} BDT
                        </p><a href="{{ route('frontend.course.admission', $courses->id) }}">ভর্তি</a>
                     </div>
                     <div class="join_offline">
                        <h4>Course Fee (Online)</h4>
                        <p>
                            @php
                               $discount =  $courses->coursefee * 40/100;
                            @endphp
                            ৳ {{$courses->coursefee - $discount }} BDT
                        </p>
                        <a href="{{ route('frontend.course.admission', $courses->id) }}" >ভর্তি</a>
                     </div>
                  </div>
                  <div class="wait_btn text-center"><a href="#">ফ্রি সেমিনার</a></div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- /courses -->
@endsection