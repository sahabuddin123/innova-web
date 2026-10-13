@extends('admin.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h3">Investment Withdraw Requests</h1>
    <a href="{{ route('admin.investment.withdraw.create', 0) }}" class="btn btn-primary">New Withdraw</a>
</div>
<div class="card">
        <div id="flash_message"></div>
    @include('admin.partials.flash')
    <div class="card-body">
        <table class="table table-bordered" id="withdrawTable" data-base-url="{{ url('admin/investment-withdraw') }}">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Shareholder</th>
                    <th>Amount</th>
                    <th>Withdraw Date</th>
                    <th>Payer Name</th>
                    <th>Receiver Name</th>
                    <th>Status</th>
                    <th>Requested At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
        $(document).ready(function(){
                var baseUrl = $('#withdrawTable').data('base-url');
                var storageBase = {!! json_encode(asset('storage')) !!};
                var table = $('#withdrawTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: { url: '{{ route("admin.investment.withdraw.data") }}', type: 'GET' },
                    columns: [
                        { data: 0 },
                        { data: 1 },
                        { data: 2 },
                        { data: 3 },
                        { data: 4 },
                        { data: 5 },
                        { data: 6 },
                        { data: 7, orderable: false, searchable: false },
                        { data: 8, orderable: false, searchable: false }
                    ]
                });

                var actionType = null; // 'approve' or 'reject'
                var actionUrl = null;
                var currentId = null;
                var currentRow = null;

                // open modal for approve/reject (delegated)
                $(document).on('click', '.btn-approve, .btn-reject', function(e){
                        e.preventDefault();
                        var $btn = $(this);
                        currentId = $btn.data('id');
                        actionType = $btn.hasClass('btn-approve') ? 'approve' : 'reject';
                        actionUrl = baseUrl + '/' + currentId + '/' + actionType;
                        currentRow = table.row($btn.closest('tr'));
                        $('#remarksModalLabel').text(actionType.charAt(0).toUpperCase() + actionType.slice(1) + ' Withdraw');

                        // fetch withdraw details and populate modal
                        $.get(baseUrl + '/' + currentId + '/json', function(resp){
                            var w = resp.withdraw;
                            var html = '';
                            html += '<p><strong>Shareholder:</strong> ' + (w.shareholder ? w.shareholder.name : '') + '</p>';
                            html += '<p><strong>Amount:</strong> ' + (w.amount ? parseFloat(w.amount).toFixed(2) : '') + '</p>';
                            html += '<p><strong>Withdraw Date:</strong> ' + (w.withdraw_date || '-') + '</p>';
                            html += '<p><strong>Method:</strong> ' + (w.method || '-') + '</p>';
                            html += '<p><strong>Pay By:</strong> ' + (w.pay_by || '-') + '</p>';
                            html += '<p><strong>Account:</strong> ' + (w.account_number || '-') + '</p>';
                            if (w.attachment) {
                                html += '<p><strong>Attachment:</strong> <a href="' + (storageBase + '/' + w.attachment) + '" target="_blank">Download</a></p>';
                            }
                            html += '<hr/>';
                            $('#withdrawDetails').html(html);
                            $('#remarks').val('');
                            $('#remarksModal').modal('show');
                        });
                });

                // submit modal via AJAX and update row without full reload
                $('#remarksForm').on('submit', function(e){
                        e.preventDefault();
                        var remarks = $('#remarks').val();
                        $.post(actionUrl, { _token: '{{ csrf_token() }}', remarks: remarks }, function(resp){
                                // show flash message at top
                                if (resp && resp.message) {
                                    var alertHtml = '<div class="alert alert-success alert-dismissible" role="alert">'
                                        + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                                        + resp.message + '</div>';
                                    $('#flash_message').html(alertHtml);
                                    setTimeout(function(){ $('#flash_message .alert').fadeOut(); }, 4000);
                                }
                                // fetch updated row data and replace
                                $.get(baseUrl + '/' + currentId + '/json', function(newResp){
                                    if (currentRow) {
                                        currentRow.data(newResp.data).draw(false);
                                    } else {
                                        table.ajax.reload(null, false);
                                    }
                                    $('#remarksModal').modal('hide');
                                });
                        }).fail(function(){
                                alert('Error processing request');
                        });
                });
        });
</script>

<!-- Remarks modal with details -->
<div class="modal fade" id="remarksModal" tabindex="-1" role="dialog" aria-labelledby="remarksModalLabel" aria-hidden="true">
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
                <div id="withdrawDetails" class="mb-3"></div>
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

