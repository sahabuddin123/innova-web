@extends('frontend.v2.app')
@section('title')
    ওয়ার্কফ্লো - {{ config('settings.site_name') }}
@endsection
@section('content')
<!-- page title -->
<section class="page-title bg-primary">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white text-uppercase text-sm">আমাদের কাজের প্রক্রিয়া</span>
                    <h1 class="text-capitalize text-lg text-white mt-2">ওয়ার্কফ্লো</h1>
                    <a href="{{ route('frontend.home') }}" class="btn btn-main btn-white-btn">হোমে ফিরুন</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- section -->
<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            @if($workflows->count() > 0)
                @foreach($workflows as $workflow)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="workflow-item text-center p-4">
                        <div class="step-number mb-3">{{ $workflow->step }}</div>
                        <i class="{{ $workflow->icon ?? 'fa fa-tasks' }} fa-3x mb-3"></i>
                        <h3>{{ $workflow->title }}</h3>
                        <p>{{ $workflow->description }}</p>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12 text-center">
                    <p>কোনো ওয়ার্কফ্লো পাওয়া যায়নি।</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection