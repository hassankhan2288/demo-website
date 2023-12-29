@extends('frontend.layouts.master')
@section('title','Cater-Choice || Register Page')
@section('main-content')
{{-- <script src="https://cdn.getaddress.io/scripts/getaddress-location-1.0.0.min.js"></script> --}}
<script src="https://cdn.getaddress.io/scripts/getaddress-autocomplete-1.0.24.min.js"></script>
<main>
    <div class="w-full bg-[#ce1212]/10 py-[15px]">
		<div class="containe px-6">
			<div class="flex items-center">
				<div class="grow">
					<nav>
						<ol class="flex items-center">
							<li class="list-unstyled"><a href="/">Home </a></li>
							<li class="list-unstyled text-[#ce1212] ml-1" aria-current="page"> / {{ __('Register') }}</li>
						</ol>
					</nav>
				</div>
				<div class="grow text-right">
                    <h2 class="text-[16px] font-bold">{{ __('Register') }}</h2>
				</div>
			</div>
		</div>
	</div>
    <div class="container px-6">
        <div class="flex flex-wrap justify-center py-[40px]">
            <div class="sm:w-[400px] w-full mx-auto mt-[25px] mb-[50px] shadow-[0px_15px_66px_5px_#d9d9d9cc] p-[30px]">
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
                <h1 class="mb-3 text-[20px] font-bold">{{ __('Register') }}</h1>
                    {{-- <p><strong>Registration is Not available at the moment</strong></p> --}}
               <p class="mb-[15px] mr-[16px]">Please fill in the information below</p>

               <form method="POST" action="{{ route('customer.post.register') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-[20px]">
                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input name="profile_image" type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                                <label for="imageUpload"></label>
                            </div>
                            <div class="avatar-preview">
                                <div id="imagePreview" style="background-image: url('https://cater-choice-assets.s3.eu-west-2.amazonaws.com/storage/default-avatar-profile.jpg');">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-[20px]">
                        <input id="name" type="text" placeholder="Name" class="p-[8px_15px] rounded-[4px] !border !border-[#ce1212]/10 w-full focus:border-[#ce1212]/30 focus-visible:!border-[#ce1212]/30 focus-visible:outline-0 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="text-red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-[20px]">
                        <input id="email" type="email" placeholder="Email Address" class="p-[8px_15px] rounded-[4px] !border !border-[#ce1212]/10 w-full focus:border-[#ce1212]/30 focus-visible:!border-[#ce1212]/30 focus-visible:outline-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="text-red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-[20px]">
                        <input id="business_name" type="text" placeholder="Business Name" class="p-[8px_15px] rounded-[4px] !border !border-[#ce1212]/10 w-full focus:border-[#ce1212]/30 focus-visible:!border-[#ce1212]/30 focus-visible:outline-0 @error('business_name') is-invalid @enderror" name="business_name" value="{{ old('business_name') }}" required>

                        @error('business_name')
                            <span class="text-red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-[20px]">
                        <select name="business_type" class="p-[8px_15px] rounded-[4px] !border !border-[#ce1212]/10 w-full focus:border-[#ce1212]/30 focus-visible:!border-[#ce1212]/30 focus-visible:outline-0 " required placeholder="Business Type">
                            <option selected="" disabled="" hidden="" value="">Select a business type</option>
                            <optgroup label="Business">
                               <option value="Office Canteen" @if (old('business_type') == 'Office Canteen') selected="selected" @endif >Office Canteen</option>
                               <option value="Wholesaler" @if (old('business_type') == 'Wholesaler') selected="selected" @endif >Wholesaler</option>
                            </optgroup>
                            <optgroup label="Education">
                               <option value="Independent School" @if (old('business_type') == 'Independent School') selected="selected" @endif >Independent School</option>
                            </optgroup>
                            <optgroup label="Health & Care">
                               <option value="Care/Nursing Homes" @if (old('business_type') == 'Care/Nursing Homes') selected="selected" @endif >Care/Nursing Homes</option>
                            </optgroup>
                            <optgroup label="Hotel">
                               <option value="Hotel" @if (old('business_type') == 'Hotel') selected="selected" @endif >Hotel</option>
                            </optgroup>
                            <optgroup label="Quick Service">
                               <option value="Cafe" @if (old('business_type') == 'Cafe') selected="selected" @endif >Cafe</option>
                               <option value="Fast Food Takeaway" @if (old('business_type') == 'Fast Food Takeaway') selected="selected" @endif >Fast Food Takeaway</option>
                               <option value="Chinese Takeaway" @if (old('business_type') == 'Chinese Takeaway') selected="selected" @endif >Chinese Takeaway</option>
                               <option value="Sandwich Bar & Deli" @if (old('business_type') == 'Sandwich Bar & Deli') selected="selected" @endif >Sandwich Bar &amp; Deli</option>
                               <option value="Mobile Van" @if (old('business_type') == 'Mobile Van') selected="selected" @endif >Mobile Van</option>
                            </optgroup>
                            <optgroup label="Restaurant">
                               <option value="Burger Restaurant" @if (old('business_type') == 'Burger Restaurant') selected="selected" @endif >Burger Restaurant</option>
                               <option value="Chicken Restaurant" @if (old('business_type') == 'Chicken Restaurant') selected="selected" @endif >Chicken Restaurant</option>
                               <option value="Fish & Chips Restaurant" @if (old('business_type') == 'Fish & Chips Restaurant') selected="selected" @endif >Fish & Chips Restaurant</option>
                               <option value="Indian Restaurant" @if (old('business_type') == 'Indian Restaurant') selected="selected" @endif >Indian Restaurant</option>
                               <option value="Kebab Restaurant" @if (old('business_type') == 'Kebab Restaurant') selected="selected" @endif >Kebab Restaurant</option>
                               <option value="Pizza Restaurant" @if (old('business_type') == 'Pizza Restaurant') selected="selected" @endif >Pizza Restaurant</option>
                               <option value="General Restaurant" @if (old('business_type') == 'General Restaurant') selected="selected" @endif >General Restaurant</option>
                               <option value="Turkish Restaurant" @if (old('business_type') == 'Turkish Restaurant') selected="selected" @endif >Turkish Restaurant</option>
                            </optgroup>
                            <optgroup label="Shop">
                               <option value="Bakery" @if (old('business_type') == 'Bakery') selected="selected" @endif >Bakery</option>
                               <option value="Butcher" @if (old('business_type') == 'Butcher') selected="selected" @endif >Butcher</option>
                               <option value="Supermarket" @if (old('business_type') == 'Supermarket') selected="selected" @endif >Supermarket</option>
                            </optgroup>
                            <optgroup label="Travel & Leisure">
                               <option value="Event Catering" @if (old('business_type') == 'Event Catering') selected="selected" @endif >Event Catering</option>
                            </optgroup>
                            <optgroup label="Other">
                               <option value="Consumer" @if (old('business_type') == 'Consumer') selected="selected" @endif >Consumer</option>
                               <option value="Theme Park" @if (old('business_type') == 'Theme Park') selected="selected" @endif >Theme Park</option>
                            </optgroup>
                        </select>
                         @error('business_type')
                             <span class="text-red" role="alert">
                                 <strong>{{ $message }}</strong>
                             </span>
                         @enderror
                    </div>

                    <div class="mb-[20px]">
                        <input id="postcode" type="text" placeholder="Postcode" class="p-[8px_15px] rounded-[4px] !border !border-[#ce1212]/10 w-full focus:border-[#ce1212]/30 focus-visible:!border-[#ce1212]/30 focus-visible:outline-0 @error('postcode') is-invalid @enderror" name="postcode" value="{{ old('postcode') }}" required autocomplete="Postcode">
                        @error('postcode')
                            <span class="text-red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-[20px]">
                        <input id="address" maxlength="50" type="text" placeholder="Address" class="p-[8px_15px] rounded-[4px] !border !border-[#ce1212]/10 w-full focus:border-[#ce1212]/30 focus-visible:!border-[#ce1212]/30 focus-visible:outline-0 @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="Address">
                        @error('address')
                            <span class="text-red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-[20px]">
                        <input id="address_2" maxlength="50" type="text" placeholder="Address 2" class="p-[8px_15px] rounded-[4px] !border !border-[#ce1212]/10 w-full focus:border-[#ce1212]/30 focus-visible:!border-[#ce1212]/30 focus-visible:outline-0 @error('address') is-invalid @enderror" name="address_2" value="{{ old('address_2') }}" required autocomplete="Address 2">
                        @error('address_2')
                            <span class="text-red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-[20px]">
                        <input id="city" type="text" placeholder="City" class="p-[8px_15px] rounded-[4px] !border !border-[#ce1212]/10 w-full focus:border-[#ce1212]/30 focus-visible:!border-[#ce1212]/30 focus-visible:outline-0 @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="City">
                        @error('city')
                        <span class="text-red" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-[20px]">
                        <input id="phone_number" type="number" placeholder="Phone Number" class="p-[8px_15px] rounded-[4px] !border !border-[#ce1212]/10 w-full focus:border-[#ce1212]/30 focus-visible:!border-[#ce1212]/30 focus-visible:outline-0 @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" min="11" required autocomplete="Phone">

                        @error('phone_number')
                            <span class="text-red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-[20px]">
                        <label for="warehouse">{{ __('Location') }}</label>
                        <select name="warehouse" class="p-[8px_15px] rounded-[4px] !border !border-[#ce1212]/10 w-full focus:border-[#ce1212]/30 focus-visible:!border-[#ce1212]/30 focus-visible:outline-0 @error('warehouse') is-invalid @enderror" required>
                            <option value="">Select Location</option>
                            @foreach ($warehouse as $warehouses)
                                @if (old('warehouse') == $warehouses->id)
                                    <option value="{{ $warehouses->id }}" selected>{{$warehouses->title}}</option>
                                @else
                                <option value="{{ $warehouses->id }}">{{$warehouses->title}}</option>
                                @endif
                                {{-- <option value="{{$warehouses->id}}">{{$warehouses->title}}</option> --}}
                            @endforeach
                        </select>
                        @error('warehouse')
                            <span class="text-red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-[20px]">
                        <label for="checkout_preference">{{ __('Checkout Preference') }}</label>
                        <select name="checkout_preference" class="p-[8px_15px] rounded-[4px] !border !border-[#ce1212]/10 w-full focus:border-[#ce1212]/30 focus-visible:!border-[#ce1212]/30 focus-visible:outline-0 @error('checkout_preference') is-invalid @enderror" required>
                            <option value="">Select Checkout Preference</option>
                            <option value="pickup" @if (old('checkout_preference') == 'pickup') selected="selected" @endif >Self Pickup</option>

                        </select>
                        @error('checkout_preference')
                            <span class="text-red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-[20px]">
                        <input id="password" type="password" placeholder="Password" class="p-[8px_15px] rounded-[4px] !border !border-[#ce1212]/10 w-full focus:border-[#ce1212]/30 focus-visible:!border-[#ce1212]/30 focus-visible:outline-0 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        <small>Password must be atleast 8 characters with 1 uppercase & Symbol value.</small>
                        @error('password')
                            <span class="text-red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span
                        @enderror
                    </div>
                    <div class="mb-[20px]">
                        <input id="password-confirm" type="password" placeholder="Confirm Password" class="p-[8px_15px] rounded-[4px] !border !border-[#ce1212]/10 w-full focus:border-[#ce1212]/30 focus-visible:!border-[#ce1212]/30 focus-visible:outline-0" name="password_confirmation" required autocomplete="new-password">
                    </div>
                    <div class="mb-[20px]">
                        <span  id="password_message"></span>
                    </div>
                    <button class="p-[10px_30px] w-full rounded-full text-white bg-[#ce1212]" id="RegisterButton">{{ __('Register') }}</button>
                    <div class="text-center mt-[15px]">
                        <a href="{{ route('customer.login') }}" class="text-[16px] hover:text-[#ce1212]"> Back to login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('frontend/footer');

 @endsection
