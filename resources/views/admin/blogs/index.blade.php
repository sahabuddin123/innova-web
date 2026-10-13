@extends('admin.app')
 
@section('title') {{ $pageTitle }} @endsection
 
@section('content')
     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-book-open"></i> {{ $pageTitle }}</h1>
        </div>
        <div>
        <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary pull-right">Add Blogs</a>
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
                                <th> Featured Image </th>
                                <th> Heading </th>
                                {{-- <th> Course Durations </th> --}}
                                {{-- <th> Total Moduls </th> --}}
                                {{-- <th> Course Fee </th> --}}
                                <th> Create At </th>
                                <th> Last Update </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($blogs as $course)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td><img src="{!! asset('public/storage/'.$course->image) !!}" alt="!"  height="50"></td>
                                        <td>{{ $course->heading }}</td>
                                        {{-- <td>{{ $course->courseduration }} Months</td> --}}
                                        {{-- <td>{{ $course->totalmoduls }}</td> --}}
                                        {{-- <td>{{ $course->coursefee }} {{ config('settings.currency_code') }}</td> --}}
                                        <td>
                                            @php
                                            $createDate = date_format($course->created_at, 'd-M-Y');
                                            @endphp
                                            {{ $createDate }}
                                        </td>
                                        <td>
                                        @php
                                            $updateDate = date_format($course->updated_at, 'd-M-Y');
                                            @endphp
                                            {{ $updateDate }}
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                <a href="{{ route('admin.blogs.view', $course->id) }}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                                <a href="{{ route('admin.blogs.edit', $course->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                <a href="{{ route('admin.blogs.delete', $course->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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