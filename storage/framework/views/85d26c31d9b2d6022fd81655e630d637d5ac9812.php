<?php $__env->startSection('title'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <style>
        @import  url('https://fonts.maateen.me/solaiman-lipi/font.css');
        table,
        td,
        tr,
        h1,
        h2,
        h3,
        h4,
        p {
            /* font-family: "Noto Sans Bengali", sans-serif !important; */
            font-family: 'SolaimanLipi', sans-serif !important;
            color: #000 !important;
        }

        td,
        th {
            font-size: 20px
        }

        @media  print {

            /* Styles for printing only, e.g., hiding unwanted elements */
            .navigation,
            .print_none {
                display: none;
            }

            /* Hide navigation bar */
            .sidebar,
            .navbar,
            footer {
                display: none;
            }

            /* Hide sidebar */
            body,
            .container.container-fluid,
            .navbar,
            .bootdey,
            .tile,
            td {
                margin: 0 !important;
                padding: 0 !important;
            }

            #printButton {
                display: none;
            }

            .container {
                display: contents;
            }

            /* Adjust margins for printing */
        }
    </style>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 print_none">
        <div class="print_none">
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-user"></i> </h1>
        </div>
        <div class="print_none">
        </div>
    </div>
    <?php echo $__env->make('admin.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="container bootdey">
        <div class="tile">
            <div class="tile-body">
                <?php
                use App\Models\BanglaDateNumber;
                use lemonpatwari\BanglaNumber\NumberToBangla;
                use Carbon\Carbon;
                $numberToBangla = new NumberToBangla();
                
                function banglaNumderFormat($BnNumber)
                {
                    $numberToBangla = new NumberToBangla();
                    $grandTotalWithoutFormat = $BnNumber;
                    $grandtotalAmount = number_format($grandTotalWithoutFormat, 2, '.', ',');
                    $explodedTotal = explode('.', $grandTotalWithoutFormat);
                    $integerPart = $explodedTotal[0];
                    $decimalPart = isset($explodedTotal[1]) ? $explodedTotal[1] : '00';
                    $banglaInteger = $numberToBangla->bnNum($integerPart);
                    $banglaDecimal = $numberToBangla->bnNum($decimalPart);
                    $formattedOutput = $banglaInteger . '.' . $banglaDecimal;
                    $formattedOutput = $banglaInteger . '.' . str_pad($banglaDecimal, 2, '0', STR_PAD_LEFT);
                    $formattedIntegerPart = strrev(implode(',', str_split(strrev($banglaInteger), 9)));
                    $formattedOutput = $formattedIntegerPart . '.' . str_pad($banglaDecimal, 2, '0', STR_PAD_LEFT);
                    return $formattedOutput;
                }
                ?>
                <div class="row invoice row-printable">
                    <div class="col-md-12">
                        <!-- col-lg-12 start here -->
                        <div class="panel panel-default plain" id="dash_0">
                            <!-- Start .panel -->
                            <div class="panel-body p30">

                                <div class="text-center"> <img
                                        src="<?php echo e(asset('public/storage/' . config('settings.site_logo'))); ?>" alt="!"
                                        height="50"></div>
                                <p class="text-right"><button id="printButton">Print</button></p>
                                <h3 class="text-center">অর্থনৈতিক প্রতিবেদন</h3>
                                <p class="text-center">ঠিকানাঃ <?php echo e($branch->baddress); ?></p>
                                <table class="table ">
                                    <tr>
                                        <th>মাসের নামঃ
                                            <?php
                                                $months = Carbon::createFromDate(null, $month)->format('F');
                                                echo BanglaDateNumber::bn_date($months);
                                            ?></th>
                                        <th>শাখার নামঃ <?php echo e($branch->bname); ?></th>
                                        <th>সালঃ <?php echo e(BanglaDateNumber::bn_number($year)); ?></th>
                                    </tr>
                                </table>
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th colspan="3">আয় সমুহ</th>
                                            
                                            <th colspan="3">ব্যয় সমূহ</th>
                                            
                                        </tr>

                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="3">
                                                
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 10%">ক্রমিক</th>
                                                            <th style="width: 20%">খাতের নাম</th>
                                                            <th style="width: 20%">টাকার পরিমাণ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $__currentLoopData = $incomeData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryId => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>

                                                                <td><?php echo e($numberToBangla->bnNum($loop->index + 1)); ?></td>
                                                            
                                                                <td>
                                                                    <?php if(isset($category['category_name'])): ?>
    <?php $routeParams = ['categoryId' => $categoryId, 'month' => request()->get('month', date('m')), 'year' => request()->get('year', date('Y'))]; ?>
    <?php if(isset($branch) && isset($branch->id)): ?>
        <?php $routeName = 'income.category-details.branch'; $routeParams['branchId'] = $branch->id; ?>
    <?php else: ?>
        <?php $routeName = 'income.category-details'; ?>
    <?php endif; ?>
    <a href="<?php echo e(route($routeName, $routeParams)); ?>" style="color: #000; text-decoration: none; cursor: pointer;">
        <?php echo e($category['category_name']); ?>

    </a>
<?php else: ?>
    No Category Name <?php echo e($categoryId); ?>

<?php endif; ?>
                                                                </td>
                                                                <td><?php echo e(banglaNumderFormat($category['total_expense'])); ?>/-
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                    <?php $grandincome = 0;
                                                    ?>
                                                    <?php $__currentLoopData = $incomeData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryId => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php $grandincome += $category['total_expense']; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="2">সর্বমোট আয়ঃ </th>
                                                            <th>
                                                                <?php echo e(banglaNumderFormat($grandincome)); ?> /-
                                                            </th>
                                                        </tr>
                                                        <tr>

                                                            <th colspan="3" style="font-size: 18px">
                                                                কথায়ঃ <?php echo e($numberToBangla->bnMoney($grandincome)); ?> মাত্র।
                                                            </th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                
                                                <?php
                                                $grandTotal = 0;
                                                ?>
                                                <?php $__currentLoopData = $reportData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryId => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $grandTotal += $category['total_expense']; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                <table class="mt-3 ml-1 mr-1" style="width: 98%">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2">ব্যালেন্স</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>এই মাসের আয়</td>
                                                            <td><b><?php echo e(banglaNumderFormat($grandincome)); ?>/-</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td>এই মাসের ব্যয়</td>
                                                            <td><b><?php echo e(banglaNumderFormat($grandTotal)); ?>/-</b></td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <?php
                                                        $balanceProfight = 0;
                                                        $balanceLoss = 0;
                                                        if ($grandincome == $grandTotal) {
                                                            $balanceProfight = '0.00';
                                                            $balanceLoss = '0.00';
                                                        } elseif ($grandincome > $grandTotal) {
                                                            $balanceProfight = $grandincome - $grandTotal;
                                                            $balanceProfight = number_format((float) $balanceProfight, 2, '.', '');
                                                        } elseif ($grandincome < $grandTotal) {
                                                            $balanceLoss = $grandTotal - $grandincome;
                                                            $balanceLoss = number_format((float) $balanceLoss, 2, '.', '');
                                                        }
                                                        ?>
                                                        <tr class="text-danger">
                                                            <th>ঘাটতি</th>
                                                            <th>
                                                                <?php echo e(banglaNumderFormat($balanceLoss)); ?>/-
                                                            </th>
                                                        </tr>
                                                        <tr class="text-success">
                                                            <th>উদ্ধৃত</th>
                                                            <th>
                                                                <?php echo e(banglaNumderFormat($balanceProfight)); ?>/-
                                                            </th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <?php
                                                $previosMonthTotalIncome = 0;
                                                $previousMothtotalExpance = 0;
                                                $PreviousMonthProfight = 0;
                                                $PreviousMonthLoss = 0;
                                                ?>
                                                <?php $__currentLoopData = $previousIncomeData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryId => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $previosMonthTotalIncome += $category['total_expense']; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php $__currentLoopData = $previousExpanceData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryId => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $previousMothtotalExpance += $category['total_expense']; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    if ($previousMothtotalExpance > $previosMonthTotalIncome) {
                                                        $PreviousMonthLoss =
                                                            $previousMothtotalExpance - $previosMonthTotalIncome;
                                                    } else {
                                                        $PreviousMonthLoss = 0;
                                                    }
                                                    if ($previousMothtotalExpance < $previosMonthTotalIncome) {
                                                        $PreviousMonthProfight =
                                                            $previosMonthTotalIncome - $previousMothtotalExpance;
                                                    } else {
                                                        $PreviousMonthProfight = 0;
                                                    }
                                                    $inTotalIncome = $totalIncomes + $grandincome;
                                                    $intotalExpance = $totalExpenses + $grandTotal;
                                                    $totalLosses = 0;
                                                    $totalprofhites = 0;
                                                    if ($inTotalIncome == $intotalExpance) {
                                                        $totalLosses = 0;
                                                        $totalprofhites = 0;
                                                    } elseif ($inTotalIncome > $intotalExpance) {
                                                        $totalLosses = 0;
                                                        $totalprofhites = $inTotalIncome - $intotalExpance;
                                                    } elseif ($inTotalIncome < $intotalExpance) {
                                                        $totalLosses = $intotalExpance - $inTotalIncome;
                                                        $totalprofhites = 0;
                                                    }
                                                ?>
                                                <table class="mt-3 ml-1 mr-1" style="width: 98%">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2">বিগত মাস গুলোর সাথে সমন্বয়</th>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 65%">বিগত মাসের ঘাটতি</td>
                                                            <td style="width: 35%">
                                                                <b><?php echo e(banglaNumderFormat($PreviousMonthLoss)); ?>/-</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td>বিগত মাসের উদ্ধৃত</td>
                                                            <td><b><?php echo e(banglaNumderFormat($PreviousMonthProfight)); ?>/-</b>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="bg-success">বিগত মাস গুলো সহ সর্বমোট আয়</td>
                                                            <td class="bg-success">
                                                                <b><?php echo e(banglaNumderFormat($inTotalIncome)); ?>/-</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="bg-danger">বিগত মাস গুলো সহ সর্বমোট ব্যয়</td>
                                                            <td class="bg-danger">
                                                                <b><?php echo e(banglaNumderFormat($intotalExpance)); ?>/-</b></td>
                                                        </tr>

                                                        <tr class="text-danger">
                                                            <th>সর্বমোট ঘাটতি</th>
                                                            <th><b> <?php echo e(banglaNumderFormat($totalLosses)); ?>/-</b></th>
                                                        </tr>
                                                        <tr class="text-success">
                                                            <th>সর্বমোট উদ্ধৃত</th>
                                                            <th><b><?php echo e(banglaNumderFormat($totalprofhites)); ?>/-</b></th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                
                                            </td>
                                            <td colspan="3">
                                                
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 10%">ক্রমিক</th>
                                                            <th style="width: 20%"> খাতের নাম</th>
                                                            <th style="width: 20%">টাকার পরিমাণ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $__currentLoopData = $reportData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryId => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>

                                                                <td><?php echo e($numberToBangla->bnNum($loop->index + 1)); ?></td>
                                                               <td>
                                                                    <?php if(isset($category['category_name'])): ?>
    <a href="<?php echo e(route('expense.category-details.branch', ['categoryId' => $categoryId, 'branchId' => $branch->id, 'month' => request()->get('month', date('m')), 'year' => request()->get('year', date('Y')), 'serial' => ($loop->index + 1)])); ?>" style="color: #000; text-decoration: none; cursor: pointer;">
        <?php echo e($category['category_name']); ?>

    </a>
<?php else: ?>
    No Category Name <?php echo e($categoryId); ?>

<?php endif; ?>
                                                                </td>
                                                                <td><?php echo e(banglaNumderFormat($category['total_expense'])); ?>/-
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>

                                                    <tfoot>
                                                        <tr>
                                                            
                                                            <th colspan="2" class="text-right">সর্বমোট ব্যায়ঃ </th>
                                                            <th class="text-center">
                                                                <?php echo e(banglaNumderFormat($grandTotal)); ?> /-
                                                            </th>
                                                        </tr>
                                                        <tr>

                                                            
                                                            <th colspan="3" style="font-size: 18px">কথায়ঃ
                                                                <?php echo e($numberToBangla->bnMoney($grandTotal)); ?>

                                                                মাত্র
                                                                ।</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </td>
                                            
                                        </tr>


                                    </tbody>
                                    <tfoot>

                                    </tfoot>
                                </table>
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
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        // Optionally, add a print button click event listener
        document.getElementById("printButton").addEventListener("click", function() {
            window.print(); // Trigger print after hiding elements
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/report/monthlyExpance.blade.php ENDPATH**/ ?>