<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
    use Carbon\Carbon;

    $date = strtotime($targetStudents->StudentsBatchs->startdate);
    $startdate = date('d-M-Y', $date);

    $bloodGroups = [
        1 => 'A(+ve)', 2 => 'O(+ve)', 3 => 'B(+ve)', 4 => 'AB(+ve)',
        5 => 'A(-ve)', 6 => 'O(-ve)', 7 => 'B(-ve)', 8 => 'AB(-ve)'
    ];
    $blood = $bloodGroups[$targetStudents->bloodgroup] ?? 'Unknown';

    $date = strtotime($targetStudents->admission_date);
    $admission_date = date('d-M-Y', $date);

    $dateObject = Carbon::parse($admission_date);
    $dateObject->addMonth($targetStudents->StudentsCourses->courseduration);
    $newDate = $dateObject->format('d-m-Y');

    // Correctly encode images to base64
    $studentImage = file_exists(public_path('storage/' . $targetStudents->image)) ? base64_encode(file_get_contents(public_path('storage/' . $targetStudents->image))) : '';
    $signImage = file_exists(public_path('backend/img/idcard/sign.png')) ? base64_encode(file_get_contents(public_path('backend/img/idcard/sign.png'))) : '';
    $webIcon = file_exists(public_path('backend/img/idcard/web.png')) ? base64_encode(file_get_contents(public_path('backend/img/idcard/web.png'))) : '';
    $bgFront = file_exists(public_path('backend/img/idcard/a.jpg')) ? base64_encode(file_get_contents(public_path('backend/img/idcard/a.jpg'))) : '';
    $bgBack = file_exists(public_path('backend/img/idcard/b.jpg')) ? base64_encode(file_get_contents(public_path('backend/img/idcard/b.jpg'))) : '';
?>

