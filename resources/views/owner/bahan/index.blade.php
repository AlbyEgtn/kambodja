<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Bahan Baku</title>

<style>
body { font-family:'Segoe UI',sans-serif; background:#f0f3f4; margin:0; }

.card {
    background:#fff; padding:30px; border-radius:14px;
    max-width:1100px; margin:35px auto;
    box-shadow:0 4px 16px rgba(0,0,0,0.08);
    border:1px solid #e3e7ea;
}

h2 { color:#00695c; margin-bottom:20px; }

button {
    padding:11px 18px; border:0; border-radius:8px;
    cursor:pointer; font-weight:600; font-size:14px;
    transition:0.2s;
}

.btn-add { background:#00695c; color:white; margin-bottom:15px; }
.btn-add:hover { background:#004d40; }

.btn-edit { background:#0277bd; color:white; }
.btn-edit:hover { background:#015a8a; }

.btn-delete { background:#c62828; color:white; }
.btn-delete:hover { background:#900000; }

table { width:100%; border-collapse:collapse; margin-top:10px; }
th { background:#d8f3dc; padding:14px; color:#004d40; }
td { padding:14px; border-bottom:1px solid #e0e0e0; }
tr:nth-child(even) td { background:#f7fbf9; }

.modal {
    position:fixed; top:0; left:0; width:100%; height:100%;
    background:rgba(0,0,0,0.45);
    display:none; justify-content:center; align-items:center;
}

.modal-content {
    background:white; padding:25px; width:420px;
    border-radius:14px; box-shadow:0 8px 28px rgba(0,0,0,0.2);
    animation:show .25s ease-in-out;
}

@keyframes show {
    from { opacity:0; transform:scale(0.9); }
    to { opacity:1; transform:scale(1); }
}

input, select {
    width:95%; padding:12px; border-radius:8px;
    border:1px solid #ccd5d9; margin-bottom:12px;
}
.close {
    float:right; cursor:pointer; font-size:20px; color:#555;
}
</style>

<script>
function openAdd(){ document.getElementById("addModal").style.display = "flex"; }
function openEdit(id,nama,stok,satuan){
    document.getElementById("editModal").style.display = "flex";
    document.getElementById("edit_id").value=id;
    document.getElementById("edit_nama").value=nama;
    document.getElementById("edit_stok").value=stok;
    document.getElementById("edit_satuan").value=satuan;
}
function closeModal(){
    document.getElementById("addModal").style.display="none";
    document.getElementById("editModal").style.display="none";
}
</script>

</head>
<body>

@include('components.navbar')

<div class="card">
    <h2>Kelola Bahan Baku</h2>

    @if(session('success'))
        <div style="background:#c8e6c9; padding:12px; border-radius:8px; margin-bottom:10px;">
            {{ session('success') }}
        </div>
    @endif

    <button class="btn-add" onclick="openAdd()">+ Tambah Bahan</button>

    <table>
        <tr>
            <th>Nama Bahan</th>
            <th>Stok</th>
            <th>Satuan</th>
            <th>Aksi</th>
        </tr>

        @foreach($data as $b)
        <tr>
            <td>{{ $b->nama_bahan }}</td>
            <td>{{ $b->stok }}</td>
            <td>{{ $b->satuan }}</td>
            <td>
                <button class="btn-edit"
                    onclick="openEdit('{{ $b->id }}','{{ $b->nama_bahan }}','{{ $b->stok }}','{{ $b->satuan }}')">
                    Edit
                </button>

                <form action="{{ route('bahan.destroy',$b->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn-delete" onclick="return confirm('Hapus bahan?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach

    </table>
</div>

<!-- Modal Tambah -->
<div class="modal" id="addModal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">×</span>
        <h3>Tambah Bahan Baku</h3>

        <form method="POST" action="{{ route('bahan.store') }}">
            @csrf
            <label>Nama Bahan</label>
            <input type="text" name="nama_bahan" required>

            <label>Stok</label>
            <input type="number" name="stok" required>

            <label>Satuan</label>
            <select name="satuan" required>
                <option>gram</option>
                <option>ml</option>
                <option>pcs</option>
            </select>

            <button class="btn-add" style="width:100%;">Simpan</button>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal" id="editModal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">×</span>
        <h3>Edit Bahan Baku</h3>

        <form method="POST" id="editForm">
            @csrf @method('PUT')

            <input type="hidden" id="edit_id" name="id">

            <label>Nama Bahan</label>
            <input type="text" id="edit_nama" name="nama_bahan" required>

            <label>Stok</label>
            <input type="number" id="edit_stok" name="stok" required>

            <label>Satuan</label>
            <select id="edit_satuan" name="satuan">
                <option>gram</option>
                <option>ml</option>
                <option>pcs</option>
            </select>

            <button class="btn-edit" style="width:100%;">Update</button>
        </form>

        <script>
        document.getElementById("editForm").onsubmit = function(){
            var id = document.getElementById("edit_id").value;
            this.action = "/owner/bahan-baku/" + id;
        }
        </script>
    </div>
</div>

</body>

</html>
