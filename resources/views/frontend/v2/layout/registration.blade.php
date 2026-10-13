@extends('frontend.v2.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <!-- ==================== Breadcrumb Start Here ==================== -->
    <section class="breadcrumb py-120 bg-main-25 position-relative z-1 overflow-hidden mb-0">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape1.png') }}" alt=""
            class="shape one animation-rotation d-md-block d-none">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape2.png') }}" alt=""
            class="shape two animation-scalation d-md-block d-none">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape3.png') }}" alt=""
            class="shape eight animation-walking d-md-block d-none">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape5.png') }}" alt=""
            class="shape six animation-walking d-md-block d-none">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape4.png') }}" alt=""
            class="shape four animation-scalation">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape4.png') }}" alt=""
            class="shape nine animation-scalation">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb__wrapper">
                        <h1 class="breadcrumb__title display-4 fw-semibold text-center"> বাকাশিবো রেজিস্ট্রেশন</h1>
                        <ul class="breadcrumb__list d-flex align-items-center justify-content-center gap-4">
                            <li class="breadcrumb__item">
                                <a href="{{ route('frontend.home') }}"
                                    class="breadcrumb__link text-neutral-500 hover-text-main-600 fw-medium">
                                    <i class="text-lg d-inline-flex ph-bold ph-house"></i> হোম</a>
                            </li>
                            <li class="breadcrumb__item">
                                <i class="text-neutral-500 d-flex ph-bold ph-caret-right"></i>
                            </li>
                            <li class="breadcrumb__item d-none">
                                <i class="text-neutral-500 d-flex ph-bold ph-caret-right"></i>
                            </li>
                            <li class="breadcrumb__item">
                                <span class="text-main-two-600"> রেজিস্ট্রেশন </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== Breadcrumb End Here ==================== -->
    <style>
        .dataTables_filter {
            float: right;
        }
    </style>
    <!-- ================================ Blog Details Section Start =================================== -->
    <div class="blog-page-section py-120 ">
        <div class="container">
            <div class="row gy-4 bg-main-25 rounded-16 p-12">
                <div class="col-lg-12">
                    <div class="p-40">
                        <div class="text-center">
                            <h3 class="mb-24 text-left">৩৬০ ঘন্টা মেয়াদি কোর্সের রেজিস্ট্রেশন</h3>
                            <p class="text-justify pb-20"> বাংলাদেশ কারিগরি শিক্ষাবোর্ডের অধীনে ৩৬০ ঘণ্টা বা ৬ মাস মেয়াদি
                                <br> কম্পিউটার বেসিক কোর্সের ({{ $targetSession->sessionName }}) সেশনের পরিক্ষার্থীর তালিকা
                            </p>
                        </div>

                        <table class="table table-bordered text-center" id="sampleTable">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> Image </th>
                                    <th> Students Name </th>
                                    {{-- <th> BTEB Registration Date </th> --}}
                                    <th> Status </th>
                                    <th class="text-center text-danger">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($registration as $course)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>
                                            <a href="{!! asset('public/storage/' . $course->StudentsInfo->image) !!}" download>
                                                <img src="{!! asset('public/storage/' . $course->StudentsInfo->image) !!}" alt="!"
                                                    style="height: 50px !important;">
                                            </a>
                                        </td>
                                        <td>{{ $course->StudentsInfo->sname }} </td>
                                        {{-- <td>
                                                    @php
                                                        $date = strtotime($course->regDate);
                                                        $createDate = date('d-M-y', $date);
                                                    @endphp
                                                    {{ $createDate }}
                                                </td> --}}
                                        <td>
                                            @php
                                                if ($course->IsActive == 1) {
                                                    $status = "<span class='text-success'>Complete</span>";
                                                } elseif ($course->IsActive == 2) {
                                                    $status = "<span class='text-info'>Waiting For Payments</span>";
                                                } elseif ($course->IsActive == 3) {
                                                    $status = "<span class='text-warning'>Postponded</span>";
                                                } elseif ($course->IsActive == 4) {
                                                    $status = "<span class='text-danger'>Restricted</span>";
                                                }
                                            @endphp
                                            <b>{!! $status !!}</b>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                <a href="{{ route('frontend.registration.view', $course->id) }}"
                                                    class="btn btn-sm btn-info" title="View Student">View</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Success Story End --}}
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript">
        $('#sampleTable').DataTable();
    </script>
@endpush
