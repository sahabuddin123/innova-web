@extends('admin.app')

@section('title')
    আয়ের রিপোর্ট
@endsection

@section('content')
    <style>
        @import url('https://fonts.maateen.me/solaiman-lipi/font.css');
        label, select, input, button, option {
            font-family: 'SolaimanLipi', sans-serif !important;
            font-size: 18px;
        }
    </style>

    <div class="tile">
        <div class="tile-body">
            <h3 class="text-center mb-4">আয়ের রিপোর্ট ফিল্টার</h3>

            <form action="{{ route('admin.income.report.get') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="branch_id">শাখা নির্বাচন করুন <span class="text-danger">*</span></label>
                    <select name="branch_id" id="branch_id" class="form-control" required>
                        <option value="">শাখা নির্বাচন করুন</option>
                        @foreach ($branch as $item)
                            <option value="{{ $item->id }}">{{ $item->bname }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="date">রিপোর্টের তারিখ (শুরু - শেষ) <span class="text-danger">*</span></label>
                    <input type="text" name="date" id="date" class="form-control" placeholder="MM/DD/YYYY - MM/DD/YYYY" required>
                </div>

                <div class="tile-footer">
                    <button class="btn btn-primary" type="submit">
                        <i class="fa fa-fw fa-lg fa-check-circle"></i> রিপোর্ট দেখুন
                    </button>
                    &nbsp;&nbsp;&nbsp;
                    <a class="btn btn-secondary" href="#">
                        <i class="fa fa-fw fa-lg fa-times-circle"></i> বাতিল করুন
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <script>
        $(function() {
            $('input[name="date"]').daterangepicker();
            $('input[name="date"]').change(function() {
                $(this).val();
                console.log($(this).val());
            });
        });
    </script>
@endpush
