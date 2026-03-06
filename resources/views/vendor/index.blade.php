<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor - SIMAC</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f8fafc;
            --surface: #ffffff;
            --text: #1f2937;
            --muted: #0f172a;
            --line: #e2e8f0;
            --primary: #0f766e;
            --primary-dark: #115e59;
            --danger: #b91c1c;
            --cream-soft: #e2e8f0;
        }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'Poppins', sans-serif; background: var(--bg); color: var(--text); }
        .wrap { width: min(1100px, calc(100% - 28px)); margin: 18px auto 32px; }
        .stack { display: grid; gap: 12px; }
        .page-head { padding: 2px 2px 6px; }
        .panel { background: var(--surface); border: 1px solid var(--line); border-top: 3px solid var(--primary); border-radius: 12px; padding: 14px; box-shadow: 0 12px 26px rgba(15,23,42,.06); overflow-x: auto; }
        h1 { margin: 0 0 4px; font-size: 24px; color: var(--primary-dark); }
        .sub { margin: 0 0 14px; color: var(--muted); font-size: 13px; }
        .form-grid { display: grid; grid-template-columns: repeat(4, minmax(170px, 1fr)); gap: 10px; }
        .field { display: grid; gap: 4px; min-width: 0; }
        .field label { font-size: 12px; color: var(--muted); font-weight: 600; }
        .field input, .field select, .field textarea {
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
        .field textarea { resize: vertical; min-height: 92px; }
        .field input:focus, .field select:focus, .field textarea:focus { outline: 2px solid var(--line); outline-offset: 1px; }
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
        .btn-warning { background: #475569; color: #fff; }
        .btn-danger { background: var(--danger); color: #fff; }
        .btn-soft { background: var(--bg); color: var(--muted); border: 1px solid var(--line); }
        .btn-close { background: var(--surface); color: var(--muted); border: 1px solid var(--line); }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th, td { text-align: left; padding: 8px 6px; border-bottom: 1px solid var(--cream-soft); white-space: nowrap; }
        th { color: var(--muted); background: var(--bg); }
        .row-actions { display: flex; gap: 6px; }
        .row-actions form { margin: 0; }
        .panel-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; margin-bottom: 4px; }
        .filter-form { display: grid; grid-template-columns: minmax(220px, 1fr) minmax(160px, 220px); gap: 8px; margin-bottom: 10px; align-items: end; }
        .modal { position: fixed; inset: 0; background: rgba(15, 23, 42, 0.35); display: none; align-items: center; justify-content: center; padding: 16px; z-index: 100; }
        .modal.open { display: flex; }
        .modal-card { width: min(980px, 100%); max-height: calc(100vh - 32px); overflow-y: auto; overflow-x: hidden; background: var(--surface); border: 1px solid var(--line); border-top: 3px solid var(--primary); border-radius: 12px; padding: 14px; box-shadow: 0 12px 26px rgba(15,23,42,.12); }
        .modal-head { display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-bottom: 8px; }
        .modal-head h2 { margin: 0; font-size: 18px; color: var(--primary-dark); }
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
        $layananOptions = ['maintenance', 'perbaikan'];
        $statusOptions = ['aktif', 'nonaktif'];
    @endphp
    <div class="wrap">
        <div class="stack">
            <div class="page-head">
                @if ($editItem)
                    <form method="POST" action="{{ route('vendor.update', $editItem->id_vendor) }}">
                        @csrf
                        @method('PATCH')
                        <div class="form-grid">
                            <div class="field">
                                <label for="nama_vendor">Nama Vendor</label>
                                <input id="nama_vendor" type="text" name="nama_vendor" value="{{ old('nama_vendor', $editItem->nama_vendor) }}" required>
                            </div>
                            <div class="field">
                                <label for="email">Email</label>
                                <input id="email" type="email" name="email" value="{{ old('email', $editItem->email) }}">
                            </div>
                            <div class="field">
                                <label for="no_hp">No HP</label>
                                <input id="no_hp" type="text" name="no_hp" value="{{ old('no_hp', $editItem->no_hp) }}">
                            </div>
                            <div class="field">
                                <label for="id_user">User PIC Internal</label>
                                <select id="id_user" name="id_user">
                                    <option value="">-</option>
                                    @foreach ($listUsers as $user)
                                        <option value="{{ $user->id_user }}" {{ (string) old('id_user', $editItem->id_user) === (string) $user->id_user ? 'selected' : '' }}>{{ $user->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field">
                                <label for="pic_nama">PIC Vendor</label>
                                <input id="pic_nama" type="text" name="pic_nama" value="{{ old('pic_nama', $editItem->pic_nama) }}">
                            </div>
                            <div class="field">
                                <label for="pic_no_hp">No HP PIC</label>
                                <input id="pic_no_hp" type="text" name="pic_no_hp" value="{{ old('pic_no_hp', $editItem->pic_no_hp) }}">
                            </div>
                            <div class="field">
                                <label for="layanan">Layanan</label>
                                @php $layananEdit = old('layanan', $editItem->layanan); @endphp
                                <select id="layanan" name="layanan" required>
                                    @foreach ($layananOptions as $layanan)
                                        <option value="{{ $layanan }}" {{ $layananEdit === $layanan ? 'selected' : '' }}>{{ $layanan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field">
                                <label for="status">Status</label>
                                @php $statusEdit = old('status', $editItem->status); @endphp
                                <select id="status" name="status" required>
                                    @foreach ($statusOptions as $statusOption)
                                        <option value="{{ $statusOption }}" {{ $statusEdit === $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field" style="grid-column: 1 / -1;">
                                <label for="alamat">Alamat</label>
                                <textarea id="alamat" name="alamat">{{ old('alamat', $editItem->alamat) }}</textarea>
                            </div>
                            <div class="field" style="grid-column: 1 / -1;">
                                <label for="catatan">Catatan</label>
                                <textarea id="catatan" name="catatan">{{ old('catatan', $editItem->catatan) }}</textarea>
                            </div>
                        </div>
                        <div class="actions">
                            <button type="submit" class="btn btn-warning">Update Data</button>
                            <a href="{{ route('vendor.index') }}" class="btn btn-soft">Batal Edit</a>
                        </div>
                    </form>
                @endif
            </div>

            <div class="panel">
                <div class="panel-head">
                    <h1>Daftar Vendor</h1>
                    <button type="button" class="btn btn-primary" onclick="openTambahModal()">Tambah Vendor</button>
                </div>
                <p class="sub">Total data: {{ $items->count() }}</p>
                <form method="GET" action="{{ route('vendor.index') }}" class="filter-form" id="vendorFilterForm">
                    <div class="field">
                        <label for="q">Pencarian</label>
                        <input id="q" type="text" name="q" value="{{ request('q') }}" placeholder="Nama vendor, PIC, email, layanan">
                    </div>
                    <div class="field">
                        <label for="status_filter">Filter Status</label>
                        <select id="status_filter" name="status">
                            <option value="">Semua status</option>
            </th>
                            <th>                @foreach ($statusOptions as $statusOption)
                                <option value="{{ $statusOption }}" {{ request('status') === $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Vendor</th>
                            <th>Kontak</th>
                            <th>PIC</th>
                            <th>Layanan</th>
                            <th>Status</th>
                            <th>User Internal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->nama_vendor }}</td>
                                <td>{{ $row->email ?: '-' }} / {{ $row->no_hp ?: '-' }}</td>
                                <td>{{ $row->pic_nama ?: '-' }} / {{ $row->pic_no_hp ?: '-' }}</td>
                                <td>{{ $row->layanan ?: '-' }}</td>
                                <td>{{ $row->status }}</td>
                                <td>{{ optional($row->user)->nama ?: '-' }}</td>
                                <td>
                                    <div class="row-actions">
                                        <a href="{{ route('vendor.index', array_merge(r8quest()->only(['q', 'status']), ['edit' => $row->id_vendor])) }}" class="btn btn-warning">Edit</a>
                                        <form method="POST" action="{{ route('vendor.destroy', $row->id_vendor) }}" class="delete-form" data-item="{{ $row->nama_vendor }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="tambahVendorModal" class="modal {{ ($errors->any() && !$editItem) ? 'open' : '' }}">
        <div class="modal-card">
            <div class="modal-head">
                <h2>Tambah Vendor</h2>
                <button type="button" class="btn btn-close" onclick="closeTambahModal()">Tutup</button>
            </div>
            <form method="POST" action="{{ route('vendor.insert') }}">
                @csrf
                <div class="form-grid">
                    <div class="field">
                        <label for="add_nama_vendor">Nama Vendor</label>
                        <input id="add_nama_vendor" type="text" name="nama_vendor" value="{{ old('nama_vendor') }}" required>
                    </div>
                    <div class="field">
                        <label for="add_email">Email</label>
                        <input id="add_email" type="email" name="email" value="{{ old('email') }}">
                    </div>
                    <div class="field">
                        <label for="add_no_hp">No HP</label>
                        <input id="add_no_hp" type="text" name="no_hp" value="{{ old('no_hp') }}">
                    </div>
                    <div class="field">
                        <label for="add_id_user">User PIC Internal</label>
                        <select id="add_id_user" name="id_user">
                            <option value="">-</option>
                            @foreach ($listUsers as $user)
                                <option value="{{ $user->id_user }}" {{ (string) old('id_user') === (string) $user->id_user ? 'selected' : '' }}>{{ $user->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label for="add_pic_nama">PIC Vendor</label>
                        <input id="add_pic_nama" type="text" name="pic_nama" value="{{ old('pic_nama') }}">
                    </div>
                    <div class="field">
                        <label for="add_pic_no_hp">No HP PIC</label>
                        <input id="add_pic_no_hp" type="text" name="pic_no_hp" value="{{ old('pic_no_hp') }}">
                    </div>
                    <div class="field">
                        <label for="add_layanan">Layanan</label>
                        @php $layananTambah = old('layanan', 'maintenance'); @endphp
                        <select id="add_layanan" name="layanan" required>
                            @foreach ($layananOptions as $layanan)
                                <option value="{{ $layanan }}" {{ $layananTambah === $layanan ? 'selected' : '' }}>{{ $layanan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label for="add_status">Status</label>
                        @php $statusTambah = old('status', 'aktif'); @endphp
                        <select id="add_status" name="status" required>
                            @foreach ($statusOptions as $statusOption)
                                <option value="{{ $statusOption }}" {{ $statusTambah === $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field" style="grid-column: 1 / -1;">
                        <label for="add_alamat">Alamat</label>
                        <textarea id="add_alamat" name="alamat">{{ old('alamat') }}</textarea>
                    </div>
                    <div class="field" style="grid-column: 1 / -1;">
                        <label for="add_catatan">Catatan</label>
                        <textarea id="add_catatan" name="catatan">{{ old('catatan') }}</textarea>
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
        const swalBaseConfig = { confirmButtonColor: '#0f766e' };

        @if (session('success'))
            Swal.fire({ ...swalBaseConfig, icon: 'success', title: 'Berhasil', text: @json(session('success')), timer: 2200, showConfirmButton: false });
        @endif

        @if (session('error'))
            Swal.fire({ ...swalBaseConfig, icon: 'error', title: 'Gagal', text: @json(session('error')) });
        @endif

        @if ($errors->any())
            Swal.fire({ ...swalBaseConfig, icon: 'warning', title: 'Validasi', text: @json($errors->first()) });
        @endif

        function openTambahModal() {
            document.getElementById('tambahVendorModal').classList.add('open');
        }

        function closeTambahModal() {
            document.getElementById('tambahVendorModal').classList.remove('open');
        }

        (function initAutoFilter() {
            const form = document.getElementById('vendorFilterForm');
            if (!form) return;

            const searchInput = document.getElementById('q');
            const statusSelect = document.getElementById('status_filter');
            let debounceTimer = null;

            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(function () { form.submit(); }, 350);
                });
            }

            if (statusSelect) {
                statusSelect.addEventListener('change', function () { form.submit(); });
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
                        title: 'Hapus Vendor?',
                        text: `Data ${itemName} akan dihapus permanen.`,
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal',
                        cancelButtonColor: '#0f172a'
                    }).then(function (result) {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });
        })();
    </script>
</body>
</html>
