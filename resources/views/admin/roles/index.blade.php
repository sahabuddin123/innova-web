@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-users"></i> {{ $pageTitle }}</h1>
    <div class="pull-right">
        @can('role-create')
            <a class="btn btn-success" href="{{ route('admin.roles.create') }}"> Create New Role</a>
        @endcan
    </div>
</div>
{{-- Flash Msg --}}
@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="tile">
<table class="table table-bordered">
  <tr>
     <th width="5%">SL.</th>
     <th width="65%">Role Name</th>
     <th width="30%">Action</th>
  </tr>
    @foreach ($roles as $key => $role)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $role->name }}</td>
        <td>
            <a class="btn btn-info" href="{{ route('admin.roles.show',$role->id) }}">Show</a>
            @can('role-edit')
                <a class="btn btn-primary" href="{{ route('admin.roles.edit',$role->id) }}">Edit</a>
            @endcan
            @can('role-delete')
                {!! Form::open(['method' => 'DELETE','route' => ['admin.roles.destroy', $role->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
            @endcan
        </td>
    </tr>
    @endforeach
</table>
        

{!! $roles->render() !!}
</div>
</div>
</div>
@endsection
@push('scripts') 

@endpush