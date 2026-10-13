@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-user"></i> {{ $pageTitle }}</h1>
    </div>
    @include('admin.partials.flash')
    <style type="text/css">
        #results { padding:20px; border:1px solid; background:#ccc; }
    </style>
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <form action="{{ route('admin.shareholder.update') }}" method="POST" role="form" enctype="multipart/form-data">
                <div class="tile-body">
                @csrf
                <input type="hidden" name="id" value="{{$target->id}}">
                <div class="form-group">
                    <label class="control-label" for="name">Share Holder or Investor Name <span class="m-l-5 text-danger"> *</span></label>
                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name', $target->name) }}"/>
                    @error('name') {{ $message }} @enderror
                </div>
                <div class="form-group">
                    <label class="control-label" for="designation">Share Holder or Investor Designation <span class="m-l-5 text-danger"> *</span></label>
                    <input class="form-control @error('designation') is-invalid @enderror" type="text" name="designation" id="designation" value="{{ old('designation', $target->designation) }}"/>
                    @error('designation') {{ $message }} @enderror
                </div>
                <div class="form-group">
                    <label class="control-label" for="email">Share Holder or Investor Email <span class="m-l-5 text-secondary"> (if any)</span></label>
                    <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email" value="{{ old('email', $target->email) }}"/>
                    @error('email') {{ $message }} @enderror
                </div>
                <div class="form-group">
                    <label class="control-label" for="phone">Share Holder or Investor Phone Number <span class="m-l-5 text-danger"> *</span></label>
                    <input class="form-control @error('phone') is-invalid @enderror" type="tel" name="phone" id="phone" placeholder="+880" value="{{ old('phone', $target->phone) }}"/>
                    @error('phone') {{ $message }} @enderror
                </div>
                <div class="form-group">
                    <label class="control-label" for="address">Share Holder or Investor Address <span class="m-l-5 text-danger"> *</span></label>
                    <textarea name="address" id="address" cols="30" rows="10" class="form-control @error('address') is-invalid @enderror">{{ old('address', $target->address) }}</textarea>
                    @error('address') {{ $message }} @enderror
                </div>
                <div class="form-group">
                    <label class="control-label" for="shareType">Investment Type <span class="m-l-5 text-danger"> *</span></label>
                    <select  class="form-control @error('shareType') is-invalid @enderror" name="shareType" id="shareType">
                    <option value="">--Select--</option>
                        <option value="1" @if(old('shareType', $target->shareType) == 1) {{"selected"}} @endif>Shareholder</option>
                        <option value="2" @if(old('shareType', $target->shareType) == 2) {{"selected"}} @endif>Investor</option>
                        <option value="3" @if(old('shareType', $target->shareType) == 3) {{"selected"}} @endif>Owner</option>
                    </select>
                    @error('shareType') {{ $message }} @enderror
                </div>
                <div class="form-group" id="image-area">
                    <label class="control-label" for="image-tag">Share Holder or Investor Image <span class="m-l-5 text-danger"> *</span></label>
                    <input class="form-control @error('image') is-invalid @enderror image-tag" type="file" name="image" id="image-tag" value="{{ old('image', $target->image) }}"/>
                    @error('image') {{ $message }} @enderror
                </div>
                @if($target->image!=null)
                    <img src="{{ asset('public/storage/'.$target->image)}}" alt="!" height="182.4">
                @endif
                <input type="hidden" name="oldimage" value="{{$target->image}}">
                <div class="form-group" id="image-area">
                    <label class="control-label" for="nid-tag">Passport / NID <span class="m-l-5 text-danger"> *</span></label>
                    <input class="form-control @error('nid') is-invalid @enderror image-tag" type="file" name="nid" id="nid-tag" value="{{ old('nid', $target->nid) }}"/>
                    @error('nid') {{ $message }} @enderror
                </div>
                @if($target->nid!=null)
                    <img src="{{ asset('public/storage/'.$target->nid)}}" alt="!" height="182.4">
                @endif
                <input type="hidden" name="oldnid" value="{{$target->nid}}">

                <div class="form-group">
                    <label class="control-label" for="isActive">Status <span class="m-l-5 text-danger"> *</span></label>
                    <select  class="form-control @error('isActive') is-invalid @enderror" name="isActive" id="isActive">
                        <option value="">--Select--</option>
                        <option value="1" @if(old('isActive', $target->isActive) == 1) {{"selected"}} @endif>Active</option>
                        <option value="2" @if(old('isActive', $target->isActive) == 2) {{"selected"}} @endif>Pending</option>
                        <option value="0" @if(old('isActive', $target->isActive) == 0) {{"selected"}} @endif>Deactive</option>
                        <option value="3" @if(old('isActive', $target->isActive) == 3) {{"selected"}} @endif>Postponded</option>
                    </select>
                    @error('isActive') {{ $message }} @enderror
                </div>
                </div>
                <div class="tile-footer">
                    <button class="btn btn-primary" type="submit" id="submitform"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Info</button>
                        &nbsp;&nbsp;&nbsp;
                    <a class="btn btn-secondary" href="{{ route('admin.shareholder.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts') 

@endpush