@extends('admin.app')

@section('title')
    {{ $pageTitle }}
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-book-open"></i> {{ $pageTitle }}</h1>
        </div>
        <div>
            <a href="{{ route('admin.seminorreg.create') }}" class="btn btn-primary pull-right">Add seminor Registration</a>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body overflow-auto">
                    <table class="table table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Seminor Name </th>
                                <th> Seminor Date </th>
                                <th> Student Name </th>
                                <th> Has Call </th>
                                <th> Has Attand </th>
                                <th> Has Convance </th>
                                <th> Has Active </th>
                                <th> Create At </th>
                                <th> Last Update </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i
                                        class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>
                                        {{ $item->Seminors->title }}
                                    </td>
                                    <td>

                                        @php
                                            $seminorDate = \Carbon\Carbon::parse($item->Seminors->date)->format(
                                                'd-M-Y',
                                            );
                                        @endphp
                                        {{ $seminorDate }}
                                    </td>
                                    <td>
                                        {{ $item->username }}
                                    </td>
                                    <td>
                                        @if ($item->isCall == 1)
                                            <b class="text-success">Yes</b>
                                        @else
                                            <b class="text-danger">No</b>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->isAttand == 1)
                                            <b class="text-success">Yes</b>
                                        @else
                                            <b class="text-danger">No</b>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->isConvance == 1)
                                            <b class="text-success">Yes</b>
                                        @else
                                            <b class="text-danger">No</b>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->IsActive == 1)
                                            <b class="text-success">Active</b>
                                        @else
                                            <b class="text-danger">Deactive</b>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $createDate = date_format($item->created_at, 'd-M-Y');
                                        @endphp
                                        {{ $createDate }}
                                    </td>
                                    <td>
                                        @php
                                            $updateDate = date_format($item->updated_at, 'd-M-Y');
                                        @endphp
                                        {{ $updateDate }}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Second group">
                                            <a href="{{ route('admin.seminorreg.edit', $item->id) }}"
                                                class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('admin.seminorreg.delete', $item->id) }}"
                                                class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
    <script type="text/javascript">
        $('#sampleTable').DataTable({
            order: [
                [0, 'desc']
            ],
        });
    </script>
@endpush
