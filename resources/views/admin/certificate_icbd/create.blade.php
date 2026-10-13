@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-certificate"></i> {{ $pageTitle }}</h1>
    </div>
    @include('admin.partials.flash')
    {{-- @dd($batches); --}}
    {{-- @dd($students); --}}
    {{-- @dd($courses); --}}
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{!! $subTitle !!}</h3>

                <form action="{{ route('admin.certificate_icbd.store') }}" method="POST" role="form">
                    @csrf
                    <div class="tile-body">
                        {{-- Student --}}
                        <div class="form-group">
                            <label for="student_id">Student <span class="text-danger">*</span></label>
                            <input type="text" name="" id="student_id"
                                class="form-control @error('student_id') is-invalid @enderror"
                                value="{{ old('student_id', $students->sname) }}" readonly>
                            <input type="hidden" name="student_id" value="{{ old('student_id', $students->id) }}">
                            @error('student_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Batch --}}
                        <div class="form-group">
                            <label for="batch_id">Batch <span class="text-danger">*</span></label>
                            <select name="batch_id" id="batch_id"
                                class="form-control @error('batch_id') is-invalid @enderror">
                                <option value="">Select Batch</option>
                                @foreach ($batches as $batch)
                                    <option value="{{ $batch->id }}" @if (old('batch_id', $students->batch_id) == $batch->id) selected @endif>
                                        {{ $batch->batchnum }}
                                    </option>
                                @endforeach
                            </select>
                            @error('batch_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Course --}}
                        <div class="form-group">
                            <label for="course_id">Course <span class="text-danger">*</span></label>
                            <select name="course_id" id="course_id"
                                class="form-control @error('course_id') is-invalid @enderror">
                                <option value="">Select Course</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}" @if (old('course_id', $students->course_id) == $course->id) selected @endif>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Certificate Number --}}
                        {{-- <div class="form-group">
                            <label for="certificate_no">Certificate Number <span class="text-danger">*</span></label>
                            <input type="text" name="certificate_no" id="certificate_no" class="form-control @error('certificate_no') is-invalid @enderror" value="{{ old('certificate_no') }}">
                            @error('certificate_no') <span class="text-danger">{{ $message }}</span> @enderror
                        </div> --}}

                        {{-- Hours --}}
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="theory_hours">Theory Hours</label>
                                <input type="number" name="theory_hours" id="theory_hours" class="form-control"
                                    value="{{ old('theory_hours', 0) }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="practical_hours">Practical Hours</label>
                                <input type="number" name="practical_hours" id="practical_hours" class="form-control"
                                    value="{{ old('practical_hours', 0) }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="intern_hours">Intern Hours</label>
                                <input type="number" name="intern_hours" id="intern_hours" class="form-control"
                                    value="{{ old('intern_hours', 0) }}">
                            </div>
                        </div>

                        {{-- Result --}}
                        <div class="form-group">
                            <label for="result">Result</label>
                            <input type="text" name="result" id="result"
                                class="form-control @error('result') is-invalid @enderror" value="{{ old('result') }}">
                            @error('result')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Issue Date --}}
                        <div class="form-group">
                            <label for="issue_date">Issue Date</label>
                            <input type="date" name="issue_date" id="issue_date"
                                class="form-control @error('issue_date') is-invalid @enderror"
                                value="{{ old('issue_date') }}">
                            @error('issue_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Certificate Receiver --}}
                        <div class="form-group">
                            <label for="certificate_receiver">Certificate Receiver</label>
                            <input type="text" name="certificate_receiver" id="certificate_receiver"
                                class="form-control @error('certificate_receiver') is-invalid @enderror"
                                value="{{ old('certificate_receiver') }}">
                            @error('certificate_receiver')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Delivery Date --}}
                        <div class="form-group">
                            <label for="delivery_date">Delivery Date</label>
                            <input type="date" name="delivery_date" id="delivery_date"
                                class="form-control @error('delivery_date') is-invalid @enderror"
                                value="{{ old('delivery_date') }}">
                            @error('delivery_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="form-group">
                            <label for="is_active">Status</label>
                            <select name="is_active" id="is_active" class="form-control">
                                <option value="">Select Status</option>
                                <option value="1" {{ old('is_active') == 1 ? 'selected' : '' }}>
                                    Delivered</option>
                                <option value="2" {{ old('is_active') == 2 ? 'selected' : '' }}>
                                    Waiting</option>
                                <option value="3" {{ old('is_active') == 3 ? 'selected' : '' }}>
                                    Printing Queue</option>
                                <option value="4" {{ old('is_active') == 4 ? 'selected' : '' }}>
                                    Cancelled</option>
                            </select>
                        </div>
                    </div>

                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-check-circle"></i> Create
                            Certificate</button>
                        <a class="btn btn-secondary" href="{{ route('admin.certificate_icbd.index') }}"><i
                                class="fa fa-times-circle"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
