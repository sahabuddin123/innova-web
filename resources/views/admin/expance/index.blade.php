@extends('admin.app')

@section('title')
    {{ $pageTitle }}
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('backend/css/lightbox-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/mignify.css') }}">
    <style>
        @import url('https://fonts.maateen.me/solaiman-lipi/font.css');

        table {
            font-family: 'SolaimanLipi', Arial, sans-serif !important;
        }

        th,
        td {
            white-space: nowrap;
        }

        div.dataTables_wrapper {
            /* width: 800px; */
            /* margin: 0 auto; */
        }

        th input {
            width: 90%;
        }
    </style>
    <?php
    use App\Models\BanglaDateNumber;
    use lemonpatwari\BanglaNumber\NumberToBangla;
    use Carbon\Carbon;
    $numberToBangla = new NumberToBangla();
    ?>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="far fa-credit-card"></i> {{ $pageTitle }}</h1>
        </div>
        <div>
            <a href="{{ route('admin.expance.create') }}" class="btn btn-primary pull-right">Add Expanse</a>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body overflow-auto">
                    <table class="table table-bordered" id="sampleTable">
                        <thead align="center">
                            <tr>
                                <th> # </th>
                                <th> মেমো তারিখ</th>
                                <th> শিরোনাম </th>
                                <th> খাতের নাম </th>
                                <th> শাখার নাম </th>
                                {{-- <th> ক্রেতা</th>   --}}
                                <th> টাকার পরিমাণ</th>
                                <th> স্ট্যটাস</th>
                                {{-- <th> সর্বশেষ আপডেট </th> --}}
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i
                                        class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody align="center">
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>

                                    <td>
                                        @php
                                            $buyDate = strtotime($item->invoiceDate);
                                            $buyDate = date('d-M-y', $buyDate);
                                        @endphp
                                        {{ $buyDate }}
                                    </td>
                                    <td>
                                        {{ $item->title }}
                                    </td>
                                    <td>
                                        <span class="badge badge-danger">
                                            {{-- {{ $item->exCategoris->categoris }} --}}
                                            @if (isset($item->exCategoris))
                                                {{ $item->exCategoris->categoris }}
                                            @else
                                                N/A (or any default value)
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">
                                            @if (isset($item->branches))
                                                {{ $item->branches->bname }}
                                            @else
                                                Branch Not Defined
                                            @endif
                                        </span>
                                    </td>

                                    {{-- <td>
                                        {{ $item->recever }}
                                    </td> --}}
                                    <td>
                                       <b>{{ BanglaDateNumber::bn_number(number_format($item->amount, 2, '.', ',')) }}{{ '/-' }}</b> 
                                    </td>
                                    <td>
                                        @php
                                            if ($item->IsActive == 1) {
                                                $status = "<span class='text-warning'>Pending</span>";
                                            } elseif ($item->IsActive == 2) {
                                                $status = "<span class='text-success'>Accept</span>";
                                            } elseif ($item->IsActive == 3) {
                                                $status = "<span class='text-danger'>Restricted</span>";
                                            }
                                        @endphp
                                        <b>{!! $status !!}</b>
                                    </td>
                                    {{-- <td>
                                        @php
                                            $date = strtotime($item->updated_at);
                                            $updateDate = date('d-M-y', $date);
                                        @endphp
                                        {{ $updateDate }}
                                    </td> --}}

                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Second group">
                                            <button type="button" class="btn btn-success btn-sm view_data"
                                                id="{{ $item->id }}" title="Short View Expanse"><i
                                                    class="fas fa-desktop"></i></button>
                                            <a href="{{ route('admin.expance.view', $item->id) }}"
                                                class="btn btn-sm btn-info" title="View Expanse"><i
                                                    class="fa fa-eye"></i></a>
                                            <a href="{{ route('admin.expance.edit', $item->id) }}"
                                                class="btn btn-sm btn-primary" title="Edit Expanse"><i
                                                    class="fa fa-edit"></i></a>
                                            <a href="{{ route('admin.expance.delete', $item->id) }}"
                                                class="btn btn-sm btn-danger" title="Delete Expanse"><i
                                                    class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th> # </th>
                                <th> মেমো তারিখ</th>
                                <th> শিরোনাম </th>
                                <th> খাতের নাম </th>
                                <th> শাখার নাম </th>
                                {{-- <th> ক্রেতা</th> --}}
                                <th> টাকার পরিমাণ</th>
                                <th> স্ট্যটাস</th>
                                {{-- <th> সর্বশেষ আপডেট </th> --}}
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i
                                        class="fa fa-bolt"> </i></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- view Modal -->
    <div class="modal fade" id="phoneModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"
        style="margin-top: 100px;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <!-- Place to print the fetched phone -->
                    <div id="phone_result"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript">
        // $(document).ready(function() {
        //     // Setup - add a text input to each footer cell
        //     $('#sampleTable tfoot th').each(function(i) {
        //         var title = $('#sampleTable thead th')
        //             .eq($(this).index())
        //             .text();
        //         $(this).html(
        //             '<input type="text" placeholder="' + title + '" data-index="' + i + '" />'
        //         );
        //     });

        //     // DataTable
        //     var table = $('#sampleTable').DataTable({
        //         pageLength: 100,
        //         scrollY: '550px',
        //         scrollCollapse: true,
        //         paging: false,
        //         fixedColumns: true,
        //         order: [
        //             [1, 'desc']
        //         ],

        //     });

        //     // Filter event handler
        //     $(table.table().container()).on('keyup', 'tfoot input', function() {
        //         table
        //             .column($(this).data('index'))
        //             .search(this.value)
        //             .draw();
        //     });
        // });
        $('#sampleTable').DataTable({order: [[1, 'desc']],});
    </script>
    <script type="text/javascript" src="{{ asset('backend/js/lightbox-popup.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/mignify.js') }}"></script>
    <!-- jQuery JS CDN -->
    <script type="text/javascript">
        // Start jQuery function after page is loaded
        $(document).ready(function() {
            // Start jQuery click function to view Bootstrap modal when view info button is clicked
            $('.view_data').click(function() {
                // Get the id of selected phone and assign it in a variable called phoneData
                var phoneData = $(this).attr('id');
                // Start AJAX function
                $.ajax({
                    // Path for controller function which fetches selected phone data
                    url: "{{ route('short.expanse.show') }}",
                    // Method of getting data
                    method: "GET",
                    // Data is sent to the server
                    data: {
                        phoneData: phoneData
                    },
                    // Callback function that is executed after data is successfully sent and recieved
                    success: function(data) {
                        // Print the fetched data of the selected phone in the section called #phone_result 
                        // within the Bootstrap modal
                        //console.log(data);
                        $('#phone_result').html(data);
                        // Display the Bootstrap modal
                        $('#phoneModal').modal('show');
                    }
                });
                // End AJAX function
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.popup-gallery').magnificPopup({
                delegate: 'a',
                type: 'image',
                tLoading: 'Loading image #%curr%...',
                mainClass: 'mfp-img-mobile',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
                },
                image: {
                    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                    titleSrc: function(item) {
                        return item.el.attr('title');
                    }
                }
            });
        });
    </script>
@endpush
