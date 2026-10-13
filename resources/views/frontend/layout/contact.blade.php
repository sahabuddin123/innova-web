@extends('frontend.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
  {{-- Contact Page --}}
  <section class="section bg-gray mt-5">
    <div class="container mt-5">
        @include('admin.partials.flash')
        <!-- contact -->
<section class="section">
    <h2 class="section-title text-center">Contact Us</h2>
    <h5 class="text-left text-center">You can directly visit our office to contact for any need. Moreover, you can call the hotline number to know any information related to training. You can also knock on the mentioned mail or Facebook messenger.</h5>
      <div class="row">
        <div class="col-lg-12">
          <h2 class="section-title mt-5">Inbox your queries</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-7 mb-4 mb-lg-0">
            <div class="login">
                <form action="{{ route('contact.store') }}" class="row" method="POST">
                    @csrf
                    <div class="col-12">
                        <label for="username">Your Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control mb-3  @error('username') is-invalid @enderror" id="username" name="username" placeholder="Please enter your full name here" value="{{old('username' )}}">
                        @error('username') {{ $message }} @enderror
                    </div>
                    <div class="col-12">
                        <label for="phone">Phone Number <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control mb-3  @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Please enter your phone number here" value="{{old('phone' )}}">
                        @error('phone') {{ $message }} @enderror
                    </div>
                    <div class="col-12">
                        <label for="email">Email Address <span class="text-secondary">(if any)</span></label>
                        <input type="email" class="form-control mb-3  @error('email') is-invalid @enderror" id="email" name="email" placeholder="Please enter your email address here" value="{{old('email' )}}">
                        @error('email') {{ $message }} @enderror
                    </div>
                    <div class="col-12">
                        <label for="courseId">Do you want to ask about any courses? <span class="text-danger">*</span></label>
                        <select name="courseId" id="courseId" class="form-control mb-3 @error('courseId') is-invalid @enderror">
                            <option value="">-- Select Course --</option>
                            @foreach ($courses as $course)
                                 <option value="{{$course->id}}"  @if(old('courseId' ) == $course->id) {{"selected"}} @endif>{{$course->name}}</option>
                            @endforeach
                        </select>
                        @error('courseId') {{ $message }} @enderror
                    </div>
                    <div class="col-12">
                        <label for="msg">Enter the details <span class="text-danger">*</span></label>
                        <textarea name="msg" id="msg" class="form-control mb-3  @error('msg') is-invalid @enderror" placeholder="Your Message" value="{{old('msg' )}}"></textarea>
                        @error('msg') {{ $message }} @enderror
                    </div>
                    <div class="col-12 mb-2">
                    <!-- Google reCaptcha v2 -->
          {!! htmlFormSnippet() !!}
         @if($errors->has('g-recaptcha-response'))
           <div>
              <small class="text-danger">{{ $errors->first('g-recaptcha-response') }}</small>
           </div>
         @endif
        </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </form>
            </div>
          
        </div>
        
        <div class="col-lg-5">
            <h4 class="mt-2">During office visits</h4>
            <ul class="pl-0">
                <li><strong>Saturday - Thursday</strong> 9 am to 8 pm</li>
                <li><strong>Friday</strong> 3 pm to 8 pm</li>
            </ul>
            <h4 class="mt-4">Contact Information</h4>
           <a href="tel:+8801817682323" class="text-color h5 d-block"><i class="ti-headphone-alt text-primary"></i> +880 181 768 2323</a>
          <a href="tel:+8801844463963" class="text-color h5 d-block"><i class="ti-headphone-alt text-primary"></i> +880 184 446 3963</a>
          <a href="mailto:innovacomputersbd@gmail.com" class="text-color h5 d-block"><i class="ti-email text-primary"></i> innovacomputersbd@gmail.com</a>
          <a href="https://facebook.com/innovacomputersbd" class="mb-4 text-color h5 d-block"><i class="ti-facebook text-primary"></i> innovacomputersbd</a>
          <p><strong>Address :</strong>  Masterpara Central Point, Charbata, khaserhat, Subarnachar, Noakhali - 3813</p>
          <p class="text-justify">INNOVA Computers BD, one of the leading IT training institutes in Bangladesh offers the best training opportunities. It has been playing a vital role to eradicate the unemployment problem since 2018. Enriched with quality training this institute has never failed to help individuals to reveal their talents making harmony between creativity and IT. No matter what is your background, we are offering 8 courses you conducted by experienced trainers to advance your skills.INNOVA Computers BD has tremendously well-decorated campuses with upgraded equipment. Our students are very much happy with our culture, environment, and outstanding training method.</p>
        </div>
      </div>

  </section>
  <!-- /contact -->
      </div>
  <!-- gmap -->
  <section class=" pt-0">
    <!-- Google Map -->
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3682.4872068396376!2d91.12346761533152!3d22.635616536358203!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3754ad4b93e01151%3A0x21b65fdbe8071a26!2sINNOVA%20Computers%20BD!5e0!3m2!1sen!2sbd!4v1681119601212!5m2!1sen!2sbd"  height="600" style="border:2px;width:100%" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </section>
  <!-- /gmap -->

   </section>
{{-- Contact End --}}
@endsection
@push('scripts')
<!--{!! htmlScriptTagJsApi() !!}-->
@endpush