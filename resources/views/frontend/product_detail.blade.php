@extends('frontend.layouts.master')

@section('title','Cater-Choice || PRODUCT DETAIL')
@section('main-content')
	<style>
		.free-products-table {
			border-collapse: separate;
			border-spacing: 0; /* Set border-spacing to 0 to remove spacing between cells */
			width: 100%;
			border: 1px solid #ccc; /* Add a border around the entire table */
		}

		.free-products-table th, .free-products-table td {
			padding: 8px;
			text-align: left;
		}

		/* Optional: Add some spacing between table cells */
		.product-name-cell,
		.product-price-cell {
			padding-left: 10px;
		}
	</style>
<main>
	<!-- Breadcrumbs -->
	<div class="w-full bg-[#ce1212]/10 py-[15px]">
		<div class="!container px-6 mx-auto">
			<div class="flex items-center">
				<div class="grow">
					<nav>
						<ol class="flex items-center">
							<li class="list-unstyled"><a href="{{route('home')}}">Home </a></li>
							<li class="list-unstyled text-[#ce1212] ml-1" aria-current="page"> / Product Details</li>
						</ol>
					</nav>
				</div>
				<div class="grow text-right">
					<h2 class="text-[16px] font-bold">Product Details</h2>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->

	<!-- Shop Single -->
	<section class="py-[40px]">
		<div class="!container px-6 mx-auto">
			<div class="grid lg:grid-cols-12 grid-cols-1 !gap-8">
				<div class="xl:col-span-4 lg:col-span-5">
					<!-- Product Slider -->
					<div class="!border !border-[#ce1212]/10 text-center rounded-[10px] p-[15px] hover:!border-[#ce1212] transition duration-300">
						<div class="product-gallery swiper w-full">
							<div class="swiper-wrapper">
								@php
									$photo=explode(',',$product_detail->image);
								@endphp
								@foreach($photo as $data)
								<div class="swiper-slide min-h-[400px] flex flex-column justify-center">
									<div class=" flex justify-center items-center">
										<div data-thumb="{{asset('storage/'.$data)}}" rel="adjustX:10, adjustY:">
											{{-- <img src="{{asset('storage/'.$data)}}" class="w-full object-center object-contain" alt="{{$data}}"> --}}
											@php
												$data = str_replace('storage/','',$data);
											@endphp
											<img src="{{image_url('storage/'.$data)}}" class="w-full object-center object-contain" alt="{{$data}}">
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
					</div>
					<div class="thumbnail-swiper swiper w-full mt-3">
						<div class="swiper-wrapper">
							@foreach($photo as $data)
								<div class="swiper-slide !border !border-[#ce1212]/10 text-center rounded-[10px] p-[10px] hover:!border-[#ce1212] transition duration-300">
									{{-- <img src="{{asset('storage/'.$data)}}" alt="{{$data}}"> --}}
									@php
										$data = str_replace('storage/','',$data);
									@endphp
									<img src="{{image_url('storage/'.$data)}}" alt="{{$data}}">
								</div>
							@endforeach
						</div>
					</div>
					<!-- End Product slider -->
				</div>
				<div class="xl:col-span-8 lg:col-span-7">
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

					@if ($message = Session::get('warning'))
					<div class="alert alert-warning alert-block">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<strong>{{ $message }}</strong>
					</div>
					@endif

					@if ($message = Session::get('info'))
					<div class="alert alert-info alert-block">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<strong>{{ $message }}</strong>
					</div>
					@endif

					@if ($errors->any())
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert">×</button>
						Please check the form below for errors
					</div>
					@endif
					<h1 class="sm:text-[2.5rem] text-[20px] font-semibold mb-[25px]">{{$product_detail->name}}</h1>
					<h5 class="sm:text-[1rem] text-[10px] font-medium mb-[10px]"><strong>Product Code :</strong> {{$product_detail->ms_id}}</h5>
					<h5 class="sm:text-[1rem] text-[10px] font-medium mb-[10px]"><strong>Pack Size    :</strong> {{$product_detail->pack_size}}</h5>
					{{-- <h5 class="sm:text-[1rem] text-[10px] font-medium mb-[10px]"><strong>Pack Price    :</strong> @if(\Auth::guard('customer')->user()) {{$product_detail->price}} @else <a href="{{route('customer.login')}}">Login </a> to See the price. @endif</h5> --}}
					@if(!\Auth::guard('customer')->user())
							<div class="d-flex custom_design_hm productdetailsprice">
								<div class="collectionPrice">
                                                            <span class="d-flex">
                                                                            <h3>Collection</h3>
                                                               @if($product_detail->Fullprice->price != 0)
																	<div class="caseprice">
																	{{--<small>Single Price: (Pickup)</small>--}}
                                                                    <strong>£{{ ($product_detail->Fullprice->price)?number_format($product_detail->Fullprice->price,2):0 }}</strong>
                                                                    </div>
																@endif

																@if($product_detail->Fullprice->p_price != 0)
																	<div class="singleprice">
																	{{--<small>Pack Price: (Pickup)</small>--}}
                                                                    <strong>£{{ ($product_detail->Fullprice->p_price)?number_format($product_detail->Fullprice->p_price,2):0 }}</strong>
                                                                </div>
																@endif
                                                            </span>
								</div>
								<div class="caseorsingle">
									<h3></h3>
									@if($product_detail->Fullprice->price != 0)
										<span>Single</span>
									@endif
									@if($product_detail->Fullprice->p_price != 0)
										<span>Case</span>
									@endif
								</div>
								<div class="deliveryPrice">
                                                        <span class="d-flex">
                                                             <h3>Delivery</h3>
                                                             @if($product_detail->Fullprice->delivery_single != 0)
																<div class="singleprice">
																{{--<small>Single Price: (Delivery)</small>--}}
                                                                <strong>£{{ ($product_detail->Fullprice->delivery_single)?number_format($product_detail->Fullprice->delivery_single,2):0 }}</strong>
                                                            </div>
															@endif
															@if($product_detail->Fullprice->delivery_pack != 0)
																<div class="caseprice">
																{{--<small>Pack Price: (Delivery)</small>--}}
                                                                <strong>£{{ ($product_detail->Fullprice->delivery_pack)?number_format($product_detail->Fullprice->delivery_pack,2):0 }}</strong>
                                                                </div>
															@endif


                                                        </span>
								</div>
							</div>
					{{--	<h5 class="sm:text-[1rem] text-[10px] font-medium mb-[10px]"><strong>Delivery Price (SINGLE):</strong>£{{($product_detail->delivery_single)?$product_detail->delivery_single:0}}</h5>
						<h5 class="sm:text-[1rem] text-[10px] font-medium mb-[10px]"><strong>Delivery Price (CASE):</strong>£{{($product_detail->delivery_pack)?$product_detail->delivery_pack:0}}</h5>
						<h5 class="sm:text-[1rem] text-[10px] font-medium mb-[10px]"><strong>Pickup Price (SINGLE):</strong>£{{($product_detail->price)?$product_detail->price:0}}</h5>
						<h5 class="sm:text-[1rem] text-[10px] font-medium mb-[10px]"><strong>Pickup Price (CASE):</strong>£{{($product_detail->p_price)?$product_detail->p_price:0}}</h5>--}}
						<h5 class="sm:text-[1rem] text-[10px] font-medium mb-[10px]">Please Login to Add to Cart</h5>
					@endif
					{{-- <h5 class="sm:text-[1rem] text-[10px] font-medium mb-[10px]"><strong>Product Description    :</strong> {!! ($product_detail[0]->description) !!} --}}
					{{-- <p>{!! ($product_detail[0]->description) !!}</p> --}}
					<!-- Product Buy -->
					@if(\Auth::guard('customer')->user())
					<div class="container btn_container">