<style>
    @font-face {
        font-family: 'Montserrat';
        src: url('<?php echo e(base_path('storage/fonts/static/Montserrat-Black.ttf')); ?>') format('truetype');
        font-weight: 900;
        font-style: normal;
    }

    @font-face {
        font-family: 'Montserrat';
        src: url('<?php echo e(base_path('storage/fonts/static/Montserrat-BlackItalic.ttf')); ?>') format('truetype');
        font-weight: 900;
        font-style: italic;
    }

    @font-face {
        font-family: 'Montserrat';
        src: url('<?php echo e(base_path('storage/fonts/static/Montserrat-Bold.ttf')); ?>') format('truetype');
        font-weight: 700;
        font-style: normal;
    }

    @font-face {
        font-family: 'Montserrat';
        src: url('<?php echo e(base_path('storage/fonts/static/Montserrat-BoldItalic.ttf')); ?>') format('truetype');
        font-weight: 700;
        font-style: italic;
    }

    @font-face {
        font-family: 'Montserrat';
        src: url('<?php echo e(base_path('storage/fonts/static/Montserrat-ExtraBold.ttf')); ?>') format('truetype');
        font-weight: 800;
        font-style: normal;
    }

    @font-face {
        font-family: 'Montserrat';
        src: url('<?php echo e(base_path('storage/fonts/static/Montserrat-ExtraBoldItalic.ttf')); ?>') format('truetype');
        font-weight: 800;
        font-style: italic;
    }

    @font-face {
        font-family: 'Montserrat';
        src: url('<?php echo e(base_path('storage/fonts/static/Montserrat-Light.ttf')); ?>') format('truetype');
        font-weight: 300;
        font-style: normal;
    }

    @font-face {
        font-family: 'Montserrat';
        src: url('<?php echo e(base_path('storage/fonts/static/Montserrat-LightItalic.ttf')); ?>') format('truetype');
        font-weight: 300;
        font-style: italic;
    }

    @font-face {
        font-family: 'Montserrat';
        src: url('<?php echo e(base_path('storage/fonts/static/Montserrat-Medium.ttf')); ?>') format('truetype');
        font-weight: 500;
        font-style: normal;
    }

    @font-face {
        font-family: 'Montserrat';
        src: url('<?php echo e(base_path('storage/fonts/static/Montserrat-MediumItalic.ttf')); ?>') format('truetype');
        font-weight: 500;
        font-style: italic;
    }

    @font-face {
        font-family: 'Montserrat';
        src: url('<?php echo e(base_path('storage/fonts/static/Montserrat-Regular.ttf')); ?>') format('truetype');
        font-weight: 400;
        font-style: normal;
    }

    @font-face {
        font-family: 'Montserrat';
        src: url('<?php echo e(base_path('storage/fonts/static/Montserrat-SemiBold.ttf')); ?>') format('truetype');
        font-weight: 600;
        font-style: normal;
    }

    @font-face {
        font-family: 'Montserrat';
        src: url('<?php echo e(base_path('storage/fonts/static/Montserrat-SemiBoldItalic.ttf')); ?>') format('truetype');
        font-weight: 600;
        font-style: italic;
    }

    @font-face {
        font-family: 'Montserrat';
        src: url('<?php echo e(base_path('storage/fonts/static/Montserrat-Thin.ttf')); ?>') format('truetype');
        font-weight: 200;
        font-style: normal;
    }

    @font-face {
        font-family: 'Montserrat';
        src: url('<?php echo e(base_path('storage/fonts/static/Montserrat-ThinItalic.ttf')); ?>') format('truetype');
        font-weight: 200;
        font-style: italic;
    }

    body,
    p,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    ul,
    td,
    div,
    span {
        font-family: 'Montserrat', sans-serif !important;
    }

    .cardsmain {
        display: grid;
        grid-template-columns: auto auto;
        grid-gap: 20px;
    }

    .d-flex {
        display: flex !important;
        justify-content: space-between;
    }

    .card_font {
        background: url("data:image/jpeg;base64,<?php echo e($bgFront); ?>") no-repeat center center;
        background-size: cover;
        height: 410px;
        width: 250px;
    }

    .back_card {
        background: url("data:image/jpeg;base64,<?php echo e($bgBack); ?>") no-repeat center center;
        background-size: cover;
        height: 410px;
        width: 250px;
    }

    .imas-area {
        padding-top: 79px;
        padding-left: 86px;
    }

    .infor_area {
        padding: 0px;
        padding-bottom: 0px;
    }

    .infor_area .sname {
        padding-top: 16px;
        font-size: 15px;
        text-align: center;
        font-family: "Montserrat", sans-serif !important;
    }

    .infor_area .cname {
        font-size: 10px;
        text-align: center;
        font-family: "Montserrat", sans-serif !important;
    }

    .details_info {
        padding-left: 30px;
        padding-top: 5px;

    }

    .details_info p {
        font-size: 10px;
        font-weight: bold;
        text-transform: uppercase;
        line-height: 7px;
    }

    .text-upper {
        text-transform: uppercase;
        font-weight: bolder;
        font-size: 12px;
        padding-left: 100px;
        padding-top: 110px;
        color: #000;
        font-family: "Montserrat", sans-serif !important;
    }

    .text-light {
        color: #fff !important;
    }

    .details_info>p {
        color: #000 !important;
    }

    .sname {
        color: #35C2D6 !important;
        font-weight: 700 !important;
        font-family: "Montserrat", sans-serif !important;

    }

    .cname {
        margin-top: -5px;
        color: #1E4B6C !important;
        font-weight: 700 !important;
        font-family: "Montserrat", sans-serif !important;
    }

    .ts_heading {
        color: #35C2D6 !important;
        font-size: 14px;
        font-weight: 700;
        padding-top: 45px;
        /* padding-left: 55px; */
        text-align: center;
    }

    .con_area>p {
        font-size: 6px;
        line-height: 5px
        text-align: justify;
        color: #000;
        padding-left: 30px;
        padding-right: 15px;
        /* margin: 5px 0px; */
        font-weight: 700;
    }

    .qrcode {
        margin-top: 5px;
        margin-left: 90px;
    }

    .card_footer {
        font-size: 10.5px;
        font-weight: 700;
        /* padding-top: 30px; */
        padding-left: 16px
    }

    .address_area p {
        font-size: 8px;
        margin: 0px;
        color: #000;
        padding: 0px 14px;
        font-weight: 600;
        line-height: 8px;
    }

    .address_area p span {
        font-weight: 900
    }
    .sing_img {
        height: 22px;
        padding-left: 40px;
        margin-bottom: -12px;
    }
    .sign_p {
        font-size: 10px;
        font-weight: 700;
        width: 168px;
        text-decoration: overline !important;
    }

    .sign_area {
        padding-left: 20px;
        padding-top: 5px;
    }

    .card_s_footer p {
        font-size: 10px;
        color: #fff;
        font-weight: 900;
        margin-top: 3px;
        padding-left: 12px;
    }

    .mb-0 {
        margin-bottom: 0px;
        margin-top: 0px;
    }

    .p-0 {
        padding: 0px;
    }

    .details_info>p {
        padding: 2px 0px;
    }

    .img-fluid {
        max-width: 100%;
        height: auto
    }

    .rounded-circle {
        border-radius: 50% !important
    }

    .web_cion {
        position: relative;
        top: 2px;
    }

    .dotsof {
        position: relative;
    }

    .dots1,
    .dots2 {
        position: absolute;
        left: 10px;
        top: 8px;
        height: 14px;
        width: 14px;
        background: #35C2D6;
        border-radius: 50%;
        font-size: 10px;
        line-height: 10px;
        text-align: center;
        font-weight: 700;
        color: #fff;

    }

    .dots2 {
        top: 45px;
    }
    body,
    p,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    ul,
    td,
    div,
    span {
        font-family: "Montserrat", sans-serif !important;
    }
