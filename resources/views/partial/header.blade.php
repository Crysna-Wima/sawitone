@php
use App\Helpers\App;
@endphp

<nav class="navbar navbar-expand-lg main-navbar">
  <form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    </ul>
  </form>
  <ul class="navbar-nav navbar-right">
    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep" aria-expanded="false"><i class="far fa-bell"></i></a>
      <div class="dropdown-menu dropdown-list dropdown-menu-right">
        <div class="dropdown-header">Notifications
          <div class="float-right">
            <a href="#">Mark All As Read</a>
          </div>
        </div>
        <div class="dropdown-list-content dropdown-list-icons" style="overflow: hidden; outline: none;" tabindex="3">
          <a href="#" class="dropdown-item">
            <div class="dropdown-item-icon bg-success text-white">
              <i class="fas fa-check"></i>
            </div>
            <div class="dropdown-item-desc">
              <b>SO Telah dibuat</b>
              <div class="time">12 Hours Ago</div>
            </div>
          </a>
          <a href="#" class="dropdown-item dropdown-item-unread">
            <div class="dropdown-item-icon bg-danger text-white">
              <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="dropdown-item-desc">
              <b>Stok menipis.</b> Segera belanja lagi!
              <div class="time">17 Hours Ago</div>
            </div>
          </a>
        </div>
        <div class="dropdown-footer text-center">
          <a href="#">View All <i class="fas fa-chevron-right"></i></a>
        </div>
        <div id="ascrail2002" class="nicescroll-rails nicescroll-rails-vr" style="width: 9px; z-index: 1000; cursor: default; position: absolute; top: 57.9861px; left: 341px; height: 350px; opacity: 0.3; display: none;">
          <div class="nicescroll-cursors" style="position: relative; top: 44px; float: right; width: 7px; height: 305px; background-color: rgb(66, 66, 66); border: 1px solid rgb(255, 255, 255); background-clip: padding-box; border-radius: 5px;"></div>
        </div>
        <div id="ascrail2002-hr" class="nicescroll-rails nicescroll-rails-hr" style="height: 9px; z-index: 1000; top: 398.986px; left: 0px; position: absolute; cursor: default; display: none; width: 341px; opacity: 0.3;">
          <div class="nicescroll-cursors" style="position: absolute; top: 0px; height: 7px; width: 350px; background-color: rgb(66, 66, 66); border: 1px solid rgb(255, 255, 255); background-clip: padding-box; border-radius: 5px; left: 0px;"></div>
        </div>
      </div>
    </li>
    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <img alt="image" src="{{asset('assets/img/avatar/avatar-1.png')}}" class="rounded-circle mr-1">
        <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->fc_userid }}</div>
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <a href="/change-password" class="dropdown-item has-icon">
          <i class="far fa-user"></i> Change Password
        </a>
        <div class="dropdown-divider"></div>
        <a href="/logout" class="dropdown-item has-icon text-danger">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </div>
    </li>
  </ul>
</nav>
<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand mb-4">
      {{-- <a href="index.html">DEXA</a> --}}
      <a href="index.html">
        <img src="{{ asset('/assets/img/logo-dexa.png') }}" alt="logo" width="160" class="mb-4 mt-3">
      </a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="index.html">DEXA</a>
    </div>
    <?php
    $url_menu = Request::segment(1);
    $url_submenu = Request::segment(2);
    ?>
    <ul class="sidebar-menu">
      <li class="menu-header">Dashboard</li>
      <li class="nav-item dropdown @if($url_menu == " dashboard") active @endif"><a href="/dashboard" class="nav-link"><i class="fas fa-home"></i><span>Dashboard</span></a></li>

      @foreach (App::get_master_menu() as $key => $parent)
      <li class="menu-header">{{ $key }}</li>
      @foreach ($parent as $item)
      @if (isset($item['submenu']))
      <li class="nav-item dropdown @if($url_menu == $item['menu']) active @endif">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="{{ $item['icon'] }}"></i></i> <span>{{ $item['nama'] }}</span></a>
        <ul class="dropdown-menu">
          @foreach ($item['submenu'] as $submenu)
          <li class="@if($url_menu == $submenu['menu'] && $url_submenu == $submenu['submenu']) active @endif"><a class="nav-link" href="{{ $submenu['link'] }}">{{ $submenu['nama'] }}</a></li>
          @endforeach
        </ul>
      </li>
      @else
      <li class="nav-item dropdown @if($url_menu == $item['menu'] && $url_submenu == $item['submenu_parent']) active @endif"><a href="{{ $item['link'] }}" class="nav-link"><i class="{{ $item['icon'] }}"></i><span>{{ $item['nama'] }}</span></a></li>
      @endif
      @endforeach
      @endforeach
    </ul>

  </aside>
</div>