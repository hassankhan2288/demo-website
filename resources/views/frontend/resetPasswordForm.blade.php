@extends('frontend.layouts.master')
@section('title','Cater-Choice || Login Page')
@section('main-content')
<main>
    <div class="w-full bg-[#706233]/10 py-[15px]">
		<div class="!container px-6 mx-auto">
			<div class="flex items-center">
				<div class="grow">
					<nav>
						<ol class="flex items-center">
							<li class="list-unstyled"><a href="/">Home </a></li>
							<li class="list-unstyled text-[#706233] ml-1" aria-current="page"> / Reset Password</li>
						</ol>
					</nav>
				</div>
				<div class="grow text-right">
                    <h2 class="text-[16px] font-bold">Reset Password</h2>
				</div>
			</div>
		</div>
	</div>
    <div class="!container mx-auto px-6">
        <div class="flex flex-wrap justify-center py-[40px]">
            <div class="sm:w-[400px] w-full mx-auto mt-[25px] mb-[50px] shadow-[0px_15px_66px_5px_#d9d9d9cc] p-[30px]">
                <h1 class="mb-3 text-[20px] font-bold">{{ __('Reset Password') }}</h1>
                <p class="mb-[15px] mr-[16px]">Please enter your password</p>
                @if(Session::has('error'))
                    <p class="alert alert-info">{{ Session::get('error') }}</p>
                @endif
                <form method="POST" action="{{ route('reset.password.post') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}" >
                <div class="mb-[20px]">
                    <input id="email" type="email" placeholder="Email" class="p-[8px_15px] rounded-[4px] !border !border-[#706233]/10 w-full focus:border-[#706233]/30 focus-visible:!border-[#706233]/30 focus-visible:outline-0 @error('email') is-invalid @enderror" name="email" value="" required  autofocus>
                    @error('email')
                        <span class="text-red" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-[20px]">
                    <input id="password" type="password" placeholder="Password" class="p-[8px_15px] rounded-[4px] !border !border-[#706233]/10 w-full focus:border-[#706233]/30 focus-visible:!border-[#706233]/30 focus-visible:outline-0 @error('password') is-invalid @enderror" name="password" value="" required  autofocus>
                    @error('password')
                        <span class="text-red" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-[20px]">
                    <input id="password_confirmation" type="password" placeholder="Confirm Password" class="p-[8px_15px] rounded-[4px] !border !border-[#706233]/10 w-full focus:border-[#706233]/30 focus-visible:!border-[#706233]/30 focus-visible:outline-0 @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value="" required  autofocus>
                    @error('password_confirmation')
                        <span class="text-red" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <button class="p-[10px_30px] w-full rounded-full text-white bg-[#706233]">{{ __('Reset') }}</button>
                <div class="text-center mt-[15px]">
                    <a href="{{ route('customer.register') }}" class="text-[16px] hover:text-[#706233]"> Sign up for an account</a>
                </div>
            </form>
        </div>
    </div>
</main>
@include('frontend/footer');

 @endsection
