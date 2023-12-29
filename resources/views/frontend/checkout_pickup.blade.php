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
                @csrf
                <div class="grid lg:grid-cols-12 grid-cols-1 gap-4">

                    <div class="lg:col-span-8 ">
                        <div class="checkout-form">
                            <!-- Form -->
                            <input type="hidden" name="warehouse_id" id="warehouse_id" value="{{ $warehouse_id }}"/>
                            <div class="lg:col-span-12 md:col-span-12 !mt-6 pickup_section">
                                <div class="lg:col-span-6 md:col-span-6 pickup_timer">
                                    <label><strong>Collection Date</strong></label>
                                    <input type="text" class="w-full !border !border-[#ce1212]/10 hover:border-[#ce1212]/50 !outline-0 rounded-[5px] p-[8px_15px]" id="date" name="pick_date" placeholder="Select Collection Date" min="<?php echo date("Y-m-d"); ?>">
                                    @error('pick_date')
                                        <span class='text-red'>{{$message}}</span>
                                    @enderror
                                </div>
                                <label class="text-[20px] font-semibold !mb-4">Collection Time</label>
                                <p id="slots_description">Please select Collection date to get slots</p>
                                <div class="slots_container_hm grid xl:grid-cols-6 lg:grid-cols-5 md:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-4" id="slots-container">
                                </div>
                              </div>

                            <!--/ End Form -->
                        </div>
                    </div>
                    <div class="lg:col-span-4 ">
                        <div class="bg-white !border !border-[#ce1212]/10 rounded-[5px] p-[20px]">
                            @php
                                $total_amount=Helper::totalCartPrice();
                                $vat= Helper::totalCartVatPrice();
                                $amount_on_delivery = $total_amount;
                            @endphp
                            <input type="hidden" value="self" name="payment_method"/>
                            <input type="hidden" value="self_pickup" name="checkout_preference"/>
                            <input type="hidden" value="card" name="paid_by" />
                            <!-- Order Widget -->
                            {{-- <h2 class="text-[18px] font-semibold my-4">Shipping Methods</h2>
                            <div class="flex flex-col gap-3">
                                <label class="flex items-center cursor-pointer relative text-black text-[16px] delivery_option" for="cod">
                                    <input name="payment_method" id="cod" class="absolute opacity-0 z-[0] peer" type="radio" value="cod" required />
                                    <span class="peer-checked:bg-[#ce1212] shadow-[inset_0px_0px_0px_3px_white] border-2 border-[#ce1212] w-[18px] h-[18px] inline-block mr-2 rounded-full shrink-0 z-[10]"></span>
                                    Delivery (Total: £{{ $amount_on_delivery }})
                                </label>
                                <label class="flex items-center cursor-pointer relative text-black text-[16px] selfpickup_option" for="self">
                                    <input name="payment_method" id="self" class="absolute opacity-0 z-[0] peer" type="radio" value="self" checked="checked" />
                                    <span class="peer-checked:bg-[#ce1212] shadow-[inset_0px_0px_0px_3px_white] border-2 border-[#ce1212] w-[18px] h-[18px] inline-block mr-2 rounded-full shrink-0 z-[10]"></span>
                                    Self Pick (Total: £{{ $total_amount }})
                                </label>
                                <label class="flex items-center cursor-pointer relative text-black text-[16px] delivery_option" for="cod">
                                    <input name="payment_method" id="cod" class="absolute opacity-0 z-[0] peer" type="radio" value="cod" required />
                                    <span class="peer-checked:bg-[#ce1212] shadow-[inset_0px_0px_0px_3px_white] border-2 border-[#ce1212] w-[18px] h-[18px] inline-block mr-2 rounded-full shrink-0 z-[10]"></span>
                                    Delivery
                                </label>
                                <label class="flex items-center cursor-pointer relative text-black text-[16px] selfpickup_option" for="self">
                                    <input name="payment_method" id="self" class="absolute opacity-0 z-[0] peer" type="radio" value="self" checked="checked" />
                                    <span class="peer-checked:bg-[#ce1212] shadow-[inset_0px_0px_0px_3px_white] border-2 border-[#ce1212] w-[18px] h-[18px] inline-block mr-2 rounded-full shrink-0 z-[10]"></span>
                                    Self Pick
                                </label>
                            </div> --}}
                            <!--/ End Order Widget -->
                            <!-- Order Widget -->
                            <div class="single-widget">
                                <h2 class="text-[18px] font-semibold mb-[5px] my-4">CART TOTALS</h2>
                                <ul class="mt-3">
                                    <li class="flex items-center justify-between border-b border-[#000] py-[10px]" data-price="{{Helper::totalCartPrice()}}">Cart Subtotal<span>£{{number_format(Helper::totalCartPrice(),2)}}</span></li>

                                    <input type="hidden" value="{{ number_format(Helper::getDeliveryCharges(\Auth::guard('customer')->user()->id, \Auth::guard('customer')->user()->warehouse),2) }}" id="delivery_charges_input"/>
                                    <input type="hidden" value="{{number_format(Helper::totalCartPrice(),2)}}" id="without_delivery"/>
                                    <li class="flex items-center justify-between border-b py-[10px] border-[#000] hide show_on_delivery">
                                        Delivery Charges
                                        @if (!Helper::getDeliveryCharges(\Auth::guard('customer')->user()->id, \Auth::guard('customer')->user()->warehouse))
                                            <span>Free</span>
                                        @else
                                            <span>£{{ Helper::getDeliveryCharges(\Auth::guard('customer')->user()->id, \Auth::guard('customer')->user()->warehouse) }}</span>
                                        @endif

                                    </li>

                                    <li class="flex items-center justify-between border-b border-[#000] py-[10px]">Vat <span>£{{number_format($vat,2)}}</span></li>
                                    <li class="flex items-center justify-between border-b border-[#000] py-[10px]  delivery_additional">Grand Total <span data-price="{{number_format(Helper::totalCartPrice()+$vat,2,'.', '')}}">£{{number_format(Helper::totalCartPrice()+$vat,2)}}</span></li>
                                    @if(session('coupon'))
                                    <li class="flex items-center justify-between border-b border-[#000] py-[10px]" data-price="{{session('coupon')['value']}}">You Save<span>£{{number_format(session('coupon')['value'],2)}}</span></li>
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
                                        <li class="flex items-center justify-between border-b border-[#000] py-[10px] d-none"  id="order_total_price">Total<span>£{{number_format($total_amount,2)}}</span></li>
                                    @else
                                        <li class="flex items-center justify-between border-b border-[#000] py-[10px] d-none"  id="order_total_price">Total<span>£{{number_format($total_amount,2)}}</span></li>
                                    @endif
                                </ul>
                            </div>
                            <!--/ End Order Widget -->
                            <button type="submit" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold w-full mt-6" style="display:none;" id="proceed_to_checkout">Pay In Store</button>
                            {{-- <span id="proceed_payment" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold w-full mt-6">Pay By Card</span> --}}
                             <span id="pay_in_store" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold w-full mt-6">Proceed To Payment</span>
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
    <!-- Start Shop Services Area  -->

    <!-- End Shop Services -->

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
