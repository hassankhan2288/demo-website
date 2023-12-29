@extends('frontend.layouts.master')
@section('title','Wishlist Page')
@section('main-content')
<main>
	<!-- Breadcrumbs -->
    <div class="w-full bg-[#ce1212]/10 py-[15px]">
		<div class="!container px-6 mx-auto">
			<div class="flex items-center">
				<div class="grow">
					<nav>
						<ol class="flex items-center">
							<li class="list-unstyled"><a href="{{route('home')}}">Home </a></li>
							<li class="list-unstyled text-[#ce1212] ml-1" aria-current="page"> / Wishlist</li>
						</ol>
					</nav>
				</div>
				<div class="grow text-right">
                    <h2 class="text-[16px] font-bold">Wishlist</h2>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->

	<!-- Shopping Cart -->
	<section class="py-[40px]">
		<div class="!container mx-auto px-6">
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
				<div class="w-full">
					<!-- Shopping Summery -->
					<table class="table shopping-summery wishlistsetting">
						<thead>
							<tr class="bg-[#ce1212]/10">
								<th class="p-[0.5rem] text-[14px]">PRODUCT</th>
								<th class="p-[0.5rem] text-[14px]">NAME</th>
								{{-- <th class="p-[0.5rem] text-[14px]">Preference</th> --}}
								{{-- <th class="p-[0.5rem] text-[14px]">Type</th> --}}
								<th class="p-[0.5rem] text-[14px]">QUANTITY</th>
								<th class="text-center p-[0.5rem] text-[14px]">ADD TO CART</th>
								<th class="text-center p-[0.5rem] text-[14px]"><i class="fa fa-trash text-[18px]" aria-hidden="true"></i></th>
							</tr>
						</thead>
						<tbody>
							@if(Helper::getAllProductFromWishlist())
								@foreach(Helper::getAllProductFromWishlist() as $key=>$wishlist)
								@php
									// dd($wishlist->product_id);
									$amount = 0;
									if(\Auth::guard('customer')->user()){
										if(\Auth::guard('customer')->user()->checkout_preference == "pickup"){
											$price = \App\Product::select('p_price','price')->where('id',$wishlist->product_id)->first();
										}else{
											$price = \App\Product::select('delivery_pack','delivery_single')->where('id',$wishlist->$wishlist->product_id)->first();
										}
										// dd($price);
									}
								@endphp
										@php
											$photo=explode(',',$wishlist->product['photo']);
											$product = \App\Product::where('id',$wishlist->product_id)->first();
											$photos=explode(',',$product->image);
											// dd($photos[0]);
										@endphp
									<tr class="border-b" >
										<td class="productdetails text-center !p-[1rem] align-middle text-[14px] image" data-title="No"><img class="w-[100px]" src="{{image_url('storage/'.$photos[0])}}" alt="{{$photo[0]}}"></td>
										<td class="productdetails text-center !p-[1rem] align-middle text-[14px]" data-title="Description">
											<p class="text-[16px] font-bold text-left"><a href="{{route('product-detail',$wishlist->product['slug'])}}">{{$wishlist->product['name']}}</a></p>
											<p class="font-[14px] font-medium">{!!($wishlist['summary']) !!}</p>
										</td>
										{{-- <td class="productdetails text-center !p-[1rem] align-middle text-[14px]" data-title="Description">
											<p class="text-[16px] font-bold text-left">{{$wishlist->preference}}</p>
										</td>
										<td class="productdetails text-center !p-[1rem] align-middle text-[14px]" data-title="Description">
											<p class="text-[16px] font-bold text-left">{{$wishlist->type}}</p>
										</td> --}}
										<td class="text-center !p-[1rem] align-middle text-[14px]">
											<div class="qty-input">
												<button class="qty-count qty-count--minus" data-action="minus" type="button">-</button>
												<input class="product-qty" type="number" name="quant[1]" data-product="{{ $product->id }}"  class="w-[70px] p-[8px_5px] rounded-[5px] !border border-[#ce1212]/10" min="1" max="10" data-min="1" data-max="10" value="1">
												<button class="qty-count " data-action="add" type="button">+</button>
											</div>
										</td>
										<td class="productdetails text-center !p-[1rem] align-middle text-[14px]">
											@if (\Auth::guard('customer')->user()->checkout_preference == "delivery")
												@if (Helper::checkWarehouseOfProduct($product->id,\Auth::guard('customer')->user()->warehouse))

													@if ($product->delivery_single > 0 && $product->delivery_case <= 0 )
														<a href="{{ route('add-to-cart',$product->slug) }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=SINGLE&quantity=1" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold inline-block pd-{{ $product->id }}" >Add to Cart</a>
													@elseif($product->delivery_single <= 0 && $product->delivery_case > 0)
														<a href="{{ route('add-to-cart',$product->slug) }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=CASE&quantity=1" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold inline-block  pd-{{ $product->id }}" >Add to Cart</a>
													@else
														<a href="{{ route('product-detail', $product->slug?? ' ') }}" class="bg-[#ce1212]/10 text-[#ce1212] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#ce1212] hover:text-white">See Details</a>
													@endif

												@else

													<a href="#" class="TWOHM bg-[#ce1212]/10 text-[#ce1212] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#ce1212] hover:text-white">Out Of Stock</a>

												@endif

											@elseif (\Auth::guard('customer')->user()->checkout_preference == "pickup")
												@if (Helper::checkWarehouseOfProduct($product->id,\Auth::guard('customer')->user()->warehouse))


													@if ($product->p_price > 0 && $product->price <= 0 )
														<a href="{{ route('add-to-cart',$product->slug) }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=CASE&quantity=1" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold inline-block  pd-{{ $product->id }}" >Add to Cart</a>
													@elseif($product->p_price <= 0 && $product->price > 0)
														<a href="{{ route('add-to-cart',$product->slug) }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=SINGLE&quantity=1" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold inline-block  pd-{{ $product->id }}" >Add to Cart</a>
													@else
														<a href="{{ route('product-detail', $product->slug?? ' ') }}" class="bg-[#ce1212]/10 text-[#ce1212] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#ce1212] hover:text-white">See Details</a>
													@endif


												@else

													<a href="#" class="TWOHM bg-[#ce1212]/10 text-[#ce1212] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#ce1212] hover:text-white">Out Of Stock</a>

												@endif
											@else
												<a href="{{ route('product-detail', $product->slug?? ' ') }}" class="bg-[#ce1212]/10 text-[#ce1212] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#ce1212] hover:text-white">See Details</a>
											@endif
											<!--THIS IS OLD-->
											{{-- @if($wishlist['amount'] > 0)
												<a href="{{route('add-to-cart',$wishlist->product['slug'])}}?preference={{$wishlist->preference}}&pack_size={{$wishlist->type}}" class='bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold inline-block'>Add To Cart</a>
											@else
											<a href="javascript:void(0)" class='bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold inline-block disabled:opacity-70'>Amount not set</a>
											@endif --}}
											
										</td>
										
										<td class="action productdetails deletbtn text-center !p-[1rem] align-middle text-[14px]" data-title="Remove"><a href="{{route('wishlist-delete',$wishlist->id)}}"><i class="fa fa-trash text-[18px]" aria-hidden="true"></i></a></td>
									</tr>
								@endforeach
							@else
								<tr class="border-b">
									<td class="text-center">
										There are no any wishlist available. <a href="{{route('product-grids')}}" style="color:blue;">Continue shopping</a>

									</td>
								</tr>
							@endif


						</tbody>
					</table>
					<!--/ End Shopping Summery -->
				</div>
			</div>
		</div>
	</section>
	<!--/ End Shopping Cart -->

	<!-- Start Shop Services Area  -->
	{{-- <section class="py-[40px] bg-[#ce1212]/10 mb-[24px]">
		<div class="!container px-6 mx-auto">
			<div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-5">
				<div>
					<!-- Start Single Service -->
					<div class="flex items-center">
						<i class="fa fa-rocket text-[33px]" aria-hidden="true"></i>
						<div class="ml-[15px]">
							<h4 class="text-[16px] mb-[10px] font-semibold">Free shiping</h4>
							<p class="text-[14px] font-medium">Orders over £100</p>
						</div>
					</div>
					<!-- End Single Service -->
				</div>
				<div>
					<!-- Start Single Service -->
					<div class="flex items-center">
						<i class="fa fa-refresh text-[30px]" aria-hidden="true"></i>
						<div class="ml-[15px]">
							<h4 class="text-[16px] mb-[10px] font-semibold">Free Return</h4>
							<p class="text-[14px] font-medium">Within 30 days returns</p>
						</div>
					</div>
					<!-- End Single Service -->
				</div>
				<div>
					<!-- Start Single Service -->
					<div class="flex items-center">
						<i class="fa fa-lock text-[35px]" aria-hidden="true"></i>
						<div class="ml-[15px]">
							<h4 class="text-[16px] mb-[10px] font-semibold">Secure Payment</h4>
							<p class="text-[14px] font-medium">100% secure payment</p>
						</div>
					</div>
					<!-- End Single Service -->
				</div>
				<div>
					<!-- Start Single Service -->
					<div class="flex items-center">
						<i class="fa fa-tag text-[30px]" aria-hidden="true"></i>
						<div class="ml-[15px]">
							<h4 class="text-[16px] mb-[10px] font-semibold">Best Price</h4>
							<p class="text-[14px] font-medium">Guaranteed price</p>
						</div>
					</div>
					<!-- End Single Service -->
				</div>
			</div>
		</div>
	</section> --}}
	<!-- End Shop Newsletter -->

	{{-- @include('frontend.layouts.newsletter') --}}



	<!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row no-gutters">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <!-- Product Slider -->
									<div class="product-gallery">
										<div class="quickview-slider-active">
											<div class="single-slider">
												<img src="images/modal1.jpg" alt="#">
											</div>
											<div class="single-slider">
												<img src="images/modal2.jpg" alt="#">
											</div>
											<div class="single-slider">
												<img src="images/modal3.jpg" alt="#">
											</div>
											<div class="single-slider">
												<img src="images/modal4.jpg" alt="#">
											</div>
										</div>
									</div>
								<!-- End Product slider -->
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="quickview-content">
                                    <h2>Flared Shift Dress</h2>
                                    <div class="quickview-ratting-review">
                                        <div class="quickview-ratting-wrap">
                                            <div class="quickview-ratting">
                                                <i class="yellow fa fa-star"></i>
                                                <i class="yellow fa fa-star"></i>
                                                <i class="yellow fa fa-star"></i>
                                                <i class="yellow fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <a href="#"> (1 customer review)</a>
                                        </div>
                                        <div class="quickview-stock">
                                            <span><i class="fa fa-check-circle-o"></i> in stock</span>
                                        </div>
                                    </div>
                                    <h3>$29.00</h3>
                                    <div class="quickview-peragraph">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia iste laborum ad impedit pariatur esse optio tempora sint ullam autem deleniti nam in quos qui nemo ipsum numquam.</p>
                                    </div>
									<div class="size">
										<div class="row">
											<div class="col-lg-6 col-12">
												<h5 class="title">Size</h5>
												<select>
													<option selected="selected">s</option>
													<option>m</option>
													<option>l</option>
													<option>xl</option>
												</select>
											</div>
											<div class="col-lg-6 col-12">
												<h5 class="title">Color</h5>
												<select>
													<option selected="selected">orange</option>
													<option>purple</option>
													<option>black</option>
													<option>pink</option>
												</select>
											</div>
										</div>
									</div>
                                    <div class="quantity">
										<!-- Input Order -->
										<div class="input-group">
											<div class="button minus">
												<button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
													<i class="ti-minus"></i>
												</button>
											</div>
											<input type="text" name="quant[1]" class="input-number"  data-min="1" data-max="1000" value="1">
											<div class="button plus">
												<button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
													<i class="ti-plus"></i>
												</button>
											</div>
										</div>
										<!--/ End Input Order -->
									</div>
									<div class="add-to-cart">
										<a href="#" class="btn">Add to cart</a>
										<a href="#" class="btn min"><i class="ti-heart"></i></a>
										<a href="#" class="btn min"><i class="fa fa-compress"></i></a>
									</div>
                                    <div class="default-social">
										<h4 class="share-now">Share:</h4>
                                        <ul>
                                            <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li><a class="youtube" href="#"><i class="fa fa-pinterest-p"></i></a></li>
                                            <li><a class="dribbble" href="#"><i class="fa fa-google-plus"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal end -->
