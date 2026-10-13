@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-money-bill-alt"></i> {{ $pageTitle }}</h1>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <form action="{{ route('admin.fees.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$targetFees->id}}">
                    <input type="hidden" name="student_id" value="{{$targetFees->student_id}}">
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="paidamount">Pay Amount <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('paidamount') is-invalid @enderror" type="number" name="paidamount" id="paidamount" value="{{ old('paidamount', $targetFees->paidamount) }}"/>
                            @error('paidamount') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="paymentType">Pay Amount <span class="m-l-5 text-danger"> *</span></label>
                            <select name="paymentType" id="paymentType" class="form-control form-control-input @error('paidamount') is-invalid @enderror">
                                <option value="1" @if($targetFees->paymentType == 1) {{"selected"}} @endif>Course Fee</option>
                                <option value="2" @if($targetFees->paymentType == 2) {{"selected"}} @endif>Regitration Fee</option>
                            </select>
                            @error('paymentType') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="paiddate">Pay Date <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('paiddate') is-invalid @enderror" type="date" name="paiddate" id="paiddate" value="{{ old('paiddate', $targetFees->paiddate) }}"/>
                            @error('paiddate') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="paidremark">Payments Remarks <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('paidremark') is-invalid @enderror" type="text" name="paidremark" id="paidremark" value="{{ old('paidremark', $targetFees->paidremark) }}"/>
                            @error('paidremark') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Payments</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.fees.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts') 

@endpush