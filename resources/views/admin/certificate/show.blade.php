@extends('admin.app')

@section('title')
    {{ $pageTitle }}
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-user"></i> {{ $pageTitle }}</h1>
        </div>
        <a href="{{route('admin.certificate.index')}}" class="btn btn-primary">All BTEB Certificate</a>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="{{ asset('public/storage/' . $target->StudentsInfo->image) }}" alt="avatar"
                                class="rounded-circle img-fluid img-thumbnail" style="width: 150px;">
                            <h5 class="my-3">{{ $target->StudentsInfo->sname }}</h5>

                            <p class="p-0 text-info"><b><mark> Student ID : {{ $target->StudentsInfo->id }} </mark></b></p>

                        </div>
                    </div>
                    <div class="card mb-4 mb-lg-0">
                        <div class="card-header bg-success">
                            <h5 class="text-white"><i class="fas fa-university"></i> Registration Information</h5>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush rounded-3">

                                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                    <p class="mb-0">Batch Name</p>
                                    <p class="mb-0">{{ $target->StudentsInfo->StudentsBatchs->batchnum }}</p>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                    <p class="mb-0">Course Name</p>
                                    <p class="mb-0">{{ $target->StudentsInfo->StudentsCourses->name }}</p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                    <p class="mb-0">Course Durations</p>
                                    <p class="mb-0">{{ $target->StudentsInfo->StudentsCourses->courseduration }} Months
                                    </p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                    <p class="mb-0">Course Moduls</p>
                                    <p class="mb-0">{{ $target->StudentsInfo->StudentsCourses->totalmoduls }}</p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                    <p class="mb-0">Registration Session</p>
                                    <p class="mb-0">
                                        {{ $target->StudentsSessions->sessionName }}
                                    </p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                    <p class="mb-0">Registration Number</p>
                                    <p class="mb-0">

                                        {{ $target->RegNum }}

                                    </p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                    <p class="mb-0 text-info">Registration Fee</p>
                                    <p class="mb-0 text-info"><b>{{ number_format($target->balance, 2) }} BDT </b></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                    <p class="mb-0 text-success">Total Registration Pay Amount</p>
                                    @php
                                        $payamount = DB::table('fees_transections')
                                            ->select('paidamount')
                                            ->where('student_id', $target->StudentsInfo->id)
                                            ->where('paymentType', 2)
                                            ->sum('paidamount');
                                        $totalDue = $target->balance - $payamount;
                                    @endphp
                                    <p class="mb-0 text-success"><b>{{ number_format($payamount, 2) }} BDT </b></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                    <p class="mb-0 text-danger">Total Registration Due Amount</p>
                                    <p class="mb-0 text-danger"><b>{{ number_format($totalDue, 2) }} BDT </b></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                    <p class="mb-0 text-primary">Certificate Status</p>
                                    <p class="mb-0">
                                        @if ($target->IsActive == 1)
                                            <b class="text-success">{{ 'Deliverd' }}</b>
                                        @elseif($target->IsActive == 2)
                                            <b class="text-warning">{{ 'Waiting For Deliverd' }}</b>
                                        @elseif($target->IsActive == 3)
                                            <b class="text-info">{{ 'Printing Queie' }}</b>
                                        @elseif($target->IsActive == 4)
                                            <b class="text-danger">{{ 'Cancle' }}</b>
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
                        <div class="card-header bg-primary">
                            <h5 class="text-white"><i class="fa fa-user"></i> Students Informations</h5>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Full Name : </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $target->StudentsInfo->sname }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Phone Number : </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $target->StudentsInfo->phone }}</p>
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
                                            $date = strtotime($target->StudentsInfo->dob);
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
                                            if ($target->StudentsInfo->gender == 1) {
                                                $gender = 'Male';
                                            } elseif ($target->StudentsInfo->gender == 2) {
                                                $gender = 'Female';
                                            } else {
                                                $gender = 'Others';
                                            }
                                        @endphp
                                        {{ $gender }}
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <p class="mb-0">Certificate Image: </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p class="text-muted mb-0">
                                        <a href="{!! asset('public/storage/' . $target->cimage) !!}" target="_blank">
                                            <img src="{!! asset('public/storage/' . $target->cimage) !!}" alt="Certificate Not added" height="100">
                                        </a>
                                    </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p class="mb-0">Delivery Image : </p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p class="text-muted mb-0">
                                        <a href="{!! asset('public/storage/' . $target->dimage) !!}" target="_blank">
                                            <img src="{!! asset('public/storage/' . $target->dimage) !!}" alt="Delivery image not added" height="100">
                                        </a>
                                    </p>
                                </div>
                            </div>
                            <hr>

                        </div>
                    </div>
                    <!-- Education Qualification -->
                    <!-- Guardian Informations -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary">
                            <h5 class="text-white"><i class="fa fa-users"></i> Guardians Informations</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Father's Name : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0">{{ $target->StudentsInfo->f_name }}</p>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Father's Phone Number : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0">{{ $target->StudentsInfo->f_phone }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Mother's Name : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0">{{ $target->StudentsInfo->m_name }}</p>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Mother's Phone Number : </p>
                                </div>
                                <div class="col-sm-9 col-md-3">
                                    <p class="text-muted mb-0">{{ $target->StudentsInfo->m_phone }}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
