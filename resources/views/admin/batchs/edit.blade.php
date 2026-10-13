@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-users"></i> {{ $pageTitle }}</h1>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <form action="{{ route('admin.batchs.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <input type="hidden" name="id" value="{{$targetbatchs->id}}">
                        <div class="form-group"> 
                            <label class="control-label" for="stuff_id">Assign Teacher<span class="m-l-5 text-danger"> *</span></label>
                            <select  class="form-control @error('stuff_id') is-invalid @enderror"name="stuff_id" id="stuff_id">
                                <option value="">Select</option>
                                @foreach ($stuff as $item)
                                    <option value="{{$item->id}}" @if($item->id == $targetbatchs->stuff_id) selected @endif>{{$item->name}}</option>
                                @endforeach
                                
                            </select>
                            @error('stuff_id') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="batchnum">Batch Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('batchnum') is-invalid @enderror" type="text" name="batchnum" id="batchnum" value="{{ old('batchnum', $targetbatchs->batchnum) }}"/>
                            @error('batchnum') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="totalseat">Total Seats <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('totalseat') is-invalid @enderror" type="number" name="totalseat" id="totalseat" value="{{ old('totalseat', $targetbatchs->totalseat) }}"/>
                            @error('totalseat') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="startdate">Batchs Start Date <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('startdate') is-invalid @enderror" type="date" name="startdate" id="startdate" value="{{ old('startdate', $targetbatchs->startdate) }}"/>
                            @error('startdate') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="enddate">Batchs End Date </label>
                            <input class="form-control @error('enddate') is-invalid @enderror" type="date" name="enddate" id="enddate" value="{{ old('enddate', $targetbatchs->enddate) }}"/>
                            @error('enddate') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="control-label" for="schedule">Batch Schedule <span class="m-l-5 text-danger"> *</span></label>
                                </div>
                                <div class="col-md-9">
                                    <div class="row pb-2">
                                        <div class="col-md-4">
                                            <label for="day1"><i class="fa fa-calendar" aria-hidden="true"></i> Friday</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day1" class="@error('day1') is-invalid @enderror" id="day1yes" value="1" @if($targetbatchs->day1 == 1) checked @endif> <label for="day1yes" >Yes</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day1" class="@error('day1') is-invalid @enderror" id="day1no" value="0" @if($targetbatchs->day1 == 0) checked @endif> <label for="day1no" >No</label>
                                            @error('day1') {{ $message }} @enderror 
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                  <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                                </div>
                                                <input class="form-control @error('schedule1') is-invalid @enderror" type="text" name="schedule1" id="schedule1" value="{{ old('schedule1',$targetbatchs->schedule1) }}" placeholder="09:00 AM - 11:00 AM"/>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Schedule day --}}
                                    <div class="row pb-2">
                                        <div class="col-md-4">
                                            <label for="day2"><i class="fa fa-calendar" aria-hidden="true"></i> Satrday</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day2" class="@error('day2') is-invalid @enderror" id="day2yes" value="1" @if($targetbatchs->day2 == 1) checked @endif> <label for="day2yes">Yes</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day2" class="@error('day2') is-invalid @enderror" id="day2no" value="0" @if($targetbatchs->day2 == 0) checked @endif> <label for="day2no">No</label>
                                            @error('day2') {{ $message }} @enderror 
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                  <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                                </div>
                                                <input class="form-control @error('schedule2') is-invalid @enderror" type="text" name="schedule2" id="schedule2" value="{{ old('schedule2',$targetbatchs->schedule2) }}" placeholder="09:00 AM - 11:00 AM"/>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Schedule day --}}
                                    <div class="row pb-2">
                                        <div class="col-md-4">
                                            <label for="day3"><i class="fa fa-calendar" aria-hidden="true"></i> Sunday</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day3" class="@error('day3') is-invalid @enderror" id="day3yes" value="1" @if($targetbatchs->day3 == 1) checked @endif> <label for="day3yes">Yes</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day3" class="@error('day3') is-invalid @enderror" id="day3no" value="0" @if($targetbatchs->day3 == 0) checked @endif> <label for="day3no">No</label>
                                            @error('day3') {{ $message }} @enderror 
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                  <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                                </div>
                                                <input class="form-control @error('schedule3') is-invalid @enderror" type="text" name="schedule3" id="schedule3" value="{{ old('schedule3',$targetbatchs->schedule3 ) }}" placeholder="09:00 AM - 11:00 AM"/>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Schedule day --}}
                                    <div class="row pb-2">
                                        <div class="col-md-4">
                                            <label for="day4"><i class="fa fa-calendar" aria-hidden="true"></i> Monday</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day4" class="@error('day4') is-invalid @enderror" id="day4yes" value="1" @if($targetbatchs->day4 == 1) checked @endif> <label for="day4yes">Yes</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day4" class="@error('day4') is-invalid @enderror" id="day4no" value="0" @if($targetbatchs->day4 == 0) checked @endif> <label for="day4no">No</label>
                                            @error('day4') {{ $message }} @enderror 
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                  <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                                </div>
                                                <input class="form-control @error('schedule4') is-invalid @enderror" type="text" name="schedule4" id="schedule4" value="{{ old('schedule4',$targetbatchs->schedule4) }}" placeholder="09:00 AM - 11:00 AM"/>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Schedule day --}}
                                    <div class="row pb-2">
                                        <div class="col-md-4">
                                            <label for="day5"><i class="fa fa-calendar" aria-hidden="true"></i> Tuesday</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day5" class="@error('day5') is-invalid @enderror" id="day5yes" value="1" @if($targetbatchs->day5 == 1) checked @endif> <label for="day5yes">Yes</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day5" class="@error('day5') is-invalid @enderror" id="day5no" value="0" @if($targetbatchs->day5 == 0) checked @endif> <label for="day5no">No</label>
                                            @error('day5') {{ $message }} @enderror 
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                  <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                                </div>
                                                <input class="form-control @error('schedule5') is-invalid @enderror" type="text" name="schedule5" id="schedule5" value="{{ old('schedule5',$targetbatchs->schedule5) }}" placeholder="09:00 AM - 11:00 AM"/>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Schedule day --}}
                                    <div class="row pb-2">
                                        <div class="col-md-4">
                                            <label for="day6"><i class="fa fa-calendar" aria-hidden="true"></i> Wednesday</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day6" class="@error('day6') is-invalid @enderror" id="day6yes" value="1" @if($targetbatchs->day6 == 1) checked @endif> <label for="day6yes">Yes</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day6" class="@error('day6') is-invalid @enderror" id="day6no" value="0" @if($targetbatchs->day6 == 0) checked @endif> <label for="day6no">No</label>
                                            @error('day6') {{ $message }} @enderror 
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                  <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                                </div>
                                                <input class="form-control @error('schedule6') is-invalid @enderror" type="text" name="schedule6" id="schedule6" value="{{ old('schedule6',$targetbatchs->schedule6) }}" placeholder="09:00 AM - 11:00 AM"/>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Schedule day --}}
                                    <div class="row pb-2">
                                        <div class="col-md-4">
                                            <label for="day7"><i class="fa fa-calendar" aria-hidden="true"></i> Thursday</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day7" class="@error('day7') is-invalid @enderror" id="day7yes" value="1" @if($targetbatchs->day7 == 1) checked @endif> <label for="day7yes">Yes</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day7" class="@error('day7') is-invalid @enderror" id="day7no" value="0" @if($targetbatchs->day7 == 0) checked @endif> <label for="day7no">No</label>
                                            @error('day7') {{ $message }} @enderror 
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                  <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                                </div>
                                                <input class="form-control @error('schedule7') is-invalid @enderror" type="text" name="schedule7" id="schedule7" value="{{ old('schedule7',$targetbatchs->schedule7) }}" placeholder="09:00 AM - 11:00 AM"/>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Schedule day --}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="IsActive">Batchs Status </label>
                            <select  class="form-control @error('IsActive') is-invalid @enderror"name="IsActive" id="IsActive">
                                <option value="1" @if($targetbatchs->IsActive == 1) {{ "selected" }}  @endif >Running</option>
                                <option value="2" @if($targetbatchs->IsActive == 2) {{ "selected" }}  @endif  >Upcomming</option>
                                <option value="3" @if($targetbatchs->IsActive == 3) {{ "selected" }}  @endif  >Complete</option>
                                <option value="0" @if($targetbatchs->IsActive == 0) {{ "selected" }}  @endif  >Postponed</option>
                            </select>
                            @error('IsActive') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Batchs</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-danger" href="{{ route('admin.batchs.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    // $('#schedule1').hide(); 
    // $('#schedule2').hide(); 
    // $('#schedule3').hide(); 
    // $('#schedule4').hide(); 
    // $('#schedule5').hide(); 
    // $('#schedule6').hide(); 
    // $('#schedule7').hide();
    if($('#day1yes').attr('checked')){
        $('#schedule1').show();
    }
    else{
        $('#schedule1').hide();
    }
    if($('#day2yes').attr('checked')){
        $('#schedule2').show();
    }
    else{
        $('#schedule2').hide();
    }
    if($('#day3yes').attr('checked')){
        $('#schedule3').show();
    }
    else{
        $('#schedule3').hide();
    }
    if($('#day4yes').attr('checked')){
        $('#schedule4').show();
    }
    else{
        $('#schedule4').hide();
    }
    if($('#day5yes').attr('checked')){
        $('#schedule5').show();
    }
    else{
        $('#schedule5').hide();
    }
    if($('#day6yes').attr('checked')){
        $('#schedule6').show();
    }
    else{
        $('#schedule6').hide();
    }
    if($('#day7yes').attr('checked')){
        $('#schedule7').show();
    }
    else{
        $('#schedule7').hide();
    }
     $('#day1yes').on('click', function(){
         $('#schedule1').show(); 
     });
     $('#day1no').on('click', function(){
         $('#schedule1').hide(); 
     });
     $('#day2yes').on('click', function(){
         $('#schedule2').show(); 
     });
     $('#day2no').on('click', function(){
         $('#schedule2').hide(); 
     });
     $('#day3yes').on('click', function(){
         $('#schedule3').show(); 
     });
     $('#day3no').on('click', function(){
         $('#schedule3').hide(); 
     });
     $('#day4yes').on('click', function(){
         $('#schedule4').show(); 
     });
     $('#day4no').on('click', function(){
         $('#schedule4').hide(); 
     });
     $('#day5yes').on('click', function(){
         $('#schedule5').show(); 
     });
     $('#day5no').on('click', function(){
         $('#schedule5').hide(); 
     });
     $('#day6yes').on('click', function(){
         $('#schedule6').show(); 
     });
     $('#day6no').on('click', function(){
         $('#schedule6').hide(); 
     });
     $('#day7yes').on('click', function(){
         $('#schedule7').show(); 
     });
     $('#day7no').on('click', function(){
         $('#schedule7').hide(); 
     });
 </script>
@endpush