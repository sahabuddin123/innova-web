@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
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
                <form action="{{ route('admin.gallery.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <input type="hidden" name="id" value="{{ $targetData->id }}">

                        <div class="form-group">
                            <label class="control-label" for="title">Title </label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title"
                                id="title" value="{{ old('title', $targetData->title) }}" />
                            @error('title')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="type">Category<span class="m-l-5 text-danger">
                                    *</span></label>
                            <select class="form-control @error('type') is-invalid @enderror" name="type" id="type">
                                <option value="">--Select--</option>
                                <option value="0" @if (old('type', $targetData->type) == 0) {{ 'selected' }} @endif>আমাদের
                                    প্রিমিসেস</option>
                                <option value="1" @if (old('type', $targetData->type) == 1) {{ 'selected' }} @endif>
                                    ফেয়ারওয়েল</option>
                                <option value="2" @if (old('type', $targetData->type) == 2) {{ 'selected' }} @endif>ইভেন্ট
                                </option>
                            </select>
                            @error('type')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="IsActive">Status<span class="m-l-5 text-danger">
                                    *</span></label>
                            <select class="form-control @error('IsActive') is-invalid @enderror"name="IsActive"
                                id="IsActive">
                                <option value="">--Select--</option>
                                <option value="0" @if (old('IsActive', $targetData->IsActive) == 0) {{ 'selected' }} @endif>
                                    Deactive</option>
                                <option value="1" @if (old('IsActive', $targetData->IsActive) == 1) {{ 'selected' }} @endif>Active
                                </option>
                            </select>
                            @error('IsActive')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    @if ($targetData->image != null)
                                        <figure class="mt-2" style="width: 80px; height: auto;">
                                            <img src="{{ asset('public/storage/' . $targetData->image) }}" id="categoryImage"
                                                class="img-fluid" alt="img">
                                        </figure>
                                    @endif
                                </div>
                                <div class="col-md-10">
                                    <label class="control-label">Image</label>
                                    <input class="form-control @error('image') is-invalid @enderror" type="file"
                                        id="image" name="image" />
                                    @error('image')
                                        {{ $message }}
                                    @enderror

                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="imageno" value="{{ $targetData->image }}">
                    <div class="tile-footer">
                        <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update
                            Image</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-danger" href="{{ route('admin.gallery.index') }}"><i
                                class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
