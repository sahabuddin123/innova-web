@extends('frontend.app')

@section('content')
<section style="padding: 65px 0px">
   
</section>
<section class="section">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h2>Student Login</h2>
                </div>
            <div class="card-body">
                <form action="{{ route('login') }}" class="row" method="POST">
                    @csrf
                    <div class="col-12">
                        <div class="form-group">
                            <label for="email" class="form-label">{{ __('E-mail') }}</label>
                        <input type="email" class="form-control mb-3" id="loginName" placeholder="Email" name="email" value="{{ old('email') }}">
                        @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input type="password" class="form-control mb-3" id="loginPassword" placeholder="Password" name="password" value="{{ old('password') }}">
                            @error('password')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">LOGIN</button>
                        @if (Route::has('password.request'))
                             <a class="btn btn-link pl-0" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>
</section>
@endsection
