@extends('frontend.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <br><br>
    <br><br>
    <br><br>
    <br><br>
    <br><br>
    <br><br>

    <link rel="stylesheet" href="{{ asset('backend/css/lightbox-popup.css') }}">
    <!-- Custom fonts for this template-->
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Page Heading -->
    @include('admin.partials.flash')
    <div class="container">
        <div class="text-center">
            <img src="{!! asset('public/verified.png') !!}" alt="!" style="height: 200px">
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                <div class="popup-gallery">
                                    <a href="{!! asset('public/storage/' . $student->image) !!}" title="{{ $student->sname }}">
                                        <img src="{!! asset('public/storage/' . $student->image) !!}" alt="!"
                                            class="rounded img-fluid img-thumbnail" style="width: 150px;">
                                    </a>
                                </div>
                                <h5 class="my-3">{{ $student->sname }}</h5>
                                <p class="p-0 text-info"><b><mark> Student ID : {{ $student->id }} </mark></b></p>
                                <p class="mb-0 text-primary">
                                    <a href="#" target="_blank" class="text-light bg-primary px-2 py-1 rounded"><i
                                            class="fab fa-facebook-f"></i></a>
                                    <a href="#" target="_blank" class="text-light bg-info px-2 py-1 rounded"><i
                                            class="fab fa-linkedin-in"></i></a>
                                    <a href="#" target="_blank" class="text-light bg-dark px-2 py-1 rounded"><i
                                            class="fab fa-github"></i></a>
                                    <a href="#" target="_blank" class="text-light bg-dark px-2 py-1 rounded"><i
                                            class="fab fa-behance"></i></a>
                                </p>
                            </div>
                        </div>
                        <div class="card mb-4 mb-lg-0">
                            <div class="card-header bg-primary">
                                <h5 class="text-white"><i class="fas fa-university"></i> Academic Information</h5>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush rounded-3">

                                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                        <p class="mb-0">Batch Name</p>
                                        <p class="mb-0">{{ $student->StudentsBatchs->batchnum }}</p>
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                        <p class="mb-0">Course Name</p>
                                        <p class="mb-0">{{ $student->StudentsCourses->name }}</p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                        <p class="mb-0">Course Durations</p>
                                        <p class="mb-0">{{ $student->StudentsCourses->courseduration }} Months</p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                        <p class="mb-0">Course Moduls</p>
                                        <p class="mb-0">{{ $student->StudentsCourses->totalmoduls }}</p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                        <p class="mb-0">Total Projects</p>
                                        <p class="mb-0">{{ $student->StudentsCourses->totalproject }}</p>
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                        <p class="mb-0">Batch Start Date</p>
                                        <p class="mb-0">
                                            @php
                                                $date = strtotime($student->StudentsBatchs->startdate);
                                                $startdate = date('d-M-Y', $date);
                                            @endphp
                                            {{ $startdate }}
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
                                        <p class="text-muted mb-0">{{ $student->sname }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Phone Number : </p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ $student->phone }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3 col-md-3">
                                        <p class="mb-0">NID / BCN : </p>
                                    </div>
                                    <div class="col-sm-9 col-md-9">
                                        <p class="text-muted mb-0">
                                            {{ $student->nid }}
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
                                            {{ $student->last_school }}
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
                                                $date = strtotime($student->dob);
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
                                                if ($student->gender == 1) {
                                                    $gender = 'Male';
                                                } elseif ($student->gender == 2) {
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
                                        <p class="mb-0">Blood Group : </p>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <p class="text-muted mb-0">
                                            @php
                                                if ($student->bloodgroup == 1) {
                                                    $blood = 'A(+ve)';
                                                } elseif ($student->bloodgroup == 2) {
                                                    $blood = 'O(+ve)';
                                                } elseif ($student->bloodgroup == 3) {
                                                    $blood = 'B(+ve)';
                                                } elseif ($student->bloodgroup == 4) {
                                                    $blood = 'AB(+ve)';
                                                } elseif ($student->bloodgroup == 5) {
                                                    $blood = 'A(-ve)';
                                                } elseif ($student->bloodgroup == 6) {
                                                    $blood = 'O(-ve)';
                                                } elseif ($student->bloodgroup == 7) {
                                                    $blood = 'B(-ve)';
                                                } else {
                                                    $blood = 'AB(-ve)';
                                                }
                                            @endphp
                                            {{ $blood }}
                                        </p>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <p class="mb-0">Religion : </p>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <p class="text-muted mb-0">
                                            @php
                                                if ($student->religion == 1) {
                                                    $religion = 'Islam';
                                                } elseif ($student->religion == 2) {
                                                    $religion = 'Hindhu';
                                                } elseif ($student->religion == 3) {
                                                    $religion = 'Bhudist';
                                                } elseif ($student->religion == 4) {
                                                    $religion = 'Christian';
                                                }
                                            @endphp
                                            {{ $religion }}
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
                                            {{ $student->height }} Inches
                                        </p>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <p class="mb-0">Weight : </p>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <p class="text-muted mb-0">
                                            {{ $student->weight }} KGs
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
                                                if ($student->IsActive == 1) {
                                                    $status = 'Regular';
                                                } elseif ($student->IsActive == 2) {
                                                    $status = 'Iregular';
                                                } elseif ($student->IsActive == 3) {
                                                    $status = 'Complete';
                                                } elseif ($student->IsActive == 4) {
                                                    $status = 'Restricted';
                                                } elseif ($student->IsActive == 5) {
                                                    $status = 'Postponded';
                                                }
                                            @endphp
                                            {{ $status }}
                                        </p>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <p class="mb-0">Admission Date : </p>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <p class="text-muted mb-0">
                                            @php
                                                $date = strtotime($student->admission_date);
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
                            <div class="card-header bg-primary">
                                <h5 class="text-white"><i class="fa fa-users"></i> Guardians Informations</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3 col-md-3">
                                        <p class="mb-0">Father's Name : </p>
                                    </div>
                                    <div class="col-sm-9 col-md-3">
                                        <p class="text-muted mb-0">{{ $student->f_name }}</p>
                                    </div>
                                    <div class="col-sm-3 col-md-3">
                                        <p class="mb-0">Father's Phone Number : </p>
                                    </div>
                                    <div class="col-sm-9 col-md-3">
                                        <p class="text-muted mb-0">{{ $student->f_phone }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3 col-md-3">
                                        <p class="mb-0">Mother's Name : </p>
                                    </div>
                                    <div class="col-sm-9 col-md-3">
                                        <p class="text-muted mb-0">{{ $student->m_name }}</p>
                                    </div>
                                    <div class="col-sm-3 col-md-3">
                                        <p class="mb-0">Mother's Phone Number : </p>
                                    </div>
                                    <div class="col-sm-9 col-md-3">
                                        <p class="text-muted mb-0">{{ $student->m_phone }}</p>
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
    <script type="text/javascript" src="{{ asset('backend/js/lightbox-popup.min.js') }}"></script>
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
                    preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
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
