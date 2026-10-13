@extends('admin.app')
@section('content')
<div class="container">
    <h1>Edit Client</h1>

    <form action="{{ route('admin.clients.update', $client) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $client->name) }}" required>
        </div>

        <div class="form-group">
            <label for="logo">Logo</label>
            <input type="file" name="logo" id="logo" class="form-control">
            <img src="{{ asset('storage/' . $client->logo) }}" alt="{{ $client->name }}" width="100">
        </div>

        <div class="form-group">
            <label for="is_active">Status</label>
            <select name="is_active" id="is_active" class="form-control">
                <option value="1" {{ $client->is_active ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$client->is_active ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection