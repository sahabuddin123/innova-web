@extends('admin.app')

@section('title')
    {{ $pageTitle }}
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-certificate"></i> {{ $pageTitle }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body overflow-auto">
                    <table class="table table-bordered table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Image</th>
                                <th>Student Name</th>
                                <th>Batch No</th>
                                <th>Certificate No</th>
                                <th>Issue Date</th>
                                <th>Receiver</th>
                                <th>Delivery Date</th>
                                <th>Status</th>
                                <th>Last Update</th>
                                <th style="width:100px;" class="text-center text-danger"><i class="fa fa-bolt"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($certificates as $course)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ asset('public/storage/' . $course->student->image) }}" 
                                             alt="Student" height="60">
                                    </td>
                                    <td>{{ $course->student->sname }}</td>
                                    <td>
                                        @php
                                            $batchno = DB::table('batchs')
                                                ->where('id', $course->batch_id)
                                                ->pluck('batchnum')
                                                ->first();
                                        @endphp
                                        {{ $batchno }}
                                    </td>
                                    <td>{{ $course->certificate_no }}</td>
                                    <td>{{ $course->issue_date ? date('d-M-Y', strtotime($course->issue_date)) : '-' }}</td>
                                    <td>{{ $course->certificate_receiver ?? '-' }}</td>
                                    <td>{{ $course->delivery_date ? date('d-M-Y', strtotime($course->delivery_date)) : '-' }}</td>
                                    <td>
                                        @php
                                            $status = '';
                                            if ($course->is_active == 1) {
                                                $status = "<span class='badge badge-success'>Delivered</span>";
                                            } elseif ($course->is_active == 2) {
                                                $status = "<span class='badge badge-info'>Waiting</span>";
                                            } elseif ($course->is_active == 3) {
                                                $status = "<span class='badge badge-warning'>Printing Queue</span>";
                                            } elseif ($course->is_active == 4) {
                                                $status = "<span class='badge badge-danger'>Cancelled</span>";
                                            }
                                        @endphp
                                        {!! $status !!}
                                    </td>
                                    <td>{{ date('d-M-y h:i a', strtotime($course->updated_at)) }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.certificate_icbd.view', $course->id) }}"
                                               class="btn btn-sm btn-info" title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.certificate_icbd.edit', $course->id) }}"
                                               class="btn btn-sm btn-primary" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @php
                                                $deleteData = [
                                                    'id' => $course->id,
                                                    'student_id' => $course->student_id,
                                                ];
                                            @endphp
                                            <a href="{{ route('admin.certificate_icbd.delete', $deleteData) }}"
                                               class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </a>
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
    <script type="text/javascript">
        $('#sampleTable').DataTable({
            order: [[0, 'asc']],
        });
    </script>
@endpush
