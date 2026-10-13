@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="far fa-credit-card"></i> {{ $pageTitle }}</h1>
    </div>
    @include('admin.partials.flash')
    <style type="text/css">
        @import url('https://fonts.maateen.me/solaiman-lipi/font.css');
            #results {
                padding: 10px;
                border: 1px solid;
                background: #ccc;
            }
            .control-label, .form-control, ::placeholder, h3,a,button {
                font-family: 'SolaimanLipi', Arial, sans-serif !important;
            }
        </style>
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <form action="{{ route('admin.income.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    <div class="tile-body">
                        @csrf
                        <input type="hidden" name="id" value="{{ $targetData->id }}">
                        {{-- target Id = {{$targetData->categoris_id}} --}}
                        <div class="form-group">
                            <label class="control-label" for="branch_id">শাখার নাম <span
                                    class="m-l-5 text-danger">*</span></label>
                            <select class="form-control @error('branch_id') is-invalid @enderror" name="branch_id"
                                id="branch_id">
                                <option value="">শাখা নির্ধারণ করুন</option>
                                @foreach ($branchs as $branch)
                                    <option value="{{ $branch->id }}"
                                        @if (old('branch_id', $targetData->branch_id) == $branch->id) {{ 'selected' }} @endif> {{ $branch->bname }}
                                    </option>
                                @endforeach
                            </select>
                            @error('branch_id')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="categoris_id">আয়ের খাত<span class="m-l-5 text-danger">
                                    *</span></label>
                            <select class="form-control @error('categoris_id') is-invalid @enderror"name="categoris_id"
                                id="categoris_id">
                                <option value="">প্রথমে শাখা নির্ধারণ করুন</option>
                                @foreach ($categoris as $item)
                                    <option value="{{ $item->id }}" @if ($targetData->categoris_id == $item->id) selected @endif>
                                        {{ $item->categoris }} </option>
                                @endforeach

                            </select>
                            @error('categoris_id')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="invoiceID">বই নং </label>
                            <input class="form-control @error('bookNO') is-invalid @enderror" type="text"
                                name="bookNO" id="bookNO" placeholder="123654"
                                value="{{ old('bookNO', $targetData->bookNO) }}" />
                            @error('bookNO')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="invoiceID">মেমো নং </label>
                            <input class="form-control @error('invoiceID') is-invalid @enderror" type="text"
                                name="invoiceID" id="invoiceID" placeholder="123654"
                                value="{{ old('invoiceID', $targetData->invoiceID) }}" />
                            @error('invoiceID')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="invoiceDate">মেমোর তারিখ <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('invoiceDate') is-invalid @enderror" type="date"
                                name="invoiceDate" id="invoiceDate"
                                value="{{ old('invoiceDate', $targetData->invoiceDate) }}" />
                            @error('invoiceDate')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="title">শিরোনাম<span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title"
                                id="title" placeholder="Chalan" value="{{ old('title', $targetData->title) }}" />
                            @error('title')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="seller">বিক্রেতার নাম</label>
                            <input class="form-control @error('seller') is-invalid @enderror" type="text" name="seller"
                                id="seller" placeholder="Mr." value="{{ old('seller', $targetData->seller) }}" />
                            @error('seller')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="recever">ক্রেতার নাম</label>
                            <input class="form-control @error('recever') is-invalid @enderror" type="text" name="recever"
                                id="recever" placeholder="Mr." value="{{ old('recever', $targetData->recever) }}" />
                            @error('recever')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="description">বিস্তারিত বিবরণ<span class="m-l-5 text-danger">
                                    *</span></label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                cols="30" rows="3">{!! old('description', $targetData->description) !!}</textarea>
                            @error('description')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="amount">টাকার পরিমাণ (ইংরেজিতে)</label>
                            <input class="form-control @error('amount') is-invalid @enderror" type="text" name="amount"
                                id="amount" placeholder="0.00" value="{{ old('amount', $targetData->amount) }}" />
                            @error('amount')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="createDate">এন্ট্রি তারিখ <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('createDate') is-invalid @enderror" type="date"
                                name="createDate" id="createDate"
                                value="{{ old('createDate', $targetData->createDate) }}" />
                            @error('createDate')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="IsActive">স্টার্টাস<span class="m-l-5 text-danger">
                                    *</span></label>
                            <select class="form-control @error('IsActive') is-invalid @enderror"name="IsActive"
                                id="IsActive">
                                <option value="">--Select--</option>
                                <option value="1" @if (old('IsActive', $targetData->IsActive) == 1) {{ 'selected' }} @endif>
                                    Pending</option>
                                <option value="2" @if (old('IsActive', $targetData->IsActive) == 2) {{ 'selected' }} @endif>
                                    Accept</option>
                                <option value="3" @if (old('IsActive', $targetData->IsActive) == 3) {{ 'selected' }} @endif>
                                    Restricted</option>
                            </select>
                            @error('IsActive')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="row">

                            <div class="col-sm-12 col-md-5">
                                <div class="form-group" id="image-area">
                                    <label class="control-label" for="image-tag">মেমোর চবি <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control @error('image') is-invalid @enderror image-tag"
                                        type="file" name="image" id="image-tag" value="{{ old('image') }}" />
                                    @error('image')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <button type="button" id="take-photo" class="btn btn-warning mt-4">আপনার কেমেরা দিয়ে
                                    তুলুন <i class="fa fa-camera" aria-hidden="true"></i></button>
                            </div>
                        </div>
                        @if ($targetData->image != null)
                            <img src="{{ asset('public/storage/' . $targetData->image) }}" alt="!" height="182.4">
                        @endif
                        <input type="hidden" name="oldimage" value="{{ $targetData->image }}">
                        <div class="row" id="photo-area">
                            <div class="col-md-6">
                                <div id="my_camera"></div>
                                <br />
                                <input type="button" class="btn btn-success" value="Take Picture"
                                    onClick="take_snapshot()">
                                <input type="hidden" name="image2" id="image_tag_student">
                            </div>
                            <div class="col-md-6">
                                <div id="results">আপনার কেমেরাই তোলা ছবি এখানে দেখুন...</div>
                            </div>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit" id="submitform"><i
                                class="fa fa-fw fa-lg fa-check-circle"></i>Update Income</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.income.index') }}"><i
                                class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('select[name="branch_id"]').on('change', function() {
                var branch_id = $(this).val();
                var url = '/admin/income/getIncomeCategoris/' + branch_id;
                // console.log(url);
                if (branch_id) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            var expanseCategoryOptions = [];
                            $.each(data, function(key, value) {
                                expanseCategoryOptions.push($('<option></option>').val(
                                    key).text(value));
                            });
                            $('#categoris_id').empty();
                            $('#categoris_id').append(expanseCategoryOptions);
                        }
                    });
                } else {
                    $('#categoris_id').empty();
                }
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <script language="JavaScript">
        $('#image-area').show();
        $('#photo-area').hide();
        $('#take-photo').on('click', function() {
            $('#image-area').hide();
            $('#photo-area').show();
            Webcam.set({
                // live preview size
                width: 800,
                height: 800,

                // device capture size
                dest_width: 800,
                dest_height: 800,

                // final cropped size
                crop_width: 500,
                crop_height: 800,

                // format and quality
                image_format: 'jpeg',
                jpeg_quality: 100,

                // flip horizontal (mirror mode)
                flip_horiz: false
            });
            Webcam.attach('#my_camera');
        });
        // preload shutter audio clip
        var shutter = new Audio();
        shutter.autoplay = false;
        shutter.src = navigator.userAgent.match(/Firefox/) ? 'shutter.ogg' :
            "{{ asset('public/storage/students/shutter.mp3') }}";

        function take_snapshot() {
            Webcam.snap(function(data_uri) {
                // play sound effect
                try {
                    shutter.currentTime = 0;
                } catch (e) {
                    ;
                } // fails in IE
                shutter.play();
                $("#image_tag_student").val(data_uri);
                document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
            });
        }
        $('#submitform').on('click', function() {
            $('#course_fee').removeAttr('disabled');
        });
    </script>
    {{-- <script src="//cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script> --}}
    <script>
        // CKEDITOR.replace( 'description' );
    </script>
@endpush
