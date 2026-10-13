@extends('admin.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h3">Create Bank Loan</h1>
</div>
@include('admin.partials.flash')

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.bank.loan.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="shareholder_id">Shareholder <span class="text-danger">*</span></label>
                <select name="shareholder_id" id="shareholder_id" class="form-control @error('shareholder_id') is-invalid @enderror" required>
                    <option value="">-- Select Shareholder --</option>
                    @foreach($shareholders as $shareholder)
                        <option value="{{ $shareholder->id }}" @if(old('shareholder_id') == $shareholder->id) selected @endif>
                            {{ $shareholder->name }} ({{ $shareholder->shareholder_code ?? 'N/A' }})
                        </option>
                    @endforeach
                </select>
                @error('shareholder_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Bank Name <span class="text-danger">*</span></label>
                    <input type="text" name="bank_name" class="form-control @error('bank_name') is-invalid @enderror" value="{{ old('bank_name') }}" required>
                    @error('bank_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>Loan Amount <span class="text-danger">*</span></label>
                    <input type="number" name="loan_amount" step="0.01" class="form-control @error('loan_amount') is-invalid @enderror" value="{{ old('loan_amount') }}" required>
                    @error('loan_amount') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Interest Rate (%) <span class="text-danger">*</span></label>
                    <input type="number" name="interest_rate" step="0.01" class="form-control @error('interest_rate') is-invalid @enderror" value="{{ old('interest_rate') }}" required>
                    @error('interest_rate') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-4">
                    <label>Loan Term (Months) <span class="text-danger">*</span></label>
                    <input type="number" name="loan_term_months" class="form-control @error('loan_term_months') is-invalid @enderror" value="{{ old('loan_term_months') }}" required>
                    @error('loan_term_months') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-4">
                    <label>Installment Count <span class="text-danger">*</span></label>
                    <input type="number" name="installment_count" class="form-control @error('installment_count') is-invalid @enderror" value="{{ old('installment_count') }}" required>
                    @error('installment_count') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Loan Date <span class="text-danger">*</span></label>
                    <input type="date" name="loan_date" class="form-control @error('loan_date') is-invalid @enderror" value="{{ old('loan_date') }}" required>
                    @error('loan_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>Maturity Date <span class="text-danger">*</span></label>
                    <input type="date" name="maturity_date" class="form-control @error('maturity_date') is-invalid @enderror" value="{{ old('maturity_date') }}" required>
                    @error('maturity_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Savings Amount</label>
                <input type="number" name="savings_amount" step="0.01" class="form-control" value="{{ old('savings_amount', 0) }}">
            </div>

            <div class="form-group">
                <label>Remarks</label>
                <textarea name="remarks" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Create Loan</button>
            <a href="{{ route('admin.bank.loan.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