{{--						@if (\Auth::guard('customer')->user()->checkout_preference == "delivery")--}}
{{--							@if ($product_detail->Fullprice->delivery_pack > 0 && $product_detail->Fullprice->delivery_single <= 0)--}}
{{--							<button class="btn price_selector selected_price" data-type="CASE">Pack Price: £{{($product_detail->delivery_pack)?$product_detail->delivery_pack:0}} </button>--}}
{{--							@endif--}}
{{--							@if ($product_detail->Fullprice->delivery_single > 0 && $product_detail->Fullprice->delivery_pack <= 0)--}}
{{--							<button class="btn price_selector selected_price" data-type="SINGLE">Single Price: £{{($product_detail->Fullprice->delivery_single)?$product_detail->Fullprice->delivery_single:0}} </button>--}}
{{--							@endif--}}
{{--							@if ($product_detail->Fullprice->delivery_single > 0 && $product_detail->Fullprice->delivery_pack > 0)--}}
{{--							<button class="btn price_selector selected_price" data-type="CASE">Pack Price: £{{($product_detail->Fullprice->delivery_pack)?$product_detail->Fullprice->delivery_pack:0}} </button>--}}
{{--							<button class="btn price_selector " data-type="SINGLE">Single Price: £{{($product_detail->Fullprice->delivery_single)?$product_detail->Fullprice->delivery_single:0}} </button>--}}
{{--							@endif--}}

