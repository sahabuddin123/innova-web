@extends('frontend.app')
 
@section('title') {{ $pageTitle }} @endsection
 
@section('content')

     
    <!-- page title -->

  <!-- /page title -->
    @include('admin.partials.flash')
    <section class="section mt-5">
        <div class="container mt-5">
            <div class="card">
                <div class="card-body">
                
    <div class="row">
        <div class="col-md-12">
            <div class="tile overflow-auto">
                <div class="tile-body">
                    <table class="table table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Image </th>
                                <th> Students Name </th>
                                <th> Religion </th>
                                <th> Exam Name </th>
                                <th> Exam Year </th>
                                <th> Exam board </th>
                                <th> Exam Roll </th>
                                <th> BTEB Registration Date  </th>
                                <th> Status </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          
                          @foreach($registration as $course)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td><a href="{!! asset('public/storage/'.$course->StudentsInfo->image) !!}" download><img src="{!! asset('public/storage/'.$course->StudentsInfo->image) !!}" alt="!"  height="90"></a></td>
                                        <td>{{ $course->StudentsInfo->sname }} </td>
                                        <td>
                                            @php
                                            if($course->StudentsInfo->religion == 1){
                                            $religion = "Islam";}
                                            else if($course->StudentsInfo->religion == 2){
                                            $religion = "Hindhu";}
                                            else if($course->StudentsInfo->religion == 3){
                                            $religion = "Bhudist";}
                                            else if($course->StudentsInfo->religion == 4){
                                            $religion = "Christian";}
                                            @endphp
                                            {{$religion}}
                                    </td>
                                     
                                       
                                        <td>
                                            @if($course->ExamName == 1)
                                            <b class="text-success">{{"JSC"}}</b>
                                            @elseif($course->ExamName == 2)
                                            <b class="text-success">{{"JDC"}}</b>
                                            @elseif($course->ExamName == 3)
                                            <b class="text-primary">{{"SSC"}}</b>
                                            @elseif($course->ExamName == 4)
                                            <b class="text-primary">{{"Dakhil"}}</b>
                                            @endif
                                        </td>
                                        <td>
                                            {{$course->PassYear}}
                                        </td>
                                        <td>
                                            @if($course->ExamBoard == 1)
                                            <b class="text-success">Barisal</b>
                                            @elseif($course->ExamBoard == 2)
                                            <b class="text-success">Chittagong</b>
                                            @elseif($course->ExamBoard == 3)
                                            <b class="text-primary">Comilla</b>
                                            @elseif($course->ExamBoard == 4)
                                            <b class="text-primary">Dhaka</b>
                                            @elseif($course->ExamBoard == 5)
                                            <b class="text-success">Dinajpur</b>
                                            @elseif($course->ExamBoard == 6)
                                            <b class="text-primary">Jessore</b>
                                            @elseif($course->ExamBoard == 7)
                                            <b class="text-primary">Mymensingh</b>
                                            @elseif($course->ExamBoard == 8)
                                            <b class="text-success">Rajshahi</b>
                                            @elseif($course->ExamBoard == 9)
                                            <b class="text-primary">Sylhet</b>
                                            @elseif($course->ExamBoard == 10)
                                            <b class="text-primary">Madrasah</b>
                                            @elseif($course->ExamBoard == 11)
                                            <b class="text-success">Technical</b>
                                            @elseif($course->ExamBoard == 12)
                                            <b class="text-primary">DIBS(Dhaka)</b>
                                            @endif
                                           
                                        </td>
                                        <td>
                                            {{$course->ExamRoll}}
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
                                     
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                <a href="{{ route('frontend.registration.view', $course->id) }}" class="btn btn-sm btn-info" title="View Student">View</a>
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
    
</div>
</div>
    </section>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
@endpush