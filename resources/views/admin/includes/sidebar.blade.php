<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left hidden">
            <li class="nav-item active" data-item="dashboard">
                <a class="nav-item-hold" href="{{route('admin.dashboard')}}">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <div class="triangle"></div>
            </li>
            
            
        </ul>
    </div>
    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <i class="sidebar-close i-Close" (click)="toggelSidebar()"></i>
        <header>
            <div class="logo">
                <img src="{{asset('img/logo.png')}}" alt="">
            </div>
        </header>
        <!-- Submenu Dashboards -->
        <div class="submenu-area" data-parent="dashboard">
            <header>
                <h6>Dashboard</h6>
                <!-- <p>Your all shop status and activity goes here</p> -->
            </header>
            <ul class="childNav">
                <li class="nav-item">
                    <a href="{{route('admin.dashboard')}}" class="@if(route::is('admin.dashboard')) open @endif">
                        <i class="nav-icon i-Dashboard my_bold"></i>
                        <span class="item-name my_bold">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{url('admin/products')}}" class="@if(route::is('products.index')) open @endif">
                        <i class="nav-icon i-Add-User my_bold"></i>
                        <span class="item-name my_bold">Product</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('admin.tax')}}" class="@if(route::is('admin.tax')) open @endif">
                        <i class="nav-icon i-Add-User my_bold"></i>
                        <span class="item-name my_bold">Tax</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('warehouse.index')}}" class="@if(route::is('warehouse.index')) open @endif">
                        <i class="nav-icon i-Book my_bold"></i>
                        <span class="item-name my_bold">Warehouse</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('deliveryr.index')}}" class="@if(route::is('deliveryr.index')) open @endif">
                        <i class="nav-icon i-Book my_bold"></i>
                        <span class="item-name my_bold">Devlivery Setting</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('stock.index')}}" class="@if(route::is('stock.index')) open @endif">
                        <i class="nav-icon i-Book my_bold"></i>
                        <span class="item-name my_bold">Stock</span>
                    </a>
                </li>

                {{-- Added By Hassan Mateen ----Begin --}}
                <li class="nav-item">
                    <a href="" id ="pickupAndCollect" class="@if(route::is('slots.index') || route::is('leaves.index')) open @endif  collapsed" data-toggle="collapse" aria-expanded="false"><i class="nav-icon fa fa-angle-down"></i> <span class="d-none d-md-inline my_bold">Pickup & Collect</span> </a>
                    <div class="collapse @if(route::is('slots.index') || route::is('leaves.index')) show @endif" id="innerMenu" data-parent="#sidebar">
                        <a href="{{route('slots.index')}}" class="@if(route::is('slots.index')) open @endif">
                            <i class="nav-icon i-Book my_bold"></i>
                            <span class="item-name my_bold">Slots</span>
                        </a>
                        <a href="{{route('leaves.index')}}" class="@if(route::is('leaves.index')) open @endif">
                            <i class="nav-icon i-Book my_bold"></i>
                            <span class="item-name my_bold">Leaves</span>
                        </a>
                    </div>
                </li>
                {{-- Added By Hassan Mateen ----End --}}

                {{-- <li class="nav-item">
                    <a href="{{route('slots.index')}}" class="@if(route::is('slots.index')) open @endif">
                        <i class="nav-icon i-Book"></i>
                        <span class="item-name">Slots</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('leaves.index')}}" class="@if(route::is('leaves.index')) open @endif">
                        <i class="nav-icon i-Book"></i>
                        <span class="item-name">Leaves</span>
                    </a>
                </li> --}}

                 <li class="nav-item">
                    <a href="{{route('admin.sale.list')}}" class="@if(route::is('admin.sale.list')) open @endif">
                        <i class="nav-icon i-Book my_bold"></i>
                        <span class="item-name my_bold">Sale</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('admin.pos.sale.list')}}" class="@if(route::is('admin.pos.sale.list')) open @endif">
                        <i class="nav-icon i-Book my_bold"></i>
                        <span class="item-name my_bold">POS Sale</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('category.index')}}" class="@if(route::is('category.index')) open @endif">
                        <i class="nav-icon i-Add-User my_bold"></i>
                        <span class="item-name my_bold">Category</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('customer_category.index')}}" class="@if(route::is('customer_category.index')) open @endif">
                        <i class="nav-icon i-Add-User my_bold"></i>
                        <span class="item-name my_bold">Customer Category</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('brand.index')}}" class="@if(route::is('brand.index')) open @endif">
                        <i class="nav-icon i-Add-User my_bold"></i>
                        <span class="item-name my_bold">Brand</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.coupon')}}" class="@if(route::is('admin.coupon')) open @endif">
                        <i class="nav-icon i-Add-User my_bold"></i>
                        <span class="item-name my_bold">Coupon</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('banner.index')}}" class="@if(route::is('banner.index')) open @endif">
                        <i class="nav-icon i-File-Chart my_bold"></i>
                        <span class="item-name my_bold">Banner</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.search_term')}}" class="@if(route::is('admin.search_term')) open @endif">
                        <i class="nav-icon i-File-Chart my_bold"></i>
                        <span class="item-name my_bold">Search Analytics</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.product_price')}}" class="@if(route::is('admin.product_price')) open @endif">
                        <i class="nav-icon i-File-Chart my_bold"></i>
                        <span class="item-name my_bold">Product Price Table</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.company_pricing')}}" class="@if(route::is('admin.company_pricing')) open @endif">
                        <i class="nav-icon i-File-Chart my_bold"></i>
                        <span class="item-name my_bold">Company Pricing</span>
                    </a>
                </li>
               <li class="nav-item">
                    <a href="{{route('admin.company')}}" class="@if(route::is('admin.company')) open @endif">
                        <i class="nav-icon i-Add-User my_bold"></i>
                        <span class="item-name my_bold">Company</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('branches.index')}}" class="@if(route::is('branches.index')) open @endif">
                        <i class="nav-icon i-Book my_bold"></i>
                        <span class="item-name my_bold">Branches</span>
                    </a>
                </li>
                @can('user-list')
                {{-- <li class="nav-item">
                    <a href="{{route('admin.user')}}" class="@if(route::is('admin.user')) open @endif">
                        <i class="nav-icon i-Add-User"></i>
                        <span class="item-name">User</span>
                    </a>
                </li> --}}
                @endcan
                <li class="nav-item">
                    <a href="{{route('admin.promotion')}}" class="@if(route::is('admin.promotion')) open @endif">
                        <i class="nav-icon i-Book my_bold"></i>
                        <span class="item-name my_bold">Promotion Banner</span>
                    </a>
                </li>
                @can('admin-list')
                <li class="nav-item">
                    <a href="{{route('admin.sub')}}" class="@if(route::is('admin.sub')) open @endif">
                        <i class="nav-icon i-Add-UserStar my_bold"></i>
                        <span class="item-name my_bold">Admin</span>
                    </a>
                </li>
                @endcan
                @can('role-list')
                <li class="nav-item">
                    <a href="{{route('admin.role')}}" class="@if(route::is('admin.role')) open @endif">
                        <i class="nav-icon i-Key-Lock my_bold"></i>
                        <span class="item-name my_bold">Role</span>
                    </a>
                </li>
                 @endcan
                 <li class="nav-item">
                    <a href="{{route('admin.report')}}" class="@if(route::is('admin.report')) open @endif">
                        <i class="nav-icon i-Book my_bold"></i>
                        <span class="item-name my_bold">Report</span>
                    </a>
                </li>

                
            </ul>
        </div>

    </div>
</div>