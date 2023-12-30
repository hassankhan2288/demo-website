<header>
    <!-- Top Nav -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @if (\Auth::guard('customer')->user())
        @if (\Auth::guard('customer')->user()->ms_number == null)
            <div class="flex text-center items-center w-100 bg-[#706233]"><p style="color: #fff;" class="text-center w-100">Your account is not synced with us. Contact Admin</p></div>
        @endif
    @endif
    <div class="!border-b flex items-center">
        <div class="!container sm:px-6 !px-3 mx-auto flex flex-wrap items-center justify-between">
            <div class="items-cneter gap-3 py-[10px] flex-wrap lg:flex ">
               <div class="flex items-start gap-2 lg:flex ">
                   {{-- <i class="fa fa-map-marker text-[14px]" aria-hidden="true"></i> --}}
                   {{-- <a href="https://goo.gl/maps/tuADY4qHM95TCBYy6" class="text-[14px]">
                       Neville Road, Bradford,BD4 8TU
                       United Kingdom
                   </a> --}}
                   {{-- <i class="fa fa-bullhorn" aria-hidden="true"></i>
                   <p>Any website issues please call </p> --}}
               </div>
               <div class="flex items-center gap-2 lg:flex ">
                   {{-- <i class="fa fa-phone text-[14px]" aria-hidden="true"></i>
                   <a href="tel:07985106062" class="text-[14px]">
                    07985106062
                   </a> --}}
               </div>
                @if (\Auth::guard('customer')->user())
                    <div class="flex items-center gap-2">
                        <i class="fa fa-shopping-cart text-[14px]" aria-hidden="true"></i>
                        <select class="selecdel" >
                            @if (\Auth::guard('customer')->user()->checkout_preference == "pickup")
                                <option selected value="{{ route('preferece','pickup') }}" data-reverTo="delivery">Collection</option>
                               {{-- <option value="{{ route('preferece','delivery') }}" data-reverTo="collection">Delivery</option> --}}
                            @else
                            <option  value="{{ route('preferece','pickup') }}">Collection</option>
                           {{-- <option selected value="{{ route('preferece','delivery') }}">Delivery</option> --}}
                            @endif
                        </select>
                        <input type="hidden" id="get_preference" value="{{\Auth::guard('customer')->user()->checkout_preference}}">
                    </div>
                @endif
            </div>
            <div class="flex items-center divide-x ml-auto justify-end">
                <div>
                    @if(\Auth::guard('customer')->user())
                    <div class="flex items-center divide-x gap-3">
                        {{-- <div class="flex items-center gap-2 py-[10px]"><i class="ti-user"></i> <a href="{{ route('customer.dashboard') }}"  >{{ \Auth::guard('customer')->user()->name }}</a></div> --}}
                        <div class="flex items-center gap-2 py-[10px]"><i class="ti-user"></i> <a href="{{ route('customer.dashboard') }}"  >My Profile</a></div>
                        <div class="flex items-center gap-2 py-[10px] pl-3"><i class="ti-power-off"></i> <a href="{{route('customer.logout')}}">Logout</a></div>
                    </div>
                    @else
                        <div class="flex items-center divide-x gap-x-3">
                            <a href="{{ route('customer.register') }}" class="text-[14px] flex items-center gap-2 py-[10px] hover:text-[#706233]"><i class="fa fa-user-plus" aria-hidden="true"></i> Register</a>
                            <a href="{{route('customer.login')}}" class="text-[14px] flex items-center gap-2 py-[10px] hover:text-[#706233] pl-3"><i class="fa fa-user" aria-hidden="true"></i> Login</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Top Nav end -->
    <!-- Main Nav -->
    <div class="!container sm:px-6 !px-3 mx-auto flex items-center justify-between py-[20px]">
        <div class="flex items-center sm:gap-3 gap-2">
            <button type="button" class="btn lg:hidden w-[35px] h-[35px] bg-[#706233]/10 rounded-full flex items-center justify-center relative" data-bs-toggle="modal" data-bs-target="#mobile-menu">
                <i class="fa fa-bars text-[18px] text-[#706233]" aria-hidden="true"></i>
            </button>
            <div class="dropdown">
                <button type="button" class="btn lg:hidden !outline-0 w-[35px] h-[35px] bg-[#706233]/10 rounded-full flex items-center justify-center relative" data-bs-auto-close="outside" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-search text-[18px] text-[#706233]"></i>
                </button>

                <ul class="dropdown-menu md:w-[70vw] w-[80vw] !border-0 !shadow-none !bg-transparent" aria-labelledby="dropdownMenuLink">
                    <li>
                        <form action="{{route("product.search.frontend")}}" method="GET">
                            <div class="h-[48px] rounded-[45px] border-[1px] border-[#706233] flex items-center">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <input type="search" autocomplete="off" name="search" placeholder="Search" class="search autocomplete w-full p-[14px_20px] rounded-l-[45px] h-full focus-visible:outline-0" value="<?php if(isset($searched)){ echo $searched;} ?>" required />
                                <button class="p-[0_16px] text-[18px] bg-[#706233] rounded-r-[45px] h-full text-[18px]" type="submit"><i class="fa fa-search" style="color: #fff"></i></button>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <a href="/" class="flex items-center lg:relative absolute lg:left-0 left-1/2 transform lg:translate-x-0 -translate-x-[50%]">
            <img src="{{asset('frontend/assets/img/demo.png')}}" class="sm:w-[170px] w-[150px]" alt="">
        </a>
        <div class="lg:w-5/12 mx-auto hidden lg:block">
            <form action="{{route("product.search.frontend")}}" method="GET">
                <div class="h-[48px] rounded-[45px] border-[1px] border-[#706233] flex items-center">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="search" name="search" placeholder="Search" class="search autocomplete w-full p-[14px_20px] rounded-l-[45px] h-full focus-visible:outline-0" value="<?php if(isset($searched)){ echo $searched;} ?>" required />
                    <!-- <select name="search" class="h-full outline-0 w-[200px] border-l border-l-[#706233] px-[10px]">
                        <option>All Categrory</option>
                        @php
                        // $category_all=DB::table('categories')->where('is_active',true)->get();
                        $category_all=App\Category::getAllParentWithChild();
                        @endphp
                        @foreach ( $category_all as $key=>$categrory )
                        <option>{{ $categrory->name }}</option>
                        @endforeach

                    </select>  -->
                    <button class="p-[0_16px] text-[18px] bg-[#706233] rounded-r-[45px] h-full text-[18px]" type="submit"><i class="fa fa-search" style="color: #fff"></i></button>
                </div>
            </form>
        </div>
       
        @if(\Auth::guard('customer')->user())
            <div class="lg:w-2/12 md:w-3/12 w-full">
                <div class="flex items-center justify-end sm:!gap-5 !gap-2">
                    @php
                        $total_prod=0;
                        $total_amount=0;
                    @endphp
                    @if(session('wishlist'))
                        @foreach(session('wishlist') as $wishlist_items)
                            @php
                                $total_prod+=$wishlist_items['quantity'];
                                $total_amount+=$wishlist_items['amount'];
                            @endphp
                        @endforeach
                    @endif
                    <div class="group relative">
                        <a href="{{route('wishlist')}}" class="flex items-center">
                            <div class="w-[35px] h-[35px] bg-[#706233]/10 group-hover:bg-[#706233] group-hover:text-white rounded-full flex items-center justify-center relative sm:mr-3">
                                <i class="fa fa-heart-o"></i>
                                <span class="absolute -top-3 -right-2 w-[22px] h-[22px] bg-[#706233] text-[10px] text-white rounded-full flex items-center justify-center">{{Helper::wishlistCount()}}</span>
                            </div>
                            <span class="group-hover:text-[#706233] lg:inline-block hidden">Wishlist</span>
                        </a>
                        <!-- Shopping Item -->
                            <div class="group-hover:block absolute hidden top-full right-0 min-w-[300px] shadow-[0px_0px_30px_#7f89a140] p-3 rounded-[5px] bg-white z-[10]">
                                <div class="flex items-center justify-between pb-2 border-b mb-3">
                                    <span class="text-[15px] font-semibold">{{count(Helper::getAllProductFromWishlist())}} Items</span>
                                    <a class="text-[15px] font-semibold" href="{{route('wishlist')}}">View Wishlist</a>
                                </div>
                                <div class="max-h-[290px] overflow-y-auto">
                                    @foreach(Helper::getAllProductFromWishlist() as $data)
                                        @php
                                            $photo=explode(',',$data->product['image']);
                                        @endphp
                                        <div class="flex items-center border-b pb-2 mb-3">
                                            <div class="relative w-[50px] h-[50px]">
                                                <a href="{{route('wishlist-delete',$data->id)}}" class="absolute -top-[8px] left-0 w-[16px] h-[16px] flex items-center justify-center text-white" title="Remove this item">
                                                    <i class="fa fa-remove"></i>
                                                </a>
                                                <a class="w-[50px] h-[50px] rounded-full overflow-hidden" href="#">
                                                    {{-- <img src="{{asset('storage/'.$photo[0])}}" class="w-full" alt="{{$photo[0]}}" /> --}}
                                                    @php
                                                        $photo[0] = str_replace('storage/','',$photo[0]);
                                                    @endphp
                                                    <img src="{{image_url('storage/'.$photo[0])}}" class="w-full" alt="{{$photo[0]}}" />
                                                </a>
                                            </div>
                                            <div class="ml-3">
                                                <h4 class="text-[14px] font-semibold mb-1"><a href="{{route('product-detail',$data->product['slug'])}}" target="_blank">{{$data->product['title']}}</a></h4>
                                                {{-- <p class="text-[12px]">{{$data->quantity}} x - <span class="text-[#706233]">£{{number_format($data->price,2)}}</span></p> --}}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div>
                                    <div class="flex items-center justify-between w-full mb-2">
                                        <span class="text-[15px] font-semibold">Total</span>
                                        <span class="text-[15px] font-semibold">£{{number_format(Helper::totalWishlistPrice(),2)}}</span>
                                    </div>
                                    <a href="{{route('cart')}}" class="bg-[#706233] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold w-full block text-center">Cart</a>
                                </div>
                            </div>
                        <!--/ End Shopping Item -->
                    </div>
                    <div class="group relative">
                        <a href="{{route('cart')}}" class="flex items-center">
                            <div class="w-[35px] h-[35px] bg-[#706233]/10 group-hover:bg-[#706233] group-hover:text-white rounded-full flex items-center justify-center relative sm:mr-3">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                <span class="absolute -top-3 -right-2 w-[22px] h-[22px] bg-[#706233] text-[10px] text-white rounded-full flex items-center justify-center" id="circle_cart_count">0</span>
                            </div>
                            <span class="group-hover:text-[#706233] lg:inline-block hidden">Cart</span>
                        </a>

                        <!-- Shopping Item -->
                            <div class="group-hover:block absolute hidden top-full right-0 min-w-[300px] shadow-[0px_0px_30px_#7f89a140] p-3 rounded-[5px] bg-white z-[10]">
                                <div class="flex items-center justify-between pb-2 border-b mb-3">
                                    <span class="text-[15px] font-semibold" id="items_count">0 Items</span>
                                    <a class="cartbtnbold text-[15px] font-semibold" href="{{route('cart')}}">View Cart</a>
                                </div>
                                <div class="max-h-[290px] overflow-y-auto" id="insert_cart_objects">

                                </div>
                                <div>
                                    <div class="flex items-center justify-between w-full mb-2">
                                        <span class="text-[15px] font-semibold">Total</span>
                                        <span class="text-[15px] font-semibold" id="total_cart_amount">£0</span>
                                    </div>
                                    <a href="{{route('checkout')}}" class="bg-[#706233] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold w-full block text-center">Checkout</a>
                                </div>
                            </div>
                        <!--/ End Shopping Item -->
                    </div>
                </div>
            </div>
        @else
        <div class="lg:w-2/12 md:w-3/12 w-full">
            <div class="flex items-center justify-end gap-3">

                <div class="group relative">
                    <a href="{{route('customer.login')}}" class="w-[35px] h-[35px] bg-[#706233]/10 rounded-full flex items-center justify-center relative">
                        <i class="fa fa-heart-o text-[#706233]"></i>
                        <span class="absolute -top-3 -right-2 w-[22px] h-[22px] bg-[#706233] text-white rounded-full flex items-center justify-center text-[10px]">{{Helper::wishlistCount()}}</span>
                    </a>

                </div>
                <div class="group relative">
                    <a href="{{route('customer.login')}}" class="w-[35px] h-[35px] bg-[#706233]/10 rounded-full flex items-center justify-center relative">
                        <i class="fa fa-shopping-cart text-[#706233]" aria-hidden="true"></i>
                        <span class="absolute -top-3 -right-2 w-[22px] h-[22px] bg-[#706233] text-white rounded-full flex items-center justify-center text-[10px]">{{Helper::cartCount()}}</span>
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
    <!-- Main Nav end -->
</header>

@php
    //$money = App\Http\Controllers\Front\HomeController::categories(1);
    //dd($money);
@endphp
<!-- Menu -->
<div class="bg-[#706233] relative z-[9] lg:block hidden">
    <div class="!container px-6 mx-auto px-4">
        <nav>
            <ul class="flex flex-wrap items-center h-full">
                <li class="group relative flex items-center">
                    <span class="text-[15px] text-bold text-black inline-flex items-center p-[11px_20px] my-[8px] mr-[15px] bg-[#E1C78F] rounded-full cursor-pointer">
                        <i class="fa fa-bars text-[18px] mr-2" aria-hidden="true"></i>
                        <span class="font-semibold">Browse Categories</span>
                        <i class="fa fa-angle-down ml-2 text-[22px]" aria-hidden="true"></i>
                    </span>
                    <div class="group-hover:block hidden absolute left-0 top-full bg-white shadow-[0px_0px_30px_#7f89a140] p-[10px_0] transition duration-300 rounded-[4px] w-[300px]">
                        <ul id="category-menu">
                            @php
                                // $category_all=DB::table('categories')->where('is_active',true)->where('parent_id',null)->get();
                                $category_all=App\Category::getAllParentWithChild();
                                $count=0;
                            @endphp
                            @foreach ( $category_all as $key=>$categrory )
                                <li class=" group/child relative">
                                    <a href="{{ route('product-cat',$categrory->id) }}" class="p-[10px_20px] text-[15px] font-semibold block ">
                                        <span>{{ $categrory->name }}</span>
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </a>
                                    <ul class="group-hover/child:block hidden absolute left-full top-0 bg-white shadow-[0px_0px_30px_#7f89a140] p-[10px_0] transition duration-300 rounded-[4px] w-[300px]">
                                        @php
                                            $category_child=DB::table('categories')->where('is_active',true)->where('parent_id',$categrory->id)->get();
                                        @endphp
                                        @foreach ($category_child as $child_Key => $child )
                                        <li><a href="{{ route('product-cat',$child->id) }}" class="p-[10px_20px] text-[15px] font-semibold block ">{{ $child->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                        <div class="pt-[10px]">
                            <button class="bg-[#706233] text-white p-[11px_30px] rounded-b-[4px] text-[14px] font-bold w-full block text-center" id="show-toggle">Show more</button>
                        </div>
                    </div>
                </li>
                <li class="flex items-center"><a href="/" class="text-[15px] font-semibold text-white inline-block px-[15px]">Home</a></li>
                <li class="flex items-center"><a href="{{route('promotions')}}" class="text-[15px] font-semibold text-white inline-block px-[15px]">Promotions</a></li>
                <li class="flex items-center"><a href="{{route('aboutus')}}" class="text-[15px] font-semibold text-white inline-block px-[15px]">About Us</a></li>
                <li class="flex items-center"><a href="{{route('contact')}}" class="text-[15px] font-semibold text-white inline-block px-[15px]">Contact Us</a></li>
                {{-- <li class="flex items-center"><a href="{{route('careers')}}" class="text-[15px] font-semibold text-white inline-block px-[15px]">Careers</a></li> --}}
                <li class="flex items-center"><a href="{{route('click')}}" class="text-[15px] font-semibold text-white inline-block px-[15px]">Click & Collect</a></li>
                <li class="flex items-center"><a href="{{route('gallery')}}" class="text-[15px] font-semibold text-white inline-block px-[15px]">Gallery</a></li>

            </ul>
        </nav>
    </div>
</div>
<!-- Menu end -->

<!-- Mobile menu popup -->

<div class="modal fade right" id="mobile-menu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 rounded-none h-full">
            <div class="modal-body scrollallow">
                <div class="flex justify-end mb-3">
                    <i class="fa fa-times text-[24px] cursor-pointer" data-bs-dismiss="modal" aria-hidden="true"></i>
                </div>
                <form action="{{route("product.search.frontend")}}" method="GET">
                    <div class="text-center flex flex-col items-center gap-2 mt-4 mb-3">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="search" autocomplete="off" name="search" placeholder="Search" class="search autocomplete w-full border p-[14px_20px] h-[48px] rounded-[45px] h-full focus-visible:outline-0" value="<?php if(isset($searched)){ echo $searched;} ?>" required />
                        <button class="p-[0_16px] text-[18px] bg-[#706233] rounded-[45px] h-[48px] w-full text-[18px] mt-2 text-white font-sembold" type="submit">
                            <i class="fa fa-search mr-1"></i> Search
                        </button>
                    </div>
                </form>
                <nav>
                    <ul class="flex flex-col flex-wrap h-full">
                        <li class="dropdown relative min-h-[50px] flex items-center">
                            <a class="text-[15px] text-bold inline-block px-[15px]" href="#" role="button" id="mobile-products" data-bs-toggle="dropdown" data-bs-auto-close="outside"><span>All Products</span> <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                            <div class="dropdown-menu" aria-labelledby="mobile-products" >
                                @php
                                    // $category_all=DB::table('categories')->where('is_active',true)->where('parent_id',null)->get();
                                    $category_all=App\Category::getAllParentWithChild();
                                    $count=0;
                                @endphp
                                @foreach ( $category_all as $key=>$categrory )
                                    <div class="dropdown">
                                        <a href="#" role="button" id="dropdownMenuLink{{ $categrory->id }}"  data-bs-toggle="dropdown" class="p-[10px_20px] text-[15px] font-semibold block ">
                                            <span>{{ $categrory->name }}</span>
                                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                                        </a>
                                        <ul class="dropdown-menu !left-[20px]" aria-labelledby="dropdownMenuLink{{ $categrory->id }}">
                                            @php
                                                $category_child=DB::table('categories')->where('is_active',true)->where('parent_id',$categrory->id)->get();
                                            @endphp
                                            @foreach ($category_child as $child_Key => $child )
                                            <li><a href="{{ route('product-cat',$child->id) }}" class="p-[10px_20px] text-[15px] font-semibold block ">{{ $child->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach

                        </div>
                        </li>
                        <li class="min-h-[50px] flex items-center"><a href="/" class="text-[15px] text-bold inline-block px-[15px]">Home</a></li>
                        <li class="min-h-[50px] flex items-center"><a href="{{route('promotions')}}" class="text-[15px] text-bold inline-block px-[15px]">Promotions</a></li>
                        <li class="min-h-[50px] flex items-center"><a href="{{route('aboutus')}}" class="text-[15px] text-bold inline-block px-[15px]">About Us</a></li>
                        <li class="min-h-[50px] flex items-center"><a href="{{route('contact')}}" class="text-[15px] text-bold inline-block px-[15px]">Contact Us</a></li>
{{--                        <li class="min-h-[50px] flex items-center"><a href="{{route('careers')}}" class="text-[15px] text-bold inline-block px-[15px]">Careers</a></li>--}}
                        <li class="min-h-[50px] flex items-center"><a href="{{route('click')}}" class="text-[15px] text-bold inline-block px-[15px]">Click & Collect</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>


