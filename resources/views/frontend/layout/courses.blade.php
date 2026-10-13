@extends('frontend.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
  
  <!-- courses -->
  <section class="section mt-5">
    <div class="container mt-5">
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
                <li class="list-inline-item"><a class="text-color" href="#">All Courses</a></li>
              </ul>
              <a href="{{ route('frontend.course.details', $item->id) }}">
                <h4 class="card-title">{{$item->name}}</h4>
              </a>
              {{-- <p class="card-text mb-2">
                {!!$item->description!!}
              </p> --}}
              <ul class="d-flex justify-content-between pl-0 py-2">
                <li class="list-item"><i class="ti-time"></i> <span class="font-weight-bolder">{{$item->courseduration}} Months</span></li>
                <li class="list-item"><i class="ti-pie-chart"></i> <span class="font-weight-bolder">{{$item->totalmoduls}} Modules</span></li>
              </ul>
              <a href="{{ route('frontend.course.admission', $item->id) }}" class="btn btn-primary btn-sm mt-2">Enroll now</a>
              <a href="{{ route('frontend.course.details', $item->id) }}" class="btn btn-outline-primary btn-sm mt-2">View Course</a>
            </div>
          </div>
    </div>
    @endforeach
    </div>
  </section>
  <!-- /courses -->
@endsection