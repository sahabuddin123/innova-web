@extends('admin.app')

@section('title') Pay Slip @endsection

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
        body{ font-family: 'Poppins', sans-serif; background:#f6f8fb }
        .container-center { max-width:1100px; margin:18px auto }
        .card { background:#fff; padding:22px; border-radius:6px; box-shadow:0 6px 18px rgba(0,0,0,0.06); margin-bottom:18px }
        .copy-label { font-size:14px; color:#666; font-weight:700; margin-bottom:10px }

        .hdr { display:flex; justify-content:space-between; align-items:flex-start }
        .hdr .logo { width:140px }
        .hdr .contact { text-align:right; font-size:15px; color:#666 }

        .title { text-align:center; font-size:26px; color:#777; margin:14px 0; font-weight:700 }

        .meta { display:flex; justify-content:space-between; gap:12px; margin-bottom:14px }
        .meta .left, .meta .right { width:48%; font-size:15px; color:#444 }
        .meta label { display:inline-block; width:120px; color:#777; font-weight:600 }

        table.simple { width:100%; border-collapse:collapse; margin-top:8px }
        table.simple th, table.simple td { border:1px solid #eceef0; padding:12px; font-size:15px }
        table.simple thead th { background:#fafafa; color:#666; font-weight:600 }

        .totals { width:320px; margin-left:auto; margin-top:14px; font-size:15px }
        .totals .line { display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #f3f4f5 }

        /* Signature box styles */
        .signs { display:flex; gap:18px; align-items:flex-end; margin-top:20px; position: absolute; top: 500px; }
        .sign-box { width:260px; border:1px solid #f0f0f0; padding:16px; border-radius:6px; background:#fafafa }
        .sign-line { height:12px; border-bottom:2px solid #cfcfcf; margin:8px 24px 20px 24px }
        .sign-label { text-align:center; color:#b33; font-weight:600; font-size:15px; margin-top:4px }
        .totals .line:last-child { border-bottom:0 }

        .footer { text-align:center; color:#8a8a8a; margin-top:16px; font-size:15px }

        .no-print { margin-top:12px }
        @page { size: A4 portrait; margin:12mm }
        @media print {
            /* hide all non-payslip content */
            .copyright, .no-print, button, .btn, .btn-group { display:none !important }
            
            /* hide admin chrome/sidebar elements */
            .main-sidebar, .sidebar, .left-side, .navbar, .main-header, .control-sidebar, .app-sidebar, 
            .topbar, .sidebar-toggle, #sidebar, .nav, .navbar-nav, header, footer, nav, 
            .navbar-expand, .navbar-light, .app-header, .app-sidebar, .pcoded, .sidebar-wrapper,
            .navbar-brand, .navbar-toggler, .breadcrumb, .page-breadcrumb, .menu-wrapper,
            .sidebar-nav, .main-content, .content, .col-sidebar { display:none !important }
            
            /* hide scrollbars and decorative elements */
            ::-webkit-scrollbar { display:none !important }
            html, body { overflow:hidden !important }
            
            /* expand content area to full width for print */
            #wrapper, .content-wrapper, .container, .container-center, main, .main, 
            .page-content, .content-body { 
                width:100% !important; 
                margin:0 !important; 
                padding:0 !important;
                max-width:100% !important;
            }
            
            /* clean body styles */
            body { 
                margin:0 !important; 
                padding:0 !important; 
                background:#fff !important;
                overflow:visible !important;
            }
            
            /* ensure payslip card is full width and clean */
            .card { 
                page-break-inside:avoid; 
                break-inside:avoid;
                border:none;
                box-shadow:none;
                margin:0 !important;
                padding:18px !important;
            }
        }
    </style>

    @php
        // safe defaults for variables passed from controller
        // Use the Payments Details logic as authoritative:
        //   totalCourseFee = students->course_fee
        //   totalDiscount = course_fee - balance
        //   totalPaid = sum paidamount where paymentType == 1
        //   netDue = balance - totalPaid
        $totalCourseFee = isset($totalCourseFee) ? floatval($totalCourseFee) : floatval($student->course_fee ?? 0);
        $totalDiscount = isset($totalDiscount) ? floatval($totalDiscount) : floatval((($student->course_fee ?? 0) - ($student->balance ?? 0)));
        $totalPaid = isset($totalPaid) ? floatval($totalPaid) : floatval(\App\Models\FeesTransections::where('student_id', $student->id ?? 0)->where('paymentType',1)->sum('paidamount'));
        $netDue = isset($netDue) ? floatval($netDue) : floatval(($student->balance ?? 0) - $totalPaid);

        $amountNumeric = floatval($transaction->paidamount ?? 0);
        $amount = number_format($amountNumeric,2);
        $amountInWords = $amountInWords ?? (number_format($amountNumeric,2) . ' Taka only');

        // QR fallback
        $qrText = 'Txn:'.$transaction->id.' | Student:'.($student->sname ?? '').' | Amt:'.$amount;
        $qrUrl = $qrDataUri ?? ('https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl='.urlencode($qrText).'&choe=UTF-8');
    @endphp

    <div class="container-center">
        <div style="text-align:center; margin-top:12px" class="no-print">
            <a href="{{ route('admin.fees.payslip.download', $transaction->id) }}" class="btn btn-primary">Download PDF</a>
            <button onclick="window.print();" class="btn btn-secondary">Print</button>
        </div>
        {{-- Office Copy --}}
        <div class="card mb-5">
            <div class="copy-label">Office Copy</div>
            <div class="hdr">
                <div class="logo"><img src="{{ asset('public/storage/'.config('settings.site_logo')) }}" alt="Invoice logo" style="max-width:100%"></div>
                <div class="contact">
                    <div style="font-weight:700">INNOVA Computers BD</div>
                    <div style="margin-top:6px">Masterpara, Charbata, Subarnachar, Noakhali</div>
                    <div style="margin-top:6px">+880 1844 463 963, +880 1817 682 323</div>
                    <div style="margin-top:6px">innovacomputersbd@gmail.com</div>
                </div>
            </div>

            <div class="title">Pay Slip</div>

            <div class="meta">
                <div class="left">
                    <div><label>Student ID:</label> {{ $student->id ?? '-' }}</div>
                    <div style="margin-top:6px"><label>Student Name:</label> {{ $student->sname ?? '-' }}</div>
                    <div style="margin-top:6px"><label>Status:</label> {{ (isset($netDue) && floatval($netDue) <= 0) ? 'PAID' : 'UNPAID' }}</div>
                </div>
                <div class="right">
                    <div><label>Invoice #</label> icbd{{ $transaction->id }}</div>
                    <div style="margin-top:6px"><label>Invoice Date</label> {{ date('l, jS M Y', strtotime($transaction->paiddate ?? $transaction->created_at)) }}</div>
                    <div style="margin-top:6px"><label>Batch Name</label> {{ $transaction->batch_name ?? ($student->batch_name ?? '-') }}</div>
                </div>
            </div>

            <table class="simple">
                <thead>
                    <tr>
                        <th style="width:6%">SL</th>
                        <th style="width:62%">Description</th>
                        <th style="width:16%">Pay Date</th>
                        <th style="width:16%; text-align:right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>{{ $transaction->paidremark ? $transaction->paidremark : ($transaction->trxID ?? 'Payment') }}</td>
                        <td>{{ date('d-M-Y', strtotime($transaction->paiddate ?? $transaction->created_at)) }}</td>
                        <td style="text-align:right">{{ number_format($transaction->paidamount ?? 0,2) }} BDT</td>
                    </tr>
                </tbody>
            </table>

            <div class="totals">
                <div class="line"><div>Total Course Fee:</div><div><strong>{{ number_format($totalCourseFee,2) }}</strong> BDT</div></div>
                <div class="line"><div>Discount (-):</div><div><strong>{{ number_format($totalDiscount,2) }}</strong> BDT</div></div>
                <div class="line"><div>Total Pay (-):</div><div><strong>{{ number_format($totalPaid,2) }}</strong> BDT</div></div>
                <div class="line"><div>Net Due:</div><div><strong>{{ number_format($netDue,2) }}</strong> BDT</div></div>
            </div>

            <div class="signs">
                <div class="sign-box">
                    {{-- <div class="sign-line"></div>
                    <div class="sign-label">payer signature</div> --}}

                    <div style="height:18px"></div>

                    <div class="sign-line"></div>
                    <div class="sign-label">Authority Signature</div>
                </div>
                <div style="flex:1"></div>
            </div>

            <div class="footer">
                <div>{{ $amountInWords }}</div>
                <div style="margin-top:8px">Generated on {{ date('l, jS M Y') }} &nbsp; </div>
            </div>
        </div>

        {{-- Student Copy --}}
        <div class="card mt-5">
            <div class="copy-label">Student Copy</div>
            <div class="hdr">
                <div class="logo"><img src="{{ asset('public/storage/'.config('settings.site_logo')) }}" alt="Invoice logo" style="max-width:100%"></div>
                <div class="contact">
                    <div style="font-weight:700">INNOVA Computers BD</div>
                    <div style="margin-top:6px">Masterpara, Charbata, Subarnachar, Noakhali</div>
                    <div style="margin-top:6px">+880 1844 463 963, +880 1817 682 323</div>
                    <div style="margin-top:6px">innovacomputersbd@gmail.com</div>
                </div>
            </div>

            <div class="title">Pay Slip</div>

            <div class="meta">
                <div class="left">
                    <div><label>Student ID:</label> {{ $student->id ?? '-' }}</div>
                    <div style="margin-top:6px"><label>Student Name:</label> {{ $student->sname ?? '-' }}</div>
                    <div style="margin-top:6px"><label>Status:</label> {{ (isset($netDue) && floatval($netDue) <= 0) ? 'PAID' : 'UNPAID' }}</div>
                </div>
                <div class="right">
                    <div><label>Invoice #</label> icbd{{ $transaction->id }}</div>
                    <div style="margin-top:6px"><label>Invoice Date</label> {{ date('l, jS M Y', strtotime($transaction->paiddate ?? $transaction->created_at)) }}</div>
                    <div style="margin-top:6px"><label>Batch Name</label> {{ $transaction->batch_name ?? ($student->batch_name ?? '-') }}</div>
                </div>
            </div>

            <table class="simple">
                <thead>
                    <tr>
                        <th style="width:6%">SL</th>
                        <th style="width:62%">Description</th>
                        <th style="width:16%">Pay Date</th>
                        <th style="width:16%; text-align:right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>{{ $transaction->paidremark ? $transaction->paidremark : ($transaction->trxID ?? 'Payment') }}</td>
                        <td>{{ date('d-M-Y', strtotime($transaction->paiddate ?? $transaction->created_at)) }}</td>
                        <td style="text-align:right">{{ number_format($transaction->paidamount ?? 0,2) }} BDT</td>
                    </tr>
                </tbody>
            </table>

            <div class="totals">
                <div class="line"><div>Total Course Fee:</div><div><strong>{{ number_format($totalCourseFee,2) }}</strong> BDT</div></div>
                <div class="line"><div>Discount (-):</div><div><strong>{{ number_format($totalDiscount,2) }}</strong> BDT</div></div>
                <div class="line"><div>Total Pay (-):</div><div><strong>{{ number_format($totalPaid,2) }}</strong> BDT</div></div>
                <div class="line"><div>Net Due:</div><div><strong>{{ number_format($netDue,2) }}</strong> BDT</div></div>
            </div>

            <div class="signs">
                <div class="sign-box">
                    {{-- <div class="sign-line"></div>
                    <div class="sign-label">payer signature</div> --}}

                    <div style="height:18px"></div>

                    <div class="sign-line"></div>
                    <div class="sign-label">Authority Signature</div>
                </div>
                <div style="flex:1"></div>
            </div>

            <div class="footer">
                <div>{{ $amountInWords }}</div>
                <div style="margin-top:8px">Generated on {{ date('l, jS M Y') }} &nbsp; </div>
            </div>
        </div>

        
    </div>

@endsection
