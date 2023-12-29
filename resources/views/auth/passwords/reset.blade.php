@include('app.includes.head')
<div class="auth-layout-wrap" >
    <div class="auth-content">
        <div class="card o-hidden">
            <div class="row">
                <div class="col-md-6 container">
                    <div class="p-4">
                        <div class="auth-logo text-center mb-4"><img src="{{asset('img/logo.png')}}" alt=""></div>
                        <h1 class="mb-3 text-18">{{ __('Reset Password') }}</h1>
                        <form method="POST" action="{{ route('pos.reset.password') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <label for="email">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                             
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>

                            <div class="form-group">
                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                            </div>

                            <button class="btn btn-primary btn-block mt-2">{{ __('Reset Password') }}</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>