<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Statistik</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: #f5f7fa;
    margin: 0;
}

.card {
    background: #fff;
    padding: 25px;
    margin: 25px auto;
    max-width: 1150px;
    border-radius: 14px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

h2 {
    margin-bottom: 8px;
    color: #00695c;
}
h3 {
    margin-top: 20px;
    color: #004d40;
}

.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px,1fr));
    gap: 12px;
    margin-bottom: 22px;
}

input, select {
    width: 100%;
    padding: 10px;
    border: 2px solid #dce4e8;
    border-radius: 8px;
    font-size: 14px;
}

button {
    padding: 10px 15px;
    background: #00695c;
    border: none;
    border-radius: 8px;
    color: #fff;
    cursor: pointer;
    font-weight: 600;
    transition: 0.2s;
}
button:hover {
    background: #004d40;
}

.summary-boxes {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px,1fr));
    gap: 18px;
    margin: 25px 0;
}

.sum-box {
    border-radius: 12px;
    padding: 18px;
    background: #e0f7f1;
    font-weight: 600;
    border-left: 6px solid #009688;
}

.sum-box.blue  { background:#e3f2fd; border-color:#1e88e5; }
.sum-box.green { background:#e8f5e9; border-color:#43a047; }
.sum-box.pink  { background:#fce4ec; border-color:#d81b60; }

.sum-box p { margin: 5px 0 0; font-size: 22px; }

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

th, td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    font-size: 14px;
}

th {
    background: #e0f2f1;
}

.export-btn {
    background:#1e88e5;
    margin-top:10px;
}
.export-btn:hover {
    background:#1565c0;
}
</style>
</head>

<body>

@include('components.navbar')

<div class="card">

    <h2>Laporan Keuangan (Omzet)</h2>
    <p style="color:#444; margin-top:-5px;">
        Sistem ini mencatat transaksi tunai & QRIS, dapat difilter berdasarkan tanggal / bulan.
    </p>

    <!-- FILTER PERIODE -->
    <form method="GET">
        <h3>Filter Periode</h3>

        <div class="filter-grid">
            <div>
                <label><b>Tanggal Harian</b></label>
                <input type="date" name="tanggal" value="{{ $tanggal }}">
            </div>

            <div>
                <label><b>Bulan</b></label>
                <input type="month" name="bulan" value="{{ $bulan }}">
            </div>

            <div>
                <label><b>Metode Pembayaran</b></label>
                <select name="metode">
                    <option value="semua">Semua Metode</option>
                    <option value="tunai"  {{ $metode=='tunai'?'selected':'' }}>Tunai</option>
                    <option value="qris"   {{ $metode=='qris'?'selected':'' }}>QRIS</option>
                </select>
            </div>

            <div style="display:flex; align-items:end;">
                <button type="submit">Tampilkan</button>
            </div>
        </div>
    </form>

    <!-- TOMBOL EXPORT -->
    <a href="{{ route('laporan.statistik.excel', request()->all()) }}">
        <button class="export-btn">Download Excel</button>
    </a>

    <!-- RINGKASAN OMZET -->
    <h3>Ringkasan Omzet</h3>

    <div class="summary-boxes">

        <div class="sum-box">
            Total Pendapatan Hari Ini ({{ now()->format('d M Y') }})
            <p>Rp {{ number_format($totalHarian) }}</p>
        </div>

        <div class="sum-box blue">
            Total Pendapatan Bulan 
            <p style="font-size: 100%;">{{ \Carbon\Carbon::parse($bulan . '-01')->translatedFormat('F Y') }}</p>
            <p>Rp {{ number_format($totalBulanan) }}</p>
        </div>


        <div class="sum-box green">
            Tunai (Cash)
            <p>Rp {{ number_format($totalTunai) }}</p>
        </div>

        <div class="sum-box pink">
            Non Tunai (QRIS)
            <p>Rp {{ number_format($totalNonTunai) }}</p>
        </div>
    </div>


    <!-- DETAIL TRANSAKSI TERBARU -->
    <h3>Detail Transaksi (5 Terbaru Sesuai Filter)</h3>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>No. Transaksi</th>
                <th>Kasir</th>
                <th>Metode</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
            @forelse($transaksi as $t)
            <tr>
                <td>{{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}</td>
                <td>{{ $t->no_transaksi }}</td>
                <td>{{ $t->kasir->nama_lengkap ?? 'Kasir' }}</td>
                <td>{{ strtoupper($t->metode_bayar) }}</td>
                <td>Rp {{ number_format($t->total_harga) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center; color:#999;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>


    <!-- REKAP BULANAN METODE BAYAR -->
    <h3>Rekap Omzet Bulanan per Metode Pembayaran</h3>

    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Metode</th>
                <th>Jumlah Transaksi</th>
                <th>Total Omzet</th>
            </tr>
        </thead>

        <tbody>
            @forelse($rekapBulanan as $r)
            <tr>
                <td>{{ \Carbon\Carbon::parse($r->bulan . '-01')->translatedFormat('F Y') }}</td>
                <td>{{ strtoupper($r->metode_bayar) }}</td>
                <td>{{ $r->jumlah }}</td>
                <td>Rp {{ number_format($r->total) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center; color:#999;">Belum ada data transaksi</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

</body>
</html>
