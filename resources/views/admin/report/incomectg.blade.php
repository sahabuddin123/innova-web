@extends('admin.app')

@section('title')
    আয়ের রিপোর্ট
@endsection

@section('content')
    <style>
        @import url('https://fonts.maateen.me/solaiman-lipi/font.css');
        body, table, td, th {
            font-family: 'SolaimanLipi', sans-serif;
            color: #000;
        }
        .table th, .table td {
            font-size: 18px;
            text-align: center;
        }
        .print-button {
            margin-bottom: 15px;
        }
        @media print {
            body * {
                visibility: hidden;
            }
            #printable, #printable * {
                visibility: visible;
            }
           
          
        }
      @media print {
        .sticky-footer, .print_none, .navbar, .sidebar, #printButton {
            display: none !important;
        }
    </style>

    @php
    function fullBanglaMoneyWithPoisha($amount)
    {
        $numberToBangla = new \lemonpatwari\BanglaNumber\NumberToBangla();

        $taka = floor($amount);
        $poisha = round(($amount - $taka) * 100);

        $takaText = $numberToBangla->bnWord($taka);
        $poishaText = $poisha > 0 ? $numberToBangla->bnNum($poisha) . ' পয়সা' : 'শূন্য পয়সা';

        return $takaText . ' টাকা ' . $poishaText . ' মাত্র';
    }

    function bnNumWithEngComma($number) {
        $formatted = number_format($number, 2, '.', ',');
        $bn_digits = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
        $result = '';
        for ($i = 0; $i < strlen($formatted); $i++) {
            $ch = $formatted[$i];
            if (is_numeric($ch)) {
                $result .= $bn_digits[(int)$ch];
            } else {
                $result .= $ch;
            }
        }
        return $result;
    }
    @endphp

    <div class="tile">
        <div class="tile-body">
            <h3 class="text-center">আয়ের রিপোর্ট</h3>

            {{-- রিপোর্ট জেনারেট সময় --}}
            <p class="text-center" style="font-weight: bold;">
                রিপোর্ট জেনারেটেড: {{ date('d-m-Y H:i:s') }}
            </p>

           

            {{-- রিপোর্ট টেবিল --}}
            <div id="printable">
                <p class="text-center">
                    শাখা: <strong>{{ $branch_name ?? 'সকল শাখা' }}</strong><br>
                    রিপোর্ট সময়কাল: {{ $start_date ?? 'সর্বসময়' }} থেকে {{ $end_date ?? 'বর্তমান' }}
                </p>

                <table class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th>ক্রমিক</th>
                            <th>খাতের নাম</th>
                            <th>মোট আয় (৳)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp
                        @foreach($result as $index => $row)
                            @php
                                $amount = is_numeric($row->total_amount) ? floatval($row->total_amount) : 0;
                                $total += $amount;
                            @endphp
                            <tr>
                                <td>{{ bnNumWithEngComma($index + 1) }}</td>
                                <td>{{ $row->category_name }}</td>
                                <td>{{ bnNumWithEngComma($amount) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="font-weight: bold;">
                            <td colspan="2" class="text-right">সর্বমোট</td>
                            <td>{{ bnNumWithEngComma($total) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">কথায়: {{ fullBanglaMoneyWithPoisha($total) }}</td>
                        </tr>
                    </tfoot>
                </table>
               {{-- প্রিন্ট বাটন --}}
            <div class="text-right mb-3">
                <button onclick="printReport()" class="btn btn-success print-button">প্রিন্ট করুন</button>
            </div>
            </div>
        </div>
    </div>

    <script>
        function printReport() {
            window.print();
        }
    </script>
@endsection
