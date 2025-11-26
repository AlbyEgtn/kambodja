<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Manajemen Resep</title>

<style>
body { font-family:'Segoe UI',sans-serif; background:#f5f7fa; margin:0; }
.card { background:#fff; padding:25px; border-radius:12px; max-width:1100px; margin:30px auto; box-shadow:0 4px 12px rgba(0,0,0,0.08); }

table { width:100%; border-collapse:collapse; margin-top:20px; }
th,td { padding:12px; border-bottom:1px solid #e0e0e0; }
th { background:#e2f3e7; }

button { padding:10px 16px; border-radius:6px; border:0; cursor:pointer; font-weight:600; }
.btn-add { background:#00695c; color:white; margin-bottom:20px; }
.btn-delete { background:#c62828; color:white; }

input,select { padding:10px; width:95%; border:1px solid #ccc; border-radius:6px; margin-bottom:10px; }

.modal { position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); display:none; justify-content:center; align-items:center; }
.modal-content { background:white; padding:20px; width:400px; border-radius:10px; }
</style>

<script>
function openAddModal() { document.getElementById("addModal").style.display = "flex"; }
function closeModal() { document.getElementById("addModal").style.display = "none"; }
</script>
</head>

<body>

@include('components.navbar')

<div class="card">
    <h2>Manajemen Resep Menu</h2>

    @if(session('success'))
        <div style="background:#c8e6c9; padding:12px; border-radius:6px; margin-bottom:10px;">
            {{ session('success') }}
        </div>
    @endif

    <button class="btn-add" onclick="openAddModal()">+ Tambah Menu</button>

    <table>
        <tr>
            <th>Menu</th>
            <th>Bahan Baku</th>
            <th>Harga</th>
            <th>Kategori</th>
            <th>Aksi</th>
        </tr>

        @foreach($menus as $m)
        <tr>
            <td>{{ $m->nama_menu }}</td>

            <td>
                <ul style="padding-left:18px; margin:0;">
                    @foreach($m->resep as $r)
                    <li>
                        {{ $r->bahan->nama_bahan }}
                        — <strong>{{ $r->jumlah_pakai }} {{ $r->bahan->satuan }}</strong>
                    </li>
                    @endforeach
                </ul>
            </td>

            <td>{{ $m->harga }}</td>
            <td>{{ $m->kategori }}</td>

            <td>
                <button onclick="openEditModal({{ $m->id }})"
                    style="background:#0277bd; color:white; padding:8px 12px; border:none; border-radius:6px;">
                    Edit
                </button>
                <form action="{{ route('menu.destroy', $m->id) }}" 
                    method="POST" onsubmit="return confirm('Hapus menu ini? Semua resep akan dihapus.')">
                    @csrf
                    @method('DELETE')
                    <button style="background:#b71c1c; color:white; padding:8px 12px; border:none; border-radius:6px;">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>


</div>

<!-- Modal Tambah Menu + Resep -->
<div class="modal" id="addModal">
    <div class="modal-content">
        <span onclick="closeModal()" style="float:right; cursor:pointer;">×</span>
        <h3>Buat Menu Baru + Resep</h3>

        <form method="POST" action="{{ route('resep.menu.store') }}">
            @csrf

            <label>Nama Menu</label>
            <input type="text" name="nama_menu" required>

            <label>Harga Menu</label>
            <input type="number" name="harga" required>

            <label>Kategori Menu</label>
            <select name="kategori" required>
                <option value="minuman">Minuman</option>
                <option value="makanan">Makanan</option>
            </select>

            <h4>Bahan Baku</h4>

            <div id="bahanContainer">

                <!-- Baris pertama -->
                <div class="bahan-row" style="display:flex; gap:10px; margin-bottom:10px;">
                    
                    <!-- PILIH BAHAN -->
                    <select name="bahan_id[]" class="bahan-select" onchange="updateSatuan(this)" required>
                        @foreach($bahan as $b)
                        <option value="{{ $b->id }}" data-satuan="{{ $b->satuan }}">
                            {{ $b->nama_bahan }}
                        </option>
                        @endforeach
                    </select>

                    <!-- JUMLAH PAKAI -->
                    <input type="number" name="jumlah_pakai[]" placeholder="Jumlah pakai" step="0.01" required>

                    <!-- SATUAN BAHAN -->
                    <span class="satuan-label" style="min-width:60px; display:flex; align-items:center;">
                        {{ $bahan[0]->satuan ?? '' }}
                    </span>
                </div>

            </div>

            <button type="button" onclick="addRow()" 
                style="background:#0277bd; color:white; margin-top:10px; padding:8px 12px;">
                + Tambah Bahan
            </button>

            <button type="submit" class="btn-add" 
                style="margin-top:20px; background:#00695c; color:white;">
                Simpan Menu
            </button>
        </form>
    </div>
</div>

<!-- Modal Edit Menu -->
<div class="modal" id="editModal">
    <div class="modal-content">
        <span onclick="closeEditModal()" class="close-btn">×</span>
        <h3>Edit Menu & Resep</h3>

        <form method="POST" action="" id="editForm">
            @csrf
            @method('PUT')

            <label>Nama Menu</label>
            <input type="text" id="edit_nama_menu" name="nama_menu" required>

            <label>Harga Menu</label>
            <input type="number" id="edit_harga" name="harga" required>

            <label>Kategori Menu</label>
            <select name="kategori" id="edit_kategori" required>
                <option value="minuman">Minuman</option>
                <option value="makanan">Makanan</option>
            </select>

            <h4>Bahan Baku</h4>

            <div id="editBahanContainer"></div>

            <button type="button" onclick="addEditRow()"
                style="background:#0277bd; color:white; margin-top:10px;">
                + Tambah Bahan
            </button>

            <button type="submit"
                style="margin-top:20px; background:#00695c; color:white; padding:10px; border-radius:6px;">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>

<script>

    function updateSatuan(selectElem) {
        let satuan = selectElem.options[selectElem.selectedIndex].dataset.satuan;
        let label = selectElem.closest('.bahan-row').querySelector('.satuan-label');
        label.textContent = satuan ?? "-";
    }

    function addRow() {
        let container = document.getElementById('bahanContainer');

        let newRow = document.createElement('div');
        newRow.classList.add('bahan-row');
        newRow.style = "display:flex; gap:10px; margin-bottom:10px; align-items:center;";

        newRow.innerHTML = `
            <div style="flex:2;">
                <select name="bahan_id[]" class="bahanSelect" onchange="updateSatuan(this)" required>
                    <option value="">-- pilih bahan --</option>
                    @foreach($bahan as $b)
                    <option value="{{ $b->id }}" data-satuan="{{ $b->satuan }}">
                        {{ $b->nama_bahan }} ({{ $b->satuan }})
                    </option>
                    @endforeach
                </select>
            </div>

            <div style="flex:1;">
                <input type="number" name="jumlah_pakai[]" step="0.01" placeholder="Jumlah" required>
            </div>

            <div style="width:80px;">
                <span class="satuan-label">-</span>
            </div>

            <button type="button" class="btn-remove-row"
                onclick="removeRow(this)"
                style="background:#c62828; color:white; border:none; padding:6px 10px; border-radius:5px;">
                ✖
            </button>
        `;

        container.appendChild(newRow);
    }

    function removeRow(btn) {
        btn.closest('.bahan-row').remove();
    }

    let allBahan = @json($bahan); // bahan baku dari controller

    function openEditModal(menuId) {
        fetch(`/owner/resep/${menuId}/json`)
            .then(res => res.json())
            .then(data => {

                document.getElementById('editForm').action = `/owner/resep/${menuId}`;
                document.getElementById('edit_nama_menu').value = data.menu.nama_menu;
                document.getElementById('edit_harga').value = data.menu.harga;
                document.getElementById('edit_kategori').value = data.menu.kategori;

                let container = document.getElementById('editBahanContainer');
                container.innerHTML = "";

                data.resep.forEach(r => {
                    addEditRow(r.bahan_id, r.jumlah_pakai);
                });

                document.getElementById('editModal').style.display = "flex";
            });
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = "none";
    }

    function addEditRow(bahanId = "", jumlah = "") {
        let container = document.getElementById('editBahanContainer');

        let row = document.createElement("div");
        row.classList.add("bahan-row");
        row.style = "display:flex; gap:10px; margin-bottom:10px; align-items:center;";

        let options = "";
        allBahan.forEach(b => {
            options += `<option value="${b.id}" ${b.id == bahanId ? 'selected' : ''} data-satuan="${b.satuan}">
                            ${b.nama_bahan} (${b.satuan})
                        </option>`;
        });

        row.innerHTML = `
            <select name="edit_bahan_id[]" onchange="updateSatuan(this)" required style="flex:2;">
                <option value="">-- pilih bahan --</option>
                ${options}
            </select>

            <input type="number" name="edit_jumlah_pakai[]" step="0.01" value="${jumlah}" placeholder="Jumlah" required style="flex:1;">

            <div style="width:80px;"><span class="satuan-label">-</span></div>

            <button type="button" onclick="removeRow(this)"
                style="background:#c62828; color:white; border:none; padding:6px 10px; border-radius:5px;">
                ✖
            </button>
        `;

        container.appendChild(row);
    }
</script>


</body>
</html>
