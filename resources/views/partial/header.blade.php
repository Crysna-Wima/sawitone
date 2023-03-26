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
      <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <img alt="image" src="{{asset('assets/img/avatar/avatar-1.png')}}" class="rounded-circle mr-1">
        <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->fc_userid }}</div></a>
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
          <img src="{{ asset('/assets/img/logo-dexa.png') }}" width="70%" height="90%">
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
          <li class="nav-item dropdown @if($url_menu == "dashboard") active @endif"><a href="/dashboard" class="nav-link"><i class="fas fa-home"></i><span>Dashboard</span></a></li>

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
