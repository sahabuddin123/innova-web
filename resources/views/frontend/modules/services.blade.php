@extends('frontend.v2.app')
@section('title')
    আমাদের সেবা - {{ config('settings.site_name') }}
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
                    <h1 class="breadcrumb__title display-4 fw-semibold text-center">আমাদের সেবা</h1>
                    <ul class="breadcrumb__list d-flex align-items-center justify-content-center gap-4">
                        <li class="breadcrumb__item">
                            <a href="/" class="breadcrumb__link text-neutral-500 hover-text-main-600 fw-medium">
                                <i class="text-lg d-inline-flex ph-bold ph-house"></i> হোম</a>
                        </li>
                        <li class="breadcrumb__item">
                            <i class="text-neutral-500 d-flex ph-bold ph-caret-right"></i>
                        </li>
                        <li class="breadcrumb__item">
                            <span class="text-main-two-600"> আমাদের সেবা </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Services Section Start -->
<section class="section service py-5 bg-white">
    <div class="container">
        <div class="row justify-content-center pt-5" style="padding: 30px 0px !important">
            @if($services->count() > 0)
                @foreach($services as $service)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-aos="fade-up" data-aos-duration="200">
                    <div class="service-item bg-white rounded-16 p-32 h-100 box-shadow-md text-center">
                        <div class="service-icon mb-24">
                            <span class="w-80 h-80 flex-center d-inline-flex bg-main-25 text-main-600 text-40 rounded-circle">
                                <i class="{{ $service->icon ?? 'ph ph-gear-six' }}"></i>
                            </span>
                        </div>
                        <h3 class="mb-16">{{ $service->title }}</h3>
                        <p class="text-neutral-500">{{ $service->description }}</p>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12 text-center">
                    <p>কোনো সেবা পাওয়া যায়নি।</p>
                </div>
            @endif
        </div>
    </div>
</section>
<!-- Services Section End -->

@push('styles')
<style>
.service-card {
    transition: transform 0.3s cubic-bezier(.4,2,.6,1);
    border: none;
    border-radius: 1.5rem;
    background: #f8fafc;
    box-shadow: 0 4px 24px 0 rgba(33,150,243,0.08), 0 1.5px 4px 0 rgba(33,150,243,0.04);
    min-height: 260px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.service-card:hover {
    transform: translateY(-8px) scale(1.03);
    box-shadow: 0 8px 32px 0 rgba(33,150,243,0.18), 0 3px 8px 0 rgba(33,150,243,0.08);
}
.service-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 60px;
}
@media (max-width: 767px) {
    .service-card {
        min-height: 180px;
        padding: 1.2rem;
    }
    .service-icon {
        height: 40px;
    }
}
</style>
@endpush
@endsection