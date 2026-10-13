@extends('admin.app')
@section('content')
<div class="container">
    <h1>Edit Technology</h1>
    <form action="{{ route('admin.technologies.update', $technology) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $technology->name) }}" required>
        </div>
        <div class="form-group">
            <label for="icon">Icon</label>
            <input type="file" name="icon" id="icon" class="form-control">
            <img src="{{ asset('storage/' . $technology->icon) }}" alt="{{ $technology->name }}" width="60">
        </div>
        <div class="form-group">
            <label for="is_active">Status</label>
            <select name="is_active" id="is_active" class="form-control">
                <option value="1" {{ $technology->is_active ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$technology->is_active ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection