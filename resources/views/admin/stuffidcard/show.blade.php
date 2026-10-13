@extends('admin.app')

@section('title')
    {{ $pageTitle }}
@endsection

@section('content')
    @php
        if ($targetStuff->bloodgroup == 1) {
            $blood = 'A(+ve)';
        } elseif ($targetStuff->bloodgroup == 2) {
            $blood = 'O(+ve)';
        } elseif ($targetStuff->bloodgroup == 3) {
            $blood = 'B(+ve)';
        } elseif ($targetStuff->bloodgroup == 4) {
            $blood = 'AB(+ve)';
        } elseif ($targetStuff->bloodgroup == 5) {
            $blood = 'A(-ve)';
        } elseif ($targetStuff->bloodgroup == 6) {
            $blood = 'O(-ve)';
        } elseif ($targetStuff->bloodgroup == 7) {
            $blood = 'B(-ve)';
        } else {
            $blood = 'AB(-ve)';
        }
    @endphp

    @php
        $date = strtotime($targetStuff->joiningdate);
        $joiningdate = date('d-M-Y', $date);
    @endphp

    <style>
        @font-face {
            font-family: "Nunito";
            src: url({{'../../../storage/fonts/static/Nunito-Bold.ttf' }}) format("truetype");
            font-weight: 700;
            font-style: normal;
        }

        @font-face {
            font-family: "Nunito";
            src: url({{ '../../../storage/fonts/static/Nunito-BoldItalic.ttf' }}) format("truetype");
            font-weight: 700;
            font-style: italic;
        }

        @font-face {
            font-family: "Nunito";
            src: url({{ '../../../storage/fonts/static/Nunito-ExtraBold.ttf' }}) format("truetype");
            font-weight: 800;
            font-style: normal;
        }

        @font-face {
            font-family: "Nunito";
            src: url({{ '../../../storage/fonts/static/Nunito-ExtraBoldItalic.ttf' }}) format("truetype");
            font-weight: 800;
            font-style: italic;
        }

        @font-face {
            font-family: "Nunito";
            src: url({{ '../../../storage/fonts/static/Nunito-Light.ttf' }}) format("truetype");
            font-weight: 300;
            font-style: normal;
        }

        @font-face {
            font-family: "Nunito";
            src: url({{ '../../../storage/fonts/static/Nunito-LightItalic.ttf' }}) format("truetype");
            font-weight: 300;
            font-style: italic;
        }

        @font-face {
            font-family: "Nunito";
            src: url({{ '../../../storage/fonts/static/Nunito-Medium.ttf' }}) format("truetype");
            font-weight: 500;
            font-style: normal;
        }

        @font-face {
            font-family: "Nunito";
            src: url({{ '../../../storage/fonts/static/Nunito-MediumItalic.ttf' }}) format("truetype");
            font-weight: 500;
            font-style: italic;
        }

        @font-face {
            font-family: "Nunito";
            src: url({{ '../../../storage/fonts/static/Nunito-Regular.ttf' }}) format("truetype");
            font-weight: 400;
            font-style: normal;
        }

        @font-face {
            font-family: "Nunito";
            src: url({{ '../../../storage/fonts/static/Nunito-SemiBold.ttf' }}) format("truetype");
            font-weight: 600;
            font-style: normal;
        }

        @font-face {
            font-family: "Nunito";
            src: url({{ '../../../storage/fonts/static/Nunito-SemiBoldItalic.ttf' }}) format("truetype");
            font-weight: 600;
            font-style: italic;
        }

        @font-face {
            font-family: "Nunito";
            src: url({{ '../../../storage/fonts/static/Nunito-Italic.ttf' }}) format("truetype");
            font-weight: 400;
            font-style: italic;
        }

        body {
            font-family: "Nunito", sans-serif !important;
        }

        .card_font {
            background: url("{!! asset('./backend/img/stuffcard/a.png') !!}");
            height: 410px;
            width: 250px;

            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }

        .back_card {
            background: url("{!! asset('./backend/img/stuffcard/b.png') !!}");
            height: 410px;
            width: 250px;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }

        .rounded-circle {
            border-radius: 100px !important;
        }

        .imas-area {
            padding-top: 61px;
            padding-left: 86px;
        }

        .infor_area {
            padding: 20px;
            padding-bottom: 0px
        }

        .infor_area .sname {
            font-size: 15px;
            font-weight: bold;
            text-align: center
        }

        .infor_area .cname {
            font-size: 10px;
            font-weight: bold;
            text-align: center;
        }

        .details_info {
            padding-left: 30px;
            padding-top: 17px;

        }

        .details_info p {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase
        }

        .text-upper {
            text-transform: uppercase;
            font-weight: bolder;
            font-size: 12px;
            padding-left: 100px;
            padding-top: 110px;
            color: #000;
        }

        .text-light {
            color: #fff !important;
        }

        .details_info>p {
            color: #000 !important;
        }

        .sname {
            color: #4262AC !important;
            font-weight: 900 !important;

        }

        .cname {
            margin-top: -5px;
            color: #1A1A1A !important;
            font-weight: 900 !important;
            margin-bottom: 0;
        }

        .ts_heading {
            color: #ffffff !important;
            font-size: 10px;
            font-weight: 700;
            padding-top: 60px;
            padding-left: 64px;
        }

        .con_area>p {
            font-size: 8px;
            text-align: justify;
            color: #000;
            padding-left: 30px;
            padding-right: 15px;
            line-height: 15px;
            margin: 5px 0px;
        }

        .con_area {
            padding-top: 18px;
            padding-right: 8px;
        }

        .qrcode {
            margin-top: 8px;
            margin-left: 102px;
        }

        .card_footer {
            font-size: 8px;
            font-weight: 900;
            padding-top: 33px;
            padding-left: 123px;
        }

        .address_area p {
            font-size: 10px;
            margin: 0px;
            color: #000;
            padding: 0px 20px;
        }

        .address_area p span {
            font-weight: 900
        }

        .sing_img {
            height: 25px;
            padding-left: 120px;
            /* padding-top: 2px; */
            margin-top: 0px;
        }

        .sign_p {
            font-size: 10px;
            font-weight: 700;
            padding-left: 96px;
            padding-top: 9px;
            /* width: 168px;
                        text-decoration: overline 2px solid; */
        }

        .sign_area {
            padding-left: 20px;
            padding-top: 5px;
        }

        .card_s_footer p {
            font-size: 7px;
            color: #fff;
            font-weight: 900;
            margin-top: 16px;
            padding-left: 20px;
        }

        .font_lin {
            width: 65px;
            border: 1px solid #F15F59;
            margin-left: 70px;
        }

        .validity_text {
            margin-top: 10px;
            text-transform: uppercase;
            text-align: center;
            color: #000;
            font-size: 12px;
            font-weight: bolder
        }

        .list_number {
            list-style: none;
            padding: 0;
            margin: 0;
            position: absolute;
    top: 86px;
    left: 10px;
        }

        .list_number li:nth-child(even) {
            height: 18px;
            width: 18px;
            border-radius: 100%;
            background: #F15F59;
            color: #fff;
            font-size: 11px;
            line-height: 12px;
            padding: 4px;
            margin-top: 17px;
            font-weight: 400;
        }

        .list_number li:nth-child(odd) {
            height: 18px;
            width: 18px;
            border-radius: 100%;
            background: #4262AC;
            color: #fff;
            font-size: 11px;
            line-height: 12px;
            padding: 4px;
            margin-top: 17px;
            font-weight: 400;
        }
                    @media print{
                .ts_heading,
.card_footer span,
.card_s_footer span{
color: #fff;
}
    </style>
    <div class="container">
        <div class="row">
            <div class="col-4 p-0" style="padding-left: 5% !important;">
                <div class="card_font">
                    <div class="imas-area">
                        <img src="{!! asset('public/storage/' . $targetStuff->image) !!}" alt="!" class="rounded-circle img-fluid"
                            style="width: 82px; height:82px;">
                    </div>
                    <div class="infor_area">
                        <p class="mb-0 sname">{{ $targetStuff->name }}</p>
                        <p class="cname">{{ $targetStuff->designation }}</p>
                        <p class="font_lin"></p>
                    </div>
                    <div class="details_info">
                        <p class="p-0 mb-0"><span style="color: #4262AC"> ID NO.</span>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                            {{ $targetStuff->stuffid }} </p>
                        <p class="mb-0"><span style="color: #4262AC">JOINING DATE</span>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            : {{ $joiningdate }}</p>
                        {{--<p class="mb-0"><span style="color: #4262AC">EMAIL</span>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            :
                            {{ $targetStuff->email }}</p>--}}
                        <p class="mb-0"><span style="color: #4262AC">PHONE</span>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            :
                            {{ $targetStuff->phone }}</p>

                        <p class="mb-0"><span style="color: #4262AC">BLOOD GROUP</span> &nbsp;&nbsp;&nbsp; :
                            {{ $blood }} </p>

                    </div>
                    <div class="qrcode">
                        <img src="data:image/png;base64, {!! base64_encode(
                            QrCode::format('png')->size(55)->generate('https://innovacomputersbd.com/emp/' . $targetStuff->stuffid),
                        ) !!}" alt="!" style="height: 45px;">
                    </div>
                    <div class="card_footer">
                        <img src="{!! asset('./backend/img/idcard/web.png') !!}" alt="" height="10"> <span
                            class="text-light ">www.innographixbd.com</span>
                    </div>
                </div>
            </div>
            <div class="col-4 p-0">
                <div class="back_card">
                   
                    <div class="trams_conditions">
                        <p class="ts_heading mb-0">
                            TERMS & CONDITIONS
                        </p>
                        <ul class="list_number">
                            <li>1</li>
                            <li>2</li>
                            <li>3</li>
                            <li>4</li>
                            <li>5</li>
                        </ul>
                        <div class="con_area">
                            <p>
                                Ownership: This ID Card is the property of InnoGraphix and must be returned upon leaving the
                                company.
                            </p>
                            <p>
                                Personal Use Only: The ID Card is non-transferable and should only be used by you.
                            </p>
                            <p>
                                Card Care: Keep your ID Card secure; avoid bending, defacing, or exposing it to heat.
                            </p>
                            <p>
                                Reporting Issues: Report lost, stolen, or damaged cards to administration immediately.
                            </p>
                            <p>
                                Policy Updates: InnoGraphix may update these terms as needed.
                            </p>
                        </div>
                        <p class="mb-0 validity_text"><span style="color: #F15F59">validity</span> : 31/12/2025</p>
                        <div class="d-flex">
                            <div class="sign_area">
                                <img src="{!! asset('./backend/img/idcard/sign.png') !!}" alt="!" class="sing_img">
                                <p class="sign_p">
                                    Authorised Signature
                                </p>
                            </div>

                        </div>
                        <div class="card_s_footer">
                            <p>
                                Emergency Call:<br> +88 01867 033 550
                            </p>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('admin.stuffcard.iddownload', $targetStuff->id) }}"
                class="btn btn-primary pull-right">Download Card</a>

        </div>
    </div>
@endsection
