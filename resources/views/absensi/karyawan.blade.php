<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Absensi</title>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>

/* ===== GLOBAL ===== */
body {
    font-family: 'Inter', sans-serif;
    background:#f0f3f4;
    margin:0;
    padding:0;
}

/* ===== NAVBAR ===== */
.navbar {
    background:#00695c;
    padding:14px 22px;
    color:white;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.navbar-left {
    font-size:20px;
    font-weight:600;
}

/* Menu desktop */
.navbar-menu {
    display:flex;
    align-items:center;
    gap:20px;
}

/* Hamburger (HP Only) */
.hamburger {
    display:none;
    font-size:26px;
    cursor:pointer;
}

/* USER DROPDOWN AREA */
.user-area {
    position: relative;
    display:inline-block;
}

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

.user-trigger:hover {
    background: rgba(255,255,255,0.25);
}

.dropdown-icon {
    font-size: 13px;
}

/* DROPDOWN BOX */
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

/* LOGOUT ITEM */
.logout-item {
    width: 100%;
    background: none;
    border: none;
    text-align: left;
    padding: 10px 15px;
    display: flex;
    align-items: center;
    gap: 10px;
    color: #c62828;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
}

.logout-item:hover {
    background: #fdecea;
}

/* Mobile menu */
.mobile-menu {
    background:#00695c;
    color:white;
    display:none;
    flex-direction:column;
    padding:12px 20px;
}
.mobile-menu .user-trigger {
    background: rgba(255,255,255,0.18);
}

/* ===== CARD ===== */
.card {
    background:white;
    padding:28px;
    border-radius:14px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
    max-width:850px;
    margin:35px auto;
}

/* ===== BACK BUTTON ===== */
.back-btn {
    background:#546e7a;
    padding:8px 14px;
    border-radius:6px;
    color:white;
    text-decoration:none;
    font-weight:600;
}
.back-btn:hover {
    background:#455a64;
}

/* ===== HEADERS ===== */
h3 {
    color:#00695c;
    margin-bottom:15px;
}
h4 {
    margin-top:22px;
    margin-bottom:10px;
    color:#00796b;
    font-size:18px;
}

/* ===== BUTTONS ===== */
button {
    padding:12px 20px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-weight:600;
    color:white;
    transition:0.25s;
}

.btn-masuk { background:#2e7d32; }
.btn-masuk:hover { background:#1b5e20; }

.btn-keluar { background:#ef6c00; }
.btn-keluar:hover { background:#d84300; }

/* ===== ALERT ===== */
.alert {
    padding:14px;
    border-radius:8px;
    margin-bottom:15px;
    font-size:14px;
}
.alert-success { background:#c8e6c9; color:#2e7d32; }
.alert-error { background:#ffcdd2; color:#c62828; }

/* ===== TABLE WRAPPER (SCROLLABLE ON MOBILE) ===== */
.table-wrapper {
    overflow-x:auto;
}

/* ===== TABLE ===== */
table {
    width:100%;
    border-collapse:collapse;
}

td, th {
    word-wrap: break-word;
}

th {
    background:#d8f3dc;
    padding:14px;
    font-size:14px;
    color:#004d40;
    border-bottom:2px solid #cfe8d8;
    text-align:left;
}

td {
    padding:14px;
    border-bottom:1px solid #e0e0e0;
    background:white;
}

tr:nth-child(even) td {
    background:#f9fbfa;
}

/* ===== BADGES ===== */
.badge {
    padding:6px 14px;
    border-radius:20px;
    font-size:13px;
    font-weight:600;
}
.hadir { background:#c8e6c9; color:#1b5e20; }
.terlambat { background:#ffe082; color:#8d6e63; }

.badge-wait { background:#fff3cd; color:#8a6d3b; }
.badge-ok { background:#c8e6c9; color:#256029; }
.badge-no { background:#ffcdd2; color:#c62828; }

/* RESPONSIVE */
@media(max-width:820px){
    .navbar-menu { display:none; }
    .hamburger { display:block; }

    .card {
        margin:20px;
        padding:22px;
    }

    button {
        width:100%;
        font-size:16px;
    }
}

</style>

</head>
<body>

<!-- NAVBAR -->
<div class="navbar">

    <div class="navbar-left">Kedai Kambojda</div>

    <!-- HAMBURGER FOR MOBILE -->
    <i class="fa-solid fa-bars hamburger" onclick="toggleMobileMenu()"></i>

    <!-- DESKTOP MENU -->
    <div class="navbar-menu">
        <div class="user-area">
            <div class="user-trigger" onclick="toggleUserDropdown()">
                <i class="fa-regular fa-user"></i>
                <span>{{ Auth::user()->nama_lengkap }}</span>
                <i class="fa-solid fa-caret-down dropdown-icon"></i>
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

<!-- MOBILE MENU -->
<div class="mobile-menu" id="mobileMenu">

    <!-- USER DROPDOWN MOBILE -->
    <div class="user-area" style="margin-bottom:8px;">
        <div class="user-trigger" onclick="toggleUserDropdownMobile()">
            <i class="fa-regular fa-user"></i>
            <span>{{ Auth::user()->nama_lengkap }}</span>
            <i class="fa-solid fa-caret-down dropdown-icon"></i>
        </div>

        <div class="user-dropdown" id="dropdownKasirMobile">
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

<script>

function toggleUserDropdown() {
    const menu = document.getElementById("dropdownKasir");
    menu.style.display = menu.style.display === "block" ? "none" : "block";
}

function toggleUserDropdownMobile() {
    const menu = document.getElementById("dropdownKasirMobile");
    menu.style.display = menu.style.display === "block" ? "none" : "block";
}

function toggleMobileMenu() {
    const menu = document.getElementById("mobileMenu");
    menu.style.display = menu.style.display === "flex" ? "none" : "flex";
}

document.addEventListener("click", function(e){
    const userArea = document.querySelector(".user-area");
    const dropdown = document.getElementById("dropdownKasir");

    if (!userArea.contains(e.target)) {
        dropdown.style.display = "none";
    }
});
</script>


<!-- CONTENT -->
<div class="card">

    <a class="back-btn" href="{{ url()->previous() }}">← Kembali</a>

    <h3>Absensi</h3>
    <p>Tekan tombol di bawah untuk melakukan absensi.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <!-- TOMBOL ABSENSI -->
    <div style="display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap;">
        @if(!$absen)
        <form method="POST" action="{{ route('absen.masuk') }}">@csrf
            <button class="btn-masuk">Absen Masuk</button>
        </form>
        @else
            @if(!$absen->jam_keluar)
                <form method="POST" action="{{ route('absen.keluar') }}">@csrf
                    <button class="btn-keluar">Absen Keluar</button>
                </form>
            @endif
        @endif
    </div>

    <h4>Absensi Hari Ini</h4>

    <!-- TABLE WRAPPER -->
    <div class="table-wrapper">
        <table>
            <tr>
                <th>Nama</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Status</th>
                <th>Verifikasi</th>
            </tr>

            @if($absen)
            <tr>
                <td>{{ Auth::user()->nama_lengkap }}</td>
                <td>{{ $absen->jam_masuk }}</td>
                <td>{{ $absen->jam_keluar ?? '-' }}</td>
                <td>
                    <span class="badge {{ strtolower($absen->status) }}">
                        {{ $absen->status }}
                    </span>
                </td>
                <td>
                    @if($absen->verifikasi_owner == 'Belum Diverifikasi')
                        <span class="badge badge-wait">Menunggu</span>
                    @elseif($absen->verifikasi_owner == 'Diverifikasi')
                        <span class="badge badge-ok">Diverifikasi</span>
                    @else
                        <span class="badge badge-no">Ditolak</span>
                    @endif
                </td>
            </tr>
            @else
            <tr>
                <td colspan="5" style="text-align:center; color:#666;">Belum ada absensi hari ini</td>
            </tr>
            @endif
        </table>
    </div>

</div>

</body>
</html>
