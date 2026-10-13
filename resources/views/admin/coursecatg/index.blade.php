@extends('admin.app')

@section('title')
    {{ $pageTitle }}
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="far fa-money-bill-alt"></i> {{ $pageTitle }}</h1>
        </div>
        <div>
            <a href="{{ route('admin.coursecatg.create') }}" class="btn btn-primary pull-right">Add Course Categoris</a>
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
                                <th> Categoris Name </th>
                                <th> Status </th>
                                <th> Create At </th>
                                <th> Last Update </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i
                                        class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $course)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $course->CourseCategoris }}</td>
                                    
                                    <td>
                                        @php
                                            if ($course->IsActive == 0) {
                                                $status = "<span class='text-danger'>Deactive</span>";
                                            } elseif ($course->IsActive == 1) {
                                                $status = "<span class='text-success'>Active</span>";
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
                                            <a href="{{ route('admin.coursecatg.edit', $course->id) }}"
                                                class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('admin.coursecatg.delete', $course->id) }}"
                                                class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
            order: [
                [0, 'desc']
            ],
        });
    </script>
@endpush
