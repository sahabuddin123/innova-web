@extends('admin.app')

@section('content')
<div class="container">
    <h1>Clients</h1>
    <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">Add Client</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Logo</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td><img src="{{ asset('storage/' . $client->logo) }}" alt="{{ $client->name }}" width="50"></td>
                    <td>{{ $client->is_active ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <a href="{{ route('admin.clients.edit', $client) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.clients.destroy', $client) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection