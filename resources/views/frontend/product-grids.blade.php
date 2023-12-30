@extends('frontend.layouts.master')

@section('title', 'Demo || PRODUCT PAGE')
<?php
//if (isset(session()->get('design'))) {
session()->get('design');
//exit;
//}
?>

@php
    $cate = Request::segment(2);

    $value = \App\Category::where('id', $cate)->first();
    //dd($value[0]->name)
@endphp
@section('main-content')
    <main class="pb-[24px]">
        <!-- Breadcrumbs -->
        <div class="w-full bg-[#706233]/10 py-[15px]">
            <div class="!container px-6 mx-auto">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div class="flex flex-wrap">
                        <nav>
                            <ol class="flex items-center bread-crumbsetting">
                                <li class="list-unstyled"><a href="{{ route('home') }}">Home </a></li>
                                <li class="list-unstyled text-[#706233] ml-1" aria-current="page">
                                    @php
                                        if (isset($value->id)) {
                                            $parent = $value->getParentCategory($value->id);
                                            if ($parent) {
                                                echo '/ ';
                                                echo "<a href='/product-cat/" . $parent->id . "'>" . $parent->name . '</a> / ' . $value->name;
                                            } else {
                                                echo ' / ' . $value->name;
                                            }
                                        }

                                    @endphp


                                    {{-- / @php if(isset($value->name)) {
                                    echo $value->name;
                                } else {
                                    echo 'Products';
                                } @endphp --}}
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="flex flex-wrap text-right ml-auto">
                        <h2 class="text-[16px] font-bold">
                            @php if (isset($value[0]->name)) {
                                    echo $value[0]->name;
                                } else {
                                    echo 'Products';
                            } @endphp
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcrumbs -->

        <?php if(session()->get('design') == 'list'){

    ?>
        @if (str_contains(Request::url(), 'product-cat'))
            @php
                $cat_id = request()->segment(count(request()->segments()));
            @endphp
            <form action="{{ route('product-cat', $cat_id) }}" method="GET">
            @else
                <form action="" method="GET">
        @endif
        @csrf
        <!-- Product list style -->
        @if (str_contains(Request::url(), 'product-cat'))
            <input type="hidden" value="{{ request()->segment(count(request()->segments())) }}" name="product_cat" />
        @endif
        <input type="hidden" value="true" name="filter" />
        <section class="py-[40px]">
            <div class="!container mx-auto px-6">
                <div class="grid lg:grid-cols-12 grid-cols-1 gap-4">
                    <button type="button"
                        class="btn sm:flex items-center gap-3 text-[#706233] text-[14px] lg:hidden hidden active:!outline-0 active:!border-none !border-none !outline-0"
                        data-bs-toggle="modal" data-bs-target="#mobile-category">
                        <span
                            class="w-[35px] h-[35px] bg-[#706233]/10 rounded-full flex items-center justify-center relative">
                            <i class="fa fa-bars text-[18px] text-[#706233]" aria-hidden="true"></i>
                        </span>
                        Show Sidebar
                    </button>
                    @if (str_contains(Request::url(), 'product-cat'))
                        <input type="hidden" value="{{ request()->segment(count(request()->segments())) }}"
                            name="product-cat" />
                    @endif
                    <div class="xl:col-span-3 lg:col-span-4 lg:block hidden">
                        <div class="p-[15px] border border-[#706233]/10 rounded-[5px] ">
                            <!-- Single Widget -->
                            <div class="single-widget category">
                                <h3
                                    class="text-[20px] font-bold mb-[20px] border-b border-[#706233]/10 pb-[10px] relative before:absolute before:content-[''] before:w-[60px] before:left-0 before:h-[4px] before:rounded-[50%] before:-bottom-[2px] before:bg-[#706233]">
                                    Categories</h3>
                                <div class="dropdown">
                                    @php
                                        // $category = new Category();
                                        $menu = App\Category::getAllParentWithChild();
                                    @endphp
                                    @if ($menu)
                                        @foreach ($menu as $cat_info)
                                            <?php
                                            $sub_cat = \App\Category::where('parent_id', $cat_info->id)->get();
                                            ?>
                                            @if (count($sub_cat) > 0)
                                                <a class="py-[8px] flex items-center justify-between" href="#"
                                                    role="button" id="dropdownMenuLink{{ $cat_info->id }}"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    {{ $cat_info->name }}
                                                    <i class="fa fa-angle-down ml-3" aria-hidden="true"></i>
                                                </a>

                                                <ul class="dropdown-menu lg:!absolute lg:!left-full lg:!right-[auto] !right-[0px] lg:!-mt-[30px] lg:!ml-[15px] !shadow-[0px_0px_30px_#7f89a140] !border-0"
                                                    aria-labelledby="dropdownMenuLink{{ $cat_info->id }}">
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('product-cat', $cat_info->id) }}">{{ $cat_info->name }}</a>
                                                    </li>
                                                    @foreach ($sub_cat as $sub_menu)
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('product-cat', $sub_menu->id) }}">{{ $sub_menu->name }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <!-- <a class="bg-[#706233] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold" href="{{ route('product-cat', $cat_info->id) }}" role="button"
                                                       id="dropdownMenuLink{{ $cat_info->id }}">
                                                        {{ $cat_info->name }}
                                                    </a> -->
                                            @endif
                                        @endforeach

                                    @endif
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="xl:col-span-9 lg:col-span-8">
                        <div class="flex flex-wrap mb-[40px]">
                            <div class="w-full">
                                <!-- Shop Top -->
                                <div class="flex items-center flex-wrap gap-3 relative">
                                    <div class="flex items-center gap-3 sm:w-auto w-full">
                                        <div class="sm:flex items-center gap-2">
                                            <label>Filter :</label>
                                            <select class="w-[120px] p-[8px_10px] rounded-[5px] !border !border-[#e7e7e7] "
                                                name="show" onchange="this.form.submit();">
                                                <option value="9">Default</option>
                                                <option value="9" @if (!empty($_GET['show']) && $_GET['show'] == '9') selected @endif>09
                                                </option>
                                                <option value="15" @if (!empty($_GET['show']) && $_GET['show'] == '15') selected @endif>15
                                                </option>
                                                <option value="21" @if (!empty($_GET['show']) && $_GET['show'] == '21') selected @endif>21
                                                </option>
                                                <option value="30" @if (!empty($_GET['show']) && $_GET['show'] == '30') selected @endif>30
                                                </option>
                                            </select>
                                        </div>
                                        <div class="sm:flex items-center gap-2">
                                            <label>Filter By :</label>
                                            <select class='w-[120px] p-[8px_10px] rounded-[5px] !border !border-[#e7e7e7]'
                                                name='sortBy' onchange="this.form.submit();">
                                                <option value="">Default</option>
                                                <option value="name" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'name') selected @endif>
                                                    Name</option>
                                                <option value="priceAsc" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'price?sort=asc') selected @endif>
                                                    Price (Lowest To Highest)</option>
                                                <option value="priceDesc"
                                                    @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'price?sort=desc') selected @endif>
                                                    Price (Highest To Lowest)</option>
                                                {{-- <option value="price" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'price') selected @endif>
                                                    Price</option> --}}
                                                {{-- <option value="category" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'category') selected @endif>
                                                    Category</option>
                                                <option value="brand" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'brand') selected @endif>
                                                    Brand</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                    <button type="button"
                                        class="absolute !-bottom-[1px] left-0 btn flex items-center gap-3 text-[#706233] text-[14px] sm:hidden active:!outline-0 active:!border-none !border-none !outline-0 !p-0"
                                        data-bs-toggle="modal" data-bs-target="#mobile-category">
                                        <span
                                            class="w-[35px] h-[35px] bg-[#706233]/10 rounded-full flex items-center justify-center relative">
                                            <i class="fa fa-bars text-[18px] text-[#706233]" aria-hidden="true"></i>
                                        </span>
                                        Show Sidebar
                                    </button>
                                    <ul class="flex items-center gap-2 ml-auto">
                                        <li
                                            class="w-[43px] h-[32px] flex items-center justify-center rounded-[5px] bg-[#706233]/10">
                                            <a href="{{ URL::to('design', ['id' => 'grid']) }}">
                                                <i class="fa fa-th-large"></i>
                                            </a>
                                        </li>
                                        <li
                                            class="w-[43px] h-[32px] flex items-center justify-center rounded-[5px] bg-[#706233]">
                                            <a href="{{ URL::to('design', ['id' => 'list']) }}" class="text-white">
                                                <i class="fa fa-th-list"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <!--/ End Shop Top -->
                            </div>
                        </div>
                        @php
                            if (Session::get('filter')) {
                                $products = Session::get('products');
                            }
                        @endphp
                        @if (count($products))
                            @foreach ($products as $product)
                                {{-- {{$product}} --}}
                                <!-- Start Single List -->

                                <div
                                    class="p-[15px] rounded-[5px]  !border !border-[#706233]/10 hover:!border-[#706233] transition duration-300 mb-6">
                                    <div class="grid sm:grid-cols-12 grid-cols-1 gap-4">
                                        <div class="lg:col-span-4 sm:col-span-6">
                                            <div class="mr-[15px] relative w-full min-h-[150px] group">
                                                <a href="{{ route('product-detail', $product->slug) }}">
                                                    @php
                                                        $photo = explode(',', $product->image);
                                                        $photo = str_replace('storage/', '', $photo);
                                                    @endphp
                                                    {{-- <img class="w-[70%] mx-auto transform group-hover:scale-110 transition duration-300" src="{{asset('storage/thumbnail/'.$photo[0])}}" alt=""> --}}
                                                    <img class="w-[70%] mx-auto transform group-hover:scale-110 transition duration-300"
                                                        src="{{ image_url('storage/' . $photo[0]) }}" alt="">
                                                    {{-- @if ($product->discount)
                                                        <span class="absolute p-[2px_8px] text-white bg-[#706233] rounded-[5px] top-[1px] left-[1px]">{{$product->discount}} % Off</span>
                                                    @endif --}}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="lg:col-span-8 md:col-span-6 flex items-center">
                                            <div class="text-left faisal">
                                                <h3
                                                    class="py-[5px] font-bold sm:text-[16px] text-[13px] text-[#706233] height-[45px]">
                                                    <a href="{{ route('product-detail', $product->slug) }}"
                                                        class="hover:text[#706233]">{{ $product->name }}</a>
                                                </h3>
                                                {{-- <div class="sm:text-[14px] text-[10px] font-medium py-[5px] truncate">Product Code: <strong>{{ $product->ms_id }}</strong></div> --}}
                                                <div class="sm:text-[14px] text-[10px] font-medium py-[5px] truncate">
                                                    Package Size: <strong>{{ $product->pack_size }} </strong></div>
                                                @if (\Auth::guard('customer')->user())
                                                    <div class="d-flex custom_design_hm">

                                                        <div>
                                                            <span class="d-flex">
                                                                <small>Case:
                                                                    <br>({{ \Auth::guard('customer')->user()->checkout_preference }})</small>
                                                                @if (\Auth::guard('customer')->user()->checkout_preference == 'delivery')
                                                                    <strong>{{ $product->Fullprice->delivery_pack ? '£' . $product->Fullprice->delivery_pack : 'NA' }}</strong>
                                                                @else
                                                                    <strong>{{ $product->Fullprice->p_price ? '£' . number_format($product->Fullprice->p_price, 2) : 'NA' }}</strong>
                                                                @endif
                                                            </span>
                                                        </div>


                                                        <div>
                                                            <span class="d-flex">
                                                                <small>Single:
                                                                    <br>({{ \Auth::guard('customer')->user()->checkout_preference }})</small>
                                                                @if (\Auth::guard('customer')->user()->checkout_preference == 'delivery')
                                                                    <strong>{{ $product->Fullprice->delivery_single ? '£' . number_format($product->Fullprice->delivery_single, 2) : 'NA' }}</strong>
                                                                @else
                                                                    <strong>{{ $product->Fullprice->price ? '£' . number_format($product->Fullprice->price, 2) : 'NA' }}</strong>
                                                                @endif

                                                            </span>
                                                        </div>

                                                    </div>
                                                @else
                                                    <div class="d-flex custom_design_hm">
                                                        <div class="collectionPrice">
                                                            <span class="d-flex">
                                                                <h3>Collection</h3>
                                                                @if ($product->Fullprice->price != 0)
                                                                    <div class="caseprice">
                                                                        {{-- <small>Single Price: (Pickup)</small> --}}
                                                                        <strong>£{{ $product->Fullprice->price ? number_format($product->Fullprice->price, 2) : 0 }}</strong>
                                                                    </div>
                                                                @endif

                                                                @if ($product->Fullprice->p_price != 0)
                                                                    <div class="singleprice">
                                                                        {{-- <small>Pack Price: (Pickup)</small> --}}
                                                                        <strong>£{{ $product->Fullprice->p_price ? number_format($product->Fullprice->p_price, 2) : 0 }}</strong>
                                                                    </div>
                                                                @endif
                                                            </span>
                                                        </div>
                                                        <div class="caseorsingle">
                                                            <h3></h3>
                                                            @if ($product->Fullprice->price != 0)
                                                                <span>Single</span>
                                                            @endif
                                                            @if ($product->Fullprice->p_price != 0)
                                                                <span>Case</span>
                                                            @endif
                                                        </div>
                                                        <div class="deliveryPrice">
                                                            <span class="d-flex">
                                                                <h3>Delivery</h3>
                                                                @if ($product->Fullprice->delivery_single != 0)
                                                                    <div class="singleprice">
                                                                        {{-- <small>Single Price: (Delivery)</small> --}}
                                                                        <strong>£{{ $product->Fullprice->delivery_single ? number_format($product->Fullprice->delivery_single, 2) : 0 }}</strong>
                                                                    </div>
                                                                @endif
                                                                @if ($product->Fullprice->delivery_pack != 0)
                                                                    <div class="caseprice">
                                                                        {{-- <small>Pack Price: (Delivery)</small> --}}
                                                                        <strong>£{{ $product->Fullprice->delivery_pack ? number_format($product->Fullprice->delivery_pack, 2) : 0 }}</strong>
                                                                    </div>
                                                                @endif


                                                            </span>
                                                        </div>
                                                    </div>
                                                @endif
                                                {{-- <div class="sm:text-[14px] text-[10px] font-medium py-[5px] truncate">Pack Price:  <strong>£{{ ($product->p_price)?$product->p_price:0 }} </strong></div>
                                                <div class="sm:text-[14px] text-[10px] font-medium py-[5px] truncate">Single Price:  <strong>£{{ ($product->price)?$product->price:0 }} </strong></div> --}}
                                                {{-- @if ($product->pack_size)
                                                    <div class="sm:text-[14px] text-[10px] font-medium py-[5px] truncate">Package Size:  <strong>{{ $product->pack_size }} </strong></div>
                                                @endif --}}
                                                @if (\Auth::guard('customer')->user())
                                                    {{-- <form method="POST" action="{{ route('single-add-to-cart') }}">
                                                    @csrf --}}
                                                    <div class="flex items-center gap-2 !mt-6">

                                                        @if (\Auth::guard('customer')->user()->checkout_preference == 'delivery')
                                                            @if (Helper::checkWarehouseOfProduct($product->id, \Auth::guard('customer')->user()->warehouse))
                                                                @if ($product->Fullprice->delivery_single > 0 && $product->Fullprice->delivery_case <= 0)
                                                                    <a href="{{ route('add-to-cart', $product->slug) }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=SINGLE"
                                                                        class="ONEHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">Add
                                                                        to Cart</a>
                                                                @elseif($product->Fullprice->delivery_single <= 0 && $product->Fullprice->delivery_case > 0)
                                                                    <a href="{{ route('add-to-cart', $product->slug) }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=CASE"
                                                                        class="ONEHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">Add
                                                                        to Cart</a>
                                                                @else
                                                                    <a href="{{ route('product-detail', $product->slug ?? ' ') }}"
                                                                        class="bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">See
                                                                        Details</a>
                                                                @endif
                                                            @else
                                                                <a href="#"
                                                                    class="TWOHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">Out
                                                                    Of Stock</a>
                                                            @endif
                                                        @elseif (\Auth::guard('customer')->user()->checkout_preference == 'pickup')
                                                            @if (Helper::checkWarehouseOfProduct($product->id, \Auth::guard('customer')->user()->warehouse))
                                                                @if ($product->Fullprice->p_price > 0 && $product->Fullprice->price <= 0)
                                                                    <a href="{{ route('add-to-cart', $product->slug) }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=CASE"
                                                                        class="ONEHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">Add
                                                                        to Cart</a>
                                                                @elseif($product->Fullprice->p_price <= 0 && $product->Fullprice->price > 0)
                                                                    <a href="{{ route('add-to-cart', $product->slug) }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=SINGLE"
                                                                        class="ONEHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">Add
                                                                        to Cart</a>
                                                                @else
                                                                    <a href="{{ route('product-detail', $product->slug ?? ' ') }}"
                                                                        class="bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">See
                                                                        Details</a>
                                                                @endif
                                                            @else
                                                                <a href="#"
                                                                    class="TWOHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">Out
                                                                    Of Stock</a>
                                                            @endif
                                                        @else
                                                            <a href="{{ route('product-detail', $product->slug ?? ' ') }}"
                                                                class="bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">See
                                                                Details</a>
                                                        @endif





                                                        <a href="{{ route('wishlist') }}/{{ $product->slug }}"
                                                            class="bg-[#706233]/10 hover:bg-[#706233] hover:text-white text-[#706233] p-[10px_15px] rounded-[50%] w-[32px] h-[32px] flex items-center justify-center !ml-2">
                                                            <i class="fa fa-heart-o sm:text-[14px] text-[10px]"
                                                                aria-hidden="true"></i>
                                                        </a>
                                                        <a href="{{ route('product-detail', $product->slug) }}"
                                                            class="bg-[#706233]/10 hover:bg-[#706233] hover:text-white text-[#706233] p-[10px_15px] rounded-[50%] w-[32px] h-[32px] flex items-center justify-center !ml-2">
                                                            <i class="fa fa-eye  sm:text-[14px] text-[10px]"
                                                                aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                    {{-- </form> --}}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single List -->
                            @endforeach
                        @else
                            <h4 class="text-yellow-500 m-[100px_auto] text-[40px]">There are no products.</h4>
                        @endif
                        <div class="flex flex-wrap mt-10 product-pagination">
                            <div class="md:w-11/12 justify-center flex">
                                @if (Session::get('filter'))
                                    {{ $products->appends(Session::get('filters'))->links() }}
                                @else
                                    {{ $products->appends($_GET)->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/ End Product list style end -->
        </form>

        <!-- Product Style -->


        <?php }else{

        $cat_id = request()->segment(count(request()->segments()));
    ?>
        {{-- <form action="{{ route('shop.filter') }}" method="POST"> --}}
        @if (str_contains(Request::url(), 'product-cat'))
            <form action="{{ route('product-cat', $cat_id) }}" method="GET">
            @else
                <form action="" method="GET">
        @endif
        {{-- @csrf --}}
        <section class="py-[40px]">
            <div class="!container mx-auto px-6">
                <div class="grid lg:grid-cols-12 grid-cols-1 gap-4 relative">
                    <button type="button"
                        class="btn sm:flex items-center gap-3 text-[#706233] text-[14px] lg:hidden hidden active:!outline-0 active:!border-none !border-none !outline-0"
                        data-bs-toggle="modal" data-bs-target="#mobile-category">
                        <span
                            class="w-[35px] h-[35px] bg-[#706233]/10 rounded-full flex items-center justify-center relative">
                            <i class="fa fa-bars text-[18px] text-[#706233]" aria-hidden="true"></i>
                        </span>
                        Show Sidebar
                    </button>
                    @if (str_contains(Request::url(), 'product-cat'))
                        <input type="hidden" value="{{ request()->segment(count(request()->segments())) }}"
                            name="product_cat" />
                    @endif
                    <input type="hidden" value="true" name="filter" />
                    <div class="xl:col-span-3 lg:col-span-4 lg:block hidden">
                        <div class="p-[15px] !border !border-[#706233]/10 rounded-[5px] ">
                            <h3
                                class="text-[20px] font-bold mb-[20px] border-b border-[#706233]/10 pb-[10px] relative before:absolute before:content-[''] before:w-[60px] before:left-0 before:h-[4px] before:rounded-[50%] before:-bottom-[2px] before:bg-[#706233]">
                                Categories</h3>
                            <div class="dropdown">
                                @php
                                    // $category = new Category();
                                    $menu = App\Category::getAllParentWithChild();
                                @endphp
                                @if ($menu)
                                    @foreach ($menu as $cat_info)
                                        <?php
                                        $sub_cat = \App\Category::where('parent_id', $cat_info->id)->get();
                                        ?>
                                        @if (count($sub_cat) > 0)
                                            <a class="py-[8px] flex items-center justify-between" href="#"
                                                role="button" id="dropdownMenuLink{{ $cat_info->id }}"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ $cat_info->name }}
                                                <i class="fa fa-angle-down ml-3" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu lg:!absolute lg:!left-full  lg:!-mt-[30px] lg:!ml-[15px] !shadow-[0px_0px_30px_#7f89a140] !border-0"
                                                aria-labelledby="dropdownMenuLink{{ $cat_info->id }}">
                                                <li><a class="dropdown-item "
                                                        href="{{ route('product-cat', $cat_info->id) }}">{{ $cat_info->name }}</a>
                                                </li>
                                                @foreach ($sub_cat as $sub_menu)
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('product-cat', $sub_menu->id) }}">{{ $sub_menu->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <!-- <a class="bg-[#706233] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold" href="{{ route('product-cat', $cat_info->id) }}" role="button"
                                                    id="dropdownMenuLink{{ $cat_info->id }}">
                                                    {{ $cat_info->name }}
                                                </a> -->
                                        @endif
                                    @endforeach

                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- side bar end --}}
                    <div class="xl:col-span-9 lg:col-span-8">
                        <!-- Shop Top -->
                        <div class="flex items-center flex-wrap gap-3 mb-[40px] relative">
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
                            <div class="flex items-center gap-3 sm:w-auto w-full">
                                <div class="sm:flex items-center gap-2">
                                    <label>Filter :</label>
                                    <select
                                        class="sm:w-[120px] w-full p-[8px_10px] rounded-[5px] !border !border-[#e7e7e7] "
                                        name="show" onchange="this.form.submit();">
                                        <option value="9">Default</option>
                                        <option value="9" @if (!empty($_GET['show']) && $_GET['show'] == '9') selected @endif>09
                                        </option>
                                        <option value="15" @if (!empty($_GET['show']) && $_GET['show'] == '15') selected @endif>15
                                        </option>
                                        <option value="21" @if (!empty($_GET['show']) && $_GET['show'] == '21') selected @endif>21
                                        </option>
                                        <option value="30" @if (!empty($_GET['show']) && $_GET['show'] == '30') selected @endif>30
                                        </option>
                                    </select>
                                </div>
                                <div class="sm:flex items-center gap-2">
                                    <label>Filter By :</label>
                                    <select
                                        class='sm:w-[120px] w-full p-[8px_10px] rounded-[5px] !border !border-[#e7e7e7]'
                                        name='sortBy' onchange="this.form.submit();">
                                        <option value="">Default</option>
                                        <option value="name" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'name') selected @endif>
                                            Name</option>
                                        <option value="priceAsc" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'price?sort=asc') selected @endif>
                                            Price (Lowest To Highest)</option>
                                        <option value="priceDesc" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'price?sort=desc') selected @endif>
                                            Price (Highest To Lowest)</option>
                                        {{-- <option value="category" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'category') selected @endif>
                                            Category</option>
                                        <option value="brand" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'brand') selected @endif>
                                            Brand</option> --}}
                                    </select>
                                </div>
                            </div>
                            <button type="button"
                                class="absolute !-bottom-[1px] left-0 btn flex items-center gap-3 text-[#706233] text-[14px] sm:hidden active:!outline-0 active:!border-none !border-none !outline-0 !p-0"
                                data-bs-toggle="modal" data-bs-target="#mobile-category">
                                <span
                                    class="w-[35px] h-[35px] bg-[#706233]/10 rounded-full flex items-center justify-center relative">
                                    <i class="fa fa-bars text-[18px] text-[#706233]" aria-hidden="true"></i>
                                </span>
                                Show Sidebar
                            </button>
                            <ul class="flex items-center gap-2 ml-auto gridlistbox ">
                                <li class="w-[43px] h-[32px] flex items-center justify-center rounded-[5px] bg-[#706233]">
                                    <a href="{{ URL::to('design', ['id' => 'grid']) }}" class="text-white">
                                        <i class="fa fa-th-large"></i>
                                    </a>
                                </li>
                                <li
                                    class="w-[43px] h-[32px] flex items-center justify-center rounded-[5px] bg-[#706233]/10">
                                    <a href="{{ URL::to('design', ['id' => 'list']) }}">
                                        <i class="fa fa-th-list"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!--/ End Shop Top -->
                        <div class="grid md:grid-cols-12 sm:grid-cols-1 gap-4">
                            {{-- @php
                                if(Session::get('filter')){
                                    $products = Session::get('products');
                                }
                            @endphp --}}
                            {{-- {{$products}} --}}
                            @if (count($products) > 0)
                                @foreach ($products as $product)
                                    {{-- @if (isset($product->Fullprice->delivery_pack))
                              {{$product->Fullprice->delivery_pack}}
                              @endif --}}
                                @if(isset($product->Fullprice) && $product->Fullprice->p_price !=0 || $product->Fullprice && $product->Fullprice->price != 0)
                                    <div class="xl:col-span-3 lg:col-span-4 md:col-span-6 faisal">
                                        @php
                                            $startdate = \Carbon\Carbon::parse($product->StartingDate);
                                            $engdate = \Carbon\Carbon::parse($product->EndingDate);
                                            $engdatefinal = $engdate->format('Y-m-d');
                                            $startdatefinal = $startdate->format('Y-m-d');
                                            $now = \Carbon\Carbon::now()->format('Y-m-d');
                                            //  echo strtotime($now).'-'.strtotime($startdatefinal);
                                        @endphp

                                        <div
                                            class="gridcontroll p-[15px] rounded-[5px]  !border !border-[#706233]/10 hover:!border-[#706233] transition duration-300">
                                            @if (
                                                $product->EndingDate != null &&
                                                    strtotime($startdatefinal) <= strtotime($now) &&
                                                    strtotime($engdatefinal) >= strtotime($now))
                                                <div class="saleoffer">
                                                    <span class="promottxt">Promotion</span>
                                                    <span class="newbadge">End. {{ $engdate->format('d-m-Y') }}</span>
                                                </div>
                                            @endif
                                            <div class="mb-[15px] relative w-full min-h-[150px] group">
                                                <a href="{{ route('product-detail', $product->slug) }}">
                                                    @php
                                                        $photo = explode(',', $product->image);
                                                        $photo = str_replace('storage/', '', $photo);
                                                    @endphp
                                                    {{-- <img class="w-[70%] mx-auto transform group-hover:scale-110 transition duration-300" src="{{asset('storage/thumbnail/'.$photo[0])}}" alt=""> --}}
                                                    <img class="w-[70%] mx-auto transform group-hover:scale-110 transition duration-300"
                                                        src="{{ image_url('storage/' . $photo[0]) }}" alt="">
                                                    {{-- @if ($product->discount)
                                                        <span class="absolute p-[2px_8px] text-white bg-[#706233] rounded-[5px] top-[1px] left-[1px]">{{$product->discount}} % Off</span>
                                                    @endif --}}
                                                </a>
                                            </div>
                                            <div class="text-center">
                                                {{-- @if (\Auth::guard('customer')->user())
                                                    <form action="{{route('single-add-to-cart')}}" method="POST">
                                                @csrf
                                                @endif --}}
                                                <h3
                                                    class="py-[5px] font-bold sm:text-[16px] text-[13px] text-center text-[#706233] height-[65px]">
                                                    <a href="{{ route('product-detail', $product->slug) }}"
                                                        class="hover:text[#706233]">{{ $product->name }}</a>
                                                </h3>
                                                <div class="sm:text-[12px] text-[10px] font-medium py-[5px] truncate">Pack
                                                    Size: <strong>{{ $product->pack_size }} </strong></div>
                                                @if (\Auth::guard('customer')->user())
                                                    <div class="d-flex custom_design_hm">
                                                        <div>
                                                            <span class="d-flex">
                                                                <small>Case:
                                                                    <br>({{ \Auth::guard('customer')->user()->checkout_preference }})</small>
                                                                @if (\Auth::guard('customer')->user()->checkout_preference == 'delivery')
                                                                    <strong>{{ $product->Fullprice && $product->Fullprice->delivery_pack ? '£' . number_format($product->Fullprice->delivery_pack, 2) : 'NA' }}</strong>
                                                                @else
                                                                    <strong>{{ $product->Fullprice && $product->Fullprice->p_price ? '£' . number_format($product->Fullprice->p_price, 2) : 'NA' }}</strong>
                                                                @endif
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="d-flex">
                                                                <small>Single:
                                                                    <br>({{ \Auth::guard('customer')->user()->checkout_preference }})</small>
                                                                @if (\Auth::guard('customer')->user()->checkout_preference == 'delivery')
                                                                    <strong>{{ $product->Fullprice && $product->Fullprice->delivery_single ? '£' . number_format($product->Fullprice->delivery_single, 2) : 'NA' }}</strong>
                                                                @else
                                                                    <strong>{{ $product->Fullprice && $product->Fullprice->price ? '£' . number_format($product->Fullprice->price, 2) : 'NA' }}</strong>
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="d-flex custom_design_hm">
                                                        <div class="collectionPrice">
                                                            <span class="d-flex">
                                                                <h3>Collection</h3>
                                                                @if ($product->Fullprice && $product->Fullprice->price != 0)
                                                                    <div class="caseprice">
                                                                        {{-- <small>Single Price: (Pickup)</small> --}}
                                                                        <strong>£{{ $product->Fullprice->price ? number_format($product->Fullprice->price, 2) : 0 }}</strong>
                                                                    </div>
                                                                @endif
                                                                @if ($product->Fullprice && $product->Fullprice->p_price != 0)
                                                                    <div class="singleprice">
                                                                        {{-- <small>Pack Price: (Pickup)</small> --}}
                                                                        <strong>£{{ $product->Fullprice->p_price ? number_format($product->Fullprice->p_price, 2) : 0 }}</strong>
                                                                    </div>
                                                                @endif
                                                            </span>
                                                        </div>
                                                        <div class="caseorsingle">
                                                            <h3></h3>
                                                            @if ($product->Fullprice && $product->Fullprice->price != 0)
                                                                <span>Single</span>
                                                            @endif
                                                            @if ($product->Fullprice && $product->Fullprice->p_price != 0)
                                                                <span>Case</span>
                                                            @endif
                                                        </div>
                                                        <div class="deliveryPrice">
                                                            <span class="d-flex">
                                                                <h3>Delivery</h3>
                                                                @if ($product->Fullprice && $product->Fullprice->delivery_single != 0)
                                                                    <div class="singleprice">
                                                                        {{-- <small>Single Price: (Delivery)</small> --}}
                                                                        <strong>£{{ $product->Fullprice->delivery_single ? number_format($product->Fullprice->delivery_single, 2) : 0 }}</strong>
                                                                    </div>
                                                                @endif
                                                                @if ($product->Fullprice && $product->Fullprice->delivery_pack != 0)
                                                                    <div class="caseprice">
                                                                        {{-- <small>Pack Price: (Delivery)</small> --}}
                                                                        <strong>£{{ $product->Fullprice->delivery_pack ? number_format($product->Fullprice->delivery_pack, 2) : 0 }}</strong>
                                                                    </div>
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endif


                                                {{-- <div class="sm:text-[14px] text-[10px] font-medium py-[5px] truncate">Pack Price:  <strong>£{{ ($product->p_price)?$product->p_price:0 }} </strong></div>
                                                <div class="sm:text-[14px] text-[10px] font-medium py-[5px] truncate">Single Price:  <strong>£{{ ($product->price)?$product->price:0 }} </strong></div> --}}
                                                {{-- @if ($product->pack_size)
                                                    <div class="sm:text-[14px] text-[10px] font-medium py-[5px] truncate">Package Size:  <strong>{{ $product->pack_size }} </strong></div>
                                                @endif --}}

                                                @if (\Auth::guard('customer')->user())
                                                    <div class="flex flex-wrap items-center gap-2 !mt-6">
                                                        {{--                                                    @if (\Auth::guard('customer')->user()->checkout_preference == 'delivery') --}}
                                                        {{--                                                        @if (Helper::checkWarehouseOfProduct($product->id, \Auth::guard('customer')->user()->warehouse)) --}}

                                                        {{--                                                            @if ($product->Fullprice->delivery_single > 0 && $product->Fullprice->delivery_case <= 0) --}}
                                                        {{--                                                                <a href="{{ route('add-to-cart',$product->slug) }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=SINGLE" class="ONEHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white" >Add to Cart</a> --}}
                                                        {{--                                                            @elseif($product->Fullprice->delivery_single <= 0 && $product->Fullprice->delivery_case > 0) --}}
                                                        {{--                                                                <a href="{{ route('add-to-cart',$product->slug) }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=CASE" class="ONEHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white" >Add to Cart</a> --}}
                                                        {{--                                                            @else --}}
                                                        {{--                                                                <a href="{{ route('product-detail', $product->slug?? ' ') }}" class="bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">See Details</a> --}}
                                                        {{--                                                            @endif --}}

                                                        {{--                                                        @else --}}

                                                        {{--                                                            <a href="#" class="TWOHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">Out Of Stock</a> --}}

                                                        {{--                                                        @endif --}}

                                                        {{--                                                    @elseif (\Auth::guard('customer')->user()->checkout_preference == "pickup") --}}
                                                        {{--                                                        @if (Helper::checkWarehouseOfProduct($product->id, \Auth::guard('customer')->user()->warehouse)) --}}


                                                        {{--                                                            @if ($product->Fullprice->p_price > 0 && $product->Fullprice->price <= 0) --}}
                                                        {{--                                                                <a href="{{ route('add-to-cart',$product->slug) }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=CASE" class="ONEHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white" >Add to Cart</a> --}}
                                                        {{--                                                                <a href="{{ route('wishlist') }}/{{ $product->slug }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=CASE" class="bg-[#706233]/10 hover:bg-[#706233] hover:text-white text-[#706233] p-[10px_15px] rounded-[50%] w-[32px] h-[32px] flex items-center justify-center !ml-2"> --}}
                                                        {{--                                                                    <i class="fa fa-heart-o sm:text-[14px] text-[10px]" aria-hidden="true"></i> --}}
                                                        {{--                                                                </a> --}}
                                                        {{--                                                            @elseif($product->Fullprice->p_price <= 0 && $product->Fullprice->price > 0) --}}
                                                        {{--                                                                <a href="{{ route('add-to-cart',$product->slug) }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=SINGLE" class="ONEHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white" >Add to Cart</a> --}}
                                                        {{--                                                                <a href="{{ route('wishlist') }}/{{ $product->slug }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=SINGLE" class="bg-[#706233]/10 hover:bg-[#706233] hover:text-white text-[#706233] p-[10px_15px] rounded-[50%] w-[32px] h-[32px] flex items-center justify-center !ml-2"> --}}
                                                        {{--                                                                    <i class="fa fa-heart-o sm:text-[14px] text-[10px]" aria-hidden="true"></i> --}}
                                                        {{--                                                                </a> --}}
                                                        {{--                                                            @else --}}
                                                        {{--                                                           --}}
                                                        {{--                                                                <a href="{{ route('product-detail', $product->slug?? ' ') }}" class="bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">See Details</a> --}}
                                                        {{--                                                                <a href="{{ route('wishlist') }}/{{ $product->slug }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=SINGLE" class="bg-[#706233]/10 hover:bg-[#706233] hover:text-white text-[#706233] p-[10px_15px] rounded-[50%] w-[32px] h-[32px] flex items-center justify-center !ml-2"> --}}
                                                        {{--                                                                    <i class="fa fa-heart-o sm:text-[14px] text-[10px]" aria-hidden="true"></i> --}}
                                                        {{--                                                                </a> --}}
                                                        {{--                                                                @endif --}}


                                                        {{--                                                        @else --}}

                                                        {{--                                                            <a href="#" class="TWOHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">Out Of Stock</a> --}}

                                                        {{--                                                        @endif --}}
                                                        {{--                                                    @else --}}
                                                        {{--                                                        <a href="{{ route('product-detail', $product->slug?? ' ') }}" class="bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">See Details</a> --}}
                                                        {{--                                                    @endif --}}

                                                        @if (\Auth::guard('customer')->user()->checkout_preference == 'delivery')
                                                            @if (Helper::checkWarehouseOfProduct($product->id, \Auth::guard('customer')->user()->warehouse))
                                                                @if ($product->Fullprice && $product->Fullprice->delivery_single > 0 && $product->Fullprice->delivery_case <= 0)
                                                                    <a href="{{ route('add-to-cart', $product->slug) }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=SINGLE"
                                                                        class="ONEHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">Add
                                                                        to Cart</a>
                                                                @elseif ($product->Fullprice && $product->Fullprice->delivery_single <= 0 && $product->Fullprice->delivery_case > 0)
                                                                    <a href="{{ route('add-to-cart', $product->slug) }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=CASE"
                                                                        class="ONEHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">Add
                                                                        to Cart</a>
                                                                @else
                                                                    <a href="{{ route('product-detail', $product->slug ?? ' ') }}"
                                                                        class="bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">See
                                                                        Details</a>
                                                                @endif
                                                            @else
                                                                <a href="#"
                                                                    class="TWOHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover-bg-[#706233] hover-text-white">Out
                                                                    Of Stock</a>
                                                            @endif
                                                        @elseif (\Auth::guard('customer')->user()->checkout_preference == 'pickup')
                                                            @if (Helper::checkWarehouseOfProduct($product->id, \Auth::guard('customer')->user()->warehouse))
                                                                @if ($product->Fullprice && $product->Fullprice->p_price > 0 && $product->Fullprice->price <= 0)
                                                                    <a href="{{ route('add-to-cart', $product->slug) }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=CASE"
                                                                        class="ONEHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover-bg-[#706233] hover-text-white">Add
                                                                        to Cart</a>
                                                                    <a href="{{ route('wishlist') }}/{{ $product->slug }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=CASE"
                                                                        class="bg-[#706233]/10 hover-bg-[#706233] hover-text-white text-[#706233] p-[10px_15px] rounded-[50%] w-[32px] h-[32px] flex items-center justify-center !ml-2">
                                                                        <i class="fa fa-heart-o sm:text-[14px] text-[10px]"
                                                                            aria-hidden="true"></i>
                                                                    </a>
                                                                @elseif ($product->Fullprice && $product->Fullprice->p_price <= 0 && $product->Fullprice->price > 0)
                                                                    <a href="{{ route('add-to-cart', $product->slug) }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=SINGLE"
                                                                        class="ONEHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover-bg-[#706233] hover-text-white">Add
                                                                        to Cart</a>
                                                                    <a href="{{ route('wishlist') }}/{{ $product->slug }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=SINGLE"
                                                                        class="bg-[#706233]/10 hover-bg-[#706233] hover-text-white text-[#706233] p-[10px_15px] rounded-[50%] w-[32px] h-[32px] flex items-center justify-center !ml-2">
                                                                        <i class="fa fa-heart-o sm:text-[14px] text-[10px]"
                                                                            aria-hidden="true"></i>
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('product-detail', $product->slug ?? ' ') }}"
                                                                        class="bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover-bg-[#706233] hover-text-white">See
                                                                        Details</a>
                                                                    <a href="{{ route('wishlist') }}/{{ $product->slug }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=SINGLE"
                                                                        class="bg-[#706233]/10 hover-bg-[#706233] hover-text-white text-[#706233] p-[10px_15px] rounded-[50%] w-[32px] h-[32px] flex items-center justify-center !ml-2">
                                                                        <i class="fa fa-heart-o sm:text-[14px] text-[10px]"
                                                                            aria-hidden="true"></i>
                                                                    </a>
                                                                @endif
                                                            @else
                                                                <a href="#"
                                                                    class="TWOHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover-bg-[#706233] hover-text-white">Out
                                                                    Of Stock</a>
                                                            @endif
                                                        @else
                                                            <a href="{{ route('product-detail', $product->slug ?? ' ') }}"
                                                                class="bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover-bg-[#706233] hover-text-white">See
                                                                Details</a>
                                                        @endif

                                                        {{-- @if ($product->price > 0 && $product->p_price <= 0)
                                                        @if (Helper::checkWarehouseOfProduct($product->id, \Auth::guard('customer')->user()->warehouse))
                                                            <a title="Add to cart" href="{{route('add-to-cart',$product->slug)}}" class="HASSAN bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] sm:text-[14px] text-[10px] hover:bg-[#706233] hover:text-white">Add to Cart</a>
                                                        @else
                                                            <a href="#" class="TWOHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">Out Of Stock</a>
                                                        @endif
                                                    @else
                                                        <a href="{{route('product-detail',$product->slug)}}" class="bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">See Details</a>
                                                    @endif --}}

                                                        {{-- <a href="{{ route('wishlist') }}/{{ $product->slug }}" class="bg-[#706233]/10 hover:bg-[#706233] hover:text-white text-[#706233] p-[10px_15px] rounded-[50%] w-[32px] h-[32px] flex items-center justify-center !ml-2">
                                                        <i class="fa fa-heart-o sm:text-[14px] text-[10px]" aria-hidden="true"></i>
                                                    </a> --}}

                                                        <a href="{{ route('product-detail', $product->slug) }}"
                                                            class="bg-[#706233]/10 hover:bg-[#706233] hover:text-white text-[#706233] p-[10px_15px] rounded-[50%] w-[32px] h-[32px] flex items-center justify-center ml-auto">
                                                            <i class="fa fa-eye  sm:text-[14px] text-[10px]"
                                                                aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                                @if (\Auth::guard('customer')->user())
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @endforeach
                            @else
                                <h4 class="text-yellow-500 m-[100px_auto] text-[40px]">There are no products.</h4>
                            @endif
                        </div>
                        <div class="flex flex-wrap mt-10 product-pagination">
                            <div class="md:w-11/12 justify-center flex">
                                {{ $products->appends($_GET)->links() }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        </form>

        <?php  } ?>


        <!-- Mobile menu popup -->

        <div class="modal fade left" id="mobile-category" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content border-0 rounded-none h-full">
                    <div class="modal-body">
                        <div class="flex justify-end mb-3">
                            <i class="fa fa-times text-[24px] cursor-pointer" data-bs-dismiss="modal"
                                aria-hidden="true"></i>
                        </div>
                        <div class="p-[15px] !border !border-[#706233]/10 rounded-[5px] ">
                            <h3
                                class="text-[20px] font-bold mb-[20px] border-b border-[#706233]/10 pb-[10px] relative before:absolute before:content-[''] before:w-[60px] before:left-0 before:h-[4px] before:rounded-[50%] before:-bottom-[2px] before:bg-[#706233]">
                                Categories</h3>
                            <div class="dropdown h-[calc(100vh-150px)] overflow-y-auto">
                                @php
                                    // $category = new Category();
                                    $menu = App\Category::getAllParentWithChild();
                                @endphp
                                @if ($menu)
                                    @foreach ($menu as $cat_info)
                                        <?php
                                        $sub_cat = \App\Category::where('parent_id', $cat_info->id)->get();
                                        ?>
                                        @if (count($sub_cat) > 0)
                                            <a class="py-[8px] flex items-center justify-between" href="#"
                                                role="button" id="dropdownMenuLink{{ $cat_info->id }}"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ $cat_info->name }}
                                                <i class="fa fa-angle-down ml-3" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu lg:!absolute lg:!left-full  lg:!-mt-[30px] lg:!ml-[15px] !shadow-[0px_0px_30px_#7f89a140] !border-0"
                                                aria-labelledby="dropdownMenuLink{{ $cat_info->id }}">
                                                <li><a class="dropdown-item "
                                                        href="{{ route('product-cat', $cat_info->id) }}">{{ $cat_info->name }}</a>
                                                </li>
                                                @foreach ($sub_cat as $sub_menu)
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('product-cat', $sub_menu->id) }}">{{ $sub_menu->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <!-- <a class="bg-[#706233] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold" href="{{ route('product-cat', $cat_info->id) }}" role="button"
                                            id="dropdownMenuLink{{ $cat_info->id }}">
                                            {{ $cat_info->name }}
                                        </a> -->
                                        @endif
                                    @endforeach

                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

@endsection
