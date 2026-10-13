@extends('admin.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="h3">Investment Detail</h1>
            <div>
                <a href="{{ route('admin.investment.statement', $shareholder->id) }}" class="btn btn-info">View Statement</a>
                <a href="{{ route('admin.investment.view', $shareholder->id) }}" class="btn btn-secondary">Back to Shareholder</a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-title">Investment Information</h5>
                <table class="table table-sm table-bordered">
                    <tr>
                        <th>Investment ID:</th>
                        <td>{{ $investment->id }}</td>
                    </tr>
                    <tr>
                        <th>Shareholder:</th>
                        <td><strong>{{ $shareholder->name }}</strong></td>
                    </tr>
                    <tr>
                        <th>Amount:</th>
                        <td><strong>{{ number_format($investment->amount, 2) }} BDT</strong></td>
                    </tr>
                    <tr>
                        <th>Investment Date:</th>
                        <td>
                            @php
                                $date = strtotime($investment->recevedDate);
                                $formattedDate = date('d-M-Y', $date);
                            @endphp
                            {{ $formattedDate }}
                        </td>
                    </tr>
                    <tr>
                        <th>Received By:</th>
                        <td>{{ $investment->recevedBy ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Remarks:</th>
                        <td>{{ $investment->paidremark ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            <div class="col-md-6">
                <h5 class="card-title">Investment Image</h5>
                @if($investment->image)
                    <div class="card border-0">
                        <img src="{{ asset('public/storage/' . $investment->image) }}" class="card-img-top" alt="Investment Image" style="max-height: 300px; object-fit: cover;">
                    </div>
                @else
                    <div class="alert alert-info">No image attached</div>
                @endif
            </div>
        </div>

        <hr>

        <div class="row mt-4">
            <div class="col-md-12">
                <h5>System Information</h5>
                <table class="table table-sm table-bordered">
                    <tr>
                        <th>Created At:</th>
                        <td>
                            @php
                                $created = strtotime($investment->created_at);
                                $createdDate = date('d-M-Y H:i A', $created);
                            @endphp
                            {{ $createdDate }}
                        </td>
                        <th>Updated At:</th>
                        <td>
                            @php
                                $updated = strtotime($investment->updated_at);
                                $updatedDate = date('d-M-Y H:i A', $updated);
                            @endphp
                            {{ $updatedDate }}
                        </td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td colspan="3">
                            @if($investment->isActive == 1)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-secondary">Inactive</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.investment.edit', $investment->id) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('admin.investment.view', $shareholder->id) }}" class="btn btn-secondary">Back</a>
</div>

@endsection
