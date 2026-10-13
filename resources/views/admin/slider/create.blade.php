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
                <form action="{{ route('admin.slider.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="title">Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title') }}"/>
                            @error('title') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="details">Description</label>
                            <textarea class="form-control" rows="4" name="details" id="details">{{ old('details') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="btnTxt">Button Text <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('btnTxt') is-invalid @enderror" type="text" name="btnTxt" id="btnTxt" value="{{ old('btnTxt') }}"/>
                            @error('btnTxt') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="btnLink">Button Link <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('btnLink') is-invalid @enderror" type="text" name="btnLink" id="btnLink" value="{{ old('btnLink') }}"/>
                            @error('btnLink') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="dao">Data Aanimation Out <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('dao') is-invalid @enderror" type="text" name="dao" id="dao" placeholder="fadeOutRight" value="{{ old('dao') }}"/>
                            @error('dao') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="ddo">Data Delay Out <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('ddo') is-invalid @enderror" type="text" name="ddo" id="ddo" placeholder="5" value="{{ old('ddo') }}"/>
                            @error('ddo') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="ddi">Data Duration In <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('ddi') is-invalid @enderror" type="text" name="ddi" id="ddi" placeholder=".3" value="{{ old('ddi') }}"/>
                            @error('ddi') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="dai">Data Animation In <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('dai') is-invalid @enderror" type="text" name="dai" id="dai" placeholder="fadeInLeft" value="{{ old('dai') }}"/>
                            @error('dai') {{ $message }} @enderror
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
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Slider</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.slider.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')

@endpush