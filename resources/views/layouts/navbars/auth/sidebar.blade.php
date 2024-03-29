
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="{{ route('dashboard') }}">
        <img src="../assets/img/logos.png" class="navbar-brand-img h-100" alt="...">
        <span class="ms-3 font-weight-bold">OAE Manufacture Indonesia</span>
    </a>
  </div>
  <hr class="horizontal dark mt-0">
  <div class="w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('dashboard') ? 'active' : '') }}" href="{{ url('dashboard') }}">
          <div class="icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa fa-home"></i>
          </div>
          <span class="nav-link-text ms-1">Beranda</span>
        </a>
      </li>
      <li class="nav-item mt-2">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Akun</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('user-profile') ? 'active' : '') }} " href="{{ url('user-profile') }}">
            <div class="icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-user"></i>
            </div>
            <span class="nav-link-text ms-1">Profil</span>
        </a>
      </li>
      @if(auth()->user()->position=='superadmin' || auth()->user()->position=='admin' || auth()->user()->position=='owner')
      <li class="nav-item pb-2">
        <a class="nav-link {{ (Request::is('user-management') ? 'active' : '') }}" href="{{ url('user-management') }}">
            <div class=" icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-list"></i>
            </div>
            <span class="nav-link-text ms-1">Pengaturan Pengguna</span>
        </a>
      </li>
      @endif
      <li class="nav-item mt-2">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Management</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('delivery') ? 'active' : '') }} " href="{{ url('delivery') }}">
            <div class="icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-truck"></i>
            </div>
            <span class="nav-link-text ms-1">Delivery</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('laporan') ? 'active' : '') }} " href="{{ url('laporan') }}">
            <div class="icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-chart-bar"></i>
            </div>
            <span class="nav-link-text ms-1">Laporan Produksi</span>
        </a>
      </li>
      <li class="nav-item mt-2">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Inventory</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('stockraw') ? 'active' : '') }}" href="{{ url('stockraw') }}">
          <div class=" icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa fa-cubes"></i>
          </div>
          <span class="nav-link-text ms-1">Stock Raw</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('wip') ? 'active' : '') }}" href="{{ url('wip') }}">
          <div class=" icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-hourglass-half"></i>
          </div>
          <span class="nav-link-text ms-1">WIP</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('material') ? 'active' : '') }}" href="{{ url('material') }}">
          <div class=" icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa fa-cube"></i>
          </div>
          <span class="nav-link-text ms-1">Material</span>
        </a>
      </li>
      @if(auth()->user()->position=='superadmin' || auth()->user()->position=='admin' || auth()->user()->position=='owner')
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('finish') ? 'active' : '') }}" href="{{ url('finish') }}">
          <div class=" icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa fa-check-circle"></i>
          </div>
          <span class="nav-link-text ms-1">Finish Good</span>
        </a>
      </li>
      <li class="nav-item mt-2">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Data</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('target') ? 'active' : '') }} " href="{{ url('target') }}">
            <div class="icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-crosshairs"></i>
            </div>
            <span class="nav-link-text ms-1">Minimal Target</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('notgood') ? 'active' : '') }}" href="{{ url('notgood') }}">
          <div class=" icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa fa-exclamation-triangle"></i>
          </div>
          <span class="nav-link-text ms-1">Not Good</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('operator') ? 'active' : '') }} " href="{{ url('operator') }}">
            <div class="icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-briefcase"></i>
            </div>
            <span class="nav-link-text ms-1">Operator</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('customer') ? 'active' : '') }} " href="{{ url('customer') }}">
            <div class="icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-user-tie"></i>
            </div>
            <span class="nav-link-text ms-1">Customer</span>
        </a>
      </li>
      <li class="nav-item pb-2">
        <a class="nav-link {{ (Request::is('supplier') ? 'active' : '') }}" href="{{ url('supplier') }}">
            <div class=" icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-building"></i>
            </div>
            <span class="nav-link-text ms-1">Supplier</span>
        </a>
      </li>
      <li class="nav-item pb-2">
        <a class="nav-link {{ (Request::is('tonase') ? 'active' : '') }}" href="{{ url('tonase') }}">
            <div class=" icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-weight-hanging"></i>
            </div>
            <span class="nav-link-text ms-1">Tonase</span>
        </a>
      </li>
      <li class="nav-item pb-2">
        <a class="nav-link {{ (Request::is('proses') ? 'active' : '') }}" href="{{ url('proses') }}">
            <div class=" icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-gear"></i>
            </div>
            <span class="nav-link-text ms-1">Proses</span>
        </a>
      </li>
      @endif
    </ul>
  </div>
</aside>
