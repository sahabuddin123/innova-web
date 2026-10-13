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
                <form action="{{ route('admin.expcategoris.update') }}" method="POST" role="form">
                    @csrf
                    <div class="tile-body">
                        <input type="hidden" name="id" value="{{$targetData->id}}">
                        <div class="form-group"> 
                            <label class="control-label" for="branch_id">Branch<span class="m-l-5 text-danger"> *</span></label>
                            <select  class="form-control @error('branch_id') is-invalid @enderror"name="branch_id" id="branch_id">
                                <option value="">Select Branch</option>
                                @foreach ($branch as $item)
                                    <option value="{{$item->id}}" @if(old('branch_id', $targetData->branch_id) == $item->id) {{"selected"}} @endif>{{$item->bname}}</option>
                                @endforeach
                            </select>
                            @error('branch_id') {{ $message }} @enderror
                        </div>
                         <div class="form-group">
                            <label class="control-label" for="categoris">Categoris <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('categoris') is-invalid @enderror" type="text" name="categoris" id="categoris" value="{{ old('categoris', $targetData->categoris) }}"/>
                            @error('categoris') {{ $message }} @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="IsActive">Status </label>
                            <select  class="form-control @error('IsActive') is-invalid @enderror"name="IsActive" id="IsActive">
                                <option value="0" @if($targetData->IsActive == 0) {{ "selected" }}  @endif >Deactivce</option>
                                <option value="1" @if($targetData->IsActive == 1) {{ "selected" }}  @endif  >Active</option>
                            </select>
                            @error('IsActive') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Categoris</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-danger" href="{{ route('admin.expcategoris.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
