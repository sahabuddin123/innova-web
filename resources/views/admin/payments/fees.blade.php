@extends('admin.app')
 
@section('title') {{ $pageTitle }} @endsection
 
@section('content')
     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-users"></i> {{ $pageTitle }}</h1>
        </div>
        <div>
         {{-- <a href="{{ route('admin.shareholder.create') }}" class="btn btn-primary pull-right">All Investor</a> --}}
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-bordered text-center" id="sampleTable">
                        <thead>
                            <tr>
                                <th> Tnx ID </th>
                                <th>Image</th>
                                <th> Student Name </th>
                                <th> Pay Amount </th>
                                <th> Remarks </th>
                                <th> Pay Date </th>
                                <th> Status </th>
                                {{-- <th> Last Update </th> --}}
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fee as $fees)
                                    <tr>
                                        <td width='7%'>{{ $fees->id }}</td>
                                        @php
                                        $students = DB::table('students')->where('id',$fees->student_id)->first();
                                        @endphp
                                        <td><img src="{!! asset('public/storage/'.$students->image) !!}" alt="!"  height="35"></td>
                                        <td>{{ $students->sname }} </td>
                                        <td>{{ number_format($fees->paidamount, 2) }} </td>
                                        <td>
                                            @if($fees->channel == 2)
                                            {{ $fees->trxID}}
                                            @else
                                            {{ $fees->paidremark}}
                                            @endif
                                        </td>
                                        <td>
                                        @php
                                            $date = strtotime($fees->paiddate);
                                            $createDate = date('d-M-y', $date);
                                        @endphp
                                            {{ $createDate }}
                                        </td>
                                        <td>
                                        @if($fees->status == 0)
                                            <form action="{{ route('FessStatus', $fees->id) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="paidamount" value="{{$fees->paidamount}}">
                                                <input type="hidden" name="paymentType" value="{{$fees->paymentType}}">
                                                <input type="hidden" name="student_id" value="{{$fees->student_id}}">
                                                <button type="submit" class='btn btn-success' name="status" value="1">Approve</button>
                                            </form>
                                            @else
                                            <form action="{{ route('FessStatus', $fees->id) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="paidamount" value="{{$fees->paidamount}}">
                                                <input type="hidden" name="paymentType" value="{{$fees->paymentType}}">
                                                <input type="hidden" name="student_id" value="{{$fees->student_id}}">
                                                <button type="submit" class='btn btn-danger' name="status" value="0">Pending</button>
                                            </form>
                                            @endif
                                        </td>
                                        {{-- <td>
                                        @php
                                            $date = strtotime($fees->updated_at);
                                            $udateDate = date('d-M-y', $date);
                                        @endphp
                                            {{ $udateDate }}
                                    </td> --}}
                                        
                                       
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                <a href="{{ route('admin.fees.payslip', $fees->id) }}" class="btn btn-sm btn-info" title="View Payslip"><i class="fas fa-file-invoice"></i></a>
                                                <a href="{{ route('admin.fees.payslip.download', $fees->id) }}" class="btn btn-sm btn-success" title="Download Payslip"><i class="fas fa-download"></i></a>
                                                <a href="{{ route('admin.fees.edit', $fees->id) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable({order: [[1, 'desc']],});</script>
@endpush