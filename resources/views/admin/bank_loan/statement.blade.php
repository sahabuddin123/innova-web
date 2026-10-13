@extends('admin.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h3 page-title">Bank Loan Statement</h1>
    <button class="btn btn-secondary" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
</div>

<div class="card" id="printArea">
    <!-- Header -->
    <div class="card-body border-bottom">
        <div class="row">
           <div class="col-md-3 text-center">
                <h5><strong>{{ config('settings.site_name') }}</strong></h5>
                {{-- <small>Company Office</small> --}}
                <p class="small">Head Office: Masterpara, Charbata, Subarnachar, Noakhali, Bangladesh</p>
            </div>
            <div class="col-md-6 text-center">
                <h4><strong>BANK LOAN STATEMENT</strong></h4>
                <p class="small">As on {{ Carbon\Carbon::now()->format('d-M-Y') }}</p>
            </div>
            <div class="col-md-3 text-right">
                <p><strong>Statement ID:</strong> BL-{{ $loan->id }}</p>
                <p><strong>Loan ID:</strong> {{ $loan->id }}</p>
            </div>
        </div>
    </div>

    <!-- Shareholder Details -->
    <div class="card-body border-bottom">
        <h5>Shareholder Information</h5>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Name:</strong> {{ $loan->shareholder->name ?? 'N/A' }}</p>
                <p><strong>Code:</strong> {{ $loan->shareholder->shareholder_code ?? 'N/A' }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Contact:</strong> {{ $loan->shareholder->contact ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $loan->shareholder->email ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Loan Details -->
    <div class="card-body border-bottom">
        <h5>Loan Details</h5>
        <div class="row">
            <div class="col-md-6">
                <table class="table table-sm">
                    <tr>
                        <td><strong>Bank Name:</strong></td>
                        <td>{{ $loan->bank_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Loan Amount:</strong></td>
                        <td>{{ number_format($loan->loan_amount, 2) }} BDT</td>
                    </tr>
                    <tr>
                        <td><strong>Interest Rate:</strong></td>
                        <td>{{ $loan->interest_rate }}% p.a.</td>
                    </tr>
                    <tr>
                        <td><strong>Loan Date:</strong></td>
                        <td>{{ $loan->loan_date ? $loan->loan_date->format('d-M-Y') : '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-sm">
                    <tr>
                        <td><strong>Maturity Date:</strong></td>
                        <td>{{ $loan->maturity_date ? $loan->maturity_date->format('d-M-Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Loan Term:</strong></td>
                        <td>{{ $loan->loan_term_months }} months</td>
                    </tr>
                    <tr>
                        <td><strong>Installment Count:</strong></td>
                        <td>{{ $loan->installment_count }}</td>
                    </tr>
                    <tr>
                        <td><strong>Monthly Savings:</strong></td>
                        <td>{{ number_format($monthlySavings, 2) }} BDT</td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
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
    </div>

    <!-- EMI Payment History -->
    <div class="card-body border-bottom">
        <h5>EMI Payment History</h5>
        <table class="table table-bordered table-sm">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Payment Date</th>
                    <th>EMI Amount</th>
                    <th>Savings Amount</th>
                    <th>Status</th>
                    <th>Paid At</th>
                    <th>Paid By</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loan->emiInstallments()->orderBy('payment_date')->get() as $index => $emi)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $emi->payment_date ? $emi->payment_date->format('d-M-Y') : '-' }}</td>
                        <td class="text-right">{{ number_format($emi->emi_amount, 2) }}</td>
                        <td class="text-right">{{ number_format($emi->savings_amount, 2) }}</td>
                        <td>
                            @if($emi->status == 'paid')
                                <span class="badge badge-success">Paid</span>
                            @elseif($emi->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @else
                                <span class="badge badge-secondary">{{ ucfirst($emi->status) }}</span>
                            @endif
                        </td>
                        <td>{{ $emi->paid_at ? $emi->paid_at->format('d-M-Y H:i') : '-' }}</td>
                        <td>{{ $emi->receivedByUser->name ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No EMI records found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Summary Section -->
    <div class="card-body">
        <h5>Summary</h5>
        <div class="row">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>Total Interest</h6>
                        <h4 class="text-danger">{{ number_format($totalInterest, 2) }} BDT</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>EMI Paid</h6>
                        <h4 class="text-success">{{ number_format($totalPaid, 2) }} BDT</h4>
                        <small>{{ $paidInstallments }} installments</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>Remaining EMI</h6>
                        <h4 class="text-warning">{{ number_format($remainingEmi, 2) }} BDT</h4>
                        <small>{{ $pendingInstallments }} installments</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>Total Savings</h6>
                        <h4 class="text-info">{{ number_format($totalSavings, 2) }} BDT</h4>
                        <small>Loan: {{ number_format($monthlySavings, 2) }} + EMI: {{ number_format($emiSavings, 2) }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3 no-print">
    <a href="{{ route('admin.bank.loan.index') }}" class="btn btn-secondary">Back</a>
</div>

<style>
    @media print {
        .sidebar, .page-title { display: none !important; }
        .navbar { display: none !important; }
        .btn { display: none !important; }
        .no-print { display: none !important; }
        body { margin: 0; padding: 0; background: white; }
        .card { border: none; box-shadow: none; }
    }
</style>
@endsection
