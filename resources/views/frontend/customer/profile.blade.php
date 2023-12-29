@extends('frontend.layouts.master')
@section('title','Cater-Choice || Customer Profile Page')
@section('main-content')
<main>
  @if ($errors->any())
    <script>
      $(document).ready(function () {
        $('#centralModalfailure').modal('show');
      });
    </script>
  @endif
  @if (session('passwordwontmatch'))
    <script>
      $(document).ready(function () {
        alertify.set('notifier','position','top-right');
        alertify.alert("Warning","Password Wont Match");
      });
    </script>
  @endif
  @if (session('successstatus'))
    <script>
      $(document).ready(function () {
        $('#centralModalSuccess').modal('show');
      });
    </script>
  @endif


  <!-- Breadcrumbs -->
  <div class="w-full bg-[#ce1212]/10 py-[15px]">
		<div class="!container px-6 mx-auto">
			<div class="flex items-center">
				<div class="grow">
					<nav>
						<ol class="flex items-center">
							<li class="list-unstyled"><a href="{{route('home')}}">Home </a></li>
							<li class="list-unstyled text-[#ce1212] ml-1" aria-current="page"><a href="{{route('customer.dashboard')}}"> / Dashboard</a></li>
							<li class="list-unstyled text-[#ce1212] ml-1" aria-current="page"> / Profile</li>
						</ol>
					</nav>
				</div>
				<div class="grow text-right">
          <h2 class="text-[16px] font-bold">Profile</h2>
				</div>
			</div>
		</div>
	</div>
  <!-- End Breadcrumbs -->

  <section class="py-[40px]">
    <div class="!container px-6 mx-auto">
      <div class="grid md:grid-cols-12 grid-cols-1 gap-4">
        <div class="lg:col-span-3 md:col-span-4">
          <div class="bg-white !border !border-[#ce1212]/10 rounded-[5px] overflow-hidden">
            <a href="{{route('customer.dashboard')}}" class="bg-white p-[15px] block border-b"> <i class="fa fa-tachometer text-[16px] mr-[5px]"></i>  Dashboard</a>
            <a href="{{route('customer.profile')}}" class="bg-[#ce1212] text-white p-[15px] block border-b"> <i class="fa fa-user text-[16px] mr-[5px]"></i>   Profile</a>
            <a href="{{route('customer.orders')}}" class="bg-white p-[15px] block border-b"> <i class="fa fa-table text-[16px] mr-[5px]"></i>  Orders</a>
            <a href="{{ route('customer.logout') }}"  class="bg-white p-[15px] block"> <i class="fa fa-sign-in text-[16px] mr-[5px]"></i> {{ __('Logout') }}</a>
            {{-- <a href="{{ route('customer.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="bg-white p-[15px] block"> <i class="fa fa-sign-in text-[16px] mr-[5px]"></i> {{ __('Logout') }}</a> --}}
            <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </div>
        </div>
        <!-- Home Section Starts Here-->
        <div class="lg:col-span-9 md:col-span-8">
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
          <div class="flex justify-between items-center mb-3">
            <h3 class="text-[18px] font-semibold">My Profile</h3>
            <p class="text-[14px] custom_time_profile"><strong>Account Created on: </strong>  <span>{{Auth::user()->created_at->diffForHumans()}}</span></p>
          </div>
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif
          <form action="{{url('customer/my-profile-update')}}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="bg-white !border !border-[#ce1212]/10 rounded-[5px] p-[15px]">
              <div class="w-100 m-auto mb-5">
                <div class="avatar-upload">
                  <div class="avatar-edit">
                      <input name="profile_image" type="file" id="imageUpload" accept=".png, .jpg, .jpeg">
                      <label for="imageUpload"></label>
                  </div>
                  <div class="avatar-preview">
                      <div id="imagePreview" style="background-image: url('{{ image_url(Auth::user()->profile_image) }}');">
                      </div>
                  </div>
                </div>
              </div>
              <div class="grid lg:grid-cols-2 grid-cols-1 gap-4">
                <div>
                  <label> Name</label>
                  <input type="text" value="{{Auth::user()->name}}" class="form-control" name="name">
                </div>
                <div>
                  <label> Email-Id</label>
                  <input type="text" value="{{Auth::user()->email}}" class="form-control" disabled >
                </div>
                <div>
                  <label> Phone Number</label>
                  <input type="number" value="{{Auth::user()->phone_number}}" class="form-control" name="phone_number">
                </div>
                <div>
                  <label> Postal Code</label>
                  <input id="postcode" type="text" value="{{$user->postal_code}}" class="form-control" name="postal_code">
                </div>
                <div>
                  <label> City</label>
                  <input id="city" type="text" value="{{Auth::user()->city}}" class="form-control" name="city">
                </div>
                <div class="mb-3">
                  <label> Warehouse</label>
                  <select name="warehouse" class="form-control @error('warehouse') is-invalid @enderror" >
                    <option >Select Location</option>
                    @foreach ($warehouses as $warehouse)
                    @if (Auth::user()->warehouse == $warehouse->id)
                      <option value="{{$warehouse->id}}" selected>{{$warehouse->title}}</option>
                    @else
                      <option value="{{$warehouse->id}}">{{$warehouse->title}}</option>
                    @endif
                    @endforeach
                  </select>
                </div>

                <div class="mb-3">
                  <label>Shipping Methods</label>
                  <select name="checkout_preference" class="form-control @error('checkout_preference') is-invalid @enderror" >

                    @if (\Auth::guard('customer')->user()->checkout_preference == "pickup")
                      <option selected value="pickup">Collection</option>
{{--                      <option value="delivery">Delivery</option>--}}
                    @else
                      <option  value="pickup">Collection</option>
{{--                      <option selected value="delivery">Delivery</option>--}}
                    @endif
                  </select>
                </div>
              </div>
              <div class="w-full py-2 text-right mt-3">
                <button type="submit" class="bg-[#198754] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold hover:opacity-80 cursor-pointer"> Update</button>
                <a data-bs-toggle="modal" data-bs-target="#openpasswordmodel" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold hover:opacity-80 cursor-pointer inline-block">Change Password</a>
              </div>
            </div>
            <div class="col-md-12 flex p-0 flex-column-mobile">
              <div class="col-md-6 p-0">
                <h3 class="text-[18px] font-semibold mb-3 mt-4">Billing Address</h3>
                <div class="bg-white !border !border-[#ce1212]/10 rounded-[5px] p-[15px]">
                  <div class="mb-3">
                    <label> Address</label>
                    <textarea id="address" name="address"  class="form-control">{{Auth::user()->address}}</textarea>
                  </div>

                  <div class="mb-3 text-right">
                    <button type="submit" class="bg-[#198754] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold hover:opacity-80 cursor-pointer">Update</button>
                  </div>
                </div>
              </div>
              <div class="col-md-6 p-0">
                <h3 class="text-[18px] font-semibold mb-3 mt-4">Shipping Address</h3>
                <div class="bg-white !border !border-[#ce1212]/10 rounded-[5px] p-[15px]">
                  <div class="mb-3">
                    <label > Address</label>
                    <textarea name="address_2"  class="form-control">{{$user->address_2}}</textarea>
                  </div>
                  <div class="mb-3 text-right">
                    <button type="submit" class="bg-[#198754] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold hover:opacity-80 cursor-pointer">Update</button>
                  </div>
                </div>
              </div>
            </div>
            @if (isset(Auth::user()->address_3))
              <div class="col-md-12 flex p-0">
                <div class="col-md-6 p-0">
                  <h3 class="text-[18px] font-semibold mb-3 mt-4">Shipping Address 2</h3>
                  <div class="bg-white !border !border-[#ce1212]/10 rounded-[5px] p-[15px]">
                    <div class="mb-3">
                      <label > Address</label>
                      <textarea name="address_3"  class="form-control">{{Auth::user()->address_3}}</textarea>
                    </div>
                    <div class="mb-3 text-right">
                      <button type="submit" class="bg-[#198754] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold hover:opacity-80 cursor-pointer">Update</button>
                    </div>
                  </div>
                </div>
              </div>
              @endif
          </form>
       </div>
      </div>
    </div>
  </section>
  <!-- Central Modal Medium Failure -->
  <div class="modal fade" id="centralModalfailure" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"aria-hidden="true">
    <div class="modal-dialog modal-notify modal-danger" role="document">
      <!--Content-->
      <div class="modal-content">
        <!--Header-->
        <div class="modal-header">
          <p class="heading lead">Error</p>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="white-text">&times;</span>
          </button>
        </div>

        <!--Body-->
        <div class="modal-body">
          <div class="text-center">
            <i class="fas fa-exclamation-circle fa-4x mb-3 animated rotateIn"></i>
            <h3 style="color: red"> Profile Not Updated </h3>
          <ul align="left"  >
                  @if($errors->any())
                    @foreach ($errors->all() as $error)

                              <li  class="text-danger">{{ $error }}</li>
                      @endforeach
                  @endif
              </ul>
              {{session('passwordwontmatch')}}
          </div>
        </div>

        <!--Footer-->
        <div class="modal-footer justify-content-center">
            <p   class="close" data-dismiss="modal" aria-label="Close"  >
          <button  class="btaobtn btaobtn-danger">Try Again<i class="far fa-gem ml-1 text-white"></i></button>
          </p>

        </div>
      </div>
      <!--/.Content-->
    </div>
  </div>
  <!-- Central Modal Medium Failure-->
  <!-- Central Modal Medium Success -->
  <div class="modal fade" id="centralModalSuccess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-notify modal-success" role="document">
      <!--Content-->
      <div class="modal-content">
        <!--Header-->
        <div class="modal-header">
          <p class="heading lead"> Success</p>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="white-text">&times;</span>
          </button>
        </div>

        <!--Body-->
        <div class="modal-body">
          <div class="text-center">
            <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
            <p>{{session('successstatus')}} </p>
          </div>
        </div>

        <!--Footer-->
        <div class="modal-footer justify-content-center">

          <a type="button" class="btn btn-outline-success waves-effect" data-dismiss="modal">Close</a>
        </div>
      </div>
      <!--/.Content-->
    </div>
  </div>
  <!-- Central Modal Medium Success-->
  <!--  Password Model Starts Here -->
  <form method="POST" action="{{url('customer/update-password')}}">
      @csrf
      <div class="modal fade" id="openpasswordmodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-notify modal-primary" role="document">
          <!--Content-->
          <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
              <p class="heading lead">Update Your Password</p>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="white-text">&times;</span>
              </button>
            </div>
            <!--Body-->
            <div class="modal-body">
              <div class="text-center">
                <i class="fa fa-lock fa-4x mb-3 animated rotateIn"></i>
                <input type="password" class="form-control" name="newpass" placeholder="Enter New Password"><br>
                <input type="password" class="form-control" name="confirm_new_Pass" placeholder="Re-Enter Password">
              </div>
            </div>
            <!--Footer-->
            <div class="modal-footer justify-content-center">
              <button type="submit" class="btn btn-success bg-[#198754] rounded-[50px] text-[14px] p-[11px_30px]" >Update</button>
            </div>
          </div>
          <!--/.Content-->
        </div>
      </div>
  <!-- Password Model Closed Here-->
  </form>
</main>
 @include('frontend/footer');

@endsection
