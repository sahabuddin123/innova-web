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
                <form action="{{ route('admin.blogs.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf 
                    
                    {{-- , $targetCourses->category_id --}}
                    <div class="tile-body">
                        <input type="hidden" name="id" value="{{$targetBlogs->id}}">
                        <div class="form-group">
                            <label class="control-label" for="category_id">Blog Categoris <span
                                    class="m-l-5 text-danger">*</span></label>
                            <select class="form-control @error('category_id') is-invalid @enderror" name="category_id"
                                id="category_id">
                                <option value="">Select Categoris</option>
                                @foreach ($blogsCategoris as $items)
                                    <option value="{{ $items->id }}"
                                        @if (old('category_id', $targetBlogs->category_id) == $items->id) {{ 'selected' }} @endif> {{ $items->categoryName }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="heading">Heading <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('heading') is-invalid @enderror" type="text" name="heading" id="heading" value="{{ old('heading', $targetBlogs->heading) }}"/>
                            @error('heading') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="summary">Summary<span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('summary') is-invalid @enderror" type="text" name="summary" id="summary" value="{{ old('summary', $targetBlogs->summary) }}"/>
                            @error('summary') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="details">Details<span class="m-l-5 text-danger"> *</span></label>
                            <textarea name="details" id="details" rows="10" value="{{ old('details', $targetBlogs->details) }}" class="form-control @error('details') is-invalid @enderror">{!! $targetBlogs->details !!}</textarea>
                            {{-- <input class="form-control @error('summary') is-invalid @enderror" type="text" name="summary" id="summary" value="{{ old('summary') }}"/> --}}
                            @error('details') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="writerName">Writer Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('writerName') is-invalid @enderror" type="text" name="writerName" id="writerName" value="{{ old('writerName', $targetBlogs->writerName) }}"/>
                            @error('writerName') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="postDate">Post Date <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('postDate') is-invalid @enderror" type="datetime-local" name="postDate" id="postDate" value="{{ old('postDate', $targetBlogs->postDate) }}"/>
                            @error('postDate') {{ $message }} @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="IsActive">Status<span class="m-l-5 text-danger"> *</span></label>
                            <select  class="form-control @error('IsActive') is-invalid @enderror"name="IsActive" id="IsActive">
                                <option value="">--Select--</option>
                                <option value="0" @if(old('IsActive',$targetBlogs->IsActive) == 0) {{"selected"}} @endif>Deactive</option>
                                <option value="1" @if(old('IsActive',$targetBlogs->IsActive) == 1) {{"selected"}} @endif>Active</option>
                            </select>
                            @error('IsActive') {{ $message }} @enderror
                        </div> 
                        <div class="form-group">
                            <label class="control-label" for="featured">Is Featured<span class="m-l-5 text-danger"> *</span></label>
                            <select  class="form-control @error('featured') is-invalid @enderror"name="featured" id="featured">
                                <option value="">--Select--</option>
                                <option value="0" @if(old('featured',$targetBlogs->featured) == 0) {{"selected"}} @endif>No</option>
                                <option value="1" @if(old('featured',$targetBlogs->featured) == 1) {{"selected"}} @endif>Yes</option>
                            </select>
                            @error('featured') {{ $message }} @enderror
                        </div> 
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    @if ($targetBlogs->image != null)
                                        <figure class="mt-2" style="width: 80px; height: auto;">
                                            <img src="{{ asset('public/storage/'.$targetBlogs->image) }}" id="Blog Image" class="img-fluid" alt="img">
                                        </figure>
                                    @endif
                                </div>
                                <div class="col-md-10">
                                    <label class="control-label">Category Image</label>
                                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                                    @error('image') {{ $message }} @enderror
                                    
                                </div>
                            </div>
                        </div>

                        
                    </div>
                    
                    <input type="hidden" name="imageno" value="{{ $targetBlogs->image }}">
                    <div class="tile-footer">
                        <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Blog</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-danger" href="{{ route('admin.blogs.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')

<script src="{{ asset('backend/ckeditor/ckeditor.js') }}"></script>
<script>
  var options = {
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
  };
</script>
<script>
    CKEDITOR.replace( 'details', options );
    // CKEDITOR.replace( 'overview', options );
    // CKEDITOR.replace( 'curriculum', options );
    // CKEDITOR.replace( 'software', options );
    // CKEDITOR.replace( 'trainee', options );
    // CKEDITOR.replace( 'jobPlacement', options );
    // CKEDITOR.replace( 'jobPosition', options );
</script>
@endpush