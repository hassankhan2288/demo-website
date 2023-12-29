@include('app.includes.head')
<div class="auth-layout-wrap" >
    <div class="auth-content">
        <div class="card o-hidden">
            <div class="row">
                <div class="col-md-6 container">
                    <div class="p-4">
                        <div class="auth-logo text-center mb-4"><img src="{{asset('img/logo.png')}}" alt=""></div>
                        <h1 class="mb-3 text-18">{{ __('Login') }}</h1>
                        @if(!empty($url))
                            <form method="POST" action="{{ route($url.'.login') }}">
                        @else
                            <form method="POST" action="{{ route('pos.login') }}">
                        @endif
                        @csrf
                            <div class="form-group">
                                <label for="email">{{ __('E-Mail Address') }}</label>
                                 <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                             
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>

                            <button class="btn btn-primary btn-block mt-2">{{ __('Login') }}</button>
                        </form>
                        <div class="mt-3 text-center">
                           {{-- @if (Route::has('password.request')) --}}
                                <a class="btn btn-link text-muted" href="{{ route('pos.reset.branch.password') }}" class="reset_pass_link">
                                    <u>{{ __('Forgot Your Password?') }}</u>
                                </a>
                            {{-- @endif --}}
                        </div> 
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
