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
                <form action="{{ route('admin.cmsabout.update') }}" method="POST" role="form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <input type="hidden" name="id" value="{{ $targetData->id }}">
                        <div class="form-group">
                            <label class="control-label" for="shortTitle">Short Title <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('shortTitle') is-invalid @enderror" type="text"
                                name="shortTitle" id="shortTitle" value="{{ old('shortTitle', $targetData->shortTitle) }}" />
                            @error('shortTitle')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="LongTitle">Long Title <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('LongTitle') is-invalid @enderror" type="text"
                                name="LongTitle" id="LongTitle" value="{{ old('LongTitle', $targetData->LongTitle) }}" />
                            @error('LongTitle')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="shortdetail">short Detail</label>
                            <textarea class="form-control" rows="4" name="shortdetail" id="shortdetail">{{ old('shortdetail', $targetData->shortdetail) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="info1">Info One <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('info1') is-invalid @enderror" type="text" name="info1"
                                id="info1" value="{{ old('info1', $targetData->info1) }}" />
                            @error('info1')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="info2">Info Two <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('info2') is-invalid @enderror" type="text" name="info2"
                                id="info2" value="{{ old('info2', $targetData->info2) }}" />
                            @error('info2')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="info3">Info Three <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('info3') is-invalid @enderror" type="text" name="info3"
                                id="info3" value="{{ old('info3', $targetData->info3) }}" />
                            @error('info3')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="btnTxt">Button text <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('btnTxt') is-invalid @enderror" type="text" name="btnTxt"
                                id="btnTxt" value="{{ old('btnTxt', $targetData->btnTxt) }}" />
                            @error('btnTxt')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="btnLink">Button Link <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('btnLink') is-invalid @enderror" type="text" name="btnLink"
                                id="btnLink" value="{{ old('btnLink', $targetData->btnLink) }}" />
                            @error('btnLink')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="Reviews">Reviews <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('Reviews') is-invalid @enderror" type="text" name="Reviews"
                                id="Reviews" value="{{ old('Reviews', $targetData->Reviews) }}" />
                            @error('Reviews')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="Rating">Rating <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('Rating') is-invalid @enderror" type="text" name="Rating"
                                id="Rating" value="{{ old('Rating', $targetData->Rating) }}" />
                            @error('Rating')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="stdId">Student ID <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('stdId') is-invalid @enderror" type="text"
                                name="stdId" id="stdId" value="{{ old('stdId', $targetData->stdId) }}" placeholder="1,2,3,4,5" />
                            @error('stdId')
                                {{ $message }}
                            @enderror
                        </div>
                        

                        <div class="form-group" id="image-area">
                            <label class="control-label" for="image-tag">Background Image 1<<span
                                    class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('bgimg1') is-invalid @enderror image-tag" type="file"
                                name="bgimg1" id="image-tag" value="{{ old('bgimg1', $targetData->bgimg1) }}" />
                            @error('bgimg1')
                                {{ $message }}
                            @enderror
                        </div>
                        <input type="hidden" name="oldcimage" value="{{ $targetData->bgimg1 }}">
                        @if ($targetData->bgimg1 != null)
                            <img src="{{ asset('public/storage/' . $targetData->bgimg1) }}" alt="!" height="80">
                        @endif

                        
                        <div class="form-group" id="image-area">
                            <label class="control-label" for="nid-tag">Background Image 2 <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('bgimg2') is-invalid @enderror image-tag" type="file"
                                name="bgimg2" id="nid-tag" value="{{ old('bgimg2', $targetData->bgimg2) }}" />
                            @error('bgimg2')
                                {{ $message }}
                            @enderror
                        </div>
                        <input type="hidden" name="olddimage" value="{{ $targetData->bgimg2 }}">
                        @if ($targetData->bgimg2 != null)
                            <img src="{{ asset('public/storage/' . $targetData->bgimg2) }}" alt="!" height="80">
                        @endif

                       

                        <div class="form-group">
                            <label class="control-label" for="video">Video URL <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('video') is-invalid @enderror" type="text"
                                name="video" id="video" value="{{ old('video', $targetData->video) }}" />
                            @error('video')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="successTraing">Success Traing <span
                                    class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('successTraing') is-invalid @enderror" type="text"
                                name="successTraing" id="successTraing" value="{{ old('successTraing', $targetData->successTraing) }}" />
                            @error('successTraing')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="completeCourse">Complete Course<span
                                    class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('completeCourse') is-invalid @enderror" type="text"
                                name="completeCourse" id="completeCourse" value="{{ old('completeCourse', $targetData->completeCourse) }}" />
                            @error('completeCourse')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="satisfaction">Satisfaction <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('satisfaction') is-invalid @enderror" type="text"
                                name="satisfaction" id="satisfaction" value="{{ old('satisfaction', $targetData->satisfaction) }}" />
                            @error('satisfaction')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="stdComunity">Student Comunity<span
                                    class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('stdComunity') is-invalid @enderror" type="text"
                                name="stdComunity" id="stdComunity" value="{{ old('stdComunity', $targetData->stdComunity) }}" />
                            @error('stdComunity')
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
                                <option value="1" @if (old('IsActive', $targetData->IsActive) == 1) {{ 'selected' }} @endif>
                                    Active</option>
                            </select>
                            @error('IsActive')
                                {{ $message }}
                            @enderror
                        </div>

                        

                    </div>
                    
                    <div class="tile-footer">
                        <button class="btn btn-success" type="submit"><i
                                class="fa fa-fw fa-lg fa-check-circle"></i>Update cms About</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-danger" href="{{ route('admin.cmsabout.index') }}"><i
                                class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
