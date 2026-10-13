@extends('admin.app')
@section('content')
    <h1 class="h3">Create Investment Withdraw</h1>
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="tile">
                <div class="tile-body">
                    @include('admin.withdraws.investment._form')
                    <a href="{{ route('admin.investment.withdraw.index') }}" class="btn btn-secondary mt-2">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection
