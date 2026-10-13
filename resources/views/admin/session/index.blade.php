@extends('admin.app')
 
@section('title') {{ $pageTitle }} @endsection
 
@section('content')
     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-calendar"></i> {{ $pageTitle }}</h1>
        </div>
        <div>
        <a href="{{ route('admin.session.create') }}" class="btn btn-primary pull-right">Add Session</a>
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
                                <th> Session Name </th>
                                <th> Start Date </th>
                                <th> End Date </th>
                                <th> Status </th>
                                <th> Create At </th>
                                <th> Last Update </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sessions as $course)
                                    <tr>
                                        <td>{{ $course->id }}</td>
                                        <td>{{ $course->sessionName }}</td>
                                        <td>
                                            @php
                                            $date = strtotime($course->startdate);
                                            $date = date("d-M-Y", $date);
                                            @endphp
                                            {{ $date }}
                                        </td>
                                        <td>
                                        @php
                                        $date = strtotime($course->enddate);
                                            $enddate = date("d-M-Y", $date);
                                         @endphp
                                         {{ $enddate}}
                                        </td>
                                        <td>
                                            @php
                                            if($course->IsActive == 0){
                                                $status = "<span class='text-warning'>Postponed</span>";
                                            }
                                            elseif($course->IsActive == 1){
                                                $status = "<span class='text-success'>Running</span>";
                                            }
                                            elseif($course->IsActive == 2){
                                                $status = "<span class='text-primary'>Upcomming</span>";
                                            }
                                            elseif($course->IsActive == 3){
                                                $status = "<span class='text-danger'>Complete</span>";
                                            }
                                            @endphp
                                            <b>{!! $status !!}</b>
                                        </td>
                                        <td>
                                        @php
                                            $date = strtotime($course->created_at);
                                            $createDate = date('d-M-Y h:i A', $date);
                                        @endphp
                                            {{ $createDate }}
                                    </td>
                                        <td>
                                        @php
                                            $date = strtotime($course->updated_at);
                                            $updateDate = date('d-M-Y h:i A', $date);
                                        @endphp    
                                        {{ $updateDate }}
                                    </td>
                                       
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                <a href="{{ route('admin.session.edit', $course->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                <a href="{{ route('admin.session.delete', $course->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
@endpush