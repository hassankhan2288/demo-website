@extends('frontend.layouts.master')
@section('title','Cater-Choice || Customer Main Page')
@section('main-content')

<main>
  <!-- Breadcrumbs -->
  <div class="w-full bg-[#706233]/10 py-[15px]">
		<div class="!container px-6 mx-auto">
			<div class="flex items-center">
				<div class="grow">
					<nav>
						<ol class="flex items-center">
							<li class="list-unstyled"><a href="{{route('home')}}">Home </a></li>
							<li class="list-unstyled text-[#706233] ml-1" aria-current="page"> / Dashboard</li>
						</ol>
					</nav>
				</div>
				<div class="grow text-right">
          <h2 class="text-[16px] font-bold">Dashboard</h2>
				</div>
			</div>
		</div>
	</div>
  <!-- End Breadcrumbs -->

  <section class="py-[40px]">
    <div class="!container px-6 mx-auto">
      <div class="grid md:grid-cols-12 grid-cols-1 gap-4">
        <div class="lg:col-span-3 md:col-span-4">
          <div class="bg-white !border !border-[#706233]/10 rounded-[5px] overflow-hidden">
            <a href="{{route('customer.dashboard')}}" class="bg-[#706233] text-white p-[15px] block border-b"> <i class="fa fa-tachometer text-[16px] mr-[5px]"></i>  Dashboard</a>
            <a href="{{route('customer.profile')}}" class="bg-white p-[15px] block border-b"> <i class="fa fa-user text-[16px] mr-[5px]"></i>   Profile</a>
            <a href="{{route('customer.orders')}}" class="bg-white p-[15px] block border-b"> <i class="fa fa-table text-[16px] mr-[5px]"></i>  Orders</a>
            {{-- <a href="{{ route('customer.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="bg-white p-[15px] block"> <i class="fa fa-sign-in text-[16px] mr-[5px]"></i> {{ __('Logout') }}</a> --}}
            <a href="{{ route('customer.logout') }}" class="bg-white p-[15px] block"> <i class="fa fa-sign-in text-[16px] mr-[5px]"></i> {{ __('Logout') }}</a>
            <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </div>
        </div>

        <!-- Home Section Starts Here-->
          <div class="lg:col-span-9 md:col-span-8">
            <div class="bg-white !border !border-[#706233]/10 rounded-[5px] p-[20px]">
              <ul>
                <li class="">
                  <div class="float-left avatar-upload mr-5">
                    <div class="avatar-edit">
                        <input name="profile_image" type="file" id="imageUpload" accept=".png, .jpg, .jpeg">   
                    </div>
                    <div class="avatar-preview">
                        <div id="imagePreview" style="background-image: url('{{ image_url($user->profile_image) }}');">
                        </div>
                    </div>
                  </div>
                </li>
                <li class="p-[10px]"><strong>Name:</strong> {{Auth::user()->name}}</li>
                <li class="p-[10px]"><strong>Email-Id:</strong> {{Auth::user()->email}}</li>
                <li class="p-[10px]">
                  <strong>Address:</strong>
                  {{Auth::guard('customer')->user()->address}},
                  {{-- {{Auth::guard('customer')->user()->address2}}, --}}
                  {{Auth::guard('customer')->user()->city}} -
                  {{Auth::guard('customer')->user()->pincode}},
                  {{Auth::guard('customer')->user()->state}},
                  {{Auth::guard('customer')->user()->country}}
                </li>
                <li class="p-[10px]">
                  <strong>Mobile Number:</strong>{{Auth::user()->phone_number}}
                </li>
                <li class="p-[10px]">
                  <strong>Alternative Mobile No: </strong>{{Auth::user()->alternativemno}}
                  <a href="{{url('customer/profile')}}" class="btaobtn btaobtn-outline-dark p-2">Edit</a>
                </li>
              </ul>
              <div class="col-md-12 flex items-center">
                <a href="{{url('cart')}}" class="text-[#706233] hover:text-[#706233] text-[20px]">
                  <i class="fa fa-shopping-cart text-[#706233]"></i>
                  <span class="text-[20px] ml-1">Go to Cart</span>
                </a>
              </div>
            </div>
          </div>
          <!-- Home Section Ends Here-->
      </div>
    </div>
  </section>
</main>


@include('frontend/footer');

 @endsection
