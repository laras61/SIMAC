<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance - SIMAC</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { margin: 0; font-family: 'Poppins', sans-serif; background: #fff7ed; color: #431407; }
        .wrap { width: min(1100px, calc(100% - 28px)); margin: 18px auto 32px; }
        
        /* Panel Styles aligned with User Page */
        .panel {
            background: #fff;
            border: 1px solid #fed7aa;
            border-top: 3px solid #f97316;
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 24px;
            box-shadow: 0 12px 26px rgba(194,65,12,.08);
            overflow-x: auto;
        }
        
        h1 { margin: 0 0 4px; font-size: 24px; color: #9a3412; }
        .sub { margin: 0 0 14px; color: #c2410c; font-size: 13px; }
        
        /* Alert Style */
        .alert-success {
            background: #dcfce7; 
            color: #166534; 
            padding: 12px 16px; 
            border-radius: 8px; 
            margin-bottom: 16px; 
            border: 1px solid #bbf7d0;
            font-size: 14px;
            font-weight: 500;
        }

        /* Button Styles */
        .btn-add {
            background: #ea580c;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 6px -1px rgba(234, 88, 12, 0.2);
            transition: all 0.2s;
            font-family: inherit;
            font-size: 14px;
            display: inline-block;
        }
        .btn-add:hover {
            background: #c2410c;
            transform: translateY(-1px);
        }

        /* Table Styles */
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }
        .table-title {
            font-size: 20px;
            font-weight: 700;
            color: #9a3412;
            margin: 0;
        }
        .table-meta {
            font-size: 13px;
            color: #9a3412;
        }

        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th { text-align: left; padding: 12px 16px; color: #9a3412; font-weight: 700; border-bottom: none; }
        td { text-align: left; padding: 16px; border-bottom: 1px solid #ffedd5; color: #431407; }
        tr:last-child td { border-bottom: none; }
        
        /* Action Buttons */
        .btn-action {
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12px;
            cursor: pointer;
            border: none;
            font-family: inherit;
            margin-right: 4px;
            color: white;
        }
        .btn-edit { background: #f59e0b; }
        .btn-edit:hover { background: #d97706; }
        .btn-delete { background: #ef4444; }
        .btn-delete:hover { background: #dc2626; }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(67, 20, 7, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .modal-overlay.active {
            display: flex;
            opacity: 1;
        }
        .modal-box {
            background: #fff;
            border-radius: 16px;
            width: min(700px, 90%);
            padding: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            transform: translateY(20px);
            transition: transform 0.3s ease;
            position: relative;
            border-top: 4px solid #f97316;
        }
        .modal-overlay.active .modal-box {
            transform: translateY(0);
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ffedd5;
            padding-bottom: 12px;
        }
        .modal-title {
            font-size: 20px;
            font-weight: 700;
            color: #9a3412;
            margin: 0;
        }
        .btn-close {
            background: none;
            border: 1px solid #fed7aa;
            color: #9a3412;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-close:hover {
            background: #fff7ed;
            color: #c2410c;
        }

        /* Form Styles */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 16px;
            margin-bottom: 16px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: #9a3412;
        }
        .form-group input, .form-group select, .form-group textarea {
            padding: 10px;
            border: 1px solid #fed7aa;
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
            background: #fff;
            color: #431407;
            transition: border-color 0.2s;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none;
            border-color: #f97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        }
        .modal-footer {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }
        .btn-submit {
            background: #f97316;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-family: inherit;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-submit:hover {
            background: #c2410c;
        }
        .btn-cancel {
            background: #fff;
            color: #9a3412;
            border: 1px solid #fed7aa;
            padding: 10px 24px;
            border-radius: 8px;
            font-family: inherit;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-cancel:hover {
            background: #fff7ed;
        }
    </style>
</head>
<body>
    @include('partials.nav')
    <div class="wrap">
        <!-- Header Panel -->
        <div class="panel">
            <h1>Menu Maintenance</h1>
            <p class="sub">Kelola jadwal dan data maintenance AC</p>

            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <button class="btn-add" onclick="openModal()">
                Tambah Maintenance
            </button>
        </div>

        <!-- List Panel -->
        <div class="panel">
            <h1>Daftar Maintenance</h1>
            <p class="sub">Total data: {{ $items->count() }}</p>
            
            <table>
                <thead>
                    <tr style="background: #fff7ed;">
                        <th width="5%">No</th>
                        <th>Tanggal Jadwal</th>
                        <th>Barang</th>
                        <th>Teknisi</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row->tanggal_jadwal }}</td>
                            <td>
                                <div style="font-weight: 600;">{{ optional($row->barang)->kode_bmn }}</div>
                                <div style="font-size: 11px; color: #9a3412;">{{ optional($row->barang)->merk ?? '-' }}</div>
                            </td>
                            <td>{{ optional($row->user)->nama ?? '-' }}</td>
                            <td>
                                <span style="background: {{ $row->jenis == 'preventive' ? '#dbeafe' : '#fee2e2' }}; color: {{ $row->jenis == 'preventive' ? '#1e40af' : '#991b1b' }}; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 500;">
                                    {{ ucfirst($row->jenis) }}
                                </span>
                            </td>
                            <td>
                                <span style="background: {{ $row->status == 'selesai' ? '#dcfce7' : '#fef9c3' }}; color: {{ $row->status == 'selesai' ? '#166534' : '#854d0e' }}; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 500;">
                                    {{ ucfirst($row->status) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn-action btn-edit" onclick="editItem({{ $row->id_maintenance }})">Edit</button>
                                <form action="{{ route('maintenance.destroy', $row->id_maintenance) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" style="text-align: center; padding: 20px; color: #9a3412;">Belum ada data maintenance.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Overlay -->
    <div id="maintenanceModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <h3 class="modal-title" id="modalTitle">Tambah Maintenance</h3>
                <button type="button" class="btn-close" onclick="closeModal()">Tutup</button>
            </div>
            
            <form id="maintenanceForm" action="{{ route('maintenance.insert') }}" method="POST">
                @csrf
                <div id="methodField"></div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="id_ac">Pilih Aset AC</label>
                        <select name="id_ac" id="id_ac" required>
                            <option value="">-- Pilih AC --</option>
                            @foreach($listBarang as $barang)
                                <option value="{{ $barang->id_ac }}">{{ $barang->kode_bmn }} - {{ $barang->merk }} ({{ $barang->lokasi }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_user">Pilih Teknisi</label>
                        <select name="id_user" id="id_user" required>
                            <option value="">-- Pilih Teknisi --</option>
                            @foreach($listTeknisi as $teknisi)
                                <option value="{{ $teknisi->id_user }}">{{ $teknisi->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_jadwal">Tanggal Jadwal</label>
                        <input type="date" name="tanggal_jadwal" id="tanggal_jadwal" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis">Jenis Maintenance</label>
                        <select name="jenis" id="jenis" required>
                            <option value="preventive">Preventive</option>
                            <option value="corrective">Corrective</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status Awal</label>
                        <select name="status" id="status" required>
                            <option value="pending">Pending</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="margin-bottom: 16px;">
                    <label for="catatan">Catatan Tambahan</label>
                    <textarea name="catatan" id="catatan" rows="3" placeholder="Masukkan catatan jika ada..."></textarea>
                </div>
                
                <div class="modal-footer">
                    <button type="submit" class="btn-submit">Simpan</button>
                    <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Pass PHP data to JavaScript
        const maintenanceData = @json($items);

        function openModal() {
            // Reset form for insert
            const form = document.getElementById('maintenanceForm');
            form.action = "{{ route('maintenance.insert') }}";
            document.getElementById('methodField').innerHTML = '';
            document.getElementById('modalTitle').innerText = 'Tambah Maintenance';
            
            // Reset values
            form.reset();
            
            const modal = document.getElementById('maintenanceModal');
            modal.style.display = 'flex';
            setTimeout(() => {
                modal.classList.add('active');
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById('maintenanceModal');
            modal.classList.remove('active');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }

        function editItem(id) {
            const item = maintenanceData.find(d => d.id_maintenance == id);
            
            if (!item) {
                alert('Data tidak ditemukan');
                return;
            }

            // Populate form
            document.getElementById('id_ac').value = item.id_ac;
            document.getElementById('id_user').value = item.id_user;
            document.getElementById('tanggal_jadwal').value = item.tanggal_jadwal;
            document.getElementById('jenis').value = item.jenis;
            document.getElementById('status').value = item.status;
            document.getElementById('catatan').value = item.catatan || '';

            // Setup form for update
            const form = document.getElementById('maintenanceForm');
            // Route for update: /maintenance/update/{id}
            form.action = "{{ url('/maintenance/update') }}/" + id;
            
            // Add PUT method spoofing
            document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
            
            document.getElementById('modalTitle').innerText = 'Edit Maintenance';

            // Open modal
            const modal = document.getElementById('maintenanceModal');
            modal.style.display = 'flex';
            setTimeout(() => {
                modal.classList.add('active');
            }, 10);
        }

        // Close modal when clicking outside
        document.getElementById('maintenanceModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>
