@extends('admin.app')

@section('title') {{ $pageTitle }} @endsection

@section('content')
<style>
    .form-control{
        padding: 5px 10px;
    }
</style>
    @include('admin.partials.flash')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $pageTitle }}</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $pageTitle }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.asset-training.courses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row gx-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Course Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" value="{{ old('slug') }}" class="form-control @error('slug') is-invalid @enderror" placeholder="Optional - auto-create from name">
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Short Description</label>
                    <textarea name="short_description" class="form-control @error('short_description') is-invalid @enderror" rows="4">{{ old('short_description') }}</textarea>
                    @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="row gx-3">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Level</label>
                        <input type="text" name="level" value="{{ old('level') }}" class="form-control @error('level') is-invalid @enderror">
                        @error('level')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Icon</label>
                        <input type="text" name="icon" value="{{ old('icon') }}" class="form-control @error('icon') is-invalid @enderror" placeholder="e.g. fas fa-laptop-code">
                        @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Button Color</label>
                        <input type="text" name="button_color" value="{{ old('button_color') }}" class="form-control @error('button_color') is-invalid @enderror" placeholder="#4d50ff">
                        @error('button_color')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="row gx-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Course Outline</label>
                        <input type="file" name="course_outline" accept=".pdf,.doc,.docx,.txt,.png,.jpg,.jpeg" class="form-control @error('course_outline') is-invalid @enderror">
                        <div class="form-text">Upload a course outline document or image to attach to this course.</div>
                        @error('course_outline')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control form-select @error('status') is-invalid @enderror">
                            <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-success px-4">Save Course</button>
                    <a href="{{ route('admin.asset-training.courses.index') }}" class="btn btn-secondary px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
