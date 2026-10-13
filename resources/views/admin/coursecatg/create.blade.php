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
                <form action="{{ route('admin.coursecatg.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        
                        <div class="form-group"> 
                            <label class="control-label" for="CourseCategoris">Course Category Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('CourseCategoris') is-invalid @enderror" type="text" name="CourseCategoris" id="CourseCategoris" value="{{ old('CourseCategoris') }}"/>
                            @error('CourseCategoris') {{ $message }} @enderror
                        </div>
                        <div class="form-group" id="image-area">
                            <label class="control-label" for="image-tag">Course Categoy ICON <span
                                    class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('icon') is-invalid @enderror image-tag"
                                type="file" name="icon" id="image-tag" value="{{ old('icon') }}" />
                            @error('icon')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group"> 
                            <label class="control-label" for="fontawesome">fontawesome icon <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('fontawesome') is-invalid @enderror" type="text" name="fontawesome" id="fontawesome" value="{{ old('fontawesome') }}"/>
                            @error('fontawesome') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="isFeature">Is Feature </label>
                            <select  class="form-control @error('isFeature') is-invalid @enderror"name="isFeature" id="isFeature">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @error('isFeature') {{ $message }} @enderror
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
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Course Ctegoris</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.coursecatg.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form> 
            </div>
        </div>
    </div>
@endsection
