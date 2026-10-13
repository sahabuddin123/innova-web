@extends('admin.app')
 
@section('title') {{ $pageTitle }} @endsection
 
@section('content')
     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-book-open"></i> {{ $pageTitle }}</h1>
        </div>
        <div>
        <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary pull-right">Add Image</a>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body overflow-auto">
                    <table class="table table-bordered text-center"  id="sampleTable">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Image </th>
                                <th> Category </th>
                                <th> Status </th>
                                <th> Create At </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $item)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>
                                            @if($item->image != "")
                                            <div class="popup-gallery">
                                                <a href="{!! asset('public/storage/'.$item->image) !!}" title="{{$item->title}}">
                                                    <img src="{!! asset('public/storage/'.$item->image) !!}" alt="!"  height="70">
                                                </a>
                                            </div>
                                            @else
                                                no image
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->type == 0)
                                                <b class="text-primary">আমাদের প্রিমিসেস</b>
                                            @elseif($item->type == 1)
                                                <b class="text-info">ফেয়ারওয়েল</b>
                                            @elseif($item->type == 2)
                                                <b class="text-warning">ইভেন্ট</b>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->IsActive == 1)
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
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                <a href="{{ route('admin.gallery.edit', $item->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                <a href="{{ route('admin.gallery.delete', $item->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
    <script type="text/javascript">$('#sampleTable').DataTable({order: [[0, 'desc']],});</script>
@endpush