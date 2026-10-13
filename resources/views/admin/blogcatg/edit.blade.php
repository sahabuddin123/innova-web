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
                <form action="{{ route('admin.blogcatg.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <input type="hidden" name="id" value="{{$targetData->id}}">
                        
                         <div class="form-group">
                            <label class="control-label" for="categoryName">Blog Categoris <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('categoryName') is-invalid @enderror" type="text" name="categoryName" id="categoryName" value="{{ old('categoryName', $targetData->categoryName) }}"/>
                            @error('categoryName') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    @if ($targetData->icon != null)
                                        <figure class="mt-2" style="width: 80px; height: auto;">
                                            <img src="{{ asset('public/storage/'.$targetData->icon) }}" id="categoryImage" class="img-fluid" alt="img">
                                        </figure>
                                        <input type="hidden" name="oldicon" value="{{$targetData->icon}}">
                                    @endif
                                </div>
                                <div class="col-md-10">
                                    <label class="control-label">Icon</label>
                                    <input class="form-control @error('icon') is-invalid @enderror" type="file" id="icon" name="icon"/>
                                    @error('icon') {{ $message }} @enderror
                                    
                                </div>
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <label class="control-label" for="fontawesome">Fontawesome <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('fontawesome') is-invalid @enderror" type="text" name="fontawesome" id="fontawesome" value="{{ old('fontawesome', $targetData->fontawesome) }}"/>
                            @error('fontawesome') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="isFeature">Is Feature </label>
                            <select  class="form-control @error('isFeature') is-invalid @enderror"name="isFeature" id="isFeature">
                                <option value="1" @if($targetData->isFeature == 1) {{ "selected" }}  @endif  >Yes</option>
                                <option value="0" @if($targetData->isFeature == 0) {{ "selected" }}  @endif >No</option>
                            </select>
                            @error('IsActive') {{ $message }} @enderror
                        </div> --}}
                        <div class="form-group">
                            <label class="control-label" for="IsActive">Status </label>
                            <select  class="form-control @error('IsActive') is-invalid @enderror"name="IsActive" id="IsActive">
                                <option value="1" @if($targetData->IsActive == 1) {{ "selected" }}  @endif  >Active</option>
                                <option value="0" @if($targetData->IsActive == 0) {{ "selected" }}  @endif >Deactivce</option>
                            </select>
                            @error('IsActive') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Blog Categoris</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-danger" href="{{ route('admin.blogcatg.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
