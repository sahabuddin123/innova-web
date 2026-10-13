@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<link rel="stylesheet" href="{{asset('./backend/vendor/bootstrap/select2.min.css')}}">
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-users"></i> {{ $pageTitle }}</h1>
    <div class="pull-right">
        <a class="btn btn-primary" href="{{ route('admin.users.index') }}"> Back</a>
    </div>
</div>
{{-- Flash Msg --}}
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

{{-- Form --}}
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="tile">
            <h3 class="tile-title">{{ $subTitle }}</h3>
{!! Form::open(array('route' => 'admin.users.store','method'=>'POST')) !!}
<div class="row">
    {{-- <div class="col-xs-12 col-sm-12 col-md-12"> --}}
        {{-- <div class="form-group"> --}}
            {{-- <strong>Name:</strong> --}}
            <input type="hidden" name="name" value="">
            {{-- {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!} --}}
        {{-- </div> --}}
    {{-- </div> --}}
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email:</strong>
            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Password:</strong>
            {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Confirm Password:</strong>
            {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Select Student:</strong>
            {{-- {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!} --}}
            <select name="student_id" id="social_icon" class="form-control js-example-templating">
                @foreach ($student as $students)
                    @php
                        $user = DB::table('users')->where('id', $students->user_id)->first();
                    @endphp
                    @if($user == null)
                    <option value="{{$students->id}}" class="{!! asset('public/storage/'.$students->image) !!}">{{$students->sname}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
{!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="{{asset('/backend/vendor/jquery/select2.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            $("#social_icon").select2({
                templateResult: formatOptions
            });
        });
        function formatOptions (state) 
        {
            if (!state.id) { return state.text; }
            if(state.element.className == "{{asset('public/storage/')}}"){
                var $state = $(
                    '<span >'+ state.text + '</span>'
                );
            }
            else{
                var $state = $(
                    '<span ><img sytle="display: inline-block;" src="'+state.element.className+'" height="50"  /> ' + state.text + '</span>'
                );
            }
            
            return $state;
        }
    </script>
@endpush