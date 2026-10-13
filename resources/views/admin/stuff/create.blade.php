@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-user"></i> {{ $pageTitle }}</h1>
    </div>
    @include('admin.partials.flash')
    <style type="text/css">
        #results { padding:10px; border:1px solid; background:#ccc; }
    </style>
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <form action="{{ route('admin.stuff.store') }}" method="POST" role="form" enctype="multipart/form-data">
                <div class="tile-body">
                @csrf
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label class="control-label" for="stuffid">Stuff ID <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('stuffid') is-invalid @enderror" type="text" name="stuffid" placeholder="ICBDEP-01" id="stuffid" value="{{ old('stuffid') }}"/>
                            @error('stuffid') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9">
                        <div class="form-group">
                            <label class="control-label" for="name">Stuff Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" placeholder="Mr." value="{{ old('name') }}"/>
                            @error('name') {{ $message }} @enderror
                        </div>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="fname">Father's Name </label>
                                <input class="form-control @error('fname') is-invalid @enderror" type="text" name="fname" id="fname" placeholder="Mr." value="{{ old('fname') }}"/>
                                @error('fname') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="mname">Mother's Name </label>
                                <input class="form-control @error('mname') is-invalid @enderror" type="text" name="mname" id="mname" placeholder="Mrs." value="{{ old('mname') }}"/>
                                @error('mname') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="gender">Gender <span class="m-l-5 text-danger"> *</span></label>
                                <select  class="form-control @error('gender') is-invalid @enderror"name="gender" id="gender">
                                <option value="">--Select--</option>
                                    <option value="1" @if(old('gender') == 1) {{"selected"}} @endif>Male</option>
                                    <option value="2" @if(old('gender') == 2) {{"selected"}} @endif>Female</option>
                                    <option value="3" @if(old('gender') == 3) {{"selected"}} @endif>Others</option>
                                </select>
                                @error('gender') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                       
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="dob">Stuff Date of Birth </label>
                                <input class="form-control @error('dob') is-invalid @enderror" type="date" name="dob" id="dob" value="{{ old('dob') }}"/>
                                @error('dob') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="bloodgroup">Blood Group </label>
                                <select  class="form-control @error('bloodgroup') is-invalid @enderror"name="bloodgroup" id="bloodgroup">
                                <option value="">--Select--</option>
                                    <option value="1" @if(old('bloodgroup') == 1) {{"selected"}} @endif>A(+ve)</option>
                                    <option value="2" @if(old('bloodgroup') == 2) {{"selected"}} @endif>O(+ve)</option>
                                    <option value="3" @if(old('bloodgroup') == 3) {{"selected"}} @endif>B(+ve)</option>
                                    <option value="4" @if(old('bloodgroup') == 4) {{"selected"}} @endif>AB(+ve)</option>
                                    <option value="5" @if(old('bloodgroup') == 5) {{"selected"}} @endif>A(-ve)</option>
                                    <option value="6" @if(old('bloodgroup') == 6) {{"selected"}} @endif>O(-ve)</option>
                                    <option value="7" @if(old('bloodgroup') == 7) {{"selected"}} @endif>B(-ve)</option>
                                    <option value="8" @if(old('bloodgroup') == 8) {{"selected"}} @endif>AB(-ve)</option>
                                </select>
                                @error('bloodgroup') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="religion">Relagion <span class="m-l-5 text-danger"> *</span></label>
                                <select  class="form-control @error('religion') is-invalid @enderror"name="religion" id="religion">
                                    <option value="">--Select--</option>
                                    <option value="1" @if(old('religion') == 1) {{"selected"}} @endif>Islam</option>
                                    <option value="2" @if(old('religion') == 2) {{"selected"}} @endif>Hindhu</option>
                                    <option value="3" @if(old('religion') == 3) {{"selected"}} @endif>Bhudist</option>
                                    <option value="4" @if(old('religion') == 4) {{"selected"}} @endif>Christian</option>
                                </select>
                                @error('religion') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="maritalStatus">Marital Status <span class="m-l-5 text-danger"> *</span></label>
                                <select  class="form-control @error('maritalStatus') is-invalid @enderror"name="maritalStatus" id="maritalStatus">
                                    <option value="">--Select--</option>
                                    <option value="1" @if(old('maritalStatus') == 1) {{"selected"}} @endif>Unmerrid</option>
                                    <option value="2" @if(old('maritalStatus') == 2) {{"selected"}} @endif>Merrid</option>
                                    <option value="3" @if(old('maritalStatus') == 3) {{"selected"}} @endif>Divorced</option>
                                </select>
                                @error('maritalStatus') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="phone">Stuff Phone Number <span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" id="phone" placeholder="+880" value="{{ old('phone') }}"/>
                                @error('phone') {{ $message }} @enderror
                            </div>
                        </div>
                         <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="email">Stuff Email Address  <span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email" placeholder="example@doman.com" value="{{ old('email') }}"/>
                                @error('email') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="nid">NID/BCN </label>
                                <input class="form-control @error('nid') is-invalid @enderror" type="text" name="nid" placeholder="NID/BCN" id="nid" value="{{ old('nid') }}"/>
                                @error('nid') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="education">Education Qualification<span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control @error('education') is-invalid @enderror" type="text" name="education" id="education" placeholder="BSc" value="{{ old('education') }}"/>
                                @error('education') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="subject">Stuff Subjects<span class="m-l-5 text-danger"> *</span> </label>
                                <input class="form-control @error('subject') is-invalid @enderror" type="text" name="subject" id="subject" placeholder="Web Developer" value="{{ old('subject') }}"/>
                                @error('subject') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="designation">Stuff Designation<span class="m-l-5 text-danger"> *</span> </label>
                                <input class="form-control @error('designation') is-invalid @enderror" type="text" name="designation" id="designation" placeholder="Director" value="{{ old('designation') }}"/>
                                @error('designation') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="department">Stuff Department </label>
                                <input class="form-control @error('department') is-invalid @enderror" type="text" name="department" id="department" placeholder="IT" value="{{ old('department') }}"/>
                                @error('department') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="salary">Basic Salary <span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control @error('salary') is-invalid @enderror" type="text" name="salary" id="salary" placeholder="+880" value="{{ old('salary') }}"/>
                                @error('salary') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="contactType">Contract Type <span class="m-l-5 text-danger"> *</span></label>
                                <select  class="form-control @error('contactType') is-invalid @enderror"name="contactType" id="contactType">
                                    <option value="">--Select--</option>
                                    <option value="1" @if(old('contactType') == 1) {{"selected"}} @endif>Permanent</option>
                                    <option value="2" @if(old('contactType') == 2) {{"selected"}} @endif>Intern</option>
                                    <option value="3" @if(old('contactType') == 3) {{"selected"}} @endif>Contractual</option>
                                </select>
                                @error('contactType') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="shift">Shift </label>
                                <input class="form-control @error('shift') is-invalid @enderror" type="text" name="shift" id="shift" placeholder="Morning" value="{{ old('shift') }}"/>
                                @error('shift') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                                <label class="control-label" for="exprience">Work Exprience <span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control @error('exprience') is-invalid @enderror" type="text" name="exprience" id="exprience" placeholder="5 Years" value="{{ old('exprience') }}"/>
                                @error('exprience') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                                <label class="control-label" for="joiningdate">Joining Date <span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control @error('joiningdate') is-invalid @enderror" type="date" name="joiningdate" id="joiningdate" value="{{ old('joiningdate') }}"/>
                                @error('joiningdate') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="link1">Facebook Link </label>
                                <input class="form-control @error('link1') is-invalid @enderror" type="url" name="link1" id="link1" placeholder="https://" value="{{ old('link1') }}"/>
                                @error('link1') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                                <label class="control-label" for="link2">Linkedin Link </label>
                                <input class="form-control @error('link2') is-invalid @enderror" type="url" name="link2" id="link2" placeholder="https://" value="{{ old('link2') }}"/>
                                @error('link2') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                                <label class="control-label" for="link3">Github Link </label>
                                <input class="form-control @error('link3') is-invalid @enderror" type="url" name="link3" id="link3"  value="{{ old('link3') }}"/>
                                @error('link3') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                    <label class="control-label" for="link4">Behance Link </label>
                                    <input class="form-control @error('link4') is-invalid @enderror" type="url" name="link4" id="link4" value="{{ old('link4') }}"/>
                                    @error('link4') {{ $message }} @enderror
                                </div>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="address">Address<span class="m-l-5 text-danger"> *</span></label>
                                <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" cols="30" rows="3">{{old('address')}}</textarea>
                                @error('address') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="IsActive">Status<span class="m-l-5 text-danger"> *</span></label>
                                <select  class="form-control @error('IsActive') is-invalid @enderror"name="IsActive" id="IsActive">
                                    <option value="">--Select--</option>
                                    <option value="1" @if(old('IsActive') == 1) {{"selected"}} @endif>Active</option>
                                    <option value="2" @if(old('IsActive') == 2) {{"selected"}} @endif>Postponded</option>
                                    <option value="3" @if(old('IsActive') == 3) {{"selected"}} @endif>Restricted</option>
                                </select>
                                @error('IsActive') {{ $message }} @enderror
                            </div>
                    </div>
                    </div>
                    <div class="row">
                    
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group" id="image-area">
                                <label class="control-label" for="image-tag">Stuff Image <span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control @error('image') is-invalid @enderror image-tag" type="file" name="image" id="image-tag" value="{{ old('image') }}"/>
                                @error('image') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="col-md-6 ">
<button type="button" id="take-photo" class="btn btn-warning mt-4">Take your Webcam <i class="fa fa-camera" aria-hidden="true"></i></button></div>
                        
                    </div>
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
                    <button class="btn btn-primary" type="submit" id="submitform"><i class="fa fa-fw fa-lg fa-check-circle"></i>Add Stuff</button>
                        &nbsp;&nbsp;&nbsp;
                    <a class="btn btn-secondary" href="{{ route('admin.stuff.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
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