</style>
<table>
    <tr>
        <td>
            <div class="card_font">
                <div class="imas-area">
                    <img src="data:image/png;base64,<?php echo e($studentImage); ?>" alt="Student Image" class="rounded-circle img-fluid" style="width: 80px; height:82px;">
                </div>
                <div class="infor_area">
                    <p class="mb-0 sname"><?php echo e($targetStudents->sname); ?></p>
                    <p class="cname"><?php echo e($targetStudents->StudentsCourses->name); ?></p>
                </div>

                <div class="details_info">
                    <p class="p-0 mb-0">ID NO.
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                        <?php echo e($targetStudents->id); ?> </p>
                    <p class="mb-0">BATCH
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        : <?php echo e($targetStudents->StudentsBatchs->batchnum); ?></p>
                    <p class="mb-0">DURATION &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :
                        <?php echo e($targetStudents->StudentsCourses->courseduration); ?> Months</p>
                    <p class="mb-0">MODULE
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :
                        <?php echo e($targetStudents->StudentsCourses->totalmoduls); ?></p>
                    <p class="mb-0">NID / BCN &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                        <?php echo e($targetStudents->nid); ?> </p>
                    <p class="mb-0">BLOOD GROUP &nbsp; : <?php echo e($blood); ?> </p>
                    <p class="mb-0">ENROLL DATE &nbsp;&nbsp;&nbsp; : <?php echo e($admission_date); ?> </p>
                    <div class="sign_area">
                        <img src="data:image/png;base64,<?php echo e($signImage); ?>" alt="Signature" class="sing_img">
                        <p class="sign_p">
                            Authorised Signature
                        </p>
                    </div>
                </div>
                <div class="card_footer">
                   <img src="data:image/png;base64,<?php echo e($webIcon); ?>" alt="Web Icon" height="12" class="web_cion">
                    <span class="text-light ">www.innovacomputersbd.com</span>
                </div>
            </div>
        </td>
        <td>
            <div class="back_card">
                <p class="mb-0 text-upper text-light">validity : <?php echo e($newDate); ?></p>

                <div class="trams_conditions">
                    <p class="ts_heading mb-0">
                        TERMS & CONDITIONS
                    </p>
                    <div class="dotsof">
                        <div class="dots1">
                            1
                        </div>
                        <div class="dots2">
                            2
                        </div>
                    </div>
                    <div class="con_area">
                        <p>
                            Your ID Card remains the property of the institute and must be returned when you expire
                            your course duration. Your ID Card is not transferable. You're responsible for use of your
                            ID Card
                            at all times while in the institute buildings. You must keep your ID Card secure.
                        </p>
                        <p>
                            You must not give your ID Card for another person to use. You should not bend or deface your
                            ID Card. You should not expose your card to extreme heat. If your ID Card is lost, stolen or
                            damaged, you should report it immediately to administration.
                        </p>
                    </div>
                    <div class="address_area">
                        <p><span>Main Branch :</span> Master Para, Central Point, Subarnachar, Noakhali.</p>
                        <p><span>Second Branch :</span> College Road, New Market, Khaserhat, Subarnachar, Noakhali.</p>
                    </div>
                    <table>
                        <tr>
                            <td>
                            </td>
                            <td>
                                <div class="qrcode">
                                    <img src="data:image/png;base64, <?php echo base64_encode(
                                        QrCode::format('png')->size(50)->generate('https://innovacomputersbd.com/std/' . $targetStudents->id),
                                    ); ?>" alt="!">
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="card_s_footer">
                    <p>
                        Emergency Call: +88 01867 033 550
                    </p>

                </div>
            </div>
        </td>
    </tr>
</table>
<?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/idcard/cards.blade.php ENDPATH**/ ?>