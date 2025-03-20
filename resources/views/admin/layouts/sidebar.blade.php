<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main" style="z-index: 0; important">
    <div class="sidenav-header text-center">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href="{{ route('show.dashboard') }}" target="_blank">
        <img src="{{  asset('storage/images/publicImg/icons/lambang_kabupaten_bangka.png') }}" class="navbar-brand-img" width="35" height="40" alt="">
        <h1 class="ms-1 text-lg font-bold text-dark">Admin</h1>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">

      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('show.dashboard') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('show.dashboard') }}">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
      </ul>

    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
      <div class="mx-3">
        @if (Auth::check())
          <form action="{{ route('logout') }}" method="post">
            @csrf
            <button class="bg-dark text-white w-100 mb-3 rounded">Logout</button>
          </form>
        @else
          <a class="btn bg-dark text-white w-100 mb-3 rounded" href="{{ route('login') }}" type="button">Login</a>
        @endif
      </div>
    </div>
  </aside>

 