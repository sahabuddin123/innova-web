@extends('admin.app')

@section('title') {{ $pageTitle }} @endsection

@section('content')
<link rel="stylesheet" href="{{asset('backend/css/lightbox-popup.css')}}">
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-user"></i> {{ $pageTitle }}</h1>
    </div>
    <div>
        <a href="{{ route('admin.shareholder.index') }}" class="btn btn-success pull-right">All Investor</a>
    </div>
</div>
@include('admin.partials.flash')
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <div class="popup-gallery">
                        <a href="{!! asset('public/storage/'.$target->image) !!}" title="{{ $target->name }}">
                            <img src="{!! asset('public/storage/'.$target->image) !!}" alt="!"  class="rounded-circle img-fluid img-thumbnail" style="width: 150px;">
                        </a>
                        </div> 
                        <h5 class="my-3">{{ $target->name }}</h5>
                        <p class="p-0 text-info"><b><mark> ID : {{ $target->id }} </mark></b></p>
                    </div>
                </div>
                <div class="card mb-4 mb-lg-0">
                <div class="card-header bg-success"><h5 class="text-white"><i class="fas fa-university"></i> Basic Information</h5></div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush rounded-3">
                        
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Designation</p>
                                <p class="mb-0">{{ $target->designation }}</p>
                            </li>
                            
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Email</p>
                                <p class="mb-0">{{ $target->email }}</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Phone</p>
                                <p class="mb-0">{{ $target->phone }}</p>
                            </li>
                           
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <p class="mb-0">Investment Type</p>
                                <p class="mb-0">
                                    @if($target->shareType == 1)
                                            <span class='text-success'>Shareholder</span>
                                            @elseif($target->shareType == 2)
                                            <span class='text-success'>Investor</span>
                                            @elseif($target->shareType == 3)
                                            <span class='text-success'>Owner</span>
                                            @endif
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
                </div>
                <div class="col-lg-8">
                    <!-- Student Information -->
                    {{-- investment --}}
                    <div class="card mb-4">
                         <div class="card-header bg-primary"> <h5 class="text-white"><i class="fa fa-user"></i> Investment Informations</h5></div>
                        <div class="card-body overflow-auto">
                           <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">SL</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Investment Date</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                        $i=1;
                                        @endphp
                                        @foreach($investment as $payfees)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$payfees->paidremark}}</td>
                                            <td class="text-center">
                                                @php
                                                $date = strtotime($payfees->recevedDate);
                                                $createDate = date('d-M-Y', $date);
                                                @endphp
                                                {{$createDate}}
                                            </td>
                                            <td class="text-center">{{number_format($payfees->amount,2)}} BDT</td>
                                            <td class="text-center"><a href="{{ route('admin.investment.edit', $payfees->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a></td>
                                        </tr>
                                        @php
                                        $i++;
                                        @endphp
                                        @endforeach
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-right">Total Pay :</th>
                                    <th class="text-center">{{number_format($paid,2)}} BDT</th>
                                </tr>
                                
                            </tfoot>
                           </table>
                        </div>
                    </div>
                    <!-- Guardian Informations -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary"> <h5 class="text-white"><i class="fa fa-users"></i> Local Informations</h5></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3 col-md-3">
                                    <p class="mb-0">Address : </p>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <p class="text-muted mb-0">{{ $target->address }}</p>
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
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