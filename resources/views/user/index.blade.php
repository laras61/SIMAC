<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - SIMAC</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f8fafc;
            --surface: #ffffff;
            --text: #1f2937;
            --muted: #64748b;
            --line: #e2e8f0;
            --primary: #0f766e;
            --primary-dark: #0f172a;
            --danger: #b91c1c;
            --cream-soft: #e2e8f0;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            color: var(--text);
        }
        .wrap { width: min(1100px, calc(100% - 28px)); margin: 18px auto 32px; }
        .stack { display: grid; gap: 12px; }
        .page-head { padding: 2px 2px 6px; }
        .panel { background: var(--surface); border: 1px solid var(--line); border-top: 3px solid var(--primary); border-radius: 12px; padding: 14px; box-shadow: 0 4px 10px rgba(15,23,42,.04); overflow-x: auto; }
        h1 { margin: 0 0 4px; font-size: 24px; color: var(--primary-dark); }
        .sub { margin: 0 0 14px; color: var(--muted); font-size: 13px; }
        .form-grid { display: grid; grid-template-columns: repeat(4, minmax(170px, 1fr)); gap: 10px; }
        .field { display: grid; gap: 4px; min-width: 0; }
        .field label { font-size: 12px; color: var(--muted); font-weight: 600; }
        .field input, .field select {
            width: 100%;
            max-width: 100%;
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 8px 10px;
            font-family: inherit;
            font-size: 13px;
            color: var(--text);
            background: var(--surface);
        }
        .field input:focus, .field select:focus { outline: 2px solid var(--line); outline-offset: 1px; }
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
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-warning { background: #d97706; color: #fff; }
        .btn-danger { background: var(--danger); color: #fff; }
        .btn-soft { background: var(--bg); color: var(--muted); border: 1px solid var(--line); }
        .btn-close { background: var(--surface); color: var(--muted); border: 1px solid var(--line); }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th, td { text-align: left; padding: 8px 6px; border-bottom: 1px solid var(--cream-soft); white-space: nowrap; }
        th { color: var(--muted); background: var(--bg); }
        .row-actions { display: flex; gap: 6px; }
        .row-actions form { margin: 0; }
        .panel-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 4px;
        }
        .filter-form {
            display: grid;
            grid-template-columns: minmax(220px, 1fr) minmax(160px, 220px);
            gap: 8px;
            margin-bottom: 10px;
            align-items: end;
        }
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.35);
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
            background: var(--surface);
            border: 1px solid var(--line);
            border-top: 3px solid var(--primary);
            border-radius: 12px;
            padding: 14px;
            box-shadow: 0 14px 28px rgba(15,23,42,.12);
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
            color: var(--primary-dark);
        }
        .modal .form-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        @media (max-width: 900px) { .form-grid { grid-template-columns: repeat(2, minmax(170px, 1fr)); } }
        @media (max-width: 900px) { .modal .form-grid { grid-template-columns: 1fr; } }
        @media (max-width: 760px) { .filter-form { grid-template-columns: 1fr; } }
        @media (max-width: 760px) { .panel-head { flex-direction: column; align-items: stretch; } }
        @media (max-width: 560px) { .form-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    @include('partials.nav')
    @php
        $roleOptions = ['admin', 'staff'];
    @endphp
    <div class="wrap">
        <div class="stack">
            <div class="page-head">
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
                @endif
            </div>

            <div class="panel">
                <div class="panel-head">
                    <h1>Daftar User</h1>
                    <button type="button" class="btn btn-primary" onclick="openTambahModal()">Tambah User</button>
                </div>
                <p class="sub">Total data: {{ $items->count() }}</p>
                <form method="GET" action="{{ route('user.index') }}" class="filter-form" id="userFilterForm">
                    <div class="field">
                        <label for="q">Pencarian</label>
                        <input id="q" type="text" name="q" value="{{ request('q') }}" placeholder="Nama, email, no HP">
                    </div>
                    <div class="field">
                        <label for="role_filter">Filter Role</label>
                        <select id="role_filter" name="role">
                            <option value="">Semua role</option>
                            @foreach ($roleOptions as $role)
                                <option value="{{ $role }}" {{ request('role') === $role ? 'selected' : '' }}>{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
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
                                        <a href="{{ route('user.index', array_merge(request()->only(['q', 'role']), ['edit' => $row->id_user])) }}" class="btn btn-warning">Edit</a>
                                        <form method="POST" action="{{ route('user.destroy', $row->id_user) }}" class="delete-form" data-item="{{ $row->nama }}">
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

            <form method="POST" action="{{ route('user.insert') }}">
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
                        <input id="add_password" type="password" name="password" required>
                    </div>
                </div>
                <div class="actions">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-close" onclick="closeTambahModal()">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const swalBaseConfig = {
            confirmButtonColor: '#0f766e'
        };

        @if (session('success'))
            Swal.fire({
                ...swalBaseConfig,
                icon: 'success',
                title: 'Berhasil',
                text: @json(session('success')),
                timer: 2200,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                ...swalBaseConfig,
                icon: 'error',
                title: 'Gagal',
                text: @json(session('error'))
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                ...swalBaseConfig,
                icon: 'warning',
                title: 'Validasi',
                text: @json($errors->first())
            });
        @endif

        function openTambahModal() {
            document.getElementById('tambahUserModal').classList.add('open');
        }

        function closeTambahModal() {
            document.getElementById('tambahUserModal').classList.remove('open');
        }

        (function initAutoFilter() {
            const form = document.getElementById('userFilterForm');
            if (!form) return;

            const searchInput = document.getElementById('q');
            const roleSelect = document.getElementById('role_filter');
            let debounceTimer = null;

            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(function () {
                        form.submit();
                    }, 350);
                });
            }

            if (roleSelect) {
                roleSelect.addEventListener('change', function () {
                    form.submit();
                });
            }
        })();

        (function initDeleteConfirmation() {
            const forms = document.querySelectorAll('.delete-form');
            if (!forms.length) return;

            forms.forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    const itemName = form.dataset.item || 'data ini';

                    Swal.fire({
                        ...swalBaseConfig,
                        icon: 'warning',
                        title: 'Hapus User?',
                        text: `Data ${itemName} akan dihapus permanen.`,
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal',
                        cancelButtonColor: '#64748b'
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        })();
    </script>
</body>
</html>
