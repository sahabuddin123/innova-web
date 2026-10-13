@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-calendar"></i> {{ $pageTitle }}</h1>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <form action="{{ route('admin.admission.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        
                        <input type="hidden" name="id" value="{{$target->id}}">
                        <div class="form-group">
                            <label class="control-label" for="username">Students Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('username') is-invalid @enderror" type="text" name="username" id="username" value="{{ old('username', $target->username) }} " />
                            @error('username') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="phone">Students Phone Number <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" id="phone" value="{{ old('phone', $target->phone) }} " />
                            @error('phone') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="email">Students Email<span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" id="email" value="{{ old('email', $target->email) }} " />
                            @error('email') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label for="courseId">Which course do Student want to do? <span class="text-danger">*</span></label>
                            <select name="courseId" id="courseId" class="form-control mb-3 @error('courseId') is-invalid @enderror">
                                <option value="">-- Select Course --</option>
                                @foreach ($courseName as $course)
                                <option value="{{$course->id}}"  @if(old('courseId', $target->courseId) == $course->id) {{"selected"}} @elseif($course->id == $target->id) {{"selected"}} @endif>{{$course->name}}</option>
                                @endforeach
                            </select>
                            @error('courseId') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label for="courseType">Your course type <span class="text-danger">*</span></label>
                            <select name="courseType" id="courseType" class="form-control mb-3 @error('courseType') is-invalid @enderror">
                                <option value="">-- Select Course --</option>
                                <option value="0"  @if(old('courseType',$target->courseType ) == 0) {{"selected"}} @endif>Offline</option>
                                <option value="1"  @if(old('courseType',$target->courseType ) == 1) {{"selected"}} @endif>Online</option>
                            </select>
                            @error('courseType') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="isActive">Status </label>
                            <select  class="form-control @error('isActive') is-invalid @enderror"name="isActive" id="isActive">
                                <option value="0" @if($target->isActive == 0) {{ "selected" }}  @endif>Waiting for Contact</option>
                                <option value="1" @if($target->isActive == 1) {{ "selected" }}  @endif>Call Not received</option>
                                <option value="2" @if($target->isActive == 2) {{ "selected" }}  @endif>Waiting For Admission</option>
                                <option value="3" @if($target->isActive == 3) {{ "selected" }}  @endif>Admission Complete</option>
                                <option value="4" @if($target->isActive == 4) {{ "selected" }}  @endif>SMS Send</option>
                                <option value="4" @if($target->isActive == 5) {{ "selected" }}  @endif>Not Interested</option>
                                <option value="5" @if($target->isActive == 6) {{ "selected" }}  @endif>Restricted</option>
                            </select>
                            @error('isActive') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Online Admission</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-danger" href="{{ route('admin.admission.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')

@endpush