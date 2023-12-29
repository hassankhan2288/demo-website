@extends('frontend.layouts.master')

@section('title','Checkout page')

@section('main-content')
<main class="relative main_cart">
    <!-- Breadcrumbs -->
    <div class="w-full bg-[#706233]/10 py-[15px]">
		<div class="!container px-6 mx-auto">
			<div class="flex items-center">
				<div class="grow">
					<nav>
						<ol class="flex items-center">
							<li class="list-unstyled"><a href="{{('home')}}">Home </a></li>
							<li class="list-unstyled text-[#706233] ml-1" aria-current="page"> / Checkout</li>
						</ol>
					</nav>
				</div>
				<div class="grow text-right">
                    <h2 class="text-[16px] font-bold">Checkout</h2>
				</div>
			</div>
		</div>
	</div>
    <!-- End Breadcrumbs -->

    <!-- Start Checkout -->
    <section class="py-[40px]">
        <div class="!container mx-auto px-6">
            @if (Session::has('error'))

            <div class="alert alert-danger mt-2">{{ Session::get('error') }}
            </div>

            @endif
            <form class="form" id="checkout_form" method="POST" action="{{route('cart.order')}}">
                @csrf
                <div class="grid lg:grid-cols-12 grid-cols-1 gap-4">

                    <div class="lg:col-span-8 ">
                        <div class="checkout-form">
                            <h2 class="text-[25px] font-bold !mb-3 delivery_section">Make Your Checkout Here</h2>
                            <p class="text-[15px] !mb-6 delivery_section">Please register in order to checkout more quickly</p>
                            <!-- Form -->
                            <div class="grid md:grid-cols-12 grid-cols-1 gap-4 delivery_section">
                                {{-- <div class="lg:col-span-6 md:col-span-6">
                                    <label>First Name<span>*</span></label>
                                    <input type="text" class="w-full !border !border-[#706233]/10 hover:border-[#706233]/50 !outline-0 rounded-[5px] p-[8px_15px]" name="first_name" placeholder="" value="{{old('first_name')}}" value="{{old('first_name')}}">
                                    @error('first_name')
                                        <span class='text-red'>{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="lg:col-span-6 md:col-span-6">
                                    <label>Last Name<span>*</span></label>
                                    <input type="text" class="w-full !border !border-[#706233]/10 hover:border-[#706233]/50 !outline-0 rounded-[5px] p-[8px_15px]" name="last_name" placeholder="" value="{{old('lat_name')}}">
                                    @error('last_name')
                                        <span class='text-red'>{{$message}}</span>
                                    @enderror
                                </div> --}}
                                <div class="lg:col-span-6 md:col-span-6">
                                    <label>Email Address<span>*</span></label>
                                    <input type="email" class="w-full !border !border-[#706233]/10 hover:border-[#706233]/50 !outline-0 rounded-[5px] p-[8px_15px]" name="email" placeholder="" value="{{isset($user->email) ? $user->email : ''}}">

                                    @error('email')
                                        <span class='text-red'>{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="lg:col-span-6 md:col-span-6">
                                    <label>Phone Number <span>*</span></label>
                                    <input type="number" class="w-full !border !border-[#706233]/10 hover:border-[#706233]/50 !outline-0 rounded-[5px] p-[8px_15px]" name="phone" placeholder=""  value="{{isset($user->phone_number) ? $user->phone_number : ''}}">
                                    @error('phone')
                                        <span class='text-red'>{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="lg:col-span-6 md:col-span-6">
                                    <label>Country<span>*</span></label>
                                    <select name="country" class="w-full !border !border-[#706233]/10 hover:border-[#706233]/50 !outline-0 rounded-[5px] p-[8px_15px]" id="country">
                                        {{-- <option value="AF">Afghanistan</option>
                                        <option value="AX">Åland Islands</option>
                                        <option value="AL">Albania</option>
                                        <option value="DZ">Algeria</option>
                                        <option value="AS">American Samoa</option>
                                        <option value="AD">Andorra</option>
                                        <option value="AO">Angola</option>
                                        <option value="AI">Anguilla</option>
                                        <option value="AQ">Antarctica</option>
                                        <option value="AG">Antigua and Barbuda</option>
                                        <option value="AR">Argentina</option>
                                        <option value="AM">Armenia</option>
                                        <option value="AW">Aruba</option>
                                        <option value="AU">Australia</option>
                                        <option value="AT">Austria</option>
                                        <option value="AZ">Azerbaijan</option>
                                        <option value="BS">Bahamas</option>
                                        <option value="BH">Bahrain</option>
                                        <option value="BD">Bangladesh</option>
                                        <option value="BB">Barbados</option>
                                        <option value="BY">Belarus</option>
                                        <option value="BE">Belgium</option>
                                        <option value="BZ">Belize</option>
                                        <option value="BJ">Benin</option>
                                        <option value="BM">Bermuda</option>
                                        <option value="BT">Bhutan</option>
                                        <option value="BO">Bolivia</option>
                                        <option value="BA">Bosnia and Herzegovina</option>
                                        <option value="BW">Botswana</option>
                                        <option value="BV">Bouvet Island</option>
                                        <option value="BR">Brazil</option>
                                        <option value="IO">British Indian Ocean Territory</option>
                                        <option value="VG">British Virgin Islands</option>
                                        <option value="BN">Brunei</option>
                                        <option value="BG">Bulgaria</option>
                                        <option value="BF">Burkina Faso</option>
                                        <option value="BI">Burundi</option>
                                        <option value="KH">Cambodia</option>
                                        <option value="CM">Cameroon</option>
                                        <option value="CA">Canada</option>
                                        <option value="CV">Cape Verde</option>
                                        <option value="KY">Cayman Islands</option>
                                        <option value="CF">Central African Republic</option>
                                        <option value="TD">Chad</option>
                                        <option value="CL">Chile</option>
                                        <option value="CN">China</option>
                                        <option value="CX">Christmas Island</option>
                                        <option value="CC">Cocos [Keeling] Islands</option>
                                        <option value="CO">Colombia</option>
                                        <option value="KM">Comoros</option>
                                        <option value="CG">Congo - Brazzaville</option>
                                        <option value="CD">Congo - Kinshasa</option>
                                        <option value="CK">Cook Islands</option>
                                        <option value="CR">Costa Rica</option>
                                        <option value="CI">Côte d’Ivoire</option>
                                        <option value="HR">Croatia</option>
                                        <option value="CU">Cuba</option>
                                        <option value="CY">Cyprus</option>
                                        <option value="CZ">Czech Republic</option>
                                        <option value="DK">Denmark</option>
                                        <option value="DJ">Djibouti</option>
                                        <option value="DM">Dominica</option>
                                        <option value="DO">Dominican Republic</option>
                                        <option value="EC">Ecuador</option>
                                        <option value="EG">Egypt</option>
                                        <option value="SV">El Salvador</option>
                                        <option value="GQ">Equatorial Guinea</option>
                                        <option value="ER">Eritrea</option>
                                        <option value="EE">Estonia</option>
                                        <option value="ET">Ethiopia</option>
                                        <option value="FK">Falkland Islands</option>
                                        <option value="FO">Faroe Islands</option>
                                        <option value="FJ">Fiji</option>
                                        <option value="FI">Finland</option>
                                        <option value="FR">France</option>
                                        <option value="GF">French Guiana</option>
                                        <option value="PF">French Polynesia</option>
                                        <option value="TF">French Southern Territories</option>
                                        <option value="GA">Gabon</option>
                                        <option value="GM">Gambia</option>
                                        <option value="GE">Georgia</option>
                                        <option value="DE">Germany</option>
                                        <option value="GH">Ghana</option>
                                        <option value="GI">Gibraltar</option>
                                        <option value="GR">Greece</option>
                                        <option value="GL">Greenland</option>
                                        <option value="GD">Grenada</option>
                                        <option value="GP">Guadeloupe</option>
                                        <option value="GU">Guam</option>
                                        <option value="GT">Guatemala</option>
                                        <option value="GG">Guernsey</option>
                                        <option value="GN">Guinea</option>
                                        <option value="GW">Guinea-Bissau</option>
                                        <option value="GY">Guyana</option>
                                        <option value="HT">Haiti</option>
                                        <option value="HM">Heard Island and McDonald Islands</option>
                                        <option value="HN">Honduras</option>
                                        <option value="HK">Hong Kong SAR China</option>
                                        <option value="HU">Hungary</option>
                                        <option value="IS">Iceland</option>
                                        <option value="IN">India</option>
                                        <option value="ID">Indonesia</option>
                                        <option value="IR">Iran</option>
                                        <option value="IQ">Iraq</option>
                                        <option value="IE">Ireland</option>
                                        <option value="IM">Isle of Man</option>
                                        <option value="IL">Israel</option>
                                        <option value="IT">Italy</option>
                                        <option value="JM">Jamaica</option>
                                        <option value="JP">Japan</option>
                                        <option value="JE">Jersey</option>
                                        <option value="JO">Jordan</option>
                                        <option value="KZ">Kazakhstan</option>
                                        <option value="KE">Kenya</option>
                                        <option value="KI">Kiribati</option>
                                        <option value="KW">Kuwait</option>
                                        <option value="KG">Kyrgyzstan</option>
                                        <option value="LA">Laos</option>
                                        <option value="LV">Latvia</option>
                                        <option value="LB">Lebanon</option>
                                        <option value="LS">Lesotho</option>
                                        <option value="LR">Liberia</option>
                                        <option value="LY">Libya</option>
                                        <option value="LI">Liechtenstein</option>
                                        <option value="LT">Lithuania</option>
                                        <option value="LU">Luxembourg</option>
                                        <option value="MO">Macau SAR China</option>
                                        <option value="MK">Macedonia</option>
                                        <option value="MG">Madagascar</option>
                                        <option value="MW">Malawi</option>
                                        <option value="MY">Malaysia</option>
                                        <option value="MV">Maldives</option>
                                        <option value="ML">Mali</option>
                                        <option value="MT">Malta</option>
                                        <option value="MH">Marshall Islands</option>
                                        <option value="MQ">Martinique</option>
                                        <option value="MR">Mauritania</option>
                                        <option value="MU">Mauritius</option>
                                        <option value="YT">Mayotte</option>
                                        <option value="MX">Mexico</option>
                                        <option value="FM">Micronesia</option>
                                        <option value="MD">Moldova</option>
                                        <option value="MC">Monaco</option>
                                        <option value="MN">Mongolia</option>
                                        <option value="ME">Montenegro</option>
                                        <option value="MS">Montserrat</option>
                                        <option value="MA">Morocco</option>
                                        <option value="MZ">Mozambique</option>
                                        <option value="MM">Myanmar [Burma]</option>
                                        <option value="NA">Namibia</option>
                                        <option value="NR">Nauru</option>
                                        <option value="NP" selected="selected">Nepal</option>
                                        <option value="NL">Netherlands</option>
                                        <option value="AN">Netherlands Antilles</option>
                                        <option value="NC">New Caledonia</option>
                                        <option value="NZ">New Zealand</option>
                                        <option value="NI">Nicaragua</option>
                                        <option value="NE">Niger</option>
                                        <option value="NG">Nigeria</option>
                                        <option value="NU">Niue</option>
                                        <option value="NF">Norfolk Island</option>
                                        <option value="MP">Northern Mariana Islands</option>
                                        <option value="KP">North Korea</option>
                                        <option value="NO">Norway</option>
                                        <option value="OM">Oman</option>
                                        <option value="PK">Pakistan</option>
                                        <option value="PW">Palau</option>
                                        <option value="PS">Palestinian Territories</option>
                                        <option value="PA">Panama</option>
                                        <option value="PG">Papua New Guinea</option>
                                        <option value="PY">Paraguay</option>
                                        <option value="PE">Peru</option>
                                        <option value="PH">Philippines</option>
                                        <option value="PN">Pitcairn Islands</option>
                                        <option value="PL">Poland</option>
                                        <option value="PT">Portugal</option>
                                        <option value="PR">Puerto Rico</option>
                                        <option value="QA">Qatar</option>
                                        <option value="RE">Réunion</option>
                                        <option value="RO">Romania</option>
                                        <option value="RU">Russia</option>
                                        <option value="RW">Rwanda</option>
                                        <option value="BL">Saint Barthélemy</option>
                                        <option value="SH">Saint Helena</option>
                                        <option value="KN">Saint Kitts and Nevis</option>
                                        <option value="LC">Saint Lucia</option>
                                        <option value="MF">Saint Martin</option>
                                        <option value="PM">Saint Pierre and Miquelon</option>
                                        <option value="VC">Saint Vincent and the Grenadines</option>
                                        <option value="WS">Samoa</option>
                                        <option value="SM">San Marino</option>
                                        <option value="ST">São Tomé and Príncipe</option>
                                        <option value="SA">Saudi Arabia</option>
                                        <option value="SN">Senegal</option>
                                        <option value="RS">Serbia</option>
                                        <option value="SC">Seychelles</option>
                                        <option value="SL">Sierra Leone</option>
                                        <option value="SG">Singapore</option>
                                        <option value="SK">Slovakia</option>
                                        <option value="SI">Slovenia</option>
                                        <option value="SB">Solomon Islands</option>
                                        <option value="SO">Somalia</option>
                                        <option value="ZA">South Africa</option>
                                        <option value="GS">South Georgia</option>
                                        <option value="KR">South Korea</option>
                                        <option value="ES">Spain</option>
                                        <option value="LK">Sri Lanka</option>
                                        <option value="SD">Sudan</option>
                                        <option value="SR">Suriname</option>
                                        <option value="SJ">Svalbard and Jan Mayen</option>
                                        <option value="SZ">Swaziland</option>
                                        <option value="SE">Sweden</option>
                                        <option value="CH">Switzerland</option>
                                        <option value="SY">Syria</option>
                                        <option value="TW">Taiwan</option>
                                        <option value="TJ">Tajikistan</option>
                                        <option value="TZ">Tanzania</option>
                                        <option value="TH">Thailand</option>
                                        <option value="TL">Timor-Leste</option>
                                        <option value="TG">Togo</option>
                                        <option value="TK">Tokelau</option>
                                        <option value="TO">Tonga</option>
                                        <option value="TT">Trinidad and Tobago</option>
                                        <option value="TN">Tunisia</option>
                                        <option value="TR">Turkey</option>
                                        <option value="TM">Turkmenistan</option>
                                        <option value="TC">Turks and Caicos Islands</option>
                                        <option value="TV">Tuvalu</option>
                                        <option value="UG">Uganda</option>
                                        <option value="UA">Ukraine</option>
                                        <option value="AE">United Arab Emirates</option> --}}
                                        <option value="Uk" selected>United Kingdom</option>
                                        {{-- <option value="UY">Uruguay</option>
                                        <option value="UM">U.S. Minor Outlying Islands</option>
                                        <option value="VI">U.S. Virgin Islands</option>
                                        <option value="UZ">Uzbekistan</option>
                                        <option value="VU">Vanuatu</option>
                                        <option value="VA">Vatican City</option>
                                        <option value="VE">Venezuela</option>
                                        <option value="VN">Vietnam</option>
                                        <option value="WF">Wallis and Futuna</option>
                                        <option value="EH">Western Sahara</option>
                                        <option value="YE">Yemen</option>
                                        <option value="ZM">Zambia</option>
                                        <option value="ZW">Zimbabwe</option> --}}
                                    </select>
                                </div>
                                {{-- <div class="lg:col-span-6 md:col-span-6">
                                    <label>Address Line 2</label>
                                    <input type="text" class="w-full !border !border-[#706233]/10 hover:border-[#706233]/50 !outline-0 rounded-[5px] p-[8px_15px]" name="address2" placeholder="" value="{{old('address2')}}">
                                    @error('address2')
                                    <span class='text-red'>{{$message}}</span>
                                    @enderror
                                </div> --}}
                                <div class="lg:col-span-6 md:col-span-6">
                                    <label>Postal Code</label>
                                    <input type="text" class="w-full !border !border-[#706233]/10 hover:border-[#706233]/50 !outline-0 rounded-[5px] p-[8px_15px]" name="post_code" placeholder="" value="{{isset($user->postal_code) ? $user->postal_code : ''}}">
                                    @error('post_code')
                                        <span class='text-red'>{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="lg:col-span-6 md:col-span-6">
                                    <label>Shipping Address<span>*</span>
                                        <span class="custom_address_button" data-bs-toggle="modal" data-bs-target="#new_address_modal">@if (isset($user->address_3)) Edit Address + @else Add Other Address + @endif</span>
                                    </label>
                                    <textarea class="w-full !border !border-[#706233]/10 hover:border-[#706233]/50 !outline-0 rounded-[5px] p-[8px_15px]" name="address2" placeholder="">{{isset($user->address_2) ? $user->address_2 : ''}}</textarea>
                                    {{-- <input type="text" class="w-full !border !border-[#706233]/10 hover:border-[#706233]/50 !outline-0 rounded-[5px] p-[8px_15px]" name="address2" placeholder="" value="{{isset($user->address_2) ? $user->address_2 : ''}}"> --}}
                                    @error('address1')
                                        <span class='text-red'>{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="lg:col-span-6 md:col-span-6 insert_after_here">
                                    <label>Billing Address<span>*</span></label>
                                    <textarea class="w-full !border !border-[#706233]/10 hover:border-[#706233]/50 !outline-0 rounded-[5px] p-[8px_15px]" name="address1" placeholder="">{{isset($user->address) ? $user->address : ''}}</textarea>
                                    {{-- <input type="text" class="w-full !border !border-[#706233]/10 hover:border-[#706233]/50 !outline-0 rounded-[5px] p-[8px_15px]" name="address1" placeholder="" value="{{isset($user->address) ? $user->address : ''}}"> --}}
                                    @error('address1')
                                        <span class='text-red'>{{$message}}</span>
                                    @enderror
                                </div>
                                @if (isset($user->address_3))
                                <div class="lg:col-span-6 md:col-span-6 red_border_shine">
                                    <label>Shipping Address 2<span>*</span></label>
                                    <label id="delete_dom">x</label>
                                    <textarea class="w-full !border !border-[#706233]/10 hover:border-[#706233]/50 !outline-0 rounded-[5px] p-[8px_15px] disabled newAddress" name="address3" id="dynamic_textarea" placeholder="" readonly="">{{isset($user->address_3) ? $user->address_3 : ''}}</textarea>
                                </div>
                                @endif




                            </div>
                            <input type="hidden" name="warehouse_id" id="warehouse_id" value="{{ $warehouse_id }}"/>
                            <div class="lg:col-span-12 md:col-span-12 !mt-6 pickup_section">
                                <div class="lg:col-span-6 md:col-span-6 pickup_timer">
                                    <label>Pickup Date</label>
                                    <input type="text" class="w-full !border !border-[#706233]/10 hover:border-[#706233]/50 !outline-0 rounded-[5px] p-[8px_15px]" id="date" name="pick_date" placeholder="" min="<?php echo date("Y-m-d"); ?>">
                                    @error('pick_date')
                                        <span class='text-red'>{{$message}}</span>
                                    @enderror
                                </div>
                                <label class="text-[20px] font-semibold !mb-4">Pickup Time</label>
                                <p id="slots_description">Please select pickup date to get slots</p>
                                <div class="slots_container_hm grid xl:grid-cols-6 lg:grid-cols-5 md:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-4" id="slots-container">
                                </div>
                              </div>
                            {{-- <div class="lg:col-span-12 md:col-span-12 !mt-6">
                                <label class="text-[20px] font-semibold !mb-4">Pickup Time</label>
                                <div class="grid xl:grid-cols-6 lg:grid-cols-5 md:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-4">
                                    @foreach ($slots as $key => $slot)
                                    <div class="flex items-center">
                                        <label class="flex items-center cursor-pointer relative text-black text-[16px] p-[15px] !border !border-[#706233] rounded-[4px]" for="flexRadioDefault2{{$key}}" value="{{$slot}}">
                                            <input class="absolute opacity-0 z-[0] peer" type="radio" id="flexRadioDefault2{{$key}}" name="pick_time" />
                                            <span class="peer-checked:bg-[#706233] shadow-[inset_0px_0px_0px_3px_white] border-2 border-[#706233] w-[18px] h-[18px] inline-block mr-2 rounded-full shrink-0 z-[10]"></span>
                                            {{ $slot }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div> --}}

                            <!--/ End Form -->
                        </div>
                    </div>
                    <div class="lg:col-span-4 ">
                        <div class="bg-white !border !border-[#706233]/10 rounded-[5px] p-[20px]">
                            @php
                                $total_amount=Helper::totalCartPrice();
                                $amount_on_delivery = $total_amount;
                            @endphp
                            <!-- Order Widget -->
                            <h2 class="text-[18px] font-semibold my-4">Shipping Methods</h2>
                            <div class="flex flex-col gap-3">
                                {{-- <label class="flex items-center cursor-pointer relative text-black text-[16px] delivery_option" for="cod">
                                    <input name="payment_method" id="cod" class="absolute opacity-0 z-[0] peer" type="radio" value="cod" required />
                                    <span class="peer-checked:bg-[#706233] shadow-[inset_0px_0px_0px_3px_white] border-2 border-[#706233] w-[18px] h-[18px] inline-block mr-2 rounded-full shrink-0 z-[10]"></span>
                                    Delivery (Total: £{{ $amount_on_delivery }})
                                </label>
                                <label class="flex items-center cursor-pointer relative text-black text-[16px] selfpickup_option" for="self">
                                    <input name="payment_method" id="self" class="absolute opacity-0 z-[0] peer" type="radio" value="self" checked="checked" />
                                    <span class="peer-checked:bg-[#706233] shadow-[inset_0px_0px_0px_3px_white] border-2 border-[#706233] w-[18px] h-[18px] inline-block mr-2 rounded-full shrink-0 z-[10]"></span>
                                    Self Pick (Total: £{{ $total_amount }})
                                </label> --}}
                                <label class="flex items-center cursor-pointer relative text-black text-[16px] delivery_option" for="cod">
                                    <input name="payment_method" id="cod" class="absolute opacity-0 z-[0] peer" type="radio" value="cod" required />
                                    <span class="peer-checked:bg-[#706233] shadow-[inset_0px_0px_0px_3px_white] border-2 border-[#706233] w-[18px] h-[18px] inline-block mr-2 rounded-full shrink-0 z-[10]"></span>
                                    Delivery
                                </label>
                                <label class="flex items-center cursor-pointer relative text-black text-[16px] selfpickup_option" for="self">
                                    <input name="payment_method" id="self" class="absolute opacity-0 z-[0] peer" type="radio" value="self" checked="checked" />
                                    <span class="peer-checked:bg-[#706233] shadow-[inset_0px_0px_0px_3px_white] border-2 border-[#706233] w-[18px] h-[18px] inline-block mr-2 rounded-full shrink-0 z-[10]"></span>
                                    Self Pick
                                </label>
                            </div>
                            <!--/ End Order Widget -->
                            <!-- Order Widget -->
                            <div class="single-widget">
                                <h2 class="text-[18px] font-semibold mb-[5px] my-4">CART TOTALS</h2>
                                <ul class="mt-3">
                                    <li class="flex items-center justify-between border-b py-[10px]" data-price="{{Helper::totalCartPrice()}}">Cart Subtotal<span>£{{number_format(Helper::totalCartPrice(),2)}}</span></li>
                                    {{-- <li class="flex items-center justify-between border-b py-[10px] hide show_on_delivery">
                                        Shipping Cost
                                        @if(count(Helper::shipping())>0 && Helper::cartCount()>0)
                                            <select name="shipping" class="nice-select">
                                                <option value="">Select your address</option>
                                                @foreach(Helper::shipping() as $shipping)
                                                <option value="{{$shipping->id}}" class="shippingOption" data-price="{{$shipping->price}}">{{$shipping->type}}: £{{$shipping->price}}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <span>Free</span>
                                        @endif
                                    </li> --}}
                                    <input type="hidden" value="{{ number_format(Helper::getDeliveryCharges(\Auth::guard('customer')->user()->id, \Auth::guard('customer')->user()->warehouse),2) }}" id="delivery_charges_input"/>
                                    <input type="hidden" value="{{number_format(Helper::totalCartPrice(),2)}}" id="without_delivery"/>
                                    <li class="flex items-center justify-between border-b py-[10px] hide show_on_delivery">
                                        Delivery Charges
                                        @if (!Helper::getDeliveryCharges(\Auth::guard('customer')->user()->id, \Auth::guard('customer')->user()->warehouse))
                                            <span>Free</span>
                                        @else
                                            <span>£{{ Helper::getDeliveryCharges(\Auth::guard('customer')->user()->id, \Auth::guard('customer')->user()->warehouse) }}</span>
                                        @endif

                                    </li>

                                    <li class="flex items-center justify-between border-b py-[10px]  delivery_additional">Grand Total <span>£{{number_format(Helper::totalCartPrice(),2)}}</span></li>
                                    @if(session('coupon'))
                                    <li class="flex items-center justify-between border-b py-[10px]" data-price="{{session('coupon')['value']}}">You Save<span>£{{number_format(session('coupon')['value'],2)}}</span></li>
                                    @endif
                                    @php

                                        $delivery_charges = Helper::getDeliveryCharges(\Auth::guard('customer')->user()->id, \Auth::guard('customer')->user()->warehouse);
                                        if($delivery_charges){
                                            $amount_on_delivery = $total_amount + $delivery_charges;
                                        }
                                        if(session('coupon')){
                                            $total_amount=$total_amount-session('coupon')['value'];
                                        }
                                    @endphp
                                    @if(session('coupon'))
                                        <li class="flex items-center justify-between border-b py-[10px] d-none"  id="order_total_price">Total<span>£{{number_format($total_amount,2)}}</span></li>
                                    @else
                                        <li class="flex items-center justify-between border-b py-[10px] d-none"  id="order_total_price">Total<span>£{{number_format($total_amount,2)}}</span></li>
                                    @endif
                                </ul>
                            </div>
                            <!--/ End Order Widget -->
                            <button type="submit" class="bg-[#706233] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold w-full mt-6 " style="display: none;" id="proceed_to_checkout">proceed to checkout</button>
                            <span id="proceed_payment" class="bg-[#706233] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold w-full mt-6">Proceed To Checkout</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!--/ End Checkout -->
    <!-- PAYEMNT SECTION -->
    <div class="custom_spinner">
        <div class="spinner_div">
            <div class="spinner-border" aria-hidden="true" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div class="error_section ">
            <p class="danger p-[8px_15px]"></p>
        </div>
    </div>

    <div class="payment_section ">
        <div id="demo-payment"></div>
        <div id="errors"></div>
        {{-- <button id="testPay" class="btn-primary btn pull-right"
                data-loading-text="Processing...">Pay</button> --}}
        <div id="demo-result" style="display: none">
            <h5>Payment Complete</h5>
            <dl>
                <dt>Status Code</dt>
                <dd id="status-code"></dd>
                <dt>Auth Code</dt>
                <dd id="auth-code"></dd>
            </dl>
        </div>
        {{-- <script src="https://web.e.test.connect.paymentsense.cloud/assets/js/checkout.js"></script> --}}
        <div id="paymentFormContainer">

        </div>

    </div>
    <!--/ PAYEMNT SECTION -->


    <!-- Modal -->
    <div class="modal fade" id="new_address_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="new_address_modalLabel">Shipping Address 2</h1>
            <button type="button" class="btn-close bg-[#706233] text-white" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <input class="mb-2 w-full !border !border-[#706233]/10 hover:border-[#706233]/50 !outline-0 rounded-[5px] p-[8px_15px]" id="apartment" placeholder="Apartment#\House#"/>
                <input class="mb-2 w-full !border !border-[#706233]/10 hover:border-[#706233]/50 !outline-0 rounded-[5px] p-[8px_15px]" id="street" placeholder="Street"/>
                <input class="mb-2 w-full !border !border-[#706233]/10 hover:border-[#706233]/50 !outline-0 rounded-[5px] p-[8px_15px]" id="address_modal" placeholder="Address"/>
            </div>
            <div class="modal-footer">
            <button id="change_shipping" type="button" class="bg-[#706233] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold w-full mt-6">Save changes</button>
            </div>
        </div>
        </div>
    </div>
    <!-- Modal END -->

</main>

    <script>
        var array = <?php echo json_encode($leave_date); ?>
        // $(document).ready(function() {
            // $( "#date" ).datepicker();
            // $('#date').datepicker({
            //     beforeShowDay: function(date){
            //         var string = jQuery.datepicker.formatDate('dd-mm-yyyy', date);
            //         return [ array.indexOf(string) == -1 ]
            //     }
            // format: 'dd-mm-yyyy',
            // }).on('changeDate', function(e) {
            //     $.ajax({
            //         type: "POST",
            //         url: "/process_date",
            //         data: {
            //             date: e.date.toString(),
            //         },
            //         success: function(result) {
            //             console.log(result);
            //         },
            //         error: function (error) {
            //             console.log(error);
            //         }
            //     });
            // });
        // });
    </script>
@endsection
