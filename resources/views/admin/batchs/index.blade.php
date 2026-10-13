@extends('admin.app')
 
@section('title') {{ $pageTitle }} @endsection
 
@section('content')
     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-users"></i> {{ $pageTitle }}</h1>
        </div>
        <div>
        <a href="{{ route('admin.batchs.create') }}" class="btn btn-primary pull-right">Add Batchs</a>
        </div>
    </div>
    <div id="flash_message"></div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body overflow-auto">
                    <table class="table table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Batch Name </th>
                                <th> Total Seat </th>
                                <th> Start Date </th>
                                <th> End Date </th>
                                
                                <th> Status </th>
                                <th> Create At </th>
                                <th> Last Update </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($batchs as $course)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $course->batchnum }}</td>
                                        <td>{{ $course->totalseat }} </td>
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
                                                $status = "<span class='text-danger'>Postponed</span>";
                                            }
                                            elseif($course->IsActive == 1){
                                                $status = "<span class='text-success'>Running</span>";
                                            }
                                            elseif($course->IsActive == 2){
                                                $status = "<span class='text-info'>Upcomming</span>";
                                            }
                                            elseif($course->IsActive == 3){
                                                $status = "<span class='text-primary'>Complete</span>";
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
                                                @if($course->IsActive != 2)
                                                 <a href="{{ route('admin.batchs.view', $course->id) }}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a> 
                                                @endif
                                                <a href="{{ route('admin.batchs.edit', $course->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                <a href="{{ route('admin.batchs.delete', $course->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                                <div class="dropdown">
                                                    <a href="#" class="btn btn-sm btn-primary dropdown-toggle" id="sms-menu" data-toggle="dropdown"><i class="fas fa-envelope"></i> </a>
                                                    <div class="dropdown-menu" aria-labelledby="#sms-menu">
                                                        <a href="javascript:void(0)" id="groupDuesms" data-id="{{ $course->id }}" value="{{ $course->id }}" class="dropdown-item" title="Send Due SMS">Due Remainder</a>
                                                        <a href="javascript:void(0)" id="grouptodayremainder" data-id="{{ $course->id }}" value="{{ $course->id }}" class="dropdown-item" title="Class Remainder">Today Class Remainder</a>
                                                        <a href="javascript:void(0)" id="groupnewschedule" data-id="{{ $course->id }}" value="{{ $course->id }}" class="dropdown-item" title="New Class Schedule">New Schedule Remainder</a>
                                                        <a href="javascript:void(0)" id="groupTodayPostpond" data-id="{{ $course->id }}" value="{{ $course->id }}" class="dropdown-item" title="Today Class Postponded">Today Postpond Remainder</a>
                                                        <a href="javascript:void(0)" id="groupTomorrowPostpond" data-id="{{ $course->id }}" value="{{ $course->id }}" class="dropdown-item" title="Tomorrow Class Postponded">Tomorrow Postpond Remainder</a> 
                                                    </div>
                                                </div>
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
<script type="text/javascript" src="{{ asset('backend/js/custom.js') }}"></script> 
    <script type="text/javascript" src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable({order: [[0, 'desc']],});</script>
@endpush