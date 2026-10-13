<!-- ==================== Mobile Menu Start Here ==================== -->
<div class="mobile-menu scroll-sm d-lg-none d-block">
    <button type="button" class="close-button"><i class="ph ph-x"></i> </button>
    <div class="mobile-menu__inner">
        <a href="{{ route('frontend.home') }}" class="mobile-menu__logo">
            <img src="{{ asset('public/storage/' . config('settings.site_logo')) }}" alt="Logo">
        </a>
        <div class="mobile-menu__menu">

            <ul class="nav-menu flex-align nav-menu--mobile">
                <li class="nav-menu__item {{ Route::currentRouteName() == 'frontend.home' ? 'activePage' : null }}">
                    <a href="{{ route('frontend.home') }}" class="nav-menu__link">হোম</a>
                </li>
                <li
                    class="nav-menu__item has-submenu {{ Route::currentRouteName() == 'frontend.about' || Route::currentRouteName() == 'frontend.team' ? 'activePage' : '' }}">
                    <a href="{{ route('frontend.about') }}" class="nav-menu__link">আমাদের সম্পর্কে</a>
                    <ul class="nav-submenu">
                        <li class="nav-submenu__item">
                            <a href="{{ route('frontend.about') }}" class="nav-submenu__link">কোম্পানি সম্পর্কে</a>
                        </li>
                        <li
                            class="nav-submenu__item">
                            <a href="{{ route('frontend.concerns') }}" class="nav-submenu__link">আমাদের উদ্বেগ</a>
                        </li>
                        <li class="nav-submenu__item">
                            <a href="{{ route('frontend.team') }}" class="nav-submenu__link">আমাদের টিম</a>
                        </li>
                        <li
                            class="nav-submenu__link">
                            <a href="{{ route('frontend.successstory') }}" class="nav-submenu__link">সাফল্যের গল্প</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-menu__item {{ Route::currentRouteName() == 'frontend.services' ? 'activePage' : '' }}">
                    <a href="{{ route('frontend.services') }}" class="nav-menu__link">আমাদের সেবা</a>
                </li>
                <li class="nav-menu__item {{ Route::currentRouteName() == 'frontend.products' ? 'activePage' : '' }}">
                    <a href="{{ route('frontend.products') }}" class="nav-menu__link">আমাদের পণ্য</a>
                </li>

                {{-- <li class="nav-menu__item {{ Route::currentRouteName() ==  'frontend.workflow' ? 'activePage' : '' }}">
                    <a href="{{route('frontend.workflow')}}" class="nav-menu__link">ওয়ার্কফ্লো</a>
                </li> --}}

                <li
                    class="nav-menu__item {{ Route::currentRouteName() == 'frontend.frelanching' ? 'activePage' : '' }}">
                    <a href="{{ route('frontend.frelanching') }}" class="nav-menu__link">ফ্রিল্যান্সিং</a>
                </li>
                <li class="nav-menu__item {{ Route::currentRouteName() == 'frontend.blogs' ? 'activePage' : '' }}">
                    <a href="{{ route('frontend.blogs') }}" class="nav-menu__link">ব্লগ</a>
                </li>
                <li class="nav-menu__item {{ Route::currentRouteName() == 'frontend.contact' ? 'activePage' : '' }}">
                    <a href="{{ route('frontend.contact') }}" class="nav-menu__link">যোগাযোগ</a>
                </li>
                <li
                    class="nav-menu__item has-submenu {{ Route::currentRouteName() == 'frontend.session.view' ? 'activePage' : '' }}">
                    <a href="javascript:void(0)" class="nav-menu__link">বাকাশিবো রেজিঃ</a>
                    @php
                        $sessions = DB::table('sessions')->where('IsActive', 1)->where('deleted_at', null)->get();
                    @endphp
                    <ul class="nav-submenu scroll-sm">
                        @foreach ($sessions as $session)
                            <li class="nav-submenu__item">
                                <a href="{{ route('frontend.session.view', $session->id) }}"
                                    class="nav-submenu__link hover-bg-neutral-30"> {{ $session->sessionName }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-menu__item {{ Route::currentRouteName() == 'asset.index' ? 'activePage' : '' }}">
                    <a href="{{ route('asset.index') }}" class="nav-menu__link">ASSET</a>
                </li>
                <li class="nav-menu__item {{ Route::currentRouteName() == 'frontend.courses' ? 'activePage' : '' }}">
                    <a href="{{ route('frontend.courses') }}" class="nav-menu__link">ব্রাউজ কোর্স </a>
                </li>
                
            </ul>
        </div>
    </div>
</div>
<!-- ==================== Mobile Menu End Here ==================== -->
<!-- ==================== Header Start Here ==================== -->
<header class="header">
    <div class="container container--xl">
        <nav class="header-inner flex-between gap-8">

            <div class="header-content-wrapper flex-align flex-grow-1" style="justify-content: space-around">
                <!-- Logo Start -->
                <div class="logo">
                    <a href="{{ route('frontend.home') }}" class="link">
                        <img src="{{ asset('public/storage/' . config('settings.site_logo')) }}" alt="Logo">
                    </a>
                </div>
                <!-- Logo End  -->

                <!-- Menu Start  -->
                <div class="header-menu d-lg-block d-none">

                    <ul class="nav-menu flex-align">
                        <li
                            class="nav-menu__item {{ Route::currentRouteName() == 'frontend.home' ? 'activePage' : null }}">
                            <a href="{{ route('frontend.home') }}" class="nav-menu__link">হোম</a>
                        </li>
                        <li
                            class="nav-menu__item has-submenu {{ Route::currentRouteName() == 'frontend.about' || Route::currentRouteName() == 'frontend.team' ? 'activePage' : '' }}">
                            <a href="{{ route('frontend.about') }}" class="nav-menu__link">আমাদের সম্পর্কে</a>
                            <ul class="nav-submenu">
                                <li class="nav-submenu__item">
                                    <a href="{{ route('frontend.about') }}" class="nav-submenu__link">কোম্পানি
                                        সম্পর্কে</a>
                                </li>
                                <li class="nav-submenu__item">
                                    <a href="{{ route('frontend.team') }}" class="nav-submenu__link">আমাদের টিম</a>
                                </li>
                                <li class="nav-submenu__item">
                                    <a href="{{ route('frontend.successstory') }}" class="nav-submenu__link">সাফল্যের গল্প</a>
                                </li>
                                <li class="nav-submenu__item">
                                    <a href="{{ route('frontend.concerns') }}" class="nav-submenu__link">আমাদের উদ্বেগ</a>
                                </li>

                            </ul>
                        </li>
                        <li
                            class="nav-menu__item {{ Route::currentRouteName() == 'frontend.services' ? 'activePage' : '' }}">
                            <a href="{{ route('frontend.services') }}" class="nav-menu__link">সার্ভিস সমূহ</a>
                        </li>
                        <li
                            class="nav-menu__item {{ Route::currentRouteName() == 'frontend.products' ? 'activePage' : '' }}">
                            <a href="{{ route('frontend.products') }}" class="nav-menu__link">আমাদের পণ্য</a>
                        </li>

                        <li
                            class="nav-menu__item {{ Route::currentRouteName() == 'frontend.frelanching' ? 'activePage' : '' }}">
                            <a href="{{ route('frontend.frelanching') }}" class="nav-menu__link">ফ্রিল্যান্সিং</a>
                        </li>
                        <li
                            class="nav-menu__item {{ Route::currentRouteName() == 'frontend.blogs' ? 'activePage' : null }}">
                            <a href="{{ route('frontend.blogs') }}" class="nav-menu__link">ব্লগ</a>
                        </li>
                        <li
                            class="nav-menu__item {{ Route::currentRouteName() == 'frontend.contact' ? 'activePage' : '' }}">
                            <a href="{{ route('frontend.contact') }}" class="nav-menu__link">যোগাযোগ</a>
                        </li>
                        <li
                            class="nav-menu__item has-submenu {{ Route::currentRouteName() == 'frontend.session.view' ? 'activePage' : '' }}">
                            <a href="javascript:void(0)" class="nav-menu__link">বাকাশিবো রেজিঃ</a>
                            @php
                                $sessions = DB::table('sessions')
                                    ->where('IsActive', 1)
                                    ->where('deleted_at', null)
                                    ->get();
                            @endphp
                            <ul class="nav-submenu scroll-sm">
                                @foreach ($sessions as $session)
                                    <li class="nav-submenu__item">
                                        <a href="{{ route('frontend.session.view', $session->id) }}"
                                            class="nav-submenu__link hover-bg-neutral-30">
                                            {{ $session->sessionName }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                         <li class="nav-menu__item {{ Route::currentRouteName() == 'asset.index' ? 'activePage' : '' }}">
                            <a href="{{ route('asset.index') }}" class="nav-menu__link">ASSET</a>
                        </li>
                        <li
                            class="nav-menu__item {{ Route::currentRouteName() == 'frontend.courses' ? 'activePage' : '' }}">
                            <a href="{{ route('frontend.courses') }}" class="nav-menu__link"
                                style="padding: 14px;border-radius: 9px;color: #fff;background: linear-gradient(214.38deg,#8b79ff -2.24%, #0a1e58 59.38%);font-size: 16px;"><i
                                    class="ph ph-book-open"></i>&nbsp;&nbsp;&nbsp; ব্রাউজ কোর্স &nbsp;&nbsp;<i
                                    class="ph ph-caret-down"></i></a>
                        </li>
                       
                    </ul>
                </div>
                <!-- Menu End  -->
            </div>

            <!-- Header Right start -->
            <div class="header-right flex-align">

                <a href="{{ route('login') }}"
                    class="info-action w-52 h-52 bg-main-25 hover-bg-main-600 border border-neutral-30 rounded-circle flex-center text-2xl text-neutral-500 hover-text-white hover-border-main-600">
                    <i class="ph ph-user-circle"></i>
                </a>
                <button type="button" class="toggle-mobileMenu d-lg-none text-neutral-200 flex-center">
                    <i class="ph ph-list"></i>
                </button>
            </div>
            <!-- Header Right End  -->
        </nav>
    </div>
</header>
<!-- ==================== Header End Here ==================== -->
