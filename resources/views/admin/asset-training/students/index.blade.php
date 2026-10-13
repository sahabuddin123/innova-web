@extends('admin.app')

@section('title')
    {{ $pageTitle }}
@endsection

@section('content')
<style>
    .form-control{
        padding: 5px 10px;
    }
</style>
    @include('admin.partials.flash')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">{{ $pageTitle }}</h1>
            <p class="text-muted mb-0">Manage registrations, update call types, add feedback, and track student status quickly.</p>
        </div>
    </div>

    <div class="card mb-4 shadow-sm asset-filter-card p-4">
        <form method="GET" class="row gx-3 gy-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Search</label>
                <input type="text" name="q" class="form-control" value="{{ $search }}" placeholder="Search name, email, phone">
            </div>
            <div class="col-md-2">
                <label class="form-label">Course</label>
                <select name="course_id" class="form-control">
                    <option value="">All Courses</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->name }}" {{ $courseId == $course->name ? 'selected' : '' }}>{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="registration_status" class="form-control">
                    <option value="">All Status</option>
                    @foreach(['Pending','Contacted','Converted','Follow Up','Follow Up Later','Lost','Not Qualified','Qualified','Service','Wrong Number','Not Interested','Canceled','Don\'t Call Again'] as $statusOption)
                        <option value="{{ $statusOption }}" {{ $status == $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Call Type</label>
                <select name="call_type" class="form-control">
                    <option value="">All Call Types</option>
                    @foreach(['1st call','2nd call','3rd call','4th call','5th call'] as $callTypeOption)
                        <option value="{{ $callTypeOption }}" {{ $callType == $callTypeOption ? 'selected' : '' }}>{{ $callTypeOption }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                <div class="mb-2 mb-md-0 text-muted">Showing {{ $students->count() }} of {{ $students->total() }} registrations</div>
                <div class="text-end text-muted small">
                    Call types: {{ $students->where('call_type', '!=', null)->count() }} &middot; Use filters above to refine results.
                </div>
            </div>
            <div class="table-responsive">
                @if($students->count())
                    <table class="table table-bordered table-hover table-sm admin-asset-table" id="assetStudentsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>WhatsApp</th>
                            <th>Call Type</th>
                            <th>Status</th>
                            <th>Feedback</th>
                            <th>Registered At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                                    <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $student->full_name }}</td>
                                <td>{{ $student->course }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->mobile }}</td>
                                <td>{{ $student->whatsapp ?? 'N/A' }}</td>
                                <td>
                                    <div>{{ $student->call_type ?? 'N/A' }}</div>
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-1 w-100 js-open-calltype-modal" data-id="{{ $student->id }}" data-name="{{ $student->full_name }}" data-call_type="{{ $student->call_type }}">Update</button>
                                </td>
                                <td>
                                    <div><span class="badge badge-{{ in_array($student->registration_status, ['Qualified','Converted']) ? 'success' : ($student->registration_status == 'Lost' || $student->registration_status == 'Rejected' || $student->registration_status == 'Not Qualified' ? 'danger' : 'secondary') }}">{{ $student->registration_status }}</span></div>
                                    <button type="button" class="btn btn-sm btn-outline-warning mt-1 w-100 js-open-status-modal" data-id="{{ $student->id }}" data-status="{{ $student->registration_status }}" data-name="{{ $student->full_name }}">Change</button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-success w-100 js-open-feedback-modal" data-id="{{ $student->id }}" data-name="{{ $student->full_name }}">Add / Edit</button>
                                </td>
                                <td>{{ $student->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.asset-training.students.show', $student->id) }}" class="btn btn-sm btn-info">View</a>
                                    <form action="{{ route('admin.asset-training.students.delete', $student->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this registration?');">
                                        @csrf
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                @else
                    <div class="text-center py-5 text-muted">
                        No ASSET registrations match your current filter. Try changing the search, course, status, or call type.
                    </div>
                @endif
                {{ $students->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Update Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="statusForm" method="POST" action="">
                    @csrf
                    <input type="hidden" name="redirect_to" value="index">
                    <div class="modal-body">
                        <p id="statusStudentName" class="font-weight-bold"></p>
                        <div class="mb-3">
                            <label for="modal_registration_status" class="form-label">Registration Status</label>
                            <select id="modal_registration_status" name="registration_status" class="form-control" required>
                                @foreach(['Pending','Contacted','Converted','Follow Up','Follow Up Later','Lost','Not Qualified','Qualified','Service','Wrong Number','Not Interested','Canceled','Don\'t Call Again'] as $statusOption)
                                    <option value="{{ $statusOption }}">{{ $statusOption }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="feedbackModalLabel">Add Feedback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="feedbackForm" method="POST" action="">
                    @csrf
                    <input type="hidden" name="redirect_to" value="index">
                    <div class="modal-body">
                        <p id="feedbackStudentName" class="font-weight-bold"></p>
                        <div class="mb-3">
                            <label for="modal_feedback_step" class="form-label">Feedback Step</label>
                            <select id="modal_feedback_step" name="feedback_step" class="form-control" required>
                                <option value="1">1st</option>
                                <option value="2">2nd</option>
                                <option value="3">3rd</option>
                                <option value="4">4th</option>
                                <option value="5">5th</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="modal_feedback" class="form-label">Feedback</label>
                            <textarea id="modal_feedback" name="feedback" rows="4" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="callTypeModal" tabindex="-1" role="dialog" aria-labelledby="callTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="callTypeModalLabel">Update Call Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="callTypeForm" method="POST" action="">
                    @csrf
                    <div class="modal-body">
                        <p id="callTypeStudentName" class="font-weight-bold"></p>
                        <div class="mb-3">
                            <label for="modal_call_type" class="form-label">Call Type</label>
                            <select id="modal_call_type" name="call_type" class="form-control" required>
                                @foreach(['1st call','2nd call','3rd call','4th call','5th call'] as $callTypeOption)
                                    <option value="{{ $callTypeOption }}">{{ $callTypeOption }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .asset-filter-card { background: #ffffff; border: 1px solid #e3e6f0; border-radius: 18px; padding: 32px; }
    .asset-filter-card .form-label { font-weight: 600; color: #4e73df; }
    .asset-filter-card .form-control { min-height: 46px; border-radius: 0.85rem; }
    .asset-filter-card .btn { min-height: 46px; }
    .admin-asset-table th { background-color: #f8f9fc; color: #5a5c69; }
    .admin-asset-table tbody tr:hover { background-color: #f2f4fb; }
    .admin-asset-table td, .admin-asset-table th { vertical-align: middle; }
    .admin-asset-table .btn { min-width: 90px; }
    .modal .modal-content { border-radius: 1.05rem; }
    .modal .modal-header .close { outline: none; }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('#assetStudentsTable').DataTable({
            responsive: true,
            paging: false,
            searching: true,
            info: false,
            order: [[0, 'desc']],
        });

        var baseUrl = '{{ url("admin/asset-training/students") }}';

        $('.js-open-status-modal').on('click', function() {
            var studentId = $(this).data('id');
            var studentName = $(this).data('name');
            var currentStatus = $(this).data('status');
            var actionUrl = baseUrl + '/' + studentId + '/status';

            $('#statusStudentName').text('Update status for: ' + studentName);
            $('#statusForm').attr('action', actionUrl);
            $('#modal_registration_status').val(currentStatus);
            $('#statusModal').modal('show');
        });

        $('.js-open-feedback-modal').on('click', function() {
            var studentId = $(this).data('id');
            var studentName = $(this).data('name');
            var actionUrl = baseUrl + '/' + studentId + '/feedback';

            $('#feedbackStudentName').text('Add feedback for: ' + studentName);
            $('#feedbackForm').attr('action', actionUrl);
            $('#modal_feedback_step').val('1');
            $('#modal_feedback').val('');
            $('#feedbackModal').modal('show');
        });

        $('.js-open-calltype-modal').on('click', function() {
            var studentId = $(this).data('id');
            var studentName = $(this).data('name');
            var currentCallType = $(this).data('call_type');
            var actionUrl = baseUrl + '/' + studentId + '/call-type';

            $('#callTypeStudentName').text('Update call type for: ' + studentName);
            $('#callTypeForm').attr('action', actionUrl);
            $('#modal_call_type').val(currentCallType || '1st call');
            $('#callTypeModal').modal('show');
        });
    });
</script>
@endpush
