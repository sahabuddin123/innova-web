@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Product Details</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <td>{{ $product->id }}</td>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td>{{ $product->title }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $product->description }}</td>
                    </tr>
                    <tr>
                        <th>Icon</th>
                        <td>{{ $product->icon }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($product->status == 1)
                            <span class="badge badge-success">Active</span>
                            @else
                            <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $product->created_at->format('d M Y') }}</td>
                    </tr>
                </table>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>
    </div>
@endsection