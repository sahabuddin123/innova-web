   <!-- ================================= Certificate Section Start ================================= -->
   <div class="certificate">
    <div class="container container--lg">
        <div class="certificate-box px-16 bg-main-600 rounded-16">
            <div class="container">
                <div class="position-relative py-80">
                    <div class="row align-items-center">
                        <div class="col-xl-6">
                            <div class="certificate__content">
                                <div class="flex-align gap-8 mb-16 wow bounceInDown">
                                    <span class="w-8 h-8 bg-white rounded-circle"></span>
                                    <h5 class="text-white mb-0">সনদপত্র নিন</h5>
                                </div>
                                <h2 class="text-white mb-40 fw-medium wow bounceIn">ইনোভা থেকে মানসম্পন্ন দক্ষতার সনদপত্র অর্জন করুন</h2>
                                <a href=""
                                    class="btn btn-white rounded-pill flex-align d-inline-flex gap-8 hover-bg-main-800 wow bounceInUp">
                                    এখনই শুরু করুন
                                    <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-6 d-xl-block d-none">
                            <div class="certificate__thumb" data-aos="fade-up-left">
                                <img src="{{ asset('frontend/v2/assets/images/thumbs/model-1.png')}}" alt="" data-tilt
                                    data-tilt-max="8" data-tilt-speed="500" data-tilt-perspective="5000"
                                    data-tilt-full-page-listening>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ================================= Certificate Section End ================================= -->
