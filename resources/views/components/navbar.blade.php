<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Owner</title>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>

/* ========================================================= */
/*                           NAVBAR                          */
/* ========================================================= */

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

/* BRAND */
.navbar-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.brand-title {
    color: white;
    font-size: 20px;
    font-weight: 600;
}

/* MENU DESKTOP */
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
    transition: 0.25s;
    display: flex;
    align-items: center;
    gap: 8px;
}

.nav-menu li a:hover {
    background: rgba(255,255,255,0.12);
    color: white;
}

.nav-active {
    background: rgba(255,255,255,0.20);
    color: white !important;
    font-weight: 600;
}

/* =========================== */
/*       DROPDOWN USER         */
/* =========================== */

.user-area,
.user-dropdown {
    position: relative;
}

.user-name {
    padding: 6px 12px;          /* lebih kecil */
    background: rgba(255,255,255,0.12);
    border-radius: 6px;
    cursor: pointer;
    color: white;
    display: flex;
    align-items: center;
    gap: 6px;
    font-weight: 500;
    font-size: 14px;            /* kecil & rapi */
    line-height: 1;
    height: 32px;               /* fix tinggi agar pas */
}


.user-name:hover {
    background: rgba(255,255,255,0.25);
}

.dropdown-menu {
    display: none;
    position: absolute;
    top: 48px;
    right: 0;
    min-width: 160px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    padding: 10px 0;
    z-index: 1000;
}

.dropdown-menu.show {
    display: block !important;
}

.logout-btn {
    width: 100%;
    padding: 12px 15px;
    background: none;
    border: none;
    cursor: pointer;
    text-align: left;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 15px;
    color: #c62828;
    font-weight: 600;
}

.logout-btn:hover {
    background: #fdecea;
}

/* ===================== */
/*   HAMBURGER MENU      */
/* ===================== */

.hamburger {
    display: none;
    flex-direction: column;
    gap: 5px;
    cursor: pointer;
}

.hamburger span {
    width: 26px;
    height: 3px;
    background: white;
    border-radius: 3px;
    transition: 0.3s ease;
}

/* Animasi hamburger → X */
.hamburger.active span:nth-child(1) { transform: translateY(8px) rotate(45deg); }
.hamburger.active span:nth-child(2) { opacity: 0; }
.hamburger.active span:nth-child(3) { transform: translateY(-8px) rotate(-45deg); }

/* ===================== */
/*   RESPONSIVE MOBILE   */
/* ===================== */

@media (max-width: 768px) {

    .topnav {
        padding: 12px 18px;
    }

    .navbar-left {
        flex-grow: 1;
    }

    .hamburger {
        display: flex;
        margin-left: auto;
    }

    .nav-menu {
        position: absolute;
        top: 65px;
        left: 0;
        width: 100%;
        background: #00695c;
        flex-direction: column;
        padding: 15px 20px;
        gap: 15px;
        border-radius: 0 0 8px 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);

        display: none;
        opacity: 0;
        transform: translateY(-10px);
        transition: 0.3s;
    }

    .nav-menu.show {
        display: flex;
        opacity: 1;
        transform: translateY(0);
    }

    .nav-menu li a {
        width: 100%;
        padding: 10px 0;
    }
}

</style>
</head>
<body>

<!-- ====================== -->
<!--       NAVBAR           -->
<!-- ====================== -->

<nav class="topnav">

    <!-- BRAND -->
    <a href="{{ url('owner/dashboard') }}" class="navbar-left" style="text-decoration:none;">
        <i class="fa-solid fa-mug-hot" style="color:white; font-size:18px;">
        <span class="brand-title">Kedai Kambojda</i></span>
    </a>

    <!-- HAMBURGER -->
    <div class="hamburger" onclick="toggleMenu()">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <!-- MENU -->
    <ul class="nav-menu">

        <li>
            <a href="{{ url('/owner/verifikasi-absensi') }}" 
                class="{{ request()->is('owner/verifikasi-absensi') ? 'nav-active' : '' }}">
                <i class="fa-solid fa-user-check"></i> Verifikasi Absensi
            </a>
        </li>

        <li>
            <a href="{{ url('/owner/laporan-statistik') }}"
                class="{{ request()->is('owner/laporan-statistik') ? 'nav-active' : '' }}">
                <i class="fa-solid fa-chart-line"></i> Laporan Statistik
            </a>
        </li>

        <li>
            <a href="{{ url('/owner/akun') }}"
                class="{{ request()->is('owner/akun') ? 'nav-active' : '' }}">
                <i class="fa-solid fa-users-gear"></i> Manajemen Akun
            </a>
        </li>

        <li>
            <a href="{{ url('/owner/bahan-baku') }}"
                class="{{ request()->is('owner/bahan-baku') ? 'nav-active' : '' }}">
                <i class="fa-solid fa-boxes-stacked"></i> Bahan Baku
            </a>
        </li>

        <li>
            <a href="{{ url('/owner/resep') }}"
                class="{{ request()->is('owner/resep') ? 'nav-active' : '' }}">
                <i class="fa-solid fa-boxes-stacked"></i> Resep
            </a>
        </li>

        <!-- DROPDOWN USER -->
        <li class="user-dropdown">
            <div class="user-name" onclick="toggleUserDropdown()">
                <i class="fa-solid fa-user"></i>
                {{ Auth::user()->username ?? 'User' }}
                <i class="fa-solid fa-caret-down"></i>
            </div>

            <div class="dropdown-menu" id="dropdownUserMenu">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="logout-btn">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </li>

    </ul>

</nav>



<!-- JAVASCRIPT -->
<script>

function toggleMenu() {
    const menu = document.querySelector('.nav-menu');
    const ham = document.querySelector('.hamburger');

    ham.classList.toggle('active');
    menu.classList.toggle('show');
}

function toggleUserDropdown() {
    const menu = document.getElementById('dropdownUserMenu');
    menu.classList.toggle('show');
}

document.addEventListener('click', function(e) {
    const dropdown = document.querySelector('.user-dropdown');
    const menu = document.getElementById('dropdownUserMenu');

    if (!dropdown.contains(e.target)) {
        menu.classList.remove('show');
    }
});

</script>

</body>
</html>
