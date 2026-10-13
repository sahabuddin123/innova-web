@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Workflow Details</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <td>{{ $workflow->id }}</td>
                    </tr>
                    <tr>
                        <th>Step</th>
                        <td>{{ $workflow->step }}</td>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td>{{ $workflow->title }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $workflow->description }}</td>
                    </tr>
                    <tr>
                        <th>Icon</th>
                        <td>{{ $workflow->icon }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($workflow->status == 1)
                            <span class="badge badge-success">Active</span>
                            @else
                            <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $workflow->created_at->format('d M Y') }}</td>
                    </tr>
                </table>
                <a href="{{ route('admin.workflows.index') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('admin.workflows.edit', $workflow->id) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>
    </div>
@endsection