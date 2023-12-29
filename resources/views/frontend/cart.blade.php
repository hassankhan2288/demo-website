@extends('frontend.layouts.master')
@section('title','Cart Page')
@section('main-content')
	<!-- Breadcrumbs -->
    <div class="w-full bg-[#706233]/10 py-[15px]">
		<div class="!container px-6 mx-auto">
			<div class="flex items-center">
				<div class="grow">
					<nav>
						<ol class="flex items-center">
							<li class="list-unstyled"><a href="{{route('home')}}">Home </a></li>
							<li class="list-unstyled text-[#706233] ml-1" aria-current="page"> / Cart</li>
						</ol>
					</nav>
				</div>
				<div class="grow text-right">
                    <h2 class="text-[16px] font-bold">Cart</h2>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->

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
			<div class="flex flex-wrap overflow-x-auto">
				<div class=" w-full">
					<table class="table shopping-summery">
						<thead>
							<tr class="bg-[#706233]/10">
								<th class="p-[0.5rem] text-[14px]">PRODUCT</th>
								<th class="p-[0.5rem] text-[14px]">NAME</th>
								<th class="p-[0.5rem] text-[14px]">TYPE</th>
								<th class="p-[0.5rem] text-[14px]">Price Type</th>
								<th class="text-center p-[0.5rem] text-[14px]">UNIT PRICE</th>
								<th class="text-center p-[0.5rem] text-[14px]">QUANTITY</th>
								<th class="text-center p-[0.5rem] text-[14px]">VAT</th>
								<th class="text-center p-[0.5rem] text-[14px]">TOTAL</th>
								<th class="text-center p-[0.5rem] text-[14px]"><i class="fa fa-trash text-[18px]" aria-hidden="true"></i></th>
							</tr>
						</thead>
						<tbody id="cart_item_list">
{{--							<form action="{{route('cart.update')}}" method="POST">--}}
								<form action="">

								@csrf
								@if(Helper::getAllProductFromCart())
									@foreach(Helper::getAllProductFromCart() as $key=>$cart)
									{{-- </?php //dd($cart->product->photo);?> --}}
										<tr class="tr-{{ $cart->product->id }} py-[15px]">
											@php
											$photo=explode(',',$cart->product['image']);
											@endphp
											<td class="image text-center !p-[1rem] align-middle text-[14px]" data-title="No">
												{{-- <img src="{{asset('storage/'.$photo[0])}}" alt="{{$photo[0]}}" class="w-[100px]" /> --}}
												@php
													$photo[0] = str_replace('storage/','',$photo[0]);
												@endphp
												<img src="{{image_url('storage/'.$photo[0])}}" alt="{{$photo[0]}}" class="w-[100px]" />
											</td>
											<td class="productdetails text-center !p-[1rem] align-middle text-[14px]" data-title="Description">
												<p class="text-[16px] font-bold"><a href="{{route('product-detail',$cart->product['slug'])}}" target="_blank">{{$cart->product->name}}</a></p>
												<p class="font-[14px] font-medium">{!!($cart['summary']) !!}</p>
											</td>
											<td class="producttype text-left !p-[1rem] align-middle text-[14px] !pl-0"><span class="main_mobile" ><b>Type: </b></span> {{ $cart->type }}</td>
											<td class="producttype text-left !p-[1rem] align-middle text-[14px] !pl-0 capitalize"><span class="main_mobile" ><b>Preference: </b></span> {{ $cart->preference }}</td>
											<td class="productprice text-center !p-[1rem] align-middle text-[14px]" data-title="Price">
												<div class="flex main_mobile_force">
													<p class="text-[10px]" style="display: block;background: #ccc;"><b>UNIT PRICE</b></p>
													<span>£{{number_format($cart['price'],2)}}</span>
												</div>
												<span class="none_force_mobile">£{{number_format($cart['price'],2)}}</span>
											</td>
											@if($cart['price'] == '0')
												<td class="productqty text-center !p-[1rem] align-middle text-[14px] none_force_mobile" data-title="Qty">
													<div class="qty-input">
														<button class="qty-count qty-count--minus" data-action="minus" type="button">-</button>
														<input class="product-qty" type="number" name="quant[{{$key}}]" data-preference="{{ $cart->preference }}" data-product_id="{{ $cart->product->id }}" data-user_id="{{ \Auth::guard('customer')->user()->id }}" class="w-[70px] p-[8px_5px] rounded-[5px] !border border-[#706233]/10" min="0" max="10" data-min="1" data-max="10" value="{{$cart->quantity}}">
														<button class="qty-count qty-count--add" data-action="add" type="button">+</button>
														<input type="hidden" name="qty_id[]" value="{{$cart->id}}">
														<input type="hidden" name="type[]" value="{{$cart->type}}">
														<input type="hidden" name="preference[]" value="{{$cart->preference}}">
													</div>
												</td>
												<td class="total-amount cart_single_price text-center !p-[1rem] align-middle text-[14px]" data-title="Vat">
													<div class="flex main_mobile_force">
														<p class="text-[10px]" style="display: block;background: #ccc;"><b>VAT</b></p>
														<span class="money">£0.00</span>
													</div>
													<span class="money none_force_mobile">£0.00</span>
												</td>
												<td class="total-amount cart_single_price text-center !p-[1rem] align-middle text-[14px]" data-title="Total">
													<div class="flex main_mobile_force">
														<p class="text-[10px]" style="display: block;background: #ccc;"><b>TOTAL</b></p>
														<span class="money">£0.00</span>
													</div>
													<span class="money none_force_mobile">£0.00</span>
												</td>
											@else
												<td class="productqty text-center !p-[1rem] align-middle text-[14px] none_force_mobile" data-title="Qty">
													<div class="qty-input">
														<button class="qty-count qty-count--minus" data-action="minus" type="button">-</button>
{{--														<input class="product-qty" type="number" name="quant[{{$key}}]" data-preference="{{ $cart->preference }}" data-product_id="{{ $cart->product->id }}" data-user_id="{{ \Auth::guard('customer')->user()->id }}" class="w-[70px] p-[8px_5px] rounded-[5px] !border border-[#706233]/10" min="0" max="10" data-min="1" data-max="10" value="{{$cart->quantity}}">--}}
														<input class="product-qty" type="number" name="quant[{{$key}}]" data-preference="{{ $cart->preference }}" data-product_id="{{ $cart->product->id }}" data-user_id="{{ \Auth::guard('customer')->user()->id }}" class="w-[70px] p-[8px_5px] rounded-[5px] !border border-[#706233]/10" min="0" max="10" data-min="1" data-max="10" value="{{ old('quant.' . $key, $cart->quantity) }}">
														<button class="qty-count qty-count--add" data-action="add" type="button">+</button>
														<input type="hidden" name="qty_id[]" value="{{$cart->id}}">
														<input type="hidden" name="type[]" value="{{$cart->type}}">
														<input type="hidden" name="preference[]" value="{{$cart->preference}}">
													</div>
												</td>
												<td class="total-amount cart_single_price text-center !p-[1rem] align-middle text-[14px]" data-title="Vat">
													<div class="flex main_mobile_force">
														<p class="text-[10px]" style="display: block;background: #ccc;"><b>VAT</b></p>
														<span class="money">£{{number_format($cart['vat'],2)}}</span>
													</div>
													<span class="money none_force_mobile">£{{number_format($cart['vat'],2)}}</span>
												</td>
												<td class="total-amount cart_single_price text-center !p-[1rem] align-middle text-[14px]" data-title="Total">
													<div class="flex main_mobile_force">
														<p class="text-[10px]" style="display: block;background: #ccc;"><b>TOTAL</b></p>
														<span class="money">£{{number_format($cart['amount']+$cart['vat'],2)}}</span>
													</div>
													<span class="money none_force_mobile">£{{number_format($cart['amount']+$cart['vat'],2)}}</span>
												</td>
											@endif
											
											<td class="text-center !p-[1rem] align-middle text-[14px] main_mobile_force" data-title="Qty">
												<div class="qty-input">
													<button class="qty-count qty-count--minus" data-action="minus" type="button">-</button>
													<input class="product-qty" type="number" name="quant[{{$key}}]" data-preference="{{ $cart->preference }}" data-product_id="{{ $cart->product->id }}" data-user_id="{{ \Auth::guard('customer')->user()->id }}" class="w-[70px] p-[8px_5px] rounded-[5px] !border border-[#706233]/10" min="1" max="9" data-min="1" data-max="9" value="{{$cart->quantity}}">
													<button class="qty-count qty-count--add" data-action="add" type="button">+</button>
												</div>
											</td>
											
											<td class="deletbtn text-center !p-[1rem] align-middle text-[14px]" data-title="Remove"><a href="{{route('cart-delete',$cart->id)}}"><i class="fa fa-trash text-[18px]" aria-hidden="true"></i></a></td>
										</tr>


{{--										@if($cart->product->freeProduct)--}}
{{--											@foreach ($cart->product->freeProduct as $freeProduct)--}}
{{--												@php--}}
{{--													$free_pro = App\Product::where('id', $freeProduct->free_product_id)->get();--}}
{{--												@endphp--}}
{{--												@foreach ($free_pro as $pro)--}}
{{--													<tr class="tr-{{ $cart->product->id }} py-[15px]">--}}
{{--														@php--}}
{{--															$photo_pro=explode(',',$pro['image']);--}}
{{--														@endphp--}}
{{--														<td class="image text-center !p-[1rem] align-middle text-[14px]" data-title="No">--}}
{{--															--}}{{-- <img src="{{asset('storage/'.$photo[0])}}" alt="{{$photo[0]}}" class="w-[100px]" /> --}}
{{--															@php--}}
{{--																$photo_pro[0] = str_replace('storage/','',$photo_pro[0]);--}}
{{--															@endphp--}}
{{--															<img src="{{image_url('storage/'.$photo_pro[0])}}" alt="{{$photo_pro[0]}}" class="w-[100px]" />--}}
{{--														</td>--}}
{{--														<td class="productdetails text-center !p-[1rem] align-middle text-[14px]" data-title="Description">--}}
{{--															<p class="text-[16px] font-bold"><a href="{{route('product-detail',$pro['slug'])}}" target="_blank">{{$pro->name}}</a></p>--}}
{{--															<p class="font-[14px] font-medium">{!!($cart['summary']) !!}</p>--}}
{{--														</td>--}}
{{--														<td class="producttype text-left !p-[1rem] align-middle text-[14px] !pl-0"><span class="main_mobile" ><b>Type: </b></span> {{ $pro->type }}</td>--}}
{{--														<td class="producttype text-left !p-[1rem] align-middle text-[14px] !pl-0 capitalize"><span class="main_mobile" ><b>Preference: </b></span> {{ $pro->preference }}</td>--}}
{{--														<td class="productprice text-center !p-[1rem] align-middle text-[14px]" data-title="Price">--}}
{{--															<div class="flex main_mobile_force">--}}
{{--																<p class="text-[10px]" style="display: block;background: #ccc;"><b>UNIT PRICE</b></p>--}}
{{--																<span>Free}</span>--}}
{{--															</div>--}}
{{--															<span style="color: red" class="none_force_mobile">Free</span>--}}
{{--														</td>--}}
{{--														<td class="productqty text-center !p-[1rem] align-middle text-[14px] none_force_mobile" data-title="Qty">--}}
{{--															<div class="qty-input">--}}
{{--																<button class="qty-count qty-count--minus" data-action="minus" type="button" disabled>-</button>--}}
{{--																<input class="product-qty" type="number" name="quant[{{$key}}]" data-preference="{{ $cart->preference }}" data-product_id="{{ $pro->id }}" data-user_id="{{ \Auth::guard('customer')->user()->id }}" class="w-[70px] p-[8px_5px] rounded-[5px] !border border-[#706233]/10" min="0" max="10" data-min="1" data-max="10" value="{{$cart->quantity}}">--}}
{{--																<button class="qty-count qty-count--add" data-action="add" type="button" disabled>+</button>--}}
{{--																<input type="hidden" name="qty_id[]" value="{{$cart->id}}">--}}
{{--																<input type="hidden" name="type[]" value="{{$cart->type}}">--}}
{{--																<input type="hidden" name="preference[]" value="{{$cart->preference}}">--}}
{{--															</div>--}}
{{--														</td>--}}
{{--														<td class="total-amount cart_single_price text-center !p-[1rem] align-middle text-[14px]" data-title="Vat">--}}
{{--															<div class="flex main_mobile_force">--}}
{{--																<p class="text-[10px]" style="display: block;background: #ccc;"><b>VAT</b></p>--}}
{{--																<span class="money">Free</span>--}}
{{--															</div>--}}
{{--															<span style="color: red" class="money none_force_mobile">Free</span>--}}
{{--														</td>--}}
{{--														<td class="total-amount cart_single_price text-center !p-[1rem] align-middle text-[14px]" data-title="Total">--}}
{{--															<div class="flex main_mobile_force">--}}
{{--																<p class="text-[10px]" style="display: block;background: #ccc;"><b>TOTAL</b></p>--}}
{{--																<span class="money">Free</span>--}}
{{--															</div>--}}
{{--															<span style="color: red" class="money none_force_mobile">Free</span>--}}
{{--														</td>--}}

{{--														<td class="text-center !p-[1rem] align-middle text-[14px] main_mobile_force" data-title="Qty">--}}
{{--															<div class="qty-input">--}}
{{--																<button class="qty-count qty-count--minus" data-action="minus" type="button">-</button>--}}
{{--																<input class="product-qty" type="number" name="quant[{{$key}}]" data-preference="{{ $cart->preference }}" data-product_id="{{ $cart->product->id }}" data-user_id="{{ \Auth::guard('customer')->user()->id }}" class="w-[70px] p-[8px_5px] rounded-[5px] !border border-[#706233]/10" min="1" max="9" data-min="1" data-max="9" value="{{$cart->quantity}}">--}}
{{--																<button class="qty-count qty-count--add" data-action="add" type="button">+</button>--}}
{{--															</div>--}}
{{--														</td>--}}

{{--														<td class="deletbtn text-center !p-[1rem] align-middle text-[14px]" data-title="Remove" ><a ><i class="fa fa-trash text-[18px]" aria-hidden="true"></i></a></td>--}}
{{--													</tr>--}}

{{--												@endforeach--}}
{{--											@endforeach--}}
{{--										@endif--}}


									@endforeach
									<track>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td class="text-right">
											<button class="bg-[#706233] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold inline-block" type="submit">Update</button>
										</td>
									</track>
								@else
									<tr class="border-b">
										<td class="text-center">
											There are no any carts available. <a href="{{route('product-grids')}}" style="color:blue;">Continue shopping</a>
										</td>
									</tr>
								@endif

							</form>
						</tbody>
					</table>
				</div>
			</div>
			<!--/ End Shopping Summery -->
			<!-- Total Amount -->
			<div class="flex flex-wrap justify-end py-[40px]">
				<div class="lg:w-4/12 md:w-7/12 w-full !border !border-[#706233]/10">
					<h3 class="p-[10px_15px] bg-[#706233]/10 py-[10px]">Cart Total</h3>
					<ul class="!p-6">
						<li class="flex justify-between py-[10px] border-b border-[#000]" id="cart_subtotal" data-price="{{Helper::totalCartPrice()}}">Cart Subtotal <span>£{{number_format(Helper::totalCartPrice(),2)}}</span></li>
						<li class="flex justify-between py-[10px] border-b border-[#000]" id="total_vart">Vat<span>£{{number_format(Helper::totalCartVatPrice(),2)}}</span></li>
						<li class="flex justify-between py-[10px] border-b border-[#000]" id="grand_total"  data-price="{{Helper::totalCartPrice()}}">Grand Total <span>£{{number_format(Helper::totalCartPrice()+Helper::totalCartVatPrice(),2)}}</span></li>
						{{-- @if (Helper::totalCartPrice() > 0)
							<li class="flex justify-between py-[10px] border-b" data-charges="{{Helper::getDeliveryCharges(\Auth::guard('customer')->user()->id, \Auth::guard('customer')->user()->warehouse)}}">
								Delivery Charges
								@if (!Helper::getDeliveryCharges(\Auth::guard('customer')->user()->id, \Auth::guard('customer')->user()->warehouse))
									<span>Free</span>
								@else
									<span>£{{ Helper::getDeliveryCharges(\Auth::guard('customer')->user()->id, \Auth::guard('customer')->user()->warehouse) }}</span>
								@endif
							</li>
						@else --}}
							{{-- <li class="flex justify-between py-[10px] border-b" data-charges="{{Helper::getDeliveryCharges(\Auth::guard('customer')->user()->id, \Auth::guard('customer')->user()->warehouse)}}">
								Delivery Charges
									<span>Free</span>
							</li> --}}
						{{-- @endif --}}
						@if(session()->has('coupon'))
							<li class="flex justify-between py-[10px] border-b" data-price="{{Session::get('coupon')['value']}}">You Save<span>£{{number_format(Session::get('coupon')['value'],2)}}</span></li>
						@endif
						@php
							$total_amount=Helper::totalCartPrice();
							$delivery_charges = Helper::getDeliveryCharges(\Auth::guard('customer')->user()->id, \Auth::guard('customer')->user()->warehouse);
							if($delivery_charges){
								$total_amount = $total_amount + $delivery_charges;
							}
							if(session()->has('coupon')){
								$total_amount=$total_amount-Session::get('coupon')['value'];
							}
						@endphp
						@if (Helper::totalCartPrice() > 0)
							@if(session()->has('coupon'))
								{{-- <li class="flex justify-between py-[10px] border-b" id="order_total_price">You Pay<span>£{{number_format($total_amount,2)}}</span></li> --}}
							@else
								{{-- <li class="flex justify-between py-[10px] border-b" id="order_total_price">You Pay<span>£{{number_format($total_amount,2)}}</span></li> --}}
							@endif
						@else
						{{-- <li class="flex justify-between py-[10px] border-b" id="order_total_price">You Pay<span>£0</span></li> --}}
						@endif
					</ul>
					<div class="!px-4 !pb-4 flex justify-end gap-2">
						<a href="{{route('product-grids')}}" ><button type="button" class="bg-[#706233] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold inline-block">Continue shopping</button></a>
						@if (Helper::cartCount())
							<a href="{{route('checkout')}}" >
								<button type="button" class="btn btn-success p-[11px_30px] rounded-[50px] text-[14px] font-bold inline-block bg-[#198754]">Checkout</button>
							</a>
						@endif
					</div>
				</div>
			</div>
			<!--/ End Total Amount -->
		</div>
	</section>
	<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
	<script>
		// jQuery(".product-qty").change(function(){
		// 	console.log('hkjhkj');
		// });
		jQuery(document).ready(function(){
		var QtyInput = (function () {
			var $qtyInputs = $(".qty-input");

			if (!$qtyInputs.length) {
				return;
			}

			var $inputs = $qtyInputs.find(".product-qty");
			var $countBtn = $qtyInputs.find(".qty-count");
			var qtyMin = parseInt($inputs.attr("min"));
			var qtyMax = parseInt($inputs.attr("max"));

			$inputs.change(function () {
				var $this = $(this);
				var $minusBtn = $this.siblings(".qty-count--minus");
				var $addBtn = $this.siblings(".qty-count--add");
				var qty = parseInt($this.val());
				if(qty > 10 || qty < 1){
					return 0;
				}

				if (isNaN(qty) || qty <= qtyMin) {
					$this.val(qtyMin);
					$minusBtn.attr("disabled", true);
				} else {
					$minusBtn.attr("disabled", false);
					
					if(qty >= qtyMax){
						$this.val(qtyMax);
						$addBtn.attr('disabled', true);
					} else {
						$this.val(qty);
						$addBtn.attr('disabled', false);
					}
				}
				console.log('this is count: ', qty);
				callAjaxIncreaseCountInCart($inputs.attr('data-preference'),$this.attr('data-product_id'), $this.attr('data-user_id'),qty);
			});

			$countBtn.click(function () {
				var operator = this.dataset.action;
				var $this = $(this);
				var $input = $this.siblings(".product-qty");
				var qty = parseInt($input.val());

				console.log('Inside inside ',qty);
				var check = qty+1;
				if (operator == "add") {
					if(check > 10){
						return 0;
					}
					qty += 1;
					if (qty >= qtyMin + 1) {
						$this.siblings(".qty-count--minus").attr("disabled", false);
					}

					if (qty >= qtyMax) {
						$this.attr("disabled", true);
						//alert(1);
					}
				} else {
					qty = qty <= qtyMin ? qtyMin : (qty -= 1);
					
					if (qty == qtyMin) {
						$this.attr("disabled", true);
						console.log('this is disabled')
					}

					if (qty < qtyMax) {
						$this.siblings(".qty-count--add").attr("disabled", false);
						console.log('this should work')
					}
				}
				$input.val(qty);
				callAjaxIncreaseCountInCart($input.attr('data-preference'),$input.attr('data-product_id'), $input.attr('data-user_id'),qty);
			});
		})();
		});



		function callAjaxIncreaseCountInCart(preference,product_id,user_id,qty){
			// console.log('tese are: ',product_id,' and ',user_id,' and ',qty);
			$.ajax({
				url: '{{ route('cart.ajax') }}',
				type: 'GET',
				data: {
					product_id : product_id,
					user_id : user_id,
					qty : qty,
					preference: preference
				},
				dataType: 'json',
				success: function(response) {
					console.log(response);
					if(response.success){
						var tr_class = ".tr-"+product_id;
						$(tr_class+" td:nth-child(5) span").html("£"+response.net_price);
						$(tr_class+" td:nth-child(7) span").html("£"+response.cart_vat);
						$(tr_class+" td:nth-child(8) span").html("£"+response.cart_amount);

						$('#cart_subtotal span').html("£"+response.cart_subtotal);
						$('#total_vart span').html("£"+response.total_vart);
						$('#grand_total span').html("£"+response.grand_total);
						// $(tr_class+" td:nth-of-child(5) span").html("£"+response.net_price);

						// Check if conditions for page refresh are met
						if (
								(response.success && response.freeCart) ||
								(response.success && response.cart_free_pro_delete)
						) {
							// Reload the page
							location.reload();
						}
					}
				},
				error: function(xhr) {
					//Do Something to handle error
					console.log(xhr);
				}
			});
		}
	</script>


@endsection

