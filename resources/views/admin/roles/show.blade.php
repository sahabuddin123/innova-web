@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-users"></i> {{ $pageTitle }}</h1>
    <div class="pull-right">
        <a class="btn btn-primary" href="{{ route('admin.roles.index') }}"> Back</a>
    </div>
</div>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="tile">
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Roles Name:</strong>
            {{ $role->name }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Permissions:</strong>
            @if(!empty($rolePermissions))
                @foreach($rolePermissions as $v)
                    <label class="badge badge-primary">{{ $v->name }}</label>
                @endforeach
            @endif
        </div>
    </div>
</div>
        </div></div></div>  
@endsection
@push('scripts') 

@endpush