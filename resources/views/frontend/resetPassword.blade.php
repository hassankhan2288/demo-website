@extends('frontend.layouts.master')
@section('title','Cater-Choice || Login Page')
@section('main-content')
<main>
    <div class="w-full bg-[#ce1212]/10 py-[15px]">
		<div class="!container px-6 mx-auto">
			<div class="flex items-center">
				<div class="grow">
					<nav>
						<ol class="flex items-center">
							<li class="list-unstyled"><a href="/">Home </a></li>
							<li class="list-unstyled text-[#ce1212] ml-1" aria-current="page"> / Reset Password</li>
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
                <p class="mb-[15px] mr-[16px]">Please enter your email address</p>
                @if(Session::has('error'))
                    <p class="alert alert-info">{{ Session::get('error') }}</p>
                @endif
                {{-- @if(!empty($url))
                <form method="POST" action="{{ route($url.'.login') }}">
                @else
                <form method="POST" action="{{ route('login') }}">
                @endif --}}
                @if ($message = Session::get('status'))
                <div class="alert alert-success alert-block">   
                    <strong>{{ $message }}</strong>
                </div>
                @endif
                <form method="POST" action="{{ route('reset.link') }}">
                @csrf
                <div class="mb-[20px]">
                    <input id="email" type="email" placeholder="Email Address" class="p-[8px_15px] rounded-[4px] !border !border-[#ce1212]/10 w-full focus:border-[#ce1212]/30 focus-visible:!border-[#ce1212]/30 focus-visible:outline-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="text-red" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <button class="p-[10px_30px] w-full rounded-full text-white bg-[#ce1212]">{{ __('Send Link') }}</button>
                <div class="text-center mt-[15px]">
                    <a href="{{ route('customer.register') }}" class="text-[16px] hover:text-[#ce1212]"> Sign up for an account</a>
                </div>
            </form>
        </div>
    </div>
</main>
@include('frontend/footer');

 @endsection
