@extends('frontend.layouts.master')

@section('title','Checkout page')

@section('main-content')
<main class="relative main_cart">
    <!-- Breadcrumbs -->
    <input type="hidden" id="checkout_url" value="{{ route('checkout') }}" />
    <input type="hidden" id="thankYou_url" value="{{ route('thankYou') }}" />
    <div class="w-full bg-[#ce1212]/10 py-[15px]">
		<div class="!container px-6 mx-auto">
			<div class="flex items-center">
				<div class="grow">
					<nav>
						<ol class="flex items-center">
							<li class="list-unstyled"><a href="{{('home')}}">Home </a></li>
							<li class="list-unstyled text-[#ce1212] ml-1" aria-current="page"> / Payment</li>
						</ol>
					</nav>
				</div>
				<div class="grow text-right">
                    <h2 class="text-[16px] font-bold">Payment</h2>
				</div>
			</div>
		</div>
	</div>
    <!-- End Breadcrumbs -->
    @if (\Session::has('success'))
              <div class="alert alert-success">
                  <ul>
                      <li>{!! \Session::get('success') !!}</li>
                  </ul>
              </div>
            @endif
            @if (\Session::has('error'))
                <div class="alert alert-danger">
                    <ul>
                        <li>{!! \Session::get('error') !!}</li>
                    </ul>
                </div>
            @endif

    <!-- Start Checkout -->
    <section class="py-[40px]">
        <div class="!container mx-auto px-6">
            @if (Session::has('error'))

            <div class="alert alert-danger mt-2">{{ Session::get('error') }}
            </div>

            @endif
            @php
             //  dd($env_variable);
            @endphp
                <div class="grid lg:grid-cols-12 grid-cols-1 gap-4">
                    <div class="lg:col-span-8 text-center d-flex flex-center flex-column">
                        @if ($env_variable == "live")
                            <div class="col-md-6 col-sm-12 col-lg-6 m-auto text-center d-flex flex-center flex-column livesystem">
                                <form id="paymemtForm" action="javascript:formSubmit()" method="post">
                                    <div>Amount: {{ $total_price_with_vat }} GBP</div>
                                    <script src="https://web.e.connect.paymentsense.cloud/assets/js/checkout.js"
                                        data-amount={{ $minor_unit_amount }}
                                        data-access-token= {{ $payment_sense_token }}
                                        data-currency-code="826"
                                        data-description="Payment of {{ $total_price_with_vat }} GBP"
                                        data-button-text="Pay Now"
                                        data-submit-button-text="Pay {{ $total_price_with_vat }} GBP"
                                        class="connect-checkout-btn"></script>


                                </form>
                            </div>
                        @else
                            <div class="col-md-6 col-sm-12 col-lg-6 m-auto text-center d-flex flex-center flex-column testsystem">
                                <form id="paymemtForm" action="javascript:formSubmit()" method="post">
                                    <div>Amount: {{ $total_price_with_vat }} GBP</div>
                                    <script src="https://web.e.test.connect.paymentsense.cloud/assets/js/checkout.js"
                                        data-amount="100"
                                        data-access-token= {{ $payment_sense_token }}
                                        data-currency-code="826"
                                        data-description="Demo Payment of {{ $total_price_with_vat }} GBP"
                                        data-button-text="Pay Now"
                                        data-submit-button-text="Pay {{ $total_price_with_vat }} GBP"
                                        class="connect-checkout-btn"></script>


                                </form>
                            </div>
                        @endif
                    </div>


                    <div class="lg:col-span-4 ">
                        <form class="form" id="checkout_form" method="POST" action="{{route('cart.order')}}">
                                @csrf
                                {{-- @foreach ($data as $key => $value )
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}"/>
                                @endforeach --}}
                                <input type="hidden" name="reference_no" value="{{ $reference_no }}" />
                                <input type="hidden" name="paymensense_token" value="{{ $payment_sense_token }}" />
                            <div class="bg-white !border !border-[#ce1212]/10 rounded-[5px] p-[20px]">
                                @php
                                    $total_amount=Helper::totalCartPriceOfOrder($order_id);
                                    $vat= Helper::totalCartVatPriceOfOrder($order_id);
                                    $amount_on_delivery = $total_amount;
                                @endphp

                                <!-- Order Widget -->
                                <div class="single-widget">
                                    <h2 class="text-[18px] font-semibold mb-[5px] my-4">CART TOTALS</h2>
                                    <ul class="mt-3">
                                        <li class="flex items-center justify-between border-b py-[10px]" data-price="{{Helper::totalCartPriceOfOrder($order_id)}}">Cart Subtotal<span>£{{number_format(Helper::totalCartPriceOfOrder($order_id),2)}}</span></li>

                                        <input type="hidden" value="{{ number_format(Helper::getDeliveryChargesOfOrder(\Auth::guard('customer')->user()->id, \Auth::guard('customer')->user()->warehouse,$order_id),2) }}" id="delivery_charges_input"/>
                                        <input type="hidden" value="{{number_format(Helper::totalCartPriceOfOrder($order_id),2)}}" id="without_delivery"/>
                                        <li class="flex items-center justify-between border-b py-[10px] @if($pick_time != null) hide @endif show_on_delivery">
                                            Delivery Charges
                                            @if (!Helper::getDeliveryChargesOfOrder(\Auth::guard('customer')->user()->id, \Auth::guard('customer')->user()->warehouse,$order_id))
                                                <span>Free</span>
                                            @else
                                                <span>£{{ Helper::getDeliveryChargesOfOrder(\Auth::guard('customer')->user()->id, \Auth::guard('customer')->user()->warehouse,$order_id) }}</span>
                                            @endif

                                        </li>

                                        <li class="flex items-center justify-between border-b py-[10px]">Vat <span>£{{number_format($vat,2)}}</span></li>
                                        <li class="flex items-center justify-between border-b py-[10px]  delivery_additional">Grand Total <span data-price="{{number_format(Helper::totalCartPriceOfOrder($order_id)+$vat,2,'.', '')}}">£{{number_format(Helper::totalCartPriceOfOrder($order_id)+$vat,2)}}</span></li>
                                        @if(session('coupon'))
                                        <li class="flex items-center justify-between border-b py-[10px]" data-price="{{session('coupon')['value']}}">You Save<span>£{{number_format(session('coupon')['value'],2)}}</span></li>
                                        @endif
                                        @php

                                            $delivery_charges = Helper::getDeliveryChargesOfOrder(\Auth::guard('customer')->user()->id, \Auth::guard('customer')->user()->warehouse,$order_id);
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
                                <button type="submit" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold w-full mt-6" style="display:none;" id="proceed_to_checkout">Pay In Store</button>
                                {{-- <span id="proceed_payment" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold w-full mt-6">Pay By Card</span> --}}
                                {{--<span id="pay_in_store" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold w-full mt-6">Pay in-store</span>--}}
                            </div>
                        </form>
                    </div>
                </div>

        </div>
    </section>
    <!--/ End Checkout -->
    <!-- PAYEMNT SECTION -->
    {{-- <div class="custom_spinner">
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
                data-loading-text="Processing...">Pay</button>
        <div id="demo-result" style="display: none">
            <h5>Payment Complete</h5>
            <dl>
                <dt>Status Code</dt>
                <dd id="status-code"></dd>
                <dt>Auth Code</dt>
                <dd id="auth-code"></dd>
            </dl>
        </div>
        {{-- <script src="https://web.e.test.connect.paymentsense.cloud/assets/js/checkout.js"></script>
        <div id="paymentFormContainer">

        </div>

    </div> --}}
    <!--/ PAYEMNT SECTION -->
    <!-- Start Shop Services Area  -->

    <!-- End Shop Services -->



</main>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection
