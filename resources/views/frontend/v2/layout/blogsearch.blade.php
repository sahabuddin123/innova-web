@extends('frontend.v2.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <!-- ==================== Breadcrumb Start Here ==================== -->
    <section class="breadcrumb py-120 bg-main-25 position-relative z-1 overflow-hidden mb-0">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape1.png') }}" alt="" class="shape one animation-rotation d-md-block d-none">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape2.png') }}" alt="" class="shape two animation-scalation d-md-block d-none">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape3.png') }}" alt="" class="shape eight animation-walking d-md-block d-none">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape5.png') }}" alt="" class="shape six animation-walking d-md-block d-none">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape4.png') }}" alt="" class="shape four animation-scalation">
        <img src="{{ asset('frontend/v2/assets/images/shapes/shape4.png') }}" alt="" class="shape nine animation-scalation">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb__wrapper">
                        <h1 class="breadcrumb__title display-4 fw-semibold text-center"> প্রবন্ধ</h1>
                        <ul class="breadcrumb__list d-flex align-items-center justify-content-center gap-4">
                            <li class="breadcrumb__item">
                                <a href="{{ route('frontend.home') }}"
                                    class="breadcrumb__link text-neutral-500 hover-text-main-600 fw-medium">
                                    <i class="text-lg d-inline-flex ph-bold ph-house"></i> হোম</a>
                            </li>
                            <li class="breadcrumb__item">
                                <i class="text-neutral-500 d-flex ph-bold ph-caret-right"></i>
                            </li>
                            <li class="breadcrumb__item d-none">
                                <i class="text-neutral-500 d-flex ph-bold ph-caret-right"></i>
                            </li>
                            <li class="breadcrumb__item">
                                <span class="text-main-two-600"> ব্লগ </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==================== Breadcrumb End Here ==================== -->
    <!-- ================================ Blog Page Section Start =================================== -->
    <div class="blog-page-section py-120">
        <div class="container">
            @php
                use Carbon\Carbon;
            @endphp
            <div class="row gy-4">
                @foreach($blogs as $blog)
                    <div class="col-lg-4 col-sm-6">
                        <div class="scale-hover-item bg-main-25 rounded-16 p-12 h-100 border border-neutral-30">
                            <div class="course-item__thumb rounded-12 overflow-hidden position-relative">
                                <a href="{{ route('frontend.blogs.read', ['id' => $blog->id]) }}" class="w-100 h-100">
                                    <img src="{{ asset('public/storage/' .$blog->image) }}" alt="{{ $blog->heading }}" class="scale-hover-item__img rounded-12 cover-img transition-2">
                                </a>
                                <div class="position-absolute inset-inline-end-0 inset-block-end-0 me-16 mb-16 py-12 px-24 rounded-8 bg-main-three-600 text-white fw-medium">
                                    <h3 class="mb-0 text-white fw-medium">{{ Carbon::parse($blog->postDate)->format('d') }}</h3>
                                    {{ Carbon::parse($blog->postDate)->format('M') }}
                                </div>
                            </div>
                            <div class="pt-32 pb-24 px-16 position-relative">
                                <h4 class="mb-28">
                                    <a href="{{ route('frontend.blogs.read', ['id' => $blog->id]) }}" class="link text-line-2">{{ $blog->heading }}</a>
                                </h4>
                                <div class="flex-align gap-14 flex-wrap justify-content-between my-20">
                                    <div class="flex-align gap-8">
                                        <span class="text-neutral-500 text-2xl d-flex"><i class="ph ph-user-circle"></i></span>
                                        <span class="text-neutral-500 text-lg">{{ $blog->writerName }}</span>
                                    </div>
                                    {{-- <span class="w-8 h-8 bg-neutral-100 rounded-circle"></span> --}}
                                    <div class="flex-align gap-8">
                                        <span class="text-neutral-500 text-2xl d-flex"><i class="ph-bold ph-eye"></i></span>
                                        <span class="text-neutral-500 text-lg">{{ $blog->views }}</span>
                                    </div>
                                    {{-- <span class="w-8 h-8 bg-neutral-100 rounded-circle"></span>
                                    <div class="flex-align gap-8">
                                        <span class="text-neutral-500 text-2xl d-flex"><i class="ph ph-chat-dots"></i></span>
                                        <span class="text-neutral-500 text-lg">{{ $blog->comments_count }}</span>
                                    </div> --}}
                                </div>
                                <div class="flex-between gap-8 pt-24 border-top border-neutral-50 mt-28 border-dashed border-0">
                                    <a href="{{ route('frontend.blogs.read', ['id' => $blog->id]) }}" class="flex-align gap-8 text-main-600 hover-text-decoration-underline transition-1 fw-semibold" tabindex="0">
                                        বিস্তারিত পড়ুন
                                        <i class="ph ph-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>                            
                    </div>
                @endforeach
            </div>
            
            <ul class="pagination mt-40 flex-align gap-12 flex-wrap justify-content-center">
                {{ $blogs->appends(request()->input())->links() }}
            </ul>
        </div>
     </div>
    <!-- ================================ Blog Page Section End =================================== -->

@endsection
@push('scripts')
{!! htmlScriptTagJsApi() !!}
@endpush