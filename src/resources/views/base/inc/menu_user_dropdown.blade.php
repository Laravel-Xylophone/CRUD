<li class="nav-item dropdown pr-4">
  <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
    <img class="img-avatar" src="{{ xylophone_avatar_url(xylophone_auth()->user()) }}" alt="{{ xylophone_auth()->user()->name }}">
  </a>
  <div class="dropdown-menu dropdown-menu-right mr-4 pb-1 pt-1">
    <a class="dropdown-item" href="{{ route('xylophone.account.info') }}"><i class="fa fa-user"></i> {{ trans('xylophone::base.my_account') }}</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ xylophone_url('logout') }}"><i class="fa fa-lock"></i> {{ trans('xylophone::base.logout') }}</a>
  </div>
</li>
