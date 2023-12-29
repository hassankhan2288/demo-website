@extends('layouts.pos')
@section('content')

{{-- <div class="w-full px-[20px] py-[10px] flex flex-wrap gap-5 justify-between bg-[#706233] items-center relative z-40 min-h-[70px]">
    <div class="customer-logo">
      <img src="{{asset('img/logo.png')}}" target="blank" alt="" class="w-[100px]">
    </div>
    <div class="xl:block hidden ml-auto">
      <ul class="bg-[#706233] flex items-center">
        <li>
          <a href="{{route('pos.dashboard')}}" class="2xl:text-[16px] !2xl:px-[16px] text-white !px-[12px] text-[12px]">
            Dashboard
          </a>
        </li>
        <li>
          <a href="{{route('pos.product')}}" class="2xl:text-[16px] !2xl:px-[16px] text-white !px-[12px] text-[12px]">
            Product
          </a>
        </li>
        <li>
          <a href="{{route('pos.sale.pos')}}" class="2xl:text-[16px] !2xl:px-[16px] text-white !px-[12px] text-[12px]">
            Place Order
          </a>
        </li>
        <li>
          <a href="{{route('pos.sale.list')}}" class="2xl:text-[16px] !2xl:px-[16px] text-white !px-[12px] text-[12px]">
            Sale
          </a>
        </li>
        <li>
          <a href="{{route('pos.report')}}" class="2xl:text-[16px] !2xl:px-[16px] text-white !px-[12px] text-[12px]">
            Report
          </a>
        </li>
      </ul>
    </div>
    <div class="flex items-center sm:gap-16 gap-5 ml-auto">
        <div class="dropdown relative">
          <div class="user col align-self-end">
            <a id="userDropdown" class=" whitespace-nowrap text-white flex items-center sm:text-[16px] text-[12px]" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="javascript:void();">
              @auth{{ucfirst(auth()->user()->name)}}@endauth
            </a>
            <div class="!right-0 !top-[35px] !transform !left-[unset] dropdown-menu dropdown-menu-right absolute hidden bg-white rounded-[4px] z-[1] min-w-[160px] shadow-[0_1px_15px_1px_rgba(0,0,0,0.04),_0_1px_6px_rgba(0,0,0,0.08)] p-[0.5rem_0]" aria-labelledby="userDropdown">
              <div class="dropdown-header my_bold text_black p-[0.42rem_1.5rem]">
                  <i class="i-Lock-User mr-1"></i> @auth{{auth()->user()->email}}@endauth
              </div>
              <a href="{{route('pos.account.settings')}}" class="dropdown-item p-[0.42rem_1.5rem]  my_bold text-black flex items-center">Account settings</a>
              <a class="dropdown-item p-[0.42rem_1.5rem]  my_bold text-black flex items-center" href="{{ route('pos.logout') }}" >Sign out</a>
            </div>
          </div>
        </div>
        <div @click="mobileMenu = true" class="xl:hidden block cursor-pointer text-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </div>
    </div>
</div> --}}

