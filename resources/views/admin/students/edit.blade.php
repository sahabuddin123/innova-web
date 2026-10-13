@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-user"></i> {{ $pageTitle }}</h1>
    </div>
    @include('admin.partials.flash')
    <style type="text/css">
        #results { padding:20px; border:1px solid; background:#ccc; }
    </style>
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <form action="{{ route('admin.students.update') }}" method="POST" role="form" enctype="multipart/form-data">
                <div class="tile-body">
                @csrf
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <input type="hidden" name="id" value="{{$targetStudents->id}}">
                            <div class="form-group">
                                <label class="control-label" for="course_id">Courses <span class="m-l-5 text-danger"> *</span></label>
                                <select  class="form-control @error('course_id') is-invalid @enderror" name="course_id" id="course_id">
                                <option value="">--Select--</option>
                                @foreach($courses as $course)
                                    <option value="{{$course->id}}" @if($course->id == $targetStudents->course_id) {{ "selected" }} @endif >{{$course->name}} - {{$course->courseduration}} Months</option>
                                @endforeach
                                </select>
                                @error('course_id') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="branch_id">Branch <span class="m-l-5 text-danger">
                                        *</span></label>
                                <select class="form-control @error('branch_id') is-invalid @enderror" name="branch_id"
                                    id="branch_id">
                                    <option value="">--Select--</option>
                                    <option value="1" @if (old('branch_id', $targetStudents->branch_id) == 1) {{ 'selected' }} @endif>Mian Branch</option>
                                    <option value="2"@if (old('branch_id', $targetStudents->branch_id) == 2) {{ 'selected' }} @endif>Khaserhat Branch</option>
                                </select>
                                @error('branch_id')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="batch_id">Batchs <span class="m-l-5 text-danger"> *</span></label>
                                <select  class="form-control @error('batch_id') is-invalid @enderror"name="batch_id" id="batch_id">
                                <option value="">--Select--</option>
                                @foreach($batchs as $batch)
                                    <option value="{{$batch->id}}" @if($batch->id == $targetStudents->batch_id) {{ "selected" }} @endif >{{$batch->batchnum}}</option>
                                @endforeach
                                </select>
                                @error('batch_id') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="sname">Students Name <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('sname') is-invalid @enderror" type="text" name="sname" id="sname" value="{{ old('sname', $targetStudents->sname) }}"/>
                        @error('sname') {{ $message }} @enderror
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="gender">Gender <span class="m-l-5 text-danger"> *</span></label>
                                <select  class="form-control @error('gender') is-invalid @enderror"name="gender" id="gender">
                                <option value="">--Select--</option>
                                    <option value="1" @if($targetStudents->gender == 1) {{"selected"}} @endif>Male</option>
                                    <option value="2" @if($targetStudents->gender == 2) {{"selected"}} @endif>Female</option>
                                    <option value="3" @if($targetStudents->gender == 3) {{"selected"}} @endif>Others</option>
                                </select>
                                @error('gender') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="dob">Students Date of Birth </label>
                                <input class="form-control @error('dob') is-invalid @enderror" type="date" name="dob" id="dob" value="{{ old('dob', $targetStudents->dob) }}"/>
                                @error('dob') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="bloodgroup">Blood Group </label>
                                <select  class="form-control @error('bloodgroup') is-invalid @enderror"name="bloodgroup" id="bloodgroup">
                                <option value="">--Select--</option>
                                    <option value="1" @if($targetStudents->bloodgroup == 1) {{"selected"}} @endif >A(+ve)</option>
                                    <option value="2" @if($targetStudents->bloodgroup == 2) {{"selected"}} @endif >O(+ve)</option>
                                    <option value="3" @if($targetStudents->bloodgroup == 3) {{"selected"}} @endif >B(+ve)</option>
                                    <option value="4" @if($targetStudents->bloodgroup == 4) {{"selected"}} @endif >AB(+ve)</option>
                                    <option value="5" @if($targetStudents->bloodgroup == 5) {{"selected"}} @endif >A(-ve)</option>
                                    <option value="6" @if($targetStudents->bloodgroup == 6) {{"selected"}} @endif >O(-ve)</option>
                                    <option value="7" @if($targetStudents->bloodgroup == 7) {{"selected"}} @endif >B(-ve)</option>
                                    <option value="8" @if($targetStudents->bloodgroup == 8) {{"selected"}} @endif >AB(-ve)</option>
                                </select>
                                @error('bloodgroup') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="religion">Relagion <span class="m-l-5 text-danger"> *</span></label>
                                <select  class="form-control @error('religion') is-invalid @enderror"name="religion" id="religion">
                                    <option value="">--Select--</option>
                                    <option value="1" @if($targetStudents->religion == 1) {{"selected"}} @endif >Islam</option>
                                    <option value="2" @if($targetStudents->religion == 2) {{"selected"}} @endif >Hindhu</option>
                                    <option value="3" @if($targetStudents->religion == 3) {{"selected"}} @endif >Bhudist</option>
                                    <option value="4" @if($targetStudents->religion == 4) {{"selected"}} @endif >Christian</option>
                                </select>
                                @error('religion') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="height">Students Height </label>
                                <input class="form-control @error('height') is-invalid @enderror" type="text" name="height" placeholder="Inches" id="height" value="{{ old('height', $targetStudents->height) }}"/>
                                @error('height') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="weight">Students Weight </label>
                                <input class="form-control @error('weight') is-invalid @enderror" type="text" name="weight" id="weight" placeholder="KiloGram" value="{{ old('weight', $targetStudents->weight) }}"/>
                                @error('weight') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="phone">Students Phone Number <span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" id="phone" placeholder="+880" value="{{ old('phone', $targetStudents->phone) }}"/>
                                @error('phone') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="nid">Students NID or Birth Certificate Number </label>
                                <input class="form-control @error('nid') is-invalid @enderror" type="text" name="nid" id="nid" placeholder="123456789" value="{{ old('nid', $targetStudents->nid) }}"/>
                                @error('nid') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="last_school">Previous School or Collage </label>
                                <input class="form-control @error('last_school') is-invalid @enderror" type="text" name="last_school" id="last_school" placeholder="School or Collage Name" value="{{ old('last_school', $targetStudents->last_school) }}"/>
                                @error('last_school') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="f_name">Father's Name </label>
                                <input class="form-control @error('f_name') is-invalid @enderror" type="text" name="f_name" id="f_name" placeholder="Mr." value="{{ old('f_name', $targetStudents->f_name) }}"/>
                                @error('f_name') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="f_phone">Father's Phone Number </label>
                                <input class="form-control @error('f_phone') is-invalid @enderror" type="text" name="f_phone" id="f_phone" placeholder="+880" value="{{ old('f_phone', $targetStudents->f_phone) }}"/>
                                @error('f_phone') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="m_name">Mother's Name </label>
                                <input class="form-control @error('m_name') is-invalid @enderror" type="text" name="m_name" id="m_name" placeholder="Mrs." value="{{ old('m_name', $targetStudents->m_name) }}"/>
                                @error('m_name') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="m_phone">Mothers's Phone Number </label>
                                <input class="form-control @error('m_phone') is-invalid @enderror" type="text" name="m_phone" id="m_phone" placeholder="+880" value="{{ old('m_phone', $targetStudents->m_phone) }}"/>
                                @error('m_phone') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="g_name">Guardian's Name <span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control @error('g_name') is-invalid @enderror" type="text" name="g_name" id="g_name" placeholder="Mr./Mrs." value="{{ old('g_name', $targetStudents->g_name) }}"/>
                                @error('g_name') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="g_phone">Guardian's Phone Number <span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control @error('g_phone') is-invalid @enderror" type="text" name="g_phone" id="g_phone" placeholder="+880" value="{{ old('g_phone', $targetStudents->g_phone) }}"/>
                                @error('g_phone') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="rel_g">Relation with Guardian <span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control @error('rel_g') is-invalid @enderror" type="text" name="rel_g" id="rel_g" placeholder="Relation" value="{{ old('rel_g', $targetStudents->rel_g) }}"/>
                                @error('rel_g') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="discount">Discount </label>
                                <input class="form-control @error('discount') is-invalid @enderror" type="text" name="discount" id="discount" placeholder="Percent" value="{{ old('discount', $targetStudents->discount) }}"/>
                                @error('discount') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                                <label class="control-label" for="course_fee">Course Fee <span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control @error('course_fee') is-invalid @enderror" disabled type="text" name="course_fee" id="course_fee" placeholder="Fees" value="{{ old('course_fee', $targetStudents->course_fee) }}"/>
                                @error('course_fee') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                                <label class="control-label" for="ref">Referance <span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control @error('ref') is-invalid @enderror" type="text" name="ref" id="ref" placeholder="Referance" value="{{ old('ref', $targetStudents->ref) }}"/>
                                @error('ref') {{ $message }} @enderror
                            </div>
                        </div>
                        
                        
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="admission_date">Admission Date <span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control @error('admission_date') is-invalid @enderror" type="date" name="admission_date" id="admission_date" placeholder="Relation" value="{{ old('admission_date', $targetStudents->admission_date) }}"/>
                                @error('admission_date') {{ $message }} @enderror
                            </div>
                        </div>
                       
                    </div>

                    <div class="row">
                    <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="IsActive">Student Status <span class="m-l-5 text-danger"> *</span></label>
                                <select  class="form-control @error('IsActive') is-invalid @enderror" name="IsActive" id="IsActive">
                                    <option value="">--Select--</option>
                                    <option value="1" @if(old('IsActive', $targetStudents->IsActive) == 1) {{"selected"}} @endif >Regular</option>
                                    <option value="2" @if(old('IsActive', $targetStudents->IsActive) == 2) {{"selected"}} @endif >Iregular</option>
                                    <option value="3" @if(old('IsActive', $targetStudents->IsActive) == 3) {{"selected"}} @endif >Complete</option>
                                    <option value="4" @if(old('IsActive', $targetStudents->IsActive) == 4) {{"selected"}} @endif >Restricted</option>
                                    <option value="5" @if(old('IsActive', $targetStudents->IsActive) == 5) {{"selected"}} @endif >Postponded</option>
                                </select>
                                @error('IsActive') {{ $message }} @enderror
                            </div>
                    </div>
                        <div class="col-sm-12 col-md-5">
                            <div class="form-group" id="image-area">
                                <label class="control-label" for="image-tag">Student Image <span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control @error('image') is-invalid @enderror image-tag" type="file" name="image" id="image-tag" value="{{ old('image') }}"/>
                                @error('image') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-md-3 ">
