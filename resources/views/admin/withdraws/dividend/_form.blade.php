<form id="dividendWithdrawForm" action="{{ route('admin.dividend.withdraw.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label>Shareholder</label>
        <select name="shareholder_id" class="form-control" required>
            <option value="">Select shareholder</option>
            @foreach(App\Models\Shareholder::where('deleted_at',null)->get() as $s)
                <option value="{{ $s->id }}" @if(isset($shareHolder) && $shareHolder->id == $s->id) selected @endif>{{ $s->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Amount</label>
        <input type="number" step="0.01" name="amount" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Withdraw Date</label>
        <input type="date" name="withdraw_date" class="form-control">
    </div>
    <div class="form-group">
        <label>Payer Name</label>
        <input type="text" name="method" class="form-control">
    </div>
    <div class="form-group">
        <label>Receiver Name</label>
        <input type="text" name="receiver_name" class="form-control" placeholder="Name of person receiving payment">
    </div>
    <div class="form-group">
        <label>Branch Name</label>
        <input type="text" name="branch_name" class="form-control" placeholder="Branch name (optional)">
    </div>
    <div class="form-group">
        <label>Payment Method</label>
        <select name="pay_by" class="form-control">
            <option value="">Select</option>
            <option value="bank">Bank Transfer</option>
            <option value="bkash">bKash</option>
            <option value="nagad">Nagad</option>
            <option value="cash">Cash</option>
        </select>
    </div>
    <div class="form-group">
        <label>Attachment (optional)</label>
        <input type="file" name="attachment" class="form-control-file">
    </div>
    <div class="form-group">
        <label>Account Number</label>
        <input type="text" name="account_number" class="form-control">
    </div>
    <div class="form-group">
        <label>Remarks</label>
        <textarea name="remarks" class="form-control" rows="3"></textarea>
    </div>
    <div class="text-right">
        <button class="btn btn-primary" type="submit">Create</button>
    </div>
</form>
