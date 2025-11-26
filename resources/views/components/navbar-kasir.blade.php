<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
/* NAVBAR WRAPPER */
.navbar {
    background:#00695c;
    padding:14px 22px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:white;
    position: relative;
}

/* LOGO */
.navbar-left {
    font-size:20px;
    font-weight:600;
}

/* MENU GROUP */
.navbar-menu {
    display:flex;
    align-items:center;
    gap:20px;
}

/* MENU ITEMS */
.navbar-menu a {
    color:white;
    text-decoration:none;
    font-weight:500;
    transition:0.2s;
}
.navbar-menu a:hover { opacity:0.8; }

/* USER AREA */
.user-area {
    position: relative;
}

/* USER BUTTON */
.user-trigger {
    background: rgba(255,255,255,0.15);
    padding: 8px 14px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    color: white;
    font-size: 14px;
    font-weight: 600;
    transition: 0.2s;
}
.user-trigger:hover { background: rgba(255,255,255,0.25); }

/* DROPDOWN USER */
.user-dropdown {
    position: absolute;
    right: 0;
    top: 45px;
    background: white;
    width: 150px;
    padding: 10px 0;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    display: none;
    z-index: 999;
}

.logout-item {
    width: 100%;
    background: none;
    border: none;
    text-align: left;
    padding: 10px 15px;
    color: #c62828;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    gap: 10px;
}
.logout-item:hover {
    background: #fdecea;
}

/* ======================= */
/* HAMBURGER (HIDDEN PC)   */
/* ======================= */
.hamburger {
    display:none;
    font-size:26px;
    cursor:pointer;
}

/* ======================= */
/* MOBILE NAV MENU         */
/* ======================= */
.mobile-menu {
    background:#00695c;
    color:white;
    display:none;
    flex-direction:column;
    padding:15px 20px;
    gap:12px;
    animation: dropdown 0.25s ease-out;
}

.mobile-menu a {
    color:white;
    text-decoration:none;
    font-size:16px;
    padding:8px 0;
}

@keyframes dropdown {
    from { opacity:0; transform:translateY(-10px); }
    to   { opacity:1; transform:translateY(0); }
}

/* =============================== */
/* RESPONSIVE BREAKPOINT (HP)      */
/* =============================== */
@media(max-width: 820px){
    .navbar-menu {
        display:none;
    }

    .hamburger {
        display:block;
    }

    .mobile-menu {
        display:flex;
    }

    /* Dropdown user reposition for mobile */
    .user-dropdown {
        position:relative;
        top:0;
        box-shadow:none;
        margin-top:8px;
    }
}
</style>


<!-- ===================== -->
<!--   NAVBAR HTML         -->
<!-- ===================== -->

<div class="navbar">

    <div class="navbar-left">
        <a href="{{ url('kasir/beranda') }}">
            <i class="fa-solid fa-mug-hot" style="color:white; font-size:18px;">
            <span class="brand-title">Kedai Kambojda</span></i>
        </a>
    </div>

    <!-- HAMBURGER ICON (HP only) -->
    <i class="fa-solid fa-bars hamburger" onclick="toggleMobileMenu()"></i>

    <!-- DESKTOP MENU -->
    <div class="navbar-menu" id="desktopMenu">

        <a href="{{ route('kasir.beranda') }}">Beranda</a>
        <a href="{{ route('absen.index') }}">Absensi</a>
        <a href="{{ route('absen.riwayat') }}">Riwayat Absensi</a>
        <a href="{{ route('kasir.transaksi') }}">Transaksi</a>
        <a href="{{ route('kasir.riwayat') }}">Riwayat Transaksi</a>

        <!-- USER -->
        <div class="user-area">
            <div class="user-trigger" onclick="toggleUserDropdown()">
                <i class="fa-regular fa-user"></i>
                <span>{{ Auth::user()->nama_lengkap }}</span>
                <i class="fa-solid fa-caret-down"></i>
            </div>

            <div class="user-dropdown" id="dropdownKasir">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-item">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>


<!-- ===================== -->
<!--   MOBILE MENU         -->
<!-- ===================== -->

<div class="mobile-menu" id="mobileMenu" style="display:none;">

    <a href="{{ route('kasir.beranda') }}">Beranda</a>
    <a href="{{ route('absen.index') }}">Absensi</a>
    <a href="{{ route('absen.riwayat') }}">Riwayat Absensi</a>
    <a href="{{ route('kasir.transaksi') }}">Transaksi</a>
    <a href="{{ route('kasir.riwayat') }}">Riwayat Transaksi</a>

    <!-- DROPDOWN USER DI MOBILE -->
    <div style="margin-top:10px;">
        <div class="user-trigger" onclick="toggleUserDropdownMobile()">
            <i class="fa-regular fa-user"></i>
            <span>{{ Auth::user()->nama_lengkap }}</span>
            <i class="fa-solid fa-caret-down"></i>
        </div>

        <div class="user-dropdown" id="dropdownKasirMobile" style="display:none;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout-item">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>

</div>


<!-- ===================== -->
<!--   JAVASCRIPT          -->
<!-- ===================== -->

<script>
function toggleUserDropdown() {
    const menu = document.getElementById("dropdownKasir");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}

function toggleUserDropdownMobile() {
    const menu = document.getElementById("dropdownKasirMobile");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}

function toggleMobileMenu() {
    const menu = document.getElementById("mobileMenu");
    menu.style.display = (menu.style.display === "flex") ? "none" : "flex";
}

document.addEventListener("click", function(e) {
    const userArea = document.querySelector(".user-area");
    const dropdown = document.getElementById("dropdownKasir");

    if (!userArea.contains(e.target)) {
        dropdown.style.display = "none";
    }
});
</script>
