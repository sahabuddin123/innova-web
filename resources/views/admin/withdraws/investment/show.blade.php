@extends('admin.app')
@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h1 class="h3 d-print-none">Investment Withdrawal Slip #{{ $withdraw->id }}</h1>
        <button class="btn btn-secondary" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
    </div>
    @include('admin.partials.flash')

    {{-- <div class="printable-area"> --}}  

    <div class="container" id="slipContainer" style="max-width: 1000px;">
        <div class="tile">
            <div class="tile-body">
                <!-- Header with Logo -->
                <div style="text-align: center; margin-bottom: 30px; padding: 20px; border-bottom: 2px solid #333;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="flex: 1;">
                            @if (config('settings.site_logo'))
                                <img src="{{ asset('public/storage/' . config('settings.site_logo')) }}" alt="Logo"
                                    style="height:60px;">
                            @else
                                <h4 style="margin: 0; font-weight: bold;">{{ config('app.name', 'Company') }}</h4>
                            @endif
                        </div>
                        <div style="flex: 1; text-align: right;">
                            <div style="font-size: 12px;">
                                <div><strong>Month:</strong> <span
                                        style="border: 1px solid #333; padding: 2px 8px;">{{ $withdraw->withdraw_date ? \Carbon\Carbon::parse($withdraw->withdraw_date)->format('M') : 'N/A' }}</span>
                                </div>
                                <div style="margin-top: 5px;"><strong>Year:</strong> <span
                                        style="border: 1px solid #333; padding: 2px 8px;">{{ $withdraw->withdraw_date ? \Carbon\Carbon::parse($withdraw->withdraw_date)->format('Y') : 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Title -->
                <div style="text-align: center; margin-bottom: 30px;">
                    <h3 style="margin: 0; font-weight: bold; text-decoration: underline;">Investment Withdrawal Slip</h3>
                </div>

                <!-- Main Content Table -->
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                    <!-- Header Row: Receipt Number, Receipt Date, Month Of -->
                    <tr>
                        <th style="border: 1px solid #333; padding: 8px; background:#fff; text-align:center;">RECEIPT NUMBER
                        </th>
                        <th style="border: 1px solid #333; padding: 8px; background:#fff; text-align:center;">RECEIPT DATE
                        </th>
                        <th style="border: 1px solid #333; padding: 8px; background:#fff; text-align:center;">MONTH OF</th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #333; padding: 10px; text-align:center;">{{ $withdraw->id }}</td>
                        <td style="border: 1px solid #333; padding: 10px; text-align:center;">
                            {{ $withdraw->withdraw_date ? \Carbon\Carbon::parse($withdraw->withdraw_date)->format('d-m-Y') : 'N/A' }}
                        </td>
                        <td style="border: 1px solid #333; padding: 10px; text-align:center;">
                            {{ $withdraw->withdraw_date ? \Carbon\Carbon::parse($withdraw->withdraw_date)->format('F') : 'N/A' }}
                        </td>
                    </tr>

                    <!-- Paid/Received/Withdraw Amount -->
                    <tr>
                        <th style="border: 1px solid #333; padding: 8px; background:#f5f5f5; text-align:center;">PAID BY
                        </th>
                        <th style="border: 1px solid #333; padding: 8px; background:#f5f5f5; text-align:center;">RECEIVED BY
                        </th>
                        <th style="border: 1px solid #333; padding: 8px; background:#f5f5f5; text-align:center;">WITHDRAW
                            AMOUNT</th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #333; padding: 10px; text-align:center;">
                            {{ $withdraw->method ?? 'N/A' }}</td>
                        <td style="border: 1px solid #333; padding: 10px; text-align:center;">
                            {{ $withdraw->receiver_name ?? 'N/A' }}</td>
                        <td style="border: 1px solid #333; padding: 10px; text-align:center;">BDT
                            {{ number_format($withdraw->amount, 2) }}</td>
                    </tr>

                    <!-- Shareholder Name (exact label required) -->
                    <tr>
                        <th style="border: 1px solid #333; padding: 8px; background:#fff; text-align:left;">SHAREHOLDER NAME
                        </th>
                        <th colspan="2" style="border: 1px solid #333; padding: 8px; background:#fff; text-align:left;">
                            {{ optional($withdraw->shareholder)->name ?? $withdraw->shareholder_id }}</th>
                    </tr>


                    <!-- Branch Name -->
                    <tr>
                        <th style="border: 1px solid #333; padding: 8px; background:#fff; text-align:left;">BRANCH NAME</th>
                        <th colspan="2" style="border: 1px solid #333; padding: 8px; background:#fff; text-align:left;">
                            {{ $withdraw->branch_name ?? (config('settings.branch_name') ?? 'Main Branch') }}</th>
                    </tr>


                    <!-- Payment Method (exact label required) -->
                    <tr>
                        <th style="border: 1px solid #333; padding: 8px; background:#fff; text-align:left;">PAYMENT METHOD
                        </th>
                        <th colspan="2" style="border: 1px solid #333; padding: 8px; background:#fff; text-align:left;">
                            {{ $withdraw->pay_by ?? 'N/A' }}</th>
                    </tr>


                    <!-- Cheque/Transaction Number -->
                    <tr>
                        <th style="border: 1px solid #333; padding: 8px; background:#f5f5f5; text-align:left;">
                            CHEQUE/TRANSACTION NUMBER</th>
                        <th colspan="2"
                            style="border: 1px solid #333; padding: 8px; background:#f5f5f5; text-align:left;">
                            {{ $withdraw->account_number ?? '-' }}</th>
                    </tr>
                    <!-- Totals and Balances (exact labels required) -->
                    <tr>
                        <th style="border: 1px solid #333; padding: 8px; background:#f5f5f5; text-align:left;">TOTAL
                            INVESTMENT AMOUNT</th>
                        <th colspan="2"
                            style="border: 1px solid #333; padding: 8px; background:#f5f5f5; text-align:left;">BDT
                            {{ number_format(optional($withdraw->shareholder)->total_investment ?? 0, 2) }}</th>
                    </tr>

                    <tr>
                        <th style="border: 1px solid #333; padding: 8px; background:#f5f5f5; text-align:left;">OUTSTANDING
                            BALANCE</th>
                        <th colspan="2"
                            style="border: 1px solid #333; padding: 8px; background:#f5f5f5; text-align:left;">BDT
                            {{ number_format(optional($withdraw->shareholder)->outstanding_balance ?? 0, 2) }}</th>
                    </tr>

                    <tr>
                        <th style="border: 1px solid #333; padding: 8px; background:#f5f5f5; text-align:left;">WITHDRAW
                            AMOUNT IN WORD</th>
                        <th colspan="2"
                            style="border: 1px solid #333; padding: 8px; background:#f5f5f5; text-align:left;">
                            {{ $withdraw->amount_in_words ?? '-' }}</th>
                    </tr>

                </table>

                <!-- Additional Notes -->
                <div style="margin-bottom: 20px;">
                    <h5 style="font-weight: bold; margin-bottom: 8px;">Additional Notes:</h5>
                    <div
                        style="border: 1px solid #333; padding: 12px; min-height: 80px; background: #fafafa; line-height: 1.5;">
                        {!! nl2br(e($withdraw->remarks ?? '')) !!}
                    </div>
                </div>

                <!-- Status Badge -->
                <div style="margin-bottom: 20px;">
                    <strong>Status:</strong>
                    @if ($withdraw->status == 'pending')
                        <span
                            style="background-color: #ffc107; padding: 5px 10px; border-radius: 4px; color: black;">PENDING</span>
                    @elseif($withdraw->status == 'approved')
                        <span
                            style="background-color: #28a745; padding: 5px 10px; border-radius: 4px; color: white;">APPROVED</span>
                    @elseif($withdraw->status == 'rejected')
                        <span
                            style="background-color: #dc3545; padding: 5px 10px; border-radius: 4px; color: white;">REJECTED</span>
                    @endif
                </div>

                <!-- Signature Section -->
                <div style="margin-top: 100px;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 33%; text-align: center; padding-top: 20px; border-top: 1px solid #333;">
                                <strong>RECEIVER SIGNATURE</strong>
                            </td>
                            <td style="width: 33%; text-align: center;"></td>
                            <td style="width: 33%; text-align: center; padding-top: 20px; border-top: 1px solid #333;">
                                <strong>AUTHORITY SIGNATURE</strong>
                            </td>
                        </tr>
                    </table>
                    <table style="width: 100%; margin-top: 100px;">
                        <tr>
                            <td style="width: 33%; text-align: center; padding-top: 20px; border-top: 1px solid #333;">
                                <strong>WITNESS SIGNATURE</strong>
                            </td>
                            <td style="width: 33%; text-align: center;"></td>
                            <td style="width: 33%; text-align: center; padding-top: 20px; border-top: 1px solid #333;">
                                <strong>WITNESS SIGNATURE</strong>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- </div> --}}
    <!-- Action Buttons (No Print) -->
    <div style="margin-top: 30px; no-print">
        @if ($withdraw->status == 'pending')
            <button class="btn btn-success btn-approve" data-id="{{ $withdraw->id }}"
                data-url-approve="{{ route('admin.investment.withdraw.approve', $withdraw->id) }}"
                data-url-reject="{{ route('admin.investment.withdraw.reject', $withdraw->id) }}">Approve</button>
            <button class="btn btn-warning btn-reject" data-id="{{ $withdraw->id }}"
                data-url-approve="{{ route('admin.investment.withdraw.approve', $withdraw->id) }}"
                data-url-reject="{{ route('admin.investment.withdraw.reject', $withdraw->id) }}">Reject</button>
        @endif
        <a href="{{ route('admin.investment.withdraw.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <style>
        @media print {
            .sidebar {
                display: none !important;
            }

            .navbar {
                display: none !important;
            }

            .btn {
                display: none !important;
            }

            .no-print {
                display: none !important;
            }

            body {
                margin: 0;
                padding: 0;
                background: white;
            }

            #slipContainer {
                max-width: 100%;
            }
            .d-print-none, .copyright {
                display: none !important;
            }
            .tile {
                border: none !important;
                box-shadow: none !important;
            }
        }
    </style>
@endsection

@push('scripts')
    <script>
        $(function() {
            var actionUrl = null;
            $(document).on('click', '.btn-approve, .btn-reject', function(e) {
                e.preventDefault();
                actionUrl = $(this).hasClass('btn-approve') ? $(this).data('url-approve') : $(this).data(
                    'url-reject');
                $('#remarksModalLabel').text(($(this).hasClass('btn-approve') ? 'Approve' : 'Reject') +
                    ' Withdrawal');
                $('#remarks').val('');
                $('#remarksModal').modal('show');
            });

            $('#remarksForm').on('submit', function(e) {
                e.preventDefault();
                var remarks = $('#remarks').val();
                $.post(actionUrl, {
                        _token: '{{ csrf_token() }}',
                        remarks: remarks
                    })
                    .done(function() {
                        location.reload();
                    })
                    .fail(function() {
                        alert('Error');
                    });
            });
        });
    </script>
    <!-- Remarks modal -->
    <div class="modal fade" id="remarksModal" tabindex="-1" role="dialog" aria-labelledby="remarksModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="remarksModalLabel">Remarks</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="remarksForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="remarks">Remarks (optional)</label>
                            <textarea id="remarks" name="remarks" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush
