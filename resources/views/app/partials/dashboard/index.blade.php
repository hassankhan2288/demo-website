@extends('layouts.app')
@section('content')
<div class="row">
    <!-- ICON BG-->
<div class="col-lg-3 col-md-6 col-sm-6">
        <a href="" class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center"><i class="i-Add-UserStar"></i>
                <div class="content">
                    <p class="text-muted mt-2 mb-0"> Branches</p>
                    <p class="text-primary text-24 line-height-1 mb-2">{{$total_branch}}</p>
                </div>
            </div>
        </a> 
    </div>
    
    <div class="col-lg-3 col-md-6 col-sm-6">
        <a href="" class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center"><i class="i-Checkout-Basket"></i>
                <div class="content">
                    <p class="text-muted mt-2 mb-0">Orders</p>
                    <p class="text-primary text-24 line-height-1 mb-2">{{$total_order}}</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <a href="" class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center"><i class="i-Library"></i>
                
                <div class="content">
                    <p class="text-muted mt-2 mb-0">Products</p>
                    <p class="text-primary text-24 line-height-1 mb-2">{{$total_product}}</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <a href="" class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center"><i class="i-Add-UserStar"></i>
                
                <div class="content">
                    <p class="text-muted mt-2 mb-0">Customer Categories</p>
                    <p class="text-primary text-24 line-height-1 mb-2">{{$total_customer_cate}}</p>
                </div>
            </div>
        </a>
    </div>


</div>

<div class="row">
    <div class="col-lg-8 col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">This Year Sales</div>
                <div id="echartBar" style="height: 300px;"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-12">
        <div class="card mb-4">
            <button type="button" class="list-group-item list-group-item-action active">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
  <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z"/>
</svg>Notifications
  </button>
           <ul class="list-group">
            @foreach ($noti as $key=>$notifications )
                
            
  <li class="list-group-item d-flex justify-content-between align-items-center">
    <a href="" >{{$notifications->user->name}} - Purchase Orders Pending Approval
    </a><span class="badge badge-primary badge-pill">{{$notifications->total}}</span>
  </li>
  @endforeach
  
</ul>
        </div>
    </div>
    
</div>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="row">
            <div class="col-lg-4 col-md-12">
                <div class="card card-chart-bottom o-hidden mb-4">
                    <div class="card-body">
                        <div class="text-muted">Last Month Sales</div>
                        <p class="mb-4 text-primary text-24">${{$last_month_sale??0}}</p>
                    </div>
                    
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="card card-chart-bottom o-hidden mb-4">
                    <div class="card-body">
                        <div class="text-muted">Last Week Sales</div>
                        <p class="mb-4 text-warning text-24">${{$last_week_sale??0}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="card card-chart-bottom o-hidden mb-4">
                    <div class="card-body">
                        <div class="text-muted">Current Sales</div>
                        <p class="mb-4 text-warning text-24">${{$current_month_sale??0}}</p>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="col-lg-4 col-sm-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">Sales by Branch</div>
                <div id="echartPie" style="height: 300px;"></div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="{{ asset('app/js/plugins/echarts.min.js') }}"></script>
<script src="{{ asset('app/js/scripts/echart.options.min.js') }}"></script>
<script type="text/javascript">
     var reports = {!!$reports!!};
    var sales_by_country = {!!$sale_by_branch!!};
    var sales_title = "Sales by branch";
</script>
<script src="{{ asset('app/js/scripts/dashboard.v1.script.min.js') }}"></script>
@endsection