{{--						@endif--}}

{{--						@if (\Auth::guard('customer')->user()->checkout_preference == "pickup")--}}
{{--							@if ($product_detail->Fullprice->p_price > 0 && $product_detail->Fullprice->price <= 0 )--}}
{{--							<button class="btn price_selector selected_price" data-type="CASE">Pack Price: £{{($product_detail->Fullprice->p_price)?$product_detail->Fullprice->p_price:0}} </button>--}}
{{--							@endif--}}
{{--							@if ($product_detail->Fullprice->price > 0 && $product_detail->Fullprice->p_price <= 0)--}}
{{--							<button class="btn price_selector selected_price" data-type="SINGLE">Single Price: £{{($product_detail->Fullprice->price)?$product_detail->Fullprice->price:0}} </button>--}}
{{--							@endif--}}
{{--							@if ($product_detail->Fullprice->price > 0 && $product_detail->Fullprice->p_price > 0)--}}
{{--							<button class="btn price_selector selected_price" data-type="CASE">Pack Price: £{{($product_detail->Fullprice->p_price)?$product_detail->Fullprice->p_price:0}} </button>--}}
{{--							<button class="btn price_selector" data-type="SINGLE">Single Price: £{{($product_detail->Fullprice->price)?$product_detail->Fullprice->price:0}} </button>--}}
{{--							@endif--}}

