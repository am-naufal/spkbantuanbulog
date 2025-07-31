    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
            <img src="{{ asset('/images/slider-logo.png') }}" alt="Logo" class="sidebar-brand-icon"
                style="height: 52px">
            <div class="sidebar-brand-text mx-3">SPK Penerima Bantuan </div>

        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        @if (auth()->user()->role === 'kepala_desa')
            <li class="nav-item {{ request()->Is('kepalaDesaDashboard*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('kepalaDesaDashboard') }}">
                    <i class="fas fa-fw fa-chart-line"></i>
                    <span>Dashboard Kepala Desa</span></a>
            </li>
        @endif
        <!-- Nav Item - Dashboard -->
        @if (auth()->user()->role === 'admin')
            <li class="nav-item {{ request()->routeIs('adminDashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('adminDashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
        @endif

        @if (auth()->user()->role === 'user')
            <li class="nav-item {{ request()->Is('dashboardusers*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('userDashboard') }}">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Dashboard Saya</span></a>
            </li>
            <!-- Heading -->


            <hr class="sidebar-divider d-none d-md-block">
            <li class="nav-item {{ request()->Is('penilaian*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('penilaianuser.index') }}">
                    <i class="fas fa-fw fa-bell"></i>
                    <span>Penilaian</span></a>
            </li>

            <li class="nav-item {{ request()->Is('perhitungan*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('perhitunganuser.index') }}">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Perhitungan</span></a>
            </li>
        @endif

        <!-- Divider -->


        @if (auth()->user()->role === 'admin')
            <!-- Heading -->
            <div class="sidebar-heading">
                DATA PERHITUNGAN
            </div>

            <!-- Nav Item - Tables -->
            <li class="nav-item {{ request()->Is('kriteria*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('kriteria.index') }}">
                    <i class="fas fa-fw fa-code"></i>
                    <span>Data Kriteria</span></a>
            </li>

            <li class="nav-item {{ request()->Is('alternatif*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('alternatif.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Data Warga / Alternatif</span></a>
            </li>

            <li class="nav-item dropdown {{ request()->is('admin/user*') ? 'active' : '' }}">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw fa-user-circle"></i>
                    <span>Data Pengguna</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="userDropdown">
                    <a class="dropdown-item {{ request()->is('admin/admin*') ? 'active' : '' }}"
                        href="{{ route('user.admin') }}">Admin</a>
                    <a class="dropdown-item {{ request()->is('user*') && !request()->is('user/admin*') ? 'active' : '' }}"
                        href="{{ route('user.index') }}">User</a>
                </div>
            </li>
            <li class="nav-item {{ request()->Is('penilaian*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('penilaian.index') }}">
                    <i class="fas fa-fw fa-bell"></i>
                    <span>Penilaian</span></a>
            </li>

            <li class="nav-item {{ request()->Is('perhitungan*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('perhitungan.index') }}">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Perhitungan</span></a>
            </li>
        @endif

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">




        @if (auth()->user()->role === 'admin')
            <!-- Divider -->
            <hr class="sidebar-divider my-0">


            <li class="nav-item dropdown {{ request()->Is('laporan*') ? 'active' : '' }}">
                <a class="nav-link dropdown-toggle" href="#" id="laporanDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span>Laporan</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="laporanDropdown">
                    <a class="dropdown-item {{ request()->is('laporan*') ? 'active' : '' }}"
                        href="{{ route('laporan') }}">Semua Laporan</a>
                    <a class="dropdown-item {{ request()->is('penerima*') ? 'active' : '' }}"
                        href="{{ route('penerima') }}">Penerima</a>
                </div>
            </li>
        @endif
        @if (auth()->user()->role === 'kepala_desa')
            <!-- Divider -->
            <li class="nav-item dropdown {{ request()->Is('laporan*') ? 'active' : '' }}">
                <a class="nav-link dropdown-toggle" href="#" id="laporanDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span>Laporan</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="laporanDropdown">
                    <a class="dropdown-item {{ request()->is('laporan*') ? 'active' : '' }}"
                        href="{{ route('laporan') }}">Semua Laporan</a>
                    <a class="dropdown-item {{ request()->is('penerima*') ? 'active' : '' }}"
                        href="{{ route('kepala.penerima') }}">Penerima</a>
                </div>
            </li>
            <hr class="sidebar-divider my-0">
        @endif
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>


    </ul>
