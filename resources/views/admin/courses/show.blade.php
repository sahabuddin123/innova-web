@extends('admin.app')
 
@section('title') {{ $pageTitle }} @endsection
 
@section('content')
     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-book-open"></i> {{ $pageTitle }}</h1>
        </div>
        <div>
        <a href="{{ route('admin.courses.index') }}" class="btn btn-success pull-right">All Courses</a>
        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary pull-right">Add Courses</a>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>{{ $targetCourses->name }}</th>
                            </tr>
                            <tr>
                                <th>Course Fee</th>
                                <th>{{ $targetCourses->coursefee }} {{config('settings.currency_code')}}</th>
                            </tr>
                            <tr>
                                <th>Course Durations</th>
                                <th>{{ $targetCourses->courseduration }} {{"Months"}}</th>
                            </tr>
                            <tr>
                                <th>Total Moduls</th>
                                <th>{{ $targetCourses->totalmoduls }}</th>
                            </tr>
                            <tr>
                                <th>Total Projects</th>
                                <th>{{ $targetCourses->totalproject }}</th>
                            </tr>
                            <tr>
                                <th>Create Time</th>
                                <th>
                                @php
                                    $createDate = date_format($targetCourses->created_at, 'd-M-Y h:i a');
                                @endphp
                                {{ $createDate }}

                                </th>
                            </tr>
                            <tr>
                                <th>Last Update</th>
                                <th>
                                @php
                                    $updatedDate = date_format($targetCourses->updated_at, 'd-M-Y h:i a');
                                @endphp
                                {{ $updatedDate }}
                                </th>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <th>{!! $targetCourses->description !!}</th>
                            </tr>
                            <tr>
                                <th>Featured Image</th>
                                <th>
                                <figure class="mt-2" style="width: 180px; height: auto;">
                                            <img src="{{ asset('public/storage/'.$targetCourses->image) }}" id="categoryImage" class="img-fluid" alt="img">
                                        </figure>
                                </th>
                            </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
