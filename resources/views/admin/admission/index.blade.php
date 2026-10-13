@extends('admin.app')
 
@section('title') {{ $pageTitle }} @endsection
 
@section('content')
     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-book-open"></i> {{ $subTitle }}</h1>
        </div>
        <div>
        {{-- <a href="{{ route('admin.courses.create') }}" class="btn btn-primary pull-right">Add Courses</a> --}}
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body overflow-auto">
                    <table class="table table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Student Name </th>
                                <th> Course Name </th>
                                <th> Phone </th>
                                <th> Email </th>
                                <th> Class Type </th>
                                <th> Status </th>
                                <th> Admission At </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admission as $course)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $course->username }}</td>
                                        <td>{{ $course->CourseInfo->first()->name }}</td>
                                        <td>{{ $course->phone }}</td>
                                        <td>{{ $course->email }} </td>
                                        <td>
                                            @if($course->courseType == 0)
                                               <b><span class="text-primary">Offline</span></b>
                                            @elseif ($course->courseType == 1)
                                                <b><span class="text-info">online</span></b>
                                            @endif
                                        </td>
                                        <td>
                                            @if($course->isActive == 0)
                                                <b><span class="text-warning">Waiting for Contact</span></b>
                                            @elseif ($course->isActive == 1)
                                                <b><span class="text-info">Call Not received</span></b>
                                            @elseif ($course->isActive == 2)
                                                <b><span class="text-success">Waiting For Admission</span></b>
                                            @elseif ($course->isActive == 3)
                                                <b><span class="text-primary">Admission Complete</span></b>
                                            @elseif ($course->isActive == 4)
                                            <b><span class="text-primary">SMS Send</span></b>
                                            @elseif ($course->isActive == 5)
                                                <b><span class="text-primary">Not Interested</span></b>
                                            @elseif ($course->isActive == 6)
                                                <b><span class="text-primary">Restricted</span></b>
                                            @endif 
                                        </td>
                                        <td>
                                            @php
                                            $createDate = date_format($course->created_at, 'd-M-Y');
                                            @endphp
                                            {{ $createDate }}
                                        </td>
                                        
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                {{-- <a href="{{ route('admin.courses.view', $course->id) }}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a> --}}
                                                <a href="{{ route('admin.admission.edit', $course->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                {{-- <a href="{{ route('admin.courses.delete', $course->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a> --}}
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
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable({order: [[1, 'desc']],});</script>
@endpush