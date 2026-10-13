@extends('admin.app')

@section('title') {{ $pageTitle }} @endsection

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4 print_none">
    <div class="print_none">
        <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-user"></i> {{ $pageTitle }}</h1>
    </div>
    <div class="print_none">
        <a href="{{ route('admin.investment.index') }}" class="btn btn-success pull-right mr-2">All Investments</a>
        <a href="{{ route('admin.investment.statement', $target->id) }}" class="btn btn-info pull-right mr-2">View Statement</a>
    </div>
</div>
@include('admin.partials.flash')
<style>
    @media print{
        .print_none, .navbar-nav{
            display:none;
        }
        #wrapper #content-wrapper , .content{
            background: transparent;
        }
        .p30{
            padding: 0;
        }
        a.scroll-to-top{
            display:none;
        }
    }
</style>
<div class="container bootdey">
<div class="tile">
    <div class="tile-body">

<div class="row invoice row-printable">
    <div class="col-md-12">
        <!-- col-lg-12 start here -->
        <div class="panel panel-default plain" id="dash_0">
            <!-- Start .panel -->
            <div class="panel-body p30">
                <div class="row">
                    <!-- Start .row -->
                    <div class="col-lg-6">
                        <!-- col-lg-6 start here -->
                        <div class="invoice-logo"><img width="100" src="{!! asset('public/storage/'.$target->image) !!}" alt="{{$target->name}}"></div>
                    </div>
                    <!-- col-lg-6 end here -->
                    <div class="col-lg-6">
                        <!-- col-lg-6 start here -->
                        <div class="invoice-from">
                            <ul class="list-unstyled text-right">
                                <li><b>INNOVA Computers BD</b></li>
                                <li>Masterpara, Charbata, Subarnachar, Noakhali. &nbsp;&nbsp;&nbsp;<i class="fas fa-map-marker-alt"></i></li>
                                <li>+880 1844 463 963, +880 1817 682 323 &nbsp;&nbsp;&nbsp;<i class="fas fa-phone-alt"></i></li>
                                <li>innovacomputersbd@gmail.com  &nbsp;&nbsp;&nbsp;<i class="fas fa-envelope"></i></li>
                            </ul>
                        </div>
                    </div>
                    <!-- col-lg-6 end here -->
                    <div class="col-md-12"><h3 class="text-center border-bottom">Investment Slip</h3></div>
                    <div class="col-lg-12">
                        <!-- col-lg-12 start here -->
                        <div class="d-flex justify-content-between mt-3">
                            <div class="">
                            <div class="invoice-details mt25">
                                    <div class="well">
                                        <ul class="list-unstyled mb0">
                                            <li><strong>Investor ID:</strong> {{$target->id}}</li>
                                            <li>
                                                <strong>Investor Name:</strong>
                                                {{$target->name}}
                                            </li>
                                        </ul>
                                    </div>
                                </div>  
                            </div>
                            <div class="">
                                <div class="invoice-details mt25">
                                    <div class="well">
                                        <ul class="list-unstyled mb0">
                                            <li>
                                                <strong>Slip Make Date:</strong>
                                                @php
                                                $dateToday = date('l, jS M Y');
                                                @endphp
                                                {{$dateToday}}
                                            </li>
                                            <li><strong>Phone : </strong>  {{$target->phone}}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-items">
                            <div class="table-responsive" style="overflow: hidden; outline: none;" tabindex="0">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="per5 text-center">SL</th>
                                            <th class="per60 text-center">Description</th>
                                            <th class="per10 text-center">Investment Date</th>
                                            <th class="per25 text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i=1;
                                        @endphp
                                        @foreach($investments as $payfees)
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
                        <div class="invoice-footer mt25">
                            <p class="text-center">Generated on {{$dateToday}} <button onclick="print()" class="btn btn-default ml15"><i class="fa fa-print mr5"></i> Print</button></p>
                        </div>
                    </div>
                    <!-- col-lg-12 end here -->
                </div>
                <!-- End .row -->
            </div>
        </div>
        <!-- End .panel -->
    </div>
    <!-- col-lg-12 end here -->
</div>
</div>   
</div>
</div>
<script>

</script>
@endsection