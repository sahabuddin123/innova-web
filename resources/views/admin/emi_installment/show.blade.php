@extends('admin.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h3">EMI Installment Details</h1>
</div>
@include('admin.partials.flash')

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5>Loan Information</h5>
                <table class="table table-sm table-bordered">
                    <tr>
                        <th>Bank Name:</th>
                        <td><strong>{{ $emi->bankLoan->bank_name ?? 'N/A' }}</strong></td>
                    </tr>
                    <tr>
                        <th>Loan Amount:</th>
                        <td>{{ number_format($emi->bankLoan->loan_amount ?? 0, 2) }} BDT</td>
                    </tr>
                    <tr>
                        <th>Interest Rate:</th>
                        <td>{{ $emi->bankLoan->interest_rate ?? 'N/A' }}%</td>
                    </tr>
                    <tr>
                        <th>Loan Status:</th>
                        <td>
                            @if($emi->bankLoan->status == 'active')
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-secondary">{{ ucfirst($emi->bankLoan->status) }}</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h5>Shareholder Information</h5>
                <table class="table table-sm table-bordered">
                    <tr>
                        <th>Name:</th>
                        <td><strong>{{ $emi->shareholder->name ?? 'N/A' }}</strong></td>
                    </tr>
                    <tr>
                        <th>Code:</th>
                        <td>{{ $emi->shareholder->shareholder_code ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Contact:</th>
                        <td>{{ $emi->shareholder->contact ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $emi->shareholder->email ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-6">
                <h5>EMI Payment Details</h5>
                <table class="table table-sm table-bordered">
                    <tr>
                        <th>EMI Amount:</th>
                        <td><strong>{{ number_format($emi->emi_amount, 2) }} BDT</strong></td>
                    </tr>
                    <tr>
                        <th>Savings Amount:</th>
                        <td>{{ number_format($emi->savings_amount, 2) }} BDT</td>
                    </tr>
                    <tr>
                        <th>Total (EMI + Savings):</th>
                        <td>{{ number_format($emi->emi_amount + $emi->savings_amount, 2) }} BDT</td>
                    </tr>
                    <tr>
                        <th>Payment Date:</th>
                        <td>{{ $emi->payment_date ? $emi->payment_date->format('d-M-Y') : '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h5>Payment Information</h5>
                <table class="table table-sm table-bordered">
                    <tr>
                        <th>Payment Method:</th>
                        <td>{{ ucfirst(str_replace('_', ' ', $emi->payment_method)) }}</td>
                    </tr>
                    <tr>
                        <th>Paid By:</th>
                        <td>{{ $emi->paid_by }}</td>
                    </tr>
                    <tr>
                        <th>Received By:</th>
                        <td>{{ $emi->receivedByUser->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            @if($emi->status == 'paid')
                                <span class="badge badge-success">Paid</span>
                            @elseif($emi->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @else
                                <span class="badge badge-secondary">{{ ucfirst($emi->status) }}</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        @if($emi->remarks)
            <hr>
            <h5>Remarks</h5>
            <p>{{ $emi->remarks }}</p>
        @endif
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.emi.installment.edit', $emi->id) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('admin.emi.installment.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