</main>

@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
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
				var pd = $inputs.attr('data-product');
				var url = new URL($('.pd-'+pd).attr('href'));
				var search_params = url.searchParams;

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
				search_params.set('quantity', qty);
				url.search = search_params.toString();

				// the new url string
				var new_url = url.toString();
				$('.pd-'+pd).attr('href',new_url);

				// output : http://demourl.com/path?id=101&topic=main
				// console.log(new_url);
				// console.log('this is count: ', qty);
				// console.log('this is pd: ', pd);
				// console.log('this is URL: ', url);

				// callAjaxIncreaseCountInCart($input.attr('data-preference'),$this.attr('data-product_id'), $this.attr('data-user_id'),qty);
			});

			$countBtn.click(function () {
				var operator = this.dataset.action;
				var $this = $(this);
				var $input = $this.siblings(".product-qty");
				var qty = parseInt($input.val());
				var pd = $input.attr('data-product');
				var url = new URL($('.pd-'+pd).attr('href'));
				var search_params = url.searchParams;

				if (operator == "add") {
					qty += 1;
					if (qty >= qtyMin + 1) {
						$this.siblings(".qty-count--minus").attr("disabled", false);
					}

					if (qty >= qtyMax) {
						$this.attr("disabled", true);
					}
				} else {
					qty = qty <= qtyMin ? qtyMin : (qty -= 1);
					
					if (qty == qtyMin) {
						$this.attr("disabled", true);
					}

					if (qty < qtyMax) {
						$this.siblings(".qty-count--add").attr("disabled", false);
					}
				}

				$input.val(qty);
				search_params.set('quantity', qty);
				url.search = search_params.toString();

				// the new url string
				var new_url = url.toString();
				$('.pd-'+pd).attr('href',new_url);

				// console.log(new_url);
				// console.log(pd);
				// console.log(url);
				// callAjaxIncreaseCountInCart($input.attr('data-preference'),$input.attr('data-product_id'), $input.attr('data-user_id'),qty);
			});
		})();
		});



		// function callAjaxIncreaseCountInCart(preference,product_id,user_id,qty){
		// 	console.log('tese are: ',product_id,' and ',user_id,' and ',qty);
		// 	$.ajax({
		// 		url: '{{ route('cart.ajax') }}',
		// 		type: 'GET',
		// 		data: {
		// 			product_id : product_id,
		// 			user_id : user_id,
		// 			qty : qty,
		// 			preference: preference
		// 		},
		// 		dataType: 'json',
		// 		success: function(response) {
		// 			console.log(response);
		// 			if(response.success){
		// 				var tr_class = ".tr-"+product_id;
		// 				$(tr_class+" td:nth-child(5) span").html("£"+response.net_price);
		// 				$(tr_class+" td:nth-child(7) span").html("£"+response.cart_vat);
		// 				$(tr_class+" td:nth-child(8) span").html("£"+response.cart_amount);

		// 				$('#cart_subtotal span').html("£"+response.cart_subtotal);
		// 				$('#total_vart span').html("£"+response.total_vart);
		// 				$('#grand_total span').html("£"+response.grand_total);
		// 				// $(tr_class+" td:nth-of-child(5) span").html("£"+response.net_price);
		// 			}
		// 		},
		// 		error: function(xhr) {
		// 			//Do Something to handle error
		// 			console.log(xhr);
		// 		}
		// 	});
		// }
	</script>
@endpush
