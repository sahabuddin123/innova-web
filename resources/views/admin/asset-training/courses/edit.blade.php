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
            <form action="{{ route('admin.asset-training.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row gx-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Course Name</label>
                        <input type="text" name="name" value="{{ old('name', $course->name) }}" class="form-control @error('name') is-invalid @enderror">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" value="{{ old('slug', $course->slug) }}" class="form-control @error('slug') is-invalid @enderror" placeholder="Optional - auto-create from name">
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Short Description</label>
                    <textarea name="short_description" class="form-control @error('short_description') is-invalid @enderror" rows="4">{{ old('short_description', $course->short_description) }}</textarea>
                    @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="row gx-3">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Level</label>
                        <input type="text" name="level" value="{{ old('level', $course->level) }}" class="form-control @error('level') is-invalid @enderror">
                        @error('level')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Icon</label>
                        <input type="text" name="icon" value="{{ old('icon', $course->icon) }}" class="form-control @error('icon') is-invalid @enderror" placeholder="e.g. fas fa-laptop-code">
                        @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Button Color</label>
                        <input type="text" name="button_color" value="{{ old('button_color', $course->button_color) }}" class="form-control @error('button_color') is-invalid @enderror" placeholder="#4d50ff">
                        @error('button_color')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                @if($course->course_outline)
                    <div class="mb-3">
                        <label class="form-label">Current Course Outline</label>
                        <div>
                            <a href="{{ asset('storage/' . $course->course_outline) }}" target="_blank" class="text-primary">View uploaded outline</a>
                        </div>
                    </div>
                @endif
                <div class="row gx-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Course Outline</label>
                        <input type="file" name="course_outline" accept=".pdf,.doc,.docx,.txt,.png,.jpg,.jpeg" class="form-control @error('course_outline') is-invalid @enderror">
                        <div class="form-text">Upload or replace the existing outline document or image.</div>
                        @error('course_outline')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control form-select @error('status') is-invalid @enderror">
                            <option value="1" {{ old('status', $course->status) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $course->status) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-success px-4">Update Course</button>
                    <a href="{{ route('admin.asset-training.courses.index') }}" class="btn btn-secondary px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
