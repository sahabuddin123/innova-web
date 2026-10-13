@extends('admin.app')
@section('content')
<div class="container">
    <h1>Technologies</h1>
    <a href="{{ route('admin.technologies.create') }}" class="btn btn-primary mb-3">Add Technology</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Icon</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($technologies as $technology)
                <tr>
                    <td>{{ $technology->name }}</td>
                    <td><img src="{{ asset('storage/' . $technology->icon) }}" alt="{{ $technology->name }}" width="40"></td>
                    <td>{{ $technology->is_active ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <a href="{{ route('admin.technologies.edit', $technology) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.technologies.destroy', $technology) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection