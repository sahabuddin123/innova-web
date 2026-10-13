@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-registered"></i> {{ $pageTitle }}</h1>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{!! $subTitle !!}</h3>
                <form action="{{ route('admin.certificate.store') }}" method="POST" role="form"
                    enctype="multipart/form-data">
                    <div class="tile-body">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <input type="hidden" name="student_id" value="{{ $students->id }}">
                                <div class="form-group">
                                    <label class="control-label" for="session_id">Compter Trade Session <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <select class="form-control @error('session_id') is-invalid @enderror" name="session_id"
                                        id="session_id">
                                        <option value="">Select One</option>
                                        @foreach ($session as $course)
                                            <option value="{{ $course->id }}"
                                                @if (old('session_id') == $course->id) {{ 'selected' }} @endif>
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
                                        name="regNo" id="regNo" value="{{ old('regNo') }}" />
                                    @error('regNo')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="cno">Certificate Number <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control @error('cno') is-invalid @enderror" type="number"
                                        name="cno" id="cno" value="{{ old('cno') }}" />
                                    @error('cno')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="recevier">Certificate Receiver Name <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control @error('recevier') is-invalid @enderror" type="text"
                                        name="recevier" id="recevier" value="{{ old('recevier') }}" />
                                    @error('recevier')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="pDate">Certificate Print Date <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control @error('pDate') is-invalid @enderror" type="date"
                                        name="pDate" id="pDate" value="{{ old('pDate') }}" />
                                    @error('pDate')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="cimage">Certificate Image<span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control @error('cimage') is-invalid @enderror" type="file"
                                        name="cimage" id="cimage" value="{{ old('cimage') }}" />
                                    @error('cimage')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="dimage">Certificate Delivery Image<span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control @error('dimage') is-invalid @enderror" type="file"
                                        name="dimage" id="dimage" value="{{ old('dimage') }}" />
                                    @error('dimage')
                                        {{ $message }}
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label" for="Result">Result Grate Letter <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control @error('Result') is-invalid @enderror" type="text"
                                        name="Result" id="Result" value="{{ old('Result') }}" />
                                    @error('Result')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="dDate">Delivery Date <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control @error('dDate') is-invalid @enderror" type="date"
                                        name="dDate" id="dDate" value="{{ old('dDate') }}" />
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
                                            @if (old('IsActive') == 1) {{ 'selected' }} @endif>Deliverd</option>
                                        <option value="2"
                                            @if (old('IsActive') == 2) {{ 'selected' }} @endif>Waiting For
                                            Delivery</option>
                                        <option value="3"
                                            @if (old('IsActive') == 3) {{ 'selected' }} @endif>Printing Queie
                                        </option>
                                        <option value="4"
                                            @if (old('IsActive') == 4) {{ 'selected' }} @endif>Cancle</option>
                                    </select>
                                    @error('IsActive')
                                        {{ $message }}
                                    @enderror
                                </div>

                            </div>
                            <div class="tile-footer">
                                <button class="btn btn-primary" type="submit" id="submitform"><i
                                        class="fa fa-fw fa-lg fa-check-circle"></i>Create Certificate</button>
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
