@include('app.includes.head')
<div class="auth-layout-wrap">
    <div class="auth-content">
        <div class="card o-hidden">
            <div class="row">
                <div class="col-md-6 container">
                        <div class="p-4">
                            <div class="auth-logo text-center mb-4"><img src="{{asset('img/logo.png')}}" alt=""></div>
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <h1 class="mb-3 text-18">{{ __('Reset Password') }}</h1>
                            <form method="POST" action="{{ route('pos.reset.link') }}">
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

                                <button class="btn btn-primary btn-block mt-2">{{ __('Send Password Reset Link') }}</button>
                            </form>
                            <div class="mt-3 text-center">
                                @if (Route::has('login'))
                                    <a class="btn btn-link text-muted" href="{{ route('pos.login') }}">
                                        {{ __('Log in account') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

