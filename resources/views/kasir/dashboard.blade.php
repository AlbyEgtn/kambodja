<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Kasir</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background:#f5f7fa;
        margin:0;
    }

    /* NAVBAR */
    .navbar {
        background:#00695c;
        color:white;
        padding:14px 20px;
        display:flex;
        justify-content:space-between;
        align-items:center;
    }

    .navbar-left {
        display:flex;
        align-items:center;
        gap:10px;
    }

    .navbar-left span {
        font-size:20px;
        font-weight:600;
    }

    .navbar-menu a {
        color:white;
        text-decoration:none;
        margin-right:20px;
        font-weight:500;
    }

    .navbar-menu a:hover {
        text-decoration:underline;
    }


    /* CARD */
    .card {
        background:#fff;
        max-width:850px;
        margin:25px auto;
        padding:25px;
        border-radius:12px;
        box-shadow:0 3px 10px rgba(0,0,0,0.08);
    }

    h3 { color:#00695c; margin-bottom:10px; }
    table { width:100%; border-collapse:collapse; margin-top:10px; }
    th, td { padding:10px; border:1px solid #e0e0e0; }
    th { background:#e2f3e7; }

    button {
        padding:10px 16px;
        border:none;
        border-radius:6px;
        cursor:pointer;
        color:white;
        font-weight:600;
    }

    .btn-masuk { background:#2e7d32; }
    .btn-keluar { background:#ef6c00; }

    .badge {
        padding:5px 12px;
        border-radius:6px;
        font-size:12px;
        font-weight:bold;
    }

    .hadir { background:#c8e6c9; color:#256029; }
    .terlambat { background:#ffe082; color:#8d6e63; }
    .waiting { background:#fff3cd; color:#8a6d3b; }
    /* =================== */
    /*  USER DROPDOWN KASIR */
    /* =================== */

    .user-area {
        position: relative;
        display: inline-block;
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

    .user-trigger i {
        font-size: 14px;
    }

    .dropdown-icon {
        font-size: 13px;
        transform: translateY(1px);
    }

    /* Dropdown box */
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

    /* Logout item */
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

</style>

</head>
<body>

{{-- NAVBAR KASIR --}}
<div class="navbar">
    <div class="navbar-left">
        <span>Kedai Kambojda</span>
    </div>

    <div class="navbar-menu">
        <a href="{{ route('kasir.beranda') }}">Beranda</a>
        <a href="{{ route('absen.index') }}">Absensi</a>
        <a href="{{ route('absen.riwayat') }}">Riwayat Absensi</a>
        <a href="{{ route('kasir.transaksi') }}">Transaksi</a>
        <a href="#">Riwayat Transaksi</a>

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

<div class="card">
    <h3>Selamat Datang, {{ Auth::user()->nama_lengkap }}!</h3>
    <p>Ini adalah dashboard kasir. Silakan melakukan absensi atau menunggu fitur transaksi selesai dibuat.</p>

    <hr><br>

    <h4>Status Absensi Hari Ini</h4>

    <table>
        <tr>
            <th>Nama</th>
            <th>Jam Masuk</th>
            <th>Jam Keluar</th>
            <th>Verifikasi Owner</th>
        </tr>

        @if(isset($absen) && $absen)
        <tr>
            <td>{{ Auth::user()->nama_lengkap }}</td>
            <td>{{ $absen->jam_masuk }}</td>
            <td>{{ $absen->jam_keluar ?? '-' }}</td>

            <td>
                @if($absen->verifikasi_owner == 'Belum Diverifikasi')
                    <span class="badge waiting">Menunggu</span>
                @elseif($absen->verifikasi_owner == 'Diverifikasi')
                    <span class="badge hadir">Diverifikasi</span>
                @else
                    <span class="badge" style="background:#ffcdd2; color:#c62828;">Ditolak</span>
                @endif
            </td>
        </tr>
        @else
        <tr>
            <td colspan="5" style="text-align:center; color:#666;">Belum absen hari ini</td>
        </tr>
        @endif

    </table>

</div>
<script>
function toggleUserDropdown() {
    const menu = document.getElementById("dropdownKasir");
    menu.style.display = menu.style.display === "block" ? "none" : "block";
}

document.addEventListener("click", function(e) {
    const area = document.querySelector(".user-area");
    const menu = document.getElementById("dropdownKasir");

    if (!area.contains(e.target)) {
        menu.style.display = "none";
    }
});
</script>

</body>
</html>
