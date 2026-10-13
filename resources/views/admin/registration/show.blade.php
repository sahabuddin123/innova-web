@extends('admin.app')

@section('title') {{ $pageTitle }} @endsection

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-user"></i> {{ $pageTitle }}</h1>
    </div>
    
</div>
@include('admin.partials.flash')
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img src="{{ asset('public/storage/'.$targetRegistration->StudentsInfo->image)}}"
                            alt="avatar" class="rounded-circle img-fluid img-thumbnail" style="width: 150px;">
                        <h5 class="my-3">{{ $targetRegistration->StudentsInfo->sname }}</h5>
                        
                        <p class="p-0 text-info"><b><mark> Student ID : {{ $targetRegistration->StudentsInfo->id }} </mark></b></p>
                        
                    </div>
                </div>
                <div class="card mb-4 mb-lg-0">
                <div class="card-header bg-success"><h5 class="text-white"><i class="fas fa-university"></i> Registration Information</h5></div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush rounded-3">
                        
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Batch Name</p>
                                <p class="mb-0">{{ $targetRegistration->StudentsInfo->StudentsBatchs->batchnum }}</p>
                            </li>
                            
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Course Name</p>
                                <p class="mb-0">{{ $targetRegistration->StudentsInfo->StudentsCourses->name }}</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Course Durations</p>
                                <p class="mb-0">{{$targetRegistration->StudentsInfo->StudentsCourses->courseduration }} Months</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Course Moduls</p>
                                <p class="mb-0">{{ $targetRegistration->StudentsInfo->StudentsCourses->totalmoduls }}</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Registration Session</p>
                                <p class="mb-0">
                                      {{ $targetRegistration->StudentsSessions->sessionName }}
                                </p>
                            </li>
                             <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Registration Date</p>
                                <p class="mb-0">
                                     @php
                                        $REGdate = strtotime($targetRegistration->regDate);
                                        $regDate = date('d-M-Y', $REGdate);
                                    @endphp
                                      {{ $regDate }}
                                    
                                </p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0 text-info">Registration Fee</p>
                                <p class="mb-0 text-info"><b>{{ number_format($targetRegistration->balance, 2) }} BDT </b></p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0 text-success">Total Registration Pay Amount</p>
                                @php
                                $payamount = DB::table('fees_transections')->select('paidamount')->where('student_id', $targetRegistration->StudentsInfo->id)->where('paymentType',2)->sum('paidamount');
                                $totalDue = $targetRegistration->balance - $payamount;
                                @endphp
                                <p class="mb-0 text-success"><b>{{ number_format($payamount, 2) }} BDT </b></p>
                            </li> 
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0 text-danger">Total Registration Due Amount</p>
                                <p class="mb-0 text-danger"><b>{{ number_format($totalDue, 2) }} BDT </b></p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0 text-primary">Registration Status</p>
                                <p class="mb-0">
                                    @if($targetRegistration->IsActive == 1)
                                        <b class="text-success">{{"Complete"}}</b>
                                    @elseif($targetRegistration->IsActive == 2)
                                        <b class="text-warning">{{"Waiting For Payment"}}</b>
                                    @elseif($targetRegistration->IsActive == 3)
                                        <b class="text-info">{{"Postponded"}}</b>
                                    @elseif($targetRegistration->IsActive == 4)
                                        <b class="text-danger">{{"Restricted"}}</b>
                                    @endif
                                </p>
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
                                    <p class="text-muted mb-0">{{ $targetRegistration->StudentsInfo->sname }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Phone Number : </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{$targetRegistration->StudentsInfo->phone}}</p>
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
                                            $date = strtotime($targetRegistration->StudentsInfo->dob);
                                            $dob = date('d-m-Y', $date);
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
                                            if($targetRegistration->StudentsInfo->gender == 1){
                                            $gender = "Male";}
                                            else if($targetRegistration->StudentsInfo->gender == 2){
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
                                            if ($targetRegistration->bloodgroup == 1) {
                                                $blood = 'A(+ve)';
                                            } elseif ($targetRegistration->bloodgroup == 2) {
                                                $blood = 'O(+ve)';
                                            } elseif ($targetRegistration->bloodgroup == 3) {
                                                $blood = 'B(+ve)';
                                            } elseif ($targetRegistration->bloodgroup == 4) {
                                                $blood = 'AB(+ve)';
                                            } elseif ($targetRegistration->bloodgroup == 5) {
                                                $blood = 'A(-ve)';
                                            } elseif ($targetRegistration->bloodgroup == 6) {
                                                $blood = 'O(-ve)';
                                            } elseif ($targetRegistration->bloodgroup == 7) {
                                                $blood = 'B(-ve)';
                                            } else {
                                                $blood = 'AB(-ve)';
                                            }
                                        @endphp
                                        {{ $blood }}
                                        </p>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        {{-- <p class="mb-0">Gender : </p> --}}
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        {{-- <p class="text-muted mb-0">
                                            @php
                                            if($targetRegistration->StudentsInfo->gender == 1){
                                            $gender = "Male";}
                                            else if($targetRegistration->StudentsInfo->gender == 2){
                                            $gender = "Female";}
                                            else{
                                            $gender = "Others";}
                                            @endphp
                                            {{$gender}}
                                        </p> --}}
                                    </div>
                                </div>
                        </div>
                    </div>
                    <!-- Education Qualification -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary"> <h5 class="text-white"><i class="fa fa-graduation-cap"></i>  Education Qualification</h5></div>
                       <div class="card-body">
                               <div class="row">
                                   <div class="col-sm-6 col-md-3">
                                       <p class="mb-0">Board Exam Name </p>
                                   </div>
                                   <div class="col-sm-6 col-md-3">
                                       <p class="mb-0">
                                       @if($targetRegistration->ExamName == 1)
                                       <b class="text-success">{{"JSC"}}</b>
                                       @elseif($targetRegistration->ExamName == 2)
                                       <b class="text-success">{{"JDC"}}</b>
                                       @elseif($targetRegistration->ExamName == 3)
                                       <b class="text-primary">{{"SSC"}}</b>
                                       @elseif($targetRegistration->ExamName == 4)
                                       <b class="text-primary">{{"Dakhil"}}</b>
                                       @endif
                                       </p>
                                   </div>
                                   <div class="col-sm-6 col-md-3">
                                       <p class="mb-0">Board Name </p>
                                   </div>
                                   <div class="col-sm-6 col-md-3">
                                       <p class="mb-0">
                                        @if($targetRegistration->ExamBoard == 1)
                                        <b class="text-success">Barisal</b>
                                        @elseif($targetRegistration->ExamBoard == 2)
                                        <b class="text-success">Chittagong</b>
                                        @elseif($targetRegistration->ExamBoard == 3)
                                        <b class="text-primary">Comilla</b>
                                        @elseif($targetRegistration->ExamBoard == 4)
                                        <b class="text-primary">Dhaka</b>
                                        @elseif($targetRegistration->ExamBoard == 5)
                                        <b class="text-success">Dinajpur</b>
                                        @elseif($targetRegistration->ExamBoard == 6)
                                        <b class="text-primary">Jessore</b>
                                        @elseif($targetRegistration->ExamBoard == 7)
                                        <b class="text-primary">Mymensingh</b>
                                        @elseif($targetRegistration->ExamBoard == 8)
                                        <b class="text-success">Rajshahi</b>
                                        @elseif($targetRegistration->ExamBoard == 9)
                                        <b class="text-primary">Sylhet</b>
                                        @elseif($targetRegistration->ExamBoard == 10)
                                        <b class="text-primary">Madrasah</b>
                                        @elseif($targetRegistration->ExamBoard == 11)
                                        <b class="text-success">Technical</b>
                                        @elseif($targetRegistration->ExamBoard == 12)
                                        <b class="text-primary">DIBS(Dhaka)</b>
                                        @endif
                                       </p>
                                   </div>
                               </div>
                               <hr>
                               <div class="row">
                                    <div class="col-sm-6 col-md-3">
                                        <p class="mb-0">Roll Number</p>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <p class="mb-0 text-success">
                                        <b>{{$targetRegistration->ExamRoll}}</b>
                                        </p>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <p class="mb-0">Registration Number </p>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <p class="mb-0 text-success">
                                        <b>{{$targetRegistration->ExamReg}}</b>
                                        </p>
                                    </div>
                               </div>
                               <hr>
                               <div class="row">
                                    <div class="col-sm-6 col-md-3">
                                        <p class="mb-0">Board Exam Session</p>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <p class="mb-0 text-info">
                                        <b>{{$targetRegistration->ExamSession}}</b>
                                        </p>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <p class="mb-0">Passing Year </p>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <p class="mb-0 text-info">
                                        <b>{{$targetRegistration->PassYear}}</b>
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <p class="mb-0">Board Exam Result (GPA)</p>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <p class="mb-0 text-danger">
                                        <b>{{$targetRegistration->Result}}</b>
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
                                    <p class="text-muted mb-0">{{ $targetRegistration->StudentsInfo->f_name }}</p>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Father's Phone Number : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0">{{ $targetRegistration->StudentsInfo->f_phone }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Mother's Name : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0">{{ $targetRegistration->StudentsInfo->m_name }}</p>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Mother's Phone Number : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0">{{ $targetRegistration->StudentsInfo->m_phone }}</p>
                                </div>
                            </div>
                           {{-- <hr>
                             <div class="row">
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Guardian's Name : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0">{{ $targetRegistration->StudentsInfo->g_name }}</p>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Guardian's Phone Number : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0">{{ $targetRegistration->StudentsInfo->g_phone }}</p>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
@endsection