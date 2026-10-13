@extends('admin.app')
 
@section('title') {{ $pageTitle }} @endsection

@section('content')
<link rel="stylesheet" href="{{asset('backend/css/lightbox-popup.css')}}">
     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-users"></i> {{ $pageTitle }}</h1>
        </div>
        <div>
        <a href="{{ route('admin.stuff.create') }}" class="btn btn-primary pull-right">Add Stuff</a>
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
                                <th> Image </th>
                                <th> Employee Name </th>
                                <th> Designation </th>
                                <th> Subjects</th>
                                {{-- <th> Departments </th> --}}
                                <th> Contract Type</th>
                                <th> Phone Number </th>
                                <th> Status</th>
                                <th> Last Update </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stuff as $course)
                           
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>
                                            <div class="popup-gallery">
                                                <a href="{!! asset('public/storage/'.$course->image) !!}" title="{{ $course->name }}">
                                                    <img src="{!! asset('public/storage/'.$course->image) !!}" alt="!"  height="70">
                                                </a>
                                            </div>
                                            
                                        </td>
                                        <td>{{ $course->name }} </td>
                                        <td>
                                            {{ $course->designation }}
                                        </td>
                                        <td>
                                            {{ $course->subject }}
                                        </td>
                                        {{-- <td>
                                            {{ $course->department }}
                                        </td> --}}
                                        <td>
                                            @if($course->contactType == 1)
                                                Permanent
                                            @elseif($course->contactType == 2)
                                                Intern
                                            
                                            @elseif($course->contactType == 3)
                                                Contractual
                                            
                                            @endif
                                        </td>
                                        <td>
                                            {{ $course->phone }}
                                        </td>
                                        <td>
                                            @php
                                            if($course->IsActive == 1){
                                                $status = "<span class='text-success'>Active</span>";
                                            }
                                            elseif($course->IsActive == 2){
                                                $status = "<span class='text-info'>Postponded</span>";
                                            }
                                            elseif($course->IsActive == 3){
                                                $status = "<span class='text-danger'>Restricted</span>";
                                            }
                                            @endphp
                                            <b>{!! $status !!}</b>
                                    </td>
                                        <td>
                                        @php
                                            $date = strtotime($course->updated_at);
                                            $updateDate = date('d-M-y', $date);
                                        @endphp    
                                        {{ $updateDate }}
                                    </td>
                                       
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                {{-- <a href="{{ route('admin.students.sms', $course->id) }}" class="btn btn-sm btn-primary" title="Send Due SMS"><i class="fas fa-envelope"></i></a> --}}
                                                <a href="{{ route('admin.stuff.view', $course->id) }}" class="btn btn-sm btn-info" title="View Student"><i class="fa fa-eye"></i></a>
                                                @if($course->IsRegister == 1)
                                                {{-- <a href="{{ route('admin.registration.create', $course->id) }}" class="btn btn-sm btn-warning text-danger" title="Make Registration"><i class="fa fa-certificate"></i></a> --}}
                                                @endif
                                                <a href="{{ route('admin.stuff.edit', $course->id) }}" class="btn btn-sm btn-primary" title="Edit Student Information"><i class="fa fa-edit"></i></a>
                                               
                                                <a href="{{ route('admin.stuff.delete', $course->id) }}" class="btn btn-sm btn-danger" title="Delete Student Information"><i class="fa fa-trash"></i></a>
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
   <script type="text/javascript" src="{{asset('backend/js/lightbox-popup.min.js')}}"></script>
   <script>
$(document).ready(function() {
	$('.popup-gallery').magnificPopup({
		delegate: 'a',
		type: 'image',
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-img-mobile',
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
			tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
			titleSrc: function(item) {
				return item.el.attr('title');
			}
		}
	});
});
   </script>
@endpush