<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perbaikan - SIMAC</title>
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
        $statusOptions = ['baru', 'proses', 'selesai'];
    @endphp
    <div class="wrap">
        <div class="stack">
            <div class="page-head">
                @if ($editItem)
                    <form method="POST" action="{{ route('perbaikan.update', $editItem->id_perbaikan) }}">
                        @csrf
                        @method('PATCH')
                        <div class="form-grid">
                            <div class="field">
                                <label for="id_ac">Aset AC</label>
                                <select id="id_ac" name="id_ac" required>
                                    @foreach ($listBarang as $barang)
                                        <option value="{{ $barang->id_ac }}" {{ (string) old('id_ac', $editItem->id_ac) === (string) $barang->id_ac ? 'selected' : '' }}>{{ $barang->kode_bmn }} - {{ $barang->merk }} ({{ $barang->lokasi }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field">
                                <label for="id_user">Staff</label>
                                <select id="id_user" name="id_user" required>
                                    @foreach ($listTeknisi as $teknisi)
                                        <option value="{{ $teknisi->id_user }}" {{ (string) old('id_user', $editItem->id_user) === (string) $teknisi->id_user ? 'selected' : '' }}>{{ $teknisi->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field">
                                <label for="tanggal_perbaikan">Tanggal Perbaikan</label>
                                <input id="tanggal_perbaikan" type="date" name="tanggal_perbaikan" value="{{ old('tanggal_perbaikan', $editItem->tanggal_perbaikan) }}" required>
                            </div>
                            <div class="field">
                                <label for="jenis_perbaikan">Jenis Perbaikan</label>
                                <input id="jenis_perbaikan" type="text" name="jenis_perbaikan" value="{{ old('jenis_perbaikan', $editItem->jenis_perbaikan) }}" required>
                            </div>
                            <div class="field">
                                <label for="id_vendor">Vendor</label>
                                <select id="id_vendor" name="id_vendor">
                                    <option value="">-</option>
                                    @foreach ($listVendors as $vendor)
                                        <option value="{{ $vendor->id_vendor }}" {{ (string) old('id_vendor', $editItem->id_vendor) === (string) $vendor->id_vendor ? 'selected' : '' }}>{{ $vendor->nama_vendor }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field">
                                <label for="biaya">Biaya</label>
                                <input id="biaya" type="number" name="biaya" value="{{ old('biaya', $editItem->biaya) }}" min="0" step="0.01">
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
                                <label for="deskripsi">Deskripsi</label>
                                <textarea id="deskripsi" name="deskripsi">{{ old('deskripsi', $editItem->deskripsi) }}</textarea>
                            </div>
                        </div>
                        <div class="actions">
                            <button type="submit" class="btn btn-warning">Update Data</button>
                            <a href="{{ route('perbaikan.index') }}" class="btn btn-soft">Batal Edit</a>
                        </div>
                    </form>
                @endif
            </div>

            <div class="panel">
                <div class="panel-head">
                    <h1>Daftar Perbaikan</h1>
                    <button type="button" class="btn btn-primary" onclick="openTambahModal()">Tambah Perbaikan</button>
                </div>
                <p class="sub">Total data: {{ $items->count() }}</p>
                <form method="GET" action="{{ route('perbaikan.index') }}" class="filter-form" id="perbaikanFilterForm">
                    <div class="field">
                        <label for="q">Pencarian</label>
                        <input id="q" type="text" name="q" value="{{ request('q') }}" placeholder="Aset, staff, jenis, deskripsi">
                    </div>
                    <div class="field">
                        <label for="status_filter">Filter Status</label>
                        <select id="status_filter" name="status">
                            <option value="">Semua status</option>
                            @foreach ($statusOptions as $statusOption)
                                <option value="{{ $statusOption }}" {{ request('status') === $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Barang</th>
                            <th>Perbaikan</th>
                            <th>Staff</th>
                            <th>Vendor</th>
                            <th>PIC Vendor</th>
                            <th>Biaya</th>
                            <th>Status</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->tanggal_perbaikan }}</td>
                                <td>{{ optional($row->barang)->kode_bmn ?? '-' }} - {{ optional($row->barang)->merk ?? '-' }}</td>
                                <td>{{ $row->jenis_perbaikan }}</td>
                                <td>{{ optional($row->user)->nama ?? '-' }}</td>
                                <td>{{ optional($row->vendor)->nama_vendor ?? '-' }}</td>
                                <td>{{ optional($row->vendor)->pic_nama ?? '-' }}</td>
                                <td>{{ $row->biaya !== null ? number_format((float) $row->biaya, 0, ',', '.') : '-' }}</td>
                                <td>{{ $row->status ?? '-' }}</td>
                                <td>{{ $row->deskripsi ?: '-' }}</td>
                                <td>
                                    <div class="row-actions">
                                        <a href="{{ route('perbaikan.index', array_merge(request()->only(['q', 'status']), ['edit' => $row->id_perbaikan])) }}" class="btn btn-warning">Edit</a>
                                        <form method="POST" action="{{ route('perbaikan.destroy', $row->id_perbaikan) }}" class="delete-form" data-item="{{ optional($row->barang)->kode_bmn ?? ('ID ' . $row->id_perbaikan) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="11">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="tambahPerbaikanModal" class="modal {{ ($errors->any() && !$editItem) ? 'open' : '' }}">
        <div class="modal-card">
            <div class="modal-head">
                <h2>Tambah Perbaikan</h2>
                <button type="button" class="btn btn-close" onclick="closeTambahModal()">Tutup</button>
            </div>
            <form method="POST" action="{{ route('perbaikan.insert') }}">
                @csrf
                <div class="form-grid">
                    <div class="field">
                        <label for="add_id_ac">Aset AC</label>
                        <select id="add_id_ac" name="id_ac" required>
                            <option value="">Pilih aset</option>
                            @foreach ($listBarang as $barang)
                                <option value="{{ $barang->id_ac }}" {{ (string) old('id_ac') === (string) $barang->id_ac ? 'selected' : '' }}>{{ $barang->kode_bmn }} - {{ $barang->merk }} ({{ $barang->lokasi }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label for="add_id_user">Staff</label>
                        <select id="add_id_user" name="id_user" required>
                            <option value="">Pilih staff</option>
                            @foreach ($listTeknisi as $teknisi)
                                <option value="{{ $teknisi->id_user }}" {{ (string) old('id_user') === (string) $teknisi->id_user ? 'selected' : '' }}>{{ $teknisi->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label for="add_tanggal_perbaikan">Tanggal Perbaikan</label>
                        <input id="add_tanggal_perbaikan" type="date" name="tanggal_perbaikan" value="{{ old('tanggal_perbaikan') }}" required>
                    </div>
                    <div class="field">
                        <label for="add_jenis_perbaikan">Jenis Perbaikan</label>
                        <input id="add_jenis_perbaikan" type="text" name="jenis_perbaikan" value="{{ old('jenis_perbaikan') }}" required>
                    </div>
                    <div class="field">
                        <label for="add_id_vendor">Vendor</label>
                        <select id="add_id_vendor" name="id_vendor">
                            <option value="">-</option>
                            @foreach ($listVendors as $vendor)
                                <option value="{{ $vendor->id_vendor }}" {{ (string) old('id_vendor') === (string) $vendor->id_vendor ? 'selected' : '' }}>{{ $vendor->nama_vendor }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label for="add_biaya">Biaya</label>
                        <input id="add_biaya" type="number" name="biaya" value="{{ old('biaya') }}" min="0" step="0.01">
                    </div>
                    <div class="field">
                        <label for="add_status">Status</label>
                        @php $statusTambah = old('status', 'baru'); @endphp
                        <select id="add_status" name="status" required>
                            @foreach ($statusOptions as $statusOption)
                                <option value="{{ $statusOption }}" {{ $statusTambah === $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field" style="grid-column: 1 / -1;">
                        <label for="add_deskripsi">Deskripsi</label>
                        <textarea id="add_deskripsi" name="deskripsi">{{ old('deskripsi') }}</textarea>
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
            document.getElementById('tambahPerbaikanModal').classList.add('open');
        }

        function closeTambahModal() {
            document.getElementById('tambahPerbaikanModal').classList.remove('open');
        }

        (function initAutoFilter() {
            const form = document.getElementById('perbaikanFilterForm');
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
                        title: 'Hapus Perbaikan?',
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
