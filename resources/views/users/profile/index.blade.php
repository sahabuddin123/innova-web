@extends('users.app')

@section('title') {{ $pageTitle }} @endsection

@section('content')
<link rel="stylesheet" href="{{asset('backend/css/lightbox-popup.css')}}">
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-user"></i> {{ $pageTitle }}</h1>
    </div>
    <div>
        {{-- <a href="{{ route('admin.students.index') }}" class="btn btn-success pull-right">All Students</a> --}}
        {{-- <a href="{{ route('admin.students.create') }}" class="btn btn-primary pull-right">Add Students</a> --}}
        @if($targetStudents->IsRegister == 1)
        <a href="{{ route('users.registration.create', $targetStudents->id) }}" class="btn btn-danger pull-right">Make BTEB Registration</a>
        @else
        <a href="{{ route('user.reg.payment') }}" class="btn btn-success pull-right">BTEB Registration Fee</a>
        @endif
    </div>
</div>
@include('admin.partials.flash')
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <div class="popup-gallery">
                        <a href="{!! asset('public/storage/'.$targetStudents->image) !!}" title="{{ $targetStudents->sname }}">
                            <img src="{!! asset('public/storage/'.$targetStudents->image) !!}" alt="!"  class="rounded-circle img-fluid img-thumbnail" style="width: 150px;">
                        </a>
                        </div> 
                        <h5 class="my-3">{{ $targetStudents->sname }}</h5>
                        <p class="p-0 text-info"><b><mark> Student ID : {{ $targetStudents->id }} </mark></b></p>
                    </div>
                </div>
                <div class="card mb-4 mb-lg-0">
                <div class="card-header bg-success"><h5 class="text-white"><i class="fas fa-university"></i> Academic Information</h5></div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush rounded-3">
                        @php
