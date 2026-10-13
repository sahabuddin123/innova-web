<!-- header -->
<header class="fixed-top header">
    <!-- top header -->
    <div class="top-header py-2 bg-white">
      <div class="container">
        <div class="row no-gutters">
          <div class="col-lg-4 text-center text-lg-left">
            <a class="text-color mr-3" href="tel:+8801867033550"><strong>CALL</strong> +880 1867 033 550</a>
            <ul class="list-inline d-inline">
              <li class="list-inline-item mx-0"><a class="d-inline-block p-2 text-color" href="#"><i class="ti-facebook"></i></a></li>
              <li class="list-inline-item mx-0"><a class="d-inline-block p-2 text-color" href="#"><i class="ti-twitter-alt"></i></a></li>
              <li class="list-inline-item mx-0"><a class="d-inline-block p-2 text-color" href="#"><i class="ti-github"></i></a></li>
              <li class="list-inline-item mx-0"><a class="d-inline-block p-2 text-color" href="#"><i class="ti-instagram"></i></a></li>
            </ul>
          </div>
          <div class="col-lg-8 text-center text-lg-right">
            <ul class="list-inline">
              <li class="list-inline-item"><a class="text-uppercase text-color p-sm-2 py-2 px-0 d-inline-block" href="#">notice</a></li>
              {{-- <li class="list-inline-item"><a class="text-uppercase text-color p-sm-2 py-2 px-0 d-inline-block" href="#">research</a></li> --}}
              <li class="list-inline-item"><a class="text-uppercase text-color p-sm-2 py-2 px-0 d-inline-block" href="#">SCHOLARSHIP</a></li>
              <li class="list-inline-item"><a class="text-uppercase text-color p-sm-2 py-2 px-0 d-inline-block" href="{{route('login')}}" >login</a></li>
              {{-- <li class="list-inline-item"><a class="text-uppercase text-color p-sm-2 py-2 px-0 d-inline-block" href="#loginModal" data-toggle="modal" data-target="#loginModal">login</a></li> --}}
              {{-- <li class="list-inline-item"><a class="text-uppercase text-color p-sm-2 py-2 px-0 d-inline-block" href="#signupModal" data-toggle="modal" data-target="#signupModal">register</a></li> --}}
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- navbar -->
    <div class="navigation w-100">
      <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark p-0">
          <a class="navbar-brand" href="{{route('frontend.home')}}"><img src="{{ asset('public/storage/'.config('settings.site_logo')) }}" alt="logo" height="60"></a>
          <button class="navbar-toggler rounded-0" type="button" data-toggle="collapse" data-target="#navigation"
            aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
  
          <div class="collapse navbar-collapse" id="navigation">
            <ul class="navbar-nav ml-auto text-center">
              <li class="nav-item {{ Route::currentRouteName() ==  'frontend.home' ? 'active' : null }}">
                <a class="nav-link" href="{{route('frontend.home')}}">হোম</a>
              </li>
              <li class="nav-item {{ Route::currentRouteName() ==  'frontend.about' ? 'active' : '@@about' }}">
                <a class="nav-link" href="{{route('frontend.about')}}">আমাদের সম্পর্কে</a>
              </li>
              <li class="nav-item {{ Route::currentRouteName() ==  'frontend.services' ? 'active' : '' }}">
                <a class="nav-link" href="{{route('frontend.services')}}">আমাদের সেবা</a>
              </li>
              <li class="nav-item {{ Route::currentRouteName() ==  'frontend.products' ? 'active' : '' }}">
                <a class="nav-link" href="{{route('frontend.products')}}">আমাদের পণ্য</a>
              </li>
              <li class="nav-item {{ Route::currentRouteName() ==  'frontend.concerns' ? 'active' : '' }}">
                <a class="nav-link" href="{{route('frontend.concerns')}}">আমাদের উদ্বেগ</a>
              </li>
              <li class="nav-item {{ Route::currentRouteName() ==  'frontend.workflow' ? 'active' : '' }}">
                <a class="nav-link" href="{{route('frontend.workflow')}}">ওয়ার্কফ্লো</a>
              </li>
              <li class="nav-item {{ Route::currentRouteName() ==  'frontend.courses' ? 'active' : '@@courses' }}">
                <a class="nav-link" href="{{route('frontend.courses')}}">ব্রাউজ কোর্স</a>
              </li>
              {{-- <li class="nav-item @@events">
                <a class="nav-link" href="#">EVENTS</a>
              </li>
              <li class="nav-item @@blog">
                <a class="nav-link" href="#">BLOG</a>
              </li> --}}
              <li class="nav-item dropdown view {{ Route::currentRouteName() ==  'frontend.session.view' ? 'active' : '' }}">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  বাকাশিবো রেজিঃ
                </a>
                @php
                $sessions = DB::table('sessions')->where('IsActive', 1)->where('deleted_at', null)->get();
                @endphp
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    {{-- Loops For Link Menu --}}
                    @foreach($sessions as $session)
                                    <li class="{{ (Route::currentRouteName() == 'frontend.session.view' && request()->route('id') == $session->id) ? 'active' : '' }}">
                    @endforeach
                  {{-- End Loops For Endmenu --}}
                </ul>
              </li>
              <li class="nav-item  {{ Route::currentRouteName() ==  'frontend.contact' ? 'active' : '@@contact' }}">
                <a class="nav-link" href="{{route('frontend.contact')}}">যোগাযোগ</a>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </div>
  </header>
  <!-- /header -->