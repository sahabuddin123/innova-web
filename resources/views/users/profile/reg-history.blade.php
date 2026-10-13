@extends('users.app')

@section('title') {{ $pageTitle }} @endsection

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4 print_none">
    <div class="print_none">
        <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-user"></i> {{ $pageTitle }}</h1>
    </div>
    <div class="print_none">
        {{-- <a href="{{ route('admin.students.index') }}" class="btn btn-success pull-right">All Payments</a> --}}
        {{-- <!-- <a href="{{ route('admin.students.create') }}" class="btn btn-primary pull-right">Add Students</a> --> --}}
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
                        <div class="invoice-logo"><img width="100" src="{!! asset('public/storage/'.$students->image) !!}" alt="Invoice logo"></div>
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
                    <div class="col-md-12"><h3 class="text-center border-bottom">Payment History</h3></div>
                    <div class="col-lg-12">
                        <!-- col-lg-12 start here -->
                        <div class="d-flex justify-content-between mt-3">
                            <div class="">
                            <div class="invoice-details mt25">
                                    <div class="well">
                                        <ul class="list-unstyled mb0">
                                            <li><strong>Student ID:</strong> {{$students->id}}</li>
                                            <li>
                                                <strong>Student Name:</strong>
                                                {{$students->sname}}
                                            </li>
                                            <li><strong>Status:</strong> <span class="label label-danger">
                                            @php
                                                $discountStatus = $students->balance - $paid;
                                            @endphp
                                                @if($discountStatus == 0)
                                                PAID
                                                @else
                                                UNPAID
                                                @endif
                                            </span></li>
                                        </ul>
                                    </div>
                                </div>  
                            </div>
                            <div class="">
                                <div class="invoice-details mt25">
                                    <div class="well">
                                        <ul class="list-unstyled mb0">
                                            {{-- <li><strong>Invoice</strong> #icbd{{$students->id}}</li> --}}
                                            <li>
                                                <strong>Date:</strong>
                                                @php
                                                $dateToday = date('l, jS M Y');
                                                @endphp
                                                {{$dateToday}}
                                            </li>
                                            <li><strong>Batch Name:</strong> <span class="label label-danger">{{$students->StudentsBatchs->batchnum}}</span></li>
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
                                            <th class="per10 text-center">Pay Date</th>
                                            <th class="per25 text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i=1;
                                        @endphp
                                        @foreach($fees as $payfees)
                                        @if($payfees->paymentType != 1)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$payfees->paidremark}}</td>
                                            <td class="text-center">
                                                @php
                                                $date = strtotime($payfees->paiddate);
                                                $createDate = date('d-M-Y', $date);
                                                @endphp
                                                {{$createDate}}
                                            </td>
                                            <td class="text-center">{{number_format($payfees->paidamount,2)}} BDT</td>
                                        </tr>
                                        @php
                                        $i++;
                                        @endphp
                                        @endif
                                        @endforeach
                                        
                                    </tbody>
                                    <tfoot>
                                        @php
                                            $RegFee = DB::table('registrations')->where('student_id',$students->id)->first();
                                            $paid = DB::table('fees_transections')->where('student_id')->where('paymentType', '!=', 1)->sum('paidamount');
                                        @endphp
                                        <tr>
                                            <th colspan="3" class="text-right">Total Registration Fee:</th>
                                            <th class="text-center">{{number_format($RegFee->balance,2)}} BDT</th>
                                        </tr>
                                        {{-- <tr>
                                            <th colspan="3" class="text-right">Discount (-):</th>
                                            <th class="text-center">
                                                @php
                                                $discount = $students->course_fee - $students->balance;
                                                @endphp
                                                {{number_format($discount,2)}} BDT
                                            </th>
                                        </tr> --}}
                                        <tr>
                                            <th colspan="3" class="text-right">Total Pay (-):</th>
                                            <th class="text-center">{{number_format($paid,2)}} BDT</th>
                                        </tr>
                                        
                                        <tr>
                                            <th colspan="3" class="text-right">Need Due:</th>
                                            <th class="text-center">
                                                {{number_format($RegFee->balance - $paid, 2)}} BDT</th>
                                        </tr>
                                        @if($RegFee->balance - $paid != 0)
                                        <tr>
                                            <th colspan="3" class="text-right">Pay your Registration Fees</th>
                                            <th class="text-center">
                                               
                                                <input type="hidden" id="price"  name="price" value="{{$RegFee->balance - $paid}}">
                                                <button type="button" id="bKash_button" class="btn btn-danger">Pay with bKash</button>
                                                
                                        </tr>
                                        @endif
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="invoice-footer mt25">
                            <p class="text-center">Generated on {{$dateToday}} {{-- <button onclick="print()" class="btn btn-default ml15"><i class="fa fa-print mr5"></i> Print</button> --}}</p>
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
@push('scripts')
<script>
    jQuery(document).ready(function(){
    var price = document.getElementById('price').value;
    console.log(price);
    var paymentID = '';
    bKash.init({
      paymentMode: 'checkout', //fixed value ‘checkout’
      //paymentRequest format: {amount: AMOUNT, intent: INTENT}
      //intent options
      //1) ‘sale’ – immediate transaction (2 API calls)
      //2) ‘authorization’ – deferred transaction (3 API calls)
      paymentRequest: {
        amount: price, //max two decimal points allowed
        intent: 'sale'
      },
      createRequest: function(request) { //request object is basically the paymentRequest object, automatically pushed by the script in createRequest method
       console.log("create working !!")
    //    console.log(request);
        $.ajax({
          url: '{{ route('create.bkash') }}',
          type: 'GET',
          data: JSON.stringify(request),
          contentType: 'application/json',
          success: function(data) {
            data = JSON.parse(data);
            console.log(data);
            //console.log(data)
            if (data && data.paymentID != null) {
              paymentID = data.paymentID;
              bKash.create().onSuccess(data); //pass the whole response data in bKash.create().onSucess() method as a parameter
            } else {
              bKash.create().onError();
            }
          },
          error: function() {
            bKash.create().onError();
          }
        });
      },
      executeRequestOnAuthorization: function() {
        console.log("execute working !!")
        $.ajax({
          url: '{{route('execute.bkash')}}',
          type: 'GET',
          contentType: 'application/json',
          data: JSON.stringify({
            "paymentID": paymentID
          }),
          success: function(data) {
            // console.log(data);
            data = JSON.parse(data);
           //console.log(data)
            if (data && data.paymentID != null) {
              console.log("trxID: ",data.trxID)
               window.location.href = '{{ route('success.bkash') }}'; // Your redirect route when successful payment
            } else {
                console.log("error ");
                window.location.href = '{{ route('fail.bkash') }}'; // Your redirect route when fail payment
                bKash.execute().onError();
            }
          },
          error: function() {
            bKash.execute().onError();
          }
        });
      },
      onClose: function(){
        window.location.href='{{route('user.payment.history')}}';  // Your redirect route when cancel payment may be cart 
      },
      });
    });
</script>
@endpush