@extends('admin.app')

@section('title')
    {{ $pageTitle }}
@endsection

@section('content')
    <style scoped>
        #bulkDeleteBtn{
            display: none !important;
        }
        .pagination {
            justify-content: flex-end !important;
        }
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            white-space: nowrap;
            vertical-align: middle;
        }
        .table thead th.sortable {
            cursor: pointer;
            user-select: none;
            transition: background-color 0.2s;
        }
        .table thead th.sortable:hover {
            background-color: #e9ecef !important;
        }
        .table thead th .sort-icon {
            margin-left: 5px;
            opacity: 0.5;
        }
        .table thead th.sorted .sort-icon {
            opacity: 1;
            color: #4e73df;
        }
        
        /* DataTables Length (Show entries) */
        .dataTables_length {
            float: left;
            margin-bottom: 15px;
            display: none
        }
        .dataTables_length label {
            font-weight: 500;
            color: #333;
        }
        .dataTables_length select {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 6px 10px;
            margin: 0 5px;
            background-color: #fff;
            color: #333;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .dataTables_length select:focus {
            border-color: #4e73df;
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        /* DataTables Filter (Search) */
        .dataTables_filter {
            float: right;
            margin-bottom: 15px;
        }
        .dataTables_filter label {
            font-weight: 500;
            color: #333;
        }
        .dataTables_filter input {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 8px 12px;
            width: 250px;
            font-size: 14px;
            color: #333;
            transition: all 0.2s;
        }
        .dataTables_filter input:focus {
            border-color: #4e73df;
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        .dataTables_filter input::placeholder {
            color: #999;
        }
        
        /* DataTables Buttons */
        .dt-buttons {
            float: left;
            margin-bottom: 15px;
        }
        .dt-buttons .btn {
            border-radius: 4px;
            padding: 8px 15px;
            font-size: 13px;
            font-weight: 500;
            margin-right: 5px;
            transition: all 0.2s;
        }
        .dt-buttons .btn buttons-copy {
            background-color: #17a2b8;
            border-color: #17a2b8;
            color: #fff;
        }
        .dt-buttons .btn buttons-copy:hover {
            background-color: #138496;
            border-color: #138496;
        }
        .dt-buttons .btn buttons-excel {
            background-color: #28a745;
            border-color: #28a745;
            color: #fff;
        }
        .dt-buttons .btn buttons-excel:hover {
            background-color: #218838;
            border-color: #218838;
        }
        .dt-buttons .btn buttons-csv {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        }
        .dt-buttons .btn buttons-csv:hover {
            background-color: #0069d9;
            border-color: #0069d9;
        }
        .dt-buttons .btn buttons-pdf {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }
        .dt-buttons .btn buttons-pdf:hover {
            background-color: #c82333;
            border-color: #c82333;
        }
        .dt-buttons .btn buttons-print {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #fff;
        }
        .dt-buttons .btn buttons-print:hover {
            background-color: #5a6268;
            border-color: #5a6268;
        }
        .dt-buttons .btn buttons-colvis {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #333;
        }
        .dt-buttons .btn buttons-colvis:hover {
            background-color: #e0a800;
            border-color: #e0a800;
        }
        
        /* DataTables Info & Pagination */
        .dataTables_info {
            float: left;
            padding-top: 10px;
            color: #666;
            font-size: 13px;
        }
        .dataTables_paginate {
            float: right;
            padding-top: 10px;
        }
        .dataTables_paginate .paginate_button {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 6px 12px;
            margin: 0 3px;
            color: #333;
            cursor: pointer;
            transition: all 0.2s;
        }
        .dataTables_paginate .paginate_button:hover {
            background-color: #e9ecef;
            border-color: #dee2e6;
        }
        .dataTables_paginate .paginate_button.current {
            background-color: #4e73df;
            border-color: #4e73df;
            color: #fff !important;
        }
        .dataTables_paginate .paginate_button.disabled {
            color: #ccc;
            cursor: not-allowed;
        }
        
        /* Clearfix for DataTables */
        .tile-body::after {
            content: "";
            display: table;
            clear: both;
        }
        .tile-body {
            overflow-x: auto !important;
        }
        #studentTable {
            min-width: 1300px;
        }
        #studentTable img {
            max-width: 70px;
            height: auto;
            display: block;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('backend/css/lightbox-popup.css') }}">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-users"></i> {{ $pageTitle }}</h1>
        </div>
        <div>
            <a href="{{ route('admin.students.create') }}" class="btn btn-primary pull-right">Add Students</a>
            <a href="{{ route('admin.students.index') }}" class="btn btn-success pull-right">All Students</a>
        </div>
    </div>
    <div id="flash_message"></div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">

            <div class="tile">

                <div class="tile-body overflow-auto">
                    <button id="bulkDeleteBtn" class="btn btn-danger mb-2">Bulk Delete</button>
                    <table id="studentTable" class="table table-bordered display nowrap" style="width:100%; min-width:1300px;">
                        <thead>
                            <tr>
                                {{-- <th><input type="checkbox" id="selectAll"></th> --}}
                                <th class="sortable" data-sort="id"> # <span class="sort-icon"><i class="fas fa-sort"></i></span></th>
                                <th class="sortable" data-sort="image"> Image <span class="sort-icon"><i class="fas fa-sort"></i></span></th>
                                <th class="sortable" data-sort="name"> Students name <span class="sort-icon"><i class="fas fa-sort"></i></span></th>
                                <th class="sortable" data-sort="phone"> Phone Number <span class="sort-icon"><i class="fas fa-sort"></i></span></th>
                                <th class="sortable" data-sort="batch"> Batch No <span class="sort-icon"><i class="fas fa-sort"></i></span></th>
                                <th class="sortable" data-sort="course"> Course Name <span class="sort-icon"><i class="fas fa-sort"></i></span></th>
                                <th class="sortable" data-sort="status"> Status <span class="sort-icon"><i class="fas fa-sort"></i></span></th>
                                <th class="sortable" data-sort="due"> Total Due <span class="sort-icon"><i class="fas fa-sort"></i></span></th>
                                <th class="sortable" data-sort="date"> Admission Date <span class="sort-icon"><i class="fas fa-sort"></i></span></th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i
                                        class="fa fa-bolt"> </i> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $course)
                                <tr>
                                    {{-- <td><input type="checkbox" class="row-select" value="{{ $course->id }}"></td> --}}
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>
                                        <div class="popup-gallery">
                                            @if (!empty($course->image))
                                                <a href="{!! asset('public/storage/' . $course->image) !!}" title="{{ $course->sname }}">
                                                    <img src="{!! asset('public/storage/' . $course->image) !!}" alt="{{ $course->sname }}" height="70">
                                                </a>
                                            @else
                                                <a href="{{ asset('backend/img/undraw_profile.svg') }}" title="No Image">
                                                    <img src="{{ asset('backend/img/undraw_profile.svg') }}" alt="No Image" height="70">
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $course->sname }} </td>
                                    <td>88{{ "".$course->phone ?? 'N/A' }}</td>
                                    <td>
                                        @if($course->batch)
                                            {{ $course->batch->batchnum }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($course->course)
                                            {{ $course->course->name }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            if ($course->IsActive == 1) {
                                                $status = "<span class='text-success'>Regular</span>";
                                            } elseif ($course->IsActive == 2) {
                                                $status = "<span class='text-info'>Iregular</span>";
                                            } elseif ($course->IsActive == 3) {
                                                $status = "<span class='text-primary'>Complete</span>";
                                            } elseif ($course->IsActive == 4) {
                                                $status = "<span class='text-danger'>Restricted</span>";
                                            } elseif ($course->IsActive == 5) {
                                                $status = "<span class='text-warning'>Postponded</span>";
                                            }
                                        @endphp
                                        <b>{!! $status !!}</b>
                                    </td>
                                    {{-- <td>
                                        @php
                                            $pay = DB::table('fees_transections')
                                                ->where('student_id', $course->id)
                                                ->where('paymentType', 1)
                                                ->sum('paidamount');
                                        @endphp
                                        <span class="text-success"> {{ number_format($pay, 2) }}</span>
                                    </td> --}}
                                    <td>
                                        @php
                                            $pay = $course->latestPayment ? $course->latestPayment->paidamount : 0;
                                            $due = $course->balance - $pay;
                                        @endphp
                                        <b class="text-danger">{{ number_format($due, 2) }}</b>
                                    </td>
                                    <td>
                                        
                                        @php
                                            $date = strtotime($course->admission_date);
                                            $createDate = date('d-M-y', $date);
                                        @endphp
                                        {{ $createDate }}
                                    </td>
                                    {{-- <td>
                                        @php
                                            $date = strtotime($course->updated_at);
                                            $updateDate = date('d-M-y', $date);
                                        @endphp
                                        {{ $updateDate }}
                                    </td> --}}
                                   


                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Second group">
                                            <div class="dropdown">
                                                <a href="#" class="btn btn-sm btn-primary dropdown-toggle"
                                                    id="sms-menu" data-toggle="dropdown"><i class="fas fa-envelope"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="#sms-menu">
                                                    <a href="javascript:void(0)" id="dueSms"
                                                        data-id="{{ $course->id }}" value="{{ $course->id }}"
                                                        class="dropdown-item" title="Send Due SMS">Due Remainder</a>
                                                    <a href="javascript:void(0)" id="remainderSms"
                                                        data-id="{{ $course->id }}" value="{{ $course->id }}"
                                                        class="dropdown-item" title="Class Remainder">Today Class
                                                        Remainder</a>
                                                    <a href="javascript:void(0)" id="scheduleSms"
                                                        data-id="{{ $course->id }}" value="{{ $course->id }}"
                                                        class="dropdown-item" title="New Class Schedule">New Schedule
                                                        Remainder</a>
                                                    <a href="javascript:void(0)" id="postpondSms"
                                                        data-id="{{ $course->id }}" value="{{ $course->id }}"
                                                        class="dropdown-item" title="Today Class Postponded">Today Postpond
                                                        Remainder</a>
                                                    <a href="javascript:void(0)" id="TomorrowpostpondSms"
                                                        data-id="{{ $course->id }}" value="{{ $course->id }}"
                                                        class="dropdown-item" title="Tomorrow Class Postponded">Tomorrow
                                                        Postpond Remainder</a>
                                                </div>
                                            </div>
                                            <a href="{{ route('admin.students.view', $course->id) }}"
                                                class="btn btn-sm btn-info" title="View Student"><i
                                                    class="fa fa-eye"></i></a>
                                            @if ($course->IsRegister == 1)
                                                <a href="{{ route('admin.registration.create', $course->id) }}"
                                                    class="btn btn-sm btn-warning text-danger" title="Make Registration"><i
                                                        class="fa fa-certificate"></i></a>
                                            @endif
                                            <a href="{{ route('admin.students.edit', $course->id) }}"
                                                class="btn btn-sm btn-primary" title="Edit Student Information"><i
                                                    class="fa fa-edit"></i></a>

                                            <a href="#" class="btn btn-sm btn-danger deletestudents"
                                                data-toggle="modal" data-target="#deleteStudent"
                                                data-url="{{ route('admin.students.delete', $course->id) }}"
                                                title="Delete Student Information"><i
                                                    class="fa fa-trash"></i></a>
                                            {{-- <a class="dropdown-item" href="#{{ route('admin.students.delete', $course->id) }}" data-toggle="modal" data-target="#logoutModal">
                                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                                    Logout
                                                </a> --}}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $students->links() }}

                </div>
            </div>
        </div>
    </div>
    <!-- Logout Modal-->
    <div class="modal fade" id="deleteStudent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are You Sure?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Click "Delete" below if you are Delete.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form id="deleteStudentForm" method="POST" style="display:inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/custom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/lightbox-popup.min.js') }}"></script>
    <!-- DataTables Buttons CDN -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.deletestudents', function(e) {
                e.preventDefault();
                var da = $(this).data('url');
                $("#deleteStudentForm").attr('action', da);
            });
            $('.popup-gallery').magnificPopup({
                delegate: 'a',
                type: 'image',
                tLoading: 'Loading image #%curr%...',
                mainClass: 'mfp-img-mobile',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1]
                },
                image: {
                    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                    titleSrc: function(item) {
                        return item.el.attr('title');
                    }
                }
            });

            // DataTable initialization with all required buttons
            var table = $('#studentTable').DataTable({
                dom: 'Blfrtip',
                buttons: [
                    'pageLength',
                    'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print',
                    'colvis'
                ],
                order: [
                    [1, 'asc']
                ],
                responsive: false,
                scrollX: true,
                scrollCollapse: true,
                autoWidth: false,
                columnDefs: [
                    { targets: '_all', defaultContent: '' }
                ]
            });

            // Table header sorting with visual feedback
            $('.table thead th.sortable').on('click', function() {
                var column = $(this).data('sort');
                var currentOrder = table.order()[0];
                var icon = $(this).find('.sort-icon i');
                
                // Remove sorted class from all headers
                $('.table thead th.sortable').removeClass('sorted');
                $(this).addClass('sorted');
                
                // Toggle sort direction
                if (currentOrder && currentOrder[0] === table.column(column).index()) {
                    if (currentOrder[1] === 'asc') {
                        table.order([column, 'desc']).draw();
                        icon.removeClass('fa-sort').addClass('fa-sort-up');
                    } else {
                        table.order([column, 'asc']).draw();
                        icon.removeClass('fa-sort-up').addClass('fa-sort-down');
                    }
                } else {
                    table.order([column, 'asc']).draw();
                    icon.removeClass('fa-sort').addClass('fa-sort-up');
                }
                
                // Reset other icons
                $('.table thead th.sortable').not(this).find('.sort-icon i')
                    .removeClass('fa-sort-up fa-sort-down')
                    .addClass('fa-sort');
            });

            // Select/Deselect all rows
            $('#selectAll').on('click', function() {
                $('.row-select').prop('checked', this.checked);
            });

            // Bulk Delete
            $('#bulkDeleteBtn').on('click', function() {
                var ids = [];
                $('.row-select:checked').each(function() {
                    ids.push($(this).val());
                });
                if (ids.length > 0) {
                    if (confirm('Are you sure you want to delete selected students?')) {
                        // TODO: AJAX call to bulk delete route
                        // $.post('/admin/students/bulk-delete', {ids: ids, _token: '{{ csrf_token() }}'}, function(response){ location.reload(); });
                        alert('Selected IDs: ' + ids.join(', '));
                    }
                } else {
                    alert('No students selected!');
                }
            });
        });
    </script>
@endpush
