<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: rgb(22 179 172)">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: rgb(22 179 172);">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <!-- <img src="{//{asset('asset')}}/apotek.png" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
        <span class="brand-text" style="color:#fff; font-weight:bold">Semar PKG79</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <!-- <div class="image"> -->
            <!-- <img src="{//{asset('public/gambar}/akun.png" style="width:60px; height:auto"> -->
            <!-- </div> -->
            <div class="info">
                <a href="#" class="d-block" style="color:#fff; font-weight:bold">{{ Auth::user()->nama }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ url('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard*') == 1 ? 'active' : '' }}">
                        <p style="color:#fff; font-weight:bold">Dashboard</p>
                    </a>
                </li>
                @if (Auth::user()->role == 'Admin')
                    <!-- <li class="nav-item">
                        <a href="{{ url('user') }}"
                            class="nav-link {{ request()->routeIs('user*') == 1 ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users" style="color: yellow;"></i>
                            <p style="color:#fff; font-weight:bold">User</p>
                        </a>
                    </li> -->
                @endif
                @if (Auth::user()->role == 'Admin' ||
                        Auth::user()->role == 'Puskesmas')
                    <!-- <li class="nav-item">
                        <a href="{{ url('pemeriksa') }}"
                            class="nav-link {{ request()->routeIs('pemeriksa*') == 1 ? 'active' : '' }}">
                            <img src="{{ asset('gambar/pemeriksa.png') }}"
                                style="width: 25.59px; height: auto;">
                            <p style="color:#fff; font-weight:bold">Pemeriksa</p>
                        </a>
                    </li> -->
                @endif

                <!-- <li class="nav-item">
                    <a href="{{ url('pasien') }}"
                        class="nav-link {{ request()->routeIs('pasien*') == 1 ? 'active' : '' }}">
                        <img src="{{ asset('gambar/pasien.png') }}" style="width: 25.59px; height: auto;">
                        <p style="color:#fff; font-weight:bold">Pasien</p>
                    </a>
                </li> -->
                <li class="nav-item">
                    <a href="{{ url('riwayat') }}"
                        class="nav-link {{ request()->routeIs('riwayat*') == 1 ? 'active' : '' }}">
                        <p style="color:#fff; font-weight:bold">Riwayat</p>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->routeIs('laporan*') == 1 ? 'active' : '' }}">
                        <img src="{{ asset('gambar/laporan.png') }}" style="width: 25.59px; height: auto;">
                        <p style="font-weight:bold; color:white">
                            Laporan
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('laporan/skrining_dasar') }}"
                                class="nav-link {{ request()->routeIs('laporan.skrining_dasar*') == 1 ? 'bg-blue' : '' }}">
                                <img src="{{ asset('gambar/skrining_dasar.png') }}"
                                    style="width: 25.59px; height: auto;">
                                <p style="font-weight:bold; color:white">Skrining Dasar</p>
                            </a>
                        </li>
                    </ul>
                </li> -->
                <li class="nav-item">
                    <a href="{{ url('logout') }}" class="nav-link">
                        <p style="color:#fff; font-weight:bold">Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
