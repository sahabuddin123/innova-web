@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-boxes"></i> {{ $pageTitle }}</h1>
        <a href="{{ route('admin.assets.create') }}" class="btn btn-primary">Add ASSET Item</a>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body overflow-auto">
                    <table class="table table-bordered text-center" id="sampleTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Level</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th style="width:130px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assets as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->level }}</td>
                                    <td>
                                        @if($item->IsActive == 1)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->created_at ? $item->created_at->format('d-M-Y') : '' }}</td>
                                    <td>
                                        <a href="{{ route('admin.assets.edit', $item->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('admin.assets.delete', $item->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
        $('#sampleTable').DataTable({ order: [[0, 'desc']] });
    </script>
@endpush
