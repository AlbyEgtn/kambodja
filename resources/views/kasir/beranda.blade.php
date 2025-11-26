<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Beranda Kasir</title>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>

/* GLOBAL */
body {
    font-family: 'Inter', sans-serif;
    background: #eef2f7;
    margin: 0;
    overflow-x: hidden;
}

/* CARD */
.card {
    background: white;
    padding: 30px;
    border-radius: 18px;
    max-width: 1050px;
    margin: 35px auto;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);

    /* ANIMASI */
    opacity: 0;
    transform: translateY(20px);
    animation: fadeUp 0.7s ease forwards;
}

@keyframes fadeUp {
    to { opacity: 1; transform: translateY(0); }
}

/* TITLES */
h2 {
    font-size: 28px;
    color: #087f5b;
    margin-bottom: 6px;
    font-weight: 700;

    animation: fadeIn 0.6s ease-out forwards;
}
h3 {
    color: #00695c;
    margin-bottom: 12px;
    font-size: 20px;
    font-weight: 600;
    animation: fadeIn 0.6s ease-out forwards;
}

.section-title {
    font-size: 15px;
    margin-bottom: 15px;
    color: #6c757d;
    animation: fadeIn 1s ease-out forwards;
}

@keyframes fadeIn {
    from { opacity: 0 }
    to   { opacity: 1 }
}

/* TABLE */
table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 8px;
    margin-top: 5px;
}

tr {
    opacity: 0;
    animation: tableRow 0.6s ease forwards;
}
tr:nth-child(1) { animation-delay: 0.2s; }
tr:nth-child(2) { animation-delay: 0.3s; }
tr:nth-child(3) { animation-delay: 0.37s; }
tr:nth-child(4) { animation-delay: 0.44s; }
tr:nth-child(5) { animation-delay: 0.51s; }

@keyframes tableRow {
    from { opacity: 0; transform: translateY(6px); }
    to   { opacity: 1; transform: translateY(0); }
}

th {
    background: #d3f9d8;
    padding: 14px;
    font-size: 14px;
    color: #00695c;
    text-align: left;
    border-radius: 10px 10px 0 0;
    font-weight: 700;
}

td {
    background: white;
    padding: 14px;
    border-bottom: 1px solid #e7e7e7;
    border-radius: 0 0 10px 10px;
    transition: 0.2s;
}

/* Hover animasi */
tbody tr:hover td {
    background: #f7fcf8;
    transform: scale(1.01);
}

/* BADGES ANIMATED */
.badge {
    padding: 6px 14px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 700;
    display: inline-block;
    animation: pop 0.4s ease;
}

@keyframes pop {
    0%   { transform: scale(0.6); opacity: 0; }
    70%  { transform: scale(1.15); }
    100% { transform: scale(1); opacity: 1; }
}

.badge-hadir { background:#d3f9d8; color:#2b8a3e; }
.badge-terlambat { background:#ffe8a1; color:#b08900; }
.badge-wait { background:#fff3cd; color:#8a6d3b; }
.badge-ok { background:#c8e6c9; color:#256029; }
.badge-no { background:#ffcdd2; color:#c62828; }

/* ALERT ANIMATED */
.alert-success,
.alert-warning {
    padding: 14px;
    border-radius: 10px;
    margin-bottom: 15px;
    animation: fadeUp 0.5s ease forwards;
    border-left: 5px solid;
}

.alert-success { 
    background: #d3f9d8;
    color: #2b8a3e;
    border-left-color:#2b8a3e;
}
.alert-warning { 
    background:#fff4e6; 
    color:#e67e22; 
    border-left-color:#e67e22; 
}

/* LINK */
.view-all {
    display: inline-block;
    margin-top: 12px;
    color: #087f5b;
    font-weight: 600;
    text-decoration: none;
    transition: 0.2s;
    float: right;
}
.view-all:hover {
    opacity: .5;
    transform: translateX(3px);
}

/* RESPONSIVE */
@media(max-width:768px){
    .card { padding: 22px; margin: 20px; }
    table { font-size: 10px; }
    th, td { padding: 8px; }
    h2 { font-size: 22px; }
    h3 { font-size: 18px; }
}

</style>

</head>
<body>

@include('components.navbar-kasir')

<div class="card">

    <h2>Beranda Kasir</h2>
    <p class="section-title">Informasi penting terkait operasional harian kedai.</p>

    <!-- ============================ -->
    <!--  BAGIAN 1 : Bahan Habis      -->
    <!-- ============================ -->
    <h3>⚠ Bahan Baku Hampir Habis</h3>

    @if($bahanHabis->count() == 0)
        <div class="alert-success">Semua stok aman ✔</div>
    @else

        <table>
            <tr>
                <th>Nama Bahan</th>
                <th>Stok</th>
                <th>Satuan</th>
                <th>Keterangan</th>
            </tr>

            @foreach($bahanHabis as $b)
            <tr>
                <td>{{ $b->nama_bahan }}</td>
                <td>{{ $b->stok }}</td>
                <td>{{ $b->satuan }}</td>
                <td>
                    @if($b->satuan == 'pcs' && $b->stok <= 10)
                        <span class="badge badge-no">Sangat rendah (≤ 10 pcs)</span>
                    @elseif(in_array($b->satuan, ['gram','ml']) && $b->stok <= 500)
                        <span class="badge badge-no">Hampir habis (≤ 500 {{ $b->satuan }})</span>
                    @else
                        <span class="badge badge-terlambat">Stok rendah</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>

    @endif

    <br><hr><br>

    <!-- ============================ -->
    <!--  BAGIAN 2 : Absensi          -->
    <!-- ============================ -->
    <h3>🕒 Riwayat Absensi Terbaru</h3>
    <p class="section-title">Berikut adalah 7 absensi terakhir Anda.</p>

    @if($absensi->count() == 0)

        <div class="alert-warning">Belum ada riwayat absensi.</div>

    @else

        <table>
            <tr>
                <th>Tanggal</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Status</th>
                <th>Verifikasi</th>
            </tr>

            @foreach($absensi as $a)
            <tr>
                <td>{{ $a->tanggal }}</td>
                <td>{{ $a->jam_masuk ?? '-' }}</td>
                <td>{{ $a->jam_keluar ?? '-' }}</td>

                <td>
                    @if(strtoupper($a->status) === 'HADIR')
                        <span class="badge badge-hadir">Hadir</span>
                    @elseif(strtoupper($a->status) === 'TERLAMBAT')
                        <span class="badge badge-terlambat">Terlambat</span>
                    @else
                        <span class="badge">{{ $a->status }}</span>
                    @endif
                </td>

                <td>
                    @if($a->verifikasi_owner == 'Belum Diverifikasi')
                        <span class="badge badge-wait">Menunggu</span>
                    @elseif($a->verifikasi_owner == 'Diverifikasi')
                        <span class="badge badge-ok">Diverifikasi</span>
                    @else
                        <span class="badge badge-no">Ditolak</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>

        <a href="{{ route('absen.riwayat') }}" class="view-all">Lihat Semua Riwayat →</a><br>

    @endif

</div>

</body>
</html>
