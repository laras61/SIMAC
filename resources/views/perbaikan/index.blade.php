<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perbaikan - SIMAC</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { margin: 0; font-family: 'Poppins', sans-serif; background: #f8fafc; color: #1f2937; }
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
        
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th { text-align: left; padding: 12px 16px; color: #9a3412; font-weight: 700; border-bottom: none; background: #fff7ed; }
        td { text-align: left; padding: 16px; border-bottom: 1px solid #ffedd5; color: #431407; vertical-align: top; }
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
            text-decoration: none;
            display: inline-block;
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
            max-height: 90vh;
            overflow-y: auto;
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
            justify-content: flex-end;
        }
        .btn-submit {
            background: #f97316;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }
        .btn-submit:hover {
            background: #ea580c;
        }
        .btn-cancel {
            background: #fff7ed;
            color: #9a3412;
            border: 1px solid #fed7aa;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }
        .btn-cancel:hover {
            background: #ffedd5;
        }
    </style>
</head>
<body>
    @include('partials.nav')
    <div class="wrap">
        <!-- Panel 1: Menu & Actions -->
        <div class="panel">
            <h1>Menu Perbaikan</h1>
            <p class="sub">Kelola data perbaikan dan servis AC</p>
            
            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <button class="btn-add" onclick="openModal('add')">
                Tambah Perbaikan
            </button>
        </div>

        <!-- Panel 2: Daftar Data -->
        <div class="panel">
            <h1>Daftar Perbaikan</h1>
            <p class="sub">Total data: {{ $items->count() }}</p>
            
            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Tanggal</th>
                        <th width="20%">Barang</th>
                        <th width="15%">Jenis</th>
                        <th width="20%">Deskripsi</th>
                        <th width="10%">Teknisi</th>
                        <th width="10%">Biaya</th>
                        <th width="5%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row->tanggal_perbaikan }}</td>
                            <td>
                                <strong>{{ optional($row->barang)->merk ?? '-' }}</strong><br>
                                <span style="font-size: 12px; color: #7c2d12;">{{ optional($row->barang)->kode_bmn ?? '-' }}</span>
                            </td>
                            <td>
                                <span style="background: #ffedd5; color: #c2410c; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 500;">
                                    {{ $row->jenis_perbaikan }}
                                </span>
                            </td>
                            <td>{{ $row->deskripsi ?? '-' }}</td>
                            <td>{{ optional($row->user)->nama ?? '-' }}</td>
                            <td>Rp {{ number_format($row->biaya ?? 0, 0, ',', '.') }}</td>
                            <td>
                                <div style="display: flex;">
                                    <button class="btn-action btn-edit" onclick="openModal('edit', {{ json_encode($row) }})">Edit</button>
                                    <form action="{{ route('perbaikan.destroy', $row->id_perbaikan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" style="text-align: center; padding: 24px; color: #9a3412;">Belum ada data perbaikan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal-box">
            <div class="modal-header">
                <h3 class="modal-title" id="modalTitle">Tambah Perbaikan</h3>
                <button class="btn-close" onclick="closeModal()">✕</button>
            </div>
            <form id="perbaikanForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label>Barang (AC)</label>
                        <select name="id_ac" id="id_ac" required>
                            <option value="">Pilih Barang</option>
                            @foreach($listBarang as $b)
                                <option value="{{ $b->id_ac }}">{{ $b->merk }} - {{ $b->kode_bmn }} ({{ $b->lokasi }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Perbaikan</label>
                        <input type="date" name="tanggal_perbaikan" id="tanggal_perbaikan" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis Perbaikan</label>
                        <input type="text" name="jenis_perbaikan" id="jenis_perbaikan" placeholder="Contoh: Ganti Kapasitor" required>
                    </div>
                    <div class="form-group">
                        <label>Teknisi</label>
                        <select name="id_user" id="id_user" required>
                            <option value="">Pilih Teknisi</option>
                            @foreach($listTeknisi as $t)
                                <option value="{{ $t->id_user }}">{{ $t->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Biaya (Rp)</label>
                        <input type="hidden" name="biaya" id="biaya">
                        <input type="text" id="biaya_display" placeholder="Rp 0" inputmode="numeric" autocomplete="off">
                    </div>
                </div>

                <div class="form-group">
                    <label>Deskripsi Perbaikan</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3" placeholder="Jelaskan detail perbaikan..."></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn-submit">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('modalOverlay');
        const form = document.getElementById('perbaikanForm');
        const modalTitle = document.getElementById('modalTitle');
        const formMethod = document.getElementById('formMethod');
        const biayaHidden = document.getElementById('biaya');
        const biayaDisplay = document.getElementById('biaya_display');
        const tanggalInput = document.getElementById('tanggal_perbaikan');

        function todayISO() {
            const d = new Date();
            const yyyy = d.getFullYear();
            const mm = String(d.getMonth() + 1).padStart(2, '0');
            const dd = String(d.getDate()).padStart(2, '0');
            return `${yyyy}-${mm}-${dd}`;
        }

        function formatRupiahFromDigits(digits) {
            if (!digits) return '';
            const num = Number(digits);
            if (!Number.isFinite(num)) return '';
            return 'Rp ' + num.toLocaleString('id-ID');
        }

        function syncBiayaFromDisplay() {
            const digits = (biayaDisplay.value || '').replace(/[^\d]/g, '');
            biayaHidden.value = digits ? String(Number(digits)) : '';
            biayaDisplay.value = formatRupiahFromDigits(digits);
        }

        biayaDisplay.addEventListener('focus', () => {
            if (biayaHidden.value) biayaDisplay.value = biayaHidden.value;
        });

        biayaDisplay.addEventListener('blur', () => {
            biayaDisplay.value = formatRupiahFromDigits(biayaHidden.value);
        });

        biayaDisplay.addEventListener('input', () => {
            syncBiayaFromDisplay();
            biayaDisplay.setSelectionRange(biayaDisplay.value.length, biayaDisplay.value.length);
        });

        function openModal(type, data = null) {
            modal.classList.add('active');
            
            if (type === 'add') {
                modalTitle.textContent = 'Tambah Perbaikan';
                form.action = "{{ route('perbaikan.insert') }}";
                formMethod.value = "POST";
                form.reset();
                // Set default date to today
                tanggalInput.min = todayISO();
                tanggalInput.value = todayISO();
                biayaHidden.value = '';
                biayaDisplay.value = '';
            } else {
                modalTitle.textContent = 'Edit Perbaikan';
                form.action = `/perbaikan/update/${data.id_perbaikan}`;
                formMethod.value = "PUT"; // Use PUT for update
                
                // Populate fields
                document.getElementById('id_ac').value = data.id_ac;
                const today = todayISO();
                const existingDate = data.tanggal_perbaikan || '';
                tanggalInput.min = existingDate && existingDate < today ? existingDate : today;
                tanggalInput.value = existingDate;
                document.getElementById('jenis_perbaikan').value = data.jenis_perbaikan;
                document.getElementById('id_user').value = data.id_user;
                biayaHidden.value = data.biaya ? String(Math.trunc(Number(data.biaya))) : '';
                biayaDisplay.value = formatRupiahFromDigits(biayaHidden.value);
                document.getElementById('deskripsi').value = data.deskripsi;
            }
        }

        function closeModal() {
            modal.classList.remove('active');
        }

        // Close on click outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });
    </script>
</body>
</html>

