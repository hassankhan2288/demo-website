@extends('frontend.layouts.master')
@section('title','Cater-Choice || Home Page')
@section('main-content')

  <main>
    <!-- hero section start -->
    <section class="p-0 main_web">
      <div class="slides-hero swiper group">
        <div class="swiper-wrapper">
          @foreach ($slider as $key=>$sliders )
            <div class="swiper-slide flex flex-column justify-center xl:h-[64vh] lg:h-[50vh] md:h-[40vh] sm:h-[30vh] h-[25vh]">
              <a href="{{ $sliders->link }}"><img src="{{$sliders->photo}}" class="w-full h-full" /></a>
            </div>
          @endforeach
        </div>
        <div class="swiper-button-prev hero-button-prev after:content-[''] w-[40px] h-[40px] rounded-full bg-[#ce1212] !opacity-0 group-hover:!opacity-100 transition duration-500">
          <i class="fa fa-angle-left text-white text-[22px]" aria-hidden="true"></i>
        </div>
        <div class="swiper-button-next hero-button-next after:content-[''] w-[40px] h-[40px] rounded-full bg-[#ce1212] !opacity-0 group-hover:!opacity-100 transition duration-500">
          <i class="fa fa-angle-right text-white text-[22px]" aria-hidden="true"></i>
        </div>
      </div>
    </section>
    <!-- hero section end -->

     <!-- hero section For mobile start -->
     <section class="p-0 main_mobile">
      <div class="slides-hero swiper group">
        <div class="swiper-wrapper">
          @foreach ($mobile_slider as $key=>$msliders )
            <div class="swiper-slide flex flex-column justify-center xl:h-[64vh] lg:h-[50vh] md:h-[40vh] sm:h-[50vh] h-[50vh]">
              <a href="{{ $msliders->link }}"><img src="{{$msliders->photo}}" class="w-full h-full" /></a>
            </div>
          @endforeach
        </div>
        <div class="swiper-button-prev hero-button-prev after:content-[''] w-[40px] h-[40px] rounded-full bg-[#ce1212] !opacity-0 group-hover:!opacity-100 transition duration-500">
          <i class="fa fa-angle-left text-white text-[22px]" aria-hidden="true"></i>
        </div>
        <div class="swiper-button-next hero-button-next after:content-[''] w-[40px] h-[40px] rounded-full bg-[#ce1212] !opacity-0 group-hover:!opacity-100 transition duration-500">
          <i class="fa fa-angle-right text-white text-[22px]" aria-hidden="true"></i>
        </div>
      </div>
    </section>
    <!-- hero section for mobile end -->

    <!--   Best selling start -->
    {{-- <section class="bg-[#bfe7f5]">
      <div class="max-w-[1920px] lg:py-[20px] !pb-[60px] mx-auto flex items-center flex-wrap lg:px-0 px-6 hm_p_bottom_mobile">
        <div class="lg:w-4/12 w-full">
            <img class="w-6/12 transform lg:rotate-0 -rotate-90 lg:!mx-0 mx-auto hm_margin_mobile" src="{{asset('frontend/assets/img/patez.png')}}">
        </div>
        <div class="lg:w-6/12 w-full flex flex-col justify-center">
          <h2 class="mb-[25px] font-extrabold lg:text-[65px] md:text-[40px] text-[30px]">Best selling, High quality range of products</h2>

          <div class="flex items-center flex-wrap gap-2">
            <a href="{{route('product-grids')}}" class="bg-[#ce1212] text-white p-[15px_30px] rounded-[50px] text-[14px] font-bold">
              Check Products
            </a>
            <a href="{{route('contact')}}" class="bg-[#ce1212] text-white p-[15px_30px] rounded-[50px] text-[14px] font-bold ">
              Have Question? Contact us
            </a>
          </div>
        </div>
      </div>
    </section> --}}
    <!--   Best selling end -->
    <?php
    $productss=  App\Product::where('is_active', true)->whereIn('category_id',[258])->limit(5)->get();
    //dd($productss);
  
  ?>
    {{-- <section class="py-[60px] main_web">
      <div class="!container !px-6 mx-auto relative">
        <div class="pb-8">
          <h5 class="text-[35px] mb-[20px] font-extrabold text-[#ce1212]">NEW PRODUCTS</h5>
        </div>
        <div class="grid xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4">
          
          <!---HERE IS TEH SECOND SECTION---->
          @foreach ($productss as $key_product => $products )
          @include('frontend.layouts.product', ['product' => $products])
          
          @endforeach
        </div>
      </div>
    </section> --}}

    <section class=" py-[60px] relative before:absolute before:inset-0 before:content-['']  before:z-[1] group">
      
      <div class="!container !px-6 mx-auto relative z-[2]">
        <h5 class="text-[35px] mb-[20px] font-extrabold text-[#ce1212]">NEW PRODUCTS</h5>
        <div class="new-product-swiper swiper">
          <div class="swiper-wrapper">
            @foreach ($productss as $key_product => $products )
            <div class="swiper-slide flex flex-column justify-center">
              <div class="text-center rounded-[10px] ">
                <div class="p-[10px] w-full min-h-[100px]">
                  {{-- <img src="{{image_url($brand->image)}}" class="w-full mx-auto" /> --}}
                  @include('frontend.layouts.product', ['product' => $products])
                </div>
              </div>
            </div>
          
          @endforeach
          </div>
          <div class="swiper-button-prev brand-button-prev after:content-[''] w-[40px] h-[40px] rounded-full bg-[#ce1212] !opacity-0 group-hover:!opacity-100 transition duration-500">
            <i class="fa fa-angle-left text-white text-[22px]" aria-hidden="true"></i>
          </div>
          <div class="swiper-button-next brand-button-next after:content-[''] w-[40px] h-[40px] rounded-full bg-[#ce1212] !opacity-0 group-hover:!opacity-100 transition duration-500">
            <i class="fa fa-angle-right text-white text-[22px]" aria-hidden="true"></i>
          </div>
        </div>
      </div>
    </section>
    <section class="instagramfeeds">
      <style>
           .instagramfeeds .referral {
              display: none !important;
            }
            .feed-item.juicer {
              display: none !important;
            }
      </style>
      <script type="text/javascript" src="https://www.juicer.io/embed/wasi-h/embed-code.js" async defer></script>
    </section>
    <!-- popular categories start -->
    {{-- <section class="py-[60px]">
      <div class="!container !px-6 mx-auto relative">
        <div class="pb-8">
          <h5 class="text-[18px] mb-[20px] font-extrabold text-[#ce1212]">Choose your Categories</h5>
          <h2 class="text-[35px] mb-[20px] font-extrabold pr-[70px]">Popular Categories</h2>
        </div>
        <div class="popular-categories swiper">
          <div class="swiper-wrapper">
            <!--If for each loop here for categories start here---->
            <div class="swiper-slide flex flex-column justify-center">
              <div class="bg-[#ce1212]/10 text-center rounded-[10px] ">
                <div class="p-[15px] rounded-[0_0_50%_50%] bg-white border-b-[5px] border-[#ce1212] w-full">
                  <img src="{{asset('public/images/category/bread.jpg')}}" class="w-[120px] h-[120px] mx-auto rounded-full" />
                </div>
                <div class="p-[20px_15px]">
                  <a href="/product-cat/38" class="hover:text-[#ce1212]">Bread</a>
                </div>
              </div>
            </div>
            <div class="swiper-slide flex flex-column justify-center">
              <div class="bg-[#ce1212]/10 text-center rounded-[10px] ">
                <div class="p-[15px] rounded-[0_0_50%_50%] bg-white border-b-[5px] border-[#ce1212] w-full">
                  <img src="{{asset('public/images/category/desserts.jpg')}}" class="w-[120px] h-[120px] mx-auto rounded-full" />
                </div>
                <div class="p-[20px_15px]">
                  <a href="/product-cat/11" class="hover:text-[#ce1212]">Desserts</a>
                </div>
              </div>
            </div>
            <div class="swiper-slide flex flex-column justify-center">
              <div class="bg-[#ce1212]/10 text-center rounded-[10px] ">
                <div class="p-[15px] rounded-[0_0_50%_50%] bg-white border-b-[5px] border-[#ce1212] w-full">
                  <img src="{{asset('public/images/category/drinks.jpg')}}" class="w-[120px] h-[120px] mx-auto rounded-full" />
                </div>
                <div class="p-[20px_15px]">
                  <a href="/product-cat/1" class="hover:text-[#ce1212]">Drinks</a>
                </div>
              </div>
            </div>
            <div class="swiper-slide flex flex-column justify-center">
              <div class="bg-[#ce1212]/10 text-center rounded-[10px] ">
                <div class="p-[15px] rounded-[0_0_50%_50%] bg-white border-b-[5px] border-[#ce1212] w-full">
                  <img src="{{asset('public/images/category/fries.jpg')}}" class="w-[120px] h-[120px] mx-auto rounded-full" />
                </div>
                <div class="p-[20px_15px]">
                  <a href="/product-cat/161" class="hover:text-[#ce1212]">Fries</a>
                </div>
              </div>
            </div>
            <div class="swiper-slide flex flex-column justify-center">
              <div class="bg-[#ce1212]/10 text-center rounded-[10px] ">
                <div class="p-[15px] rounded-[0_0_50%_50%] bg-white border-b-[5px] border-[#ce1212] w-full">
                  <img src="{{asset('public/images/category/pizza.jpg')}}" class="w-[120px] h-[120px] mx-auto rounded-full" />
                </div>
                <div class="p-[20px_15px]">
                  <a href="/product-cat/45" class="hover:text-[#ce1212]">Pizza</a>
                </div>
              </div>
            </div>
            <div class="swiper-slide flex flex-column justify-center">
              <div class="bg-[#ce1212]/10 text-center rounded-[10px] ">
                <div class="p-[15px] rounded-[0_0_50%_50%] bg-white border-b-[5px] border-[#ce1212] w-full">
                  <img src="{{asset('public/images/category/packaging.jpg')}}" class="w-[120px] h-[120px] mx-auto rounded-full" />
                </div>
                <div class="p-[20px_15px]">
                  <a href="/product-cat/19" class="hover:text-[#ce1212]">Packaging</a>
                </div>
              </div>
            </div>
            <!--End foreach--->
          </div>
        </div>
        <div class="swiper-button-prev categories-button-prev after:content-[''] w-[40px] h-[40px] rounded-full bg-[#ce1212]/10 transition duration-500 top-[70px] right-12 left-[unset]">
          <i class="fa fa-angle-left text-black text-[22px]" aria-hidden="true"></i>
        </div>
        <div class="swiper-button-next categories-button-next after:content-[''] w-[40px] h-[40px] rounded-full bg-[#ce1212]/10 transition duration-500 top-[70px] right-0">
          <i class="fa fa-angle-right text-black text-[22px]" aria-hidden="true"></i>
        </div>
      </div>
    </section> --}}
    <!-- popular categories end -->

    <!-- DRINKS start -->
    {{-- <section class="py-[60px]">
      <div class="!container !px-6 mx-auto relative">
        <div class="pb-8">
          <h5 class="text-[35px] mb-[20px] font-extrabold text-[#ce1212]">DRINKS</h5>
        </div>
        <div class="grid xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4">
          <?php
          //$products=  App\Product::where('is_active', true)->whereIn('category_id',[1,34,35,36])->limit(5)->get();
          ?>
          <!---HERE IS TEH FIRST SECTION---->
          @foreach ( $products as $key_product => $product )
          @include('frontend.layouts.product', ['products' => $products])
          
          @endforeach
        </div>
      </div>
    </section> --}}
    <!-- DRINKS end --> 

    <!-- bakery start -->
    {{-- <section class="py-[60px]">
      <div class="!container !px-6 mx-auto relative">
        <div class="pb-8">
          <h5 class="text-[35px] mb-[20px] font-extrabold text-[#ce1212]">BAKERY</h5>
        </div>
        <div class="grid xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4">
          <?php
            //$productss=  App\Product::where('is_active', true)->whereIn('category_id',[4,38,39,40,41,42,43,44,45,46,47,48,49,50])->limit(5)->get();
          
          ?>
          <!---HERE IS TEH SECOND SECTION---->
          @foreach ($productss as $key_product => $products )
          @include('frontend.layouts.product', ['product' => $products])
          
          @endforeach
        </div>
      </div>
    </section> --}}
    <!-- bakery end --> 

    <!-- Brand start -->
    <section class="py-[60px] relative before:absolute before:inset-0 before:content-[''] before:bg-[#fff]/20 before:z-[1] group">
      {{-- <img src="{{image_url('storage/images/category/bread.jpg')}}" class="w-full h-full object-cover absolute inset-0"> --}}
      <div class="!container !px-6 mx-auto relative z-[2]">
        <h3 class="text-[#ce1212] text-[45px] text-center font-bold mb-8">Our <span class="text-[#ce1212]">Brands</span></h3>
        <div class="brand-swiper swiper">
          <div class="swiper-wrapper">
            @foreach ($brand_all as $key=>$brand )
            <div class="swiper-slide flex flex-column justify-center">
              <div class="text-center rounded-[10px] ">
                <div class="p-[15px] w-full min-h-[100px]">
                  <img src="{{image_url($brand->image)}}" class="w-full mx-auto" />
                </div>
              </div>
            </div>
            @endforeach
          </div>
          <div class="swiper-button-prev brand-button-prev after:content-[''] w-[40px] h-[40px] rounded-full bg-[#ce1212] !opacity-0 group-hover:!opacity-100 transition duration-500">
            <i class="fa fa-angle-left text-white text-[22px]" aria-hidden="true"></i>
          </div>
          <div class="swiper-button-next brand-button-next after:content-[''] w-[40px] h-[40px] rounded-full bg-[#ce1212] !opacity-0 group-hover:!opacity-100 transition duration-500">
            <i class="fa fa-angle-right text-white text-[22px]" aria-hidden="true"></i>
          </div>
        </div>
      </div>
    </section>
    <!-- Brand end -->

    @include('frontend/footer');
  </main><!-- End #main -->
  {{-- <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
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
	</script> --}}

  @endsection

