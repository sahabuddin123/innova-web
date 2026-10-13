@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-calendar"></i> {{ $pageTitle }}</h1>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <form action="{{ route('admin.session.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="sessionName">Session Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('sessionName') is-invalid @enderror" type="text" name="sessionName" id="sessionName" value="{{ old('sessionName') }}"/>
                            @error('sessionName') {{ $message }} @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="startdate">Session Start Date <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('startdate') is-invalid @enderror" type="date" name="startdate" id="startdate" value="{{ old('startdate') }}"/>
                            @error('startdate') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="enddate">Session End Date </label>
                            <input class="form-control @error('enddate') is-invalid @enderror" type="date" name="enddate" id="enddate" value="{{ old('enddate') }}"/>
                            @error('enddate') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="IsActive">Session Status </label>
                            <select  class="form-control @error('IsActive') is-invalid @enderror"name="IsActive" id="IsActive">
                                <option value="1">Running</option>
                                <option value="2">Upcomming</option>
                                <option value="3">Complete</option>
                                <option value="0">Postponed</option>
                            </select>
                            @error('IsActive') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Session</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.session.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts') 

@endpush