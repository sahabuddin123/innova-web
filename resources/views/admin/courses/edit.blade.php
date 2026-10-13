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
                <form action="{{ route('admin.courses.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <input type="hidden" name="id" value="{{$targetCourses->id}}">
                        <div class="form-group">
                            <label class="control-label" for="shortTitle">Short Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('shortTitle') is-invalid @enderror" type="text" name="shortTitle" id="shortTitle" value="{{ old('shortTitle', $targetCourses->shortTitle) }}"/>
                            @error('shortTitle') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name', $targetCourses->name) }}"/>
                            @error('name') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="coursefee">Course Fee <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('coursefee') is-invalid @enderror" type="number" name="coursefee" id="coursefee" value="{{ old('coursefee', $targetCourses->coursefee) }}"/>
                            @error('coursefee') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="courseduration">Course Durations <span class="m-l-5 text-danger"> *</span></label>
                            <select name="courseduration" id="courseduration" class="form-control @error('courseduration') is-invalid @enderror">
                                <option value="">-- Select Course Durations --</option>
                                <option value="1" @if($targetCourses->courseduration == "1") {{ "selected" }}  @endif >1 Month</option>
                                <option value="2" @if($targetCourses->courseduration == "2") {{ "selected" }}  @endif>2 Months</option>
                                <option value="3" @if($targetCourses->courseduration == "3") {{ "selected" }}  @endif>3 Months</option>
                                <option value="4" @if($targetCourses->courseduration == "4") {{ "selected" }}  @endif>4 Months</option>
                                <option value="6" @if($targetCourses->courseduration == "6") {{ "selected" }}  @endif>6 Months</option>
                                <option value="8" @if($targetCourses->courseduration == "8") {{ "selected" }}  @endif>8 Months</option>
                                <option value="12" @if($targetCourses->courseduration == "12") {{ "selected" }}  @endif>12 Months</option>
                            </select>
                            @error('courseduration') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="lacture">Total Lacture <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('lacture') is-invalid @enderror" type="text" name="lacture" id="lacture" value="{{ old('lacture', $targetCourses->lacture) }}"/>
                            @error('lacture') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="totalmoduls">Total Course Moduls <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('totalmoduls') is-invalid @enderror" type="text" name="totalmoduls" id="totalmoduls" value="{{ old('totalmoduls', $targetCourses->totalmoduls) }}"/>
                            @error('totalmoduls') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="totalproject">Total Number of Projects<span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('totalproject') is-invalid @enderror" type="text" name="totalproject" id="totalproject" value="{{ old('totalproject', $targetCourses->totalproject) }}"/>
                            @error('totalproject') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="description">Description</label>
                            <textarea class="form-control" rows="4" name="description" id="description">{!! old('description', $targetCourses->description) !!}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="overview">Course Overview</label>
                            <textarea class="form-control" rows="4" name="overview" id="overview">{!! old('overview', $targetCourses->overview) !!}</textarea>
                            @error('overview') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="curriculum">Course Curriculum</label>
                            <textarea class="form-control" rows="4" name="curriculum" id="curriculum">{!! old('curriculum', $targetCourses->curriculum) !!}</textarea>
                            @error('curriculum') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="software">Course Software</label>
                            <textarea class="form-control" rows="4" name="software" id="software">{!! old('software', $targetCourses->software) !!}</textarea>
                            @error('software') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="trainee">Trainee</label>
                            <textarea class="form-control" rows="4" name="trainee" id="trainee">{!! old('trainee', $targetCourses->trainee) !!}</textarea>
                            @error('trainee') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="jobPlacement">Job Placement</label>
                            <textarea class="form-control" rows="4" name="jobPlacement" id="jobPlacement">{!! old('jobPlacement', $targetCourses->jobPlacement) !!}</textarea>
                            @error('jobPlacement') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="jobPosition">Job Position</label>
                            <textarea class="form-control" rows="4" name="jobPosition" id="jobPosition">{!! old('jobPosition', $targetCourses->jobPosition) !!}</textarea>
                            @error('jobPosition') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="IsActive">Status<span class="m-l-5 text-danger"> *</span></label>
                            <select  class="form-control @error('IsActive') is-invalid @enderror"name="IsActive" id="IsActive">
                                <option value="">--Select--</option>
                                <option value="0" @if(old('IsActive',$targetCourses->IsActive) == 0) {{"selected"}} @endif>Deactive</option>
                                <option value="1" @if(old('IsActive',$targetCourses->IsActive) == 1) {{"selected"}} @endif>Active</option>
                            </select>
                            @error('IsActive') {{ $message }} @enderror
                        </div> 
                        <div class="form-group">
                            <label class="control-label" for="featured">Is Featured<span class="m-l-5 text-danger"> *</span></label>
                            <select  class="form-control @error('featured') is-invalid @enderror"name="featured" id="featured">
                                <option value="">--Select--</option>
                                <option value="0" @if(old('featured',$targetCourses->featured) == 0) {{"selected"}} @endif>No</option>
                                <option value="1" @if(old('featured',$targetCourses->featured) == 1) {{"selected"}} @endif>Yes</option>
                            </select>
                            @error('featured') {{ $message }} @enderror
                        </div> 
                         <div class="form-group">
                            <label class="control-label" for="IsCourse">Is Course Page<span class="m-l-5 text-danger"> *</span></label>
                            <select  class="form-control @error('IsCourse') is-invalid @enderror"name="IsCourse" id="IsCourse">
                                <option value="">--Select--</option>
                                <option value="0" @if(old('IsCourse',$targetCourses->IsCourse) == 0) {{"selected"}} @endif>No</option>
                                <option value="1" @if(old('IsCourse',$targetCourses->IsCourse) == 1) {{"selected"}} @endif>Yes</option>
                            </select>
                            @error('IsCourse') {{ $message }} @enderror
                        </div> 
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    @if ($targetCourses->image != null)
                                        <figure class="mt-2" style="width: 80px; height: auto;">
                                            <img src="{{ asset('public/storage/'.$targetCourses->image) }}" id="categoryImage" class="img-fluid" alt="img">
                                        </figure>
                                    @endif
                                </div>
                                <div class="col-md-10">
                                    <label class="control-label">Category Image</label>
                                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                                    @error('image') {{ $message }} @enderror
                                    
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="video">Course Short Video Link </label>
                            <input class="form-control @error('video') is-invalid @enderror" type="text" id="video" name="video" value="{{ old('video', $targetCourses->video) }}" placeholder="https://www.youtube.com/watch?v=42SPCQ_FcmE"/>
                            @error('video') {{ $message }} @enderror
                        </div>
                    </div>
                    <input type="hidden" name="imageno" value="{{ $targetCourses->image }}">
                    <div class="tile-footer">
                        <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Course</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-danger" href="{{ route('admin.courses.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')

<script src="{{ asset('backend/ckeditor/ckeditor.js') }}"></script>
<script>
  var options = {
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
  };
</script>
<script>
    CKEDITOR.replace( 'description', options );
    CKEDITOR.replace( 'overview', options );
    CKEDITOR.replace( 'curriculum', options );
    CKEDITOR.replace( 'software', options );
    CKEDITOR.replace( 'trainee', options );
    CKEDITOR.replace( 'jobPlacement', options );
    CKEDITOR.replace( 'jobPosition', options );
</script>
@endpush