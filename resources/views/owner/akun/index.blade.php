<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Manajemen Akun Pengguna</title>

<style>
/* GLOBAL */
body {
    font-family:'Segoe UI', sans-serif;
    background:#f0f3f4;
    margin:0;
    padding:0;
}

/* CARD (BOX WRAPPER) */
.card {
    background:#fff;
    padding:30px;
    border-radius:14px;
    max-width:1150px;
    margin:35px auto;
    box-shadow:0 4px 16px rgba(0,0,0,0.08);
    border:1px solid #e3e7ea;
}

/* TITLE */
.card h2 {
    color:#00695c;
    margin-bottom:25px;
}

/* BUTTONS */
button {
    padding:11px 18px;
    border-radius:8px;
    border:0;
    cursor:pointer;
    font-weight:600;
    font-size:14px;
    transition:0.25s;
}

.btn-add {
    background:#00695c;
    color:white;
    margin-bottom:18px;
}

.btn-add:hover {
    background:#004d40;
}

.btn-edit {
    background:#0277bd;
    color:white;
}

.btn-edit:hover {
    background:#015a8a;
}

.btn-delete {
    background:#c62828;
    color:white;
}

.btn-delete:hover {
    background:#8e0000;
}

/* TABLE */
table {
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
    overflow:hidden;
    border-radius:10px;
}

th {
    background:#d8f3dc;
    padding:14px;
    text-align:left;
    color:#004d40;
    font-size:14px;
}

td {
    padding:14px;
    border-bottom:1px solid #e0e0e0;
    background:#ffffff;
    font-size:14px;
}

tr:nth-child(even) td {
    background:#f7fbf9;
}

/* SUCCESS BOX */
.alert {
    background:#c8e6c9;
    padding:14px;
    border-radius:8px;
    color:#1b5e20;
    margin-bottom:15px;
    border-left:5px solid #2e7d32;
}

/* ===== MODAL (POPUP) MODERN ===== */

.modal {
    position:fixed;
    top:0; left:0;
    width:100%; height:100%;
    background:rgba(0,0,0,0.45);
    display:none;
    justify-content:center;
    align-items:center;
    padding:20px;
    animation: fadeIn 0.25s ease-in-out;
}

.modal-content {
    background:white;
    width:420px;
    max-width:90%;
    padding:25px;
    border-radius:14px;
    box-shadow:0 8px 32px rgba(0,0,0,0.20);
    animation: popup 0.25s ease-in-out;
    position:relative;
}

@keyframes fadeIn {
    from { opacity:0; }
    to { opacity:1; }
}

@keyframes popup {
    from { transform:scale(0.85); opacity:0; }
    to { transform:scale(1); opacity:1; }
}

/* CLOSE BUTTON */
.close {
    position:absolute;
    top:12px;
    right:16px;
    font-size:22px;
    cursor:pointer;
    color:#666;
    transition:0.2s;
}

.close:hover {
    color:#000;
}

/* INPUT & SELECT */
.modal-content input,
.modal-content select {
    width:95%;
    padding:12px 14px;
    margin-bottom:12px;
    border-radius:8px;
    border:1px solid #cfd8dc;
    font-size:14px;
}

.modal-content label {
    font-size:14px;
    font-weight:600;
    color:#004d40;
}

/* SUBMIT BUTTON */
.modal-content button {
    width:100%;
    padding:12px;
    border-radius:8px;
    font-size:15px;
    font-weight:600;
}

.modal-submit {
    background:#00695c;
    color:white;
}

.modal-submit:hover {
    background:#004d40;
}

.modal-update {
    background:#0277bd;
    color:white;
}

.modal-update:hover {
    background:#015a8a;
}

</style>

<script>
function openAddModal() {
    document.getElementById("addModal").style.display = "flex";
}

function openEditModal(id, nama, username, roleId, status) {
    let modal = document.getElementById("editModal");
    modal.style.display = "flex";

    document.getElementById("edit_id").value = id;
    document.getElementById("edit_nama").value = nama;
    document.getElementById("edit_username").value = username;
    document.getElementById("edit_role").value = roleId;
    document.getElementById("edit_status").value = status;

    // Dynamic update form action
    let form = document.getElementById("editForm");
    form.action = "/owner/akun/" + id;
}

function closeModal() {
    document.getElementById("addModal").style.display = "none";
    document.getElementById("editModal").style.display = "none";
}
</script>

</head>

<body>
@include('components.navbar')

<div class="card">
    <h2>Manajemen Akun Pengguna</h2>

    @if(session('success'))
        <div style="background:#c8e6c9; padding:12px; border-radius:6px; margin-bottom:10px;">
            {{ session('success') }}
        </div>
    @endif

    <button class="btn-add" onclick="openAddModal()">+ Tambah Akun</button>

    <table>
        <tr>
            <th>Nama Lengkap</th>
            <th>Username</th>
            <th>Password</th>
            <th>Role</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        @foreach($users as $u)
        <tr>
            <td>{{ $u->nama_lengkap }}</td>
            <td>{{ $u->username }}</td>
            <td>{{ $u->password }}</td>
            <td>{{ $u->role->nama }}</td>
            <td>{{ $u->status }}</td>
            <td>
                <button class="btn-edit"
                    onclick="openEditModal('{{ $u->id }}','{{ $u->nama_lengkap }}','{{ $u->username }}','{{ $u->role_id }}','{{ $u->status }}')">
                    Edit
                </button>

                <form method="POST" action="{{ route('owner.akun.destroy', $u->id) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn-delete" onclick="return confirm('Hapus akun?')" type="submit">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>

<!-- MODAL TAMBAH -->
<div class="modal" id="addModal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">×</span>
        <h3>Tambah Akun</h3>

        <form method="POST" action="{{ route('owner.akun.store') }}">
            @csrf
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" required>

            <label>Username</label>
            <input type="text" name="username" required>

            <label>Role</label>
            <select name="role_id" required>
                @foreach($roles as $r)
                <option value="{{ $r->id }}">{{ $r->nama }}</option>
                @endforeach
            </select>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit" style="background:#00695c; color:white;">Simpan</button>
        </form>
    </div>
</div>

<!-- MODAL EDIT -->
<div class="modal" id="editModal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">×</span>
        <h3>Edit Akun</h3>

        <form method="POST" action="" id="editForm">
            @csrf
            @method('PUT')

            <input type="hidden" id="edit_id" name="id">

            <label>Nama Lengkap</label>
            <input type="text" id="edit_nama" name="nama_lengkap" required>

            <label>Username</label>
            <input type="text" id="edit_username" name="username" required>

            <label>Role</label>
            <select id="edit_role" name="role_id" required>
                @foreach($roles as $r)
                <option value="{{ $r->id }}">{{ $r->nama }}</option>
                @endforeach
            </select>

            <label>Status</label>
            <select id="edit_status" name="status">
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>

            <label>Password (Opsional)</label>
            <input type="password" name="password" placeholder="Isi jika ingin mengubah">

            <button type="submit" style="background:#0277bd; color:white;">Update</button>
        </form>

        <script>
        document.getElementById("editForm").onsubmit = function() {
            var id = document.getElementById("edit_id").value;
            this.action = "/owner/akun/" + id;
        };
        </script>
    </div>
</div>

</body>
</html>
