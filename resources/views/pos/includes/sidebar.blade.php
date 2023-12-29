<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <li class="nav-item active " data-item="dashboard">
                <a class="nav-item-hold" href="{{route('pos.dashboard')}}">
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
                    <a href="{{route('pos.dashboard')}}" class="@if(route::is('pos.dashboard')) open @endif">
                        <i class="nav-icon i-File-Clipboard-Text--Image"></i>
                        <span class="item-name">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('pos.product')}}" class="@if(route::is('pos.product')) open @endif">
                        <i class="nav-icon i-Book"></i>
                        <span class="item-name">Product</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('pos.sale.pos')}}" class="@if(route::is('pos.sale.pos')) open @endif">
                        <i class="nav-icon i-Book"></i>
                        <span class="item-name">Place Order</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('pos.sale.list')}}" class="@if(route::is('pos.sale.list')) open @endif">
                        <i class="nav-icon i-Book"></i>
                        <span class="item-name">Sale</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('pos.report')}}" class="@if(route::is('pos.report')) open @endif">
                        <i class="nav-icon i-Book"></i>
                        <span class="item-name">Report</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>