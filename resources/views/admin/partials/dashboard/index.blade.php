@extends('layouts.admin')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
@section('content')
    <div class="row">
        <!-- ICON BG-->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="{{ url('admin/company') }}" class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Add-User"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Companies</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{ $total_user }}</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="{{ url('admin/branches') }}" class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Add-UserStar"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Branches</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{ $total_admin }}</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="{{ url('admin/products') }}" class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Library"></i>

                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Product</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{ $total_product }}</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="{{ url('admin/sales/sale-list') }}" class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Checkout-Basket"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Order</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{ $total_order }}</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div>
                        <h4 class="branch_text">B2B Customers Analytics :</h4>
                        <hr class="short_hr">
                    </div>
                    <ul class="nav nav-pills mb-3 ml-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active tap_color text_black" id="pills-seller-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-seller" type="button" role="tab" aria-controls="pills-seller"
                                aria-selected="true">Best Sellers</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link tap_color text_black" id="pills-new-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-new" type="button" role="tab" aria-controls="pills-new"
                                aria-selected="false">New Customers</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tap_color text_black" id="pills-customer-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-customer" type="button" role="tab"
                                aria-controls="pills-customer" aria-selected="false">Customers</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tap_color text_black" id="pills-product-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-product" type="button" role="tab" aria-controls="pills-product"
                                aria-selected="false">Most Viewed Products</button>
                        </li>
                    </ul>



                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="pills-seller" role="tabpanel"
                            aria-labelledby="pills-seller-tab">
                            <table class="table tab-content" id="pills-tabContent">
                                <thead>
                                    <tr>
                                        <th class="text_black" scope="col">Product Image</th>
                                        <th class="text_black" scope="col">Product Name</th>
                                        <th class="text_black" scope="col">Code</th>
                                        <th class="text_black" scope="col">Quantity</th>
                                        <th class="text_black" scope="col">Price</th>
                                        <th class="text_black" scope="col">Pack Price</th>
                                        <th class="text_black" scope="col">Single Price</th>
                                        <th class="text_black" scope="col">Pack Size</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($best_sellers))
                                        @foreach ($best_sellers as $sellers)
                                            <tr>
                                                <td><img src="{{ asset($sellers->image) }}" alt="Image" width="70" height="70"></td>
                                                <td>{{ $sellers->name }}</td>
                                                <td>{{ $sellers->code }}</td>
                                                <td>{{ $sellers->qty }}</td>
                                                <td>{{ $sellers->price }}</td>
                                                <td>{{ $sellers->delivery_pack }}</td>
                                                <td>{{ $sellers->delivery_single }}</td>
                                                <td>{{ $sellers->pack_size }}</td>
                                            </tr>
                                        @endforeach
                                    @endif

                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="pills-new" role="tabpanel" aria-labelledby="pills-new-tab">
                            <table class="table tab-content" id="pills-tabContent">
                                <thead>
                                    <tr>
                                        <th class="text_black" scope="col">New Customers</th>
                                        <th class="text_black" scope="col">Code</th>
                                        <th class="text_black" scope="col">Orders</th>
                                        <th class="text_black" scope="col">Average</th>
                                        <th class="text_black" scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($new_customer))
                                        @foreach ($new_customer as $new)
                                            <tr>
                                                <td>{{ $new->name }}</td>
                                                <td>{{ $new->ms_number }}</td>
                                                <td>{{ $new->sale_count }}</td>
                                                <td>{{ $new->sale_sum_grand_total ? number_format((float) $new->sale_sum_grand_total, 2, '.', '') : 0 }}
                                                </td>
                                                <td>{{ $new->sale_avg_grand_total ? number_format((float) $new->sale_avg_grand_total, 2, '.', '') : 0 }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="pills-customer" role="tabpanel"
                            aria-labelledby="pills-customer-tab">
                            <table class="table tab-content" id="pills-tabContent">
                                <thead>
                                    <tr>
                                        <th class="text_black" scope="col">Customers</th>
                                        <th class="text_black" scope="col">Orders</th>
                                        <th class="text_black" scope="col">Average</th>
                                        <th class="text_black" scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($customers))
                                        @foreach ($customers as $customer)
                                            <tr>
                                                <td>{{ $customer->name }}</td>
                                                <td>{{ $customer->sale_count }}</td>
                                                <td>{{ $customer->sale_sum_grand_total ? number_format((float) $customer->sale_sum_grand_total, 2, '.', '') : 0 }}
                                                </td>
                                                <td>{{ $customer->sale_avg_grand_total ? number_format((float) $customer->sale_avg_grand_total, 2, '.', '') : 0 }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="pills-product" role="tabpanel"
                            aria-labelledby="pills-product-tab">
                            <table class="table tab-content" id="pills-tabContent">
                                <thead>
                                    <tr>
                                        <th class="text_black" scope="col">Product Name</th>
                                        <th class="text_black" scope="col">Code</th>
                                        <th class="text_black" scope="col">Quantity</th>
                                        <th class="text_black" scope="col">Price</th>
                                        <th class="text_black" scope="col">Pack Price</th>
                                        <th class="text_black" scope="col">Single Price</th>
                                        <th class="text_black" scope="col">Views</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($viewed_products))
                                        @foreach ($viewed_products as $product)
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->code }}</td>
                                                <td>{{ $product->qty }}</td>
                                                <td>{{ $product->price }}</td>
                                                <td>{{ $product->delivery_pack }}</td>
                                                <td>{{ $product->delivery_single }}</td>
                                                <td>{{ $product->count }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Website Customers --}}
    <div class="row">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div>
                        <h4 class="branch_text">B2C Customers Analytics :</h4>
                        <hr class="short_hr">
                    </div>
                    <ul class="nav nav-pills mb-3 ml-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active tap_color text_black" id="pills-seller-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-seller1" type="button" role="tab"
                                aria-controls="pills-seller" aria-selected="true">Best Sellers</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link tap_color text_black" id="pills-new-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-new1" type="button" role="tab" aria-controls="pills-new"
                                aria-selected="false">New Customers</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tap_color text_black" id="pills-customer-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-customer1" type="button" role="tab"
                                aria-controls="pills-customer1" aria-selected="false">Customers</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tap_color text_black" id="pills-product-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-product1" type="button" role="tab"
                                aria-controls="pills-product1" aria-selected="false">Most Viewed Products</button>
                        </li>
                    </ul>



                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="pills-seller1" role="tabpanel"
                            aria-labelledby="pills-seller-tab">
                            <table class="table tab-content" id="pills-tabContent">
                                <thead>
                                    <tr>
                                        <th class="text_black" scope="col">Product Image</th>
                                        <th class="text_black" scope="col">Product Name</th>
                                        <th class="text_black" scope="col">Code</th>
                                        <th class="text_black" scope="col">Quantity</th>
                                        <th class="text_black" scope="col">Price</th>
                                        <th class="text_black" scope="col">Pack Price</th>
                                        <th class="text_black" scope="col">Single Price</th>
                                        <th class="text_black" scope="col">Pack Size</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($best_sellers_b2c))
                                        @foreach ($best_sellers_b2c as $sellers)
                                            <tr>
                                                <td><img src="{{ asset($sellers->image) }}" alt="Image" width="70" height="70"></td>
                                                <td>{{ $sellers->name }}</td>
                                                <td>{{ $sellers->code }}</td>
                                                <td>{{ $sellers->qty }}</td>
                                                <td>{{ $sellers->price }}</td>
                                                <td>{{ $sellers->delivery_pack }}</td>
                                                <td>{{ $sellers->delivery_single }}</td>
                                                <td>{{ $sellers->pack_size }}</td>
                                            </tr>
                                        @endforeach
                                    @endif

                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="pills-new1" role="tabpanel" aria-labelledby="pills-new-tab">
                            <table class="table tab-content" id="pills-tabContent">
                                <thead>
                                    <tr>
                                        <th class="text_black" scope="col">New Customers</th>
                                        <th class="text_black" scope="col">Code</th>
                                        <th class="text_black" scope="col">Orders</th>
                                        <th class="text_black" scope="col">Average</th>
                                        <th class="text_black" scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($new_customer_b2c))
                                        {{-- {{dd($new_customer_b2c)}} --}}
                                        @foreach ($new_customer_b2c as $new)
                                            <tr>
                                                <td>{{ $new->name }}</td>
                                                <td>{{ $new->ms_number }}</td>
                                                <td>{{ $new->sale_count }}</td>
                                                <td>{{ $new->sale_sum_grand_total ? number_format((float) $new->sale_sum_grand_total, 2, '.', '') : 0 }}
                                                </td>
                                                <td>{{ $new->sale_avg_grand_total ? number_format((float) $new->sale_avg_grand_total, 2, '.', '') : 0 }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="pills-customer1" role="tabpanel"
                            aria-labelledby="pills-customer-tab">
                            <table class="table tab-content" id="pills-tabContent">
                                <thead>
                                    <tr>
                                        <th class="text_black" scope="col">Customers</th>
                                        <th class="text_black" scope="col">Orders</th>
                                        <th class="text_black" scope="col">Average</th>
                                        <th class="text_black" scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($customers_b2c))
                                        @foreach ($customers_b2c as $customer)
                                            <tr>
                                                <td>{{ $customer->name }}</td>
                                                <td>{{ $customer->sale_count }}</td>
                                                <td>{{ $customer->sale_sum_grand_total ? number_format((float) $customer->sale_sum_grand_total, 2, '.', '') : 0 }}
                                                </td>
                                                <td>{{ $customer->sale_avg_grand_total ? number_format((float) $customer->sale_avg_grand_total, 2, '.', '') : 0 }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="pills-product1" role="tabpanel"
                            aria-labelledby="pills-product-tab">
                            <table class="table tab-content" id="pills-tabContent">
                                <thead>
                                    <tr>
                                        <th class="text_black" scope="col">Product Name</th>
                                        <th class="text_black" scope="col">Code</th>
                                        <th class="text_black" scope="col">Quantity</th>
                                        <th class="text_black" scope="col">Price</th>
                                        <th class="text_black" scope="col">Pack Price</th>
                                        <th class="text_black" scope="col">Single Price</th>
                                        <th class="text_black" scope="col">Views</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($viewed_products))
                                        @foreach ($viewed_products as $product)
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->code }}</td>
                                                <td>{{ $product->qty }}</td>
                                                <td>{{ $product->price }}</td>
                                                <td>{{ $product->delivery_pack }}</td>
                                                <td>{{ $product->delivery_single }}</td>
                                                <td>{{ $product->count }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row tab-content">
        <div class="col-lg-12 col-md-12">
            <div style="justify-content: space-between;" class="row">
                <div style="float: right; width: 48%" class="card mb-6">
                    <div class="card-body">
                        <div class="card-title">This Year Sales</div>
                        <div id="echartBar" style="height: 300px;"></div>
                    </div>
                </div>
            
            <div style="float: left; width: 48%" class="card mb-6">
                <div class="card-body">
                    <div class="card-title">This Month Sales</div>
                    <div id="echartBarMonth" style="height: 300px;"></div>
                </div>
            </div>
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
                                <p class="mb-4 text-primary text-24">£{{ $last_month_sale ?? 0 }}</p>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="card card-chart-bottom o-hidden mb-4">
                            <div class="card-body">
                                <div class="text-muted">Last Week Sales</div>
                                <p class="mb-4 text-warning text-24">£{{ $last_week_sale ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="card card-chart-bottom o-hidden mb-4">
                            <div class="card-body">
                                <div class="text-muted">Current Sales</div>
                                <p class="mb-4 text-warning text-24">£{{ $current_month_sale ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="card-title">Sales by Company</div>
                        <div id="echartPie" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="card mb-4">
                    <button type="button" class="list-group-item list-group-item-action active">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-bell" viewBox="0 0 16 16">
                            <path
                                d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
                        </svg>Notifications
                    </button>
                    <ul class="list-group">
                        @foreach ($noti as $key => $notifications)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @if (isset($notifications->user_id))
                                    <a href="{{ route('admin.sale.list.company', $notifications->user_id) }}">{{ $notifications->user->name }}
                                        - Purchase Orders Pending Approval
                                    </a><span class="badge badge-primary badge-pill">{{ $notifications->total }}</span>
                                @else
                                    <a href="{{ route('admin.sale.list.company', 2) }}">Leeds - Purchase Orders Pending
                                        Approval
                                    </a><span class="badge badge-primary badge-pill">32</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>



    @endsection
    @section('scripts')
        <script src="{{ asset('app/js/plugins/echarts.min.js') }}"></script>
        <script src="{{ asset('app/js/scripts/echart.options.min.js') }}"></script>
        <script type="text/javascript">
            var reports = {!! $reports !!};
             var reports_monthly = {!! $reports_monthly !!};
            var sales_by_country = {!! $sale_by_company !!};
            var current_month_sale1 = {!! $current_month_sale1 !!};
            var sales_title = "Sales by company";
        </script>
        <script src="{{ asset('app/js/scripts/dashboard.v1.script.min.js') }}"></script>
    @endsection
