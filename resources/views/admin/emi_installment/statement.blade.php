@extends('admin.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h3 page-title">EMI Statement</h1>
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
                <h4><strong>EMI INSTALLMENT STATEMENT</strong></h4>
                <p class="small">As on {{ Carbon\Carbon::now()->format('d-M-Y') }}</p>
            </div>
            <div class="col-md-3 text-right">
                <p><strong>Statement ID:</strong> EMI-{{ $loan->id }}</p>
                <p><strong>Loan ID:</strong> {{ $loan->id }}</p>
            </div>
        </div>
    </div>

    <!-- Loan Details -->
    <div class="card-body border-bottom">
        <h5>Loan Information</h5>
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
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-sm">
                    <tr>
                        <td><strong>Shareholder:</strong></td>
                        <td>{{ $loan->shareholder->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Loan Date:</strong></td>
                        <td>{{ $loan->loan_date ? $loan->loan_date->format('d-M-Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Maturity Date:</strong></td>
                        <td>{{ $loan->maturity_date ? $loan->maturity_date->format('d-M-Y') : '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- EMI Schedule -->
    <div class="card-body border-bottom">
        <h5>EMI Payment Schedule</h5>
        <table class="table table-bordered table-sm">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Payment Date</th>
                    <th>EMI Amount</th>
                    <th>Savings Amount</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Paid At</th>
                    <th>Received By</th>
                </tr>
            </thead>
            <tbody>
                @php $runningTotal = 0; @endphp
                @forelse($emis as $index => $emi)
                    @php $runningTotal += $emi->emi_amount + $emi->savings_amount; @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $emi->payment_date ? $emi->payment_date->format('d-M-Y') : '-' }}</td>
                        <td class="text-right">{{ number_format($emi->emi_amount, 2) }}</td>
                        <td class="text-right">{{ number_format($emi->savings_amount, 2) }}</td>
                        <td class="text-right"><strong>{{ number_format($emi->emi_amount + $emi->savings_amount, 2) }}</strong></td>
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
                        <td colspan="8" class="text-center text-muted">No EMI records found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Summary Section -->
    <div class="card-body">
        <h5>Summary</h5>
        <div class="row">
            <div class="col-md-6">
                <table class="table table-sm table-bordered">
                    <tr>
                        <th>Total EMI Amount:</th>
                        <td class="text-right"><strong>{{ number_format($totalEmiAmount, 2) }} BDT</strong></td>
                    </tr>
                    <tr>
                        <th>Total Savings Amount:</th>
                        <td class="text-right"><strong>{{ number_format($totalSavingsAmount, 2) }} BDT</strong></td>
                    </tr>
                    <tr>
                        <th>Grand Total:</th>
                        <td class="text-right"><strong>{{ number_format($totalEmiAmount + $totalSavingsAmount, 2) }} BDT</strong></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-sm table-bordered">
                    <tr>
                        <th>Paid EMI:</th>
                        <td class="text-right text-success"><strong>{{ number_format($paidEmiAmount, 2) }} BDT</strong></td>
                    </tr>
                    <tr>
                        <th>Pending EMI:</th>
                        <td class="text-right text-warning"><strong>{{ number_format($pendingEmiAmount, 2) }} BDT</strong></td>
                    </tr>
                    <tr>
                        <th>Total Savings Collected:</th>
                        <td class="text-right text-info"><strong>{{ number_format($paidSavingsAmount, 2) }} BDT</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="mt-3 no-print">
    <a href="{{ route('admin.bank.loan.show', $loan->id) }}" class="btn btn-secondary">Back to Loan</a>
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
