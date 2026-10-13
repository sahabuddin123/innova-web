@extends('admin.app')
@section('content')
    {{-- <h1 class="h3">Edit Dividend Withdraw #</h1> --}}
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-money-bill-alt"></i> {{ $pageTitle }} - #{{ $withdraw->id }}
        </h1>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <div class="tile-body">
                    <form action="{{ route('admin.dividend.withdraw.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $withdraw->id }}">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" step="0.01" name="amount" value="{{ $withdraw->amount }}"
                                class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Withdraw Date</label>
                            <input type="date" name="withdraw_date" value="{{ $withdraw->withdraw_date }}"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Payer name</label>
                            <input type="text" name="method" value="{{ $withdraw->method }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Receiver Name</label>
                            <input type="text" name="receiver_name" value="{{ $withdraw->receiver_name ?? '' }}"
                                class="form-control" placeholder="Name of person receiving payment">
                        </div>
                        <div class="form-group">
                            <label>Branch Name</label>
                            <input type="text" name="branch_name" value="{{ $withdraw->branch_name ?? '' }}" class="form-control" placeholder="Branch name (optional)">
                        </div>
                        <div class="form-group">
                            <label>Payment Method</label>
                            <select name="pay_by" class="form-control">
                                <option value="">Select</option>
                                <option value="bank" @if ($withdraw->pay_by == 'bank') selected @endif>Bank Transfer
                                </option>
                                <option value="bkash" @if ($withdraw->pay_by == 'bkash') selected @endif>bKash</option>
                                <option value="nagad" @if ($withdraw->pay_by == 'nagad') selected @endif>Nagad</option>
                                <option value="cash" @if ($withdraw->pay_by == 'cash') selected @endif>Cash</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Attachment (optional)</label>
                            @if ($withdraw->attachment)
                                <p><a href="{{ asset('storage/' . $withdraw->attachment) }}" target="_blank">Existing file</a>
                                </p>
                            @endif
                            <input type="file" name="attachment" class="form-control-file">
                        </div>
                        <div class="form-group">
                            <label>Account Number</label>
                            <input type="text" name="account_number" value="{{ $withdraw->account_number }}"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="pending" @if ($withdraw->status == 'pending') selected @endif>Pending</option>
                                <option value="approved" @if ($withdraw->status == 'approved') selected @endif>Approved</option>
                                <option value="rejected" @if ($withdraw->status == 'rejected') selected @endif>Rejected</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Remarks</label>
                            <textarea name="remarks" class="form-control" rows="3">{{ $withdraw->remarks }}</textarea>
                        </div>
                        <button class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.dividend.withdraw.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
