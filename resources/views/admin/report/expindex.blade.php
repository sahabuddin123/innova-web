@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="far fa-credit-card"></i> {{ $pageTitle }}</h1>
    </div>
    @include('admin.partials.flash')
    <style type="text/css">
        #results {
            padding: 10px;
            border: 1px solid;
            background: #ccc;
        }
    </style>
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <form action="{{ route('admin.getReport') }}" method="POST" role="form" enctype="multipart/form-data">
                    <div class="tile-body">
                        @csrf
                        <div class="form-group">
                            <label class="control-label" for="category_id">Expanse Categoris<span class="m-l-5 text-danger">
                                    *</span></label>
                            <select class="form-control @error('category_id') is-invalid @enderror"name="category_id"
                                id="category_id">
                                <option value="">Select Categoris</option>
                                @foreach ($categoris as $item)
                                    <option value="{{ $item->id }}">{{ $item->categoris }}</option>
                                @endforeach

                            </select>
                            @error('category_id')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="date">Invoice Date <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('date') is-invalid @enderror" type="text" name="date"
                                id="date" value="{{ old('date') }}" />
                            @error('date')
                                {{ $message }}
                            @enderror
                        </div>


                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit" id="submitform"><i
                                    class="fa fa-fw fa-lg fa-check-circle"></i>Get Expanse Report</button>
                            &nbsp;&nbsp;&nbsp;
                            <a class="btn btn-secondary" href="{{ route('admin.expancere.index') }}"><i
                                    class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                        </div>
                </form>
            </div>
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <form action="{{ route('admin.report.monthly') }}" method="POST" role="form"
                    enctype="multipart/form-data">
                    <div class="tile-body">
                        @csrf
                        <div class="form-group">
                            <label class="control-label" for="branch_id">Branch<span class="m-l-5 text-danger">
                                    *</span></label>
                            <select class="form-control @error('branch_id') is-invalid @enderror"name="branch_id"
                                id="branch_id">
                                <option value="">Select Branch</option>
                                @foreach ($branch as $item)
                                    <option value="{{ $item->id }}">{{ $item->bname }}</option>
                                @endforeach

                            </select>
                            @error('branch_id')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="month">Month and Year<span class="m-l-5 text-danger">*</span></label>
                            <input class="form-control @error('month') is-invalid @enderror" type="month" name="month" id="month" value="{{ old('month') }}" />
                            @error('month')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit" id="submitform"><i
                                    class="fa fa-fw fa-lg fa-check-circle"></i>Get Monthly Report</button>
                            &nbsp;&nbsp;&nbsp;
                            <a class="btn btn-secondary" href="{{ route('admin.expancere.index') }}"><i
                                    class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <script>
        $(function() {
            $('input[name="date"]').daterangepicker();
            $('input[name="date"]').change(function() {
                $(this).val();
                console.log($(this).val());
            });
        });
    </script>
@endpush
