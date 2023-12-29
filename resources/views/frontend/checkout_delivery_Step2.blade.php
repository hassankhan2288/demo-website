@extends('frontend.layouts.master')

@section('title','Checkout page')

@section('main-content')
<main class="relative main_cart">
    <!-- Breadcrumbs -->
    <input type="hidden" id="env_variable" value="{{ $env }}" />
    <input type="hidden" id="env_url" value="{{ $url }}" />
    <input type="hidden" id="user_id" value="{{ $user->ms_number }}" />
    <div class="w-full bg-[#ce1212]/10 py-[15px]">
		<div class="!container px-6 mx-auto">
			<div class="flex items-center">
				<div class="grow">
					<nav>
						<ol class="flex items-center">
							<li class="list-unstyled"><a href="{{('home')}}">Home </a></li>
							<li class="list-unstyled text-[#ce1212] ml-1" aria-current="page"> / Checkout</li>
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
                {{-- <form class="form" id="checkout_form" method="POST" action="{{route('payment')}}"> --}}
                    @php
                    if(isset($devliverydata['address3'])){
                        $addressextra= $devliverydata['address3'];
                    }else{
                        $addressextra='';
                    }
                    
                    @endphp
                @csrf
                <input type="hidden" value="delivery" name="payment_method"/>
                <input type="hidden" value="delivery" name="checkout_preference"/>
                <input type="hidden" value="card" name="paid_by" />
                <input type="hidden" value="{{$devliverydata['email']}}" name="email" />
                <input type="hidden" value="{{$devliverydata['phone']}}" name="phone" />
                <input type="hidden" value="{{$devliverydata['country']}}" name="country" />
                <input type="hidden" value="{{$devliverydata['post_code']}}" name="post_code" />
                <input type="hidden" value="{{$devliverydata['address1']}}" name="address_billing" />
                <input type="hidden" value="{{$devliverydata['address2']}}" name="address_shipping" />
                <input type="hidden" value="{{ $devliverydata['address3'] ?? ''}}" name="address_shipping_extra" />
                <input type="hidden" value="{{$devliverydata['warehouse_id']}}" name="warehouse_id" />
                
                <div class="grid lg:grid-cols-12 grid-cols-1 gap-4">

                    <div class="lg:col-span-8 ">
                        <div class="checkout-form">
                            <h2 class="text-[25px] font-bold !mb-3">Devlivery</h2>
                            <p class="text-[15px] !mb-6 ">Please select delivery slot</p>
                            <!-- Form -->
                           


                            <!--/ End Form -->
                            <ul class="deliverydaysshowing">
                                @foreach ($datesweeks as $date)
                                <li><label>
                                    <input required type="radio" name="delivery_date" value="{{$date}}">
                                    {{$date}}</label>
                                </li>
                                @endforeach
                                
                            </ul>
                        </div>
                    </div>
                    <div class="lg:col-span-4 ">
                        <div class="bg-white !border !border-[#ce1212]/10 rounded-[5px] p-[20px]">
                            @php
                                $total_amount=Helper::totalCartPrice();
                               $vat= Helper::totalCartVatPrice();
                                $amount_on_delivery = $total_amount;
                            @endphp
                          
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
                            <!--/ End Order Widget -->
                            {{-- @if ($total_amount <= 249 && $warehouse_id == 7) --}}
                                <button class="bg-[#ce121275] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold  mt-6">Proceed To Payment</button>
                            {{-- @else --}}
                         
                                {{-- <span id="proceed_payment" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold w-full mt-6">Pay By Card</span> --}}
                            {{-- @endif --}}
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
            <button type="button" class="btn-close bg-[#ce1212] text-white" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <input class="mb-2 w-full !border !border-[#ce1212]/10 hover:border-[#ce1212]/50 !outline-0 rounded-[5px] p-[8px_15px]" id="apartment" placeholder="Apartment#\House#"/>
                <input class="mb-2 w-full !border !border-[#ce1212]/10 hover:border-[#ce1212]/50 !outline-0 rounded-[5px] p-[8px_15px]" id="street" placeholder="Street"/>
                <input class="mb-2 w-full !border !border-[#ce1212]/10 hover:border-[#ce1212]/50 !outline-0 rounded-[5px] p-[8px_15px]" id="address_modal" placeholder="Address"/>
            </div>
            <div class="modal-footer">
            <button id="change_shipping" type="button" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold w-full mt-6">Save changes</button>
            </div>
        </div>
        </div>
    </div>
    <!-- Modal END -->

</main>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@endsection
