<?php  $image= $product->image;
        $images = explode(',',$image);
?>
<div class="bg-white !border !border-[#706233]/10 rounded-[5px] p-[15px] group">
    <a href="{{ route('product-detail', $product->slug?? ' ') }}" >
        <div class="mb-[15px] relative w-full min-h-[150px]">
            @php
                $images[0] = str_replace('storage/','',$images[0]);
            @endphp
            <img src="{{image_url('storage/'.$images[0])}}" class="w-[50%] mx-auto transform group-hover:scale-110 transition duration-300" />
            {{-- <img src="{{asset('storage/thumbnail/'.$images[0])}}" class="w-[50%] mx-auto transform group-hover:scale-110 transition duration-300" /> --}}
        </div>
        <div class="text-center">
            <a href="{{ route('product-detail', $product->slug?? ' ') }}" class="hover:text-[#706233] font-bold py-[5px] block height-[45px]">{{ $product->name }}</a>


{{--            @if (\Auth::guard('customer')->user())--}}
{{--                    <div class="d-flex custom_design_hm">--}}

{{--                        <div>--}}
{{--                            <span class="d-flex">--}}
{{--                                <small>Case: <br>({{ \Auth::guard('customer')->user()->checkout_preference }})</small>--}}
{{--                                @if(\Auth::guard('customer')->user()->checkout_preference == "delivery")--}}
{{--                                    <strong>{{ ($product->Fullprice->delivery_pack)?'£'.number_format($product->Fullprice->delivery_pack,2):'NA' }}</strong>--}}
{{--                                @else--}}
{{--                                    <strong>{{ ($product->Fullprice->p_price)?'£'.number_format($product->Fullprice->p_price,2):'NA' }}</strong>--}}
{{--                                @endif--}}
{{--                            </span>--}}
{{--                        </div>--}}


{{--                        <div>--}}
{{--                            <span class="d-flex">--}}
{{--                            <small>Single: <br>({{ \Auth::guard('customer')->user()->checkout_preference }})</small>--}}
{{--                            @if(\Auth::guard('customer')->user()->checkout_preference == "delivery")--}}
{{--                                    <strong>{{ ($product->Fullprice->delivery_single)?'£'.number_format($product->Fullprice->delivery_single,2):'NA' }}</strong>--}}
{{--                                @else--}}
{{--                                    <strong>{{ ($product->Fullprice->price)?'£'.number_format($product->Fullprice->price,2):'NA' }}</strong>--}}
{{--                                @endif--}}

{{--                            </span>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--            @else--}}
{{--                    <div class="d-flex custom_design_hm">--}}
{{--                        <div class="collectionPrice">--}}
{{--                            <span class="d-flex">--}}
{{--                                            <h3>Collection</h3>--}}
{{--                                @if($product->price != 0)--}}
{{--                                    <div class="caseprice">--}}
{{--                                        --}}{{--<small>Single Price: (Pickup)</small>--}}
{{--                                    <strong>£{{ ($product->Fullprice->price)?number_format($product->Fullprice->price,2):0 }}</strong>--}}
{{--                                    </div>--}}
{{--                                @endif--}}