// dd($targetStudents);
                        @endphp
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Batch Name</p>
                                <p class="mb-0">{{ $targetStudents->StudentsBatchs->batchnum }}</p>
                            </li>
                            
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Course Name</p>
                                <p class="mb-0">{{ $targetStudents->StudentsCourses->name }}</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Course Durations</p>
                                <p class="mb-0">{{ $targetStudents->StudentsCourses->courseduration }} Months</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Course Moduls</p>
                                <p class="mb-0">{{ $targetStudents->StudentsCourses->totalmoduls }}</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Total Projects</p>
                                <p class="mb-0">{{ $targetStudents->StudentsCourses->totalproject }}</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0 text-info">Course Fee</p>
                                <p class="mb-0 text-info"><b>{{ number_format($targetStudents->StudentsCourses->coursefee, 2) }} BDT </b></p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Discount</p>
                                <p class="mb-0">{{ $targetStudents->discount }} % </p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0 text-primary">Total Course Fee</p>
                                <p class="mb-0 text-primary"><b>{{ number_format($targetStudents->balance, 2) }} BDT </b></p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0 text-success">Total Pay Amount</p>
                                @php
                                $payamount = DB::table('fees_transections')->select('paidamount')->where('student_id', $targetStudents->id)->where('paymentType',1)->sum('paidamount');
                                $totalDue = $targetStudents->balance - $payamount;
                                @endphp
                                <p class="mb-0 text-success"><b>{{ number_format($payamount, 2) }} BDT </b></p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0 text-danger">Total Due Amount</p>
                                <p class="mb-0 text-danger"><b>{{ number_format($totalDue, 2) }} BDT </b></p>
                            </li>
                            @php
                                        function time_elapsed_string($datetime, $full = false) {
                                            $now = new DateTime;
                                            $ago = new DateTime($datetime);
                                            $diff = $now->diff($ago);

                                            $diff->w = floor($diff->d / 7);
                                            $diff->d -= $diff->w * 7;

                                            $string = array(
                                                'y' => 'year',
                                                'm' => 'month',
                                                'w' => 'week',
                                                'd' => 'day',
                                                'h' => 'hour',
                                                'i' => 'minute',
                                                's' => 'second',
                                            );
                                            foreach ($string as $k => &$v) {
                                                if ($diff->$k) {
                                                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                                                } else {
                                                    unset($string[$k]);
                                                }
                                            }

                                            if (!$full) $string = array_slice($string, 0, 1);
                                            return $string ? implode(', ', $string) . ' ago' : 'just now';
                                        }
                                        @endphp
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Last Payment Date</p>
                                <p class="mb-0">
                                @php
                                $lastdate = DB::table('fees_transections')->where('student_id',$targetStudents->id)->where('paymentType',1)->pluck('paiddate')->take(1)->last();
                               
                                if(isset($lastdate)){
                                $data =  time_elapsed_string($lastdate);
                               }
                               else{
                                
                                $data =  "No payments";
                               }
                                
                                @endphp
                               {{$data}}
                                    
                                </p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Batch Start Date</p>
                                <p class="mb-0">
                                @php
                                    $date = strtotime($targetStudents->StudentsBatchs->startdate);
                                    $startdate = date('d-M-Y', $date);
                                @endphp
                                    {{ $startdate }}
                                </p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Class Schedule</p>
                                <p class="mb-0">{{ $targetStudents->StudentsBatchs->schedule }}</p>
                            </li>
                        </ul>
                    </div>
                </div>
                </div>
                <div class="col-lg-8">
                    <!-- Student Information -->
                    <div class="card mb-4">
                         <div class="card-header bg-primary"> <h5 class="text-white"><i class="fa fa-user"></i> Students Informations</h5></div>
                        <div class="card-body">
                           
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Full Name : </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $targetStudents->sname }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Phone Number : </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{$targetStudents->phone}}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 col-md-3">
                                <p class="mb-0">NID / BCN : </p>
                                </div>
                                <div class="col-sm-9 col-md-9">
                                    <p class="text-muted mb-0">
                                       {{$targetStudents->nid}} 
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 col-md-3">
                                <p class="mb-0">School / Collage : </p>
                                </div>
                                <div class="col-sm-9 col-md-9">
                                    <p class="text-muted mb-0">
                                       {{$targetStudents->last_school}} 
                                    </p>
                                </div>
                            </div>
                            <hr>
                                <div class="row">
                                    <div class="col-sm-6 col-md-3">
                                        <p class="mb-0">Date of Birth : </p>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <p class="text-muted mb-0">
                                        @php
                                            $date = strtotime($targetStudents->dob);
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
                                            @php
                                            if($targetStudents->gender == 1){
                                            $gender = "Male";}
                                            else if($targetStudents->gender == 2){
                                            $gender = "Female";}
                                            else{
                                            $gender = "Others";}
                                            @endphp
                                            {{$gender}}
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
                                            if($targetStudents->bloodgroup == 1){
                                            $blood = "A(+ve)";}
                                            else if($targetStudents->bloodgroup == 2){
                                            $blood = "O(+ve)";}
                                            else if($targetStudents->bloodgroup == 3){
                                            $blood = "B(+ve)";}
                                            else if($targetStudents->bloodgroup == 4){
                                            $blood = "AB(+ve)";}
                                            else if($targetStudents->bloodgroup == 5){
                                            $blood = "A(-ve)";}
                                            else if($targetStudents->bloodgroup == 6){
                                            $blood = "O(-ve)";}
                                            else if($targetStudents->bloodgroup == 7){
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
                                            if($targetStudents->religion == 1){
                                            $religion = "Islam";}
                                            else if($targetStudents->religion == 2){
                                            $religion = "Hindhu";}
                                            else if($targetStudents->religion == 3){
                                            $religion = "Bhudist";}
                                            else if($targetStudents->religion == 4){
                                            $religion = "Christian";}
                                            @endphp
                                            {{$religion}}
                                        </p>
                                    </div>
                                </div>
                                <hr>
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                <p class="mb-0">Height : </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p class="text-muted mb-0">
                                       {{$targetStudents->height}} Inches
                                    </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                <p class="mb-0">Weight : </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p class="text-muted mb-0">
                                       {{$targetStudents->weight}} KGs
                                    </p>
                                </div>
                            </div>
                            
                            <hr>
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                <p class="mb-0">Student Status : </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p class="text-muted mb-0">
                                    @php
                                        if($targetStudents->IsActive == 1){
                                        $status = "Regular";}
                                        else if($targetStudents->IsActive == 2){
                                        $status = "Iregular";}
                                        else if($targetStudents->IsActive == 3){
                                        $status = "Complete";}
                                        else if($targetStudents->IsActive == 4){
                                        $status = "Restricted";}
                                        else if($targetStudents->IsActive == 5){
                                        $status = "Postponded";}
                                    @endphp
                                        {{$status}} 
                                    </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                <p class="mb-0">Admission Date : </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p class="text-muted mb-0">
                                    @php
                                        $date = strtotime($targetStudents->admission_date);
                                        $admission_date = date('d-M-Y', $date);
                                    @endphp
                                      {{ $admission_date }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Guardian Informations -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary"> <h5 class="text-white"><i class="fa fa-users"></i> Guardians Informations</h5></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Father's Name : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0">{{ $targetStudents->f_name }}</p>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Father's Phone Number : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0">{{ $targetStudents->f_phone }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Mother's Name : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0">{{ $targetStudents->m_name }}</p>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Mother's Phone Number : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0">{{ $targetStudents->m_phone }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Guardian's Name : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0">{{ $targetStudents->g_name }}</p>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Guardian's Phone Number : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0">{{ $targetStudents->g_phone }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Relation Guardian : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0">{{ $targetStudents->rel_g }}</p>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Referance : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0">{{ $targetStudents->ref }}</p>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
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