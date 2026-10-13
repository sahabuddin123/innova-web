@extends('frontend.v2.app')
@section('title')
    আমাদের পণ্য - {{ config('settings.site_name') }}
@endsection
@section('content')

<!-- Breadcrumb Section Start -->
<section class="breadcrumb py-120 bg-main-25 position-relative z-1 overflow-hidden mb-0">
    <img src="/frontend/v2/assets/images/shapes/shape1.png" alt="" class="shape one animation-rotation d-md-block d-none">
    <img src="/frontend/v2/assets/images/shapes/shape2.png" alt="" class="shape two animation-scalation d-md-block d-none">
    <img src="/frontend/v2/assets/images/shapes/shape3.png" alt="" class="shape eight animation-walking d-md-block d-none">
    <img src="/frontend/v2/assets/images/shapes/shape5.png" alt="" class="shape six animation-walking d-md-block d-none">
    <img src="/frontend/v2/assets/images/shapes/shape4.png" alt="" class="shape four animation-scalation">
    <img src="/frontend/v2/assets/images/shapes/shape4.png" alt="" class="shape nine animation-scalation">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="breadcrumb__wrapper">
                    <h1 class="breadcrumb__title display-4 fw-semibold text-center">আমাদের পণ্য</h1>
                    <ul class="breadcrumb__list d-flex align-items-center justify-content-center gap-4">
                        <li class="breadcrumb__item">
                            <a href="/" class="breadcrumb__link text-neutral-500 hover-text-main-600 fw-medium">
                                <i class="text-lg d-inline-flex ph-bold ph-house"></i> হোম</a>
                        </li>
                        <li class="breadcrumb__item">
                            <i class="text-neutral-500 d-flex ph-bold ph-caret-right"></i>
                        </li>
                        <li class="breadcrumb__item">
                            <span class="text-main-two-600"> আমাদের পণ্য </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Products Section Start -->
<section class="section product py-5 bg-white " style="padding-top: 40px">
    <div class="container">
        <div class="row justify-content-center g-4 product-grid" style="padding-top: 40px; padding-bottom: 40px;">
            @if($products->count() > 0)
                {{-- @foreach($products as $product)
                <div class="col-xl-4 col-md-6 col-sm-10 d-flex align-items-stretch"">
                    <div class="product-card w-100 text-center p-4 shadow-lg rounded-4 h-100 bg-white position-relative overflow-hidden animate__animated animate__fadeInUp" style="padding: 30px!important;">
                        <div class="product-card-accent"></div>
                        <div class="product-icon mb-3">
                            <i class="{{ $product->icon ?? 'fa fa-box' }}" style="font-size:2.7rem;color:#1976d2;"></i>
                        </div>
                        <h3 class="fw-bold mb-2 product-title">{{ $product->title }}</h3>
                        <p class="text-secondary mb-3 product-desc">{{ $product->description }}</p>
                        <a href="#" class="btn btn-sm btn-main-600 px-4 py-2 rounded-pill mt-auto product-btn">বিস্তারিত</a>
                    </div>
                </div>
                @endforeach --}}
                <div class="row gy-4">
                @foreach($products as $product)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-aos="fade-up" data-aos-duration="200">
                    <div class="product-item bg-white rounded-16 p-32 h-100 box-shadow-md text-center border border-neutral-30 product-card-hover">
                        <div class="product-icon mb-24">
                            <span class="w-80 h-80 flex-center d-inline-flex bg-main-two-25 text-main-two-600 text-40 rounded-circle">
                                <i class="{{ $product->icon ?? 'ph ph-package' }}"></i>
                            </span>
                        </div>
                        <h3 class="mb-16">{{ $product->title }}</h3>
                        <p class="text-neutral-500">{{ $product->description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
                <div class="col-12 text-center">
                    <p>কোনো পণ্য পাওয়া যায়নি।</p>
                </div>
            @endif
        </div>
    </div>
</section>
<!-- Products Section End -->

@push('styles')
<style>
.product-card-hover {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.product-card-hover:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15) !important;
    border-color: #1976d2 !important;
}
.product-card-hover:hover .product-icon span {
    background: linear-gradient(90deg, #1976d2 0%, #42a5f5 100%) !important;
    color: #fff !important;
    transition: background 0.3s ease, color 0.3s ease;
}
</style>
@endpush
@endsection