<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<nav class="navbar-karyawan">

    <!-- BRAND / LOGO -->
    <a href="{{ url('/karyawan/dashboard') }}" class="nav-brand">
        <i class="fa-solid fa-mug-hot" style="color:white; font-size:18px;">
        <span class="brand-title">Kedai Kambojda</span></i>
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
    <div class="user-area">
        <div class="user-trigger" onclick="toggleUserDropdown()">
            <i class="fa-solid fa-user"></i>
            <span>{{ Auth::user()->username }}</span>
            <i class="fa-solid fa-chevron-down dropdown-icon"></i>
        </div>

        <div class="user-dropdown" id="dropdownUserKaryawan">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="logout-item">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </div>

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
    .user-trigger .dropdown-icon {
    font-size: 12px;
    color: white !important;
    margin-left: 2px;
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
/* USER DROPDOWN */
    .user-area {
        position: relative;
    }

    .user-trigger {
    display: flex;
    align-items: center;
    gap: 8px;

    background: #0A8273;               /* hijau soft seperti foto */
    padding: 8px 14px;                 /* ukuran lebih pas */
    border-radius: 10px;               /* rounded sama */

    cursor: pointer;
    color: white;
    font-size: 15px;
    font-weight: 600;                  /* tebal seperti foto */
    transition: 0.2s;
    line-height: 1;
}

    .user-trigger i {
        font-size: 16px;                    /* icon user lebih jelas */
    }

    .dropdown-icon {
        font-size: 14px;                    /* icon kecil */
        margin-left: 2px;
        transform: translateY(1px);         /* sejajarkan seperti foto */
    }


        .user-trigger:hover {
            background: rgba(255,255,255,0.25);
        }


    /* BOX DROPDOWN */
    .user-dropdown {
        position: absolute;
        right: 0;
        top: 40px;
        width: 150px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        padding: 10px 0;
        display: none;
        z-index: 999;
    }

    /* Logout item */
    .logout-item {
        width: 100%;
        background: none;
        border: none;
        padding: 10px 15px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        color: #c62828;
        font-weight: 600;
        cursor: pointer;
    }

    .logout-item:hover {
        background: #fdecea;
    }

</style>
<script>
function toggleUserDropdown() {
    const menu = document.getElementById("dropdownUserKaryawan");
    menu.style.display = menu.style.display === "block" ? "none" : "block";
}


document.addEventListener("click", function(e) {
    const area = document.querySelector(".user-area");
    const menu = document.getElementById("dropdownUserKaryawan");

    if (!area.contains(e.target)) {
        menu.style.display = "none";
    }
});
</script>
