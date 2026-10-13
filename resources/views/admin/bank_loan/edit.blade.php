@extends('admin.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h3">Edit Bank Loan</h1>
</div>
@include('admin.partials.flash')

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.bank.loan.update', $loan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="shareholder_id">Shareholder <span class="text-danger">*</span></label>
                    <select name="shareholder_id" id="shareholder_id" class="form-control @error('shareholder_id') is-invalid @enderror" required>
                        <option value="">-- Select Shareholder --</option>
                        @foreach($shareholders as $shareholder)
                            <option value="{{ $shareholder->id }}" @if(old('shareholder_id', $loan->shareholder_id) == $shareholder->id) selected @endif>
                                {{ $shareholder->name }} ({{ $shareholder->shareholder_code ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                    @error('shareholder_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="bank_name">Bank Name <span class="text-danger">*</span></label>
                    <input type="text" name="bank_name" id="bank_name" class="form-control @error('bank_name') is-invalid @enderror" 
                           value="{{ old('bank_name', $loan->bank_name) }}" placeholder="e.g., ABC Bank Ltd" required>
                    @error('bank_name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="loan_amount">Loan Amount (BDT) <span class="text-danger">*</span></label>
                    <input type="number" name="loan_amount" id="loan_amount" class="form-control @error('loan_amount') is-invalid @enderror" 
                           value="{{ old('loan_amount', $loan->loan_amount) }}" step="0.01" min="0" required>
                    @error('loan_amount')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="interest_rate">Interest Rate (%) <span class="text-danger">*</span></label>
                    <input type="number" name="interest_rate" id="interest_rate" class="form-control @error('interest_rate') is-invalid @enderror" 
                           value="{{ old('interest_rate', $loan->interest_rate) }}" step="0.01" min="0" required>
                    @error('interest_rate')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="loan_term_months">Loan Term (Months) <span class="text-danger">*</span></label>
                    <input type="number" name="loan_term_months" id="loan_term_months" class="form-control @error('loan_term_months') is-invalid @enderror" 
                           value="{{ old('loan_term_months', $loan->loan_term_months) }}" min="1" required>
                    @error('loan_term_months')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="installment_count">Installment Count <span class="text-danger">*</span></label>
                    <input type="number" name="installment_count" id="installment_count" class="form-control @error('installment_count') is-invalid @enderror" 
                           value="{{ old('installment_count', $loan->installment_count) }}" min="1" required>
                    @error('installment_count')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="status">Status <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="">-- Select Status --</option>
                        <option value="active" @if(old('status', $loan->status) == 'active') selected @endif>Active</option>
                        <option value="completed" @if(old('status', $loan->status) == 'completed') selected @endif>Completed</option>
                        <option value="closed" @if(old('status', $loan->status) == 'closed') selected @endif>Closed</option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="loan_date">Loan Date <span class="text-danger">*</span></label>
                    <input type="date" name="loan_date" id="loan_date" class="form-control @error('loan_date') is-invalid @enderror" 
                           value="{{ old('loan_date', $loan->loan_date ? $loan->loan_date->format('Y-m-d') : '') }}" required>
                    @error('loan_date')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="maturity_date">Maturity Date <span class="text-danger">*</span></label>
                    <input type="date" name="maturity_date" id="maturity_date" class="form-control @error('maturity_date') is-invalid @enderror" 
                           value="{{ old('maturity_date', $loan->maturity_date ? $loan->maturity_date->format('Y-m-d') : '') }}" required>
                    @error('maturity_date')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="savings_amount">Savings Amount (BDT)</label>
                    <input type="number" name="savings_amount" id="savings_amount" class="form-control @error('savings_amount') is-invalid @enderror" 
                           value="{{ old('savings_amount', $loan->savings_amount) }}" step="0.01" min="0">
                    @error('savings_amount')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="remarks">Remarks</label>
                <textarea name="remarks" id="remarks" class="form-control @error('remarks') is-invalid @enderror" 
                          rows="3" placeholder="Additional remarks">{{ old('remarks', $loan->remarks) }}</textarea>
                @error('remarks')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.bank.loan.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
