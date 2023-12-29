@extends('frontend.layouts.master')
@section('title','Cater-Choice || Customer Orders Page')
@section('main-content')

  <!-- Breadcrumbs -->
  <div class="w-full bg-[#ce1212]/10 py-[15px]">
		<div class="!container px-6 mx-auto">
			<div class="flex items-center">
				<div class="grow">
					<nav>
						<ol class="flex items-center">
							<li class="list-unstyled"><a href="{{route('home')}}">Home </a></li>
							<li class="list-unstyled text-[#ce1212] ml-1" aria-current="page"><a href="{{route('customer.dashboard')}}"> / Dashboard</a></li>
							<li class="list-unstyled text-[#ce1212] ml-1" aria-current="page"> / Orders</li>
						</ol>
					</nav>
				</div>
				<div class="grow text-right">
          <h2 class="text-[16px] font-bold">Orders</h2>
				</div>
			</div>
		</div>
	</div>
  <!-- End Breadcrumbs -->

  <section class="py-[40px]">
    <div class="!container px-6 mx-auto">
      <div class="grid md:grid-cols-12 grid-cols-1 gap-4">
        <div class="lg:col-span-3 md:col-span-4">
          <div class="bg-white !border !border-[#ce1212]/10 rounded-[5px] overflow-hidden">
            <a href="{{route('customer.dashboard')}}" class="bg-white  p-[15px] block border-b"> <i class="fa fa-tachometer text-[16px] mr-[5px]"></i>  Dashboard</a>
            <a href="{{route('customer.profile')}}" class="bg-white p-[15px] block border-b"> <i class="fa fa-user text-[16px] mr-[5px]"></i>   Profile</a>
            <a href="{{route('customer.orders')}}" class="bg-[#ce1212] p-[15px] text-white block border-b"> <i class="fa fa-table text-[16px] mr-[5px]"></i>  Orders</a>
            <a href="{{ route('customer.logout') }}"  class="bg-white p-[15px] block"> <i class="fa fa-sign-in text-[16px] mr-[5px]"></i> {{ __('Logout') }}</a>
            {{-- <a href="{{ route('customer.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="bg-white p-[15px] block"> <i class="fa fa-sign-in text-[16px] mr-[5px]"></i> {{ __('Logout') }}</a> --}}
            <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </div>
        </div>
        <div class="lg:col-span-9 md:col-span-8">
          <h3 class="text-[18px] font-semibold mb-3">My Orders</h3>
          <div class="overflow-x-auto">
            <div class="]">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="table-responsive main_web">
                        {{--<table class="display nowrap w-100 table sale-list dataTable dataTables_wrapper container-fluid dt-bootstrap4" id="customer_order_table">--}}
                      <table class="display nowrap table sale-list dataTable dataTables_wrapper container-fluid dt-bootstrap4" id="customer_order_table">
                      <thead class="bg-[#ce1212]/10">
                        <tr>
                          <th data-sortable="true" data-priority="1" class="text-center p-[0.5rem] text-[14px] bg-w-imp p-[15px] text-white">Order_Id</th>
                          <th data-sortable="true" class="text-center p-[0.5rem] text-[14px] bg-w-imp p-[15px] text-white">Order Quantity</th>
                          <th data-sortable="true" class="text-center p-[0.5rem] text-[14px] bg-w-imp p-[15px] text-white">Total Price </th>
                          <th data-sortable="false" class="text-center p-[0.5rem] text-[14px] bg-w-imp p-[15px] text-white">Status </th>
                          <th data-sortable="false" class="text-center p-[0.5rem] text-[14px] bg-w-imp p-[15px] text-white action_hm">Action</th>
                        </tr>
                      </thead>
                      {{-- @php
                        $user_id= Auth::user()->id;
                        $Orders=App\Sale::where('customer_id','=',$user_id)->get();
                        dd($Orders);
                      @endphp --}}
                      <tbody>
                        {{-- @foreach ($Orders as $item)
                          <tr>
                            <td class="text-center !p-[1rem] align-middle text-[14px]">{{$item->order_number}}</td>
                            <td class="text-center !p-[1rem] align-middle text-[14px]"></?php echo $item->quantity?></td>
                            <td class="text-center !p-[1rem] align-middle text-[14px]"></?php echo $item->address1 ?></td>
                            <td class="text-center !p-[1rem] align-middle text-[14px]">{{$item->total_amount}}</td>
                            <td class="text-center !p-[1rem] align-middle text-[14px]">
                              <a href="{{url('customer/Order-Status/'.$item->id.'')}}" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold">Check Status</a>
                              @if($item->Delivery_Status!='pending' || $item->Order_Cancel_Status==1)
                                <a href="{{url('customer/Order-Status/'.$item->id.'')}}" class="bg-yellow-500 text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold opacity-70">Cancel Order</a>
                              @else
                                <a href="{{url('customer/Order-Cancel/'.$item->id.'')}}" class="bg-yellow-500 text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold">Cancel Order</a>
                              @endif
                            </td>
                          </tr>
                        @endforeach --}}
                      </tbody>
                    </table>

                  </div>
                  <div class="main_mobile">
                    <ul class="list_orders_mobile">
                      @foreach ($orders as $order)
                          <li class="inner_li_order">
                              <div>
                                  <span><strong>Order No:</strong> <span>{{ $order->id }}</span></span>
                              </div>
                              <div>
                                <span><strong>Order Date:</strong> <span>{{ date('d-m-y h:i:sa',strtotime($order->created_at)) }}</span></span>
                              </div>
                              <div>
                                <span><strong>Total:</strong> <span>£{{ $order->grand_total }}</span></span>
                              </div>
                              <div>
                                <span><strong>Status:</strong> <span>{{ $order->payment_status }}</span></span>
                              </div>
                              <div class="buttons">
                                  <a href="/customer/report/{{ $order->id }}" class="btn btn-link btnview" target="_blank"><i class="fa fa-eye"></i> View</a>
                                  @if ($order->payment_status == "Pending")
                                  <a href="/checkout/payment?order_id={{ $order->id }}" class="btn btn-link btnview" target="_blank"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> Pay Now</a>
                                  @endif
                              </div>
                          </li>                        
                      @endforeach
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@if (session('status'))
  <script>
    $(document).ready(function () {
      $('#centralModalSuccess').modal('show');
    });
  </script>
@endif
<!-- Central Modal Medium Success -->
  <div class="modal fade" id="centralModalSuccess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-notify modal-success" role="document">
      <!--Content-->
      <div class="modal-content">
        <!--Header-->
        <div class="modal-header">
          <p class="heading lead">Success</p>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="white-text">&times;</span>
          </button>
        </div>

        <!--Body-->
        <div class="modal-body">
          <div class="text-center">
            <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
            <p> <?php echo  session('status') ?></p>
          </div>
        </div>

        <!--Footer-->
        <div class="modal-footer justify-content-center">
          <a href="{{url('/')}}" class="btn btn-success">SHOP MORE<i class="far fa-gem ml-1 text-white"></i></a>
          <a type="button" class="btn btn-outline-success waves-effect" data-dismiss="modal">No, thanks</a>
        </div>
      </div>
      <!--/.Content-->
    </div>
  </div>
<!-- Central Modal Medium Success-->

 @if (session('Order_Status'))
    @include('components.user.orderstatus')
    <script>
        $(document).ready(function ()
        {
            $('#show_Order_Status_Modal').modal('show');
        });
    </script>
 @endif
@include('frontend/footer');
@endsection
