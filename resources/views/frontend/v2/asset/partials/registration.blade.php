<h2 class="section-title text-center mb-5">
    ASSET রেজিস্ট্রেশন ফর্ম
</h2>

<form action="{{ route('asset.store') }}" method="POST" enctype="multipart/form-data">

    @csrf

    {{-- COURSE --}}
    <div class="form-group">

        <label class="form-label">
            কোর্স নির্বাচন করুন *
        </label>

        <select class="form-control" name="course">

            <option value="">
                -- কোর্স নির্বাচন করুন --
            </option>

            @php
                $courses = $assetCourses ?? \App\Models\AssetCourse::where('status', true)->get();
            @endphp

            @forelse($courses as $course)
                <option value="{{ $course->name }}">
                    {{ $course->name }}
                </option>
            @empty
                <option disabled>No courses available</option>
            @endforelse

        </select>

    </div>

    <hr class="my-5">

    <h4 class="font-weight-bold mb-4">
        ব্যক্তিগত তথ্য
    </h4>

    <div class="row">

        {{-- FULL NAME --}}
        <div class="col-md-12">

            <div class="form-group">

                <label class="form-label">
                    পূর্ণ নাম *
                </label>

                <input type="text" class="form-control" name="full_name" placeholder="আপনার পূর্ণ নাম লিখুন">

            </div>

        </div>

        {{-- FATHER NAME --}}
        <div class="col-md-6">

            <div class="form-group">

                <label class="form-label">
                    পিতার নাম *
                </label>

                <input type="text" class="form-control" name="father_name" placeholder="পিতার নাম লিখুন">

            </div>

        </div>

        {{-- MOTHER NAME --}}
        <div class="col-md-6">

            <div class="form-group">

                <label class="form-label">
                    মাতার নাম *
                </label>

                <input type="text" class="form-control" name="mother_name" placeholder="মাতার নাম লিখুন">

            </div>

        </div>

        {{-- MOBILE --}}
        <div class="col-md-6">

            <div class="form-group">

                <label class="form-label">
                    মোবাইল নাম্বার *
                </label>

                <input type="text" class="form-control" name="mobile" placeholder="01XXXXXXXXX">

            </div>

        </div>

        {{-- WHATSAPP --}}
        <div class="col-md-6">

            <div class="form-group">

                <label class="form-label">
                    WhatsApp নম্বর
                </label>

                <input type="text" class="form-control" name="whatsapp" placeholder="01XXXXXXXXX">

            </div>

        </div>

        {{-- EMAIL --}}
        <div class="col-md-6">

            <div class="form-group">

                <label class="form-label">
                    ইমেইল ঠিকানা *
                </label>

                <input type="email" class="form-control" name="email" placeholder="example@gmail.com">

            </div>

        </div>

        {{-- RELIGION --}}
        <div class="col-md-6">

            <div class="form-group">

                <label class="form-label">
                    ধর্ম *
                </label>

                <select class="form-control" name="religion">

                    <option value="">
                        -- ধর্ম নির্বাচন করুন --
                    </option>

                    <option>ইসলাম</option>

                    <option>হিন্দু</option>

                    <option>খ্রিস্টান</option>

                    <option>বৌদ্ধ</option>

                </select>

            </div>

        </div>

        {{-- GENDER --}}
        <div class="col-md-6">

            <div class="form-group">

                <label class="form-label">
                    লিঙ্গ *
                </label>

                <select class="form-control" name="gender">

                    <option value="">
                        -- লিঙ্গ নির্বাচন করুন --
                    </option>

                    <option>পুরুষ</option>

                    <option>মহিলা</option>

                    <option>অন্যান্য</option>

                </select>

            </div>

        </div>

        {{-- DATE OF BIRTH --}}
        <div class="col-md-6">

            <div class="form-group">

                <label class="form-label">
                    জন্ম তারিখ *
                </label>

                <input type="date" class="form-control" name="dob">

            </div>

        </div>

        {{-- NID --}}
        <div class="col-md-6">

            <div class="form-group">

                <label class="form-label">
                    জাতীয় পরিচয়পত্র নম্বর *
                </label>

                <input type="text" class="form-control" name="nid" placeholder="জাতীয় পরিচয়পত্র নম্বর লিখুন">

            </div>

        </div>

        {{-- EMPLOYMENT STATUS --}}
        <div class="col-md-12">

            <div class="form-group">

                <label class="form-label">
                    পেশাগত অবস্থা *
                </label>

                <select class="form-control" name="employment_status">

                    <option value="">
                        -- পেশাগত অবস্থা নির্বাচন করুন --
                    </option>

                    <option>শিক্ষার্থী</option>

                    <option>ফ্রিল্যান্সার</option>

                    <option>চাকরিজীবী</option>

                    <option>বেকার</option>

                </select>

            </div>

        </div>

        {{-- ADDRESS --}}
        <div class="col-md-12">

            <div class="form-group">

                <label class="form-label">
                    বর্তমান ঠিকানা *
                </label>

                <textarea class="form-control" name="address" placeholder="বর্তমান ঠিকানা লিখুন"></textarea>

            </div>

        </div>

    </div>

    <hr class="my-5">

    <h4 class="font-weight-bold mb-4">
        শিক্ষাগত তথ্য
    </h4>

    <div class="row">

        {{-- EDUCATION --}}
        <div class="col-md-6">

            <div class="form-group">

                <label class="form-label">
                    শিক্ষাগত যোগ্যতা *
                </label>

                <select class="form-control" name="education">

                    <option value="">
                        -- শিক্ষাগত যোগ্যতা নির্বাচন করুন --
                    </option>

                    <option>SSC</option>

                    <option>HSC</option>

                    <option>Diploma</option>

                    <option>Honours</option>

                    <option>Masters</option>

                </select>

            </div>

        </div>

        {{-- BOARD --}}
        <div class="col-md-6">

            <div class="form-group">

                <label class="form-label">
                    বোর্ড / প্রতিষ্ঠান *
                </label>

                <input type="text" class="form-control" name="board"
                    placeholder="বোর্ড / প্রতিষ্ঠানের নাম লিখুন">

            </div>

        </div>

        {{-- SUBJECT --}}
        <div class="col-md-6">

            <div class="form-group">

                <label class="form-label">
                    বিষয় *
                </label>

                <input type="text" class="form-control" name="subject" placeholder="বিষয়ের নাম লিখুন">

            </div>

        </div>

        {{-- PASSING YEAR --}}
        <div class="col-md-6">

            <div class="form-group">

                <label class="form-label">
                    পাশের সাল *
                </label>

                <input type="text" class="form-control" name="passing_year" placeholder="পাশের সাল লিখুন">

            </div>

        </div>

        {{-- PHOTO --}}
        <div class="col-md-12">

            <div class="form-group">

                <label class="form-label">
                    ছবি আপলোড করুন
                </label>

                <input type="file" class="form-control" name="photo">

            </div>

        </div>

    </div>

    <div class="text-center mt-5">

        <button type="submit" class="submit-btn" style="margin-top: 20px !important;">
            রেজিস্ট্রেশন সাবমিট করুন
        </button>

    </div>

</form>
