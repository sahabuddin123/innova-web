<?php $__env->startSection('title'); ?>
    রিপোর্ট
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <style>
        @import  url('https://fonts.maateen.me/solaiman-lipi/font.css');

        body,
        .report-container,
        table,
        th,
        td,
        button {
            font-family: 'SolaimanLipi', sans-serif !important;
        }

        .report-container {
            max-width: 1100px;
            margin: 20px auto;
            padding: 30px 30px 10px 30px;
            background: #fff;
        }

        .meta-table {
            width: 100%;
            border: none;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .meta-table td {
            border: none;
            padding: 2px 4px;
            vertical-align: top;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            border: 1px solid #000;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 16px;
            text-align: center
        }

        .data-table th {
            background: #f0f0f0;
            font-weight: bold;
        }



        .data-table .desc-row td {
            text-align: left;
        }

        .data-table .amount-row td {
            text-align: right;
            font-weight: bold;
        }

        .words-row td {
            border-top: none;
            border-bottom: none;
            font-weight: bold;
        }

        .signatures {
            width: 100%;
            margin-top: 40px;
            font-size: 16px;
        }

        .signatures td {
            padding: 30px 0 0 0;
            text-align: center;
            vertical-align: bottom;
        }

        .sign-line {
            display: inline-block;
            border-top: 1px solid #000;
            width: 160px;
            margin-bottom: 0px;
        }

        .note-label {
            font-size: 16px;
            margin-top: 30px;
        }

        .note-box {
            border: 1px solid #000;
            min-height: 60px;
            margin-top: 5px;
            font-size: 16px;
            padding: 8px;
        }

        .report-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .report-header img {
            max-width: 150px;
        }
        .mll-1 {
            margin-left: 30px;
        }
        .mrr-1 {
            margin-right: 10px;
        }
        @media  print {

            .print_none,
            .navigation,
            .sidebar,
            .navbar,
            footer,
            .page-titles {
                display: none !important;
            }

            .report-container {
                max-width: 100%;
                margin: 0;
                padding: 0;
            }
        }
    </style>

    <?php echo $__env->make('admin.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php
    use lemonpatwari\BanglaNumber\NumberToBangla;
    $numberToBangla = new NumberToBangla();
    ?>
    <div class="container-fluid print_none" style="margin-bottom: 20px;">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-primary">বিবরণ</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <a href="javascript:window.print();" class="btn btn-info d-none d-lg-block m-l-15">
                        <span><i class="fa fa-print"></i></span> প্রিন্ট
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="report-container">
        <div class="report-header">
            <img src="<?php echo e(asset('public/storage/' . config('settings.site_logo'))); ?>" alt="INNOVA COMPUTERS">
        </div>
        <table class="meta-table">
            <tr>
                <td style="width:33%">প্রতিষ্ঠানের নামঃ ইনোভা কম্পিউটার্স বিডি ।</td>
                <td style="width:33%">শাখার নামঃ <?php echo e($targetData->branches->bname ?? ''); ?></td>
                <td style="width:33%">ভাউচার নংঃ 
                    <?php
                        $inv = isset($targetData->invoiceID) ? (string)$targetData->invoiceID : '';
                        echo (ctype_digit($inv) && $inv !== '') ? $numberToBangla->bnNum($inv) : $inv;
                    ?>
                </td>
            </tr>
            <tr>
                <td>খাতের নামঃ <?php echo e($targetData->exCategoris->category ?? ($targetData->inCategoris->categoris ?? '')); ?></td>
                <td>মাসের নামঃ <?php
                    if (isset($targetData->invoiceDate)) {
                        $monthNum = date('m', strtotime($targetData->invoiceDate));
                        $banglaMonths = [
                            '01' => 'জানুয়ারি',
                            '02' => 'ফেব্রুয়ারি',
                            '03' => 'মার্চ',
                            '04' => 'এপ্রিল',
                            '05' => 'মে',
                            '06' => 'জুন',
                            '07' => 'জুলাই',
                            '08' => 'আগস্ট',
                            '09' => 'সেপ্টেম্বর',
                            '10' => 'অক্টোবর',
                            '11' => 'নভেম্বর',
                            '12' => 'ডিসেম্বর',
                        ];
                        echo $banglaMonths[$monthNum] ?? $monthNum;
                    }
                ?></td>
                <td>সালঃ <?php
                    if (isset($targetData->invoiceDate)) {
                        $year = date('Y', strtotime($targetData->invoiceDate));
                        echo (ctype_digit($year) && $year !== '') ? $numberToBangla->bnNum($year) : $year;
                    }
                ?></td>
            </tr>
            <tr>
                <td>বিক্রেতার নামঃ <?php echo e($targetData->seller ?? ''); ?></td>
                <td>গ্রহণকারীর নামঃ <?php echo e($targetData->recever ?? ''); ?></td>
                <td>তারিখঃ
                    <?php
                        if (isset($targetData->invoiceDate)) {
                            $date = date('d/m/Y', strtotime($targetData->invoiceDate));
                            $dateParts = explode('/', $date);
                            $bnDate = [];
                            foreach ($dateParts as $part) {
                                $bnDate[] = (ctype_digit($part) && $part !== '') ? $numberToBangla->bnNum($part) : $part;
                            }
                            echo implode('/', $bnDate);
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td>মেমো শিরোনামঃ <b><?php echo e($targetData->title ?? ''); ?></b></td>
                <td></td>
                <td></td>
            </tr>
        </table>

        <table class="data-table">
            <thead>
                <tr>
                    <th>বিবরণী</th>
                    <th>টাকার পরিমাণ</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center"><?php echo e($targetData->description ?? ''); ?></td>
                    <td style="text-align: center">
                        <?php
                            $amountValue = isset($targetData->amount)
                                ? str_replace(',', '', (string) $targetData->amount)
                                : '';
                        ?>
                        <?php echo e(is_numeric($amountValue) && $amountValue !== '' && $amountValue !== null ? $numberToBangla->bnNum($amountValue) : ''); ?>

                    </td>
                </tr>
                <tr>
                    <td style="text-align: right">সর্বমোট পরিমাণ (অংকে):</td>
                    <td style="text-align: center">
                        <b><?php echo e(is_numeric($amountValue) && $amountValue !== '' && $amountValue !== null ? $numberToBangla->bnNum($amountValue) : ''); ?></b>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: left">সর্বমোট পরিমাণ (কথায়):
                        <?php
                            $amountValue = isset($targetData->amount)
                                ? str_replace(',', '', (string) $targetData->amount)
                                : '';
                        ?>
                        <?php
                            $words = '';
                            if (is_numeric($amountValue) && $amountValue !== '' && $amountValue !== null) {
                                $parts = explode('.', $amountValue);
                                $intPart = $parts[0];
                                $poisha = isset($parts[1]) ? substr($parts[1], 0, 2) : '';
                                if (ctype_digit((string)$intPart)) {
                                    $words = $numberToBangla->bnWord($intPart) . ' টাকা';
                                    if ($poisha !== '' && ctype_digit($poisha) && intval($poisha) > 0) {
                                        $words .= ' ' . $numberToBangla->bnWord($poisha) . ' পয়সা মাত্র';
                                    } else {
                                        $words .= ' মাত্র';
                                    }
                                } else {
                                    $words = '';
                                }
                            }
                        ?>
                        <b> <?php echo e($words); ?></b>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="signatures">
            <tr>
                <td style="text-align: left"><span class="sign-line"></span><br><span class="mll-1">গ্রহণকারীর স্বাক্ষর</span>
                </td>
                <td></td>
                <td></td>
                <td style="text-align: right"><span class="sign-line"></span><br><span class="mrr-1">প্রস্তুতকারীর
                        স্বাক্ষর</span></td>

            </tr>
            <tr>
                <td style="text-align: left"><span class="sign-line"></span><br><span class="mll-1">ইস্যুকারীর
                        স্বাক্ষর</span></td>
                <td></td>
                <td></td>
                <td style="text-align: right"><span class="sign-line"></span><br><span class="mrr-1">নির্বাহী পরিচালকের
                        স্বাক্ষর</span></td>
            </tr>
        </table>

        
    </div>

    <div class="container-fluid print_none" style="margin-top: 20px;">
        <div class="row">
            <div class="col-md-12">
                <a href="javascript:history.back();" class="btn btn-warning m-t-10"><i class="fa fa-arrow-left"></i> ফিরে
                    যান</a>
                
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/report/singleRecordPrint.blade.php ENDPATH**/ ?>