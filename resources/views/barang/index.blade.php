<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang - SIMAC</title>
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
                <h1>Menu Barang</h1>
                <p class="sub">
                    {{ $editItem ? 'Edit data barang' : 'Kelola data barang' }}
                </p>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-error">{{ session('error') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-error">
                        {{ $errors->first() }}
                    </div>
                @endif

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
                                <input id="lokasi" type="text" name="lokasi" value="{{ old('lokasi', $editItem->lokasi) }}" required>
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
                @else
                    <div class="actions">
                        <button type="button" class="btn btn-primary" onclick="openTambahModal()">Tambah Barang</button>
                    </div>
                @endif
            </div>

            <div class="panel">
                <h1>Daftar Barang</h1>
                <p class="sub">Total data: {{ $items->count() }}</p>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
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
                                <td>{{ $row->id_ac }}</td>
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
                                        <a href="{{ route('barang.index', ['edit' => $row->id_ac]) }}" class="btn btn-warning">Edit</a>
                                        <form method="POST" action="{{ route('barang.destroy', $row->id_ac) }}" onsubmit="return confirm('Hapus data ini?')">
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
                        <input id="add_lokasi" type="text" name="lokasi" value="{{ old('lokasi') }}" required>
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

    <script>
        function openTambahModal() {
            document.getElementById('tambahBarangModal').classList.add('open');
        }

        function closeTambahModal() {
            document.getElementById('tambahBarangModal').classList.remove('open');
        }
    </script>
</body>
</html>
