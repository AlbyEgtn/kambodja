<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
    
    nav {
    width: 100%;
    background:#00695c;
    padding:12px;
    display:flex;
    justify-content:center;
    gap:25px;
    flex-wrap:wrap;
    }
    
    .topnav {
        width: 97%;
        background: #00695c;
        padding: 14px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0px 4px 12px rgba(0,0,0,0.15);
        position: sticky;
        top: 0;
        z-index: 999;
        font-family: 'Inter', sans-serif;
    }

    .navbar-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .brand-title {
        color: white;
        font-size: 20px;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .nav-menu {
        display: flex;
        align-items: center;
        gap: 25px;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .nav-menu li a {
        color: #d8f8f2;
        text-decoration: none;
        font-size: 15px;
        font-weight: 500;
        padding: 8px 12px;
        border-radius: 6px;
        transition: 0.25s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .nav-menu li a:hover {
        background: rgba(255,255,255,0.12);
        color: white;
    }

    /* ACTIVE STATE */
    .nav-active {
        background: rgba(255,255,255,0.20) !important;
        color: #ffffff !important;
        font-weight: 600;
    }

    .logout-btn {
        background: #d32f2f;
        padding: 8px 15px;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        transition: 0.25s ease;
    }

    .logout-btn:hover {
        background: #b71c1c;
    }
</style>

<nav class="topnav">

    <a href="{{ url('owner/dashboard') }}" class="navbar-left" style="text-decoration:none; display:flex; align-items:center; gap:8px;">
        <i class="fa-solid fa-mug-hot" style="color:white; font-size:22px;"></i>
        <span class="brand-title" style="color:white; font-size:18px; font-weight:600;">Kedai Kambojda</span>
    </a>

    <ul class="nav-menu">
        <li>
            <a href="{{ url('/owner/verifikasi-absensi') }}" 
               class="{{ request()->is('owner/verifikasi-absensi') ? 'nav-active' : '' }}">
                <i class="fa-solid fa-user-check"></i>
                Verifikasi Absensi
            </a>
        </li>

        <li>
            <a href="{{ url('/owner/laporan-statistik') }}"
               class="{{ request()->is('owner/laporan-statistik') ? 'nav-active' : '' }}">
                <i class="fa-solid fa-chart-line"></i>
                Laporan Statistik
            </a>
        </li>

        <li>
            <a href="{{ url('/owner/akun') }}"
               class="{{ request()->is('owner/akun') ? 'nav-active' : '' }}">
                <i class="fa-solid fa-users-gear"></i>
                Manajemen Akun
            </a>
        </li>

        <li>
            <a href="{{ url('/owner/bahan-baku') }}"
               class="{{ request()->is('owner/bahan-baku') ? 'nav-active' : '' }}">
                <i class="fa-solid fa-boxes-stacked"></i>
                Bahan Baku
            </a>
        </li>
        <li>
            <a href="{{ url('/owner/resep') }}"
               class="{{ request()->is('owner/resep') ? 'nav-active' : '' }}">
                <i class="fa-solid fa-boxes-stacked"></i>
                Resep
            </a>
        </li>
    </ul>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="logout-btn">
            <i class="fa-solid fa-right-from-br"></i>
            Logout
        </button>
    </form>

</nav>
