@extends('frontend.v2.app')

@section('title', 'আমাদের টিম - INNOVA Computers BD')

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
                    <h1 class="breadcrumb__title display-4 fw-semibold text-center">আমাদের টিম</h1>
                    <ul class="breadcrumb__list d-flex align-items-center justify-content-center gap-4">
                        <li class="breadcrumb__item">
                            <a href="/" class="breadcrumb__link text-neutral-500 hover-text-main-600 fw-medium">
                                <i class="text-lg d-inline-flex ph-bold ph-house"></i> হোম</a>
                        </li>
                        <li class="breadcrumb__item">
                            <i class="text-neutral-500 d-flex ph-bold ph-caret-right"></i>
                        </li>
                        <li class="breadcrumb__item">
                            <span class="text-main-two-600"> আমাদের টিম </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Team Section Start -->
<section class="team-section py-5" style="background: linear-gradient(135deg, #f8fafc 0%, #e3eefe 100%); min-height: 100vh;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                {{-- <h2 class="font-weight-bold display-4 mb-3" style="color:#1a237e; letter-spacing:1px;">আমাদের টিম</h2> --}}
                <p class="lead text-secondary">পেশাদার ও দক্ষ টিমের সাথে পরিচিত হন</p>
            </div>
        </div>
        <div class="row justify-content-center">
            @foreach($teams as $team)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8 mb-4 d-flex align-items-stretch">
                <div class="card team-card shadow-lg border-0 w-100">
                    <div class="card-body text-center p-4">
                        @if($team->photo)
                            <img src="{{ asset('storage/'.$team->photo) }}" alt="{{ $team->name }}" class="rounded-circle mb-3 team-img" width="130" height="130">
                        @else
                            <img src="{{ asset('frontend/img/team-placeholder.jpg') }}" alt="No Image" class="rounded-circle mb-3 team-img" width="130" height="130">
                        @endif
                        <h5 class="card-title font-weight-bold mt-3 mb-1" style="color:#0d47a1;">{{ $team->name }}</h5>
                        <p class="text-primary mb-2" style="font-size:1.1rem; font-weight:500;">{{ $team->designation }}</p>
                        @if($team->bio_bn)
                            <p class="card-text text-muted small mb-0">{{ $team->bio_bn }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @if($teams->isEmpty())
        <div class="row">
            <div class="col-12 text-center">
                <p class="text-muted">কোনো টিম সদস্য পাওয়া যায়নি।</p>
            </div>
        </div>
        @endif
    </div>
</section>
<!-- Team Section End -->
@endsection

<style>
.team-card {
    transition: transform 0.3s cubic-bezier(.4,2,.6,1);
    border-radius: 18px;
    background: #fff;
    box-shadow: 0 4px 24px 0 rgba(33,150,243,0.08), 0 1.5px 4px 0 rgba(33,150,243,0.04);
    border: none;
    min-height: 340px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.team-card:hover {
    transform: translateY(-10px) scale(1.03);
    box-shadow: 0 8px 32px 0 rgba(33,150,243,0.18), 0 3px 8px 0 rgba(33,150,243,0.08);
}
.team-img {
    border: 4px solid #1976d2;
    box-shadow: 0 2px 8px rgba(33,150,243,0.10);
    object-fit: cover;
    width: 130px;
    height: 130px;
}
.card-title {
    font-size: 1.25rem;
    font-weight: 700;
    letter-spacing: 0.5px;
}
.text-primary {
    color: #1976d2 !important;
}
.team-section {
    padding-bottom: 60px;
}
@media (max-width: 767px) {
    .team-card {
        min-height: 280px;
    }
    .team-img {
        width: 100px;
        height: 100px;
    }
}
</style>