{{--                                @if($product->p_price != 0)--}}
{{--                                    <div class="singleprice">--}}
{{--                                        --}}{{--    <small>Pack Price: (Pickup)</small>--}}
{{--                                    <strong>£{{ ($product->Fullprice->p_price)?number_format($product->Fullprice->p_price,2):0 }}</strong>--}}
{{--                                </div>--}}
{{--                                @endif--}}
{{--                            </span>--}}
{{--                        </div>--}}
{{--                        <div class="caseorsingle">--}}
{{--                            <h3></h3>--}}
{{--                            @if($product->Fullprice->price != 0)--}}
{{--                                <span>Single</span>--}}
{{--                            @endif--}}
{{--                            @if($product->Fullprice->p_price != 0)--}}
{{--                                <span>Case</span>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                        <div class="deliveryPrice">--}}
{{--                            <span class="d-flex">--}}
{{--                                    <h3>Delivery</h3>--}}
{{--                                    @if($product->Fullprice->delivery_single != 0)--}}
{{--                                    <div class="singleprice">--}}
{{--                                    --}}{{--<small>Single Price: (Delivery)</small>--}}
{{--                                    <strong>£{{ ($product->Fullprice->delivery_single)?number_format($product->Fullprice->delivery_single,2):0 }}</strong>--}}
{{--                                </div>--}}
{{--                                @endif--}}
{{--                                @if($product->Fullprice->delivery_pack != 0)--}}
{{--                                    <div class="caseprice">--}}
{{--                                    --}}{{--<small>Pack Price: (Delivery)</small>--}}
{{--                                    <strong>£{{ ($product->Fullprice->delivery_pack)?number_format($product->Fullprice->delivery_pack,2):0 }}</strong>--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                            </span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--            @endif--}}
            @if (\Auth::guard('customer')->user())
                <div class="d-flex custom_design_hm">
                    <div>
            <span class="d-flex">
                <small>Case: <br>({{ \Auth::guard('customer')->user()->checkout_preference }})</small>
                @if(\Auth::guard('customer')->user()->checkout_preference == "delivery")
                    <strong>{{ ($product->Fullprice && $product->Fullprice->delivery_pack)?'£'.number_format($product->Fullprice->delivery_pack,2):'NA' }}</strong>
                @else
                    <strong>{{ ($product->Fullprice && $product->Fullprice->p_price)?'£'.number_format($product->Fullprice->p_price,2):'NA' }}</strong>
                @endif
            </span>
                    </div>
                    <div>
            <span class="d-flex">
                <small>Single: <br>({{ \Auth::guard('customer')->user()->checkout_preference }})</small>
                @if(\Auth::guard('customer')->user()->checkout_preference == "delivery")
                    <strong>{{ ($product->Fullprice && $product->Fullprice->delivery_single)?'£'.number_format($product->Fullprice->delivery_single,2):'NA' }}</strong>
                @else
                    <strong>{{ ($product->Fullprice && $product->Fullprice->price)?'£'.number_format($product->Fullprice->price,2):'NA' }}</strong>
                @endif
            </span>
                    </div>
                </div>
            @else
                <div class="d-flex custom_design_hm">
                    <div class="collectionPrice">
            <span class="d-flex">
                <h3>Collection</h3>
                @if($product->price != 0)
                    <div class="caseprice">
                        {{--<small>Single Price: (Pickup)</small>--}}
                        <strong>£{{ ($product->Fullprice && $product->Fullprice->price)?number_format($product->Fullprice->price,2):0 }}</strong>
                    </div>
                @endif

                @if($product->p_price != 0)
                    <div class="singleprice">
                        {{--<small>Pack Price: (Pickup)</small>--}}
                        <strong>£{{ ($product->Fullprice && $product->Fullprice->p_price)?number_format($product->Fullprice->p_price,2):0 }}</strong>
                    </div>
                @endif
            </span>
                    </div>
                    <div class="caseorsingle">
                        <h3></h3>
                        @if($product->Fullprice && $product->Fullprice->price != 0)
                            <span>Single</span>
                        @endif
                        @if($product->Fullprice && $product->Fullprice->p_price != 0)
                            <span>Case</span>
                        @endif
                    </div>
                    <div class="deliveryPrice">
            <span class="d-flex">
                <h3>Delivery</h3>
                @if($product->Fullprice && $product->Fullprice->delivery_single != 0)
                    <div class="singleprice">
                        {{--<small>Single Price: (Delivery)</small>--}}
                        <strong>£{{ ($product->Fullprice && $product->Fullprice->delivery_single)?number_format($product->Fullprice->delivery_single,2):0 }}</strong>
                    </div>
                @endif
                @if($product->Fullprice && $product->Fullprice->delivery_pack != 0)
                    <div class="caseprice">
                        {{--<small>Pack Price: (Delivery)</small>--}}
                        <strong>£{{ ($product->Fullprice && $product->Fullprice->delivery_pack)?number_format($product->Fullprice->delivery_pack,2):0 }}</strong>
                    </div>
                @endif
            </span>
                    </div>
                </div>
            @endif


            {{-- <div class="qty-input w-100 justify-center">
                <button class="qty-count qty-count--minus" data-action="minus" type="button">-</button>
                <input class="product-qty w-75" type="number" name="quant[1]"  class="w-[70px] p-[8px_5px] rounded-[5px] !border border-[#706233]/10" min="1" max="10" data-min="1" data-max="10" value="1" id="quantity">
                <button class="qty-count " data-action="add" type="button">+</button>
            </div> --}}
        </div>
    </a>
{{--    @if(\Auth::guard('customer')->user())--}}
{{--        <div class="flex items-center gap-2 !mt-6">--}}

{{--        @if (\Auth::guard('customer')->user()->checkout_preference == "delivery")--}}
{{--            @if (Helper::checkWarehouseOfProduct($product->id,\Auth::guard('customer')->user()->warehouse))--}}

{{--                @if ($product->Fullprice->delivery_single > 0 && $product->Fullprice->delivery_case <= 0 )--}}
{{--                    <a href="{{ route('add-to-cart',$product->slug) }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=SINGLE" class="ONEHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white" >Add to Cart</a>--}}
{{--                @elseif($product->Fullprice->delivery_single <= 0 && $product->Fullprice->delivery_case > 0)--}}
{{--                    <a href="{{ route('add-to-cart',$product->slug) }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=CASE" class="ONEHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white" >Add to Cart</a>--}}
{{--                @else--}}
{{--                    <a href="{{ route('product-detail', $product->slug?? ' ') }}" class="bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">See Details</a>--}}
{{--                @endif--}}

{{--            @else--}}

{{--                <a href="#" class="TWOHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">Out Of Stock</a>--}}

{{--            @endif--}}

{{--        @elseif (\Auth::guard('customer')->user()->checkout_preference == "pickup")--}}
{{--            @if (Helper::checkWarehouseOfProduct($product->id,\Auth::guard('customer')->user()->warehouse))--}}


