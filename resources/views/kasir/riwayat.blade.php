<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Riwayat Transaksi</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body { font-family:'Segoe UI', sans-serif; background:#f5f7fa; margin:0; }

.container {
    max-width:1000px;
    margin:30px auto;
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
}

h3 { color:#00695c; margin-bottom:20px; }

table { width:100%; border-collapse:collapse; }
th, td {
    padding:12px;
    border-bottom:1px solid #ddd;
}
th { background:#e0f2f1; }

.btn-detail {
    background:#00695c;
    color:white;
    padding:8px 12px;
    border-radius:6px;
    cursor:pointer;
    border:none;
}
.btn-detail:hover { background:#004d40; }

/* Modal */
.modal {
    position:fixed;
    left:0; top:0;
    width:100%; height:100%;
    background:rgba(0,0,0,0.5);
    display:none;
    justify-content:center;
    align-items:center;
}
.modal-content {
    background:white;
    padding:20px;
    border-radius:10px;
    width:500px;
}
.close-btn {
    float:right;
    cursor:pointer;
    font-size:20px;
    font-weight:bold;
}
</style>

<script>
function showDetail(dataJson) {
    let data = JSON.parse(dataJson);

    let html = "";
    data.forEach(d => {
        html += `
            <tr>
                <td>${d.menu}</td>
                <td>${d.qty}</td>
                <td>Rp${d.subtotal.toLocaleString()}</td>
            </tr>
        `;
    });

    document.getElementById("detail-body").innerHTML = html;
    document.getElementById("modal").style.display = "flex";
}

function closeModal() {
    document.getElementById("modal").style.display = "none";
}
</script>

</head>

<body>

@include('components.navbar-kasir')

<div class="container">
    <h3>Riwayat Transaksi</h3>

    <table>
        <thead>
            <tr>
                <th>No Transaksi</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Metode</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($transaksi as $t)
                <tr>
                    <td>{{ $t->no_transaksi }}</td>
                    <td>{{ $t->tanggal }}</td>
                    <td>Rp{{ number_format($t->total_harga) }}</td>
                    <td>{{ strtoupper($t->metode_bayar) }}</td>
                    <td>
                        <button class="btn-detail"
                            onclick='showDetail(`@json(
                                $t->detail->map(function($d){
                                    return [
                                        "menu" => $d->menu->nama_menu,
                                        "qty" => $d->qty,
                                        "subtotal" => $d->subtotal
                                    ];
                                })
                            )`)'>
                            Detail
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


<!-- MODAL DETAIL -->
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">×</span>
        <h3>Detail Transaksi</h3>

        <table style="width:100%; margin-top:10px;">
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody id="detail-body"></tbody>
        </table>
    </div>
</div>

</body>
</html>
