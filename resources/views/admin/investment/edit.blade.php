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
                <form action="{{ route('admin.investment.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$target->id}}">
                    <input type="hidden" name="shareholder_id" value="{{$shareHolder->id}}">
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="amount">Investment Amount <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('amount') is-invalid @enderror" type="number" name="amount" id="amount" value="{{ old('amount', $target->amount) }}"/>
                            @error('amount') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="recevedBy">Received By <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('recevedBy') is-invalid @enderror" type="text" name="recevedBy" id="recevedBy" value="{{ old('recevedBy', $target->recevedBy) }}"/>
                            @error('recevedBy') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="recevedDate">Received Date <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('recevedDate') is-invalid @enderror" type="date" name="recevedDate" id="recevedDate" value="{{ old('recevedDate', $target->recevedDate) }}"/>
                            @error('recevedDate') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="paidremark">Remarks <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('paidremark') is-invalid @enderror" type="text" name="paidremark" id="paidremark" value="{{ old('paidremark', $target->paidremark) }}"/>
                            @error('paidremark') {{ $message }} @enderror
                        </div>
                        <div class="form-group" id="image-area">
                            <label class="control-label" for="image-tag">Supporting Documents <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('image') is-invalid @enderror image-tag" type="file" name="image" id="image-tag" value="{{ old('image', $target->image) }}"/>
                            @error('image') {{ $message }} @enderror
                        </div>
                        @if($target->image!=null)
                            <img src="{{ asset('public/storage/'.$target->image)}}" alt="!" height="182.4">
                        @endif
                        <input type="hidden" name="oldimage" value="{{$target->image}}">
                       
                        <div class="form-group">
                            <label class="control-label" for="isActive">Status <span class="m-l-5 text-danger"> *</span></label>
                            <select  class="form-control @error('isActive') is-invalid @enderror" name="isActive" id="isActive">
                                <option value="" @if(old('isActive') == null ) {{"selected"}} @endif>--Select--</option>
                                <option value="0" @if(old('isActive', $target->isActive) == 0) {{"selected"}} @endif>Waiting for approval </option>
                                <option value="1" @if(old('isActive', $target->isActive) == 1) {{"selected"}} @endif>Approved</option>
                                <option value="2" @if(old('isActive', $target->isActive) == 2) {{"selected"}} @endif>Pending</option>
                                <option value="3" @if(old('isActive', $target->isActive) == 3) {{"selected"}} @endif>Postponded</option>
                            </select>
                            @error('isActive') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Payments</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.investment.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts') 

@endpush