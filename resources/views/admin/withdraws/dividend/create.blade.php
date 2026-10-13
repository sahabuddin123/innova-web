@extends('admin.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-money-bill-alt"></i> {{ $pageTitle }} </h1>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <div class="tile-body">
                    @include('admin.withdraws.dividend._form')
                    <a href="{{ route('admin.dividend.withdraw.index') }}" class="btn btn-secondary mt-2">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection
