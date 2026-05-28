<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{ route('dashboard') }}" class="app-brand-link">
      <span class="app-brand-logo demo">
        <span class="bg-primary text-white d-flex align-items-center justify-content-center rounded-circle" style="width: 38px; height: 38px;">
          <i class="ti ti-tool fs-4"></i>
        </span>
      </span>
      <span class="app-brand-text demo menu-text fw-bold ms-2">POS Bengkel</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
      <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Home / Dashboard -->
    <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <a href="{{ route('dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-layout-dashboard"></i>
        <div>Dashboard</div>
      </a>
    </li>

    <!-- Kasir -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link">
        <i class="menu-icon tf-icons ti ti-shopping-cart"></i>
        <div>Kasir Transaksi</div>
      </a>
    </li>

    <!-- Dropdown Data Master -->
    <li class="menu-item {{ request()->segment(1) == 'master' || request()->is('categories*', 'services*') ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-database"></i>
        <div>Data Master</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->is('categories*') ? 'active' : '' }}">
          <a href="{{ route('categories.index') }}" class="menu-link">
            <div>Kategori</div>
          </a>
        </li>
        <li class="menu-item {{ request()->is('services*') ? 'active' : '' }}">
          <a href="{{ route('services.index') }}" class="menu-link">
            <div>Jasa Servis</div>
          </a>
        </li>
        <li class="menu-item {{ request()->segment(2) == 'sukucadang' ? 'active' : '' }}">
          <a href="javascript:void(0);" class="menu-link">
            <div>Stok & Suku Cadang</div>
          </a>
        </li>
        <li class="menu-item {{ request()->segment(2) == 'mekanik' ? 'active' : '' }}">
          <a href="javascript:void(0);" class="menu-link">
            <div>Mekanik</div>
          </a>
        </li>
        <li class="menu-item {{ request()->segment(2) == 'pelanggan' ? 'active' : '' }}">
          <a href="javascript:void(0);" class="menu-link">
            <div>Pelanggan</div>
          </a>
        </li>
      </ul>
    </li>

    <!-- Logout -->
    <li class="menu-item">
      <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-sidebar-form').submit();" class="menu-link">
        <i class="menu-icon tf-icons ti ti-logout"></i>
        <div data-i18n="Logout">Keluar</div>
      </a>
      <form id="logout-sidebar-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </li>
  </ul>
</aside>
