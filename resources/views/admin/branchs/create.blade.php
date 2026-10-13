@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="far fa-money-bill-alt"></i> {{ $pageTitle }}</h1>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <form action="{{ route('admin.branch.store') }}" method="POST" role="form">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group"> 
                            <label class="control-label" for="bname">Branch Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('bname') is-invalid @enderror" type="text" name="bname" id="bname" value="{{ old('bname') }}"/>
                            @error('bname') {{ $message }} @enderror
                        </div>
                        <div class="form-group"> 
                            <label class="control-label" for="baddress">Branch Address <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('baddress') is-invalid @enderror" type="text" name="baddress" id="baddress" value="{{ old('baddress') }}"/>
                            @error('baddress') {{ $message }} @enderror
                        </div>
                        <div class="form-group"> 
                            <label class="control-label" for="startdate">Branch Start Date <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('startdate') is-invalid @enderror" type="date" name="startdate" id="startdate" value="{{ old('startdate') }}"/>
                            @error('startdate') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="btype">Branch Type </label>
                            <select  class="form-control @error('btype') is-invalid @enderror"name="btype" id="btype">
                                <option value="1" @if(old('btype') == 1) {{ "selected" }} @endif>Training Center</option>
                                <option value="2" @if(old('btype') == 2) {{ "selected" }} @endif>Shop</option>
                            </select>
                            @error('btype') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="IsActive">Is Active </label>
                            <select  class="form-control @error('IsActive') is-invalid @enderror"name="IsActive" id="IsActive">
                                <option value="1" @if(old('IsActive') == 1) {{ "selected" }} @endif>Active</option>
                                <option value="0" @if(old('IsActive') == 0) {{ "selected" }} @endif>Deactive</option>
                            </select>
                            @error('IsActive') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Branch</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.branch.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form> 
            </div>
        </div>
    </div>
@endsection
