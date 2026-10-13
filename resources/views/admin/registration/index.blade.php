@extends('admin.app')
 
@section('title') {{ $pageTitle }} @endsection
 
@section('content')
     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-users"></i> {{ $pageTitle }}</h1>
        </div>
        <div>
        {{-- <a href="{{ route('admin.students.create') }}" class="btn btn-primary pull-right">Add Students</a> --}}
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
                                <th> Image </th>
                                <th> Students name </th>
                                <th> Batch No </th>
                                <th> Technical Board Session  </th>
                                <th> Registration Date  </th>
                                <th> Status </th>
                                <th> Last Update </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                          
                            
                          @foreach($registration as $course)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td><img src="{!! asset('public/storage/'.$course->StudentsInfo->image) !!}" alt="!"  height="90"></td>
                                        <td>{{ $course->StudentsInfo->sname }} </td>
                                        <td>
                                        @php
                                        $batchno = DB::table('batchs')->where('id',$course->StudentsInfo->batch_id)->pluck('batchnum')->first();
                                        @endphp
                                        {{$batchno}}
                                        </td>
                                        <td>
                                            {{$course->StudentsSessions->sessionName}}
                                        </td>
                                        <td>
                                            @php
                                                $date = strtotime($course->regDate);
                                                $createDate = date('d-M-y', $date);
                                            @endphp
                                                {{ $createDate }}
                                        </td>
                                        <td>
                                            @php
                                            if($course->IsActive == 1){
                                                $status = "<span class='text-success'>Complete</span>";
                                            }
                                            elseif($course->IsActive == 2){
                                                $status = "<span class='text-info'>Waiting For Payments</span>";
                                            }
                                            elseif($course->IsActive == 3){
                                                $status = "<span class='text-warning'>Postponded</span>";
                                            }
                                            elseif($course->IsActive == 4){
                                                $status = "<span class='text-danger'>Restricted</span>";
                                            }
                                            @endphp
                                            <b>{!! $status !!}</b>
                                        </td>
                                        
                                        <td>
                                        @php
                                            $date = strtotime($course->updated_at);
                                            $updateDate = date('d-M-y h:s a', $date);
                                        @endphp    
                                        {{ $updateDate }}
                                    </td>
                                       
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                <a href="{{ route('admin.registration.view', $course->id) }}" class="btn btn-sm btn-info" title="View Student"><i class="fa fa-eye"></i></a>
                                                {{-- @if($course->IsRegister == 1)
                                                <a href="{{ route('admin.registration.create', $course->id) }}" class="btn btn-sm btn-warning text-danger" title="Make Registration"><i class="fa fa-certificate"></i></a>
                                                @endif --}}
                                                <a href="{{ route('admin.registration.edit', $course->id) }}" class="btn btn-sm btn-primary" title="Edit Student Information"><i class="fa fa-edit"></i></a>
                                               @php
                                               $deleteData = ['id' => $course->id, 'student_id' => $course->student_id]
                                               @endphp
                                                <a href="{{ route('admin.registration.delete', $deleteData) }}" class="btn btn-sm btn-danger" title="Delete Student Information"><i class="fa fa-trash"></i></a>
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