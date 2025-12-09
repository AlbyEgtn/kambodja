<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Transaksi Kasir</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
/* GLOBAL STYLE */
body {
    font-family: 'Inter', sans-serif;
    background: #eef2f7;
    margin: 0;
}

/* WRAPPER */
.container {
    max-width: 1050px;
    margin: 30px auto;
    background: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 7px 20px rgba(0,0,0,0.08);
}

/* TITLE */
h3 {
    color: #087f5b;
    margin-bottom: 20px;
    font-size: 26px;
    font-weight: 700;
}

/* MENU GRID MODERN */
.menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 16px;
}

.menu-btn {
    background: #087f5b;
    color: white;
    padding: 20px 15px;
    border-radius: 14px;
    text-align: center;
    cursor: pointer;
    font-weight: 600;
    border: none;
    transition: 0.25s ease-in-out;
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}
.menu-btn:hover {
    background: #066647;
    transform: translateY(-4px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
}
.menu-btn small {
    opacity: 0.9;
}

/* TABLE STYLE */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    border-radius: 10px;
    overflow: hidden;
}

th {
    background: #d3f9d8;
    padding: 14px;
    font-size: 14px;
    color: #087f5b;
    font-weight: 700;
}

td {
    padding: 14px;
    background: white;
    border-bottom: 1px solid #eee;
    font-size: 15px;
}

tr:hover td {
    background: #f7fcf8;
}

/* BUTTON STYLE */
button {
    padding: 11px 15px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.2s;
}

.btn-hapus {
    background: #e03131;
    color: white;
}
.btn-hapus:hover {
    background: #c92a2a;
}

.btn-bayar {
    background: #2f9e44;
    color: white;
    margin-top: 22px;
    width: 100%;
    font-size: 18px;
    border-radius: 10px;
    padding: 14px;
    box-shadow: 0 5px 14px rgba(47,158,68,0.25);
}
.btn-bayar:hover {
    background: #228b3c;
    transform: translateY(-2px);
}

/* TOTAL BAR */
.total-row {
    color: #2f9e44;
    font-size: 20px;
    font-weight: 700;
}

/* INPUT SELECT */
select, input[type="number"] {
    padding: 12px;
    width: 100%;
    border-radius: 10px;
    border: 2px solid #dee2e6;
    margin-top: 5px;
    font-size: 15px;
    transition: 0.2s;
}
select:focus, input[type="number"]:focus {
    border-color: #087f5b;
    outline: none;
    box-shadow: 0 0 6px rgba(8,127,91,0.3);
}
</style>

<!-- GOOGLE FONT -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<script>
let cart = [];
let kembalian = 0;

function addToCart(id, nama, harga) {
    id = parseInt(id);

    let item = cart.find(i => i.id === id);

    if (item) {
        item.qty++;
    } else {
        cart.push({ id, nama, harga: parseInt(harga), qty: 1 });
    }

    renderCart();
}

function hapusItem(id) {
    id = parseInt(id);
    cart = cart.filter(i => i.id !== id);
    renderCart();
}

function renderCart() {
    let tbody = document.getElementById("cart-body");
    tbody.innerHTML = "";

    let subtotal = 0;

    cart.forEach(item => {
        let total = item.harga * item.qty;
        subtotal += total;

        tbody.innerHTML += `
            <tr>
                <td>${item.nama}</td>
                <td>${item.qty}</td>
                <td>Rp${total.toLocaleString()}</td>
                <td><button class="btn-hapus" onclick="hapusItem(${item.id})">Hapus</button></td>
            </tr>
        `;
    });

    document.getElementById("subtotal").innerText = "Rp" + subtotal.toLocaleString();
    document.getElementById("total").innerText = "Rp" + subtotal.toLocaleString();
}

function showUangField() {
    let metode = document.getElementById("metodePembayaran").value;
    let box = document.getElementById("box-uang");
    box.style.display = metode === "tunai" ? "block" : "none";
}

document.addEventListener("DOMContentLoaded", showUangField);

function tutupKonfirmasi() {
    document.getElementById("modalKonfirmasi").style.display = "none";
}

function tutupStruk() {
    document.getElementById("modalStruk").style.display = "none";
}

function cetakStruk() {
    window.print();
}

/* ============================
   FUNGSI BAYAR — HANYA SHOW MODAL
   ============================ */
function bayar() {
    let total = parseInt(document.getElementById("total").innerText.replace(/\D/g, ""));
    let metode = document.getElementById("metodePembayaran").value;

    if (cart.length === 0) {
        alert("Keranjang masih kosong!");
        return;
    }

    document.getElementById("konfirmasiText").innerHTML = `
        Yakin ingin memproses pembayaran?<br><br>
        Metode: <b>${metode.toUpperCase()}</b><br>
        Total: <b>Rp${total.toLocaleString()}</b>
    `;

    document.getElementById("modalKonfirmasi").style.display = "flex";
}

/* ==================================
   FUNGSI PROSES PEMBAYARAN — SUBMIT
   ================================== */
function prosesPembayaran() {
    let total = parseInt(document.getElementById("total").innerText.replace(/\D/g, ""));
    let metode = document.getElementById("metodePembayaran").value;
    let uangPembeli = 0;

    if (metode === "tunai") {
        uangPembeli = parseInt(document.getElementById("uangPembeli").value);
        if (isNaN(uangPembeli) || uangPembeli < total) {
            alert("Nominal uang tidak cukup!");
            return;
        }
        kembalian = uangPembeli - total;
    }

    document.getElementById("cartInput").value    = JSON.stringify(cart);
    document.getElementById("totalInput").value   = total;
    document.getElementById("metodeInput").value  = metode;
    document.getElementById("uangInput").value    = uangPembeli;
    document.getElementById("kembaliInput").value = kembalian;

    // Tutup modal konfirmasi
    document.getElementById("modalKonfirmasi").style.display = "none";

    // Tampilkan modal struk
    document.getElementById("modalStruk").style.display = "flex";

    // kirim form setelah sedikit delay
    setTimeout(() => {
        document.getElementById("formTransaksi").submit();
    }, 800);
}
</script>


</head>

<body>

@include('components.navbar-kasir')

    <div class="container">
        <h3>Transaksi Penjualan</h3>

        <!-- MENU GRID -->
        <div class="menu-grid">
            @foreach($menus as $m)
                <button class="menu-btn"
                    @if(!$m->bisa_dijual)
                        disabled
                        style="background:#c7c7c7; cursor:not-allowed; opacity:0.7;"
                    @else
                        onclick="addToCart('{{ $m->id }}', '{{ $m->nama_menu }}', '{{ $m->harga }}')"
                    @endif
                >
                    {{ $m->nama_menu }}<br>
                    <small>Rp{{ number_format($m->harga) }}</small>

                    @if(!$m->bisa_dijual)
                        <div style="font-size:12px; margin-top:6px; color:#b71c1c;">
                            Stok Tidak Cukup
                        </div>
                    @endif
                </button>
            @endforeach
        </div>

        <h4 style="margin-top:25px; font-size:20px; color:#087f5b;">Keranjang</h4>

        <table>
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="cart-body"></tbody>
        </table>

        <!-- METODE PEMBAYARAN -->
        <div style="margin-top:20px;">
            <label><b>Metode Pembayaran</b></label>
            <select id="metodePembayaran" onchange="showUangField()">
                <option value="tunai">Tunai (Cash)</option>
                <option value="qris">QRIS</option>
            </select>
        </div>

        <!-- INPUT UANG -->
        <div id="box-uang" style="margin-top:15px; display:none;">
            <label><b>Nominal Uang Pembeli</b></label>
            <input id="uangPembeli" type="number" placeholder="Masukkan nominal uang">
        </div>

        <!-- TOTAL -->
        <div style="margin-top:25px; display:flex; justify-content:space-between;">
            <span><b>Subtotal:</b> <span id="subtotal">Rp0</span></span>
            <span class="total-row">Total: <span id="total">Rp0</span></span>
        </div>

        <button class="btn-bayar" onclick="bayar()">Bayar</button>

        <form id="formTransaksi" method="POST" action="{{ route('kasir.transaksi.simpan') }}">
            @csrf
            <input type="hidden" name="cart"        id="cartInput">
            <input type="hidden" name="total"       id="totalInput">
            <input type="hidden" name="metode"      id="metodeInput">
            <input type="hidden" name="uang_pembeli" id="uangInput">
            <input type="hidden" name="kembali"      id="kembaliInput">
        </form>

    </div>
    <div id="modalKonfirmasi" style="
        display:none; position:fixed; inset:0;
        background:rgba(0,0,0,0.6);
        justify-content:center; align-items:center;">
        <div style="
            background:white; padding:20px; width:360px;
            border-radius:12px; text-align:center;">
            
            <h3 style="margin:0; color:#087f5b;">Konfirmasi Pembayaran</h3>
            <p id="konfirmasiText" style="margin-top:10px;"></p>

            <button onclick="prosesPembayaran()" style="
                background:#2f9e44; color:white; padding:10px 15px;
                border:none; border-radius:8px; margin-top:15px;">
                Ya, Bayar
            </button>

            <button onclick="tutupKonfirmasi()" style="
                background:#e03131; color:white; padding:8px 12px;
                border:none; border-radius:8px; margin-top:10px;">
                Batal
            </button>
        </div>
    </div>

    <!-- MODAL CETAK STRUK -->
    <div id="modalStruk" style="
        display:none; position:fixed; inset:0;
        background:rgba(0,0,0,0.6);
        justify-content:center; align-items:center;">
        <div style="
            background:white; padding:20px; width:360px;
            border-radius:12px; text-align:center;">
            
            <h3 style="margin:0; color:#087f5b;">Transaksi Berhasil!</h3>

            <button onclick="cetakStruk()" style="
                background:#1e88e5; color:white; padding:10px 14px;
                border:none; border-radius:8px; margin-top:15px;">
                Cetak Struk
            </button>

            <button onclick="tutupStruk()" style="
                background:#757575; color:white; padding:8px 12px;
                border:none; border-radius:8px; margin-top:10px;">
                Tutup
            </button>
        </div>
    </div>


</body>
</html>
