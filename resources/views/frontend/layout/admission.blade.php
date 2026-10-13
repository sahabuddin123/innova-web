@extends('frontend.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')

 <!-- Admission -->
<section class="section mt-5">
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="{{ asset('public/storage/'.config('settings.site_logo')) }}" alt="logo" height="60">
                        <h3 class="text-center mt-2">Fill the form below with correct information</h3>
                        <p class="card-text">After filling the form our representative will contact you shortly.</p>
                        
                        @include('admin.partials.flash')
                    </div>
                    <div class="card-body">
                        <div class="login">
                            <form action="{{ route('courses.admission.store') }}" class="row" method="POST">
                                @csrf
                                <div class="col-12">
                                    <label for="username">Your Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control mb-3  @error('username') is-invalid @enderror" id="username" name="username" placeholder="Please enter your full name here" value="{{old('username' )}}">
                                    @error('username') {{ $message }} @enderror
                                </div>
                                <div class="col-12">
                                    <label for="phone">Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control mb-3  @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Please enter your phone number here" value="{{old('phone' )}}">
                                    @error('phone') {{ $message }} @enderror
                                </div>
                                <div class="col-12">
                                    <label for="email">Email Address <span class="text-secondary">(if any)</span></label>
                                    <input type="email" class="form-control mb-3  @error('email') is-invalid @enderror" id="email" name="email" placeholder="Please enter your email address here" value="{{old('email' )}}">
                                    @error('email') {{ $message }} @enderror
                                </div>
                                <div class="col-12">
                                    <label for="courseId">Which course do you want to do? <span class="text-danger">*</span></label>
                                    <select name="courseId" id="courseId" class="form-control mb-3 @error('courseId') is-invalid @enderror">
                                        <option value="">-- Select Course --</option>
                                        @foreach ($courses as $course)
                                             <option value="{{$course->id}}"  @if(old('courseId' ) == $course->id) {{"selected"}} @elseif($course->id == $SelectedCourse->id) {{"selected"}} @endif>{{$course->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('courseId') {{ $message }} @enderror
                                </div>
                                <div class="col-12">
                                    <label for="courseType">Your course type <span class="text-danger">*</span></label>
                                    <select name="courseType" id="courseType" class="form-control mb-3 @error('courseType') is-invalid @enderror">
                                        <option value="">-- Select Course --</option>
                                        <option value="0"  @if(old('courseType' ) == 0) {{"selected"}} @endif>Offline</option>
                                        <option value="1"  @if(old('courseType' ) == 1) {{"selected"}} @endif>Online</option>
                                    </select>
                                    @error('courseType') {{ $message }} @enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block">Enroll</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
  <!-- /about -->
  @endsection