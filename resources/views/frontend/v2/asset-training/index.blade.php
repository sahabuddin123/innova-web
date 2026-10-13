@extends('frontend.v2.app')

@section('content')
<section class="section pt-6 pb-0">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-10">
                <span class="d-inline-block text-success text-uppercase letter-spacing-2">ASSET Training</span>
                <h1 class="mt-4">ফ্রি প্রশিক্ষণ!</h1>
                <p class="lead mt-3">গণপ্রজাতন্ত্রী বাংলাদেশের সরকার-নির্ধারিত ASSET প্রকল্পের আওতায় ডিজিটাল দক্ষতা উন্নয়নের জন্য দক্ষ প্রশিক্ষণ।</p>
                <a href="{{ route('asset-training.register') }}" class="btn btn-primary btn-lg mt-4">এখনই রেজিস্ট্রেশন করুন</a>
            </div>
        </div>

        <div class="row mt-5 justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0 p-4">
                    <div class="row align-items-center text-center">
                        <div class="col-12 mb-4">
                            <div class="d-flex justify-content-center align-items-center flex-wrap gap-4">
                                <img src="{{ asset('frontend/v2/assets/images/partners/gov.png') }}" alt="Gov" height="54">
                                <img src="{{ asset('frontend/v2/assets/images/partners/asset.png') }}" alt="ASSET" height="54">
                                <img src="{{ asset('frontend/v2/assets/images/partners/basis.png') }}" alt="BASIS" height="54">
                                <img src="{{ asset('frontend/v2/assets/images/partners/bitm.png') }}" alt="BITM" height="54">
                                <img src="{{ asset('frontend/v2/assets/images/partners/worldbank.png') }}" alt="World Bank" height="54">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-lg-10 mx-auto">
                <div class="row gy-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm p-4 h-100">
                            <h4 class="mb-3">ভর্তির যোগ্যতা</h4>
                            <ul class="ps-3 mb-0">
                                <li>শিক্ষাগত যোগ্যতার সনদপত্র (নূন্যতম HSC পাশ)</li>
                                <li>জাতীয় পরিচয়পত্র (NID) ফটোকপি</li>
                                <li>বয়স ১৮ থেকে ৪৫ বছরের মধ্যে</li>
                                <li>সদ্য তোলা পাসপোর্ট সাইজ রঙিন ছবি</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm p-4 h-100" style="background:#f3fff6;">
                            <h4 class="mb-3">সুযোগ-সুবিধা</h4>
                            <ul class="ps-3 mb-0">
                                <li>কোর্স শেষে প্রশিক্ষণ সনদ প্রদান</li>
                                <li>জাতীয় দক্ষতা উন্নয়ন কর্তৃপক্ষের সার্টিফিকেট</li>
                                <li>শিক্ষা ও কর্মসংস্থানের সহায়তা</li>
                                <li>মহিলা ও অনগ্রসর গোষ্ঠীর জন্য বিশেষ সুযোগ</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 text-center mb-4">
                <h2>কোর্সসমূহ</h2>
                <p class="text-muted">নিচের কোর্সগুলো ASSET ট্রেনিং পেজ থেকে ডাইনামিকভাবে প্রদর্শিত হবে।</p>
            </div>
            @foreach($courses as $course)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="badge bg-primary">{{ $course->level ?: 'LEVEL-4' }}</span>
                                @if($course->icon)
                                    <i class="{{ $course->icon }} fs-3 text-primary"></i>
                                @endif
                            </div>
                            <h5 class="card-title">{{ $course->name }}</h5>
                            <p class="text-muted mb-4">{{ $course->short_description }}</p>
                            <a href="{{ route('asset-training.register', ['course_id' => $course->id]) }}" class="btn btn-block text-white" style="background: {{ $course->button_color ?: '#4d50ff' }};">রেজিস্ট্রেশন করুন</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row mt-5 justify-content-center">
            <div class="col-lg-10">
                <div class="row gy-4 text-center">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-4 h-100">
                            <h5>সময়সূচি (SCHEDULE)</h5>
                            <p>সকাল ১০ টা থেকে দুপুর ১ টা পর্যন্ত / বিকাল ২ টা থেকে সন্ধ্যা ৬ টা পর্যন্ত</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-4 h-100">
                            <h5>ঠিকানা (VENUE)</h5>
                            <p>মহাখালী, ঢাকা, বাংলাদেশ</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-4 h-100">
                            <h5>যোগাযোগ (CONTACT)</h5>
                            <p class="mb-0">+8801844443954</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-lg-10 mx-auto text-center">
                <div class="card border-0 shadow-sm p-5">
                    <h3 class="mb-3">আসন সংখ্যা সীমিত — এখনই রেজিস্ট্রেশন করুন!</h3>
                    <a href="{{ route('asset-training.register') }}" class="btn btn-lg btn-success">রেজিস্ট্রেশন শুরু করুন</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
