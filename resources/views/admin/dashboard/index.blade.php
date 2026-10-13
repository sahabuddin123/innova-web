@extends('admin.app')
@section('title') Dashboard @endsection
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>
    <!-- Content Row -->
<div class="row">

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <a href="{{ route('admin.students.index') }}">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Total Students</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalstudent}}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
            </div>
            </a>
            
        </div>
    </div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <a href="{{ route('admin.students.complete') }}">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Course Complete Students</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$completestudent}}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
            </div>
            </a>
        </div>
    </div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <a href="{{ route('admin.students.active') }}">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Active Students
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$activestuent}}</div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
            </div>
            </a>
        </div>
    </div>
</div>

<!-- Pending Requests Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <a href="{{ route('admin.students.iregular') }}">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Iregular Students</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$iregularstudent}}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
            </div>
            </a>
        </div>
    </div>
</div>

<!-- Pending Requests Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <a href="{{ route('admin.students.postpond') }}">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Postponded Students</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$postponded}}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
            </div>
            </a>
        </div>
    </div>
</div>

<!-- Pending Requests Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
            <a href="{{ route('admin.students.resticted') }}">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                        Restricted Students</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$restrictedstudent}}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
            </div>
            </a>
        </div>
    </div>
</div>

<!-- Pending Requests Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <a href="{{ route('admin.registration.index') }}">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Register Students</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$registerStudent}}</div>
                </div>
                <div class="col-auto">
                    <i class="fa fa-certificate fa-2x text-gray-300"></i>
                </div>
            </div>
            </a>
        </div>
    </div>
</div>

<!-- Pending Requests Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <a href="{{ route('admin.batchs.upcomming') }}">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Upcomming Batch</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$upcommingbatch}}</div>
                </div>
                <div class="col-auto">
                    <i class="fas  fa-graduation-cap fa-2x text-gray-300"></i>
                   
                </div>
            </div>
            </a>
        </div>
    </div>
</div>

</div>
<!-- Content Row -->
<div class="row">

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <a href="{{ route('admin.batchs.index') }}">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Total Batch</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalbatch}}</div>
                </div>
                <div class="col-auto">
                    <i class="fas  fa-graduation-cap fa-2x text-gray-300"></i>
                   
                </div>
            </div>
            </a>
        </div>
    </div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <a href="{{ route('admin.batchs.complete') }}">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Complete Batch</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$completebatch}}</div>
                </div>
                <div class="col-auto">
                <i class="fas  fa-graduation-cap fa-2x text-gray-300"></i>
                </div>
            </div>
            </a>
        </div>
    </div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <a href="{{ route('admin.batchs.running') }}">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Running Batch
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$runningbatch}}</div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                <i class="fas  fa-graduation-cap fa-2x text-gray-300"></i>
                </div>
            </div>
            </a>
        </div>
    </div>
</div>

<!-- Pending Requests Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <a href="{{ route('admin.batchs.postponded') }}">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Pending Batch</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$pendingbatch}}</div>
                </div>
                <div class="col-auto">
                <i class="fas  fa-graduation-cap fa-2x text-gray-300"></i>
                </div>
            </div>
            </a>
        </div>
    </div>
</div>

</div>
<!-- Content Row -->
<div class="row">

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Earning This Month</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$paidcurrentMonth}}</div>
                </div>
                <div class="col-auto">
                    <i class="fas  fa-graduation-cap fa-2x text-gray-300"></i>
                   
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Total Earning Payment</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalpayments}}</div>
                </div>
                <div class="col-auto">
                <i class="fas  fa-graduation-cap fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1"> Total Payable Amount
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$payableamount}}</div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                <i class="fas  fa-graduation-cap fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pending Requests Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Total Due Amount</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totaldueamount}}</div>
                </div>
                <div class="col-auto">
                <i class="fas  fa-graduation-cap fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<!-- Content Row -->

<div class="row">

<!-- Area Chart -->
<div class="col-xl-8 col-lg-7">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">This Year Income vs Expense Overview</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                    aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Dropdown Header:</div>
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="chart-area">
                <canvas id="myAreaChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Pie Chart -->
<div class="col-xl-4 col-lg-5">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Total Course Fee</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                    aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Dropdown Header:</div>
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="chart-pie pt-4 pb-2">
                <canvas id="myPieChart"></canvas>
            </div>
            <div class="mt-4 text-center small">
                <span class="mr-2">
                    <i class="fas fa-circle text-primary"></i> Total Earnings
                </span>
                <span class="mr-2">
                    <i class="fas fa-circle text-danger"></i> Total Due Amount
                </span>
                
            </div>
        </div>
    </div>
</div>
</div>

<!-- Additional Detailed Sections -->
<div class="row">
    <!-- Stuff/Staff Stats -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <a href="{{ route('admin.stuff.index') }}">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Staff</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalstuff ?? 0 }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-user-tie fa-2x text-gray-300"></i></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Course Stats -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <a href="{{ route('admin.courses.index') }}">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Courses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalcourse ?? 0 }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-book fa-2x text-gray-300"></i></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Certificate Stats -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <a href="{{ route('admin.certificate.index') }}">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Certificates</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalcertificate ?? 0 }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-certificate fa-2x text-gray-300"></i></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Branch Stats -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <a href="{{ route('admin.branch.index') }}">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Branches</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalbranch ?? 0 }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-store fa-2x text-gray-300"></i></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Second Row: Income/Expense & More Stats -->
