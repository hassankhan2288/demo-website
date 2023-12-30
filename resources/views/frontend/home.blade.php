@extends('frontend.layouts.master')
@section('title', 'Demo|| Home Page')
@php
    $cate_id = Request::segment(2);
    if (!is_numeric($cate_id)) {
        $cate_id = Request::segment(3);
    }
    if ($cate_id != null) {
        $cate = $cate_id;
    } else {
        $cate = '0';
    }
@endphp
@section('main-content')

    <main>
        <!-- hero section start -->
        <section class="p-0 main_web">
            <div class="slides-hero swiper group">
                <div class="swiper-wrapper">
                    @foreach ($slider as $key => $sliders)
                        <div
                            class="swiper-slide flex flex-column justify-center xl:h-[64vh] lg:h-[50vh] md:h-[40vh] sm:h-[30vh] h-[25vh]">
                            <a href="{{ $sliders->link }}">
                                {{-- <img src="{{$sliders->photo}}" class="w-full h-full" /> --}}
                                <img src="{{ asset('frontend/assets/img/main_banner.png') }}" class="w-full h-full" />
                            </a>
                        </div>
                    @endforeach
                </div>
                <div
                    class="swiper-button-prev hero-button-prev after:content-[''] w-[40px] h-[40px] rounded-full bg-[#706233] !opacity-0 group-hover:!opacity-100 transition duration-500">
                    <i class="fa fa-angle-left text-white text-[22px]" aria-hidden="true"></i>
                </div>
                <div
                    class="swiper-button-next hero-button-next after:content-[''] w-[40px] h-[40px] rounded-full bg-[#706233] !opacity-0 group-hover:!opacity-100 transition duration-500">
                    <i class="fa fa-angle-right text-white text-[22px]" aria-hidden="true"></i>
                </div>
            </div>
        </section>
        <!-- hero section end -->

        <!-- hero section For mobile start -->
        <section class="p-0 main_mobile">
            <div class="slides-hero swiper group">
                <div class="swiper-wrapper">
                    @foreach ($mobile_slider as $key => $msliders)
                        <div
                            class="swiper-slide flex flex-column justify-center xl:h-[64vh] lg:h-[50vh] md:h-[40vh] sm:h-[50vh] h-[50vh]">
                            <a href="{{ $msliders->link }}"><img src="{{ $msliders->photo }}" class="w-full h-full" /></a>
                        </div>
                    @endforeach
                </div>
                <div
                    class="swiper-button-prev hero-button-prev after:content-[''] w-[40px] h-[40px] rounded-full bg-[#706233] !opacity-0 group-hover:!opacity-100 transition duration-500">
                    <i class="fa fa-angle-left text-white text-[22px]" aria-hidden="true"></i>
                </div>
                <div
                    class="swiper-button-next hero-button-next after:content-[''] w-[40px] h-[40px] rounded-full bg-[#706233] !opacity-0 group-hover:!opacity-100 transition duration-500">
                    <i class="fa fa-angle-right text-white text-[22px]" aria-hidden="true"></i>
                </div>
            </div>
        </section>
        <!-- hero section for mobile end -->

        {{-- <!--   Best selling start -->
    <section class="bg-[#E1C78F]">
      <div class="max-w-[1920px] lg:py-[20px] !pb-[60px] mx-auto flex items-center flex-wrap lg:px-0 px-6 hm_p_bottom_mobile">
        <div class="lg:w-4/12 w-full">
            <img class="w-6/12 transform lg:rotate-0 -rotate-90 lg:!mx-0 mx-auto hm_margin_mobile" src="{{asset('frontend/assets/img/patez.png')}}">
        </div>
        <div class="lg:w-6/12 w-full flex flex-col justify-center">
          <h2 class="mb-[25px] font-extrabold lg:text-[55px] md:text-[40px] text-[30px]">Best selling, High quality range of products</h2>

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
    </section> --}}

        <!-- popular categories start -->
        <section class="py-[60px]">
            <div class="!container !px-6 mx-auto relative">
                <div class="pb-8">
                    <h5 class="text-[18px] mb-[20px] font-extrabold text-[#706233]">Choose your Categories</h5>
                    <h2 class="sm:text-[30px] text-[20px] mb-[20px] pr-[70px] text-[#706233] font-bold"
                        style="font-family: Candara ;">POPULAR CATEGORIES</h2>
                </div>
                <div class="popular-categories swiper">
                    <div class="swiper-wrapper">
                        @foreach ($category_all as $category)
                            <div class="swiper-slide flex flex-column justify-center">
                        <a href="{{ route('product-cat', $category->id) }}">
                                <div class="bg-[#706233]/10 text-center rounded-[30px] ">
                                    <div class="p-[15px] rounded-[0_0_60%_60%] bg-white border-b-[5px] border-[#706233] w-full">
                                        {{-- <img src="{{ asset('images/category/' . $category->image) }}" class="!rounded-b-none" /> --}}
                                        <img src="{{ asset('images/pic_3.jpg') }}" class="w-[150px] h-[150px] mx-auto rounded-full" />
                                    </div>
                                    <div class="p-[20px_15px]">
                                        <div class="hover:text-[#706233]">{{ $category->name }}</div>
                                    </div>
                                </div>
                        </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div
                    class="swiper-button-prev categories-button-prev after:content-[''] w-[40px] h-[40px] rounded-full bg-[#706233]/10 transition duration-500 top-[70px] right-12 left-[unset]">
                    <i class="fa fa-angle-left text-black text-[22px]" aria-hidden="true"></i>
                </div>
                <div
                    class="swiper-button-next categories-button-next after:content-[''] w-[40px] h-[40px] rounded-full bg-[#706233]/10 transition duration-500 top-[70px] right-0">
                    <i class="fa fa-angle-right text-black text-[22px]" aria-hidden="true"></i>
                </div>
            </div>
        </section>
        <!-- popular categories end -->

        <!-- NEW ITEM start -->
        {{-- <section class="py-[60px]">
      <div class="!container !px-6 mx-auto relative">
        <div class="pb-8">
          <h5 class="sm:text-[30px] text-[20px] mb-[20px] text-[#706233] font-bold" style="font-family: Candara ;">NEW ITEMS</h5>
        </div>
        <div class="grid xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4">
          <?php
          $products = App\Product::where('is_active', true)
              ->whereIn('category_id', [1, 34, 35, 36])
              ->limit(5)
              ->get();
          ?>
          @foreach ($products as $key_product => $product)
          @include('frontend.layouts.product', ['products' => $products])
          
          @endforeach
        </div>
      </div>
    </section> --}}

        <section
            class="py-[60px] relative before:absolute before:inset-0 before:content-[''] before:bg-[#fff]/20 before:z-[1] group">
            <div class="!container !px-6 mx-auto relative z-[2]">
                <div class="row heading-wrap mb-5">
                    <h3 class="text-[#706233] sm:text-[30px] text-[20px] font-bold mb-8" style="font-family: Candara ;">NEW <span
                            class="text-[#706233]">ITEM</span></h3>
                </div>
                <div class="brand-swiper swiper">
                    <div class="swiper-wrapper">
                        <?php
                        $products = App\Product::where('is_active', true)
                            ->where('status', 'active')
                            ->limit(5)
                            ->get();
                        ?>
                        @foreach ($products as $key_product => $products)
                            <?php $image = $products->image;
                            $images = explode(',', $image);
                            ?>
                            <div class="swiper-slide flex flex-column justify-center">
                                <div class="text-center rounded-[10px] ">
                                    <div class="p-[4px] w-full min-h-[100px]">
                                        <a href="{{ route('product-detail', ['slug' => $products->slug, 'cat_id' => $cate]) }}"
                                            class="bg-white rounded-[5px]">
                                            {{-- <img src="{{ asset('storage/' . $images[0]) }}" class="w-full mx-auto"/> --}}
                                            <img src="{{ asset('images/pic_1.jpg') }}" class="w-full mx-auto"
                                                alt="">
                                            {{-- <div class="text-center"> --}}
                                            {{-- <p class="font-bold mt-3 text-[#706233]">Demo Product</p> --}}
                                            <p class="font-bold mt-3 text-[#706233]">{{ $products->name }}</p>
                                            {{-- </div> --}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div
                        class="swiper-button-prev brand-button-prev after:content-[''] w-[40px] h-[40px] rounded-full bg-[#706233] !opacity-0 group-hover:!opacity-100 transition duration-500">
                        <i class="fa fa-angle-left text-white text-[22px]" aria-hidden="true"></i>
                    </div>
                    <div
                        class="swiper-button-next brand-button-next after:content-[''] w-[40px] h-[40px] rounded-full bg-[#706233] !opacity-0 group-hover:!opacity-100 transition duration-500">
                        <i class="fa fa-angle-right text-white text-[22px]" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </section>
        <!-- NEW ITEM end -->

        <!-- OUR BESTSELLER start -->
        {{-- <section class="py-[60px]">
      <div class="!container !px-6 mx-auto relative">
        <div class="pb-8">
          <h5 class="text-[30px] mb-[20px] font-extrabold text-[#706233]">OUR BESTSELLER</h5>
        </div>
        <div class="grid xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4">
          <?php
          $productss = App\Product::where('is_active', true)
              ->where('status', 'active')
              ->limit(5)
              ->get();
          // dd($productss)
          ?>
          <!---HERE IS TEH SECOND SECTION---->
          @foreach ($productss as $key_product => $products)
          @include('frontend.layouts.product', ['product' => $products])
          
          @endforeach
        </div>
      </div>
    </section> --}}

        <section class="py-[60px]">
            <div class="!container !px-6 mx-auto relative">
                <div class="pb-8">
                    <div class="row heading-wrap mb-5">
                        <h2 class="sm:text-[30px] text-[20px] mb-[20px] text-[#706233] font-bold"
                            style="font-family: Candara ;">OUR BESTSELLER</h2>

                    </div>
                </div>
                <div class="grid xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4">
                    <?php
                    $products = App\Product::where('is_active', true)
                        ->where('status', 'active')
                        // ->whereIn('category_id', [4, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50])
                        ->orderBy('id', 'DESC')
                        ->limit(5)
                        ->get();
                    ?>
                    @foreach ($products as $key_product => $products)
                        <?php $image = $products->image;
                        $images = explode(',', $image);
                        ?>
                        <a href="{{ route('product-detail', ['slug' => $products->slug, 'cat_id' => $cate]) }}">
                            <div class="bg-white !border !border-[#ce1212]/10 rounded-[5px] p-[15px] group h-full">
                                <div class="mb-[15px] relative w-full min-h-[150px] home_img">
                                    {{-- <img src="{{ asset('storage/' . $images[0]) }}" /> --}}
                                    <img src="{{ asset('images/pic_5.jpg') }}" />
                                </div>
                                <div class="text-center home_name">
                                  
                                    <div> <strong><span style="color:#706233">Name: {{ $products->name }}</span></strong></div>
                                    <div> <strong><span style="color:#706233">Price: {{ $products->price }}</span></strong>
                                    {{-- <span>{{ $products->price }}</span> --}}
                                    </div>
                                    <div class="container w-[120px] h-[15px]">
                                        <!-- Generator: Adobe Illustrator 24.3.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                                        <svg version="1.1" id="Group_804" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                            viewBox="0 0 91.3 15.5" style="enable-background:new 0 0 91.3 15.5;"
                                            xml:space="preserve">
                                            <style type="text/css">
                                                .st0 {
                                                    fill: #706233;
                                                }
                                            </style>
                                            <g>
                                                <g id="star-fill" transform="translate(0 0)">
                                                    <g id="Group_688" transform="translate(0 0)">
                                                        <path id="Path_297" class="st0"
                                                            d="M4.1,14.9c-0.3,0.1-0.6,0-0.7-0.2c0-0.1-0.1-0.2,0-0.3l0.8-4.6L0.8,6.5C0.6,6.3,0.6,6,0.8,5.8
                                                  C0.9,5.7,1,5.7,1.1,5.6L5.8,5l2.1-4.2C8,0.5,8.3,0.4,8.6,0.6c0.1,0,0.2,0.1,0.2,0.2L10.9,5l4.7,0.7c0.3,0.1,0.5,0.3,0.4,0.6
                                                  c0,0.1-0.1,0.2-0.2,0.3l-3.4,3.2l0.8,4.6c0.1,0.3-0.1,0.5-0.4,0.6c-0.1,0-0.2,0-0.3,0l-4.2-2.2L4.1,14.9L4.1,14.9z" />
                                                    </g>
                                                </g>
                                                <g id="star-fill-2" transform="translate(19.275 0)">
                                                    <g id="Group_688-2" transform="translate(0 0)">
                                                        <path id="Path_297-2" class="st0" d="M4.1,14.9c-0.3,0.1-0.6,0-0.7-0.2c0-0.1-0.1-0.2,0-0.3l0.8-4.6L0.8,6.5
                                                              C0.6,6.3,0.6,6,0.8,5.8C0.9,5.7,1,5.7,1.1,5.6L5.8,5l2.1-4.2C8,0.5,8.3,0.4,8.6,0.6c0.1,0,0.2,0.1,0.2,0.2L10.9,5l4.7,0.7
                                                              c0.3,0.1,0.5,0.3,0.4,0.6c0,0.1-0.1,0.2-0.2,0.3l-3.4,3.2l0.8,4.6c0.1,0.3-0.1,0.5-0.4,0.6c-0.1,0-0.2,0-0.3,0l-4.2-2.2L4.1,14.9
                                                              L4.1,14.9z" />
                                                    </g>
                                                </g>
                                                <g id="star-fill-3" transform="translate(37.265 0)">
                                                    <g id="Group_688-3" transform="translate(0 0)">
                                                        <path id="Path_297-3" class="st0" d="M4.1,14.9c-0.3,0.1-0.6,0-0.7-0.2c0-0.1-0.1-0.2,0-0.3l0.8-4.6L0.8,6.5
                                                              C0.6,6.3,0.6,6,0.8,5.8C0.9,5.7,1,5.7,1.1,5.6L5.8,5l2.1-4.2C8,0.5,8.3,0.4,8.6,0.6c0.1,0,0.2,0.1,0.2,0.2L10.9,5l4.7,0.7
                                                              c0.3,0.1,0.5,0.3,0.4,0.6c0,0.1-0.1,0.2-0.2,0.3l-3.4,3.2l0.8,4.6c0.1,0.3-0.1,0.5-0.4,0.6c-0.1,0-0.2,0-0.3,0l-4.2-2.2L4.1,14.9
                                                              L4.1,14.9z" />
                                                    </g>
                                                </g>
                                                <g id="star-fill-4" transform="translate(56.54 0)">
                                                    <g id="Group_688-4" transform="translate(0 0)">
                                                        <path id="Path_297-4" class="st0" d="M4.1,14.9c-0.3,0.1-0.6,0-0.7-0.2c0-0.1-0.1-0.2,0-0.3l0.8-4.6L0.8,6.5
                                                              C0.6,6.3,0.6,6,0.8,5.8C0.9,5.7,1,5.7,1.1,5.6L5.8,5l2.1-4.2C8,0.5,8.3,0.4,8.6,0.6c0.1,0,0.2,0.1,0.2,0.2L10.9,5l4.7,0.7
                                                              c0.3,0.1,0.5,0.3,0.4,0.6c0,0.1-0.1,0.2-0.2,0.3l-3.4,3.2l0.8,4.6c0.1,0.3-0.1,0.5-0.4,0.6c-0.1,0-0.2,0-0.3,0l-4.2-2.2L4.1,14.9
                                                              L4.1,14.9z" />
                                                    </g>
                                                </g>
                                                <g id="star-half" transform="translate(74.53 0)">
                                                    <g id="Group_803" transform="translate(0 0)">
                                                        <path id="Path_299" class="st0" d="M5.8,5l2.1-4.2C8,0.5,8.3,0.4,8.6,0.6c0.1,0,0.2,0.1,0.2,0.2L10.9,5l4.7,0.7
                                                              c0.2,0,0.4,0.2,0.4,0.5c0,0.2,0,0.3-0.2,0.4l-3.4,3.2l0.8,4.6c0.1,0.3-0.1,0.5-0.4,0.6c-0.1,0-0.2,0-0.3,0l-4.2-2.2l-4.2,2.2
                                                              c0,0-0.1,0-0.1,0c-0.3,0-0.5-0.2-0.6-0.4c0-0.1,0-0.1,0-0.2l0.8-4.6L0.8,6.5C0.7,6.4,0.7,6.3,0.7,6.2c0-0.1,0-0.2,0.1-0.3
                                                              c0.1-0.1,0.2-0.2,0.4-0.2L5.8,5L5.8,5z M8.4,11.6c0.1,0,0.2,0,0.2,0.1l3.6,1.8l-0.7-3.8c0-0.2,0-0.4,0.2-0.5l2.8-2.7L10.5,6
                                                              c-0.2,0-0.3-0.1-0.4-0.3L8.4,2.2L8.4,11.6L8.4,11.6z" />
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- OUR BESTSELLER end -->

         <!-- Take advantage of many benefits start -->

         <div class="!container px-6 mx-auto">
          <div class="row heading-wrap mb-5">
              <div class="col-lg-7 text-center mx-auto">
                  <hr> <img src="{{ asset('images/design.png') }}" alt="Demo"
                      class="img-fluid mx-auto text-[#706233]" style=" width:120px">
                  <h1 class="sm:text-[35px] text-[25px] text-[#706233] !mb-6 font-bold" style="font-family: Candara ;">OUR SERVICES</h1>
              </div>
          </div>
          <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-10" style="margin-top: 70px">
              <div class="flex items-center ">
                  <img src="\frontend\assets\img\24h_icon.jpg" class="w-[100px]" />
                  <div class="!ml-4">
                      {{-- <h1 class="text-[18px] font-bold mb-2">Bestellen</h2> --}}
                      <p class="font-medium">Order around the clock 24/7</p>
                  </div>
              </div>
              <div class="flex items-center">
                  <img src="\frontend\assets\img\imgpsh.jpg" class="w-[100px]" />
                  <div class="!ml-4">
                      {{-- <h2 class="text-[18px] font-bold mb-2">Rabatte</h2> --}}
                      <p class="font-medium">Many promotions and discounts</p>
                  </div>
              </div>
              <div class="flex items-center">
                  <img src="\frontend\assets\img\service_icon.jpg" class="w-[100px]" />
                  <div class="!ml-4">
                      {{-- <h2 class="text-[18px] font-bold mb-2">Lieferung</h2> --}}
                      <p class="font-medium">Freight-free delivery throughout Karachi</p>
                  </div>
              </div>
          </div>
      </div>

      <div class="!container px-6 mx-auto mt-5" style="margin-bottom: 60px">
          <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-10">
              <div class="flex items-center ">
                  <img src="\frontend\assets\img\tab_icon.jpg" class="w-[100px]" />
                  <div class="!ml-4">
                      {{-- <h1 class="text-[18px] font-bold mb-2">Produkte</h2> --}}
                      <p class="font-medium">All products at a glance</p>
                  </div>
              </div>
              <div class="flex items-center">
                  <img src="\frontend\assets\img\hand_icon.jpg" class="w-[100px]" />
                  <div class="!ml-4">
                      {{-- <h2 class="text-[18px] font-bold mb-2">Projekts</h2> --}}
                      <p class="font-medium">Support during the project</p>
                  </div>
              </div>
              <div class="flex">
                  <img src="\frontend\assets\img\message_icon.jpg" class="w-[100px]" />
                  <div class="!ml-4 my-auto">
                      {{-- <h2 class="text-[18px] font-bold mb-2">Support</h2> --}}
                      <p class="font-medium">Technical Support</p>
                  </div>
              </div>
          </div>
      </div>

      <!-- Take advantage of many benefits end -->
      <section class="py-[20px]">
          <div class="container-fluid">
              <p style="text-align: center"><a href="{{ route('customer.register') }}"
                      class="p-[10px_30px] w-full rounded-full text-white bg-[#706233]"
                      style="background-color :#706233">To The Registration</a></p>

          </div>
      </section>



        @include('frontend/footer');
    </main>
    <!-- End #main -->


@endsection
