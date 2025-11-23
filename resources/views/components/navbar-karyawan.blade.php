<nav class="navbar-karyawan">

    <!-- BRAND / LOGO -->
    <a href="{{ url('/karyawan/dashboard') }}" class="nav-brand">
        <i class="fa-solid fa-mug-hot"></i>
        <span>Kedai Kambojda</span>
    </a>

    <!-- MENU -->
    <div class="nav-links">
        <a href="{{ url('/karyawan/dashboard') }}"
           class="{{ request()->is('karyawan/dashboard') ? 'nav-active' : '' }}">
            Dashboard
        </a>

        <a href="{{ route('absen.index') }}"
           class="{{ request()->routeIs('absen.index') ? 'nav-active' : '' }}">
            Absensi
        </a>

        <a href="{{ url('../absensi/riwayat') }}"
           class="{{ request()->is('absen.riwayat') ? 'nav-active' : '' }}">
            Riwayat
        </a>
    </div>

    <!-- LOGOUT -->
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-btn">Logout</button>
    </form>

</nav>

<style>
    .navbar-karyawan {
        width: 100%;
        background:#00695c;
        padding:12px 20px;
        display:flex;
        justify-content:space-between;
        align-items:center;
        box-sizing:border-box;
        color:white;
        font-family:'Segoe UI', sans-serif;
    }

    /* Brand */
    .navbar-karyawan .nav-brand {
        display:flex;
        align-items:center;
        gap:8px;
        color:white;
        text-decoration:none;
        font-size:18px;
        font-weight:600;
    }

    .navbar-karyawan .nav-brand i {
        font-size:22px;
        color:white;
    }

    /* Menu */
    .navbar-karyawan .nav-links {
        display:flex;
        gap:25px;
    }

    .navbar-karyawan .nav-links a {
        color:white;
        text-decoration:none;
        font-size:15px;
        font-weight:500;
        transition:0.2s;
    }

    .navbar-karyawan .nav-links a:hover {
        text-decoration:underline;
    }

    .nav-active {
        text-decoration:underline !important;
        font-weight:600 !important;
    }

    /* Logout Button */
    .logout-btn {
        background:#c62828;
        border:none;
        color:white;
        padding:8px 14px;
        font-size:14px;
        border-radius:6px;
        cursor:pointer;
        font-weight:600;
        transition:0.2s;
    }

    .logout-btn:hover {
        background:#8e0000;
    }
</style>
