@extends('frontend.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')


   <!-- about -->
<section class="section">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <img class="img-fluid mb-4" src="{{ asset('frontend/assets/images/about/about-us.png' ) }}" alt="about image">
          <h2 class="section-title">ABOUT OUR JOURNY</h2>
          <p>{{ config('settings.short_about') }}</p>
        </div>
      </div>
    </div>
  </section>
  <!-- /about -->
  <!-- funfacts -->
<section class="section-sm bg-primary">
    <div class="container">
      <div class="row">
        <!-- funfacts item -->
        <div class="col-md-3 col-sm-6 mb-4 mb-md-0">
          <div class="text-center">
            <h2 class="count text-white" data-count="10">0</h2>
            <h5 class="text-white">TEACHERS</h5>
          </div>
        </div>
        <!-- funfacts item -->
        <div class="col-md-3 col-sm-6 mb-4 mb-md-0">
          <div class="text-center">
            <h2 class="count text-white" data-count="12">0</h2>
            <h5 class="text-white">COURSES</h5>
          </div>
        </div>
        <!-- funfacts item -->
        <div class="col-md-3 col-sm-6 mb-4 mb-md-0">
          <div class="text-center">
            <h2 class="count text-white" data-count="600">+</h2>
            <h5 class="text-white">STUDENTS</h5>
          </div>
        </div>
        <!-- funfacts item -->
        <div class="col-md-3 col-sm-6 mb-4 mb-md-0">
          <div class="text-center">
            <h2 class="count text-white" data-count="2000">+</h2>
            <h5 class="text-white">SATISFIED CLIENT</h5>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /funfacts -->
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
            <h2 class="section-title">Success Stories</h2>
            <p class="text-justify">{{$story->msg}}</p>
            </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /success story -->
  
  <!-- teachers -->
  <section class="section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12">
          <h2 class="section-title">Our Team</h2>
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

  @endsection