{{-- <div x-show="mobileMenu" :class="{ '!flex': mobileMenu }" x-on:click="mobileMenu = false" style="overflow: scroll;" class="fixed glass hidden w-full h-screen left-0 top-0 z-40 flex flex-wrap justify-center content-center sm:p-24 p-6">
    <div x-on:click.stop="" style=" min-height: -webkit-fill-available;" class="xl:w-1/2 sm:w-96 w-full sm:p-8 p-6 bg-white shadow-xl relative">
      <span x-on:click="mobileMenu = false" class="w-[40px] cursor-pointer h-[40px] rounded-full shadow-lg text-white text-[20px] !absolute -right-5 -top-5 bg-[#706233] flex items-center justify-center">
        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
      </span>
      <div class="text-center">
        <ul style="background-color: white;" class="mt-8">
          <li>
            <a href="{{route('pos.dashboard')}}" class="2xl:text-[16px] !2xl:px-[16px] text-black !px-[12px] text-[12px]">
              Überblick
            </a>
          </li>
          <li>
            <a href="{{route('pos.product')}}" class="2xl:text-[16px] !2xl:px-[16px] text-black !px-[12px] text-[12px]">
              Product
            </a>
          </li>
          <li>
            <a href="{{route('pos.sale.pos')}}" class="2xl:text-[16px] !2xl:px-[16px] text-black !px-[12px] text-[12px]">
              Place Order
            </a>
          </li>
          <li>
            <a href="{{route('pos.sale.list')}}" class="2xl:text-[16px] !2xl:px-[16px] text-black !px-[12px] text-[12px]">
              Sale
            </a>
          </li>
          <li>
            <a href="{{route('pos.report')}}" class="2xl:text-[16px] !2xl:px-[16px] text-black !px-[12px] text-[12px]">
              Report
            </a>
          </li>
        </ul>

      </div>
      <div class="hidden">
        <img x-ref="productImage" src="" alt="" style="margin: auto;" class="object-contain h-48 w-48">
      </div>
      <div x-ref="productDetails" class="mt-5  justify-center text-center">
      </div>
    </div>
  </div> --}}

<div id="toast-top-left" x-show="loading" class="flex absolute top-5 right-5 items-center p-4 space-x-4 w-full max-w-xs z-10" role="alert">
  <div id="toast-interactive" class="p-4 mb-2 w-full max-w-xs text-gray-500 bg-white rounded-lg shadow dark:bg-gray-800 dark:text-gray-400" role="alert">
    <div class="flex">
      <div class="inline-flex flex-shrink-0 justify-center items-center w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:text-blue-300 dark:bg-red-900">
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
        </svg>
        <span class="sr-only">Refresh icon</span>
      </div>
      <div class="ml-3 text-sm font-normal">
        <span class="mb-1 text-sm font-semibold text-gray-900 dark:text-white">Update available</span>
        <div class="mb-2 text-sm font-normal">Please wait new products available for update...</div>
      </div>
    </div>
  </div>
