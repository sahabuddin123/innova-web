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
                <form action="{{ route('admin.seminorreg.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="seminor_id">Course <span class="m-l-5 text-danger"> *</span></label>
                            <select  class="form-control @error('seminor_id') is-invalid @enderror" name="seminor_id" id="seminor_id">
                            <option value="">--Select--</option>
                            @foreach($seminor as $item)
                                <option value="{{$item->id}}" @if(old('seminor_id') == $item->id) {{"selected"}} @endif>{{$item->title}}</option>
                            @endforeach
                            </select>
                            @error('seminor_id') {{ $message }} @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="username">Studen Full Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('username') is-invalid @enderror" type="text" name="username" id="username" value="{{ old('username') }}"/>
                            @error('username') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="phone">Student Phone Number</label>
                            <input class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" id="phone" value="{{ old('phone') }}"/>
                            @error('phone') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="email">Student Email Address </label>
                            <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email" value="{{ old('email') }}"/>
                            @error('email') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="profession">Student profession </label>
                            <input class="form-control @error('profession') is-invalid @enderror" type="text" name="profession" id="profession" value="{{ old('profession') }}"/>
                            @error('profession') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="address">Student Address </label>
                            <input class="form-control @error('address') is-invalid @enderror" type="text" name="address" id="address" value="{{ old('address') }}"/>
                            @error('address') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="isCall">Has the student been called?<span class="m-l-5 text-danger"> *</span></label>
                            <select  class="form-control @error('type') is-invalid @enderror"name="isCall" id="isCall">
                                <option value="">--Select--</option>
                                <option value="0" @if(old('isCall') == 0) {{"selected"}} @endif>No</option>
                                <option value="1" @if(old('isCall') == 1) {{"selected"}} @endif>Yes</option>
                            </select>
                            @error('isCall') {{ $message }} @enderror
                        </div> 
                        <div class="form-group">
                            <label class="control-label" for="isAttand">Has the student participated in the seminar?<span class="m-l-5 text-danger"> *</span></label>
                            <select  class="form-control @error('type') is-invalid @enderror"name="isAttand" id="isAttand">
                                <option value="">--Select--</option>
                                <option value="0" @if(old('isAttand') == 0) {{"selected"}} @endif>No</option>
                                <option value="1" @if(old('isAttand') == 1) {{"selected"}} @endif>Yes</option>
                            </select>
                            @error('isAttand') {{ $message }} @enderror
                        </div> 
                        <div class="form-group">
                            <label class="control-label" for="isConvance">Has the student agreed to enroll in the course?<span class="m-l-5 text-danger"> *</span></label>
                            <select  class="form-control @error('type') is-invalid @enderror"name="isConvance" id="isConvance">
                                <option value="">--Select--</option>
                                <option value="0" @if(old('isConvance') == 0) {{"selected"}} @endif>No</option>
                                <option value="1" @if(old('isConvance') == 1) {{"selected"}} @endif>Yes</option>
                            </select>
                            @error('isConvance') {{ $message }} @enderror
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
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Seminor Registration</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.seminorreg.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')

@endpush