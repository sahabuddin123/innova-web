@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-book"></i> {{ $pageTitle }}</h1>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <form action="{{ route('admin.seminor.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="course_id">Course <span class="m-l-5 text-danger"> *</span></label>
                            <select  class="form-control @error('course_id') is-invalid @enderror" name="course_id" id="course_id">
                            <option value="">--Select--</option>
                            @foreach($course as $item)
                                <option value="{{$item->id}}" @if(old('course_id') == $item->id) {{"selected"}} @endif>{{$item->name}}</option>
                            @endforeach
                            </select>
                            @error('course_id') {{ $message }} @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="title">Seminor Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title') }}"/>
                            @error('title') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="address">Seminor Location / Online Seminor Link</label>
                            <input class="form-control @error('address') is-invalid @enderror" type="text" name="address" id="address" value="{{ old('address') }}"/>
                            @error('address') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="time">Seminor Time </label>
                            <input class="form-control @error('time') is-invalid @enderror" type="time" name="time" id="time" value="{{ old('time') }}"/>
                            @error('time') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="date">Seminor Date </label>
                            <input class="form-control @error('date') is-invalid @enderror" type="date" name="date" id="date" value="{{ old('date') }}"/>
                            @error('date') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="type">Seminor type<span class="m-l-5 text-danger"> *</span></label>
                            <select  class="form-control @error('type') is-invalid @enderror"name="type" id="type">
                                <option value="">--Select--</option>
                                <option value="0" @if(old('type') == 0) {{"selected"}} @endif>Offline</option>
                                <option value="1" @if(old('type') == 1) {{"selected"}} @endif>Online</option>
                            </select>
                            @error('type') {{ $message }} @enderror
                        </div> 
                        <div class="form-group">
                            <label class="control-label" for="IsActive">Status<span class="m-l-5 text-danger"> *</span></label>
                            <select  class="form-control @error('IsActive') is-invalid @enderror"name="IsActive" id="IsActive">
                                <option value="">--Select--</option>
                                <option value="0" @if(old('IsActive') == 0) {{"selected"}} @endif>Deactive</option>
                                <option value="1" @if(old('IsActive') == 1) {{"selected"}} @endif>Active</option>
                            </select>
                            @error('IsActive') {{ $message }} @enderror
                        </div> 
                        <div class="form-group">
                            <label class="control-label">Image</label>
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                            @error('image') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Seminor</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.seminor.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')

@endpush