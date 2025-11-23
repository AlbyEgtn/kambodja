<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Verifikasi Absensi Owner</title>

<style>
/* === GLOBAL === */
body {
    font-family: 'Segoe UI', sans-serif;
    background:#f0f3f4;
    margin:0;
    padding:0;
    color:#333;
}

/* === CONTAINER CARD === */
.card {
    background:#fff;
    padding:30px;
    border-radius:14px;
    box-shadow:0 4px 16px rgba(0,0,0,0.08);
    max-width:1100px;
    margin:35px auto;
    border:1px solid #e3e7ea;
}

h3 {
    color:#00695c;
    margin-bottom:20px;
    font-size:22px;
}

/* === TABLE === */
table {
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
    border-radius:12px;
    overflow:hidden;
}

th {
    background:#d8f3dc;
    padding:14px;
    font-size:14px;
    text-align:left;
    color:#004d40;
}

td {
    padding:14px;
    background:white;
    border-bottom:1px solid #e0e0e0;
    font-size:14px;
}

tr:nth-child(even) td {
    background:#f7fbf9;
}

/* === BADGES === */

.badge {
    padding:6px 14px;
    border-radius:20px;
    font-size:13px;
    font-weight:600;
}

.badge-ok {
    background:#c8e6c9;
    color:#1b5e20;
}

.badge-no {
    background:#ffcdd2;
    color:#c62828;
}

/* === BUTTONS === */

button {
    padding:10px 14px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-weight:600;
    font-size:14px;
    display:flex;
    align-items:center;
    gap:6px;
    transition:0.25s;
}

.btn-ok {
    background:#2e7d32;
    color:white;
}

.btn-ok:hover {
    background:#1b5e20;
}

.btn-no {
    background:#c62828;
    color:white;
}

.btn-no:hover {
    background:#8e0000;
}

/* === FLEX BOX FOR BUTTON GROUP === */
.action-buttons {
    display:flex;
    gap:10px;
}

/* NAVBAR STYLES – KEPT FROM YOUR DESIGN */
header {
    background:#004d40;
    color:#fff;
    padding:13px;
    text-align:center;
    font-size:22px;
    width:100%;
}

nav {
    background:#00695c;
    padding:12px;
    display:flex;
    justify-content:center;
    gap:25px;
}

nav a {
    color:#fff;
    text-decoration:none;
    font-weight:500;
}

nav a:hover {
    text-decoration:underline;
}
</style>

</head>

<body>
@include('components.navbar')
<div class="card">
    <h3>Verifikasi Absensi (Owner)</h3>

    <table>
        <tr>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Verifikasi</th>
        </tr>

        @foreach($data as $a)
        <tr>
            <td>{{ $a->user->nama_lengkap }}</td>
            <td>{{ $a->tanggal }}</td>
            <td>{{ $a->status }}</td>
            <td>

                @if($a->verifikasi_owner === 'Belum Diverifikasi')

                    <div style="display:flex; gap:10px;">
                        <form method="POST" action="/owner/verifikasi-absensi/{{ $a->id }}/approve">@csrf
                            <button class="btn-ok">✔ Verifikasi</button>
                        </form>

                        <form method="POST" action="/owner/verifikasi-absensi/{{ $a->id }}/reject">@csrf
                            <button class="btn-no">✖ Tolak</button>
                        </form>
                    </div>

                @elseif($a->verifikasi_owner === 'Diverifikasi')

                    <span class="badge badge-ok">Diverifikasi ✔</span>

                @elseif($a->verifikasi_owner === 'Ditolak')

                    <span class="badge badge-no">Ditolak ✖</span>

                @endif

            </td>

        </tr>
        @endforeach

    </table>

</div>

</body>
</html>
