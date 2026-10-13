@extends('admin.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h3">Bank Loans</h1>
    <a href="{{ route('admin.bank.loan.create') }}" class="btn btn-primary">New Loan</a>
</div>
@include('admin.partials.flash')

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-light">
                    <tr>
                        <th>#</th>
                        <th>Shareholder</th>
                        <th>Bank Name</th>
                        <th>Loan Amount</th>
                        <th>Interest Rate</th>
                        <th>Loan Date</th>
                        <th>Maturity Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $loan)
                    <tr>
                        <td>{{ $loan->id }}</td>
                        <td>{{ $loan->shareholder->name ?? 'N/A' }}</td>
                        <td>{{ $loan->bank_name }}</td>
                        <td>{{ number_format($loan->loan_amount, 2) }}</td>
                        <td>{{ $loan->interest_rate }}%</td>
                        <td>{{ $loan->loan_date ? $loan->loan_date->format('d-M-Y') : '-' }}</td>
                        <td>{{ $loan->maturity_date ? $loan->maturity_date->format('d-M-Y') : '-' }}</td>
                        <td>
                            @if($loan->status == 'active')
                                <span class="badge badge-success">{{ ucfirst($loan->status) }}</span>
                            @elseif($loan->status == 'completed')
                                <span class="badge badge-info">{{ ucfirst($loan->status) }}</span>
                            @else
                                <span class="badge badge-secondary">{{ ucfirst($loan->status) }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.bank.loan.view', $loan->id) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('admin.bank.loan.edit', $loan->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <a href="{{ route('admin.bank.loan.statement', $loan->id) }}" class="btn btn-sm btn-success">Statement</a>
                            <a href="{{ route('admin.bank.loan.emi.statement', $loan->id) }}" class="btn btn-sm btn-success">EMI Statement</a>
                            <a href="{{ route('admin.bank.loan.savings.statement', $loan->id) }}" class="btn btn-sm btn-warning">Savings Statement</a>
                            <form style="display:inline" method="POST" action="{{ route('admin.bank.loan.delete', $loan->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">No loans found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
