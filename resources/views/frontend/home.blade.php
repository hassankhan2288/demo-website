@extends('frontend.layouts.master')
@section('title','Demo|| Home Page')
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
        <div class="swiper-button-prev hero-button-prev after:content-[''] w-[40px] h-[40px] rounded-full bg-[#706233] !opacity-0 group-hover:!opacity-100 transition duration-500">
          <i class="fa fa-angle-left text-white text-[22px]" aria-hidden="true"></i>
        </div>
        <div class="swiper-button-next hero-button-next after:content-[''] w-[40px] h-[40px] rounded-full bg-[#706233] !opacity-0 group-hover:!opacity-100 transition duration-500">
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
        <div class="swiper-button-prev hero-button-prev after:content-[''] w-[40px] h-[40px] rounded-full bg-[#706233] !opacity-0 group-hover:!opacity-100 transition duration-500">
          <i class="fa fa-angle-left text-white text-[22px]" aria-hidden="true"></i>
        </div>
        <div class="swiper-button-next hero-button-next after:content-[''] w-[40px] h-[40px] rounded-full bg-[#706233] !opacity-0 group-hover:!opacity-100 transition duration-500">
          <i class="fa fa-angle-right text-white text-[22px]" aria-hidden="true"></i>
        </div>
      </div>
    </section>
    <!-- hero section for mobile end -->

    <!--   Best selling start -->
    <section class="bg-[#bfe7f5]">
      <div class="max-w-[1920px] lg:py-[20px] !pb-[60px] mx-auto flex items-center flex-wrap lg:px-0 px-6 hm_p_bottom_mobile">
        <div class="lg:w-4/12 w-full">
            <img class="w-6/12 transform lg:rotate-0 -rotate-90 lg:!mx-0 mx-auto hm_margin_mobile" src="{{asset('frontend/assets/img/patez.png')}}">
        </div>
        <div class="lg:w-6/12 w-full flex flex-col justify-center">
          <h2 class="mb-[25px] font-extrabold lg:text-[65px] md:text-[40px] text-[30px]">Best selling, High quality range of products</h2>

          <div class="flex items-center flex-wrap gap-2">
            <a href="{{route('product-grids')}}" class="bg-[#706233] text-white p-[15px_30px] rounded-[50px] text-[14px] font-bold">
              Check Products
            </a>
            <a href="{{route('contact')}}" class="bg-[#706233] text-white p-[15px_30px] rounded-[50px] text-[14px] font-bold ">
              Have Question? Contact us
            </a>
          </div>
        </div>
      </div>
    </section>
  
    <!-- popular categories start -->
    <section class="py-[60px]">
      <div class="!container !px-6 mx-auto relative">
        <div class="pb-8">
          <h5 class="text-[18px] mb-[20px] font-extrabold text-[#706233]">Choose your Categories</h5>
          <h2 class="text-[30px] mb-[20px] font-extrabold pr-[70px] text-[#706233]">POPULAR CATEGORIES</h2>
        </div>
        <div class="popular-categories swiper">
          <div class="swiper-wrapper">
            <!--If for each loop here for categories start here---->
            <div class="swiper-slide flex flex-column justify-center">
              <div class="bg-[#706233]/10 text-center rounded-[10px] ">
                <div class="p-[15px] rounded-[0_0_50%_50%] bg-white border-b-[5px] border-[#706233] w-full">
                  <img src="{{asset('public/images/category/bread.jpg')}}" class="w-[120px] h-[120px] mx-auto rounded-full" />
                </div>
                <div class="p-[20px_15px]">
                  <a href="/product-cat/38" class="hover:text-[#706233]">Bread</a>
                </div>
              </div>
            </div>
            <div class="swiper-slide flex flex-column justify-center">
              <div class="bg-[#706233]/10 text-center rounded-[10px] ">
                <div class="p-[15px] rounded-[0_0_50%_50%] bg-white border-b-[5px] border-[#706233] w-full">
                  <img src="{{asset('public/images/category/desserts.jpg')}}" class="w-[120px] h-[120px] mx-auto rounded-full" />
                </div>
                <div class="p-[20px_15px]">
                  <a href="/product-cat/11" class="hover:text-[#706233]">Desserts</a>
                </div>
              </div>
            </div>
            <div class="swiper-slide flex flex-column justify-center">
              <div class="bg-[#706233]/10 text-center rounded-[10px] ">
                <div class="p-[15px] rounded-[0_0_50%_50%] bg-white border-b-[5px] border-[#706233] w-full">
                  <img src="{{asset('public/images/category/drinks.jpg')}}" class="w-[120px] h-[120px] mx-auto rounded-full" />
                </div>
                <div class="p-[20px_15px]">
                  <a href="/product-cat/1" class="hover:text-[#706233]">Drinks</a>
                </div>
              </div>
            </div>
            <div class="swiper-slide flex flex-column justify-center">
              <div class="bg-[#706233]/10 text-center rounded-[10px] ">
                <div class="p-[15px] rounded-[0_0_50%_50%] bg-white border-b-[5px] border-[#706233] w-full">
                  <img src="{{asset('public/images/category/fries.jpg')}}" class="w-[120px] h-[120px] mx-auto rounded-full" />
                </div>
                <div class="p-[20px_15px]">
                  <a href="/product-cat/161" class="hover:text-[#706233]">Fries</a>
                </div>
              </div>
            </div>
            <div class="swiper-slide flex flex-column justify-center">
              <div class="bg-[#706233]/10 text-center rounded-[10px] ">
                <div class="p-[15px] rounded-[0_0_50%_50%] bg-white border-b-[5px] border-[#706233] w-full">
                  <img src="{{asset('public/images/category/pizza.jpg')}}" class="w-[120px] h-[120px] mx-auto rounded-full" />
                </div>
                <div class="p-[20px_15px]">
                  <a href="/product-cat/45" class="hover:text-[#706233]">Pizza</a>
                </div>
              </div>
            </div>
            <div class="swiper-slide flex flex-column justify-center">
              <div class="bg-[#706233]/10 text-center rounded-[10px] ">
                <div class="p-[15px] rounded-[0_0_50%_50%] bg-white border-b-[5px] border-[#706233] w-full">
                  <img src="{{asset('public/images/category/packaging.jpg')}}" class="w-[120px] h-[120px] mx-auto rounded-full" />
                </div>
                <div class="p-[20px_15px]">
                  <a href="/product-cat/19" class="hover:text-[#706233]">Packaging</a>
                </div>
              </div>
            </div>
            <!--End foreach--->
          </div>
        </div>
        <div class="swiper-button-prev categories-button-prev after:content-[''] w-[40px] h-[40px] rounded-full bg-[#706233]/10 transition duration-500 top-[70px] right-12 left-[unset]">
          <i class="fa fa-angle-left text-black text-[22px]" aria-hidden="true"></i>
        </div>
        <div class="swiper-button-next categories-button-next after:content-[''] w-[40px] h-[40px] rounded-full bg-[#706233]/10 transition duration-500 top-[70px] right-0">
          <i class="fa fa-angle-right text-black text-[22px]" aria-hidden="true"></i>
        </div>
      </div>
    </section>
    <!-- popular categories end -->

    <!-- NEW ITEM start -->
    <section class="py-[60px]">
      <div class="!container !px-6 mx-auto relative">
        <div class="pb-8">
          <h5 class="text-[30px] mb-[20px] font-extrabold text-[#706233]">NEW ITEMS</h5>
        </div>
        <div class="grid xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4">
          <?php
          $products=  App\Product::where('is_active', true)->whereIn('category_id',[1,34,35,36])->limit(5)->get();
          ?>
          @foreach ( $products as $key_product => $product )
          @include('frontend.layouts.product', ['products' => $products])
          
          @endforeach
        </div>
      </div>
    </section>
    <!-- NEW ITEM end --> 

    <!-- OUR BESTSELLER start -->
    <section class="py-[60px]">
      <div class="!container !px-6 mx-auto relative">
        <div class="pb-8">
          <h5 class="text-[30px] mb-[20px] font-extrabold text-[#706233]">OUR BESTSELLER</h5>
        </div>
        <div class="grid xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4">
          <?php
            $productss=  App\Product::where('is_active', true)->whereIn('category_id',[4,38,39,40,41,42,43,44,45,46,47,48,49,50])->limit(5)->get();
          
          ?>
          <!---HERE IS TEH SECOND SECTION---->
          @foreach ($productss as $key_product => $products )
          @include('frontend.layouts.product', ['product' => $products])
          
          @endforeach
        </div>
      </div>
    </section>
    <!-- OUR BESTSELLER end --> 

   

    @include('frontend/footer');
  </main>
  <!-- End #main -->


  @endsection

