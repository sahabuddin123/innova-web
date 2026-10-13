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
                <form action="{{ route('admin.blogs.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="category_id">Blog Categoris <span
                                    class="m-l-5 text-danger">*</span></label>
                            <select class="form-control @error('category_id') is-invalid @enderror" name="category_id"
                                id="category_id">
                                <option value="">Select Categoris</option>
                                @foreach ($blogsCategoris as $items)
                                    <option value="{{ $items->id }}"
                                        @if (old('category_id')) {{ 'selected' }} @endif> {{ $items->categoryName }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="heading">Heading <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('heading') is-invalid @enderror" type="text" name="heading" id="heading" value="{{ old('heading') }}"/>
                            @error('heading') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="summary">Summary<span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('summary') is-invalid @enderror" type="text" name="summary" id="summary" value="{{ old('summary') }}"/>
                            @error('summary') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="details">Details<span class="m-l-5 text-danger"> *</span></label>
                            <textarea name="details" id="details" rows="10" value="{{ old('details') }}" class="form-control @error('details') is-invalid @enderror"></textarea>
                            {{-- <input class="form-control @error('summary') is-invalid @enderror" type="text" name="summary" id="summary" value="{{ old('summary') }}"/> --}}
                            @error('details') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="writerName">Writer Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('writerName') is-invalid @enderror" type="text" name="writerName" id="writerName" value="{{ old('writerName') }}"/>
                            @error('writerName') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="postDate">Post Date <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('postDate') is-invalid @enderror" type="datetime-local" name="postDate" id="postDate" value="{{ old('postDate') }}"/>
                            @error('postDate') {{ $message }} @enderror
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
                            <label class="control-label" for="featured">Is Featured<span class="m-l-5 text-danger"> *</span></label>
                            <select  class="form-control @error('featured') is-invalid @enderror"name="featured" id="featured">
                                <option value="">--Select--</option>
                                <option value="0" @if(old('featured') == 0) {{"selected"}} @endif>No</option>
                                <option value="1" @if(old('featured') == 1) {{"selected"}} @endif>Yes</option>
                            </select>
                            @error('featured') {{ $message }} @enderror
                        </div> 
                        
                        <div class="form-group">
                            <label class="control-label">Featured Image</label>
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                            @error('image') {{ $message }} @enderror
                        </div>
                        
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Blog</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.blogs.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
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