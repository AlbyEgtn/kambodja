<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Kasir</title>

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

    .btn-logout {
        background:#c62828;
        padding:8px 14px;
        border:none;
        border-radius:6px;
        color:white;
        cursor:pointer;
        font-weight:600;
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
</style>

</head>
<body>

{{-- NAVBAR KASIR --}}
<div class="navbar">
    <div class="navbar-left">
        <span>Kedai Kambojda</span>
    </div>

    <div class="navbar-menu">
        <a href="{{ route('absen.index') }}">Absensi</a>
        <a href="{{ route('absen.riwayat') }}">Riwayat Absensi</a>
        <a href="#">Transaksi (coming soon)</a>
        <a href="#">Riwayat Transaksi</a>

        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button class="btn-logout">Logout</button>
        </form>
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
            <th>Status</th>
            <th>Verifikasi Owner</th>
        </tr>

        @if(isset($absen) && $absen)
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

</body>
</html>
