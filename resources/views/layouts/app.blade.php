<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('app.includes.head')
    @yield('styles')
    
</head>

<body class="text-left">

    <div class="app-admin-wrap layout-sidebar-compact sidebar-dark-purple sidenav-open clearfix">
        @include('app.includes.sidebar')
        <!--=============== Left side End ================-->
        <div class="main-content-wrap d-flex flex-column">
            @include('app.includes.header')
            <!-- ============ Body content start ============= -->
            <div class="main-content">
                @include('app.includes.breadcrumb')
                <div class="separator-breadcrumb border-top"></div>
                @yield('content')
                </div>
                <!-- end of main-content -->
                <!-- Footer Start -->
                <div class="flex-grow-1"></div>

                @include('app.includes.footer')
                
                <!-- fotter end -->
            </div>
        </div>
    </div>

    @include('app.includes.foot')

    @yield('scripts')
    
</body>
</html>
