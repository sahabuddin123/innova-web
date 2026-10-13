@extends('admin.app')
{{-- @section('title') {{ $pageTitle }} @endsection --}}
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-users"></i> {{ $pageTitle }}</h1>
    <div class="pull-right">
        <a class="btn btn-primary" href="{{ route('admin.admins.index') }}"> Back</a>
    </div>
</div>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="tile">
        <div class="form-group">
            <strong>Name:</strong>
            {{ $user->name }}
        </div>
        <div class="form-group">
            <strong>Email:</strong>
            {{ $user->email }}
        </div>
        <div class="form-group">
            <strong>Roles:</strong>
            @if(!empty($user->getRoleNames()))
                @foreach($user->getRoleNames() as $v)
                    <label class="badge badge-success">{{ $v }}</label>
                @endforeach
            @endif
        </div>
    </div>
</div>
</div>
@endsection