</div>
<!-- noprint-area -->
<div class="hide-print flex flex-row md:flex-nowrap flex-wrap h-screen antialiased text-blue-gray-800">
  <!-- left sidebar -->
  <div class="flex flex-row md:w-auto w-full flex-shrink-0 pl-4 pr-2 py-4">
    <div class="flex md:flex-col items-center py-4 flex-shrink-0 md:w-20 w-full bg-[#706233] rounded-3xl gap-5 md:justify-start justify-center">
      <div role="status" x-show="loading">
        <svg aria-hidden="true" class="mr-2 w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
          <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
        </svg>
        <span class="sr-only">Loading...</span>
      </div>
      <a href="{{route('admin.pos.sale.list')}}" x-show="!loading" class="flex items-center justify-center h-12 w-12 bg-red-50 text-cyan-700 rounded-full">
        <svg class="h-8 w-8 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
          <polyline points="9 22 9 12 15 12 15 22" />
        </svg>
      </a>
      <ul class="flex md:flex-col gap-5 md:mt-7">
        <li>
          <div class="text-center">
            <a href="#" x-on:click="startWithSampleData(1)" class="flex items-center flex-col text-center">
            <span class="flex items-center justify-center h-12 w-12 rounded-2xl" x-bind:class="{
                    'hover:bg-red-400 text-red-100': activeMenu !== 'pos',
                    'bg-red-300 shadow-lg text-white': activeMenu === 'pos',
                  }">
              <svg class="h-8 w-8 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="1 4 1 10 7 10" />
                <polyline points="23 20 23 14 17 14" />
                <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15" />
              </svg>
            </span>
            </a>
            <p class="text-red-100 flex-col text-center">Refresh</p>
          </div>
        </li>
        <li>
          <div class="text-center">
            <a href="#" class="flex items-center flex-col text-center" x-on:click="favoriteProducts()">
            <span class="flex items-center justify-center text-red-100 hover:bg-red-400 h-12 w-12 rounded-2xl">

              <svg x-show="!isFavorite" class="h-8 w-8 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
              </svg>

              <svg x-show="isFavorite" class="h-8 w-8 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
              </svg>

            </span>
            </a>
            <p class="text-red-100 flex-col text-center">Favourite Products</p>
          </div>
        </li>

        <li>
          <div class="text-center">
            <a href="#" class="flex items-center flex-col text-center" x-on:click="pauseSaleList()">
            <span class="flex items-center justify-center text-red-100 hover:bg-red-400 h-12 w-12 rounded-2xl">

              <svg x-show="!pauseList" class="h-8 w-8 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="6" y="4" width="4" height="16" />
                <rect x="14" y="4" width="4" height="16" />
              </svg>

              <svg x-show="pauseList" s class="h-8 w-8 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="6" y="4" width="4" height="16" />
                <rect x="14" y="4" width="4" height="16" />
              </svg>

            </span>
            </a>
            <p class="text-red-100 flex-col text-center">View Hold Orders</p>
          </div>
        </li>
      </ul>
    </div>
  </div>

  <!-- page content -->
  <div class="flex-grow flex xl:flex-nowrap flex-wrap">
    <!-- store menu -->
    <div class="flex px-2 flex-row md:flex-nowrap flex-wrap relative gap-2 xl:hidden w-full mt-4">
      <div class="absolute left-5 top-3 px-2 py-2 rounded-full bg-[#706233] text-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </div>
      <input type="text" class="bg-white rounded-3xl shadow text-lg full w-full h-16 py-4 pl-16 transition-shadow focus:shadow-2xl focus:outline-none" placeholder="Search Products" x-model="keyword" />
      <select x-model="category" id="category" class="bg-white rounded-3xl shadow text-lg full w-full h-16 py-4 pl-8 transition-shadow focus:shadow-2xl focus:outline-none">
        <option value="">Select Category</option>
        @if($categories)
        @foreach($categories as $category)
        <option value="{{$category->id}}">{{$category->name}}</option>
        @endforeach
        @endif

      </select>
{{--      <select x-model="brand" id="brand" class="bg-white rounded-3xl shadow text-lg full w-full h-16 py-4 pl-8 transition-shadow focus:shadow-2xl focus:outline-none">--}}
{{--        <option value="">Select Brand</option>--}}
{{--        @if($brands)--}}
{{--        @foreach($brands as $brand)--}}
{{--        <option value="{{$brand->id}}">{{$brand->title}}</option>--}}
{{--        @endforeach--}}
{{--        @endif--}}
{{--      </select>--}}
    </div>
    <div class="flex flex-col bg-blue-gray-50 h-full w-full py-4 xl:order-1 order-2">
      <div class="px-2 flex-row relative gap-2 xl:flex hidden">
        <div class="absolute left-5 top-3 px-2 py-2 rounded-full bg-[#706233] text-white">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>
        <input type="text" class="bg-white rounded-3xl shadow text-lg full w-full h-16 py-4 pl-16 transition-shadow focus:shadow-2xl focus:outline-none" placeholder="Search Products" x-model="keyword" />
        <select x-model="category" id="category" class="bg-white rounded-3xl shadow text-lg full w-full h-16 py-4 pl-8 transition-shadow focus:shadow-2xl focus:outline-none">
          <option value="">Select Category</option>
          @if($categories)
          @foreach($categories as $category)
          <option value="{{$category->id}}">{{$category->name}}</option>
          @endforeach
          @endif

        </select>
{{--        <select x-model="brand" id="brand" class="bg-white rounded-3xl shadow text-lg full w-full h-16 py-4 pl-8 transition-shadow focus:shadow-2xl focus:outline-none">--}}
{{--          <option value="">Select Brand</option>--}}
{{--          @if($brands)--}}
{{--          @foreach($brands as $brand)--}}
{{--          <option value="{{$brand->id}}">{{$brand->title}}</option>--}}
{{--          @endforeach--}}
{{--          @endif--}}
{{--        </select>--}}
      </div>
      <div class="h-full overflow-hidden mt-4">
        <div class="h-full xl:overflow-y-auto px-2">
          <div class="select-none bg-red-gray-100 rounded-3xl flex flex-wrap content-center justify-center h-full opacity-25" x-show="products.length === 0">
            <div class="w-full text-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
              </svg>
              <p class="text-xl">
                YOU DON'T HAVE
                <br />
                ANY PRODUCTS TO SHOW
              </p>
            </div>
          </div>
          <div class="select-none bg-red-gray-100 rounded-3xl flex flex-wrap content-center justify-center h-full opacity-25" x-show="filteredProducts().length === 0 && keyword.length > 0">
            <div class="w-full text-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              <p class="text-xl">
                EMPTY SEARCH RESULT
                <br />
                "<span x-text="keyword" class="font-semibold"></span>"
              </p>
            </div>
          </div>
          <div x-show="!pauseList" class="grid xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-3 grid-cols-2  md:gap-6 gap-3 pb-3">
            <template x-for="product in filteredProducts()" :key="product.id">
              <div role="button" class="relative select-none cursor-pointer transition-shadow overflow-hidden rounded-2xl bg-white shadow hover:shadow-lg flex flex-col" :title="product.name">
                <div class="absolute top-2 left-2 w-12 h-12 rounded-full flex items-center justify-center" x-bind:class="{ 'bg-red-500': product.pack_size !== null }">
                  <p class="text-white text-xs font-semibold" x-text="product.pack_size" x-show="product.pack_size !== null"></p>
                </div>
                <img class="object-contain h-48 w-48 mx-auto" :src="product.image" :alt="product.name">
                <div class="flex pb-3 px-3 text-sm">
                  <p class="flex-grow text-center text-black font-bold mr-1 pt-2" x-text="product.name"></p>
                </div>
                <div class="flex justify-between pt-2 mt-auto">
                  <template x-if="product.price !== null && product.price !== 0">
                    <div class="w-6/12 text-center bg-red-500 font-medium text-white px-2 py-1" x-on:click="addToCart(product, 'price')">
                      <p class="text-[10px]">Single price</p>
                      <button class="bg-red-500 font-medium text-white" x-text="priceFormat(product.price)"></button>
                    </div>
                  </template>
                  <template x-if="product.price === null || product.price === 0">
                    <div class="w-6/12 text-center bg-red-500 font-medium text-white px-2 py-1">
                      <p class="text-[10px]">Single price</p>
                      <button class="bg-red-500 font-medium text-white" x-text="'N/A'"></button>
                    </div>
                  </template>
                  <template x-if="product.p_price !== null && product.p_price !== 0">
                  <div class="w-6/12 text-center bg-red-100 font-medium text-black px-2 py-1" x-on:click="addToCart(product, 'p_price')">
                    <p class="text-[10px]">Pack price</p>
                    <button class="bg-red-100 font-medium text-black" x-text="priceFormat(product.p_price)"></button>
                  </div>
                  </template>
                  <template x-if="product.p_price === null || product.p_price === 0">
                  <div class="w-6/12 text-center bg-red-100 font-medium text-black px-2 py-1">
                    <p class="text-[10px]">Pack price</p>
                    <button class="bg-red-100 font-medium text-black">N/A</button>
                  </div>
                  </template>
                </div>
              </div>
            </template>
          </div>

          <!-- Pause List -->
          <div x-show="pauseList" class="grid lg:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-3 pb-3">
            <template x-for="pause in pauses" :key="pause.id">

              <div class="p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex flex-wrap items-center justify-between">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white" x-text="pause.name"></h5>
                <div class="ml-auto">
                  <button x-on:click="retakePause(pause)" type="button" class="text-white bg-[#706233] hover:bg-red-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-blue-800">Resale</button>
                  <button x-on:click="removePause(pause)" type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">Remove</button>

                </div>
              </div>

            </template>
          </div>
          <!-- end Pause list -->
        </div>
      </div>
    </div>
    <!-- end of store menu -->

    <div onclick="toggleCartArea()" class="h-16 text-center flex justify-center fixed bottom-0 left-0 right-0 bg-white shadow-[0px_0px_10px_#0000004d] xl:hidden cursor-pointer z-10">
      <div class="pl-8 text-left text-lg py-4 relative">
        <!-- cart icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <div x-show="getItemsCount() > 0" class="bg-change-400 text-center absolute bg-[#706233] text-white w-5 h-5 text-xs p-0 leading-5 rounded-full -right-2 top-3" x-text="getItemsCount()"></div>
      </div>
      <div class="flex-grow px-8 text-right text-lg py-4 relative">
        <!-- trash button -->
        <button x-on:click="clearCart = true" class="options_select hover:text-pink-500 focus:outline-none">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
          </svg>
        </button>
      </div>
    </div>

    <!-- right sidebar -->
    <div class="xl:w-5/12 w-full flex flex-col xl:h-full xl:pr-4 xl:pl-2 xl:py-4 xl:order-2 order-1 xl:relative fixed transition-all duration-500 xl:bottom-auto -bottom-[110%] w-full xl:left-auto left-0 z-10"  id="cart-area">
      <div class="bg-white rounded-3xl flex flex-col h-full shadow">
        <div onclick="toggleCartArea()" class="xl:hidden absolute right-4 -top-8 w-11 h-11 flex justify-center items-center font-bold text-[24px] text-red-500 cursor-pointer bg-white shadow-[0px_0px_10px_#0000004d] rounded-full">X</div>
        <!-- empty cart -->
        <div x-show="cart.length === 0" class="flex-1 w-full p-4 opacity-25 select-none flex flex-col flex-wrap content-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-16 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
          <p>
            CART EMPTY
          </p>
        </div>

        <!-- cart items -->
        <div x-show="cart.length > 0" class="flex-1 flex flex-col overflow-auto max-h-[calc(100vh-400px)] xl:max-h-[100%]">
          <div class="h-16 text-center flex justify-center">
            <div class="pl-8 text-left text-lg py-4 relative">
              <!-- cart icon -->
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
              <div x-show="getItemsCount() > 0" class="text-center absolute bg-[#706233] text-white w-5 h-5 text-xs p-0 leading-5 rounded-full -right-2 top-3" x-text="getItemsCount()"></div>
            </div>
            <div class="flex-grow px-8 text-right text-lg py-4 relative">
              <!-- trash button -->
              <button x-on:click="clearCart = true" class="text-blue-gray-300 hover:text-pink-500 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
              </button>
            </div>
          </div>

          <div class="flex-1 w-full px-4 overflow-auto">
            <template x-for="item in cart" :key="item.productId">
              <div class="select-none mb-3 bg-blue-gray-50 rounded-lg w-full text-blue-gray-700 py-2 px-2 flex justify-center">
                <img :src="item.image" alt="" class="rounded-lg h-10 w-10 bg-white shadow mr-2">
                <div class="flex-grow">
                  <h5 class="text-sm" x-text="item.name"></h5>
                  <p class="text-xs block" x-text="priceFormat(item.price)"></p>
                </div>
                <div class="py-1">
                  <div class="w-28 grid grid-cols-3 gap-2 ml-2">
                    <button x-on:click="addQty(item, -1)" class="rounded-lg text-center py-1 text-white bg-blue-gray-600 hover:bg-blue-gray-700 focus:outline-none">
                      
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-3 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                      </svg>
                    </button>
                    <input x-model.number="item.qty" type="text" class="bg-white rounded-lg text-center shadow focus:outline-none focus:shadow-lg text-sm">
                    <button x-on:click="addQty(item, 1)" class="rounded-lg text-center py-1 text-white bg-blue-gray-600 hover:bg-blue-gray-700 focus:outline-none">
                      
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-3 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
            </template>
          </div>

        </div>
        <!-- end of cart items -->

        <!-- payment info -->
        <div class="select-none h-auto w-full text-center pt-3 pb-4 px-4">
          <div class="flex mb-3 text-sm font-semibold text-blue-gray-700">
            <div class="text-left w-full">Sub total</div>
            <div class="text-right w-full" x-text="priceFormat(getSubTotalPrice())"></div>
          </div>
          <div class="flex mb-3 text-sm font-semibold text-blue-gray-700">
            <div class="text-left w-full">Vat</div>
            <div class="text-right w-full" x-text="priceFormat(getTotalTax())"></div>
          </div>
          <div class="flex mb-3 text-lg font-semibold text-blue-gray-700">
            <div class="text-left w-full">GRAND TOTAL</div>
            <div class="text-right w-full" x-text="priceFormat(getTotalPrice())"></div>
          </div>
          <!-- <div class="mb-3 text-blue-gray-700 px-3 pt-2 pb-3 rounded-lg bg-blue-gray-50">
              <div class="flex text-lg font-semibold">
                <div class="flex-grow text-left">CASH</div>
                <div class="flex text-right">
                  <div class="mr-2">{{currency()}}</div>
                  <input x-bind:value="numberFormat(cash)" x-on:keyup="updateCash($event.target.value)" type="text" class="w-28 text-right bg-white shadow rounded-lg focus:bg-white focus:shadow-lg px-2 focus:outline-none">
                </div>
              </div>
              <hr class="my-2">
               <div class="grid grid-cols-3 gap-2 mt-2">
                <template x-for="money in moneys">
                  <button x-on:click="addCash(money)" class="bg-white rounded-lg shadow hover:shadow-lg focus:outline-none inline-block px-2 py-1 text-sm">+<span x-text="numberFormat(money)"></span></button>
                </template>
              </div>
            </div> -->
          <!-- <div
              x-show="change > 0"
              class="flex mb-3 text-lg font-semibold bg-red-50 text-blue-gray-700 rounded-lg py-2 px-3"
            >
              <div class="text-red-800">CHANGE</div>
              <div
                class="text-right flex-grow text-red-600"
                x-text="priceFormat(change)">
              </div>
            </div> -->
          <!--  <div
              x-show="change < 0"
              class="flex mb-3 text-lg font-semibold bg-pink-100 text-blue-gray-700 rounded-lg py-2 px-3"
            >
              <div
                class="text-right flex-grow text-pink-600"
                x-text="priceFormat(change)">
              </div>
            </div>
            <div
              x-show="(cash>0 && change == 0) && cart.length > 0"
              class="flex justify-center mb-3 text-lg font-semibold bg-red-50 text-cyan-700 rounded-lg py-2 px-3"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
              </svg>
            </div> -->
          <div class="flex flex-row justify-center gap-2">
            <button class="text-white rounded-2xl text-lg w-full py-3 focus:outline-none" x-bind:class="{
                'bg-[#706233] hover:bg-red-600': submitable(),
                'bg-red-gray-200': !submitable()
              }" :disabled="!submitable()" x-on:click="submit(false)">
              Checkout
            </button>
            <button class="text-white rounded-2xl text-lg w-full py-3 focus:outline-none" x-bind:class="{
                'bg-[#706233] hover:bg-red-600': submitable(),
                'bg-red-gray-200': !submitable()
              }" :disabled="!submitable()" x-on:click="popupOpen()">
              On Hold
            </button>
          </div>
        </div>
        <!-- end of payment info -->
      </div>
    </div>
    <!-- end of right sidebar -->
  </div>

  <!-- modal first time -->
  <div x-show="pausePopup" class="fixed glass w-full h-screen left-0 top-0 z-10 flex flex-wrap justify-center content-center sm:p-24 p-6">
    <div class="w-96 rounded-3xl sm:p-8 p-6 bg-white shadow-xl">
      <div class="text-center">

        <h3 class="text-center text-2xl mb-8">Hold sale?</h3>
      </div>
      <div class="text-center flex justify-center flex-row">
        <button x-on:click="pauseSale()" class="text-left w-full m-2 rounded-xl bg-blue-gray-500 text-white focus:outline-none hover:bg-red-400 px-4 py-4">

          </svg>
          Yes
        </button>
        <button x-on:click="popupClose()" class="text-left w-full m-2 rounded-xl bg-blue-gray-500 text-white focus:outline-none hover:bg-red-400 px-4 py-4">

          No
        </button>
      </div>
    </div>
  </div>
  <div x-show="clearCart" class="fixed glass w-full h-screen left-0 top-0 z-10 flex flex-wrap justify-center content-center sm:p-24 p-6"  @click.outside="applyCouponPopup = false">
    <div class="w-96 sm:p-8 p-6 bg-white shadow-xl">
      <div class="text-center">

        <h3 class="text-center text-2xl mb-8">Are you sure to delete all items from cart?</h3>
      </div>
      <div class="text-center flex justify-center flex-row">
        <button x-on:click="clear(), clearCart = false" class="text-left w-full m-2 rounded-xl bg-blue-gray-500 text-white focus:outline-none hover:bg-red-400 px-4 py-4">
          Yes
        </button>
        <button x-on:click="clearCart = false" class="text-left w-full m-2 rounded-xl bg-blue-gray-500 text-white focus:outline-none hover:bg-red-400 px-4 py-4">
          No
        </button>
      </div>
    </div>
  </div>

  <!-- modal receipt -->
  <div x-show="isShowModalReceipt" class="fixed w-full h-screen left-0 top-0 z-10 flex flex-wrap justify-center content-center sm:p-24 p-5">
    <div x-show="isShowModalReceipt" class="fixed glass w-full h-screen left-0 top-0 z-0" x-on:click="closeModalReceipt()" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
    <div x-show="isShowModalReceipt" class="sm:w-96 w-full sm:mx-0 rounded-3xl bg-white shadow-xl overflow-hidden z-10" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90">
      <div id="receipt-content" class="text-left w-full text-sm p-6 overflow-auto">
        <div class="text-center">
          <img src="{{asset('img/logo.png')}}" alt="{{config('app.name')}}" class="mb-3 inline-block">
          <h2 class="text-xl font-semibold">{{config('app.name')}}</h2>
          <p>{{$user->name}}</p>
        </div>
        <div class="flex mt-4 text-xs">
          <div class="flex-grow">No: <span x-text="receiptNo"></span></div>
          <div x-text="receiptDate"></div>
        </div>
        <hr class="my-2">
        <div>
          <table class="w-full text-xs">
            <thead>
              <tr>
                <th class="py-1 w-1/12 text-center">#</th>
                <th class="py-1 text-left">Item</th>
                <th class="py-1 w-2/12 text-center">Qty</th>
                <th class="py-1 w-3/12 text-right">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <template x-for="(item, index) in cart" :key="item">
                <tr>
                  <td class="py-2 text-center" x-text="index+1"></td>
                  <td class="py-2 text-left">
                    <span x-text="item.name"></span>
                    <br />
                    <small x-text="priceFormat(item.price)"></small>
                  </td>
                  <td class="py-2 text-center" x-text="item.qty"></td>
                  <td class="py-2 text-right" x-text="priceFormat(item.qty * item.price)"></td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
        <hr class="my-2">
        <div>
          <div class="flex font-semibold">
            <div class="flex-grow">Sub total</div>
            <div x-text="priceFormat(getSubTotalPrice())"></div>
          </div>
          <div class="flex font-semibold">
            <div class="flex-grow">Tax</div>
            <div x-text="priceFormat(getTotalTax())"></div>
          </div>
          <div class="flex font-semibold">
            <div class="flex-grow">TOTAL</div>
            <div x-text="priceFormat(getTotalPrice())"></div>
          </div>
          <div class="flex text-xs font-semibold">
            <div class="flex-grow">PAY AMOUNT</div>
            <div x-text="priceFormat(cash)"></div>
          </div>
          <hr class="my-2">
          <!-- <div class="flex text-xs font-semibold">
              <div class="flex-grow">CHANGE</div>
              <div x-text="priceFormat(change)"></div>
            </div> -->
        </div>

