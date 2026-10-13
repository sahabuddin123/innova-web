@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-boxes"></i> {{ $pageTitle }}</h1>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle ?? 'Add ASSET item' }}</h3>
                <form action="{{ route('admin.assets.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="title">Title <span class="text-danger">*</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title') }}" />
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="level">Level <span class="text-danger">*</span></label>
                            <input class="form-control @error('level') is-invalid @enderror" type="text" name="level" id="level" value="{{ old('level') }}" />
                            @error('level') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="short_description">Short Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('short_description') is-invalid @enderror" name="short_description" id="short_description" rows="4">{{ old('short_description') }}</textarea>
                            @error('short_description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="button_text">Button Text <span class="text-danger">*</span></label>
                            <input class="form-control @error('button_text') is-invalid @enderror" type="text" name="button_text" id="button_text" value="{{ old('button_text') }}" />
                            @error('button_text') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="button_url">Button URL</label>
                            <input class="form-control @error('button_url') is-invalid @enderror" type="text" name="button_url" id="button_url" value="{{ old('button_url') }}" />
                            @error('button_url') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="image">Image</label>
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" />
                            @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="sort_order">Sort Order</label>
                            <input class="form-control @error('sort_order') is-invalid @enderror" type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" />
                            @error('sort_order') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="IsActive">Status</label>
                            <select class="form-control @error('IsActive') is-invalid @enderror" name="IsActive" id="IsActive">
                                <option value="1" @if(old('IsActive', 1) == 1) selected @endif>Active</option>
                                <option value="0" @if(old('IsActive') == 0) selected @endif>Inactive</option>
                            </select>
                            @error('IsActive') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Item</button>
                        <a class="btn btn-secondary" href="{{ route('admin.assets.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
