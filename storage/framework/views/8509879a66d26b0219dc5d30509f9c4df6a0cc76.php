<?php $__env->startSection('title'); ?>
    আয় বিস্তারিত
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <style>
        @import  url('https://fonts.maateen.me/solaiman-lipi/font.css');

        /* * { font-family: 'SolaimanLipi', sans-serif !important; color: #000 !important; } */

        body {
            background-color: #fff;
            padding: 0;
            margin: 0;
            font-family: 'SolaimanLipi', sans-serif !important;
        }

        .report-container {
            max-width: 900px;
            margin: 20px auto;
            padding: 30px;
            background-color: white;
        }

        .report-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .report-header img {
            max-width: 150px;
        }

        .header-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .header-info div {
            flex: 1;
            text-align: center;
        }

        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 16px;
        }

        .info-section div {
            flex: 1;
            text-align: center;
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
        }

        .data-table th {
            background: #f0f0f0;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-area {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            margin: 12px 0 0 0;
        }

        .remarks-box {
            flex: 2;
            border: 1px solid #000;
            min-height: 70px;
            padding: 10px;
        }

        .words-box {
            flex: 3;
            border: 1px solid #000;
            min-height: 70px;
            padding: 12px;
            background: #fafafa;
            font-weight: 600;
        }

        .total-box {
            flex: 1;
            border: 1px solid #000;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .total-box .label {
            border-bottom: 1px solid #000;
            padding: 8px;
            font-weight: bold;
        }

        .total-box .amount {
            padding: 12px;
            font-weight: bold;
            font-size: 16px;
        }

        .comment-section {
            margin: 0 0 10px 0;
            font-size: 16px;
        }

        .comment-box {
            border: 1px solid #000;
            min-height: 70px;
            padding: 8px;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 100px;
            font-size: 16px;
            text-align: center;
        }

        .signature-item {
            flex: 1;
            padding-top: 5px;
            border-top: 1px solid #000;
            margin: 0 5px;
        }

        /* Screen vs Print toggle */
        .screen-only {
            display: block !important;
        }

        .print-only {
            display: none !important;
            visibility: hidden !important;
            height: 0 !important;
            overflow: hidden !important;
        }

        @media  print {

            .navigation,
            .print_none,
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

            .screen-only {
                display: none !important;
                visibility: hidden !important;
            }

            .print-only {
                display: block !important;
                visibility: visible !important;
                height: auto !important;
                overflow: visible !important;
                background: #fff !important;
            }
        }
    </style>

    <div class="container-fluid print_none" style="margin-bottom: 20px;">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-primary">আয় বিবরণ</h4>
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

    <?php echo $__env->make('admin.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php
    use lemonpatwari\BanglaNumber\NumberToBangla;
    $numberToBangla = new NumberToBangla();
    ?>

    <?php
        // Prepare pagination pages (max 15 rows per page)
        $flat = $processedIncomes ?? [];
        $flat = array_values($flat);
        $totalCount = count($flat);
        $pages = [];
        $pageIndex = 0;
        $index = 0;
        $globalIndex = 0;

        while ($index < $totalCount) {
            if ($pageIndex === 0) {
                // First page: up to 15 rows
                $slice = array_slice($flat, $index, 20);
                $page = [];
                foreach ($slice as $s) {
                    $s['__global_index'] = $globalIndex;
                    $page[] = $s;
                    $globalIndex++;
                }
                $pages[] = $page;
                $index += count($slice);
            } else {
                // Subsequent pages: carry-forward + up to 14 new rows
                $prevTotal = 0.0;
                for ($j = 0; $j < $index; $j++) {
                    $amtRaw = 0;
                    if (isset($flat[$j]['amount'])) {
                        $amtRaw = $flat[$j]['amount'];
                    } elseif (isset($flat[$j]['amountFormatted'])) {
                        $amtRaw = str_replace(',', '', (string) $flat[$j]['amountFormatted']);
                    }
                    $prevTotal += floatval($amtRaw);
                }

                $carry = [
                    'description' => 'পূর্বের জের',
                    'amountFormatted' => number_format($prevTotal, 2),
                    'day' => '',
                    'month' => '',
                    '__is_carry' => true,
                ];

                $slice = array_slice($flat, $index, 19);
                $page = [$carry];
                foreach ($slice as $s) {
                    $s['__global_index'] = $globalIndex;
                    $page[] = $s;
                    $globalIndex++;
                }
                $pages[] = $page;
                $index += count($slice);
            }

            $pageIndex++;
        }
    ?>

    <!-- Screen view: show full list (no pagination) -->
    <div class="report-container screen-only">
        <div class="report-header">
            <img src="<?php echo e(asset('public/storage/'.config('settings.site_logo'))); ?>" alt="INNOVA COMPUTERS">
        </div>
        <div class="header-info">
            <div>প্রতিষ্ঠানের নামঃ ইনোভা কম্পিউটার্স বিডি</div>
            <div>শাখার নামঃ <?php echo e($branchName ?? ''); ?></div>
            <div>সিরিয়াল নংঃ <?php echo e(isset($serialNo) ? $numberToBangla->bnNum((string) $serialNo) : ''); ?></div>
        </div>
        <div class="info-section">
            <div style="margin-left: -40px;margin-right: 38px;"><b> খাতের নামঃ <?php echo e($category ? $category->categoris : ' '); ?></b></div>
            <div>মাসের নামঃ <?php echo e($monthName ?? 'January'); ?></div>
            <div>সালঃ <?php echo e(isset($year) ? $numberToBangla->bnNum((string) $year) : ''); ?> ইং</div>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 8%">ক্রঃ</th>
                    <th style="width: 12%">তারিখ</th>
                    <th style="width: 50%">বিবরণী</th>
                    <th style="width: 30%; text-align: right;">টাকার পরিমাণ</th>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($processedIncomes) && count($processedIncomes) > 0): ?>
                    <?php $__currentLoopData = $processedIncomes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $income): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-center"><?php echo e($numberToBangla->bnNum((string) ($key + 1))); ?></td>
                            <td><?php echo e($numberToBangla->bnNum((string) $income['day'])); ?>/<?php echo e($numberToBangla->bnNum((string) $income['month'])); ?>

                            </td>
                                <td>
                                    <?php if(isset($income['id'])): ?>
                                        <a href="<?php echo e(route('admin.income.view', $income['id'])); ?>?report=1"><?php echo e($income['description']); ?></a>
                                    <?php else: ?>
                                        <?php echo e($income['description']); ?>

                                    <?php endif; ?>
                                </td>
                            <td class="text-right">
                                <?php echo e($numberToBangla->bnNum(str_replace(',', '', (string) $income['amountFormatted']))); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">রেকর্ড নেই</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="total-area">
            
            <div class="words-box">
                <strong>কথায়ঃ</strong>
                <div style="margin-top:6px;"><?php echo e($totalInWords ?? ''); ?></div>
            </div>
            <div class="total-box">
                <div class="label">সর্বমোট টাকার পরিমাণ অংকে</div>
                <div class="amount">
                    <?php echo e(isset($totalFormatted) ? $numberToBangla->bnNum(str_replace(',', '', (string) $totalFormatted)) : '०'); ?>

                </div>
            </div>
        </div>
    </div>

    <!-- Print view: paginated pages (visible only during print) -->
    <div class="print-only">
        <?php if(count($pages) > 1): ?>
            <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pIdx => $pageRows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="report-container" style="<?php echo e($pIdx < count($pages) - 1 ? 'page-break-after: always;' : ''); ?>">
                    <!-- Header & Info repeated on each page -->
                    <div class="report-header">
                        <img src="<?php echo e(asset('public/storage/'.config('settings.site_logo'))); ?>" alt="INNOVA COMPUTERS">
                    </div>

                    <div class="header-info">
                        <div>প্রতিষ্ঠানের নামঃ ইনোভা কম্পিউটার্স বিডি</div>
                        <div>শাখার নামঃ <?php echo e($branchName ?? ''); ?></div>
                        <div>সিরিয়াল নংঃ <?php echo e(isset($serialNo) ? $numberToBangla->bnNum((string) $serialNo) : ''); ?></div>
                    </div>

                    <div class="info-section">
                        <div style="margin-left: -40px;margin-right: 38px;"><b> খাতের নামঃ <?php echo e($category ? $category->categoris : ''); ?></b></div>
                        <div>মাসের নামঃ <?php echo e($monthName ?? 'January'); ?></div>
                        <div>সালঃ <?php echo e(isset($year) ? $numberToBangla->bnNum((string) $year) : ''); ?> ইং</div>
                    </div>

                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width: 8%">ক্রঃ</th>
                                <th style="width: 12%">তারিখ</th>
                                <th style="width: 50%">বিবরণী</th>
                                <th style="width: 30%; text-align: right;">টাকার পরিমাণ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $pageRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rKey => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    // robust amount extraction for printing
                                    if (isset($row['amount'])) {
                                        $amtForPrintRaw = $row['amount'];
                                    } elseif (isset($row['amountFormatted'])) {
                                        $amtForPrintRaw = str_replace(',', '', (string) $row['amountFormatted']);
                                    } else {
                                        $amtForPrintRaw = 0;
                                    }
                                ?>
                                <tr>
                                    <?php if(isset($row['__is_carry']) && $row['__is_carry'] === true): ?>
                                        <td class="text-center">&nbsp;</td>
                                        <td class="text-center">&nbsp;</td>
                                        <td><strong><?php echo e($row['description']); ?></strong></td>
                                        <td class="text-right">
                                            <strong><?php echo e($numberToBangla->bnNum((string) $amtForPrintRaw)); ?></strong>
                                        </td>
                                    <?php else: ?>
                                        <td class="text-center">
                                            <?php echo e($numberToBangla->bnNum((string) ($row['__global_index'] + 1))); ?></td>
                                        <td class="text-center">
                                            <?php echo e($numberToBangla->bnNum((string) $row['day'])); ?>/<?php echo e($numberToBangla->bnNum((string) $row['month'])); ?>

                                        </td>
                                        <td><?php echo e($row['description']); ?></td>
                                        <td class="text-right">
                                            <?php echo e($numberToBangla->bnNum((string) $amtForPrintRaw)); ?>

                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php
                                $rowsOnPage = count($pageRows);
                                $fill = 20 - $rowsOnPage;
                            ?>
                            <?php for($f = 0; $f < $fill; $f++): ?>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>

                    <?php if($pIdx === count($pages) - 1): ?>
                        <!-- Last page: show total, comments, signatures -->
                        <div class="total-area">
                            

                            <div class="words-box">
                                <strong>কথায়ঃ</strong>
                                <div style="margin-top:6px;"><?php echo e($totalInWords ?? ''); ?></div>
                            </div>

                            <div class="total-box">
                                <div class="label">সর্বমোট টাকার পরিমাণ অংকে</div>
                                <div class="amount">
                                    <?php echo e(isset($totalFormatted) ? $numberToBangla->bnNum(str_replace(',', '', (string) $totalFormatted)) : '০'); ?>

                                </div>
                            </div>
                        </div>

                        <div class="comment-section">
                            <div class="comment-label">মন্তব্যঃ</div>
                            <div class="comment-box"><?php echo e($comments ?? ''); ?></div>
                        </div>

                        <div class="signature-section">
                            <div class="signature-item">প্রস্তুতকারীর স্বাক্ষর</div>
                            <div class="signature-item">হিসাবরক্ষকের স্বাক্ষর</div>
                            <div class="signature-item">নিরিক্ষকের স্বাক্ষর</div>
                            <div class="signature-item">অডিট অফিসারের স্বাক্ষর</div>
                            <div class="signature-item">নির্বাহী পরিচালকের স্বাক্ষর</div>
                        </div>
                    <?php else: ?>
                        <!-- Intermediate pages: show page subtotal and footer -->
                        <?php
                            $pageSubtotal = 0.0;
                            foreach ($pageRows as $row) {
                                if (!(isset($row['__is_carry']) && $row['__is_carry'] === true)) {
                                    $amtRaw = 0;
                                    if (isset($row['amount'])) {
                                        $amtRaw = $row['amount'];
                                    } elseif (isset($row['amountFormatted'])) {
                                        $amtRaw = str_replace(',', '', (string) $row['amountFormatted']);
                                    }
                                    $pageSubtotal += floatval($amtRaw);
                                }
                            }
                            $pageSubtotalFormatted = number_format($pageSubtotal, 2);
                        ?>
                        <div class="total-area" style="margin-top: 40px;">
                            
                            <div class="words-box">
                                <strong>সাব-টোটাল কথায়ঃ</strong>
                                <?php echo e($numberToBangla->bnWord($pageSubtotal)); ?> 
                            </div>
                            <div class="total-box">
                                <div class="label">সাব-টোটাল টাকা</div>
                                <div class="amount">
                                    <?php echo e($numberToBangla->bnNum(str_replace(',', '', $pageSubtotalFormatted))); ?></div>
                            </div>
                        </div>

                        <div class="comment-section">
                            <div class="comment-label">মন্তব্যঃ</div>
                            <div class="comment-box"><?php echo e($comments ?? ''); ?></div>
                        </div>

                        <div class="signature-section">
                            <div class="signature-item">প্রস্তুতকারীর স্বাক্ষর</div>
                            <div class="signature-item">হিসাবরক্ষকের স্বাক্ষর</div>
                            <div class="signature-item">নিরিক্ষকের স্বাক্ষর</div>
                            <div class="signature-item">অডিট অফিসারের স্বাক্ষর</div>
                            <div class="signature-item">নির্বাহী পরিচালকের স্বাক্ষর</div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <!-- Single page: no pagination needed, show grand total -->
            <div class="report-container">
                <div class="report-header">
                    <img src="<?php echo e(asset('public/storage/'.config('settings.site_logo'))); ?>" alt="INNOVA COMPUTERS">
                </div>

                <div class="header-info">
                    <div>প্রতিষ্ঠানের নামঃ ইনোভা কম্পিউটার্স বিডি</div>
                    <div>শাখার নামঃ <?php echo e($branchName ?? ''); ?></div>
                    <div>সিরিয়াল নংঃ <?php echo e(isset($serialNo) ? $numberToBangla->bnNum((string) $serialNo) : ''); ?></div>
                </div>

                <div class="info-section">
                    <div style="margin-left: -40px;margin-right: 38px;"><b> খাতের নামঃ <?php echo e($category ? $category->categoris : ''); ?></b></div>
                    <div>মাসের নামঃ <?php echo e($monthName ?? 'January'); ?></div>
                    <div>সালঃ <?php echo e(isset($year) ? $numberToBangla->bnNum((string) $year) : ''); ?> ইং</div>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 8%">ক্রঃ</th>
                            <th style="width: 12%">তারিখ</th>
                            <th style="width: 50%">বিবরণী</th>
                            <th style="width: 30%; text-align: right;">টাকার পরিমাণ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($processedIncomes) && count($processedIncomes) > 0): ?>
                            <?php $__currentLoopData = $processedIncomes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $income): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-center"><?php echo e($numberToBangla->bnNum((string) ($key + 1))); ?></td>
                                    <td><?php echo e($numberToBangla->bnNum((string) $income['day'])); ?>/<?php echo e($numberToBangla->bnNum((string) $income['month'])); ?>

                                    </td>
                                    <td><?php echo e($income['description']); ?></td>
                                    <td class="text-right">
                                        <?php echo e($numberToBangla->bnNum(str_replace(',', '', (string) $income['amountFormatted']))); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">রেকর্ড নেই</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="total-area">
                    
                    <div class="words-box">
                        <strong>কথায়ঃ</strong>
                        <div style="margin-top:6px;"><?php echo e($totalInWords ?? ''); ?></div>
                    </div>
                    <div class="total-box">
                        <div class="label">সর্বমোট টাকার পরিমাণ অংকে</div>
                        <div class="amount">
                            <?php echo e(isset($totalFormatted) ? $numberToBangla->bnNum(str_replace(',', '', (string) $totalFormatted)) : '०'); ?>

                        </div>
                    </div>
                </div>

                <div class="comment-section">
                    <div class="comment-label">মন্তব্যঃ</div>
                    <div class="comment-box"><?php echo e($comments ?? ''); ?></div>
                </div>

                <div class="signature-section">
                    <div class="signature-item">প্রস্তুতকারীর স্বাক্ষর</div>
                    <div class="signature-item">হিসাবরক্ষকের স্বাক্ষর</div>
                    <div class="signature-item">নিরিক্ষকের স্বাক্ষর</div>
                    <div class="signature-item">অডিট অফিসারের স্বাক্ষর</div>
                    <div class="signature-item">নির্বাহী পরিচালকের স্বাক্ষর</div>
                </div>
            </div>
        <?php endif; ?>

        <div class="container-fluid print_none" style="margin-top: 20px;">
            <div class="row">
                <div class="col-md-12">
                    <a href="javascript:history.back();" class="btn btn-warning m-t-10"><i class="fa fa-arrow-left"></i>
                        ফিরে যান</a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/report/incomeCategoryDetails.blade.php ENDPATH**/ ?>