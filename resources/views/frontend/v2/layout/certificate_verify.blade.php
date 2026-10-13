@extends('frontend.v2.app')

@section('title', 'সার্টিফিকেট ভেরিফিকেশন')

@section('content')
    <div class="container py-4">
        <div class="row mb-3">
            <div class="col-12">
                <h2 class="h4">সার্টিফিকেট ভেরিফিকেশন</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">হোম</a></li>
                        <li class="breadcrumb-item active" aria-current="page">সার্টিফিকেট ভেরিফিকেশন</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if (!empty($message))
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-warning">
                        {{ $message }}
                    </div>
                    <a href="{{ url()->current() }}" class="btn btn-secondary">আবার চেষ্টা করুন</a>
                    <a href="{{ url('/') }}" class="btn btn-link">হোমে ফিরে যান</a>
                </div>
            </div>
        @elseif(!empty($certificate))
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-header">
                            <strong>সার্টিফিকেটের তথ্য</strong>
                        </div>
                        <div class="card-body">
                            <p><strong>সার্টিফিকেট নম্বর:</strong> {{ $certificate->certificate_no ?? 'N/A' }}</p>
                            <p><strong>ইস্যু তারিখ:</strong>
                                {{ optional($certificate->created_at)->format('d M Y') ?? ($certificate->issue_date ?? 'N/A') }}
                            </p>
                             <p><strong>ফলাফল:</strong> {{ $certificate->result ?? 'N/A' }}</p>
                            <p><strong>স্ট্যাটাস:</strong>
                                @if ($certificate->is_active == 1)
                                    <span class="badge bg-success">বৈধ</span>
                                @elseif($certificate->is_active == 2)
                                    <span class="badge bg-info">প্রক্রিয়াধীন</span>
                                @elseif($certificate->is_active == 3)
                                    <span class="badge bg-warning">প্রিন্টিং কিউ</span>
                                @elseif($certificate->is_active == 4)
                                    <span class="badge bg-danger">বাতিল</span>
                                @else
                                    <span class="badge bg-secondary">অজানা</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header">
                            <strong>শিক্ষার্থীর তথ্য</strong>
                        </div>
                        <div class="card-body">
                            <p><strong>স্টুডেন্ট আইডি:</strong>
                                {{ $student->student_id ?? ($certificate->student_id ?? 'N/A') }}</p>
                            <p><strong>নাম:</strong> {{ $student->sname ?? ($certificate->student_name ?? 'N/A') }}</p>
                            <p><strong>পিতা:</strong> {{ $student->f_name ?? 'N/A' }}</p>
                            <p><strong>মাতা:</strong> {{ $student->m_name ?? 'N/A' }}</p>
                            <p><strong>ফোন:</strong> {{ $student->phone ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <strong>কোর্স ও ব্যাচ</strong>
                        </div>
                        <div class="card-body">
                            <p><strong>কোর্স:</strong> {{ $certificate->course->name }}</p>
                            <p><strong>ব্যাচ:</strong> @php
                                $batchno = DB::table('batchs')->where('id', $certificate->batch_id)->first();
                            @endphp
                                {{ $batchno->batchnum }}</p>
                            <p><strong>সময়কাল:</strong> {{ $certificate->course->courseduration ?? 'N/A' }} মাস</p>
                            <p><strong>মডিউল:</strong> {{ $certificate->course->totalmoduls ?? 'N/A' }} </p>
                            <p><strong>তাত্ত্বিক:</strong> {{ $certificate->theory_hours ?? 'N/A' }} ঘন্টা</p>
                            <p><strong>ব্যবহারিক:</strong> {{ $certificate->practical_hours ?? 'N/A' }} ঘন্টা</p>
                            <p><strong>শিক্ষানবিষ:</strong> {{ $certificate->intern_hours ?? 'N/A' }} ঘন্টা</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">

                    <div class="card mb-3">
                        <div class="card-header">
                            <strong>শিক্ষার্থীর ছবি</strong>
                        </div>
                        <div class="card-body text-center">
                            @if (!empty($student->image))
                                <img src="{{ asset('public/storage/' . $student->image) }}" alt="Student Image"
                                    class="img-thumbnail" style="max-width: 180px;">
                            @else
                                <img src="{{ asset('images/default-avatar.png') }}" alt="No Image" class="img-thumbnail"
                                    style="max-width: 180px;">
                                <p class="mt-2 text-muted">ছবি পাওয়া যায়নি</p>
                            @endif
                        </div>
                    </div>
                    <div class="card text-center mb-3">
                        <div class="card-header">
                            ভেরিফিকেশন
                        </div>
                        <div class="card-body">
                            <img src="data:image/png;base64, {!! base64_encode(
                                QrCode::format('png')->size(100)->generate('https://innovacomputersbd.com/certifiocate-verify/' . $certificate->certificate_no),
                            ) !!}" alt="QR" class="qr">
                            <p class="mb-2"><strong>ভেরিফাই করা হয়েছে</strong></p>
                            <p>{{ now()->format('d M Y, H:i') }}</p>
                            <a href="{{ url('/') }}" class="btn btn-outline-primary mt-2"
                                style="padding: 14px;border-radius: 9px;color: #fff;background: linear-gradient(214.38deg,#8b79ff -2.24%, #0a1e58 59.38%);font-size: 16px;">হোমে
                                ফিরে যান</a>
                        </div>
                    </div>

                    @if (!empty($certificate->attachment))
                        <div class="card">
                            <div class="card-header">সংযুক্ত সার্টিফিকেট</div>
                            <div class="card-body text-center">
                                <a href="{{ asset($certificate->attachment) }}" target="_blank"
                                    class="btn btn-sm btn-primary">সার্টিফিকেট দেখুন</a>
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-info">
                            কোনো সার্টিফিকেট তথ্য পাওয়া যায়নি।
                        </div>
                    </div>
                </div>
        @endif
    </div>
@endsection
