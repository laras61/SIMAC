<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang - SIMAC</title>
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
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            color: var(--text);
        }
        .wrap { width: min(1100px, calc(100% - 28px)); margin: 18px auto 32px; }
        .stack { display: grid; gap: 12px; }
        .page-head { padding: 2px 2px 6px; }
        .panel { background: var(--surface); border: 1px solid var(--line); border-top: 3px solid var(--primary); border-radius: 12px; padding: 14px; box-shadow: 0 12px 26px rgba(15,23,42,.06); overflow-x: auto; }
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
        .btn-warning { background: #475569; color: #fff; }
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
            box-shadow: 0 12px 26px rgba(15,23,42,.12);
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
        $lokasiOptions = ['LAB A', 'LAB B', 'LAB C', 'LAB D', 'LAB E', 'LAB F', 'RUANG SEKRE', 'RUANG DOSEN'];
    @endphp
    <div class="wrap">
        <div class="stack">
            <div class="page-head">

                @if ($editItem)
                    <form method="POST" action="{{ route('barang.update', $editItem->id_ac) }}">
                        @csrf
                        @method('PATCH')

                        <div class="form-grid">
                            <div class="field">
                                <label for="kode_bmn">Kode BMN</label>
                                <input id="kode_bmn" type="text" name="kode_bmn" value="{{ old('kode_bmn', $editItem->kode_bmn) }}" required>
                            </div>
                            <div class="field">
                                <label for="merk">Merk</label>
                                <input id="merk" type="text" name="merk" value="{{ old('merk', $editItem->merk) }}" required>
                            </div>
                            <div class="field">
                                <label for="serial_number">Serial Number</label>
                                <input id="serial_number" type="text" name="serial_number" value="{{ old('serial_number', $editItem->serial_number) }}" required>
                            </div>
                            <div class="field">
                                <label for="tipe_ac">Tipe AC</label>
                                <input id="tipe_ac" type="text" name="tipe_ac" value="{{ old('tipe_ac', $editItem->tipe_ac) }}" required>
                            </div>
                            <div class="field">
                                <label for="tgl_beli">Tanggal Beli</label>
                                <input id="tgl_beli" type="date" name="tgl_beli" value="{{ old('tgl_beli', $editItem->tgl_beli) }}" required>
                            </div>
                            <div class="field">
                                <label for="tgl_instalasi">Tanggal Instalasi</label>
                                <input id="tgl_instalasi" type="date" name="tgl_instalasi" value="{{ old('tgl_instalasi', $editItem->tgl_instalasi) }}" required>
                            </div>
                            <div class="field">
                                <label for="lokasi">Lokasi</label>
                                @php
                                    $selectedLokasiEdit = old('lokasi', $editItem->lokasi);
                                @endphp
                                <select id="lokasi" name="lokasi" required>
                                    @foreach ($lokasiOptions as $lokasiOption)
                                        <option value="{{ $lokasiOption }}" {{ $selectedLokasiEdit === $lokasiOption ? 'selected' : '' }}>{{ $lokasiOption }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field">
                                <label for="status">Status</label>
                                @php
                                    $selectedStatus = old('status', $editItem->status);
                                @endphp
                                <select id="status" name="status" required>
                                    <option value="aktif" {{ $selectedStatus === 'aktif' ? 'selected' : '' }}>aktif</option>
                                    <option value="rusak" {{ $selectedStatus === 'rusak' ? 'selected' : '' }}>rusak</option>
                                    <option value="nonaktif" {{ $selectedStatus === 'nonaktif' ? 'selected' : '' }}>nonaktif</option>
                                </select>
                            </div>
                        </div>

                        <div class="actions">
                            <button type="submit" class="btn btn-warning">Update Data</button>
                            <a href="{{ route('barang.index') }}" class="btn btn-soft">Batal Edit</a>
                        </div>
                    </form>
                @endif
            </div>

            <div class="panel">
                <div class="panel-head">
                    <h1>Daftar Barang</h1>
                    <button type="button" class="btn btn-primary" onclick="openTambahModal()">Tambah Barang</button>
                </div>
                <p class="sub">Total data: {{ $items->count() }}</p>
                <form method="GET" action="{{ route('barang.index') }}" class="filter-form" id="barangFilterForm">
                    <div class="field">
                        <label for="q">Pencarian</label>
                        <input id="q" type="text" name="q" value="{{ request('q') }}" placeholder="Kode BMN, merk, serial, tipe, lokasi">
                    </div>
                    <div class="field">
                        <label for="status_filter">Filter Status</label>
                        <select id="status_filter" name="status">
                            <option value="">Semua status</option>
                            <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>aktif</option>
                            <option value="rusak" {{ request('status') === 'rusak' ? 'selected' : '' }}>rusak</option>
                            <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>nonaktif</option>
                        </select>
                    </div>
                </form>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode BMN</th>
                            <th>Merk</th>
                            <th>Serial Number</th>
                            <th>Tipe AC</th>
                            <th>Tanggal Beli</th>
                            <th>Tanggal Instalasi</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->kode_bmn }}</td>
                                <td>{{ $row->merk }}</td>
                                <td>{{ $row->serial_number }}</td>
                                <td>{{ $row->tipe_ac }}</td>
                                <td>{{ $row->tgl_beli }}</td>
                                <td>{{ $row->tgl_instalasi }}</td>
                                <td>{{ $row->lokasi }}</td>
                                <td>{{ $row->status }}</td>
                                <td>
                                    <div class="row-actions">
                                        <a href="{{ route('barang.index', array_merge(request()->only(['q', 'status']), ['edit' => $row->id_ac])) }}" class="btn btn-warning">Edit</a>
                                        <form method="POST" action="{{ route('barang.destroy', $row->id_ac) }}" class="delete-form" data-item="{{ $row->kode_bmn }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="10">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="tambahBarangModal" class="modal {{ ($errors->any() && !$editItem) ? 'open' : '' }}">
        <div class="modal-card">
            <div class="modal-head">
                <h2>Tambah Barang</h2>
                <button type="button" class="btn btn-close" onclick="closeTambahModal()">Tutup</button>
            </div>

            <form method="POST" action="{{ route('barang.insert') }}">
                @csrf
                <div class="form-grid">
                    <div class="field">
                        <label for="add_kode_bmn">Kode BMN</label>
                        <input id="add_kode_bmn" type="text" name="kode_bmn" value="{{ old('kode_bmn') }}" required>
                    </div>
                    <div class="field">
                        <label for="add_merk">Merk</label>
                        <input id="add_merk" type="text" name="merk" value="{{ old('merk') }}" required>
                    </div>
                    <div class="field">
                        <label for="add_serial_number">Serial Number</label>
                        <input id="add_serial_number" type="text" name="serial_number" value="{{ old('serial_number') }}" required>
                    </div>
                    <div class="field">
                        <label for="add_tipe_ac">Tipe AC</label>
                        <input id="add_tipe_ac" type="text" name="tipe_ac" value="{{ old('tipe_ac') }}" required>
                    </div>
                    <div class="field">
                        <label for="add_tgl_beli">Tanggal Beli</label>
                        <input id="add_tgl_beli" type="date" name="tgl_beli" value="{{ old('tgl_beli') }}" required>
                    </div>
                    <div class="field">
                        <label for="add_tgl_instalasi">Tanggal Instalasi</label>
                        <input id="add_tgl_instalasi" type="date" name="tgl_instalasi" value="{{ old('tgl_instalasi') }}" required>
                    </div>
                    <div class="field">
                        <label for="add_lokasi">Lokasi</label>
                        @php
                            $selectedLokasiTambah = old('lokasi', $lokasiOptions[0]);
                        @endphp
                        <select id="add_lokasi" name="lokasi" required>
                            @foreach ($lokasiOptions as $lokasiOption)
                                <option value="{{ $lokasiOption }}" {{ $selectedLokasiTambah === $lokasiOption ? 'selected' : '' }}>{{ $lokasiOption }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label for="add_status">Status</label>
                        @php
                            $statusTambah = old('status', 'aktif');
                        @endphp
                        <select id="add_status" name="status" required>
                            <option value="aktif" {{ $statusTambah === 'aktif' ? 'selected' : '' }}>aktif</option>
                            <option value="rusak" {{ $statusTambah === 'rusak' ? 'selected' : '' }}>rusak</option>
                            <option value="nonaktif" {{ $statusTambah === 'nonaktif' ? 'selected' : '' }}>nonaktif</option>
                        </select>
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
            document.getElementById('tambahBarangModal').classList.add('open');
        }

        function closeTambahModal() {
            document.getElementById('tambahBarangModal').classList.remove('open');
        }

        (function initAutoFilter() {
            const form = document.getElementById('barangFilterForm');
            if (!form) return;

            const searchInput = document.getElementById('q');
            const statusSelect = document.getElementById('status_filter');
            let debounceTimer = null;

            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(function () {
                        form.submit();
                    }, 350);
                });
            }

            if (statusSelect) {
                statusSelect.addEventListener('change', function () {
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

                    const itemCode = form.dataset.item || 'data ini';

                    Swal.fire({
                        ...swalBaseConfig,
                        icon: 'warning',
                        title: 'Hapus Barang?',
                        text: `Data ${itemCode} akan dihapus permanen.`,
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal',
                        cancelButtonColor: '#0f172a'
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


