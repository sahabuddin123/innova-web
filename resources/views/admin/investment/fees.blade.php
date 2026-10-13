@extends('admin.app')
 
@section('title') {{ $pageTitle }} @endsection
 
@section('content')
     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-users"></i> {{ $pageTitle }}</h1>
        </div>
        <div>
            <a href="{{ route('admin.shareholder.index') }}" class="btn btn-primary pull-right">All Investor</a>
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
                                <th> Documents</th>
                                <th> Investor Name </th>
                                <th> Pay Amount </th>
                                <th> Pay Date </th>
                                <th> Status </th>
                                {{-- <th> Last Update </th> --}}
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invesments as $fees)
                                    <tr>
                                        <td width='7%'>{{ $fees->id }}</td>
                                        <td>
                                            @if($fees->image != null)
                                            <img src="{!! asset('public/storage/'.$fees->image) !!}" alt="!"  height="35">
                                            @else
                                            Documents Not Added
                                            @endif
                                        </td>
                                        
                                        <td>{{ $fees->ShareHolderInfo->first()->name }} </td>
                                        <td>{{ number_format($fees->amount, 2) }} </td>
                                        <td>
                                        @php
                                            $date = strtotime($fees->paiddate);
                                            $createDate = date('d-M-y', $date);
                                        @endphp
                                            {{ $createDate }}
                                        </td>
                                        <td>
                                            @if($fees->isActive == 1)
                                               <b><span class='text-success'>Approved</span></b>
                                            
                                            @elseif($fees->isActive == 2)
                                               <b><span class='text-info'>Pending</span></b>
                                            
                                            @elseif($fees->isActive == 3)
                                                <b><span class='text-primary'>Postponded</span></b>
                                            
                                            @elseif($fees->isActive == 0)
                                                <b><span class='text-danger'>Waiting for approval</span></b>
                                            
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                <a href="{{ route('admin.investment.edit', $fees->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                                <a href="{{ route('admin.investment.delete', $fees->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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