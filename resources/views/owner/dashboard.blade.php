<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Owner</title>

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
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
}

th, td {
    padding:12px;
    border-bottom:1px solid #ddd;
}

th {
    background:#e0f2f1;
    text-align:left;
}
</style>
</head>

<body>

@include('components.navbar')

<div class="card">
    <h2>Dashboard Owner</h2>

    <!-- Ringkasan -->
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

    <!-- Bahan Hampir Habis -->
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
                <td>
                    @if($b->satuan == 'pcs' && $b->stok <= 10)
                        <span style="color:#c62828;">Stok sangat rendah (pcs &lt;= 10)</span>
                    @elseif(in_array($b->satuan, ['gram','ml']) && $b->stok <= 500)
                        <span style="color:#c62828;">Stok hampir habis (&lt;= 500 {{ $b->satuan }})</span>
                    @else
                        <span style="color:#c62828;">Stok rendah</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    @endif

</div>

</body>
</html>
