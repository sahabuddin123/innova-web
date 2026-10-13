@extends('admin.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h3">Edit EMI Installment</h1>
</div>
@include('admin.partials.flash')

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.emi.installment.update', $emi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="bank_loan_id">Bank Loan</label>
                    <input type="text" class="form-control" value="{{ $emi->bankLoan->bank_name ?? 'N/A' }} - {{ number_format($emi->bankLoan->loan_amount ?? 0, 2) }} BDT" readonly>
                    <input type="hidden" name="bank_loan_id" value="{{ $emi->bank_loan_id }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="shareholder_id">Shareholder</label>
                    <input type="text" class="form-control" value="{{ $emi->shareholder->name ?? 'N/A' }}" readonly>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="emi_amount">EMI Amount (BDT) <span class="text-danger">*</span></label>
                    <input type="number" name="emi_amount" id="emi_amount" class="form-control @error('emi_amount') is-invalid @enderror" 
                           value="{{ old('emi_amount', $emi->emi_amount) }}" step="0.01" min="0" required>
                    @error('emi_amount')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="savings_amount">Savings Amount (BDT)</label>
                    <input type="number" name="savings_amount" id="savings_amount" class="form-control @error('savings_amount') is-invalid @enderror" 
                           value="{{ old('savings_amount', $emi->savings_amount) }}" step="0.01" min="0">
                    @error('savings_amount')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="payment_date">Payment Date <span class="text-danger">*</span></label>
                    <input type="date" name="payment_date" id="payment_date" class="form-control @error('payment_date') is-invalid @enderror" 
                           value="{{ old('payment_date', $emi->payment_date ? $emi->payment_date->format('Y-m-d') : '') }}" required>
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
                        <option value="cash" @if(old('payment_method', $emi->payment_method) == 'cash') selected @endif>Cash</option>
                        <option value="cheque" @if(old('payment_method', $emi->payment_method) == 'cheque') selected @endif>Cheque</option>
                        <option value="bank_transfer" @if(old('payment_method', $emi->payment_method) == 'bank_transfer') selected @endif>Bank Transfer</option>
                        <option value="mobile_banking" @if(old('payment_method', $emi->payment_method) == 'mobile_banking') selected @endif>Mobile Banking</option>
                        <option value="others" @if(old('payment_method', $emi->payment_method) == 'others') selected @endif>Others</option>
                    </select>
                    @error('payment_method')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="paid_by">Paid By <span class="text-danger">*</span></label>
                    <input type="text" name="paid_by" id="paid_by" class="form-control @error('paid_by') is-invalid @enderror" 
                           value="{{ old('paid_by', $emi->paid_by) }}" required>
                    @error('paid_by')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="received_by">Received By <span class="text-danger">*</span></label>
                    <input type="text" name="received_by" id="received_by" class="form-control @error('received_by') is-invalid @enderror" 
                           value="{{ old('received_by', $emi->received_by) }}" required>
                    @error('received_by')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="status">Status <span class="text-danger">*</span></label>
                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                    <option value="pending" @if(old('status', $emi->status) == 'pending') selected @endif>Pending</option>
                    <option value="paid" @if(old('status', $emi->status) == 'paid') selected @endif>Paid</option>
                    <option value="overdue" @if(old('status', $emi->status) == 'overdue') selected @endif>Overdue</option>
                </select>
                @error('status')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="remarks">Remarks</label>
                <textarea name="remarks" id="remarks" class="form-control @error('remarks') is-invalid @enderror" 
                          rows="3">{{ old('remarks', $emi->remarks) }}</textarea>
                @error('remarks')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.emi.installment.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
