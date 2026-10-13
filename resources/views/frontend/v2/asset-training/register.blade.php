@extends('frontend.v2.app')

@section('content')
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<section class="asset-hero">
    <div class="bg-gradents">
        <div class="blob b1"></div>
        <div class="blob b2"></div>
        <div class="blob b3"></div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-11">
                <div class="header-row d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between mb-4 gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="logo-glass d-flex align-items-center justify-content-center">
                            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L15.5 8.5L22 12L15.5 15.5L12 22L8.5 15.5L2 12L8.5 8.5L12 2Z" fill="url(#g)"/>
                                <defs>
                                    <linearGradient id="g" x1="0" x2="1" y1="0" y2="1">
                                        <stop offset="0" stop-color="#4F46E5"/>
                                        <stop offset="1" stop-color="#7C3AED"/>
                                    </linearGradient>
                                </defs>
                            </svg>
                        </div>
                        <div>
                            <h1 class="title mb-1">ASSET Training Registration</h1>
                            <p class="subtitle mb-0">ফ্রি প্রশিক্ষণের জন্য আবেদন করুন — দ্রুত ও সহজ।</p>
                        </div>
                    </div>
                    <nav aria-label="breadcrumb" class="mt-2 mt-md-0">
                        <ol class="breadcrumb glass-breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">হোম</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('asset-training.index') }}">ASSET Training</a></li>
                            <li class="breadcrumb-item active" aria-current="page">রেজিস্ট্রেশন</li>
                        </ol>
                    </nav>
                </div>

                <div class="glass-card p-4 p-md-5">
                    <div class="row g-4">
                        <div class="col-lg-7">
                            @if(session('success'))
                                <div class="alert alert-success alert-glass animated-success">{{ session('success') }}</div>
                            @endif
                            @if($errors->any())
                                <div class="alert alert-danger alert-glass">
                                    <ul class="mb-0 ps-3">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('asset-training.register.store') }}" method="POST" enctype="multipart/form-data" id="assetForm">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label">রেজিস্ট্রেশন কোর্স</label>
                                        <select name="course_id" class="form-select">
                                            <option value="">-- কোর্স নির্বাচন করুন --</option>
                                            @foreach($courses as $course)
                                                <option value="{{ $course->id }}" {{ old('course_id', request('course_id')) == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('course_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">পূর্ণ নাম</label>
                                        <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" placeholder="আপনার পূর্ণ নাম">
                                        @error('full_name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">ইমেইল</label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="আপনার ইমেইল">
                                        @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">বর্তমান ঠিকানা</label>
                                        <input type="text" name="address" class="form-control" value="{{ old('address') }}" placeholder="আপনার ঠিকানা">
                                        @error('address')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">ফোন নম্বর</label>
                                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="01XXXXXXXXX">
                                        @error('phone')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Whatsapp নম্বর</label>
                                        <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp') }}" placeholder="Whatsapp নম্বর (ঐচ্ছিক)">
                                        @error('whatsapp')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">জন্মতারিখ</label>
                                        <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}">
                                        @error('date_of_birth')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">শিক্ষাগত যোগ্যতা</label>
                                        <input type="text" name="educational_qualification" class="form-control" value="{{ old('educational_qualification') }}" placeholder="HSC, Diploma, BBA">
                                        @error('educational_qualification')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">শিক্ষা প্রতিষ্ঠান</label>
                                        <input type="text" name="educational_organization" class="form-control" value="{{ old('educational_organization') }}" placeholder="কলেজ/বিশ্ববিদ্যালয়ের নাম">
                                        @error('educational_organization')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">আপনি বর্তমানে</label>
                                        <select name="current_status" class="form-select">
                                            <option value="">-- নির্বাচন করুন --</option>
                                            @foreach(['Student','Freelancer','Job Holder','Businessman','Unemployed','Other'] as $status)
                                                <option value="{{ $status }}" {{ old('current_status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                            @endforeach
                                        </select>
                                        @error('current_status')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">ব্যাংক একাউন্ট আছে?</label>
                                        <div class="radio-glass">
                                            <div>
                                                <input type="radio" id="bank_yes" name="has_bank_account" value="1" {{ old('has_bank_account') === '1' ? 'checked' : '' }}>
                                                <label for="bank_yes">হ্যাঁ</label>
                                            </div>
                                            <div>
                                                <input type="radio" id="bank_no" name="has_bank_account" value="0" {{ old('has_bank_account') === '0' ? 'checked' : '' }}>
                                                <label for="bank_no">না</label>
                                            </div>
                                        </div>
                                        @error('has_bank_account')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-12">
                                        <div class="section-divider"></div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">NID Upload</label>
                                        <div class="glass-upload" id="nidDrop">
                                            <input type="file" name="nid_file" id="nid_file">
                                            <div class="upload-icon">📄</div>
                                            <div class="upload-text">PDF/JPG/PNG আপলোড করুন</div>
                                            <div class="file-name small text-truncate mt-2 text-white-50" id="nid_name">{{ old('nid_file') ? old('nid_file') : '' }}</div>
                                        </div>
                                        @error('nid_file')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">শিক্ষাগত সনদ</label>
                                        <div class="glass-upload" id="certDrop">
                                            <input type="file" name="certificate_file" id="certificate_file">
                                            <div class="upload-icon">🎓</div>
                                            <div class="upload-text">সার্টিফিকেট আপলোড করুন</div>
                                            <div class="file-name small text-truncate mt-2 text-white-50" id="cert_name">{{ old('certificate_file') ? old('certificate_file') : '' }}</div>
                                        </div>
                                        @error('certificate_file')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">পাসপোর্ট সাইজ ছবি</label>
                                        <div class="glass-upload" id="ppDrop">
                                            <input type="file" name="passport_image" id="passport_image">
                                            <div class="upload-icon">🖼️</div>
                                            <div class="upload-text">ছবি আপলোড করুন</div>
                                            <div class="file-name small text-truncate mt-2 text-white-50" id="pp_name">{{ old('passport_image') ? old('passport_image') : '' }}</div>
                                        </div>
                                        @error('passport_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-12 text-center mt-3">
                                        <button type="submit" class="submit-btn">রেজিস্ট্রেশন জমা দিন</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-lg-5">
                            <div class="info-panel p-4 rounded-3">
                                <h5 class="mb-3">কি নিয়ে আসুন</h5>
                                <ul class="list-unstyled text-muted lh-lg">
                                    <li>• NID / জন্ম নিবন্ধন</li>
                                    <li>• সর্বশেষ শিক্ষাগত সনদ</li>
                                    <li>• পাসপোর্ট সাইজ রঙিন ছবি</li>
                                </ul>

                                <hr class="my-3">

                                <h6 class="mb-2">প্রক্রিয়া</h6>
                                <ol class="small text-muted mb-0">
                                    <li>নথি যাচাই করা হবে</li>
                                    <li>নির্বাচিত প্রার্থীদের সাথে যোগাযোগ করা হবে</li>
                                </ol>

                                <div class="mt-4">
                                    <div class="progress glass-progress" style="height:10px; border-radius:10px;">
                                        <div class="progress-bar" role="progressbar" style="width:38%" aria-valuenow="38" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="small text-muted mt-2">আবেদন প্রক্রিয়ার চাপ: <strong>38%</strong></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap');
:root{ --primary-1:#4F46E5; --primary-2:#7C3AED; --accent:#06B6D4 }
body .asset-hero{min-height:100vh; position:relative; padding-bottom:80px}
.bg-gradents{position:absolute; inset:0; z-index:0; overflow:hidden}
.blob{position:absolute; filter:blur(60px); opacity:0.7; transform:translateZ(0); will-change:transform}
.b1{width:420px; height:420px; background:linear-gradient(135deg,var(--primary-1),var(--primary-2)); top:-80px; left:-120px}
.b2{width:340px; height:340px; background:linear-gradient(135deg,var(--accent),#8B5CF6); bottom:-80px; right:-100px}
.b3{width:260px; height:260px; background:linear-gradient(135deg,#22D3EE,#7C3AED); top:20%; right:10%}
.glass-card{position:relative; z-index:2; border-radius:24px; background: rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.12); backdrop-filter: blur(18px); box-shadow: 0 8px 30px rgba(2,6,23,0.45);} 
.glass-breadcrumb .breadcrumb-item a{color:rgba(255,255,255,0.85)}
.header-row .title{font-family: 'Poppins',sans-serif; font-weight:800; font-size:1.6rem; color:#fff; background:linear-gradient(90deg,var(--primary-1),var(--primary-2)); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent}
.header-row .subtitle{color:rgba(255,255,255,0.75); font-size:0.95rem}
.logo-glass{width:58px;height:58px;border-radius:14px;background:linear-gradient(180deg, rgba(255,255,255,0.06), rgba(255,255,255,0.02)); border:1px solid rgba(255,255,255,0.08); box-shadow: 0 6px 18px rgba(79,70,229,0.12)}
.glass-input{background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.10); color:#fff; padding:12px 14px; border-radius:12px; transition: all .22s ease}
.glass-input:focus, .glass-input:hover{border-color: rgba(124,58,237,0.9); box-shadow: 0 6px 20px rgba(124,58,237,0.12); outline: none}
.glass-label{font-weight:600; color:rgba(255,255,255,0.9); font-size:0.85rem}
.dropzone{position:relative; border-radius:12px; padding:12px; background:rgba(255,255,255,0.02); border:1px dashed rgba(255,255,255,0.08); min-height:74px; display:flex; align-items:center; justify-content:center; cursor:pointer}
.dropzone:hover{border-color:rgba(124,58,237,0.9); transform: translateY(-2px); transition: all .18s ease}
.dropzone .dz-icon{font-size:22px; color:rgba(255,255,255,0.9)}
.dropzone .dz-text{color:rgba(255,255,255,0.75); font-size:0.9rem}
.dropzone .dz-filename{color:rgba(255,255,255,0.85); margin-top:6px}
.dropzone .real-file{position:absolute; inset:0; width:100%; height:100%; opacity:0; cursor:pointer}
.btn-cta{background:linear-gradient(90deg,var(--primary-1),var(--primary-2)); color:#fff; font-weight:700; border-radius:999px; padding:12px 36px; border:none; box-shadow: 0 8px 30px rgba(79,70,229,0.18); transition: all .18s ease}
.btn-cta:hover{transform:translateY(-3px) scale(1.01); box-shadow: 0 14px 40px rgba(124,58,237,0.22)}
.info-panel{background: linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.02)); border-radius:14px; border:1px solid rgba(255,255,255,0.06); color:rgba(255,255,255,0.9)}
.glass-progress .progress-bar{background:linear-gradient(90deg,var(--primary-1),var(--primary-2));}
.alert-glass{background: linear-gradient(90deg, rgba(6,182,212,0.12), rgba(124,58,237,0.06)); border:1px solid rgba(255,255,255,0.05); color:#fff}
.animated-success{animation: floatIn .5s ease both}
@keyframes floatIn{from{opacity:0; transform:translateY(-6px)} to{opacity:1; transform:none}}
@media(max-width:991px){ .header-row{gap:10px} .logo-glass{width:48px;height:48px} }
@media(max-width:575px){ .glass-card{padding:18px} .title{font-size:1.2rem} }
</style>

<script>
document.addEventListener('DOMContentLoaded', function(){
    // File input display handlers
    function wireUp(fileId, nameId, dropId){
        var input = document.getElementById(fileId);
        var nameBox = document.getElementById(nameId);
        var drop = document.getElementById(dropId);
        if(!input || !nameBox || !drop) return;
        drop.addEventListener('click', function(){ input.click(); });
        input.addEventListener('change', function(){ if(input.files && input.files[0]){ nameBox.textContent = input.files[0].name; } });
        drop.addEventListener('dragover', function(e){ e.preventDefault(); drop.classList.add('dragover'); });
        drop.addEventListener('dragleave', function(){ drop.classList.remove('dragover'); });
        drop.addEventListener('drop', function(e){ e.preventDefault(); drop.classList.remove('dragover'); var files = e.dataTransfer.files; if(files.length){ input.files = files; var ev = new Event('change'); input.dispatchEvent(ev); } });
    }

    wireUp('nid_file','nid_name','nidDrop');
    wireUp('certificate_file','cert_name','certDrop');
    wireUp('passport_image','pp_name','ppDrop');
});
</script>

@endsection
