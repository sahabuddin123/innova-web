

<?php $__env->startSection('title'); ?>
    <?php echo e($pageTitle); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $date = strtotime($targetStudents->StudentsBatchs->startdate);
        $startdate = date('d-M-Y', $date);
    ?>

    <?php
        if ($targetStudents->bloodgroup == 1) {
            $blood = 'A(+ve)';
        } elseif ($targetStudents->bloodgroup == 2) {
            $blood = 'O(+ve)';
        } elseif ($targetStudents->bloodgroup == 3) {
            $blood = 'B(+ve)';
        } elseif ($targetStudents->bloodgroup == 4) {
            $blood = 'AB(+ve)';
        } elseif ($targetStudents->bloodgroup == 5) {
            $blood = 'A(-ve)';
        } elseif ($targetStudents->bloodgroup == 6) {
            $blood = 'O(-ve)';
        } elseif ($targetStudents->bloodgroup == 7) {
            $blood = 'B(-ve)';
        } else {
            $blood = 'AB(-ve)';
        }
    ?>

    <?php
        $date = strtotime($targetStudents->admission_date);
        $admission_date = date('d-M-Y', $date);
    ?>

    <style>
         @font-face {
               font-family: "Nunito";
                src: url(<?php echo e(storage_path("fonts/static/Nunito-Bold.ttf")); ?>) format("truetype");
                font-weight: 700;
                font-style: normal;
            }
    
            @font-face {
               font-family: "Nunito";
                src: url(<?php echo e(storage_path("fonts/static/Nunito-BoldItalic.ttf")); ?>) format("truetype");
                font-weight: 700;
                font-style: italic;
            }
    
            @font-face {
               font-family: "Nunito";
                src: url(<?php echo e(storage_path("fonts/static/Nunito-ExtraBold.ttf")); ?>) format("truetype");
                font-weight: 800;
                font-style: normal;
            }
    
            @font-face {
               font-family: "Nunito";
                src: url(<?php echo e(storage_path("fonts/static/Nunito-ExtraBoldItalic.ttf")); ?>) format("truetype");
                font-weight: 800;
                font-style: italic;
            }
    
            @font-face {
               font-family: "Nunito";
                src: url(<?php echo e(storage_path("fonts/static/Nunito-Light.ttf")); ?>) format("truetype");
                font-weight: 300;
                font-style: normal;
            }
    
            @font-face {
               font-family: "Nunito";
                src: url(<?php echo e(storage_path("fonts/static/Nunito-LightItalic.ttf")); ?>) format("truetype");
                font-weight: 300;
                font-style: italic;
            }
    
            @font-face {
               font-family: "Nunito";
                src: url(<?php echo e(storage_path("fonts/static/Nunito-Medium.ttf")); ?>) format("truetype");
                font-weight: 500;
                font-style: normal;
            }
    
            @font-face {
               font-family: "Nunito";
                src: url(<?php echo e(storage_path("fonts/static/Nunito-MediumItalic.ttf")); ?>) format("truetype");
                font-weight: 500;
                font-style: italic;
            }
    
            @font-face {
               font-family: "Nunito";
                src: url(<?php echo e(storage_path("fonts/static/Nunito-Regular.ttf")); ?>) format("truetype");
                font-weight: 400;
                font-style: normal;
            }
    
            @font-face {
               font-family: "Nunito";
                src: url(<?php echo e(storage_path("fonts/static/Nunito-SemiBold.ttf")); ?>) format("truetype");
                font-weight: 600;
                font-style: normal;
            }
    
            @font-face {
               font-family: "Nunito";
                src: url(<?php echo e(storage_path("fonts/static/Nunito-SemiBoldItalic.ttf")); ?>) format("truetype");
                font-weight: 600;
                font-style: italic;
            }
    
            @font-face {
               font-family: "Nunito";
                src: url(<?php echo e(storage_path("fonts/static/Nunito-Italic.ttf")); ?>) format("truetype");
                font-weight: 400;
                font-style: italic;
            }
    
            body {
                font-family: "Nunito", sans-serif !important;
            }

        .card_font {
            background: url("<?php echo asset('./backend/img/idcard/a.jpg'); ?>");
            height: 410px;
            width: 250px;

            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }

        .back_card {
            background: url("<?php echo asset('./backend/img/idcard/b.jpg'); ?>");
            height: 410px;
            width: 250px;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }

        .imas-area {
            padding-top: 79px;
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
            padding-top: 10px;

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
            color: #35C2D6 !important;
            font-weight: 900 !important;

        }

        .cname {
            margin-top: -5px;
            color: #1E4B6C !important;
            font-weight: 900 !important;
        }

        .ts_heading {
            color: #35C2D6 !important;
            font-size: 14px;
            font-weight: 600;
            padding-top: 42px;
            padding-left: 55px
        }

        .con_area>p {
            font-size: 6px;
            text-align: justify;
            color: #000;
            padding-left: 30px;
            padding-right: 15px;
            line-height: 8px;
            margin: 5px 0px;
        }

        .qrcode {
            margin-top: -10px;
            margin-left: -10px;
        }

        .card_footer {
            font-size: 11px;
            font-weight: 900;
            padding-top: 30px;
            padding-left: 16px
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
            padding-left: 20px
        }

        .sign_p {
            font-size: 10px;
            font-weight: 700;
            width: 168px;
            text-decoration: overline 2px solid;
        }

        .sign_area {
            padding-left: 20px;
            padding-top: 5px;
        }

        .card_s_footer p {
            font-size: 11px;
            color: #fff;
            font-weight: 900;
            margin-top: -7px;
            padding-left: 12px;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-4 p-0" style="padding-left: 5% !important;">
                <div class="card_font">
                    <div class="imas-area">
                        <img src="<?php echo asset('public/storage/' . $targetStudents->image); ?>" alt="!" class="rounded-circle img-fluid"
                            style="width: 82px; height:82px;">
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
                    </div>
                    <div class="card_footer">
                        <img src="<?php echo asset('./backend/img/idcard/web.png'); ?>" alt="" height="14"> <span
                            class="text-light ">www.innovacomputersbd.com</span>
                    </div>
                </div>
            </div>
            <div class="col-4 p-0">
                <div class="back_card">
                    <?php
                        use Carbon\Carbon;
                        $dateObject = Carbon::parse($admission_date);
                        $dateObject->addMonth($targetStudents->StudentsCourses->courseduration);
                        $newDate = $dateObject->format('d-m-Y');
                    ?>
                    <p class="mb-0 text-upper text-light">validity : <?php echo e($newDate); ?></p>
                    <div class="trams_conditions">
                        <p class="ts_heading mb-0">
                            TERMS & CONDITIONS
                        </p>
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
                        <div class="d-flex">
                            <div class="sign_area">
                                <img src="<?php echo asset('./backend/img/idcard/sign.png'); ?>" alt="!" class="sing_img">
                                <p class="sign_p">
                                    Authorised Signature
                                </p>
                            </div>
                            <div class="qrcode">
                                <img src="data:image/png;base64, <?php echo base64_encode(
                                    QrCode::format('png')->size(55)->generate('https://innovacomputersbd.com/std/' . $targetStudents->id),
                                ); ?>" alt="!">
                            </div>
                        </div>
                        <div class="card_s_footer">
                            <p>
                                Emergency Call: +88 01867 033 550
                            </p>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-5">
            <a href="<?php echo e(route('admin.idcard.iddownload', $targetStudents->id)); ?>"
                class="btn btn-primary pull-right">Download Card</a>

        </div>
    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/idcard/show.blade.php ENDPATH**/ ?>