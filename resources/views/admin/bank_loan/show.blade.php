@extends('admin.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h3">Bank Loan Details</h1>
</div>
@include('admin.partials.flash')

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-sm table-bordered">
                    <tr>
                        <th>Loan ID:</th>
                        <td>{{ $loan->id }}</td>
                    </tr>
                    <tr>
                        <th>Shareholder:</th>
                        <td>{{ $loan->shareholder->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Bank Name:</th>
                        <td><strong>{{ $loan->bank_name }}</strong></td>
                    </tr>
                    <tr>
                        <th>Loan Amount:</th>
                        <td><strong>{{ number_format($loan->loan_amount, 2) }} BDT</strong></td>
                    </tr>
                    <tr>
                        <th>Interest Rate:</th>
                        <td>{{ $loan->interest_rate }}%</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-sm table-bordered">
                    <tr>
                        <th>Loan Date:</th>
                        <td>{{ $loan->loan_date ? $loan->loan_date->format('d-M-Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Maturity Date:</th>
                        <td>{{ $loan->maturity_date ? $loan->maturity_date->format('d-M-Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Loan Term:</th>
                        <td>{{ $loan->loan_term_months }} months</td>
                    </tr>
                    <tr>
                        <th>Installment Count:</th>
                        <td>{{ $loan->installment_count }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            @if($loan->status == 'active')
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-secondary">{{ ucfirst($loan->status) }}</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <hr>

        <h5>EMI Summary</h5>
        <div class="row">
            <div class="col-md-3">
                <div class="card text-center bg-light">
                    <div class="card-body">
                        <h6>Total Installments</h6>
                        <h3>{{ $loan->emiInstallments()->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center bg-light">
                    <div class="card-body">
                        <h6>Paid Installments</h6>
                        <h3 class="text-success">{{ $loan->paidInstallments()->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center bg-light">
                    <div class="card-body">
                        <h6>Pending Installments</h6>
                        <h3 class="text-warning">{{ $loan->pendingInstallments()->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center bg-light">
                    <div class="card-body">
                        <h6>Total Savings</h6>
                        <h3 class="text-info">{{ number_format($loan->totalSavings(), 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.bank.loan.edit', $loan->id) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('admin.bank.loan.statement', $loan->id) }}" class="btn btn-success">View Statement</a>
    <a href="{{ route('admin.bank.loan.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
