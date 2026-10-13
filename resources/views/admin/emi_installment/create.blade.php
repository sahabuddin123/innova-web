@extends('admin.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h3">Record EMI Payment</h1>
</div>
@include('admin.partials.flash')

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.emi.installment.store') }}" method="POST">
            @csrf

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="bank_loan_id">Select Bank Loan <span class="text-danger">*</span></label>
                    <select name="bank_loan_id" id="bank_loan_id" class="form-control @error('bank_loan_id') is-invalid @enderror" required>
                        <option value="">-- Select Loan --</option>
                        @foreach($loans as $loan)
                            <option value="{{ $loan->id }}" data-shareholder="{{ $loan->shareholder->name }}" data-shareholder-id="{{ $loan->shareholder_id }}">
                                {{ $loan->bank_name }} - {{ number_format($loan->loan_amount, 2) }} BDT
                            </option>
                        @endforeach
                    </select>
                    @error('bank_loan_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="shareholder_id">Shareholder</label>
                    <input type="text" id="shareholder_name" class="form-control" readonly>
                    <input type="hidden" name="shareholder_id" id="shareholder_id">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="emi_amount">EMI Amount (BDT) <span class="text-danger">*</span></label>
                    <input type="number" name="emi_amount" id="emi_amount" class="form-control @error('emi_amount') is-invalid @enderror" 
                           value="{{ old('emi_amount') }}" step="0.01" min="0" required>
                    @error('emi_amount')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="savings_amount">Savings Amount (BDT)</label>
                    <input type="number" name="savings_amount" id="savings_amount" class="form-control @error('savings_amount') is-invalid @enderror" 
                           value="{{ old('savings_amount') }}" step="0.01" min="0">
                    @error('savings_amount')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="payment_date">Payment Date <span class="text-danger">*</span></label>
                    <input type="date" name="payment_date" id="payment_date" class="form-control @error('payment_date') is-invalid @enderror" 
                           value="{{ old('payment_date', date('Y-m-d')) }}" required>
                    @error('payment_date')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                    <select name="payment_method" id="payment_method" class="form-control @error('payment_method') is-invalid @enderror" required>
                        <option value="">-- Select Method --</option>
                        <option value="cash" @if(old('payment_method') == 'cash') selected @endif>Cash</option>
                        <option value="cheque" @if(old('payment_method') == 'cheque') selected @endif>Cheque</option>
                        <option value="bank_transfer" @if(old('payment_method') == 'bank_transfer') selected @endif>Bank Transfer</option>
                        <option value="mobile_banking" @if(old('payment_method') == 'mobile_banking') selected @endif>Mobile Banking</option>
                        <option value="others" @if(old('payment_method') == 'others') selected @endif>Others</option>
                    </select>
                    @error('payment_method')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="paid_by">Paid By <span class="text-danger">*</span></label>
                    <input type="text" name="paid_by" id="paid_by" class="form-control @error('paid_by') is-invalid @enderror" 
                           value="{{ old('paid_by') }}" placeholder="e.g., Shareholder Name" required>
                    @error('paid_by')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="received_by">Received By <span class="text-danger">*</span></label>
                    <input type="text" name="received_by" id="received_by" class="form-control @error('received_by') is-invalid @enderror" 
                           value="{{ old('received_by') }}" placeholder="e.g., Officer Name" required>
                    @error('received_by')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="remarks">Remarks</label>
                <textarea name="remarks" id="remarks" class="form-control @error('remarks') is-invalid @enderror" 
                          rows="3" placeholder="Additional remarks">{{ old('remarks') }}</textarea>
                @error('remarks')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save EMI</button>
                <a href="{{ route('admin.emi.installment.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#bank_loan_id').change(function() {
        var option = $(this).find('option:selected');
        var shareholderName = option.data('shareholder');
        var shareholderId = option.data('shareholder-id');
        
        $('#shareholder_name').val(shareholderName);
        $('#shareholder_id').val(shareholderId);
    });
});
</script>
@endpush
@endsection
