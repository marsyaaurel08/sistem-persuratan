<nav class="nxl-navigation custom-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header" style= "background-color: #000B58;">
            <a href="index.html" class="b-brand">
                <!-- ========   change your logo hear   ============ -->
                <img src="{{ asset('assets/images/logo-full-pjt.png') }}" alt="" class="logo logo-lg" style="max-width: 200px;"/>
                <img src="{{ asset('assets/images/logo-pjt.png') }}" alt="" class="logo logo-sm" style="width: 70px;"/>
            </a>
        </div>
        <div class="navbar-content">
            <ul class="nxl-navbar">
                <li class="nxl-item nxl-caption">
                    <label>Navigation</label>
                </li>
                <li class="nxl-item">
                    <a href="{{ url('/dashboard') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-home"></i></span>
                        <span class="nxl-mtext">Dashboard</span><span class="nxl-arrow">
                    </a>
                </li>
                {{-- <li class="nxl-item">
                    <a href="{{ url('/surat_masuk') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-mail"></i></span>
                        <span class="nxl-mtext">Surat Masuk</span><span class="nxl-arrow">
                    </a>
                </li>
                <li class="nxl-item">
                    <a href="{{ url('/surat_keluar') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-send"></i></span>
                        <span class="nxl-mtext">Surat Keluar</span><span class="nxl-arrow">
                    </a>

                </li> --}}
                <li class="nxl-item">
                    <a href="{{ url('/arsip') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-archive"></i></span>
                        <span class="nxl-mtext">Arsip</span><span class="nxl-arrow">
                    </a>
                </li>
                <li class="nxl-item">
                    <a href="{{ url('/laporan') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-bar-chart-2"></i></span>
                        <span class="nxl-mtext">Rekap</span><span class="nxl-arrow">
                    </a>
                </li>
                {{-- <li class="nxl-item">
                    <a href="{{ url('/manajemen-pengguna') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-users"></i></span>
                        <span class="nxl-mtext">Manajemen Pengguna</span><span class="nxl-arrow">
                    </a>
                </li> --}}
                <li class="nxl-item">
                    <a href="javascript:void(0);" class="nxl-link" data-bs-toggle="modal" data-bs-target="#modalLogout">
                        <span class="nxl-micon"><i class="feather-log-out"></i></span>
                        <span class="nxl-mtext">Logout</span><span class="nxl-arrow">
                    </a>
                </li>
        </div>
    </div>
</nav>