<!-- ==================== Footer Start Here ==================== -->
<footer class="footer bg-main-25 position-relative z-1">
    <img src="{{ asset('frontend/v2/assets/images/shapes/shape2.png')}}" alt="" class="shape five animation-scalation">
    <img src="{{ asset('frontend/v2/assets/images/shapes/shape6.png')}}" alt="" class="shape one animation-scalation">
    
    <div class="py-120 ">
        <div class="container container-two">
            <div class="row row-cols-xxl-5 row-cols-lg-3 row-cols-sm-2 row-cols-1 gy-5">
                <div class="col" data-aos="fade-up" data-aos-duration="300" >
                    <div class="footer-item">
                        <div class="footer-item__logo">
                            <a href="{{route('frontend.home')}}"> <img src="{{ asset('public/storage/'.config('settings.site_logo')) }}" alt=""></a>
                        </div>
                        <p class="my-32">ইনোভা একটি দক্ষতা উন্নয়ন প্রতিষ্ঠান, যেখানে আধুনিক আইটি কোর্সের মাধ্যমে শিক্ষার্থীদের কর্মসংস্থানের সুযোগ তৈরি করা হয়।</p>
                        <ul class="social-list flex-align gap-24">
                            <li class="social-list__item">
                                <a href="{{config('settings.social_facebook')}}" class="text-main-600 text-2xl hover-text-main-two-600"><i class="ph-bold ph-facebook-logo"></i></a>
                            </li>
                            <li class="social-list__item">
                                <a href="{{config('settings.social_twitter')}}" class="text-main-600 text-2xl hover-text-main-two-600"> <i class="ph-bold ph-twitter-logo"></i></a>
                            </li>
                            <li class="social-list__item">
                                <a href="{{config('settings.social_linkedin')}}" class="text-main-600 text-2xl hover-text-main-two-600"><i class="ph-bold ph-linkedin-logo"></i></a>
                            </li>
                            <li class="social-list__item">
                                <a href="{{config('settings.social_instagram')}}" class="text-main-600 text-2xl hover-text-main-two-600"><i class="ph-bold ph-instagram-logo"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col" data-aos="fade-up" data-aos-duration="400" >
                    <div class="footer-item">
                        <h4 class="footer-item__title mb-32">কুইক লিংক</h4>
                        <ul class="footer-menu">
                            <li class="mb-16">
                                <a href="{{route('frontend.about')}}" class="text-neutral-500 hover-text-main-600 hover-text-decoration-underline">আমাদের সম্পর্কে</a>
                            </li>
                            <li class="mb-16">
                                <a href="{{route('frontend.instructors')}}" class="text-neutral-500 hover-text-main-600 hover-text-decoration-underline">মেন্টরস</a>
                            </li>
                            <li class="mb-16">
                                <a href="{{route('frontend.contact')}}" class="text-neutral-500 hover-text-main-600 hover-text-decoration-underline">যোগাযোগ</a>
                            </li>
                            <li class="mb-16">
                                <a href="{{route('frontend.blogs')}}" class="text-neutral-500 hover-text-main-600 hover-text-decoration-underline">ব্লগ</a>
                            </li>
                            <li class="mb-0">
                                <a href="{{route('frontend.frelanching')}}" class="text-neutral-500 hover-text-main-600 hover-text-decoration-underline">ফ্রিল্যান্সিং</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col" data-aos="fade-up" data-aos-duration="600" >
                    <div class="footer-item">
                        <h4 class="footer-item__title mb-32">লিংক</h4>
                        <ul class="footer-menu">
                            <li class="mb-16">
                                <a href="{{route('frontend.courses')}}" class="text-neutral-500 hover-text-main-600 hover-text-decoration-underline">কোর্স</a>
                            </li>
                            <li class="mb-16">
                                <a href="{{route('frontend.seminors')}}" class="text-neutral-500 hover-text-main-600 hover-text-decoration-underline">সেমিনার</a>
                            </li>
                            <li class="mb-16">
                                <a href="{{route('frontend.successstory')}}" class="text-neutral-500 hover-text-main-600 hover-text-decoration-underline">সাফল্যের গল্প</a>
                            </li>
                            <li class="mb-16">
                                <a href="{{route('frontend.galary')}}" class="text-neutral-500 hover-text-main-600 hover-text-decoration-underline">আমাদের গ্যালারী</a>
                            </li>
                            <li class="mb-16">
                                <a href="{{route('frontend.faq')}}" class="text-neutral-500 hover-text-main-600 hover-text-decoration-underline">আপনার প্রশ্নসমূহ</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col" data-aos="fade-up" data-aos-duration="800" >
                    <div class="footer-item">
                        <h4 class="footer-item__title mb-32">যোগাযোগ</h4>
                        <div class="flex-align gap-20 mb-24">
                            <span class="icon d-flex text-32 text-main-600"><i class="ph ph-phone"></i></span>
                            <div class="">
                                <a href="tel:(+880)1867033550" class="text-neutral-500 d-block hover-text-main-600 mb-4">(+৮৮০)  ১৮৬ ৭০৩ ৩৫৫০</a>
                                <a href="tel:(+880)1844463954" class="text-neutral-500 d-block hover-text-main-600 mb-0">(+৮৮০)  ১৮৪ ৪৪৬ ৩৯৫৪</a>
                            </div>
                        </div>
                        <div class="flex-align gap-20 mb-24">
                            <span class="icon d-flex text-32 text-main-600"><i class="ph ph-envelope-open"></i></span>
                            <div class="">
                                <a href="mailto:innovacom.ae@gmail.com" class="text-neutral-500 d-block hover-text-main-600 mb-4">innovacom.ae@gmail.com</a>
                                <a href="mailto:service.icbd@gmail.com" class="text-neutral-500 d-block hover-text-main-600 mb-0">service.icbd@gmail.com</a>
                            </div>
                        </div>
                        <div class="flex-align gap-20 mb-24">
                            <span class="icon d-flex text-32 text-main-600"><i class="ph ph-map-trifold"></i></span>
                            <div class="">
                                <span class="text-neutral-500 d-block mb-4">মাস্টার পাড়া, চরবাটা</span>
                                <span class="text-neutral-500 d-block mb-0">সুবর্ণচর, নোয়াখালী - ৩৮১৩</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col" data-aos="fade-up" data-aos-duration="1000" >
                    <div class="footer-item">
                        <h4 class="footer-item__title mb-32">এখানে সাবস্ক্রাইব করুন</h4>
                        <p class="text-neutral-500">আমাদের নিউজলেটার সাবস্ক্রিপশনের জন্য নিবন্ধন করতে আপনার ইমেইল ঠিকানা প্রদান করুন</p>
                        <form action="#" class="mt-24 position-relative">
                            <input type="email" class="form-control bg-white shadow-none border border-neutral-30 rounded-pill h-52 ps-24 pe-40 focus-border-main-600" placeholder="ই-মেইল...">
                            <button type="submit" class="w-36 h-36 flex-center rounded-circle bg-main-600 text-white hover-bg-main-800 position-absolute top-50 translate-middle-y inset-inline-end-0 me-8">
                                <i class="ph ph-paper-plane-tilt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <!-- bottom Footer -->
        <div class="bottom-footer bg-main-25 border-top border-dashed border-main-100 border-0 py-32">
            <div class="container container-two">
                <div class="bottom-footer__inner flex-between gap-3 flex-wrap">
                    <p class="bottom-footer__text" data-aos="fade-right" data-aos-duration="1000" >স্বত্ব © ২০২০-২০২৫ <span class="fw-semibold">ইনোভা কম্পিউটার্স বিডি</span> , সর্বস্বত্ব সংরক্ষিত।</p>
                    <div class="footer-links" data-aos="fade-left" data-aos-duration="1000" >
                        <a href="#" class="text-neutral-500 hover-text-main-600 hover-text-decoration-underline">গোপনীয়তা নীতি</a>
                        <a href="#" class="text-neutral-500 hover-text-main-600 hover-text-decoration-underline">শর্তাবলী</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- ==================== Footer End Here ==================== -->
  