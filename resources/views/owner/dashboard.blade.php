<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Owner</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body { font-family:'Segoe UI',sans-serif; background:#f5f7fa; margin:0; }

.card {
    background:#fff; padding:25px; border-radius:12px;
    max-width:1100px; margin:25px auto;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
}

h2 { color:#00695c; margin-bottom:15px; }
h3 { color:#004d40; }

.grid {
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:15px;
}

.stat {
    padding:20px;
    border-radius:12px;
    background:#e0f2f1;
    text-align:center;
    box-shadow:0 2px 6px rgba(0,0,0,0.08);
}

.stat h4 { margin:0; font-size:16px; color:#004d40; }
.stat p { font-size:20px; font-weight:bold; color:#00695c; }

.alert {
    background:#ffebee;
    color:#c62828;
    padding:12px;
    border-radius:6px;
    margin-bottom:10px;
    border-left:5px solid #b71c1c;
}

table {
    width:100%; border-collapse:collapse; margin-top:10px;
}

th, td {
    padding:12px; border-bottom:1px solid #ddd;
}

th { background:#e0f2f1; text-align:left; }

/* RESPONSIVE */
@media (max-width: 768px) {
    .card { padding:18px; margin:15px; }
    h2 { font-size:20px; text-align:center; }
    .grid { grid-template-columns:1fr; gap:12px; }
    table { font-size:14px; }
    th, td { padding:8px; }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

@include('components.navbar')

<div class="card">
    <h2>Dashboard Owner</h2>

    <!-- RINGKASAN -->
    <div class="grid">
        <div class="stat">
            <h4>Total Akun Pengguna</h4>
            <p>{{ $totalUser }}</p>
        </div>

        <div class="stat">
            <h4>Total Karyawan</h4>
            <p>{{ $totalKaryawan }}</p>
        </div>

        <div class="stat">
            <h4>Total Bahan Baku</h4>
            <p>{{ $totalBahan }}</p>
        </div>

        <div class="stat" style="background:#e3f2fd;">
            <h4>Bahan Hampir Habis</h4>
            <p>{{ $bahanHabis->count() }}</p>
        </div>
    </div>

    <br><hr><br>

    <!-- GRAFIK -->
    <div class="chart-grid" style="
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 25px;
        margin-bottom: 40px;
    ">
        <!-- card grafik pendapatan -->
        <div class="chart-card" style="
            background:white;
            padding:25px;
            border-radius:16px;
            box-shadow:0 4px 12px rgba(0,0,0,0.08);
        ">
            <h3 style="margin-bottom:15px;">Grafik Pendapatan</h3>

            <form method="GET" style="margin-bottom:20px;">
                <label>Dari:</label>
                <input type="date" name="from" value="{{ request('from') }}">

                <label style="margin-left:10px;">Sampai:</label>
                <input type="date" name="to" value="{{ request('to') }}">

                <button type="submit" style="
                    background:#00695c;
                    color:white;
                    padding:6px 12px;
                    border:none;
                    border-radius:8px;
                    cursor:pointer;
                ">Filter</button>
            </form>

            <canvas id="chartPendapatan" height="100"></canvas>
        </div>

        <!-- card metode pembayaran -->
        <div class="chart-card" style="
            background:white;
            padding:25px;
            border-radius:16px;
            box-shadow:0 4px 12px rgba(0,0,0,0.08);
        ">
            <h3 style="margin-bottom:15px;">Metode Pembayaran</h3>
            <canvas id="chartMetode" height="230"></canvas>
        </div>
    </div>

        
    <!-- BAHAN HAMPIR HABIS -->
    <h3>Bahan Baku Hampir Habis</h3>
    <p>Ditampilkan otomatis berdasarkan satuan dan stok minimal.</p>

    @if($bahanHabis->count() == 0)
        <div class="alert" style="background:#c8e6c9; color:#1b5e20; border-left-color:#2e7d32;">
            Semua stok aman ✔
        </div>
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
                <td style="color: #b71c1c">
                    @if($b->stok == 0)
                        <span class="badge badge-no">Stok Habis</span>

                    @elseif($b->satuan == 'pcs' && $b->stok <= 10)
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

    <!-- RIWAYAT TRANSAKSI -->
    <h3>Riwayat Transaksi Terbaru</h3>

    <table>
        <thead>
            <tr>
                <th>No Transaksi</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Metode</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayat as $r)
            <tr>
                <td>{{ $r->no_transaksi }}</td>
                <td>{{ $r->tanggal }}</td>
                <td>Rp{{ number_format($r->total_harga) }}</td>
                <td>{{ strtoupper($r->metode_bayar) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <br><hr><br>

</div>

<script>
// ==== Grafik Pendapatan ====

const tgl = @json($grafik->pluck('tgl'));
const total = @json($grafik->pluck('total'));

new Chart(document.getElementById('chartPendapatan'), {
    type: 'line',
    data: {
        labels: tgl,
        datasets: [{
            label: 'Pendapatan',
            data: total,
            borderColor: '#00695c',
            borderWidth: 3,
            tension: 0.3,
            fill: true,
            backgroundColor: 'rgba(0,105,92,0.2)'
        }]
    },
    options: { responsive: true }
});


// ==== Grafik Metode Pembayaran ====

const metodeLabel = @json($metodePembayaran->pluck('metode_bayar'));
const metodeTotal = @json($metodePembayaran->pluck('total'));

new Chart(document.getElementById('chartMetode'), {
    type: 'doughnut',
    data: {
        labels: metodeLabel,
        datasets: [{
            data: metodeTotal,
            backgroundColor: [
                '#00796b',
                '#4caf50',
                '#ff9800',
                '#9c27b0'
            ]
        }]
    },
});
</script>


</body>
</html>
