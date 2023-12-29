@extends('frontend.layouts.master')
@section('title','Cart Page')
@section('main-content')
@php
    $user = \Auth::guard('customer')->user();
    if(isset($user->email_verified_at)){
        if($user->email_verified_at != null){
            return redirect()->route('customer.dashboard');
        }
    }
@endphp
<!-- Breadcrumbs -->
<div class="w-full bg-[#706233]/10 py-[15px]">
    <div class="!container px-6 mx-auto">
        <div class="flex items-center">
            <div class="grow">
                <nav>
                    <ol class="flex items-center">
                        <li class="list-unstyled"><a href="{{('home')}}">Home </a></li>
                        <li class="list-unstyled text-[#706233] ml-1" aria-current="page"> / Thank You</li>
                    </ol>
                </nav>
            </div>
            <div class="grow text-right">
                <h2 class="text-[16px] font-bold">Thank You</h2>
            </div>
        </div>
    </div>
</div>

<!-- Shopping Cart -->
<section class="py-[40px]">
    <div class="!container mx-auto px-6">
        <!-- Shopping Summery -->
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif
        @if ($message = Session::get('message'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif

        @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif
        <!--/ End Shopping Summery -->

    </div>
</section>
<!--/ End Shopping Cart -->
<div class="w-full bg-[#FCFDFC] py-[15px] mb-3">
    <div class="text-center">
        <h1 class="thankyou_text">Verification Email Has Been Sent. </h1>
        <h1 class="thankyou_text">If you do not see the mail in your inbox please check spam/junk folder.</h1>
        {{-- <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <input type="hidden" name="user_id" value="{{ session()->get('id') }}" />
            <button class="w-25 mt-3 p-[10px_30px] w-full rounded-full text-white bg-[#706233]" type="submit">Resend Email</button>
        </form> --}}
        <div class="mx-auto mb-1">
            <img src="/images/mail-download.gif" class="w-25 mx-auto mb-5">
        </div>
    </div>
</div>

@endsection