{{--						@endif--}}
						@if (\Auth::guard('customer')->user()->checkout_preference == "delivery")
							@if ($product_detail->Fullprice)
								@if ($product_detail->Fullprice->delivery_pack > 0 && $product_detail->Fullprice->delivery_single <= 0)
									<button class="btn price_selector selected_price" data-type="CASE">Pack Price: £{{ $product_detail->Fullprice->delivery_pack }}</button>
								@endif
								@if ($product_detail->Fullprice->delivery_single > 0 && $product_detail->Fullprice->delivery_pack <= 0)
									<button class="btn price_selector selected_price" data-type="SINGLE">Single Price: £{{ $product_detail->Fullprice->delivery_single }}</button>
								@endif
								@if ($product_detail->Fullprice->delivery_single > 0 && $product_detail->Fullprice->delivery_pack > 0)
									<button class="btn price_selector selected_price" data-type="CASE">Pack Price: £{{ $product_detail->Fullprice->delivery_pack }}</button>
									<button class="btn price_selector" data-type="SINGLE">Single Price: £{{ $product_detail->Fullprice->delivery_single }}</button>
								@endif
							@endif
						@endif

						@if (\Auth::guard('customer')->user()->checkout_preference == "pickup")
							@if ($product_detail->Fullprice)
								@if ($product_detail->Fullprice->p_price > 0 && $product_detail->Fullprice->price <= 0)
									<button class="btn price_selector selected_price" data-type="CASE">Pack Price: £{{ $product_detail->Fullprice->p_price }}</button>
								@endif
								@if ($product_detail->Fullprice->price > 0 && $product_detail->Fullprice->p_price <= 0)
									<button class="btn price_selector selected_price" data-type="SINGLE">Single Price: £{{ $product_detail->Fullprice->price }}</button>
								@endif
								@if ($product_detail->Fullprice->price > 0 && $product_detail->Fullprice->p_price > 0)
									<button class="btn price_selector selected_price" data-type="CASE">Pack Price: £{{ $product_detail->Fullprice->p_price }}</button>
									<button class="btn price_selector" data-type="SINGLE">Single Price: £{{ $product_detail->Fullprice->price }}</button>
								@endif
							@endif
						@endif


						{{-- @if ($product_detail->delivery_price != null && $product_detail->delivery_price > 0)
							<button class="btn price_selector selected_price" data-type="delivery">Delivery Price: £{{($product_detail->delivery_price)?$product_detail->delivery_price:0}} </button>
						@endif
						@if ($product_detail->p_price != null && $product_detail->p_price > 0)
							<button class="btn price_selector" data-type="pickup">Pickup Price: £{{($product_detail->p_price)?$product_detail->p_price:0}} </button>
						@endif --}}


					</div>
					<form action="{{route('single-add-to-cart')}}" method="POST">
						@csrf
						<div class="flex items-center gap-3 mt-4">
							<h6 class="text-[1rem] font-medium">Quantity :</h6>
{{--							@if (\Auth::guard('customer')->user()->checkout_preference == "delivery")--}}
{{--								@if ($product_detail->Fullprice->delivery_pack > 0 && $product_detail->Fullprice->delivery_single <= 0)--}}
{{--								<input type="hidden" name="type" value="CASE" />--}}
{{--								@endif--}}
{{--								@if ($product_detail->Fullprice->delivery_pack <= 0 && $product_detail->Fullprice->delivery_single > 0)--}}
{{--								<input type="hidden" name="type" value="SINGLE" />--}}
{{--								@endif--}}
{{--								@if ($product_detail->Fullprice->delivery_pack > 0 && $product_detail->Fullprice->delivery_single > 0)--}}
{{--								<input type="hidden" name="type" value="CASE" />--}}
{{--								@endif--}}
{{--							@else--}}
{{--								@if ($product_detail->Fullprice->p_price > 0 && $product_detail->Fullprice->price <= 0)--}}
{{--								<input type="hidden" name="type" value="CASE" />--}}
{{--								@endif--}}
{{--								@if ($product_detail->Fullprice->p_price <= 0 && $product_detail->Fullprice->price > 0)--}}
{{--								<input type="hidden" name="type" value="SINGLE" />--}}
{{--								@endif--}}
{{--								@if ($product_detail->Fullprice->p_price > 0 && $product_detail->Fullprice->price > 0)--}}
{{--								<input type="hidden" name="type" value="CASE" />--}}
{{--								@endif--}}
{{--							@endif--}}

							@if (\Auth::guard('customer')->user()->checkout_preference == "delivery")
								@if ($product_detail->Fullprice)
									@if ($product_detail->Fullprice->delivery_pack > 0 && $product_detail->Fullprice->delivery_single <= 0)
										<input type="hidden" name="type" value="CASE" />
									@endif
									@if ($product_detail->Fullprice->delivery_pack <= 0 && $product_detail->Fullprice->delivery_single > 0)
										<input type="hidden" name="type" value="SINGLE" />
									@endif
									@if ($product_detail->Fullprice->delivery_pack > 0 && $product_detail->Fullprice->delivery_single > 0)
										<input type="hidden" name="type" value="CASE" />
									@endif
								@endif
							@else
								@if ($product_detail->Fullprice)
									@if ($product_detail->Fullprice->p_price > 0 && $product_detail->Fullprice->price <= 0)
										<input type="hidden" name="type" value="CASE" />
									@endif
									@if ($product_detail->Fullprice->p_price <= 0 && $product_detail->Fullprice->price > 0)
										<input type="hidden" name="type" value="SINGLE" />
									@endif
									@if ($product_detail->Fullprice->p_price > 0 && $product_detail->Fullprice->price > 0)
										<input type="hidden" name="type" value="CASE" />
									@endif
								@endif
							@endif

							{{-- @if ($product_detail->p_price > 0 && $product_detail->price > 0)
								<input type="hidden" name="type" value="delivery" />
							@elseif ($product_detail->p_price > 0 && $product_detail->price <= 0)
								<input type="hidden" name="type" value="CASE" />
							@elseif ($product_detail->p_price <= 0 && $product_detail->price > 0)
								<input type="hidden" name="type" value="SINGLE" />
							@endif --}}
							<input type="hidden" name="preference" value="{{  \Auth::guard('customer')->user()->checkout_preference  }}" >
							<input type="hidden" name="slug" value="{{$product_detail->slug}}">
							<input type="hidden" name="product_id" value="{{ $product_detail->id}}">
							<div class="qty-input">
								<button class="qty-count qty-count--minus" data-action="minus" type="button">-</button>
								<input class="product-qty" type="number" name="quant[1]"  class="w-[70px] p-[8px_5px] rounded-[5px] !border border-[#ce1212]/10" min="1" max="10" data-min="1" data-max="10" value="1" id="quantity">
								<button class="qty-count " data-action="add" type="button">+</button>
							</div>
							{{-- <input type="number" name="quant[1]" class="w-[70px] p-2 border rounded-[5px]" min="1" max="10"  data-min="1" data-max="10" value="1" id="quantity" /> --}}
						</div>
						<div class="flex items-center flex-wrap gap-3 mt-4">
							@if($stock == 0 AND $warehouse_id != 0)
								{{-- @if ($product_detail->stock->isNotEmpty() && $product_detail->stock->warehouse_id != \Auth::guard('customer')->user()->warehouse) --}}
									<button type="submit" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold disabled:opacity-70" disabled>Add to cart</button>
									<a href="{{route('add-to-wishlist',$product_detail->slug)}}" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold opacity-70">
										<i class="fa fa-heart-o"></i>
									</a>
									<p class="text-red w-full">Sorry Stock Not Available in Your Location .</p>
								{{-- @else --}}
									{{-- <button type="submit" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold disabled:opacity-70" disabled>Add to cart</button>
									<a href="{{route('add-to-wishlist',$product_detail->slug)}}" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold opacity-70">
										<i class="fa fa-heart-o"></i>
									</a>  --}}
								{{-- @endif --}}
							@else
{{--								@if (\Auth::guard('customer')->user()->checkout_preference == "delivery")--}}
{{--									@if ($product_detail->Fullprice->delivery_pack > 0 || $product_detail->Fullprice->delivery_single > 0 )--}}
{{--										<button type="submit" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold">Add to cart</button>--}}
{{--										<a href="{{route('add-to-wishlist',$product_detail->slug)}}" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold"><i class="fa fa-heart-o"></i></a>--}}
{{--									@else--}}
{{--										<p class="text-red w-full">Sorry, product price not configured.</p>--}}
{{--									@endif--}}
{{--								@else--}}
{{--								@if ($product_detail->Fullprice->p_price > 0 || $product_detail->Fullprice->price > 0 )--}}
{{--									<button type="submit" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold">Add to cart</button>--}}
{{--									<a href="{{route('add-to-wishlist',$product_detail->slug)}}" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold"><i class="fa fa-heart-o"></i></a>--}}
{{--								@else--}}
{{--									<p class="text-red w-full">Sorry, product price not configured.</p>--}}
{{--								@endif--}}
{{--								@endif--}}
								@if (\Auth::guard('customer')->user()->checkout_preference == "delivery")
									@if ($product_detail->Fullprice)
										@if ($product_detail->Fullprice->delivery_pack > 0 || $product_detail->Fullprice->delivery_single > 0)
											<button type="submit" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold">Add to cart</button>
											<a href="{{ route('add-to-wishlist', $product_detail->slug) }}" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold"><i class="fa fa-heart-o"></i></a>
										@else
											<p class="text-red w-full">Sorry, product price not configured.</p>
										@endif
									@else
										<p class="text-red w-full">Sorry, product price not configured.</p>
									@endif
								@else
									@if ($product_detail->Fullprice)
										@if ($product_detail->Fullprice->p_price > 0 || $product_detail->Fullprice->price > 0)
											<button type="submit" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold">Add to cart</button>
											<a href="{{ route('add-to-wishlist', $product_detail->slug) }}" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold"><i class="fa fa-heart-o"></i></a>
										@else
											<p class="text-red w-full">Sorry, product price not configured.</p>
										@endif
									@else
										<p class="text-red w-full">Sorry, product price not configured.</p>
									@endif
								@endif

							@endif
						</div>
{{--						@if($product_detail->freeProduct)--}}
{{--							<br>--}}
{{--							<h2><b>Free Products</b></h2>--}}
{{--							<br>--}}
{{--							@foreach ($product_detail->freeProduct as $freeProduct)--}}
{{--								@php--}}
{{--									$free_pro = App\Product::where('id', $freeProduct->free_product_id)->get();--}}
{{--								@endphp--}}
{{--								@foreach ($free_pro as $pro)--}}
{{--									<p>{{$pro->name}} &nbsp;&nbsp; £{{$pro->price}} </p>--}}
{{--									<br>--}}
{{--								@endforeach--}}

{{--							@endforeach--}}
{{--						@endif--}}
						@if(count($product_detail->freeProduct)>0)
							<br>
							<h2><b>Free Products</b></h2>
							<br>
							<table class="free-products-table">
								<thead>
								<tr>
									<th>Image</th>
									<th>Name</th>
									<th>Price</th>
								</tr>
								</thead>
								<tbody>
								@foreach ($product_detail->freeProduct as $freeProduct)
									@php
										$free_pro = App\Product::where('id', $freeProduct->free_product_id)->get();
									@endphp
									@foreach ($free_pro as $pro)
										<tr>
											<td class="product-image-cell">
												<img src="{{ asset('path_to_your_product_image_directory/' . $pro->image) }}" alt="{{ $pro->name }}" width="100">
											</td>
											<td class="product-name-cell">{{ $pro->name }}</td>
											<td class="product-price-cell">£{{ $pro->price }}</td>
										</tr>
									@endforeach
								@endforeach
								</tbody>
							</table>
						@endif

					</form>
					<!--/ End Product Buy -->
					@endif
					<div class="accordion grid sm:grid-cols-2 grid-cols-1 gap-4 mt-4" id="accordionExample">
						<div class="flex flex-col gap-4">
							<div class="accordion-item rounded-[4px] border">
								<h2 class="accordion-header" id="headingOne">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
									Description
								</button>
								</h2>
								<div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										{!! $product_detail->product_details !!}
									</div>
								</div>
							</div>
							<div class="accordion-item rounded-[4px] border">
								<h2 class="accordion-header" id="headingThree">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
									Allergens
								</button>
								</h2>
								<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										{!! $product_detail->allergens !!}
									</div>
								</div>
							</div>
						</div>
						<div class="flex flex-col gap-4">
							<div class="accordion-item rounded-[4px] border">
								<h2 class="accordion-header" id="headingTwo">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
									Ingredients
								</button>
								</h2>
								<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										{!! $product_detail->ingredients !!}
									</div>
								</div>
							</div>
							<div class="accordion-item rounded-[4px] border">
								<h2 class="accordion-header" id="headingFour">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
									Pack Size
								</button>
								</h2>
								<div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="collapseFour" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										{!! $product_detail->packing_info !!}
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--/ End Shop Single -->

	<!-- Start Most Popular -->
    <section class="pt-[40px] pb-[110px]">
      	<div class="!container !px-6 mx-auto relative">
			<div class="pb-8 pr-[100px]">
				<h2 class="text-[35px] mb-[20px] font-extrabold">Related Products</h2>
			</div>
			<div class="single-product swiper w-full">
				<div class="swiper-wrapper">
					@foreach($product_p as $product)
						@if($product->id !==$product_detail->id)
							<!-- Start Single Product -->
							<div class="swiper-slide flex flex-column justify-center">
								@include('frontend.layouts.product')
								{{-- <div class="bg-white !border !border-[#ce1212]/10 rounded-[5px] p-[15px] group">
									<div class="mb-[15px] relative w-full min-h-[150px]">
										<a href="{{route('product-detail',$data->slug)}}">
											@php
												$photo=explode(',',$data->image);
											@endphp
											<img class="w-[50%] mx-auto transform group-hover:scale-110 transition duration-300"  src="{{asset('storage/thumbnail/'.$photo[0])}}" alt="{{$photo[0]}}">
										</a>
									</div>
									<div class="text-center">
										<h3><a href="{{route('product-detail',$data->slug)}}" class="hover:text-[#ce1212] font-bold mb-[5px]">{{$data->name}}</a></h3>
										<div class="text-[14px] font-medium py-[5px] truncate">Product Code: <strong>{{ $data->ms_id }}</strong></div>
										<div class="text-[14px] font-medium py-[5px] truncate">Package Size:  <strong>{{ $data->pack_size }}</strong></div>
										<div class="text-[14px] font-medium py-[5px] truncate">Pack Price:  <strong>£{{ ($data->p_price)?$data->p_price:0 }}</strong></div>
										<div class="text-[14px] font-medium py-[5px] truncate">Single Price:  <strong>£{{ ($data->price)?$data->price:0 }}</strong></div>
										@if(\Auth::guard('customer')->user())
										{{-- </?php //dd($products->stock[0]->stocks); ?> --}}
										{{-- <form action="{{route('single-add-to-cart')}}" method="POST">
										@csrf
										<div class="flex items-center gap-2 !mt-6">
											<input type="hidden" name="quant" value="1">
											<input type="hidden" name="slug" value="{{  $data->slug }}">
											<input type="hidden" name="product_id" value="{{ $data->id}}">
											<input type="hidden" name="home" value="singular">
											@if ($data->price > 0 && $data->p_price <= 0)
											@if (Helper::checkWarehouseOfProduct($data->id,\Auth::guard('customer')->user()->warehouse))
												<button class="TWOHM bg-[#ce1212]/10 text-[#ce1212] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#ce1212] hover:text-white" type="submit">Add to Cart</button>
											@else
												<a href="#" class="TWOHM bg-[#ce1212]/10 text-[#ce1212] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#ce1212] hover:text-white">Out Of Stock</a>
											@endif
											@else
											<a href="{{ route('product-detail', $data->slug?? ' ') }}" class="bg-[#ce1212]/10 text-[#ce1212] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#ce1212] hover:text-white">See Details</a>
											@endif
											<a href="{{ route('product-detail', $data->slug?? ' ') }}" class="bg-[#ce1212]/10 hover:bg-[#ce1212] hover:text-white text-[#ce1212] p-[10px_15px] rounded-[50%] w-[32px] h-[32px] flex items-center justify-center ml-auto">
											<i class="fa fa-eye  text-[14px]" aria-hidden="true"></i>
											</a>
										</div>
										</form>
										@endif
									</div>
								</div> --}}
							</div>
							<!-- End Single Product -->
						@endif
					@endforeach
				</div>
			</div>
			<div class="swiper-button-prev single-button-prev after:content-[''] w-[40px] h-[40px] rounded-full bg-[#ce1212]/10 transition duration-500 top-[22px] right-12 left-[unset]">
				<i class="fa fa-angle-left text-black text-[22px]" aria-hidden="true"></i>
			</div>
			<div class="swiper-button-next single-button-next after:content-[''] w-[40px] h-[40px] rounded-full bg-[#ce1212]/10 transition duration-500 top-[22px] right-0">
				<i class="fa fa-angle-right text-black text-[22px]" aria-hidden="true"></i>
			</div>
		</div>
    </section>
	<!-- End Most Popular Area -->

</main>
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
				// callAjaxIncreaseCountInCart($input.attr('data-preference'),$this.attr('data-product_id'), $this.attr('data-user_id'),qty);
			});

			$countBtn.click(function () {
				var operator = this.dataset.action;
				var $this = $(this);
				var $input = $this.siblings(".product-qty");
				var qty = parseInt($input.val());

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

@endsection
