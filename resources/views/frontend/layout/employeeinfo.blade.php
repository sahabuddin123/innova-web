@extends('frontend.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<br><br>
<br><br>
<br><br>
<br><br>
<br><br>
<br><br>

<link rel="stylesheet" href="{{asset('backend/css/lightbox-popup.css')}}">
    <!-- Custom fonts for this template-->
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<!-- Page Heading -->
@include('admin.partials.flash')
<div class="container">
    <div class="text-center">
<img src="{!! asset('public/verified.png')!!}" alt="!" style="height: 200px">
    </div>

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <div class="popup-gallery">
                        <a href="{!! asset('public/storage/'.$employees->image) !!}" title="{{ $employees->name }}">
                            <img src="{!! asset('public/storage/'.$employees->image) !!}" alt="!"  class="rounded img-fluid img-thumbnail" style="width: 150px;">
                        </a>
                        </div> 
                        <h5 class="my-3">{{ $employees->name }}</h5>
                        <p class="p-0 text-info"><b><mark> Employee ID : {{ $employees->stuffid }} </mark></b></p>
                        <p class="mb-0 text-primary">
                            <a href="{{$employees->link1}}" target="_blank" class="text-light bg-primary px-2 py-1 rounded"><i class="fab fa-facebook-f"></i></a>
                            <a href="{{$employees->link2}}" target="_blank" class="text-light bg-info px-2 py-1 rounded"><i class="fab fa-linkedin-in"></i></a>
                            <a href="{{$employees->link3}}" target="_blank" class="text-light bg-dark px-2 py-1 rounded"><i class="fab fa-github"></i></a>
                            <a href="{{$employees->link4}}" target="_blank" class="text-light bg-dark px-2 py-1 rounded"><i class="fab fa-behance"></i></a>
                        </p>
                    </div>
                </div>
                <div class="card mb-4 mb-lg-0">
                <div class="card-header bg-success"><h5 class="text-white"><i class="fas fa-university"></i> Office Information</h5></div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush rounded-3">
                        
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Designation</p>
                                <p class="mb-0">{{ $employees->designation }}</p>
                            </li>
                            
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Department</p>
                                <p class="mb-0">{{ $employees->department }}</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Subjects</p>
                                <p class="mb-0">{{ $employees->subject }}</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Work Experience</p>
                                <p class="mb-0">{{ $employees->exprience }}</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Contract Type</p>
                                @if($employees->contactType == 1)
                                <p class="mb-0">Permanent</p>
                                @elseif($employees->contactType == 2)
                                <p class="mb-0">Intern</p>
                                @else
                                <p class="mb-0">Contractual</p>
                                @endif
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0 text-info">Work Shift</p>
                                <p class="mb-0 text-info">{{$employees->shift}}</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Joining Date</p>
                                <p class="mb-0">
                                    @php
                                    $date = strtotime($employees->joiningdate);
                                    $admission_date = date('d-M-Y', $date);
                                @endphp
                                  {{ $admission_date }}
                                    
                                </p>
                            </li>
                            {{-- <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0 text-primary">Basic</p>
                                <p class="mb-0 text-primary"><b>{{ number_format($employees->salary, 2) }} BDT </b></p>
                            </li> --}}
                            {{-- <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0 text-primary">
                                    <a href="{{$targetStudents->link1}}" target="_blank" class="text-light bg-primary px-2 py-1 rounded"><i class="fab fa-facebook-f"></i></a>
                                    <a href="{{$targetStudents->link2}}" target="_blank" class="text-light bg-info px-2 py-1 rounded"><i class="fab fa-linkedin-in"></i></a>
                                    <a href="{{$targetStudents->link3}}" target="_blank" class="text-light bg-dark px-2 py-1 rounded"><i class="fab fa-github"></i></a>
                                    <a href="{{$targetStudents->link4}}" target="_blank" class="text-light bg-dark px-2 py-1 rounded"><i class="fab fa-behance"></i></a>
                                </p>
                                
                            </li> --}}
                           
                        </ul>
                    </div>
                </div>
                </div>
                <div class="col-lg-8">
                    <!-- Student Information -->
                    <div class="card mb-4">
                         <div class="card-header bg-primary"> <h5 class="text-white"><i class="fa fa-user"></i> Employee Informations</h5></div>
                        <div class="card-body">
                           
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Full Name : </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $employees->name }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Phone Number : </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{$employees->phone}}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 col-md-3">
                                <p class="mb-0">NID / BCN : </p>
                                </div>
                                <div class="col-sm-9 col-md-9">
                                    <p class="text-muted mb-0">
                                       {{$employees->nid}} 
                                    </p>
                                </div>
                            </div>
                            {{-- <hr> --}}
                            {{-- <div class="row">
                                <div class="col-sm-3 col-md-3">
                                <p class="mb-0">Education Qulification : </p>
                                </div>
                                <div class="col-sm-9 col-md-9">
                                    <p class="text-muted mb-0">
                                       {{$employees->education}} 
                                    </p>
                                </div>
                            </div> --}}
                            <hr>
                                <div class="row">
                                    <div class="col-sm-6 col-md-3">
                                        <p class="mb-0">Date of Birth : </p>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <p class="text-muted mb-0">
                                        @php
                                            $date = strtotime($employees->dob);
                                            $dob = date('d-M-Y', $date);
                                        @endphp
                                                {{ $dob }}
                                        </p>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <p class="mb-0">Gender : </p>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <p class="text-muted mb-0">
                                            @if($employees->gender == 1)
                                          Male
                                            @elseif($employees->gender == 2)
                                            Female
                                            @else
                                           Others
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-6 col-md-3">
                                        <p class="mb-0">Blood Group : </p>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <p class="text-muted mb-0">
                                            @php
                                            if($employees->bloodgroup == 1){
                                            $blood = "A(+ve)";}
                                            else if($employees->bloodgroup == 2){
                                            $blood = "O(+ve)";}
                                            else if($employees->bloodgroup == 3){
                                            $blood = "B(+ve)";}
                                            else if($employees->bloodgroup == 4){
                                            $blood = "AB(+ve)";}
                                            else if($employees->bloodgroup == 5){
                                            $blood = "A(-ve)";}
                                            else if($employees->bloodgroup == 6){
                                            $blood = "O(-ve)";}
                                            else if($employees->bloodgroup == 7){
                                            $blood = "B(-ve)";}
                                            else{
                                            $blood = "AB(-ve)";}
                                            @endphp
                                            {{$blood}}
                                        </p>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                    <p class="mb-0">Religion : </p>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <p class="text-muted mb-0">
                                            @php
                                            if($employees->religion == 1){
                                            $religion = "Islam";}
                                            else if($employees->religion == 2){
                                            $religion = "Hindhu";}
                                            else if($employees->religion == 3){
                                            $religion = "Bhudist";}
                                            else if($employees->religion == 4){
                                            $religion = "Christian";}
                                            @endphp
                                            {{$religion}}
                                        </p>
                                    </div>
                                </div>
                                <hr>
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                <p class="mb-0">Employees Status : </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p class="text-muted mb-0">
                                    
                                        @if($employees->IsActive == 1)
                                        <span class="text-success"><b> Active</b></span> 
                                        @elseif($employees->IsActive == 2)
                                        <span class="text-info"><b> Postponded</b></span>  
                                        @elseif($employees->IsActive == 3)
                                        <span class="text-danger"><b> Restricted</b></span>   
                                        @endif 
                                    </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                <p class="mb-0">Joining Date : </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p class="text-muted mb-0">
                                    @php
                                        $date = strtotime($employees->joiningdate);
                                        $joiningdate = date('d-M-Y', $date);
                                    @endphp
                                      {{ $joiningdate }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Guardian Informations -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary"> <h5 class="text-white"><i class="fa fa-users"></i> Others Informations</h5></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <p class="mb-0">Father's Name : </p>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <p class="text-muted mb-0">{{ $employees->fname }}</p>
                                </div>
                                
                            </div>
                            <hr>
                            <div class="row">
                                
                                <div class="col-sm-12 col-md-6">
                                    <p class="mb-0">Mother's Name : </p>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <p class="text-muted mb-0">{{ $employees->mname }}</p>
                                </div>
                            </div>
                            <hr>
                            
                            <div class="row">
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Address : </p>
                                </div>
                                <div class="col-sm-9 col-md-9">
                                    <p class="text-muted mb-0">{{ $employees->address }}</p>
                                </div>
                               
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<br><br><br>
@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('backend/js/lightbox-popup.min.js')}}"></script>
<script>
$(document).ready(function() {
 $('.popup-gallery').magnificPopup({
     delegate: 'a',
     type: 'image',
     tLoading: 'Loading image #%curr%...',
     mainClass: 'mfp-img-mobile',
     gallery: {
         enabled: true,
         navigateByImgClick: true,
         preload: [0,1] // Will preload 0 - before current, and 1 after the current image
     },
     image: {
         tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
         titleSrc: function(item) {
             return item.el.attr('title');
         }
     }
 });
});
</script>
@endpush