{{--        <form class="flex flex-wrap gap-3 w-full p-5" x-show="isCreditCard">--}}
{{--          <hr class="my-2 h-px bg-gray-200 border-0 dark:bg-gray-700" />--}}

{{--          <label class="relative w-full flex flex-col">--}}
{{--            <span class="font-bold mb-3">Card number</span>--}}
{{--            <input class="rounded-md peer pl-12 pr-2 py-2 border-2 border-gray-200 placeholder-gray-300" type="text" name="card_number" placeholder="0000 0000 0000" />--}}
{{--            <svg xmlns="http://www.w3.org/2000/svg" class="absolute bottom-0 left-0 -mb-0.5 transform translate-x-1/2 -translate-y-1/2 text-black peer-placeholder-shown:text-gray-300 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />--}}
{{--            </svg>--}}
{{--          </label>--}}

{{--          <label class="relative flex-1 flex flex-col">--}}
{{--            <span class="font-bold mb-3">Expire date</span>--}}
{{--            <input class="rounded-md peer pl-12 pr-2 py-2 border-2 border-gray-200 placeholder-gray-300" type="text" name="expire_date" placeholder="MM/YY" />--}}
{{--            <svg xmlns="http://www.w3.org/2000/svg" class="absolute bottom-0 left-0 -mb-0.5 transform translate-x-1/2 -translate-y-1/2 text-black peer-placeholder-shown:text-gray-300 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />--}}
{{--            </svg>--}}
{{--          </label>--}}

{{--          <label class="relative flex-1 flex flex-col">--}}
{{--            <span class="font-bold flex items-center gap-3 mb-3">--}}
{{--              CVC/CVV--}}
{{--              <span class="relative group">--}}
{{--                <span class="hidden group-hover:flex justify-center items-center px-2 py-1 text-xs absolute -right-2 transform translate-x-full -translate-y-1/2 w-max top-1/2 bg-black text-white"> Hey ceci est une infobulle !</span>--}}
{{--                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />--}}
{{--                </svg>--}}
{{--              </span>--}}
{{--            </span>--}}
{{--            <input class="rounded-md peer pl-12 pr-2 py-2 border-2 border-gray-200 placeholder-gray-300" type="text" name="card_cvc" placeholder="&bull;&bull;&bull;" />--}}
{{--            <svg xmlns="http://www.w3.org/2000/svg" class="absolute bottom-0 left-0 -mb-0.5 transform translate-x-1/2 -translate-y-1/2 text-black peer-placeholder-shown:text-gray-300 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />--}}
{{--            </svg>--}}
{{--          </label>--}}
{{--        </form>--}}
      </div>
      <div class="p-4 w-full">

        <button class="bg-[#706233] text-white text-lg px-4 py-3 rounded-2xl w-full focus:outline-none" x-on:click="printAndProceed()">
          <div role="status" x-show="isSubmitting">
            <svg aria-hidden="true" class="mr-2 w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
              <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
            </svg>
            <span class="sr-only">Loading...</span>
          </div>
          <span x-show="!isSubmitting">PROCEED</span>
        </button>
      </div>
    </div>
  </div>
</div>
<!-- end of noprint-area -->

<div id="print-area" class="print-area"></div>
<input type="hidden" id="pos-currency" value="{{currency()}}">
<input type="hidden" id="pos-product-list" value="{{ route('admin.pos.product.list', ['user_id' => $userId]) }}">
<input type="hidden" id="pos-sale-submit" value="{{route('admin.pos.sale.submit')}}">
{{--<input type="hidden" id="pos-product-count" value="{{$products}}">--}}
<input type="hidden" id="pos-order-id" value="{{$orderId}}">
<input type="hidden" id="pos-user-id" value="{{$userId}}">
<input type="hidden" id="pos-branch-id" value="{{$branchId}}">
<input type="hidden" id="pos-product-count" value="10">
<input type="hidden" id="amazon-s3" value="{{route('amazon.s3')}}">

@endsection
@section('styles')
<style>
  .dropdown-menu.show {
      display: block;
  }
</style>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="{{ asset('css/pos.css') }}">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<script type="text/javascript" src="{{ asset('js/idb.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>
<script type="text/javascript" src="{{ asset('js/admin_pos.js?version=1.0.1') }}"></script>
<script>
  function toggleCartArea(){
    $('#cart-area').toggleClass("-bottom-[110%] bottom-0")
  }
</script>
@endsection