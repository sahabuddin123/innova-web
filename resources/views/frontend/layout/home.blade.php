@extends('frontend.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<!-- hero slider -->   
<section class="hero-section bg-cover" data-background="{{ asset('frontend/assets/images/banner/innova-web5.jpg') }}">
    <div class="container">
      <div class="hero-slider">
        @foreach ($slider as $item)
        <!-- slider item -->
        <div class="hero-slider-item">
          <div class="row">
            <div class="col-md-8">
              <h1 class="text-black pt-5" data-animation-out="@if($item->dao != null){{$item->dao}}@else fadeOutRight @endif" data-delay-out="@if($item->ddo != null){{$item->ddo}}@else 5 @endif" data-duration-in="@if($item->ddi != null){{$item->ddi}}@else .3 @endif" data-animation-in="@if($item->dai != null){{$item->dai}}@else fadeInLeft @endif" data-delay-in=".1">
                {!!$item->title!!}
              </h1>
              <p class="text-muted mb-4" data-animation-out="@if($item->dao != null){{$item->dao}}@else fadeOutRight @endif" data-delay-out="@if($item->ddo != null){{$item->ddo}}@else 5 @endif" data-duration-in="@if($item->ddi != null){{$item->ddi}}@else .3 @endif" data-animation-in="@if($item->dai != null){{$item->dai}}@else fadeInLeft @endif" data-delay-in=".4">
                {!!$item->details!!}
              </p>
              <a href="{{$item->btnLink}}" target="_blank" class="btn btn-primary" data-animation-out="@if($item->dao != null){{$item->dao}}@else fadeOutRight @endif" data-delay-out="@if($item->ddo != null){{$item->ddo}}@else 5 @endif" data-duration-in="@if($item->ddi != null){{$item->ddi}}@else .3 @endif" data-animation-in="@if($item->dai != null){{$item->dai}}@else fadeInLeft @endif" data-delay-in=".7">{{$item->btnTxt}}</a>
            </div>
          </div>
        </div>
        @endforeach
        <!-- slider item -->
      </div>
    </div>
  </section>
  <!-- /hero slider -->
  
  <!-- about us -->
  <section class="section">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 order-2 order-md-1">
          <h2 class="section-title">আমাদের সম্পর্কে</h2>
          <p class="text-justify">{{ config('settings.short_about') }}</p>
          {{-- <a href="#" class="btn btn-outline-primary">Read more</a> --}}
        </div>
        <div class="col-md-6 order-1 order-md-2 mb-4 mb-md-0">
          <img class="img-fluid w-100" src="{{ asset('frontend/assets/images/about/about-us.png' ) }}" alt="about image">
        </div>
      </div>
    </div>
  </section>
  <!-- /about us -->
  
  <!-- courses -->
  <section class="section-sm">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="d-flex align-items-center section-title justify-content-between">
            <h2 class="mb-0 text-nowrap mr-3">জনপ্রিয় কোর্সসমূহ</h2>
            <div class="border-top w-100 border-primary d-none d-sm-block"></div>
            <div>
              <a href="{{ route('frontend.courses') }}" class="btn btn-sm btn-outline-primary ml-sm-3 d-none d-sm-block">ব্রাউস কোর্স</a>
            </div>
          </div>
        </div>
      </div>
      <!-- course list -->
  <div class="row justify-content-center">
    @foreach ($courses as $item)
       <!-- course item -->
      <div class="col-lg-4 col-sm-6 mb-5">
        <div class="card p-0 border-primary rounded-0 hover-shadow">
          <img class="card-img-top rounded-0" src="{{ asset('public/storage/'.$item->image) }}" alt="course thumb">
          <div class="card-body">
            <ul class="list-inline mb-2">
              {{-- <li class="list-inline-item"><i class="ti-calendar mr-1 text-color"></i>02-14-2018</li> --}}
              <li class="list-inline-item"><a class="text-color" href="{{ route('frontend.courses') }}">সকল কোর্স</a></li>
            </ul>
            <a href="{{ route('frontend.course.details', $item->id) }}">
              <h4 class="card-title">{{$item->name}}</h4>
            </a>
            {{-- <p class="card-text mb-2">
              {!!$item->description!!}
            </p> --}}
            <ul class="d-flex justify-content-between pl-0 py-2">
              <li class="list-item"><i class="ti-time"></i> <span class="font-weight-bolder">{{$item->courseduration}} মাস</span></li>
              <li class="list-item"><i class="ti-pie-chart"></i> <span class="font-weight-bolder">{{$item->totalmoduls}} মডিউল</span></li>
            </ul>
           
            
            <a href="{{ route('frontend.course.admission', $item->id) }}" class="btn btn-primary btn-sm mt-2">ভর্তি</a>
            <a href="{{ route('frontend.course.details', $item->id) }}" class="btn btn-primary btn-sm mt-2">কোর্স বিস্তারিত</a>
          </div>
        </div>
      </div> 
    @endforeach
    

  </div>
  <!-- /course list -->
      <!-- mobile see all button -->
      <div class="row">
        <div class="col-12 text-center">
          <a href="courses.html" class="btn btn-sm btn-outline-primary d-sm-none d-inline-block">sell all</a>
        </div>
      </div>
    </div>
  </section>
  <!-- /courses -->
  
  <!-- cta -->
  <section class="section bg-primary">
    <div class="container">
      <div class="row">
        <div class="col-12 text-center">
          <h6 class="text-white font-secondary mb-0">অ্যাডভান্স ওয়ার্কশপে যোগ দিতে ক্লিক করুন</h6>
          <h2 class="section-title text-white">উন্নত প্রযুক্তিতে প্রশিক্ষণ</h2>
          <a href="#" class="btn btn-light">এখনি যোগদিন</a>
        </div>
      </div>
    </div>
  </section>
  <!-- /cta -->
  
  <!-- success story -->
  <section class="section bg-cover" data-background="{{ asset('frontend/assets/images/backgrounds/review-bg.jpg') }}">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-sm-4 position-relative success-video">
          <a class="play-btn venobox" href="{{$story->video}}" data-vbtype="video">
            <i class="ti-control-play"></i>
          </a>
        </div>
        <div class="col-lg-6 col-sm-8">
          <div class="bg-white p-5">
            <h2 class="section-title">সফলতার গল্প</h2>
            <p class="text-justify">{{$story->msg}}</p>
            </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /success story -->
  
  <!-- events -->
  {{-- <section class="section bg-gray">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="d-flex align-items-center section-title justify-content-between">
            <h2 class="mb-0 text-nowrap mr-3">Upcoming Events</h2>
            <div class="border-top w-100 border-primary d-none d-sm-block"></div>
            <div>
              <a href="events.html" class="btn btn-sm btn-outline-primary ml-sm-3 d-none d-sm-block">see all</a>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
    <!-- event -->
    <div class="col-lg-4 col-sm-6 mb-5 mb-lg-0">
      <div class="card border-0 rounded-0 hover-shadow">
        <div class="card-img position-relative">
          <img class="card-img-top rounded-0" src="{{ asset('frontend/assets/images/events/event-1.jpg') }}" alt="event thumb">
          <div class="card-date"><span>18</span><br>December</div>
        </div>
        <div class="card-body">
          <!-- location -->
          <p><i class="ti-location-pin text-primary mr-2"></i>Dhanmondi Lake, Dhaka</p>
          <a href="#"><h4 class="card-title">Lorem ipsum dolor amet, consectetur adipisicing.</h4></a>
        </div>
      </div>
    </div>
    <!-- event -->
    <div class="col-lg-4 col-sm-6 mb-5 mb-lg-0">
      <div class="card border-0 rounded-0 hover-shadow">
        <div class="card-img position-relative">
          <img class="card-img-top rounded-0" src="{{ asset('frontend/assets/images/events/event-2.jpg') }}" alt="event thumb">
          <div class="card-date"><span>21</span><br>December</div>
        </div>
        <div class="card-body">
          <!-- location -->
          <p><i class="ti-location-pin text-primary mr-2"></i>Dhanmondi Lake, Dhaka</p>
          <a href="#"><h4 class="card-title">Lorem ipsum dolor amet, consectetur adipisicing.</h4></a>
        </div>
      </div>
    </div>
    <!-- event -->
    <div class="col-lg-4 col-sm-6 mb-5 mb-lg-0">
      <div class="card border-0 rounded-0 hover-shadow">
        <div class="card-img position-relative">
          <img class="card-img-top rounded-0" src="{{ asset('frontend/assets/images/events/event-3.jpg') }}" alt="event thumb">
          <div class="card-date"><span>23</span><br>December</div>
        </div>
        <div class="card-body">
          <!-- location -->
          <p><i class="ti-location-pin text-primary mr-2"></i>Dhanmondi Lake, Dhaka</p>
          <a href="#"><h4 class="card-title">Lorem ipsum dolor amet, consectetur adipisicing.</h4></a>
        </div>
      </div>
    </div>
  </div>
      <!-- mobile see all button -->
      <div class="row">
        <div class="col-12 text-center">
          <a href="course.html" class="btn btn-sm btn-outline-primary d-sm-none d-inline-block">sell all</a>
        </div>
      </div>
    </div>
  </section> --}}
  <!-- /events -->
  
  <!-- teachers -->
  <section class="section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12">
          <h2 class="section-title">আমাদের টিম</h2>
        </div>
        @foreach ($teacher as $item)
        <div class="col-lg-4 col-sm-6 mb-5 mb-lg-0">
          <div class="card border-0 rounded-0 hover-shadow">
            <img class="card-img-top rounded-0" src="{{ asset('public/storage/'.$item->image) }}" alt="teacher">
            <div class="card-body">
              <a href="#">
                <h4 class="card-title">{{$item->name}}</h4>
              </a>
              <p>{{$item->subject}}</p>
              <ul class="list-inline">
                <li class="list-inline-item"><a class="text-color" href="{{$item->link1}}" target="_blank"><i class="ti-facebook"></i></a></li>
                <li class="list-inline-item"><a class="text-color" href="{{$item->link4}}" target="_blank"><i class="ti-twitter-alt"></i></a></li>
                <li class="list-inline-item"><a class="text-color" href="{{$item->link3}}" target="_blank"><i class="ti-google"></i></a></li>
                <li class="list-inline-item"><a class="text-color" href="{{$item->link2}}" target="_blank"><i class="ti-linkedin"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
        @endforeach
        <!-- teacher -->
      </div>
    </div>
  </section>
  <!-- /teachers -->
  
  <!-- blog -->
  {{-- <section class="section pt-0">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2 class="section-title">Latest News</h2>
        </div>
      </div>
      <div class="row justify-content-center">
    <!-- blog post -->
    <article class="col-lg-4 col-sm-6 mb-5 mb-lg-0">
      <div class="card rounded-0 border-bottom border-primary border-top-0 border-left-0 border-right-0 hover-shadow">
        <img class="card-img-top rounded-0" src="{{ asset('frontend/assets/images/blog/post-1.jpg')}}" alt="Post thumb">
        <div class="card-body">
          <!-- post meta -->
          <ul class="list-inline mb-3">
            <!-- post date -->
            <li class="list-inline-item mr-3 ml-0">August 28, 2018</li>
            <!-- author -->
            <li class="list-inline-item mr-3 ml-0">By Somrat Sorkar</li>
          </ul>
          <a href="#">
            <h4 class="card-title">Lorem ipsum dolor amet, adipisicing eiusmod tempor.</h4>
          </a>
          <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicin</p>
          <a href="#" class="btn btn-primary btn-sm">read more</a>
        </div>
      </div>
    </article>
    <!-- blog post -->
    <article class="col-lg-4 col-sm-6 mb-5 mb-lg-0">
      <div class="card rounded-0 border-bottom border-primary border-top-0 border-left-0 border-right-0 hover-shadow">
        <img class="card-img-top rounded-0" src="{{ asset('frontend/assets/images/blog/post-2.jpg')}}" alt="Post thumb">
        <div class="card-body">
          <!-- post meta -->
          <ul class="list-inline mb-3">
            <!-- post date -->
            <li class="list-inline-item mr-3 ml-0">August 13, 2018</li>
            <!-- author -->
            <li class="list-inline-item mr-3 ml-0">By Jonathon Drew</li>
          </ul>
          <a href="#">
            <h4 class="card-title">Lorem ipsum dolor amet, adipisicing eiusmod tempor.</h4>
          </a>
          <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicin</p>
          <a href="#" class="btn btn-primary btn-sm">read more</a>
        </div>
      </div>
    </article>
    <!-- blog post -->
    <article class="col-lg-4 col-sm-6 mb-5 mb-lg-0">
      <div class="card rounded-0 border-bottom border-primary border-top-0 border-left-0 border-right-0 hover-shadow">
        <img class="card-img-top rounded-0" src="{{ asset('frontend/assets/images/blog/post-3.jpg')}}" alt="Post thumb">
        <div class="card-body">
          <!-- post meta -->
          <ul class="list-inline mb-3">
            <!-- post date -->
            <li class="list-inline-item mr-3 ml-0">August 24, 2018</li>
            <!-- author -->
            <li class="list-inline-item mr-3 ml-0">By Alex Pitt</li>
          </ul>
          <a href="#">
            <h4 class="card-title">Lorem ipsum dolor amet, adipisicing eiusmod tempor.</h4>
          </a>
          <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicin</p>
          <a href="#" class="btn btn-primary btn-sm">read more</a>
        </div>
      </div>
    </article>
  </div>
    </div>
  </section> --}}
  <!-- /blog -->
  @endsection