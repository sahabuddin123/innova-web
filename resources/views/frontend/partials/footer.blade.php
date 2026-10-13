
<!-- footer -->
<footer>
    <!-- newsletter -->
    <div class="newsletter">
      <div class="container">
        <div class="row">
          <div class="col-md-9 ml-auto bg-primary py-5 newsletter-block">
            <h3 class="text-white">সাবস্ক্রাইব করুন</h3>
            <form action="#">
              <div class="input-wrapper">
                <input type="email" class="form-control border-0" id="newsletter" name="newsletter" placeholder="আপনার  ইমেল দিন....">
                <button type="submit" value="send" class="btn btn-primary">জয়েন করুন</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- footer content -->
    <div class="footer bg-footer section border-bottom">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-sm-8 mb-5 mb-lg-0">
            <!-- logo -->
            <a class="logo-footer" href="/"><img class="img-fluid mb-4" src="{{ asset('public/storage/'.config('settings.site_logo')) }}" alt="logo"></a>
            <ul class="list-unstyled">
              <li class="mb-2">মাস্টার পাড়া সেন্ট্রাল পয়েন্ট, চরবাটা, <br>সুবর্ণচর, নোয়াখালী - ৩৮১৩</li>
              <li class="mb-2">+৮৮০ ১৮১ ৭৬৮ ২৩২৩</li>
              <li class="mb-2">+৮৮০  ১৮৪ ৪৪৬ ৩৯৬৩</li>
              <li class="mb-2">innovacomputersbd@gmail.com</li>
            </ul>
          </div>
          <!-- company -->
          <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-5 mb-md-0">
            <h4 class="text-white mb-5">কুইক লিংক</h4>
            <ul class="list-unstyled">
              <li class="mb-3"><a class="text-color" href="#">আমাদের সম্পর্কে</a></li>
              <li class="mb-3"><a class="text-color" href="#">মেন্টরস</a></li>
              <li class="mb-3"><a class="text-color" href="#">যোগাযোগ</a></li>
              <li class="mb-3"><a class="text-color" href="#">ব্লগ</a></li>
            </ul>
          </div>
          <!-- links -->
          <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-5 mb-md-0">
            <h4 class="text-white mb-5">লিংক</h4>
            <ul class="list-unstyled">
              <li class="mb-3"><a class="text-color" href="#">কোর্স</a></li>
              <li class="mb-3"><a class="text-color" href="#">ফ্রি সেমিনারের সময়সূচি</a></li>
              <li class="mb-3"><a class="text-color" href="#">নোটিশ</a></li>
              <li class="mb-3"><a class="text-color" href="#">ফ্রি স্কলারশিপ</a></li>
            </ul>
          </div>
          <!-- support -->
          <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-5 mb-md-0">
            <h4 class="text-white mb-5">সাপোর্ট</h4>
            <ul class="list-unstyled">
              <li class="mb-3"><a class="text-color" href="#">আমাদের সুবিধাদি</a></li>
              <li class="mb-3"><a class="text-color" href="#">আমাদের অর্জন</a></li>
              <li class="mb-3"><a class="text-color" href="#!">ক্যারিয়ার প্লেসমেন্ট</a></li>
              <li class="mb-3"><a class="text-color" href="#!">ফ্রিল্যান্সিং</a></li>
            </ul>
          </div>
          <!-- support -->
          <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-5 mb-md-0">
            <h4 class="text-white mb-5">অন্যান্য</h4>
            <ul class="list-unstyled">
              <li class="mb-3"><a class="text-color" href="#">স্টুডেন্ট ফিডব্যাক</a></li>
              <li class="mb-3"><a class="text-color" href="#">সাফল্যের গল্প</a></li>
              <li class="mb-3"><a class="text-color" href="#">আমাদের গ্যালারী</a></li>
              <li class="mb-3"><a class="text-color" href="#">আপনার প্রশ্নসমূহ</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- copyright -->
    <div class="copyright py-4 bg-footer">
      <div class="container">
        <div class="row">
          <div class="col-sm-7 text-sm-left text-center">
            <p class="mb-0">
               <a href="#" class="text-muted">{!! config('settings.footer_copyright_text') !!}</a>
            </p>
          </div>
          <div class="col-sm-5 text-sm-right text-center">
            <ul class="list-inline">
              <li class="list-inline-item"><a class="d-inline-block p-2" href="{{config('settings.social_facebook')}}"><i class="ti-facebook text-primary"></i></a></li>
              <li class="list-inline-item"><a class="d-inline-block p-2" href="{{config('settings.social_twitter')}}"><i class="ti-twitter-alt text-primary"></i></a></li>
              <li class="list-inline-item"><a class="d-inline-block p-2" href="{{config('settings.social_linkedin')}}"><i class="ti-linkedin text-primary"></i></a></li>
              <li class="list-inline-item"><a class="d-inline-block p-2" href="{{config('settings.social_instagram')}}"><i class="ti-instagram text-primary"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- /footer -->