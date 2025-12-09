<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Riwayat Absensi</title>

<style>
    body { font-family: 'Segoe UI', sans-serif; background:#f5f7fa; margin:0; padding:0; }
    .navbar {
    background:#00695c;
    padding:14px 22px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:white;
}

.navbar-left {
    font-size:20px;
    font-weight:600;
}

.navbar-menu a {
    color:white;
    margin-right:20px;
    text-decoration:none;
    font-weight:500;
}

.navbar-menu a:hover {
    text-decoration:underline;
}

.btn-logout {
    background:#c62828;
    border:none;
    padding:8px 14px;
    border-radius:6px;
    color:white;
    cursor:pointer;
    font-weight:600;
}
/* ====== BACK BUTTON ====== */
.back-btn {
    display:inline-block;
    margin-bottom:15px;
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

    header { background:#004d40; color:#fff; padding:15px; text-align:center; font-size:20px; }
    .container { max-width:1100px; margin:28px auto; padding:0 16px; }
    .card { background:#fff; padding:22px; border-radius:10px; box-shadow:0 4px 12px rgba(0,0,0,0.06); }
    h3 { color:#00695c; margin:0 0 14px 0; }
    .filter { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:12px; align-items:end; }
    input[type="date"], select { padding:8px 10px; border:1px solid #d0d7d9; border-radius:6px; }
    button { padding:9px 14px; background:#00796b; color:#fff; border:0; border-radius:6px; cursor:pointer; }
    table { width:100%; border-collapse:collapse; margin-top:14px; }
    th, td { padding:12px; border-bottom:1px solid #e9eef0; text-align:left; font-size:14px; }
    th { background:#e8f5ef; color:#004d40; }
    tr:nth-child(even) td { background:#fbfdfc; }
    .badge { padding:6px 12px; border-radius:18px; font-weight:600; font-size:13px; }
    .badge-hadir { background:#c8e6c9; color:#1b5e20; }
    .badge-terlambat { background:#ffe082; color:#8d6e63; }
    .badge-wait { background:#fff3cd; color:#8a6d3b; }
    .badge-ok { background:#c8e6c9; color:#256029; }
    .badge-no { background:#ffcdd2; color:#c62828; }
    .empty { text-align:center; padding:24px; color:#666; }
    .pagination { margin-top:12px; display:flex; gap:8px; align-items:center; }
    .page-link { padding:6px 10px; border-radius:6px; background:#fff; border:1px solid #e0e6e6; text-decoration:none; color:#004d40; }
</style>
</head>
<body>

<div class="navbar">
    <div class="navbar-left">Kedai Kambojda</div>
    <div class="navbar-left">Riwayat Absnesi</div>

    <div class="navbar-menu">
        <form style="display:inline;" method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn-logout">Logout</button>
        </form>
    </div>
</div>

<div class="container">
    
  <div class="card">
    <a class="back-btn" href="{{ url()->previous() }}">← Kembali</a>
    <h3>Riwayat Absensi Saya</h3>

    <form method="GET" class="filter" action="{{ route('absen.riwayat') }}">
        <div>
            <label for="from">Dari</label><br>
            <input type="date" id="from" name="from" value="{{ request('from') }}">
        </div>

        <div>
            <label for="to">Sampai</label><br>
            <input type="date" id="to" name="to" value="{{ request('to') }}">
        </div>

        <div>
            <label>&nbsp;</label><br>
            <button type="submit">Filter</button>
        </div>
    </form>

    @if($absensi->count() == 0)
        <div class="empty">Belum ada riwayat absensi.</div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Verifikasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($absensi as $a)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($a->tanggal)->format('Y-m-d') }}</td>
                    <td>{{ $a->jam_masuk ?? '-' }}</td>
                    <td>{{ $a->jam_keluar ?? '-' }}</td>
                    <td>
                        @if($a->verifikasi_owner === 'Belum Diverifikasi')
                            <span class="badge badge-wait">Menunggu</span>
                        @elseif($a->verifikasi_owner === 'Diverifikasi')
                            <span class="badge badge-ok">Diverifikasi</span>
                        @else
                            <span class="badge badge-no">Ditolak</span>
                        @endif
                    </td>
                    <td>{{ $a->catatan ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- pagination --}}
        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:12px;">
            <div style="color:#666">Menampilkan {{ $absensi->firstItem() ?? 0 }} - {{ $absensi->lastItem() ?? 0 }} dari {{ $absensi->total() }} entri</div>
            <div>
                {{ $absensi->appends(request()->query())->links('pagination::simple-default') }}
            </div>
        </div>
    @endif

  </div>
</div>

</body>
</html>
