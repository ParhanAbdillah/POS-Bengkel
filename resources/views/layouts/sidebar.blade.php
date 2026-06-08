<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{ route('dashboard') }}" class="app-brand-link">
      <span class="app-brand-text demo menu-text fw-bold ms-2">Mandiri Motor</span>
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
      <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
    </a>
  </div>
  <div class="menu-inner-shadow"></div>
  <ul class="menu-inner py-1">

    <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <a href="{{ route('dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-layout-dashboard"></i>
        <div>Dashboard</div>
      </a>
    </li>

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">TRANSAKSI TOKO</span>
    </li>
    <li class="menu-item {{ request()->routeIs('product-sales.*') ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-shopping-cart"></i>
        <div>Penjualan</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('product-sales.create') ? 'active' : '' }}">
          <a href="{{ route('product-sales.create') }}" class="menu-link">
            <div>POS Penjualan</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('product-sales.index') ? 'active' : '' }}">
          <a href="{{ route('product-sales.index') }}" class="menu-link">
            <div>Riwayat Penjualan</div>
          </a>
        </li>
      </ul>
    </li>
    <li class="menu-item {{ request()->routeIs('transactions.*') ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-edit"></i>
        <div>Transaksi Servis</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('transactions.create') ? 'active' : '' }}">
          <a href="{{ route('transactions.create') }}" class="menu-link">
            <div>Data Servis Masuk</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('transactions.index') ? 'active' : '' }}">
          <a href="{{ route('transactions.index') }}" class="menu-link">
            <div>List Transaksi Servis</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('transactions.returns') ? 'active' : '' }}">
          <a href="{{ route('transactions.returns') }}" class="menu-link">
            <div>Pengembalian Servis</div>
          </a>
        </li>
      </ul>
    </li>
    <li class="menu-item {{ request()->routeIs('vehicles.*') ? 'active' : '' }}">
      <a href="{{ route('vehicles.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-list-details"></i>
        <div>Data Kendaraan Servis</div>
      </a>
    </li>
    <li class="menu-item {{ request()->routeIs('mechanics.*') ? 'active' : '' }}">
      <a href="{{ route('mechanics.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-settings"></i>
        <div>Mekanik</div>
      </a>
    </li>

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">DATA MASTER</span>
    </li>
    <li class="menu-item {{ request()->is('categories*', 'services*','spareparts*', 'customers*') ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-database"></i>
        <div>Master</div>
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
        <li class="menu-item {{ request()->is('spareparts*') ? 'active' : '' }}">
          <a href="{{ route('spareparts.index') }}" class="menu-link">
            <div>Sparepart</div>
          </a>
        </li>
        <li class="menu-item {{ request()->is('customers*') ? 'active' : '' }}">
          <a href="{{ route('customers.index') }}" class="menu-link">
            <div>Pelanggan</div>
          </a>
        </li>
      </ul>
    </li>

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">LAPORAN</span>
    </li>
    <li class="menu-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
      <a href="{{ route('reports.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-file-analytics"></i>
        <div>Laporan Keuangan</div>
      </a>
    </li>

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
