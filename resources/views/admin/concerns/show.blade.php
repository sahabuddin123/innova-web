@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Concern Details</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <td>{{ $concern->id }}</td>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td>{{ $concern->title }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $concern->description }}</td>
                    </tr>
                    <tr>
                        <th>Icon</th>
                        <td>{{ $concern->icon }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($concern->status == 1)
                            <span class="badge badge-success">Active</span>
                            @else
                            <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $concern->created_at->format('d M Y') }}</td>
                    </tr>
                </table>
                <a href="{{ route('admin.concerns.index') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('admin.concerns.edit', $concern->id) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>
    </div>
@endsection