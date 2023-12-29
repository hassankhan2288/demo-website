<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <li class="nav-item active " data-item="dashboard">
                <a class="nav-item-hold" href="{{route('app.dashboard')}}">
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
                    <a href="{{route('app.dashboard')}}" class="@if(route::is('app.dashboard')) open @endif">
                        <i class="nav-icon i-File-Clipboard-Text--Image"></i>
                        <span class="item-name">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('app.branch')}}" class="@if(route::is('app.branch')) open @endif">
                        <i class="nav-icon i-Book"></i>
                        <span class="item-name">Branch</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('customers_category.index')}}" class="@if(route::is('app.user')) open @endif">
                        <i class="nav-icon i-Add-User"></i>
                        <span class="item-name">Category</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('app.product')}}" class="@if(route::is('app.product')) open @endif">
                        <i class="nav-icon i-Book"></i>
                        <span class="item-name">Product</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('app.sale.list')}}" class="@if(route::is('app.sale.list')) open @endif">
                        <i class="nav-icon i-Book"></i>
                        <span class="item-name">Sale</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('app.report')}}" class="@if(route::is('app.report')) open @endif">
                        <i class="nav-icon i-Book"></i>
                        <span class="item-name">Report</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>