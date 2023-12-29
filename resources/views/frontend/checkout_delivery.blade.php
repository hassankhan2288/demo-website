@extends('frontend.layouts.master')

@section('title','Checkout page')

@section('main-content')
<main class="relative main_cart">
    <!-- Breadcrumbs -->
    <input type="hidden" id="env_variable" value="{{ $env }}" />
    <input type="hidden" id="env_url" value="{{ $url }}" />
    <input type="hidden" id="user_id" value="{{ $user->ms_number }}" />
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
            <form class="form" id="checkout_form" method="POST" action="{{route('checkout.delivery')}}">
                {{-- <form class="form" id="checkout_form" method="POST" action="{{route('cart.order')}}"> --}}
                {{-- <form class="form" id="checkout_form" method="POST" action="{{route('payment')}}"> --}}
                @csrf
                <div class="grid lg:grid-cols-12 grid-cols-1 gap-4">

                    <div class="lg:col-span-8 ">
                        <div class="checkout-form">
                            <h2 class="text-[25px] font-bold !mb-3">Make Your Checkout Here</h2>
                            <p class="text-[15px] !mb-6 ">Please register in order to checkout more quickly</p>
                            <!-- Form -->
                            <div class="grid md:grid-cols-12 grid-cols-1 gap-4 ">
                                <input type="hidden" value="delivery" name="payment_method"/>
                                <input type="hidden" value="delivery" name="checkout_preference"/>
                                <input type="hidden" value="card" name="paid_by" />

                                <div class="lg:col-span-6 md:col-span-6">
                                    <label>Email Address<span>*</span></label>
                                    <input type="email" class="w-full !border !border-[#706233]/10 hover:border-[#706233]/50 !outline-0 rounded-[5px] p-[8px_15px]" name="email" required placeholder="" value="{{isset($user->email) ? $user->email : ''}}">

                                    @error('email')
                                        <span class='text-red'>{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="lg:col-span-6 md:col-span-6">
                                    <label>Phone Number <span>*</span></label>
                                    <input type="number" class="w-full !border !border-[#706233]/10 hover:border-[#706233]/50 !outline-0 rounded-[5px] p-[8px_15px]" name="phone" required placeholder=""  value="{{isset($user->phone_number) ? $user->phone_number : ''}}">
                                    @error('phone')
                                        <span class='text-red'>{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="lg:col-span-6 md:col-span-6">
                                    <label>Country<span>*</span></label>
                                    <select name="country" class="w-full !border !border-[#706233]/10 hover:border-[#706233]/50 !outline-0 rounded-[5px] p-[8px_15px]" id="country" required>
                 
                                        <option value="Uk" selected>United Kingdom</option>
                                     
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
                                    <input type="text" class="w-full !border !border-[#706233]/10 hover:border-[#706233]/50 !outline-0 rounded-[5px] p-[8px_15px]" name="post_code" required placeholder="" value="{{isset($user->postal_code) ? $user->postal_code : ''}}">
                                    @error('post_code')
                                        <span class='text-red'>{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="lg:col-span-6 md:col-span-6">
                                    <label>Shipping Address<span>*</span>
                                        <span class="custom_address_button" data-bs-toggle="modal" data-bs-target="#new_address_modal">@if (isset($user->address_3)) Edit Address + @else Add Other Address + @endif</span>
                                    </label>
                                    @php
                                        if(!isset($user->address_2))
                                        {
                                            $shippingadd = $user->address;
                                        }else{
                                            $shippingadd = $user->address_2;
                                        }
                                            @endphp
                                    <textarea class="w-full !border !border-[#706233]/10 hover:border-[#706233]/50 !outline-0 rounded-[5px] p-[8px_15px]" name="address2"  placeholder="" required>{{$shippingadd}}</textarea>
                                    {{-- <input type="text" class="w-full !border !border-[#706233]/10 hover:border-[#706233]/50 !outline-0 rounded-[5px] p-[8px_15px]" name="address2" placeholder="" value="{{isset($user->address_2) ? $user->address_2 : ''}}"> --}}
                                    @error('address1')
                                        <span class='text-red'>{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="lg:col-span-6 md:col-span-6 insert_after_here">
                                    <label>Billing Address<span>*</span></label>
                                    <textarea id="billingaddress" maxlength="50" class="w-full !border !border-[#706233]/10 hover:border-[#706233]/50 !outline-0 rounded-[5px] p-[8px_15px]" name="address1" required  placeholder="">{{isset($user->address) ? $user->address : ''}}</textarea>
                                    {{-- <input type="text" class="w-full !border !border-[#706233]/10 hover:border-[#706233]/50 !outline-0 rounded-[5px] p-[8px_15px]" name="address1" placeholder="" value="{{isset($user->address) ? $user->address : ''}}"> --}}
                                    @error('address1')
                                        <span class='text-red'>{{$message}}</span>
                                    @enderror
                                </div>
                                @if (isset($user->address_3))
                                <div class="lg:col-span-6 md:col-span-6 red_border_shine">
                                    <label>Shipping Address 2<span>*</span></label>
                                    <label id="delete_dom">x</label>
                                    <textarea  maxlength="50" class="w-full !border !border-[#706233]/10 hover:border-[#706233]/50 !outline-0 rounded-[5px] p-[8px_15px] disabled newAddress" name="address3" id="dynamic_textarea" placeholder="" readonly="">{{isset($user->address_3) ? $user->address_3 : ''}}</textarea>
                                </div>
                                @endif




                            </div>
                            <input type="hidden" name="warehouse_id" id="warehouse_id" value="{{ $warehouse_id }}"/>

                            <button type="submit" class="bg-[#706233] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold mt-6 " id="proceed_to_checkout">Proceed To checkout</button>

                            <!--/ End Form -->
                        </div>
                    </div>
                    <div class="lg:col-span-4 ">
                        <div class="bg-white !border !border-[#706233]/10 rounded-[5px] p-[20px]">
                            @php
                                $total_amount=Helper::totalCartPrice();
                               $vat= Helper::totalCartVatPrice();
                                $amount_on_delivery = $total_amount;
                            @endphp
                            <!-- Order Widget -->
                            {{-- <h2 class="text-[18px] font-semibold my-4">Shipping Methods</h2>
                            <div class="flex flex-col gap-3">
                                <label class="flex items-center cursor-pointer relative text-black text-[16px] delivery_option" for="cod">
                                    <input name="payment_method" id="cod" class="absolute opacity-0 z-[0] peer" type="radio" value="cod" required />
                                    <span class="peer-checked:bg-[#706233] shadow-[inset_0px_0px_0px_3px_white] border-2 border-[#706233] w-[18px] h-[18px] inline-block mr-2 rounded-full shrink-0 z-[10]"></span>
                                    Delivery (Total: £{{ $amount_on_delivery }})
                                </label>
                                <label class="flex items-center cursor-pointer relative text-black text-[16px] selfpickup_option" for="self">
                                    <input name="payment_method" id="self" class="absolute opacity-0 z-[0] peer" type="radio" value="self" checked="checked" />
                                    <span class="peer-checked:bg-[#706233] shadow-[inset_0px_0px_0px_3px_white] border-2 border-[#706233] w-[18px] h-[18px] inline-block mr-2 rounded-full shrink-0 z-[10]"></span>
                                    Self Pick (Total: £{{ $total_amount }})
                                </label>
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
                            </div> --}}
                            <!--/ End Order Widget -->
                            <!-- Order Widget -->
                            <div class="single-widget">
                                <h2 class="text-[18px] font-semibold mb-[5px] my-4">CART TOTALS</h2>
                                <ul class="mt-3">
                                    <li class="flex items-center justify-between border-b border-[#000] py-[10px]" data-price="{{Helper::totalCartPrice()}}">Cart Subtotal<span>£{{number_format(Helper::totalCartPrice(),2)}}</span></li>
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
                                    <li class="flex items-center justify-between border-b border-[#000] py-[10px]">
                                        Delivery Charges
                                        @if (!Helper::getDeliveryCharges(\Auth::guard('customer')->user()->id, \Auth::guard('customer')->user()->warehouse))
                                            <span>Free</span>
                                        @else
                                            <span>£{{ Helper::getDeliveryCharges(\Auth::guard('customer')->user()->id, \Auth::guard('customer')->user()->warehouse) }}</span>
                                        @endif

                                    </li>
                                    @php

                                        $delivery_charges = Helper::getDeliveryCharges(\Auth::guard('customer')->user()->id, \Auth::guard('customer')->user()->warehouse);
                                        if($delivery_charges){
                                            $total_amount = $total_amount + $delivery_charges;
                                        }
                                        if(session('coupon')){
                                            $total_amount=$total_amount-session('coupon')['value'];
                                        }
                                    @endphp
                                    <li class="flex items-center justify-between border-b border-[#000] py-[10px]">Vat <span>£{{number_format($vat,2)}}</span></li>
                                    <li class="flex items-center justify-between border-b border-[#000] py-[10px]  delivery_additional">Grand Total <span data-price="{{number_format($total_amount+$vat,2,'.', '')}}">£{{number_format($total_amount+$vat,2)}}</span></li>
                                    @if(session('coupon'))
                                    <li class="flex items-center justify-between border-b border-[#000] py-[10px]" data-price="{{session('coupon')['value']}}">You Save<span>£{{number_format(session('coupon')['value'],2)}}</span></li>
                                    @endif
                                    @if(session('coupon'))
                                        <li class="flex items-center justify-between border-b border-[#000] py-[10px] d-none"  id="order_total_price">Total<span>£{{number_format($total_amount,2)}}</span></li>
                                    @else
                                        <li class="flex items-center justify-between border-b border-[#000] py-[10px] d-none"  id="order_total_price">Total<span>£{{number_format($total_amount,2)}}</span></li>
                                    @endif
                                </ul>
                            </div>
                            <button type="submit" class="bg-[#706233] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold w-full mt-6 " id="proceed_to_checkout">Proceed To checkout</button>
                            <!--/ End Order Widget -->
                            {{-- @if ($total_amount <= 249 && $warehouse_id == 7)
                                <button class="bg-[#70623375] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold  mt-6" disabled>Proceed To Payment</button>
                           @else
                                <button type="submit" class="bg-[#706233] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold w-full mt-6 " id="proceed_to_checkout">Proceed To Payment</button>
                               
                            @endif 
                            --}}
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
