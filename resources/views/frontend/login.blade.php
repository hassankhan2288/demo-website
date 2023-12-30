@extends('frontend.layouts.master')
@section('title','Demo || Login Page')
@section('main-content')
<main>
    <div class="w-full bg-[#706233]/10 py-[15px]">
		<div class="!container px-6 mx-auto">
			<div class="flex items-center">
				<div class="grow">
					<nav>
						<ol class="flex items-center">
							<li class="list-unstyled"><a href="/">Home </a></li>
							<li class="list-unstyled text-[#706233] ml-1" aria-current="page"> / Login</li>
						</ol>
					</nav>
				</div>
				<div class="grow text-right">
                    <h2 class="text-[16px] font-bold">Login</h2>
				</div>
			</div>
		</div>
	</div>
    <div class="!container mx-auto px-6">
        <div class="flex flex-wrap justify-center py-[40px]">
            <div class="sm:w-[400px] w-full mx-auto mt-[25px] mb-[50px] shadow-[0px_15px_66px_5px_#d9d9d9cc] p-[30px]">
                <h1 class="mb-3 text-[20px] font-bold">{{ __('Login') }}</h1>
                <p class="mb-[15px] mr-[16px]">Please enter your email address and password</p>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                @if(Session::has('error'))
                    <p class="alert alert-info">{{ Session::get('error') }}</p>
                @endif
                @if(!empty($url))
                <form method="POST" action="{{ route($url.'.login') }}">
                @else
                <form method="POST" action="{{ route('customer.login') }}">
                @endif
                @csrf
                <div class="mb-[20px]">
                    <input id="email" type="email" placeholder="Email Address" class="p-[8px_15px] rounded-[4px] !border !border-[#706233]/10 w-full focus:border-[#706233]/30 focus-visible:!border-[#706233]/30 focus-visible:outline-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="text-red" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-[20px]">
                    <input id="password" type="password" placeholder="Password" class="p-[8px_15px] rounded-[4px] !border !border-[#706233]/10 w-full focus:border-[#706233]/30 focus-visible:!border-[#706233]/30 focus-visible:outline-0 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="text-red" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-check mb-[20px]">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                    <a href="{{route('reset-user-password')}}" class="reset_pass_link">Forgot Password?</a>
                </div>

                <button class="p-[10px_30px] w-full rounded-full text-white bg-[#706233]">{{ __('Login') }}</button>
                <div class="text-center mt-[15px]">
                    <a href="{{ route('customer.register') }}" class="text-[16px] hover:text-[#706233]"> Sign up for an account</a>
                </div>
            </form>
        </div>
    </div>
</main>
@include('frontend/footer');

 @endsection
