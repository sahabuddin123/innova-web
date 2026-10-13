@extends('admin.app')
@section('content')
{{-- <div class="row mb-4">
    <div class="col-md-6">
        <h2 class="h3">Investment and Withdrawal Statement</h2>
        <p><strong>Shareholder:</strong> {{ $shareholder->name }} ({{ $shareholder->email }})</p>
        <p><strong>Total Investment:</strong> {{ number_format($totalInvestment, 2) }}</p>
        <p><strong>Total Withdrawn:</strong> {{ number_format($totalWithdrawn, 2) }}</p>
        <p><strong>Current Balance:</strong> {{ number_format($currentBalance, 2) }}</p>
    </div>
</div> --}}
<div class="tile">
    <div class="tile-header">
                <div class="row mb-4">
            <div class="col-md-6">
                <img src="{{ asset('public/storage/' . $shareholder->image) }}" alt="Company Logo" style="max-height: 80px;">
            </div>
            <div class="col-md-6 text-right">
                <h4><strong>INNOVA Computers BD</strong></h4>
                <p class="mb-1">Masterpara, Charbata, Subarnachar, Noakhali.</p>
                <p class="mb-1"><i class="fa fa-phone"></i> +880 1844 463 963, +880 1817 682 323</p>
                <p><i class="fa fa-envelope"></i> innovacomputersbd@gmail.com</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="text-center"><strong>Investment Statement</strong></h2>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <p><strong>Investor ID:</strong> {{ $shareholder->id }}</p>
                <p><strong>Investor Name:</strong> {{ $shareholder->name }}</p>
                <p><strong>Total Investment:</strong> {{ number_format($totalInvestment, 2) }}</p>
                <p><strong>Total Withdrawn:</strong> {{ number_format($totalWithdrawn, 2) }}</p>
                <p><strong>Current Balance:</strong> {{ number_format($currentBalance, 2) }}</p>
            </div>
            <div class="col-md-6 text-right">
                <p><strong>Generate at :</strong> {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
                <p><strong>Phone :</strong> {{ $shareholder->phone ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
    <div class="tile-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-light">
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th class="text-right">Deposit</th>
                        <th class="text-right">Withdrawal</th>
                        <th class="text-right">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @if($transactions->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center text-muted">No transactions found</td>
                    </tr>
                    @else
                        @foreach($transactions as $txn)
                        <tr>
                            <td>
                                @if(is_string($txn['date']))
                                    {{ \Carbon\Carbon::parse($txn['date'])->format('d-M-Y') }}
                                @else
                                    {{ $txn['date']->format('d-M-Y') }}
                                @endif
                            </td>
                            <td>
                                {{ $txn['description'] }}
                                @if($txn['ref_type'] == 'investment')
                                    <a href="{{ route('admin.investment.detail', $txn['id']) }}" class="btn btn-sm btn-info" target="_blank" title="View Investment"><i class="fa fa-eye"></i></a>
                                @elseif($txn['ref_type'] == 'withdraw')
                                    <a href="{{ route('admin.investment.withdraw.view', $txn['id']) }}" class="btn btn-sm btn-warning" target="_blank" title="View Withdrawal"><i class="fa fa-eye"></i></a>
                                @endif
                            </td>
                            <td>
                                @if($txn['type'] == 'Deposit')
                                    <span class="badge badge-success">Deposit</span>
                                @else
                                    <span class="badge badge-danger">Withdrawal</span>
                                @endif
                            </td>
                            <td class="text-right">
                                @if($txn['debit'] > 0)
                                    <strong class="text-success">{{ number_format($txn['debit'], 2) }}</strong>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-right">
                                @if($txn['credit'] > 0)
                                    <strong class="text-danger">{{ number_format($txn['credit'], 2) }}</strong>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-right font-weight-bold">
                                {{ number_format($txn['balance'], 2) }}
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot class="bg-light font-weight-bold">
                    <tr>
                        <td colspan="3" class="text-right">Total:</td>
                        <td class="text-right text-success">
                            {{ number_format($transactions->sum('debit'), 2) }}
                        </td>
                        <td class="text-right text-danger">
                            {{ number_format($transactions->sum('credit'), 2) }}
                        </td>
                        <td class="text-right">
                            @php
                                $finalBalance = $transactions->sum('debit') - $transactions->sum('credit');
                            @endphp
                            {{ number_format($finalBalance, 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.investment.view', $shareholder->id) }}" class="btn btn-secondary">Back to Investments</a>
    <button onclick="window.print()" class="btn btn-primary">Print Statement</button>
</div>

@endsection

@push('scripts')
<style>
    @media print {
        .btn-secondary, .btn-primary, body > nav, body > .sidebar, .btn-info, .btn-warning, .sidebar { 
            display: none; 
        }
        .table { font-size: 12px; }
    }
</style>
@endpush
