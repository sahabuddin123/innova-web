@extends('admin.app')
 
@section('title') {{ $pageTitle }} @endsection
 
@section('content')
     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-users"></i> {{ $pageTitle }}</h1>
        </div>
        <div>
        <!-- <a href="{{ route('admin.students.create') }}" class="btn btn-primary pull-right">Add Students</a> -->
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
                                <th> Course Name </th>
                                <th> Total Pay </th>
                                <th> Total Due </th>
                                <th> Last Payment</th>
                                <th> Admission Date</th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        @php
                                        function time_elapsed_string($datetime, $full = false) {
                                            $now = new DateTime;
                                            $ago = new DateTime($datetime);
                                            $diff = $now->diff($ago);

                                            $diff->w = floor($diff->d / 7);
                                            $diff->d -= $diff->w * 7;

                                            $string = array(
                                                'y' => 'year',
                                                'm' => 'month',
                                                'w' => 'week',
                                                'd' => 'day',
                                                'h' => 'hour',
                                                'i' => 'minute',
                                                's' => 'second',
                                            );
                                            foreach ($string as $k => &$v) {
                                                if ($diff->$k) {
                                                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                                                } else {
                                                    unset($string[$k]);
                                                }
                                            }

                                            if (!$full) $string = array_slice($string, 0, 1);
                                            return $string ? implode(', ', $string) . ' ago' : 'just now';
                                        }
                                        @endphp
                        <tbody>
                            @foreach($students as $course)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td><img src="{!! asset('public/storage/'.$course->image) !!}" alt="!"  height="90"></td>
                                        <td>{{ $course->sname }} </td>
                                        <td>
                                        @php
                                        $batchno = DB::table('batchs')->where('id',$course->batch_id)->pluck('batchnum')->first();
                                        @endphp
                                        {{$batchno}}
                                        </td>
                                        <td>
                                        @php
                                        $coursename = DB::table('courses')->where('id',$course->course_id)->pluck('name')->first();
                                        @endphp
                                        {{$coursename}}
                                        </td>
                                        <td>
                                            @php
                                            $pay = DB::table('fees_transections')->where('student_id',$course->id)->sum('paidamount');
                                            @endphp
                                            {{number_format($pay,2)}}
                                        </td>
                                        <td>
                                            @php
                                            $due = $course->balance - $pay;
                                           @endphp
                                           {{number_format($due,2)}}
                                        </td>
                                        
                                        <td>
                                            @php
                                            $lastdate = DB::table('fees_transections')->where('student_id',$course->id)->pluck('paiddate')->take(1)->last();
                                           
                                            if(isset($lastdate)){
                                            $data =  time_elapsed_string($lastdate);
                                           }
                                           else{
                                            
                                            $data =  "No payments";
                                           }
                                            
                                            @endphp
                                           {{$data}}
                                        </td>
                                        
                                        <td>
                                        @php
                                            $date = strtotime($course->admission_date);
                                            $createDate = date('d-M-y', $date);
                                        @endphp
                                            {{ $createDate }}
                                    </td>
                                        
                                       
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                <a href="{{ route('admin.fees.create', $course->id) }}" class="btn btn-sm btn-info"><i class="fas fa-money-bill"></i></a>
                                                <a href="{{ route('admin.fees.view', $course->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-desktop"></i></a>
                                                <!-- <a href="{{ route('admin.students.view', $course->id) }}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a> -->
                                                <!-- <a href="{{ route('admin.students.edit', $course->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a> -->
                                                <!-- <a href="{{ route('admin.students.delete', $course->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a> -->
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