<button type="button" id="take-photo" class="btn btn-warning mt-4">Take your Webcam <i class="fa fa-camera" aria-hidden="true"></i></button></div>
                        
                    </div>
                    @if($targetStudents->image!=null)
                    <img src="{{ asset('public/storage/'.$targetStudents->image)}}" alt="!" height="182.4">
                    @endif
                    <input type="hidden" name="oldimage" value="{{$targetStudents->image}}">
                    <div class="row" id="photo-area">
                        <div class="col-md-6">
                            <div id="my_camera"></div>
                            <br/>
                            <input type="button" class="btn btn-success" value="Take Picture" onClick="take_snapshot()">
                            <input type="hidden" name="image2" id="image_tag_student">
                            <!-- <div id="apndimg"></div> -->
                        </div>
                        <div class="col-md-6">
                            <div id="results">Your captured image will appear here...</div>
                        </div>
                    </div>
                    
                </div>
                <div class="tile-footer">
                    <button class="btn btn-primary" type="submit" id="submitform"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Students Info</button>
                        &nbsp;&nbsp;&nbsp;
                    <a class="btn btn-secondary" href="{{ route('admin.students.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts') 
<script>
    $(document).ready(function(){
        $('select[name="course_id"]').on('change',function(){
            var course_id = $(this).val();
            if(course_id){
                    $.ajax({
                        url: '/admin/students/getCoursesInfo/'+course_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data){
                            $('#course_fee').empty();
                            $.each(data,function(key,value){
                                $('#course_fee').val(value);
                            });
                        }
                    });
            }else{
                $('#course_fee').empty();
            }
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<script language="JavaScript">
$('#image-area').show();
$('#photo-area').hide();
$('#take-photo').on('click', function(){
    $('#image-area').hide();
$('#photo-area').show();
Webcam.set({
				// live preview size
				width: 640,
				height: 480,
				
				// device capture size
				dest_width: 640,
				dest_height: 480,
				
				// final cropped size
				crop_width: 300,
				crop_height: 300,
				
				// format and quality
				image_format: 'jpeg',
				jpeg_quality: 100,
				
				// flip horizontal (mirror mode)
				flip_horiz: true
			});
    Webcam.attach( '#my_camera' );
});
    // preload shutter audio clip
		var shutter = new Audio();
		shutter.autoplay = false;
		shutter.src = navigator.userAgent.match(/Firefox/) ? 'shutter.ogg' : "{{asset('public/storage/students/shutter.mp3')}}";
    
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            // play sound effect
			try { shutter.currentTime = 0; } catch(e) {;} // fails in IE
			shutter.play();
            $("#image_tag_student").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        } );
    }
    $('#submitform').on('click', function(){
        $('#course_fee').removeAttr('disabled');
    });
</script>
@endpush