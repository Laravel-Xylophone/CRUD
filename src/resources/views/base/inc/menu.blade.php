<!-- =================================================== -->
<!-- ========== Top menu items (ordered left) ========== -->
<!-- =================================================== -->
<ul class="nav navbar-nav d-md-down-none">

    @if (xylophone_auth()->check())
        <!-- Topbar. Contains the left part -->
        @include(xylophone_view('inc.topbar_left_content'))
    @endif

</ul>
<!-- ========== End of top menu left items ========== -->



<!-- ========================================================= -->
<!-- ========= Top menu right items (ordered right) ========== -->
<!-- ========================================================= -->
<ul class="nav navbar-nav ml-auto">
    @if (xylophone_auth()->guest())
        <li class="nav-item"><a class="nav-link" href="{{ url(config('xylophone.base.route_prefix', 'admin').'/login') }}">{{ trans('xylophone::base.login') }}</a>
        </li>
        @if (config('xylophone.base.registration_open'))
            <li class="nav-item"><a class="nav-link" href="{{ route('xylophone.auth.register') }}">{{ trans('xylophone::base.register') }}</a></li>
        @endif
    @else
        <!-- Topbar. Contains the right part -->
        @include(xylophone_view('inc.topbar_right_content'))
        @include(xylophone_view('inc.menu_user_dropdown'))
    @endif
</ul>
<!-- ========== End of top menu right items ========== -->
