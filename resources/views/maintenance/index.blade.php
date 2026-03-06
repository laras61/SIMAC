<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance - SIMAC</title>
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
        .btn-soft { background: var(--bg); color: var(--muted); border: 1px solid var(--line); }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th, td { text-align: left; padding: 8px 6px; border-bottom: 1px solid var(--cream-soft); white-space: nowrap; }
        th { color: var(--muted); background: var(--bg); }
        .row-actions { display: flex; gap: 6px; }
        .row-actions form { margin: 0; }
        .panel-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; margin-bottom: 4px; }
        .filter-form { display: grid; grid-template-columns: minmax(220px, 1fr) minmax(160px, 220px); gap: 8px; margin-bottom: 10px; align-items: end; }
        .badge {
            display: inline-block;
            border-radius: 999px;
            padding: 2px 8px;
            font-size: 11px;
            font-weight: 600;
        }
        .badge.pending { color: #92400e; background: #fef3c7; }
        .badge.proses { color: #1d4ed8; background: #dbeafe; }
        .badge.selesai { color: #166534; background: #dcfce7; }
        @media (max-width: 900px) { .form-grid { grid-template-columns: repeat(2, minmax(170px, 1fr)); } }
        @media (max-width: 760px) { .filter-form { grid-template-columns: 1fr; } }
        @media (max-width: 760px) { .panel-head { flex-direction: column; align-items: stretch; } }
        @media (max-width: 560px) { .form-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    @include('partials.nav')
    @php
        $statusOptions = ['pending', 'proses', 'selesai'];
        $statusUpdateOptions = ['proses', 'selesai'];
    @endphp
    <div class="wrap">
        <div class="stack">
            <div class="page-head">
                @if ($editItem)
                    <form method="POST" action="{{ route('maintenance.update', $editItem->id_maintenance) }}">
                        @csrf
                        @method('PATCH')
                        <div class="form-grid">
                            <div class="field">
                                <label>Aset AC</label>
                                <input type="text" value="{{ optional($editItem->barang)->kode_bmn ?? '-' }} - {{ optional($editItem->barang)->merk ?? '-' }} ({{ optional($editItem->barang)->lokasi ?? '-' }})" readonly>
                            </div>
                            <div class="field">
                                <label>Tanggal Jadwal</label>
                                <input type="date" value="{{ $editItem->tanggal_jadwal }}" readonly>
                            </div>
                            <div class="field">
                                <label for="id_user">PIC</label>
                                <select id="id_user" name="id_user" required>
                                    <option value="">Pilih PIC</option>
                                    @foreach ($listPic as $pic)
                                        <option value="{{ $pic->id_user }}" {{ (string) old('id_user', $editItem->id_user) === (string) $pic->id_user ? 'selected' : '' }}>{{ $pic->nama }}</option>
                                    @endforeach
                                </select>
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
                                <label for="status">Status</label>
                                <select id="status" name="status" required>
                                    @foreach ($statusUpdateOptions as $statusOption)
                                        <option value="{{ $statusOption }}" {{ old('status', $editItem->status) === $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field">
                                <label for="tanggal_dikerjakan">Tanggal Dikerjakan</label>
                                <input id="tanggal_dikerjakan" type="date" name="tanggal_dikerjakan" value="{{ old('tanggal_dikerjakan', $editItem->tanggal_dikerjakan) }}">
                            </div>
                            <div class="field" style="grid-column: 1 / -1;">
                                <label for="catatan">Catatan</label>
                                <textarea id="catatan" name="catatan">{{ old('catatan', $editItem->catatan) }}</textarea>
                            </div>
                        </div>
                        <div class="actions">
                            <button type="submit" class="btn btn-warning">Update Maintenance</button>
                            <a href="{{ route('maintenance.index') }}" class="btn btn-soft">Batal Edit</a>
                        </div>
                    </form>
                @endif
            </div>

            <div class="panel">
                <div class="panel-head">
                    <h1>Daftar Maintenance Otomatis</h1>
                </div>
                <p class="sub">Jadwal maintenance dibuat otomatis dari data barang setiap 6 bulan.</p>
                <form method="GET" action="{{ route('maintenance.index') }}" class="filter-form" id="maintenanceFilterForm">
                    <div class="field">
                        <label for="q">Pencarian</label>
                        <input id="q" type="text" name="q" value="{{ request('q') }}" placeholder="Aset, PIC, jenis, status">
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
                            <th>Tanggal Jadwal</th>
                            <th>Tanggal Dikerjakan</th>
                            <th>Barang</th>
                            <th>PIC</th>
                            <th>Vendor</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->tanggal_jadwal }}</td>
                                <td>{{ $row->tanggal_dikerjakan ?: '-' }}</td>
                                <td>{{ optional($row->barang)->kode_bmn ?? '-' }} - {{ optional($row->barang)->merk ?? '-' }}</td>
                                <td>{{ optional($row->user)->nama ?? '-' }}</td>
                                <td>{{ optional($row->vendor)->nama_vendor ?? '-' }}</td>
                                <td>{{ $row->jenis }}</td>
                                <td><span class="badge {{ $row->status }}">{{ $row->status }}</span></td>
                                <td>{{ $row->catatan ?: '-' }}</td>
                                <td>
                                    <div class="row-actions">
                                        <a href="{{ route('maintenance.index', array_merge(request()->only(['q', 'status']), ['edit' => $row->id_maintenance])) }}" class="btn btn-warning">Update</a>
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

        (function initAutoFilter() {
            const form = document.getElementById('maintenanceFilterForm');
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

    </script>
</body>
</html>
