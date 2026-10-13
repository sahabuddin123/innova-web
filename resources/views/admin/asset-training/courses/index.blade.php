@extends('admin.app')

@section('title')
    {{ $pageTitle }}
@endsection

@section('content')
    @include('admin.partials.flash')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $pageTitle }}</h1>
        <a href="{{ route('admin.asset-training.courses.create') }}" class="btn btn-primary">Create Course</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="coursesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Level</th>
                            <th>Status</th>
                            <th>Registrations</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $course->name }}</td>
                                <td>{{ $course->level ?? 'N/A' }}</td>
                                <td>{!! $course->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' !!}</td>
                                <td>{{ $course->registrations()->count() }}</td>
                                <td>
                                    <a href="{{ route('admin.asset-training.courses.edit', $course->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.asset-training.courses.delete', $course->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this course?');">
                                        @csrf
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $courses->links() }}
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#coursesTable').DataTable({
            responsive: true,
            paging: false,
            searching: true,
            info: false,
            order: [[0, 'desc']],
        });
    });
</script>
@endpush
