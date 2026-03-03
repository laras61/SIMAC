<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - SIMAC</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'Poppins', sans-serif; background: #fff7ed; color: #431407; }
        .wrap { width: min(1100px, calc(100% - 28px)); margin: 18px auto 32px; }
        .stack { display: grid; gap: 12px; }
        .panel { background: #fff; border: 1px solid #fed7aa; border-top: 3px solid #f97316; border-radius: 12px; padding: 14px; box-shadow: 0 12px 26px rgba(194,65,12,.08); overflow-x: auto; }
        h1 { margin: 0 0 4px; font-size: 24px; color: #9a3412; }
        .sub { margin: 0 0 14px; color: #c2410c; font-size: 13px; }
        .alert { padding: 10px 12px; border-radius: 10px; font-size: 13px; margin-bottom: 10px; }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .form-grid { display: grid; grid-template-columns: repeat(4, minmax(170px, 1fr)); gap: 10px; }
        .field { display: grid; gap: 4px; min-width: 0; }
        .field label { font-size: 12px; color: #9a3412; font-weight: 600; }
        .field input, .field select {
            width: 100%;
            max-width: 100%;
            border: 1px solid #fdba74;
            border-radius: 8px;
            padding: 8px 10px;
            font-family: inherit;
            font-size: 13px;
            color: #431407;
            background: #fff;
        }
        .field input:focus, .field select:focus { outline: 2px solid #fdba74; outline-offset: 1px; }
        .actions { margin-top: 10px; display: flex; gap: 8px; flex-wrap: wrap; }
        .btn {
            border: 0;
            border-radius: 8px;
            padding: 8px 12px;
            font-family: inherit;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn-primary { background: #ea580c; color: #fff; }
        .btn-warning { background: #f59e0b; color: #fff; }
        .btn-danger { background: #dc2626; color: #fff; }
        .btn-soft { background: #fff7ed; color: #9a3412; border: 1px solid #fdba74; }
        .btn-close { background: #fff; color: #9a3412; border: 1px solid #fdba74; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th, td { text-align: left; padding: 8px 6px; border-bottom: 1px solid #ffedd5; white-space: nowrap; }
        th { color: #9a3412; background: #fff7ed; }
        .row-actions { display: flex; gap: 6px; }
        .row-actions form { margin: 0; }
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(67, 20, 7, 0.35);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
            z-index: 100;
        }
        .modal.open { display: flex; }
        .modal-card {
            width: min(950px, 100%);
            max-height: calc(100vh - 32px);
            overflow-y: auto;
            overflow-x: hidden;
            background: #fff;
            border: 1px solid #fed7aa;
            border-top: 3px solid #f97316;
            border-radius: 12px;
            padding: 14px;
            box-shadow: 0 12px 26px rgba(194,65,12,.18);
        }
        .modal-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 8px;
        }
        .modal-head h2 {
            margin: 0;
            font-size: 18px;
            color: #9a3412;
        }
        .modal .form-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        @media (max-width: 900px) { .form-grid { grid-template-columns: repeat(2, minmax(170px, 1fr)); } }
        @media (max-width: 900px) { .modal .form-grid { grid-template-columns: 1fr; } }
        @media (max-width: 560px) { .form-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    @include('partials.nav')
    <div class="wrap">
        <div class="stack">
            <div class="panel">
                <h1>Menu User</h1>
                <p class="sub">{{ $editItem ? 'Edit data user' : 'Kelola data user' }}</p>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-error">{{ session('error') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-error">{{ $errors->first() }}</div>
                @endif

                @php
                    $roleOptions = ['admin', 'teknisi', 'staff'];
                @endphp

                @if ($editItem)
                    <form method="POST" action="{{ route('user.update', $editItem->id_user) }}">
                        @csrf
                        @method('PATCH')

                        <div class="form-grid">
                            <div class="field">
                                <label for="nama">Nama</label>
                                <input id="nama" type="text" name="nama" value="{{ old('nama', $editItem->nama) }}" required>
                            </div>
                            <div class="field">
                                <label for="email">Email</label>
                                <input id="email" type="email" name="email" value="{{ old('email', $editItem->email) }}" required>
                            </div>
                            <div class="field">
                                <label for="no_hp">No HP</label>
                                <input id="no_hp" type="text" name="no_hp" value="{{ old('no_hp', $editItem->no_hp) }}">
                            </div>
                            <div class="field">
                                <label for="role">Role</label>
                                @php
                                    $selectedRole = old('role', $editItem->role);
                                @endphp
                                <select id="role" name="role" required>
                                    @foreach ($roleOptions as $role)
                                        <option value="{{ $role }}" {{ $selectedRole === $role ? 'selected' : '' }}>{{ $role }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field">
                                <label for="password">Password (opsional)</label>
                                <input id="password" type="password" name="password" placeholder="Kosongkan jika tidak diubah">
                            </div>
                        </div>

                        <div class="actions">
                            <button type="submit" class="btn btn-warning">Update Data</button>
                            <a href="{{ route('user.index') }}" class="btn btn-soft">Batal Edit</a>
                        </div>
                    </form>
                @else
                    <div class="actions">
                        <button type="button" class="btn btn-primary" onclick="openTambahModal()">Tambah User</button>
                    </div>
                @endif
            </div>

            <div class="panel">
                <h1>Daftar User</h1>
                <p class="sub">Total data: {{ $items->count() }}</p>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $row)
                            <tr>
                                <td>{{ $row->id_user }}</td>
                                <td>{{ $row->nama }}</td>
                                <td>{{ $row->email }}</td>
                                <td>{{ $row->no_hp }}</td>
                                <td>{{ $row->role }}</td>
                                <td>
                                    <div class="row-actions">
                                        <a href="{{ route('user.index', ['edit' => $row->id_user]) }}" class="btn btn-warning">Edit</a>
                                        <form method="POST" action="{{ route('user.destroy', $row->id_user) }}" onsubmit="return confirm('Hapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="tambahUserModal" class="modal {{ ($errors->any() && !$editItem) ? 'open' : '' }}">
        <div class="modal-card">
            <div class="modal-head">
                <h2>Tambah User</h2>
                <button type="button" class="btn btn-close" onclick="closeTambahModal()">Tutup</button>
            </div>

            <form method="POST" action="{{ route('user.insert') }}" id="addUserForm">
                @csrf
                <div class="form-grid">
                    <div class="field">
                        <label for="add_nama">Nama</label>
                        <input id="add_nama" type="text" name="nama" value="{{ old('nama') }}" required>
                    </div>
                    <div class="field">
                        <label for="add_email">Email</label>
                        <input id="add_email" type="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="field">
                        <label for="add_no_hp">No HP</label>
                        <input id="add_no_hp" type="text" name="no_hp" value="{{ old('no_hp') }}">
                    </div>
                    <div class="field">
                        <label for="add_role">Role</label>
                        @php
                            $selectedAddRole = old('role', 'staff');
                        @endphp
                        <select id="add_role" name="role" required>
                            @foreach ($roleOptions as $role)
                                <option value="{{ $role }}" {{ $selectedAddRole === $role ? 'selected' : '' }}>{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label for="add_password">Password</label>
                        <input id="add_password" type="password" name="password" required minlength="8" oninput="validatePassword(this)">
                        <span id="passwordError" style="color: #991b1b; font-size: 11px; display: none;">Password minimal 8 karakter</span>
                    </div>
                </div>
                <div class="actions">
                    <button type="submit" class="btn btn-primary" id="btnSubmitAdd">Simpan</button>
                    <button type="button" class="btn btn-soft" onclick="closeTambahModal()">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openTambahModal() {
            const modal = document.getElementById('tambahUserModal');
            if (modal) modal.classList.add('open');
        }
        function closeTambahModal() {
            const modal = document.getElementById('tambahUserModal');
            if (modal) modal.classList.remove('open');
        }

        function validatePassword(input) {
            const errorSpan = document.getElementById('passwordError');
            const submitBtn = document.getElementById('btnSubmitAdd');
            
            if (input.value.length > 0 && input.value.length < 8) {
                errorSpan.style.display = 'block';
                input.style.borderColor = '#dc2626';
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.5';
                submitBtn.style.cursor = 'not-allowed';
            } else {
                errorSpan.style.display = 'none';
                input.style.borderColor = '#fdba74';
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
                submitBtn.style.cursor = 'pointer';
            }
        }
    </script>
</body>
</html>
