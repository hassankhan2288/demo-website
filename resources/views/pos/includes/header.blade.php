<div class="main-header">
    <div class="logo">
        <img src="{{asset('img/logo.png')}}" alt="">
    </div>
    <div class="menu-toggle">
        <div></div>
        <div></div>
        <div></div>
    </div>
    <div class="d-flex align-items-center">
        <!-- Mega menu -->
        

    </div>
    <div style="margin: auto"></div>
    <div class="header-part-right">
        <!-- Full screen toggle -->
        <!-- User avatar dropdown -->
        <div class="dropdown">
            <div class="user col align-self-end">
                <a id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="javascript:void();">@auth{{ucfirst(auth()->user()->name)}}@endauth</a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <div class="dropdown-header">
                        <i class="i-Lock-User mr-1"></i> @auth{{auth()->user()->email}}@endauth
                    </div>
                    <a href="{{route('pos.account.settings')}}" class="dropdown-item">Account settings</a>
                    <a class="dropdown-item" href="{{ route('pos.logout') }}" >Sign out</a>
                </div>
            </div>
        </div>
    </div>
    <form id="logout-form" action="{{ route('pos.logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

</div>