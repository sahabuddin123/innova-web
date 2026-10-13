@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-book"></i> {{ $pageTitle }}</h1>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <form action="{{ route('admin.review.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="student_id">Students <span class="m-l-5 text-danger"> *</span></label>
                            <select  class="form-control @error('student_id') is-invalid @enderror" name="student_id" id="student_id">
                            <option value="">--Select--</option>
                            @foreach($student as $item)
                                <option value="{{$item->id}}" @if(old('student_id') == $item->id) {{"selected"}} @endif>{{$item->sname}}</option>
                            @endforeach
                            </select>
                            @error('student_id') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="stdName">Student Name </label>
                            <input class="form-control @error('stdName') is-invalid @enderror" type="text" name="stdName" id="stdName" value="{{ old('stdName') }}"/>
                            @error('stdName') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="course">Course Name </label>
                            <input class="form-control @error('course') is-invalid @enderror" type="text" name="course" id="course" value="{{ old('course') }}"/>
                            @error('course') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="rating">Student Rating </label>
                            <input class="form-control @error('rating') is-invalid @enderror" type="text" name="rating" id="rating" value="{{ old('rating') }}"/>
                            @error('rating') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="msg">Student Review Message <span class="m-l-5 text-danger"> *</span></label>
                            <textarea class="form-control" rows="4" name="msg" id="msg">{{ old('msg') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="video">Review Video Link </label>
                            <input class="form-control @error('video') is-invalid @enderror" type="text" name="video" id="video" value="{{ old('video') }}"/>
                            @error('video') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="IsActive">Status<span class="m-l-5 text-danger"> *</span></label>
                            <select  class="form-control @error('IsActive') is-invalid @enderror"name="IsActive" id="IsActive">
                                <option value="">--Select--</option>
                                <option value="0" @if(old('IsActive') == 0) {{"selected"}} @endif>Deactive</option>
                                <option value="1" @if(old('IsActive') == 1) {{"selected"}} @endif>Active</option>
                            </select>
                            @error('IsActive') {{ $message }} @enderror
                        </div> 
                        <div class="form-group">
                            <label class="control-label">Image</label>
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                            @error('image') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Review</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.review.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')

@endpush