<div class="row">
    <!-- Income This Month -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <a href="{{ route('admin.income.index') }}">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Income This Month</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $incomeThisMonth ?? 0 }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-arrow-up fa-2x text-success"></i></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Expense This Month -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <a href="{{ route('admin.expance.index') }}">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Expense This Month</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $expenseThisMonth ?? 0 }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-arrow-down fa-2x text-danger"></i></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Online Admissions -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <a href="{{ route('admin.admission.index') }}">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Online Admissions</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $onlineAdmission ?? 0 }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-file-alt fa-2x text-gray-300"></i></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Sessions -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <a href="{{ route('admin.session.index') }}">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Sessions</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalsession ?? 0 }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-calendar fa-2x text-gray-300"></i></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Third Row: Recent Activities & Quick Links -->
<div class="row">
    <!-- Recent Students Table -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Recent Students</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Course</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($recentStudents) && count($recentStudents) > 0)
                            {{-- @dd($recentStudents) --}}
                                @foreach($recentStudents as $student)
                                <tr>
                                    <td>{{ $student->sname ?? '' }}</td>
                                    <td>{{ $student->phone ?? '' }}</td>
                                    <td>{{ $student->course->name ?? '' }}</td>
                                    <td>
                                        @if($student->IsActive == 1)
                                        <span class="badge bg-success text-light">Active</span>
                                        @elseif($student->status == 2)
                                        <span class="badge bg-warning text-dark">Complete</span>
                                        @else
                                        <span class="badge bg-secondary text-light">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr><td colspan="4" class="text-center">No recent students</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Links -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6">
                        <a href="{{ route('admin.students.create') }}" class="btn btn-primary btn-block">
                            <i class="fas fa-user-plus"></i> Add Student
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.courses.create') }}" class="btn btn-success btn-block">
                            <i class="fas fa-book"></i> Add Course
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.batchs.create') }}" class="btn btn-info btn-block">
                            <i class="fas fa-layer-group"></i> Add Batch
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.fees.index') }}" class="btn btn-warning btn-block">
                            <i class="fas fa-money-bill"></i> Fees Collection
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.stuff.create') }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-user-tie"></i> Add Staff
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.registration.index') }}" class="btn btn-dark btn-block">
                            <i class="fas fa-clipboard-list"></i> Registrations
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fourth Row: Top Courses & Payment History -->
<div class="row">
    <!-- Top Courses -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Top Courses by Students</h6>
            </div>
            <div class="card-body">
                @if(isset($topCourses) && count($topCourses) > 0)
                {{-- @dd($topCourses) --}}
                    @foreach($topCourses as $index => $course)
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <span class="badge bg-primary rounded-circle p-2">{{ $index + 1 }}</span>
                        </div>
                        <div class="flex-grow-1">
                            <div class="font-weight-bold">{{ $course->name ?? '' }}</div>
                            <small class="text-muted">{{ $course->students_count ?? 0 }} Students</small>
                        </div>
                        <div>
                            <span class="text-success font-weight-bold">{{ $course->coursefee ?? 0 }} TK</span>
                        </div>
                    </div>
                    @endforeach
                @else
                    <p class="text-center text-muted">No course data available</p>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Recent Payments -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Recent Payments</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($recentPayments) && count($recentPayments) > 0)
                            {{-- @php dd( $recentPayments); @endphp   --}}
                                @foreach($recentPayments as $payment)
                                <tr>
                                    
                                    <td>{{ $payment->student->sname ?? '' }}</td>
                                    <td class="text-success">{{ $payment->paidamount ?? 0 }} TK</td>
                                    <td>{{ date('d M', strtotime($payment->created_at ?? now())) }}</td>
                                    <td><span class="badge bg-success">Paid</span></td>
                                </tr>
                                @endforeach
                            @else
                                <tr><td colspan="4" class="text-center">No recent payments</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fifth Row: System Info & Alerts -->
<div class="row">
    <!-- System Info -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">System Info</h6>
            </div>
            <div class="card-body">
                <div class="mb-2"><strong>PHP Version:</strong> {{ phpversion() }}</div>
                <div class="mb-2"><strong>Laravel Version:</strong> {{ app()->version() }}</div>
                <div class="mb-2"><strong>Server:</strong> {{ $_SERVER['SERVER_SOFTWARE'] ?? 'N/A' }}</div>
                <div class="mb-2"><strong>Database:</strong> {{ config('database.connections.mysql.database') }}</div>
                <div><strong>Time:</strong> {{ now()->format('d M Y, h:i A') }}</div>
            </div>
        </div>
    </div>
    
    <!-- Alerts/Notifications -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">Alerts</h6>
            </div>
            <div class="card-body">
                @if(isset($alerts) && count($alerts) > 0)
                    @foreach($alerts as $alert)
                    <div class="alert alert-{{ $alert->type ?? 'info' }} py-2 px-3 mb-2">
                        <small>{{ $alert->message ?? '' }}</small>
                    </div>
                    @endforeach
                @else
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                        <p class="mt-2">No alerts</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Monthly Summary -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">This Month Summary</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 border-end">
                        <div class="h4 text-success">{{ $paidcurrentMonth ?? 0 }}</div>
                        <small class="text-muted">Income</small>
                    </div>
                    <div class="col-6">
                        <div class="h4 text-danger">{{ $expenseThisMonth ?? 0 }}</div>
                        <small class="text-muted">Expense</small>
                    </div>
                </div>
                <hr>
                <div class="text-center">
                    <div class="h5 text-primary">{{ ($paidcurrentMonth ?? 0) - ($expenseThisMonth ?? 0) }}</div>
                    <small class="text-muted">Net Profit</small>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
@include('admin.dashboard.chart');
@endpush