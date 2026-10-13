@extends('admin.app')

@section('title')
    {{ $pageTitle }}
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('backend/css/lightbox-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/mignify.css') }}">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="far fa-credit-card"></i> {{ $pageTitle }}</h1>
        </div>
        <div>
            <a href="{{ route('admin.income.create') }}" class="btn btn-primary pull-right">Add Income</a>
            <a href="{{ route('admin.income.index') }}" class="btn btn-danger pull-right">All Income</a>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-4">
            <div class="tile">
                <div class="tile-body">
                    @if (isset($targetData->image))
                        <a data-magnify="gallery" data-src="" data-caption="{{ $targetData->title }}" data-group="a"
                            href="{{ asset('public/storage/' . $targetData->image) }}">
                            <img src="{{ asset('public/storage/' . $targetData->image) }}" class="rounded  img-thumbnail"
                                alt="..." width="100%">
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-8">
            <div class="tile">
                <div class="tile-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Income Categoris : </p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $targetData->inCategoris->categoris }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Books No : </p>
                            </div>

                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $targetData->bookNO }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Invoice No : </p>
                            </div>
                            <div class="col-sm-3">
                                <p class="text-muted mb-0">{{ $targetData->invoiceID }}</p>
                            </div>
                            <div class="col-sm-3">
                                <p class="mb-0">Invoice Date : </p>
                            </div>
                            <div class="col-sm-3">
                                <p class="text-muted mb-0">
                                    @php
                                        $buyDate = strtotime($targetData->invoiceDate);
                                        $buyDate = date('d-M-y', $buyDate);
                                    @endphp
                                    {{ $buyDate }}
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3 col-md-3">
                                <p class="mb-0">Buyer / Recever Name : </p>
                            </div>
                            <div class="col-sm-9 col-md-9">
                                <p class="text-muted mb-0">
                                    {{ $targetData->recever }}
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3 col-md-3">
                                <p class="mb-0">Seller / Shop Name : </p>
                            </div>
                            <div class="col-sm-9 col-md-9">
                                <p class="text-muted mb-0">
                                    {{ $targetData->seller }}
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3 col-md-3">
                                <p class="mb-0">Invoice Title : </p>
                            </div>
                            <div class="col-sm-9 col-md-9">
                                <p class="text-muted mb-0">
                                    {{ $targetData->title }}
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <p class="mb-0">Description : </p>
                            </div>

                            <div class="col-sm-12 col-md-10 offset-md-2">
                                <p class="text-muted mb-0">
                                    {!! $targetData->description !!}
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Create Date: </p>
                            </div>
                            <div class="col-sm-3">
                                <p class="text-muted mb-0">
                                    @php
                                        $createDate = strtotime($targetData->createDate);
                                        $createDate = date('d-M-y', $createDate);
                                    @endphp
                                    {{ $createDate }}

                                </p>
                            </div>
                            <div class="col-sm-3">
                                <p class="mb-0">Status : </p>
                            </div>
                            <div class="col-sm-3">
                                <p class="text-muted mb-0">
                                    @php
                                        if ($targetData->IsActive == 1) {
                                            $status = "<span class='text-warning'>Pending</span>";
                                        } elseif ($targetData->IsActive == 2) {
                                            $status = "<span class='text-success'>Accept</span>";
                                        } elseif ($targetData->IsActive == 3) {
                                            $status = "<span class='text-danger'>Restricted</span>";
                                        }
                                    @endphp
                                    <b>{!! $status !!}
                                </p>

                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="visible-print text-center">
                {{-- {{QrCode::style('dot')}} --}}
                {{-- {!! QrCode::style('round')->size(300)->generate(Request::url()); !!} --}}
                {{-- <img src="{!! QrCode::format('png')->generate(Request::url())->size(100) !!}"> --}}

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript">
        $('#sampleTable').DataTable({
            order: [
                [1, 'desc']
            ],
        });
    </script>
    <script type="text/javascript" src="{{ asset('backend/js/lightbox-popup.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/mignify.js') }}"></script>
    <!-- jQuery JS CDN -->
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
