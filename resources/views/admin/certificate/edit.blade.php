@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-registered"></i> {{ $pageTitle }}</h1>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{!! $subTitle !!}</h3>
                <form action="{{ route('admin.certificate.update') }}" method="POST" role="form"
                    enctype="multipart/form-data">
                    <div class="tile-body">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <input type="hidden" name="id" value="{{ $target->id }}">
                                <input type="hidden" name="student_id" value="{{ $target->student_id }}">
                                <div class="form-group">
                                    <label class="control-label" for="session_id">Compter Trade Session <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <select class="form-control @error('session_id') is-invalid @enderror" name="session_id"
                                        id="session_id">
                                        <option value="">Select One</option>
                                        @foreach ($session as $course)
                                            <option value="{{ $course->id }}"
                                                @if (old('session_id', $target->session_id) == $course->id) {{ 'selected' }} @endif>
                                                {{ $course->sessionName }}</option>
                                        @endforeach
                                    </select>
                                    @error('session_id')
                                        {{ $message }}
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="regNo">BTEB Registration Number <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control @error('regNo') is-invalid @enderror" type="number"
                                        name="regNo" id="regNo" value="{{ old('regNo', $target->regNo) }}" />
                                    @error('regNo')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="cno">Certificate Number <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control @error('cno') is-invalid @enderror" type="number"
                                        name="cno" id="cno" value="{{ old('cno', $target->cno) }}" />
                                    @error('cno')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="recevier">Certificate Receiver Name <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control @error('recevier') is-invalid @enderror" type="text"
                                        name="recevier" id="recevier" value="{{ old('recevier', $target->recevier) }}" />
                                    @error('recevier')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="pDate">Certificate Print Date <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control @error('pDate') is-invalid @enderror" type="date"
                                        name="pDate" id="pDate" value="{{ old('pDate', $target->pDate) }}" />
                                    @error('pDate')
                                        {{ $message }}
                                    @enderror
                                </div>

                                <div class="form-group" id="image-area">
                                    <label class="control-label" for="image-tag">Certificate Image <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control @error('cimage') is-invalid @enderror image-tag"
                                        type="file" name="cimage" id="image-tag"
                                        value="{{ old('cimage', $target->cimage) }}" />
                                    @error('cimage')
                                        {{ $message }}
                                    @enderror
                                </div>
                                @if ($target->cimage != null)
                                    <img src="{{ asset('public/storage/' . $target->cimage) }}" alt="!"
                                        height="80">
                                @endif
                                <input type="hidden" name="oldcimage" value="{{ $target->cimage }}">
                                <div class="form-group" id="image-area">
                                    <label class="control-label" for="nid-tag">Delivery Image <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control @error('dimage') is-invalid @enderror image-tag"
                                        type="file" name="dimage" id="nid-tag"
                                        value="{{ old('dimage', $target->dimage) }}" />
                                    @error('dimage')
                                        {{ $message }}
                                    @enderror
                                </div>
                                @if ($target->dimage != null)
                                    <img src="{{ asset('public/storage/' . $target->dimage) }}" alt="!"
                                        height="80">
                                @endif
                                <input type="hidden" name="olddimage" value="{{ $target->dimage }}">
                                <div class="form-group">
                                    <label class="control-label" for="Result">BTEB Exam Result ( GL ) <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control @error('Result') is-invalid @enderror" type="text"
                                        name="Result" id="Result" value="{{ old('Result', $target->Result) }}" />
                                    @error('Result')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="dDate">Delivery Date <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control @error('dDate') is-invalid @enderror" type="date"
                                        name="dDate" id="dDate" value="{{ old('dDate', $target->dDate) }}" />
                                    @error('dDate')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="IsActive">Registration Status <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <select class="form-control @error('IsActive') is-invalid @enderror"name="IsActive"
                                        id="IsActive">
                                        <option value="">Select one</option>
                                        <option value="1"
                                            @if (old('IsActive', $target->IsActive) == 1) {{ 'selected' }} @endif>Deliverd</option>
                                        <option value="2"
                                            @if (old('IsActive', $target->IsActive) == 2) {{ 'selected' }} @endif>Waiting For
                                            delivery</option>
                                        <option value="3"
                                            @if (old('IsActive', $target->IsActive) == 3) {{ 'selected' }} @endif>Printing Queie
                                        </option>
                                        <option value="4"
                                            @if (old('IsActive', $target->IsActive) == 4) {{ 'selected' }} @endif>Cancle</option>
                                    </select>
                                    @error('IsActive')
                                        {{ $message }}
                                    @enderror
                                </div>

                            </div>
                            <div class="tile-footer">
                                <button class="btn btn-primary" type="submit" id="submitform"><i
                                        class="fa fa-fw fa-lg fa-check-circle"></i>Update Certificate</button>
                                &nbsp;&nbsp;&nbsp;
                                <a class="btn btn-secondary" href="{{ route('admin.certificate.index') }}"><i
                                        class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                            </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
