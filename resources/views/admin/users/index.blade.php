@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-users"></i> {{ $subTitle }}</h1>
  <div class="pull-right">
      @can('role-create')
      <a class="btn btn-success" href="{{ route('admin.users.create') }}"> Create New User</a>
      @endcan
  </div>
</div>

@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif

<div class="row">
  <div class="col-md-12 mx-auto">
      <div class="tile">
<table class="table table-bordered">
 <tr>
   <th>No</th>
   <th> Image </th>
   <th>Name</th>
   <th>Email</th>
   {{-- <th>Roles</th> --}}
   <th width="280px">Action</th>
 </tr>
 @foreach ($data as $key => $user)
  <tr>
    <td>{{ ++$i }}</td>
    @php
        $student = DB::table('students')->where('user_id', $user->id)->first();
    @endphp
    <td>
      @if($student->image != "")
      <div class="popup-gallery">
          <a href="{!! asset('public/storage/'.$student->image) !!}" title="{{ $student->sname }}">
              <img src="{!! asset('public/storage/'.$student->image) !!}" alt="!"  height="70">
          </a>
      </div>
      @else
          no image
      @endif
  </td>
    <td>
      
      {{ $student->sname }}
    </td>
    <td>{{ $user->email }}</td>
    {{-- <td> --}}
      {{-- @if(!empty($user->getRoleNames()))
        @foreach($user->getRoleNames() as $v)
           <label class="badge badge-success">{{ $v }}</label>
        @endforeach
      @endif --}}
    {{-- </td> --}}
    <td>
       <a class="btn btn-info" href="{{ route('admin.users.show',$user->id) }}">Show</a>
       <a class="btn btn-primary" href="{{ route('admin.users.edit',$user->id) }}">Edit</a>
        {{-- {!! Form::open(['method' => 'DELETE','route' => ['admin.users.destroy', $user->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!} --}}
    </td>
  </tr>
 @endforeach
</table>


{!! $data->render() !!}
      </div>
  </div>
</div>
@endsection