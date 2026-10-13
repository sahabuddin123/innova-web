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
                <form action="{{ route('admin.inccategoris.store') }}" method="POST" role="form">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group"> 
                            <label class="control-label" for="branch_id">Branch<span class="m-l-5 text-danger"> *</span></label>
                            <select  class="form-control @error('branch_id') is-invalid @enderror"name="branch_id" id="branch_id">
                                <option value="">Select Branch</option>
                                @foreach ($branch as $item)
                                    <option value="{{$item->id}}" @if(old('branch_id') == $item->id) {{"selected"}} @endif>{{$item->bname}}</option>
                                @endforeach
                            </select>
                            @error('branch_id') {{ $message }} @enderror
                        </div>
                        <div class="form-group"> 
                            <label class="control-label" for="categoris">Category Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('categoris') is-invalid @enderror" type="text" name="categoris" id="categoris" value="{{ old('categoris') }}"/>
                            @error('categoris') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="IsActive">Is Active </label>
                            <select  class="form-control @error('IsActive') is-invalid @enderror"name="IsActive" id="IsActive">
                                <option value="1">Active</option>
                                <option value="0">Deactive</option>
                            </select>
                            @error('IsActive') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Categoris</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.inccategoris.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form> 
            </div>
        </div>
    </div>
@endsection
