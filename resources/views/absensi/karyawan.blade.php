<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Absensi Karyawan</title>

<style>

/* ====== GLOBAL ====== */
body {
    font-family: 'Segoe UI', sans-serif;
    background:#f0f3f4;
    margin:0;
    padding:0;
}

/* ====== CARD ====== */
.card {
    background:#fff; 
    padding:30px; 
    border-radius:14px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
    max-width:850px; 
    margin:40px auto;
    border:1px solid #e3e7ea;
}

/* ====== HEADER STYLE ====== */
h3 {
    color:#00695c; 
    margin-bottom:15px;
    font-size:22px;
}

h4 {
    margin-top:25px;
    margin-bottom:10px;
    font-size:18px;
    color:#00796b;
}

/* ====== BUTTON ====== */
button {
    padding:12px 20px; 
    border:none; 
    border-radius:8px; 
    cursor:pointer;
    font-weight:600; 
    font-size:15px; 
    color:white;
    transition:0.25s;
}

.btn-masuk {
    background:#2e7d32;
}
.btn-masuk:hover {
    background:#1b5e20;
}

.btn-keluar {
    background:#ef6c00;
}
.btn-keluar:hover {
    background:#d84300;
}

/* ====== TABLE ====== */
table {
    width:100%; 
    border-collapse:collapse; 
    margin-top:10px;
    overflow:hidden;
    border-radius:10px;
}

th {
    background:#d8f3dc;
    padding:14px;
    font-size:14px;
    color:#004d40;
    text-align:left;
    border-bottom:2px solid #cfe8d8;
}

td {
    padding:14px;
    border-bottom:1px solid #e0e0e0;
    background:#ffffff;
}

/* Alternating row color */
tr:nth-child(even) td {
    background:#f9fbfa;
}

/* ====== BADGE ====== */
.badge {
    padding:6px 14px; 
    border-radius:20px; 
    font-size:13px; 
    font-weight:600;
}

/* Hadir */
.hadir {
    background:#c8e6c9;
    color:#1b5e20;
}

/* Terlambat */
.terlambat {
    background:#ffe082;
    color:#8d6e63;
}

/* Verifikasi Badges */
.badge-wait {
    background:#fff3cd; 
    color:#8a6d3b;
}

.badge-ok {
    background:#c8e6c9; 
    color:#256029;
}

.badge-no {
    background:#ffcdd2; 
    color:#c62828;
}

/* ====== ALERT ====== */
.alert {
    padding:14px; 
    border-radius:8px; 
    margin-bottom:15px; 
    font-size:14px;
}

.alert-success {
    background:#c8e6c9; 
    color:#2e7d32;
}

.alert-error {
    background:#ffcdd2; 
    color:#c62828;
}

/* ====== RESPONSIVE ====== */
@media (max-width: 600px) {
    .card {
        padding:20px;
        margin:20px;
    }
    button {
        width:100%;
    }
}

</style>

</head>

<body>
@include('components.navbar-karyawan')
<div class="card">

    <h3>Absensi Karyawan</h3>
    <p>Tekan tombol di bawah untuk melakukan absensi.</p>

    <!-- MESSAGE -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <!-- TOMBOL ABSENSI -->
    <div style="display:flex; gap:10px; margin-bottom:20px;">
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

    <table>
        <tr>
            <th>Nama</th>
            <th>Jam Masuk</th>
            <th>Jam Keluar</th>
            <th>Status</th>
            <th>Verifikasi Owner</th>
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
                    <span class="badge" style="background:#fff3cd; color:#8a6d3b;">
                        Menunggu
                    </span>
                @elseif($absen->verifikasi_owner == 'Diverifikasi')
                    <span class="badge" style="background:#c8e6c9; color:#256029;">
                        Diverifikasi
                    </span>
                @else
                    <span class="badge" style="background:#ffcdd2; color:#c62828;">
                        Ditolak
                    </span>
                @endif
            </td>
        </tr>
        @else
        <tr>
            <td colspan="4" style="text-align:center; color:#666;">Belum ada absensi hari ini</td>
        </tr>
        @endif

    </table>
    
</div>

</body>
</html>