{{--                @if ($product->Fullprice->p_price > 0 && $product->Fullprice->price <= 0 )--}}
{{--                    <a href="{{ route('add-to-cart',$product->slug) }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=CASE" class="ONEHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white" >Add to Cart</a>--}}
{{--                @elseif($product->Fullprice->p_price <= 0 && $product->Fullprice->price > 0)--}}
{{--                    <a href="{{ route('add-to-cart',$product->slug) }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=SINGLE" class="ONEHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white" >Add to Cart</a>--}}
{{--                @else--}}
{{--                    <a href="{{ route('product-detail', $product->slug?? ' ') }}" class="bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">See Details</a>--}}
{{--                @endif--}}


{{--            @else--}}

{{--                <a href="#" class="TWOHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">Out Of Stock</a>--}}

{{--            @endif--}}
{{--        @else--}}
{{--            <a href="{{ route('product-detail', $product->slug?? ' ') }}" class="bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">See Details</a>--}}
{{--        @endif--}}

{{--        <a href="{{ route('wishlist')}}/{{ $product->slug }}" class="bg-[#706233]/10 hover:bg-[#706233] hover:text-white text-[#706233] p-[10px_15px] rounded-[50%] w-[32px] h-[32px] flex items-center justify-center !ml-2">--}}
{{--            <i class="fa fa-heart-o sm:text-[14px] text-[10px]" aria-hidden="true"></i>--}}
{{--        </a>--}}
{{--        <a href="{{ route('product-detail', $product->slug?? ' ') }}" class="bg-[#706233]/10 hover:bg-[#706233] hover:text-white text-[#706233] p-[10px_15px] rounded-[50%] w-[32px] h-[32px] flex items-center justify-center ml-auto">--}}
{{--            <i class="fa fa-eye  text-[14px]" aria-hidden="true"></i>--}}
{{--        </a>--}}
{{--        </div>--}}
{{--    @endif--}}
    @if (\Auth::guard('customer')->user())
        <div class="flex items-center gap-2 !mt-6">

            @if (\Auth::guard('customer')->user()->checkout_preference == "delivery")
                @if (Helper::checkWarehouseOfProduct($product->id, \Auth::guard('customer')->user()->warehouse))
                    @if ($product->Fullprice && $product->Fullprice->delivery_single > 0 && $product->Fullprice->delivery_case <= 0)
                        <a href="{{ route('add-to-cart', $product->slug) }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=SINGLE" class="ONEHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">Add to Cart</a>
                    @elseif ($product->Fullprice && $product->Fullprice->delivery_single <= 0 && $product->Fullprice->delivery_case > 0)
                        <a href="{{ route('add-to-cart', $product->slug) }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=CASE" class="ONEHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">Add to Cart</a>
                    @else
                        <a href="{{ route('product-detail', $product->slug?? ' ') }}" class="bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover-bg-[#706233] hover-text-white">See Details</a>
                    @endif
                @else
                    <a href="#" class="TWOHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">Out Of Stock</a>
                @endif
            @elseif (\Auth::guard('customer')->user()->checkout_preference == "pickup")
                @if (Helper::checkWarehouseOfProduct($product->id, \Auth::guard('customer')->user()->warehouse))
                    @if ($product->Fullprice && $product->Fullprice->p_price > 0 && $product->Fullprice->price <= 0)
                        <a href="{{ route('add-to-cart', $product->slug) }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=CASE" class="ONEHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">Add to Cart</a>
                    @elseif ($product->Fullprice && $product->Fullprice->p_price <= 0 && $product->Fullprice->price > 0)
                        <a href="{{ route('add-to-cart', $product->slug) }}?preference={{ \Auth::guard('customer')->user()->checkout_preference }}&pack_size=SINGLE" class="ONEHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">Add to Cart</a>
                    @else
                        <a href="{{ route('product-detail', $product->slug?? ' ') }}" class="bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover-bg-[#706233] hover-text-white">See Details</a>
                    @endif
                @else
                    <a href="#" class="TWOHM bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover:bg-[#706233] hover:text-white">Out Of Stock</a>
                @endif
            @else
                <a href="{{ route('product-detail', $product->slug?? ' ') }}" class="bg-[#706233]/10 text-[#706233] p-[8px_15px] rounded-[50px] text-[14px] hover-bg-[#706233] hover-text-white">See Details</a>
            @endif

            <a href="{{ route('wishlist')}}/{{ $product->slug }}" class="bg-[#706233]/10 hover-bg-[#706233] hover-text-white text-[#706233] p-[10px_15px] rounded-[50%] w-[32px] h-[32px] flex items-center justify-center !ml-2">
                <i class="fa fa-heart-o sm:text-[14px] text-[10px]" aria-hidden="true"></i>
            </a>
            <a href="{{ route('product-detail', $product->slug?? ' ') }}" class="bg-[#706233]/10 hover-bg-[#706233] hover-text-white text-[#706233] p-[10px_15px] rounded-[50%] w-[32px] h-[32px] flex items-center justify-center ml-auto">
                <i class="fa fa-eye  text-[14px]" aria-hidden="true"></i>
            </a>
        </div>
    @endif


</div>


