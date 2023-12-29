@extends('frontend.layouts.master')
@section('title','Cart Page')
@section('main-content')

<!-- Breadcrumbs -->
<div class="w-full bg-[#ce1212]/10 py-[15px]">
    <div class="!container px-6 mx-auto">
        <div class="flex items-center">
            <div class="grow">
                <nav>
                    <ol class="flex items-center">
                        <li class="list-unstyled"><a href="{{('home')}}">Home </a></li>
                        <li class="list-unstyled text-[#ce1212] ml-1" aria-current="page"> / Thank You</li>
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
<div class="w-full bg-[#fff]/10 py-[15px] mb-3">
    <div class="text-center">
        <h1 class="thankyou_text">Your Order Has Been Placed. Thank You. Check Your Orders <a href="customer/orders">'here'</a></h1>
        <div class="mx-auto mb-1">
            <img src="/images/thumbs-up-nice.gif" class="mx-auto mb-5">
        </div>
    </div>
</div>
	
@endsection